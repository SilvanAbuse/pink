<?php
$group_57501ad11cf25_field_data = array(
	'key'                   => 'group_57501ad11cf25',
	'title'                 => 'Page Settings',
	'fields'                => array(
		array(
			'key'               => 'field_58c2795e94d5c',
			'label'             => 'Show Header',
			'name'              => 'show_header',
			'type'              => 'true_false',
			'instructions'      => 'Show/hide banner on this page.',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'message'           => '',
			'default_value'     => 1,
			'ui'                => 1,
			'ui_on_text'        => 'Show',
			'ui_off_text'       => 'Hide',
		),
		array(
			'key'               => 'field_58c27d25d60fc',
			'label'             => 'Header Settings Source',
			'name'              => 'header_settings_source',
			'type'              => 'button_group',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'default' => 'Default (from Theme Options)',
				'custom'  => 'Custom',
			),
			'allow_null'        => 0,
			'default_value'     => 'default',
			'layout'            => 'horizontal',
			'return_format'     => 'value',
		),
		array(
			'key'               => 'field_58c26ecc107b7',
			'label'             => 'Banner',
			'name'              => '',
			'type'              => 'tab',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'placement'         => 'top',
			'endpoint'          => 0,
		),
		array(
			'key'               => 'field_575aac9c8d83b',
			'label'             => 'Banner Type',
			'name'              => 'banner_type',
			'type'              => 'button_group',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'color' => '<i class="fa fa-paint-brush"></i> Color',
				'image' => '<i class="fa fa-picture-o"></i> Image',
				'video' => '<i class="fa fa-video-camera"></i> Video',
			),
			'allow_null'        => 0,
			'default_value'     => '',
			'layout'            => 'horizontal',
			'return_format'     => 'value',
		),
		array(
			'key'                          => 'field_58b7cd5dedd71',
			'label'                        => 'Banner Image',
			'name'                         => 'banner_image_bg_custom',
			'type'                         => 'background',
			'instructions'                 => '',
			'required'                     => 0,
			'conditional_logic'            => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'wrapper'                      => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'show_background_repeat'       => 1,
			'background_repeat'            => 'inherit',
			'show_background_clip'         => 0,
			'background_clip'              => 'inherit',
			'show_background_size'         => 1,
			'background_size'              => 'inherit',
			'show_background_attachment'   => 1,
			'background_attachment'        => 'inherit',
			'show_background_position'     => 1,
			'background_position'          => 'inherit',
			'show_background_origin'       => 0,
			'background_origin'            => 'padding-box',
			'display_background_color'     => 0,
			'background_color'             => '',
			'show_background_image'        => 1,
			'show_preview_media'           => 1,
			'show_preview'                 => 1,
			'preview-height'               => 200,
			'show_text_color'              => 0,
			'text_color'                   => '#000',
			'ext_value'                    => array(),
			'background_repeat_values'     => array(
				'no-repeat' => 'No Repeat',
				'repeat'    => 'Repeat All',
				'repeat-x'  => 'Repeat Horizontally',
				'repeat-y'  => 'Repeat Vertically',
				'inherit'   => 'Inherit',
			),
			'background_clip_values'       => array(
				'border-box'  => 'Border Box',
				'padding-box' => 'Padding Box',
				'content-box' => 'Content Box',
				'inherit'     => 'Inherit',
			),
			'background_size_values'       => array(
				'cover'   => 'Cover',
				'contain' => 'Contain',
				'inherit' => 'Inherit',
				'auto'    => 'auto',
			),
			'background_attachment_values' => array(
				'scroll'  => 'Scroll',
				'fixed'   => 'Fixed',
				'local'   => 'Local',
				'inherit' => 'Inherit',
			),
			'background_position_values'   => array(
				'left top'      => 'Left Top',
				'left center'   => 'Left center',
				'left bottom'   => 'Left Bottom',
				'center top'    => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom',
				'right top'     => 'Right Top',
				'right center'  => 'Right center',
				'right bottom'  => 'Right Bottom',
				'inherit'       => 'Inherit',
			),
			'background_origin_values'     => array(
				'border-box'  => 'Border Box',
				'padding-box' => 'Padding Box',
				'content-box' => 'Content Box',
				'inherit'     => 'Inherit',
			),
		),
		array(
			'key'               => 'field_575ac52c6e6cd',
			'label'             => 'Banner (Color)',
			'name'              => 'banner_image_color',
			'type'              => 'color_picker',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'color',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => '#191919',
		),
		array(
			'key'               => 'field_58c263081b0bd',
			'label'             => 'Video Source',
			'name'              => 'banner_video_source',
			'type'              => 'button_group',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'youtube' => '<i class="fa fa-youtube"></i> YouTube',
				'vimeo'   => '<i class="fa fa-vimeo"></i> Vimeo',
			),
			'allow_null'        => 0,
			'default_value'     => 'youtube',
			'layout'            => 'horizontal',
			'return_format'     => 'value',
		),
		array(
			'key'               => 'field_58c26488af3b9',
			'label'             => 'YouTube',
			'name'              => 'banner_video_source_youtube',
			'type'              => 'oembed',
			'instructions'      => 'Enter YouTube video link.',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'field_58c263081b0bd',
						'operator' => '==',
						'value'    => 'youtube',
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
		array(
			'key'               => 'field_58c264d7af3bb',
			'label'             => 'Vimeo',
			'name'              => 'banner_video_source_vimeo',
			'type'              => 'oembed',
			'instructions'      => 'Enter Vimeo video link.',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'field_58c263081b0bd',
						'operator' => '==',
						'value'    => 'vimeo',
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
		array(
			'key'               => 'field_575abc7c96f15',
			'label'             => 'Background Opacity Color',
			'name'              => 'background_opacity_color',
			'type'              => 'button_group',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'image',
					),
				),
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'none'   => 'None',
				'black'  => 'Black',
				'custom' => 'Custom',
			),
			'allow_null'        => 0,
			'default_value'     => '',
			'layout'            => 'horizontal',
			'return_format'     => 'value',
		),
		array(
			'key'               => 'field_575abd19e7d39',
			'label'             => 'Background Opacity Color (Custom Color)',
			'name'              => 'banner_image_opacity_custom_color',
			'type'              => 'color_picker',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'image',
					),
					array(
						'field'    => 'field_575abc7c96f15',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'field_575abc7c96f15',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '50',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => '#000000',
		),
		array(
			'key'               => 'field_575ac40722619',
			'label'             => 'Background Opacity Color (Custom Opacity)',
			'name'              => 'banner_image_opacity_custom_opacity',
			'type'              => 'number',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'image',
					),
					array(
						'field'    => 'field_575abc7c96f15',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_575aac9c8d83b',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'field_575abc7c96f15',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '50',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => '.8',
			'placeholder'       => '',
			'prepend'           => '',
			'append'            => '',
			'min'               => 0,
			'max'               => 1,
			'step'              => '0.01',
		),
		array(
			'key'               => 'field_58c2842041d66',
			'label'             => 'Page Header Height',
			'name'              => 'page_header_height',
			'type'              => 'range',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'default_value'     => 287,
			'min'               => 200,
			'max'               => 600,
			'step'              => '',
			'prepend'           => '',
			'append'            => 'px',
		),
		array(
			'key'               => 'field_58c275ce29fab',
			'label'             => 'Titlebar Text Align',
			'name'              => 'titlebar_text_align',
			'type'              => 'select',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'choices'           => array(
				'default'  => 'All Center',
				'allleft'  => 'All Left',
				'allright' => 'All Right',
				'left'     => 'Title Left / Breadcrumb Right',
				'right'    => 'Title Right / Breadcrumb Left',
			),
			'default_value'     => array(
				0 => 'default',
			),
			'allow_null'        => 0,
			'multiple'          => 0,
			'ui'                => 1,
			'ajax'              => 0,
			'return_format'     => 'value',
			'placeholder'       => '',
		),
		array(
			'key'               => 'field_58c26eed107b8',
			'label'             => 'Breadcrumb',
			'name'              => '',
			'type'              => 'tab',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'placement'         => 'top',
			'endpoint'          => 0,
		),
		array(
			'key'               => 'field_58c2739529fa6',
			'label'             => 'Display Breadcrumb',
			'name'              => 'display_breadcrumb',
			'type'              => 'true_false',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'message'           => '',
			'default_value'     => 0,
			'ui'                => 1,
			'ui_on_text'        => '',
			'ui_off_text'       => '',
		),
		array(
			'key'               => 'field_58c2749b29fa8',
			'label'             => 'Display Breadcrumb on Mobile',
			'name'              => 'display_breadcrumb_on_mobile',
			'type'              => 'true_false',
			'instructions'      => '',
			'required'          => 0,
			'conditional_logic' => array(
				array(
					array(
						'field'    => 'field_58c2795e94d5c',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'field_58c27d25d60fc',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'field_58c2739529fa6',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'wrapper'           => array(
				'width' => '',
				'class' => '',
				'id'    => '',
			),
			'message'           => '',
			'default_value'     => 0,
			'ui'                => 1,
			'ui_on_text'        => '',
			'ui_off_text'       => '',
		),
	),
	'location'              => array(

		// Pages
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'page',
			),
		),

		// Posts
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'post',
			),
		),

		// CPT Portolfio
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'portfolio',
			),
		),

		// CPT Teams
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'teams',
			),
		),

		// BBPress
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'forum',
			),
		),
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'topic',
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
	'modified'              => 1489142967,
);

acf_add_local_field_group( apply_filters( 'page_settings_group_57501ad11cf25', $group_57501ad11cf25_field_data ) );
