<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title2 ?? ($title ?? '') . config('app.name', 'Laravel') }}</title>

	<!-- Favicon: Icon Khas Laravel (Downloads/Laravel.svg) -->
	<link rel="icon" type="image/svg+xml"
		href="data:image/svg+xml,%3Csvg width='50' height='52' viewBox='0 0 50 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z' fill='%23FF2D20' fill-rule='evenodd'/%3E%3C/svg%3E">
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

	<!-- Font Awesome CDN Preconnect & Resources -->
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/webfonts/fa-solid-900.woff2"
		as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/webfonts/fa-regular-400.woff2"
		as="font" type="font/woff2" crossorigin>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

	{{-- Fairfax HD = font utama seluruh situs (judul, paragraf, navbar,
	tombol). Self-hosted karena Fairfax HD tidak ada di Google Fonts.

	Preload memakai file .ttf asli (bukan woff2 hasil subset), sesuai
	permintaan: TTF dan WOFF2 berisi outline yang sama persis, jadi
	hasil render tidak berubah - hanya besar unduhan (±2,9 MB per file).

	Hanya Regular + Bold yang di-preload karena itu yang dipakai
	mayoritas teks. Italic & Serif TIDAK di-preload - browser hanya
	mengambilnya kalau ada elemen yang benar-benar memakainya, jadi
	di-preload justru jadi sia-sia (dan menambah 5,8 MB sia-sia).

	`crossorigin` WAJIB ada di sini walau font-nya dari domain
	sendiri: preload font selalu berjalan dalam mode CORS, dan tanpa
	atribut ini browser mengunduh dua kali (sekali preload, sekali
	saat dipakai) - persis bug yang pernah kita temui untuk Font Awesome. --}}
	<link rel="preload" href="{{ asset('fonts/fairfax/Fairfax.ttf') }}" as="font" type="font/ttf" crossorigin>
	<link rel="preload" href="{{ asset('fonts/fairfax/FairfaxBold.ttf') }}" as="font" type="font/ttf" crossorigin>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	{{-- Fraunces = font serif untuk typewriter (.font-style-serif).
	Weight 700 - hurufnya sudah tebal dan berkontras tinggi, bobot
	400 terlihat terlalu tipis untuk nama besar di hero.
	Axis `opsz` (9..144) ikut diambil supaya optikal ukurannya
	menyesuaikan ukuran teks otomatis.
	PENTING: jangan dipisah ke
	<link> sendiri. Semua font ini
	render-blocking; menambah satu request lagi berarti satu
	round-trip ekstra yang menahan first paint.
	Kalau weight-nya diubah, WAJIB diubah juga font-weight di
	.font-style-serif (style.css) - kalau tidak,
	browser akan mensintesis bobot dari instance terdekat. --}}
	<link
		href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
		rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}?v=19" rel="stylesheet">

	{{-- Resource yang harus turun duluan (mis. background section pertama).
	Ditaruh DI SETELAH stylesheet supaya tidak memblokir render, tapi
	tetap ditemukan browser sebelum CSS selesai di-parse.
	Lihat @push('head') di home.blade.php. --}}
	@stack('head')

	<script src="{{ asset('js/modernizr.js') }}"></script>
	<script src="{{ asset('js/jquery.js') }}"></script>
</head>

<body id="top" data-spy="scroll" data-pf-section="hero">
	<!-- Ambient Glow Canvas & Custom Trailing Cursor -->
	<canvas id="custom-cursor-canvas" aria-hidden="true"></canvas>
	<div id="cursor-dot" aria-hidden="true"><span class="cursor-dot-hover"></span></div>
	<div id="cursor-ring" aria-hidden="true"></div>

	<div id="app">
		<x-navbar />

		{{ $slot }}
	</div>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
	<script src="{{ asset('js/wow.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/SmoothScroll.js') }}"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
	<script src="{{ asset('js/sections.js') }}?v=1"></script>
	<script src="{{ asset('js/tint-navbar.js') }}"></script>
	<script src="{{ asset('js/resize-trans-down-btn-cutoff.js') }}"></script>
	{{-- Sumber tunggal getNavbarShrink(); WAJIB sebelum custom.js & vertical-nav.js --}}
	<script src="{{ asset('js/navbar-shrink.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
	<script>window.PORTFOLIO_TRANSLATIONS = @json(config('portfolio.translations'));</script>
	<script src="{{ asset('js/translate.js') }}"></script>
	<script src="{{ asset('js/reveal.js') }}"></script>
	<script src="{{ asset('js/typewriter.js') }}"></script>
	<script src="{{ asset('js/carousel-fx.js') }}?v=400"></script>
	<script src="{{ asset('js/vertical-nav.js') }}"></script>
	<script src="{{ asset('js/cursor.js') }}?v=17"></script>
</body>

</html>