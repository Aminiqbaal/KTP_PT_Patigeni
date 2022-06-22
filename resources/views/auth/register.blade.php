@extends('auth.layouts.master')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-lg-4 col-md-6 col-sm-8">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1 class="text-center mb-3">{{ __('Register') }}</h1>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                            </svg></span>
                        </div>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                            </svg></span>
                        </div>
                        <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                            </svg></span>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                            </svg></span>
                        </div>
                        <input class="form-control" type="password" id="password-confirm" name="password_confirmation" placeholder="Repeat password" required>
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Create Account</button>
                    <a class="btn btn-block btn-link" href="{{ route('login') }}">Login</a>
                </form>
            </div>
        </div>
    </div>
@endsection
