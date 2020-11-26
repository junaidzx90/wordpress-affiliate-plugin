<?php
// Pretty link generates
add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){
    $wp_rewrite->rules = array_merge(
        ['product/(\d+)/?$' => 'index.php?product_id=$matches[1]'],
        $wp_rewrite->rules
    );
	$wp_rewrite->rules = array_merge(
        ['productlink/(\d+)/?$' => 'index.php?product_link_id=$matches[1]'],
        $wp_rewrite->rules
    );
});

add_filter( 'query_vars', function( $query_vars ){
    $query_vars[] = 'product_id';
	$query_vars[] = 'product_link_id';
    return $query_vars;
});

add_action( 'template_redirect', function(){
    $product_id = intval( get_query_var( 'product_id' ) );
	$product_link_id = intval( get_query_var( 'product_link_id' ) );
    if ( $product_id ) {
        //Product counting redirecting template includes
        include plugin_dir_path( __FILE__ ) . 'wpa-affiliate-product.php';
        wp_die();
    }
	if ( $product_link_id ) {
        //Productlink counting redirecting template includes
        include plugin_dir_path( __FILE__ ) . 'wpa-affiliate-productlink.php';
        wp_die();
    }
});
// Pretty link generates ends
?>