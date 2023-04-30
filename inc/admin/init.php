<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'basel_get_theme_settings_search_data' ) ) {
	/**
	 * Get theme settings search data.
	 */
	function basel_get_theme_settings_search_data() {
		check_ajax_referer( 'basel-get-theme-settings-data-nonce', 'security' );

		$all_fields   = XTS\Options::get_fields();
		$all_sections = XTS\Options::get_sections();

		$options_data = array();
		foreach ( $all_fields as $field ) {
			$section_id = $field->args['section'];
			$section    = $all_sections[ $section_id ];

			if ( isset( $section['parent'] ) ) {
				$path = $all_sections[ $section['parent'] ]['name'] . ' -> ' . $section['name'];
			} else {
				$path = $section['name'];
			}

			$text = $field->args['name'];
			if ( isset( $field->args['description'] ) ) {
				$text .= ' ' . $field->args['description'];
			}
			if ( isset( $field->args['tags'] ) ) {
				$text .= ' ' . $field->args['tags'];
			}

			$options_data[] = array(
				'id'         => $field->args['id'],
				'title'      => $field->args['name'],
				'text'       => $text,
				'section_id' => $section['id'],
				'icon'       => isset( $section['icon'] ) ? $section['icon'] : $all_sections[ $section['parent'] ]['icon'],
				'path'       => $path,
			);
		}

		wp_send_json(
			array(
				'theme_settings' => $options_data,
			)
		);
	}

	add_action( 'wp_ajax_basel_get_theme_settings_search_data', 'basel_get_theme_settings_search_data' );
}

if ( ! function_exists( 'basel_get_theme_settings_typography_data' ) ) {
	/**
	 * Get theme settings typography data.
	 */
	function basel_get_theme_settings_typography_data() {
		check_ajax_referer( 'basel-get-theme-settings-data-nonce', 'security' );

		$custom_fonts_data = basel_get_opt( 'multi_custom_fonts' );
		$custom_fonts      = array();
		if ( isset( $custom_fonts_data['{{index}}'] ) ) {
			unset( $custom_fonts_data['{{index}}'] );
		}

		if ( is_array( $custom_fonts_data ) ) {
			foreach ( $custom_fonts_data as $font ) {
				if ( ! $font['font-name'] ) {
					continue;
				}

				$custom_fonts[ $font['font-name'] ] = $font['font-name'];
			}
		}

		$typekit_fonts = basel_get_opt( 'typekit_fonts' );

		if ( $typekit_fonts ) {
			$typekit = explode( ',', $typekit_fonts );
			foreach ( $typekit as $font ) {
				$custom_fonts[ ucfirst( trim( $font ) ) ] = trim( $font );
			}
		}

		wp_send_json(
			array(
				'typography' => array(
					'stdfonts'    => basel_get_config( 'standard-fonts' ),
					'googlefonts' => XTS\Google_Fonts::$all_google_fonts,
					'customFonts' => $custom_fonts,
				),
			)
		);
	}

	add_action( 'wp_ajax_basel_get_theme_settings_typography_data', 'basel_get_theme_settings_typography_data' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue admin scripts
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_admin_scripts' ) ) {
	function basel_admin_scripts() {
		$version = basel_get_theme_info( 'Version' );

		wp_enqueue_script( 'basel-admin-scripts', BASEL_ASSETS . '/js/admin.js', array(), $version, true );
		wp_enqueue_script( 'basel-admin-options', BASEL_ASSETS . '/js/options.js', array(), $version, true );

		basel_admin_scripts_localize();

		// Slider
		wp_enqueue_script( 'jquery-ui-slider' );

	}
	add_action( 'admin_init', 'basel_admin_scripts', 100 );
}

if ( ! function_exists( 'basel_admin_wpb_scripts' ) ) {
	/**
	 * Add scripts for WPB fields.
	 */
	function basel_admin_wpb_scripts() {
		$version = basel_get_theme_info( 'Version' );

		if ( apply_filters( 'basel_gradients_enabled', true ) ) {
			wp_enqueue_script( 'basel-colorpicker-scripts', BASEL_ASSETS . '/js/colorpicker.min.js', array(), $version, true );
			wp_enqueue_script( 'basel-gradient-scripts', BASEL_ASSETS . '/js/gradX.min.js', array(), $version, true );
		}

		wp_enqueue_script( 'basel-slider', BASEL_ASSETS . '/js/vc-fields/slider.js', array(), $version, true );
		wp_enqueue_script( 'basel-responsive-size', BASEL_ASSETS . '/js/vc-fields/responsive-size.js', array(), $version, true );
		wp_enqueue_script( 'basel-vc-image-select', BASEL_ASSETS . '/js/vc-fields/image-select.js', array(), $version, true );
		wp_enqueue_script( 'basel-vc-colorpicker', BASEL_ASSETS . '/js/vc-fields/colorpicker.js', array(), $version, true );
		wp_enqueue_script( 'basel-vc-functions', BASEL_ASSETS . '/js/vc-fields/vc-functions.js', array(), $version, true );
	}

	add_action( 'vc_backend_editor_render', 'basel_admin_wpb_scripts' );
	add_action( 'vc_frontend_editor_render', 'basel_admin_wpb_scripts' );
}

if ( ! function_exists( 'basel_frontend_editor_enqueue_scripts' ) ) {
	function basel_frontend_editor_enqueue_scripts() {
		$version = basel_get_theme_info( 'Version' );
		wp_enqueue_script( 'js-cookie', BASEL_SCRIPTS . '/js.cookie.js', array( 'jquery' ), $version, true );
		basel_enqueue_scripts();
		wp_enqueue_script( 'basel-frontend-editor-functions', BASEL_ASSETS . '/js/vc-fields/frontend-editor-functions.js', array(), $version, true );
	}

	add_action( 'vc_frontend_editor_enqueue_js_css', 'basel_frontend_editor_enqueue_scripts', 100 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Localize admin script function
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_admin_scripts_localize' ) ) {
	function basel_admin_scripts_localize() {
		wp_localize_script( 'basel-admin-scripts', 'baselConfig', basel_admin_script_local() );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get localization array for admin scripts
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_admin_script_local' ) ) {
	function basel_admin_script_local() {
		$localize_data = array(
			'ajax'                            => admin_url( 'admin-ajax.php' ),
			'import_nonce'                    => wp_create_nonce( 'basel-import-nonce' ),
			'mega_menu_added_thumbnail_nonce' => wp_create_nonce( 'basel-mega-menu-added-thumbnail-nonce' ),
			'get_theme_settings_data_nonce'   => wp_create_nonce( 'basel-get-theme-settings-data-nonce' ),
		);

		// If we are on edit product attribute page
		if ( ! empty( $_GET['page'] ) && $_GET['page'] == 'product_attributes' && ! empty( $_GET['edit'] ) && function_exists( 'wc_attribute_taxonomy_name_by_id' ) ) {
			$attribute_id                            = sanitize_text_field( wp_unslash( $_GET['edit'] ) );
			$taxonomy_ids                            = wc_get_attribute_taxonomy_ids();
			$attribute_name                          = array_search( $attribute_id, $taxonomy_ids, false );
			$localize_data['attributeSwatchSize']    = basel_wc_get_attribute_term( 'pa_' . $attribute_name, 'swatch_size' );
			$localize_data['attributeShowOnProduct'] = basel_wc_get_attribute_term( 'pa_' . $attribute_name, 'show_on_product' );
		}

		$localize_data['searchOptionsPlaceholder'] = esc_js( __( 'Search for options', 'basel' ) );
		$localize_data['ajaxUrl']                  = admin_url( 'admin-ajax.php' );
		$localize_data['patcher_nonce'] = wp_create_nonce( 'patcher_nonce' );

		return apply_filters( 'basel_admin_script_local', $localize_data );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue admin styles
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_enqueue_admin_styles' ) ) {
	function basel_enqueue_admin_styles() {
		$version = basel_get_theme_info( 'Version' );

		if ( is_admin() ) {
			wp_enqueue_style( 'basel-admin-style', BASEL_ASSETS . '/css/theme-admin.css', array(), $version );
			if ( apply_filters( 'basel_gradients_enabled', true ) ) {
				wp_enqueue_style( 'basel-colorpicker-style', BASEL_ASSETS . '/css/colorpicker.css', array(), $version );
				wp_enqueue_style( 'basel-gradient-style', BASEL_ASSETS . '/css/gradX.css', array(), $version );
			}

			wp_enqueue_style( 'basel-jquery-ui', BASEL_ASSETS . '/css/jquery-ui.css', array(), $version );
		}

	}

	add_action( 'admin_enqueue_scripts', 'basel_enqueue_admin_styles' );
}

