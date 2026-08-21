@extends('layouts.app', ['title' => 'Dokter - '])

@section('content')
@include('layouts.banner')
<div class="bg-krem py-5 app-serif">
    <div class="container pt-3">
        <h1 class="wow fadeInLeft" data-wow-delay="0.2s">Jadwal Dokter</h1>
        <hr>
        @if($doctors->count())
            <div class="table-responsive wow fadeInRight" data-wow-delay="0.6s">
                <table class="table table-bordered tb-doctor">
                    <thead class="table-doctor">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Poliklinik</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Senin</th>
                            <th scope="col">Selasa</th>
                            <th scope="col">Rabu</th>
                            <th scope="col">Kamis</th>
                            <th scope="col">Jumat</th>
                            <th scope="col">Sabtu</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $key => $doctor)
                        <tr>
                            <th scope="row">{{ $doctors->firstItem()+$key }}</th>
                            <td>{{ $doctor->poli->name }}</td>
                            <td><a href="{{ route('doctors.show', $doctor->slug) }}">{{ $doctor->name }}</a></td>
                            <td>{{ str_replace(":",".",substr($doctor->sen_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sen_end,0,5)) }}</td>
                            <td>{{ str_replace(":",".",substr($doctor->sel_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sel_end,0,5)) }}</td>
                            <td>{{ str_replace(":",".",substr($doctor->rab_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->rab_end,0,5)) }}</td>
                            <td>{{ str_replace(":",".",substr($doctor->kam_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->kam_end,0,5)) }}</td>
                            <td>{{ str_replace(":",".",substr($doctor->jum_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->jum_end,0,5)) }}</td>
                            <td>{{ str_replace(":",".",substr($doctor->sab_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sab_end,0,5)) }}</td>
                            <td class="text-center"><button type="button" class="btn btn-primary btn-sm addjanji">Daftar</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>
            <div class="wow fadeInLeft" data-wow-delay="0.4s">
                {{ $doctors->links() }}
            </div>
        @else
            <div class="alert alert-info">
                Tidak ada dokter.
            </div>
        @endif
    </div>
</div>
@endsection