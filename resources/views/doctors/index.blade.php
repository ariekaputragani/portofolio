@extends('layouts.app', ['title' => 'Dokter - '])

@section('content')
@include('layouts.banner')
<div class="container py-5 huruf-serif">
    <div class="row">
        <div class="col-3">
            @include('layouts.nav')
        </div>
        <div class="col-9">
            <h4>Semua Dokter</h4>
            <hr>
            @if($doctors->count())
            <div class="table-responsive">
                <table class="table table-bordered tb-doctor">
                    <thead class="table-doctor">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Poliklinik</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $key => $doctor)
                        <tr>
                            <th scope="row">{{ $doctors->firstItem()+$key }}</th>
                            <td>{{ $doctor->poli->name }}</td>
                            <td><a href="{{ route('doctors.show', $doctor->slug) }}">{{ $doctor->name }}</a></td>
                            <td>{{ $doctor->birthdate }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>{{ $doctor->address }}</td>
                            <td>
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <a href="/doctors/{{ $doctor->slug }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    </div>
                                    <div class="ms-2">
                                        <a href="/doctors/{{ $doctor->slug }}/delete" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>
            @else
                <div class="alert alert-info">
                    Tidak ada dokter.
                </div>
            @endif
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection