<?php
$exclude_pages = array();

// Exclude Home and Blog pages.
$show_on_front = get_option( 'show_on_front' );
if ( $show_on_front == 'page' ) {

	$page_on_front  = get_option( 'page_on_front' );
	$page_for_posts = get_option( 'page_for_posts' );

	if ( isset( $page_on_front ) && $page_on_front != '0' ) {
		$exclude_pages[] = $page_on_front;
	}

	if ( isset( $page_for_posts ) && $page_for_posts != '0' ) {
		$exclude_pages[] = $page_for_posts;
	}
}

// Exclude WooCommerce pages
if ( class_exists( 'WooCommerce' ) && is_admin() ) {
	$woocommerce_pages = array(
		'woocommerce_shop_page_id',
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_pay_page_id',
		'woocommerce_thanks_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_edit_address_page_id',
		'woocommerce_view_order_page_id',
		'woocommerce_terms_page_id',
	);
	foreach ( $woocommerce_pages as $woocommerce_page ) {
		$woocommerce_page_id = get_option( $woocommerce_page );
		if ( $woocommerce_page_id ) {
			$exclude_pages[] = $woocommerce_page_id;
		}
	}
}

return array(
	'title'            => esc_html__( '404 Page', 'pgs-core' ),
	'id'               => 'fourofour_section',
	'customizer_width' => '400px',
	'icon'             => 'fa fa-exclamation-triangle',
	'desc'             => esc_html__( 'Set 404 page title and content.', 'pgs-core' ),
	'fields'           => array(
		// Page Title
		array(
			'id'       => 'fourofour_title_section-start',
			'type'     => 'section',
			'title'    => esc_html__( 'Page Title', 'pgs-core' ),
			'subtitle' => esc_html__( 'Here you can manage 404 page title.', 'pgs-core' ),
			'indent'   => true,
		),
		array(
			'id'      => 'fourofour_page_title_source',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Page Title Source', 'pgs-core' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'custom'  => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default' => 'default',
		),
		array(
			'id'       => 'fourofour_page_title',
			'type'     => 'text',
			'title'    => esc_html__( 'Page Title', 'pgs-core' ),
			'desc'     => esc_html__( 'Enter custom 404 page title.', 'pgs-core' ),
			'default'  => esc_html__( '404 error', 'pgs-core' ),
			'required' => array( 'fourofour_page_title_source', '=', 'custom' ),
		),
		array(
			'id'     => 'fourofour_title_section-end',
			'type'   => 'section',
			'indent' => false,
		),

		// Page Content
		array(
			'id'       => 'fourofour_content_section-start',
			'type'     => 'section',
			'title'    => esc_html__( 'Page Content', 'pgs-core' ),
			'subtitle' => esc_html__( 'Here you can manage 404 page content.', 'pgs-core' ),
			'indent'   => true,
		),
		array(
			'id'    => 'header_width_info',
			'type'  => 'info',
			'style' => 'warning',
			'desc'  => esc_html__( 'If "Page Content" is set to page and any page is selected, then it will use the content of that page, instead of 404 page itself.', 'pgs-core' ),
			'icon'  => 'el el-info-circle',
		),
		array(
			'id'      => 'fourofour_page_content_source',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Page Content Type', 'pgs-core' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'page'    => esc_html__( 'Page', 'pgs-core' ),
			),
			'default' => 'default',
		),
		array(
			'id'       => 'fourofour_page_content_title',
			'type'     => 'text',
			'title'    => esc_html__( 'Content Title', 'pgs-core' ),
			'desc'     => esc_html__( 'Enter custom 404 content title.', 'pgs-core' ),
			'default'  => esc_html__( '404', 'pgs-core' ),
			'required' => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'       => 'fourofour_page_content_subtitle',
			'type'     => 'text',
			'title'    => esc_html__( 'Content Subitle', 'pgs-core' ),
			'desc'     => esc_html__( 'Enter custom 404 content subtitle.', 'pgs-core' ),
			'default'  => esc_html__( "Oops ! Sorry We Can't Find That Page.", 'pgs-core' ),
			'required' => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'           => 'fourofour_page_content_description',
			'type'         => 'textarea',
			'title'        => esc_html__( 'Content Description', 'pgs-core' ),
			'desc'         => esc_html__( 'Enter custom 404 content description.', 'pgs-core' ),
			'validate'     => 'html_custom',
			'default'      => sprintf(
				wp_kses(
					__( "Can't find what you looking for? Take a moment and do a search below or start from our <a class='error-search-box-description-link' href='%s'>Home Page</a>", 'pgs-core' ),
					array(
						'a' => array(
							'class' => array(),
							'href'  => array(),
						),
					)
				),
				esc_url( home_url( '/' ) )
			),
			'allowed_html' => array(
				'a'      => array(
					'href'  => array(),
					'title' => array(),
					'class' => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
			),
			'required'     => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'       => 'fourofour_page_content_image',
			'type'     => 'media',
			'url'      => true,
			'compiler' => 'true',
			'title'    => esc_html__( 'Content Image', 'pgs-core' ),
			'desc'     => esc_html__( 'Set content image.', 'pgs-core' ),
			'default'  => array( 'url' => PGSCORE_URL . 'images/options/404/error-404-image.png' ),
			'required' => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'             => 'fourofour_page_content_padding',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units'          => array( 'px', 'em' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Content Padding', 'pgs-core' ),
			'desc'           => esc_html__( 'You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'pgs-core' ),
			'default'        => array(
				'units' => 'px',
			),
			'select2'        => array(
				'allowClear' => false,
			),
			'required'       => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'             => 'fourofour_page_content_margin',
			'type'           => 'spacing',
			'mode'           => 'margin',
			'units'          => array( 'px', 'em' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Content Margin', 'pgs-core' ),
			'desc'           => esc_html__( 'You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'pgs-core' ),
			'default'        => array(
				'units' => 'px',
			),
			'select2'        => array(
				'allowClear' => false,
			),
			'required'       => array( 'fourofour_page_content_source', '=', 'default' ),
		),
		array(
			'id'       => 'fourofour_page_content_page',
			'type'     => 'select',
			'title'    => esc_html__( 'Page', 'pgs-core' ),
			'desc'     => esc_html__( 'Select page to display as 404 page.', 'pgs-core' ),
			'data'     => 'pages',
			'args'     => array(
				'exclude' => $exclude_pages,
			),
			'required' => array( 'fourofour_page_content_source', '=', 'page' ),
		),
		array(
			'id'     => 'fourofour_content_section-end',
			'type'   => 'section',
			'indent' => false,
		),
	),
);
