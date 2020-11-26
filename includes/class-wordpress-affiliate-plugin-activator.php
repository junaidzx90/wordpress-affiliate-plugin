<?php

/**
 * Fired during plugin activation
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 * @author     satalketo <demo@gmail.com>
 */
class Wordpress_Affiliate_Plugin_Activator
{
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		global $wpdb; //Define wpdb global variable
		$products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
		$clicks_table = $wpdb->prefix . 'wpa_clicks'; //define wpa_clicks table with wp prefix
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$products_SQL = "CREATE TABLE IF NOT EXISTS `$products` ( 
		`product_ID` INT NOT NULL AUTO_INCREMENT,
		`product_name` VARCHAR(255) NOT NULL ,
		PRIMARY KEY (`product_ID`)) ENGINE = InnoDB";
		dbDelta($products_SQL); //Action for create wpa_products table


		$suppliers_SQL = "CREATE TABLE IF NOT EXISTS `$suppliers` ( 
		`supplier_ID` INT NOT NULL AUTO_INCREMENT,
		`supplier_name` VARCHAR(255) NOT NULL, 
		PRIMARY KEY (`supplier_ID`)) ENGINE = InnoDB";
		dbDelta($suppliers_SQL); //Action for create wpa_suppliers table


		$product_links_SQL = "CREATE TABLE IF NOT EXISTS `$product_links` (
		`productLink_ID` INT NOT NULL AUTO_INCREMENT,
		`product_ID` INT NOT NULL,  
		`supplier_ID` INT NOT NULL,
		`product_price` FLOAT NOT NULL,
		`affiliate_link` VARCHAR(255) NOT NULL,
		PRIMARY KEY  (`productLink_ID`)) ENGINE = InnoDB";
		dbDelta($product_links_SQL); //Action for create table wpa_product_links


		$wpa_clicks_SQL = "CREATE TABLE IF NOT EXISTS `$clicks_table` (
		`click_id` INT NOT NULL AUTO_INCREMENT,
		`session_id` INT(11) NOT NULL,
		`product_id` INT(11) NOT NULL,
		`product_link_id` INT(11) NOT NULL,
		`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`referring_page` VARCHAR(255) NOT NULL,
		PRIMARY KEY  (`click_id`)) ENGINE = InnoDB";
		dbDelta($wpa_clicks_SQL);//Action for create table clicks_table
	}
}
