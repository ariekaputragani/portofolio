@extends('layouts.app', ['title' => 'Kontak - '])

@php $site = config('portfolio'); @endphp

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <div class="mb-5">
                <p class="section-eyebrow mb-2" data-t="kontak.eyebrow">KONTAK</p>
                <h1 class="hero-title text-gradient mb-3" data-t="kontak.title">Hubungi Saya</h1>
                <p class="text-secondary fs-5 mb-0" data-t="kontak.subtitle">Siap memulai proyek bersama? Hubungi saya di bawah ini sesuai kebutuhan Anda.</p>
            </div>

            <div class="row gy-4 mb-5">
                <div class="col-lg-6">
                    <div class="card p-4 border-0 h-100">
                        <h4 class="fw-bold text-white mb-4">Informasi Kontak</h4>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-circle-hero" style="width:48px;height:48px;font-size:1.2rem;">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <span class="text-secondary small d-block" data-t="kontak.alamat">Alamat</span>
                                    <span class="fw-semibold text-white">{{ $site['location'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-circle-hero" style="width:48px;height:48px;font-size:1.2rem;">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div>
                                    <span class="text-secondary small d-block" data-t="kontak.email">Email</span>
                                    <a href="mailto:{{ $site['email'] }}" class="fw-semibold text-primary text-decoration-none">{{ $site['email'] }}</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-circle-hero" style="width:48px;height:48px;font-size:1.2rem;">
                                    <i class="fa-brands fa-github"></i>
                                </div>
                                <div>
                                    <span class="text-secondary small d-block">GitHub</span>
                                    <a href="{{ $site['socials']['github'] }}" target="_blank" rel="noreferrer" class="fw-semibold text-primary text-decoration-none">{{ $site['socials']['github'] }}</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-circle-hero" style="width:48px;height:48px;font-size:1.2rem;">
                                    <i class="fa-brands fa-linkedin"></i>
                                </div>
                                <div>
                                    <span class="text-secondary small d-block">LinkedIn</span>
                                    <a href="{{ $site['socials']['linkedin'] }}" target="_blank" rel="noreferrer" class="fw-semibold text-primary text-decoration-none">{{ $site['socials']['linkedin'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card p-4 border-0 h-100">
                        <h4 class="fw-bold text-white mb-4" data-t="kontak.form">Kirim Pesan</h4>
                        <form action="{{ route('messages.store') }}" method="post" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label text-secondary small" data-t="kontak.nama">Nama</label>
                                <input type="text" class="form-control bg-dark border-secondary border-opacity-25 text-white" id="name" name="name" placeholder="Masukkan Nama Lengkap">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-secondary small" data-t="kontak.email">Email</label>
                                <input type="email" class="form-control bg-dark border-secondary border-opacity-25 text-white" id="email" name="email" placeholder="Masukkan Email">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label text-secondary small" data-t="kontak.phone_label">Nomor Telepon</label>
                                <input type="tel" class="form-control bg-dark border-secondary border-opacity-25 text-white" id="phone" name="phone" placeholder="Masukkan Nomor Telepon">
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label text-secondary small" data-t="kontak.pesan">Pesan</label>
                                <textarea class="form-control bg-dark border-secondary border-opacity-25 text-white" rows="4" id="message" name="message" placeholder="Pesan Anda"></textarea>
                                @error('message')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn book-btn btn-lg w-100 d-inline-flex align-items-center justify-content-center gap-2" data-t="kontak.kirim">
                                Kirim Pesan <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.map')
@endsection