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
			// Array for product images, CSS-animation for appearing.
			$more_product_images_array = '
				<div class = "cwp-more-info-image cwp-more-info-image_active animated fadeInUp"
					 style = "background-image: url(' . esc_url( get_the_post_thumbnail_url( $product_id, 'full' ) ) . ');
					 		  animation-delay: 100ms"
					 data-src = "' . esc_url( get_the_post_thumbnail_url( $product_id, 'full' ) ) . '">
				</div>';
			// Full size product thumbnail.
			$product_image = get_the_post_thumbnail_url( $product_id, 'full' );
		}	else {
			$product_image = '';
		}

		// More product images with CSS-animation for their appearing.
		if ( fw_get_db_post_option( $product_id, 'images' ) ) {
			foreach ( fw_get_db_post_option( $product_id, 'images' ) as $key => $image ) {
				$more_product_images_array .=  '
					<div class = "cwp-more-info-image animated fadeInUp"
						 style = "background-image: url(' . esc_url( $image['image']['url'] ) . ');
						 		  animation-delay: ' . ( 100 * ( $key + 2 ) ) . 'ms"
						 data-src = "' . esc_url( $image['image']['url'] ) . '">
					</div>
				';
			}
		}

		// If product has colors.
		if ( fw_get_db_post_option( $product_id, 'colors' ) ) {
			// Empty list for all colors of current product.
			$product_colors_array = '<ul class = "cwp-more-info-colors-list">';

			foreach ( fw_get_db_post_option( $product_id, 'colors' ) as $key => $color ) {
				// Colors list item tag open. Add active class if it's the first item.
				if ( $key === 0 ) {
					$product_colors_array .= '<li class = "cwp-more-info-colors-item cwp-more-info-colors-item_active">';
				}	else {
					$product_colors_array .= '<li class = "cwp-more-info-colors-item">';
				}

				// If color has name.
				if ( isset( $color['color_name'] ) ) {
					$product_colors_array .= '<span class = "cwp-more-info-colors-item__title">' . sprintf( esc_html__( '%s', 'mebel-laim' ), $color['color_name'] ) . '</span>';
				}

				// If color type is chosen.
				if ( isset( $color['color_type'] ) ) {
					switch ( $color['color_type']['color_type_select'] ) {
						case 'color_pallete':	// If color is chosen as pallete.
							$product_colors_array .= '<span class = "cwp-more-info-colors-item__color" style = "background-color: ' . esc_attr( $color['color_type']['color_pallete']['if_color_pallete'] ) . '"></span>';
							break;

						case 'image_upload':	// If color is chosen as image.
							$product_colors_array .= '<span class = "cwp-more-info-colors-item__color" style = "background-image: url(' . esc_url( $color['color_type']['image_upload']['if_image_upload']['url'] ) . ')"></span>';
							break;
						
						default:
							$product_colors_array .= esc_html__( 'No colors chosen.', 'mebel-laim' );
							break;
					}
				}
				$product_colors_array .= '</li>';	// Close HTML list item tag.
			}
			$product_colors_array .= '</ul>';	// Close HTML list tag.
		}

		// Old price.
		if ( fw_get_db_post_option( $product_id, 'old_price' ) ) {
			$product_price_old = number_format( fw_get_db_post_option( $product_id, 'old_price' ), 0, '.', ' ' );
		}	else {
			$product_price_old = '';
		}

		// Actual price.
		if ( fw_get_db_post_option( $product_id, 'new_price' ) ) {
			$product_price_new = number_format( fw_get_db_post_option( $product_id, 'new_price' ), 0, '.', ' ' );
		}	else {
			$product_price_new = '';
		}

		// Product type.
		if ( fw_get_db_post_option( $product_id, 'product_type' ) ) {
			$product_type = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'product_type' ) );
		}	else {
			$product_type = '';
		}

		// Product material.
		if ( fw_get_db_post_option( $product_id, 'material' ) ) {
			$product_material = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'material' ) );
		}	else {
			$product_material = '';
		}

		// Product width.
		if ( fw_get_db_post_option( $product_id, 'width' ) ) {
			$product_width = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'width' ) );
		}	else {
			$product_width = '';
		}

		// Product height.
		if ( fw_get_db_post_option( $product_id, 'height' ) ) {
			$product_height = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'height' ) );
		}	else {
			$product_height = '';
		}

		// Product depth.
		if ( fw_get_db_post_option( $product_id, 'depth' ) ) {
			$product_depth = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'depth' ) );
		}	else {
			$product_depth = '';
		}

		// Product more features.
		if ( fw_get_db_post_option( $product_id, 'more_features' ) ) {
			$product_text = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'more_features' ) );
		}	else {
			$product_text = '';
		}

		// Number of products per pack.
		if ( fw_get_db_post_option( $product_id, 'number_per_pack' ) ) {
			$number_per_pack = sprintf( esc_html__( '%d', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'number_per_pack' ) );
		}	else {
			$number_per_pack = '';
		}

		// Brand name.
		if ( fw_get_db_post_option( $product_id, 'brand_name' ) ) {
			$brand_name = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'brand_name' ) );
		}	else {
			$brand_name = '';
		}

		// Country of manufacture.
		if ( fw_get_db_post_option( $product_id, 'country_of_manufacture' ) ) {
			$country_of_manufacture = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'country_of_manufacture' ) );
		}	else {
			$country_of_manufacture = '';
		}

		// Guarantee.
		if ( fw_get_db_post_option( $product_id, 'guarantee' ) ) {
			$guarantee = sprintf( esc_html__( '%s', 'mebel-laim' ), fw_get_db_post_option( $product_id, 'guarantee' ) );
		}	else {
			$guarantee = '';
		}

		// Success ajax message.
		wp_send_json_success(
			array(
				'product'		=> get_the_permalink( $product_id ),
				'title'			=> $product_title,
				'thumbnail' 	=> $product_image,
				'more_images'	=> $more_product_images_array,
				'colors'		=> $product_colors_array,
				'old_price' 	=> $product_price_old,
				'new_price' 	=> $product_price_new,
				'type'			=> $product_type,
				'material'		=> $product_material,
				'width'			=> $product_width,
				'height'		=> $product_height,
				'depth'			=> $product_depth,
				'text'			=> $product_text,
				'per_pack'		=> $number_per_pack,
				'brand'			=> $brand_name,
				'manufacture'	=> $country_of_manufacture,
				'guarantee'		=> $guarantee,
				'message'		=> __( 'Дополнительные данные товара успешно получены.', 'mebel-laim' )
			)
		);
    }
}