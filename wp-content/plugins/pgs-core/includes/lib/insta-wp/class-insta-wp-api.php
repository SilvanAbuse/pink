<?php
class Insta_WP_API {

    protected $access_token;

    protected $auth_data;

    protected $auth_successful;

    protected $api_url     = 'https://api.instagram.com/';
    protected $api_version = 'v1';

    public function __construct() {
        $this->auth_successful = false;
    }

    public static function withAccessToken($access_token) {
        $instance = new self();
        $instance->access_token = $access_token;
        $instance->auth_successful = true;
        return $instance;
    }

    public static function withClientData($client_id, $client_secret, $code, $redirect_uri) {
        $instance = new self();
        $instance->requestAccessToken($client_id, $client_secret, $code, $redirect_uri);
        return $instance;
    }

    public function requestAccessToken($client_id, $client_secret, $code, $redirect_uri)
    {
        $params = array(
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
			'grant_type'    => 'authorization_code',
			'redirect_uri'  => $redirect_uri,
			'code'          => $code,
        );

        $url  = trailingslashit( $this->api_url ) . 'oauth/access_token';
        $data = $this->fetchData($url, $params);

        if ($data) {
            $data = json_decode($data);
            $this->auth_data = $data;

            if (isset($data->access_token)) {
                $this->access_token = $data->access_token;
                $this->auth_successful = true;
            }
        }
    }

    public function accessToken() {
        return $this->access_token;
    }

    public function authData() {
        return $this->auth_data;
    }

    public function authWasSuccessful() {
        return $this->auth_successful;
    }

    public function errorMessage() {
        if  (!$this->authWasSuccessful()) {
            if (isset($this->auth_data) && isset($this->auth_data->error_message)) {
                return $this->auth_data->error_message;
            }
        }

        return null;
    }

    public function getUserId($username)
    {
        $username = strtolower($username);

        $url = $this->endpointUrl('users/search', array(), array('q' => $username));
        $get = file_get_contents($url);
        $json = json_decode($get);

        foreach($json->data as $user)
        {
            if($user->username == $username)
            {
                return intval($user->id);
            }
        }

        return 0;
    }

    public function fetchData($url, $post_params = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $components = parse_url($url);
        if ($components['scheme'] == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $post_params = (array)$post_params;
        $post_params = array_filter($post_params);
        if (count($post_params)) {
            curl_setopt($ch, CURLOPT_POST, count($post_params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function authUrl( $client_id, $client_secret, $redirect_uri ) {
		return add_query_arg( array(
			'client_id'     => $client_id,
			// 'client_secret'     => urlencode( $client_secret ),
			'redirect_uri'  => esc_url( $redirect_uri ),
			'response_type' => 'code',
			'scope'         => 'basic',
			'state'         => '',
		), 'https://api.instagram.com/oauth/authorize' );
    }

    public function recentPhotosForUser($user_id, $params = null) {
        $url = $this->endpointUrl('users/%d/media/recent', array($user_id), $params);
        return json_decode($this->fetchData($url));
    }

    public function recentPhotosForLocation($location_id, $params = null) {
        $url = $this->endpointUrl('locations/%d/media/recent', array($location_id), $params);
        return json_decode($this->fetchData($url));
    }

    public function recentPhotosForTag($tag, $params = null) {
        $url = $this->endpointUrl('tags/%s/media/recent', array($tag), $params);
        return json_decode($this->fetchData($url));
    }

    public function searchUsersByName($username, $params = null) {
        $params = wp_parse_args( $params, array(
            'q' => $username,
            // 'count' => 10,
        ) );

        $url = $this->endpointUrl('users/search', null, $params);
        return json_decode($this->fetchData($url));
    }

    public function userIdForName($username, $params = null) {
        $params = wp_parse_args( $params, array(
            'count' => 1,
        ) );

        $result = $this->searchUsersByName($username, null, $params);

        if (property_exists($result, 'data')) {
            $data = $result->data;

            if (count($data)) {
                $best_hit = array_shift($data);

                return $best_hit->id;
            }
        }

        return null;
    }

    public function endpointUrl($path, $args = null, $params = null) {

        $url = null;

        if ($path) {
            $url_base = $this->urlBase();
            $query_string = $this->urlQueryString((array)$params);

            $url = $url_base . vsprintf($path, (array)$args) . $query_string;
        }

        return $url;
    }

    public static function urlBase()
    {
        return self::URL_BASE . $this->api_version . '/';
    }

    public function urlQueryString($args = null) {

        $query_args = wp_parse_args($args, array(
            'access_token' => $this->access_token,
        ));

        return sprintf("?%s", http_build_query($query_args));
    }
}
