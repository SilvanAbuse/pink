<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		apply_filters(
			'product_size_guide_group_5a1e62ed6b6ca',
			array(
				'key'                   => 'group_5a1e62ed6b6ca',
				'title'                 => esc_html__( 'Size Guide Image', 'pgs-core' ),
				'fields'                => array(
					array(
						'key'               => 'field_5bb227f74f85b',
						'label'             => 'Select Size Guides',
						'name'              => 'select_size_guides',
						'type'              => 'button_group',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           =>
						array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           =>
						array(
							'image' => 'Size Guide Image',
							'table' => 'Size Guide Table',
						),
						'allow_null'        => 0,
						'default_value'     => 'image',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
					),
					array(
						'key'               => 'field_5a1e6310237da',
						'label'             => esc_html__( 'Size Guide Image', 'pgs-core' ),
						'name'              => 'size_guide_image',
						'type'              => 'image',
						'instructions'      => esc_html__( 'This image will visible as size guide for product.', 'pgs-core' ),
						'required'          => 0,
						'conditional_logic' =>
						array(
							array(
								array(
									'field'    => 'field_5bb227f74f85b',
									'operator' => '==',
									'value'    => 'image',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
						'preview_size'      => 'full',
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
						'key'               => 'field_5b98b3bffbaf2',
						'label'             => 'Size Guide Table',
						'name'              => 'size_guide_tables',
						'type'              => 'post_object',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' =>
						array(
							array(
								array(
									'field'    => 'field_5bb227f74f85b',
									'operator' => '==',
									'value'    => 'table',
								),
							),
						),
						'wrapper'           =>
						array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         =>
						array(
							0 => 'size_guides',
						),
						'taxonomy'          =>
						array(),
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'id',
						'ui'                => 1,
					),

				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'product',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
			)
		)
	);
}
