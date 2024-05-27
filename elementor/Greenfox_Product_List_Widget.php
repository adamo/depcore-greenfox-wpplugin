<?php namespace Depcore\Greenfox;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use \Elementor\Widget_Base;

class Greenfox_Product_List_Widget extends Widget_Base {

    public function get_name() {
        return 'greenfox-product-list';
    }

    public function get_title() {
        return __( 'Greenfox Product List', 'text-domain' );
    }

    public function get_icon() {
        return 'eicon-posts-list'; // You can change the icon as needed
    }

    public function get_categories() {
        return [ 'general' ]; // Adjust category as needed
    }

    protected function render() {
        $args = array(
            'post_type' => 'greenfox-product',
            'posts_per_page' => -1, // Set to -1 to display all posts, you can change as needed
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            echo '<ul>';
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        }

        wp_reset_postdata();
    }
}