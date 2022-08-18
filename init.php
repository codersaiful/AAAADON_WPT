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
    var_dump($args);
    return $args;
}