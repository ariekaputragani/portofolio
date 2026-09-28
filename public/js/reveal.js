/* Scroll Reveal (jQuery) — port 1:1 dari resources/js/wow.js projek ../portfolio. */
(function ($) {
    "use strict";

    var REVEAL_ENTER = "sr-reveal-enter";

    function delayOf($el) {
        var raw = $el.attr("data-wow-delay");
        var seconds = parseFloat(raw);
        return isFinite(seconds) ? seconds * 1000 : 0;
    }

    function applyHidden($el) {
        $el.css("visibility", "visible").removeClass(REVEAL_ENTER);
    }

    function reveal($el) {
        $el.css("transitionDelay", delayOf($el) + "ms").addClass(REVEAL_ENTER);
    }

    function reset($el) {
        $el.css("transitionDelay", "0ms").removeClass(REVEAL_ENTER);
    }

    $(function () {
        var $boxes = $(".sr-reveal");

        if ("IntersectionObserver" in window) {
            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        var $target = $(entry.target);
                        if (entry.isIntersecting) {
                            reveal($target);
                        } else {
                            reset($target);
                        }
                    });
                },
                { threshold: 0.1 }
            );

            $boxes.each(function () {
                var $box = $(this);
                applyHidden($box);
                observer.observe(this);
            });

            if (typeof MutationObserver !== "undefined") {
                var mutationObserver = new MutationObserver(function () {
                    $(".sr-reveal").each(function () {
                        var boxEl = this;
                        var alreadyAdded = false;
                        $boxes.each(function () {
                            if (this === boxEl) {
                                alreadyAdded = true;
                                return false;
                            }
                        });
                        if (!alreadyAdded) {
                            $boxes = $boxes.add(boxEl);
                            applyHidden($(boxEl));
                            observer.observe(boxEl);
                        }
                    });
                });
                mutationObserver.observe(document.body, { childList: true, subtree: true });
            }

            $(window).on("beforeunload", function () {
                observer.disconnect();
                if (typeof mutationObserver !== "undefined") mutationObserver.disconnect();
            });
        } else {
            $boxes.css({ opacity: "1", transform: "none" });
        }
    });
})(jQuery);
