<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/admin
 * @author     satalketo <demo@gmail.com>
 */
class Wordpress_Affiliate_Plugin_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// // Hook for Sortcode
		add_shortcode("wpa", array($this, "wp_affiliate_plugin_shortcode_func"));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Affiliate_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Affiliate_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (isset($_GET['page']) == 'wordpress-affiliate-plugin' && isset($_GET['page']) == 'wpa-clicks-stats') {
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wordpress-affiliate-plugin-admin.css', array(), $this->version, 'all');
			wp_register_style( $this->plugin_name.'-select', plugin_dir_url(__FILE__) . 'css/select.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name.'-select');
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordpress_Affiliate_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordpress_Affiliate_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (isset($_GET['page']) == 'wordpress-affiliate-plugin' && isset($_GET['page']) == 'wpa-clicks-stats') {
			wp_enqueue_script($this->plugin_name.'-jquery', plugin_dir_url(__FILE__) . 'js/jquery.min.js', array(), "", true);
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wordpress-affiliate-plugin-admin.js', array(), $this->version, true);
			wp_localize_script($this->plugin_name, '_ajax_url', array(
				'ajax_url' => admin_url('admin-ajax.php')
			));
			wp_enqueue_script($this->plugin_name.'-sweetalert', plugin_dir_url(__FILE__) . 'js/sweetalert.js', array(), "", true);
			wp_enqueue_script($this->plugin_name.'-select',  plugin_dir_url(__FILE__) . 'js/select.js', array(), "", true);
		}
	}

	// Make wordpress-affiliate-plugin MENUS
	function wp_affiliate_plugin()
	{
		add_menu_page( //Main menu register
			"Wordpress affiliate plugin", //page_title
			"Wordpress affiliate plugin", //menu title
			"manage_options", //capability
			"wordpress-affiliate-plugin", //menu_slug
			array($this, "wordpress_affiliate_plugin"), //callback function
			'dashicons-megaphone',
			65
		);
		add_submenu_page( //sub menu register
			"wordpress-affiliate-plugin", //parent_slug
			"Add Products", //page title
			"Add Products", //menu title
			"manage_options", //capability
			"wordpress-affiliate-plugin",  //menu-slug
			array($this, "wordpress_affiliate_plugin") //Callback function same with parent
		);
		add_submenu_page( //sub menu register
			"wordpress-affiliate-plugin", //parent_slug
			"clicks stats", //page title
			"Clicks stats", //menu title
			"manage_options", //capability
			"wpa-clicks-stats",  //menu-slug
			array($this, "wpa_clicks_stats") //Callback function same with parent
		);
	}

	// Add product ajax request
	function add_product()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		// Store all data from inputs
		$product_name = ucfirst($wpdb->_real_escape($_POST['product_name']));
		if ($product_name != "") {
			// mysql query for checking data exist or not database
			$wpdb->get_results("SELECT * FROM $wpa_products WHERE product_name = '$product_name'");
			if ($wpdb->num_rows > 0) {
				echo json_encode(array("title" => "This product already exists!", "text" => "Please enter another one.", "status" => false));
				die();
			} else {
				// Insert data to database
				$wpdb->insert(
					$wpa_products,
					array(
						"product_name" => "$product_name"
					),
					array("%s")
				);
				echo json_encode(array("title" => "GOOD JOB!", "text" => "A new product has been added.", "status" => true));
				die();
			}
		}
	} //End add product
	// Get product info
	function product_details()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix

		$product_name = $_POST['product_name'];

		$data = $wpdb->get_results("SELECT s.supplier_name, s.supplier_ID FROM $wpa_products p,  $wpa_suppliers s, $wpa_product_links l  WHERE p.product_ID = l.product_ID and  l.supplier_ID = s.supplier_ID and p.product_name = '$product_name'  ORDER BY p.product_ID DESC");

		if ($wpdb->num_rows > 0) {
			$output = json_encode($data);
			echo $output;
			die();
		} else {
			echo json_encode(array("text" => "No product found!", "status" => false));
			die();
		}
	}

	// Get product links has or not
	function get_affiliate_data_for_product()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
		$links = $wpdb->get_results("SELECT p.product_ID FROM $wpa_products p,  $wpa_suppliers s, $wpa_product_links l  WHERE p.product_ID = l.product_ID and  l.supplier_ID = s.supplier_ID");

		if ($wpdb->num_rows > 0) {
			$output = json_encode($links);
			echo $output;
			die();
		} else {
			echo json_encode(array("text" => "No product found!", "status" => false));
			die();
		}
	}

	function get_affiliate_data()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
		$links = $wpdb->get_results("SELECT  p.product_name, s.supplier_name, l.affiliate_link, l.productLink_ID, l.product_ID FROM $wpa_products p,  $wpa_suppliers s, $wpa_product_links l  WHERE p.product_ID = l.product_ID and  l.supplier_ID = s.supplier_ID  ORDER BY l.productLink_ID DESC");

		if ($wpdb->num_rows > 0) {
			$output = json_encode($links);
			echo $output;
			die();
		} else {
			echo json_encode(array("text" => "No shortcodes were created!", "status" => false));
			die();
		}
	}

	// Get product data
	function get_product()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$products = $wpdb->get_results("SELECT * FROM $wpa_products ORDER BY product_ID DESC");

		if ($wpdb->num_rows > 0) {
			echo json_encode($products);
			die();
		} else {
			echo json_encode(array("text" => "No product found!", "status" => false));
			die();
		}
	} //End get_product

	// Get provider data
	function supplier_data()
	{
		global $wpdb; //get global veriable
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //Define wpa_products table with wp prefix
		$supplier = $wpdb->get_results("SELECT * FROM $wpa_suppliers ORDER BY supplier_name DESC");

		if ($wpdb->num_rows > 0) {
			echo json_encode($supplier);
			die();
		} else {
			echo json_encode(array("text" => "No supplier found!", "status" => false));
			die();
		}
	} //End supplier_data

	// Add providers
	function add_providers()
	{
		global $wpdb; //get global veriable
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		// Store all data from inputs
		$provider_name = ucfirst($wpdb->_real_escape($_POST['providers_name']));
		if ($provider_name != "") {
			// mysql query for checking data exist or not database
			$wpdb->get_results("SELECT * FROM $wpa_suppliers WHERE supplier_name = '$provider_name'");
			if ($wpdb->num_rows > 0) {
				echo json_encode(array("title" => "This provider already exists!", "text" => "Please enter another one.", "status" => false));
				die();
			} else {
				// Insert data to database
				$wpdb->insert(
					$wpa_suppliers,
					array(
						"supplier_name" => "$provider_name"
					),
					array("%s")
				);
				echo json_encode(array("title" => "GOOD JOB!", "text" => "A new supplier has been added.", "status" => true));
				die();
			}
		}
	} //End add_providers

	//Add Link
	function add_aff_link()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
		// Store all data from inputs
		$product_id = $wpdb->_real_escape($_POST['product_id']);
		$provider_id =  $wpdb->_real_escape($_POST['provider_id']);
		$price =  $wpdb->_real_escape($_POST['price']);
		$links =  filter_var($_POST['links'], FILTER_VALIDATE_URL);
		$link =  filter_var($links, FILTER_SANITIZE_URL);


		if ($product_id != "" or $provider_id != "" or $link != "") {
			if ($link) {
				// mysql query for checking data exist or not database
				$results = $wpdb->get_results("SELECT * FROM $wpa_product_links WHERE affiliate_link = '$link'");
				if ($wpdb->num_rows > 0) {
					// Trying to get product id from product name
					foreach ($results as $result);
					//Fetch product name that are contain existing url
					$url_exst_pname = $wpdb->get_var("SELECT product_name FROM $wpa_products WHERE product_ID = $result->product_ID");
					//Send error msg to view
					echo json_encode(array("title" => "This link is already carrying '$url_exst_pname' product!", "text" => "Please check this link again.", "status" => false));
					die();
				} else {
					//Insert link data to database
					$wpdb->insert(
						$wpa_product_links,
						array(
							"product_price" => $price,
							"product_ID" => $product_id,
							"supplier_ID" => $provider_id,
							"affiliate_link" => "$link"
						),
						array("%d", "%d", "%d", "%s")
					);
					echo json_encode(array("title" => "GOOD JOB!", "text" => "New link added to '$product_name'", "status" => true));
					die();
				}
			} else {
				echo json_encode(array("title" => "INVALID URL!", "text" => "Please type a valid url.", "status" => false));
				die();
			}
		}
	} // End Add Link

	function select_supplier()
	{
		global $wpdb; //get global veriable
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		// GETTING ONLY SUPPLIER NAMES
		$supplier_names = $wpdb->get_results("SELECT supplier_id, supplier_name FROM $wpa_suppliers GROUP BY supplier_name ORDER BY supplier_ID DESC");
		if ($wpdb->num_rows > 0) {
			$output = json_encode($supplier_names);
			echo $output;
			die();
		}
	} //End select_supplier

	function select_product_opt()
	{
		global $wpdb; //get global veriable
		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		// GETTING ONLY SUPPLIER NAMES
		$product_name = $wpdb->get_results("SELECT product_id, product_name FROM $wpa_products GROUP BY product_name ORDER BY product_ID DESC");
		if ($wpdb->num_rows > 0) {
			$output = json_encode($product_name);
			echo $output;
			die();
		}
	} //End select_supplier

	// DELETE PRODUCT
	function delete_data()
	{
		global $wpdb; //get global veriable
		$data_id = $_POST['data_id'];
		$delete_for = $_POST['delete_for'];

		$wpa_products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
		$wpa_suppliers = $wpdb->prefix . 'wpa_suppliers'; //define wpa_suppliers table with wp prefix
		$wpa_product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix

		if ($delete_for == "product") { //Product deletions
			$wpdb->get_results("SELECT * FROM $wpa_product_links WHERE product_ID = $data_id");
			if ($wpdb->num_rows > 0) {
				$wpdb->delete(
					$wpa_product_links,
					array(
						"product_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				$wpdb->delete(
					$wpa_products,
					array(
						"product_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				die();
			} else {
				$wpdb->delete(
					$wpa_products,
					array(
						"product_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				die();
			}
		} ///End product deletions

		if ($delete_for == "supplier") { //Supplier deletions
			$wpdb->get_results("SELECT * FROM $wpa_product_links WHERE supplier_ID = $data_id");
			if ($wpdb->num_rows > 0) {
				$wpdb->delete(
					$wpa_product_links,
					array(
						"supplier_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				$wpdb->delete(
					$wpa_suppliers,
					array(
						"supplier_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				die();
			} else {
				$wpdb->delete(
					$wpa_suppliers,
					array(
						"supplier_ID" => $data_id
					),
					array(
						"%d"
					)
				);
				die();
			}
		} ///End supplier deletions

		if ($delete_for == "links") { //links deletions
			$wpdb->delete(
				$wpa_product_links,
				array(
					"productLink_ID" => $data_id
				),
				array(
					"%d"
				)
			);
			die();
		} ///End links deletions
	}
	// //Create shortcode for every single product
	function wp_affiliate_plugin_shortcode_func($atts)
	{
		// set up default parameters
		extract(shortcode_atts(array(
			'productid' => ''
		), $atts));

		if ($productid) {
			ob_start();
			require_once plugin_dir_path(__FILE__) . "partials/wordpress-affiliate-product-view.php";
			return ob_get_clean();
		}
	}

	// Add products callback function
	function wordpress_affiliate_plugin()
	{
		require_once plugin_dir_path(__FILE__) . "partials/wordpress-affiliate-plugin-admin-display.php";
	}
	// Submenu for showing clicks stats data
	function wpa_clicks_stats(){
		require_once plugin_dir_path(__FILE__) . "partials/wpa-clicks-stats-display.php";
	}
}//END CLASS
