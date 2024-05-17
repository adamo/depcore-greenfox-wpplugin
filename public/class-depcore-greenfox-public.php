<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://depcore.pl
 * @since      1.0.0
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/public
 * @author     Depcore <biuro@depcore.pl>
 */
class Depcore_Greenfox_Public {

	private $prefix = 'depcore-';
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function register_shortcodes() {
		add_shortcode( 'depcore_greenfox_product_information', array( $this, 'display_product_information_greenfox' ) );
	}

	public function display_product_information_greenfox() {

		$metabox_group =[
			'Product information' => ['price', 'grammage','storage_method','shelf_life','type_of_pre-packaging','number_of_products_per_unit_package','type_of_packaging','number_of_products_per_package','ingredients_according_to_commission_regulation'],
			'Nutritional information' => ['nutritional_value_per_100g_of_product', 'energy_value','fat','including_saturated_fatty_acids','carbohydrates','including_suggars','dietary_fiber','protein','salt'],
			'Logistics information' => ['EAN_of_unit_package', 'EAN_of_bulk_package','dimensions_of_unit_package_cm','dimensions_of_bulk_package_cm','logistics_minimum','number_of_boxes_per_pallet','number_of_boxes_per_layer','number_of_layers_on_a_pallet','pallet_weight','pallet_dimensions_cm'],
		];

		$prefix= $this->prefix;
		ob_start();
		include_once 'partials/depcore-greenfox-public-display.php';
		return ob_get_clean();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/depcore-greenfox-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/depcore-greenfox-public.js', array( 'jquery' ), $this->version, true );

	}

}
