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
        <li class="breadcrumb-item active">Sales</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="ui-view"></div>
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <strong>
                            Sales
                        </strong>
                        <span class="float-right">
                            {{$sales->links("pagination::bootstrap-4")}}
                        </span>
                        <table class="table table-responsive-sm">
                            <tr>
                                <th>User</th>
                                <th>Property</th>
                                <th>Total paid</th>
                                <th>Total amount</th>
                                <th>Next due payment</th>
                                <th>Action</th>
                            </tr>
                            @forelse($sales as $sale)
                            <tr>
                                <td>
                                    {{ucfirst($sale->user->full_name)}}
                                </td>
                                <td>
                                    <span class="font-weight-bolder">
                                        {{ucfirst($sale->property->name)}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{route('admin.sales.show', $sale)}}" class="text-primary">
                                        <strong>
                                            {!!config('payment.naira')!!}{{number_format($sale->total_paid)}}
                                        </strong>
                                    </a>
                                </td>
                                <td>
                                    <strong class="text-dark">
                                        {!!config('payment.naira')!!}{{number_format($sale->total_amount)}}
                                    </strong>
                                </td>
                                <td>
                                    <span>
                                        {{$sale->updated_at->format('Y/M/d')}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{route('admin.sales.show', $sale)}}" class="text text-primary">
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
                                                    No Sales to display.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                        <span class="float-right">
                            {{$sales->render("pagination::bootstrap-4")}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection