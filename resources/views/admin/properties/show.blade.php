@extends('layouts.app')


@section('subheader')
<div class="c-subheader justify-content-between px-3">
    <ol class="breadcrumb border-0 m-0 px-0 px-md-3">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item"><a href="{{route('admin.properties.index')}}">Properties</a></li>
        <li class="breadcrumb-item active">{{$property->name}}</li>
    </ol>
</div>
@endsection

@section('content')
<div id="ui-view"><div><div class="fade-in">
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <img src="{{$property->image_url['url']}}" width="400" alt="">
                </div>
            </div>
            <div class="row my-3">
                @foreach($property->gallery_images_url as $image)
                <div class="col-md-3 mx-3 my-2">
                    <img class="thumbnail border-danger rounded" src="{{$image['url']}}" height="80" alt="">
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">

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