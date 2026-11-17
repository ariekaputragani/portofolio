jQuery(function ($) {
    /* -------------------------------------------------------------
    Matikan transisi tombol hero selama jendela di-resize.

    `.btn-outline-hero` (tombol "Hubungi Saya") warnanya berubah
    saat jendela melewati breakpoint 991.98px, karena media query
    mobile di style.css meng-override variabel warnanya ke
    #231937. Kalau transisi `color` / `border-color` bawaan
    Bootstrap ikut jalan, perubahan itu jadi beranimasi — padahal
    bukan hover, dan durasi 0.15s-nya praktis tak terlihat karena
    layout sedang reflow.

    Atribut `data-resizing` dipasang selama resize benar-benar
    terjadi dan dilepas RESIZE_IDLE_MS (150ms) setelah resize
    berhenti, sehingga transisi kembali hidup dan hover tetap
    mulus dua arah seperti tombol Bootstrap 5 biasa.

    Pasangannya di CSS: `#home .btn-outline-hero[data-resizing]`
    di public/css/style.css.
    ------------------------------------------------------------- --*/
    var $btn = $("#home .btn-outline-hero");
    if (!$btn.length) return;

    var RESIZE_IDLE_MS = 150;
    var idleTimer = null;

    $(window).on("resize", function () {
        $btn.attr("data-resizing", "1");
        clearTimeout(idleTimer);
        idleTimer = setTimeout(function () {
            $btn.removeAttr("data-resizing");
        }, RESIZE_IDLE_MS);
    });
});
