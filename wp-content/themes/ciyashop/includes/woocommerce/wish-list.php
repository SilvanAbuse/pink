<?php
add_action( 'ciyashop_before_page_wrapper', 'ciyashop_wc_wishlist', 10 );
function ciyashop_wc_wishlist() {
		/**
		 * Filters active plugins.
		 *
		 * @param array $active_plugins List of active plugins.
		 *
		 * @visible false
		 * @ignore
		 */
	if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || in_array( 'yith-woocommerce-wishlist-premium/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		global $ciyashop_options,$cs_product_list_styles;

		switch ( $ciyashop_options['product_hover_style'] ) {
			case $cs_product_list_styles['hover-summary']:
				add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_actions_add_wishlist_link', 20 );
				break;
			case $cs_product_list_styles['icons-top-left']:
			case $cs_product_list_styles['icons-top-right']:
				add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_product_actions_add_wishlist_link', 35 );
				break;
			default:
				add_action( 'ciyashop_product_actions', 'ciyashop_product_actions_add_wishlist_link', 8 );
		}
	}
}

/********************************************************************
 *
 * Product Loop
 *
 ********************************************************************/
// Add wishlist icon
function ciyashop_product_actions_add_wishlist_link() {
	$position               = ciyashop_get_tooltip_position();
	$wishlist_icon_position = isset( $position['wishlist_icon'] ) ? $position['wishlist_icon'] : '';

	if ( $wishlist_icon_position ) {
		?>
		<div class="product-action product-action-wishlist" data-toggle='tooltip' data-original-title="<?php esc_attr_e( 'Wishlist', 'ciyashop' ); ?>" data-placement='<?php echo esc_attr( $wishlist_icon_position ); ?>'>
			<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
		</div>
		<?php
	} else {
		?>
		<div class="product-action product-action-wishlist">
			<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
		</div>
		<?php
	}
}
