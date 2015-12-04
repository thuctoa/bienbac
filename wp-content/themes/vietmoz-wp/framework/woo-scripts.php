<?php
/**
 * Woocommerce tweak and extra functions
 *
 * @package moztheme
 */

//Change vietnam dong symbol
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
 
function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'VND': $currency_symbol = 'VNĐ'; break;
     }
     return $currency_symbol;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove default WooCommerce breadcrumbs and add Yoast ones instead
// remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
// add_action( 'woocommerce_before_main_content','my_yoast_breadcrumb', 20, 0);
// if (!function_exists('my_yoast_breadcrumb') ) {
// 	function my_yoast_breadcrumb() {
// 		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
// 	}
// }