@extends('layouts.app', ['title' => 'Kontak - '])

@php $site = config('portfolio'); @endphp

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <h1 class="wow fadeInLeft" data-wow-delay="0.2s">Kontak</h1>
        <hr>
        <h3 class="wow fadeInUp" data-wow-delay="0.6s" data-t="kontak.title">Siap memulai proyek bersama?</h3>
        <p class="wow fadeInUp" data-wow-delay="0.8s" data-t="kontak.subtitle">Hubungi saya di bawah ini sesuai kebutuhan Anda, saya siap melayani dengan sepenuh hati.</p>
        <table class="table table-hover mt-5">
            <tbody>
                <tr class="table-krem">
                    <td class="text-center table-kt wow fadeInLeft" data-wow-delay="0.8s"><i class="fa-solid fa-location-dot mr-10"></i></td>
                    <td class="text-uppercase"><div class="wow fadeInUp" data-wow-delay="1s" data-t="kontak.alamat">Alamat</div></td>
                    <td class="text-end"><div class="wow fadeInRight" data-wow-delay="1.2s">{{ $site['location'] }}</div></td>
                </tr>
                <tr class="table-krem">
                    <td class="text-center table-kt wow fadeInLeft" data-wow-delay="0.8s"><i class="fa-solid fa-envelope mr-10"></i></td>
                    <td class="text-uppercase"><div class="wow fadeInUp" data-wow-delay="1s" data-t="kontak.email">Email</div></td>
                    <td class="text-end"><div class="wow fadeInRight" data-wow-delay="1.2s"><a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a></div></td>
                </tr>
                <tr class="table-krem">
                    <td class="text-center table-kt wow fadeInLeft" data-wow-delay="0.8s"><i class="fa-brands fa-github mr-10"></i></td>
                    <td class="text-uppercase"><div class="wow fadeInUp" data-wow-delay="1s">GitHub</div></td>
                    <td class="text-end"><div class="wow fadeInRight" data-wow-delay="1.2s"><a href="{{ $site['socials']['github'] }}" target="_blank" rel="noreferrer">{{ $site['socials']['github'] }}</a></div></td>
                </tr>
                <tr class="table-krem">
                    <td class="text-center table-kt wow fadeInLeft" data-wow-delay="0.8s"><i class="fa-brands fa-linkedin mr-10"></i></td>
                    <td class="text-uppercase"><div class="wow fadeInUp" data-wow-delay="1s">LinkedIn</div></td>
                    <td class="text-end"><div class="wow fadeInRight" data-wow-delay="1.2s"><a href="{{ $site['socials']['linkedin'] }}" target="_blank" rel="noreferrer">{{ $site['socials']['linkedin'] }}</a></div></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="container p-5 my-5 bg-pesan huruf-serif">
    <div class="row">
        <div class="col-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15863.628221275416!2d106.6991774871582!3d-6.275950099999992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fb2aed665719%3A0xb26b334677019f20!2sRSIA%20Bina%20Medika%20Bintaro!5e0!3m2!1sid!2sid!4v1725013547872!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="col-6 wow fadeInRight" data-wow-delay="0.4s">
            <form action="{{ route('messages.store') }}" method="post" novalidate>
                @csrf
                <h3 data-t="kontak.form">Kirim Pesan</h3>
                <div class="my-3">
                    <label for="name" class="form-label" data-t="kontak.nama">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap">
                    @error('name')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="my-3">
                    <label for="email" class="form-label" data-t="kontak.email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                    @error('email')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="my-3">
                    <label for="phone" class="form-label" data-t="kontak.phone_label">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Telepon">
                    @error('phone')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="my-3">
                    <label for="message" class="form-label" data-t="kontak.pesan">Pesan</label>
                    <textarea class="form-control" rows="5" id="message" name="message" placeholder="Pesan"></textarea>
                    @error('message')
                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="my-3 d-grid">
                    <button type="submit" class="btn submit-btn btn-lg btn-block" data-t="kontak.kirim">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid p-5 bg-info">
    <div class="container">
        <div class="row justify-content-between huruf-serif">
            <div class="col-9">
                <h3 class="my-3 text-uppercase" data-t="kontak.subtitle">Siap memulai proyek sekarang juga!</h3>
            </div>
            <div class="col-3 text-end my-auto">
                <a type="button" class="btn btn-success btn-lg addjanji" href="{{ route('home') }}">Ya, Siap!</a>
            </div>
        </div>
    </div>
</div>

@endsection