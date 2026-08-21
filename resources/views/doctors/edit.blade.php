@extends('layouts.app2', ['title2' => 'Dokter baru'])

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="display-3"><a href="/doctors" class="me-3"><i class="fa fa-chevron-left"></i></a>Update dokter: {{ $doctor->name }}</p>
                </div>
                <div class="card-body">
                    <form action="/doctors/{{ $doctor->slug }}/edit" method="post" autocomplete="off" enctype="multipart/form-data" novalidate>
                        @method('patch')
                        @csrf
                        @include('doctors.partials.form-control')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection