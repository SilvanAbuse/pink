<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );
?>
<div class="pgscore_info_box-inner clearfix">
	<?php
	if ( $icon_html ) {
		?>
		<div class="pgscore_info_box-icon">
			<div class="pgscore_info_box-icon-wrap">
				<?php
				pgscore_get_shortcode_templates( 'info_box/content-parts/icon' );
				if ( $style_2_step_position == 'under_icon' ) {
					pgscore_get_shortcode_templates( 'info_box/content-parts/step' );
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="pgscore_info_box-content">
		<div class="pgscore_info_box-content-wrap">
			<div class="pgscore_info_box-content-inner">
				<?php
				if ( $style_2_step_position == 'above_title' ) {
					pgscore_get_shortcode_templates( 'info_box/content-parts/step' );
				}
				pgscore_get_shortcode_templates( 'info_box/content-parts/title' );
				pgscore_get_shortcode_templates( 'info_box/content-parts/description' );
				?>
			</div>
			<?php
			if ( $style_2_step_position == 'opposite_icon' ) {
				pgscore_get_shortcode_templates( 'info_box/content-parts/step' );
			}
			?>
		</div>
	</div>
</div>
