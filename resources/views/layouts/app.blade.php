<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title2 ?? $title . config('app.name', 'Laravel') }}</title>

	{{-- ---------------------------------------------------------------
	     PRELOAD FONT ICON (Font Awesome 6) - HARUS DI PALING ATAS <head>.

	     Semua @font-face di /css/all.min.css memakai `font-display: block`.
	     Artinya selama font belum tiba, glifnya digambar TIDAK TERLIHAT
	     (bukan placeholder, bukan tofu): ikonnya benar-benar hilang, lalu
	     bertunculan begitu font selesai. Itulah bug "ikon FA berkedip hilang".

	     Tanpa preload, request font baru dimulai SETELAH all.min.css
	     (100 KB) selesai di-download dan di-parse - padahal paint juga
	     menunggu CSS. Jadi font selalu downloading di belakang. Preload
	     membuat request font jalan paralel dengan CSS, jadi antrean itu hilang.

	     `crossorigin` WAJIB ada. Font selalu diambil dalam mode CORS, jadi
	     preload tanpa atribut ini mengunduh file-nya DUA KALI (preload-nya
	     tidak terpakai, lalu @font-face mengunduh ulang).

	     Font-nya sendiri sudah di-subset ke 35 glif yang benar-benar dipakai
	     project ini: 292 KB -> 7,2 KB (lihat public/webfonts). Dengan
	     sekecil itu, font hampir selalu siap sebelum frame pertama dicetak,
	     jadi blok `font-display: block` tidak pernah kelihatan.

	     Apenas tiga font yang dipakai, sesuai pemakaian di views/:
	       fa-solid-900    -> .fa-solid / .fa (default), weight 900
	       fa-regular-400  -> .fa-regular, weight 400
	       fa-brands-400   -> .fa-brands (ikon sosial), weight 400
	     `fa-v4compatibility` tidak di-preload: hanya dipakai kelas FA4 lama
	     di halaman admin, dan filenya sudah kecil (4,7 KB).
	--------------------------------------------------------------- --}}
	<link rel="preload" href="/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>

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
	<link rel="preload" href="/fonts/fairfax/Fairfax.ttf" as="font" type="font/ttf" crossorigin>
	<link rel="preload" href="/fonts/fairfax/FairfaxBold.ttf" as="font" type="font/ttf" crossorigin>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	{{-- Fraunces = font serif untuk typewriter (.font-style-serif).
	     Weight 700 - hurufnya sudah tebal dan berkontras tinggi, bobot
	     400 terlihat terlalu tipis untuk nama besar di hero.
	     Axis `opsz` (9..144) ikut diambil supaya optikal ukurannya
	     menyesuaikan ukuran teks otomatis.
	     PENTING: jangan dipisah ke <link> sendiri. Semua font ini
	     render-blocking; menambah satu request lagi berarti satu
	     round-trip ekstra yang menahan first paint.
	     Kalau weight-nya diubah, WAJIB diubah juga font-weight di
	     .font-style-serif (style.css DAN portfolio.css) - kalau tidak,
	     browser akan mensintesis bobot dari instance terdekat. --}}
	<link
		href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Poppins:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
		rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="/css/all.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/owl.theme.default.min.css" rel="stylesheet">
	<link href="/css/owl.carousel.css" rel="stylesheet">
	<link href="/css/select2.min.css" rel="stylesheet">
	<link href="/css/sweetalert2.min.css" rel="stylesheet">
	<link href="/css/style.css?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
	<link href="/css/portfolio.css?v={{ filemtime(public_path('css/portfolio.css')) }}" rel="stylesheet">

	{{-- Resource yang harus turun duluan (mis. background section pertama).
	     Ditaruh DI SETELAH stylesheet supaya tidak memblokir render, tapi
	     tetap ditemukan browser sebelum CSS selesai di-parse.
	     Lihat @push('head') di home.blade.php. --}}
	@stack('head')

	<!-- Modernizr (CodyHouse fixed-background-effect) -->
	<script src="/js/modernizr.js"></script>
</head>

<body id="top" data-spy="scroll">
	<div id="app">
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