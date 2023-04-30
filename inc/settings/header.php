<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * Header
 */
Options::add_section(
	array(
		'id'       => 'header_section',
		'name'     => esc_html__( 'Header', 'basel' ),
		'priority' => 40,
		'icon'     => 'dashicons dashicons-schedule',
	)
);

Options::add_field(
	array(
		'id'          => 'logo',
		'name'        => esc_html__( 'Upload image: png, jpg or gif file', 'basel' ),
		'description' => esc_html__( 'Logo image', 'basel' ),
		'type'        => 'upload',
		'section'     => 'header_section',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'logo-sticky',
		'name'        => esc_html__( 'Upload image: png, jpg or gif file', 'basel' ),
		'description' => esc_html__( 'Logo image for sticky header', 'basel' ),
		'type'        => 'upload',
		'section'     => 'header_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'logo-white',
		'name'        => esc_html__( 'Upload image: png, jpg or gif file', 'basel' ),
		'description' => esc_html__( 'Logo image - white', 'basel' ),
		'type'        => 'upload',
		'section'     => 'header_section',
		'tags'        => 'white logo white',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'logo_width',
		'name'        => esc_html__( 'Logo container width', 'basel' ),
		'description' => esc_html__( 'Set width for logo area in the header. In percentages', 'basel' ),
		'type'        => 'range',
		'section'     => 'header_section',
		'default'     => 20,
		'min'         => 1,
		'step'        => 1,
		'max'         => 50,
		'priority'    => 40,
		'tags'        => 'logo width logo size',
	)
);

Options::add_field(
	array(
		'id'          => 'logo_img_width',
		'name'        => esc_html__( 'Logo image maximum width', 'basel' ),
		'description' => esc_html__( 'Set maximum width for logo image in the header. In pixels', 'basel' ),
		'type'        => 'range',
		'section'     => 'header_section',
		'default'     => 200,
		'min'         => 50,
		'step'        => 1,
		'max'         => 600,
		'priority'    => 50,
		'tags'        => 'logo width logo size',
	)
);

/**
 * Top bar
 */
Options::add_section(
	array(
		'id'       => 'top_bar_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Top bar', 'basel' ),
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'top-bar',
		'section'     => 'top_bar_section',
		'name'        => esc_html__( 'Top bar', 'basel' ),
		'description' => esc_html__( 'Information about the header.', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'top-bar-color',
		'name'     => esc_html__( 'Top bar text color', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'top_bar_section',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'basel' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'basel' ),
				'value' => 'light',
			),
		),
		'default'  => 'light',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'top-bar-bg',
		'name'        => esc_html__( 'Top bar background', 'basel' ),
		'description' => esc_html__( 'You can set your top bar background color or upload some graphic.', 'basel' ),
		'type'        => 'background',
		'default'     => array(
			'color' => '#1aada3',
		),
		'section'     => 'top_bar_section',
		'selector'    => '.topbar-wrapp',
		'tags'        => 'top bar color topbar color topbar background',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'header_text',
		'name'        => esc_html__( 'Text in the header top bar', 'basel' ),
		'description' => esc_html__( 'Place here text you want to see in the header top bar. You can use shortocdes. Ex.: [social_buttons]', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'default'     => '<i class="fa fa-phone-square" style="color:white;"> </i> OUR PHONE NUMBER: <span style="margin-left:10px; border-bottom: 1px solid rgba(125,125,125,0.3);">+77 (756) 334 876</span>',
		'section'     => 'top_bar_section',
		'tags'        => 'top bar text topbar text',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'top_bar_height',
		'name'     => esc_html__( 'Top bar height for desktop', 'basel' ),
		'type'     => 'range',
		'section'  => 'top_bar_section',
		'default'  => 42,
		'min'      => 24,
		'step'     => 1,
		'max'      => 100,
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'top_bar_mobile_height',
		'name'     => esc_html__( 'Top bar mobile height for desktop', 'basel' ),
		'type'     => 'range',
		'section'  => 'top_bar_section',
		'default'  => 38,
		'min'      => 24,
		'step'     => 1,
		'max'      => 100,
		'priority' => 50,
	)
);

/**
 * Header layout
 */
Options::add_section(
	array(
		'id'       => 'header_layout_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Header Layout', 'basel' ),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'header_full_width',
		'section'     => 'header_layout_section',
		'name'        => esc_html__( 'Full Width', 'basel' ),
		'description' => esc_html__( 'Make header full width', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'tags'        => 'full width header',
		'requires'    => array(
			array(
				'key'     => 'header',
				'compare' => 'not_equals',
				'value'   => array( 'vertical' ),
			),
		),
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_header',
		'section'     => 'header_layout_section',
		'name'        => esc_html__( 'Sticky Header', 'basel' ),
		'description' => esc_html__( 'Enable/disable sticky header option', 'basel' ),
		'type'        => 'switcher',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'header',
		'name'        => esc_html__( 'Header', 'basel' ),
		'description' => esc_html__( 'Set your header design.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_layout_section',
		'options'     => array(
			'shop'        => array(
				'name'  => esc_html__( 'E-Commerce', 'basel' ),
				'value' => 'shop',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-shop.png',
			),
			'base'        => array(
				'name'  => esc_html__( 'Base header', 'basel' ),
				'value' => 'base',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-base.png',
			),
			'simple'      => array(
				'name'  => esc_html__( 'Simplified', 'basel' ),
				'value' => 'simple',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-simple.png',
			),
			'split'       => array(
				'name'  => esc_html__( 'Double menu', 'basel' ),
				'value' => 'split',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-split.png',
			),
			'logo-center' => array(
				'name'  => esc_html__( 'Logo center', 'basel' ),
				'value' => 'logo-center',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-logo-center.png',
			),
			'categories'  => array(
				'name'  => esc_html__( 'With categories menu', 'basel' ),
				'value' => 'categories',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-categories.png',
			),
			'menu-top'    => array(
				'name'  => esc_html__( 'Menu in top bar', 'basel' ),
				'value' => 'menu-top',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-menu-top.png',
			),
			'vertical'    => array(
				'name'  => esc_html__( 'Vertical', 'basel' ),
				'value' => 'vertical',
				'image' => BASEL_ASSETS_IMAGES . '/settings/header-vertical.png',
			),
		),
		'default'     => 'shop',
		'tags'        => 'header layout header type header design header base header style',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'header-overlap',
		'section'     => 'header_layout_section',
		'name'        => esc_html__( 'Header above the content', 'basel' ),
		'description' => esc_html__( 'Overlap page content with this header (header is transparent)', 'basel' ),
		'type'        => 'switcher',
		'default'     => false,
		'tags'        => 'full width header',
		'requires'    => array(
			array(
				'key'     => 'header',
				'compare' => 'equals',
				'value'   => array( 'simple', 'shop', 'split' ),
			),
		),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'right_column_width',
		'name'        => esc_html__( 'Right column width', 'basel' ),
		'description' => esc_html__( 'Set width for icons and links area in the header (shopping cart, wishlist, search). In pixels', 'basel' ),
		'type'        => 'range',
		'section'     => 'header_layout_section',
		'default'     => 250,
		'min'         => 30,
		'step'        => 1,
		'max'         => 450,
		'requires'    => array(
			array(
				'key'     => 'header',
				'compare' => 'not_equals',
				'value'   => array( 'vertical' ),
			),
		),
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'header_height',
		'name'     => esc_html__( 'Header height', 'basel' ),
		'type'     => 'range',
		'section'  => 'header_layout_section',
		'default'  => 95,
		'min'      => 40,
		'step'     => 1,
		'max'      => 220,
		'requires' => array(
			array(
				'key'     => 'header',
				'compare' => 'not_equals',
				'value'   => array( 'vertical' ),
			),
		),
		'tags'     => 'header size logo height logo size',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'sticky_header_height',
		'name'     => esc_html__( 'Sticky header height', 'basel' ),
		'type'     => 'range',
		'section'  => 'header_layout_section',
		'default'  => 75,
		'min'      => 40,
		'step'     => 1,
		'max'      => 180,
		'requires' => array(
			array(
				'key'     => 'header',
				'compare' => 'not_equals',
				'value'   => array( 'vertical' ),
			),
		),
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'mobile_header_height',
		'name'     => esc_html__( 'Mobile header height', 'basel' ),
		'type'     => 'range',
		'section'  => 'header_layout_section',
		'default'  => 60,
		'min'      => 40,
		'step'     => 1,
		'max'      => 120,
		'tags'     => 'mobile header size mobile logo height mobile logo size',
		'priority' => 80,
	)
);

/**
 * Shopping cart widget
 */
Options::add_section(
	array(
		'id'       => 'header_cart_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Shopping cart widget', 'basel' ),
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'cart_position',
		'name'        => esc_html__( 'Shopping cart position', 'basel' ),
		'description' => esc_html__( 'Shopping cart widget may be placed in the header or as a sidebar.', 'basel' ),
		'type'        => 'select',
		'section'     => 'header_cart_section',
		'options'     => array(
			'side'     => array(
				'name'  => esc_html__( 'Hidden sidebar', 'basel' ),
				'value' => 'side',
			),
			'dropdown' => array(
				'name'  => esc_html__( 'Dropdown widget in header', 'basel' ),
				'value' => 'dropdown',
			),
			'without'  => array(
				'name'  => esc_html__( 'Without', 'basel' ),
				'value' => 'without',
			),
		),
		'default'     => 'side',
		'tags'        => 'cart widget',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'shopping_cart',
		'name'        => esc_html__( 'Shopping cart', 'basel' ),
		'description' => esc_html__( 'Set your shopping cart widget design in the header.', 'basel' ),
		'type'        => 'select',
		'section'     => 'header_cart_section',
		'options'     => array(
			1         => array(
				'name'  => esc_html__( 'Design 1', 'basel' ),
				'value' => 1,
			),
			2         => array(
				'name'  => esc_html__( 'Design 2', 'basel' ),
				'value' => 2,
			),
			3         => array(
				'name'  => esc_html__( 'Design 3', 'basel' ),
				'value' => 3,
			),
			'disable' => array(
				'name'  => esc_html__( 'Disable', 'basel' ),
				'value' => 'disable',
			),
		),
		'default'     => 1,
		'tags'        => 'cart widget style cart widget design',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'shopping_icon_alt',
		'section'     => 'header_cart_section',
		'name'        => esc_html__( 'Alternative shopping cart icon', 'basel' ),
		'description' => esc_html__( 'Use alternative cart icon in header icons links', 'basel' ),
		'type'        => 'switcher',
		'default'     => false,
		'priority'    => 30,
	)
);

/**
 * Appearance
 */
Options::add_section(
	array(
		'id'       => 'header_style_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Appearance', 'basel' ),
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'header_color_scheme',
		'name'        => esc_html__( 'Header text color', 'basel' ),
		'description' => esc_html__( 'You can change colors of links and icons for the header', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_style_section',
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
		'default'     => 'dark',
		'tags'        => 'header color',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'header_background',
		'name'     => esc_html__( 'Header background', 'basel' ),
		'type'     => 'background',
		'section'  => 'header_style_section',
		'selector' => 'html .main-header, .sticky-header.header-clone, .header-spacing',
		'tags'     => 'header color',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'header-border',
		'name'        => esc_html__( 'Header Border', 'basel' ),
		'description' => esc_html__( 'Border bottom for the header.', 'basel' ),
		'type'        => 'border',
		'section'     => 'header_style_section',
		'selector'    => '.main-header',
		'bottom'      => true,
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'icons_design',
		'name'        => esc_html__( 'Icons font for header icons', 'basel' ),
		'description' => esc_html__( 'Choose between two icon fonts: Font Awesome and Line Icons', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_style_section',
		'options'     => array(
			'line'        => array(
				'name'  => esc_html__( 'Line Icons', 'basel' ),
				'value' => 'line',
			),
			'fontawesome' => array(
				'name'  => esc_html__( 'Font Awesome', 'basel' ),
				'value' => 'fontawesome',
			),
		),
		'default'     => 'line',
		'tags'        => 'font awesome icons shopping cart icon',

		'priority'    => 40,
	)
);

/**
 * Main menu
 */
Options::add_section(
	array(
		'id'       => 'header_menu_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Main menu', 'basel' ),
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'menu_align',
		'name'        => esc_html__( 'Main menu align', 'basel' ),
		'description' => esc_html__( 'Set menu text position on some headers', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_menu_section',
		'options'     => array(
			'left'   => array(
				'name'  => esc_html__( 'Left', 'basel' ),
				'value' => 'left',
			),
			'center' => array(
				'name'  => esc_html__( 'Center', 'basel' ),
				'value' => 'center',
			),
			'right'  => array(
				'name'  => esc_html__( 'Right', 'basel' ),
				'value' => 'right',
			),
		),
		'default'     => 'left',
		'tags'        => 'menu center menu',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'mobile_menu_position',
		'name'        => esc_html__( 'Mobile menu side', 'basel' ),
		'description' => esc_html__( 'Choose from which side mobile navigation will be shown', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_menu_section',
		'options'     => array(
			'left'  => array(
				'name'  => esc_html__( 'Left', 'basel' ),
				'value' => 'left',
			),
			'right' => array(
				'name'  => esc_html__( 'Right', 'basel' ),
				'value' => 'right',
			),
		),
		'default'     => 'left',
		'priority'    => 20,
	)
);

/**
 * My account links
 */
Options::add_section(
	array(
		'id'       => 'header_account_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'My account links', 'basel' ),
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'login_links',
		'section'     => 'header_account_section',
		'name'        => esc_html__( 'Show in the HEADER', 'basel' ),
		'description' => esc_html__( 'Show links to login/register or my account page in the header', 'basel' ),
		'type'        => 'switcher',
		'default'     => '0',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'login_sidebar',
		'section'  => 'header_account_section',
		'name'     => esc_html__( 'Login form in sidebar', 'basel' ),
		'type'     => 'switcher',
		'default'  => '1',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'header_my_account_style',
		'name'     => esc_html__( 'Style', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'header_account_section',
		'options'  => array(
			'text' => array(
				'name'  => esc_html__( 'Text', 'basel' ),
				'value' => 'text',
			),
			'icon' => array(
				'name'  => esc_html__( 'Icon', 'basel' ),
				'value' => 'icon',
			),
		),
		'default'  => 'text',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'my_account_with_username',
		'section'  => 'header_account_section',
		'name'     => esc_html__( 'With username', 'basel' ),
		'type'     => 'switcher',
		'default'  => false,
		'priority' => 40,
	)
);

/**
 * Other
 */
Options::add_section(
	array(
		'id'       => 'header_other_section',
		'parent'   => 'header_section',
		'name'     => esc_html__( 'Other', 'basel' ),
		'priority' => 80,
	)
);

Options::add_field(
	array(
		'id'           => 'categories-menu',
		'name'         => esc_html__( 'Categories menu', 'basel' ),
		'description'  => esc_html__( 'Use your custom menu as a categories navigation for particular headers.', 'basel' ),
		'type'         => 'select',
		'section'      => 'header_other_section',
		'empty_option' => true,
		'options'      => basel_get_menus_array( true ),
		'priority'     => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'more_cat_button',
		'name'         => esc_html__( 'Limit categories', 'basel' ),
		'description'  => esc_html__( 'Display a certain number of categories and "show more" button.', 'basel' ),
		'type'         => 'switcher',
		'section'      => 'header_other_section',
		'default'     => false,
		'priority'     => 11,
	)
);

Options::add_field(
	array(
		'id'          => 'more_cat_button_count',
		'type'        => 'range',
		'section'     => 'header_other_section',
		'name'        => esc_html__( 'Number of categories', 'basel' ),
		'description' => esc_html__( 'Specify the number of categories to be shown initially', 'basel' ),
		'min'         => 1,
		'max'         => 100,
		'step'        => 1,
		'default'     => 5,
		'priority'    => 12,
		'requires' => array(
			array(
				'key'     => 'more_cat_button',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'header_area',
		'name'        => esc_html__( 'Text in the header', 'basel' ),
		'description' => esc_html__( 'You can place here some advertisement or phone numbers. You can use shortcode to place here HTML block [html_block id=""]', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'section'     => 'header_other_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'header_search',
		'name'        => esc_html__( 'Search widget', 'basel' ),
		'description' => esc_html__( 'Display search icon in the header in different views', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'header_other_section',
		'options'     => array(
			'dropdown'    => array(
				'name'  => esc_html__( 'Dropdown', 'basel' ),
				'value' => 'dropdown',
			),
			'full-screen' => array(
				'name'  => esc_html__( 'Full screen', 'basel' ),
				'value' => 'full-screen',
			),
			'disable'     => array(
				'name'  => esc_html__( 'Disable', 'basel' ),
				'value' => 'disable',
			),
		),
		'default'     => 'full-screen',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'mobile_search_icon',
		'type'     => 'switcher',
		'section'  => 'header_other_section',
		'tags'     => 'search icon mobile',
		'name'     => esc_html__( 'Search icon on mobile', 'xts_theme' ),
		'requires' => array(
			array(
				'key'     => 'header_search',
				'compare' => 'not_equals',
				'value'   => 'disable',
			),
		),
		'default'  => false,
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'mobile_search_form',
		'type'     => 'switcher',
		'section'  => 'header_other_section',
		'tags'     => 'search menu mobile',
		'name'     => esc_html__( 'Search above the mobile menu', 'xts_theme' ),
		'default'  => '1',
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'search_ajax',
		'type'     => 'switcher',
		'section'  => 'header_other_section',
		'tags'     => 'search ajax',
		'name'     => esc_html__( 'AJAX Search', 'xts_theme' ),
		'default'  => '1',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'search_ajax_result_count',
		'type'     => 'range',
		'section'  => 'header_other_section',
		'tags'     => 'ajax search count',
		'name'     => esc_html__( 'AJAX search result count', 'xts_theme' ),
		'min'      => 5,
		'max'      => 50,
		'step'     => 1,
		'requires' => array(
			array(
				'key'     => 'search_ajax',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => 5,
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'mobile_search_close_btn',
		'type'     => 'switcher',
		'section'  => 'header_other_section',
		'tags'     => 'search menu mobile',
		'name'     => esc_html__( 'Close button in mobile menu', 'xts_theme' ),
		'default'  => false,
		'priority' => 80,
	)
);