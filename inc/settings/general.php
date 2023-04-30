<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * General
 */
Options::add_section(
	array(
		'id'       => 'general_section',
		'name'     => esc_html__( 'General', 'basel' ),
		'priority' => 10,
		'icon'     => 'dashicons dashicons-admin-home',
	)
);

/**
 * General
 */

Options::add_field(
	array(
		'id'          => 'favicon',
		'name'        => esc_html__( 'Favicon image (deprecated)', 'basel' ),
		'description' => esc_html__( 'You need to upload favicon image using WordPress core option in Appearance -> Customize -> Site identity -> Site icon.', 'basel' ),
		'type'        => 'upload',
		'section'     => 'general_section',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'favicon_retina',
		'name'        => esc_html__( 'Favicon retina image (deprecated)', 'basel' ),
		'description' => esc_html__( 'You need to upload favicon image using WordPress core option in Appearance -> Customize -> Site identity -> Site icon.', 'basel' ),
		'type'        => 'upload',
		'section'     => 'general_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'page_comments',
		'name'     => esc_html__( 'Show comments on page', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'general_section',
		'default'  => '1',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'google_map_api_key',
		'name'        => esc_html__( 'Google map API key', 'basel' ),
		'type'        => 'text_input',
		'description' => wp_kses(
			__( 'Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'basel' ),
			'default'
		),
		'section'     => 'general_section',
		'tags'        => 'google api key',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'relevanssi_search',
		'name'        => esc_html__( 'Use Relevanssi for AJAX search', 'basel' ),
		'description' => 'You will need to install and activate this <a href="https://ru.wordpress.org/plugins/relevanssi/" target="_blank">plugin</a>',
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '0',
		'priority'    => 62,
	)
);

Options::add_field(
	array(
		'id'           => 'custom_404_page',
		'name'         => esc_html__( 'Custom 404 page', 'basel' ),
		'type'         => 'select',
		'description'  => esc_html__( 'You can make your custom 404 page', 'basel' ),
		'section'      => 'general_section',
		'options'      => basel_get_pages( true ),
		'empty_option' => true,
		'priority'     => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'widget_title_tag',
		'name'        => esc_html__( 'Widget title tag', 'basel' ),
		'description' => esc_html__( 'Choose which HTML tag to use in widget title.', 'basel' ),
		'type'        => 'select',
		'section'     => 'general_section',
		'default'     => 'h5',
		'options'     => array(
			'h1'   => array(
				'name'  => 'h1',
				'value' => 'h1',
			),
			'h2'   => array(
				'name'  => 'h2',
				'value' => 'h2',
			),
			'h3'   => array(
				'name'  => 'h3',
				'value' => 'h3',
			),
			'h4'   => array(
				'name'  => 'h4',
				'value' => 'h4',
			),
			'h5'   => array(
				'name'  => 'h5',
				'value' => 'h5',
			),
			'h6'   => array(
				'name'  => 'h6',
				'value' => 'h6',
			),
			'p'    => array(
				'name'  => 'p',
				'value' => 'p',
			),
			'div'  => array(
				'name'  => 'div',
				'value' => 'div',
			),
			'span' => array(
				'name'  => 'span',
				'value' => 'span',
			),
		),
		'priority'    => 71,
	)
);

Options::add_field(
	array(
		'id'          => 'search_post_type',
		'name'        => esc_html__( 'Search post type', 'basel' ),
		'description' => esc_html__( 'You can set up site search for posts or for products (woocommerce)', 'basel' ),
		'group'       => esc_html__( 'Search', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'general_section',
		'options'     => array(
			'product' => array(
				'name'  => esc_html__( 'Product', 'basel' ),
				'value' => 'product',
			),
			'post'    => array(
				'name'  => esc_html__( 'Post', 'basel' ),
				'value' => 'post',
			),
		),
		'default'     => 'product',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'       => 'search_by_sku',
		'name'     => esc_html__( 'Search by product SKU', 'basel' ),
		'group'       => esc_html__( 'Search', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'general_section',
		'default'  => false,
		'priority' => 90,
	)
);

Options::add_field(
	array(
		'id'       => 'show_sku_on_ajax',
		'name'     => esc_html__( 'Show SKU on AJAX results', 'basel' ),
		'group'       => esc_html__( 'Search', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'general_section',
		'requires' => array(
			array(
				'key'     => 'search_by_sku',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => false,
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'enqueue_posts_results',
		'name'        => esc_html__( 'Display results from blog', 'basel' ),
		'description' => esc_html__( 'Enable search for two post types.', 'basel' ),
		'group'       => esc_html__( 'Search', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'general_section',
		'default'     => false,
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'search_posts_results_column',
		'name'        => esc_html__( 'Number of columns for blog results', 'basel' ),
		'group'       => esc_html__( 'Search', 'basel' ),
		'type'        => 'range',
		'section'     => 'general_section',
		'default'     => 2,
		'min'         => 2,
		'step'        => 1,
		'max'         => 6,
		'requires'    => array(
			array(
				'key'     => 'enqueue_posts_results',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority'    => 120,
	)
);

/**
 * Mobile bottom navbar.
 */
Options::add_section(
	array(
		'id'       => 'general_navbar_section',
		'parent'   => 'general_section',
		'name'     => esc_html__( 'Mobile bottom navbar', 'basel' ),
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_toolbar',
		'name'        => esc_html__( 'Enable Sticky navbar', 'basel' ),
		'description' => esc_html__( 'Sticky navigation toolbar will be shown at the bottom on mobile devices.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'general_navbar_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_toolbar_fields',
		'name'        => esc_html__( 'Select buttons', 'basel' ),
		'description' => esc_html__( 'Choose which buttons will be used for sticky navbar.', 'basel' ),
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'section'     => 'general_navbar_section',
		'options'     => basel_get_sticky_toolbar_fields( true ),
		'default'     => array(
			'shop',
			'sidebar',
			'wishlist',
			'cart',
			'account',
		),
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_toolbar_label',
		'name'        => esc_html__( 'Navbar labels', 'basel' ),
		'description' => esc_html__( 'Show/hide labels under icons in the mobile navbar.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'general_navbar_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'link_1_url',
		'name'     => esc_html__( 'Custom button URL', 'basel' ),
		'group'    => esc_html__( 'Custom button [1]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'link_1_text',
		'name'     => esc_html__( 'Custom button text', 'basel' ),
		'group'    => esc_html__( 'Custom button [1]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 41,
	)
);

Options::add_field(
	array(
		'id'       => 'link_1_icon',
		'name'     => esc_html__( 'Custom button icon', 'basel' ),
		'group'    => esc_html__( 'Custom button [1]', 'basel' ),
		'type'     => 'upload',
		'section'  => 'general_navbar_section',
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'link_2_url',
		'name'     => esc_html__( 'Custom button URL', 'basel' ),
		'group'    => esc_html__( 'Custom button [2]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'link_2_text',
		'name'     => esc_html__( 'Custom button text', 'basel' ),
		'group'    => esc_html__( 'Custom button [2]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 61,
	)
);

Options::add_field(
	array(
		'id'       => 'link_2_icon',
		'name'     => esc_html__( 'Custom button icon', 'basel' ),
		'group'    => esc_html__( 'Custom button [2]', 'basel' ),
		'type'     => 'upload',
		'section'  => 'general_navbar_section',
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'link_3_url',
		'name'     => esc_html__( 'Custom button URL', 'basel' ),
		'group'    => esc_html__( 'Custom button [3]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 80,
	)
);

Options::add_field(
	array(
		'id'       => 'link_3_text',
		'name'     => esc_html__( 'Custom button text', 'basel' ),
		'group'    => esc_html__( 'Custom button [3]', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'general_navbar_section',
		'priority' => 81,
	)
);


Options::add_field(
	array(
		'id'       => 'link_3_icon',
		'name'     => esc_html__( 'Custom button icon', 'basel' ),
		'group'    => esc_html__( 'Custom button [3]', 'basel' ),
		'type'     => 'upload',
		'section'  => 'general_navbar_section',
		'priority' => 90,
	)
);

/**
 * Instagram.
 */
Options::add_section(
	array(
		'id'       => 'instagram_section',
		'parent'   => 'general_section',
		'name'     => esc_html__( 'Instagram API', 'basel' ),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'insta_token',
		'name'        => esc_html__( 'Connect instagram account', 'basel' ),
		'description' => 'To get this data, follow the instructions in our documentation <a href="https://xtemos.com/docs/basel/faq-guides/setup-instagram-api/" target="_blank">here</a>.',
		'type'        => 'instagram_api',
		'section'     => 'instagram_section',
		'priority'    => 10,
	)
);