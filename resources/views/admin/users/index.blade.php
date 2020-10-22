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
        <li class="breadcrumb-item active">Users</li>
    </ol>
</div>
@endsection

@section('content')

<div id="ui-view"></div>
<div class="fade-in">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <strong>
                        Users
                    </strong>
                    <span class="float-right">
                        {{$users->links("pagination::bootstrap-4")}}
                    </span>
                    <table class="table table-responsive-sm table-condensed">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                {{ucfirst($user->full_name)}}
                            </td>
                            <td>
                                <span class="font-weight-bolder">
                                    {{$user->email}}
                                </span>
                            </td>
                            <td>
                                <span class="font-weight-bolder">
                                    {{ucfirst($user->mobile ?? "N/A")}}
                                </span>
                            </td>
                            <td>
                                <a href="{{route('admin.users.show', $user)}}" class="text text-primary">
                                    View
                                </a>
                                <a href="{{route('admin.users.sales.create', $user)}}" class="btn btn-sm p-1 btn-primary">
                                    Sale
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
                                                No User to display.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </table>
                    <span class="float-right">
                        {{$users->render("pagination::bootstrap-4")}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection