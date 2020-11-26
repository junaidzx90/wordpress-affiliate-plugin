<?php
$product_id = intval( get_query_var( 'product_id' ) );
if(isset($product_id)){
    global $wpdb;
    $wpa_product_links = $wpdb->prefix . 'wpa_product_links';
    $clicks_table = $wpdb->prefix . 'wpa_clicks';

    $productlink = $wpdb->get_var("SELECT affiliate_link FROM $wpa_product_links WHERE product_ID = $product_id ORDER BY product_price ASC");

    if($wpdb->num_rows>0){
         // Count pretty link clicks
        $count_set = $wpdb->insert(
            $clicks_table,
            array(
                "product_id" => $product_id
            ),
            array("%d")
        );
        if($count_set){
            //Redirect cheapest product page
            wp_redirect( $productlink );
            flush_rewrite_rules();
            die;
        }else{
            wp_redirect(home_url( '/' ));
            flush_rewrite_rules();
            die;
        }
    }else{
        // This is the simple error message, you can modify that
        die("<h1 style='color: #ff4343;position: absolute;top: 48%;left: 52%;transform: translateY(-50%) translateX(-50%);'>This product link is broken! mabe it's remove</h1>");
    }
}
?>