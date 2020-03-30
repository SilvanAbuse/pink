<?php
/**
 * Register Widget
 *
 * @package CiyaShop
 */

/**
 * Register theme widgets.
 *
 * @return void
 */
function ciyashop_register_widgets() {

	require get_parent_theme_file_path( '/includes/widgets/pgs_contactus_widgets.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_instagram_widgets.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_instagram_widgets_2.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_newsletter_widgets.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_opening_hours.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_social_widgets.php' );
	require get_parent_theme_file_path( '/includes/widgets/pgs_testimonials_widgets.php' );

	register_widget( 'pgs_contact_widget' );
	register_widget( 'pgs_instagram_widget' );
	register_widget( 'PGS_Instagram_Widget_2' );
	register_widget( 'pgs_newsletter_widget' );
	register_widget( 'pgs_opening_widget' );
	register_widget( 'pgs_social_widget' );
	register_widget( 'pgs_testimonials_widget' );

	/* Check whether WooCommerce plugin is active, then register WooCommerce related widgets */
	if ( function_exists( 'WC' ) ) {
		require get_parent_theme_file_path( '/includes/widgets/pgs_bestseller_product.php' );
		require get_parent_theme_file_path( '/includes/widgets/pgs_featured_product.php' );
		require get_parent_theme_file_path( '/includes/widgets/pgs_related_product.php' );
		require get_parent_theme_file_path( '/includes/widgets/pgs_shop_flters.php' );
		require get_parent_theme_file_path( '/includes/widgets/pgs_wc-widget-layered-nav.php' );

		register_widget( 'pgs_bestseller_widget' );
		register_widget( 'pgs_featured_products_widget' );
		register_widget( 'pgs_related_widget' );
		register_widget( 'PGS_Shop_Filters_Widget' );
		register_widget( 'Pgs_WC_Widget_Layered_Nav' );

		if ( ciyashop_check_plugin_active( 'yith-woocommerce-brands-add-on/init.php' ) ) {
			require get_parent_theme_file_path( '/includes/widgets/pgs_brand_flters.php' );
			register_widget( 'pgs_brand_filters_widget' );
		}
	}
}
add_action( 'widgets_init', 'ciyashop_register_widgets' );

/**
 * WooCommerce widgets
 *
 * @return void
 */
function ciyashop_override_woocommerce_widgets() {
	// Ensure our parent class exists to avoid fatal error (thanks Wilgert!).
	if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
		unregister_widget( 'WC_Widget_Layered_Nav_Filters' );

		require get_parent_theme_file_path( '/includes/widgets/pgs_layered_nav_filters.php' );

		register_widget( 'PGS_Widget_Layered_Nav_Filters' );
	}
}
add_action( 'widgets_init', 'ciyashop_override_woocommerce_widgets', 15 );
