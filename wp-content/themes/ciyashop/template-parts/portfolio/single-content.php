<?php
global $ciyashop_options;
?>
<article id="post-<?php the_ID(); ?>">	
	<div class="post-details">
		<div class="entry-content">
			<?php
			if ( is_single() ) {
				the_content();
			} else {
				the_excerpt();
			}
			?>
		</div>
	</div>	
</article>
