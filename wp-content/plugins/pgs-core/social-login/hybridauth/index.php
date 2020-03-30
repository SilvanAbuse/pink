<?php
// ------------------------------------------------------------------------
//	Handle LEGACY End Points (of v2)
// ------------------------------------------------------------------------
//  Note: The way we handle errors is a bit messy and should be reworked
// ------------------------------------------------------------------------

session_start()
    or die("Couldn't start new php session.");

if( ! file_exists( __DIR__ . '/library/src/autoload.php' ) ){
    die("Couldn't find required files.");
}

require_once __DIR__ . '/library/src/autoload.php';

if (count($_GET)) {
	$url = Hybridauth\HttpClient\Util::getCurrentUrl(false);

	$url = str_ireplace( '/hybridauth/index.php', '/hybridauth/callbacks/', $url );

	$url .= strtolower( $_GET['hauth_done'] ) .  '.php?';

	unset( $_GET['hauth_done'] );

	foreach ($_GET as $key => $value) {
		$url .= $key . '=' . urlencode( $value ) . '&';
	}

	Hybridauth\HttpClient\Util::redirect($url);
}

header("HTTP/1.0 403 Forbidden");
die;
