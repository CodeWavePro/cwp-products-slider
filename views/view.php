<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$is_auto = ( isset( $atts['is_auto'] ) && ( $atts['is_auto']['fill'] === 'auto_fill' ) ) ? true : false;

// Slides count per one screen.
$slides_per_screen = ( isset( $atts['slides_per_screen'] ) && $atts['slides_per_screen'] ) ? $atts['slides_per_screen'] : 5;
// Slides max count.
$slides_max_count = ( isset( $atts['slides_max_count'] ) && $atts['slides_max_count'] ) ? $atts['slides_max_count'] : 24;
// Timer for scrolling slider animation.
$timer = ( isset( $atts['timer'] ) && $atts['timer'] ) ? $atts['timer'] : 5;
// Seconds to miliseconds for JS.
$timer *= 1000;
// Slider background color.
$slider_bg_color = ( isset( $atts['slider_bg_color'] ) && $atts['slider_bg_color'] ) ? $atts['slider_bg_color'] : '#f9f9f9';
// Margin top.
$margin_top = ( isset( $atts['margin_top'] ) && $atts['margin_top'] ) ? $atts['margin_top'] : '0';
// Margin bottom.
$margin_bottom = ( isset( $atts['margin_bottom'] ) && $atts['margin_bottom'] ) ? $atts['margin_bottom'] : '50';
// Icon for every specification field.
$currency_icon = ( isset( $atts['currency_icon'] ) && $atts['currency_icon'] ) ? '<i class = "' . esc_attr( $atts['currency_icon']['icon-class'] ) . '"></i>' : '';
// Icon for preloader.
$preloader_icon = ( isset( $atts['preloader_icon'] ) && $atts['preloader_icon'] ) ? $atts['preloader_icon']['icon-class'] : '';
?>

<section class = "fw-main-row section-cwp-products-slider" style = "background-color: <?php echo esc_attr( $slider_bg_color ) ?>">
	<div class = "fw-container-fluid">
		<div class = "fw-row">
			<div class = "fw-col-xs-12">
				<!-- Slider wrapper. -->
				<div class = "cwp-product-slider owl-carousel owl-theme"
					 data-slides = "<?php echo esc_attr( $slides_per_screen ) ?>"
					 data-timer = "<?php echo esc_attr( $timer ) ?>"
					 data-preloader = "<?php echo esc_attr( $preloader_icon ) ?>"
					 style = "background-color: <?php echo esc_attr( $slider_bg_color ) ?>;
					 		  margin-top: <?php echo esc_attr( $margin_top ) ?>px;
					 		  margin-bottom: <?php echo esc_attr( $margin_bottom ) ?>px">

					<?php
					// If "Auto fill" slider content type is selected.
					if ( $is_auto ) {
						$loop = new WP_Query(	// Variable for new query.
							array(
								'post_type'			=> 'products',	// Custom post type.
								'posts_per_page'	=> $slides_max_count	// Max slides count.
							)
						);

						while ( $loop->have_posts() ) : $loop->the_post();
							$id = get_the_ID();	// Current product ID.
							?>
							<div class = "cwp-slide">
								<div class = "cwp-slide-image" style = "background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( $id, 'medium' ) ) ?>)">
									<!-- Overlays are showing when PLUS icon is clicked. -->
									<div class = "button-slide-overlay-before_brand"></div>
									<div class = "button-slide-overlay-before"></div>

									<!-- Buttons are showing when PLUS icon is clicked. -->
									<div class = "button-slide-overlay animated">
										<a class = "button cwp-slide-more-info-button animated" href = "#" data-id = "<?php echo esc_attr( $id ) ?>">
											<?php esc_html_e( 'Больше информации', 'mebel-laim' ) ?>
										</a>
										<a class = "button animated" href = "#" style = "animation-delay: 150ms">
											<?php esc_html_e( 'Быстрый заказ', 'mebel-laim' ) ?>
										</a>
										<a class = "button animated" href = "#" style = "animation-delay: 300ms">
											<?php esc_html_e( 'Добавить в корзину', 'mebel-laim' ) ?>											
										</a>
										<a class = "button animated" href = "<?php echo esc_url( the_permalink() ) ?>" style = "animation-delay: 450ms">
											<?php esc_html_e( 'Перейти к товару', 'mebel-laim' ) ?>
										</a>
									</div>

									<!-- PLUS icon. -->
									<a href = "#" class = "product-actions" title = "<?php esc_attr_e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
										<!-- Horizontal line. -->
						 				<span class = "line"></span>
						 				<!-- Vertical line. -->
						 				<span class = "line line__cross"></span>
						 			</a>
								</div><!-- .cwp-slide-image -->

								<div class = "cwp-slide-term">
						 			<?php
						 			// Getting all terms of current product in taxonomy "products".
						 			$terms = wp_get_post_terms( $id, 'products' );

						 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
						 			foreach ( $terms as $term ) {
						 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
						 					?>
						 					<a class = "cwp-slide-term__link" href = "<?php echo esc_url( get_term_link( $term->term_id, 'products' ) ) ?>">
						 						<?php printf( esc_html__( '%s', 'mebel-laim' ), $term->name ) ?>
						 					</a>
						 					<?php
						 					break;
						 				}
						 			}
						 			?>
						 		</div><!-- .cwp-slide-term -->

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
							 					<!--
							 					RUBLE icon for currency (from Font Awesome Icons).
							 					@link https://fontawesome.com/icons
							 					-->
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
						wp_reset_query();	// Clearing query for correct work of other loops.
					}	else {	// If "Manual fill" slider content type is selected.
						if ( isset( $atts['is_auto']['manually_fill']['slider'] ) &&
							 $atts['is_auto']['manually_fill']['slider'] ) {
							foreach ( $atts['is_auto']['manually_fill']['slider'] as $id ) {
								?>
								<div class = "cwp-slide">
									<div class = "cwp-slide-image" style = "background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( $id, 'medium' ) ) ?>)">
										<!-- Overlays are showing when PLUS icon is clicked. -->
										<div class = "button-slide-overlay-before_brand"></div>
										<div class = "button-slide-overlay-before"></div>

										<!-- Buttons are showing when PLUS icon is clicked. -->
										<div class = "button-slide-overlay animated">
											<a class = "button cwp-slide-more-info-button animated" href = "#" data-id = "<?php echo esc_attr( $id ) ?>">
												<?php esc_html_e( 'Больше информации', 'mebel-laim' ) ?>
											</a>
											<a class = "button animated" href = "#" style = "animation-delay: 150ms">
												<?php esc_html_e( 'Быстрый заказ', 'mebel-laim' ) ?>
											</a>
											<a class = "button animated" href = "#" style = "animation-delay: 300ms">
												<?php esc_html_e( 'Добавить в корзину', 'mebel-laim' ) ?>											
											</a>
											<a class = "button animated" href = "<?php echo esc_url( get_the_permalink( $id ) ) ?>" style = "animation-delay: 450ms">
												<?php esc_html_e( 'Перейти к товару', 'mebel-laim' ) ?>
											</a>
										</div>

										<!-- PLUS icon. -->
										<a href = "#" class = "product-actions" title = "<?php esc_attr_e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
											<!-- Horizontal line. -->
							 				<span class = "line"></span>
							 				<!-- Vertical line. -->
							 				<span class = "line line__cross"></span>
							 			</a>
									</div><!-- .cwp-slide-image -->

									<div class = "cwp-slide-term">
							 			<?php
							 			// Getting all terms of current product in taxonomy "products".
							 			$terms = wp_get_post_terms( $id, 'products' );

							 			// Searching if one of terms has no child terms - this is the lowest term, we need it.
							 			foreach ( $terms as $term ) {
							 				if ( count( get_term_children( $term->term_id, 'products' ) ) === 0 ) {
							 					?>
							 					<a class = "cwp-slide-term__link" href = "<?php echo esc_url( get_term_link( $term->term_id, 'products' ) ) ?>">
							 						<?php printf( esc_html__( '%s', 'mebel-laim' ), $term->name ) ?>
							 					</a>
							 					<?php
							 					break;
							 				}
							 			}
							 			?>
							 		</div><!-- .cwp-slide-term -->

									<div class = "cwp-slide-info">
										<div class = "cwp-slide-title">
								 			<h3 class = "cwp-slide-text__header">
								 				<?php echo get_the_title( $id ) ?>
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
								 					<span class = "cwp-slide-price__currency">
								 						<?php echo $currency_icon ?>
								 					</span>
								 				</span>
								 				<?php
								 			}
								 			?>
								 		</div><!-- .cwp-slide-price -->
									</div><!-- .cwp-slide-info -->
								</div><!-- .cwp-slide -->
								<?php
							}
						}
					}
					?>

				</div><!-- .cwp-product-slider -->
			</div><!-- .fw-col-xs-12 -->
		</div><!-- .fw-row -->
	</div><!-- .fw-container -->
</section><!-- .fw-main-row.section-cwp-products-slider -->

<!-- Hidden block to show more info about product, when .cwp-slide-more-info-button is clicked. -->
<div class = "cwp-more-info-wrapper animated">
	<!-- Close wrapper. -->
	<a href = "#" class = "close-popup" title = "<?php esc_attr_e( 'Действия', 'mebel-laim' ) ?>" data-clicked = "0">
		<!-- Horizontal line. -->
		<span class = "line"></span>
		<!-- Vertical line. -->
		<span class = "line line__cross"></span>
	</a>

	<!-- More information about product: fields & buttons. -->
	<div class = "cwp-more-info animated">
		<!-- Product name. -->
		<h2 class = "cwp-more-info__title vertical-line-for-header"></h2>

		<!-- Prices: old & actual. -->
		<div class = "cwp-more-info-prices">			
			<span class = "cwp-more-info-prices__old">
				<span class = "cwp-more-info-prices__value"></span>
			</span>
			<span class = "cwp-more-info-prices__new">
				<span class = "cwp-more-info-prices__value"></span>
				<span class = "cwp-more-info-prices__currency">
					<?php echo $currency_icon ?>
				</span>
			</span>
		</div>

		<div class = "cwp-more-info-item cwp-more-info-colors animated"></div>

		<?php
		// Icon for every specification field.
		$specification_icon = ( isset( $atts['specification_icon'] ) && $atts['specification_icon'] ) ?
					 		  '<i class = "' . esc_attr( $atts['specification_icon']['icon-class'] ) . ' cwpgt-more-info__icon"></i>' :
							  '';
		?>

		<div class = "cwp-more-info-item cwp-more-info-type animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Тип:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-material animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Материал:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-width animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Длина:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-height animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Высота:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-depth animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Глубина:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-manufacture-country animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Количество в упаковке:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-brand-country animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Производитель:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-guarantee animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Страна производства:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-number-per-pack animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Гарантия:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>
		<div class = "cwp-more-info-item cwp-more-info-text animated">
			<span class = "product__label">
				<?php echo $specification_icon . ' ' . esc_html__( 'Дополнительная информация:', 'mebel-laim' ) ?>
			</span>
			<span class = "cwp-product__value"></span>
		</div>

		<!-- Buttons wrapper. -->
		<div class = "cwp-more-info-buttons">
			<a class = "button cwp-more-info_button button_go-to-product" href = "#">
				<?php esc_html_e( 'На страницу товара', 'mebel-laim' ) ?>
			</a>
			<a class = "button cwp-more-info_button button_add-to-cart" href = "#">
				<?php esc_html_e( 'Добавить в корзину', 'mebel-laim' ) ?>
			</a>
			<a class = "button cwp-more-info_button button_quick-order" href = "#">
				<?php esc_html_e( 'Быстрый заказ', 'mebel-laim' ) ?>
			</a>
		</div>
	</div><!-- .cwp-more-info -->

	<!-- Right part with images. -->
	<div class = "cwp-more-info-right">
		<!-- Product image. -->
		<div class = "cwp-more-info-image-wrapper animated"></div>
		<!-- More product images (if exist). -->
		<div class = "cwp-more-info-images animated"></div>
	</div>
</div><!-- .cwp-more-info-wrapper -->