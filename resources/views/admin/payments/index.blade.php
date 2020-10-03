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
@endphp

@extends('layouts.app')


@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Payments</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="ui-view"></div>
    <div class="fade-in">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <strong>
                            Payments
                        </strong>
                        <span class="float-right">
                            {{$payments->links("pagination::bootstrap-4")}}
                        </span>
                        <div class="row">
                            <div class="col-md-12 mx-auto my-3">
                                <a href="{{route('admin.payments.index')}}" class="btn btn-sm btn-{{request()->payment_method == null ? 'outline-dark' : 'success'}} mx-1">
                                    <strong>All</strong></a>
                                <a href="{{route('admin.payments.index', ['payment_method'=>'paystack'])}}" class="btn btn-sm btn-{{request()->payment_method == 'paystack' ? 'outline-dark' : 'info'}} mx-1">
                                    <strong>Paystack</strong></a>
                                <a href="{{route('admin.payments.index', ['payment_method'=>'flutterwave'])}}" class="btn btn-sm btn-{{request()->payment_method == 'flutterwave' ? 'outline-dark' : 'warning'}} mx-1">
                                    <strong>Flutterwave</strong></a>
                                <a href="{{route('admin.payments.index', ['payment_method'=>'bank-transfer'])}}" class="btn btn-sm btn-{{request()->payment_method == 'bank-transfer' ? 'outline-dark' : 'primary'}} mx-1">
                                    <strong>Bank transfer</strong></a>
                            </div>
                        </div>
                        <table class="table table-responsive-sm">
                            <thead>
                                <th>User</th>
                                <th>Property</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            @forelse($payments as $payment)
                            <tr>
                                <td>
                                    {{ucfirst($payment->user->full_name)}}
                                </td>
                                <td>
                                    <a href="{{route('admin.sales.show', $payment->sale)}}" class="text-primary">
                                        {{ucfirst($payment->sale->property->name)}}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge border-{{$method[$payment->method]}} text-{{$method[$payment->method]}}">
                                        {{ucfirst($payment->method)}}
                                    </span>
                                </td>
                                <td>
                                    <strong>
                                        {!!config('payment.naira')!!}{{number_format($payment->amount)}}
                                    </strong>
                                </td>
                                <td>
                                    <a href="{{route('admin.payments.show', $payment)}}" class="badge text-white badge-{{$status[$payment->status]}}">
                                        {{ucfirst($payment->status)}}
                                    </a>
                                </td>
                                <td>
                                    <small class="font-weight-bolder">
                                        {{$payment->updated_at->format('Y/M/d')}}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{route('admin.payments.show', $payment)}}" class="text text-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10">
                                    <div class="col-lg-10 mx-auto">
                                        <div class="row">
                                            <div class="col-md-12 text-center my-5">
                                                <p class="display-3 text-secondary">
                                                    No Payments to display.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                        <span class="float-right">
                            {{$payments->render("pagination::bootstrap-4")}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection