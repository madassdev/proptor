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
@endphp

@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.payments.index')}}">Payments</a></li>
        <li class="breadcrumb-item active">{{ucfirst($payment->user->full_name)}}</li>
    </ol>
</div>
@endsection

@section('content')
<div id="ui-view"><div><div class="fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8 mx-auto">
            <div class="card card-accent-{{$status[$payment->status]}}">
                <div class="card-body  px-5 py-3">
                    <div class="row">
                        <div class="col-md-6">
                            Payment
                            <p class="text-primary h1">
                                {!!config('payment.naira').number_format($payment->amount)!!}
                            </p>
                            <p class="text-dark mb-1">
                                Paid by:
                                <span class="h5">
                                    {{ucfirst($payment->user->full_name)}} 
                                    <small>
                                        ({{$payment->user->mobile ?? 'No phone number'}})
                                    </small> 
                                </span>
                            </p>
                            <p class="mb-1">
                                Payment via: <span class="badge badge-{{$method[$payment->method]}} text-white">{{ucfirst($payment->method)}}</span>
                            </p>
                            <p>
                                Status: <span class="badge badge-{{$status[$payment->status]}} text-white">{{ucfirst($payment->status)}}</span>
                            </p>
                            <p class="mb-1">
                                Date: <span class="text-muted font-weight-bolder">{{$payment->updated_at->format('Y/M/d')}}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                Payment for:
                            </p>
                            <p class="text-dark h3">
                                {{ucfirst($payment->sale->property->name)}}
                            </p>
                            <p class="mb-0">
                                <small>
                                    Plan
                                </small> 
                            </p>
                            <p class="text-info font-weight-bolder">
                                {{strtoupper($payment->sale->plan->name)}}
                            </p>
                            <a href="{{route('admin.sales.show', $payment->sale)}}" class="btn btn-primary btn-sm font-weight-bold">Sale: {{$payment->sale->code}}</a>
                            <!-- <img src="{{asset('images/'.$payment->method.'_logo.png')}}" alt="" width="150px" srcset="" class="rounded thumbnail float-right"> -->
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if($payment->status != 'success')
                    <form action="{{route('admin.payments.update', $payment)}}" method="post"  onsubmit="return confirm('About to confirm payment manually, User payment and sales records will be updated accordingly, sure to continue???');" style="display: inline-block;">
                        @csrf
                        @method('put')
                        <input type="hidden" name="status" value="success">
                        <button type="submit" class="btn btn-sm btn-success">
                            Confirm payment?
                        </button>
                    </form>

                    <form action="{{route('admin.payments.update', $payment)}}" method="post"  onsubmit="return confirm('Payment will be marked as cancelled, proceed???');" style="float:right">
                        @csrf
                        @method('put')
                        <input type="hidden" name="status" value="failed">
                        <button type="submit" class="btn btn-sm btn-danger">
                            Cancel payment?
                        </button>
                    </form>
                    @else
                    <div class="col-md-12 text-center">
                        <button class="btn btn-secondary text-white btn-block">
                            <i class="fa fa-check mr-2"></i> {{ucfirst($payment->status)}}
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection