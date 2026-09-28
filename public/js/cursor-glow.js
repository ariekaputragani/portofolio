(function ($) {
  "use strict";

  function initCursorGlow() {
    if ($('#cursor-glow-canvas').length) return;

    var $canvas = $('<canvas>', {
      id: 'cursor-glow-canvas',
      'aria-hidden': 'true'
    }).css({
      position: 'fixed',
      top: 0,
      left: 0,
      width: '100vw',
      height: '100vh',
      zIndex: 0,
      pointerEvents: 'none'
    });

    $('body').prepend($canvas);
    var canvas = $canvas[0];

    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var frame = 0;
    var targetX = $(window).width() / 2;
    var targetY = $(window).height() / 2;
    var currentX = targetX;
    var currentY = targetY;
    var trail = [];

    var baseOrbs = [
      [246, 80],
      [263, 84],
      [192, 88],
      [328, 78],
      [168, 76],
      [280, 82]
    ];
    var frequencies = [
      [23e-5, 31e-5],
      [19e-5, 28e-5],
      [34e-5, 22e-5],
      [27e-5, 18e-5],
      [16e-5, 25e-5],
      [31e-5, 17e-5]
    ];

    function createParticles() {
      return Array.from({ length: 70 }, function () {
        return {
          x: Math.random() * canvas.width,
          y: Math.random() * canvas.height,
          r: 0.3 + 1.2 * Math.random(),
          phase: Math.random() * Math.PI * 2,
          speed: 0.006 + 0.018 * Math.random()
        };
      });
    }

    function createOrbs() {
      return Array.from({ length: 6 }, function (_, i) {
        var hueBase = baseOrbs[i][0];
        var sat = baseOrbs[i][1];
        var freqX = frequencies[i][0];
        var freqY = frequencies[i][1];

        return {
          cx: 0.12 * canvas.width + 0.76 * Math.random() * canvas.width,
          cy: 0.12 * canvas.height + 0.76 * Math.random() * canvas.height,
          rx: 0.1 * canvas.width + 0.2 * Math.random() * canvas.width,
          ry: 0.1 * canvas.height + 0.16 * Math.random() * canvas.height,
          freqX: freqX,
          freqY: freqY,
          phaseX: Math.random() * Math.PI * 2,
          phaseY: Math.random() * Math.PI * 2,
          x: 0,
          y: 0,
          visualR: Math.max(canvas.width, canvas.height) * (0.3 + 0.25 * Math.random()),
          hueBase: hueBase,
          sat: sat,
          alphaPhase: Math.random() * Math.PI * 2,
          alphaSpeed: 0.003 + 0.005 * Math.random()
        };
      });
    }

    var particles = createParticles();
    var orbs = createOrbs();

    function resize() {
      canvas.width = $(window).width();
      canvas.height = $(window).height();
      particles = createParticles();
      orbs = createOrbs();
    }
    resize();
    $(window).on('resize', resize);

    $(window).on('mousemove', function (e) {
      targetX = e.clientX;
      targetY = e.clientY;
    });

    function render() {
      frame++;
      currentX += (targetX - currentX) * 0.065;
      currentY += (targetY - currentY) * 0.065;

      trail.push({ x: currentX, y: currentY });
      if (trail.length > 25) trail.shift();

      var width = canvas.width;
      var height = canvas.height;
      var maxDim = Math.max(width, height);

      ctx.clearRect(0, 0, width, height);

      // 1. Star Dust Particles
      particles.forEach(function (p) {
        var t = (Math.sin(frame * p.speed + p.phase) + 1) / 2;
        var alpha = 0.3 * t;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, 2 * Math.PI);
        ctx.fillStyle = 'rgba(196, 181, 253, ' + alpha + ')';
        ctx.fill();
      });

      // 2. Animated Floating Orbs
      orbs.forEach(function (orb) {
        var offsetX = Math.sin(0.0071 * frame + 3.7 * orb.phaseX) * orb.rx * 0.12;
        var offsetY = Math.cos(0.0053 * frame + 2.3 * orb.phaseY) * orb.ry * 0.12;
        orb.x = orb.cx + Math.sin(frame * orb.freqX + orb.phaseX) * orb.rx + offsetX;
        orb.y = orb.cy + Math.cos(frame * orb.freqY + orb.phaseY) * orb.ry + offsetY;

        var hue = orb.hueBase + 18 * Math.sin(0.0011 * frame + orb.phaseX);
        var alphaFactor = (Math.sin(frame * orb.alphaSpeed + orb.alphaPhase) + 1) / 2;
        var alpha = 0.03 + 0.05 * alphaFactor;
        var h = 70;
        var m = 60;
        var u = 50;

        var grad = ctx.createRadialGradient(orb.x, orb.y, 0, orb.x, orb.y, orb.visualR);
        grad.addColorStop(0, 'hsla(' + hue + ', ' + orb.sat + '%, ' + h + '%, ' + alpha + ')');
        grad.addColorStop(0.25, 'hsla(' + (hue + 10) + ', ' + orb.sat + '%, ' + h + '%, ' + (0.75 * alpha) + ')');
        grad.addColorStop(0.5, 'hsla(' + (hue + 22) + ', ' + orb.sat + '%, ' + m + '%, ' + (0.42 * alpha) + ')');
        grad.addColorStop(0.78, 'hsla(' + (hue + 38) + ', ' + (orb.sat - 6) + '%, ' + u + '%, ' + (0.12 * alpha) + ')');
        grad.addColorStop(1, 'hsla(' + hue + ', ' + orb.sat + '%, ' + u + '%, 0)');

        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, width, height);
      });

      // 3. Motion Trail
      if (trail.length > 1) {
        trail.forEach(function (pt, idx) {
          var ratio = idx / (trail.length - 1);
          var cubicRatio = ratio * ratio * ratio;
          var alpha = 0.14 * cubicRatio;
          ctx.beginPath();
          ctx.arc(pt.x, pt.y, 0.5 + 3.5 * cubicRatio, 0, 2 * Math.PI);
          var hue = 252 + 15 * ratio;
          var lightness = 74;
          ctx.fillStyle = 'hsla(' + hue + ', 85%, ' + lightness + '%, ' + alpha + ')';
          ctx.fill();
        });
      }

      // 4. Cursor Follow Glow Radial Gradient
      var cursorGrad = ctx.createRadialGradient(currentX, currentY, 0, currentX, currentY, 0.38 * maxDim);
      cursorGrad.addColorStop(0, 'rgba(216, 180, 254, 0.18)');
      cursorGrad.addColorStop(0.035, 'rgba(196, 163, 253, 0.14)');
      cursorGrad.addColorStop(0.08, 'rgba(167, 139, 250, 0.10)');
      cursorGrad.addColorStop(0.16, 'rgba(139, 112, 246, 0.07)');
      cursorGrad.addColorStop(0.28, 'rgba(120, 100, 241, 0.045)');
      cursorGrad.addColorStop(0.43, 'rgba(99, 102, 241, 0.025)');
      cursorGrad.addColorStop(0.65, 'rgba(99, 102, 241, 0.008)');
      cursorGrad.addColorStop(1, 'rgba(99, 102, 241, 0)');

      ctx.fillStyle = cursorGrad;
      ctx.fillRect(0, 0, width, height);

      requestAnimationFrame(render);
    }

    render();
  }

  $(initCursorGlow);
})(jQuery);
