<?php
/**
 * Custom JS options
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

/**
 * Custom JS section.
 */
Options::add_section(
	array(
		'id'       => 'custom_js',
		'name'     => esc_html__( 'Custom JS', 'basel' ),
		'priority' => 130,
		'icon'     => 'dashicons dashicons-media-text',
	)
);

Options::add_field(
	array(
		'id'       => 'custom_js',
		'name'     => esc_html__( 'Global Custom JS', 'basel' ),
		'type'     => 'editor',
		'language' => 'javascript',
		'section'  => 'custom_js',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'js_ready',
		'name'        => esc_html__( 'On document ready', 'basel' ),
		'description' => esc_html__( 'Will be executed on $(document).ready()', 'basel' ),
		'type'        => 'editor',
		'language'    => 'javascript',
		'section'     => 'custom_js',
		'priority'    => 20,
	)
);
