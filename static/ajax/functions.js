jQuery( function( $ ) {
	var isActiveAjax = false;	// If false - user can do ajax request.

	/**
	 * When all page is loaded.
	 */
	$( document ).ready( function() {
		var clicked, slide;	// For Owl Carousel slide.
		var productId; // ID of product which clicked for more info.
		var data; // For Ajax request.

		/**
		 * Show more info about product.
		 */
		$( '.cwp-product-slider' ).on( 'click', '.cwp-slide-more-info-button', function( e ) {
			e.preventDefault();

			if ( !isActiveAjax ) {	// If user can use ajax.
				isActiveAjax = true;	// Ajax for other actions is blocked.
				productId = $( this ).attr( 'data-id' );	// Get product ID from .cwp-slide-more-info-button data-id attribute.
				data = {
					action 			: 'show_more_product_info',
					product_id		: productId
				};
				console.log( 'before ajax' );

				$.post( cwpAjax.ajaxurl, data, function( data ) {	// Ajax post request.
					console.log( 'after ajax' );
					switch ( data.success ) {	// Checking ajax response.
						case true: 	// If ajax response is success.
							/**
							 * Filling all more product info fields with response data.
							 */
							if ( data.data.thumbnail != '' ) {	// If thumbnail is not empty.
								$( '.cwp-more-info__image' ).html( data.data.thumbnail );
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
			    			break;

						case false: 	// If we have some errors.
			    			console.log( data.data.message );	// Show errors in console.

			    		default: 	// Default variant.
			    			console.log( 'Unknown error!' );	// Show message of unknown error in console.
			    			break;
					}
				} );

				$( '.cwp-more-info-wrapper' ).css( 'display', 'block' );	// Show more info block.
				isActiveAjax = false;	// User can use ajax ahead.
			}
		} );
	} );

} );