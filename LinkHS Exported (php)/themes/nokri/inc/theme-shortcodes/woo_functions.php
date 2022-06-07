<?php
if ( ! function_exists( 'nokri_hide_package_quantity' ) ) {
function nokri_hide_package_quantity( $return, $product ) {
	return true;
}
}
add_filter( 'woocommerce_is_sold_individually', 'nokri_hide_package_quantity', 10, 2 );


if ( ! function_exists( 'nokri_woo_price' ) ) {
function nokri_woo_price($currency = '', $price = 0)
{
	global $nokri;
	$thousands_sep = wc_get_price_thousand_separator();
	$decimals = wc_get_price_decimals();;
	$decimals_separator = wc_get_price_decimal_separator();

	$price  = number_format( (int)$price, $decimals, $decimals_separator, $thousands_sep  );
	$price  = ( isset( $price ) && $price != "") ? $price : 0;	
	
	if( isset($nokri['sb_price_direction']) && $nokri['sb_price_direction'] == 'right' )
	{
		$price =  $price . $currency;
	}	
	else if( isset($nokri['sb_price_direction']) && $nokri['sb_price_direction'] == 'left' )
	{
		$price =  $currency . $price;
	}	
	else
	{
		$price =  $currency . $price;	
	}
	
	return $price;
}
}