{{-- Navbar: State 2 murni --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container" id="navContainer">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            @php $path = request()->path() == '' ? '/' : '/' . request()->path(); @endphp
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center gap-2 gap-lg-3">
                @foreach(config('portfolio.nav') as $item)
                    @php
                        $active = $item['href'] === '/'
                            ? $path === '/'
                            : str_starts_with($path, $item['href']);
                    @endphp
                    <li class="nav-item">
                        <a href="{{ url($item['href']) }}" class="nav-link {{ $active ? 'active fw-semibold' : '' }}"
                            data-t="nav.{{ strtolower($item['label']) }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="d-inline-flex align-items-center gap-2 mt-2 mt-lg-0" id="navControls">
                <button type="button"
                    class="btn btn-outline-secondary btn-sm lang-btn d-flex align-items-center justify-content-center"
                    id="lang-toggle" aria-label="English / Indonesia" title="English / Indonesia">
                    <i class="fa-solid fa-globe me-1"></i>
                    <span class="lang-label" id="lang-label">EN</span>
                </button>
                <a href="{{ url('/kontak') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2" style="border-radius: 999px;">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span data-t="nav.hubungi">Hubungi Saya</span>
                </a>
            </div>
        </div>
    </div>
</nav>