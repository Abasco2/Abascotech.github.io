<?php
if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Size guide element map
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'basel_vc_map_size_guide' ) ) {
	function basel_vc_map_size_guide() {
		if ( ! shortcode_exists( 'basel_size_guide' ) ) {
			return;
		}

		vc_map(
			array(
				'name'        => esc_html__( 'Size guide', 'basel' ),
				'base'        => 'basel_size_guide',
				'class'       => '',
				'category'    => esc_html__( 'Theme elements', 'basel' ),
				'description' => esc_html__( 'Display size guide table anywhere', 'basel' ),
				'icon'        => BASEL_ASSETS . '/images/vc-icon/size-guide.svg',
				'params'      => array(
					/**
					 * Content
					 */
					array(
						'type'       => 'basel_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Content', 'basel' ),
						'param_name' => 'content_divider',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Select size guide', 'basel' ),
						'param_name' => 'id',
						'value'      => basel_get_size_guides_array(),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Hide title', 'basel' ),
						'param_name' => 'hide_title',
						'value' => array( esc_html__( 'Yes, please', 'basel' ) => 'yes' ),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Hide description', 'basel' ),
						'param_name' => 'hide_description',
						'value' => array( esc_html__( 'Yes, please', 'basel' ) => 'yes' ),
					),
					/**
					 * Extra
					 */
					array(
						'type'       => 'basel_title_divider',
						'holder'     => 'div',
						'title'      => esc_html__( 'Extra options', 'basel' ),
						'param_name' => 'extra_divider',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Extra class name', 'basel' ),
						'param_name' => 'el_class',
						'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'basel' ),
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'CSS box', 'basel' ),
						'param_name' => 'css',
						'group' => esc_html__( 'Design Options', 'basel' )
					),
				),
			)
		);
	}
	add_action( 'vc_before_init', 'basel_vc_map_size_guide' );
}
