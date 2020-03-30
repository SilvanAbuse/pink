<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 *
 * @todo add $icon_... defaults
 * @todo add $icon_typicons and etc
 *
 * @var $atts
 * @var $el_class
 * @var $message_box_style
 * @var $style
 * @var $color
 * @var $message_box_color
 * @var $css_animation
 * @var $icon_type
 * @var $icon_fontawesome
 * @var $content - shortcode content
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Message
 */
$el_class                     = '';
$message_box_color            = '';
$message_box_style            = '';
$style                        = '';
$css                          = '';
$color                        = '';
$css_animation                = '';
$icon_type                    = '';
$icon_fontawesome             = '';
$icon_linecons                = '';
$icon_openiconic              = '';
$icon_typicons                = '';
$icon_entypo                  = '';
$pgscore_vc_message_hide_icon = '';
$pgscore_vc_message_closeable = '';
$defaultIconClass             = 'fa fa-adjust';

$atts = $this->convertAttributesToMessageBox2( $atts );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$elementClass = array(
	'base'          => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_message_box', $this->settings['base'], $atts ),
	'style'         => 'vc_message_box-' . $message_box_style,
	'shape'         => 'vc_message_box-' . $style,
	'color'         => ( strlen( $color ) > 0 && false === strpos( 'alert', $color ) ) ? 'vc_color-' . $color : 'vc_color-' . $message_box_color,
	'css_animation' => $this->getCSSAnimation( $css_animation ),
);

$close_icon = false;
if ( isset( $pgscore_vc_message_closeable ) && false != trim( $pgscore_vc_message_closeable ) && $pgscore_vc_message_closeable = 'true' ) {
	$close_icon     = true;
	$elementClass[] = 'alert';
}

$icon_stat = true;
if ( isset( $pgscore_vc_message_hide_icon ) && 'true' == $pgscore_vc_message_hide_icon ) {
	$icon_stat      = false;
	$elementClass[] = 'vc_message_box-witout-icon';
}

$class_to_filter  = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class        = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

// Pick up icons
$iconClass = isset( ${'icon_' . $icon_type} ) ? ${'icon_' . $icon_type} : $defaultIconClass;
switch ( $color ) {
	case 'info':
		$icon_type = 'fontawesome';
		$iconClass = 'fa fa-info-circle';
		break;
	case 'alert-info':
		$icon_type = 'pixelicons';
		$iconClass = 'vc_pixel_icon vc_pixel_icon-info';
		break;
	case 'success':
		$icon_type = 'fontawesome';
		$iconClass = 'fa fa-check';
		break;
	case 'alert-success':
		$icon_type = 'pixelicons';
		$iconClass = 'vc_pixel_icon vc_pixel_icon-tick';
		break;
	case 'warning':
		$icon_type = 'fontawesome';
		$iconClass = 'fa fa-exclamation-triangle';
		break;
	case 'alert-warning':
		$icon_type = 'pixelicons';
		$iconClass = 'vc_pixel_icon vc_pixel_icon-alert';
		break;
	case 'danger':
		$icon_type = 'fontawesome';
		$iconClass = 'fa fa-times';
		break;
	case 'alert-danger':
		$icon_type = 'pixelicons';
		$iconClass = 'vc_pixel_icon vc_pixel_icon-explanation';
		break;
	case 'alert-custom':
	default:
		break;
}

// Enqueue needed font for icon element
if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && 'pixelicons' !== $icon_type ) {
	vc_icon_element_fonts_enqueue( $icon_type );
}
?>
<div class="<?php echo esc_attr( $css_class ); ?>">
	<?php
	if ( $close_icon ) {
		?>
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
	}
	if ( $icon_stat ) {
		?>
		<div class="vc_message_box-icon"><i class="<?php echo esc_attr( $iconClass ); ?>"></i></div>
		<?php
	}
	echo wpb_js_remove_wpautop( $content, true );
	?>
</div>
