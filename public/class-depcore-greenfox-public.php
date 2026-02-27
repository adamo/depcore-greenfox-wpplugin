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
class Depcore_Greenfox_Public
{
    private $prefix = "depcore-";

    public $schema_mappings = [
        // 'Nutritional information' => 'itemprop="nutrition" itemscope itemtype="https://schema.org/NutritionInformation"',
        "price" => 'itemprop="price" content="PLN"',
        // 'grammage' => 'itemprop="weight"',
        // 'ingredients_according_to_commission_regulation' => 'itemprop="ingredients"',
        // 'energy_value' => 'itemprop="calories"',
        // 'fat' => 'itemprop="fatContent"',
        // 'including_saturated_fatty_acids' => 'itemprop="saturatedFatContent"',
        // 'carbohydrates' => 'itemprop="carbohydrateContent"',
        // 'including_suggars' => 'itemprop="sugarContent"',
        // 'dietary_fiber' => 'itemprop="fiberContent"',
        // 'protein' => 'itemprop="proteinContent"',
        // 'salt' => 'itemprop="sodiumContent"',
        "EAN_of_unit_package" => 'itemprop="sku"',
    ];

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
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function register_shortcodes()
    {
        add_shortcode("depcore_greenfox_product_information", [
            $this,
            "display_product_information_greenfox",
        ]);
    }

    public function display_product_information_greenfox()
    {
        $metabox_group = [
            "Product information" => [
                "price",
                "grammage",
                "storage_method",
                "shelf_life",
                "type_of_pre-packaging",
                "number_of_products_per_unit_package",
                "type_of_packaging",
                "number_of_products_per_package",
                "ingredients_according_to_commission_regulation",
            ],
            "Nutritional information" => [
                "nutritional_value_per_100g_of_product",
                "energy_value",
                "fat",
                "including_saturated_fatty_acids",
                "carbohydrates",
                "including_suggars",
                "dietary_fiber",
                "protein",
                "salt",
            ],
            "Logistics information" => [
                "EAN_of_unit_package",
                "EAN_of_bulk_package",
                "dimensions_of_unit_package_cm",
                "dimensions_of_bulk_package_cm",
                "logistics_minimum",
                "number_of_layers_on_a_pallet",
                "number_of_boxes_per_layer",
                "number_of_boxes_per_pallet",
                "pallet_weight",
                "pallet_dimensions_cm",
            ],
        ];

        $prefix = $this->prefix;
        ob_start();
        include_once "partials/depcore-greenfox-public-display.php";
        return ob_get_clean();
    }

    public function add_itemprop_image($attr)
    {
        $attr["itemprop"] = "image";
        return $attr;
    }

    public function add_itemprop_name($title)
    {
        global $post;
        return "<span itemprop='name'> {$post->post_title}</span>";
    }

    public function remove_wpseo()
    {
        if (is_singular("greenfox-product")) {
            add_filter("wpseo_json_ld_output", "__return_empty_array", 10, 1);
        }
    }

    public function register_greenfox_product_list_shortcode()
    {
        add_shortcode("greenfox_product_list", [$this, "display_product_list"]);
    }

    public function display_product_list()
    {
        $args = [
            "post_type" => "greenfox-product",
            "posts_per_page" => -1, // Set to -1 to display all posts, you can change as needed
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $product_categories = $this->get_product_categories();
            include "partials/product-categories.php";
            echo '<div class="depcore-products-grid products-grid" id="depcore-producs-list">';
            while ($query->have_posts()) {
                $query->the_post();
                include "partials/single-portfolio-item.php";
            }
            echo "</div>";
        }

        wp_reset_postdata();
    }

    public function map_schema_value($value)
    {
        if (array_key_exists($value, $this->schema_mappings)) {
            return $this->schema_mappings[$value];
        }
        return "";
    }

    public function get_product_categories()
    {
        $product_categories = get_terms([
            "taxonomy" => "greenfox-product-category",
            "hide_empty" => true,

            "parent" => 0,
        ]);
        return $product_categories;
    }

    public function register_greenfox_product_list_widget()
    {
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(
            new Greenfox_Product_List_Widget(),
        );
    }

    public function get_customm_post_type_categories_as_classes()
    {
        $categories = get_the_terms(get_the_ID(), "greenfox-product-category");
        $classes = [];
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $classes[] = $category->slug;
            }
        }
        return implode(", ", $classes);
    }

    public function get_customm_post_type_categories_as_links()
    {
        $categories = get_the_terms(get_the_ID(), "greenfox-product-category");
        $links = [];
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $links[] =
                    '<a href="' .
                    get_term_link($category) .
                    '">' .
                    $category->name .
                    "</a>";
            }
        }
        return implode(", ", $links);
    }

    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . "css/depcore-greenfox-public.css",
            [],
            $this->version,
            "all",
        );
    }
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . "js/depcore-greenfox-public.js",
            ["jquery"],
            $this->version,
            true,
        );
    }
}
