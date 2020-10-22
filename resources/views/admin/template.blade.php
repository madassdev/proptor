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
        <li class="breadcrumb-item active">Plans</li>
    </ol>
</div>
@endsection

@section('content')

<div id="ui-view"></div>
<div class="fade-in">
    <div class="row">
    </div>
</div>
@endsection

@section('scripts')
@endsection