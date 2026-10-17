@php
    $path = request()->path() == '' ? '/' : '/' . request()->path();

    // Section navbar yang SEDANG menutupi navbar waktu scroll 0.
    //
    // Halaman utama (/) punya <section class="pf-fixed-background hero">
    // yang menutupi 100vh pertama, jadi palet yang benar sebelum JS jalan
    // adalah palet "hero". Halaman lain TIDAK punya <section> seperti itu
    // (pakai <div class="pf-fixed-background">), jadi navbar mereka tetap
    // memakai --navbar-bg-default (teal).
    //
    // Atribut ini harus ada di HTML, bukan dipasang JS: kalau JS yang
    // memasang, navbar akan tampil dengan warna default dulu (teal +
    // teks putih) lalu melompat ke warna section begitu DOMContentLoaded —
    // itu kedip navbar yang kelihatan saat page load. Dengan atributnya
    // sudah ada, CSS resolve palet yang benar sejak frame pertama dan
    // JS cuma mengIKUTI (nilai yang ditulisnya sama persis).
    $initialSection = request()->routeIs('home') ? 'hero' : null;
@endphp
<nav class="navbar navbar-expand-lg sticky-top pt-2 pb-0"
    @if($initialSection) data-pf-section="{{ $initialSection }}" @endif>
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
            //
            // Split juga dihitung ulang di sini, bukan cuma saat scroll:
            // overlay menu (#mainNavbar) baru jadi `display: flex` (fixed
            // 100dvh) SAAT menu dibuka. Kalau user membuka menu tanpa
            // menggulir, tidak ada event scroll yang menyalakan
            // updateSectionTint(), jadi overlay akan masih memakai nilai
            // --pf-split-y default (polos) padahal navbar di atasnya sudah
            // ter-split. Event `shown` dipanggil juga karena saat `show`
            // rect-nya belum tentu final.
            $("#mainNavbar").on("show.bs.collapse collapsing.bs.collapse", function () {
                $(".navbar").addClass("menu-open");
                updateNavbarState();
            });

            $("#mainNavbar").on("shown.bs.collapse", function () {
                updateNavbarState();
            });

            $("#mainNavbar").on("hide.bs.collapse hidden.bs.collapse", function () {
                $(".navbar").removeClass("menu-open");
                updateNavbarState();
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

            // ------------------------------------------------------------
            // Navbar di-split oleh garis batas section.
            //
            // Yang dipotong adalah satu garis horizontal di koordinat
            // VIEWPORT, yaitu `top` milik section yang lebih bawah (batas
            // tempat background image section a bertemu section b).
            //
            // Permukaan navbar yang memakai gradient itu BUKAN satu kotak:
            //
            //     .sh-nav-capsule  top & tinggi sendiri, di dalam navbar
            //     .sh-btn-circle   top & tinggi sendiri (2 di desktop,
            //                      1 di mobile)
            //     #mainNavbar      overlay fixed 100dvh (mobile, saat
            //                      menu kebuka)
            //
            // Jadi offset garis potong WAJIB dihitung per permukaan:
            //
            //     offset = batasY - permukaan.top   (lalu clamp ke
            //                                            0..permukaan.tinggi)
            //
            // Dulu offset ini dihitung sekali dari tinggi <nav> lalu dipakai
            // sebagai PERSEN tinggi capsule — meleset dua kali (sumber
            // koordinatnya salah satu, skala persennya juga salah satu),
            // jadi garis potongnya tidak pernah persis di garis batas.
            // Sekarang satu nilai px per permukaan, semua dihitung dari
            // koordinat viewport yang sama, jadi 100% segaris.
            //
            // Warna a dan b TIDAK ditulis di sini. Nilai resminya ada di
            // public/css/portfolio.css sebagai
            // .navbar[data-pf-section="..."] { --navbar-bg: ... } lalu dibaca
            // sekali saat init lewat elemen sementara.
            //
            // Selector section sengaja hanya "section.pf-fixed-background"
            // supaya halaman lain yang pakai <div class="pf-fixed-background">
            // (proyek, kontak, tentang, berita, ...) tidak ikut dan navbar
            // tetap memakai --navbar-bg-default (teal) seperti sebelumnya.
            // ------------------------------------------------------------
            var PF_SECTIONS = [
                { cls: "hero", key: "hero" },
                { cls: "pf-section-skills", key: "skills" },
                { cls: "pf-section-bigsins", key: "bigsins" },
                { cls: "pf-section-journey", key: "journey" },
                { cls: "pf-section-layanan", key: "layanan" },
                { cls: "pf-project", key: "project" },
                { cls: "pf-section-blog", key: "blog" },
                { cls: "pf-section-kontak", key: "kontak" }
            ];

            var PF_TINT_FALLBACK = { r: 32, g: 178, b: 170, a: 1 };
            var FALLBACK_ENTRY = { bg: PF_TINT_FALLBACK, color: { r: 255, g: 255, b: 255, a: 1 } };

            // Permukaan navbar yang warnanya ikut di-split: surface background
            // (gradient) DAN elemen teks (gradient yang dipotong ke glif).
            //
            // Ketiganya butuh --pf-split-y milik sendiri karena `top` dan
            // `tinggi` masing-masing berbeda, sedangkan yang dipotong hanya
            // SATU garis di koordinat viewport. Node-nya di-cache (DOM statis),
            // tapi rect-nya dibaca ulang tiap frame karena tinggi navbar dan
            // posisi teks berubah antara state top dan scrolled.
            //
            // `.sh-hamburger-line` ikut masuk karena garis hamburger juga
            // ikut terpotong batas section, sama seperti glif teks navbar.
            // Garis 1/2/3 punya offset berbeda-beda (translateY -6px / 0 /
            // +6px), jadi offset-nya WAJIB dihitung per garis — kalau cuma
            // dihitung sekali di induknya, ketiga garis terpotong meleset.
            var surfaceCache = null;

            function getSplitSurfaces() {
                if (!surfaceCache) {
                    surfaceCache = document.querySelectorAll(
                        ".sh-nav-capsule, .sh-btn-circle, .sh-btn-contact, #mainNavbar, " +
                        ".sh-nav-item, " +
                        ".sh-nav-item > span, .sh-nav-item > i, .lang-label, " +
                        "#lang-toggle .sh-nav-icon, .sh-btn-contact > span, " +
                        ".sh-btn-contact > i, .sh-hamburger-line"
                    );
                }

                var out = [];

                for (var i = 0; i < surfaceCache.length; i++) {
                    var el = surfaceCache[i];
                    var rect = el.getBoundingClientRect();

                    // Tidak dirender (display:none) -> tidak ada yang dipotong.
                    if (rect.width <= 0 || rect.height <= 0) continue;

                    // #mainNavbar cuma jadi permukaan split saat berubah jadi
                    // overlay fixed di mobile. Di desktop dia cuma wrapper
                    // transparan, jadi dilewati — kalau tidak, nilai px-nya
                    // akan di-inherit ke capsule di dalamnya dan fought over.
                    if (el.id === "mainNavbar" && window.getComputedStyle(el).position !== "fixed") {
                        continue;
                    }

                    out.push({ el: el, rect: rect });
                }

                return out;
            }

            var sectionCache = null;
            var tintCache = null;

            function getTrackedSections() {
                if (sectionCache) return sectionCache;

                sectionCache = [];
                var nodes = document.querySelectorAll("section.pf-fixed-background");

                Array.prototype.forEach.call(nodes, function (node) {
                    for (var i = 0; i < PF_SECTIONS.length; i++) {
                        if (node.classList.contains(PF_SECTIONS[i].cls)) {
                            sectionCache.push({ el: node, key: PF_SECTIONS[i].key });
                            return;
                        }
                    }
                });

                return sectionCache;
            }

            // Dipanggil ulang kalau DOM berubah (mis. section ditambahkan
            // lewat Vue setelah init), supaya cache tidak basi.
            function refreshSectionCache() {
                sectionCache = null;
                surfaceCache = null;
                updateNavbarState();
            }

            // Membaca nilai custom property dari CSS. CSSnya bisa ditulis
            // dalam bentuk rgb()/rgba() ATAU hex (#abc, #abcd, #aabbcc,
            // #aabbccdd) — keduanya harus diterima, kalau tidak semua warna
            // di palet akan dianggap tidak valid dan jatuh ke fallback.
            function parseCssColor(raw) {
                var text = String(raw == null ? "" : raw).trim();

                var fn = text.match(/rgba?\(([^)]+)\)/);
                if (fn) {
                    var parts = fn[1].split(/[\s,/]+/);
                    var nums = [];

                    for (var i = 0; i < parts.length; i++) {
                        var v = parseFloat(parts[i]);
                        if (!isNaN(v)) nums.push(v);
                    }

                    if (nums.length >= 3) {
                        return {
                            r: Math.round(nums[0]),
                            g: Math.round(nums[1]),
                            b: Math.round(nums[2]),
                            a: nums.length > 3 ? nums[3] : 1
                        };
                    }
                }

                var hex = text.match(/^#([0-9a-f]+)$/i);
                if (hex) {
                    var digits = hex[1];

                    // #abc / #abcd -> #aabbcc / #aabbccdd
                    if (digits.length === 3 || digits.length === 4) {
                        digits = digits.split("").map(function (c) { return c + c; }).join("");
                    }

                    if (digits.length === 6 || digits.length === 8) {
                        return {
                            r: parseInt(digits.slice(0, 2), 16),
                            g: parseInt(digits.slice(2, 4), 16),
                            b: parseInt(digits.slice(4, 6), 16),
                            a: digits.length === 8 ? parseInt(digits.slice(6, 8), 16) / 255 : 1
                        };
                    }
                }

                return null;
            }

            function tintToCss(c) {
                return c.a >= 1
                    ? "rgb(" + c.r + ", " + c.g + ", " + c.b + ")"
                    : "rgba(" + c.r + ", " + c.g + ", " + c.b + ", " + c.a + ")";
            }

            // ------------------------------------------------------------
            // Versi HEX SOLID dari sebuah warna: komponen RGB dipakai
            // apa adanya, alpha dipaksa menjadi 1 (tidak ada transparansi).
            //
            // Dipakai HANYA untuk state :hover di navbar desktop. Palet
            // section menuliskan --navbar-bg sebagai rgba(..., 0.8) supaya
            // navbar tetap tembus pandang saat tidak di-hover. Kalau warna
            // yang sama dipakai mentah-mentah untuk TEKS hover, teksnya
            // ikut jadi semi-transparan dan bercampur dengan warna di
            // belakangnya — terlihatwashed out. Warna hover teks karena
            // itu ditulis ulang di sini sebagai hex penuh: warnanya
            // (hue/saturation) tidak berubah, hanya opasitasnya jadi 100%.
            //
            // State TIDAK hover tetap memakai rgba(..., 0.8) asli — nilai
            // itu tidak pernah disentuh fungsi ini.
            // ------------------------------------------------------------
            function tintToSolidCss(c) {
                function hex(v) {
                    var s = Math.max(0, Math.min(255, Math.round(v))).toString(16);
                    return s.length < 2 ? "0" + s : s;
                }
                return "#" + hex(c.r) + hex(c.g) + hex(c.b);
            }

            // Salin sebuah warna dengan alpha DIPAKSA menjadi nilai tertentu.
            // Dipakai untuk background hover tombol EN / "Hubungi Saya":
            // palet memberi --navbar-color sebagai hex penuh (mis.
            // #FFE5CF), dan di sini diturunkan ke rgba(..., 0.8) supaya
            // tombol hover ikut semi-transparan seperti navbar di
            // sekitarnya — tidak terlihat lebih "padat" sendiri.
            //
            // RGB tidak diubah sama sekali, jadi warna yang tampil tetap
            // persis sama, hanya opasitasnya 100% -> 80%.
            function capAlpha(c, a) {
                return {
                    r: c.r,
                    g: c.g,
                    b: c.b,
                    a: a
                };
            }

            // ---- Warna teks & warna hover ---------------------------
            //
            // Palet section punya dua warna per section (lihat CSS):
            //   --navbar-bg     -> background navbar (state normal)
            //   --navbar-color  -> warna TEKS navbar, dan juga background
            //                     tombol EN / "Hubungi Saya" saat hover
            //
            // Warna teks memakai nilai --navbar-color apa adanya. Tidak ada
            // lagi luminance/kontras yang memilih putih atau gelap otomatis:
            // palet yang Anda tulis di CSS adalah sumber kebenaran, dan teksnya
            // ikut di-split di garis batas section, persis seperti background-nya.
            var PF_LIGHT = { r: 255, g: 255, b: 255, a: 1 };

            // Baca palet section dari CSS (sumber kebenaran tunggal) sekali
            // saja. Elemen sementara dibuat offscreen supaya getComputedStyle
            // benar-benar me-resolve aturan .navbar[data-pf-section="..."].
            function getSectionTints() {
                if (tintCache) return tintCache;

                tintCache = {};

                var probe = document.createElement("div");
                probe.className = "navbar";
                probe.setAttribute("aria-hidden", "true");
                probe.style.cssText = "position:absolute;left:-99999px;top:0;width:1px;height:1px;" +
                    "pointer-events:none;visibility:hidden;";

                if (document.body) document.body.appendChild(probe);

                for (var i = 0; i < PF_SECTIONS.length; i++) {
                    var key = PF_SECTIONS[i].key;
                    probe.setAttribute("data-pf-section", key);

                    var style = window.getComputedStyle(probe);

                    tintCache[key] = {
                        // Background state normal
                        bg: parseCssColor(style.getPropertyValue("--navbar-bg")) || PF_TINT_FALLBACK,
                        // Background saat hover; kalau section tidak
                        // mendeklarasikannya, tetap pakai putih supaya
                        // pertukaran warnanya tetap terbaca.
                        color: parseCssColor(style.getPropertyValue("--navbar-color")) || PF_LIGHT
                    };
                }

                if (probe.parentNode) probe.parentNode.removeChild(probe);

                return tintCache;
            }

            // Nilai terakhir yang sudah ditulis, supaya tidak setProperty tiap
            // frame hanya untuk menulis nilai yang sama.
            var lastTintA = null;
            var lastTintB = null;

            function resetSplit($nav) {
                var surfaces = getSplitSurfaces();

                for (var i = 0; i < surfaces.length; i++) {
                    surfaces[i].el.style.removeProperty("--pf-split-y");
                }

                $nav[0].style.removeProperty("--pf-tint-a");
                $nav[0].style.removeProperty("--pf-tint-b");
                $nav[0].style.removeProperty("--pf-tint-solid-a");
                $nav[0].style.removeProperty("--pf-tint-solid-b");
                $nav[0].style.removeProperty("--pf-nav-tint-a");
                $nav[0].style.removeProperty("--pf-nav-tint-b");
                $nav[0].style.removeProperty("--pf-nav-hover-bg");
                $nav[0].style.removeProperty("--pf-nav-hover-fg");
                $nav[0].style.removeProperty("--pf-menu-bg");
                $nav[0].style.removeProperty("--pf-menu-color");
                $nav.removeAttr("data-pf-section");

                lastTintA = lastTintB = null;
            }

            // boundaryY = koordinat viewport garis batas section (atau null
            // kalau tidak ada batas di area navbar, mis. a === b).
            function applySplit($nav, aKey, bKey, boundaryY) {
                // aKey/bKey null = halaman tanpa section. Kembalikan saja ke
                // nilai awal CSS (--navbar-bg-default, teal).
                if (!aKey || !bKey) {
                    if (lastTintA === null && lastTintB === null) return;
                    resetSplit($nav);
                    return;
                }

                if (aKey !== lastTintA || bKey !== lastTintB) {
                    var tints = getSectionTints();
                    var entryA = tints[aKey] || FALLBACK_ENTRY;
                    var entryB = tints[bKey] || FALLBACK_ENTRY;

                    // Background state normal = --navbar-bg, dipotong jadi split
                    $nav[0].style.setProperty("--pf-tint-a", tintToCss(entryA.bg));
                    $nav[0].style.setProperty("--pf-tint-b", tintToCss(entryB.bg));

                    // Versi SOLID dari warna background section yang sama
                    // (alpha dipaksa 1, RGB tidak berubah). Dipakai HANYA
                    // oleh state :hover di navbar desktop — lihat
                    // tintToSolidCss() di atas. State normal tetap memakai
                    // --pf-tint-a/b yang masih rgba(..., 0.8).
                    $nav[0].style.setProperty("--pf-tint-solid-a", tintToSolidCss(entryA.bg));
                    $nav[0].style.setProperty("--pf-tint-solid-b", tintToSolidCss(entryB.bg));

                    // Warna TEKS state normal = --navbar-color, juga dipotong
                    // di garis batas yang sama. Dipakai lewat `background-clip:
                    // text`, jadi --pf-split-y di elemen teks ikut dihitung JS.
                    $nav[0].style.setProperty("--pf-nav-tint-a", tintToCss(entryA.color));
                    $nav[0].style.setProperty("--pf-nav-tint-b", tintToCss(entryB.color));

                    // Hover tombol EN & "Hubungi Saya": background ditukar ke
                    // --navbar-color section aktif, teksnya ke --navbar-bg.
                    // Background hover ikut semi-transparan (alpha 0.8)
                    // supaya tombol tidak terlihat lebih "padat" dibanding
                    // navbar di sekitarnya. Teks hover tetap HEX SOLID
                    // (alpha 1) — lihat tintToSolidCss().
                    $nav[0].style.setProperty("--pf-nav-hover-bg", tintToCss(capAlpha(entryB.color, 0.8)));
                    $nav[0].style.setProperty("--pf-nav-hover-fg", tintToSolidCss(entryB.bg));

                    // Menu collapse mobile (overlay full screen saat terbuka):
                    // SATU warna solid, bukan split.
                    //
                    // Memakai entryA, yaitu section yang menutupi PERMUKAAN navbar
                    // (probe 0.5px dari tepi ATAS navbar, sama dengan `upper` di
                    // updateSectionTint). Karena navbar sticky di atas,
                    // pergantiannya terjadi tepat di tepi ATAS tiap section:
                    // scroll 0 masih section 1, begitu lewat 911px (titik atas
                    // section 2) langsung ikut section 2 - bukan di garis tengah.
                    //
                    // --pf-menu-bg untuk background overlay & tombol,
                    // --pf-menu-color untuk ikon + teks di dalamnya.
                    $nav[0].style.setProperty("--pf-menu-bg", tintToCss(entryA.bg));
                    $nav[0].style.setProperty("--pf-menu-color", tintToCss(entryA.color));

                    // Section yang menutupi bagian bawah navbar; dipakai untuk
                    // debugging dan styling tambahan.
                    $nav.attr("data-pf-section", bKey);

                    lastTintA = aKey;
                    lastTintB = bKey;
                }

                // Offset ditulis PER PERMUKAAN. Semua permukaan dihitung dari
                // koordinat viewport yang sama, jadi garis potongnya benar-
                // benar satu garis yang sama dengan batas section — cuma
                // dipotong sesuai kotak masing-masing.
                var surfaces = getSplitSurfaces();

                for (var i = 0; i < surfaces.length; i++) {
                    var el = surfaces[i].el;
                    var rect = surfaces[i].rect;
                    var offset;

                    if (boundaryY === null) {
                        // Tidak ada batas di area navbar -> polos warna a.
                        offset = rect.height;
                    } else {
                        offset = boundaryY - rect.top;

                        if (offset < 0) offset = 0;
                        else if (offset > rect.height) offset = rect.height;
                    }

                    var next = offset.toFixed(2) + "px";

                    // Baca inline style (bukan getComputedStyle) supaya tidak
                    // memaksa style recalc cuma untuk cek "sudah sama belum".
                    if (el.style.getPropertyValue("--pf-split-y") !== next) {
                        el.style.setProperty("--pf-split-y", next);
                    }
                }
            }

            function updateSectionTint($nav) {
                var navH = $nav[0].getBoundingClientRect().height;
                if (!(navH > 0)) return;

                var sections = getTrackedSections();

                if (!sections.length) {
                    applySplit($nav, null, null, null);
                    return;
                }

                // Baris probe: 0.5px dari tepi atas navbar dan 0.5px dari tepi
                // bawahnya. Pakai 0.5 (bukan 0) supaya tidak pernah jatuh
                // persis di tepi section yang kebetulan berada tepat di y=0
                // atau tepat di dasar navbar.
                var topProbe = 0.5;
                var bottomProbe = navH - 0.5;

                var upper = null;
                var lower = null;

                for (var i = 0; i < sections.length; i++) {
                    var rect = sections[i].el.getBoundingClientRect();

                    if (!upper && rect.top <= topProbe && rect.bottom > topProbe) {
                        upper = sections[i];
                    }

                    if (rect.top <= bottomProbe && rect.bottom > bottomProbe) {
                        lower = sections[i];
                    }
                }

                // Navbar sudah keluar dari semua section (mis. sedang berada di
                // area footer): pakai warna section terakhir, polos.
                if (!upper && !lower) {
                    applySplit($nav, sections[sections.length - 1].key, sections[sections.length - 1].key, null);
                    return;
                }

                // Batas ada tapi salah satu sisi tidak tertangkap section mana
                // pun (halaman pendek, atau ada celah di layout): pakai yang
                // ada, navbar jadi polos warna itu.
                if (!upper) {
                    applySplit($nav, lower.key, lower.key, null);
                    return;
                }

                if (!lower || upper === lower) {
                    applySplit($nav, upper.key, upper.key, null);
                    return;
                }

                // Dua section berbeda menutupi navbar: split di garis batas.
                // `top` ini yang dipakai SEMUA permukaan, tanpa perkalian
                // atau pembagian dengan tinggi apapun.
                applySplit($nav, upper.key, lower.key, lower.el.getBoundingClientRect().top);
            }

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

                    // ---------------------------------------------------------
                    // Matikan transisi `color` TANPA SILANG saat user sedang
                    // scroll (dan nyalakan lagi 150ms setelah scroll berhenti).
                    //
                    // Latar: tanda silang (`.sh-btn-circle.d-lg-none`) memakai
                    // `color: var(--pf-menu-color) !important` supaya sinkron
                    // dengan item menu. Nilai itu ditulis JS di
                    // applySplit() setiap kali section berganti - jadi saat
                    // scroll, `color` benar-benar berubah dan AKAN ikut
                    // bertransisi 0.35s kalau transisinya nyala. Akibatnya
                    // warna X "menyusul" section yang sudah berganti, dan
                    // tidak sinkron dengan item menu (item menu tidak punya
                    // transisi color).
                    //
                    // Hover, sebaliknya, HARUS mulus dua arah (masuk dan
                    // keluar) seperti di situs live. Karena color dipakai
                    // oleh dua hal berbeda (hover = halus, scroll = instan)
                    // dan keduanya tidak bisa dibedakan lewat CSS, jadi
                    // pemisahnya dilakukan di sini lewat atribut ini.
                    //
                    // CSS-nya ada di blok `.navbar:not([data-scrolling])`
                    // (lihat public/css/portfolio.css). Atribut ini hanya
                    // dipasang saat scroll benar-benar terjadi, sehingga
                    // hover di luar scroll tetap mulus.
                    // ---------------------------------------------------------
                    var scrolling = window.__pfScrolling === true;
                    if (scrolling) {
                        $nav.attr("data-scrolling", "1");
                    } else {
                        $nav.removeAttr("data-scrolling");
                    }

                    updateSectionTint($nav);
                } catch (e) {
                    if (window.console) console.warn("Navbar scroll-state error:", e);
                }
            }

            // Scroll memunculkan banyak event; cukup satu kali per frame.
            var stateQueued = false;

            // Pendantai scroll: `window.__pfScrolling` dibaca di
            // updateNavbarState() untuk memasang/melepas atribut
            // `data-scrolling` pada .navbar (lihat komentar di sana).
            //
            // selama scroll: flag = true  -> transisi `color` tanda silang
            //   dimatikan, jadi warna section ganti INSTAN dan sinkron
            //   dengan item menu.
            // 150ms setelah scroll berhenti: flag = false -> transisi
            //   `color` dinyalakan lagi, jadi hover masuk/keluar tetap mulus.
            //
            // Jeda 150ms disengaja: transisi hover berlangsung 350ms, jadi
            // nilainya harus kembali normal sebelum user sempat hover lagi.
            var scrollIdleTimer = null;
            var SCROLL_IDLE_MS = 150;

            function markScrolling() {
                window.__pfScrolling = true;

                if (scrollIdleTimer) {
                    clearTimeout(scrollIdleTimer);
                }

                scrollIdleTimer = setTimeout(function () {
                    window.__pfScrolling = false;
                    scrollIdleTimer = null;
                    // Paksa satu pembaruan supaya atribut langsung dilepas.
                    updateNavbarState();
                }, SCROLL_IDLE_MS);
            }

            function queueNavbarState() {
                if (stateQueued) return;
                stateQueued = true;

                var run = function () {
                    stateQueued = false;
                    updateNavbarState();
                };

                if (window.requestAnimationFrame) {
                    window.requestAnimationFrame(run);
                } else {
                    setTimeout(run, 16);
                }
            }

            // Hanya event scroll yang menandai "sedang scroll". Event
            // `resize` sengaja tidak: mengubah ukuran window bukan
            // pergerakan scroll, jadi transisi color harus tetap hidup
            // supaya hover setelah resize tetap mulus.
            $(window).on("scroll", function () {
                markScrolling();
                queueNavbarState();
            });
            $(window).on("resize", queueNavbarState);
            $(document).on("scroll", function () {
                markScrolling();
                queueNavbarState();
            });
            window.__pfScrolling = false;
            updateNavbarState();

            // Cache menyimpan elemen (bukan posisi), jadi tetap valid walau
            // layout berubah. Cukup di-refresh sekali setelah semua gambar
            // selesai dimuat, lalu warnanya dihitung ulang.
            $(window).on("load", refreshSectionCache);
        }

        initNavbar();
    })();
</script>