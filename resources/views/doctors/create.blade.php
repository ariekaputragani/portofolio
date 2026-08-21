@extends('layouts.app2', ['title2' => 'Dokter baru'])

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="display-3"><a href="/doctors" class="me-3"><i class="fa fa-chevron-left"></i></a>Dokter baru</p>
                </div>
                <div class="card-body">
                    <form action="/doctors/store" method="post" autocomplete="off" enctype="multipart/form-data" novalidate>
                        @csrf
                        @include('doctors.partials.form-control', ['submit' => 'Buat'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection