<?php

namespace App\Http\Controllers;

use App\Events\PaymentSuccess;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        // $this->middleware('role:admin')->only(['confirmPayment']);
    }

    public function payments(Request $request)
    {
        $user = request()->user();
        if($user->hasRole('admin'))
        {
            return $this->allOrders($request);
        }
        $payments = $user->payments()->with('sale')->paginate(20);
        return response()->json(['data'=>["payments"=>$payments]]);
    }

    public function confirmPayment(Payment $payment)
    {
        // return [$payment, 88];

        if($payment->status != 'pending')
        {
           return response()->json(['message'=>'Can only confirm pending payments']);
        }
        $payment->update(['status'=>'confirmed']);

        event(new PaymentSuccess($payment));
        
        return response()->json(['message'=>'Payment confirmed succesfully', 'data'=>$payment->load('sale')]);
    }

    public function allOrders(Request $request)
    {
        $payments = Payment::latest()->paginate(20);
        if($request->has('payment_status'))
        {
            $payments = Payment::latest()->whereStatus($request->payment_status)->paginate(20);
        }
        return response()->json(['data'=>["payments"=>$payments]]);
    }
}
