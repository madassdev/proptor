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
        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a></li>
        <li class="breadcrumb-item active">Create user</li>
    </ol>
</div>
@endsection

@section('content')

<div id="ui-view"><div><div class="fade-in">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <strong>Create new User</strong> 
                    <a href="{{route('admin.users.index')}}" class="btn btn-danger float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.store')}}" method="post" class="">
                        @csrf
                        <div class="form-group">
                            <label for="company">Name</label>
                            <input class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" name="full_name" id="company" type="text" placeholder="Full name" required>
                            <input type="hidden" name="type" value="land">
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="city">Email address</label>
                                <input class="form-control @error('email') is-invalid @enderror" id="price" value="{{ old('email') }}" name="email" type="email" placeholder="Enter user email address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="city">Phone number</label>
                                <input class="form-control @error('mobile') is-invalid @enderror" id="price" value="{{ old('mobile') }}" name="mobile" type="number" placeholder="Enter phone number">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
@endsection