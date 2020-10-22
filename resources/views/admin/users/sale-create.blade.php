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
        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.users.show', $user)}}">{{ucfirst($user->full_name)}}</a></li>
        <li class="breadcrumb-item active">Add Sale</li>
    </ol>
</div>
@endsection

@section('content')

<div id="ui-view"><div><div class="fade-in">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <strong>Create Sale</strong> 
                    <a href="{{route('admin.users.index')}}" class="btn btn-danger float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.sales.store', $user)}}" method="post" class="">
                        @csrf
                        <div class="form-group">
                            <label for="company">Property</label>
                            <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="property_search" type="text" placeholder="Type property name" required autocomplete="off">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <ul class="list-group result">
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="company">Plan</label>
                            <select name="plan_id" id="plan_select" class="form-control" required>
                                <option value="" selected disabled>Select</option>
                                <!-- @foreach($plans as $plan)
                                    <option value="{{$plan->id}}" {{old('plan_id') == $plan->id ? 'selected' : ''}}>{{$plan->name}}</option>
                                @endforeach -->
                            </select>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        var nf = new Intl.NumberFormat()
        $(document).on("keyup", "#property_search", function(e){
            var txt = $(this).val();
            var resultDropdown = $(".result");
            var properties = "";
            if (txt !='')
            {
                $.ajax
                (
                {
                    type:"post",    //submit method
                    url: api_url+"/properties/search",  //url to sumitted data To
                    data: {q : txt}, //Data to be submitted
                    cache: false,
                    dataType: 'json',
                    //action on successful post request
                    success: function(data)
                    {
                        if(data.data.length){
                            //process JSON
                            $.each(data.data, function(idx, property){
                                properties += '<li class="list-group-item"><a href="#" class="text-primary selected_property"'+"data-plans='"+JSON.stringify(property.plans)+"'"+'" data-id="'+ property.name +'">' + property.name +'</a> - '+ property.price.toLocaleString() +'</li>';
                            });

                            resultDropdown.html(properties);

                        }else{
                            properties = '<li class="list-group-item">No property found</li>'
                            resultDropdown.html(properties);
                        }


                    },
                }
                )
            }
            else
            {
                resultDropdown.empty();
            }

            $(document).on("click", ".selected_property", function(e){
                e.preventDefault();
                var resultDropdown = $(".result");

                var property_search = $("#property_search")
                var plan_select = $("#plan_select")
                var property_plans = JSON.parse($(this).attr('data-plans'))
                var options = ''
                $.each(property_plans, function(idx, plan){
                    // console.log(property.plans)
                    options += '<option value="'+plan.id+'">' + plan.name + "</option>"
                });
                plan_select.html(options);
                
                property_search.val($(this).attr('data-id'))
                resultDropdown.hide()

            });
        })

        
    });
</script>
@endsection