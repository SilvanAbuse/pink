<?php
add_action( 'init', 'pgscore_acf_fields_loader_new' );
function pgscore_acf_fields_loader_new(){
	
	// return if "acf_add_local_field_group" function does not exists.
	if( !function_exists('acf_add_local_field_group') ) return;
	
	// Page
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/page-settings.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/page-sidebar.php');
	
	// Posts
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/post-format-audio.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/post-format-gallery.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/post-format-quote.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/post-format-video.php');
	
	// CPTs
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/portfolio-details.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/team-details.php');
	include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/testimonials.php');
	
	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/wc-custom-tab.php');
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/wc-product-video.php');
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/wc-size-guide-image.php');
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/product-category-icon.php');
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/product-category-banner.php');
		include_once(trailingslashit(PGSCORE_PATH).'includes/acf/fields/product-tag-banner.php');
	}
}

if( !defined( 'ACF_DEV' ) || (defined( 'ACF_DEV' ) && !ACF_DEV) ) {
	
	// 4. Hide ACF field group menu item
	// add_filter( 'acf/settings/show_admin', '__return_false' );
}

/*********************************************************************************
 * 
 * Add custom class based on field name
 * 
*********************************************************************************/
add_filter( 'acf/prepare_field', 'pgscore_acf_add_field_name_class' );
function pgscore_acf_add_field_name_class( $field ) {
	
	// Return field without save image data in database
	$field_post = get_post($field['ID']);
	if( isset($field_post->post_type) &&  $field_post->post_type == 'acf-field' ){
		return $field;
	}

	$name = $field['_name'];
	$acf_class = 'acf_field_name-'.$name;
	
	if( empty($field['wrapper']['class']) ){
		$field['wrapper']['class'] = $acf_class;
	}else{
		$classes = explode( ' ', $field['wrapper']['class']);
		$classes = array_filter( array_unique( $classes ) );
		if( !in_array($acf_class, $classes) ){
			$classes[] = $acf_class;
		}
		$classes = implode( ' ', $classes );
		
		$field['wrapper']['class'] = $classes;
	}
	return $field;
}

/*********************************************************************************
 * 
 * Set images for radio-buttons
 * 
 *********************************************************************************/
add_filter('acf/prepare_field/type=radio', 'pgscore_acf_radio_image');
function pgscore_acf_radio_image( $field ) {
	
	// Return field without save image data in database
	$field_post = get_post($field['ID']);
	if( isset($field_post->post_type) &&  $field_post->post_type == 'acf-field' ){
		return $field;
	}
	
	// Populate field with class
	$class = $field['wrapper']['class'];
	$classes = explode( ' ', $class);
	
	if( !in_array( 'acf-image-radio', $classes) ){
		return $field;
	}
	
	$name = $field['_name'];
	
	if( $name == 'faq_layout' ){
		$field['choices'] = array(
			'multi_category' => '<img src="'.esc_url( trailingslashit(PGSCORE_URL).'images/acf/faq_layout/multi_category.png').'" alt="'.esc_attr__('Multi Category', 'pgs-core').'" /><span class="radio_btn_title">'.esc_attr__('Multi Category', 'pgs-core').'</span>',
			'single_category'=> '<img src="'.esc_url( trailingslashit(PGSCORE_URL).'images/acf/faq_layout/single_category.png').'" alt="'.esc_attr__('Single Category', 'pgs-core').'" /><span class="radio_btn_title">'.esc_attr__('Single Category', 'pgs-core').'</span>',
		);
		$field['value'] = 'multi_category';
	}
	
    return $field;
}

/*********************************************************************************
 * 
 * Set Font Awesome Icons
 * 
 *********************************************************************************/
add_filter('acf/prepare_field/type=select', 'pgscore_acf_font_awesome');
function pgscore_acf_font_awesome( $field ) {
	
	// Return field without save image data in database
	$field_post = get_post($field['ID']);
	if( isset($field_post->post_type) &&  $field_post->post_type == 'acf-field' ){
		return $field;
	}
	
	$name = $field['_name'];
	
	// Populate field with class
	$class = $field['wrapper']['class'];
	$classes = explode( ' ', $class);
	
	if( !in_array( 'acf_pgs_fontawesome', $classes) ){
		return $field;
	}
	
	$fa_icons = pgscore_fontawesome_array();
	
	$field['choices'] = array();
	foreach( $fa_icons as $fa_icon_k => $fa_icon_v ) {
		// $opt_title = ucwords( str_replace( "-", " ", str_replace( "fa-", "", $fa_icon_k ) ) );
		
		$field['choices'][$fa_icon_k] = $fa_icon_v;
	}
	
	$field['allow_null'] = 0;
	$field['multiple'] = 0;
	$field['ui'] = 1;
	$field['ajax'] = 0;
	$field['return_format'] = 'array';
	
    return $field;
}




// Hide upgrade notice for bundled plugin
function pgscore_remove_acfpro_update_($value) {
	global $pagenow;	
	if( isset($value->response) && $pagenow!='themes.php'){
		unset( $value->response[ 'advanced-custom-fields-pro/acf.php' ] );
	}
	return $value;
}
add_filter('site_transient_update_plugins', 'pgscore_remove_acfpro_update_');

/* Set the theme acf plugin path in update package */
add_filter('acf/updates/plugin_update', 'pgscore_update_acfpro_plugin', 11,2);
function pgscore_update_acfpro_plugin( $update, $transient){
	if( function_exists('acf_pro_is_license_active') && !acf_pro_is_license_active() && is_object($update) ) {
		$update->package = get_template_directory_uri() . '/includes/plugins/advanced-custom-fields-pro.zip';
	}
	
	
	return $update;
}