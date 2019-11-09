jQuery( function( $ ) {

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var clicked, slide;

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
			    dots 				: true
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

	} );

} );