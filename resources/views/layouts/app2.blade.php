<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title2 ?? $title . config('app.name', 'Laravel') }}</title>

	{{-- Preload font icon Font Awesome 6, supaya tidak ada ikon yang hilang
	     saat page load. Semua @font-face-nya `font-display: block`, jadi tanpa
	     preload ikon baru+TIDAK terlihat+ setelah all.min.css (100 KB) selesai.
	     Font-nya sudah di-subset ke 7,2 KB, jadi hampir selalu siap sebelum
	     frame pertama. `crossorigin` wajib: tanpa itu filenya diunduh 2x. }}
	<link rel="preload" href="/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="/css/all.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/owl.theme.default.min.css" rel="stylesheet">
	<link href="/css/owl.carousel.css" rel="stylesheet">
	<link href="/css/select2.min.css" rel="stylesheet">
	<link href="/css/sweetalert2.min.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">

	{{-- Resource yang harus turun duluan (mis. background section pertama).
	     Lihat @stack('head') di layouts/app.blade.php. --}}
	@stack('head')

	<!-- Modernizr (CodyHouse fixed-background-effect) -->
	<script src="/js/modernizr.js"></script>
</head>
<body id="top" data-spy="scroll" class="bg-rs huruf-serif">
    <div id="app">
		@yield('content')
    </div>
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jquery.sticky.js"></script>
	<script src="/js/jquery.stellar.min.js"></script>
	<script src="/js/wow.min.js"></script>
	<script src="/js/owl.carousel.min.js"></script>
	<script src="/js/SmoothScroll.js"></script>
	<script src="/js/select2.min.js"></script>
	<script src="/js/sweetalert2.all.min.js"></script>
	<script src="/js/script.js"></script>
	<script src="/js/translate.js"></script>
</body>
</html>
