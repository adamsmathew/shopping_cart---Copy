@extends('layouts.app')

@section('content')
<div class="container-xxl position-relative bg-light d-flex p-0">
    <!-- Sign In Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-white rounded shadow p-4 p-sm-5 my-4 mx-3">
                    <h3 class="text-center mb-4 text-primary">Login</h3> <!-- Centered Login Title -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            <label for="email">{{ __('Email Address') }}</label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password">{{ __('Password') }}</label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            {{-- @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif --}}
                        </div>

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">{{ __('Login') }}</button>
                        {{-- <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a></p> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign In End -->
</div>
@endsection