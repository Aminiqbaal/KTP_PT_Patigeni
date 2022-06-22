@extends('auth.layouts.master')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-lg-4 col-md-6 col-sm-8">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 class="text-center mb-3">{{ __('Login') }}</h1>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                            </svg></span>
                        </div>
                        <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username" autofocus>
                        @error('username')
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
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {{-- <a class="btn btn-link px-0" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
