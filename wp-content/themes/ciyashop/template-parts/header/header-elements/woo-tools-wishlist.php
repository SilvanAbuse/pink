<?php
// Return if compare plugin is not installed/activated ($yith_woocompare == null)
if ( ! class_exists( 'YITH_WCWL' ) || wp_is_mobile() ) {
	return;
}

$yith_wcwl    = YITH_WCWL();
$wishlist_url = $yith_wcwl->get_wishlist_url();
?>
<li class="woo-tools-action woo-tools-wishlist">
	<a href="<?php echo esc_url( $wishlist_url ); ?>"><?php ciyashop_wishlist_icon(); ?>
	<span class="wishlist ciyashop-wishlist-count">
		<?php echo YITH_WCWL()->count_products(); ?>
	</span>
	</a>
</li>
