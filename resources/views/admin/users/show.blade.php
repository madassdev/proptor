@php

function paint($amount)
{
    if((0 <= $amount) && ($amount <= 30))
    {
        return "progress-bar-striped progress-bar-animated border-danger bg-danger";
    }

    if((30 <= $amount) && ($amount <= 99))
    {
        return "progress-bar-striped progress-bar-animated border-warning bg-warning";
    }

    if($amount >= 100)
    {
        return "border-success bg-success";
    }
}
@endphp
@extends('layouts.app')

@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a></li>
        <li class="breadcrumb-item active">{{ucfirst($user->full_name)}}</li>
    </ol>
</div>
@endsection

@section('content')
<div id="ui-view"><div><div class="fade-in">
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{route('admin.users.sales.create', $user)}}" class="btn btn-primary"> <i class="cil cil-cart"></i> Add sale</a>
            <a href="{{route('admin.users.index')}}" class="btn btn-danger float-right">Back</a>
        </div>
    </div>
    <div class="row">
        @forelse($user->sales as $sale)
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 p-1 text-center">
                                <p class="h3 text-primary mb-0">
                                    {{ucfirst($sale->property->name)}}
                                </p>
                                <small>{{$sale->property->address}}</small>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-md-4 p-3 text-center card bg-gradient-light">
                                <i class="cil-check-circle text-success h3"></i>
                                <p class="mb-0 h5">
                                   {!!config('payment.naira')!!}{{number_format($sale->total_paid)}}
                                </p>
                                <small>
                                    Total paid 
                                </small>
                            </div>
                            <div class="col-md-4 p-3 text-center card bg-gradient-light">
                                <i class="cil-warning h3 text-warning"></i>
                                <p class="mb-0 h5">
                                   {!!config('payment.naira')!!}{{number_format(max($sale->total_amount - $sale->total_paid,0))}}
                                </p>
                                <small>
                                    Total remaining
                                </small>
                            </div>
                            <div class="col-md-4 p-3 text-center card bg-gradient-light">
                                <i class="cil-star h3 text-primary"></i>
                                <p class="mb-0 h5">
                                    {{$sale->plan->name}}
                                </p>
                                <small>
                                    Plan
                                </small>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar {{paint($sale->percent_paid)}}" role="progressbar" style="width: {{$sale->percent_paid}}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-muted mt-2 text-center">
                                    <small>
                                        Progress: {{min (100, round($sale->percent_paid))}}% 
                                        @if($sale->percent_paid >= 100) 
                                            <i class="cil cil-check text-white p-1 bg-success" style="border-radius:200px"></i>
                                        @endif
                                    </small> <br>
                                    <a href="{{route('admin.sales.show', $sale)}}" class="text-primary">
                                        <i class="cil cil-money"></i>
                                        View
                                    </a>
                                </p>
                                <p>
                                </p>
                            </div>
                        </div>
                        @if($sale->percent_paid < 100) 
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>
                                    <button class="btn btn-info btn-sm collapsed" type="button" data-toggle="collapse" data-target="#{{$sale->code}}" aria-expanded="false" aria-controls="{{$sale->code}}">
                                        Add Payment <i class="cil cil-plus font-weight-bolder mx-1"></i>
                                    </button>
                                </p>
                                <div class="collapse" id="{{$sale->code}}">
                                    <form action="{{route('admin.sales.autopay', $sale)}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input type="number" name="amount" id="" class="form-control" placeholder="Amount">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success float-right">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-10 mx-auto">
                <p class="display-4 text-muted">
                    User has not made any purchase yet
                </p>
            </div>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')

@endsection