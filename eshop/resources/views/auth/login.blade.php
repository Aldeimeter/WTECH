@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="form-group text-center mt-5 col-12 col-lg-6 offset-lg-3 bg-white p-1 border border-opacity-50 rounded-5 border-2">
            <h1 class="m-3">{{__('Prihlásenie')}}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{__('E-mailová adresa')}}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{__('Heslo')}}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>

                    </div>
                    <!-- <div class= "col-md-8 offset-md-2"> -->
                    <!--     @if (Route::has('password.request')) -->
                    <!--         <a class="btn btn-link" href="{{ route('password.request') }}"> -->
                    <!--             {{ __('Forgot Your Password?') }} -->
                    <!--         </a> -->
                    <!--     @endif -->
                    <!-- </div> -->
                    <div class= "col-md-8 offset-md-2">
                        @if (Route::has('register'))
                            <a class="btn btn-link" href="{{ route('register') }}">
                                {{ __('Ešte nemáte účet?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
