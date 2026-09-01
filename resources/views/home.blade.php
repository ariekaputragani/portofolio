@extends('layouts.app', ['title' => ''])

@php
	$site = config('portfolio');
	$slideImages = ['gambar1.jpg', 'gambar2.jpg', 'gambar3.jpg', 'gambar4.jpg'];
	$pipeline = $technologies;
	$totalTech = collect($pipeline)->reduce(fn($c, $g) => $c + count($g), 0);
@endphp

@section('content')
	{{-- Hero --}}
	<section class="hero pf-scope">
		<div class="container">
			<div class="row align-items-center gy-5">
				<div class="col-lg-3 text-center sr-reveal" data-wow-delay="0.15s">
					<div class="d-inline-block">
						<div class="clock">
							<svg viewBox="0 0 240 240" class="analog-clock-svg">
								<defs>
									<filter id="markerShadow" x="-30%" y="-30%" width="160%" height="160%">
										<feDropShadow dx="1" dy="2" stdDeviation="1.5" flood-color="#000000"
											flood-opacity="0.5" />
									</filter>
									<filter id="handShadow" x="-30%" y="-30%" width="160%" height="160%">
										<feDropShadow dx="2" dy="3" stdDeviation="2.5" flood-color="#000000"
											flood-opacity="0.45" />
									</filter>
								</defs>

								<!-- 12 Hour Markers (Dark Capsule Pills) -->
								<g class="clock-markers">
									@for ($i = 0; $i < 12; $i++)
										@php $angle = $i * 30; @endphp
										<g transform="translate(120, 120) rotate({{ $angle }}) translate(0, -92)">
											<rect x="-3.5" y="-7" width="7" height="14" rx="3.5" fill="#1c1f22"
												filter="url(#markerShadow)" />
										</g>
									@endfor
								</g>

								<!-- Hour Hand (Blue Rectangular Bar with Tip Notch) -->
								<g class="clock-hand" id="clockHourHand" transform="translate(120, 120) rotate(0)">
									<path d="M -6.5 10 L -6.5 -50 L -3 -50 L -3 -56 L 3 -56 L 3 -50 L 6.5 -50 L 6.5 10 Z"
										fill="#003ce7" filter="url(#handShadow)" />
								</g>

								<!-- Minute Hand (Blue Rectangular Bar with Tip Notch) -->
								<g class="clock-hand" id="clockMinuteHand" transform="translate(120, 120) rotate(0)">
									<path d="M -6.5 12 L -6.5 -74 L -3 -74 L -3 -80 L 3 -80 L 3 -74 L 6.5 -74 L 6.5 12 Z"
										fill="#003ce7" filter="url(#handShadow)" />
								</g>

								<!-- Second Hand (Silver Metallic Needle) -->
								<g class="clock-hand" id="clockSecondHand" transform="translate(120, 120) rotate(0)">
									<line x1="0" y1="18" x2="0" y2="-88" stroke="#a0a7ae" stroke-width="2.5"
										stroke-linecap="round" filter="url(#handShadow)" />
								</g>

								<!-- Center Pivot Cap (Black Rounded Square) -->
								<g transform="translate(120, 120)">
									<rect x="-10" y="-10" width="20" height="20" rx="5" fill="#121417"
										filter="url(#handShadow)" />
								</g>
							</svg>
						</div>
					</div>
				</div>
				<div class="col-lg-3 text-center sr-reveal hero-avatar-col" data-wow-delay="0.15s">
					<div class="float-animation d-inline-block">
						<div class="avatar-frame-container">
							<img src="{{ asset('images/profile.jpg') }}" class="avatar-img" alt="Foto {{ $site['name'] }}"
								draggable="false">
							<img src="{{ asset('images/frame-s19.png') }}" class="avatar-frame-overlay"
								alt="Bingkai Frame S19" draggable="false">
						</div>
					</div>
				</div>
				<div class="col-lg-6 sr-reveal">
					<p class="hero-eyebrow" data-t="hero.halo">Saya</p>
					<h1 class="hero-title mb-3">
						<span class="text-gradient typing-name">{{ $site['name'] }}</span>
					</h1>
					<p class="hero-role mb-3">
						<span data-t="hero.role_prefix">{{ $site['hero']['role_prefix'] ?? 'Seorang' }}</span> <span
							class="typing-role"></span>
					</p>
					<p class="hero-intro mb-4" data-t="hero.intro">{{ $site['hero']['intro'] }}</p>
					<div class="d-flex flex-wrap gap-3">
						<a href="{{ route('proyek') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
							data-t="hero.cta_proyek">
							Lihat Proyek <i class="fa-solid fa-arrow-right"></i>
						</a>
						<a href="{{ route('kontak') }}"
							class="btn btn-outline-secondary btn-lg d-inline-flex align-items-center gap-2"
							data-t="hero.cta_kontak">
							<i class="fa-regular fa-envelope"></i> Hubungi Saya
						</a>
					</div>
					<div class="d-flex flex-wrap gap-2 mt-4">
						@foreach($site['hero']['tech'] as $tech)
							<span class="chip">{{ $tech }}</span>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Combined About & Tech Pipeline: 100% background gradient portofolio -->
	<div class="about-tech-wrapper pf-scope">
		<!-- About Preview -->
		<section class="section section-tint border-0">
			<div class="container">
				<div class="row align-items-center gy-5">
					<div class="col-lg-6">
						<p class="section-eyebrow mb-2" data-t="about.eyebrow">Tentang Saya</p>
						<h2 class="section-title mb-4">
							<span data-t="about.title_1">Membangun solusi digital yang</span>
							<span data-t="about.title_2">berdampak</span>
						</h2>
						<p class="text-secondary fs-5" data-t="about.text">
							Saya adalah {{ $site['role'] }} yang senang mengubah ide menjadi produk digital yang nyata. Dari
							merancang arsitektur hingga detail interaksi, saya berusaha memberikan kualitas terbaik di
							setiap proyek.
						</p>
						<ul class="list-unstyled mt-4">
							@foreach($site['highlights'] as $highlight)
								<li class="d-flex align-items-start gap-2 mb-2">
									<i class="fa-solid fa-circle-check text-primary flex-shrink-0 mt-1"></i>
									<span>{{ $highlight }}</span>
								</li>
							@endforeach
						</ul>
						<a href="{{ route('tentang') }}"
							class="btn btn-outline-primary mt-3 d-inline-flex align-items-center gap-2" data-t="about.cta">
							Selengkapnya <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
					<div class="col-lg-6">
						<div class="card h-100">
							<div class="card-body p-4">
								<h5 class="fw-bold mb-4" data-t="about.skills">Keahlian</h5>
								@foreach($site['skills'] as $skill)
									<div class="mb-3">
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
				</div>
			</div>
		</section>

		<!-- Tech marquee -->
		<section class="tp-section">
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
							<h3 class="tp-title">Tech <span class="tp-title-gradient" data-t="tech.title_2">Pipeline</span>
							</h3>
							<p class="tp-subtitle"><span data-t="tech.active">Active</span> • {{ $totalTech }}</p>
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
													<div class="tp-badge {{ $badges[$item['level']] ?? 'tp-badge-intermediate' }}">
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
						<span class="tp-footer-text" data-t="tech.pipelines">{{ count($pipeline) }} Active Pipelines</span>
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
		</section>
	</div>

	<!-- Layanan (services) -->

	<div class="pf-scope pf-hero-bg py-4">
		<!-- Layanan (services) -->
		<section id="layanan-section" class="py-4">
			<div class="container py-3">
				<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
					<div class="text-center mb-5">
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
										<div class="icon-circle-hero mb-4"><i class="{{ $service['icon'] }}"></i></div>
										<h4 class="card-title fw-bold text-white mb-2">{{ $service['title'] }}</h4>
										<p class="card-text text-secondary flex-grow-1">{{ $service['description'] }}</p>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="text-center mt-5">
						<a href="{{ route('layanan') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
							data-t="layanan.cta">
							Semua Layanan <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Proyek -->
		<section id="proyek-section" class="py-4">
			<div class="container py-3">
				<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
					<div class="text-center mb-5">
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
									<div class="card-img-wrapper" style="height: 200px; background: rgba(0,0,0,0.3);">
										<img src="{{ asset(ltrim($project['image'], '/')) }}" alt="{{ $project['title'] }}"
											class="w-100 h-100 object-fit-cover"
											style="width:100%;height:100%;object-fit:cover;">
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
					<div class="text-center mt-5">
						<a href="{{ route('proyek') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
							data-t="proyek.cta">
							Semua Proyek <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Blog -->
		<section id="blog-section" class="py-4">
			<div class="container py-3">
				<div class="hero-card-frame p-4 p-lg-5 sr-reveal">
					<div class="text-center mb-5">
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
									<div class="card-img-wrapper" style="height: 190px; background: rgba(0,0,0,0.3);">
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
					<div class="text-center mt-5">
						<a href="{{ route('blog') }}" class="btn book-btn btn-lg d-inline-flex align-items-center gap-2"
							data-t="blog.semua">
							Semua Artikel <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
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
							<h2 class="wow fadeInUp" data-wow-delay="0.4s"><i class="fa-solid fa-envelope mr-10"></i> <span
									data-t="kontak.eyebrow">Kontak</span></h2>
						</div>
						<p class="text-center wow fadeInUp" data-wow-delay="0.5s" data-t="kontak.subtitle">Siap memulai
							proyek? Kirim pesan kepada saya.</p>
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
									<input type="text" class="form-control" id="name" name="name"
										placeholder="Masukkan Nama Lengkap">
									@error('name')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="email" class="form-label" data-t="kontak.email">Email</label>
									<input type="email" class="form-control" id="email" name="email"
										placeholder="Masukkan Email">
									@error('email')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="phone" class="form-label" data-t="kontak.phone_label">Nomor Telepon</label>
									<input type="text" class="form-control" id="phone" name="phone"
										placeholder="Masukkan Nomor Telepon">
									@error('phone')
										<div class="text-danger mt-2">
											{{ $message }}
										</div>
									@enderror
								</div>
								<div class="my-3">
									<label for="message" class="form-label" data-t="kontak.pesan">Pesan</label>
									<textarea class="form-control" rows="5" id="message" name="message"
										placeholder="Pesan"></textarea>
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

	<script>
		(function () {
			function initAnalogClock() {
				var secHand = document.getElementById("clockSecondHand");
				var minHand = document.getElementById("clockMinuteHand");
				var hrHand = document.getElementById("clockHourHand");
				if (!secHand || !minHand || !hrHand) return;

				function updateClock() {
					var now = new Date();
					var ms = now.getMilliseconds();
					var sec = now.getSeconds() + ms / 1000;
					var min = now.getMinutes() + sec / 60;
					var hr = (now.getHours() % 12) + min / 60;

					secHand.setAttribute("transform", "translate(120, 120) rotate(" + (sec * 6).toFixed(2) + ")");
					minHand.setAttribute("transform", "translate(120, 120) rotate(" + (min * 6).toFixed(2) + ")");
					hrHand.setAttribute("transform", "translate(120, 120) rotate(" + (hr * 30).toFixed(2) + ")");

					requestAnimationFrame(updateClock);
				}
				requestAnimationFrame(updateClock);
			}
			if (document.readyState === "loading") {
				document.addEventListener("DOMContentLoaded", initAnalogClock);
			} else {
				initAnalogClock();
			}
		})();
	</script>
@endsection