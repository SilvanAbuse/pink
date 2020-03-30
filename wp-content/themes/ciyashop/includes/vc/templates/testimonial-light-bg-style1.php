<?php
//About Banner
return array(
	'name'             => esc_html__( 'Light BG with Style 1', 'ciyashop' ),
	'template_category'=> esc_html__( 'Testimonial', 'ciyashop' ),
	'disabled'         => true,                                        // Disable it to not show in the default tab
	'content'          => <<<CONTENT
[vc_row enable_first_overlay="true" first_overlay_opacity="95" first_background_color="#ffffff" pgscore_enable_responsive_settings="true" pgscore_enable_overlay="true" el_id="1515418699187-1037afa0-9aa4" css=".vc_custom_1524655116955{margin-right: 0px !important;margin-left: 0px !important;padding-top: 80px !important;padding-bottom: 80px !important;background-image: url(https://ciyashop.potenzaglobalsolutions.com/furniture/wp-content/uploads/sites/60/2018/01/testimonial-bg.jpg?id=11503) !important;background-position: 0 0 !important;background-repeat: repeat !important;}" pgscore_overlay_color="rgba(255,255,255,0.92)" element_css_sm=".vc_custom_1524655116963{padding-top: 50px !important;padding-bottom: 50px !important;}" element_css_xs=".vc_custom_1524655116967{padding-top: 40px !important;padding-bottom: 40px !important;}" element_css_md=".vc_custom_1524655116959{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column css=".vc_custom_1524655223713{padding-top: 0px !important;}" offset="vc_col-lg-offset-1 vc_col-lg-10 vc_col-md-offset-1 vc_col-md-10"][pgscore_testimonials posts_per_page="8"][/vc_column][/vc_row]
CONTENT
);