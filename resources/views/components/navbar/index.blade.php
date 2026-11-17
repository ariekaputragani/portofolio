@php
    $path = request()->path() == '' ? '/' : '/' . request()->path();
    $isHome = request()->is('/');
    $initialSection = ($isHome || $path === '/' || request()->routeIs('home')) ? 'hero' : null;
@endphp
<nav class="navbar navbar-expand-lg sticky-top pt-2 pb-0" @if($initialSection) data-pf-section="{{ $initialSection }}"
@endif>
    <div class="container d-flex align-items-center" id="navContainer">
        <button class="sh-btn-circle d-lg-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Buka navigasi">
            <span class="sh-hamburger">
                <span class="sh-hamburger-line line-1"></span>
                <span class="sh-hamburger-line line-2"></span>
                <span class="sh-hamburger-line line-3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="sh-nav-group-wrapper" id="navGroupWrapper">
                <div class="sh-nav-capsule me-auto d-inline-flex align-items-center gap-2" id="navbarMenu">
                    <x-navbar.link href="{{ $isHome ? '#top' : url('/') }}">
                        <i class="fa-solid fa-house sh-nav-icon"></i>
                        <span data-t="nav.beranda">Beranda</span>
                    </x-navbar.link>

                    <x-navbar.link href="{{ $isHome ? '#about' : url('/#about') }}">
                        <i class="fa-solid fa-user sh-nav-icon"></i>
                        <span data-t="nav.tentang">Tentang</span>
                    </x-navbar.link>

                    <x-navbar.link href="{{ $isHome ? '#projects' : url('/#projects') }}">
                        <i class="fa-solid fa-code sh-nav-icon"></i>
                        <span data-t="nav.proyek">Proyek</span>
                    </x-navbar.link>

                    <x-navbar.link href="{{ $isHome ? '#journey' : url('/#journey') }}">
                        <i class="fa-solid fa-hourglass sh-nav-icon"></i>
                        <span data-t="nav.perjalanan">Perjalanan</span>
                    </x-navbar.link>

                    <x-navbar.link href="{{ $isHome ? '#stack' : url('/#stack') }}">
                        <i class="fa-solid fa-cubes sh-nav-icon"></i>
                        <span data-t="nav.stack">Stack</span>
                    </x-navbar.link>

                    <x-navbar.link href="{{ url('/blog') }}" :active="request()->is('blog*')">
                        <i class="fa-solid fa-newspaper sh-nav-icon"></i>
                        <span data-t="nav.blog">Blog</span>
                    </x-navbar.link>
                </div>
                <div class="d-inline-flex align-items-center gap-2" id="navControls">
                    <x-navbar.language-toggle />
                    <a href="{{ $isHome ? '#contact' : url('/#contact') }}" class="sh-btn-contact smoothScroll">
                        <i class="fa-solid fa-paper-plane sh-nav-icon me-1"></i>
                        <span data-t="nav.hubungi">Hubungi Saya</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>