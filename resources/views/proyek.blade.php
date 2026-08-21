@extends('layouts.app', ['title' => 'Proyek - '])

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <h1 class="wow fadeInLeft" data-wow-delay="0.2s">Proyek Saya</h1>
        <p class="wow fadeInLeft" data-wow-delay="0.3s" data-t="proyek.subtitle">Beberapa proyek terbaik yang pernah saya kerjakan.</p>
        <hr class="pb-2">
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="h-100 wow" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <div class="card card-hover h-100 border-0 shadow-sm overflow-hidden">
                            <div class="position-relative" style="height: 200px; background: #f0f0f0;">
                                <img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}" class="w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <span class="text-secondary small">{{ $project['year'] }}</span>
                                <h5 class="card-title fw-bold mt-1">
                                    <a href="{{ route('proyek.show', $project['slug']) }}" class="text-decoration-none">{{ $project['title'] }}</a>
                                </h5>
                                <p class="card-text text-secondary flex-grow-1">{{ $project['subtitle'] }}</p>
                                <div class="d-flex flex-wrap mb-3">
                                    @foreach(array_slice($project['stack'], 0, 3) as $tech)
                                        <span class="chip">{{ $tech }}</span>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('proyek.show', $project['slug']) }}" class="btn btn-sm btn-outline-primary" data-t="proyek.detail">Detail</a>
                                    @if($project['github'])
                                        <a href="{{ $project['github'] }}" target="_blank" rel="noreferrer" class="btn btn-sm btn-outline-secondary" aria-label="GitHub {{ $project['title'] }}"><i class="fa-brands fa-github"></i></a>
                                    @endif
                                    @if($project['live'])
                                        <a href="{{ $project['live'] }}" target="_blank" rel="noreferrer" class="btn btn-sm btn-outline-secondary" aria-label="Demo {{ $project['title'] }}"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection