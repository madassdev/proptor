@extends('layouts.app')

@php
    $status = [
        "active"=>"success",
        "success"=>"success",
        "confirmed"=>"success",
        "pending"=>"warning",
        "canceled"=>"danger",
        "failed"=>"danger",
        "inactive"=>"secondary",
    ];

    $method = [
        "paystack"=>"info",
        "flutterwave"=>"warning",   
        "bank-transfer"=>"dark" 
    ];

    $paystack_active = "secondary";
    $count = 0;
@endphp

@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.sales.index')}}">Sales</a></li>
        <li class="breadcrumb-item active">{{ucfirst($sale->code)}}</li>
    </ol>
</div>
@endsection

@section('content')
<div id="ui-view"><div><div class="fade-in">
    <div class="row justify-content-center">
        <div class="col-md-12 mx-auto">
            <div class="card card-accent-primary">
                <div class="card-body  px-5 py-3">
                    <div class="row">
                        <div class="col-md-4">
                            Remaining amount
                            <p class="text-danger h3">
                                {!!config('payment.naira').number_format($sale->total_amount - $sale->total_paid)!!}
                            </p>
                            Total paid
                            <p class="text-success h5">
                                {!!config('payment.naira').number_format($sale->total_paid)!!}
                            </p>
                            
                            Property amount
                            <p class="text-dark font-weight-bolder">
                                {!!config('payment.naira').number_format($sale->total_amount)!!}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-0">
                                Property
                            </p>
                            <p class="text-dark h3 mb-0">
                                {{ucfirst($sale->property->name)}} <br>
                            </p>
                            <small class="text-muted">
                                {{$sale->property->address??"Property address appears here"}}
                            </small>
                            <p class="mt-1 mb-0">
                                <small>
                                    Plan
                                </small> 
                            </p>
                            <p class="text-info font-weight-bolder">
                                {{strtoupper($sale->plan->name)}}
                            </p>
                            <a href="{{route('admin.sales.show', $sale)}}" class="btn btn-primary btn-sm font-weight-bold">Sale: {{$sale->code}}</a>
                        </div>
                        <div class="col-md-4">
                            User details
                            <p class="text-dark h3">
                                {{ucfirst($sale->user->full_name)}}
                            </p>
                            <p class="text-dark mb-1">
                                Agent:
                                <span class="h5">
                                    {{ucfirst($sale->agent->namse ?? 'No agent')}} 
                                </span>
                            </p>
                            <p class="text-success h3">
                                {!!config('payment.naira').number_format($sale->total_paid)!!}
                            </p>
                            
                            Property amount
                            <p class="text-dark font-weight-bolder">
                                {!!config('payment.naira').number_format($sale->total_amount)!!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <p class="h3 m-0 text-center">
                        Payments
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($sale->payments as $payment)
                        <div class="col-md-3">
                            <a href="{{route('admin.payments.show',$payment)}}">
                                <div class="card card-accent-{{$method[$payment->method]}} p-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{asset('images/'.$payment->method.'_logo.png')}}" alt="" class="img-fluid img-responsive">
                                            <span class="text-secondary">
                                                <!-- {{ucfirst($payment->method)}} -->
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text text-dark h5">
                                                {!!config('payment.naira')!!}{{number_format($payment->amount)}}
                                            </span> 
                                            <p class="mb-0">
                                                <span class="badge badge-{{$status[$payment->status]}}">
                                                    {{ucfirst($payment->status)}}
                                                </span>
                                            </p>
                                            <small>
                                                {{$payment->created_at->format('Y/M/d')}}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <span class="float-right">
                        View more: {{$sale->payments->render("pagination::bootstrap-4")}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection