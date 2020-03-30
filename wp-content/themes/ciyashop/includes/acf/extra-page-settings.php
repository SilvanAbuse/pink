<?php
/**
 * AFC extra settings.
 *
 * @package CiyaShop
 */

add_filter( 'acf/get_field_groups', 'ciyashop_woocommerece_page_settings_group_fields', 20, 1 );

/**
 * WooCommerce page settings
 *
 * @param array $field_groups field group.
 * @return $field_groups
 */
function ciyashop_woocommerece_page_settings_group_fields( $field_groups ) {
	global $post;

	// bail early, if not a post.
	if ( ! $post ) {
		return $field_groups;
	}

	$wc_page_ids = array();
	$pages       = array( 'myaccount', 'shop', 'cart', 'checkout', 'terms' );

	if ( function_exists( 'wc_get_page_id' ) ) {
		foreach ( $pages as $page ) {
			$wc_page_ids[] = wc_get_page_id( $page );
		}

		if ( has_shortcode( $post->post_content, 'yith_wcwl_wishlist' ) ) {
			$wc_page_ids[] = $post->ID;
		}
	}

	// bail early, if not a WooCommerce page.
	if ( ! in_array( $post->ID, $wc_page_ids ) ) {
		return $field_groups;
	}

	$page_settings_field_group_key = array_search( 'group_57501ad11cf25', array_column( $field_groups, 'key' ) );

	if ( $page_settings_field_group_key ) {
		unset( $field_groups[ $page_settings_field_group_key ] );
	}

	return $field_groups;
}
