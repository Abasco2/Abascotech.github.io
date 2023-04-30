<?php
if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 *  Wishlist element map
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_vc_map_wishlist' ) ) {
	function basel_vc_map_wishlist() {
		vc_map(
			array(
				'name'        => esc_html__( 'Wishlist', 'basel' ),
				'base'        => 'basel_wishlist',
				'category'    => esc_html__( 'Theme elements', 'basel' ),
				'description' => esc_html__( 'Required for the wishlist page.', 'basel' ),
				'icon'        => BASEL_ASSETS . '/images/vc-icon/wishlist.svg',
			)
		);
	}

	add_action( 'vc_before_init', 'basel_vc_map_wishlist' );
}
