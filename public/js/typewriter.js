(function ($) {
  "use strict";

  // ------------------------------------------------------------
  // JANGAN menunggu DOMContentLoaded.
  //
  // `$(function(){...})` = satu tick setelah DOMContentLoaded. Tapi
  // DOMContentLoaded sendiri MENUNGGU semua script `defer`, termasuk
  // /js/app.js yang 888 KB. Di koneksi lambat, nama baru mulai diketik
  // 5-8 DETIK setelah halaman dicetak - padahal elemen .typing-name
  // sudah ada jauh sebelum itu.
  //
  // Selama menunggu, <script> inline di home.blade.php menahan nama
  // dengan .typing-name-pending. Kalau jaring pengamannya meledak lebih
  // dulu, nama LENGKAP muncul duluan lalu menyusut jadi satu huruf
  //ketika akhirnya diketik - persis kedip yang mau dihilangkan.
  //
  // Di sini jalan SEKALI JADI begitu script ini dieksekusi (script
  // terakhir di <body>, jadi jQuery dan elemennya sudah siap).
  // Kalau elemennya ternyata belum ada, baru jatuh ke DOMContentLoaded.
  // ------------------------------------------------------------
  function initTypewriters() {
    // 1. ROLE TYPEWRITER (Same timing as jigarsable.netlify.app)
    var $roleElements = $(".typing-role");
    var roles = [
      "Full-stack Web Developer",
      "Game Developer",
      "Frontend Developer",
      "Backend Developer",
      "Software Engineer"
    ];

    $roleElements.each(function () {
      var $el = $(this);
      var roleIndex = 0;
      var charIndex = 0;
      var isDeleting = false;

      var $parent = $el.parent();
      var $cursor = $parent.find(".typed-cursor-role");
      if (!$cursor.length) {
        $cursor = $('<span class="typed-cursor typed-cursor-role">|</span>');
        $el.after($cursor);
      }

      function typeRole() {
        var currentRole = roles[roleIndex];

        if (isDeleting) {
          charIndex--;
          $el.text(currentRole.substring(0, charIndex));
        } else {
          charIndex++;
          $el.text(currentRole.substring(0, charIndex));
        }

        var speed = isDeleting ? 25 : 50;

        if (!isDeleting && charIndex === currentRole.length) {
          speed = 1000;
          isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
          isDeleting = false;
          roleIndex = (roleIndex + 1) % roles.length;
          speed = 500;
        }

        setTimeout(typeRole, speed);
      }

      typeRole();
    });

    // 2. NAME TYPEWRITER WITH 4 FONT ROTATIONS
    var $nameElements = $(".typing-name");
    var fontClasses = ["font-style-poppins", "font-style-space", "font-style-serif", "font-style-fairfax"];

    $nameElements.each(function () {
      var $el = $(this);
      var fullName = $el.attr("data-name") || $.trim($el.text());

      // Tanpa nama sama sekali: jangan asal ketik nama orang lain.
      // Dulu ada fallback hardcode "Ari Eka Putragani" di sini, yang
      // diam-diam menampilkan nama yang salah kalau template lain
      // dipakai tanpa atribut data-name.
      if (!fullName) {
        if (window.console) console.warn("typewriter: .typing-name tanpa data-name dan tanpa teks, dilewati.");
        return;
      }

      var fontCycleIndex = 0;
      var charIndex = 0;
      var isDeleting = false;

      // Lepas penanda "belum siap" yang dipasang <script> inline di
      // home.blade.php. Sampai kelas ini ada, nama disembunyikan pakai
      // visibility:hidden (ruang tetap, jadi tidak ada layout shift) -
      // tanpa itu, nama lengkap yang sudah ter-render server akan
      // terlihat sebentar lalu menyusut jadi satu huruf di bawah.
      $el.removeClass("typing-name-pending");

      $el.addClass(fontClasses[fontCycleIndex]);

      var $parent = $el.parent();
      var $cursor = $parent.find(".typed-cursor-name");
      if (!$cursor.length) {
        $cursor = $('<span class="typed-cursor typed-cursor-name">|</span>');
        $el.after($cursor);
      }

      function typeName() {
        if (isDeleting) {
          charIndex--;
          $el.text(fullName.substring(0, charIndex));
        } else {
          charIndex++;
          $el.text(fullName.substring(0, charIndex));
        }

        var speed = isDeleting ? 25 : 50;

        if (!isDeleting && charIndex === fullName.length) {
          speed = 1200;
          isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
          isDeleting = false;
          $el.removeClass(fontClasses[fontCycleIndex]);
          fontCycleIndex = (fontCycleIndex + 1) % fontClasses.length;
          $el.addClass(fontClasses[fontCycleIndex]);
          speed = 400;
        }

        setTimeout(typeName, speed);
      }

      typeName();
    });
  }

  // Elemen targetnya ada di hero, jauh sebelum script terakhir ini
  // dieksekusi - jadi langsung jalan, tidak perlu menunggu.
  // Fallback ke DOMContentLoaded hanya kalau ternyata belum ada.
  if (document.querySelector(".typing-name, .typing-role")) {
    initTypewriters();
  } else if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initTypewriters);
  } else {
    initTypewriters();
  }
})(jQuery);
