jQuery( function( $ ) {

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var clicked, slide;	// For Owl Carousel slide.
		var data; // For Ajax request.
		var moreImagesNewActiveImage;	// New image source link in more product images slider.

		/**
		 * Owl Slider.
		 */
		if ( $( 'div' ).hasClass( 'cwp-product-slider' ) ) {
			var owl = $( '.cwp-product-slider' );
			var sliderItems = parseInt( owl.attr( 'data-slides' ) );
			var sliderTimer = parseInt( owl.attr( 'data-timer' ) );

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
				$( '.cwp-more-info-images, .cwp-more-info-prices__old, .cwp-more-info-prices__new, .cwp-more-info-type, .cwp-more-info-material, .cwp-more-info-width, .cwp-more-info-height, .cwp-more-info-depth, .cwp-more-info-text, .cwp-more-info-number-per-pack, .cwp-more-info-manufacture-country, .cwp-more-info-brand-country, .cwp-more-info-guarantee' ).html( '' );
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