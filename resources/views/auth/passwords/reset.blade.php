@extends('layouts.app2', ['title2' => 'Reset Password'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="rounded border p-3 bg-light">
                <p class="display-3"><a href="{{ route('login') }}" class="me-3"><i class="fa fa-chevron-left"></i></a>{{ __('Reset Password') }}</p>
                <hr>
                <form method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mt-5 mb-3 justify-content-center">
                        
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-envelope-o input-login"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Masukkan Email') }}" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" style="margin-left:54px" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-envelope-o input-login"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Masukkan Password') }}" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" style="margin-left:54px" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-envelope-o input-login"></i></span>
                                <input id="password-confirm" type="password" class="form-control" placeholder="{{ __('Konfirmasi Password') }}" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-0">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
