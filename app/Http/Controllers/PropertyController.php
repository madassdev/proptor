<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
        $this->middleware(['auth:api','can:delete-property'])->only('destroy');
    }

    public function index()
    {
        $properties = Property::with('features')->withCount('features')->paginate(20);
        return response()->json(['data'=>$properties]);
    }

    public function store(PropertyCreateRequest $request)
    {
        $property = Property::create($request->validated());
        $property->features()->sync($request->features);

        return response()->json(['message'=>'Property created successfully.', 'data'=>$property]);
    }

    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $property->update($request->validated());
        $property->features()->sync($request->features);
        
        return response()->json(['message'=>'Property updated successfully.', 'data'=>$property]);
    }

    public function show(Property $property)
    {
        return response()->json(['data'=>$property->load('plans')]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message'=>'Property deleted successfully.']);
    }
}
