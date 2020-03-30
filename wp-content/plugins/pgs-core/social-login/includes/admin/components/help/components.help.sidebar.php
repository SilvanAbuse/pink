<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_help_sidebar() {
	do_action( "pgssl_component_help_sidebar_start" );
	?>
	<div class="postbox">
		<div class="inside">
			<h3><?php _pgssl_e("About PGS Social Login", 'pgssl-text-domain') ?> <?php echo pgssl_get_version(); ?></h3>

			<div style="padding:0 20px;">
				<p>
					<?php _pgssl_e('PGS Social Login is a free and open source plugin made by the community, for the community', 'pgssl-text-domain') ?>.
				</p> 
				<p>
					<?php _pgssl_e('Basically, PGS Social Login allow your website visitors and customers to register and login via social networks such as twitter, facebook and google but it has much more to offer', 'pgssl-text-domain') ?>.
				</p> 
				<p>
					<?php _pgssl_e('For more information about PGS Social Login, refer to our online user guide', 'pgssl-text-domain') ?>.
				</p> 
			</div> 
		</div> 
	</div> 
	<div class="postbox">
		<div class="inside">
			<h3><?php _pgssl_e("Thanks", 'pgssl-text-domain') ?></h3>

			<div style="padding:0 20px;">
				<p>
					<?php _pgssl_e('Big thanks to everyone who have contributed to PGS Social Login by submitting Patches, Ideas, Reviews and by Helping in the support forum', 'pgssl-text-domain') ?>.
				</p> 
			</div> 
		</div> 
	</div>
	<?php
	do_action( "pgssl_component_help_sidebar_end" );
}