<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		apply_filters(
			'product_video_group_598c246d064a4',
			array(
				'key'                   => 'group_598c246d064a4',
				'title'                 => esc_html__( 'Product Video', 'pgs-core' ),
				'fields'                => array(
					array(
						'key'               => 'field_598c2dff557f4',
						'label'             => esc_html__( 'Video Source', 'pgs-core' ),
						'name'              => 'product_video_source',
						'type'              => 'button_group',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'internal' => '<i class="fa fa-upload"></i> Internal',
							'external' => '<i class="fa fa-external-link"></i> External',
						),
						'allow_null'        => 0,
						'default_value'     => '',
						'layout'            => 'horizontal',
						'return_format'     => 'value',
					),
					array(
						'key'               => 'field_598c2e44557f5',
						'label'             => esc_html__( 'Video', 'pgs-core' ),
						'name'              => 'product_video_internal',
						'type'              => 'file',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_598c2dff557f4',
									'operator' => '==',
									'value'    => 'internal',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
						'library'           => 'all',
						'min_size'          => '',
						'max_size'          => '',
						'mime_types'        => 'mp4,ogv,webm',
					),
					array(
						'key'               => 'field_598c2ed6557f6',
						'label'             => esc_html__( 'Video', 'pgs-core' ),
						'name'              => 'product_video_external',
						'type'              => 'oembed',
						'instructions'      => esc_html__( 'Enter YouTube, Vimeo or Dailymotion video url.', 'pgs-core' ),
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_598c2dff557f4',
									'operator' => '==',
									'value'    => 'external',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'width'             => '',
						'height'            => '',
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
				'instruction_placement' => 'field',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
				'modified'              => 1505221913,
			)
		)
	);
}
