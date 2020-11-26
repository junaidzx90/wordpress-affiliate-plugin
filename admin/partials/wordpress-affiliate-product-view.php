<?php
global $wpdb; //get global veriable
$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
wp_enqueue_style($this->plugin_name, PLUGIN_DIR_URL . 'admin/css/wordpress-affiliate-product-view.css', array(), $this->version, 'all');

$products = $wpdb->get_results("SELECT p.*, l.*,s.* FROM $wpa_product_links l
JOIN $wpa_products p ON p.product_ID = l.product_ID
JOIN $wpa_suppliers s ON s.supplier_id = l.supplier_id AND p.product_ID = $productid ORDER BY p.product_ID DESC");

$output = "";
if ($wpdb->num_rows > 0) {
    $output .= '<div class="product_views">';
    $output .= '<ul>';
    foreach ($products as $product) {
        $output .= '<li>';
        $output .= '<a class="" href="' . $product->affiliate_link . '">';
        $output .= '<span class="price">$' . $product->product_price . '</span>';
        $output .= '<span class="supplier">View at ' . $product->supplier_name . '</span>';
        $output .= '</a>';
        $output .= '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    echo $output;
}
