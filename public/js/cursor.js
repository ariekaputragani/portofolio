(function ($) {
    "use strict";

    function initCursor() {
        var $canvas = $('#custom-cursor-canvas');
        if (!$canvas.length) return;

        var canvas = $canvas[0];
        var $dot = $('#cursor-dot');
        var $ring = $('#cursor-ring');

        // Tinggi layout (sebelum transform scale) tiap permukaan. Dipakai
        // untuk mengubah offset dari koordinat VISUAL ke koordinat
        // ELEMENT — lihat updateSurfaceSplit().
        var DOT_LAYOUT_H = 12;
        var RING_LAYOUT_H = 40;

        var targetX = -100;
        var targetY = -100;
        var ringX = targetX;
        var ringY = targetY;

        // Track Mouse
        $(window).on('mousemove', function (e) {
            targetX = e.clientX;
            targetY = e.clientY;
        });

        // ------------------------------------------------------------
        // SPLIT WARNA DI GARIS BATAS SECTION (POLA TINT-NAVBAR.JS).
        //
        // Mengimplementasikan logika split-y seperti pada tint-navbar.js:
        // warna a (section di atas batas) dipotong tegas terhadap warna b
        // (section di bawah batas) di koordinat garis batas section.
        //
        // Masing-masing dot dan ring menghitung --pf-split-y dari rect
        // visual & hotspot-nya sendiri:
        // - Dot berpusat di (targetX, targetY) yang presisi di ujung pointer.
        // - Ring berpusat di (ringX - 5, ringY - 5) yang trailing inertia.
        // ------------------------------------------------------------
        var PF_SECTIONS = window.PF_SECTIONS;

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

        // Baca palet kursor dari CSS (elemen probe offscreen, sama seperti
        // getSectionTints() di tint-navbar.js). Nilainya string mentah —
        // ditulis apa adanya ke custom property, tidak perlu di-parse.
        function getCursorTints() {
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
                    dotColor: style.getPropertyValue("--dot-color"),
                    dotShadowHover: style.getPropertyValue("--dot-box-shadow-hover"),
                    navbarBg: style.getPropertyValue("--navbar-bg"),
                    navbarColor: style.getPropertyValue("--navbar-color"),
                    ringBorder: style.getPropertyValue("--ring-border"),
                    ringHover: style.getPropertyValue("--ring-hover")
                };
            }

            $probe.remove();

            return tintCache;
        }

        // Key warna yang terakhir ditulis, supaya custom property tidak
        // ditulis ulang tiap frame kalau pasangan section belum berganti.
        // curKey ikut di-cache karena warna shadow dot bergantung padanya.
        var lastDotA = null;
        var lastDotB = null;
        var lastDotCur = null;
        var lastRingA = null;
        var lastRingB = null;

        function writeDotColors(tints, aKey, bKey, curKey) {
            if (aKey === lastDotA && bKey === lastDotB && curKey === lastDotCur) return;

            var a = tints[aKey];
            var b = tints[bKey];
            var cur = tints[curKey] || b;
            if (!a || !b) return;

            var s = $dot[0].style;
            s.setProperty("--pf-dot-a", a.dotColor);
            s.setProperty("--pf-dot-b", b.dotColor);
            s.setProperty("--pf-dot-hover-a", a.navbarColor);
            s.setProperty("--pf-dot-hover-b", b.navbarColor);

            // Shadow / glow dot ikut di-split di garis batas section (aKey & bKey)
            // persis seperti background dot, sehingga bayangan ikut terbelah tegas:
            s.setProperty("--pf-dot-shadow-a", a.navbarBg || a.dotColor);
            s.setProperty("--pf-dot-shadow-b", b.navbarBg || b.dotColor);
            s.setProperty("--pf-dot-shadow-hover-a", a.dotShadowHover || a.navbarColor);
            s.setProperty("--pf-dot-shadow-hover-b", b.dotShadowHover || b.navbarColor);

            s.setProperty("--navbar-bg", cur.navbarBg);
            s.setProperty("--dot-box-shadow-hover", cur.dotShadowHover);

            lastDotA = aKey;
            lastDotB = bKey;
            lastDotCur = curKey;
        }

        function writeRingColors(tints, aKey, bKey) {
            if (aKey === lastRingA && bKey === lastRingB) return;

            var a = tints[aKey];
            var b = tints[bKey];
            if (!a || !b) return;

            var s = $ring[0].style;
            s.setProperty("--pf-ring-a", a.ringBorder);
            s.setProperty("--pf-ring-b", b.ringBorder);
            s.setProperty("--pf-ring-hover-a", a.ringHover);
            s.setProperty("--pf-ring-hover-b", b.ringHover);

            lastRingA = aKey;
            lastRingB = bKey;
        }

        // ------------------------------------------------------------
        // Update split satu permukaan kursor (dot ATAU ring).
        //
        // Menerapkan pola split-y dari tint-navbar.js secara dinamis
        // sesuai koordinat visual dan posisi hotspot masing-masing:
        //
        // - Dot membaca rect dan hotspot-nya sendiri (targetX, targetY).
        // - Ring membaca rect dan hotspot-nya sendiri (ringX - 5, ringY - 5).
        //
        // Garis batas antar section dideteksi via topProbe & bottomProbe.
        // Jika permukaan sedang memotong batas:
        //     offset = (boundaryY - visual.top) / scale;
        //     --pf-split-y = offset px (warna terbagi tegas di garis batas)
        // Jika permukaan berada di dalam satu section utuh:
        //     --pf-split-y = layoutH px (warna solid section tersebut)
        // ------------------------------------------------------------
        function updateSurfaceSplit(surface, layoutH, isDot) {
            var sections = getTrackedSections();
            if (!sections.length) return;

            var visual = surface[0].getBoundingClientRect();
            if (!(visual.height > 0)) return;

            var scale = visual.height / layoutH;
            if (!(scale > 0)) return;

            var centerY = visual.top + visual.height / 2;

            var topProbe = visual.top + 0.5;
            var bottomProbe = visual.bottom - 0.5;

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

            if (!upper && !lower) {
                var firstSecTop = sections[0].el.getBoundingClientRect().top;
                var edgeKey = (centerY < firstSecTop) ? sections[0].key : sections[sections.length - 1].key;
                upper = { key: edgeKey };
                lower = { key: edgeKey };
            } else if (!upper) {
                upper = lower;
            } else if (!lower) {
                lower = upper;
            }

            var aKey, bKey, curKey;
            var offset;

            if (upper.key === lower.key) {
                // Berada utuh dalam satu section: warna solid section tersebut
                aKey = upper.key;
                bKey = upper.key;
                curKey = upper.key;
                offset = layoutH;
            } else {
                // Memotong garis batas section: split tajam sesuai garis
                var boundaryY = lower.el.getBoundingClientRect().top;
                aKey = upper.key;
                bKey = lower.key;
                curKey = (centerY < boundaryY) ? upper.key : lower.key;

                offset = (boundaryY - visual.top) / scale;
                if (offset < 0) offset = 0;
                else if (offset > layoutH) offset = layoutH;
            }

            var splitY = offset.toFixed(2) + "px";

            var tints = getCursorTints();
            if (isDot) {
                writeDotColors(tints, aKey, bKey, curKey);
            } else {
                writeRingColors(tints, aKey, bKey);
            }

            var st = surface[0].style;
            if (st.getPropertyValue("--pf-split-y") !== splitY) {
                st.setProperty("--pf-split-y", splitY);
            }
        }

        // Hover Reactions on Interactive Elements (jQuery Event Delegation)
        var interactiveSelectors = 'a, button, .btn, [role="button"], .nav-link, .page-link, .project-card, .service-card, .hero-card-frame, .pf-sins-card, .pf-journey-card, .badge, .owl-prev, .owl-next, .cd-vertical-nav a, [data-cursor="hover"]';

        $(document).on('mouseover', interactiveSelectors, function () {
            $canvas.addClass('hover');
        });

        $(document).on('mouseout', interactiveSelectors, function () {
            $canvas.removeClass('hover');
        });

        // 4. Main Render Loop (Canvas Glow + Follower Physics)
        function render() {
            // Follower Ring Smooth Trailing Inertia
            ringX += (targetX - ringX) * 0.18;
            ringY += (targetY - ringY) * 0.18;

            $dot.css({
                left: targetX,
                top: targetY
            });

            $ring.css({
                left: ringX,
                top: ringY
            });

            // Field blend dihitung SETELAH posisi ditulis, supaya rect
            // yang dibaca sudah memasukkan posisi frame ini (satu kali
            // layout recalc per frame, tidak bolak-balik).
            updateSurfaceSplit($dot, DOT_LAYOUT_H, true);
            updateSurfaceSplit($ring, RING_LAYOUT_H, false);

            requestAnimationFrame(render);
        }

        render();

        // Cache menyimpan elemen, jadi tetap valid walau layout berubah.
        // Refresh setelah gambar selesai dimuat (tinggi section berubah) —
        // pola yang sama dengan refreshSectionCache() di tint-navbar.js.
        $(window).on("load", function () {
            sectionCache = null;
            tintCache = null;
        });
    }

    // Initialize when DOM is ready via jQuery
    $(initCursor);
})(jQuery);
