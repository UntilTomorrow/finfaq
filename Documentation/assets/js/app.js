(function ($) {
  "use strict";
	$('.open-mobile-menu').on('click', function () {
		$('.mobile_info_open').addClass('show');
		$('.offcanvas-overlay').addClass('overlay-open');
	})

	$('.close_info, .offcanvas-overlay').on('click', function () {
		$('.mobile_info_open').removeClass('show');
		$('.offcanvas-overlay').removeClass('overlay-open');
	})
	var scrollSpy = new bootstrap.ScrollSpy(document.body, {
		target: '#navbar-examplee'
	});

	$('.popup').magnificPopup({
		type: 'image'
		// other options
	  });

})(jQuery);
