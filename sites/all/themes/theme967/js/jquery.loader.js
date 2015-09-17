jQuery(window).bind('load', function() {
	jQuery('.foreground').toggle('slow');
});

jQuery(function() {
	jQuery('.isotope-element').hover(function() {
		jQuery(this).find('.views-field-field-portfolio-image img').stop().animate({opacity:'.4'})
	},

	function() {
		jQuery(this).find('.views-field-field-portfolio-image img').stop().animate({opacity:'1'})
	})
});

(function($) {
	jQuery(document).ready(function($) {
		if (jQuery(".portfolio-grid").length) {
			var $container = jQuery('#isotope-container'),
				margin = 0;
			
			if (jQuery(window).width() > 995) {
				margin = ($container.width()%5) - 5;
				margin = margin == -5 ? 0 : margin;
			} else if (jQuery(window).width() > 767) {
				margin = ($container.width()%4) - 4;
				margin = margin == -4 ? 0 : margin;
			} else if (jQuery(window).width() > 479) {
				margin = ($container.width()%2) - 2;
				margin = margin == -2 ? 0 : margin;
			}
			$container.css({"margin-right": margin});

			$container.imagesLoaded( function() {
				$container.isotope({
					itemSelector		: '.isotope-element',
					resizable			: false,
					transformsEnabled	: true,
					layoutMode			: 'masonry',
				});
			});

			jQuery(window).on("debouncedresize", function(event) {
				margin = 0;
				jQuery('#isotope-container').css({"margin-right": 0});
				
				if (jQuery(window).width() > 995) {
					margin = (jQuery("#isotope-container").width()%5) - 5;
					margin = margin == -5 ? 0 : margin;
				} else if (jQuery(window).width() > 767) {
					margin = ($container.width()%4) - 4;
					margin = margin == -4 ? 0 : margin;
				} else if (jQuery(window).width() > 479) {
					margin = ($container.width()%2) - 2;
					margin = margin == -2 ? 0 : margin;
				}
				jQuery('#isotope-container').css({"margin-right": margin});
				
				$container.isotope('reLayout');
			});
		};

		if ($.cookie('the_cookie') == 0) {
			styleSwitch(0)
		}

		function styleSwitch(cookie) {
			if (cookie == 0) {
				$('#style-mobile').remove();
				$('#skeleton-mobile').remove();
				$('.switcher').text("Responsive Version");
				$.cookie('the_cookie', 0);
			} else {
				$('head').append('<link rel="stylesheet" href="<?php echo base_path().path_to_theme() ?>/css/style-mobile.css" media="screen" id="style-mobile">');
				$('head').append('<link rel="stylesheet" href="<?php echo base_path().path_to_theme() ?>/css/skeleton-mobile.css" media="screen" id="skeleton-mobile">');
				$('.switcher').text("Desktop Version only");
				$.cookie('the_cookie', 1);
			}
		}

		$('.switcher').click(function() {
			styleSwitch($.cookie('the_cookie') == 0 ? 1 : 0);
			location.reload();
		});
	});
})(jQuery);

jQuery(document).ready(function () {
	jQuery("#isotope-options .option-set li a[data-option-value='.all']").addClass("selected");
	
	// Portfolio image size
	jQuery('.tm-masonry-item img').each(function() {
		var width = jQuery(this).parents('.tm-masonry-item').width(),
			height = jQuery(this).parents('.tm-masonry-item').height(),
			h = height/width;
		
		if (h > 0.5194) {
			jQuery(this).css({height: height, maxWidth: 'inherit'});
		} else {
			jQuery(this).css({height: 'auto', maxWidth: '100%'});
		}
	})
	
	// Contact form validation
	var my_form_id = new tFormer('contact-site-form', {
		fields: {
			name: {
				rules: "*"
			},
			mail: {
				rules: "* @"
			},
			subject: {
				rules: "*"
			},
			message: {
				rules: "*"
			}
		}
	});
	
	// Contact form tooltips
	jQuery(".contact-form .form-item-name").append('<div class="error-message">This field is required!</div>');
	jQuery(".contact-form .form-item-mail").append('<div class="error-message">Please enter a valid email address!</div>');
	jQuery(".contact-form .form-item-subject").append('<div class="error-message">This field is required!</div>');
	jQuery(".contact-form .form-item-message .form-textarea-wrapper").append('<div class="error-message">This field is required!</div>');
	
	jQuery(".contact-form input[type='reset']").on("click", function($) {
		jQuery(this).parents(".contact-form").find(".error").removeClass("error");
	})
	
	
});

// Tiled gallery
jQuery(window).bind('resize', function() {
	jQuery('.tm-masonry-item img').each(function() {
		var width = jQuery(this).parents('.tm-masonry-item').width(),
			height = jQuery(this).parents('.tm-masonry-item').height(),
			h = height/width;
		
		if (h > 0.5194) {
			jQuery(this).css({height: height, maxWidth: 'inherit'});
		} else {
			jQuery(this).css({height: 'auto', maxWidth: '100%'});
		}
	})
})

// Back to Top Button
jQuery(window).load(function() {
	jQuery().UItoTop({
		easingType: 'easeOutQuart',
		containerID: 'backtotop'
	});
})