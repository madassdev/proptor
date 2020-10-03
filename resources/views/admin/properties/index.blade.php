@php
    $status = [
        "active"=>"success",
        "pending"=>"warning",
        "canceled"=>"danger",
        "inactive"=>"secondary",
    ];
@endphp

@extends('layouts.app')

@section('links')
@endsection

@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Properties</li>
    </ol>
</div>
@endsection

@section('content')

<div id="ui-view"></div>
<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 mx-auto my-2">
                        <strong>
                            Properties
                        </strong>
                        <span class="float-right">
                            {{$properties->links("pagination::bootstrap-4")}}
                        </span>
                    </div>
                    <table class="table table-responsive">
                        @php
                        $count = 0;
                        @endphp
                        <thead>
                            <th>S/N</th>
                            <!-- <th>Thumbnail</th> -->
                            <th>Name</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Plans</th>
                            <th>Actions</th>
                        </thead>
                        @forelse($properties as $property)
                        <tr>
                            @php
                            $count++;
                            @endphp
                            <td>{{$count}}</td>
                            <!-- <td><img src="https://picsum.photos/200/200" alt="" width="50px" srcset="" style="border-radius: 100px;"></td> -->
                            <td>
                                <a href="{{route('admin.properties.show', $property)}}" class="text-primary font-weight-bold">
                                    {{ucfirst($property->name)}}
                                </a>
                            </td>
                            <td class="font-weight-bold">${{number_format($property->price)}}</td>
                            <td>{{number_format($property->size ?? 100)}}</td>
                            <td>
                                <small>
                                {{ucfirst($property->city .', '.$property->city)}} </td>
                                </small>
                            <td>
                                <span class="badge badge-{{$status[$property->status]}}">
                                    {{ucfirst($property->status)}}
                                </span>
                            </td>
                            <td>
                                <small>
                                    {{$property->plans->map(function($plan){
                                    return $plan->name;    
                                    })->implode(' | ')}}
                                </small>
                            </td>
                            <td>
                                <a href="{{route('admin.properties.edit', $property)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Confirm delete?');" style="display: inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                                <div class="col-lg-10 mx-auto">
                                    <div class="row">
                                        <div class="col-md-12 text-center my-5">
                                            <p class="display-3 text-secondary">
                                                No Properties to display.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <span class="float-right">
                            {{$properties->render("pagination::bootstrap-4")}}
                        </span>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection