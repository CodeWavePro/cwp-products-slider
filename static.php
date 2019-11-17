<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-products-slider' );
wp_enqueue_style(
    'fw-shortcode-cwp-products-slider',
    $uri . '/static/css/styles.css'
);
wp_enqueue_script(
    'fw-shortcode-cwp-products-slider',
    $uri . '/static/js/scripts.min.js'
);

/**
 * Function localizes js file and makes own variable for ajax-url.
 */
if ( !is_admin() ) {
	$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-products-slider' );

	if ( wp_script_is( 'cwp-products-slider', 'registered' ) ) {
		return false;
	}	else {
		wp_enqueue_script(
			'cwp-products-slider',
			$uri . '/static/js/cwp-products-slider.min.js',
			array( 'jquery' )
		);
		wp_localize_script(
			'cwp-products-slider',
			'cwpAjax',
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		);
	}
}
?> 