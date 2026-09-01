@extends('layouts.app', ['title' => 'Proyek - '])

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <div class="mb-5">
                <p class="section-eyebrow mb-2" data-t="proyek.eyebrow">PORTOFOLIO</p>
                <h1 class="hero-title text-gradient mb-3">Proyek Saya</h1>
                <p class="text-secondary fs-5 mb-0" data-t="proyek.subtitle">Beberapa proyek terbaik yang pernah saya kerjakan.</p>
            </div>

            <div class="row g-4">
                @foreach($projects as $project)
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="card card-hover h-100 w-100 border-0 overflow-hidden d-flex flex-column">
                            <div class="card-img-wrapper" style="height: 210px; background: rgba(0,0,0,0.3);">
                                <img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}" class="w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 text-primary border border-secondary border-opacity-25 px-3 py-1 rounded-pill small">
                                        {{ $project['year'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <h4 class="card-title fw-bold mb-2">
                                    <a href="{{ route('proyek.show', $project['slug']) }}" class="text-white text-decoration-none">
                                        {{ $project['title'] }}
                                    </a>
                                </h4>
                                <p class="card-text text-secondary small flex-grow-1 mb-3">{{ $project['subtitle'] }}</p>
                                
                                <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        @foreach(array_slice($project['stack'], 0, 3) as $tech)
                                            <span class="chip me-1 mb-1">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('proyek.show', $project['slug']) }}" class="btn btn-sm btn-outline-primary flex-grow-1 d-inline-flex align-items-center justify-content-center gap-1" data-t="proyek.detail">
                                            Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                        @if($project['github'])
                                            <a href="{{ $project['github'] }}" target="_blank" rel="noreferrer" class="btn btn-sm btn-outline-secondary px-3" aria-label="GitHub {{ $project['title'] }}"><i class="fa-brands fa-github"></i></a>
                                        @endif
                                        @if($project['live'])
                                            <a href="{{ $project['live'] }}" target="_blank" rel="noreferrer" class="btn btn-sm btn-outline-secondary px-3" aria-label="Demo {{ $project['title'] }}"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
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
</div>
@endsection