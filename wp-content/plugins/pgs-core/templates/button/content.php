<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_button'] );
extract( $atts );

$button_link   = vc_build_link( $button_link );
$button_target = 0;
if ( ! empty( $button_link['target'] ) ) {
	$button_target = 1;
}
$button_classes   = array();
$button_classes[] = 'inline_hover';

if ( $button_icon ) {
	$button_classes[] = 'button-icon';
	$button_classes[] = 'button-icon-position-' . $button_icon_position;
}


if ( isset( $button_type ) && ! empty( $button_type ) ) {
	$button_classes[] = 'pgscore_button_' . $button_type;
}
if ( $button_type && $button_type != 'link' ) {
	$button_classes[] = 'pgscore_button_border_' . $button_border;
}
//if($button_type!='link'){
	$button_classes[] = 'pgscore_button_size_' . $button_size;
//}
if ( $button_type && $button_type == 'link' ) {
	if ( $button_underline ) {
		//$button_text_styles[] = "text-decoration:underline";
		$button_classes[] = 'button-underline';
	}
}
$button_classes = implode( ' ', array_filter( array_unique( $button_classes ) ) );



$button_text_styles = array();
$prehover_style     = array();
if ( ! empty( $button_text_color ) ) {
	$button_text_styles[]    = "color:{$button_text_color}";
	$prehover_style['color'] = $button_text_color;
}

if ( $button_type && $button_type == 'default' ) {
	if ( ! empty( $button_background_color ) ) {
		$button_text_styles[] = "background:{$button_background_color}";

		$prehover_style['background'] = $button_background_color;
	}
}
if ( $button_type && $button_type == 'border' ) {
	if ( ! empty( $button_border_color ) ) {
		$button_text_styles[]           = "border-color:{$button_border_color}";
		$prehover_style['border-color'] = $button_border_color;
	}
}

if ( $button_type && $button_type == 'link' ) {
	if ( ! empty( $button_font_weight ) ) {
		$button_text_styles[] = "font-weight:{$button_font_weight}";
	}
}



$google_font_css = array();
if ( isset( $use_google_font ) && $use_google_font == 'yes' && isset( $banner_google_fonts ) ) {

	$enqueue_google_font = true;

	if ( isset( $google_font_enqueue_source ) && $google_font_enqueue_source == 'manual' ) {
		$enqueue_google_font = false;
	}

	$google_font_css    = pgscore_get_google_fonts_css( $banner_google_fonts, $enqueue_google_font );
	$button_text_styles = array_merge( $google_font_css, $button_text_styles );
}

$button_text_styles = implode( ';', array_filter( array_unique( $button_text_styles ) ) );

$hover_text_styles = array();
if ( ! empty( $button_text_hover_color ) ) {
	$hover_text_styles['color'] = $button_text_hover_color;
}

if ( $button_type && $button_type == 'default' ) {
	if ( ! empty( $button_background_hover_color ) ) {
		$hover_text_styles['background'] = $button_background_hover_color;
	}
}
if ( $button_type && $button_type == 'border' ) {
	if ( ! empty( $button_border_hover_color ) ) {
		$hover_text_styles['background']   = $button_border_background_color;
		$hover_text_styles['border-color'] = $button_border_hover_color;
	}
}
if ( $button_type && $button_type == 'link' ) {
	if ( ! empty( $button_border_hover_color ) ) {
		$hover_text_styles['border-color'] = $button_border_hover_color;
	}
}
?>

<?php if ( isset( $button_link['title'] ) && ! empty( $button_link['title'] ) ) { ?>
<div  class="<?php echo esc_attr( $button_classes ); ?>">
	
	<a style="<?php echo esc_attr( $button_text_styles ); ?>" <?php echo ( $button_target ) ? 'target="_blank"' : ''; ?> class="inline_hover" data-hover_styles="<?php echo esc_attr( json_encode( $hover_text_styles ) ); ?>" data-prehover_style="<?php echo esc_attr( json_encode( $prehover_style ) ); ?>" href="<?php echo esc_attr( $button_link['url'] ); ?>">
	<?php
	if ( $button_icon ) {
		if ( $button_icon_position == 'left' ) {
			?>
			<?php echo $icon_html; ?>
			<?php
		}
	}
	?>
	<?php echo esc_html( $button_link['title'] ); ?>
	<?php
	if ( $button_icon ) {
		if ( $button_icon_position == 'right' ) {
			?>
			<?php echo $icon_html; ?>
			<?php
		}
	}
	?>
	</a>
</div>
<?php } ?>
