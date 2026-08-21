@extends('layouts.app', ['title' => 'Layanan - '])

@php $siteImages = ['gambar4.jpg', 'akomodasi.jpg', '24-7-service.jpg', 'about-bg.jpg']; @endphp

@section('content')
@include('layouts.banner')
<div class="bg-krem p-5 app-serif">
	<div class="container pt-3">
		<div class="row mb-3">
			<h1 class="benefit wow fadeInLeft" data-wow-delay="0.2s">Layanan</h1>
			<hr>
		</div>
		@foreach($services as $index => $service)
			<div class="row {{ $loop->last ? 'mt-3' : 'my-3' }}">
				<div class="col-3">
					<img src="{{ asset('images/' . $siteImages[$index % count($siteImages)]) }}" alt="{{ $service['title'] }}" class="img-thumbnail img-1 wow fadeInLeft" data-wow-delay="0.7s">
				</div>
				<div class="col-xl-7 col-9">
					<div class="d-flex benefit">
						<h3 class="wow fadeInUp" data-wow-delay="0.8s"><i class="{{ $service['icon'] }} mr-10"></i></h3><h3 class="wow fadeInRight" data-wow-delay="0.9s">{{ $service['title'] }}</h3>
					</div>
					<p class="benefit wow fadeInRight" data-wow-delay="1s">{{ $service['description'] }}</p>
					<ul class="benefit wow fadeInRight" data-wow-delay="1.1s">
						@foreach($service['points'] as $point)
							<li><i class="fa-solid fa-circle-check text-primary me-2"></i>{{ $point }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection