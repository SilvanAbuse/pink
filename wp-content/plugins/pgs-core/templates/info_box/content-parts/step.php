<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

$step_wrapper_styles = $step_styles = array();

if ( $layout == 'style_4' ) {
	if ( $style_4_step_color && trim( $style_4_step_color ) != false ) {
		$step_styles['color'] = "color:{$style_4_step_color};";
	}
} elseif ( $layout == 'style_5' ) {
	if ( $style_5_step_color && trim( $style_5_step_color ) != false ) {
		$step_styles['color'] = "color:{$style_5_step_color};";
	}
}

$step_wrapper_styles = implode( ' ', array_filter( array_unique( $step_wrapper_styles ) ) );
$step_styles         = implode( ' ', array_filter( array_unique( $step_styles ) ) );

if ( $enable_step == 'true' || $layout == 'style_4' || $layout == 'style_5' ) {
	if ( ( $layout == 'style_4' || $layout == 'style_5' ) && isset( $step_4_5 ) ) {
		$step = $step_4_5;
	}
	?>
	<div class="pgscore_info_box-step-wrapper" style="<?php echo esc_attr( $step_wrapper_styles ); ?>">
		<?php
		if ( ( $layout == 'style_4' || $layout == 'style_5' ) && isset( $step_tag ) ) {
			?>
			<<?php echo $step_tag; ?> class="pgscore_info_box-step" style="<?php echo esc_attr( $step_styles ); ?>">
				<?php echo esc_html( $step ); ?>
			</<?php echo $step_tag; ?>>
			<?php
		} else {
			?>
			<span class="pgscore_info_box-step" style="<?php echo esc_attr( $step_styles ); ?>">
			<?php echo esc_html( $step ); ?>
			</span>
			<?php
		}
		?>
	</div>
	<?php
}
