<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminCreatedUser;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Property;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "full_name" => "required|string",
            "email" => 'required|email|unique:users',
            "mobile" => 'string',
        ]);

        $generated_password = rand(100000, 900000);

        $user = User::create([
            "full_name" => $request->full_name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "password" => bcrypt($generated_password),
            "v_code" => $generated_password,
            "status" => "registered-for"
        ]);

        auth()->user()->agent->users()->attach($user);
        
        event(new AdminCreatedUser($user));

        return redirect(route('admin.users.index'))->withSuccess('User created successfully');
    }

    public function show(User $user)
    {
        $user->load('sales.payments', 'sales.property', 'sales.plan');
        $user->sales = $user->sales->sortBy('percent_paid');
        return view('admin.users.show', compact('user'));
    }

    public function salesCreate(User $user)
    {
        $plans = Plan::all();
        return view('admin.users.sale-create', compact('user', 'plans'));
    }

    public function salesStore(request $request, User $user)
    {
        $agent = auth()->user();
        
        $request->validate([
            'name'=>'required|exists:properties,name,deleted_at,NULL',
            'plan_id' => 'required|numeric|exists:plans,id,deleted_at,NULL'
        ]);

        $property = Property::whereName($request->name)->firstOrFail();
        
        $plan = $property->plans->firstWhere('id', $request->plan_id);
        
        
        if(!$plan){
            return response()->json(['message'=>'Plan cannot be used for this property'], 403);
        }

        // Sale pricing calculations.
        $min_payable = $property->price;
        $total_amount = $property->price + $plan->extra_interest * 0.01 * $property->price;
        if($plan->first_payment_formular == "percentage")
        {
            $min_payable = $plan->min_first_payment * 0.01 * $property->price;
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

        return redirect(route('admin.sales.show', $sale))->withSuccess('Sale record saved sucessfully, awaiting payment.');
        
        return response()->json(['message'=>'Sale created, awaiting payment', 'data' => $sale->fresh()->load('property', 'plan')]);
        return $request;
    }
}
