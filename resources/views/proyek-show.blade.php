@extends('layouts.app', ['title' => $project['title'] . ' - '])

@section('content')
<div class="pf-scope pf-hero-bg py-5">
    <div class="container py-4">
        <div class="hero-card-frame p-4 p-lg-5">
            <a href="{{ route('proyek') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-4 d-inline-flex align-items-center gap-2" data-t="proyek.kembali">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke proyek
            </a>
            <div class="row gy-4">
                <div class="col-md-8">
                    <span class="badge bg-dark bg-opacity-75 text-primary border border-secondary border-opacity-25 px-3 py-1 rounded-pill small mb-2">
                        {{ $project['year'] }}
                    </span>
                    <h1 class="hero-title text-gradient mb-2">{{ $project['title'] }}</h1>
                    <p class="text-secondary fs-5 mb-4">{{ $project['subtitle'] }}</p>
                    
                    <div class="card-img-wrapper rounded-4 overflow-hidden mb-4 border border-secondary border-opacity-25" style="max-height: 400px;">
                        <img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}" class="w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    
                    <p class="text-secondary fs-6 lead mb-4" style="line-height: 1.8;">{{ $project['description'] }}</p>
                    
                    <h4 class="fw-bold text-white mb-3" data-t="proyek.fitur">Fitur Utama</h4>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-4">
                        @foreach($project['features'] as $feature)
                            <li class="d-flex align-items-center gap-2 text-secondary">
                                <i class="fa-solid fa-circle-check text-primary"></i>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <div class="card p-4 border-0 h-100">
                        <h5 class="fw-bold text-white mb-3" data-t="proyek.stack">Teknologi</h5>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            @foreach($project['stack'] as $tech)
                                <span class="chip me-1 mb-1">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="d-grid gap-2 mt-auto">
                            @if($project['live'])
                                <a href="{{ $project['live'] }}" target="_blank" rel="noreferrer" class="btn book-btn btn-lg d-inline-flex align-items-center justify-content-center gap-2" data-t="proyek.demo">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo
                                </a>
                            @endif
                            @if($project['github'])
                                <a href="{{ $project['github'] }}" target="_blank" rel="noreferrer" class="btn btn-outline-secondary btn-lg d-inline-flex align-items-center justify-content-center gap-2" data-t="proyek.github">
                                    <i class="fa-brands fa-github"></i> Source Code
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection