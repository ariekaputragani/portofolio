@extends('layouts.app', ['title' => ''])

@php
	$site = config('portfolio');
	$slideImages = ['gambar1.jpg', 'gambar2.jpg', 'gambar3.jpg', 'gambar4.jpg'];
	$pipeline = $technologies;
	$totalTech = collect($pipeline)->reduce(fn($c, $g) => $c + count($g), 0);
	$bigSins = $site['big_sins'] ?? [];
	$journey = $site['journey'] ?? [];
@endphp

@push('head')
	<link rel="preload" as="image" href="{{ asset('images/img-1.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-2.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-3.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-4.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-5.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-6.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-7.jpg') }}" fetchpriority="high">
	<link rel="preload" as="image" href="{{ asset('images/img-8.jpg') }}" fetchpriority="high">
@endpush

@section('content')
	<section class="pf-fixed-background hero">
		<div class="hero-content-wrapper w-100 flex-grow-1 d-flex align-items-center">
			<div class="container">
				<div class="row align-items-center gy-5">
					<div class="col-xl-7 col-lg-8 text-center d-flex flex-column align-items-center justify-content-center">
						<p class="hero-eyebrow" data-t="hero.halo">Saya</p>
						<h1 class="hero-title mb-3">
							<span class="text-gradient typing-name"
								data-name="{{ $site['name'] }}">{{ $site['name'] }}</span>
							{{-- Script ini WAJIB inline di sini - jangan dipindah ke

							<head>
								dan jangan digabung ke typewriter.js.

								Alasannya urutan waktu: browser mulai mengecat begitu
								stylesheet di

								<head> siap, tanpa menunggu script di

								<body>. typewriter.js baru jalan di DOMContentLoaded,
									yang ditunda script defer /js/app.js (888 KB).
									Akibatnya nama lengkap sudah tampil sekitar 1 detik,
									lalu ketika typewriter.js finally jalan ia langsung
									mengetik dari "A" sehingga nama menyusut jadi satu
									huruf lalu diketik ulang dari awal. Itu kedipnya.

									Script inline di dalam <h1> jalan saat PARSE, jadi
										sebelum frame pertama di-paint - satu-satunya waktu
										yang tepat untuk ini.

										Yang dilakukan hanya memasang kelas yang menyembunyikan
										nama (visibility: hidden, ruang tetap). typewriter.js
										melepasnya tepat sebelum mulai mengetik.

										Kalau JS dimatikan, script ini tidak pernah jalan,
										kelas tidak pernah dipasang, dan nama tetap tampil utuh. --}}
										<script>
											(function () {
												var script = document.currentScript;
												var el = script && script.previousElementSibling;
												if (!el || !el.classList.contains("typing-name")) return;
												el.classList.add("typing-name-pending");
												// Jaring pengaman: kalau typewriter.js gagal dimuat,
												// jangan sampai nama hilang permanen.
												setTimeout(function () {
													el.classList.remove("typing-name-pending");
												}, 3000);
											})();
										</script>
									</h1>
									<p class="hero-role mb-3">
										<span
											data-t="hero.role_prefix">{{ $site['hero']['role_prefix'] ?? 'Seorang' }}</span>
										<span class="typing-role"></span>
									</p>
									{{-- Motto tetap di hero: Motto #3 (Introvert Berkualitas)
									Sengaja TIDAK diberi `data-t="hero.intro"`: translate.js akan
									menimpa isinya dengan kalimat generic jika ada.
									Nama pengarang ditulis di sini dengan <br> agar semantik
									kutipan tetap utuh dalam satu elemen <p>. --}}
									<p class="text-secondary mb-4">
										{{ is_array($site['hero']['intro']) ? ($site['hero']['intro'][2] ?? $site['hero']['intro'][0]) : $site['hero']['intro'] }}<br>
										-{{ config('portfolio.name') }}
									</p>
									<div class="d-flex flex-wrap justify-content-center gap-3">
										<a href="{{ route('proyek') }}"
											class="btn project-btn btn-lg rounded-pill d-inline-flex align-items-center gap-2"
											data-t="hero.cta_proyek">
											Lihat Proyek <i class="fa-solid fa-arrow-right"></i>
										</a>
										<a href="{{ route('kontak') }}"
											class="btn btn-outline-hero btn-lg rounded-pill d-inline-flex align-items-center gap-2"
											data-t="hero.cta_kontak">
											<i class="fa-regular fa-envelope"></i> Hubungi Saya
										</a>
									</div>
					</div>
					<div class="col-xl-5 col-lg-4 text-center hero-avatar-col">
						<div class="float-animation d-inline-block">
							<div class="avatar-frame-container">
								<img src="{{ asset('images/profile.jpg') }}" class="avatar-img"
									alt="Foto {{ $site['name'] }}" draggable="false">
								<img src="{{ asset('images/frame-s19.png') }}" class="avatar-frame-overlay"
									alt="Bingkai Frame S19" draggable="false">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="pf-fixed-background pf-scope pf-section-skills">
		<div class="container pf-section-inner">
			<div class="row g-4 align-items-center">
				<div class="col-lg-5">
					<p class="section-eyebrow mb-2" data-t="about.eyebrow">Tentang Saya</p>
					<h2 class="section-title mb-3">
						<span data-t="about.title_1">Membangun solusi digital yang</span>
						<span data-t="about.title_2">berdampak</span>
					</h2>
					<p class="text-secondary fs-6 mb-3" data-t="about.text">
						Saya adalah {{ $site['role'] }} yang senang mengubah ide menjadi produk digital yang nyata. Dari
						merancang arsitektur hingga detail interaksi, saya berusaha memberikan kualitas terbaik di
						setiap proyek.
					</p>
					<ul class="list-unstyled mb-3">
						@foreach($site['highlights'] as $highlight)
							<li class="d-flex align-items-start gap-2 mb-2 pf-small">
								<i class="fa-solid fa-circle-check text-primary flex-shrink-0 mt-1"></i>
								<span>{{ $highlight }}</span>
							</li>
						@endforeach
					</ul>
					<a href="{{ route('tentang') }}" class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
						data-t="about.cta">
						Selengkapnya <i class="fa-solid fa-arrow-right"></i>
					</a>

					<div class="card mt-4">
						<div class="card-body p-4">
							<h5 class="fw-bold mb-3" data-t="about.skills">Keahlian</h5>
							@foreach($site['skills'] as $skill)
								<div class="mb-2">
									<div class="d-flex justify-content-between small mb-1">
										<span>{{ $skill['name'] }}</span>
										<span class="text-secondary">{{ $skill['level'] }}%</span>
									</div>
									<div class="progress" role="progressbar" aria-valuenow="{{ $skill['level'] }}"
										aria-valuemin="0" aria-valuemax="100">
										<div class="progress-bar bg-gradient-brand" style="width: {{ $skill['level'] }}%">
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-lg-7">
					{{-- Tech Pipeline marquee — markup tp-* tidak boleh diubah karena
					animasinya bergantung pada struktur ini --}}
					<div class="tp-section pf-tp-inline">
						<div class="tp-shell">
							<div class="tp-header">
								<div class="tp-header-left">
									<div class="tp-icon">
										<svg class="tp-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
												d="M13 10V3L4 14h7v7l9-11h-7z"></path>
										</svg>
									</div>
									<div>
										<h3 class="tp-title">Tech <span class="tp-title-gradient"
												data-t="tech.title_2">Pipeline</span>
										</h3>
										<p class="tp-subtitle"><span data-t="tech.active">Active</span> • {{ $totalTech }}
										</p>
									</div>
								</div>
							</div>
							<div class="tp-rows">
								@foreach($pipeline as $label => $items)
									@php $index = $loop->index;
										$variant = $index % 4;
										$direction = $index % 2 === 0 ? 'tp-animate-right' : 'tp-animate-left';
										$stars = ['Expert' => '★★★', 'Advanced' => '★★', 'Intermediate' => '★'];
									$badges = ['Expert' => 'tp-badge-expert', 'Advanced' => 'tp-badge-advanced', 'Intermediate' => 'tp-badge-intermediate']; @endphp
									<div class="tp-row">
										<div class="tp-pill-wrap">
											<div class="tp-pill tp-pill-{{ $variant }}">
												<span class="tp-pill-letter">{{ $label[0] }}</span>
												<span class="tp-pill-label">{{ $label }}</span>
											</div>
										</div>
										<div class="tp-track tp-track-{{ $variant }}">
											<div class="tp-shimmer">
												<div class="tp-shimmer-bar"></div>
											</div>
											<div class="tp-scroll">
												<div class="tp-scroll-inner {{ $direction }}">
													@for($q = 0; $q < 4; $q++)
														@foreach($items as $item)
															<div class="tp-chip tp-chip-{{ $variant }}">
																<span class="tp-name">{{ $item['name'] }}</span>
																<div
																	class="tp-badge {{ $badges[$item['level']] ?? 'tp-badge-intermediate' }}">
																	{{ $stars[$item['level']] ?? '★' }}
																</div>
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
									<span class="tp-footer-text" data-t="tech.pipelines">{{ count($pipeline) }} Active
										Pipelines</span>
								</div>
								<div class="tp-divider"></div>
								<div class="tp-footer-item">
									<div class="tp-dot tp-dot-blue"></div>
									<span class="tp-footer-text">{{ $totalTech }} <span data-t="tech.flowing">Technologies
											Flowing</span></span>
								</div>
								<div class="tp-divider"></div>
								<div class="tp-footer-item">
									<div class="tp-dot tp-dot-orange"></div>
									<span class="tp-footer-text" data-t="tech.loop">Infinite Loop</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ SECTION 3/8 — 3 BIG SINS ============
	Nama "3 Big Sins" dipertahankan sesuai permintaan.
	Tiga pilar: Blog Publikasi / Layanan / Edukasi — diadaptasi dari
	struktur "TRI DHARMA" (Education / Research & Publications / Service)
	di https://www.res.my.id/ --}}
	<section class="pf-fixed-background pf-scope pf-section-bigsins">
		<div class="container pf-section-inner">
			<div class="text-center mb-4">
				<p class="section-eyebrow mb-2" data-t="bigsins.eyebrow">Tiga Pilar</p>
				<h2 class="section-title mb-3" data-t="bigsins.title">3 Deadly Sins</h2>
				<p class="section-subtitle mx-auto" data-t="bigsins.subtitle">
					Tiga hal yang terus saya kerjakan: menulis, membangun, dan mengajar.
				</p>
			</div>
			<div class="row g-4 justify-content-center">
				@foreach($bigSins as $pillar)
					<div class="col-lg-4 col-md-12 d-flex">
						<div class="card card-hover h-100 w-100 border-0 pf-sins-card pf-sins-{{ $loop->index }}">
							<div class="card-body p-4 d-flex flex-column">
								<div class="pf-sins-icon mb-3">
									<i class="{{ $pillar['icon'] }}"></i>
								</div>
								<h4 class="card-title fw-bold text-white mb-2">{{ $pillar['title'] }}</h4>
								<p class="card-text text-secondary flex-grow-1 mb-3">{{ $pillar['description'] }}</p>
								<ul class="list-unstyled pf-sins-points mb-0">
									@foreach($pillar['points'] as $point)
										<li class="d-flex align-items-start gap-2">
											<i class="fa-solid fa-circle-check flex-shrink-0 mt-1"></i>
											<span class="small">{{ $point }}</span>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	{{-- ============ SECTION 4/8 — JOURNEY ============ --}}
	<section class="pf-fixed-background pf-scope pf-section-journey">
		<div class="container pf-section-inner">
			<div class="text-center mb-4">
				<p class="section-eyebrow mb-2" data-t="journey.eyebrow">Perjalanan</p>
				<h2 class="section-title mb-3" data-t="journey.title">Perjalanan Saya</h2>
				<p class="section-subtitle mx-auto" data-t="journey.subtitle">
					Jalan dari halaman kosong sampai membangun aplikasi web yang bisa dirawat.
				</p>
			</div>
			<div class="pf-journey">
				@foreach($journey as $step)
					<div class="pf-journey-item">
						<div class="pf-journey-marker" aria-hidden="true"></div>
						<div class="pf-journey-card">
							<span class="pf-journey-period">{{ $step['period'] }}</span>
							<h3 class="pf-journey-title">{{ $step['title'] }}</h3>
							<p class="pf-journey-text">{{ $step['description'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	{{-- ============ SECTION 5/8 — LAYANAN ============ --}}
	<section id="layanan-section" class="pf-fixed-background pf-scope pf-section-layanan">
		<div class="container pf-section-inner">
			<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
				<div class="text-center mb-4">
					<p class="section-eyebrow mb-2" data-t="layanan.eyebrow">LAYANAN</p>
					<h2 class="section-title mb-3">
						<span data-t="layanan.title">Solusi Digital</span> <span class="text-gradient">Terlengkap</span>
					</h2>
					<p class="section-subtitle mx-auto" data-t="layanan.subtitle">
						Layanan yang saling melengkapi untuk mendukung kebutuhan digital Anda.
					</p>
				</div>
				<div class="row g-4 justify-content-center">
					@foreach($services as $index => $service)
						<div class="col-lg-3 col-md-6 col-12 d-flex">
							<div class="card card-hover h-100 w-100 p-4 border-0">
								<div class="card-body p-0 d-flex flex-column">
									<div class="icon-circle-hero mb-3"><i class="{{ $service['icon'] }}"></i></div>
									<h4 class="card-title fw-bold text-white mb-2">{{ $service['title'] }}</h4>
									<p class="card-text text-secondary flex-grow-1">{{ $service['description'] }}</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<div class="text-center mt-4">
					<a href="{{ route('layanan') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
						data-t="layanan.cta">
						Semua Layanan <i class="fa-solid fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ SECTION 6/8 — PROYEK ============ --}}
	<section id="proyek-section" class="pf-fixed-background pf-scope pf-project">
		<div class="container pf-section-inner">
			<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
				<div class="text-center mb-3">
					<p class="section-eyebrow mb-2" data-t="proyek.eyebrow">PORTOFOLIO</p>
					<h2 class="section-title mb-3">
						<span data-t="proyek.title_1">Proyek</span> <span class="text-gradient">Unggulan</span>
					</h2>
					<p class="section-subtitle mx-auto" data-t="proyek.subtitle">
						Beberapa hasil karya dan aplikasi web yang telah dikembangkan.
					</p>
				</div>
				<div class="row g-4">
					@foreach($projects as $project)
						<div class="col-lg-4 col-md-6 col-12 d-flex">
							<div class="card card-hover h-100 w-100 border-0 overflow-hidden d-flex flex-column">
								<div class="card-img-wrapper" style="height: 96px; background: rgba(0,0,0,0.3);">
									<img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}"
										class="w-100 h-100 object-fit-cover" style="width:100%;height:100%;object-fit:cover;">
								</div>
								<div class="card-body p-4 d-flex flex-column flex-grow-1">
									<p class="card-text text-secondary small mb-2">
										<i class="fa-solid fa-code me-2 text-primary"></i>{{ $project['subtitle'] }}
									</p>
									<h4 class="card-title fw-bold mb-2">
										<a href="{{ route('proyek.show', $project['slug']) }}"
											class="text-white text-decoration-none">
											{{ $project['title'] }}
										</a>
									</h4>
									<p class="card-text text-secondary small flex-grow-1 mb-3">
										{{ Str::limit($project['description'], 100) }}
									</p>
									<div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
										<div class="d-flex flex-wrap gap-1 mb-3">
											@foreach($project['stack'] as $tech)
												<span class="chip me-1 mb-1">{{ $tech }}</span>
											@endforeach
										</div>
										<a href="{{ route('proyek.show', $project['slug']) }}"
											class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-2 w-100 justify-content-center">
											Detail Proyek <i class="fa-solid fa-arrow-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<div class="text-center mt-2">
					<a href="{{ route('proyek') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
						data-t="proyek.cta">
						Semua Proyek <i class="fa-solid fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ SECTION 7/8 — BLOG PUBLIKASI ============ --}}
	<section id="blog-section" class="pf-fixed-background pf-scope pf-section-blog">
		<div class="container pf-section-inner">
			<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
				<div class="text-center mb-3">
					<p class="section-eyebrow mb-2" data-t="blog.eyebrow">BLOG & ARTIKEL</p>
					<h2 class="section-title mb-3">
						<span data-t="blog.title_1">Artikel &</span> <span class="text-gradient">Wawasan Terbaru</span>
					</h2>
					<p class="section-subtitle mx-auto" data-t="blog.subtitle">
						Artikel tentang pengembangan web, SEO, dan dunia teknologi.
					</p>
				</div>
				<div class="row g-4">
					@foreach($posts as $index => $post)
						<div class="col-lg-4 col-md-6 col-12 d-flex">
							<div class="card card-hover h-100 w-100 border-0 overflow-hidden d-flex flex-column">
								<div class="card-img-wrapper" style="height: 132px; background: rgba(0,0,0,0.3);">
									<img src="{{ asset('images/' . $slideImages[$index % count($slideImages)]) }}"
										alt="{{ $post['title'] }}" class="w-100 h-100 object-fit-cover"
										style="width:100%;height:100%;object-fit:cover;">
									<div class="position-absolute top-0 end-0 m-3">
										<span
											class="badge bg-dark bg-opacity-75 text-primary border border-secondary border-opacity-25 px-3 py-2 rounded-pill small">
											<i
												class="fa-regular fa-calendar-days me-1"></i>{{ \Carbon\Carbon::parse($post['date'])->format("d F Y") }}
										</span>
									</div>
								</div>
								<div class="card-body p-4 d-flex flex-column flex-grow-1">
									<h4 class="card-title fw-bold mb-2">
										<a href="{{ route('blog.show', $post['slug']) }}"
											class="text-white text-decoration-none">
											{{ $post['title'] }}
										</a>
									</h4>
									<p class="card-text text-secondary small flex-grow-1 mb-3">
										{{ Str::limit($post['excerpt'] ?? $post['title'], 110) }}
									</p>
									<div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
										<div class="d-flex flex-wrap gap-1 mb-3">
											@foreach($post['tags'] as $tag)
												<span class="chip me-1 mb-1">{{ $tag }}</span>
											@endforeach
										</div>
										<a href="{{ route('blog.show', $post['slug']) }}"
											class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-2 w-100 justify-content-center"
											data-t="blog.baca">
											Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<div class="text-center mt-3">
					<a href="{{ route('blog') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
						data-t="blog.semua">
						Semua Artikel <i class="fa-solid fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	{{-- ============ SECTION 8/8 — KONTAK (terakhir, sebelum footer) ============ --}}
	<section id="book-online" class="pf-fixed-background pf-scope pf-section-kontak">
		<div class="container pf-section-inner">
			<div class="hero-card-frame p-4 p-lg-5">
				<div class="text-center mb-4">
					<p class="section-eyebrow mb-2" data-t="kontak.eyebrow">Kontak</p>
					<h2 class="section-title mb-3"><i class="fa-solid fa-envelope me-2"></i><span
							data-t="kontak.subtitle">Siap memulai proyek? Kirim pesan kepada saya.</span></h2>
				</div>
				<div class="row align-items-center gy-4">
					<div class="col-lg-5 text-center">
						<img src="{{ asset('images/appointment.png') }}" alt="" class="img-fluid pf-contact-img">
					</div>
					<div class="col-lg-7">
						<form action="{{ route('messages.store') }}" method="post" novalidate>
							@csrf
							<div class="mb-3">
								<label for="name" class="form-label" data-t="kontak.nama">Nama</label>
								<input type="text" class="form-control" id="name" name="name"
									placeholder="Masukkan Nama Lengkap">
								@error('name')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="mb-3">
								<label for="email" class="form-label" data-t="kontak.email">Email</label>
								<input type="email" class="form-control" id="email" name="email"
									placeholder="Masukkan Email">
								@error('email')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="mb-3">
								<label for="phone" class="form-label" data-t="kontak.phone_label">Nomor Telepon</label>
								<input type="text" class="form-control" id="phone" name="phone"
									placeholder="Masukkan Nomor Telepon">
								@error('phone')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="mb-3">
								<label for="message" class="form-label" data-t="kontak.pesan">Pesan</label>
								<textarea class="form-control" rows="4" id="message" name="message"
									placeholder="Pesan"></textarea>
								@error('message')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
								@enderror
							</div>
							<div class="d-grid">
								<button type="submit" class="btn submit-btn btn-lg" data-t="kontak.kirim">Kirim</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- -------------------------------------------------------------
	Matikan transisi tombol hero selama jendela di-resize.

	`.btn-outline-hero` (tombol "Hubungi Saya") warnanya berubah
	saat jendela melewati breakpoint 991.98px, karena media query
	mobile di portfolio.css meng-override variabel warnanya ke
	#231937. Kalau transisi `color` / `border-color` bawaan
	Bootstrap ikut jalan, perubahan itu jadi beranimasi — padahal
	bukan hover, dan durasi 0.15s-nya praktis tak terlihat karena
	layout sedang reflow.

	Atribut `data-resizing` dipasang selama resize benar-benar
	terjadi dan dilepas RESIZE_IDLE_MS (150ms) setelah resize
	berhenti, sehingga transisi kembali hidup dan hover tetap
	mulus dua arah seperti tombol Bootstrap 5 biasa.

	Pasangannya di CSS: `.hero .btn-outline-hero[data-resizing]`
	di public/css/portfolio.css.
	------------------------------------------------------------- --}}
	<script>
		(function () {
			var BTN = document.querySelector(".hero .btn-outline-hero");
			if (!BTN) return;

			var RESIZE_IDLE_MS = 150;
			var idleTimer = null;

			window.addEventListener("resize", function () {
				BTN.setAttribute("data-resizing", "1");
				clearTimeout(idleTimer);
				idleTimer = setTimeout(function () {
					BTN.removeAttribute("data-resizing");
				}, RESIZE_IDLE_MS);
			}, { passive: true });
		})();
	</script>
@endsection