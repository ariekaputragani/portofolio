@extends('layouts.app', ['title' => $post['title'] . ' - '])

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <a href="{{ route('blog') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-4 d-inline-flex align-items-center gap-2" data-t="blog.baca">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke blog
            </a>
            
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <span class="badge bg-dark bg-opacity-75 text-primary border border-secondary border-opacity-25 px-3 py-2 rounded-pill small">
                    <i class="fa-regular fa-calendar-days me-1"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }} &middot; {{ $post['read_time'] }}
                </span>
                @foreach($post['tags'] as $tag)
                    <span class="chip me-1">{{ $tag }}</span>
                @endforeach
            </div>
            
            <h1 class="hero-title text-gradient mb-4">{{ $post['title'] }}</h1>

            <div class="card p-4 p-lg-5 border-0 mb-5">
                <div class="prose text-secondary fs-6" style="line-height: 1.8;">
                    @foreach($post['content'] as $section)
                        <h3 class="fw-bold text-white mt-4 mb-3">{{ $section['heading'] }}</h3>
                        @foreach($section['paragraphs'] as $paragraph)
                            <p class="mb-3">{{ $paragraph }}</p>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div>
                <a href="{{ route('blog') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2" data-t="blog.semua">
                    <i class="fa-solid fa-arrow-left"></i> Semua Artikel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection