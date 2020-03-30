<?php
/*
 * Plugin: Advanced Custom Fields: Background
 * Plugin URI: https://github.com/reyhoun/acf-background
 * Version: 1.6.0
 * Author: Reyhoun
 * Author URI: http://reyhoun.com/
*/

// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
// load_plugin_textdomain( 'acf-background', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_background( $version ) {

	include_once( 'acf-background-v5.php' );
}

add_action( 'acf/include_field_types', 'include_field_types_background' );

// 3. Include field type for ACF4
function register_fields_background() {
	include_once( 'acf-background-v4.php' );
}

add_action( 'acf/register_fields', 'register_fields_background' );
