(function ($) {

  "use strict";

  $('.owl-carousel').owlCarousel({
    animateOut: 'fadeOut',
    items: 1,
    loop: true,
    autoplay: true,
  })

  // PARALLAX EFFECT
  $.stellar();

  $(function () {
    $('html, body').css('scroll-behavior', 'auto');

    // getNavbarShrink() kini disediakan navbar-shrink.js (sumber tunggal,
    // dipakai juga oleh vertical-nav.js).

    function scrollToTarget($target, duration) {
      if (!$target || !$target.length) return;

      var $section = $target.is('section') ? $target : $target.closest('section');
      var $scrollTarget = $section.length ? $section : $target;
      var targetTop = $scrollTarget.offset().top;

      // Kompensasi perubahan tinggi navbar dari state atas ke scrolled di desktop
      targetTop -= getNavbarShrink();

      // Khusus target '#top' dan '#home' langsung menuju 0
      if ($target.is('#top, #home') || targetTop < 0) {
        targetTop = 0;
      }

      $('html, body').stop().animate({
        scrollTop: targetTop
      }, typeof duration === 'number' ? duration : 1000);
    }

    // Navigasi cross-page (misal dari /blog ke target section di home) persis seperti news-detail.html ke index.html di 2098_health
    function alignHash() {
      var hash = window.location.hash;
      if (!hash || hash === '#' || hash === '#0') return;
      try {
        var $target = $(hash);
        if ($target.length) {
          var $section = $target.is('section') ? $target : $target.closest('section');
          var $scrollTarget = $section.length ? $section : $target;
          var targetTop = $scrollTarget.offset().top - getNavbarShrink();
          if ($target.is('#top, #home') || targetTop < 0) {
            targetTop = 0;
          }
          $(window).scrollTop(targetTop);
        }
      } catch (e) { }
    }

    if (window.location.hash) {
      alignHash();
      $(window).on('load', function () {
        setTimeout(alignHash, 50);
      });
      // Antisipasi setelah native anchor scroll browser selesai
      setTimeout(alignHash, 150);
      setTimeout(alignHash, 300);
    }

    // Smooth scroll for in-page anchor clicks
    $('nav a, #home a').on('click', function (e) {
      var $anchor = $(this);
      var href = $anchor.attr('href') || '';
      var hash = this.hash || (href.indexOf('#') !== -1 ? href.substring(href.indexOf('#')) : '');

      // Hanya samapage jika ada target hash dan elemennya ada di halaman ini
      var isSamePage = Boolean(hash && $(hash).length);

      if (isSamePage) {
        e.preventDefault();
        e.stopImmediatePropagation();
        scrollToTarget($(hash), 1000);
      }
    });

    $(window).on('hashchange', function () {
      var hash = window.location.hash;
      if (!hash || hash === '#' || hash === '#0') return;
      try {
        var $target = $(hash);
        if ($target.length) {
          scrollToTarget($target, 1000);
        }
      } catch (e) {
        // ignore invalid selectors
      }
    });
  });

  // WOW ANIMATION
  new WOW({ mobile: false }).init();

})(jQuery);
