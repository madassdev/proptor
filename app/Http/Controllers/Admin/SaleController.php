<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Feature;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'delete']);
        $this->middleware(['auth','can:delete-property'])->only('destroy');
    }

    public function index(Request $request)
    {
        $sales = Sale::with('user', 'agent', 'property')->orderBy('updated_at', 'DESC')->paginate(20);
        return view('admin.sales.index', compact('sales'));
    }

    

    public function show(Sale $sale)
    {
        $sale->load('user', 'property', 'agent', 'plan');
        $sale->setRelation('payments', $sale->payments()->latest()->paginate(8,['*'], 'payment'));
        return view('admin.sales.show', compact('sale'));
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect(route('admin.properties.index'))->withSuccess('Property deleted successfully!');
        return response()->json(['message'=>'Property deleted successfully.']);
    }

    public function autopay(Sale $sale, Request $request)
    {
        $request->validate([
            "amount"=>"required|numeric|min:1"
        ]);

        $sale->payments()->create([
            "user_id" => $sale->user_id,
            "amount" => $request->amount,
            "method" => "autopaid",
            "reference" => "autopaid",
            "status" => "success"
        ]);
        
        return [$sale, $request->all()];
    }
}
