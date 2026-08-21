@extends('layouts.app2', ['title' => 'Verify - '])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="rounded border p-3 bg-light">
                <p class="display-3"><a href="{{ route('login') }}" class="me-3"><i class="fa fa-chevron-left"></i></a>{{ __('Verifikasi Alamat Email Anda') }}</p>
                <hr>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                    </div>
                @endif

                {{ __('Sebelum melanjutkan, harap periksa email Anda untuk mendapatkan tautan verifikasi.') }}
                {{ __('Jika Anda tidak menerima email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk meminta lagi') }}</button>.
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
