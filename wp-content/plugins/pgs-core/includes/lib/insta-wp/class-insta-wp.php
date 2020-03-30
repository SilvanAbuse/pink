<?php
/**
 * Instagram WP class file.
 *
 * @package Instagram WP
 */

/**
 * Instagram WP class.
 *
 * @since 1.0.0
 */
class Insta_WP {

	/**
	 * Options prefix.
	 *
	 * @var string
	 */
	protected $option_prefix;

	/**
	 * Client ID.
	 *
	 * @var string
	 */
	protected $client_id_key;

	/**
	 * Client Secret.
	 *
	 * @var string
	 */
	protected $client_secret_key;

	/**
	 * Access key.
	 *
	 * @var string
	 */
	protected $access_token_key;

	/**
	 * Authentication redirection URL.
	 *
	 * @var string
	 */
	protected $auth_redirect_uri;

	/**
	 * Admin Page Slug
	 *
	 * @var string
	 */
	protected $admin_page;

	/**
	 * Constructor. Don't call directly, @see instance() instead.
	 *
	 * @see instance()
	 *
	 * @return void
	 **/
	public function __construct() {

		$this->option_prefix       = 'insta_wp';
		$this->option_name         = $this->option_prefix . '_settings';
		$this->redirection_url_key = $this->option_prefix . '_redirection_url';
		$this->client_id_key       = $this->option_prefix . '_client_id';
		$this->client_secret_key   = $this->option_prefix . '_client_secret';
		$this->access_token_key    = $this->option_prefix . '_access_token';
		$this->admin_page          = 'insta-wp';
		$this->auth_redirect_uri   = admin_url( 'options-general?page=' . $this->admin_page );

		$this->init();
	}

	/**
	 * Init function.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'add_admin_settings' ) );
	}

	/**
	 * Register admin menus
	 */
	public function add_admin_menu() {

		add_options_page(
			esc_html__( 'Insta WP Settings', 'pgs-core' ),// page_title.
			esc_html__( 'Insta WP', 'pgs-core' ),         // menu_title.
			'manage_options',                             // capability.
			$this->admin_page,                            // menu_slug.
			array( $this, 'admin_page' )                  // function.
		);

		add_action( 'load-settings_page_' . $this->admin_page, array( $this, 'authorize_instagram' ) );
	}

	/**
	 * Register admin menus
	 */
	public function admin_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				//add_settings_section callback is displayed here. For every new section we need to call settings_fields.
				settings_fields( 'insta_wp_option_section' );
				
				// all the add_settings_field callbacks is displayed here
				do_settings_sections( 'insta_wp_settings' );
				
				// Add the submit button to serialize the options
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add admin setting section and fields.
	 */
	public function add_admin_settings() {
		$client_id     = $this->get_field( $this->client_id_key );
		$client_secret = $this->get_field( $this->client_secret_key );
		$access_token  = $this->get_field( $this->access_token_key );
		
		// Add Section
		add_settings_section(
			'insta_wp_option_section',              // id.
			esc_html__( 'API Settings', 'pgs-core' ),                              // title.
			array( $this, 'display_section_header_content' ), // callback.
			'insta_wp_settings'                         // page.
		);
		
		// Add Fields
		add_settings_field(
			'redirection_url',                       // id.
			'Redirection URL',                       // title.
			array( $this, 'render_settings_field' ), // callback.
			'insta_wp_settings',                     // page.
			'insta_wp_option_section',               // section.
			array(
				'field'      => $this->redirection_url_key,
				'attributes' => array( 'readonly' ),
				'value'      => $this->auth_redirect_uri,
				'type'       => 'code',
				'description' => esc_html__( 'Copy this URL and add it in your Instagram application in in Valid redirect URIs field.', 'pgs-core' ),
			)
		);
		
		add_settings_field(
			'client_id',                          // id.
			'Client ID',                          // title.
			array( $this, 'render_settings_field' ), // callback.
			'insta_wp_settings',                     // page.
			'insta_wp_option_section',             // section.
			array(
				'field'       => $this->client_id_key,
				'type'        => 'text',
				'description' => esc_html__( 'Enter Client ID.', 'pgs-core' ),
			)
		);
		
		add_settings_field(
			'client_secret',                          // id.
			'Client Secret',                          // title.
			array( $this, 'render_settings_field' ), // callback.
			'insta_wp_settings',                         // page.
			'insta_wp_option_section',                // section.
			array(
				'field'      => $this->client_secret_key,
				'type'       => 'text',
				'description'=> esc_html__( 'Enter Client Secret.', 'pgs-core' ),
			)
		);

		$auth_info         = null;

		if ( $client_id && $client_secret ) {
			if (!$access_token) {
				$auth_url  = Insta_WP_API::authUrl( $client_id, $client_secret, $this->auth_redirect_uri );
				$auth_info = sprintf(
					'<a href="%s" class="button">%s</a>',
					$auth_url,
					esc_html__( 'Generate Access Token', 'pgs-core' )
				);
			} else {
				$auth_info = sprintf(
					'<a href="#" class="button" id="instagram_deauth">%s</a>',
					esc_html__( 'Unregister Accesss Token', 'pgs-core' )
				);
			}
		} else {
			$auth_info = sprintf(
				'<span class="description">%s</span>',
				wp_kses(
					__( 'Please enter <strong>Client ID</strong> and <strong>Client Secret</strong> to generate <strong>Access Token</strong>.', 'pgs-core' ),
					array(
						'strong' => array(),
					)
				)
			);
		}

		add_settings_field(
			'access_token',                          // id.
			esc_html__('Access Token', 'pgs-core'),  // title.
			array( $this, 'render_settings_field' ), // callback.
			'insta_wp_settings',                     // page.
			'insta_wp_option_section',                // section.
			array(
				'field'       => $this->access_token_key,
				'attributes'  => array( 'readonly' ),
				'after'       => " " . $auth_info,
				'type'        => $access_token ? 'text' : 'none',
			)
		);

		// Register Settings
		register_setting(
			'insta_wp_option_section',          // option_group.
			$this->client_id_key,               // option_name.
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'insta_wp_option_section',
			$this->client_secret_key,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'insta_wp_option_section',
			$this->access_token_key,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

	}

	/**
	 * Function sanitize_fields
	 *
	 * @param array $input   Field data array.
	 */
	public function sanitize_fields( $input ) {
		$sanitary_values = array();
		if ( isset( $input['client_id'] ) ) {
			$sanitary_values['client_id'] = sanitize_text_field( $input['client_id'] );
		}

		if ( isset( $input['client_secret'] ) ) {
			$sanitary_values['client_secret'] = sanitize_text_field( $input['client_secret'] );
		}

		if ( isset( $input['access_token'] ) ) {
			$sanitary_values['access_token'] = sanitize_text_field( $input['access_token'] );
		}

		return $sanitary_values;
	}

	/**
	 * Function display_section_header_content
	 */
	public function display_section_header_content() {
		// To generate an Access Token, you need to create an Instagram application first. Click here to register your application.
		echo wpautop(
			sprintf(
				wp_kses(
					__( 'To generate an Access Token, you need to create and configure an <strong>Instagram</strong> application first. Click <a href="%s" target="_blank">here</a> to register your application.', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
						'strong' => array(),
					)
				),
				'https://www.instagram.com/developer/clients/manage/'
			)
		);

		echo wpautop(
			wp_kses(
				__( 'While configuring the <strong>Instagram</strong> application, it will require a redirection URL. Add below URL in your application in <strong>Valid redirect URIs</strong> field.', 'pgs-core' ),
				array(
					'strong' => array(),
				)
			)
		);
	}

	/**
	 * Renders the specified settings field
	 *
	 * @param array $args Array of arguments (field, name, id, value)
	 * @return void
	 * @author Simon Fransson
	 **/
	public function render_settings_field($args = null) {
		$defaults = array(
			'field'      => null,
			'type'       => 'text',
			'name'       => null,
			'id'         => null,
			'value'      => null,
			'class'      => array( 'regular-text' ),
			'description'=> null,
			'after'      => null,
			'before'     => null,
			'attributes' => array(),
		);

		$args = wp_parse_args( $args, $defaults );
		
		// Set variables
		// extract( $args );
		foreach ( $args as $arg_k => $arg_v ) {
			$$arg_k = $arg_v;
		}

		if ( ! $field ) {
			return null;
		}

		$class = array_merge( array(
			'insta-wp-field',
			'insta-wp-field-' . $type,
		), $class );

		if ( ! $value ) {
			$value = get_option( $field );
		}

		if ( ! $name ) {
			$name = $field;
		}

		if (!$id) {
			$id = $field;
		}

		$extra_attrs = array();
		foreach ( $attributes as $attr => $attr_val ) {
			if ( is_numeric( $attr ) ) {
				$extra_attrs[] = $attr_val;
			} else {
				$extra_attrs[] = "${attr}=\"${attr_val}\"";
			}
		}

		if ($before) {
			echo $before;
		}

		switch ($type) {
			case 'page':
				return $this->render_page_setting(array(
					'name'    => $name,
					'id'      => $id,
					'selected'=> $value,
				));
				break;

			case 'none':
				break;

			case 'text':
				printf(
					'<input type="text" name="%s" id="%s" value="%s" class="%s" %s>',
					$name,
					$id,
					$value,
					implode( " ", (array) $class ),
					implode( " ", $extra_attrs )
				);
				break;

			case 'textarea':
				$class[] = 'large-text';
				printf(
					'<textarea type="text" name="%s" id="%s" class="%s" %s>%s</textarea>',
					$name,
					$id,
					implode( " ", (array) $class ),
					implode( " ", $extra_attrs ),
					$value
				);
				break;

			case 'code':
				$class[] = 'insta-wp-code';
				printf(
					'<code id="%s" class="%s" %s>%s</code>',
					$id,
					implode( " ", (array) $class ),
					implode( " ", $extra_attrs ),
					$value
				);
				break;

			default:
				break;
		}

		$description = strval( $description );
		if ( ! empty( $description ) ) {
			?>
			<p class="description"><?php echo esc_html( $description ); ?></p>
			<?php
		}

		if ( $after ) {
			echo $after;
		}
	}

	function authorize_instagram() {
		var_dump(__LINE__);
	}

	/**
	 * Get field
	 */
	function get_field( $key = '' ){
		return get_option( $key );
	}
}

if ( is_admin() ) {
	$insta_wp = new Insta_WP();
}
