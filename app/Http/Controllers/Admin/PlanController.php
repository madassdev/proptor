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

    public function store(Request $request)
    {
        $rules['name'] = ['required', 'string', 'unique:plans,name,NULL,id'];
        $rules['duration'] = ['required', 'numeric','min:1'];

        $request->validate($rules);

        $plan = Plan::create($request->all());
        return redirect(route('admin.plans.index'))->withSuccess('Plan created successfully!');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    } 

    public function update(Request $request, Plan $plan)
    {
        $rules['name'] = ['required', 'sometimes', 'string', 'unique:plans,name,'.$plan->id.',id,deleted_at,NULL'];
        $rules['duration'] = ['required', 'sometimes', 'numeric', 'min:1'];

        $plan->update($request->all());
        return redirect(route('admin.plans.index'))->withSuccess('Plan updated successfully');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect(route('admin.plans.index'))->withSuccess('Plan deleted successfully!');
    }
}
