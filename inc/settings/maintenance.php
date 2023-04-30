<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

/**
 * Maintenance.
 */
Options::add_section(
	array(
		'id'       => 'maintenance',
		'name'     => esc_html__( 'Maintenance', 'basel' ),
		'priority' => 160,
		'icon'     => 'dashicons dashicons-hammer',
	)
);

Options::add_field(
	array(
		'id'          => 'maintenance_mode',
		'name'        => esc_html__( 'Enable maintenance mode', 'basel' ),
		'description' => esc_html__( 'If enabled you need to create maintenance page in Dashboard - Pages - Add new. Choose "Template" to be "Maintenance" in "Page attributes". Or you can import the page from our demo in Dashboard - Basel - Base import', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'maintenance',
		'default'     => false,
		'priority'    => 10,
	)
);
