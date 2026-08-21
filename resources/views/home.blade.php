@extends('layouts.app', ['title' => ''])

@php
    $site = config('portfolio');
    $slideImages = ['gambar1.jpg', 'gambar2.jpg', 'gambar3.jpg', 'gambar4.jpg'];
    $pipeline = $technologies;
    $totalTech = collect($pipeline)->reduce(fn ($c, $g) => $c + count($g), 0);
@endphp

@section('content')
	<div id="demo" class="carousel slide app-serif" data-bs-ride="carousel" data-stellar-background-ratio="0.5">
		<div class="carousel-indicators">
			@foreach($projects as $index => $project)
				<button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></button>
			@endforeach
		</div>
		<div class="carousel-inner">
			@foreach($projects as $index => $project)
				<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
					<img src="{{ asset('images/' . $slideImages[$index % count($slideImages)]) }}" alt="{{ $project['title'] }}" class="d-block w-100">
					<div class="carousel-caption">
						<h3>{{ $project['title'] }}</h3>
						<p>{{ $project['subtitle'] }}</p>
						<a href="{{ route('proyek.show', $project['slug']) }}" class="btn btn-warning btn-lg" data-t="proyek.detail">Detail</a>
					</div>
				</div>
			@endforeach
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
		</button>
	</div>

	<!-- Hero -->
	<div class="bg-doctor app-serif hero-section">
		<div class="container-fluid p-5">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-xl-8 col-lg-9 col-12">
						<p class="text-primary fw-semibold mb-3 wow fadeInUp" data-wow-delay="0.4s" data-t="hero.halo">Halo, saya</p>
						<h1 class="display-4 fw-bold mb-3 wow fadeInUp" data-wow-delay="0.5s">
							<span class="text-gradient">{{ $site['name'] }}</span>
						</h1>
						<p class="fs-4 fw-light text-secondary mb-4 wow fadeInUp" data-wow-delay="0.6s" data-t="hero.role">{{ $site['role'] }}</p>
						<p class="text-secondary fs-5 mb-4 wow fadeInUp" data-wow-delay="0.7s" data-t="hero.intro">{{ $site['hero']['intro'] }}</p>
						<div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay="0.8s">
							<a href="{{ route('proyek') }}" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2" data-t="hero.cta_proyek">Lihat Proyek</a>
							<a href="{{ route('kontak') }}" class="btn btn-outline-secondary btn-lg d-inline-flex align-items-center gap-2" data-t="hero.cta_kontak">Hubungi Saya</a>
						</div>
						<div class="d-flex flex-wrap gap-2 mt-4 wow fadeInUp" data-wow-delay="0.9s">
							@foreach($site['hero']['tech'] as $tech)
								<span class="chip">{{ $tech }}</span>
							@endforeach
						</div>
					</div>
					<div class="col-xl-4 col-lg-3 col-12 text-center wow fadeInRight" data-wow-delay="1s">
						<div class="float-animation d-inline-block mt-4 mt-lg-0">
							<div class="bg-gradient-brand rounded-circle mx-auto" style="width: 240px; height: 240px; padding: 6px;">
								<img src="{{ asset('images/profile.jpg') }}" alt="Foto {{ $site['name'] }}" class="rounded-circle w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- About preview -->
	<div class="lamcb app-serif section">
		<div class="container">
			<div class="row align-items-center gy-5">
				<div class="col-lg-6">
					<p class="text-primary text-uppercase fw-semibold small mb-2 wow fadeInUp" data-wow-delay="0.1s" data-t="about.eyebrow">Tentang Saya</p>
					<h2 class="fw-bold mb-4 wow fadeInUp" data-wow-delay="0.2s">
						<span data-t="about.title_1">Membangun solusi digital yang</span> <span class="text-gradient" data-t="about.title_2">berdampak</span>
					</h2>
					<p class="text-secondary fs-5 wow fadeInUp" data-wow-delay="0.3s" data-t="about.text">
						Saya adalah {{ $site['role'] }} yang senang mengubah ide menjadi produk digital yang nyata. Dari merancang arsitektur hingga detail interaksi, saya berusaha memberikan kualitas terbaik di setiap proyek.
					</p>
					<ul class="list-unstyled mt-4">
						@foreach($site['highlights'] as $highlight)
							<li class="d-flex align-items-start gap-2 mb-2 wow fadeInUp" data-wow-delay="0.4s">
								<i class="fa-solid fa-circle-check text-primary flex-shrink-0 mt-1"></i>
								<span>{{ $highlight }}</span>
							</li>
						@endforeach
					</ul>
					<a href="{{ route('tentang') }}" class="btn btn-outline-primary mt-3 d-inline-flex align-items-center gap-2 wow fadeInUp" data-wow-delay="0.5s" data-t="about.cta">Selengkapnya</a>
				</div>
				<div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
					<div class="bg-body-secondary border rounded-4 p-4">
						<h5 class="fw-semibold mb-4" data-t="about.skills">Keahlian</h5>
						@foreach($site['skills'] as $skill)
							<div class="mb-3">
								<div class="d-flex justify-content-between small mb-1">
									<span>{{ $skill['name'] }}</span>
									<span class="text-secondary">{{ $skill['level'] }}%</span>
								</div>
								<div class="progress progress-portfolio" role="progressbar" aria-valuenow="{{ $skill['level'] }}" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar bg-gradient-brand" style="width: {{ $skill['level'] }}%"></div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Tech marquee -->
	<section class="tp-section">
		<div class="tp-shell">
			<div class="tp-header">
				<div class="tp-header-left">
					<div class="tp-icon">
						<svg class="tp-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
						</svg>
					</div>
					<div>
						<h3 class="tp-title">Tech <span class="tp-title-gradient" data-t="tech.title_2">Pipeline</span></h3>
						<p class="tp-subtitle"><span data-t="tech.active">Active</span> • {{ $totalTech }}</p>
					</div>
				</div>
			</div>
			<div class="tp-rows">
				@foreach($pipeline as $label => $items)
					@php $index = $loop->index; $variant = $index % 4; $direction = $index % 2 === 0 ? 'tp-animate-right' : 'tp-animate-left'; $stars = ['Expert' => '★★★', 'Advanced' => '★★', 'Intermediate' => '★']; $badges = ['Expert' => 'tp-badge-expert', 'Advanced' => 'tp-badge-advanced', 'Intermediate' => 'tp-badge-intermediate']; @endphp
					<div class="tp-row">
						<div class="tp-pill-wrap">
							<div class="tp-pill tp-pill-{{ $variant }}">
								<span class="tp-pill-letter">{{ $label[0] }}</span>
								<span class="tp-pill-label">{{ $label }}</span>
							</div>
						</div>
						<div class="tp-track tp-track-{{ $variant }}">
							<div class="tp-shimmer"><div class="tp-shimmer-bar"></div></div>
							<div class="tp-scroll">
								<div class="tp-scroll-inner {{ $direction }}">
									@for($q = 0; $q < 4; $q++)
										@foreach($items as $item)
											<div class="tp-chip tp-chip-{{ $variant }}">
												<span class="tp-name">{{ $item['name'] }}</span>
												<div class="tp-badge {{ $badges[$item['level']] ?? 'tp-badge-intermediate' }}">{{ $stars[$item['level']] ?? '★' }}</div>
												<div class="tp-glow tp-glow-{{ $variant }}"></div>
											</div>
										@endforeach
									@endfor
								</div>
							</div>
							<div class="tp-bar-top tp-bar-top-{{ $variant }}"></div>
							<div class="tp-bar-bottom tp-bar-bottom-{{ $variant }}"></div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="tp-footer">
				<div class="tp-footer-item">
					<div class="tp-dot tp-dot-green"></div>
					<span class="tp-footer-text" data-t="tech.pipelines">{{ count($pipeline) }} Active Pipelines</span>
				</div>
				<div class="tp-divider"></div>
				<div class="tp-footer-item">
					<div class="tp-dot tp-dot-blue"></div>
					<span class="tp-footer-text">{{ $totalTech }} <span data-t="tech.flowing">Technologies Flowing</span></span>
				</div>
				<div class="tp-divider"></div>
				<div class="tp-footer-item">
					<div class="tp-dot tp-dot-orange"></div>
					<span class="tp-footer-text" data-t="tech.loop">Infinite Loop</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Layanan (services) -->
	<div class="lamcb app-serif">
		<section id="benefit" data-stellar-background-ratio="1">
			<div class="container p-5 a-b">
				<div class="row">
					<div class="lamh my-3">
						<div class="text-center mt-4 mb-3">
							<h2 class="wow fadeInUp" data-wow-delay="0.1s"><i class="fa-solid fa-hand-holding-heart mr-10"></i> <span data-t="layanan.title">Layanan</span></h2>
						</div>
						<p class="text-center text-secondary wow fadeInUp" data-wow-delay="0.2s" data-t="layanan.subtitle">Layanan yang saling melengkapi untuk mendukung kebutuhan digital Anda.</p>
						<hr>
					</div>
					<div class="d-flex justify-content-between mt-3 flex-wrap gap-3">
						@foreach($services as $index => $service)
							<div class="card wow fadeInUp col-lg-3 col-md-6 col-12" data-wow-delay="{{ 0.2 + ($index * 0.1) }}s">
								<div class="card-body">
									<div class="icon-circle mb-3"><i class="{{ $service['icon'] }}"></i></div>
									<h3 class="card-title">{{ $service['title'] }}</h3>
									<p class="card-text">{{ $service['description'] }}</p>
								</div>
							</div>
						@endforeach
					</div>
					<div class="text-center mt-5">
						<a href="{{ route('layanan') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 wow fadeInUp" data-wow-delay="0.8s" data-t="layanan.cta">Semua Layanan</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Blog -->
		<section id="berita" data-stellar-background-ratio="3">
			<div class="container p-5">
				<div class="row">
					<div class="lamh my-3">
						<div class="text-center mt-4 mb-3">
							<h2 class="wow fadeInUp" data-wow-delay="0.1s"><i class="fa-solid fa-newspaper mr-10"></i> <span data-t="blog.title">Blog</span></h2>
						</div>
						<hr>
					</div>
					<div class="d-flex justify-content-between my-3 a-b flex-wrap gap-3">
						@foreach($posts as $post)
							<div class="card wow fadeInUp col-lg-4 col-md-6 col-12" data-wow-delay="0.4s">
								<div class="card-body">
									<p class="card-text text-secondary"><i class="fa-regular fa-calendar-days me-2"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }}</p>
									<h3 class="card-title"><a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a></h3>
									<p class="card-text">{{ Str::limit($post['excerpt'], 100) }}</p>
								</div>
								<div class="card-footer">
									@foreach($post['tags'] as $tag)
										<span class="chip">{{ $tag }}</span>
									@endforeach
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<div class="text-center">
					<a href="{{ route('blog') }}" class="btn btn-success mt-3 wow fadeInUp" type="button" data-wow-delay="0.8s" data-t="blog.cta">Semua Artikel</a>
				</div>
			</div>
		</section>
	</div>

	<!-- Contact form -->
	<section id="book-online" data-stellar-background-ratio="3.5">
		<div class="container-fluid bg-warning">
			<div class="container pt-5">
				<div class="row">
					<div class="book-h bg-dark text-light my-3">
						<div class="text-center mt-4">
							<h2 class="wow fadeInUp" data-wow-delay="0.4s"><i class="fa-solid fa-envelope mr-10"></i> <span data-t="kontak.eyebrow">Kontak</span></h2>
						</div>
						<p class="text-center wow fadeInUp" data-wow-delay="0.5s" data-t="kontak.subtitle">Siap memulai proyek? Kirim pesan kepada saya.</p>
						<hr>
					</div>
					<div class="d-flex justify-content-between mt-3">
						<div class="col-md-1"></div>
						<div class="d-flex align-items-end col-md-4 col-sm-6">
							<img src="{{ asset('images/appointment.png') }}" alt="" width="90%">
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-6 col-sm-6 wow fadeInRight" data-wow-delay="0.8s">
							<form action="{{ route('messages.store') }}" method="post" novalidate>
								@csrf
								<div class="my-3">
									<label for="name" class="form-label" data-t="kontak.nama">Nama</label>
									<input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap">
									@error('name')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="email" class="form-label" data-t="kontak.email">Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
									@error('email')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="phone" class="form-label" data-t="kontak.phone_label">Nomor Telepon</label>
									<input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Telepon">
									@error('phone')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="message" class="form-label" data-t="kontak.pesan">Pesan</label>
									<textarea class="form-control" rows="5" id="message" name="message" placeholder="Pesan"></textarea>
									@error('message')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3 d-grid">
									<button type="submit" class="btn submit-btn btn-lg" data-t="kontak.kirim">Kirim</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@include('layouts.map')
@endsection