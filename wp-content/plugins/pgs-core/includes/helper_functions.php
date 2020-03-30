<?php
// Filter out hard-coded width, height attributes on all captions (wp-caption class)
add_shortcode( 'wp_caption', 'pgscore_fixed_img_caption_shortcode' );
add_shortcode( 'caption', 'pgscore_fixed_img_caption_shortcode' );
function pgscore_fixed_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content         = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' != $output ) {
		return $output;
	}
	extract(
		shortcode_atts(
			array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => '',
			),
			$attr
		)
	);
	if ( 1 > (int) $width || empty( $caption ) ) {
		return $content;
	}
	if ( $id ) {
		$id = 'id="' . esc_attr( $id ) . '" ';
	}
	return '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" >'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

/**
 * Filter out hard-coded width, height attributes on all captions (wp-caption class)
 *
 * @since PGS Core 1.0
 */
function pgscore_fix_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content         = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' != $output ) {
		return $output;
	}
	extract(
		shortcode_atts(
			array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => '',
			),
			$attr
		)
	);
	if ( 1 > (int) $width || empty( $caption ) ) {
		return $content;
	}
	if ( $id ) {
		$id = 'id="' . esc_attr( $id ) . '" ';
	}
	return '<figure ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" >' . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_shortcode( 'wp_caption', 'pgscore_fix_img_caption_shortcode' );
add_shortcode( 'caption', 'pgscore_fix_img_caption_shortcode' );

function pgscore_get_excerpt_max_charlength( $charlength, $excerpt = null ) {
	if ( empty( $excerpt ) ) {
		$excerpt = get_the_excerpt();
	}
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

		$new_excerpt = '';
		if ( $excut < 0 ) {
			$new_excerpt = mb_substr( $subex, 0, $excut );
		} else {
			$new_excerpt = $subex;
		}
		$new_excerpt .= '[...]';
		return $new_excerpt;
	} else {
		return $excerpt;
	}
}
function pgscore_the_excerpt_max_charlength( $charlength, $excerpt = null ) {
	$new_excerpt = pgscore_get_excerpt_max_charlength( $charlength, $excerpt );
	echo $new_excerpt;
}

/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function pgscore_shortenString( $string = '', $maxLength, $addEllipsis = true, $wordsafe = false ) {
	if ( empty( $string ) ) {
		$string;
	}
	$ellipsis  = '';
	$maxLength = max( $maxLength, 0 );
	if ( mb_strlen( $string ) <= $maxLength ) {
		return $string;
	}
	if ( $addEllipsis ) {
		$ellipsis   = mb_substr( '...', 0, $maxLength );
		$maxLength -= mb_strlen( $ellipsis );
		$maxLength  = max( $maxLength, 0 );
	}
	if ( $wordsafe ) {
		$string = preg_replace( '/\s+?(\S+)?$/', '', mb_substr( $string, 0, $maxLength ) );
	} else {
		$string = mb_substr( $string, 0, $maxLength );
	}
	if ( $addEllipsis ) {
		$string .= $ellipsis;
	}

	return $string;
}

function pgscore_array_sort_by_column( &$array, $column, $direction = SORT_ASC ) {
	$reference_array = array();
	foreach ( $array as $key => $row ) {
		if ( isset( $row[ $column ] ) ) {
			$reference_array[ $key ] = $row[ $column ];
		}
	}
	if ( sizeof( $reference_array ) == sizeof( $array ) ) {
		array_multisort( $reference_array, $array, $direction );
	}
}

/**
 * Get shortcode template parts.
 */
function pgscore_get_shortcode_templates( $slug, $name = '' ) {
	$template = '';

	$template_path = 'template-parts/shortcodes/';
	$plugin_path   = trailingslashit( PGSCORE_PATH );

	// Look in yourtheme/template-parts/shortcodes/slug-name.php
	if ( $name ) {
		$template = locate_template(
			array(
				$template_path . "{$slug}-{$name}.php",
			)
		);
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $plugin_path . "templates/{$slug}-{$name}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/template-parts/shortcodes/slug.php
	if ( ! $template ) {
		$template = locate_template(
			array(
				$template_path . "{$slug}.php",
			)
		);
	}

	// Get default slug.php
	if ( ! $template && file_exists( $plugin_path . "templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'pgscore_get_shortcode_templates', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

function pgscore_class_builder( $class = '' ) {
	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}
	$classes = array_map( 'esc_attr', $classes );

	return implode( ' ', array_filter( array_unique( $classes ) ) );
}

function pgscore_shortcode_id( $atts ) {
	extract( $atts );

	if ( ! empty( $element_id ) ) {
		$element_id = ( preg_match( '/^\d/', $element_id ) === 1 ) ? $shortcode_handle . '_' . $element_id : $element_id;
	}

	// bail, if no valid id found.
	if ( ! isset( $element_id ) || '' == $element_id ) {
		return;
	}

	echo 'id="' . esc_attr( $element_id ) . '"';
}

function pgscore_check_plugin_active( $plugin = '' ) {

	if ( empty( $plugin ) ) {
		return false;
	}

	global $pgscore_globals;
	$active_plugins = $pgscore_globals['active_plugins'];

	return (
		in_array( $plugin, $active_plugins )
		|| ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( $plugin ) )
	);
}

function pgscore_is_plugin_installed( $search ) {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins      = get_plugins();
	$plugins      = array_filter(
		array_keys( $plugins ),
		function( $k ) {
			if ( strpos( $k, '/' ) !== false ) {
				return true;
			}
		}
	);
	$plugins_stat = function( $plugins, $search ) {
		$new_plugins = array();
		foreach ( $plugins as $plugin ) {
			$new_plugins_data = explode( '/', $plugin );
			$new_plugins[]    = $new_plugins_data[0];
		}
		return in_array( $search, $new_plugins );
	};
	return $plugins_stat( $plugins, $search );
}

function pgscore_allowed_html( $allowed_els = '' ) {

	// bail early if parameter is empty
	if ( empty( $allowed_els ) ) {
		return array();
	}

	if ( is_string( $allowed_els ) ) {
		$allowed_els = explode( ',', $allowed_els );
	}

	$allowed_html = array();

	$allowed_tags = wp_kses_allowed_html( 'post' );

	foreach ( $allowed_els as $el ) {
		$el = trim( $el );
		if ( array_key_exists( $el, $allowed_tags ) ) {
			$allowed_html[ $el ] = $allowed_tags[ $el ];
		}
	}

	return $allowed_html;
}

function pgscore_product_types( $args = array() ) {
	$product_types = array(
		'new_arrivals' => esc_html__( 'Newest', 'pgs-core' ),
		'featured'     => esc_html__( 'Featured', 'pgs-core' ),
		'best_sellers' => esc_html__( 'Best Sellers', 'pgs-core' ),
		'on_sale'      => esc_html__( 'On sale', 'pgs-core' ),
		'cheapest'     => esc_html__( 'Cheapest', 'pgs-core' ),
	);

	// Deprecated.
	$product_types = apply_filters_deprecated( 'ciyashop_product_types', array( $product_types ), '4.0', 'pgscore_product_types' ); // TODO: CiyaShop Upcoming Release
	$product_types = apply_filters( 'pgscore_product_types', $product_types );

	if ( isset( $args['array_flip'] ) && $args['array_flip'] ) {
		$product_types = array_flip( $product_types );
	}

	return $product_types;
}


function pgscore_get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	// Add full for fallback.
	$sizes['full'] = array();

	return $sizes;
}

function pgscore_validate_css_unit( $str = '', $units = array() ) {

	// bail early if any param is empty
	if ( ! is_string( $str ) || '' == $str || ! is_array( $units ) || empty( $units ) ) {
		return false;
	}

	// prepare units string
	$units_str = implode( '|', $units );

	// prepare regex
	$reg_ex = '/^(auto|0)$|^[+-]?[0-9]+.?([0-9]+)?(' . $units_str . ')$/';

	// check match
	preg_match_all( $reg_ex, $str, $matches, PREG_SET_ORDER, 0 );

	// check if matched found.
	if ( count( $matches ) > 0 ) {
		return true;
	}

	return false;
}

//function to convert google font field values in valid formate and enqueue style
function pgscore_get_google_fonts_css( $google_fonts, $enqueue_google_font = true ) {

	//default value for font fields value
	$fields     = array();
	$text_style = array();

	$google_fonts_data = ciyashop_parse_multi_attribute(
		$google_fonts,
		array(
			'font_style'  => isset( $fields['font_style'] ) ? $fields['font_style'] : '',
			'font_family' => isset( $fields['font_family'] ) ? $fields['font_family'] : '',
		)
	);

	//convert values in to the valid array
	if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data, $google_fonts_data['font_family'], $google_fonts_data['font_style'] ) ) {
		$google_fonts_family       = explode( ':', $google_fonts_data['font_family'] );
		$text_style['font-family'] = 'font-family:' . $google_fonts_family[0] . ';';
		$google_fonts_styles       = explode( ':', $google_fonts_data['font_style'] );
		if ( isset( $google_fonts_styles[1] ) ) {
			$text_style['font-weight'] = 'font-weight:' . $google_fonts_styles[1] . ';';
		}
		if ( isset( $google_fonts_styles[2] ) ) {
			$text_style['font-style'] = 'font-style:' . $google_fonts_styles[2] . ';';
		}
	}

	if ( isset( $google_fonts_data['font_family'] ) ) {
		$google_font_style = 'vc_google_fonts_' . ciyashop_build_safe_css_class( $google_fonts_data['font_family'] );
	}

	//check if already enqueued style
	if ( isset( $google_font_style ) && ! wp_style_is( $google_font_style ) && $enqueue_google_font ) {
		wp_enqueue_style( $google_font_style, '//fonts.googleapis.com/css?family=' . $google_fonts_data['font_family'] );
	}

	return $text_style;
}



/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function pgscore_shorten_string( $string = '', $maxLength, $addEllipsis = true, $wordsafe = false ) {
	if ( empty( $string ) ) {
		$string;
	}
	$ellipsis  = '';
	$maxLength = max( $maxLength, 0 );
	if ( mb_strlen( $string ) <= $maxLength ) {
		return $string;
	}
	if ( $addEllipsis ) {
		$ellipsis   = mb_substr( '...', 0, $maxLength );
		$maxLength -= mb_strlen( $ellipsis );
		$maxLength  = max( $maxLength, 0 );
	}
	if ( $wordsafe ) {
		$string = preg_replace( '/\s+?(\S+)?$/', '', mb_substr( $string, 0, $maxLength ) );
	} else {
		$string = mb_substr( $string, 0, $maxLength );
	}
	if ( $addEllipsis ) {
		$string .= $ellipsis;
	}

	return $string;
}


function pgscore_dynamic_image( $thumb_size = '', $thumb_size_w = '', $thumb_size_h = '', $color = '' ) {

	// bail early if any data missing.
	if ( '' == $thumb_size || '' == $thumb_size_w || '' == $thumb_size_h ) {
		return false;
	}

	if ( is_array( $thumb_size ) ) {
		$thumb_size = implode( '-', $thumb_size );
	}

	$img_key = trim( strtolower( "{$thumb_size}-{$thumb_size_w}-{$thumb_size_h}-{$color}" ) );
	$img_key = 'ciyashop-dynamic-img-' . sanitize_title_with_dashes( $img_key );

	if ( WP_DEBUG || false === ( $image = get_transient( $img_key ) ) ) {

		// Create an image
		$im = imagecreate( $thumb_size_w, $thumb_size_h );

		// White background and blue text
		$default_color = array(
			'r' => 254,
			'g' => 254,
			'b' => 254,
		);

		if ( '' != $color && is_string( $color ) ) {
			$color_hex2rgb = ciyashop_hex2rgb( $color );
			if ( $color_hex2rgb ) {
				$color = $color_hex2rgb;
			}
		} else {
			$color = $default_color;
		}

		$bg = imagecolorallocate( $im, $color['r'], $color['g'], $color['b'] );

		ob_start();
		imagepng( $im );
		$image = ob_get_clean();

		imagedestroy( $im );

		// Include IXR_Base64 class
		if ( ! class_exists( 'IXR_Base64' ) ) {
			require_once( ABSPATH . WPINC . '/IXR/class-IXR-base64.php' );
		}

		// prepare base64
		$image_base64 = new IXR_Base64( $image );
		$image_xml    = $image_base64->getXml();
		$image        = str_replace( array( '<base64>', '</base64>' ), array( '', '' ), $image_xml );
		$image        = 'data:image/png;base64,' . $image;

		set_transient( $img_key, $image, apply_filters( 'ciyashop_dynamic_image_cache_time', HOUR_IN_SECONDS * 24 ) );
	}

	// return image
	return $image;
}

//function to get the list of id and title of Static Blocks
if ( ! function_exists( 'pgscore_get_static_blocks' ) ) {
	function pgscore_get_static_blocks() {

		$static_blocks = array();

		$args = array(
			'post_type'      => 'static_block',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);

		$static_block = new WP_Query( $args );

		$static_posts = get_posts( $args );

		foreach ( $static_posts as $post ) {
			// setup_postdata( $post );
			$static_blocks[$post->ID] = esc_html( $post->post_title );
		}

		wp_reset_postdata();

		return $static_blocks;
	}
}

if ( ! function_exists( 'ciyashop_get_custom_headers' ) ) {
	function ciyashop_get_custom_headers() {
		global $wpdb;

		$custom_headers = array();
		$table_name     = $wpdb->prefix . 'cs_header_builder';

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {

			$header_layout_data = $wpdb->get_results( "SELECT * FROM $table_name" );
			foreach ( $header_layout_data as $header_layout ) {
				$custom_headers[ $header_layout->id ] = $header_layout->name;
			}
			wp_reset_query();
		}
		return $custom_headers;
	}
}


add_action( 'admin_init', 'pgscore_updater_init' );

function pgscore_updater_init() {
	if ( isset( $_GET['do_update_pgs_updater'] ) && 'posttype_updater' == $_GET['do_update_pgs_updater'] ) {

		$pgs_posttype_updater = get_option( 'pgs_posttype_updated', false );

		if ( ! $pgs_posttype_updater ) {
			pgs_post_type_update();
		}

		$send = admin_url( 'admin.php?page=ciyashop-panel' );
		wp_redirect( $send );
		exit();
	}
}

function pgs_post_type_update() {
	global $wpdb;
	$table = $wpdb->prefix . 'posts';
	$data  = array( 'post_type' => 'static_block' );
	$where = array( 'post_type' => 'cms_block' );

	$update = $wpdb->update( $table, $data, $where );

	if ( false === $update ) {
		wp_die( __( 'Error in run the updater.', 'pgs-core' ) );
	} else {
		update_option( 'pgs_posttype_updated', true );
	}
}

if ( ! function_exists( 'pgscore_get_instagram_image' ) ) {
	/**
	 * Get instagram image.
	 */
	function pgscore_get_instagram_image( $item_count ) {

		global $ciyashop_options;

		$instagram_client_id = ( isset( $ciyashop_options['instagram_client_id'] ) && ! empty( $ciyashop_options['instagram_client_id'] ) ) ? $ciyashop_options['instagram_client_id'] : '';
		$access_token = ( isset( $ciyashop_options['instagram_access_token'] ) && ! empty( $ciyashop_options['instagram_access_token'] ) ) ? $ciyashop_options['instagram_access_token'] : '';

		if ( empty( $access_token ) || empty( $instagram_client_id ) ) {
			return;
		}

		$api_url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=$access_token&count=$item_count";

		$images_data             = array();
		$instagram_transient_key = 'ciyashop-instagram-' . $access_token . $item_count;

		if ( WP_DEBUG || false === ( $images_data = get_transient( $instagram_transient_key ) ) ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
			$response = wp_remote_get( $api_url, array( 'timeout' => 120 ) );

			if ( is_wp_error( $response ) ) {
				return;
			}

			$response_raw  = $response['body'];
			$response_data = json_decode( $response_raw );

			// Return if error found
			if ( ! empty( $response_data->meta->error_message ) ) {
				return;
			}

			if ( ! isset( $response_data->data ) ) {
				return;
			}

			$images_data = $response_data->data;

			if ( ! empty( $images_data ) ) {
				/**
				 * Filters arguments for instagram cache time.
				 *
				 * @param int    $cache_time      Cache time in seconds.
				 *
				 * @visible true
				 */
				set_transient( $instagram_transient_key, $images_data, apply_filters( 'ciyashop_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		// Return if no images found
		if ( count( array( $images_data ) ) === 0 ) {
			return;
		}

		return $images_data;
	}
}
