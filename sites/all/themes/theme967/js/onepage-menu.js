(function($) {
	Drupal.theme967 = Drupal.theme967 || {};
	Drupal.theme967.currentRegion = null;
	Drupal.theme967.menuItems = [];

	Drupal.behaviors.onepageAction = {
		attach: function (context) { 
			$(window).load(function() {
				Drupal.theme967.showMenu();
			});
			$(window).resize(function() {
				Drupal.theme967.showMenu();
			});
		}
	};

	Drupal.theme967.showMenu = function() {
		var wrapper = $('#superfish-1');
		if ($(window).scrollTop() > -1) {
			$('.front #superfish-1 li a').smoothScroll({
				offset: -84,
				speed: 1000
			});
		} else {
			$('.front #superfish-1 li a').smoothScroll({
				offset: -84,
				speed: 1000
			});
		}
	};

	Drupal.behaviors.scrollMenuAction = {
		attach: function (context) {
			if ($('body.front').length) {
				$('.front #superfish-1 li a[href*="#"]').each(function() {
					var str = $(this).attr("href");
					$(this).addClass('op-menu-item');
					id = str.split('#')[1];
					menu_item = $(this);
					if (menu_item.length) {
						Drupal.theme967.menuItems.push(menu_item)
						menu_item.attr('data-id', id);
						menu_item.attr('data-link-type', 'scroll');
					}
				});
				$(document).ready(function() {
					$(window).scroll(function() {
						var top = $(window).scrollTop(),
							selected_item = -1,
							menu_height = $('.stickup').outerHeight();
						
						for (i = 0; i < Drupal.theme967.menuItems.length; i++) {
							var menu_item = Drupal.theme967.menuItems[i],
								id = $(menu_item).attr('data-id'),
								element = $("#" + id),
								offset = $(element).offset(),
								i_top = offset.top,
								i_bottom = offset.top + $(element).outerHeight();

							if ((top + menu_height >= i_top) && (top + menu_height <= i_bottom)) {
								selected_item = i;
							}
						}
						if (selected_item !== Drupal.theme967.currentRegion) {
							for (j = 0; j < Drupal.theme967.menuItems.length; j++) {
								if (j !== selected_item) {
									$(Drupal.theme967.menuItems[j]).removeClass('current');
								}
							}
							$(Drupal.theme967.menuItems[selected_item]).addClass('current');
						}
					});
				});
			}
		}
	};
})(jQuery);

jQuery(document).ready(function () {
	// Sticky menu
	if ((jQuery(window).width() > 995) && (jQuery('#header .stickup').length)) {
		jQuery('#header .stickup').tmStickUp({});
	}
})

// Mobile menu
jQuery(function() {
	jQuery('#superfish-1').mobileMenu();
})