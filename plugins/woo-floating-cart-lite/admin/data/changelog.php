<?php

return array(

	array(
		'version' => '1.0.9',
		'date' =>'03.25.2018',
		'changes' => array(
			'support' => array(
				'Better theme compatibility'
			)			
		)
	),
	
	array(
		'version' => '1.0.8',
		'date' =>'11.25.2017',
		'changes' => array(

			'fix' => array(
				'Removed deprecated functions'
			),
			'support' => array(
				'Wordpress v4.9 Support'
			)			
		)
	),
	
	array(
		'version' => '1.0.7',
		'date' =>'26.09.2017',
		'changes' => array(

			'fix' => array(
				'Fix compatibility issue with the X Theme',
				'Replace deprecated functions'
			),
			'support' => array(
				'Better theme compatibility'
			)					
		)
	),
	
	array(
		'version' => '1.0.6.9',
		'date' =>'21.06.2017',
		'changes' => array(

			'fix' => array(
				'Disable bundled sub products when using WooCommerce Product Bundles plugin',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.8',
		'date' =>'07.06.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with product remove not updating subtotal on first try',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.7',
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
		'version' => '1.0.6.6',
		'date' =>'19.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with products not adding to cart right after removing a product',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.5',
		'date' =>'18.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with having to click twice to remove a product after adding it',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.4',
		'date' =>'11.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed intermittent 502 error with ajax requests',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.3',
		'date' =>'10.04.2017',
		'changes' => array(

			'enhance' => array(
				'Better trigger icon animation when trigger position is set to Top Left or Top Right',
			),
			'update' => array(
				'Template changes: <strong>/templates/minicart.php</strong> and <strong>/templates/parts/cart/footer.php</strong>',
			)				
		)
	),
	
	array(
		'version' => '1.0.6.2',
		'date' =>'04.04.2017',
		'changes' => array(

			'fix' => array(
				'Fixed issue with Remove / Undo cart total not updating sometimes.'
			)			
		)
	),
	
	array(
		'version' => '1.0.6.1',
		'date' =>'16.03.2017',
		'changes' => array(
			
			'enhance' => array(
				'Show error message within cart header whenever product quantity has reached stock limit or a minimum quantity is required.'
			)			
		)
	),
	
	array(
		'version' => '1.0.6',
		'date' =>'15.03.2017',
		'changes' => array(
			
			'new' => array(
				'Auto sync cart content with third party mini cart plugins or within themes.',
				'Added global javascript function woofc_refresh_cart() for developers to force cart refresh within plugins or themes.'			
			),
			'support' => array(
				'Added Support for caching plugins'
			),	
			'fix' => array(
				'Fix cart issues on non woocommerce pages.'
			)			
		)
	),
	
	array(
		'version' => '1.0.5',
		'date' =>'17.02.2017',
		'changes' => array(
			
			'new' => array(
				'Sync cart with native WooCommerce cart page on Add, remove, update products'		
			),
			'support' => array(
				'Added support for Yith Product Addons Plugin',
				'Better support for third party plugins',
			),	
			'enhance' => array(
				'Centralize template output functions'
			)		
		)
	),
	array(
		'version' => '1.0.4',
		'date' =>'11.02.2017',
		'changes' => array(
			'new' => array(
				'Added Product Variations Support',
			),
			'enhance' => array(
				'Better theme compatibility'
			),	
		)
	),	
	array(
		'version' => '1.0.3.2',
		'date' =>'26.01.2017',
		'changes' => array(
			'update' => array(
				'Updated Full Version Changelog'
			),
			'fix' => array(
				'Minor CSS Fixes'
			)	
		)
	),	
	array(
		'version' => '1.0.3.1',
		'date' =>'19.01.2017',
		'changes' => array(
			'fix' => array(
				'Fixed minor bug with add to cart button when used with third party gift card plugins'
			)	
		)
	),	
	array(
		'version' => '1.0.3',
		'date' =>'10.01.2017',
		'changes' => array(
			'fix' => array(
				'Fixed WooCommerce installation check notice'
			)	
		)
	),
	array(
		'version' => '1.0.2',
		'date' =>'30.11.2016',
		'changes' => array(
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