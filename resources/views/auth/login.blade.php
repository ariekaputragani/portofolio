@extends('layouts.app2', ['title' => 'Login - '])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="rounded border p-3 bg-light">
                <p class="display-3"><a href="{{ route('home') }}" class="me-3"><i class="fa fa-chevron-left"></i></a>{{ __('Login') }}</p>
                <hr>
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="row mt-5 mb-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-envelope-o input-login"></i></span>
                                <input id="email" type="email" placeholder="{{ __('Masukkan Email')}}" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" style="margin-left:54px" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-unlock-alt input-login"></i></span>
                                <input id="password" type="password" placeholder="{{ __('Masukkan Password')}}" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" style="margin-left:54px" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-check huruf-lg">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Ingatkan saya') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-0">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Lupa Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="text-center mb-3">
                        @if (Route::has('register'))
                            <a class="btn btn-link" href="{{ route('register') }}">
                                {{ __('Belum punya akun?') }}
                            </a>
                        @endif
                    </div>
                    <div class="text-center mb-0">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
