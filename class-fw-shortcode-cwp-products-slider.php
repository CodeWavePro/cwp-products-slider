<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Shortcode_CWP_Products_Slider extends FW_Shortcode {
	public function _init() {
        $this->register_ajax();
    }

    private function register_ajax() {
        add_action( 'wp_ajax__show_more', array( $this, '_show_more' ) );
		add_action( 'wp_ajax_nopriv__show_more', array( $this, '_show_more' ) );
    }

    /**
	 * Show product more info fields in Products Slider.
	 */
    public function _show_more() {
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
		 * Product title.
		 */
		$product_title = get_the_title( $product_id );

		// If product has thumbnail.
		if ( has_post_thumbnail( $product_id ) ) {
			// Array for product images.
			$more_product_images_array = '<div class = "cwp-more-info-image cwp-more-info-image_active" style = "background-image: url(' . get_the_post_thumbnail_url( $product_id, 'full' ) . ')" data-src = "' . get_the_post_thumbnail_url( $product_id, 'full' ) . '"></div>';
			// Full size product thumbnail.
			$product_image = get_the_post_thumbnail_url( $product_id, 'full' );
		}	else {
			$product_image = '';
		}

		// More product images.
		if ( fw_get_db_post_option( $product_id, 'images' ) ) {
			foreach ( fw_get_db_post_option( $product_id, 'images' ) as $image ) {
				$more_product_images_array .=  '<div class = "cwp-more-info-image" style = "background-image: url(' . $image['image']['url'] . ')" data-src = "' . $image['image']['url'] . '"></div>';
			}
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
				'title'			=> $product_title,
				'thumbnail' 	=> $product_image,
				'more_images'	=> $more_product_images_array,
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
}