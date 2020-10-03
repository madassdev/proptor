<?php

namespace App\Http\Controllers;

use App\Events\PaymentMade;
use App\Events\PaymentSuccess;
use App\Models\Agent;
use App\Models\Property;
use App\Models\Sale;
use App\Models\User;
use App\Services\AgentService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function addSale(Request $request)
    {
        $user = $agent = User::find(1);

        $property = Property::whereId($request->property_id)->with('plans')->first();

        // Validate request
        $request->validate([
            "property_id" => "required|exists:properties,id,deleted_at,NULL",
            "plan_id" => ["required","exists:plans,id"],
        ]);

        
        /*
            What type of property is this?
            Does this plan cover for this property?
            Can they pay this amount for this property?

            Minimum payable amount and Total amount will be calculated based on business 
            decisions which is dependent on either or both of the Property and Plan models.
        */

        $min_payable = 100000; // To be calculated
        $total_amount = 12000000; // To be calculated

        $plan = $property->plans->firstWhere('id', $request->plan_id);

        
        if(!$plan){
            return response()->json(['message'=>'Plan cannot be used for this property'], 403);
        }

        $sale = Sale::create([
            "user_id" => $user->id,
            "agent_id" => $agent->id,
            "plan_id" => $plan->id,
            "property_id" => $property->id,
            "next_min_amount" => $min_payable,
            "total_amount" => $total_amount,
            "code" => strtoupper('ORD-'.\Str::random(8)) 
        ]);
        
        return response()->json(['message'=>'Sale created, awaiting payment', 'data' => $sale->fresh()->load('property', 'plan')]);
    }

    public function payForSale(Request $request, Sale $sale)
    {
        // return route('mailroutes.admin.payments.show', ['payment'=>1]);
        $user = auth()->guard('api')->user();
        $request->validate([
            "amount"=>"required|numeric|min:0",
            "payment_method" => "required|string|in:bank-transfer,paystack,flutterwave",
            "payment_reference" => "required|string",
        ]);
        
         /*
            Determine what is being paid for
            Is this the expecting price

         */

         if($sale->next_min_amount > $request->amount)
         {
            return response()->json(['message'=>'You cannot pay less than '.$sale->next_min_amount. ' for this sale at this time.'], 403);
         }

        // The current project model only solves for bank transfer,
        // Payment Status and Amount shall be modified based on future implemented Payment methods.

        if($request->payment_method == 'paystack' or $request->payment_method == 'flutterwave')
        {
            $processed_payment =  PaymentService::processPayment($request->payment_method, $request->payment_reference);
            $amount = $processed_payment['amount_paid']; // PaymentMethod::amount_paid
            $status = 'success'; // PaymentMethod::amount_paid
            if($sale->next_min_amount > $amount)
            {
                return response()->json(['message'=>'You cannot pay less than '.$sale->next_min_amount. ' for this sale at this time.'], 403);
            }
        }
        
        // Bank transfer (Manual payment)
        if($request->payment_method == 'bank-transfer')
        {
            $amount = $request->amount; // PaymentMethod::amount_paid
            $status = "pending"; // PaymentMethod::status 
        }


        $payment = $sale->payments()->create([
            "user_id" => $user->id,
            "method" => $request->payment_method,
            "reference" => $request->payment_reference,
            "status" => $status,
            "amount" => $amount,    
        ]);

        $payment->load('user', 'sale.property');

        $payment->status == 'success' ? event(new PaymentSuccess($payment)) : event(new PaymentMade($payment));

        return response()->json([
            'message'=> 'Payment record saved successfully',
            'data'=>[
                'sale'=>$sale->fresh()->load('payments')
            ]
        ]);

    }

}
