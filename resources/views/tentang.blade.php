@extends('layouts.app', ['title' => 'Tentang - '])

@php $site = config('portfolio'); @endphp

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <div class="row align-items-center gy-5">
                <div class="col-md-8 col-sm-12">
                    <p class="section-eyebrow mb-2" data-t="about.eyebrow">TENTANG SAYA</p>
                    <h1 class="hero-title mb-4">Halo, saya <span class="text-gradient typing-name">{{ $site['name'] }}</span></h1>
                    <div class="text-secondary fs-6 lead" style="line-height: 1.8;">
                        <p>Saya adalah seorang <span class="typing-role text-primary fw-bold"></span> yang senang mengubah ide menjadi produk digital yang nyata. Dengan pengalaman lebih dari 3 tahun di bidang pengembangan web, saya telah membantu banyak klien membangun website yang cepat, modern, dan mudah digunakan.</p>
                        <p>Saya menguasai berbagai teknologi seperti Laravel, PHP, JavaScript, dan Bootstrap. Fokus utama saya adalah performa, SEO, dan aksesibilitas sehingga setiap proyek yang saya kerjakan tidak hanya tampil menarik tetapi juga optimal untuk pengguna.</p>
                        <p>Dalam setiap pekerjaan, saya menerapkan standar kode yang rapi dan mudah dikelola. Saya juga terbiasa bekerja sama dengan tim maupun secara mandiri untuk memastikan setiap kebutuhan klien terpenuhi dengan baik.</p>
                        <p>Jika Anda memiliki proyek yang ingin diwujudkan, jangan ragu untuk menghubungi saya melalui halaman kontak. Mari berkolaborasi untuk menciptakan solusi digital yang berdampak.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        @foreach($site['hero']['tech'] as $tech)
                            <span class="chip me-1 mb-1">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 text-center hero-avatar-col">
                    <div class="float-animation d-inline-block">
                        <div class="avatar-frame-container">
                            <img src="{{ asset('images/profile.jpg') }}" class="avatar-img" alt="{{ $site['name'] }}" draggable="false">
                            <img src="{{ asset('images/frame-s19.png') }}" class="avatar-frame-overlay" alt="Bingkai Frame S19" draggable="false">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.map')
@endsection