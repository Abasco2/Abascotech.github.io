<?php
/**
 * AIOSEO.
 *
 * @package basel
 */

if ( ! function_exists( 'aioseo' ) ) {
	return;
}

add_action( 'wp_head', 'basel_page_css_files_disable', 0 );
add_action( 'wp_head', 'basel_page_css_files_enable', 2 );