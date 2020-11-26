<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              demo@gmail.com/about-me
 * @since             1.0.0
 * @package           Wordpress_Affiliate_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Affiliate Plugin
 * Plugin URI:        https://example.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            satalketo
 * Author URI:        demo@gmail.com/about-me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-affiliate-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WORDPRESS_AFFILIATE_PLUGIN_VERSION', '1.0.0' );
define( 'PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordpress-affiliate-plugin-activator.php
 */
function activate_wordpress_affiliate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-affiliate-plugin-activator.php';
	Wordpress_Affiliate_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordpress-affiliate-plugin-deactivator.php
 */
function deactivate_wordpress_affiliate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-affiliate-plugin-deactivator.php';
	Wordpress_Affiliate_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wordpress_affiliate_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_wordpress_affiliate_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-affiliate-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */


//Include prettylinks
require plugin_dir_path( __FILE__ ) . 'includes/wpa-affiliate-pretty-links.php';

// include update manager
update_manager();
function update_manager(){
	if(file_exists(PLUGIN_DIR_PATH . 'update_manager/plugin-update-checker.php')){
		require_once PLUGIN_DIR_PATH . 'update_manager/plugin-update-checker.php';
		$update = Puc_v4p10_Factory::buildUpdateChecker( 'http://localhost/controller/controller.json', __FILE__ );
	}
	return $update;
}


function run_wordpress_affiliate_plugin() {

	$plugin = new Wordpress_Affiliate_Plugin();
	$plugin->run();

}
run_wordpress_affiliate_plugin();
