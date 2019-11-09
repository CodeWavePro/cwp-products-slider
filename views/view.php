<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$slides_per_screen = ( isset( $atts['slides_per_screen'] ) && $atts['slides_per_screen'] ) ? $atts['slides_per_screen'] : 5;
$timer = ( isset( $atts['timer'] ) && $atts['timer'] ) ? $atts['timer'] : 5;
$timer *= 1000; // Seconds to miliseconds for JS.
?>

<div class = "cwp-product-slider owl-carousel owl-theme" data-slides = "<?php esc_attr_e( $slides_per_screen ) ?>" data-timer = "<?php esc_attr_e( $timer ) ?>">
	<?php
	if ( isset( $atts['is_auto'] ) && ( $atts['is_auto']['fill'] === 'auto_fill' ) ) {	// If "Auto fill" slider content type is selected.
		$loop = new WP_Query(
			array(
				'post_type'			=> 'products',
				'posts_per_page'	=> 30
			)
		);

		while ( $loop->have_posts() ) : $loop->the_post();
			$id = get_the_ID();	// Current product ID.
			?>
			<div class = "cwp-slide">
				<div class = "cwp-slide-image" style = "background-image: url(<?php echo get_the_post_thumbnail_url( $id, 'medium' ) ?>)">
					<div class = "button-slide-overlay-before_brand"></div>
					<div class = "button-slide-overlay-before"></div>
					<div class = "button-slide-overlay animated">
						<a class = "button animated" href = "#"><?php _e( 'Больше информации', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "#" style = "animation-delay: 150ms"><?php _e( 'Быстрый заказ', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "#" style = "animation-delay: 300ms"><?php _e( 'Добавить в корзину', 'mebel-laim' ) ?></a>
						<a class = "button animated" href = "<?php the_permalink() ?>" style = "animation-delay: 450ms"><?php _e( 'Перейти к товару', 'mebel-laim' ) ?></a>
					</div>

					<a href = "#" class = "product-actions" title = "<?php _e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
		 				<span class = "product-actions__line"></span>
		 				<span class = "product-actions__line product-actions__line_vertical"></span>
		 			</a>
				</div>

				<div class = "cwp-slide-term">
		 			<?php
		 			// Getting all terms of current product in taxonomy "products".
		 			$terms = wp_get_post_terms( $id, 'products' );

		 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
		 			foreach ( $terms as $term ) {
		 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
		 					?>
		 					<a class = "cwp-slide-term__link" href = "<?php echo get_term_link( $term->term_id, 'products' ) ?>"><?php esc_html_e( $term->name, 'mebel-laim' ) ?></a>
		 					<?php
		 					break;
		 				}
		 			}
		 			?>
		 		</div>

				<div class = "cwp-slide-info">
					<div class = "cwp-slide-title">
			 			<h3 class = "cwp-slide-text__header">
			 				<?php the_title() ?>
			 			</h3>
			 		</div>

			 		<div class = "cwp-slide-price">

			 			<?php
		 				/**
		 				 * If product new price is not empty.
		 				 * 
		 				 * @ Product -> Prices -> New Price.
		 				 */
			 			if ( fw_get_db_post_option( $id, 'new_price' ) ) {
			 				?>
			 				<span class = "cwp-slide-price__new">
			 					<?php echo number_format( fw_get_db_post_option( $id, 'new_price' ), 0, '.', ' ' ) ?>
			 					<span class = "cwp-slide-price__currency"><i class = "fas fa-ruble-sign"></i></span>
			 				</span>
			 				<?php
			 			}
			 			?>

			 		</div><!-- .cwp-slide-price -->
				</div><!-- .cwp-slide-info -->
			</div><!-- .cwp-slide -->
			<?php
		endwhile;
		wp_reset_query();
	}	else {
		// 
	}
	?>
</div><!-- .cwp-slider -->