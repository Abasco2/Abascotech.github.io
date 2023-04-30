<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

$selectors = basel_get_config( 'selectors' );

/**
 * General
 */
Options::add_section(
	array(
		'id'       => 'typography_section',
		'name'     => esc_html__( 'Typography', 'basel' ),
		'priority' => 50,
		'icon'     => 'dashicons dashicons-editor-textcolor',
	)
);

Options::add_field(
	array(
		'id'          => 'text-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Text font', 'basel' ),
		'description' => esc_html__( 'Set you typography options for body, paragraphs.', 'basel' ),
		'selector'    => $selectors['text-font'][0],
		'default'     => array(
			array(
				'font-family' => 'Karla',
			),
		),
		'line-height' => false,
		'tags'        => 'typography',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'primary-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Primary font', 'basel' ),
		'description' => esc_html__( 'Set you typography options for titles, post names.', 'basel' ),
		'selector'    => $selectors['primary-font'][0],
		'default'     => array(
			array(
				'font-family' => 'Karla',
			),
		),
		'line-height' => false,
		'tags'        => 'typography',
		'priority'    => 10,
	)
);


Options::add_field(
	array(
		'id'          => 'post-titles-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Entities names', 'basel' ),
		'description' => esc_html__( 'Titles for posts, products, categories and pages', 'basel' ),
		'selector'    => $selectors['titles-font'][0],
		'default'     => array(
			array(
				'font-family' => 'Lora',
			),
		),
		'line-height' => false,
		'tags'        => 'typography',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'secondary-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Secondary font', 'basel' ),
		'description' => esc_html__( 'Use for secondary titles (use CSS class "font-alt" or "title-alt")', 'basel' ),
		'selector'    => $selectors['secondary-font'][0],
		'default'     => array(
			array(
				'font-family' => 'Lato',
				'font-style'  => 'italic',
				'font-weight' => 400,
			),
		),
		'line-height' => false,
		'font-size'   => false,
		'tags'        => 'typography',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'widget-titles-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Widget titles font', 'basel' ),
		'description' => esc_html__( 'Typography options for titles for widgets in your sidebars.', 'basel' ),
		'selector'    => $selectors['widget-titles-font'][0],
		'tags'        => 'typography',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'navigation-font',
		'type'        => 'typography',
		'section'     => 'typography_section',
		'name'        => esc_html__( 'Navigation font', 'basel' ),
		'description' => esc_html__( 'This option will change typography for your header navigation.', 'basel' ),
		'selector'    => $selectors['navigation-font'][0],
		'line-height' => false,
		'tags'        => 'typography',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'load_all_font_weights',
		'name'        => esc_html__( 'Load all font weights', 'basel' ),
		'description' => esc_html__( 'Not recommended. Disable this option to load only those font weights that are selected for your typography options.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'typography_section',
		'default'     => '1',
		'priority'    => 60,
	)
);

/**
 * Typekit fonts.
 */
Options::add_section(
	array(
		'id'       => 'typekit_section',
		'parent'   => 'typography_section',
		'name'     => esc_html__( 'Typekit Fonts', 'basel' ),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'typekit_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => wp_kses(
			__( 'To use your Typekit font, you need to create an account on the <a href="https://typekit.com/" target="_blank"><u>service</u></a> and obtain your key ID here. Then, you need to enter all custom fonts you will use separated with coma. After this, save Theme Settings and reload this page to be able to select your fonts in the list under the Theme Settings -> Typography section.', 'basel' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
				'u'      => array(),
			)
		),
		'section'  => 'typekit_section',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'typekit_id',
		'name'        => esc_html__( 'Typekit Kit ID', 'basel' ),
		'description' => esc_html__( 'Enter your ', 'basel' ) . '<a target="_blank" href="https://typekit.com/account/kits">Typekit Kit ID</a>.',
		'type'        => 'text_input',
		'section'     => 'typekit_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'typekit_fonts',
		'name'        => esc_html__( 'Typekit Typekit Font Face', 'basel' ),
		'description' => esc_html__( 'Example: futura-pt, lato', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'typekit_section',
		'priority'    => 30,
	)
);


/**
 * Custom Fonts.
 */
Options::add_section(
	array(
		'id'       => 'custom_fonts_section',
		'parent'   => 'typography_section',
		'name'     => esc_html__( 'Custom Fonts', 'basel' ),
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'multi_custom_fonts_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => wp_kses(
			__(
				'In this section you can upload your custom fonts files. To ensure the best compatibility in all browsers you would better upload your fonts in all available formats. 
<br><strong>IMPORTANT NOTE</strong>: After uploading all files and entering the font name, you will have to save Theme Settings and <strong>RELOAD</strong> this page. Then, you will be able to go to Theme Settings -> Typography and select the custom font from the list. Find more information in our documentation <a href="https://xtemos.com/docs/basel/faq-guides/upload-custom-fonts/" target="_blank">here</a>.',
				'basel'
			),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
			)
		),
		'section'  => 'custom_fonts_section',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'multi_custom_fonts',
		'type'     => 'custom_fonts',
		'section'  => 'custom_fonts_section',
		'name'     => esc_html__( 'Advanced typography', 'basel' ),
		'fonts'    => apply_filters( 'basel_custom_fonts_type', array( 'woff', 'woff2' ) ),
		'priority' => 20,
	)
);

/**
 * Advanced typography.
 */
Options::add_section(
	array(
		'id'       => 'advanced_typography_section',
		'parent'   => 'typography_section',
		'name'     => esc_html__( 'Advanced typography', 'basel' ),
		'priority' => 30,
	)
);

$selectors = basel_get_config( 'typography-selectors' );

Options::add_field(
	array(
		'id'          => 'advanced_typography',
		'type'        => 'typography',
		'section'     => 'advanced_typography_section',
		'name'        => esc_html__( 'Advanced typography', 'basel' ),
		'selectors'   => $selectors,
		'color-hover' => true,
		'priority'    => 10,
	)
);
