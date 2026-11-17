jQuery(document).ready(function ($) {
	var animating = false;

	//update arrows visibility and detect which section is visible in the viewport
	setSlider();
	$(window).on('scroll resize', function () {
		(!window.requestAnimationFrame) ? setSlider() : window.requestAnimationFrame(setSlider);
	});

	//move to next/previous section clicking on arrows
	$('.cd-vertical-nav .cd-prev').on('click', function (e) {
		e.preventDefault();
		prevSection();
	});
	$('.cd-vertical-nav .cd-next').on('click', function (e) {
		e.preventDefault();
		nextSection();
	});

	//move to next/previous using the keyboards
	$(document).keydown(function (e) {
		if (e.which == '38') {
			prevSection();
			e.preventDefault();
		} else if (e.which == '40') {
			nextSection();
			e.preventDefault();
		}
	});

	//getNavbarShrink() kini disediakan navbar-shrink.js (sumber tunggal,
	//dipakai juga oleh custom.js)

	function getTargetTop(target) {
		if (!target || !target.length) return 0;
		if (target.is('#home, #top') || target.index('[data-type="slider-item"]') === 0) {
			return 0;
		}
		var targetTop = target.offset().top - getNavbarShrink();
		return Math.max(0, Math.round(targetTop));
	}

	//go to next section
	function nextSection() {
		if (!animating) {
			if ($('.is-visible[data-type="slider-item"]').next().length > 0) smoothScroll($('.is-visible[data-type="slider-item"]').next());
		}
	}

	//go to previous section
	function prevSection() {
		if (!animating) {
			var prevSection = $('.is-visible[data-type="slider-item"]').first();
			if (prevSection.length > 0 && Math.abs($(window).scrollTop() - getTargetTop(prevSection))) {
				smoothScroll(prevSection);
			} else if (prevSection.prev().length > 0) {
				smoothScroll(prevSection.prev('[data-type="slider-item"]'));
			}
		}
	}

	function setSlider() {
		checkNavigation();
		checkVisibleSection();
	}

	//update the visibility of the navigation arrows
	function checkNavigation() {
		($(window).scrollTop() < $(window).height() / 2) ? $('.cd-vertical-nav .cd-prev').addClass('inactive') : $('.cd-vertical-nav .cd-prev').removeClass('inactive');
		($(window).scrollTop() > $(document).height() - 3 * $(window).height() / 2) ? $('.cd-vertical-nav .cd-next').addClass('inactive') : $('.cd-vertical-nav .cd-next').removeClass('inactive');
	}

	//detect which section is visible in the viewport
	function checkVisibleSection() {
		var scrollTop = $(window).scrollTop(),
			windowHeight = $(window).height();

		$('[data-type="slider-item"]').each(function () {
			var actualBlock = $(this),
				offset = scrollTop - actualBlock.offset().top;
			//add/remove .is-visible class if the section is in the viewport - it is used to navigate through the sections
			(offset >= 0 && offset < windowHeight) ? actualBlock.addClass('is-visible') : actualBlock.removeClass('is-visible');
		});
	}

	function smoothScroll(target) {
		if (!target || !target.length) return;
		animating = true;
		var targetTop = getTargetTop(target);
		$('body,html').animate({ 'scrollTop': targetTop }, 500, function () {
			animating = false;
			setSlider();
		});
	}
});
