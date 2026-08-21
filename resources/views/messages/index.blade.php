@extends('layouts.app', ['title' => 'Pesan - '])

@section('content')
@include('layouts.banner')
<div class="container py-5 huruf-serif">
    <div class="row">
        <div class="col-3">
            @include('layouts.nav')
        </div>
        <div class="col-9">
            <h4>Semua Pesan</h4>
            <hr>
            @if($messages->count())
            <div class="table-responsive">
                <table class="table table-bordered tb-doctor">
                    <thead class="table-doctor">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">No Telepon</th>
                            <th scope="col">Pesan</th>
                            <th scope="col">Waktu Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $key => $message)
                        <tr>
                            <th scope="row">{{ $messages->firstItem()+$key }}</th>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone }}</td>
                            <td>{{ $message->message }}</td>
                            <td>{{ $message->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>
            @else
                <div class="alert alert-info">
                    Tidak ada pesan.
                </div>
            @endif
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection