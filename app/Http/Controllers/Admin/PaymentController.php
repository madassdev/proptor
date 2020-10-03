<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Feature;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Sale;
use App\Events\PaymentSuccess;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'delete']);
        $this->middleware(['auth','can:delete-property'])->only('destroy');
    }

    public function index(Request $request)
    {
        $method = $request->payment_method;
        // return $method;
        $payments = Payment::latest()
                            ->with('sale.property', 'user')
                            ->method($method)
                            ->paginate(10)
                            ->appends(request()->query())
                            ;
        // $payments = $payments->appends(request()->query());
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('user', 'sale.property', 'sale.agent');
        return view('admin.payments.show', compact('payment'));
        
    }

    public function update(Payment $payment, Request $request)
    {
        $request->validate([
            "status" => "in:success,failed,canceled,pending",
        ]);
        $old_payment_status = $payment->status;
        $payment->update($request->only('status'));
        if($old_payment_status == "pending" && $payment->status == 'success')
        {
            event(new PaymentSuccess($payment));
        }

        return redirect(route('admin.payments.index', ['payment_method'=>$payment->method]))->withSuccess("Payment updated as ".strtoupper($payment->status));
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect(route('admin.properties.index'))->withSuccess('Property deleted successfully!');
        return response()->json(['message'=>'Property deleted successfully.']);
    }
}
