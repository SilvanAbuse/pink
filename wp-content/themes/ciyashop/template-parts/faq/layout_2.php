<?php
global $ciyashop_options;

/**
 * Fires before faq layout 2 initiated.
 *
 * @visible false
 * @ignore
 */
do_action( 'faq_layout_2_init' );

if ( ! ciyashop_check_plugin_active( 'pgs-core/pgs-core.php' ) ) {
	return;
}

$faq_page_query = array(
	'post_type'      => 'faqs',
	'posts_per_page' => -1,
);

$layout_2_category        = '';
$layout_2_category_option = ( isset( $ciyashop_options['layout_2_category'] ) ) ? $ciyashop_options['layout_2_category'] : '';
if ( ! empty( $layout_2_category_option ) ) {
	$layout_2_category = $layout_2_category_option;
}

if ( ! empty( $layout_2_category ) ) {

	$faq_category_data = get_term_by( 'id', $layout_2_category, 'faq-category' );

	$faq_page_query['tax_query'] = array(
		array(
			'taxonomy' => 'faq-category',
			'field'    => 'term_id',
			'terms'    => array( $faq_category_data->term_id ),
		),
	);
	query_posts( $faq_page_query );
	if ( have_posts() ) {
		?>
		<div class="accordion">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<div class="accordion-title">
					<a href="#"><?php the_title(); ?></a>
				</div>
				<div class="accordion-content"> 
					<?php the_content(); ?>					
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		?>
		<div class=""><h3><?php esc_html_e( 'Nothing found.', 'ciyashop' ); ?></h3></div>
		<?php
	}
	wp_reset_query();
} else {
	?>
	<div class=""><h3><?php esc_html_e( 'Nothing found.', 'ciyashop' ); ?></h3></div>
	<?php
}
