<?php
function pgscore_widgets_classes() {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/widgets/categories.php';
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/widgets/recent-posts.php';
}
add_action( 'plugins_loaded', 'pgscore_widgets_classes', 20 );

// register widgets
function pgscore_register_widgets() {
	register_widget( 'PGSCore_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'pgscore_register_widgets' );
