<?php
if( session_id() ) {
    pgssl_init_php_session_storage();
}

function pgssl_init_php_session_storage() {
    global $pgssl_version;

    $_SESSION["pgssl::plugin"] = "PGS Social Login " . $pgssl_version;

    if( defined( 'ABSPATH' ) )
    {
        $_SESSION['pgssl:consts:ABSPATH'] = ABSPATH;
    }
}

function pgssl_set_provider_config_in_session_storage($provider, $config) {
	$provider = strtolower($provider);

	$_SESSION['pgssl:' . $provider . ':config'] = (array) $config;
}

function pgssl_get_provider_config_from_session_storage($provider) {
	$provider = strtolower($provider);

    if(isset($_SESSION['pgssl:' . $provider . ':config']))
    {
        return (array) $_SESSION['pgssl:' . $provider . ':config'];
    }
}
