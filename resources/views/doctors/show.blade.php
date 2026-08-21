@extends('layouts.app2', ['title' => $doctor->name . ' - '])

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 article p-2">
            <h1 class="pt-3 px-3" style="background: #58bbf8"><a href="/dokter" class="me-3"><i class="fa fa-chevron-left"></i></a>Profil Dokter<hr class="pb-2"></h1>
            @if($doctor->pp)
                <div class="row mb-3">
                    <div class="col-7 ms-2">
                        <img src="{{ $doctor->takeImage }}" class="img-thumbnail thumb w-100" alt="">
                    </div>
                </div>
            @endif
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Nama</b></div>
                <div class="col-9">: {{ $doctor->name }}</div>
            </div>
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Poli</b></div>
                <div class="col-9">: {{ $doctor->poli->name }}</div>
            </div>
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Tanggal Lahir</b></div>
                <div class="col-9">: {{ $doctor->birthdate }}</div>
            </div>
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Email</b></div>
                <div class="col-9">: <a href="#">{{ $doctor->email }}</a></div>
            </div>
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Telepon</b></div>
                <div class="col-9">: {{ $doctor->phone }}</div>
            </div>
            <div class="row mb-3 pt-14 ms-2">
                <div class="col-3 text-end"><b>Alamat</b></div>
                <div class="col-9">: {{ $doctor->address }}</div>
            </div>
            <p class="mb-3 ms-2">{!! nl2br($doctor->desc) !!}</p>
            <h1 class="pt-3 px-3" style="background: #4472c4">Jadwal Dokter<hr class="pb-2"></h1>
            <table class="table table-bordered tb-doctor">
                <tr>
                    <td>Senin</td>
                    <td>{{ str_replace(":",".",substr($doctor->sen_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sen_end,0,5)) }}</td>
                </tr>
                <tr>
                    <td>Selasa</td>
                    <td>{{ str_replace(":",".",substr($doctor->sel_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sel_end,0,5)) }}</td>
                </tr>
                <tr>
                    <td>Rabu</td>
                    <td>{{ str_replace(":",".",substr($doctor->rab_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->rab_end,0,5)) }}</td>
                </tr>
                <tr>
                    <td>Kamis</td>
                    <td>{{ str_replace(":",".",substr($doctor->kam_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->kam_end,0,5)) }}</td>
                </tr>
                <tr>
                    <td>Jumat</td>
                    <td>{{ str_replace(":",".",substr($doctor->jum_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->jum_end,0,5)) }}</td>
                </tr>
                <tr>
                    <td>Sabtu</td>
                    <td>{{ str_replace(":",".",substr($doctor->sab_start,0,5)) }} - {{ str_replace(":",".",substr($doctor->sab_end,0,5)) }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection