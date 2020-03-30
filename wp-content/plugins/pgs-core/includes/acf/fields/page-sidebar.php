<?php
$group_5b9215d6576e8_field_data = array(
	'key'                   => 'group_5b9215d6576e8',
	'title'                 => 'Page Sidebar',
	'fields'                => array(
		array(
			'key'               => 'field_5b92169939be8',
			'label'             => 'Page Sidebar',
			'name'              => 'page_sidebar',
			'type'              => 'select',
			'instructions'      => 'This setting will override the theme option sidebar settings',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'default'       => 'Default',
				'left_sidebar'  => 'Left Sidebar',
				'right_sidebar' => 'Right Sidebar',
			),
			'default_value'     => array(
				0 => 'default',
			),
			'allow_null'        => 0,
			'multiple'          => 0,
			'ui'                => 0,
			'return_format'     => 'value',
			'ajax'              => 0,
			'placeholder'       => '',
		),
	),
	'location'              => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'page',
			),
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => 'default',
			),
		),
	),
	'menu_order'            => 0,
	'position'              => 'side',
	'style'                 => 'default',
	'label_placement'       => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen'        => '',
	'active'                => 1,
	'description'           => '',
);

acf_add_local_field_group( apply_filters( 'page_settings_group_5b9215d6576e8', $group_5b9215d6576e8_field_data ) );
