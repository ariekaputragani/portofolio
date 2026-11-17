(function ($) {
    "use strict";

    function initNavbar() {

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
        // public/css/style.css sebagai
        // .navbar[data-pf-section="..."] { --navbar-bg: ... } lalu dibaca
        // sekali saat init lewat elemen sementara.
        //
        // Selector section sengaja hanya "section.pf-fixed-background"
        // supaya halaman lain yang pakai <div class="pf-fixed-background">
        // (proyek, kontak, tentang, berita, ...) tidak ikut dan navbar
        // tetap memakai --navbar-bg-default (teal) seperti sebelumnya.
        // ------------------------------------------------------------
        var PF_SECTIONS = window.PF_SECTIONS;

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
                surfaceCache = $(
                    ".sh-nav-capsule, .sh-btn-circle, .sh-btn-contact, #mainNavbar, " +
                    ".sh-nav-item, " +
                    ".sh-nav-item > span, .sh-nav-item > i, .lang-label, " +
                    "#lang-toggle .sh-nav-icon, .sh-btn-contact > span, " +
                    ".sh-btn-contact > i, .sh-hamburger-line"
                ).get();
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
            $("section.pf-fixed-background").each(function () {
                var node = this;
                var $node = $(this);
                for (var i = 0; i < PF_SECTIONS.length; i++) {
                    var s = PF_SECTIONS[i];
                    var isMatch = (s.id && node.id === s.id) || (s.cls && $node.hasClass(s.cls));
                    if (isMatch) {
                        sectionCache.push({ el: node, key: s.key });
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
            vnavCache = null;
            vnavState = null;
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

        // ---- Warna teks & warna navbar ---------------------------
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

        // Baca palet section dari CSS (sumber kebenaran tunggal) sekali
        // saja. Elemen sementara dibuat offscreen supaya getComputedStyle
        // benar-benar me-resolve aturan .navbar[data-pf-section="..."].
        function getSectionTints() {
            if (tintCache) return tintCache;

            tintCache = {};

            var $probe = $('<div class="navbar" aria-hidden="true"></div>').css({
                position: "absolute",
                left: "-99999px",
                top: "0",
                width: "1px",
                height: "1px",
                pointerEvents: "none",
                visibility: "hidden"
            }).appendTo("body");

            for (var i = 0; i < PF_SECTIONS.length; i++) {
                var key = PF_SECTIONS[i].key;
                $probe.attr("data-pf-section", key);

                var style = window.getComputedStyle($probe[0]);

                tintCache[key] = {
                    bg: parseCssColor(style.getPropertyValue("--navbar-bg")),
                    color: parseCssColor(style.getPropertyValue("--navbar-color"))
                };
            }

            $probe.remove();

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

            // Vertical nav ikut dibersihkan bila halaman kehilangan
            // section, supaya tombolnya kembali ke default CSS.
            var vlinks = getVerticalNavLinks();

            for (var j = 0; j < vlinks.length; j++) {
                vlinks[j].style.removeProperty("--pf-split-y");
                vlinks[j].style.removeProperty("--pf-tint-a");
                vlinks[j].style.removeProperty("--pf-tint-b");
                vlinks[j].style.removeProperty("--pf-nav-tint-a");
                vlinks[j].style.removeProperty("--pf-nav-tint-b");
            }

            vnavState = null;

            $nav[0].style.removeProperty("--pf-tint-a");
            $nav[0].style.removeProperty("--pf-tint-b");
            $nav[0].style.removeProperty("--pf-nav-tint-a");
            $nav[0].style.removeProperty("--pf-nav-tint-b");
            $nav[0].style.removeProperty("--pf-menu-bg");
            $nav[0].style.removeProperty("--pf-menu-color");
            $nav.removeAttr("data-pf-section");
            $("body").removeAttr("data-pf-section");

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
                var entryA = tints[aKey];
                var entryB = tints[bKey];
                if (!entryA || !entryB) return;

                // Background state normal = --navbar-bg, dipotong jadi split
                $nav[0].style.setProperty("--pf-tint-a", tintToCss(entryA.bg));
                $nav[0].style.setProperty("--pf-tint-b", tintToCss(entryB.bg));

                // Warna TEKS state normal = --navbar-color, juga dipotong
                // di garis batas yang sama. Dipakai lewat `background-clip:
                // text`, jadi --pf-split-y di elemen teks ikut dihitung JS.
                $nav[0].style.setProperty("--pf-nav-tint-a", tintToCss(entryA.color));
                $nav[0].style.setProperty("--pf-nav-tint-b", tintToCss(entryB.color));

                // Menu collapse mobile (overlay full screen saat terbuka):
                // SATU gaya warna solid konsisten mengikuti section home (hero),
                // tidak berganti warna antar section agar pengalaman pengguna stabil.
                //
                // --pf-menu-bg untuk background overlay & tombol,
                // --pf-menu-color untuk ikon + teks di dalamnya.
                var homeTint = tints["hero"] || entryA;
                $nav[0].style.setProperty("--pf-menu-bg", tintToCss(homeTint.bg));
                $nav[0].style.setProperty("--pf-menu-color", tintToCss(homeTint.color));

                // Section yang menutupi bagian bawah navbar; dipakai untuk
                // debugging dan styling tambahan.
                $nav.attr("data-pf-section", bKey);
                $("body").attr("data-pf-section", bKey);

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
            // getBoundingClientRect (bukan outerHeight): nilai float presisi
            // dari viewport, tidak dibulatkan dan tidak terpengaruh
            // margins/sub-pixel scaling — penting supaya garis split
            // benar-benar segaris dengan batas section.
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

        // ------------------------------------------------------------
        // Vertical nav (panah prev/next .cd-vertical-nav) ikut sistem
        // split yang SAMA dengan navbar: background --pf-nav-split-bg dan
        // ikon dengan background-clip:text, dipotong di garis batas
        // section — TAPI garisnya bukan milik navbar. Tombol ini menetap
        // di tengah viewport, jadi yang memotongnya adalah batas antar
        // section yang sedang MELEWATI tombol saat scroll. Offset-nya
        // dihitung per tombol (dan per ikon) tiap frame, sehingga garis
        // potong MENYAPU tombol sedikit demi sedikit — bukan terpotong
        // 100% sekaligus seperti transisi split di card.
        //
        // Pasangan warna a/b TIDAK bisa diambil dari atribut
        // data-pf-section di <body> (itu cuma SATU pasangan milik navbar;
        // dua tombol bisa berada di dua section berbeda sekaligus saat
        // garis batas berada di celah di antara keduanya). Karena itu
        // pasangan ditulis JS per tombol, memakai palet yang sama dengan
        // navbar (getSectionTints). Default CSS-nya menunjuk
        // var(--navbar-bg) / var(--navbar-color) seperti di .navbar —
        // body sudah punya atribut itu sejak server-side, jadi frame
        // pertama tidak kedip sebelum JS menimpanya.
        // ------------------------------------------------------------
        var vnavCache = null;
        var vnavState = null;

        function getVerticalNavLinks() {
            if (!vnavCache) vnavCache = $(".cd-vertical-nav a").get();
            return vnavCache;
        }

        // Menulis satu nilai --pf-split-y untuk satu permukaan (tombol
        // ATAU ikonnya), di-clamp ke tinggi kotaknya. Pola yang sama
        // dengan loop permukaan di applySplit().
        function writeVnavSplit(el, rect, boundaryY) {
            var offset = (boundaryY === null)
                ? rect.height
                : boundaryY - rect.top;

            if (offset < 0) offset = 0;
            else if (offset > rect.height) offset = rect.height;

            var next = offset.toFixed(2) + "px";

            // Baca inline style (bukan getComputedStyle) supaya tidak
            // memaksa style recalc cuma untuk cek "sudah sama belum".
            if (el.style.getPropertyValue("--pf-split-y") !== next) {
                el.style.setProperty("--pf-split-y", next);
            }
        }

        function updateVerticalNavTint() {
            var links = getVerticalNavLinks();
            if (!links.length) return;

            var sections = getTrackedSections();

            // Halaman tanpa section: biarkan default CSS, tidak ada yang
            // dipotong (resetSplit yang membersihkan bila sebelumnya
            // sempat ditulis).
            if (!sections.length) return;

            if (!vnavState || vnavState.length !== links.length) {
                vnavState = [];
                for (var k = 0; k < links.length; k++) vnavState.push(null);
            }

            var tints = getSectionTints();

            for (var i = 0; i < links.length; i++) {
                var link = links[i];
                var linkRect = link.getBoundingClientRect();

                if (linkRect.width <= 0 || linkRect.height <= 0) continue;

                // Probe di dalam tepi atas & bawah tombol — logika yang
                // sama dengan updateSectionTint().
                var topProbe = linkRect.top + 0.5;
                var bottomProbe = linkRect.bottom - 0.5;

                var upper = null;
                var lower = null;

                for (var j = 0; j < sections.length; j++) {
                    var rect = sections[j].el.getBoundingClientRect();

                    if (!upper && rect.top <= topProbe && rect.bottom > topProbe) {
                        upper = sections[j];
                    }

                    if (rect.top <= bottomProbe && rect.bottom > bottomProbe) {
                        lower = sections[j];
                    }
                }

                // Tombol di luar semua section (area footer) -> polos
                // warna section terakhir, sama seperti aturan navbar.
                if (!upper && !lower) {
                    upper = lower = sections[sections.length - 1];
                } else if (!upper) {
                    upper = lower;
                } else if (!lower) {
                    lower = upper;
                }

                var aKey = upper.key;
                var bKey = lower.key;
                var last = vnavState[i];

                // Pasangan warna hanya ditulis saat ganti section; garis
                // potongnya di bawah yang diperbarui tiap frame.
                if (!last || last.a !== aKey || last.b !== bKey) {
                    var entryA = tints[aKey];
                    var entryB = tints[bKey];
                    if (!entryA || !entryB) continue;

                    link.style.setProperty("--pf-tint-a", tintToCss(entryA.bg));
                    link.style.setProperty("--pf-tint-b", tintToCss(entryB.bg));
                    link.style.setProperty("--pf-nav-tint-a", tintToCss(entryA.color));
                    link.style.setProperty("--pf-nav-tint-b", tintToCss(entryB.color));

                    vnavState[i] = { a: aKey, b: bKey };
                }

                var boundaryY = (upper === lower)
                    ? null
                    : lower.el.getBoundingClientRect().top;

                writeVnavSplit(link, linkRect, boundaryY);

                // Ikon FA di dalam tombol memakai gradient sendiri
                // (background-clip:text di CSS), jadi --pf-split-y-nya
                // WAJIB milik ikon: kotaknya beda dari kotak tombol,
                // padahal garis potongnya harus satu garis yang sama.
                // Sama alasan dengan teks navbar yang dihitung per glif.
                var icon = link.firstElementChild;
                if (icon && icon.tagName === "I") {
                    writeVnavSplit(icon, icon.getBoundingClientRect(), boundaryY);
                }
            }
        }

        function updateNavbarState() {
            try {
                var $nav = $(".navbar");
                if (!$nav.length) return;

                var scrolled = $(window).scrollTop() > $nav.outerHeight();

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
                // (lihat public/css/style.css). Atribut ini hanya
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

                // Panah vertical nav dihitung dengan sinyal scroll yang
                // sama (rAF-throttled), supaya sapuan garis potongnya
                // sinkron frame-demi-frame dengan navbar.
                updateVerticalNavTint();
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

    $(function () {
        initNavbar();
    });
})(jQuery);