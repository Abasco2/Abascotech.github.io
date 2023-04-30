<?php
/**
 * WEBP integration file.
 *
 * @package basel
 */

if ( ! defined( 'IMAGIFY_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'basel_single_product_gallery_images_webp' ) ) {
	/**
	 * Single product WEBP fix.
	 *
	 * @param string $class Default classes.
	 *
	 * @return string
	 */
	function basel_single_product_gallery_images_webp( $class ) {
		$class .= ' imagify-no-webp';

		return $class;
	}

	add_filter( 'basel_single_product_gallery_image_class', 'basel_single_product_gallery_images_webp' );
}
