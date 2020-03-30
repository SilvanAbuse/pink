<?php
global $smart_product, $threesixtyslider, $ciyashop_options;
$threesixtyslider_id = $smart_product['360id'];
?>
<?php do_action( 'before_smart_product_html', $threesixtyslider->postID ); ?>
<div id="threesixty-slider-<?php echo esc_attr( $threesixtyslider_id ); ?>" class="mfp-hide threesixty-loading threesixty-image <?php $threesixtyslider->classes(); ?>" style="width: <?php echo esc_attr( $threesixtyslider->width ); ?>px;">
	<div class="threesixty-preview-<?php echo esc_attr( $threesixtyslider_id ); ?>">
		<?php
		if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
			echo '<img class="threesixty-preview-image ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $threesixtyslider->imagesURLs[ $threesixtyslider->imagesCount - 1 ] ) . '"/>';
		} else {
			echo '<img class="threesixty-preview-image" src="' . esc_url( $threesixtyslider->imagesURLs[ $threesixtyslider->imagesCount - 1 ] ) . '"/>';
		}
		?>
	</div>
	<div class="threesixty-spinner threesixty-spinner-<?php echo esc_attr( $threesixtyslider_id ); ?>">
		<span>0%</span>
	</div>
	<ol class="threesixty-images threesixty-images-<?php echo esc_attr( $threesixtyslider_id ); ?>"></ol>
	<?php if ( $threesixtyslider->useScrollbar() ) : ?>
	<div class="threesixty-scrollbar">
		<div id="nouislider-<?php echo esc_attr( $threesixtyslider_id ); ?>"></div>
	</div>
	<?php endif; ?>
</div>
<?php do_action( 'after_smart_product_html', $threesixtyslider->postID ); ?>
<!--SPV--><script>//SPV
(function($) {
	<?php if ( 'true' == $threesixtyslider->fullscreen ) : ?>
	$('#threesixty-anchor-<?php echo esc_js( $threesixtyslider_id ); ?>').magnificPopup({
		type:'inline',
		closeOnBgClick: true,
		midClick: true,
		callbacks: {
			resize: function() {
				var originalHeight 	= <?php echo esc_js( $threesixtyslider->heightOrigianl ); ?>,
					originalWidth 	= <?php echo esc_js( $threesixtyslider->widthOrigianl ); ?>,
					mfpHeight 		= <?php echo esc_js( $threesixtyslider->heightOrigianl ); ?>,
					mfpWidth 		= <?php echo esc_js( $threesixtyslider->widthOrigianl ); ?>,
					ratio 			= originalWidth / originalHeight,
					winHeight 		= $(window).height(),
					winWidth 		= $(window).width();

				if ( originalHeight > winHeight * 0.9 ) {
					mfpHeight 		= winHeight * 0.9;
					mfpWidth 		= mfpHeight * ratio;
				}
				if ( mfpWidth > winWidth * 0.9 ) {
					mfpWidth 		= winWidth * 0.9;
					mfpHeight 		= mfpWidth / ratio;
				}
				if ( mfpHeight < originalHeight && mfpWidth < originalWidth ) {
					$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').height(mfpHeight);
					$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').width(mfpWidth);
				} 
				else {
					$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').height(originalHeight);
					$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').width(originalWidth);
				}
			},
			close: function() {
				$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').height('auto');
				$('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').width(<?php echo esc_js( $threesixtyslider->width ); ?>);
			}
		},
		closeMarkup :"<button class=\"mfp-close\"></button>"
	});
	<?php endif; ?>
	var product_<?php echo esc_js( $threesixtyslider_id ); ?> = $('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').ThreeSixty({
		totalFrames: <?php echo esc_js( $threesixtyslider->getImagesCount() ); ?>,
		endFrame: 0,
		currentFrame: <?php echo esc_js( $threesixtyslider->getImagesCount() ); ?>,
		imgList: '.threesixty-images-<?php echo esc_js( $threesixtyslider_id ); ?>',
		progress: '.threesixty-spinner-<?php echo esc_js( $threesixtyslider_id ); ?>',
		preview: '.threesixty-preview-<?php echo esc_js( $threesixtyslider_id ); ?>',
		images: <?php $threesixtyslider->imagesJSArray(); ?>,
		height: 0,
		width: <?php echo esc_js( $threesixtyslider->width ); ?>,
		navigation: <?php echo esc_js( $threesixtyslider->navigation ); ?>,
		drag: <?php echo esc_js( $threesixtyslider->drag ); ?>,
		showCursor: true,
		interval: <?php echo esc_js( $threesixtyslider->interval ); ?>,
		speedMultiplier: <?php echo esc_js( $threesixtyslider->speedMultiplier ); ?>,
		<?php if ( 'true' == $threesixtyslider->autoplay ) : ?>
		startAutoplay: true,
		<?php endif; ?>
		onReady: function() {
			$("#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>").removeClass('threesixty-loading');
			<?php if ( 'true' == $threesixtyslider->autoplay ) : ?>
				product_<?php echo esc_js( $threesixtyslider_id ); ?>.play();
			<?php endif; ?>
			<?php if ( $threesixtyslider->useScrollbar() ) : ?>
			$('#nouislider-<?php echo esc_js( $threesixtyslider_id ); ?>').noUiSlider({
				range: {
					'min': 0, 
					'max': <?php echo esc_js( $threesixtyslider->getImagesCount() - 1 ); ?>
				},
				start: <?php echo esc_js( $threesixtyslider->scrollbar_start ); ?>,
				step: 1,
				orientation: '<?php echo esc_js( ( $threesixtyslider->verticalScrollbar() ) ? 'vertical' : 'horizontal' ); ?>',
				direction: "<?php echo esc_js( $threesixtyslider->direction ); ?>",
				serialization: {
					lower: [
						$.Link({
							target: function( val ) {
								product_<?php echo esc_js( $threesixtyslider_id ); ?>.gotoAndPlay( val );
							}
						})
					]
				}		
			});
			$('#nouislider-<?php echo esc_js( $threesixtyslider_id ); ?>.noUi-vertical').height(parseInt($('#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>').height())-40);
			<?php endif; ?>
		}
		<?php do_action( 'after_smart_product_js_arguments', $threesixtyslider->postID ); ?>
	});
	<?php if ( 'true' == $threesixtyslider->moveOnScroll ) : ?>
	$(window).scroll(function(event) {
		var page_percentage, frame_value, page_offset;
		page_offset = $(window)[0].pageYOffset;
		if(page_offset) {
			frame_value = Math.abs(Math.floor(page_offset / <?php echo esc_js( $threesixtyslider->interval ); ?> * 2));
			if(frame_value > <?php echo esc_js( $threesixtyslider->getImagesCount() ); ?>){
				frame_value = frame_value % <?php echo esc_js( $threesixtyslider->getImagesCount() ); ?>;
			};
			product_<?php echo esc_js( $threesixtyslider_id ); ?>.gotoAndPlay(frame_value);
		}
	});
	<?php endif; ?>
	<?php if ( 'true' == $threesixtyslider->moveOnHover ) : ?>
	$("#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>").mouseover(function(){
		product_<?php echo esc_js( $threesixtyslider_id ); ?>.play();
	});
	$("#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>").mouseleave(function(){
		product_<?php echo esc_js( $threesixtyslider_id ); ?>.stop();
	});
	<?php elseif ( 'true' == $threesixtyslider->stopOnHover ) : ?>
	$("#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>").mouseover(function(){
		product_<?php echo esc_js( $threesixtyslider_id ); ?>.stop();
	});
	$("#threesixty-slider-<?php echo esc_js( $threesixtyslider_id ); ?>").mouseleave(function(){
		product_<?php echo esc_js( $threesixtyslider_id ); ?>.play();
	});
	<?php endif; ?>
}(jQuery));
</script>
