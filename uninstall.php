<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}
global $wpdb;
$products = $wpdb->prefix . 'wpa_products'; 
$suppliers = $wpdb->prefix . 'wpa_suppliers';
$product_links = $wpdb->prefix . 'wpa_product_links';
$wpa_clicks = $wpdb->prefix . 'wpa_clicks';
$wpdb->query("DROP TABLE IF EXISTS $products");
$wpdb->query("DROP TABLE IF EXISTS $suppliers");
$wpdb->query("DROP TABLE IF EXISTS $product_links");
$wpdb->query("DROP TABLE IF EXISTS $wpa_clicks");