(function ($) {
  "use strict";

  $(function () {
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

    // 2. NAME TYPEWRITER WITH 3 FONT ROTATIONS
    var $nameElements = $(".typing-name");
    var fontClasses = ["font-style-poppins", "font-style-space", "font-style-serif"];

    $nameElements.each(function () {
      var $el = $(this);
      var fullName = $el.attr("data-name") || $.trim($el.text()) || "Ari Eka Putragani";
      var fontCycleIndex = 0;
      var charIndex = 0;
      var isDeleting = false;

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
  });
})(jQuery);
