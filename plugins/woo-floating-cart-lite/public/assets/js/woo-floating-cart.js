(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	*/
	
	$(function() {

		// wc_cart_fragments_params is required to continue, ensure the object exists
		if ( typeof wc_cart_fragments_params === 'undefined' ) {
			return false;
		}
					
		var cartWrapper = $('.woofc');
	
		if( cartWrapper.length > 0 ) {
			
			var isTouch = touchSupport();
			
			//store jQuery objects
			var cartBody, cartList, cartTotal, cartTrigger, cartCount, cartSpinner, cartError, undo, cartErrorTimeoutId, undoTimeoutId, addTimeoutId;
			var undoTimeoutId;
			var addTimeoutId;
			var cartActive = false;
			var cartTransitioning = false;
			var updatingNativeCart = false;
			var updatingWoofc = false;

			initVars();


			/* Storage Handling */
			var $supports_html5_storage;
			var cart_hash_key = wc_cart_fragments_params.ajax_url.toString() + '-wc_cart_hash';
		
			try {
				$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
				window.sessionStorage.setItem( 'wc', 'test' );
				window.sessionStorage.removeItem( 'wc' );
				window.localStorage.setItem( 'wc', 'test' );
				window.localStorage.removeItem( 'wc' );
			} catch( err ) {
				$supports_html5_storage = false;
			}
			
					
			//add product to cart
			$(document.body).on('added_to_cart', function(evt, fragments, cart_hash, btn){

				addToCart(btn, fragments);
			});


			// Update WooFC cart on woocommerce update events
			$(document.body).on('updated_wc_div updated_cart_totals applied_coupon removed_coupon', function(){
				
				if(!updatingNativeCart) {
					refreshCart();
				}
			});
			
			// Update Cart List Obj
			$(document.body).on('wc_fragments_refreshed', function() {
				cartList = cartBody.find('ul').eq(0);
				cartTotal = cartWrapper.find('.woofc-checkout').find('span.amount');
			});
						
			// Update Native Cart
			
			if($('body').hasClass('woocommerce-cart')) {
					
				$(document.body).on('woofc_product_update woofc_product_removed woofc_undo_product_remove', function() {
					if(!updatingWoofc) {
						
						updatingNativeCart = true;
						
						// Update woocommerce cart page
						$(document.body).trigger('wc_update_cart');
		
						$(document).ajaxComplete(function(e, xhr, options) {
						    if (options.url === wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' )) { // Or whatever test you may need
						        updatingNativeCart = false;	
						        $(e.currentTarget).unbind('ajaxComplete');
						    }
						});
					}
				});
			
			}
			
			// Update Cart List Obj
			$(document.body).on('wc_fragments_refreshed', function() {
				
				initVars();
				
				if($('body').hasClass('woocommerce-checkout')) {
					$(document.body).trigger('update_checkout');
				}
			});				
			

			//open/close cart
			cartTrigger.on('vclick', function(evt){
				evt.preventDefault();
				if(!cartTransitioning) {
					toggleCart();
				}
			});
	
			//close cart when clicking on the .woofc::before (bg layer)
			cartWrapper.on('vclick', function(evt){
				if( $(evt.target).is($(this)) ) {
					toggleCart(true);
				}	
			});
	
			//delete an item from the cart
			cartBody.on('vclick', '.woofc-delete-item', function(evt){
				evt.preventDefault();
				
				var key = $(evt.target).parents('.woofc-product').data('key');
				removeProduct(key);
			});
	
			//update item quantity
				
			$( document ).on('change', '.woofc-quantity input', function() {
				
				var $parent = $(this).parent();
				var min = parseFloat( $( this ).attr( 'min' ) );
				var max	= parseFloat($( this ).attr( 'max' ) );
				
				if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
					
					$( this ).val( min );
					showError(WOOFC.lang.min_qty_required, $parent);
					
				}else if ( max && max > 0 && parseFloat( $( this ).val() ) > max ) {
					
					$( this ).val( max );
					showError(WOOFC.lang.max_stock_reached, $parent);
					
				}
				
				var product = $(this).closest('.woofc-product');
				var qty = $(this).val();
				var key = product.data('key');
				
				updateProduct(key, qty);
				
			});
		

			$( document ).on( 'vclick', '.woofc-quantity-up, .woofc-quantity-down', function(evt) {
				
				evt.preventDefault();
				
				// Get values
				 
				var $parent 	= $( this ).closest( '.woofc-quantity' ),
					$qty		= $parent.find( 'input' ),
					currentVal	= parseFloat( $qty.val() ),
					max			= parseFloat( $qty.attr( 'max' ) ),
					min			= parseFloat( $qty.attr( 'min' ) ),
					step		= $qty.attr( 'step' ),
					newQty		= currentVal;
		
				// Format values
				if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) {
					currentVal = 0;
				}	
				if ( max === '' || max === 'NaN' ) {
					max = '';
				}	
				if ( min === '' || min === 'NaN' ) {
					min = 0;
				}	
				if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) {
					step = 1;
				}	

		
				// Change the value
				if ( $( this ).is( '.woofc-quantity-up' ) ) {
		
					if ( max && ( max === currentVal || currentVal > max ) ) {
						newQty = ( max );
						showError(WOOFC.lang.max_stock_reached, $parent);
					} else {
						newQty = ( currentVal + parseFloat( step ) );
					}
		
				} else {
		
					if ( min && ( min === currentVal || currentVal < min ) ) {
						newQty = ( min );
						showError(WOOFC.lang.min_qty_required, $parent);
					} else if ( currentVal > 0 ) {
						newQty = ( currentVal - parseFloat( step ) );
					}
		
				}

				// Trigger change event

				var product = $qty.closest('.woofc-product');
				var key = product.data('key');
					
				if(currentVal !== newQty) {	
					
					// Update product quantity
					updateProduct(key, newQty);
				}
			
			});
			
	
			//reinsert item deleted from the cart
			undo.on('vclick', 'a', function(evt){

				evt.preventDefault();
				var product = cartList.find('.woofc-deleted');
				product.addClass('woofc-undo-deleted');
				
				animationEnd(product, true, function(el) {
					
					el.removeClass('woofc-deleted woofc-undo-deleted').removeAttr('style');
		
					var key = undo.data('key');
			
					undoProductRemove(key, function() {
						
						$( document.body ).trigger( 'woofc_undo_product_remove', [ key ] );
						
					});
					refreshCartVisibility();
				});
				undo.removeClass('woofc-visible');
			});

		}
		
		function initVars() {
			
			cartBody = cartWrapper.find('.woofc-body');
			cartList = cartBody.find('ul').eq(0);
			cartTotal = cartWrapper.find('.woofc-checkout').find('span.amount');
			cartTrigger = cartWrapper.find('.woofc-trigger');
			cartCount = cartTrigger.find('.woofc-count');
			cartSpinner = cartWrapper.find('.woofc-spinner-wrap');
			cartError = cartWrapper.find('.woofc-cart-error');
			undo = cartWrapper.find('.woofc-undo');
		}
		
		function transitionEnd(el, once, callback) {
			
			var events = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
			
			if(once) {
				
				el.one(events, function() {

					$(this).off(events);
					
					//evt.preventDefault();
					callback($(this));
				});
			
			}else{
				
				el.on(events, function() {
					
					$(this).off(events);
					
					//evt.preventDefault();
					callback($(this));
				});
			} 
		}
		
		function animationEnd(el, once, callback) {
			
			var events = 'webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend';
			
			if(once) {
				
				el.one(events, function() {

					$(this).off(events);
					
					//evt.preventDefault();
					callback($(this));
				});
			
			}else{
				
				el.on(events, function() {
					
					$(this).off(events);
					
					//evt.preventDefault();
					callback($(this));
				});
			} 
		}

		function toggleCart(bool) {
			
			cartTransitioning = true;
			var cartIsOpen = ( typeof bool === 'undefined' ) ? cartWrapper.hasClass('woofc-cart-open') : bool;
			
			if( cartIsOpen ) {
				cartWrapper.removeClass('woofc-cart-open');
				cartActive = false;
				
				//reset undo
				resetUndo();	
	
				setTimeout(function(){
					cartBody.scrollTop(0);
					//check if cart empty to hide it
					refreshCartVisibility();
				}, 500);
				
			} else {
				cartWrapper.addClass('woofc-cart-open');
				cartActive = true;
			}
			
			transitionEnd(cartWrapper, true, function() {
				cartTransitioning = false;
				if( !cartIsOpen ) {
					cartWrapper.addClass('woofc-cart-opened');
				}else{
					cartWrapper.removeClass('woofc-cart-opened');
				}	
			});
		}

		function addToCart(trigger, fragments) {
			
			if(addTimeoutId){
				clearInterval(addTimeoutId);
			}
			
			if(trigger.data('loading') || updatingWoofc) {
				return false;
			}
			
			var args = {
				fragments: fragments
			};

			trigger.removeClass('added');

			trigger.data('loading', true);
			trigger.addClass('loading');
			
			//update cart product list
			request('add', args, function(data) {
				
				trigger.removeClass('loading').addClass('added');
				trigger.removeData('loading');
				
				$( document.body ).trigger( 'woofc_added_to_cart', [ data ] );
				
				addTimeoutId = setTimeout(function() {
					trigger.removeClass('added');
				}, 3000);
			});
	
			//show cart
			refreshCartVisibility();
		}
	
		function request(type, args, callback) {
			
			$('html').addClass('woofc-loading');
			
			if($('body').hasClass('woocommerce-cart')) {
				
				if(updatingWoofc) {
					return false;
				}
				updatingWoofc = true;
			}
			
			if(type !== 'remove' && type !== 'undo') {
				Cookies.remove('woofc_last_removed');
				undo.removeClass('woofc-visible');
			}
			
			if(type === 'refresh') {
				
				refreshFragments(type, callback);
				return false;
				
			}else if(type === 'add') {
				
				onRequestDone(args, type, callback);
				return false;
			}
			
			var params = {
				action: 'woofc_update_cart',
				type: type
			};

			params = $.extend(params, args);

			$.woofcAjaxQueue({
				url: WOOFC.ajaxurl,
				data: params,
				type: 'post'
			});	
			
			refreshFragments(type, callback);
			
		}
		
		function refreshFragments(type, callback) {
			
			var refresh_fragments = {
				url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
				type: 'post', 
				success: function(data) {
				
					onRequestDone(data, type, callback);
				}
			};	
			
			$.woofcAjaxQueue(refresh_fragments);
		}
		
		function onRequestDone(data, type, callback) {

			if(type === 'remove' || type === 'undo') {
				
				$.each( data.fragments, function( key, value ) {
					
					if(key === 'woofc') {

						//update total price
						updateCartTotal(value.subtotal);
						
						//update number of items 
						updateCartCount(value.total_items);
						
					}else if((key.search('.woofc') === -1)){
						
						$( key ).replaceWith( value );
					}
				});
				
			}else{
				
				$.each( data.fragments, function( key, value ) {
					
					if(key !== 'woofc') {
						
						$( key ).replaceWith( value );
					}
				});
				
			}

			if ( $supports_html5_storage ) {
				sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( data.fragments ) );
				set_cart_hash( data.cart_hash );

				if ( data.cart_hash ) {
					set_cart_creation_timestamp();
				}
			}
							
			$( document.body ).trigger( 'wc_fragments_refreshed' );
			
			refreshCartVisibility();

			var loadingTimout = cartWrapper.attr('data-loadingtimeout') ? parseInt(cartWrapper.attr('data-loadingtimeout')) : 0;
		
			setTimeout(function() {
				$('html').addClass('woofc-stoploading');
				setTimeout(function() {
					$('html').removeClass('woofc-loading woofc-stoploading');
					
					if(typeof(callback) !== 'undefined') {
						callback(data);
					}
			
				}, loadingTimout);	
			}, 100);	
			
			updatingWoofc = false;
					
		}
		
		function updateProduct(key, qty, callback) {
			
			if(qty > 0) {
				
				request('update', {
					
					cart_item_key: key,
					cart_item_qty: qty
					
				}, function(data) {
					
					$( document.body ).trigger( 'woofc_product_update', [ key, qty ] );
					
					if(typeof(callback) !== 'undefined') {
						callback(data);
					}
					
				});
				
			}else{
				removeProduct(key, callback);
			}
		}
		
		function removeProduct(key, callback) {
		
			resetHeaderMessages();
		
			var in8Seconds = new Date();
			in8Seconds.setTime(in8Seconds.getTime()+(8*1000));
			
			Cookies.set('woofc_last_removed', {
				'key': key,
				'html': cartList.find('.woofc-deleted'),
				'position': cartList.find('.woofc-deleted').index()
			},
			{
			    expires: in8Seconds
			});
		
			request('remove', {
				
				cart_item_key: key
				
			}, function() {

				resetUndo();
			
				var product = cartList.find('li[data-key="'+key+'"]');
				var topPosition = product.offset().top - cartBody.children('ul').offset().top;
				
				product.css('top', topPosition+'px');
				product.addClass('woofc-deleted');
				undo.data('key', key).addClass('woofc-visible');
				
				$( document.body ).trigger( 'woofc_product_removed', [ key ] );
				
				refreshCartVisibility();
		
				//wait 8sec before completely remove the item
				undoTimeoutId = setTimeout(function(){
					
                    resetUndo();
					
					if(typeof(callback) !== 'undefined') {
						callback();
					}
					
				}, 8000);
			
			});
		}

		function resetUndo() {
			
			if(undoTimeoutId) {
				clearInterval(undoTimeoutId);
			}
			Cookies.remove('woofc_last_removed');
			undo.removeData('key').removeClass('woofc-visible');
			cartList.find('.woofc-deleted').remove();
		}
		
		function undoProductRemove(key, callback) {
			
			request('undo', {
				
				cart_item_key: key,
				
			}, callback);
		}

		function refreshCart(callback) {
			
			request('refresh', {}, callback);
		}
		
		function updateCartCount(quantity) {
			
			var emptyCart = cartWrapper.hasClass('woofc-empty');
			var next = quantity + 1;
	
			if( emptyCart ) {
				
				cartCount.find('li').eq(0).text(quantity);
				cartCount.find('li').eq(1).text(next);
				
			} else {

				cartCount.addClass('woofc-update-count');

				setTimeout(function() {
					cartCount.find('li').eq(0).text(quantity);
				}, 150);

				setTimeout(function() {
					cartCount.removeClass('woofc-update-count');
				}, 200);

				setTimeout(function() {
					cartCount.find('li').eq(1).text(next);
				}, 230);
			}
			
			refreshCartCountSize();
		}

		function updateCartTotal(total) {
			cartTotal = cartWrapper.find('.woofc-checkout').find('span.amount');
			cartTotal.html( total );
		}
		
		function refreshCartVisibility() {
		
			if( cartList.find('li:not(.woofc-deleted):not(.woofc-no-product)').length === 0) {
				cartWrapper.addClass('woofc-empty');
			}else{
				cartWrapper.removeClass('woofc-empty');
			}
			
		}
		
		function refreshCartCountSize() {
		
			var quantity = Number(cartCount.find('li').eq(0).text());	
					
			if(quantity > 99) {
				cartCount.addClass('woofc-count-big');
			}else{
				cartCount.removeClass('woofc-count-big');
			}
		}

		/* Cart session creation time to base expiration on */
		function set_cart_creation_timestamp() {
			if ( $supports_html5_storage ) {
				sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
			}
		}
	
		/** Set the cart hash in both session and local storage */
		function set_cart_hash( cart_hash ) {
			if ( $supports_html5_storage ) {
				localStorage.setItem( cart_hash_key, cart_hash );
				sessionStorage.setItem( cart_hash_key, cart_hash );
			}
		}

		function showError(error, elemToShake) {
	
			resetHeaderMessages();
			
			if(typeof(elemToShake) !== 'undefined') {
				elemToShake.removeClass('woofc-shake');
			}
			
			cartError.removeClass('woofc-shake woofc-visible');
			setTimeout(function() {
				
				cartError.text(error).addClass('woofc-visible');
			
				transitionEnd(cartError, true, function() {
					
					cartError.addClass('woofc-shake');
					
					if(typeof(elemToShake) !== 'undefined') {
						elemToShake.addClass('woofc-shake');
					}
					
					animationEnd(cartError, true, function() {
						
						cartError.removeClass('woofc-shake');
						
						cartErrorTimeoutId = setTimeout(function() {
							
							cartError.removeClass('woofc-visible');
							
						}, 5000);
					});
				});
			
			},100);

		}
		
		function resetHeaderMessages() {
			
			if(cartErrorTimeoutId) {
				clearInterval(cartErrorTimeoutId);
			}
			
			undo.removeClass('woofc-visible');
			cartError.removeClass('woofc-visible');
		}
		
		function touchSupport() {
			
			if ("ontouchstart" in document.documentElement) {
				$('html').addClass('woofc-touchevents');
				return true;
			}
			
			$('html').addClass('woofc-no-touchevents');
			
			return false;
		}	
						
		if( cartWrapper.length > 0 ) {
			
			refreshCartCountSize();
			
			refreshCart(function() {
				$('body').addClass('woofc-ready');
				
				$(document).trigger('woofc_ready');
			});
		}
		
		window.woofc_refresh_cart = refreshCart;

	});


})( jQuery, window );
