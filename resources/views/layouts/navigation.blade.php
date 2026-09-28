<nav class="navbar navbar-expand-lg sticky-top pt-2 pb-0">
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
            @php $path = request()->path() == '' ? '/' : '/' . request()->path(); @endphp
            <div class="sh-nav-group-wrapper" id="navGroupWrapper">
                <div class="sh-nav-capsule me-auto d-inline-flex align-items-center gap-2" id="navbarMenu">
                    @foreach(config('portfolio.nav') as $item)
                        @php
                            $active = $item['href'] === '/'
                                ? $path === '/'
                                : str_starts_with($path, $item['href']);
                        @endphp
                        <a href="{{ url($item['href']) }}" class="sh-nav-item {{ $active ? 'active' : '' }}">
                            <i class="{{ $item['icon'] ?? 'fa-solid fa-circle' }} sh-nav-icon"></i>
                            <span data-t="nav.{{ strtolower($item['label']) }}">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
                <div class="d-inline-flex align-items-center gap-2" id="navControls">
                    <button type="button" class="sh-btn-circle lang-btn" id="lang-toggle"
                        aria-label="English / Indonesia" title="English / Indonesia">
                        <i class="fa-solid fa-globe sh-nav-icon me-1"></i>
                        <span class="lang-label" id="lang-label">EN</span>
                    </button>
                    <a href="{{ url('/kontak') }}" class="sh-btn-contact">
                        <i class="fa-solid fa-paper-plane tele sh-nav-icon me-1"></i>
                        <span data-t="nav.hubungi">Hubungi Saya</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    (function () {
        "use strict";

        function initNavbar() {
            if (typeof jQuery === "undefined") {
                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", initNavbar);
                } else {
                    setTimeout(initNavbar, 10);
                }
                return;
            }

            var $ = jQuery;

            // Handle collapse state class on navbar for mobile state
            $("#mainNavbar").on("show.bs.collapse collapsing.bs.collapse", function () {
                $(".navbar").addClass("menu-open");
            });

            $("#mainNavbar").on("hide.bs.collapse hidden.bs.collapse", function () {
                $(".navbar").removeClass("menu-open");
            });

            // Close mobile menu on link click or outside click
            $(document).on("click", function (e) {
                if ($(window).width() < 992 && $("#mainNavbar").hasClass("show")) {
                    if (!$(e.target).closest("#navContainer").length) {
                        $("#mainNavbar").collapse("hide");
                    }
                }
            });

            $("#mainNavbar").on("click", ".sh-nav-item, .sh-btn-contact", function () {
                if ($(window).width() < 992 && $("#mainNavbar").hasClass("show")) {
                    $("#mainNavbar").collapse("hide");
                }
            });

            function updateNavbarState() {
                try {
                    var $nav = $(".navbar");
                    if (!$nav.length) return;

                    var rootFontSize = parseFloat($("html").css("font-size")) || 16;
                    var maxScroll = 4.5 * rootFontSize; // 4.5rem (72px)
                    var y = $(window).scrollTop();
                    var scrolled = y > maxScroll;

                    $nav.toggleClass("navbar-scrolled", scrolled);
                    $nav.attr("data-scroll-state", scrolled ? "scrolled" : "top");
                } catch (e) {
                    if (window.console) console.warn("Navbar scroll-state error:", e);
                }
            }

            $(window).on("scroll resize", updateNavbarState);
            $(document).on("scroll", updateNavbarState);
            updateNavbarState();
        }

        initNavbar();
    })();
</script>