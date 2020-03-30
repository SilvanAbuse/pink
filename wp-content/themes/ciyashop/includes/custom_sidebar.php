<?php
/** * Custom Sidebar * Class for adding custom widget area and choose them on single pages/posts */
if ( ! class_exists( 'CiyaShopCustomSidebar' ) ) {

	class CiyaShopCustomSidebar {

		var $sidebars = array();
		var $stored   = '';

		function __construct() {
			$this->stored = 'ciyashop_sidebars';
			$this->title  = __( 'Custom Widget Area', 'ciyashop' );
			add_action( 'load-widgets.php', array( &$this, 'ciyashop_load_files' ), 5 );
			add_action( 'widgets_admin_page', array( &$this, 'ciyashop_widgets_sidebar_form' ), 5 );
			add_action( 'widgets_init', array( $this, 'ciyashop_register_custom_sidebars' ), 9999 );
			add_action( 'wp_ajax_ciyashop_delete_sidebar_area', array( $this, 'ciyashop_delete_sidebar_area' ), 1000 );
			add_action( 'wp_ajax_nopriv_ciyashop_delete_sidebar_area', array( $this, 'ciyashop_delete_sidebar_area' ), 1000 );
		}

		function ciyashop_load_files() {
			add_action( 'load-widgets.php', array( $this, 'ciyashop_add_sidebar_area' ), 100 );
			$currentScreen = get_current_screen();
			if ( is_object( $currentScreen ) && 'widgets' === $currentScreen->id ) {
				wp_enqueue_script( 'ciyashop_sidebar', get_template_directory_uri() . '/js/custom_sidebar.min.js' );
				wp_localize_script(
					'ciyashop_sidebar',
					'ciyashop_sidebar_strings',
					array(
						'delete_sidebar_msg'     => __( 'You cannot delete this sidebar. This sidebar is already in use.', 'ciyashop' ),
						'delete_sidebar_confirm' => __( 'Are you sure you want to delete sidebar?', 'ciyashop' ),
					)
				);
			}
		}

		function ciyashop_widgets_sidebar_form() {
			?>
			<div id="ciyashop-widgets-form-cover">
				<h2><?php _e( 'Custom Sidebar Widget', 'ciyashop' ); ?></h2>
				<form method="post" action="widgets.php">
					<input type="text" name="ciyashop_sidebar_name" placeholder="<?php _e( 'Enter Sidebar Name', 'ciyashop' ); ?>" />
					<input type="submit" class="button button-primary" name="create_ciyashop_sidebar" value="<?php _e( 'Create', 'ciyashop' ); ?>" />
				</form>
			</div>
			<?php
		}

		function ciyashop_add_sidebar_area() {
			if ( isset( $_POST['create_ciyashop_sidebar'] ) && isset( $_POST['ciyashop_sidebar_name'] ) && ! empty( $_POST['ciyashop_sidebar_name'] ) ) {
				$this->sidebars = get_option( $this->stored );
				$name           = $this->ciyashop_get_sidebar_name( $_POST['ciyashop_sidebar_name'] );
				if ( empty( $this->sidebars['name'] ) ) {
					$this->sidebars[] = array(
						'name' => $name,
					);
				} else {
					$this->sidebars[] = array_merge( $this->sidebars, array( 'name' => $name ) );
				}
				update_option( $this->stored, $this->sidebars );
				unset( $_POST['create_ciyashop_sidebar'] );
				unset( $_POST['ciyashop_sidebar_name'] );
				wp_redirect( get_admin_url() . 'widgets.php' );
				die();
			}
		}

		//delete sidebar area from the db
		function ciyashop_delete_sidebar_area() {

			function search_value( $id, $array, $field ) {
				foreach ( $array as $key => $val ) {
					if ( $val[ $field ] === $id ) {
						return $key;
					}
				}
				return -1;
			}

			if ( ! empty( $_POST['widget_id'] ) ) {
				global $wpdb;
				$result          = true;
				$widget_id       = stripslashes( $_POST['widget_id'] ); //Check whether sidebar is used in existing page
				$existExistQuery = 'SELECT meta_value FROM ' . $wpdb->postmeta . " WHERE meta_key='pgs_custom_sidebar'";
				$queryResult     = $wpdb->get_results( $existExistQuery, ARRAY_A );
				$this->sidebars  = get_option( $this->stored );

				if ( $queryResult ) {
					$key = search_value( $widget_id, $queryResult, 'meta_value' );
					if ( -1 == $key ) {
						$key = search_value( $widget_id, $this->sidebars, 'id' );
						if ( -1 !== $key ) {
							unset( $this->sidebars[ $key ] );
							update_option( $this->stored, $this->sidebars );
							$result = true;
						} else {
							$result = false;
						}
					} else {
						$result = false;
					}
				} else {
					$this->sidebars = get_option( $this->stored );
					$key            = search_value( $widget_id, $this->sidebars, 'id' );
					if ( false !== $key ) {
						unset( $this->sidebars[ $key ] );
						update_option( $this->stored, $this->sidebars );
						$result = true;
					}
				};

				echo json_encode( array( 'result' => $result ) );
			}
			die();
		}

		//checks the user submitted name and makes sure that there are no colitions
		function ciyashop_get_sidebar_name( $name ) {
			if ( empty( $GLOBALS['wp_registered_sidebars'] ) ) {
				return $name;
			}
			$taken = array();
			foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
				$taken[] = $sidebar['name'];
			}
			if ( empty( $this->sidebars ) ) {
				$this->sidebars = array();
			}
			$taken = array_merge( $taken, $this->sidebars );
			if ( in_array( $name, $taken ) ) {
				$counter  = substr( $name, -1 );
				$new_name = '';
				if ( ! is_numeric( $counter ) ) {
					$new_name = $name . ' 1';
				} else {
					$new_name = substr( $name, 0, -1 ) . ( (int) $counter + 1 );
				}
				$name = $this->ciyashop_get_sidebar_name( $new_name );
			}
			return $name;
		}

		//register custom sidebar areas
		function ciyashop_register_custom_sidebars() {
			if ( empty( $this->sidebars ) ) {
				$this->sidebars = get_option( $this->stored );
			}

			$args = array(
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			);
			/**
			 * Filters arguments for custom widgets.
			 *
			 * @param array    $args      Array of widget parameters.
			 *
			 * @visible true
			 */
			$args = apply_filters( 'ciyashop_custom_widget_args', $args );
			if ( is_array( $this->sidebars ) ) {
				$sidebar_details = array();
				$count           = 0;
				foreach ( $this->sidebars as $sidebar ) {
					$count++;
					$args['name']      = $sidebar['name'];
					$args['id']        = 'pgs-cs-' . $count;
					$args['class']     = 'ciyashop-custom';
					$sidebar_details[] = array(
						'id'   => $args['id'],
						'name' => $args['name'],
					);
					register_sidebar( $args );
				}
				update_option( $this->stored, $sidebar_details );
			}
		}
	}
}

new CiyaShopCustomSidebar();



