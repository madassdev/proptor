<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Feature;
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

        $property->plans()->sync($request->plans);

        // The features will be attached to the property, 
        // any feature that doesn't exist yet will be created
        $features = collect($request->features)->map(function($feature){
            return Feature::firstOrCreate(['name' => $feature])->id;
        });
        $property->features()->sync($features);

        return response()->json(['message'=>'Property created successfully.', 'data'=>$property]);
    }

    public function view(Property $property)
    {
        $property->increment('views');

        return response()->json(['message'=>'Property view successful', 'data'=>[
            'property'=>$property
        ]]);
    }

    public function update(PropertyUpdateRequest $request, Property $property)
    {
        $property->update($request->validated());

        $property->plans()->sync($request->plans);
        
        $features = collect($request->features)->map(function($feature){
            return Feature::firstOrCreate(['name' => $feature])->id;
        });
        $property->features()->sync($features);
        
        return response()->json(['message'=>'Property updated successfully.', 'data'=>$property]);
    }

    public function show(Property $property)
    {
        return response()->json(['data'=>$property->load('plans', 'type', 'features')]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message'=>'Property deleted successfully.']);
    }
}
