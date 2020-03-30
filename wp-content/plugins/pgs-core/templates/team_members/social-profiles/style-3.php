<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
?>
<div class="team-social-icon pgssi-style-border pgscore-social-icons pgssi-shape-Round pgssi-effect-color-hover pgssi-size-small">
	<?php
	if ( function_exists( 'have_rows' ) ) {
		if ( have_rows( 'social_profiles' ) ) {
			?>
			<ul>
				<?php
				while ( have_rows( 'social_profiles' ) ) {
					the_row();
					$social_title = get_sub_field( 'social_title' );
					$social_icon  = get_sub_field( 'social_icon' );
					$social_url   = get_sub_field( 'social_url' );
					if ( $social_title && $social_icon && $social_url ) {
						$icon_classes   = array();
						$icon_classes[] = 'pgssi-item';
						$icon_classes[] = 'pgssi-color-' . sanitize_title( $social_title );
						$icon_classes   = pgscore_class_builder( $icon_classes );

						if ( ( strpos( $social_icon['value'], 'fab' ) !== false ) || ( strpos( $social_icon['value'], 'fas' ) !== false ) || ( strpos( $social_icon['value'], 'far' ) !== false ) ) {
							$social_icon_value = $social_icon['value'];
						} else {
							$social_icon_value = 'fa ' . $social_icon['value'];
						}
						?>
						<li class="<?php echo esc_attr( $icon_classes ); ?>">
							<a href="<?php echo esc_url( $social_url ); ?>" title="<?php echo esc_attr( ( $social_title ) ? $social_title : '' ); ?>">
								<i class="<?php echo esc_attr( $social_icon_value ); ?>"></i>
							</a>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
		}
	}
	?>
</div>
