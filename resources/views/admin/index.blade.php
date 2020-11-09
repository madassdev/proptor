@extends('layouts.app')
@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-gradient-primary">
                <div class="card-body card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-value-lg">{{number_format($total_properties)}}</div>
                        <div>Properties</div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-gradient-success">
                <div class="card-body card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-value-lg">{{number_format($total_users)}}</div>
                        <div>Users</div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-gradient-warning">
                <div class="card-body card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-value-lg">{{number_format($total_sales)}}</div>
                        <div>Total Sales</div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-gradient-danger">
                <div class="card-body card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-value-lg">{!!config('payment.naira').number_format($total_payments)!!}</div>
                        <div>Payments</div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg class="c-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- <div class="row mb-3">
        <div class="col-md-12">
            <h5 class="text-primary text-center">
                *** Featured properties ***
            </h5>
        </div>
    </div>
    <div class="row">
        @foreach($properties as $property)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <img src="https://picsum.photos/200/200" alt="" width="60px" srcset="" style="border-radius: 100px;">
                        </div>
                        <div class="col-md-8">
                            <span style="display:block" class="mb-1">
                                <i class="fas fa-home text-primary mr-2"></i>
                                <span  class=""> {{$property->name}}</span>
                            </span>
                            <span style="display:block" class="mb-1">
                                <i class="fas fa-credit-card text-warning mr-2"></i>
                                <span  class="font-weight-bold"> ${{number_format($property->price)}}</span>
                            </span>
                            <span style="display:block" class="mb-1">
                                <i class="fas fa-square text-primary mr-2"></i>
                                <span  class=""> {{$property->size ?? 100}} m<sup>2</sup></span>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{route('admin.properties.show',$property)}}" class="btn btn-block btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div> -->
</div>
@endsection