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

add_filter( 'wpto_table_query_args', 'wpt_addon_wpto_table_query_args', 99, 6 );
function wpt_addon_wpto_table_query_args( $args, $table_ID, $atts, $column_settings, $enabled_column_array, $column_array ){
    
    $args['orderby'] = 'featured_products';
    // var_dump($args);
    return $args;
}

/**
 * Getting help from github:
 * @link https://gist.github.com/felipeelia/1214cede99a9bf27df68db3086dabf56
 *
 * @param [type] $orderby
 * @param [type] $query
 * @return void
 */
function featured_products_orderby( $orderby, $query ) {
	global $wpdb;
    
    
	if ( 'featured_products' == $query->get( 'orderby' ) ) {
		$featured_product_ids = (array) wc_get_featured_product_ids();
        // var_dump(var_dump($orderby),$featured_product_ids);
		if ( count( $featured_product_ids ) ) {
			$string_of_ids = '(' . implode( ',', $featured_product_ids ) . ')';
			$orderby = "( {$wpdb->posts}.ID IN {$string_of_ids}) " . $query->get( 'order' )." , post_date DESC";
		}
        // var_dump($orderby);
	}

	return $orderby;
}
add_filter( 'posts_orderby', 'featured_products_orderby', 10, 2 );

// function featured_products_orderby( $orderby, $query ) {
//     global $wpdb;
    
//     if ( 'featured_products' == $query->get( 'orderby' ) ) {
//     $featured_product_ids = (array) wc_get_featured_product_ids();
//     if ( count( $featured_product_ids ) ) {
//     $string_of_ids = '(' . implode( ',', $featured_product_ids ) . ')';
//     $orderby = "( {$wpdb->posts}.ID IN {$string_of_ids}) " . $query->get( 'order' )." , post_date DESC";
//     }
//     }
    
//     return $orderby;
//     }