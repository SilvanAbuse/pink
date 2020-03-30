<?php
/**
 * Admin init
 *
 * @package CiyaShop
 */

require_once get_parent_theme_file_path( '/includes/admin/class-ciyashop-theme-activation.php' );
require_once get_parent_theme_file_path( '/includes/admin/class-ciyashop-product-attributes.php' ); // wc prodct attribute fields
require_once get_parent_theme_file_path( '/includes/admin/panel/panel.php' );

if ( ! class_exists( 'Mega_Menu' ) ) {
	require_once get_parent_theme_file_path( '/includes/admin/nav-menu-images/nav-menu-images.php' );
	add_action( 'admin_init', 'register_cs_mega_menu_metabox', 20 );
}

function register_cs_mega_menu_metabox() {

	$menu_id         = ciyashop_get_selected_menu_id();
	$theme_locations = get_nav_menu_locations();

	if ( ! isset( $theme_locations['primary'] ) && empty( $theme_locations['primary'] ) ) {
		return;
	}

	if ( $theme_locations['primary'] == $menu_id ) {
		add_meta_box( 'ciyashop_mega_menu_enable', 'CS Mega Menu', 'cs_mega_menu_metabox', 'nav-menus', 'side', 'high' );
	}
}

function cs_mega_menu_metabox() {

	$menu_id      = ciyashop_get_selected_menu_id();
	$cs_mega_menu = '';

	$cs_mega_menu_enable = get_post_meta( $menu_id, 'cs_megamenu_enable', true );

	if ( 'true' == $cs_mega_menu_enable ) {
		$cs_mega_menu = 'checked="checked"';
	}
	?>	
	<div class="inside">
		<div class="cs_megamenu_accordion" id="cs_megamenu_accordion">
			<p class="wp-clearfix">
				<label for="cs_megamenu_enable">
					<input type="checkbox" id="cs_megamenu_enable" class="menu-item-checkbox megamenu_enabled" name="cs_megamenu_enable" value="" <?php echo esc_attr( $cs_mega_menu ); ?> > <?php esc_html_e( 'Enable Mega Menu', 'ciyashop' ); ?>
				</label>			
				<span class="spinner"></span>
			</p>
		</div>
	</div>
	<?php
}

add_action( 'wp_ajax_cs_megamenu_enable', 'cs_megamenu_enable' );
add_action( 'wp_ajax_nopriv_cs_megamenu_enable', 'cs_megamenu_enable' );

function cs_megamenu_enable() {

	$menu_id   = $_POST['menu_id'];
	$mm_enable = $_POST['mm_enable'];

	update_post_meta( $menu_id, 'cs_megamenu_enable', $mm_enable );
	$return_data = array(
		'menu_id'  => $menu_id,
		'redirect' => true,
	);

	echo wp_json_encode( $return_data );
	die();
}

add_filter( 'get_user_option_metaboxhidden_nav-menus', 'ciyashop_cpt_always_visible', 10, 3 );
function ciyashop_cpt_always_visible( $result = array(), $option, $user ) {

	if ( in_array( 'ciyashop_mega_menu_enable', $result ) ) {
		$result = array_diff( $result, array( 'ciyashop_mega_menu_enable' ) );
	}

	return $result;
}
