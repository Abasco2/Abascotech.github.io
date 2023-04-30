<?php
/**
 *
 * The framework's functions and definitions
 */

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'BASEL_THEME_DIR', get_template_directory_uri() );
define( 'BASEL_THEMEROOT', get_template_directory() );
define( 'BASEL_IMAGES', BASEL_THEME_DIR . '/images' );
define( 'BASEL_SCRIPTS', BASEL_THEME_DIR . '/js' );
define( 'BASEL_STYLES', BASEL_THEME_DIR . '/css' );
define( 'BASEL_FRAMEWORK', BASEL_THEMEROOT . '/inc' );
define( 'BASEL_DUMMY', BASEL_THEME_DIR . '/inc/dummy-content' );
define( 'BASEL_CLASSES', BASEL_THEMEROOT . '/inc/classes' );
define( 'BASEL_CONFIGS', BASEL_THEMEROOT . '/inc/configs' );
define( 'BASEL_3D', BASEL_FRAMEWORK . '/third-party' );
define( 'BASEL_ASSETS', BASEL_THEME_DIR . '/inc/assets' );
define( 'BASEL_ASSETS_IMAGES', BASEL_ASSETS . '/images' );
define( 'BASEL_API_URL', 'https://xtemos.com/licenses/api/' );
define( 'BASEL_DEMO_URL', 'https://demo.xtemos.com/basel/' );
define( 'BASEL_PLUGINS_URL', 'https://woodmart.xtemos.com/plugins/' );
define( 'BASEL_DUMMY_URL', BASEL_DEMO_URL . 'dummy-content/' );
define( 'BASEL_SLUG', 'basel' );
define( 'BASEL_POST_TYPE_VERSION', '1.14' );

/**
 * ------------------------------------------------------------------------------------------------
 * Load all CORE Classes and files
 * ------------------------------------------------------------------------------------------------
 */
require_once apply_filters( 'basel_require', BASEL_FRAMEWORK . '/autoload.php' );

$basel_theme = new BASEL_Theme();

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue styles
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_enqueue_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'basel_enqueue_styles', 10000 );

	function basel_enqueue_styles() {
		$version = basel_get_theme_info( 'Version' );
		$is_rtl  = is_rtl() ? '-rtl' : '';

		if ( basel_get_opt( 'minified_css' ) ) {
			$main_css_url = get_template_directory_uri() . '/style.min.css';
		} else {
			$main_css_url = get_stylesheet_uri();
		}

		if ( ! basel_get_opt( 'combined_css', false ) ) {
			$main_css_url = get_template_directory_uri() . '/css/parts/base' . $is_rtl . '.min.css';
		}

		wp_dequeue_style( 'yith-wcwl-font-awesome' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css-theme' );
		if ( basel_get_opt( 'light_bootstrap_version' ) ) {
			wp_enqueue_style( 'bootstrap', BASEL_STYLES . '/bootstrap-light' . $is_rtl . '.min.css', array(), $version );
		} else {
			wp_enqueue_style( 'bootstrap', BASEL_STYLES . '/bootstrap' . $is_rtl . '.min.css', array(), $version );
		}

		if ( basel_get_opt( 'wpb_optimized_css' ) ) {
			wp_deregister_style( 'js_composer_front' );
			wp_dequeue_style( 'js_composer_front' );

			wp_enqueue_style( 'js_composer_front', BASEL_STYLES . '/wpb-optimized.min.css', array(), $version );
		}

		wp_enqueue_style( 'basel-style', $main_css_url, array( 'bootstrap' ), $version );
		wp_enqueue_style( 'js_composer_front', false, array(), $version );

		if ( basel_get_opt( 'disable_gutenberg_css' ) ) {
			wp_deregister_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library' );

			wp_deregister_style( 'wc-block-style' );
			wp_dequeue_style( 'wc-block-style' );
		}

		wp_enqueue_style( 'vc_font_awesome_5' );
		wp_enqueue_style( 'vc_font_awesome_5_shims' );

		wp_deregister_style( 'contact-form-7' );
		wp_dequeue_style( 'contact-form-7' );
		wp_deregister_style( 'contact-form-7-rtl' );
		wp_dequeue_style( 'contact-form-7-rtl' );

		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

		// load typekit fonts
		$typekit_id = basel_get_opt( 'typekit_id' );

		if ( $typekit_id ) {
			wp_enqueue_style( 'basel-typekit', 'https://use.typekit.net/' . esc_attr( $typekit_id ) . '.css', array(), $version );
		}

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue scripts
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_enqueue_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'basel_enqueue_scripts', 10000 );

	function basel_enqueue_scripts() {

		$version = basel_get_theme_info( 'Version' );

		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), $version );
		}

		wp_register_script( 'maplace', basel_get_script_url( 'maplace-0.1.3' ), array( 'jquery', 'google.map.api' ), $version, true );

		if ( ! basel_woocommerce_installed() ) {
			wp_register_script( 'js-cookie', basel_get_script_url( 'js.cookie' ), array( 'jquery' ), $version, true );
		}

		wp_enqueue_script( 'basel_html5shiv', basel_get_script_url( 'html5' ), array(), $version );
		wp_script_add_data( 'basel_html5shiv', 'conditional', 'lt IE 9' );

		wp_dequeue_script( 'flexslider' );
		wp_dequeue_script( 'photoswipe-ui-default' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_style( 'photoswipe-default-skin' );

		if ( basel_get_opt( 'image_action' ) != 'zoom' ) {
			wp_dequeue_script( 'zoom' );
		}

		wp_enqueue_script( 'isotope', basel_get_script_url( 'isotope.pkgd' ), array( 'jquery' ), $version, true );
		wp_enqueue_script( 'wpb_composer_front_js' );

		if ( basel_get_opt( 'combined_js' ) ) {
			wp_enqueue_script( 'basel-theme', basel_get_script_url( 'theme' ), array( 'jquery', 'js-cookie' ), $version, true );
		} else {
			wp_enqueue_script( 'basel-magnific-popup', basel_get_script_url( 'jquery.magnific-popup' ), array(), $version, true );
			wp_enqueue_script( 'basel-owl-carousel', basel_get_script_url( 'owl.carousel' ), array(), $version, true );
			wp_enqueue_script( 'basel-imagesloaded', basel_get_script_url( 'imagesloaded.pkgd' ), array(), $version, true );
			wp_enqueue_script( 'basel-pjax', basel_get_script_url( 'jquery.pjax' ), array(), $version, true );
			wp_enqueue_script( 'basel-packery', basel_get_script_url( 'packery-mode.pkgd' ), array(), $version, true );
			wp_enqueue_script( 'basel-autocomplete', basel_get_script_url( 'jquery.autocomplete' ), array(), $version, true );
			wp_enqueue_script( 'basel-device', basel_get_script_url( 'device' ), array( 'jquery' ), $version, true );
			wp_enqueue_script( 'basel-waypoints', basel_get_script_url( 'waypoints' ), array( 'jquery' ), $version, true );

			$minified = basel_get_opt( 'minified_js' ) ? '.min' : '';
			wp_enqueue_script( 'basel-functions', BASEL_SCRIPTS . '/functions' . $minified . '.js', array( 'jquery', 'js-cookie' ), $version, true );
		}

		// Add virations form scripts through the site to make it work on quick view
		if ( basel_get_opt( 'quick_view_variable' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation', false, array(), $version );
		}

		$translations = array(
			'photoswipe_close_on_scroll'        => apply_filters( 'basel_photoswipe_close_on_scroll', true ),
			'adding_to_cart'                    => esc_html__( 'Processing', 'basel' ),
			'added_to_cart'                     => esc_html__( 'Product was successfully added to your cart.', 'basel' ),
			'continue_shopping'                 => esc_html__( 'Continue shopping', 'basel' ),
			'view_cart'                         => esc_html__( 'View Cart', 'basel' ),
			'go_to_checkout'                    => esc_html__( 'Checkout', 'basel' ),
			'countdown_days'                    => esc_html__( 'days', 'basel' ),
			'countdown_hours'                   => esc_html__( 'hr', 'basel' ),
			'countdown_mins'                    => esc_html__( 'min', 'basel' ),
			'countdown_sec'                     => esc_html__( 'sc', 'basel' ),
			'loading'                           => esc_html__( 'Loading...', 'basel' ),
			'close'                             => esc_html__( 'Close (Esc)', 'basel' ),
			'share_fb'                          => esc_html__( 'Share on Facebook', 'basel' ),
			'pin_it'                            => esc_html__( 'Pin it', 'basel' ),
			'tweet'                             => esc_html__( 'Tweet', 'basel' ),
			'download_image'                    => esc_html__( 'Download image', 'basel' ),
			'wishlist'                          => ( class_exists( 'YITH_WCWL' ) ) ? 'yes' : 'no',
			'cart_url'                          => ( basel_woocommerce_installed() ) ? esc_url( wc_get_cart_url() ) : '',
			'ajaxurl'                           => admin_url( 'admin-ajax.php' ),
			'add_to_cart_action'                => ( basel_get_opt( 'add_to_cart_action' ) ) ? esc_js( basel_get_opt( 'add_to_cart_action' ) ) : 'widget',
			'categories_toggle'                 => ( basel_get_opt( 'categories_toggle' ) ) ? 'yes' : 'no',
			'enable_popup'                      => ( basel_get_opt( 'promo_popup' ) ) ? 'yes' : 'no',
			'popup_delay'                       => ( basel_get_opt( 'promo_timeout' ) ) ? (int) basel_get_opt( 'promo_timeout' ) : 1000,
			'popup_event'                       => basel_get_opt( 'popup_event' ),
			'popup_scroll'                      => ( basel_get_opt( 'popup_scroll' ) ) ? (int) basel_get_opt( 'popup_scroll' ) : 1000,
			'popup_pages'                       => ( basel_get_opt( 'popup_pages' ) ) ? (int) basel_get_opt( 'popup_pages' ) : 0,
			'promo_popup_hide_mobile'           => ( basel_get_opt( 'promo_popup_hide_mobile' ) ) ? 'yes' : 'no',
			'product_images_captions'           => ( basel_get_opt( 'product_images_captions' ) ) ? 'yes' : 'no',
			'all_results'                       => esc_html__( 'View all results', 'basel' ),
			'product_gallery'                   => basel_get_product_gallery_settings(),
			'zoom_enable'                       => ( basel_get_opt( 'image_action' ) == 'zoom' ) ? 'yes' : 'no',
			'ajax_scroll'                       => ( basel_get_opt( 'ajax_scroll' ) ) ? 'yes' : 'no',
			'ajax_scroll_class'                 => apply_filters( 'basel_ajax_scroll_class', '.main-page-wrapper' ),
			'ajax_scroll_offset'                => apply_filters( 'basel_ajax_scroll_offset', 100 ),
			'product_slider_auto_height'        => ( basel_get_opt( 'product_slider_auto_height' ) ) ? 'yes' : 'no',
			'product_slider_autoplay'           => apply_filters( 'basel_product_slider_autoplay', false ),
			'ajax_add_to_cart'                  => ( apply_filters( 'basel_ajax_add_to_cart', true ) ) ? basel_get_opt( 'single_ajax_add_to_cart' ) : false,
			'cookies_version'                   => ( basel_get_opt( 'cookies_version' ) ) ? (int) basel_get_opt( 'cookies_version' ) : 1,
			'header_banner_version'             => ( basel_get_opt( 'header_banner_version' ) ) ? (int) basel_get_opt( 'header_banner_version' ) : 1,
			'header_banner_close_btn'           => basel_get_opt( 'header_close_btn' ),
			'header_banner_enabled'             => basel_get_opt( 'header_banner' ),
			'promo_version'                     => ( basel_get_opt( 'promo_version' ) ) ? (int) basel_get_opt( 'promo_version' ) : 1,
			'pjax_timeout'                      => apply_filters( 'basel_pjax_timeout', 5000 ),
			'split_nav_fix'                     => apply_filters( 'basel_split_nav_fix', false ),
			'shop_filters_close'                => basel_get_opt( 'shop_filters_close' ) ? 'yes' : 'no',
			'sticky_desc_scroll'                => apply_filters( 'basel_sticky_desc_scroll', true ),
			'quickview_in_popup_fix'            => apply_filters( 'quickview_in_popup_fix', false ),
			'one_page_menu_offset'              => apply_filters( 'basel_one_page_menu_offset', 150 ),
			'is_multisite'                      => is_multisite(),
			'current_blog_id'                   => get_current_blog_id(),
			'swatches_scroll_top_desktop'       => basel_get_opt( 'swatches_scroll_top_desktop' ),
			'swatches_scroll_top_mobile'        => basel_get_opt( 'swatches_scroll_top_mobile' ),
			'lazy_loading_offset'               => basel_get_opt( 'lazy_loading_offset' ),
			'add_to_cart_action_timeout'        => basel_get_opt( 'add_to_cart_action_timeout' ) ? 'yes' : 'no',
			'add_to_cart_action_timeout_number' => basel_get_opt( 'add_to_cart_action_timeout_number' ),
			'single_product_variations_price'   => basel_get_opt( 'single_product_variations_price' ) ? 'yes' : 'no',
			'google_map_style_text'             => esc_html__( 'Custom style', 'basel' ),
			'comment_images_upload_size_text'             => sprintf( esc_html__( 'Some files are too large. Allowed file size is %s.', 'basel' ), size_format( basel_get_opt( 'single_product_comment_images_upload_size' ) * MB_IN_BYTES ) ), // phpcs:ignore
			'comment_images_count_text'                   => sprintf( esc_html__( 'You can upload up to %s images to your review.', 'basel' ), basel_get_opt( 'single_product_comment_images_count' ) ), // phpcs:ignore
			'comment_images_upload_mimes_text'            => sprintf( esc_html__( 'You are allowed to upload images only in %s formats.', 'basel' ), apply_filters( 'xts_comment_images_upload_mimes', 'png, jpeg' ) ), // phpcs:ignore
			'comment_images_added_count_text'             => esc_html__( 'Added %s image(s)', 'basel' ), // phpcs:ignore
			'comment_images_upload_size'        => basel_get_opt( 'single_product_comment_images_upload_size' ) * MB_IN_BYTES,
			'comment_images_count'              => basel_get_opt( 'single_product_comment_images_count' ),
			'comment_images_upload_mimes'       => apply_filters(
				'basel_comment_images_upload_mimes',
				array(
					'jpg|jpeg|jpe' => 'image/jpeg',
					'png'          => 'image/png',
				)
			),
			'home_url'                          => home_url( '/' ),
			'shop_url'                          => basel_woocommerce_installed() ? esc_url( wc_get_page_permalink( 'shop' ) ) : '',
			'cart_redirect_after_add'           => get_option( 'woocommerce_cart_redirect_after_add' ),
			'product_categories_placeholder'    => esc_html__( 'Select a category', 'woocommerce' ),
			'product_categories_no_results'     => esc_html__( 'No matches found', 'woocommerce' ),
			'cart_hash_key'                     => apply_filters( 'woocommerce_cart_hash_key', 'wc_cart_hash_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) . get_template() ) ),
			'fragment_name'                     => apply_filters( 'woocommerce_cart_fragment_name', 'wc_fragments_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) . get_template() ) ),
			'combined_css'                      => basel_get_opt( 'combined_css', false ) ? 'yes' : 'no',
			'load_more_button_page_url_opt'     => basel_get_opt( 'load_more_button_page_url', true ) ? 'yes' : 'no',
			'ajax_search_delay'                 => apply_filters( 'basel_ajax_search_delay', 300 ),
		);

		$basel_core = array(
			esc_html__( 'You are now logged in as <strong>%s</strong>', 'basel' ),
			esc_html__( 'Basel Slider', 'basel' ),
			esc_html__( 'Slide', 'basel' ),
			esc_html__( 'Slides', 'basel' ),
			esc_html__( 'Parent Item:', 'basel' ),
			esc_html__( 'All Items', 'basel' ),
			esc_html__( 'View Item', 'basel' ),
			esc_html__( 'Add New Item', 'basel' ),
			esc_html__( 'Add New', 'basel' ),
			esc_html__( 'Edit Item', 'basel' ),
			esc_html__( 'Update Item', 'basel' ),
			esc_html__( 'Search Item', 'basel' ),
			esc_html__( 'Not found', 'basel' ),
			esc_html__( 'Not found in Trash', 'basel' ),
			esc_html__( 'Sliders', 'basel' ),
			esc_html__( 'Slider', 'basel' ),
			esc_html__( 'Search Sliders', 'basel' ),
			esc_html__( 'Popular Sliders', 'basel' ),
			esc_html__( 'All Sliders', 'basel' ),
			esc_html__( 'Parent Slider', 'basel' ),
			esc_html__( 'Parent Slider', 'basel' ),
			esc_html__( 'Edit Slider', 'basel' ),
			esc_html__( 'Update Slider', 'basel' ),
			esc_html__( 'Add New Slider', 'basel' ),
			esc_html__( 'New Slide', 'basel' ),
			esc_html__( 'Add or remove Sliders', 'basel' ),
			esc_html__( 'Choose from most used sliders', 'basel' ),
			esc_html__( 'Title', 'basel' ),
			esc_html__( 'Date', 'basel' ),
			esc_html__( 'Size Guide', 'basel' ),
			esc_html__( 'Size Guides', 'basel' ),
			esc_html__( 'Add new', 'basel' ),
			esc_html__( 'Add new size guide', 'basel' ),
			esc_html__( 'New size guide', 'basel' ),
			esc_html__( 'Edit size guide', 'basel' ),
			esc_html__( 'View size guide', 'basel' ),
			esc_html__( 'All size guides', 'basel' ),
			esc_html__( 'Search size guides', 'basel' ),
			esc_html__( 'No size guides found.', 'basel' ),
			esc_html__( 'No size guides found in trash.', 'basel' ),
			esc_html__( 'Size guide to place in your products', 'basel' ),
			esc_html__( 'HTML Block', 'basel' ),
			esc_html__( 'HTML Blocks', 'basel' ),
			esc_html__( 'CMS Blocks for custom HTML to place in your pages', 'basel' ),
			esc_html__( 'Shortcode', 'basel' ),
			esc_html__( 'Sidebar', 'basel' ),
			esc_html__( 'Sidebars', 'basel' ),
			esc_html__( 'You can create additional custom sidebar and use them in Visual Composer', 'basel' ),
			esc_html__( 'Portfolio', 'basel' ),
			esc_html__( 'Project', 'basel' ),
			esc_html__( 'Projects', 'basel' ),
			esc_html__( 'portfolio', 'basel' ),
			esc_html__( 'Project Categories', 'basel' ),
			esc_html__( 'Project Category', 'basel' ),
			esc_html__( 'Search Categories', 'basel' ),
			esc_html__( 'Popular Project Categories', 'basel' ),
			esc_html__( 'All Project Categories', 'basel' ),
			esc_html__( 'Parent Category', 'basel' ),
			esc_html__( 'Parent Category', 'basel' ),
			esc_html__( 'Edit Category', 'basel' ),
			esc_html__( 'Update Category', 'basel' ),
			esc_html__( 'Add New Category', 'basel' ),
			esc_html__( 'New Category', 'basel' ),
			esc_html__( 'Add or remove Categories', 'basel' ),
			esc_html__( 'Choose from most used text-domain', 'basel' ),
			esc_html__( 'Category', 'basel' ),
			esc_html__( 'Categories', 'basel' ),
		);

		wp_localize_script( 'basel-functions', 'basel_settings', $translations );
		wp_localize_script( 'basel-theme', 'basel_settings', $translations );

		if ( ( is_home() || is_singular( 'post' ) || is_archive() ) && basel_get_opt( 'blog_design' ) == 'masonry' ) {
			// Load masonry script JS for blog
			wp_enqueue_script( 'masonry', false, array(), $version );
		}

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get google fonts URL
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_get_fonts_url' ) ) {
	function basel_get_fonts_url( $fonts ) {
		$font_url = '';

		$font_url = add_query_arg( 'family', urlencode( $fonts ), '//fonts.googleapis.com/css' );

		return $font_url;
	}
}

function basel_lazy_loading_init( $force_init = false ) {
	if ( ( ( ! basel_get_opt( 'lazy_loading' ) || is_admin() ) && ! $force_init ) ) {
		return;
	}

	// Used for product categories images for example.
	add_filter( 'basel_attachment', 'basel_lazy_attachment_replace', 10, 3 );

	// Used for instagram images.
	add_filter( 'basel_image', 'basel_lazy_image_standard', 10, 1 );

	// Used for avatar images.
	add_filter( 'get_avatar', 'basel_lazy_avatar_image', 10 );

	// Images generated by WPBakery functions
	add_filter( 'vc_wpb_getimagesize', 'basel_lazy_image', 10, 3 );

	// Products, blog, a lot of other standard WordPress images
	add_filter( 'wp_get_attachment_image_attributes', 'basel_lazy_attributes', 10, 3 );
}

add_action( 'init', 'basel_lazy_loading_init', 120 );

function basel_lazy_loading_deinit( $force_deinit = false ) {
	if ( basel_get_opt( 'lazy_loading' ) && ! $force_deinit ) {
		return;
	}

	remove_action( 'basel_attachment', 'basel_lazy_attachment_replace', 10, 3 );
	remove_action( 'get_avatar', 'basel_lazy_avatar_image', 10 );
	remove_action( 'basel_image', 'basel_lazy_image_standard', 10, 1 );
	remove_action( 'vc_wpb_getimagesize', 'basel_lazy_image', 10, 3 );
	remove_action( 'wp_get_attachment_image_attributes', 'basel_lazy_attributes', 10, 3 );
}

if ( ! function_exists( 'basel_lazy_loading_rss_deinit' ) ) {
	function basel_lazy_loading_rss_deinit() {
		if ( is_feed() ) {
			basel_lazy_loading_deinit( true );
		}
	}

	add_action( 'wp', 'basel_lazy_loading_rss_deinit', 10 );
}

if ( ! function_exists( 'basel_stop_lazy_loading_before_order_table' ) ) {
	/**
	 * Fix Woocommerce email with lazy load
	 */
	function basel_stop_lazy_loading_before_order_table() {
		basel_lazy_loading_deinit( true );
	}

	add_action( 'woocommerce_email_before_order_table', 'basel_stop_lazy_loading_before_order_table', 20 );
	add_action( 'woocommerce_email_header', 'basel_stop_lazy_loading_before_order_table', 20 );
}


if ( ! function_exists( 'basel_start_lazy_loading_before_order_table' ) ) {
	function basel_start_lazy_loading_before_order_table() {
		basel_lazy_loading_init( true );
	}

	add_action( 'woocommerce_email_after_order_table', 'basel_start_lazy_loading_before_order_table', 20 );
	add_action( 'woocommerce_email_footer', 'basel_start_lazy_loading_before_order_table', 20 );
}

if ( ! function_exists( 'basel_get_script_url' ) ) {
	function basel_get_script_url( $script_name ) {
		return BASEL_SCRIPTS . '/' . $script_name . '.min.js';
	}
}

if ( ! function_exists( 'basel_is_product_attribute_archive' ) ) {
	function basel_is_product_attribute_archive() {
		$queried_object = get_queried_object();
		if ( $queried_object && property_exists( $queried_object, 'taxonomy' ) ) {
			$taxonomy = $queried_object->taxonomy;
			return 'pa_' == substr( $taxonomy, 0, 3 );
		}
		return false;
	}
}

if ( ! function_exists( 'basel_zenqueue_inline_style' ) ) {
	/**
	 * Enqueue inline style by key.
	 *
	 * @param string $key File slug.
	 */
	function basel_enqueue_inline_style( $key ) {
		if ( function_exists( 'wc' ) && wc()->is_rest_api_request() ) {
			return;
		}

		BASEL_Registry()->pagecssfiles->enqueue_inline_style( $key );
	}
}

if ( ! function_exists( 'basel_force_enqueue_style' ) ) {
	/**
	 * Enqueue style by key.
	 *
	 * @param string $key File slug.
	 * @param bool   $ignore_combined Ignore combined.
	 */
	function basel_force_enqueue_style( $key, $ignore_combined = false ) {
		BASEL_Registry()->pagecssfiles->enqueue_style( $key, $ignore_combined );
	}
}

if ( ! function_exists( 'basel_force_enqueue_styles' ) ) {
	/**
	 * Force enqueue styles.
	 */
	function basel_force_enqueue_styles() {
		$styles_always = basel_get_opt( 'styles_always_use' );
		if ( is_array( $styles_always ) ) {
			foreach ( $styles_always as $style ) {
				basel_force_enqueue_style( $style );
			}
		}

		if ( is_singular( 'post' ) || basel_is_blog_archive() ) {
			basel_force_enqueue_style( 'blog-general' );
		}

		if ( is_singular( 'portfolio' ) || basel_is_portfolio_archive() ) {
			basel_force_enqueue_style( 'portfolio-general' );
		}

		if ( is_active_widget( 0, 0, 'calendar' ) ) {
			basel_force_enqueue_style( 'widget-calendar' );
		}

		if ( is_active_widget( 0, 0, 'rss' ) ) {
			basel_force_enqueue_style( 'widget-rss' );
		}

		if ( ! basel_get_opt( 'disable_gutenberg_css' ) ) {
			basel_force_enqueue_style( 'wp-gutenberg' );
		}

		if ( is_404() ) {
			basel_force_enqueue_style( 'page-404' );
		}

		if ( is_search() ) {
			basel_force_enqueue_style( 'page-search-results' );
		}

		if ( basel_get_opt( 'dark_version' ) ) {
			basel_force_enqueue_style( 'opt-basel-dark', true );
		}

		if ( basel_get_opt( 'lazy_loading' ) ) {
			basel_force_enqueue_style( 'opt-lazy-loading' );
		}

		if ( defined( 'RS_REVISION' ) ) {
			basel_force_enqueue_style( 'int-revolution-slider', true );
		}

		if ( function_exists( '_mc4wp_load_plugin' ) ) {
			basel_force_enqueue_style( 'int-mc4wp', true );
		}

		if ( defined( 'WPCF7_VERSION' ) ) {
			basel_force_enqueue_style( 'int-wpcf7', true );
		}

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			basel_force_enqueue_style( 'woo-int-dokan-vend', true );
		}

		if ( defined( 'YITH_YWZM_VERSION' ) ) {
			basel_force_enqueue_style( 'woo-int-yith-zoom', true );
		}

		if ( defined( 'WC_STRIPE_VERSION' ) ) {
			basel_force_enqueue_style( 'woo-int-stripe', true );
		}

		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			basel_force_enqueue_style( 'int-wpml', true );
		}

		if ( defined( 'YITH_WPV_VERSION' ) ) {
			basel_force_enqueue_style( 'woo-int-yith-vendor', true );
		}

		if ( defined( 'WC_GATEWAY_PPEC_VERSION' ) ) {
			basel_force_enqueue_style( 'woo-int-paypal-express', true );
		}

		if ( defined( 'YITH_WCWL' ) ) {
			basel_force_enqueue_style( 'woo-int-yith-wishlist', true );
			basel_force_enqueue_style( 'woo-page-my-account' );
		}

		if ( class_exists( 'WooCommerce_Germanized' ) ) {
			basel_force_enqueue_style( 'woo-int-germanized', true );
		}

		if ( class_exists( 'WC_Vendors' ) ) {
			basel_force_enqueue_style( 'woo-int-wc-vend', true );
		}

		if ( class_exists( 'ANR' ) ) {
			basel_force_enqueue_style( 'int-advanced-nocaptcha', true );
		}

		if ( class_exists( 'bbPress' ) ) {
			basel_force_enqueue_style( 'int-bbpress', true );
		}

		if ( defined( 'WPB_VC_VERSION' ) ) {
			basel_force_enqueue_style( 'int-wpbakery-base' );
		}

		if ( basel_woocommerce_installed() ) {
			basel_force_enqueue_style( 'woo-base' );

			if ( is_cart() || is_checkout() || is_account_page() ) {
				basel_force_enqueue_style( 'woo-lib-select2' );
			}

			if ( is_cart() ) {
				basel_force_enqueue_style( 'woo-page-cart' );
			}

			if ( is_checkout() ) {
				basel_force_enqueue_style( 'woo-page-checkout' );
			}

			if ( is_account_page() ) {
				basel_force_enqueue_style( 'woo-page-my-account' );
			}

			if ( is_product() ) {
				basel_force_enqueue_style( 'woo-page-single-product' );
				$single_product_design = basel_get_opt( 'product_design' );
				if ( 'default' !== $single_product_design ) {
					basel_force_enqueue_style( 'woo-single-product-' . $single_product_design );
				}
			}

			if ( is_product_taxonomy() || is_shop() || is_product_category() || is_product_tag() || basel_is_product_attribute_archive() ) {
				basel_force_enqueue_style( 'woo-page-shop' );
			}

			$compare_page  = function_exists( 'wpml_object_id_filter' ) ? wpml_object_id_filter( basel_get_opt( 'compare_page' ), 'page', true ) : basel_get_opt( 'compare_page' );
			$wishlist_page = function_exists( 'wpml_object_id_filter' ) ? wpml_object_id_filter( basel_get_opt( 'wishlist_page' ), 'page', true ) : basel_get_opt( 'wishlist_page' );

			if ( $compare_page && (int) basel_get_the_ID() === (int) $compare_page ) {
				basel_force_enqueue_style( 'woo-page-compare' );
			}

			if ( $wishlist_page && (int) basel_get_the_ID() === (int) $wishlist_page ) {
				basel_force_enqueue_style( 'woo-page-wishlist' );
				basel_force_enqueue_style( 'woo-page-my-account' );
			}
		}
	}

	add_action( 'wp_enqueue_scripts', 'basel_force_enqueue_styles', 10001 );
}

if ( ! function_exists( 'basel_woo_widgets_select2' ) ) {
	/**
	 * Enqueue style for woo widgets.
	 *
	 * @since 1.0.0
	 *
	 * @param string $data Data.
	 *
	 * @return string
	 */
	function basel_woo_widgets_select2( $data ) {
		basel_enqueue_inline_style( 'woo-lib-select2' );

		return $data;
	}

	add_action( 'woocommerce_product_categories_widget_dropdown_args', 'basel_woo_widgets_select2', 10 );
	add_action( 'woocommerce_layered_nav_any_label', 'basel_woo_widgets_select2', 10 );
}

if ( ! function_exists( 'basel_single_product_add_to_cart_scripts' ) ) {
	/**
	 * Enqueue single product scripts.
	 *
	 * @since 1.0.0
	 */
	function basel_single_product_add_to_cart_scripts() {
		if ( 'nothing' !== basel_get_opt( 'add_to_cart_action' ) ) {
			basel_enqueue_inline_style( 'woo-opt-add-to-cart-popup' );
			basel_enqueue_inline_style( 'lib-magnific-popup' );
		}
	}

	add_action( 'woocommerce_before_add_to_cart_form', 'basel_single_product_add_to_cart_scripts' );
}

if ( ! function_exists( 'basel_product_loop_add_to_cart_scripts' ) ) {
	/**
	 * Enqueue single product scripts.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $data Data.
	 *
	 * @return mixed
	 */
	function basel_product_loop_add_to_cart_scripts( $data ) {
		if ( 'nothing' !== basel_get_opt( 'add_to_cart_action' ) ) {
			basel_enqueue_inline_style( 'woo-opt-add-to-cart-popup' );
			basel_enqueue_inline_style( 'lib-magnific-popup' );
		}

		return $data;
	}

	add_action( 'woocommerce_loop_add_to_cart_link', 'basel_product_loop_add_to_cart_scripts' );
}
