<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Function localizes js file and makes own variable for ajax-url.
 */
if ( !is_admin() ) {
	$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-products-slider' );

	// Check if Owl Carousel 2 script and styles are registered (enqueued).
	if ( !wp_script_is( 'cwp-owl-carousel-2-script', 'enqueued' ) ) {
		wp_enqueue_script(
			'cwp-owl-carousel-2-script',
			$uri . '/static/libs/js/owl.carousel.min.js',
			['jquery']
		);
	}

	if ( !wp_style_is( 'cwp-owl-carousel-2-css', 'enqueued' ) ) {
		wp_enqueue_style(
			'cwp-owl-carousel-2-css',
			$uri . '/static/libs/css/owl.carousel.min.css'
		);
	}

	if ( !wp_style_is( 'cwp-owl-carousel-2-theme-css', 'enqueued' ) ) {
		wp_enqueue_style(
			'cwp-owl-carousel-2-theme-css',
			$uri . '/static/libs/css/owl.theme.default.min.css'
		);
	}
	//--------------- End of Owl Carousel scripts & styles. ---------------

	if ( !wp_style_is( 'fw-shortcode-cwp-products-slider-css', 'enqueued' ) ) {
		wp_enqueue_style(
		    'fw-shortcode-cwp-products-slider-css',
		    $uri . '/static/css/css/style.min.css'
		);
	}

	if ( !wp_script_is( 'cwp-products-slider-js', 'enqueued' ) ) {
		wp_enqueue_script(
			'cwp-products-slider-js',
			$uri . '/static/js/scripts.min.js',
			['jquery']
		);
		wp_localize_script(
			'cwp-products-slider-js',
			'cwpAjax',
			['ajaxurl' => admin_url( 'admin-ajax.php' )]
		);
	}
}