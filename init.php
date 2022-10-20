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
if( ! defined( 'ABSPATH' ) ) exit;

// Bring the featured products at the first place in Frontend
add_filter( 'wpto_table_query_args', 'wpt_addon_wpto_table_query_args', 99, 6 );
function wpt_addon_wpto_table_query_args( $args, $table_ID, $atts, $column_settings, $enabled_column_array, $column_array ){
    /**
     * All the term's id from filtered products.
     * It needs to handle more filterings like tag and others that this plugin provide.
     * It is just a mirror code that proves the sorting potential of the featured products.
     * More additional reviews as well as codes needed to make it robust and sophisticated.
     */
    $wpt_product_terms = $args['tax_query']['product_cat_IN']['terms'];

    // retrieving featured all featured product ids
    $wpt_featured_ids = array_reverse( wc_get_featured_product_ids() );

    $wpt_products_ids = [];

    $wpt_products = get_posts([
        'post_type' => 'product',
        'numberposts' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $wpt_product_terms,
                'include_children' => false
            ]
        ]
    ]);

    // Saving all products' id from selected terms
    foreach( $wpt_products as $wpt_product ) {
        $wpt_products_ids[] = $wpt_product->ID;
    }

    // Scrapping the featured ids that are available inside selected terms.
    $wpt_valid_featured_id = array_intersect( $wpt_featured_ids, $wpt_products_ids );

    if( ! empty( $wpt_valid_featured_id ) ) {
        $wpt_sorted_products = array_merge( $wpt_valid_featured_id, $wpt_products_ids);
        $args['orderby'] = 'post__in';
        $args['post__in'] = array_unique($wpt_sorted_products);
    }

    return $args;
}


// Bring the featured products at the first place in Dashboard
add_filter( 'posts_orderby', function( $orderby, $query ) {
    $post_types = (array) $query->get( 'post_type' );

    if ( in_array( 'product', $post_types ) ) {
        $wpt_featured_ids = wc_get_featured_product_ids();

        if ( ! empty( $wpt_featured_ids ) ) {
            $backend_orderby = "FIELD(wp_posts.ID,'" . implode( "','", $wpt_featured_ids ) . "') DESC";
            $orderby = empty( $orderby ) ? $backend_orderby : "$backend_orderby, $orderby";
        }
    }

    return $orderby;

}, 100, 2 );

// Adding extra class can be helpful to design them differently
add_filter( 'wpto_tr_class_arr', 'remove_post_class' );
function remove_post_class( $classes ) {
    $_featured_products = wc_get_product();

    if( $_featured_products->is_featured() ) {
        $classes[] = 'featured-top';
    }

    return $classes;
}
