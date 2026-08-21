@extends('layouts.app', ['title' => $project['title'] . ' - '])

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
    <div class="container pt-3">
        <a href="{{ route('proyek') }}" class="btn btn-outline-secondary mb-3" data-t="proyek.kembali"><i class="fa-solid fa-arrow-left me-2"></i>Kembali ke proyek</a>
        <div class="row">
            <div class="col-md-8">
                <span class="text-secondary small">{{ $project['year'] }}</span>
                <h1 class="wow fadeInLeft" data-wow-delay="0.2s">{{ $project['title'] }}</h1>
                <p class="text-secondary fs-5 wow fadeInLeft" data-wow-delay="0.3s">{{ $project['subtitle'] }}</p>
                <div class="wow fadeInUp" data-wow-delay="0.4s">
                    <img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}" class="img-fluid img-thumbnail mb-4" style="width:100%;">
                </div>
                <p class="wow fadeInUp" data-wow-delay="0.5s">{{ $project['description'] }}</p>
                <h3 class="mt-4 wow fadeInUp" data-wow-delay="0.6s" data-t="proyek.fitur">Fitur</h3>
                <ul class="wow fadeInUp" data-wow-delay="0.7s">
                    @foreach($project['features'] as $feature)
                        <li><i class="fa-solid fa-circle-check text-primary me-2"></i>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm wow fadeInRight" data-wow-delay="0.4s">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" data-t="proyek.stack">Teknologi</h5>
                        <div class="d-flex flex-wrap mb-3">
                            @foreach($project['stack'] as $tech)
                                <span class="chip">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="d-grid gap-2">
                            @if($project['live'])
                                <a href="{{ $project['live'] }}" target="_blank" rel="noreferrer" class="btn btn-primary" data-t="proyek.demo"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Live Demo</a>
                            @endif
                            @if($project['github'])
                                <a href="{{ $project['github'] }}" target="_blank" rel="noreferrer" class="btn btn-outline-secondary" data-t="proyek.github"><i class="fa-brands fa-github me-2"></i>Source Code</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection