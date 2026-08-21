@extends('layouts.app', ['title' => 'Blog - '])

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <h1 class="wow fadeInLeft" data-wow-delay="0.2s">Blog</h1>
        <p class="wow fadeInLeft" data-wow-delay="0.3s" data-t="blog.subtitle">Artikel tentang pengembangan web, SEO, dan teknologi.</p>
        <hr class="pb-2">
        <div class="row">
            <div class="col-md-7">
                @forelse ($posts as $post)
                    <div class="d-flex flex-row flex-wrap mb-2">
                        <div class="p-2 text-white" style="background: #ff2424"><i class="fa-regular fa-calendar-days me-2"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }}</div>
                        @foreach($post['tags'] as $tag)
                            <a href="{{ route('blog') }}" class="p-2 bg-warning border bl-05 text-white">{{ $tag }}</a>
                        @endforeach
                    </div>
                    <h4>
                        <a href="{{ route('blog.show', $post['slug']) }}" class="card-title">{{ $post['title'] }}</a>
                    </h4>
                    <div class="my-2">
                        {{ Str::limit($post['excerpt'], 200) }}
                    </div>
                    <a href="{{ route('blog.show', $post['slug']) }}" class="btn btn-primary btn-lg text-uppercase fw-semibold mb-4" data-t="blog.baca">Baca Selengkapnya &gt;</a>
                @empty
                    <div class="alert alert-info">
                        Tidak ada postingan.
                    </div>
                @endforelse
            </div>
            <div class="col-md-5 bg-right p-2">
                <h1 class="pt-3 px-3" style="background: #58bbf8">Kategori / Tag<hr class="pb-2"></h1>
                <div class="rn-ct">
                    @php
                        $tags = $posts->flatMap(fn ($p) => $p['tags'])->unique();
                    @endphp
                    @foreach($tags as $tag)
                        <li class="dli"><a href="{{ route('blog') }}"><i class="fa-solid fa-angle-right"></i> {{ $tag }}</a></li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection