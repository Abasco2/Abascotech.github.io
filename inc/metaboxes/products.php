<?php
/**
 * Product metaboxes
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Metaboxes;

if ( ! function_exists( 'basel_register_product_metaboxes' ) ) {
	/**
	 * Register page metaboxes
	 *
	 * @since 1.0.0
	 */
	function basel_register_product_metaboxes() {
		global $basel_transfer_options, $basel_prefix;

		$basel_prefix = '_basel_';

		$product_metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'xts_product_metaboxes',
				'title'      => esc_html__( 'Product Setting (custom metabox from theme)', 'basel' ),
				'post_types' => array( 'product' ),
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'basel' ),
				'priority' => 10,
				'icon'     => BASEL_ASSETS . '/assets/images/dashboard-icons/settings.svg',
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'product_design',
				'name'        => esc_html__( 'Product page design', 'basel' ),
				'description' => esc_html__( 'Choose between different predefined designs', 'basel' ),
				'group'       => esc_html__( 'Product design & color options', 'basel' ),
				'type'        => 'buttons',
				'section'     => 'general',
				'options'     => array(
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'inherit',
					),
					'default' => array(
						'name'  => esc_html__( 'Default', 'basel' ),
						'value' => 'default',
					),
					'alt'     => array(
						'name'  => esc_html__( 'Centered', 'basel' ),
						'value' => 'default',
					),
				),
				'default'     => 'inherit',
				'priority'    => 10,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'single_product_style',
				'name'        => esc_html__( 'Product image width', 'basel' ),
				'description' => esc_html__( 'You can choose different page layout depending on the product image size you need', 'basel' ),
				'group'       => esc_html__( 'Product design & color options', 'basel' ),
				'type'        => 'select',
				'section'     => 'general',
				'options'     => array(
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'inherit',
					),
					1         => array(
						'name'  => esc_html__( 'Small image', 'basel' ),
						'value' => 1,
					),
					2         => array(
						'name'  => esc_html__( 'Medium', 'basel' ),
						'value' => 2,
					),
					3         => array(
						'name'  => esc_html__( 'Large', 'basel' ),
						'value' => 3,
					),
				),
				'default'     => 'inherit',
				'priority'    => 20,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'product-background',
				'name'        => esc_html__( 'Single product background', 'basel' ),
				'description' => esc_html__( 'Set background for your products page. You can also specify different background for particular products while editing it.', 'basel' ),
				'group'       => esc_html__( 'Product design & color options', 'basel' ),
				'type'        => 'color',
				'section'     => 'general',
				'data_type'   => 'hex',
				'priority'    => 40,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'main_layout',
				'name'        => esc_html__( 'Sidebar position', 'basel' ),
				'description' => esc_html__( 'Select main content and sidebar alignment.', 'basel' ),
				'group'       => esc_html__( 'Sidebar options', 'basel' ),
				'type'        => 'buttons',
				'section'     => 'general',
				'options'     => array(
					'default'       => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'default',
					),
					'full-width'    => array(
						'name'  => esc_html__( 'Without', 'basel' ),
						'value' => 'full-width',
					),
					'sidebar-left'  => array(
						'name'  => esc_html__( 'Left', 'basel' ),
						'value' => 'sidebar-left',
					),
					'sidebar-right' => array(
						'name'  => esc_html__( 'Right', 'basel' ),
						'value' => 'sidebar-right',
					),
				),
				'default'     => 'default',
				'priority'    => 50,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'sidebar_width',
				'name'        => esc_html__( 'Sidebar size', 'basel' ),
				'description' => esc_html__( 'You can set different sizes for your pages sidebar', 'basel' ),
				'group'       => esc_html__( 'Sidebar options', 'basel' ),
				'type'        => 'buttons',
				'section'     => 'general',
				'options'     => array(
					'default' => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'default',
					),
					2         => array(
						'name'  => esc_html__( 'Small', 'basel' ),
						'value' => 2,
					),
					3         => array(
						'name'  => esc_html__( 'Medium', 'basel' ),
						'value' => 3,
					),
					4         => array(
						'name'  => esc_html__( 'Large', 'basel' ),
						'value' => 4,
					),
				),
				'default'     => 'default',
				'priority'    => 60,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'custom_sidebar',
				'name'     => esc_html__( 'Custom sidebar for this page', 'basel' ),
				'group'    => esc_html__( 'Sidebar options', 'basel' ),
				'type'     => 'select',
				'section'  => 'general',
				'options'  => basel_get_sidebars_array( true ),
				'priority' => 70,
			)
		);

		$blocks = basel_get_static_blocks_array( true );

		$blocks[0] = array(
			'name'  => 'none',
			'value' => 'none',
		);

		ksort( $blocks );

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'extra_content',
				'name'        => esc_html__( 'Extra content block', 'basel' ),
				'description' => esc_html__( 'You can create some extra content with WPBakery Page Builder (in Admin panel / HTML Blocks / Add new) and add it to this product', 'basel' ),
				'group'       => esc_html__( 'Extra content options', 'basel' ),
				'type'        => 'select',
				'section'     => 'general',
				'options'     => $blocks,
				'priority'    => 80,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'extra_position',
				'name'     => esc_html__( 'Extra content position', 'basel' ),
				'group'    => esc_html__( 'Extra content options', 'basel' ),
				'type'     => 'buttons',
				'section'  => 'general',
				'options'  => array(
					'after'     => array(
						'name'  => esc_html__( 'After content', 'basel' ),
						'value' => 'after',
					),
					'before'    => array(
						'name'  => esc_html__( 'Before content', 'basel' ),
						'value' => 'before',
					),
					'prefooter' => array(
						'name'  => esc_html__( 'Prefooter', 'basel' ),
						'value' => 'prefooter',
					),
				),
				'default'  => 'after',
				'priority' => 90,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'hide_tabs_titles',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Hide tabs headings', 'basel' ),
				'description' => esc_html__( 'Description and Additional information', 'basel' ),
				'group'       => esc_html__( 'Product tab options', 'basel' ),
				'section'     => 'general',
				'priority'    => 100,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'product_custom_tab_title',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'basel' ),
				'group'    => esc_html__( 'Product tab options', 'basel' ),
				'section'  => 'general',
				'priority' => 110,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'product_custom_tab_content',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'basel' ),
				'group'    => esc_html__( 'Product tab options', 'basel' ),
				'section'  => 'general',
				'priority' => 120,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'new_label_date',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Mark product as "New" till date', 'basel' ),
				'description' => esc_html__( 'Specify the end date when the "New" status will be retired. NOTE: "Permanent "New" label" option should be disabled if you use the exact date.', 'basel' ),
				'group'    => esc_html__( 'Product extra options', 'basel' ),
				'section'  => 'general',
				'datepicker' => true,
				'priority' => 130,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'new_label',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Permanent "New" label', 'basel' ),
				'description' => esc_html__( 'Enable this option to make your product have "New" status forever.', 'basel' ),
				'group'       => esc_html__( 'Product extra options', 'basel' ),
				'section'     => 'general',
				'priority'    => 131,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'related_off',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Hide related products', 'basel' ),
				'description' => esc_html__( 'You can hide related products on this page', 'basel' ),
				'group'       => esc_html__( 'Product extra options', 'basel' ),
				'section'     => 'general',
				'priority'    => 140,
			)
		);

		$taxonomies_list = array(
			'' => array(
				'name'  => 'Select',
				'value' => '',
			),
		);
		$taxonomies      = get_taxonomies();
		foreach ( $taxonomies as $taxonomy ) {
			$taxonomies_list[ $taxonomy ] = array(
				'name'  => $taxonomy,
				'value' => $taxonomy,
			);
		}

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'swatches_attribute',
				'type'        => 'select',
				'name'        => esc_html__( 'Grid swatch attribute to display', 'basel' ),
				'description' => esc_html__( 'Choose attribute that will be shown on products grid for this particular product', 'basel' ),
				'group'       => esc_html__( 'Product extra options', 'basel' ),
				'section'     => 'general',
				'options'     => $taxonomies_list,
				'priority'    => 150,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'product_video',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Product video URL', 'basel' ),
				'group'    => esc_html__( 'Product extra options', 'basel' ),
				'section'  => 'general',
				'priority' => 160,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'product_hashtag',
				'type'        => 'text_input',
				'name'        => esc_html__( 'Instagram product hashtag (deprecated)', 'basel' ),
				'description' => wp_kses( __( 'Insert tag that will be used to display images from instagram from your customers. For example: <strong>#nike_rush_run</strong>', 'basel' ), 'default' ),
				'group'       => esc_html__( 'Product extra options', 'basel' ),
				'section'     => 'general',
				'priority'    => 170,
			)
		);

		$basel_local_transfer_options = array(
			'product_design',
			'single_product_style',
			'thums_position',
			'product-background',
			'main_layout',
			'sidebar_width',
		);
		
		$basel_transfer_options = array_merge( $basel_transfer_options, $basel_local_transfer_options );
	}

	add_action( 'init', 'basel_register_product_metaboxes', 100 );
}

$product_attribute_metabox = Metaboxes::add_metabox(
	array(
		'id'         => 'xts_product_attribute_metaboxes',
		'title'      => esc_html__( 'Extra options from theme', 'basel' ),
		'object'     => 'term',
		'taxonomies' => array( 'product_cat' ),
	)
);

$product_attribute_metabox->add_section(
	array(
		'id'       => 'general',
		'name'     => esc_html__( 'General', 'basel' ),
		'icon'     => BASEL_ASSETS . '/assets/images/dashboard-icons/settings.svg',
		'priority' => 10,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'          => 'title_image',
		'name'        => esc_html__( 'Image for category heading', 'basel' ),
		'description' => esc_html__( 'Upload an image', 'basel' ),
		'type'        => 'upload',
		'section'     => 'general',
		'data_type'   => 'url',
		'priority'    => 10,
	)
);
