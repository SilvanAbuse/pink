<?php
global $ciyashop_options;

$ciyashop_blog_layout = ( isset( $ciyashop_options['blog_layout'] ) ) ? $ciyashop_options['blog_layout'] : 'classic';
$post_class           = '';

if ( function_exists( 'get_field' ) ) {
	$gallery_images = get_field( 'gallery_images' );
	$image_count    = 0;

	if ( ! empty( $gallery_images ) ) {
		foreach ( $gallery_images  as $gallery_image ) {
			if ( ! empty( $gallery_image['image'] ) ) {
				$image_count++;
			}
		}
	}

	if ( empty( $image_count ) ) {
		$post_class = 'post-no-image';
	}
}

$owl_options_args = array(
	'items'              => 1,
	'loop'               => true,
	'dots'               => false,
	'nav'                => true,
	'margin'             => 10,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'smartSpeed'         => 1000,
	'navText'            => array(
		"<i class='fas fa-angle-left fa-2x'>&nbsp;</i>",
		"<i class='fas fa-angle-right fa-2x'>&nbsp;</i>",
	),
	'lazyLoad'           => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = '';
if ( is_array( $owl_options_args ) && ! empty( $owl_options_args ) ) {
	$owl_options = json_encode( $owl_options_args );
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<?php
	$gallery_type = get_post_meta( get_the_ID(), 'gallery_type', true );
	if ( function_exists( 'have_rows' ) ) {
		if ( have_rows( 'gallery_images' ) ) {
			if ( 'slider' == $gallery_type ) {
				?>
				<div class="blog-entry-slider">
					<div class="blog-gallery-carousel owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
						<?php
						while ( have_rows( 'gallery_images' ) ) {
							the_row();

							// vars
							$image = get_sub_field( 'image' );
							if ( $image ) {
								?>
								<div class="blog-item item">
									<?php
									if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
										echo '<img  data-src="' . esc_url( $image['sizes']['ciyashop-blog-thumb'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" class="owl-lazy" />';
									} else {
										echo '<img  src="' . esc_url( $image['sizes']['ciyashop-blog-thumb'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
									}
									?>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
				<?php
			} elseif ( 'grid' == $gallery_type ) {
				?>
				<div class="blog-entry-grid clearfix ">
					<ul class="grid-post">
						<?php
						while ( have_rows( 'gallery_images' ) ) {
							the_row();

							// vars
							$image = get_sub_field( 'image' );
							if ( $image ) {
								?>
								<li>
									<div class="blog-item">
										<?php
										if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
											echo '<img class="img-fluid ciyashop-lazy-load" alt="' . esc_attr( $image['alt'] ) . '" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $image['sizes']['ciyashop-blog-thumb'] ) . '" >';
										} else {
											echo '<img class="img-fluid" alt="' . esc_attr( $image['alt'] ) . '" src="' . esc_url( $image['sizes']['ciyashop-blog-thumb'] ) . '" >';
										}
										?>
									</div>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<?php
			}
		}
	}
	?>

	<?php if ( 'classic' == $ciyashop_blog_layout || is_single() || is_archive() ) : ?>
		<div class="entry-header-section">
	<?php endif; ?>

	<?php
	get_template_part( 'template-parts/entry_meta-date' );

	if ( ! is_single() ) {
		?>
		<div class="entry-title">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</div>
		<?php
	}

	get_template_part( 'template-parts/entry_meta' );
	?>

	<?php if ( 'classic' == $ciyashop_blog_layout || is_single() || is_archive() ) : ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_single() ) {
			the_content();
		} else {
			the_excerpt();
		}

		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'ciyashop' ) . ':</span>',
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
		?>
	</div>

	<?php get_template_part( 'template-parts/entry_footer' ); ?>

</article><!-- #post -->
