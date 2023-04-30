<?php
/**
 * Page metaboxes
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Metaboxes;

if ( ! function_exists( 'basel_register_page_metaboxes' ) ) {
	/**
	 * Register page metaboxes
	 *
	 * @since 1.0.0
	 */
	function basel_register_page_metaboxes() {
		global $basel_transfer_options, $basel_prefix;

		$basel_prefix = '_basel_';

		$basel_transfer_options[] = 'page-title-size';
		$basel_transfer_options[] = 'main_layout';
		$basel_transfer_options[] = 'sidebar_width';
		$basel_transfer_options[] = 'header';
		$basel_transfer_options[] = 'header-overlap';
		$basel_transfer_options[] = 'header_color_scheme';

		$page_metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'xts_page_metaboxes',
				'title'      => esc_html__( 'Page Setting (custom metabox from theme)', 'basel' ),
				'post_types' => array( 'page', 'post', 'portfolio' ),
			)
		);

		$page_metabox->add_section(
			array(
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'basel' ),
				'priority' => 10,
				'icon'     => BASEL_ASSETS . '/assets/images/dashboard-icons/settings.svg',
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'header',
				'name'        => esc_html__( 'Header', 'basel' ),
				'description' => esc_html__( 'Set your header design.', 'basel' ),
				'group'       => esc_html__( 'Header options', 'basel' ),
				'type'        => 'select',
				'section'     => 'general',
				'options'     => array(
					'inherit'     => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'inherit',
					),
					'shop'        => array(
						'name'  => esc_html__( 'E-Commerce', 'basel' ),
						'value' => 'shop',
					),
					'base'        => array(
						'name'  => esc_html__( 'Base header', 'basel' ),
						'value' => 'base',
					),
					'simple'      => array(
						'name'  => esc_html__( 'Simplified', 'basel' ),
						'value' => 'simple',
					),
					'split'       => array(
						'name'  => esc_html__( 'Double menu', 'basel' ),
						'value' => 'split',
					),
					'logo-center' => array(
						'name'  => esc_html__( 'Logo center', 'basel' ),
						'value' => 'logo-center',
					),
					'categories'  => array(
						'name'  => esc_html__( 'With categories menu', 'basel' ),
						'value' => 'categories',
					),
					'menu-top'    => array(
						'name'  => esc_html__( 'Menu in top bar', 'basel' ),
						'value' => 'menu-top',
					),
					'vertical'    => array(
						'name'  => esc_html__( 'Vertical', 'basel' ),
						'value' => 'vertical',
					),
				),
				'default'     => 'inherit',
				'priority'    => 10,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'header-overlap',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Header above the content', 'basel' ),
				'description' => esc_html__( 'Overlap page content with this header (header is transparent)', 'basel' ),
				'group'       => esc_html__( 'Header options', 'basel' ),
				'requires'    => array(
					array(
						'key'     => $basel_prefix . 'header',
						'compare' => 'equals',
						'value'   => array( 'simple', 'shop', 'split' ),
					),
				),
				'section'     => 'general',
				'priority'    => 20,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'header_color_scheme',
				'name'        => esc_html__( 'Header text color', 'basel' ),
				'description' => esc_html__( 'You can change colors of links and icons for the header', 'basel' ),
				'group'       => esc_html__( 'Header options', 'basel' ),
				'type'        => 'buttons',
				'section'     => 'general',
				'options'     => array(
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'inherit',
					),
					'dark'    => array(
						'name'  => esc_html__( 'Dark', 'basel' ),
						'value' => 'dark',
					),
					'light'   => array(
						'name'  => esc_html__( 'Light', 'basel' ),
						'value' => 'light',
					),
				),
				'default'     => 'inherit',
				'priority'    => 30,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'open_categories',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Open categories menu', 'basel' ),
				'description' => esc_html__( 'Always shows categories navigation on this page', 'basel' ),
				'group'       => esc_html__( 'Header options', 'basel' ),
				'section'     => 'general',
				'priority'    => 40,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'title_off',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Disable Page title', 'basel' ),
				'description' => esc_html__( 'You can hide page heading for this page', 'basel' ),
				'group'       => esc_html__( 'Page title options', 'basel' ),
				'section'     => 'general',
				'priority'    => 50,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'title_image',
				'type'        => 'upload',
				'name'        => esc_html__( 'Image for page title', 'basel' ),
				'description' => esc_html__( 'Upload an image', 'basel' ),
				'group'       => esc_html__( 'Page title options', 'basel' ),
				'section'     => 'general',
				'data_type'   => 'url',
				'priority'    => 60,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'title_bg_color',
				'type'        => 'color',
				'name'        => esc_html__( 'Page title background color', 'basel' ),
				'description' => esc_html__( 'Сhoose a color', 'basel' ),
				'group'       => esc_html__( 'Page title options', 'basel' ),
				'section'     => 'general',
				'data_type'   => 'hex',
				'priority'    => 70,
			)
		);

		$page_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'title_color',
				'name'     => esc_html__( 'Text color for title', 'basel' ),
				'group'    => esc_html__( 'Page title options', 'basel' ),
				'type'     => 'buttons',
				'section'  => 'general',
				'options'  => array(
					'default' => array(
						'name'  => esc_html__( 'Inherit', 'basel' ),
						'value' => 'default',
					),
					'light'   => array(
						'name'  => esc_html__( 'Light', 'basel' ),
						'value' => 'light',
					),
					'dark'    => array(
						'name'  => esc_html__( 'Dark', 'basel' ),
						'value' => 'dark',
					),
				),
				'default'  => 'default',
				'priority' => 80,
			)
		);

		$page_metabox->add_field(
			array(
				'id'          => $basel_prefix . 'page-title-size',
				'name'        => esc_html__( 'Page title size' ),
				'description' => esc_html__( 'You can set different sizes for your pages titles', 'basel' ),
				'group'       => esc_html__( 'Page title options', 'basel' ),
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
					'small'   => array(
						'name'  => esc_html__( 'Small', 'basel' ),
						'value' => 'small',
					),
					'large'   => array(
						'name'  => esc_html__( 'Large', 'basel' ),
						'value' => 'large',
					),
				),
				'default'     => 'inherit',
				'priority'    => 90,
			)
		);

		$page_metabox->add_field(
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
				'priority'    => 100,
			)
		);

		$page_metabox->add_field(
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
				'priority'    => 100,
			)
		);

		$page_metabox->add_field(
			array(
				'id'       => $basel_prefix . 'custom_sidebar',
				'name'     => esc_html__( 'Custom sidebar for this page', 'basel' ),
				'group'    => esc_html__( 'Sidebar options', 'basel' ),
				'type'     => 'select',
				'section'  => 'general',
				'options'  => basel_get_sidebars_array( true ),
				'priority' => 120,
			)
		);
	}

	add_action( 'init', 'basel_register_page_metaboxes', 100 );
}


$post_category_metabox = Metaboxes::add_metabox(
	array(
		'id'         => 'xts_post_category_metaboxes',
		'title'      => esc_html__( 'Extra options from theme', 'basel' ),
		'object'     => 'term',
		'taxonomies' => array( 'category' ),
	)
);

$post_category_metabox->add_section(
	array(
		'id'       => 'general',
		'name'     => esc_html__( 'General', 'basel' ),
		'icon'     => BASEL_ASSETS . '/assets/images/dashboard-icons/settings.svg',
		'priority' => 10,
	)
);

$post_category_metabox->add_field(
	array(
		'id'          => '_basel_blog_design',
		'name'        => esc_html__( 'Blog Design', 'basel' ),
		'description' => esc_html__( 'You can use different design for your blog styled for the theme.', 'basel' ),
		'type'        => 'select',
		'section'     => 'general',
		'options'     => array(
			'inherit'      => array(
				'name'  => esc_html__( 'Inherit', 'basel' ),
				'value' => 'inherit',
			),
			'default'      => array(
				'name'  => esc_html__( 'Default', 'basel' ),
				'value' => 'Default',
			),
			'default-alt'  => array(
				'name'  => esc_html__( 'Default alternative', 'basel' ),
				'value' => 'default-alt',
			),
			'small-images' => array(
				'name'  => esc_html__( 'Small images', 'basel' ),
				'value' => 'small-images',
			),
			'masonry'      => array(
				'name'  => esc_html__( 'Masonry grid', 'basel' ),
				'value' => 'default',
			),
			'mask'         => array(
				'name'  => esc_html__( 'Mask on image', 'basel' ),
				'value' => 'mask',
			),
		),
		'priority'    => 10,
	)
);
