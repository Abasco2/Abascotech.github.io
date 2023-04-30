<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

$selectors = basel_get_config( 'selectors' );

/**
 * Styles and colors.
 */
Options::add_section(
	array(
		'id'       => 'colors_section',
		'name'     => esc_html__( 'Styles and colors', 'basel' ),
		'priority' => 60,
		'icon'     => 'dashicons dashicons-admin-customizer',
	)
);

Options::add_field(
	array(
		'id'              => 'primary-color',
		'name'            => esc_html__( 'Primary color', 'basel' ),
		'description'     => esc_html__( 'Pick a background color for the theme buttons and other colored elements.', 'basel' ),
		'type'            => 'color',
		'section'         => 'colors_section',
		'selector'        => $selectors['primary-color']['color'],
		'selector_bg'     => $selectors['primary-color']['background-color'],
		'selector_border' => $selectors['primary-color']['border-color'],
		'selector_stroke' => $selectors['primary-color']['stroke'],
		'default'         => array( 'idle' => '#1aada3' ),
		'priority'        => 10,
	)
);

Options::add_field(
	array(
		'id'              => 'secondary-color',
		'name'            => esc_html__( 'Secondary color', 'basel' ),
		'description'     => esc_html__( 'Color for secondary elements on the website.', 'basel' ),
		'type'            => 'color',
		'section'         => 'colors_section',
		'selector'        => $selectors['secondary-color']['color'],
		'selector_bg'     => $selectors['secondary-color']['background-color'],
		'selector_border' => $selectors['secondary-color']['border-color'],
		'default'         => array( 'idle' => '#FBBC34' ),
		'priority'        => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'android_browser_bar_color',
		'name'        => esc_html__( 'Android browser bar color', 'basel' ),
		'description' => wp_kses( __( 'Define color for the browser top bar on Android devices. <a href="https://developers.google.com/web/fundamentals/design-and-ux/browser-customization/#color_browser_elements">[Read more]</a>', 'basel' ), 'default' ),
		'type'        => 'color',
		'section'     => 'colors_section',
		'default'     => array(),
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'dark_version',
		'name'        => esc_html__( 'Dark theme', 'basel' ),
		'description' => esc_html__( 'Turn your website color to dark scheme', 'basel' ),
		'group'       => esc_html__( 'Website dark theme', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'colors_section',
		'default'     => false,
		'priority'    => 60,
	)
);

Options::add_section(
	array(
		'id'       => 'buttons_section',
		'parent'   => 'colors_section',
		'name'     => esc_html__( 'Buttons', 'basel' ),
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'              => 'regular-buttons-bg-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button',
		'name'            => esc_html__( 'Regular buttons color', 'xts_theme' ),
		'selector_bg'     => current( $selectors['regular-buttons-bg-color'] ),
		'selector_border' => current( $selectors['regular-buttons-bg-color'] ),
		'default'         => array(
			'idle' => '#ECECEC',
		),
		'priority'        => 10,
	)
);

Options::add_field(
	array(
		'id'              => 'regular-buttons-bg-hover-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button',
		'name'            => esc_html__( 'Regular buttons hover color', 'xts_theme' ),
		'selector_bg'     => basel_append_hover_state( $selectors['regular-buttons-bg-color'] ),
		'selector_border' => basel_append_hover_state( $selectors['regular-buttons-bg-color'] ),
		'default'         => array(
			'idle' => '#3E3E3E',
		),
		'priority'        => 20,
	)
);

Options::add_field(
	array(
		'id'              => 'shop-buttons-bg-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button shop',
		'name'            => esc_html__( 'Shop buttons color', 'xts_theme' ),
		'selector'        => current( $selectors['shop-button-color'] ),
		'selector_bg'     => current( $selectors['shop-buttons-bg-color'] ),
		'selector_border' => current( $selectors['shop-buttons-bg-color'] ),
		'default'         => array(
			'idle' => '#000',
		),
		'priority'        => 30,
	)
);

Options::add_field(
	array(
		'id'              => 'shop-buttons-bg-hover-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button shop',
		'name'            => esc_html__( 'Shop buttons hover color', 'xts_theme' ),
		'selector'        => basel_append_hover_state( $selectors['shop-button-color'] ),
		'selector_bg'     => basel_append_hover_state( $selectors['shop-buttons-bg-color'] ),
		'selector_border' => basel_append_hover_state( $selectors['shop-buttons-bg-color'] ),
		'default'         => array(
			'idle' => '#333',
		),
		'priority'        => 40,
	)
);

Options::add_field(
	array(
		'id'              => 'accent-buttons-bg-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button',
		'name'            => esc_html__( 'Accent buttons color', 'xts_theme' ),
		'selector_bg'     => current( $selectors['accent-buttons-bg-color'] ),
		'selector_border' => current( $selectors['accent-buttons-bg-color'] ),
		'priority'        => 50,
	)
);

Options::add_field(
	array(
		'id'              => 'accent-buttons-bg-hover-color',
		'type'            => 'color',
		'section'         => 'buttons_section',
		'tags'            => 'color button',
		'name'            => esc_html__( 'Accent buttons hover color', 'xts_theme' ),
		'selector_bg'     => basel_append_hover_state( $selectors['accent-buttons-bg-color'] ),
		'selector_border' => basel_append_hover_state( $selectors['accent-buttons-bg-color'] ),
		'priority'        => 60,
	)
);

Options::add_section(
	array(
		'id'       => 'notices_section',
		'parent'   => 'colors_section',
		'name'     => esc_html__( 'Notices', 'basel' ),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'              => 'success_notice_border_color',
		'name'            => esc_html__( 'Success notice border color', 'basel' ),
		'group'           => esc_html__( 'Success', 'basel' ),
		'type'            => 'color',
		'default'         => array(),
		'section'         => 'notices_section',
		'selector_border' => '.woocommerce-message, .wpcf7-mail-sent-ok, .mc4wp-alert .mc4wp-success',
		'priority'        => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'success_notice_text_color',
		'name'     => esc_html__( 'Success notice text color', 'basel' ),
		'group'    => esc_html__( 'Success', 'basel' ),
		'type'     => 'color',
		'default'  => array(),
		'section'  => 'notices_section',
		'selector' => '.woocommerce-message, .wpcf7-mail-sent-ok, .mc4wp-alert .mc4wp-success, .woocommerce-message .button',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'              => 'warning_notice_border_color',
		'name'            => esc_html__( 'Warning notice border color', 'basel' ),
		'group'           => esc_html__( 'Warning', 'basel' ),
		'type'            => 'color',
		'default'         => array(),
		'section'         => 'notices_section',
		'selector_border' => 'div.wpcf7-validation-errors, .woocommerce-error, .woocommerce-info, .mc4wp-alert .mc4wp-error',
		'priority'        => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'warning_notice_text_color',
		'name'     => esc_html__( 'Warning notice text color', 'basel' ),
		'group'    => esc_html__( 'Warning', 'basel' ),
		'type'     => 'color',
		'default'  => array(),
		'section'  => 'notices_section',
		'selector' => 'div.wpcf7-validation-errors, .woocommerce-error, .woocommerce-info, .mc4wp-alert .mc4wp-error',
		'priority' => 40,
	)
);
