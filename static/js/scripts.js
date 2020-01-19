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
		var preloaderIcon = $( '.product-slider' ).attr( 'data-preloader' );

		/**
		 * Owl Slider.
		 */
		if ( $( 'div' ).hasClass( 'product-slider' ) ) {
			owl = $( '.product-slider' );
			sliderItems = parseInt( owl.attr( 'data-slides' ) );
			sliderTimer = parseInt( owl.attr( 'data-timer' ) );

			owl.owlCarousel( {
				autoplay 			: true,
		    	loop 				: true,
		    	slideBy 			: 'page',
			    margin 				: 30,
			    autoplayHoverPause 	: true,
			    autoplayTimeout		: sliderTimer,
			    nav 				: false,
			    dots 				: true,
			    responsive			: {
			    	0: {
			    		autoplay 	: false,
			    		items 		: 1
			    	},
			    	500: {
			    		autoplay 	: false,
			    		items 		: 2
			    	},
			    	800: {
			    		autoplay 	: false,
			    		items 		: 3
			    	},
			    	1200: {
			    		autoplay 	: true,
			    		items 		: 4
			    	},
			    	1600: {
			    		autoplay 	: true,
			    		items 		: sliderItems
			    	}
			    }
		    } );
		}

	} );

} );