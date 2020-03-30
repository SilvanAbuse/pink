<?php

add_action( 'after_setup_theme', 'pgs_promo_notice' );

if ( ! function_exists( 'pgs_promo_notice' ) ) {

	function pgs_promo_notice() {
		// The promo time
		$review_time = get_option( 'ciyashop_notice_promo_time' );

		if ( '' == $review_time ) {
			$review_time = time();
			update_option( 'ciyashop_notice_promo_time', $review_time );
		}

		// Are we to show the promo popup
		if ( '' != $review_time && $review_time > 0 ) {
			add_action( 'admin_notices', 'ciyashop_designer_promo' );
		} else {
			$time = time();
			if ( ( $time - abs( $review_time ) ) >= 1000000 ) {
				update_option( 'ciyashop_notice_promo_time', $time );
			}
		}

		// Are we to disable the promo popup
		if ( isset( $_GET['ciyashop_notice_promo'] ) && 0 == (int) $_GET['ciyashop_notice_promo'] ) {
			$time = time();

			update_option( 'ciyashop_notice_promo_time', ( 0 - $time ) );
			die( $time );
		}
	}
}

if ( ! function_exists( 'ciyashop_designer_promo' ) ) {

	// Show the promo
	function ciyashop_designer_promo() {

		$review_time = get_option( 'ciyashop_notice_promo_time' );

		echo '
            <script>
            jQuery(document).ready( function() {
                    (function($) {
                            $("#ciyashop_notice_promo .ciyashop_notice_promo-close").click(function(){
                                    var data;

                                    // Hide it
                                    $("#ciyashop_notice_promo").hide();

                                    // Save this preference
                                    $.post("' . admin_url( '?ciyashop_notice_promo=0' ) . '", data, function(response) {
                                            //alert(response);
                                    });
                            });
                    })(jQuery);
            });
            </script>';

				echo '
                <div class="notice notice-success" id="ciyashop_notice_promo" style="min-height:120px">
                        <a class="ciyashop_notice_promo-close" href="javascript:" aria-label="Dismiss this Notice">
                                <span class="dashicons dashicons-dismiss"></span> Dismiss
                        </a>
                        <img src="' . get_template_directory_uri() . '/images/admin/welcome-logo.png" style="float:left; margin:10px 20px 10px 10px" width="100" />
                        <p style="font-size:16px">' . __( 'Thanks for Purchasing our item and being part of <strong>Potenza</strong>. If you like our Item and support, Please share your honest rate and review. Your detailed review in Comments will add more value to our services! Advance Thanks in Anticipation!', 'ciyashop' ) . '</p>
                        <p>
                               <a class="ciyashop_notice_button ciyashop_notice_button2" target="_blank" href="http://themeforest.net/downloads">' . __( "Rate it 5&#9733;'s", 'ciyashop' ) . '</a>
                                <a class="ciyashop_notice_button ciyashop_notice_button3" target="_blank" href="http://docs.potenzaglobalsolutions.com/docs/ciyashop-wp/">' . __( 'Documentation', 'ciyashop' ) . '</a>
								<a class="ciyashop_notice_button ciyashop_notice_button5" target="_blank" href="https://www.youtube.com/watch?v=Jng3bJDDlqI&list=PLplHaPmX0cKUB56krFQov9XI10I7DMgQS">' . __( 'Video Tutorial', 'ciyashop' ) . '</a>
                                <a class="ciyashop_notice_button ciyashop_notice_button4" target="_blank" href="https://ciyashop.potenzaglobalsolutions.com/">' . __( 'View Demo', 'ciyashop' ) . '</a>                                
								<a class="ciyashop_notice_button ciyashop_notice_button6" target="_blank" href="https://themeforest.net/item/ciyashop-responsive-multipurpose-woocommerce-wordpress-theme/22055376/support">' . __( 'Support', 'ciyashop' ) . '</a>
                        </p>
                </div>';

	}
}
