<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://depcore.pl
 * @since      1.0.0
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/admin
 * @author     Depcore <biuro@depcore.pl>
 */
class Depcore_Greenfox_Admin {

	private $plugin_name;
	private $prefix = 'depcore-';
	private $cpt_defaults = [
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'show_in_rest'		  => false,
		'can_export'          => true,
	];

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/depcore-greenfox-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/depcore-greenfox-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function init_post_types()
	{
		$this->register_product_post_type();
		$this->register_product_category_taxonomy();
	}

	public function register_product_category_taxonomy(){
		$args = array(
			'labels'      => $this->generate_taxonomy_labels('Product category', 'Product categories'),
			'hierarchical'    => true,
			'public'      => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'   => false,
			'show_ui'     => true,
			'show_in_rest'      => false, // Needed for tax to appear in Gutenberg editor.
			'query_var'     => true,
			'rewrite'     => array(
				'slug' => 'greenfox-product-category',
				'with_front' => 'true',
			),
			'query_var'     => true,
		);
		register_taxonomy('greenfox-product-category', array('greenfox-product'), $args);

	}

	public function register_product_post_type() {
		__('Product category', 'depcore-greenfox');
		__('Greenfox product', 'depcore-greenfox');
		__('Add new greenfox product', 'depcore-greenfox');
		__('Greenfox products', 'depcore-greenfox');
		__('Salt', 'depcore-greenfox');
		__('grammage', 'depcore-greenfox');


		$args = array(
			'labels'              => $this->generate_labels('GreenFox product', 'GreenFox products'),
			'menu_icon'           => 'dashicons-admin-site',
			'menu_position'       => 5,
			'description'         => 'description',
			'rewrite'             => array(
				'slug' => _x('greenfox-product', 'slug', 'depcore-greenfox'),
			),
			'capability_type'     => 'page',
			'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes'),
		);

		register_post_type('greenfox-product', array_merge($args, $this->cpt_defaults));


	}

	protected function generate_labels($singular, $plural)
	{
		$singular = strtolower($singular);
		$plural = strtolower($plural);
		return [
			'name'               => __(ucfirst($singular), 'depcore-greenfox'),
			'singular_name'      => __(ucfirst($singular), 'depcore-greenfox'),
			'add_new'            => _x("Add new $singular", $singular, 'depcore-greenfox'),
			'add_new_item'       => __("Add new $singular", 'depcore-greenfox'),
			'edit_item'          => __("Edit $singular", 'depcore-greenfox'),
			'new_item'           => __("New $singular", 'depcore-greenfox'),
			'view_item'          => __("View $singular", 'depcore-greenfox'),
			'search_items'       => __("Search $plural", 'depcore-greenfox'),
			'not_found'          => __("No $plural found", 'depcore-greenfox'),
			'not_found_in_trash' => __("No $plural found in Trash", 'depcore-greenfox'),
			'parent_item_colon'  => __("Parent $singular:", 'depcore-greenfox'),
			'menu_name'          => __(ucfirst($singular), 'depcore-greenfox'),
		];
	}

	protected function generate_taxonomy_labels($singular, $plural)
	{
		$singular = strtolower($singular);
		$plural = strtolower($plural);
		return array(
			'name'          => _x(ucfirst($singular), 'Taxonomy general name', 'depcore-greenfox'),
			'singular_name'     => _x(ucfirst($singular), 'Taxonomy singular name', 'depcore-greenfox'),
			'search_items'      => __("Search $plural", 'depcore-greenfox'),
			'popular_items'     => __("Popular $plural", 'depcore-greenfox'),
			'all_items'       => __("All $plural", 'depcore-greenfox'),
			'parent_item'     => __("Parent $singular", 'depcore-greenfox'),
			'parent_item_colon'   => __("Parent $singular", 'depcore-greenfox'),
			'edit_item'       => __("Edit $singular", 'depcore-greenfox'),
			'update_item'     => __("Update $singular", 'depcore-greenfox'),
			'add_new_item'      => __("Add New $singular", 'depcore-greenfox'),
			'new_item_name'     => __("New $singular", 'depcore-greenfox'),
			'add_or_remove_items' => __("Add or remove $singular", 'depcore-greenfox'),
			'choose_from_most_used' => __("Choose from most used $singular", 'depcore-greenfox'),
			'menu_name'       => __(ucfirst($singular), 'depcore-greenfox'),
		);
	}


	public function init_metaboxes()
	{

		$metabox_groups =[
			'Product information' => ['price', 'grammage','storage_method','shelf_life','type_of_pre-packaging','number_of_products_per_unit_package','type_of_packaging','number_of_products_per_package','ingredients_according_to_commission_regulation'],
			'Nutritional information' => ['nutritional_value_per_100g_of_product', 'energy_value','fat','including_saturated_fatty_acids','carbohydrates','including_suggars','dietary_fiber','protein','salt'],
			'Logistics information' => ['EAN_of_unit_package', 'EAN_of_bulk_package','dimensions_of_unit_package_cm','dimensions_of_bulk_package_cm','logistics_minimum','number_of_boxes_per_pallet','number_of_boxes_per_layer','number_of_layers_on_a_pallet','pallet_weight','pallet_dimensions_cm'],
		];

		foreach ($metabox_groups as $group_name => $fields) {
			$this->create_metabox_group($group_name, $fields);
		}

		$cmb = new_cmb2_box(array(
			'id' 			=> $this->prefix . 'product_gallery',
			'title'         => __('Additional settings', 'depcore-greenfox'),
			'object_types'  => array('greenfox-product'),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
		));


		$cmb->add_field(array(
			'id' => $this->prefix . 'product_gallery',
			'name' => __('Product gallery', 'depcore-greenfox'),
			'type' => 'file_list',
			'desc' => __('Upload images for this product', 'depcore-greenfox'),
			'prompt' => __('Add new image', 'depcore-greenfox'),
		));
		$cmb = new_cmb2_box(array(
			'id' 			=> $this->prefix . 'product_cta',
			'title'         => __('CTA', 'depcore-greenfox'),
			'object_types'  => array('greenfox-product'),
			'context'       => 'side',
			'priority'      => 'low',
			'show_names'    => true,
		));

		$cmb->add_field(array(
			'id' => $this->prefix . 'show_cta',
			'name' => __('Show CTA', 'depcore-greenfox'),
			'type' => 'checkbox',
			'desc' => __('Show CTA button under the product description', 'depcore-greenfox'),
			'default' => 'off',
		));

		$cmb->add_field(array(
			'id' => $this->prefix . 'cta_text',
			'name' => __('CTA text', 'depcore-greenfox'),
			'type' => 'text',
			'desc' => __('Text for the CTA button', 'depcore-greenfox'),
		));

		// select contact form 7 which will be used for the CTA
		$cmb->add_field(array(
			'id' => $this->prefix . 'cta_form',
			'name' => __('CTA form', 'depcore-greenfox'),
			'type' => 'select',
			'options' => $this->get_contact_forms(),
			'desc' => __('Select the form which will be used for the CTA', 'depcore-greenfox'),
		));

	}

	protected function get_contact_forms()
	{
		$forms = [];
		$args = array(
			'post_type' => 'wpcf7_contact_form',
			'posts_per_page' => -1,
		);
		$cf7_forms = get_posts($args);
		foreach ($cf7_forms as $form) {
			$forms[$form->ID] = $form->post_title;
		}
		return $forms;
	}

	protected function create_metabox_group($label, $fields){
		$cmb = new_cmb2_box(array(
			'id' 			=> $this->prefix . $label.'_info',
			'title'         => __($label, 'depcore-greenfox'),
			'object_types'  => array('greenfox-product'),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
			'vertical_tabs' => true, // Set vertical tabs, default false
		));

		foreach ($fields as $field) {
			$cmb->add_field(array(
				'id' => $this->prefix . $field,
				'name' => self::create_cmb_name($field),
				'type' => 'text',
			));
		}

	}

	public static function create_cmb_name($field)
	{
		return  __(str_replace('_',' ', ucfirst($field)),'depcore-greenfox');
	}

}
