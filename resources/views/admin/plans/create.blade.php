@extends('layouts.app')

@section('links')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item"><a href="{{route('admin.plans.index')}}">Plans</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</div>
@endsection

@section('content')
<div id="ui-view"><div><div class="fade-in">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <strong>Create new Plan</strong> 
                    <a href="{{route('admin.plans.index')}}" class="btn btn-danger float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.plans.store')}}" method="post" class="">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="company">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="company" type="text" placeholder="Plan name" required>
                                <input type="hidden" name="type" value="land">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="city">Duration(in months)</label>
                                <input class="form-control @error('duration') is-invalid @enderror" id="price" value="{{ old('duration') }}" name="duration" type="number" placeholder="Enter plan duration in months" required>
                                @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<script>
    $(document).ready(function() {
    $('.plans-select').select2();
});
</script>
@endsection