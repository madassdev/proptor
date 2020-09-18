<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeatureCreateRequest;
use App\Http\Requests\FeatureUpdateRequest;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
        $this->middleware(['auth:api','can:delete-feature'])->only('destroy');
    }

    public function index()
    {
        $features = Feature::with('types')->paginate(20);
        return response()->json(['data'=>$features]);
    }

    public function store(FeatureCreateRequest $request)
    {
        $feature = Feature::create($request->validated());
        $feature->types()->sync($request->types);

        return response()->json(['message'=>'Feature created successfully.', 'data'=>$feature]);
    }

    public function update(FeatureUpdateRequest $request, Feature $feature)
    {
        $feature->update($request->validated());
        $feature->types()->sync($request->types);

        return response()->json(['message'=>'Feature updated successfully.', 'data'=>$feature]);
    }

    public function show(Feature $feature)
    {
        return response()->json(['data'=>$feature->load('types')]);
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return response()->json(['message'=>'Feature deleted successfully.']);
    }
}
