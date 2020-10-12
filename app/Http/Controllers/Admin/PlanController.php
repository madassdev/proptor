<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::paginate(20);
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(PlanCreateRequest $request)
    {
        $plan = Plan::create($request->all());
        return redirect(route('admin.plans.index'))->withSuccess('Plan created successfully!');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    } 

    public function update(PlanUpdateRequest $request, Plan $plan)
    {
        $plan->update($request->all());
        return redirect(route('admin.plans.index'))->withSuccess('Plan updated successfully');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect(route('admin.plans.index'))->withSuccess('Plan deleted successfully!');
    }
}
