<?php
/**
 * Ajax functions for cwp-products-slider Unyson shortcode.
 */
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Function localizes js file and makes own variable for ajax-url.
 */
add_action( 'wp_enqueue_scripts', 'cwp_products_slider_ajax', 99 );
function cwp_products_slider_ajax() {
	$uri = fw_get_template_customizations_directory_uri( '/extensions/shortcodes/shortcodes/cwp-products-slider' );
	wp_enqueue_script( 'cwpps-js', $uri . '/static/ajax/functions.min.js', array( 'jquery' ) );
	wp_localize_script( 'cwpps-js', 'cwpAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Show product more info fields in Products Slider.
 */
add_action( 'wp_ajax_show_more_product_info', 'show_more_product_info' );
add_action( 'wp_ajax_nopriv_show_more_product_info', 'show_more_product_info' );
function show_more_product_info() {
	$product_id = $_POST['product_id'];	// Getting product id.

	if ( !is_numeric( $product_id ) ) {	// If product id is not numeric.
		wp_send_json_error(	// Sending error message and exiting function.
			array(
				'message'	=> __( 'Неверный формат данных. ID товара не является числом.', 'mebel-laim' )
			)
		);
	}

	/**
	 * Prepairing all existing product fields for sending.
	 *
	 * Product thumbnail.
	 */
	if ( has_post_thumbnail( $product_id ) ) {
		$product_image = get_the_post_thumbnail_url( $product_id, 'full' );
	}	else {
		$product_image = '';
	}

	// Old price.
	if ( fw_get_db_post_option( $product_id, 'old_price' ) ) {
		$product_price_old = fw_get_db_post_option( $product_id, 'old_price' );
	}	else {
		$product_price_old = '';
	}

	// Actual price.
	if ( fw_get_db_post_option( $product_id, 'new_price' ) ) {
		$product_price_new = fw_get_db_post_option( $product_id, 'new_price' );
	}	else {
		$product_price_new = '';
	}

	// Product type.
	if ( fw_get_db_post_option( $product_id, 'product_type' ) ) {
		$product_type = fw_get_db_post_option( $product_id, 'product_type' );
	}	else {
		$product_type = '';
	}

	// Product material.
	if ( fw_get_db_post_option( $product_id, 'material' ) ) {
		$product_material = fw_get_db_post_option( $product_id, 'material' );
	}	else {
		$product_material = '';
	}

	// Product width.
	if ( fw_get_db_post_option( $product_id, 'width' ) ) {
		$product_width = fw_get_db_post_option( $product_id, 'width' );
	}	else {
		$product_width = '';
	}

	// Product height.
	if ( fw_get_db_post_option( $product_id, 'height' ) ) {
		$product_height = fw_get_db_post_option( $product_id, 'height' );
	}	else {
		$product_height = '';
	}

	// Product depth.
	if ( fw_get_db_post_option( $product_id, 'depth' ) ) {
		$product_depth = fw_get_db_post_option( $product_id, 'depth' );
	}	else {
		$product_depth = '';
	}

	// Product more features.
	if ( fw_get_db_post_option( $product_id, 'more_features' ) ) {
		$product_text = fw_get_db_post_option( $product_id, 'more_features' );
	}	else {
		$product_text = '';
	}

	// Number of products per pack.
	if ( fw_get_db_post_option( $product_id, 'number_per_pack' ) ) {
		$number_per_pack = fw_get_db_post_option( $product_id, 'number_per_pack' );
	}	else {
		$number_per_pack = '';
	}

	// Country of manufacture.
	if ( fw_get_db_post_option( $product_id, 'country_of_manufacture' ) ) {
		$country_of_manufacture = fw_get_db_post_option( $product_id, 'country_of_manufacture' );
	}	else {
		$country_of_manufacture = '';
	}

	// Brand country.
	if ( fw_get_db_post_option( $product_id, 'brand_country' ) ) {
		$brand_country = fw_get_db_post_option( $product_id, 'brand_country' );
	}	else {
		$brand_country = '';
	}

	// Guarantee.
	if ( fw_get_db_post_option( $product_id, 'guarantee' ) ) {
		$guarantee = fw_get_db_post_option( $product_id, 'guarantee' );
	}	else {
		$guarantee = '';
	}

	// Success ajax message.
	wp_send_json_success(
		array(
			'thumbnail' 	=> $product_image,
			'old_price' 	=> $product_price_old,
			'new_price' 	=> $product_price_new,
			'type'			=> $product_type,
			'material'		=> $product_material,
			'width'			=> $product_width,
			'height'		=> $product_height,
			'depth'			=> $product_depth,
			'text'			=> $product_text,
			'per_pack'		=> $number_per_pack,
			'manufacture'	=> $country_of_manufacture,
			'brand'			=> $brand_country,
			'guarantee'		=> $guarantee,
			'message'		=> __( 'Дополнительные данные товара успешно получены.', 'mebel-laim' )
		)
	);
}
?>