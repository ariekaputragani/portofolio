(function ($) {
    "use strict";

    // getNavbarShrink(): hitung selisih tinggi navbar saat masih di state
    // awal (gede, 4.5rem) vs state scrolled (58px) di desktop. Hasilnya
    // dipakai sebagai kompensasi offset saat smooth scroll ke section,
    // karena navbar menyusut setelah target discroll ke atas.
    //
    // File ini sengaja dipisah supaya jadi sumber tunggal: fungsinya yang
    // sama dipakai custom.js (smooth scroll link/hash) dan vertical-nav.js
    // (panah prev/next). Load WAJIB sebelum keduanya (lihat urutan script
    // di resources/views/components/app-layout.blade.php).
    //
    // Catatan: angka 58 adalah tinggi navbar scrolled PADA ROOT FONT 16px.
    // Cek navbar-scrolled di bawah membuat nilai ini tidak pernah dipakai
    // di state scrolled, jadi aman untuk font-size root selain 16px.
    window.getNavbarShrink = function () {
        var $nav = $('.navbar');
        if (!$nav.length || $nav.hasClass('navbar-scrolled')) return 0;
        var currentHeight = $nav.outerHeight();
        var minHeight = $(window).width() >= 992 ? 58 : currentHeight;
        return Math.max(0, currentHeight - minHeight);
    };
})(jQuery);
