<?php

/**
 * Fired during plugin deactivation
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 * @author     satalketo <demo@gmail.com>
 */
class Wordpress_Affiliate_Plugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
