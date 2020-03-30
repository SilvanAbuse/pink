<?php
/********************************************************************
 *
 * Product Loop
 *
 ********************************************************************/
// Move "Compare button" to "ciyashop_product_actions"
function ciyashop_wc_compare() {
	if ( class_exists( 'YITH_Woocompare' ) ) {
		global $yith_woocompare, $ciyashop_options, $cs_product_list_styles;
		if ( ! $ciyashop_options ) {
			$ciyashop_options = get_option( 'ciyashop_options' );
		}

		$product_hover_style = ( isset( $ciyashop_options['product_hover_style'] ) && ! empty( $ciyashop_options['product_hover_style'] ) ) ? $ciyashop_options['product_hover_style'] : 'image-center';

		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
		switch ( $product_hover_style ) {
			case $cs_product_list_styles['icons-bottom-bar']:
			case $cs_product_list_styles['info-bottom']:
			case $cs_product_list_styles['info-bottom-bar']:
				add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_start', 11 );
				add_action( 'ciyashop_product_actions', array( $yith_woocompare->obj, 'add_compare_link' ), 12 );
				add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_end', 13 );
				break;
			default:
				add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_start', 9 );
				add_action( 'ciyashop_product_actions', array( $yith_woocompare->obj, 'add_compare_link' ), 10 );
				add_action( 'ciyashop_product_actions', 'ciyashop_product_action_compare_wrapper_end', 11 );
		}
	}
}
add_action( 'init', 'ciyashop_wc_compare', 19 );

function ciyashop_product_action_compare_wrapper_start() {
	$position         = ciyashop_get_tooltip_position();
	$compare_position = isset( $position['compare_icon'] ) ? $position['compare_icon'] : '';

	if ( $compare_position ) {
		?>
		<div class="product-action product-action-compare" data-toggle='tooltip' data-original-title="<?php esc_attr_e( 'Compare', 'ciyashop' ); ?>" data-placement='<?php echo esc_attr( $compare_position ); ?>'>
		<?php
	} else {
		?>
		<div class="product-action product-action-compare">
		<?php
	}
}
function ciyashop_product_action_compare_wrapper_end() {
	?>
	</div>
	<?php
}

add_action( 'yith_woocompare_popup_head', 'ciyashop_compare_init' );
function ciyashop_compare_init() {

	remove_filter( 'woocommerce_loop_add_to_cart_link', 'ciyashop_woocommerce_loop_add_to_cart_link', 10, 2 );
	add_filter( 'woocommerce_loop_add_to_cart_link', 'ciyashop_woocommerce_compare_add_to_cart_link', 10, 2 );
	function ciyashop_woocommerce_compare_add_to_cart_link( $link, $product ) {
		if ( $product->is_in_stock() ) {
			$position      = ciyashop_get_tooltip_position();
			$cart_position = isset( $position['cart_icon'] ) ? $position['cart_icon'] : '';
				return '<div class="product-action product-action-add-to-cart">' . $link . '</div>';
		}
		return '';
	}

	// add 'woocommerce-compare' class
	add_filter( 'body_class', 'ciyashop_compare_body_class' );
}

function ciyashop_compare_body_class( $classes ) {

	$classes[] = 'woocommerce-compare';

	return $classes;
}

add_filter( 'wp_title', 'ciyashop_compare_wp_title', 10, 3 );
function ciyashop_compare_wp_title( $title, $sep, $seplocation ) {
	if ( ( isset( $_REQUEST['action'] ) || 'yith-woocompare-view-table' == $_REQUEST['action'] ) ) {
		$title = esc_html__( 'Product Comparison', 'ciyashop' );
	}
	return $title;
}

// Load theme's style
function prefix_add_footer_styles() {

	global $wp_styles;

	if ( ( $wp_styles instanceof WP_Styles ) ) {
		wp_styles()->do_items( 'ciyashop-style' );
		wp_styles()->do_items( 'ciyashop-responsive' );
		wp_styles()->do_items( 'ciyashop-color-customize' );
	}
};
add_action( 'yith_woocompare_after_main_table', 'prefix_add_footer_styles' );
