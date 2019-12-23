jQuery( function( $ ) {
	var isActiveAjax = false;

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var btn, clicked, slide;	// For Owl Carousel slide.
		var moreImagesNewActiveImage;	// New image source link in more product images slider.
		var productId; // ID of product which clicked for more info.
		var ajaxData; // For Ajax request.
		var owl, sliderItems, sliderTimer;	// For Owl Carousel initialization.

		/**
		 * Owl Slider.
		 */
		if ( $( 'div' ).hasClass( 'cwp-product-slider' ) ) {
			owl = $( '.cwp-product-slider' );
			sliderItems = parseInt( owl.attr( 'data-slides' ) );
			sliderTimer = parseInt( owl.attr( 'data-timer' ) );

			owl.owlCarousel( {
				autoplay 			: true,
				items 				: sliderItems,
		    	loop 				: true,
			    margin 				: 30,
			    autoplayHoverPause 	: true,
			    autoplayTimeout		: sliderTimer,
			    nav 				: false,
			    dots 				: true,
			    responsive			: {
			    	0: {
			    		items: 1
			    	},
			    	500: {
			    		items: 2
			    	},
			    	800: {
			    		items: 3
			    	},
			    	1200: {
			    		items: 4
			    	},
			    	1600: {
			    		items: sliderItems
			    	}
			    }
		    } );
		}

		/**
		 * Product plus click.
		 */
		$( '.cwp-slide' ).on( 'click', '.product-actions', function( e ) {
			e.preventDefault();
			btn = $( this );
			slide = btn.closest( '.cwp-slide' );
			clicked = btn.attr( 'data-clicked' );

			if ( clicked == 0 ) {
				// Display current overlay.
				$( this ).addClass( 'product-actions_active' );
				$( '.button-slide-overlay', slide ).css( 'display', 'grid' );

				// Overlays before buttons appearing.
				$( '.button-slide-overlay-before_brand', slide ).addClass( 'button-slide-overlay-before_active' );
				setTimeout( function() {
					$( '.button-slide-overlay-before', slide ).addClass( 'button-slide-overlay-before_active' );
				}, 50 );

				// Current overlay animation on show.
				setTimeout( function() {
					$( '.button-slide-overlay', slide ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
					$( '.button-slide-overlay .button', slide ).removeClass( 'fadeOutUp' ).addClass( 'fadeInDown' );
					btn.attr( 'data-clicked', 1 );
				}, 1 );
			}	else {	// Close.
				$( this ).removeClass( 'product-actions_active' );
				$( '.button-slide-overlay .button', slide ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
				$( '.button-slide-overlay', slide ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

				setTimeout( function() {
					$( '.button-slide-overlay-before', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 300 );

				setTimeout( function() {
					$( '.button-slide-overlay-before_brand', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 350 );

				setTimeout( function() {
					$( '.button-slide-overlay', slide ).css( 'display', 'none' );
					btn.attr( 'data-clicked', 0 );
				}, 1000 );
			}
		} );

		/**
		 * Show more info about product.
		 */
		$( '.cwp-product-slider' ).on( 'click', '.cwp-slide-more-info-button', function( e ) {
			e.preventDefault();

			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.

				// Close buttons wrapper.
				$( '.product-actions' ).removeClass( 'product-actions_active' );
				$( '.button-slide-overlay .button', slide ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
				$( '.button-slide-overlay', slide ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

				setTimeout( function() {
					$( '.button-slide-overlay-before', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 300 );

				setTimeout( function() {
					$( '.button-slide-overlay-before_brand', slide ).removeClass( 'button-slide-overlay-before_active' );
				}, 350 );

				setTimeout( function() {
					$( '.button-slide-overlay', slide ).css( 'display', 'none' );
					btn.attr( 'data-clicked', 0 );
				}, 1000 );

				$( 'body' ).append(
					'<div class = "product-more-info-preloader animated fadeIn">' +
						'<i class = "fas fa-spinner product-more-info-preloader__icon"></i>' +
					'</div>'
				);

				productId = $( this ).attr( 'data-id' );	// Get product ID from .cwp-slide-more-info-button data-id attribute.
				ajaxData = {
					action 			: '_show_more',
					product_id		: productId
				};

				$.post( cwpAjax.ajaxurl, ajaxData, function( data ) {	// Ajax post request.
					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							/**
							 * Filling all more product info fields with response data.
							 */
							if ( data.data.product != '' ) {	// If product id is not empty.
								$( '.button_go-to-product' ).attr( 'href', data.data.product );
							}

							if ( data.data.title != '' ) {	// If title is not empty.
								$( '.cwp-more-info__title' ).html( data.data.title );
							}

							if ( data.data.thumbnail != '' ) {	// If thumbnail is not empty.
								$( '.cwp-more-info-image-wrapper' ).css( 'background-image', 'url(' + data.data.thumbnail + ')' );
							}

							if ( data.data.more_images != '' ) {	// If more product images array is not empty.
								$( '.cwp-more-info-images' ).html( data.data.more_images );
								$( '.cwp-more-info-images' ).addClass( 'owl-carousel owl-theme' );

								/**
								 * Owl Slider for product images array.
								 */
								owl = $( '.cwp-more-info-images' );

								owl.owlCarousel( {
									autoplay 	: false,
									items 		: 12,
							    	loop 		: false,
								    margin 		: 0,
								    nav 		: true,
								    navText		: ['<span class = "line"></span><span class = "line line__cross"></span>','<span class = "line"></span><span class = "line line__cross"></span>'],
								    dots 		: false,
								    responsive	: {
								    	0: {
								    		items: 4
								    	},
								    	600: {
								    		items: 8
								    	},
								    	800: {
								    		items: 12
								    	}
								    }
							    } );
							}

							if ( data.data.colors != '' ) {	// If colors array is not empty.
								$( '.cwp-more-info-colors' ).html( data.data.colors );
							}

							if ( data.data.old_price != '' ) {	// If old price is not empty.
								$( '.cwp-more-info-prices__old' ).html( data.data.old_price );
							}

							if ( data.data.new_price != '' ) {	// If new price is not empty.
								$( '.cwp-more-info-prices__new' ).html( data.data.new_price );
							}

							if ( data.data.type != '' ) {	// If type is not empty.
								$( '.cwp-more-info-type' ).html( data.data.type );
							}

							if ( data.data.material != '' ) {	// If new price is not empty.
								$( '.cwp-more-info-material' ).html( data.data.material );
							}

							if ( data.data.width != '' ) {	// If width is not empty.
								$( '.cwp-more-info-width' ).html( data.data.width );
							}

							if ( data.data.height != '' ) {	// If height is not empty.
								$( '.cwp-more-info-height' ).html( data.data.height );
							}

							if ( data.data.depth != '' ) {	// If depth is not empty.
								$( '.cwp-more-info-depth' ).html( data.data.depth );
							}

							if ( data.data.text != '' ) {	// If text is not empty.
								$( '.cwp-more-info-text' ).html( data.data.text );
							}

							if ( data.data.per_pack != '' ) {	// If number of products per pack is not empty.
								$( '.cwp-more-info-number-per-pack' ).html( data.data.per_pack );
							}

							if ( data.data.manufacture != '' ) {	// If manufacture country is not empty.
								$( '.cwp-more-info-manufacture-country' ).html( data.data.manufacture );
							}

							if ( data.data.brand != '' ) {	// If brand country is not empty.
								$( '.cwp-more-info-brand-country' ).html( data.data.brand );
							}

							if ( data.data.guarantee != '' ) {	// If depth is not empty.
								$( '.cwp-more-info-guarantee' ).html( data.data.guarantee );
							}

							console.log( data.data.message );	// Show success message in console.

							$( '.product-more-info-preloader' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide preloader.
							$( '.cwp-more-info' ).removeClass( 'fadeOutLeft' ).addClass( 'fadeInLeft' );	// Remove animation hiding class.
							$( '.cwp-more-info-image-wrapper' ).removeClass( 'fadeOutRight' ).addClass( 'fadeInRight' );	// Remove animation hiding class.
							$( '.cwp-more-info-wrapper' ).css( 'display', 'grid' );	// Display more info block as CSS-grid.

							// Delay 100 ms after display wrapper to see correct animation.
							setTimeout(
								function() {
									$( '.cwp-more-info-wrapper' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );	// Show info wrapper with fade animation.
									$( '.cwp-more-info-item' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );	// Show info fields with fade animation.
								},
								100
							);
							// Delay 1 second to play animation, then remove preloader.
							setTimeout(
								function() {
									$( '.product-more-info-preloader' ).remove();	// Remove preloader from DOM.
								},
								1000
							);
			    			break;

						case false: 	// If we have some errors.
			    			console.log( data.data.message );	// Show errors in console.

			    		default: 	// Default variant.
			    			console.log( 'Unknown error!' );	// Show message of unknown error in console.
			    			break;
					}
				} );

				isActiveAjax = false;	// User can use ajax ahead.
			}
		} );

		/**
		 * Close more info about product.
		 */
		$( 'body' ).on( 'click', '.close-popup', function( e ) {
			e.preventDefault();

			$( '.cwp-more-info' ).removeClass( 'fadeInLeft' ).addClass( 'fadeOutLeft' );	// Hide info with animation.
			$( '.cwp-more-info-image-wrapper' ).removeClass( 'fadeInRight' ).addClass( 'fadeOutRight' );	// Hide image with animation.
			$( '.cwp-more-info-wrapper' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );	// Hide info wrapper with fade animation.
			setTimeout( function() {
				$( '.cwp-more-info-wrapper' ).css( 'display', 'none' );	// Hide more product info wrapper.
				$( '.cwp-more-info-image-wrapper' ).css( 'background-image', 'url()' );	// Remove main image from background.
				// Clearing all HTML blocks.
				$( '.cwp-more-info-item' ).html( '' );
				$( '.cwp-more-info-images' ).trigger( 'destroy.owl.carousel' );	// Destroy Owl Carousel.
			}, 1000 );
		} );

		/**
		 * Change image in more product images slider.
		 */
		$( '.cwp-more-info-images' ).on( 'click', '.cwp-more-info-image', function( e ) {
			e.preventDefault();

			$( '.cwp-more-info-image' ).removeClass( 'cwp-more-info-image_active' );	// Remove active class from all slider images.
			$( this ).addClass( 'cwp-more-info-image_active' );	// Add active class to current image thumbnail.
			moreImagesNewActiveImage = $( this ).attr( 'data-src' );	// Get new active slide image link.
			$( '.cwp-more-info-image-wrapper' ).css( 'background-image', 'url(' + moreImagesNewActiveImage + ')' );	// Set new active image as main big-size product image.
		} );

		/**
		 * Product color select.
		 */
		$( '.cwp-more-info-colors' ).on( 'click', '.cwp-more-info-colors-item', function( e ) {
			e.preventDefault();

			$( '.cwp-more-info-colors-item' ).removeClass( 'cwp-more-info-colors-item_active' );	// Remove active class from all product colors.
			$( this ).addClass( 'cwp-more-info-colors-item_active' );	// Add active class to current product color.
		} );

	} );

} );