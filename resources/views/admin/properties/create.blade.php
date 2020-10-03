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
        <li class="breadcrumb-item"><a href="{{route('admin.properties.index')}}">Properties</a></li>
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
                    <strong>Create new Property</strong> 
                    <a href="{{route('admin.properties.index')}}" class="btn btn-danger float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.properties.store')}}" method="post" class="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="company">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="company" type="text" placeholder="Property name" required>
                            <input type="hidden" name="type" value="land">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="city">Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" name="price" type="number" placeholder="Enter price of property">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="postal-code">Size (in Square meters sqm)</label>
                                <input class="form-control @error('size') is-invalid @enderror" id="units" value="{{ old('size') ?? 100 }}" name="size" type="number" placeholder="Size (in Square meters sqm)">
                                @error('size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <label for="city">State</label>
                                <input class="form-control @error('state') is-invalid @enderror" id="state" value="{{ old('state') }}" name="state" type="text" placeholder="Enter state">
                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4">
                            <label for="postal-code">City </label>
                                <input class="form-control @error('city') is-invalid @enderror" id="city" value="{{ old('city') }}" name="city" type="text" placeholder="Enter city">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label class="col-md-3 col-form-label" for="textarea-input">Address</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="textarea-input" name="address" rows="2" placeholder="Enter the address of the property">{{old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Select">Select plans</label>
                            <select name="plans[]" class="form-control plans-select @error('size') is-invalid @enderror" id="plans-select" multiple="true" required>
                                @foreach($plans as $plan)
                                <option value="{{$plan->id}}" @php if(old('plans')){echo (collect(old('plans'))->contains($plan->id)) ? 'selected':'';}else{echo 'selected';}  @endphp }}>{{$plan->name}}</option>
                                <!-- <option value="{{$plan->id}}" {{ (collect(old('plans'))->contains($plan->id)) ? 'selected':'' }}>{{$plan->name}}</option> -->
                                @endforeach
                            </select>
                            @error('plans')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <hr>

                        <div class="form-group row mt-3">
                            <label class="col-md-3 col-form-label" for="textarea-input">Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="textarea-input" name="description" rows="5" placeholder="Description of property">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group py-3 text-center border-secondary m-3">
                            <label for="image url">Preview image</label> <br>
                            <input type="file" id="" name="image">
                        </div>
                        <div class="form-group py-3 text-center border-secondary m-3">
                            <label for="image url">Gallery images</label> <br>
                            <input type="file" id="" name="gallery_images[]" multiple="true" placeholder="Select images">
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