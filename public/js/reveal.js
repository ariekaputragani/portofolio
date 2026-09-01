/* Scroll Reveal — port 1:1 dari resources/js/wow.js projek ../portfolio.
   Memakai kelas .sr-reveal (bukan .wow) supaya WOW.js lama yang masih
   dipakai section "Tech Pipeline" ke bawah tidak bentrok. */
(function () {
    "use strict";

    var REVEAL_ENTER = "sr-reveal-enter";

    var select = function () {
        return Array.prototype.slice.call(document.querySelectorAll(".sr-reveal"));
    };

    var boxes = select();

    var delayOf = function (element) {
        var raw = element.getAttribute("data-wow-delay");
        var seconds = parseFloat(raw);
        return isFinite(seconds) ? seconds * 1000 : 0;
    };

    var applyHidden = function (element) {
        element.style.visibility = "visible";
        element.classList.remove(REVEAL_ENTER);
    };

    var reveal = function (element) {
        element.style.transitionDelay = delayOf(element) + "ms";
        element.classList.add(REVEAL_ENTER);
    };

    var reset = function (element) {
        element.style.transitionDelay = "0ms";
        element.classList.remove(REVEAL_ENTER);
    };

    if ("IntersectionObserver" in window) {
        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        reveal(entry.target);
                    } else {
                        reset(entry.target);
                    }
                });
            },
            { threshold: 0.1 }
        );

        boxes.forEach(function (box) {
            applyHidden(box);
            observer.observe(box);
        });

        if (typeof MutationObserver !== "undefined") {
            var mutationObserver = new MutationObserver(function () {
                select().forEach(function (box) {
                    if (boxes.indexOf(box) !== -1) return;
                    boxes.push(box);
                    applyHidden(box);
                    observer.observe(box);
                });
            });
            mutationObserver.observe(document.body, { childList: true, subtree: true });
        }

        window.addEventListener("beforeunload", function () {
            observer.disconnect();
            if (mutationObserver) mutationObserver.disconnect();
        });
    } else {
        // Fallback browser lama: tampilkan semua tanpa animasi.
        boxes.forEach(function (box) {
            box.style.opacity = "1";
            box.style.transform = "none";
        });
    }
})();
