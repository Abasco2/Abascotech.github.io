<?php
/**
 * Yoast.
 *
 * @package basel
 */

if ( ! function_exists( 'YoastSEO' ) ) {
	return;
}

add_action( 'category_description', 'basel_page_css_files_disable', 9 );
add_action( 'term_description', 'basel_page_css_files_disable', 9 );

add_action( 'category_description', 'basel_page_css_files_enable', 11 );
add_action( 'term_description', 'basel_page_css_files_enable', 11 );
