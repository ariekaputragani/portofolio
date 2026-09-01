<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title2 ?? $title . config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="/css/all.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/owl.theme.default.min.css" rel="stylesheet">
	<link href="/css/owl.carousel.css" rel="stylesheet">
	<link href="/css/select2.min.css" rel="stylesheet">
	<link href="/css/sweetalert2.min.css" rel="stylesheet">
	<link href="/css/style.css?v=13" rel="stylesheet">
	<link href="/css/portfolio.css?v=98" rel="stylesheet">
</head>
<body id="top" data-spy="scroll">
    <div id="app">
		<section class="preloader">
			<div class="spinner-grow text-primary" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</section>
		@include('layouts.navigation')

		@yield('content')
		 @include('layouts.footer')
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
	<script>window.PORTFOLIO_TRANSLATIONS = @json(config('portfolio.translations'));</script>
	<script src="/js/translate.js"></script>
	<script src="/js/reveal.js"></script>
	<script src="/js/typewriter.js"></script>
	<script src="/js/carousel-fx.js?v=400"></script>
</body>
</html>
