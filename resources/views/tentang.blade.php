@extends('layouts.app', ['title' => 'Tentang - '])

@php $site = config('portfolio'); @endphp

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <h1 class="wow fadeInLeft" data-wow-delay="0.6s">Halo, saya <span class="text-gradient">{{ $site['name'] }}</span></h1>
                <div class="wow fadeInLeft" data-wow-delay="0.8s">
                    <p>Saya adalah seorang <span>{{ $site['role'] }}</span> yang senang mengubah ide menjadi produk digital yang nyata. Dengan pengalaman lebih dari 3 tahun di bidang pengembangan web, saya telah membantu banyak klien membangun website yang cepat, modern, dan mudah digunakan.</p>
                    <p>Saya menguasai berbagai teknologi seperti Laravel, PHP, JavaScript, dan Bootstrap. Fokus utama saya adalah performa, SEO, dan aksesibilitas sehingga setiap proyek yang saya kerjakan tidak hanya tampil menarik tetapi juga optimal untuk pengguna.</p>
                    <p>Dalam setiap pekerjaan, saya menerapkan standar kode yang rapi dan mudah dikelola. Saya juga terbiasa bekerja sama dengan tim maupun secara mandiri untuk memastikan setiap kebutuhan klien terpenuhi dengan baik.</p>
                    <p>Jika Anda memiliki proyek yang ingin diwujudkan, jangan ragu untuk menghubungi saya melalui halaman kontak. Mari berkolaborasi untuk menciptakan solusi digital yang berdampak.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3 wow fadeInLeft" data-wow-delay="0.9s">
                    @foreach($site['hero']['tech'] as $tech)
                        <span class="chip">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <img src="{{ asset('images/profile.jpg') }}" class="img-thumbnail wow fadeInRight rounded-circle" data-wow-delay="0.6s" alt="{{ $site['name'] }}">
            </div>
        </div>
    </div>
</div>
@include('layouts.map')
@endsection