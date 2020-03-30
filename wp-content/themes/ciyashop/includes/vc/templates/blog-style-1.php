<?php
//Blog Style 1
return array(
	'name'             => esc_html__( 'Blog Style', 'ciyashop' ),
	'template_category'=> esc_html__( 'Blog', 'ciyashop' ),
	'disabled'         => true,                                        // Disable it to not show in the default tab
	'content'          => <<<CONTENT
[vc_row el_id="1523540465121-b0963ee9-7a35"][vc_column][pgscore_recent_posts style="style-1" listing_type="carousel" intro_title_color="#ffffff" intro_description_color="#ffffff" intro_link_color="#ffffff" intro_link_position="with_controls" intro_content_alignment="left" intro_bg_type="color" intro_bg_color="#88d482" carousel_items_xl="2" carousel_items_lg="2" carousel_items_md="1" enable_intro="true" enable_intro_link="true" intro_title="Recent Title" intro_description="CiyaShop is an enchanting and easy to use e-Commerce Wp template that allows you to sell your products in a dynamic way." intro_link="url:%23|||"][/vc_column][/vc_row]
CONTENT
);