<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 * @author     satalketo <demo@gmail.com>
 */
class Wordpress_Affiliate_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordpress-affiliate-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
