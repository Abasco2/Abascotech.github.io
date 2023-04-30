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
		'id'       => 'import_export',
		'name'     => esc_html__( 'Import / Export', 'basel' ),
		'priority' => 170,
		'icon'     => 'dashicons dashicons-image-rotate',
	)
);

Options::add_field(
	array(
		'id'       => 'import_export',
		'name'     => esc_html__( 'Import/export', 'basel' ),
		'type'     => 'import',
		'section'  => 'import_export',
		'priority' => 10,
	)
);
