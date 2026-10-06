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
</head>
<body id="top" data-spy="scroll" class="bg-rs huruf-serif">
    <div id="app">
		<section class="preloader">
			<div class="spinner">

				<span class="spinner-rotate"></span>

			</div>
		</section>
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
