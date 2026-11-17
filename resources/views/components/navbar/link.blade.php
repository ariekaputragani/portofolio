<a {{ $attributes }}
    class="sh-nav-item smoothScroll{{ request()->fullUrlIs(url($href)) ? ' active' : '' }}">{{ $slot }}</a>