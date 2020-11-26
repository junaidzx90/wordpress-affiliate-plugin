<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/includes
 * @author     satalketo <demo@gmail.com>
 */
class Wordpress_Affiliate_Plugin
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wordpress_Affiliate_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('WORDPRESS_AFFILIATE_PLUGIN_VERSION')) {
			$this->version = WORDPRESS_AFFILIATE_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = 'wordpress-affiliate-plugin';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wordpress_Affiliate_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Wordpress_Affiliate_Plugin_i18n. Defines internationalization functionality.
	 * - Wordpress_Affiliate_Plugin_Admin. Defines all hooks for the admin area.
	 * - Wordpress_Affiliate_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-affiliate-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-affiliate-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-affiliate-plugin-admin.php';

		$this->loader = new Wordpress_Affiliate_Plugin_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wordpress_Affiliate_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Wordpress_Affiliate_Plugin_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Wordpress_Affiliate_Plugin_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		// Action hook for menu pages
		$this->loader->add_action('admin_menu', $plugin_admin, 'wp_affiliate_plugin');
		// // Hook for products add
		$this->loader->add_action("wp_ajax_add_product", $plugin_admin, "add_product");
		$this->loader->add_action("wp_ajax_nopriv_add_product", $plugin_admin, "add_product");
		// // Hook for product_data show
		$this->loader->add_action("wp_ajax_get_product", $plugin_admin, "get_product");
		$this->loader->add_action("wp_ajax_nopriv_get_product", $plugin_admin, "get_product");
		// // Hook for get links for making _shortcode
		$this->loader->add_action("wp_ajax_get_affiliate_data_for_product", $plugin_admin, "get_affiliate_data_for_product");
		$this->loader->add_action("wp_ajax_nopriv_get_affiliate_data_for_product", $plugin_admin, "get_affiliate_data_for_product");
		// // // Hook for _product_details
		$this->loader->add_action("wp_ajax_product_details", $plugin_admin, "product_details");
		$this->loader->add_action("wp_ajax_nopriv_product_details", $plugin_admin, "product_details");
		// // // Hook for select mentu
		$this->loader->add_action("wp_ajax_add_providers", $plugin_admin, "add_providers");
		$this->loader->add_action("wp_ajax_nopriv_add_providers", $plugin_admin, "add_providers");
		// // // Hook for supplier_data
		$this->loader->add_action("wp_ajax_supplier_data", $plugin_admin, "supplier_data");
		$this->loader->add_action("wp_ajax_nopriv_supplier_data", $plugin_admin, "supplier_data");
		// // // Hook for add_aff_link
		$this->loader->add_action("wp_ajax_add_aff_link", $plugin_admin, "add_aff_link");
		$this->loader->add_action("wp_ajax_nopriv_add_aff_link", $plugin_admin, "add_aff_link");
		// // // Hook for select_supplier
		$this->loader->add_action("wp_ajax_select_supplier", $plugin_admin, "select_supplier");
		$this->loader->add_action("wp_ajax_nopriv_select_supplier", $plugin_admin, "select_supplier");
		// // // Hook for select_product_opt
		$this->loader->add_action("wp_ajax_select_product_opt", $plugin_admin, "select_product_opt");
		$this->loader->add_action("wp_ajax_nopriv_select_product_opt", $plugin_admin, "select_product_opt");
		// // // Hook for get_affiliate_data
		$this->loader->add_action("wp_ajax_get_affiliate_data", $plugin_admin, "get_affiliate_data");
		$this->loader->add_action("wp_ajax_nopriv_get_affiliate_data", $plugin_admin, "get_affiliate_data");
		// // // Hook for delete_data
		$this->loader->add_action("wp_ajax_delete_data", $plugin_admin, "delete_data");
		$this->loader->add_action("wp_ajax_nopriv_delete_data", $plugin_admin, "delete_data");
	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wordpress_Affiliate_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
