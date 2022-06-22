@extends('auth.layouts.master')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-md-7 p-4 mb-0">
            <div class="card-body">
                <h1>Login</h1>
                <p class="text-medium-emphasis">Sign In to your account</p>
                <div class="input-group mb-3"><span class="input-group-text">
                    <svg class="icon">
                    <use xlink:href="{{ asset('vendors/coreui/icons/sprites/free.svg#cil-user') }}"></use>
                    </svg></span>
                <input class="form-control" type="text" placeholder="Username">
                </div>
                <div class="input-group mb-4"><span class="input-group-text">
                    <svg class="icon">
                    <use xlink:href="{{ asset('vendors/coreui/icons/sprites/free.svg#cil-lock-locked') }}"></use>
                    </svg></span>
                <input class="form-control" type="password" placeholder="Password">
                </div>
                <div class="row">
                <div class="col-6">
                    <button class="btn btn-primary px-4" type="button">Login</button>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
