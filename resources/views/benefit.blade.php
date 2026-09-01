@extends('layouts.app', ['title' => 'Layanan - '])

@php $siteImages = ['gambar4.jpg', 'akomodasi.jpg', '24-7-service.jpg', 'about-bg.jpg']; @endphp

@section('content')
<div class="pf-scope pf-hero-bg py-5">
	<div class="container py-4">
		<div class="hero-card-frame p-4 p-lg-5">
			<div class="mb-5">
				<p class="section-eyebrow mb-2" data-t="layanan.eyebrow">LAYANAN</p>
				<h1 class="hero-title text-gradient mb-3" data-t="layanan.title">Layanan Digital</h1>
				<p class="text-secondary fs-5 mb-0" data-t="layanan.subtitle">Layanan yang saling melengkapi untuk mendukung kebutuhan digital Anda.</p>
			</div>

			<div class="d-flex flex-column gap-4">
				@foreach($services as $index => $service)
					<div class="card card-hover p-4 border-0">
						<div class="row align-items-center gy-4">
							<div class="col-md-3 text-center text-md-start">
								<div class="card-img-wrapper rounded-3 overflow-hidden" style="height: 180px;">
									<img src="{{ asset('images/' . $siteImages[$index % count($siteImages)]) }}" alt="{{ $service['title'] }}" class="w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;">
								</div>
							</div>
							<div class="col-md-9">
								<div class="d-flex align-items-center gap-3 mb-2">
									<div class="icon-circle-hero flex-shrink-0" style="width:48px;height:48px;font-size:1.3rem;">
										<i class="{{ $service['icon'] }}"></i>
									</div>
									<h3 class="fw-bold text-white mb-0">{{ $service['title'] }}</h3>
								</div>
								<p class="text-secondary mb-3 fs-6">{{ $service['description'] }}</p>
								<ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
									@foreach($service['points'] as $point)
										<li class="d-flex align-items-center gap-2 text-secondary">
											<i class="fa-solid fa-circle-check text-primary"></i>
											<span>{{ $point }}</span>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection