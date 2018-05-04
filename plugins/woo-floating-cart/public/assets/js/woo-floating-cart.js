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
			var singleAddToCartBtn, cartBody, cartList, cartTotal, cartTrigger, cartCount, cartSpinner, cartError, undo, cartErrorTimeoutId, undoTimeoutId, addTimeoutId;
			var cartActive = false;
			var cartTransitioning = false;
			var updatingNativeCart = false;
			var updatingWoofc = false;
			var hasErrors = false;
			
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
			
						
			var triggerevent = cartWrapper.attr('data-triggerevent');
			var hoverdelay = cartWrapper.attr('data-hoverdelay') ? cartWrapper.attr('data-hoverdelay') : 0;

			if(isTouch && triggerevent === 'mouseenter') {
				triggerevent = 'vclick';
			}

			//add product to cart
			$(document.body).on('added_to_cart', function(evt, fragments, cart_hash, btn){
				
				addToCart(btn, fragments);
					
			});

			//single add product to cart
			$(document).on('click', singleAddToCartBtn.selector, function(evt){
				
				var btn = $(this);
				
				if(!skipAddToCart(btn)) {
	
					evt.preventDefault();
					evt.stopPropagation();
	
					if(validateAddToCart(btn)) {
						addToCart(btn);
					}
				}
			});
			
			// Update WooFC cart on woocommerce update events
			$(document.body).on('updated_wc_div updated_cart_totals applied_coupon removed_coupon', function(){
				
				if(!updatingNativeCart) {
					refreshCart();
				}
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
							
			if(triggerevent === 'mouseenter') {

				var mouseEnterTimer;
				cartTrigger.on('mouseenter', function(evt){
						
				    mouseEnterTimer = setTimeout(function () {
					    
					    if(!cartActive && !cartTransitioning) {
							evt.preventDefault();
							toggleCart();
						}	
				        
				    }, hoverdelay);
				    
				}).on("mouseleave", function() {
					
				    clearTimeout(mouseEnterTimer);
				});

			}	

	
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
				if(undoTimeoutId) {
					clearInterval(undoTimeoutId);
				}
				evt.preventDefault();
				
				var timeout = 0;
				
				var product = cartList.find('.woofc-deleted');
				
				product.each(function(i) {
				
					var $this = $(this);
					
					timeout = timeout + 300;
					
					setTimeout(function() {
						
						$this.addClass('woofc-undo-deleted');
						
					}, timeout);
		
				});
	
				animationEnd(product, true, function(el) {
					
					el.removeClass('woofc-deleted woofc-undo-deleted').removeAttr('style');
		
					var key = undo.data('key');
			
					undoProductRemove(key, function() {
						
						$( document.body ).trigger( 'woofc_undo_product_remove', [ key ] );
						
					});
					refreshCartVisibility();
					
				});
					
				setTimeout(function() {				
					undo.removeClass('woofc-visible');
				});

			});
			
			

			var default_txt = '';
			if(singleAddToCartBtn.length > 0) {
				default_txt = singleAddToCartBtn.html();
					
				if(default_txt !== '') {
					singleAddToCartBtn.html(WOOFC.lang.wait);
				}
				singleAddToCartBtn.data('loading', true).addClass('loading');
			}
			
			refreshCartCountSize();
			
			refreshCart(function() {
				
				if(singleAddToCartBtn.length) {
					singleAddToCartBtn.removeData('loading').removeClass('loading');
					if(default_txt !== '') {
						singleAddToCartBtn.html(default_txt);
					}
				}
			
				$('body').addClass('woofc-ready');
				
				$(document).trigger('woofc_ready');
			});
		
		}
		
		function initVars() {
			
			singleAddToCartBtn = $('form .single_add_to_cart_button, .variations .single_add_to_cart_button');
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
		
		function skipAddToCart(btn) {
		console.log(btn.closest('.wc-product-table').length)
			if(btn.hasClass('gform_button') || btn.closest('.wc-product-table').length) {
				
				return true;
			} 
			
			return false;
		}
		
		function validateAddToCart(btn) {
			
			var form = btn.closest('form');
			var errors = 0;
			form.find('.required-product-addon').each(function() {
		    	var addon = $(this);
				var input = $(this).find('input');
		    	if(input.length > 1) {
			    	addon.removeClass('woofc-error');
		    		if(!input.is(':checked')) {
						errors++;
						addon.addClass('woofc-error');
					}
		    	}else{
			    	addon.removeClass('woofc-error');
					if(input.val() === '') {
						errors++;
						addon.addClass('woofc-error');
		        	}
		    	}
			});
			
			if(errors > 0) {
				var firstError = form.find('.required-product-addon.woofc-error').first();
				$('html,body').animate({scrollTop: firstError.offset().top - 100}, 500);
			}
			
		    return (errors === 0);
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
			
			fragments = typeof(fragments) !== 'undefined' ? fragments : null;
		
			if(addTimeoutId){
				clearInterval(addTimeoutId);
			}
			
			if(trigger.data('loading') || updatingWoofc) {
				return false;
			}
			
			var type;
			var single = trigger.hasClass('single_add_to_cart_button');
			var single_variation = false;
			
			if(single) {
				single_variation = trigger.closest('.variations').length;
			}
			
			var args = {};
			
			trigger.removeClass('added');
			
			if(!single || fragments) {
				
				type = 'add';
				args = {
					fragments: fragments
				};
				
			}else{
				
				type = 'single-add';
				var form = trigger.closest('form');
				args = form.serializeJSON();
				
				if(typeof args === 'string') {
					args = $.parseJSON(args);
				}
				
				if(typeof args === 'object') {
					args['add-to-cart'] = form.find('[name="add-to-cart"]').val();
				}
			}

			
			trigger.data('loading', true);
			trigger.addClass('loading');
			
			//update cart product list
			request(type, args, function(data) {
				
				if(!hasErrors) {
					
					if(cartWrapper.attr('data-flytocart') === '1') {
						
						animateAddToCart(trigger, single, single_variation);
						
					}else if(!single_variation){
						
						animateCartShake();
					}
					
					trigger.removeClass('loading').addClass('added');
					trigger.removeData('loading');
			
					$( document.body ).trigger( 'woofc_added_to_cart', [ data ] );
			
					addTimeoutId = setTimeout(function() {
						trigger.removeClass('added');
					}, 3000);
					
				}else{
					
					trigger.removeClass('loading');
					trigger.removeData('loading');
				}

			});
	
			//show cart
			refreshCartVisibility();
		}

		function animateAddToCart(trigger, single, single_variation) {
			
			var item = null;
			var productsContainer = $('body');
			var position = cartWrapper.attr('data-position');
			
			if(!single) {
				
				item = findLoopImage(trigger);

			}else{
				
				item = findSingleImage(trigger);
			
				if(item && item.length === 0) {
					
					var id_input = productsContainer.find('input[name="add-to-cart"]');
					
					if(id_input.length) {
						
						var product_id = id_input.val();
						
						trigger = $('.add_to_cart_button[data-product_id="'+product_id+'"]');
						
						if(trigger.length) {
							animateAddToCart(trigger, single, single_variation);
							return false;
						}	
					}	
					
				}else if(!single_variation){
					
					animateCartShake();
				}	
			}	

			if(!item || item.length === 0) {
	
				return false;
			}

			var itemPosition = item.offset();
			var triggerPosition = cartTrigger.offset();
			
			
			var defaultState = {
				opacity: 1,
				top: itemPosition.top,
				left: itemPosition.left,
				width: item.width(),
				height: item.height(),
				transform: 'scale(1)'
			};
			
			var top_dir = 0;
			var left_dir = 0;
		
			if(position === 'bottom-right') {
				
				top_dir = -1;
				left_dir = -1;
				
			}else if(position === 'bottom-left') {
				
				top_dir = -1;
				left_dir = 1;
				
			}else if(position === 'top-right') {
				
				top_dir = 1;
				left_dir = -1;
				
			}else if(position === 'top-left') {
				
				top_dir = 1;
				left_dir = 1;
			}		

			var animationState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2) + (trigger.height() * top_dir),
			    left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2) + (trigger.width() * left_dir),
			    opacity: 0.9,
			    transform: 'scale(0.5)'
			};
			
			var inCartState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2),
			    left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2),				
			    opacity: 0,
			    transform: 'scale(0)'
			};


			var duplicatedItem = item.clone();
			duplicatedItem.find('.add_to_cart_button').remove();
			duplicatedItem.css(defaultState);
			duplicatedItem.addClass('woofc-fly-to-cart');
			
			duplicatedItem.appendTo(productsContainer);
			
			var flyAnimationDuration = cartWrapper.attr('data-flyduration') ? cartWrapper.attr('data-flyduration') : 650;
			flyAnimationDuration = (parseInt(flyAnimationDuration) / 1000);

			TweenLite.to(duplicatedItem, flyAnimationDuration, { css: animationState, ease: Power3.easeOut, onComplete:function() {
					
				TweenLite.to($(this.target), (flyAnimationDuration * 0.8), { css: inCartState, ease: Power3.easeOut, onComplete: function() {
				
					$(this.target).remove();
							
					animateCartShake();
	
				}});		
			
			}});

		}
		
		function animateCartShake() {
			
			var shakeClass = cartWrapper.attr('data-shaketrigger');
			
			if(shakeClass !== '') {
				cartTrigger.addClass('woofc-shake-'+shakeClass);
				
				animationEnd(cartTrigger, false, function(_trigger) {
					_trigger.removeClass('woofc-shake-'+shakeClass);
					
					if(cartWrapper.attr('data-opencart-onadd') === '1') {
						toggleCart(false);
					}	
		
				});
			}
		}
		
		function findLoopImage(trigger) {
			
			var item = null;
			
			if(trigger.closest('.product').length) {
				
				var product = trigger.closest('.product');
				
				if(product.find('.attachment-woocommerce_thumbnail').length) {
					
					item = product.find('.attachment-woocommerce_thumbnail');
					
				}else{
					
					item = product;
				}
			}
			
			return item;
				
		}
				
		function findSingleImage(trigger) {
			
			var item = null;
			
			// If Woo Product Table, Find Row Image 
			if(trigger.closest('.product-row').find('.product-table-image').length) {
					
				item =  trigger.closest('.product-row').find('.product-table-image');
				
			// If Woo Product Table, Find Row Image 
			}else if(trigger.closest('.variations').find('.image_link img').length) {
					
				item = trigger.closest('.variations').find('.image_link img');
				
			// Find image in Woo Quick View Modal
			}else if(trigger.closest('.woo-quick-view').length) {
					
				item = $('.wooqv-slider-wrapper');
			
			// Find image in Product Quick View Modal
			}else if(trigger.closest('.product-quick-view-container').length) {
				
				item = trigger.closest('.product-quick-view-container').find('.slide.first img');
			
			// Find image in single product page	
			}else if(trigger.closest('.product').length) {
				
				var product = trigger.closest('.product');
				
				if(product.find('.images img.attachment-shop_single').length) {
					
					item = product.find('.images img.attachment-shop_single').first();
				
				}else if(product.find('.magic-slide').length) {
				
					item = product.find('.magic-slide');
			
				}else if(product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').length) {	
					
					item = product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').first();
					
				}else if(product.find('.images img').length) {
					
					item = product.find('.images img').fisrt();
				}
			}
			
			return item;	
		}
        		
		function request(type, args, callback) {
			
			hasErrors = false;
				
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

			if(type === 'single-add') {
				
				$('.woocommerce-error').remove();
				
				$.woofcAjaxQueue({
					
					url: location.href,
					data: params,
					type: 'post'
					
				}).done(function(data) {
						
					if(data && $(data).find('.woocommerce-error').length > 0) {
						hasErrors = true;
						$('#product-'+params['add-to-cart']).before($(data).find('.woocommerce-error'));
						onRequestDone(data, 'single-error', callback);
					}
				});	
				
				refreshFragments(type, callback);
				
			}else{

				$.woofcAjaxQueue({
					
					url: WOOFC.ajaxurl,
					data: params,
					type: 'post'
					
				});	
				
				refreshFragments(type, callback);
				
			}	
		}
		
		function refreshFragments(type, callback) {
	
			$.woofcAjaxQueue({
				url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
				type: 'post', 
				success: function(data) {
				
					onRequestDone(data, type, callback);
				}
			});
		}
		
		function onRequestDone(data, type, callback) {

			if(type !== 'single-error'){
	
				if(type === 'remove' || type === 'undo') {
					
					$.each( data.fragments, function( key, value ) {
						
						if(key === 'woofc') {

							//update total price
							updateCartTotal(value.subtotal);
							
							//update number of items 
							updateCartCount(value.total_items);
							
						}else if((key.search('.woofc') !== -1)){
							
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
			}
			
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
				
				if(product.length > 0) {
					
					var isBundle = product.hasClass('woofc-bundle');
					var isComposite = product.hasClass('woofc-composite');
					var topPosition = product.offset().top - cartBody.children('ul').offset().top;
					var selector = '';
					
					product.css('top', topPosition+'px');
				
				}
				
				var timeout = 0;
				if(isBundle || isComposite) {

					var group_id = product.data('key');
					
					if(isBundle) {
						selector = '.woofc-bundled-item[data-group="'+group_id+'"]';
					}else{
						selector = '.woofc-composite-item[data-group="'+group_id+'"]';
					}	
				
					var groupedProducts = $(cartList.find(selector).get().reverse());
					
					groupedProducts.addClass('woofc-deleted');	
				}
				setTimeout(function() {
					product.addClass('woofc-deleted');
					refreshCartVisibility();
				}, timeout);

				undo.data('key', key).addClass('woofc-visible');
			
				$( document.body ).trigger( 'woofc_product_removed', [ key ] );

		
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


		$(document).ready(function() {
			
					
			if(typeof(wp) !== 'undefined' && typeof(wp.customize) !== 'undefined' && typeof(wp.customize.preview) !== 'undefined') {
	            
	            wp.customize.value('woofc[cart_product_show_bundled_products]').bind( function() {
	                
	                top.wp.customize.previewer.save();
	            });
	            
	            wp.customize.value('woofc[cart_product_show_composite_products]').bind( function() {
	                
	                top.wp.customize.previewer.save();
	            });
	            
	            wp.customize.value('woofc[cart_product_show_attributes]').bind( function() {
	                
	                top.wp.customize.previewer.save();
	            });

	            wp.customize.value('woofc[cart_product_attributes_hide_label]').bind( function() {
	                
	                top.wp.customize.previewer.save();
	            });
	            
	            wp.customize.preview.bind( 'saved', function() {
		            
	                refreshCart();
	            });
			}
		
		});
		
		window.woofc_refresh_cart = refreshCart;
	});


})( jQuery, window );
