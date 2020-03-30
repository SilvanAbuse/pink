<?php
global $ciyashop_globals;

require_once get_parent_theme_file_path( '/includes/theme-setup-wizard/envato_setup/envato_setup_init.php' );
require_once get_parent_theme_file_path( '/includes/theme-setup-wizard/envato_setup/envato_setup.php' );

// add_filter( 'envato_theme_setup_wizard_theme_name', 'ciyashop_set_theme_setup_wizard_theme_name' );
function ciyashop_set_theme_setup_wizard_theme_name( $theme_name ) {
	global $ciyashop_globals;

	$theme_name = $ciyashop_globals['theme_name'];

	return $theme_name;
}

add_filter( 'envato_setup_logo_image', 'ciyashop_set_envato_setup_logo_image' );
function ciyashop_set_envato_setup_logo_image( $image_url ) {

	$logo_path = get_parent_theme_file_path( 'images/logo.png' );
	$logo_url  = get_parent_theme_file_uri( 'images/logo.png' );

	if ( file_exists( $logo_path ) ) {
		$image_url = $logo_url;
	}

	return $image_url;
}

add_filter( 'ciyashop_theme_setup_wizard_steps', 'ciyashop_theme_setup_wizard_steps_extend' );
function ciyashop_theme_setup_wizard_steps_extend( $steps ) {

	if ( isset( $steps['design'] ) ) {
		unset( $steps['design'] );
	}

	return $steps;
}

// Please don't forgot to change filters tag.
// It must start from your theme's name.
add_filter( $ciyashop_globals['theme_name'] . '_theme_setup_wizard_username', 'ciyashop_set_theme_setup_wizard_username', 10 );
if ( ! function_exists( 'ciyashop_set_theme_setup_wizard_username' ) ) {
	function ciyashop_set_theme_setup_wizard_username( $username ) {
		return 'potenzaglobalsolutions';
	}
}

add_filter( $ciyashop_globals['theme_name'] . '_theme_setup_wizard_oauth_script', 'ciyashop_set_theme_setup_wizard_oauth_script', 10 );
if ( ! function_exists( 'ciyashop_set_theme_setup_wizard_oauth_script' ) ) {
	function ciyashop_set_theme_setup_wizard_oauth_script( $oauth_url ) {
		return 'http://themes.potenzaglobalsolutions.com/api/envato/auth.php';
	}
}

add_filter( 'envato_theme_setup_wizard_styles', 'ciyashop_set_theme_setup_wizard_site_styles', 10 );
if ( ! function_exists( 'ciyashop_set_theme_setup_wizard_site_styles' ) ) {
	function ciyashop_set_theme_setup_wizard_site_styles( $styles ) {

		$styles = array(
			'style_1' => 'Style 1',
			'style_2' => 'Style 2',
			'style_3' => 'Style 3',
		);

		$styles = ciyashop_sample_data_items();

		return $styles;
	}
}

add_filter( $ciyashop_globals['theme_name'] . '_theme_setup_wizard_default_theme_style', 'ciyashop_set_envato_setup_default_theme_style' );
function ciyashop_set_envato_setup_default_theme_style( $style ) {

	$style = 'default';

	return $style;
}

function ciyashop_theme_name_scripts() {
	/* Add Your Custom CSS and JS */
}
add_action( 'admin_init', 'ciyashop_theme_name_scripts', 20 );

add_action( 'admin_head', 'ciyashop_theme_setup_wizard_set_assets', 0 );
function ciyashop_theme_setup_wizard_set_assets() {
	wp_print_scripts( 'ciyashop-theme-setup' );
}

add_filter( 'envato_setup_wizard_footer_copyright', 'ciyashop_envato_setup_wizard_footer_copyright', 10, 2 );
function ciyashop_envato_setup_wizard_footer_copyright( $copyright, $theme_data ) {

	/* translators: %s: Postenza Global Solutions (Name of Theme Developer) */
	$copyright = sprintf(
		/* translators: $s: Company Name */
		esc_html__( '&copy; Created by %s', 'ciyashop' ),
		sprintf(
			'<a href="%s" target="_blank">%s</a>',
			'http://www.potenzaglobalsolutions.com/',
			esc_html__( 'Potenza Global Solutions', 'ciyashop' )
		)
	);

	return $copyright;
}

add_filter( 'envato_theme_setup_wizard_themeforest_profile_url', 'ciyashop_envato_theme_setup_wizard_themeforest_profile_url' );
function ciyashop_envato_theme_setup_wizard_themeforest_profile_url( $url ) {

	$url = '';

	return $url;
}
