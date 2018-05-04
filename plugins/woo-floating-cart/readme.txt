=== WooCommerce Interactive Floating Cart ===

Contributors: XplodedThemes
Plugin Name: Woo Floating Cart
Tags: woocommerce, floating cart, cart, mini cart, interactive cart
Author URI: http://www.xplodedthemes.com/
Author: XplodedThemes
Requires at least: 3.9
Tested up to: 4.9.4
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An Interactive Floating Cart for WooCommerce that slides in when the user decides to buy an item.

== Description ==

An Interactive Floating Cart for WooCommerce that slides in when the user decides to buy an item. Fully customizable right from WordPress Customizer with Live Preview. Products, quantities and prices are updated instantly via Ajax.

**Video Overview**

[youtube https://www.youtube.com/watch?v=_1cRp4E7iEQ]

<a target="_blank" href="https://www.youtube.com/watch?v=_1cRp4E7iEQ">https://www.youtube.com/watch?v=_1cRp4E7iEQ</a>

**Demo**

[http://woo-floating-cart.xplodedthemes.com](http://woo-floating-cart.xplodedthemes.com)

**Features**

Fully customizable right from WordPress Customizer with Live Preview.

- Apply Google Fonts
- Change Cart Position
- Change Cart Width / Height
- Change Counter Position
- Custom Colors / Backgrounds
- Custom Icons (SVG / Image / Font Icons)
- Select between 11 loading spinner animations
- Enable Fly To Cart animation
- Enable Cart Shake animation
- Option to automatically open the cart after adding a product
- Exclude pages from displaying the cart
- Device Visibility options
- Ajax Add to cart also supported on Single Product pages
- Ajax Add to cart also supported within Quick View modals
- Option to change the checkout link to redirect to the cart page instead
- Option to trigger the cart on Mouse Over with optional delay
- Select between Subtotal or Total to be displayed within the checkout button
- Product Variations Support
- Display product attributes within the cart
- Display Composite / Bundled product items
- Supports WooCommerce Currency Converter Widget
- RTL Support
- Automated Updates
- 1 Year Support & Updates

**Compatible With <a target="_blank" href="http://xplodedthemes.com/products/woo-quick-view/">Woo Quick View</a>**

<a target="_blank" href="http://xplodedthemes.com/products/woo-quick-view/"><img height="auto" width="590" alt="Woo Quick View - XplodedThemes.com" src="http://xplodedthemes.com/content/uploads/edd/2017/03/main_banner.png"></a>

== Installation ==

Installing "Woo Floating Cart" can be done by following these steps:

1. Download the plugin from the customer area at "XplodedThemes.com" 
2. Upload the plugin ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
3. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= V.1.1.2 - 03.25.2018 =
- Fix fly to cart animation to try and only animate the image without the whole container
- Fix conflict with 2 different serializeJSON libraries
- Fix javascript error on some shop pages, especially when using Dokan plugin
- Bypass add to cart buttons within gravity forms so they can work as usual.
- Support Woo Product Table Plugin

= V.1.1.1 - 01.15.2018 =
- Support Woo Variations Table Plugin

= V.1.1.0 - 11.25.2017 =
- Wordpress v4.9 Customizer Support
- Added Ajax queue system faster and more reliable Ajax requests

= V.1.0.9.5 - 10.24.2017 =
- Fix compatibility issue with the X Theme
- Better theme compatibility

= V.1.0.9.4 - 11.10.2017 =
- Fix bundled items removal issue with Composite / Bundled products
- Replace deprecated functions
- Disable the Single Add To Cart button until the floating cart is ready

= V.1.0.9.3 - 25.09.2017 =
- Better compatibility with Composite and Bundled products

= V.1.0.9.2 - 07.07.2017 =
- Fix multiple domain license check bug

= V.1.0.9.1 - 21.06.2017 =
- Added option to show / hide bundled products for WooCommerce Product Bundles plugin
- Support WooCommerce Product Bundles plugin

= V.1.0.9 - 16.06.2017 =
- Fix product attributes display issue if attribute value is set to "Any"
- Template changes: /templates/parts/cart/list/product.php
- Template changes: /templates/parts/cart/list/product/variations.php

= V.1.0.8.9 - 07.06.2017 =
- Fixed issue with product remove not updating subtotal on first try

= V.1.0.8.8 - 20.04.2017 =
- Fixed deprecated function warnings caused by WooCommerce v3.0.x
- Template changes: /templates/parts/cart/list/product/thumbnail.php

= V.1.0.8.7 - 19.04.2017 =
- Fixed issue with products not adding to cart right after removing a product

= V.1.0.8.6 - 18.04.2017 =
- Fixed issue with having to click twice to remove a product after adding it
- Changed the Checkout label to Cart in go to cart mode

= V.1.0.8.5 - 11.04.2017 =
- Fixed intermittent 502 error with ajax requests
- Fixed fly to cart animation from Woo Quick View modal

= V.1.0.8.4 - 10.04.2017 =
- Added option to display product attributes as a list or inline
- Added option to hide product attributes labels
- Added option to automatically open the cart after adding a product
- Fixed product attributes display on WooCommerce v3.x.x
- Template changes: /templates/parts/cart/list/product/variations.php and /templates/parts/cart/list/product.php

= V.1.0.8.3 - 10.04.2017 =
- Added option to resize default cart width and height
- Better trigger icon animation when trigger position is set to Top Left or Top Right
- Fixed issue with some third party quick view modals add to cart button infinite loading.
- Fixed single post fly to cart animation on WooCommerce v3.x.x
- Template changes: /templates/minicart.php and /templates/parts/cart/footer.php

= V.1.0.8.2 - 04.04.2017 =
- Fixed issue with Remove / Undo cart total not updating sometimes.
- Fixed issue with local license being reset by it self.

= V.1.0.8.1 - 16.03.2017 =
- Added color and typography customization options for the newly added error message
- Supports WooCommerce Currency Converter Widget
- Show error message within cart header whenever product quantity has reached stock limit or a minimum quantity is required.
- Show woocommerce error messages within single product pages if ajax add to cart request failed for X reason

= V.1.0.8 - 15.03.2017 =
- Auto sync cart content with third party mini cart plugins or within themes.
- Added global javascript function woofc_refresh_cart() for developers to force cart refresh within plugins or themes.
- Added support for Woo Quick View Plugin
- Added Support for caching plugins
- Fix cart issues on non woocommerce pages.

= V.1.0.7 - 17.02.2017 =
- Sync cart with native WooCommerce cart page on Add, remove, update products
- Fly to cart animation now works on single product pages and within Quick View plugins
- Added support for Yith Product Addons Plugin
- Better support for third party plugins
- Centralize template output functions
- Fixed customizer issue with checkout background color not being changed

= V.1.0.6 - 11.02.2017 =
- Added Product Variations Support
- Added option to display product attributes within the cart
- Added option to select between Subtotal or Total to be displayed within the checkout button
- Added option to hide the WooCommerce “View Cart” link that appears after adding an item to cart
- Better theme compatibility

= V.1.0.5.1 - 30.01.2017 =
- Fixed weird issue with customizer fields visibility on WordPress 4.7.2
- Fixed issue with Customizer Typography fields not being displayed

= V.1.0.5 - 26.01.2017 =
- Added option to change the checkout link to redirect to the cart page instead.
- Added option to trigger the cart on Mouse Over with optional delay
- Added Device Visibility options

= V.1.0.4.1 - 19.01.2017 =
- Fixed minor bug with add to cart button when used with third party gift card plugins
- Fixed bug with customizer sections being hidden on some themes due to a conflict

= V.1.0.4 - 10.01.2017 =
- Ajax Add to cart now supported on single shop pages and within product quick views
- License System now allows the same purchase code to be valid within a multisite setup.
  1 License: unlimited domains, subdomains, folders as long as as it is under a multisite.
- Fixed WooCommerce installation check notice

= V.1.0.3 - 16.12.2016 =
- Now supports RTL
- Minor CSS fix with Fly to cart animation

= V.1.0.2 - 30.11.2016 =
- Added 11 different loading spinners (optional)
- Added new Fly To Cart animation (optional)
- Added option to exclude pages from displaying the cart
- Allow html in product titles
- License validation Fix

= V.1.0.1 - 02.11.2016 =
- Added hover background / color option to checkout button.
- Replaced click with click event for faster taps on mobile.
- Updated Translation Files
- Removed hover effect on mobile for faster response
- Fixed bug with checkout button typography options
- Minor CSS Fixes

= V.1.0.0 - 01.11.2016 =
- Initial Version

