<?php
/**
 * Wishlist helper functions.
 */

use XTS\WC_Wishlist\Wishlist;

if ( ! function_exists( 'basel_get_whishlist_page_url' ) ) {
	/**
	 * Get wishlist page url.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function basel_get_whishlist_page_url() {
		$page_id = basel_get_opt( 'wishlist_page' );

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			$page_id = wpml_object_id_filter( $page_id, 'page', true );
		}

		return get_permalink( $page_id );
	}
}


if ( ! function_exists( 'basel_get_wishlist_count' ) ) {
	/**
	 * Get wishlist count.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	function basel_get_wishlist_count() {
		$list = new Wishlist();
		return $list->get_count();
	}
}

if ( ! function_exists( 'basel_get_pages_array' ) ) {
	/**
	 * Get all pages array
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function basel_get_pages_array() {
		$pages = array();

		foreach ( get_pages() as $page ) {
			$pages[ $page->ID ] = array(
				'name'  => $page->post_title,
				'value' => $page->ID,
			);
		}

		return $pages;
	}
}

if ( ! function_exists( 'basel_set_cookie' ) ) {
	/**
	 * Set cookies.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name.
	 * @param string $value Value.
	 */
	function basel_set_cookie( $name, $value ) {
		$expire = time() + intval( apply_filters( 'basel_session_expiration', 60 * 60 * 24 * 7 ) );
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, basel_cookie_secure_param(), false );
		$_COOKIE[ $name ] = $value;
	}
}

if ( ! function_exists( 'basel_get_cookie' ) ) {
	/**
	 * Get cookie.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name.
	 *
	 * @return string
	 */
	function basel_get_cookie( $name ) {
		return isset( $_COOKIE[ $name ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ $name ] ) ) : false; // phpcs:ignore
	}
}
