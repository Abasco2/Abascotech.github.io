<?php if ( ! defined('BASEL_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Products hover effects
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters( 'basel_get_product_hovers', array(
	'base' => esc_html__( 'Base', 'basel' ),
	'alt' => esc_html__( 'Alternative', 'basel' ),
	'button' => esc_html__( 'Show button on hover on image', 'basel' ),
	'info' => esc_html__( 'Full info on hover', 'basel' ),
	'link' => esc_html__( 'Button on hover', 'basel' ),
	'standard' => esc_html__( 'Standard button', 'basel' ),
	'excerpt' => esc_html__( 'With excerpt', 'basel' ),
	'quick' => esc_html__( 'Quick shop', 'basel' ),
) );