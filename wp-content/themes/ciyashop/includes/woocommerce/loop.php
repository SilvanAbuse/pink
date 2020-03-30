<?php
add_action( 'woocommerce_before_single_product', 'ciyashop_woocommerce_init_loop' );
function ciyashop_woocommerce_init_loop() {
	global $ciyashop_options;
}

/********************************************************************
 *
 * Products Loop Customization
 *
 ********************************************************************/
function ciyashop_products_loop_classes( $classes = array() ) {
	global $ciyashop_options;

	if ( ! empty( $classes ) && ! is_array( $classes ) ) {
		$classes = explode( ' ', $classes );
	}

	$classes[] = 'products-loop';
	$classes[] = 'row';

	if ( is_product() ) {
		$classes[] = 'owl-carousel';
	} else {
		$column        = ciyashop_loop_columns();
		$gridlist_view = isset( $_COOKIE['gridlist_view'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['gridlist_view'] ) ) : 'products-loop-column-' . $column;

		if ( is_shop() || is_product_category() || is_product_tag() ) {
			if ( 'list' != $gridlist_view ) {
				$classes[] = 'grid';
			}

			if ( isset( $ciyashop_options['product_pagination'] ) && 'infinite_scroll' == $ciyashop_options['product_pagination'] ) {
				$classes[] = 'product-infinite_scroll';
			}

			$classes[] = $gridlist_view;
		}
	}

	if ( isset( $ciyashop_options['products_columns_mobile'] ) ) {
		$xs_columns = (int) $ciyashop_options['products_columns_mobile'];
	} else {
		$xs_columns = 1;
	}
	$classes[] = 'ciyashop-products-shortcode';
	$classes[] = 'mobile-col-' . $xs_columns;

	if ( is_cart() ) {
		$classes[] = 'owl-carousel';
	}

	$classes = apply_filters( 'ciyashop_products_loop_classes', $classes );
	$classes = ciyashop_class_builder( $classes );

	return $classes;
}

/********************************************************************
 *
 * Inner div for standard quick shop hover style
 *
 ********************************************************************/

add_filter( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_inner_start', 13 );
function ciyashop_woocommerce_shop_loop_item_inner_start() {
	global $ciyashop_options;
	if ( isset( $ciyashop_options['product_hover_style'] ) && 'standard-quick-shop' == $ciyashop_options['product_hover_style'] ) {
		?>
		<div class="ciyashop-product-variations-wrapper-inner"> 
		<?php
	}
}

add_filter( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_inner_end', 41 );
function ciyashop_woocommerce_shop_loop_item_inner_end() {
	global $ciyashop_options;
	if ( isset( $ciyashop_options['product_hover_style'] ) && 'standard-quick-shop' == $ciyashop_options['product_hover_style'] ) {
		?>
	</div> 
		<?php
	}
}

/********************************************************************
 *
 * Add product category title
 *
 ********************************************************************/
add_filter( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_category', 13 );
function ciyashop_woocommerce_shop_loop_item_category() {
	global $product, $ciyashop_options;
	$product_cats = get_the_terms( $product->get_id(), 'product_cat' );

	if ( ( $product_cats && ! is_wp_error( $product_cats ) ) && ( 'minimal-hover-cart' != $ciyashop_options['product_hover_style'] ) ) {

		// convert objects to array
		$product_cats_new = json_encode( $product_cats );
		$product_cats_new = json_decode( $product_cats_new, true );

		$product_cats_ids = array_column( $product_cats_new, 'term_id' );

		// Category Index
		$cat_index = 0;

		if ( defined( 'WPSEO_FILE' ) ) {
			$primary_cat_id = get_post_meta( $product->get_id(), '_yoast_wpseo_primary_product_cat', true );
			if ( ! empty( $primary_cat_id ) && in_array( $primary_cat_id, $product_cats_ids ) ) {
				$cat_index = array_search( $primary_cat_id, $product_cats_ids );
			}
		}
		?>
		<span class="ciyashop-product-category">
			<a href="<?php echo esc_url( get_term_link( $product_cats[ $cat_index ]->term_id ), 'product_cat' ); ?>">
				<?php echo esc_html( $product_cats[ $cat_index ]->name ); ?>
			</a>
		</span><!-- .product-category-name-->
		<?php
	}
}

/********************************************************************
 *
 * Set Product List Elements
 *
 ********************************************************************/

/********************************************************************
* Remove Default List Elements
********************************************************************/

// Remove Default Title Display
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// Remove Woocommerce Rating For Change Position
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Remove woocommerce price for change position
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/********************************************************************
* Add Product List Elements
********************************************************************/
add_action( 'ciyashop_before_page_wrapper', 'ciyashop_set_product_list_elements', 40 );
function ciyashop_set_product_list_elements() {
	global $ciyashop_options, $cs_product_list_styles;

	/********************************************************************
	 *
	 * Add link to product title
	 *
	 ********************************************************************/
	if ( 'minimal-hover-cart' == $ciyashop_options['product_hover_style'] ) {
		add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_title', 20 );
	} else {
		add_filter( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_title', 15 );
	}

	/********************************************************************
	 *
	 * Add woocommerce rating to new position
	 *
	 ********************************************************************/

	if ( in_array( $ciyashop_options['product_hover_style'], array( $cs_product_list_styles['icons-bottom-bar'], $cs_product_list_styles['info-bottom'], $cs_product_list_styles['info-bottom-bar'] ) ) ) {
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_wc_shop_loop_item_rating', 12 );
	} else {
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_wc_shop_loop_item_rating', 30 );
	}

	/********************************************************************
	 *
	 * Add woocommerce price to new position
	 *
	 ********************************************************************/

	if ( 'standard-info-transparent' == $ciyashop_options['product_hover_style'] ) {
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 27 );
	} elseif ( 'hover-summary' == $ciyashop_options['product_hover_style'] ) {
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 32 );
	} else {
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 20 );
	}

	/********************************************************************
	 *
	 * Add new div for standard-info-transparent style
	 *
	 ********************************************************************/

	if ( 'standard-info-transparent' == $ciyashop_options['product_hover_style'] ) {

		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_open_standard_info_container', 25 ); // open div
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_add_product_variation', 32 ); // add variation
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_close_standard_info_container', 35 ); // close div
	}

	if ( 'standard-quick-shop' == $ciyashop_options['product_hover_style'] ) {
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_product_actions_add_variation_product_view', 10 ); // add variation
	} else {
		add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_actions_add_variation_product_view', 27 );
	}
}


/********************************************************************
* Callback Functions For Product List Elements Actions
********************************************************************/

/* Callback Function For Product Title Link Action */
function ciyashop_woocommerce_shop_loop_item_title() {
	global $product;
	?>
	<h3 class="product-name">
		<a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
			<?php echo esc_html( get_the_title( get_the_ID() ) ); ?>
		</a>
	</h3><!-- .product-name-->
	<?php
}

/* Callback Function For Product Woocommerce Ratings */
function ciyashop_wc_shop_loop_item_rating() {
	global $product;
	$rating_count = $product->get_rating_count();

	if ( $rating_count <= 0 ) {
		return;
	}
	?>
	<div class="star-rating-wrapper">
		<?php

		/**
		 * Hook: ciyashop_loop_item_rating.
		 *
		 * @hooked woocommerce_template_loop_rating - 10
		 *
		 * @visible true
		 */
		do_action( 'ciyashop_loop_item_rating' );
		?>
	</div><!-- .star-rating-wrapper -->
	<?php
}
add_action( 'ciyashop_loop_item_rating', 'woocommerce_template_loop_rating' );


/* Callback Functions For Product Woocommerce Standard-Info-Transparent List Style */
function ciyashop_open_standard_info_container() {
	?>
	<div class="standard-info">
	<?php
}
function ciyashop_close_standard_info_container() {
	?>
	</div><!-- .standard-info -->
	<?php
}
function ciyashop_add_product_variation() {
	if ( ! is_product() ) {
		echo ciyashop_attr_variation_list();
	}
}

/********************************************************************
 *
 * Add Product Description
 *
 ********************************************************************/

/********************************************************************
 *
 * For List View
 *
 ********************************************************************/
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5 );

// For Grid View
add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_woocommerce_shop_loop_item_description', 40 );
function ciyashop_woocommerce_shop_loop_item_description() {
	global $product, $ciyashop_options;

	if ( isset( $ciyashop_options['product_hover_style'] ) && 'hover-summary' != $ciyashop_options['product_hover_style'] ) {
		return;
	}

	if ( isset( $ciyashop_options['product_hover_style'] ) && 'yes' == $ciyashop_options['show_product_desc'] ) {
		?>
	<!--  Product List product description div starts -->
	<div class="ciyashop-product-description">
		<div class="ciyashop-description-inner">
		<?php echo ( 'product_contents' == $ciyashop_options['product_desc_source'] ) ? $product->get_description() : $product->get_short_description(); ?>
		</div>
	</div><!-- .product-description-->
		<?php
	}
}

/********************************************************************
 *
 * Remove product link default callback
 *
 ********************************************************************/
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/********************************************************************
 *
 * Extra wrappers to product loop.
 *
 ********************************************************************/
add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_add_innerdiv_start', 5 );                // .product-inner opening
add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_add_innerdiv_end', 20 );                   // .product-inner closing

add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_start', 6 );           // .product-thumbnail opening
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_end', 30 );      // .product-thumbnail closing

add_action( 'woocommerce_before_shop_loop_item', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_start', 7 );     // .product-thumbnail-inner opening
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_end', 12 );// .product-thumbnail-inner closing

add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_wc_before_shop_loop_item_title_product_info_open', 9 );            // .product-info opening
add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_woocommerce_after_shop_loop_item_product_info_close', 18 );         // .product-info closing

function ciyashop_wc_before_shop_loop_item_add_innerdiv_start() {
	?>
	<div class="product-inner">
	<?php
}
function ciyashop_wc_before_shop_loop_item_add_innerdiv_end() {
	?>
	</div><!-- .product-inner -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_start() {
	global $ciyashop_options;
	if ( 'hover-summary' == $ciyashop_options['product_hover_style'] ) {
		?>
		<!--  This will be used for "Summary" grid style only -->
		<div class="content-hover-block"></div>
		<?php
	}
	?>
	<div class="product-thumbnail">
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_end() {
	?>
	</div><!-- .product-thumbnail -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_start() {
	?>
	<div class="product-thumbnail-inner">
		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
			<div class="product-thumbnail-main">
			<?php
}

function ciyashop_wc_before_shop_loop_item_product_thumbnail_inner_end() {
	?>
		</div>
		<?php
			global $ciyashop_options;
			$attachment_image = ciyashop_get_swap_image();
		if ( isset( $ciyashop_options['product_image_swap'] ) && 1 == $ciyashop_options['product_image_swap'] && ! empty( $attachment_image ) ) {
			echo '<div class="product-thumbnail-swap">';
				echo $attachment_image; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}
		?>
		</a>
	</div><!-- .product-thumbnail-inner -->
	<?php
}

function ciyashop_wc_before_shop_loop_item_title_product_info_open() {
	?>
	<div class="product-info">
	<?php
}

function ciyashop_woocommerce_after_shop_loop_item_product_info_close() {
	?>
	</div><!-- .product-info -->
	<?php
}

/********************************************************************
 *
 * Apply filter on woocommerce before loop item title
 *
 ********************************************************************/
add_action( 'woocommerce_shortcode_before_featured_products_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_shortcode_before_product_category_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_shortcode_before_sale_products_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_shortcode_before_products_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_before_shop_loop', 'ciyashop_shop_loop_item_hover_style_init' );
add_action( 'woocommerce_after_single_product_summary', 'ciyashop_shop_loop_item_hover_style_init', 0 );
add_action( 'dokan_store_profile_frame_after', 'ciyashop_shop_loop_item_hover_style_init' );

function ciyashop_shop_loop_item_hover_style_init( $template_name ) {

	global $ciyashop_options;

	$product_hover_style = ciyashop_product_hover_style();

	if ( in_array( $product_hover_style, array( 'default', 'icon-top-left', 'icons-top-right', 'image-center', 'image-icon-left', 'image-icon-bottom', 'icons-bottom-right', 'image-left', 'button-standard', 'icons-left', 'icons-rounded', 'image-bottom', 'image-bottom-bar', 'image-bottom-2', 'icons-transparent-center', 'standard-info-transparent', 'standard-quick-shop', 'hover-summary' ) ) ) {
		add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_actions', 25 );
	} elseif ( in_array( $product_hover_style, array( 'info-bottom', 'info-bottom-bar' ) ) ) {
		add_action( 'woocommerce_after_shop_loop_item', 'ciyashop_product_actions', 19 );
	} elseif ( in_array( $product_hover_style, array( 'info-transparent-center' ) ) ) {
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_product_actions', 12 );
	} elseif ( in_array( $product_hover_style, array( 'minimal-hover-cart', 'minimal' ) ) ) {
		add_action( 'woocommerce_shop_loop_item_title', 'ciyashop_product_actions', 18 );
	}

	// Show Hide Sale
	add_filter( 'woocommerce_sale_flash', 'ciyashop_sale_flash_label', 10, 3 );

	// Show Hide Featured
	add_filter( 'ciyashop_featured', 'ciyashop_featured_label', 10, 3 );

	add_filter( 'post_class', 'ciyashop_product_classes' );
}

function ciyashop_product_actions() {
	/**
	 * Hook: ciyashop_before_product_actions.
	 *
	 * @hooked ciyashop_product_actions_wrapper_open - 10
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_before_product_actions' );

	/**
	 * Hook: ciyashop_product_actions.
	 *
	 * @hooked woocommerce_template_loop_add_to_cart      - 10
	 * @hooked ciyashop_product_actions_add_wishlist_link - 20
	 * @hooked add_compare_link                           - 30
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_product_actions' );

	/**
	 * Hook: ciyashop_after_product_actions.
	 *
	 * @hooked ciyashop_product_actions_wrapper_close - 10
	 *
	 * @visible true
	 */
	do_action( 'ciyashop_after_product_actions' );
}

add_action( 'ciyashop_before_product_actions', 'ciyashop_product_actions_wrapper_open' );
function ciyashop_product_actions_wrapper_open() {
	?>
	<div class="product-actions">
		<div class="product-actions-inner">
		<?php
}

add_action( 'ciyashop_after_product_actions', 'ciyashop_product_actions_wrapper_close' );
function ciyashop_product_actions_wrapper_close() {
	?>
		</div>
	</div>
	<?php
}

/********************************************************************
 *
 * Add product style class
 *
 ********************************************************************/
function ciyashop_product_classes( $classes ) {
	global $post, $ciyashop_options;

	// Set Product Hover Style Class
	$product_hover_style = ciyashop_product_hover_style();
	$classes[]           = 'product-hover-style-' . $product_hover_style;

	// Set Product Hover Button Shape Class
	if ( in_array( $product_hover_style, array( 'image-center', 'image-icon-left', 'image-icon-bottom', 'image-left', 'image-bottom', 'info-bottom', 'image-bottom-2' ) ) ) {
		$product_hover_button_shape = ciyashop_product_hover_button_shape();
		$classes[]                  = 'product-hover-button-shape-' . $product_hover_button_shape;
	}

	// Set Product Hover Button Style Class
	if ( in_array( $product_hover_style, array( 'image-center', 'image-icon-left', 'image-left', 'image-icon-bottom', 'image-bottom' ) ) ) {
		$product_hover_button_style = ciyashop_product_hover_button_style();
		$classes[]                  = 'product-hover-button-style-' . $product_hover_button_style;
	}

	// Set Product Hover style class for default style
	if ( in_array( $product_hover_style, array( 'default', 'icon-top-left', 'icons-top-right', 'image-left', 'button-standard', 'icons-left', 'icons-rounded', 'icons-bottom-right', 'hover-summary', 'minimal-hover-cart', 'minimal', 'standard-info-transparent', 'standard-quick-shop', 'image-bottom-2' ) ) ) {
		$product_hover_default_button_style = ciyashop_product_hover_default_button_style();
		$classes[]                          = 'product-hover-button-style-' . $product_hover_default_button_style;
	}

	// Set Product Hover Bar Style Class
	if ( in_array( $product_hover_style, array( 'image-bottom-bar', 'info-bottom-bar' ) ) ) {
		$product_hover_bar_style = ciyashop_product_hover_bar_style();
		$classes[]               = 'product-hover-bar-style-' . $product_hover_bar_style;
	}

	// Set Product Hover Bar Style Class
	if ( in_array( $product_hover_style, array( 'image-bottom-bar', 'info-bottom', 'info-bottom-bar' ) ) ) {
		$product_hover_add_to_cart_position = ciyashop_product_hover_add_to_cart_position();
		$classes[]                          = 'product-hover-act-position-' . $product_hover_add_to_cart_position;
	}

	// Product Title length
	if ( isset( $ciyashop_options['product_title_length'] ) && ! empty( $ciyashop_options['product_title_length'] ) ) {
		$classes[] = 'product_title_type-' . $ciyashop_options['product_title_length'];
	}

	$icon_type = isset( $ciyashop_options['product_hover_icon_type'] ) && ! empty( $ciyashop_options['product_hover_icon_type'] ) ? $ciyashop_options['product_hover_icon_type'] : 'fill-icon';

	$classes[] = 'product_icon_type-' . $icon_type;

	$classes = apply_filters( 'ciyashop_product_classes', $classes, $post );

	return $classes;
}

/********************************************************************
 *
 * Out of Stock
 *
 ********************************************************************/
if ( ! function_exists( 'ciyashop_product_availability' ) ) {
	function ciyashop_product_availability() {
		global $ciyashop_options;
		global $product;
		$availibility = $product->get_availability();
		if ( ( is_shop() && ! $ciyashop_options['product-out-of-stock-icon'] ) && ( is_shop() && ! $ciyashop_options['product-in-stock-icon'] ) ) {
			return;
		}

		if ( is_shop() || ! $product->is_in_stock() ) {
			if ( $ciyashop_options['product-out-of-stock-icon'] ) {
				if ( ! $product->is_in_stock() ) {
					echo wc_get_stock_html( $product );
				}
			}
			if ( $ciyashop_options['product-in-stock-icon'] ) {
				if ( $product->is_in_stock() ) {
					echo wc_get_stock_html( $product );
				}
			}
		}

	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'ciyashop_product_availability', 10 );
add_action( 'ciyashop_before_product_actions', 'ciyashop_product_availability', 5 );

/********************************************************************
 *
 * Catalog Mode
 *
 ********************************************************************/
add_action( 'wp_head', 'ciyashop_woocommerce_catalog_mode' );
function ciyashop_woocommerce_catalog_mode() {

	if ( class_exists( 'WooCommerce' ) ) {
		global $ciyashop_options;

		if ( isset( $ciyashop_options['woocommerce_catalog_mode'] ) && 1 == $ciyashop_options['woocommerce_catalog_mode'] ) {
			remove_action( 'ciyashop_product_actions', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			remove_action( 'woocommerce_single_product_summary', 'ciyashop_product_sticky_content', 31 );
			remove_action( 'ciyashop_before_page_wrapper', 'ciyashop_wc_set_add_to_cart_element', 20 );
			remove_action( 'ciyashop_header_wootools', 'ciyashop_header_wootools_cart', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'ciyashop_sticky_header_wootools', 'ciyashop_sticky_header_wootools_cart', 10 );
			add_filter( 'yith_wcwl_wishlist_params', 'ciyashop_wishlist_catalog_mode_cart_hide', 10, 5 );
			add_filter( 'woocommerce_is_purchasable', '__return_false' );
		}
	}
}

if ( ! function_exists( 'ciyashop_wishlist_catalog_mode_cart_hide' ) ) {
	function ciyashop_wishlist_catalog_mode_cart_hide( $additional_params, $action, $action_params, $pagination, $per_page ) {

		// Hide add to cart for wishlist
		$additional_params['show_add_to_cart'] = false;
		return $additional_params;
	}
}

/********************************************************************
 *
 * Catalog Mode On Redirect to shop page
 *
 ********************************************************************/
add_action( 'template_redirect', 'ciyashop_woocommerce_catalog_mode_redirection' );
function ciyashop_woocommerce_catalog_mode_redirection() {
	if ( class_exists( 'WooCommerce' ) ) {
		global $ciyashop_options;
		if ( ( isset( $ciyashop_options['woocommerce_catalog_mode'] ) && 1 == $ciyashop_options['woocommerce_catalog_mode'] ) || isset( $ciyashop_options['hide_price_for_guest_user'] ) && $ciyashop_options['hide_price_for_guest_user'] && ! is_user_logged_in() ) {
			if ( is_cart() || is_checkout() ) {
				wp_safe_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
			}
		}
	}
}

/* * ******************************************************************
 *
 * Hide Price
 *
 * ****************************************************************** */
add_filter( 'woocommerce_get_price_html', 'ciyashop_hide_price', 99, 2 );
if ( ! function_exists( 'ciyashop_hide_price' ) ) {
	function ciyashop_hide_price( $price, $product ) {
		global $ciyashop_options;
		if ( isset( $ciyashop_options['woocommerce_catalog_mode'] ) && 1 == $ciyashop_options['woocommerce_catalog_mode'] ) {
			if ( isset( $ciyashop_options['woocommerce_price_hide'] ) && 1 == $ciyashop_options['woocommerce_price_hide'] ) {
				$price = '';
			}
		}
		return $price;
	}
}

// Set products per page.
add_filter( 'loop_shop_per_page', 'ciyashop_woocommerce_loop_shop_per_page' );
function ciyashop_woocommerce_loop_shop_per_page( $posts_per_page ) {
	global $ciyashop_options;
	if ( isset( $ciyashop_options['products_per_page'] ) && '' != $ciyashop_options['products_per_page'] ) {
		$posts_per_page = $ciyashop_options['products_per_page'];
	}
	return $posts_per_page;
}

/********************************************************************
 *
 * Others
 *
 ********************************************************************/
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5 );


/**
 * Change the placeholder image
 */
add_filter( 'woocommerce_placeholder_img_src', 'ciyashop_custom_woocommerce_placeholder_img_src' );
function ciyashop_custom_woocommerce_placeholder_img_src( $src ) {
	$src               = get_parent_theme_file_uri( '/images/product-placeholder.jpg' );
	$placeholder_image = get_option( 'woocommerce_placeholder_image', 0 );

	if ( ! empty( $placeholder_image ) && ! wp_attachment_is_image( $placeholder_image ) ) {
		$src = $placeholder_image;
	} elseif ( ! empty( $placeholder_image ) && wp_attachment_is_image( $placeholder_image ) ) {
		$size  = ( is_product() || ( isset( $_REQUEST['action'] ) && 'ciyashop_quick_view' === $_REQUEST['action'] ) ) ? 'woocommerce_single' : 'woocommerce_thumbnail';
		$image = wp_get_attachment_image_src( $placeholder_image, $size );
		if ( ! empty( $image[0] ) ) {
			$src = $image[0];
		}
	}

	return $src;
}
