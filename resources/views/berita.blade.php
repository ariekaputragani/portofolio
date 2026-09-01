@extends('layouts.app', ['title' => 'Blog - '])

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <div class="mb-5">
                <p class="section-eyebrow mb-2" data-t="blog.eyebrow">BLOG & ARTIKEL</p>
                <h1 class="hero-title text-gradient mb-3">Blog Terbaru</h1>
                <p class="text-secondary fs-5 mb-0" data-t="blog.subtitle">Artikel tentang pengembangan web, SEO, dan teknologi.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-4">
                        @forelse ($posts as $post)
                            <div class="card card-hover p-4 border-0">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                    <span class="badge bg-dark bg-opacity-75 text-primary border border-secondary border-opacity-25 px-3 py-2 rounded-pill small">
                                        <i class="fa-regular fa-calendar-days me-1"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }}
                                    </span>
                                    @foreach($post['tags'] as $tag)
                                        <span class="chip me-1">{{ $tag }}</span>
                                    @endforeach
                                </div>
                                <h3 class="card-title fw-bold mb-3">
                                    <a href="{{ route('blog.show', $post['slug']) }}" class="text-white text-decoration-none">
                                        {{ $post['title'] }}
                                    </a>
                                </h3>
                                <p class="text-secondary mb-4 fs-6" style="line-height: 1.7;">
                                    {{ Str::limit($post['excerpt'], 200) }}
                                </p>
                                <div>
                                    <a href="{{ route('blog.show', $post['slug']) }}" class="btn btn-outline-primary d-inline-flex align-items-center gap-2" data-t="blog.baca">
                                        Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="card p-4 border-0 text-center">
                                <p class="text-secondary mb-0">Tidak ada postingan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card p-4 border-0 position-sticky" style="top: 90px;">
                        <h4 class="fw-bold text-white mb-3 pb-2 border-bottom border-secondary border-opacity-25">Kategori / Tag</h4>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @php
                                $tags = $posts->flatMap(fn ($p) => $p['tags'])->unique();
                            @endphp
                            @foreach($tags as $tag)
                                <a href="{{ route('blog') }}" class="chip text-decoration-none me-1 mb-1">
                                    <i class="fa-solid fa-tag me-1 text-primary"></i>{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection