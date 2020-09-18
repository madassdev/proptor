<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
        $this->middleware(['auth:api','can:delete-plan'])->only('destroy');
    }

    public function index()
    {
        $plans = Plan::paginate(20);
        return response()->json(['data'=>$plans]);
    }

    public function store(PlanCreateRequest $request)
    {
        $plan = Plan::create($request->validated());

        return response()->json(['message'=>'Plan created successfully.', 'data'=>$plan]);
    }

    public function update(PlanUpdateRequest $request, Plan $plan)
    {
        $plan->update($request->validated());
        
        return response()->json(['message'=>'Plan updated successfully.', 'data'=>$plan]);
    }

    public function show(Plan $plan)
    {
        return response()->json(['data'=>$plan]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message'=>'Plan deleted successfully.']);
    }
}
