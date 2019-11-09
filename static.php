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