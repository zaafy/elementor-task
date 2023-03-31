<?php
// product display shortcode
// [emt_product product_id="xxx" bg_color="#ffffff"]
// [emt_product product_id=”37″ bg_color=”#ff0000″]
// [emt_product product_id=37 bg_color=#ff0000]



function emt_product_shortcode_func( $args ) {
	$atts = shortcode_atts( array(
		'product_id' => '0',
		'bg_color' => '#ffffff',
	), $args );

    set_query_var('emt_product_id', $atts['product_id']);
    set_query_var('emt_product_bgc', $atts['bg_color']);

    ob_start();
    include ( __DIR__ . '/../template-parts/product-listing-element.php' );
    $output = ob_get_clean();

    set_query_var('emt_product_id', false);
    set_query_var('emt_product_bgc', false);

	return $output;
}
add_shortcode( 'emt_product', 'emt_product_shortcode_func' );