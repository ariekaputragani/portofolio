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

        // Transisi KELUAR (unhover) untuk tombol capsule navbar.
        // Animasi masuk hanya bisa dipicu CSS lewat :hover, dan begitu kursor
        // pergi pseudo-element-nya langsung hilang (terlihat kaku/monoton).
        // Karena CSS tidak bisa mengingat state hover yang sudah berakhir, kelas
        // .sh-nav-out dipasang di sini supaya wipe ke kiri (lihat portfolio.css)
        // tetap berjalan sebelum border benar-benar hilang.
        //
        // Nilai clip-path animasi masuk yang SEDANG berjalan dicatat tiap frame
        // (dan ditulis ke --sh-nav-out-clip saat kursor pergi), jadi kalau
        // kursor pergi di tengah animasi, wipe keluar lanjut dari posisi itu
        // dan tidak meloncat ke border penuh. Kalau tidak terbaca, CSS memakai
        // keyframe terakhir hover (border penuh) seperti biasa.
        function initCapsuleExitWipe() {
            var items = document.querySelectorAll(".sh-nav-capsule .sh-nav-item");
            if (!items.length) return;

            Array.prototype.forEach.call(items, function (item) {
                var frame = 0;
                var lastClip = "";

                function readClip() {
                    lastClip = "";

                    try {
                        var style = window.getComputedStyle(item, "::after");
                        var clip = style.clipPath || style.webkitClipPath;

                        // hanya nilai inset() yang bisa diinterpolasi animasi
                        if (clip && clip.indexOf("inset") === 0) {
                            lastClip = clip;
                        }
                    } catch (e) {
                        if (window.console) console.warn("Capsule exit wipe error:", e);
                    }
                }

                // Border sudah penuh = animasi masuk sudah di keyframe terakhir
                function isHoverAnimFinished(clip) {
                    return !!clip && /^inset\(\s*0(px|%)?\s+0(px|%)?\s+0(px|%)?\s+0(px|%)?\s*\)$/.test(clip);
                }

                function watch() {
                    frame = 0;
                    readClip();

                    // Animasi masuk sudah tuntas (sudah di keyframe terakhir),
                    // tidak perlu lanjut memantau tiap frame
                    if (!isHoverAnimFinished(lastClip)) {
                        frame = window.requestAnimationFrame(watch);
                    }
                }

                item.addEventListener("mouseenter", function () {
                    item.classList.remove("sh-nav-out");
                    item.style.removeProperty("--sh-nav-out-clip");
                    lastClip = "";

                    if (!frame && window.requestAnimationFrame) {
                        frame = window.requestAnimationFrame(watch);
                    }
                });

                item.addEventListener("mouseleave", function () {
                    if (frame && window.cancelAnimationFrame) {
                        window.cancelAnimationFrame(frame);
                        frame = 0;
                    }

                    // Jangan baca ulang di sini: :hover sudah lepas, jadi
                    // nilainya cuma state dasar (tersembunyi). Pakai nilai
                    // terakhir yang dicatat watch() saat kursor masih di atas.
                    if (!lastClip) {
                        readClip();
                    }

                    item.style.removeProperty("--sh-nav-out-clip");

                    if (lastClip) {
                        item.style.setProperty("--sh-nav-out-clip", lastClip);
                    }

                    item.classList.add("sh-nav-out");
                });
            });
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initCapsuleExitWipe);
        } else {
            initCapsuleExitWipe();
        }

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