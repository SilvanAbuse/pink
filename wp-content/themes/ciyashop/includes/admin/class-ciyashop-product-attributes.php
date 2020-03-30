<?php
/**
 * Product attribute
 *
 * @package CiyaShop
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ciyashop_Product_Attributes' ) ) {
	class Ciyashop_Product_Attributes {
		public static $_instance = null;

		public function __construct() {
			do_action( 'cardealer_theme_class_loaded' );
			$this->init();
		}

		public static function init() {
			add_action( 'init', array( __CLASS__, 'ciyashop_set_product_attributes' ) );

			/*
			----------- add attribute fields admin product attribute page --------------
			*/
			// add attribute page.
			add_action( 'woocommerce_after_add_attribute_fields', array( __CLASS__, 'ciyashop_add_custom_field_attributes' ) );
			// edit attribute page.
			add_action( 'woocommerce_after_edit_attribute_fields', array( __CLASS__, 'ciyashop_edit_custom_field_attributes' ) );

			/*
			----------- handle attribute post fields of product attribute page --------------
			*/
			// handle add attribute.
			add_action( 'woocommerce_attribute_added', array( __CLASS__, 'ciyashop_wc_attribute_added' ), 20, 2 );
			// handle edit attribute.
			add_action( 'woocommerce_attribute_updated', array( __CLASS__, 'ciyashop_wc_attribute_updated' ), 20, 3 );
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public static function ciyashop_add_custom_field_attributes() {
			// display fields on add attr page
			?>
			<div class="form-field">
				<label for="ciyashop_enable_swatch"><?php esc_html_e( 'Enable Swatch?', 'ciyashop' ); ?></label>
				<input name="ciyashop_enable_swatch" id="ciyashop_enable_swatch" type="checkbox" />
				<p class="description"><?php esc_html_e( 'Check this checkbox to enable attributes swatch.', 'ciyashop' ); ?></p>
			</div>
			<?php
		}

		public static function ciyashop_edit_custom_field_attributes() {
			global $wpdb;
			if ( ! isset( $_GET['edit'] ) ) {
				return;
			}
			$attribute_name = wc_attribute_taxonomy_name_by_id( (int) $_GET['edit'] );
			$swatch         = self::ciyashop_get_attribute_term( $attribute_name, 'swatch' );
			$checked        = ( 'on' == $swatch ) ? 'checked' : '';
			?>
			<tr class="form-field form-required">
				<th scope="row" valign="top">
					<label for="ciyashop_enable_swatch"><?php esc_html_e( 'Enable Swatch?', 'ciyashop' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="ciyashop_enable_swatch" id="ciyashop_enable_swatch" <?php echo esc_attr( $checked ); ?>>
					<p class="description"><?php esc_html_e( 'Check this checkbox to enable attributes swatch.', 'ciyashop' ); ?></p>
				</td>
			</tr>
			<?php
		}

		// handle post fields of update attribute page.
		public static function ciyashop_wc_attribute_updated( $attribute_id, $attribute, $old_attribute_name ) {
			if ( ! isset( $_GET['edit'] ) || absint( $_GET['edit'] != $attribute_id ) ) {
				return;
			}

			$ciyashop_swatch_attr = isset( $_POST['ciyashop_enable_swatch'] ) ? sanitize_text_field( $_POST['ciyashop_enable_swatch'] ) : '';
			if ( $ciyashop_swatch_attr ) {
				update_option( 'ciyashop_pa_' . $attribute['attribute_name'] . '_swatch', $ciyashop_swatch_attr );
			} else {
				delete_option( 'ciyashop_pa_' . $attribute['attribute_name'] . '_swatch', $ciyashop_swatch_attr );
			}
		}

		// handle post fields of add attribute page.
		public static function ciyashop_wc_attribute_added( $attribute_id, $attribute ) {
			if ( ! isset( $_POST['ciyashop_enable_swatch'] ) || empty( $_POST['ciyashop_enable_swatch'] ) ) {
				return;
			}

			$ciyashop_swatch_attr = sanitize_text_field( $_POST['ciyashop_enable_swatch'] );
			add_option( 'ciyashop_pa_' . $attribute['attribute_name'] . '_swatch', $ciyashop_swatch_attr );
		}

		// get attribute option.
		public static function ciyashop_get_attribute_term( $attribute_name, $term ) {
			return get_option( 'ciyashop_' . $attribute_name . '_' . $term );
		}

		public static function ciyashop_set_product_attributes() {
			if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
				return;
			}
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( function_exists( 'acf_add_local_field_group' ) ) {
				$fields = array(
					'key'                   => 'group_5ba0e6a268cca',
					'title'                 => esc_html__( 'Attributes Options', 'ciyashop' ),
					'fields'                => array(
						array(
							'key'               => 'field_5ba0ef16ff663',
							'label'             => esc_html__( 'Image preview', 'ciyashop' ),
							'name'              => 'image_preview',
							'type'              => 'image',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'return_format'     => 'array',
							'preview_size'      => 'thumbnail',
							'library'           => 'all',
							'min_width'         => '',
							'min_height'        => '',
							'min_size'          => '',
							'max_width'         => '',
							'max_height'        => '',
							'max_size'          => '',
							'mime_types'        => '',
						),
						array(
							'key'               => 'field_5ba0ef83ff664',
							'label'             => esc_html__( 'Color Preview', 'ciyashop' ),
							'name'              => 'color_preview',
							'type'              => 'color_picker',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
						),
					),
					'location'              => array(),
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => 1,
					'description'           => '',
				);

				foreach ( $attribute_taxonomies as $key => $value ) {
					$fields['location'][ $key ] = array(
						array(
							'param'    => 'taxonomy',
							'operator' => '==',
							'value'    => 'pa_' . $value->attribute_name,
						),
					);
				}
				acf_add_local_field_group( $fields );
			}
		}
	}
}
Ciyashop_Product_Attributes::instance();
