<?php
global $WOOCS, $post;

if ( ! $WOOCS ) {
	return;
}
?>
<form method="post" action="#" class="woocommerce-currency-switcher-form" data-ver="<?php echo esc_attr( WOOCS_VERSION ); ?>">
	<input type="hidden" name="woocommerce-currency-switcher" value="<?php echo esc_attr( $WOOCS->current_currency ); ?>" />
	<select name="woocommerce-currency-switcher" class="ciyashop-woocommerce-currency-switcher ciyashop-select2" onchange="woocs_redirect(this.value);void(0);">
		<?php
		foreach ( $WOOCS->get_currencies() as $key => $currency ) {
			/**
			 * @ignore
			 */
			$option_txt  = apply_filters( 'woocs_currname_in_option', $currency['name'] );
			$option_txt .= ' (' . $currency['symbol'] . ')';
			?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $WOOCS->current_currency, $key ); ?>>
				<?php echo esc_html( $option_txt ); ?>
			</option>
			<?php
		}
		?>
	</select>
</form>
