@extends('layouts.app', ['title' => 'Data Janji - '])

@section('content')
@include('layouts.banner')
<div class="container py-5 huruf-serif">
    <div class="row">
        <div class="col-3">
            @include('layouts.nav')
        </div>
        <div class="col-9">
            <h4>Data Janji</h4>
            <hr>
            @if($appointments->count())
            <div class="table-responsive">
                <table class="table table-bordered tb-doctor">
                    <thead class="table-doctor">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tanggal Janji</th>
                            <th scope="col">Departemen</th>
                            <th scope="col">No Telepon</th>
                            <th scope="col">Pesan Tambahan</th>
                            <th scope="col">Waktu Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $key => $appointment)
                        <tr>
                            <th scope="row">{{ $appointments->firstItem()+$key }}</th>
                            <td>{{ $appointment->name }}</td>
                            <td>{{ $appointment->email }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->departement }}</td>
                            <td>{{ $appointment->phone }}</td>
                            <td>{{ $appointment->message }}</td>
                            <td>{{ $appointment->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>
            @else
                <div class="alert alert-info">
                    Tidak ada data janji.
                </div>
            @endif
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection