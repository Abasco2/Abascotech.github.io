<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * General
 */
Options::add_section(
	array(
		'id'       => 'general_layout_section',
		'name'     => esc_html__( 'General layout', 'basel' ),
		'priority' => 20,
		'icon'     => 'dashicons dashicons-layout',
	)
);

Options::add_field(
	array(
		'id'          => 'site_width',
		'name'        => esc_html__( 'Site width', 'basel' ),
		'description' => esc_html__( 'You can make your content wrapper boxed or full width', 'basel' ),
		'type'        => 'select',
		'section'     => 'general_layout_section',
		'options'     => array(
			'full-width'         => array(
				'name'  => esc_html__( 'Full width', 'basel' ),
				'value' => 'full-width',
			),
			'boxed'            => array(
				'name'  => esc_html__( 'Boxed', 'basel' ),
				'value' => 'boxed',
			),
			'full-width-content' => array(
				'name'  => esc_html__( 'Content full width', 'basel' ),
				'value' => 'full-width-content',
			),
			'wide'               => array(
				'name'  => esc_html__( 'Wide (1600 px)', 'basel' ),
				'value' => 'wide',
			),
		),
		'default'     => 'full-width',
		'tags'        => 'boxed full width wide',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'main_layout',
		'name'        => esc_html__( 'Main Layout', 'basel' ),
		'description' => esc_html__( 'Select main content and sidebar alignment.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'general_layout_section',
		'options'     => array(
			'full-width'    => array(
				'name'  => esc_html__( 'Without', 'basel' ),
				'value' => 'full-width',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/none.png',
			),
			'sidebar-left'  => array(
				'name'  => esc_html__( 'Left', 'basel' ),
				'value' => 'sidebar-left',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/left.png',
			),
			'sidebar-right' => array(
				'name'  => esc_html__( 'Right', 'basel' ),
				'value' => 'sidebar-right',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/right.png',
			),
		),
		'default'     => 'sidebar-right',
		'tags'        => 'sidebar left sidebar right',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'hide_main_sidebar_mobile',
		'section'     => 'general_layout_section',
		'name'        => esc_html__( 'Off canvas sidebar for mobile', 'basel' ),
		'description' => esc_html__( 'You can can hide sidebar and show nicely on button click on the page.', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'sidebar_width',
		'name'        => esc_html__( 'Sidebar size', 'basel' ),
		'description' => esc_html__( 'You can set different sizes for your pages sidebar', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'general_layout_section',
		'options'     => array(
			2  => array(
				'name'  => esc_html__( 'Small', 'basel' ),
				'value' => 2,
			),
			3  => array(
				'name'  => esc_html__( 'Medium', 'basel' ),
				'value' => 3,
			),
			4  => array(
				'name'  => esc_html__( 'Large', 'basel' ),
				'value' => 4,
			),
		),
		'default'     => 3,
		'tags'        => 'small sidebar large sidebar',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'body-background',
		'name'        => esc_html__( 'Site background', 'basel' ),
		'description' => esc_html__( 'Set background image or color for body. Only for BOXED layout.', 'basel' ),
		'type'        => 'background',
		'default'     => array(),
		'section'     => 'general_layout_section',
		'selector'    => 'body, .basel-dark .main-page-wrapper',
		'priority'    => 50,
	)
);