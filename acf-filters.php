<?php
/**
 * Plugin Name: Advanced Custom Fields: Filters-field
 * Description: Adds new field type where you can choose filters to build a post grid later on.
 * Version:     1.0.0
 * Author:      Iikka Timlin
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-filters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

spl_autoload_register( function( $classname ) {
	$prefix = 'Urbanproof\\ACF\\';
	$base_dir = __DIR__ . '/classes/';
	$prefix_len = strlen( $prefix );
	if ( strncmp( $prefix, $classname, $prefix_len ) !== 0 ) {
		return;
	}
	$relative_classname = substr( $classname, $prefix_len );
	$file = $base_dir . str_replace( '\\', '/', $relative_classname ) . '.php';
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

new Urbanproof\ACF\FilterFieldPlugin();
