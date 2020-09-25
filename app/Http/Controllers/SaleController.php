<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Property;
use App\Models\Sale;
use App\Models\User;
use App\Services\AgentService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {

    }

    public function addSale(Request $request)
    {
        $user = $agent = User::find(1);

        $property = Property::whereId($request->property_id)->with('plans')->first();
        return 911;

        // Validate request
        $request->validate([
            "property_id" => "required|exists:properties,id",
            "plan_id" => ["required","exists:plans,id"],
            "amount_to_pay" => "required|numeric",
        ]);

        
        /*
            What type of property is this?
            Does this plan cover for this property?
            Can they pay this amount for this property?

            Minimum payable amount and Total amount will be calculated based on business decisions which is dependent on either or both of the Property and Plan models.
        */

        $min_payable = 100000;
        $total_amount = 12000000;

        $plan = $property->plans->firstWhere('id', $request->plan_id);

        if()
        {

        }
        
        if(!$plan){
            return response()->json(['message'=>'Plan cannot be used for this property'], 403);
        }
        
        if($request->amount_to_pay < $min_payable)
        {
            return response()->json(['message'=>'This amount cannot be accepted for this property using this plan.'], 403);
        }

        $sale = Sale::create([
            "user_id" => $user->id,
            "agent_id" => $agent->id,
            "plan_id" => $plan->id,
            "property_id" => $property->id,
            "first_amount" => $request->amount_to_pay,
            "total_amount" => $total_amount,
            "code" => strtoupper('ORD-'.\Str::random(8)) 
        ]);
        
        return response()->json(['message'=>'Sale created, awaiting payment', 'data' => $sale->load('property', 'plan')]);
    }

    public function payForSale(Request $request, Sale $sale)
    {
         /*
            Determine what is being paid for
         */
    }
}
