<?php
/**
 * Instagram Settings
 *
 * @package PGS Core
 */
return array(
	'title'            => esc_html__( 'Instagram', 'pgs-core' ),
	'id'               => 'instagram-settings',
	'customizer_width' => '400px',
	'icon'             => 'el el-instagram',
	'fields'           => array(
		array(
			'id'             => 'instagram_client_id',
			'type'           => 'text',
			'title'          => esc_html__( 'Client ID', 'pgs-core' ),
			'description'    => esc_html__( 'Enter Client ID.', 'pgs-core' ) .
				'<br><br>' . sprintf(
					wp_kses(
						/* translators: %1$s is replaced with instagram developer url and %2$s with authentication instagram url*/
						__( 'Click <a href="%1$s" target="_blank">here</a> to generate "<strong>Client ID</strong>". Please check this <a href="%2$s" target="_blank">guide</a> for more information on "<strong>Client ID</strong>" generation.', 'pgs-core' ),
						array(
							'a'      => array(
								'href'   => true,
								'target' => true,
							),
							'strong' => true,
							'br'     => true,
						)
					),
					'https://www.instagram.com/developer/clients/manage/',
					'https://auth0.com/docs/connections/social/instagram'
				) .
				'<br><br><strong>' . esc_html__( 'Use below required details when generating Client ID.', 'pgs-core' ) . '</strong>' .
				'<br><strong>Valid redirect URIs:</strong>' . '<br>' . '<div id="instagram_redirect_uris">' . ( is_ssl() ? 'https://' : 'http://' ) . sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) . '</div>', // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			'editor_options' => '',
		),
		array(
			'id'       => 'generate_access_token',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Generate Access Token', 'pgs-core' ),
			'options'  => array(
				'generate_access_token' => esc_html__( 'Generate Access Token', 'pgs-core' ),
			),
			'default'  => 'generate_access_token',
			'required' => array( 'instagram_client_id', 'not_empty_and', '' ),
		),
		array(
			'id'             => 'instagram_access_token',
			'type'           => 'text',
			'title'          => esc_html__( 'Instagram Access Token', 'pgs-core' ),
			'default'        => '',
			'editor_options' => '',
			'required'       => array( 'instagram_client_id', 'not_empty_and', '' ),
		),
	),
);
