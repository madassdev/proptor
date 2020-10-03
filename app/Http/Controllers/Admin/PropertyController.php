<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Feature;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'delete']);
        $this->middleware(['auth','can:delete-property'])->only('destroy');
    }

    public function index()
    {
        $properties = Property::latest()->with('plans')->paginate(20);
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('admin.properties.create', compact('plans'));
    }

    public function uploadToCloudinary(object $file)
    {
        $uploaded_image = cloudinary()->upload($file->getRealPath());
        return [
            "public_id"=>$uploaded_image->getPublicId(),
            "url"=>$uploaded_image->getSecurePath(),
        ];
    }
    public function store(PropertyCreateRequest $request)
    {
        $image_url = [
            "public_id"=> "placeholder-image-368x247_sqyisc",
            "url"=> "https://res.cloudinary.com/franksmith/image/upload/v1601745772/placeholder-image-368x247_sqyisc.png"
        ];
        $gallery_images_url = [
            [
                "public_id"=> "placeholder-image-368x247_sqyisc",
                "url"=> "https://res.cloudinary.com/franksmith/image/upload/v1601745772/placeholder-image-368x247_sqyisc.png"
            ],[
                "public_id"=> "placeholder-image-368x247_sqyisc",
                "url"=> "https://res.cloudinary.com/franksmith/image/upload/v1601745772/placeholder-image-368x247_sqyisc.png"
            ]
        ];

        if($request->has('image'))
        {
            // UPLOAD to CLOUDINARY
            $image_url = $this->uploadToCloudinary($request->file('image'));
        }

        if($request->has('gallery_images'))
        {
            // UPLOAD to CLOUDINARY
            $images = collect($request->file('gallery_images'));
            $gallery_images_url = $images->map(function($image){
                    return $this->uploadToCloudinary($image);
                });
        }

        $property = Property::create($request->validated() + [
            "image_url"=>$image_url,
            "gallery_images_url"=>$gallery_images_url,
        ]);

        $property->plans()->sync($request->plans);

        // The features will be attached to the property, 
        // any feature that doesn't exist yet will be created
        $features = collect($request->features)->map(function($feature){
            return Feature::firstOrCreate(['name' => $feature])->id;
        });
        $property->features()->sync($features);
        
        return redirect(route('admin.properties.index'))->withSuccess('Property created successfully!');
    }

    public function edit(Request $request, Property $property)
    {
        $plans = Plan::all();
        return view('admin.properties.edit', compact('property', 'plans'));
    }

    public function update(PropertyUpdateRequest $request, Property $property)
    {
        // return 123;
        $property->update($request->validated());

        $property->plans()->sync($request->plans);
        
        $features = collect($request->features)->map(function($feature){
            return Feature::firstOrCreate(['name' => $feature])->id;
        });
        $property->features()->sync($features);

        return redirect(route('admin.properties.index'))->withSuccess('Property successfully updated!');
        
    }

    public function show(Property $property)
    {
        $property->load('plans');
        return view('admin.properties.show', compact('property'));
        return response()->json(['data'=>$property->load('plans', 'type', 'features')]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect(route('admin.properties.index'))->withSuccess('Property deleted successfully!');
        return response()->json(['message'=>'Property deleted successfully.']);
    }
}
