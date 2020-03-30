<?php
if ( function_exists( 'acf_add_local_field_group' ) && class_exists( 'WooCommerce' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_5cd100db47b96',
			'title'                 => 'Tag Banner Image',
			'fields'                => array(
				array(
					'key'               => 'field_5cd100ec58a03',
					'label'             => 'Banner Image',
					'name'              => 'product_tag_banner_image',
					'type'              => 'image',
					'instructions'      => esc_html__( 'This banner will be visible on the Product Tag archive page.', 'pgs-core' ),
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
			),
			'location'              => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'product_tag',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

endif;

