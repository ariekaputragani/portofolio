@php
    $navItems = config('portfolio.nav');
    $translations = config('portfolio.translations.en');
@endphp
<nav class="navbar navbar-expand-xl bg-light navbar-light sticky-top" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="280px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ms-auto">
                @foreach($navItems as $item)
                    @php
                        $active = request()->is(ltrim($item['href'], '/')) || (ltrim($item['href'], '/') === '' && request()->is('/'));
                    @endphp
                    <li class="nav-item mx-2">
                        <a class="nav-link smoothScroll{{ $active ? ' active' : '' }}" href="{{ url($item['href']) }}" data-t="nav.{{ strtolower($item['label']) }}">{{ $item['label'] }}</a>
                    </li>
                @endforeach
                <li class="nav-item ms-2">
                    <a type="button" class="btn book-btn" href="{{ url('/kontak') }}" data-t="nav.hubungi">Hubungi Saya</a>
                </li>
                <li class="nav-item ms-2">
                    <button type="button" class="btn btn-outline-secondary" id="lang-toggle" title="English / Indonesia">
                        <i class="fa-solid fa-language"></i> <span id="lang-label">EN</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>