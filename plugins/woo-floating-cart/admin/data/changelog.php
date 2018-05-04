<?php

return array(

	array(
		'version' => '1.1.2',
		'date' =>'03.25.2018',
		'changes' => array(
			'fix' => array(
				'Fix fly to cart animation to try and only animate the image without the whole container',
				'Fix conflict with 2 different serializeJSON libraries',
				'Fix javascript error on some shop pages, especially when using Dokan plugin',
				'Bypass add to cart buttons within gravity forms so they can work as usual.'
			),
			'support' => array(
				'Support Woo Product Table Plugin'
			)			
		)
	),

	array(
		'version' => '1.1.1',
		'date' =>'01.15.2018',
		'changes' => array(

			'support' => array(
				'Support Woo Variations Table Plugin'
			)			
		)
	),
	
	array(
		'version' => '1.1.0',
		'date' =>'11.25.2017',
		'changes' => array(

			'support' => array(
				'Wordpress v4.9 Customizer Support'
			),
			'enhance' => array(
				'Added Ajax queue system faster and more reliable Ajax requests',
			)				
		)
	),
	
	array(
		'version' => '1.0.9.5',
		'date' =>'10.24.2017',
		'changes' => array(

			'fix' => array(
				'Fix compatibility issue with the X Theme'
			),
			'support' => array(
				'Better theme compatibility'
			)				
		)
	),
	
	array(
		'version' => '1.0.9.4',
		'date' =>'11.10.2017',
		'changes' => array(

			'fix' => array(
				'Fix bundled items removal issue with Composite / Bundled products',
				'Replace deprecated functions',
			),
			'enhance' => array(
				'Disable the Single Add To Cart button until the floating cart is ready',
			)					
		)
	),
	
	array(
		'version' => '1.0.9.3',
		'date' =>'25.09.2017',
		'changes' => array(

			'fix' => array(
				'Better compatibility with Composite and Bundled products',
			)				
		)
	),
	
	array(
		'version' => '1.0.9.2',
		'date' =>'07.07.2017',
		'changes' => array(

			'fix' => array(
				'Fix multiple domain license check bug',
			)				
		)
	),
	
	array(
		'version' => '1.0.9.1',
		'date' =>'21.06.2017',
		'changes' => array(

			'new' => array(
				'Added option to show / hide bundled products for WooCommerce Product Bundles plugin'
			),
			'support' => array(
				'Support WooCommerce Product Bundles plugin'
			)					
		)
	),
	
	array(
		'version' => '1.0.9',
		'date' =>'16.06.2017',
		'changes' => array(

			'fix' => array(
				'Fix product attributes display issue if attribute value is set to "Any"',
			),
			'update' => array(
				'Template changes: <strong>/templates/parts/cart/list/product.php</strong>',
				'Template changes: <strong>/templates/parts/cart/list/product/variations.php</strong>',
			)				
		)
	),
	
	array(
		'version' => '1.0.8.9',
		'date' =>'07.06.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with product remove not updating subtotal on first try',
			)				
		)
	),
	
	array(
		'version' => '1.0.8.8',
		'date' =>'20.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed deprecated function warnings caused by WooCommerce v3.0.x',
			),
			'update' => array(
				'Template changes: <strong>/templates/parts/cart/list/product/thumbnail.php</strong>',
			)				
		)
	),
	
	array(
		'version' => '1.0.8.7',
		'date' =>'19.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with products not adding to cart right after removing a product',
			)				
		)
	),
	
	array(
		'version' => '1.0.8.6',
		'date' =>'18.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with having to click twice to remove a product after adding it',
			),
			'enhance' => array(
				'Changed the <strong>Checkout</strong> label to <strong>Cart</strong> in go to cart mode',
			)				
		)
	),
	
	array(
		'version' => '1.0.8.5',
		'date' =>'11.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed intermittent 502 error with ajax requests',
				'Fixed fly to cart animation from <a target="_blank" href="http://xplodedthemes.com/products/woo-quick-view/">Woo Quick View</a> modal'
			)				
		)
	),
	
	array(
		'version' => '1.0.8.4',
		'date' =>'10.04.2017',
		'changes' => array(
			
			'new' => array(
				'Added option to display product attributes as a list or inline',
				'Added option to hide product attributes labels',
				'Added option to automatically open the cart after adding a product'
			),
			'fix' => array(
				'Fixed product attributes display on WooCommerce v3.x.x'
			),
			'update' => array(
				'Template changes: <strong>/templates/parts/cart/list/product/variations.php</strong> and <strong>/templates/parts/cart/list/product.php</strong>',
			)			
		)
	),
	
	array(
		'version' => '1.0.8.3',
		'date' =>'10.04.2017',
		'changes' => array(

			'new' => array(
				'Added option to resize default cart width and height',
			),
			'enhance' => array(
				'Better trigger icon animation when trigger position is set to Top Left or Top Right',
			),
			'fix' => array(
				'Fixed issue with some third party quick view modals add to cart button infinite loading.',
				'Fixed single post fly to cart animation on WooCommerce v3.x.x'
			),
			'update' => array(
				'Template changes: <strong>/templates/minicart.php</strong> and <strong>/templates/parts/cart/footer.php</strong>',
			)			
		)
	),
	
	array(
		'version' => '1.0.8.2',
		'date' =>'04.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with Remove / Undo cart total not updating sometimes.',
				'Fixed issue with local license being reset by it self.'
			)			
		)
	),
	
	array(
		'version' => '1.0.8.1',
		'date' =>'16.03.2017',
		'changes' => array(

			'new' => array(
				'Added color and typography customization options for the newly added error message',
			),
			'support' => array(
				'Supports WooCommerce Currency Converter Widget'
			),	
			'enhance' => array(
				'Show error message within cart header whenever product quantity has reached stock limit or a minimum quantity is required.',
				'Show woocommerce error messages within single product pages if ajax add to cart request failed for X reason'
			)			
		)
	),
	
	array(
		'version' => '1.0.8',
		'date' =>'15.03.2017',
		'changes' => array(
			
			'new' => array(
				'Auto sync cart content with third party mini cart plugins or within themes.',
				'Added global javascript function woofc_refresh_cart() for developers to force cart refresh within plugins or themes.'			
			),
			'support' => array(
				'Added support for <a target="_blank" href="http://xplodedthemes.com/products/woo-quick-view/">Woo Quick View</a> Plugin',
				'Added Support for caching plugins'
			),	
			'fix' => array(
				'Fix cart issues on non woocommerce pages.'
			)			
		)
	),
	
	array(
		'version' => '1.0.7',
		'date' =>'17.02.2017',
		'changes' => array(
			
			'new' => array(
				'Sync cart with native WooCommerce cart page on Add, remove, update products',
				'Fly to cart animation now works on single product pages and within Quick View plugins'			
			),
			'support' => array(
				'Added support for Yith Product Addons Plugin',
				'Better support for third party plugins',
			),	
			'enhance' => array(
				'Centralize template output functions'
			),	
			'fix' => array(
				'Fixed customizer issue with checkout background color not being changed'
			)			
		)
	),
	
	array(
		'version' => '1.0.6',
		'date' =>'11.02.2017',
		'changes' => array(
			
			'new' => array(
				'Added Product Variations Support',
				'Added option to display product attributes within the cart',
				'Added option to select between Subtotal or Total to be displayed within the checkout button',
				'Added option to hide the WooCommerce “View Cart” link that appears after adding an item to cart'				
			),
			'enhance' => array(
				'Better theme compatibility'
			),				
		)
	),
	
	array(
		'version' => '1.0.5.1',
		'date' =>'30.01.2017',
		'changes' => array(
			'fix' => array(
				'Fixed weird issue with customizer fields visibility on WordPress 4.7.2',
				'Fixed issue with Customizer Typography fields not being displayed'
			)	
		)
	),
	
	array(
		'version' => '1.0.5',
		'date' =>'26.01.2017',
		'changes' => array(
			'new' => array(
				'Added option to change the checkout link to redirect to the cart page instead.',
				'Added option to trigger the cart on Mouse Over with optional delay',
				'Added Device Visibility options'
			)	
		)
	),
	
	array(
		'version' => '1.0.4.1',
		'date' =>'19.01.2017',
		'changes' => array(
			'fix' => array(
				'Fixed minor bug with add to cart button when used with third party gift card plugins',
				'Fixed bug with customizer sections being hidden on some themes due to a conflict'
			)	
		)
	),
	array(
		'version' => '1.0.4',
		'date' =>'10.01.2017',
		'changes' => array(
			'new' => array(
				'Ajax Add to cart now supported on single shop pages and within product quick views'
			),
			'enhance' => array(
				'License System now allows the same purchase code to be valid within a multisite setup.<br>1 License: unlimited domains, subdomains, folders as long as as it is under a multisite.'
			),
			'fix' => array(
				'Fixed WooCommerce installation check notice'
			)	
		)
	),
	array(
		'version' => '1.0.3',
		'date' =>'16.12.2016',
		'changes' => array(
			'new' => array(
				'Now supports RTL'
			),
			'fix' => array(
				'Minor CSS fix with Fly to cart animation'
			)	
		)
	),	
	array(
		'version' => '1.0.2',
		'date' =>'30.11.2016',
		'changes' => array(
			'new' => array(
				'Added 11 different loading spinners (optional)',
				'Added new Fly To Cart animation (optional)',
				'Added option to exclude pages from displaying the cart'
			),
			'fix' => array(
				'Allow html in product titles',
				'License validation Fix'
			)	
		)
	),
	array(
		'version' => '1.0.1',
		'date' =>'02.11.2016',
		'changes' => array(
			'new' => array(
				'Added hover background / color option to checkout button.'
			),
			'enhance' => array(
				'Replaced click with click event for faster taps on mobile.'
			),	
			'update' => array(
				'Updated Translation Files'	
			),
			'fix' => array(
				'Removed hover effect on mobile for faster response',
				'Fixed bug with checkout button typography options',
				'Minor CSS Fixes'
			)	
		)
	),
	array(
		'version' => '1.0.0',
		'date' =>'01.11.2016',
		'changes' => array(
			'initial' => 'Initial Version'
		)
	)
);