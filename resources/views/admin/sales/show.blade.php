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
        "bank-transfer"=>"dark", 
        "autopaid"=>"success", 
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
        <div class="col-md-6">
            <div class="card card-accent-primary">
                <div class="card-body  px-5 py-3">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <p class="h3 m-0 text-center">
                        Payments
                    </p>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <th>S/N</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            @forelse($sale->payments as $payment)
                            @php $count++; @endphp
                            <tr>
                                <td>{{$count}}</td>
                                <td>{!!config('payment.naira')!!}{{number_format($payment->amount)}}</td>
                                <td>
                                    <span class="badge badge-{{$status[$payment->status]}}">
                                        {{ucfirst($payment->status)}}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-{{$method[$payment->method]}}">
                                        {{ucfirst($payment->method)}}
                                    </span>
                                </td>
                                <td>
                                    {{$payment->created_at->format('Y/M/d')}}
                                </td>
                                <td>
                                    <a href="{{route('admin.payments.show',$payment)}}">View</a>
                                </td>
                            </tr>
                            @empty

                            @endforelse

                        </table>
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