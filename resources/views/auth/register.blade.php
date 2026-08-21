@extends('layouts.app2', ['title' => 'Register - '])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="rounded border p-3 bg-light">
                <p class="display-3"><a href="{{ route('home') }}" class="me-3"><i class="fa fa-chevron-left"></i></a>{{ __('Register') }}</p>
                <hr>
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="row mt-5 mb-3 justify-content-center">

                        <div class="col-md-8">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="fa fa-user input-login"></i></span>
                            
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Masukkan Nama') }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
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
                                <span class="input-group-text"><i class="fa fa-envelope-o input-login"></i></span>
                            
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Masukkan Email') }}" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                            
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Masukkan Password') }}" name="password" required autocomplete="new-password">

                            @error('password')
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
                                <input id="password-confirm" type="password" class="form-control" placeholder="{{ __('Konfirmasi Password') }}" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0 text-center">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
