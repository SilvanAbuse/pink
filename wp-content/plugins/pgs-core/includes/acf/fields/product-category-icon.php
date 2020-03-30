<?php
if ( function_exists( 'acf_add_local_field_group' ) && class_exists( 'WooCommerce' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_5b9a53d9d9b6b',
			'title'                 => 'Product Category Icon',
			'fields'                => array(
				array(
					'key'               => 'field_5b9a53eba1c43',
					'label'             => 'Image (icon) for categories on the shop page header',
					'name'              => 'product_category_icon',
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
			),
			'location'              => array(
				array(
					array(
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => 'product_cat',
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
	);

endif;

