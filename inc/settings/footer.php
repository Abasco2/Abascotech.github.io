<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * General
 */
Options::add_section(
	array(
		'id'       => 'footer_section',
		'name'     => esc_html__( 'Footer', 'basel' ),
		'priority' => 40,
		'icon'     => 'dashicons dashicons-editor-kitchensink',
	)
);

Options::add_field(
	array(
		'id'          => 'disable_footer',
		'section'     => 'footer_section',
		'name'        => esc_html__( 'Footer', 'basel' ),
		'description' => esc_html__( 'Enable/disable footer on your website.', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'footer-layout',
		'name'        => esc_html__( 'Footer layout', 'basel' ),
		'description' => esc_html__( 'Choose your footer layout. Depending on columns number you will have different number of widget areas for footer in Appearance->Widgets', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'footer_section',
		'options'     => array(
			1  => array(
				'name'  => esc_html__( 'Single Column', 'basel' ),
				'value' => 1,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-1.png',
			),
			2  => array(
				'name'  => esc_html__( 'Two Columns', 'basel' ),
				'value' => 2,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-2.png',
			),
			3  => array(
				'name'  => esc_html__( 'Three Columns', 'basel' ),
				'value' => 3,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-3.png',
			),
			4  => array(
				'name'  => esc_html__( 'Four Columns', 'basel' ),
				'value' => 4,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-4.png',
			),
			5  => array(
				'name'  => esc_html__( 'Six Columns', 'basel' ),
				'value' => 5,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-5.png',
			),
			6  => array(
				'name'  => esc_html__( '1/4 + 1/2 + 1/4', 'basel' ),
				'value' => 6,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-6.png',
			),
			7  => array(
				'name'  => esc_html__( '1/2 + 1/4 + 1/4', 'basel' ),
				'value' => 7,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-7.png',
			),
			8  => array(
				'name'  => esc_html__( '1/4 + 1/4 + 1/2', 'basel' ),
				'value' => 8,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-8.png',
			),
			9  => array(
				'name'  => esc_html__( 'Two rows', 'basel' ),
				'value' => 9,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-9.png',
			),
			10 => array(
				'name'  => esc_html__( 'Two rows', 'basel' ),
				'value' => 10,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-10.png',
			),
			11 => array(
				'name'  => esc_html__( 'Two rows', 'basel' ),
				'value' => 11,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-11.png',
			),
			12 => array(
				'name'  => esc_html__( 'Two rows', 'basel' ),
				'value' => 12,
				'image' => BASEL_ASSETS_IMAGES . '/settings/footer-12.png',
			),
		),
		'default'     => 12,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'footer-style',
		'name'        => esc_html__( 'Footer text color', 'basel' ),
		'description' => esc_html__( 'Choose your footer color scheme', 'basel' ),
		'group'       => esc_html__( 'Footer color scheme options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'footer_section',
		'options'     => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'basel' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'basel' ),
				'value' => 'light',
			),
		),
		'default'     => 'light',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'footer-bar-bg',
		'name'        => esc_html__( 'Footer background', 'basel' ),
		'description' => esc_html__( 'You can set your footer section background color or upload some graphic.', 'basel' ),
		'group'       => esc_html__( 'Footer color scheme options', 'basel' ),
		'type'        => 'background',
		'default'     => array(
			'color' => '#000000',
		),
		'section'     => 'footer_section',
		'selector'    => '.footer-container',
		'tags'        => 'footer color',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'disable_copyrights',
		'section'     => 'footer_section',
		'name'        => esc_html__( 'Copyrights', 'basel' ),
		'description' => esc_html__( 'Turn on/off a section with your copyrights under the footer.', 'basel' ),
		'group'       => esc_html__( 'Footer copyrights', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'copyrights-layout',
		'name'        => esc_html__( 'Copyrights layout', 'basel' ),
		'description' => esc_html__( 'Set different copyrights section layout.', 'basel' ),
		'group'       => esc_html__( 'Footer copyrights', 'basel' ),
		'type'        => 'select',
		'section'     => 'footer_section',
		'options'     => array(
			'two-columns' => array(
				'name'  => esc_html__( 'Two columns', 'basel' ),
				'value' => 'two-columns',
			),
			'centered'    => array(
				'name'  => esc_html__( 'Centered', 'basel' ),
				'value' => 'centered',
			),
		),
		'default'     => 'centered',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'copyrights',
		'name'        => esc_html__( 'Copyrights text', 'basel' ),
		'group'       => esc_html__( 'Footer copyrights', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'description' => esc_html__( 'Place here text you want to see in the copyrights area. You can use shortocdes. Ex.: [social_buttons]', 'basel' ),
		'default'     => '',
		'section'     => 'footer_section',
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'copyrights2',
		'name'        => esc_html__( 'Text next to copyrights', 'basel' ),
		'group'       => esc_html__( 'Footer copyrights', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'description' => esc_html__( 'You can use shortcodes. Ex.: [social_buttons] or place an HTML Block built with WPBakery Page Builder builder there like [html_block id="258"]', 'basel' ),
		'default'     => '',
		'section'     => 'footer_section',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'prefooter_area',
		'name'        => esc_html__( 'HTML before footer', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'description' => esc_html__( 'This is the text before footer field, again good for additional info. You can place here any shortcode, for ex.: [html_block id=""]', 'basel' ),
		'group'       => esc_html__( 'Prefooter area', 'basel' ),
		'section'     => 'footer_section',
		'tags'        => 'prefooter',
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'scroll_top_btn',
		'section'     => 'footer_section',
		'name'        => esc_html__( 'Scroll to top button', 'basel' ),
		'description' => esc_html__( 'This button moves you to the top of the page when you click it.', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_footer',
		'section'     => 'footer_section',
		'name'        => esc_html__( 'Sticky footer', 'basel' ),
		'description' => esc_html__( 'The footer will be displayed behind the content of the page and will be visible when user scrolls to the bottom on the page.', 'basel' ),
		'type'        => 'switcher',
		'default'     => false,
		'priority'    => 110
	)
);

Options::add_field(
	array(
		'id'          => 'collapse_footer_widgets',
		'section'     => 'footer_section',
		'name'        => esc_html__( 'Collapse widgets on mobile', 'basel' ),
		'description' => esc_html__( 'Widgets added to the footer will be collapsed by default and opened when you click on their titles.', 'basel' ),
		'type'        => 'switcher',
		'default'     => false,
		'priority'    => 120,
	)
);





