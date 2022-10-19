<?php
/**
 * Plugin Name: AAADON Featured Product on list starting (WPT Addons)
 * Plugin URI: #
 * Description: For Featured Product at the beggining of list
 * Author: Saiful Islam
 * Author URI: https://profiles.wordpress.org/codersaiful/#content-plugins
 *
 * Version: 1.0.0
 * Requires at least:    4.0.0
 * Tested up to:         5.8.2
 * WC requires at least: 3.7
 * WC tested up to:      6.2.2
 *
 */
if( ! defined('ABSPATH') ) exit;

// Adding custom js to bring the featured products at the first place
add_action('wp_enqueue_scripts', 'wpt_top_featured_product');
function wpt_top_featured_product() {
    wp_enqueue_script('wpt_top_featured-script', plugins_url('featured.js', __FILE__), ['jquery'], '1.0.0', true);
}

// Adding extra class to the featured products to identify them with js
add_filter( 'wpto_tr_class_arr', 'remove_post_class' );
function remove_post_class( $classes ) {
    $_featured_products = wc_get_product();

    if( $_featured_products->is_featured() ) {
        $classes[] = 'featured-top';
    }

    return $classes;
}
