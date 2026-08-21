@extends('layouts.app', ['title' => 'Profil - '])

@section('content')
@include('layouts.banner')
<div class="container py-5 huruf-serif">
    <div class="row">
        <div class="col-3">
            @include('layouts.nav')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header"><h1>{{ __('Akun') }}</h1></div>

                <div class="card-body">
                    <h4>Nama<a href="#" class="ms-2" id="editname"><i class="fa fa-pencil"></i></a></h4>
                    <h4>{{ Auth::user()->name }}</h4>
                    <h4>Email<a href="#" class="ms-2" id="editemail"><i class="fa fa-pencil"></i></a></h4>
                    <h4>{{ Auth::user()->email }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
