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
    <div class="row justify-content-center">
        @foreach($user->sales as $sale)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-gradient-light">
                        <p class="h3 text-primary">
                            {{ucfirst($sale->property->name)}}
                        </p>
                    </div>
                    <div class="card-body">
                        Total paid: $5000 <br>
                        Total price: $120000 <br>
                        Total remaining: $90000 <br>
                        Next due date: Jan 22 <br>
                        Plan: Basic <br>
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
                                <div class="fomr-group">
                                    <button type="submit" class="btn btn-sm btn-success float-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')

@endsection