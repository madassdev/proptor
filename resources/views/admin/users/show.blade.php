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
            <a href="{{route('admin.users.index')}}" class="btn btn-danger float-right">Back</a>
        </div>
    </div>
    <div class="row justify-content-center">
        @forelse($user->sales as $sale)
            <div class="col-md-6">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>
                                    <button class="btn btn-primary btn-sm collapsed" type="button" data-toggle="collapse" data-target="#{{$sale->code}}" aria-expanded="false" aria-controls="{{$sale->code}}">Add Payment</button>
                                </p>
                                <div class="collapse" id="{{$sale->code}}" style="">
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