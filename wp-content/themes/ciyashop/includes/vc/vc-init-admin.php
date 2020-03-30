<?php
if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
	include( get_parent_theme_file_path( 'includes/vc/theme-vc-templates.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/theme-vc-templates-panel-editor.php' ) );
	add_action( 'admin_print_scripts-post.php', 'ciyashop_vc_templates_enqueue_scripts' );
	add_action( 'admin_print_scripts-post-new.php', 'ciyashop_vc_templates_enqueue_scripts' );
}

function ciyashop_vc_templates_enqueue_scripts() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	$post_type = get_post_type();

	wp_register_script( 'jquery-lazy', get_parent_theme_file_uri( '/js/jquery.lazy/jquery.lazy.min.js' ), array(), '1.7.9', true );

	// VC Templates Backend
	if ( ! vc_is_frontend_editor() && vc_check_post_type( $post_type ) ) {

		wp_register_script( 'ciyashop_vc_templates_js', get_parent_theme_file_uri( '/js/vc-templates' . $suffix . '.js' ), array( 'ciyashop_admin_js', 'jquery-lazy' ), WPB_VC_VERSION, true );
		wp_enqueue_script( 'ciyashop_vc_templates_js' );
	}

	// VC Templates Frontend
	if ( vc_is_frontend_editor() ) {
		wp_register_script( 'ciyashop_vc_templates_js', get_parent_theme_file_uri( '/js/vc-templates' . $suffix . '.js' ), array( 'vc-frontend-editor-min-js', 'jquery-lazy' ), WPB_VC_VERSION, true );
		wp_enqueue_script( 'ciyashop_vc_templates_js' );
	}
}

add_action( 'init', 'ciyashop_extend_vc_shortcodes' );
function ciyashop_extend_vc_shortcodes() {
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/vc_row.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/vc_row_inner.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/vc_column.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/vc_column_inner.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-icon.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-message.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-tta-accordion.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-tta-section.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-tta-tabs.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/shortcode-vc-tta-tour.php' ) );
	include( get_parent_theme_file_path( 'includes/vc/shortcodes/vc_custom_heading.php' ) );
}

add_filter( 'vc_base_build_shortcodes_custom_css', 'ciyashop_parse_vc_shortcodes_custom_css', 12, 3 );
function ciyashop_parse_vc_shortcodes_custom_css( $content, $post_id, $recur = false ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! $recur ) {
		$post = get_post( $post_id );
		if ( $post ) {
			$content = $post->post_content;
		}
	}

	$css = '';
	if ( ! preg_match( '/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $content ) ) {
		return $css;
	}
	WPBMap::addAllMappedShortcodes();
	preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

	foreach ( $shortcodes[2] as $index => $tag ) {

		$shortcode  = WPBMap::getShortCode( $tag );
		$attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );

		if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
			foreach ( $shortcode['params'] as $param ) {
				if ( isset( $param['type'] ) && 'css_editor' === $param['type'] && isset( $attr_array[ $param['param_name'] ] ) ) {
					if ( 'element_css_md' == $param['param_name'] || 'element_css_sm' == $param['param_name'] || 'element_css_xs' == $param['param_name'] ) {
						continue;
					}
					$css .= $attr_array[ $param['param_name'] ];
				}
			}
		}
		if ( 'vc_row' == $tag && ( isset( $attr_array['pgscore_enable_responsive_settings'] ) && 'true' == $attr_array['pgscore_enable_responsive_settings'] ) ) {
			if ( isset( $attr_array['element_css_md'] ) && ! empty( $attr_array['element_css_md'] ) ) {
				$css .= '@media (max-width: 1200px) {' . $attr_array['element_css_md'] . '}';
			}
			if ( isset( $attr_array['element_css_sm'] ) && ! empty( $attr_array['element_css_sm'] ) ) {
				$css .= '@media (max-width: 992px) {' . $attr_array['element_css_sm'] . '}';
			}
			if ( isset( $attr_array['element_css_xs'] ) && ! empty( $attr_array['element_css_xs'] ) ) {
				$css .= '@media (max-width: 767px) {' . $attr_array['element_css_xs'] . '}';
			}
		}
		if ( 'vc_row_inner' == $tag && ( isset( $attr_array['pgscore_enable_responsive_settings'] ) && 'true' == $attr_array['pgscore_enable_responsive_settings'] ) ) {
			if ( isset( $attr_array['element_css_md'] ) && ! empty( $attr_array['element_css_md'] ) ) {
				$css .= '@media (max-width: 1200px) {' . $attr_array['element_css_md'] . '}';
			}
			if ( isset( $attr_array['element_css_sm'] ) && ! empty( $attr_array['element_css_sm'] ) ) {
				$css .= '@media (max-width: 992px) {' . $attr_array['element_css_sm'] . '}';
			}
			if ( isset( $attr_array['element_css_xs'] ) && ! empty( $attr_array['element_css_xs'] ) ) {
				$css .= '@media (max-width: 767px) {' . $attr_array['element_css_xs'] . '}';
			}
		}
		if ( 'vc_column' == $tag && ( isset( $attr_array['pgscore_enable_responsive_settings'] ) && 'true' == $attr_array['pgscore_enable_responsive_settings'] ) ) {
			if ( isset( $attr_array['element_css_md'] ) && ! empty( $attr_array['element_css_md'] ) ) {
				$css .= '@media (max-width: 1200px) {' . $attr_array['element_css_md'] . '}';
			}
			if ( isset( $attr_array['element_css_sm'] ) && ! empty( $attr_array['element_css_sm'] ) ) {
				$css .= '@media (max-width: 992px) {' . $attr_array['element_css_sm'] . '}';
			}
			if ( isset( $attr_array['element_css_xs'] ) && ! empty( $attr_array['element_css_xs'] ) ) {
				$css .= '@media (max-width: 767px) {' . $attr_array['element_css_xs'] . '}';
			}
		}
		if ( 'vc_column_inner' == $tag && ( isset( $attr_array['pgscore_enable_responsive_settings'] ) && 'true' == $attr_array['pgscore_enable_responsive_settings'] ) ) {
			if ( isset( $attr_array['element_css_md'] ) && ! empty( $attr_array['element_css_md'] ) ) {
				$css .= '@media (max-width: 1200px) {' . $attr_array['element_css_md'] . '}';
			}
			if ( isset( $attr_array['element_css_sm'] ) && ! empty( $attr_array['element_css_sm'] ) ) {
				$css .= '@media (max-width: 992px) {' . $attr_array['element_css_sm'] . '}';
			}
			if ( isset( $attr_array['element_css_xs'] ) && ! empty( $attr_array['element_css_xs'] ) ) {
				$css .= '@media (max-width: 767px) {' . $attr_array['element_css_xs'] . '}';
			}
		}
	}

	foreach ( $shortcodes[5] as $shortcode_content ) {
		$css .= ciyashop_parse_vc_shortcodes_custom_css( $shortcode_content, $post_id, $recur = true );
	}

	return $css;
}
