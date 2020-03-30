<?php
/************************************************************************************
 *
 * Visual Composer
 *
 ************************************************************************************/

/*
 * Prevent Visual Composer Redirection after plugin activation
 */
remove_action( 'admin_init', 'vc_page_welcome_redirect', 9999 );

/*
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 * http://tgmpluginactivation.com/faq/updating-bundled-visual-composer/
 * https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524297
 */
add_action( 'vc_before_init', 'ciyashop_vcSetAsTheme' );
function ciyashop_vcSetAsTheme() {
	vc_set_as_theme();

	$vc_supported_cpts = array(
		'page',
		'post',
	);
	vc_set_default_editor_post_types( $vc_supported_cpts );
}

add_action( 'admin_init', 'ciyashop_hide_vc_activation_nag' );
function ciyashop_hide_vc_activation_nag() {
	if ( is_admin() ) {
		setcookie( 'vchideactivationmsg', '1', strtotime( '+3 years' ), '/' );
		setcookie( 'vchideactivationmsg_vc11', ( defined( 'WPB_VC_VERSION' ) ? WPB_VC_VERSION : '1' ), strtotime( '+3 years' ), '/' );
	}
}

/************************************************************************************
 *
 * Revolution Slider
 *
 ************************************************************************************/

// Remove Revolution Slider custom template.
add_filter( 'theme_page_templates', 'ciyashop_remove_revslider_template', 11 );
function ciyashop_remove_revslider_template( $post_templates ) {
	unset( $post_templates['../public/views/revslider-page-template.php'] );

	return $post_templates;
}

/************************************************************************************
 *
 * Breadcrumb NavXT
 *
 ************************************************************************************/

/*
 * Remove the blog from the 404 and search breadcrumb trail
 */
if ( function_exists( 'bcn_display' ) ) {
	function ciyashop_wpst_override_breadcrumb_trail( $trail ) {
		if ( is_404() || is_search() ) {
			unset( $trail->trail[1] );
			array_keys( $trail->trail );
		}
	}

	add_action( 'bcn_after_fill', 'ciyashop_wpst_override_breadcrumb_trail' );
}

/************************************************************************************
 *
 * Advanced Custom Fields
 *
 ************************************************************************************/
add_filter( 'acf/updates/plugin_update', 'ciyashop_update_acfpro_plugin', 11, 2 );
function ciyashop_update_acfpro_plugin( $update, $transient ) {

	if ( function_exists( 'acf_pro_is_license_active' ) && ! acf_pro_is_license_active() && is_object( $update ) ) {
		$update->package = get_parent_theme_file_uri( '/includes/plugins/advanced-custom-fields-pro.zip' );
	}
	return $update;
}

add_filter( 'upgrader_package_options', 'ciyashop_update_acfpro_package_options' );
function ciyashop_update_acfpro_package_options( $options ) {

	if ( ! empty( $options ) && isset( $options['hook_extra']['plugin'] ) && 'advanced-custom-fields-pro/acf.php' == $options['hook_extra']['plugin'] ) {

		$tgmpa_plugins      = ciyashop_tgmpa_plugin_list();
		$acf_pro_index      = array_search( 'advanced-custom-fields-pro', array_column( $tgmpa_plugins, 'slug' ) );
		$acf_pro_data       = $tgmpa_plugins[ $acf_pro_index ];
		$options['package'] = $acf_pro_data['source'];
	}
	return $options;
}

/************************************************************************************
 *
 * Contact Form 7
 *
 ************************************************************************************/
// Disable default assets loading
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Load assets on pages containing CF7 shortcodes.
function ciyashop_cf7_load_assets() {
	global $post;
	if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'contact-form-7' ) || has_shortcode( $post->post_content, 'contact-form' ) ) ) {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}
}
add_action( 'wp_enqueue_scripts', 'ciyashop_cf7_load_assets' );

/************************************************************************************
 *
 * Redux Framework
 *
 ************************************************************************************/
// Remove Redux Framework ads in Backend
add_filter( 'redux/ciyashop_options/aURL_filter', 'ciyashop_remove_redux_ads' );
function ciyashop_remove_redux_ads( $redux_ads ) {
	return false;
}
