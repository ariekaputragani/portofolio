@extends('layouts.app', ['title' => $post['title'] . ' - '])

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <a href="{{ route('blog') }}" class="btn btn-outline-secondary mb-3" data-t="blog.baca"><i class="fa-solid fa-arrow-left me-2"></i>Kembali ke blog</a>
        <span class="text-secondary small"><i class="fa-regular fa-calendar-days me-2"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }} &middot; {{ $post['read_time'] }}</span>
        <h1 class="wow fadeInLeft" data-wow-delay="0.2s">{{ $post['title'] }}</h1>
        <div class="d-flex flex-wrap mb-4 wow fadeInLeft" data-wow-delay="0.3s">
            @foreach($post['tags'] as $tag)
                <span class="chip">{{ $tag }}</span>
            @endforeach
        </div>
        <div class="prose">
            @foreach($post['content'] as $section)
                <h2>{{ $section['heading'] }}</h2>
                @foreach($section['paragraphs'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            @endforeach
        </div>
        <div class="mt-5">
            <a href="{{ route('blog') }}" class="btn btn-primary" data-t="blog.semua">Semua Artikel</a>
        </div>
    </div>
</div>
@endsection