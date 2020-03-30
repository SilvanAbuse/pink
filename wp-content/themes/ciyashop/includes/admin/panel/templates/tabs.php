<?php
$tabs        = $this->sections;
$current_tab = $this->get_current_tab();
?>
<h2 class="nav-tab-wrapper">
	<?php
	$tabs_sr = 1;
	foreach ( $tabs as $tab_k => $tab ) {
		if ( 1 == $tabs_sr ) {
			$tab_slug = 'license';
			$tab_url  = admin_url( 'admin.php?page=' . $this->args['slug'] );
		} else {
			// $tab_slug = $this->args['slug'].'-'.sanitize_text_field($tab['slug']);
			$tab_slug = sanitize_text_field( $tab['slug'] );
			$tab_url  = admin_url( 'admin.php?page=' . $this->args['slug'] . '-' . $tab_slug );
		}

		$classes   = array(
			'nav-tab',
		);
		$classes[] = 'nav-tab-' . $tab['slug'];

		if ( isset( $tab['link_type'] ) && 'custom' == $tab['link_type'] ) {
			$tab_url = $tab['link'];
		}

		if ( $current_tab == $tab_slug ) {
			$classes[] = 'nav-tab-active';
		}
		$classes = implode( ' ', array_filter( array_unique( $classes ) ) );
		?>
		<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $tab_url ); ?>">
			<?php echo esc_html( $tab['title'] ); ?>
		</a>
		<?php
		$tabs_sr++;
	}
	?>
</h2>
