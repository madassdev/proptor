<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeCreateRequest;
use App\Http\Requests\TypeUpdateRequest;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
        $this->middleware(['auth:api','can:delete-type'])->only('destroy');
    }

    public function index()
    {
        $types = Type::with('features')->withCount('features')->paginate(20);
        return response()->json(['data'=>$types]);
    }

    public function store(TypeCreateRequest $request)
    {
        $type = Type::create($request->validated());
        $type->features()->sync($request->features);

        return response()->json(['message'=>'Type created successfully.', 'data'=>$type]);
    }

    public function update(TypeUpdateRequest $request, Type $type)
    {
        $type->update($request->validated());
        $type->features()->sync($request->features);
        
        return response()->json(['message'=>'Type updated successfully.', 'data'=>$type]);
    }

    public function show(Type $type)
    {
        return response()->json(['data'=>$type->load('features')]);
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return response()->json(['message'=>'Type deleted successfully.']);
    }
}
