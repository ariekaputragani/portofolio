(function ($) {
    "use strict";

    var script = document.currentScript;
    var el = script && script.previousElementSibling;
    if (!el) return;

    var $el = $(el);
    if (!$el.hasClass("typing-name")) return;

    $el.addClass("typing-name-pending");

    // Jaring pengaman: kalau typewriter.js gagal dimuat,
    // jangan sampai nama hilang permanen.
    setTimeout(function () {
        $el.removeClass("typing-name-pending");
    }, 3000);
})(jQuery);
