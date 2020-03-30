<?php
/*
 * This function use for subscribe user in mailchimp.
 */
add_action( 'wp_ajax_mailchimp_singup', 'pgscore_mailchimp_signup_action' );
add_action( 'wp_ajax_nopriv_mailchimp_singup', 'pgscore_mailchimp_signup_action' );
function pgscore_mailchimp_signup_action() {

	global $pgscore_globals, $theme_option;

	$theme_option = $GLOBALS[ $pgscore_globals['options_name'] ];

	require_once trailingslashit( PGSCORE_PATH ) . 'includes/lib/mailchimp/Mailchimp.php'; // mailchimp class library

	$apikey = '';
	$listId = '';

	/* -----------------------------------------------
	 *
	 * MailChimp API Key
	 *
	 * ----------------------------------------------- */
	if ( isset( $theme_option['mailchimp_api_key'] ) && '' != $theme_option['mailchimp_api_key'] ) {
		$apikey = esc_html( $theme_option['mailchimp_api_key'] );
	}

	// Override API Key from wp-config.php
	if ( defined( 'PGSCORE_MAILCHIMP_APIKEY' ) && '' != PGSCORE_MAILCHIMP_APIKEY ) {
		$apikey = PGSCORE_MAILCHIMP_APIKEY;
	}

	/* -----------------------------------------------
	 *
	 * MailChimp List ID
	 *
	 * ----------------------------------------------- */
	if ( isset( $theme_option['mailchimp_list_id'] ) && '' != $theme_option['mailchimp_list_id'] ) {
		$listId = esc_html( $theme_option['mailchimp_list_id'] );
	}

	// Override List ID from wp-config.php
	if ( defined( 'PGSCORE_MAILCHIMP_LISTID' ) && '' != PGSCORE_MAILCHIMP_LISTID ) {
		$listId = PGSCORE_MAILCHIMP_LISTID;
	}

	$msg             = $msg_raw = esc_html__( 'Something went wrong. Please try again later.', 'pgs-core' );
	$newsletter_stat = false;

	if ( empty( $apikey ) || empty( $listId ) ) {
		echo esc_html( $msg );

		wp_die();
	}

	$newsletter_email = $_REQUEST['newsletter_email'];

	$sanitized_newsletter_email = filter_var( $newsletter_email, FILTER_SANITIZE_EMAIL );
	if ( filter_var( $sanitized_newsletter_email, FILTER_VALIDATE_EMAIL ) ) {

		$email = sanitize_email( $sanitized_newsletter_email );

		//trigger exception in a "try" block
		try {
			$mailchimp = new Mailchimp( $apikey );

			$post_params = array(
				'email'  => $email,
				'status' => 'subscribed',
			);

			//trigger exception in a "try" block
			try {
				$result = $mailchimp->lists->subscribe( $listId, $post_params );
				if ( is_array( $result ) && ( isset( $result['email'] ) && '' != $result['email'] ) && ( isset( $result['euid'] ) && '' != $result['euid'] ) && ( isset( $result['leid'] ) && '' != $result['leid'] ) ) {
					$msg = esc_html__( 'Successfully Subscribed. Please check confirmation email.', 'pgs-core' );
				}
			} catch ( Exception $e ) {
				$msg = $e->getMessage();
			}
		} catch ( Exception $e ) {
			$msg = $e->getMessage();
		}
	} else {
		$msg             = esc_html__( 'Please enter a valid email.', 'pgs-core' );
		$newsletter_stat = false;
	}

	if ( strpos( $msg, 'You must provide a MailChimp API key' ) === 0 ) {
		if ( current_user_can( 'manage_options' ) ) {
			$msg = esc_html__( 'Please enter MailChimp API key.', 'pgs-core' );
		} else {
			$msg = $msg_raw;
		}
	} elseif ( strpos( $msg, 'Invalid MailChimp API key' ) === 0 ) {
		if ( current_user_can( 'manage_options' ) ) {
			$msg = esc_html__( 'Please enter valid MailChimp API key.', 'pgs-core' );
		} else {
			$msg = $msg_raw;
		}
	} elseif ( strpos( $msg, 'Invalid MailChimp List ID' ) === 0 ) {
		if ( current_user_can( 'manage_options' ) ) {
			$msg = esc_html__( 'Please enter valid MailChimp List ID.', 'pgs-core' );
		} else {
			$msg = $msg_raw;
		}
	} elseif ( strpos( $msg, 'The email parameter should include an email, euid, or leid key' ) === 0 ) {
		$msg = esc_html__( 'Please enter email.', 'pgs-core' );
	}

	echo esc_html( $msg );

	wp_die();
}
