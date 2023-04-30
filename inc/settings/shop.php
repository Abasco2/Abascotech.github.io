<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;

/**
 * Shop
 */
Options::add_section(
	array(
		'id'       => 'shop_section',
		'name'     => esc_html__( 'Shop', 'basel' ),
		'priority' => 90,
		'icon'     => 'dashicons dashicons-cart',
	)
);

Options::add_field(
	array(
		'id'          => 'shop_per_page',
		'name'        => esc_html__( 'Products per page', 'basel' ),
		'description' => esc_html__( 'Number of products per page', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'shop_section',
		'default'     => 12,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns',
		'name'        => esc_html__( 'Products columns', 'basel' ),
		'description' => esc_html__( 'How many products you want to show per row', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'options'     => array(
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'     => 4,
		'priority'    => 20,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns_mobile',
		'name'        => esc_html__( 'Products columns on mobile', 'basel' ),
		'description' => esc_html__( 'How many products you want to show per row on mobile devices', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'options'     => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
		),
		'default'     => 2,
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_pagination',
		'name'        => esc_html__( 'Products pagination', 'basel' ),
		'description' => esc_html__( 'Choose a type for the pagination on your shop page.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'options'     => array(
			'pagination' => array(
				'name'  => esc_html__( 'Pagination', 'basel' ),
				'value' => 'pagination',
			),
			'more-btn'   => array(
				'name'  => esc_html__( 'Load more button', 'basel' ),
				'value' => 'more-btn',
			),
			'infinit'    => array(
				'name'  => esc_html__( 'Infinit scrolling', 'basel' ),
				'value' => 'infinit',
			),
		),
		'default'     => 'pagination',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'load_more_button_page_url',
		'name'        => esc_html__( 'Keep the page number in the URL', 'basel' ),
		'description' => esc_html__( 'Enable this option if you want to change the page number in the URL when you click on the “Load more” button.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => true,
		'priority'    => 41,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters',
		'name'        => esc_html__( 'Shop filters', 'basel' ),
		'description' => esc_html__( 'Enable shop filters widget\'s area above the products.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_always_open',
		'name'        => esc_html__( 'Shop filters area always opened', 'basel' ),
		'description' => esc_html__( 'If you enable this option the shop filters will be always opened on the shop page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 60,
		'requires'    => array(
			array(
				'key'     => 'shop_filters',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_type',
		'name'        => esc_html__( 'Shop filters content type', 'basel' ),
		'description' => esc_html__( 'You can use widgets or custom HTML block with our Product filters WPBakery element.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'default'     => 'widgets',
		'options'     => array(
			'widgets' => array(
				'name'  => esc_html__( 'Widgets', 'basel' ),
				'value' => 'widgets',
			),
			'content' => array(
				'name'  => esc_html__( 'Custom content', 'basel' ),
				'value' => 'content',
			),
		),
		'priority'    => 70,
		'requires'    => array(
			array(
				'key'     => 'shop_filters',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_content',
		'name'        => esc_html__( 'Shop filters custom content', 'basel' ),
		'description' => esc_html__( 'You can create an HTML Block in Dashboard -> HTML Blocks and add Product filters WPBakery element there.', 'basel' ),
		'type'        => 'select',
		'section'     => 'shop_section',
		'options'     => basel_get_static_blocks_array( true ),
		'priority'    => 80,
		'requires'    => array(
			array(
				'key'     => 'shop_filters_type',
				'compare' => 'equals',
				'value'   => 'content',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_close',
		'name'        => esc_html__( 'Stop close filters after click', 'basel' ),
		'description' => esc_html__( 'This option will prevent filters area from closing when you click on certain filter links.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 90,
		'requires'    => array(
			array(
				'key'     => 'shop_filters_always_open',
				'compare' => 'equals',
				'value'   => false,
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_masonry',
		'name'        => esc_html__( 'Masonry grid', 'basel' ),
		'description' => esc_html__( 'Useful if your products have different height.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 100,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'mini_cart_quantity',
		'name'     => esc_html__( 'Quantity input on shopping cart widget', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'shop_section',
		'default'  => '0',
		'priority' => 101,
	)
);

Options::add_field(
	array(
		'id'          => 'add_to_cart_action',
		'name'        => esc_html__( 'Action after add to cart', 'basel' ),
		'description' => esc_html__( 'Choose between showing informative popup and opening shopping cart widget. Only for shop page.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'options'     => array(
			'popup'   => array(
				'name'  => esc_html__( 'Show popup', 'basel' ),
				'value' => 'popup',
			),
			'widget'  => array(
				'name'  => esc_html__( 'Display widget', 'basel' ),
				'value' => 'widget',
			),
			'nothing' => array(
				'name'  => esc_html__( 'No action', 'basel' ),
				'value' => 'nothing',
			),
		),
		'default'     => 'widget',
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'add_to_cart_action_timeout',
		'name'        => esc_html__( 'Hide widget automatically', 'basel' ),
		'description' => esc_html__( 'After adding to cart the shopping cart widget will be hidden automatically', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 120,
		'requires'    => array(
			array(
				'key'     => 'add_to_cart_action',
				'compare' => 'not_equals',
				'value'   => 'nothing',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'add_to_cart_action_timeout_number',
		'name'        => esc_html__( 'Hide widget after', 'basel' ),
		'description' => esc_html__( 'Set the number of seconds for the shopping cart widget to be displayed after adding to cart', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_section',
		'default'     => 3,
		'min'         => 1,
		'max'         => 20,
		'step'        => 1,
		'priority'    => 130,
		'requires'    => array(
			array(
				'key'     => 'add_to_cart_action',
				'compare' => 'not_equals',
				'value'   => 'nothing',
			),
			array(
				'key'     => 'add_to_cart_action_timeout',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_different_sizes',
		'name'        => esc_html__( 'Products grid with different sizes', 'basel' ),
		'description' => esc_html__( 'In this situation, some of the products will be twice bigger in width than others. Recommended to use with 6 columns grid only.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 20,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_hover',
		'name'        => esc_html__( 'Hover on product', 'basel' ),
		'description' => esc_html__( 'Choose one of those hover effects for products', 'basel' ),
		'type'        => 'select',
		'section'     => 'shop_section',
		'default'     => 'alt',
		'options'     => array(
			'base'     => array(
				'name'  => esc_html__( 'Base', 'basel' ),
				'value' => 'base',
			),
			'alt'      => array(
				'name'  => esc_html__( 'Alternative', 'basel' ),
				'value' => 'alt',
			),
			'button'   => array(
				'name'  => esc_html__( 'Show button on hover on image', 'basel' ),
				'value' => 'button',
			),
			'info'     => array(
				'name'  => esc_html__( 'Full info on hover', 'basel' ),
				'value' => 'info',
			),
			'link'     => array(
				'name'  => esc_html__( 'Button on hover', 'basel' ),
				'value' => 'link',
			),
			'standard' => array(
				'name'  => esc_html__( 'Standard button', 'basel' ),
				'value' => 'standard',
			),
			'excerpt'  => array(
				'name'  => esc_html__( 'With excerpt', 'basel' ),
				'value' => 'excerpt',
			),
			'quick'    => array(
				'name'  => esc_html__( 'Quick shop', 'basel' ),
				'value' => 'quick',
			),
		),
		'priority'    => 140,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'ajax_shop',
		'name'        => esc_html__( 'AJAX shop', 'basel' ),
		'description' => esc_html__( 'Enable AJAX functionality for filters widgets on shop.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 150,
	)
);

Options::add_field(
	array(
		'id'          => 'ajax_scroll',
		'name'        => esc_html__( 'Scroll to top after AJAX', 'basel' ),
		'description' => esc_html__( 'Disable - Enable scroll to top after AJAX.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 160,
	)
);

Options::add_field(
	array(
		'id'          => 'hover_image',
		'name'        => esc_html__( 'Hover image', 'basel' ),
		'description' => esc_html__( 'Disable - Enable hover image for products on the shop page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 170,
	)
);

Options::add_field(
	array(
		'id'       => 'product_title_lines_limit',
		'name'     => esc_html__( 'Product title lines limit', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'shop_section',
		'options'  => array(
			'one'  => array(
				'name'  => esc_html__( 'One line', 'basel' ),
				'value' => 'one',
			),
			'two'  => array(
				'name'  => esc_html__( 'Two line', 'basel' ),
				'value' => 'one',
			),
			'none' => array(
				'name'  => esc_html__( 'None', 'basel' ),
				'value' => 'none',
			),
		),
		'default'  => 'none',
		'priority' => 180,
	)
);

Options::add_field(
	array(
		'id'          => 'grid_stock_progress_bar',
		'name'        => esc_html__( 'Stock progress bar', 'basel' ),
		'description' => esc_html__( 'Display a number of sold and in stock products as a progress bar.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 190,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_countdown',
		'name'        => esc_html__( 'Countdown timer', 'basel' ),
		'description' => esc_html__( 'Show timer for products that have scheduled date for the sale price', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 200,
	)
);

Options::add_field(
	array(
		'id'          => 'quick_view',
		'name'        => esc_html__( 'Quick View', 'basel' ),
		'description' => esc_html__( 'Enable Quick view option. Ability to see the product information with AJAX.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 210,
	)
);

Options::add_field(
	array(
		'id'          => 'quick_view_variable',
		'name'        => esc_html__( 'Show variations on quick view', 'basel' ),
		'description' => esc_html__( 'Enable Quick view option for variable products. Will allow your users to purchase variable products directly from the quick view.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 220,
		'requires'    => array(
			array(
				'key'     => 'quick_view',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'search_categories',
		'name'        => esc_html__( 'Categories dropdown in WOO search form', 'basel' ),
		'description' => esc_html__( 'Display categories select that allows users search products by category', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => '1',
		'priority'    => 230,
	)
);

Options::add_field(
	array(
		'id'          => 'categories_design',
		'name'        => esc_html__( 'Categories design', 'basel' ),
		'description' => esc_html__( 'Choose one of those designs for categories', 'basel' ),
		'type'        => 'select',
		'section'     => 'shop_section',
		'default'     => 'default',
		'options'     => array(
			'default'       => array(
				'name'  => esc_html__( 'Default', 'basel' ),
				'value' => 'default',
			),
			'alt'           => array(
				'name'  => esc_html__( 'Alternative', 'basel' ),
				'value' => 'alt',
			),
			'center'        => array(
				'name'  => esc_html__( 'Center title', 'basel' ),
				'value' => 'center',
			),
			'replace-title' => array(
				'name'  => esc_html__( 'Replace title', 'basel' ),
				'value' => 'replace-title',
			),
		),
		'priority'    => 240,
	)
);

Options::add_field(
	array(
		'id'       => 'hide_categories_product_count',
		'name'     => esc_html__( 'Hide product count on category', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'shop_section',
		'default'  => false,
		'priority' => 250,
	)
);

Options::add_field(
	array(
		'id'          => 'hide_larger_price',
		'name'        => esc_html__( 'Hide "to" price', 'basel' ),
		'description' => esc_html__( 'This option will hide a higher price for variable products and leave only a small one.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_section',
		'default'     => false,
		'priority'    => 251,
	)
);

Options::add_field(
	array(
		'id'          => 'cat_desc_position',
		'name'        => esc_html__( 'Category description position', 'basel' ),
		'description' => esc_html__( 'You can change default products category description position and move it below the products.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_section',
		'options'     => array(
			'before' => array(
				'name'  => esc_html__( 'Before product grid', 'basel' ),
				'value' => 'before',
			),
			'after'  => array(
				'name'  => esc_html__( 'After product grid', 'basel' ),
				'value' => 'after',
			),
		),
		'default'     => 'before',
		'priority'    => 260,
	)
);

Options::add_field(
	array(
		'id'          => 'empty_cart_text',
		'name'        => esc_html__( 'Empty cart text', 'basel' ),
		'description' => esc_html__( 'Text will be displayed if user don\'t add any products to cart', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'section'     => 'shop_section',
		'default'     => 'Before proceed to checkout you must add some products to your shopping cart.<br> You will find a lot of interesting products on our "Shop" page.',
		'priority'    => 270,
	)
);

/**
 * Shop page layout
 */
Options::add_section(
	array(
		'id'       => 'shop_layout_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Shop page layout', 'basel' ),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_layout',
		'name'        => esc_html__( 'Shop Layout', 'basel' ),
		'description' => esc_html__( 'Select main content and sidebar alignment for shop pages.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_layout_section',
		'options'     => array(
			'full-width'    => array(
				'name'  => esc_html__( '1 Column', 'basel' ),
				'value' => 'full-width',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/none.png',
			),
			'sidebar-left'  => array(
				'name'  => esc_html__( '2 Column Left', 'basel' ),
				'value' => 'sidebar-left',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/left.png',
			),
			'sidebar-right' => array(
				'name'  => esc_html__( '2 Column Right', 'basel' ),
				'value' => 'sidebar-right',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/right.png',
			),
		),
		'priority'    => 10,
		'default'     => 'full-width',
	)
);

Options::add_field(
	array(
		'id'          => 'shop_sidebar_width',
		'name'        => esc_html__( 'Sidebar size', 'basel' ),
		'description' => esc_html__( 'You can set different sizes for your shop pages sidebar', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_layout_section',
		'options'     => array(
			2 => array(
				'name'  => esc_html__( 'Small', 'basel' ),
				'value' => 2,
			),
			3 => array(
				'name'  => esc_html__( 'Medium', 'basel' ),
				'value' => 3,
			),
			4 => array(
				'name'  => esc_html__( 'Large', 'basel' ),
				'value' => 4,
			),
		),
		'priority'    => 20,
		'default'     => 3,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar_mobile',
		'name'        => esc_html__( 'Off canvas sidebar for mobile', 'basel' ),
		'description' => esc_html__( 'You can can hide sidebar and show nicely on button click on the shop page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => '1',
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'shop_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar_tablet',
		'name'        => esc_html__( 'Off canvas sidebar for tablet', 'basel' ),
		'description' => esc_html__( 'You can can hide sidebar and show nicely on button click on the shop page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => '1',
		'priority'    => 40,
		'requires'    => array(
			array(
				'key'     => 'shop_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar_desktop',
		'name'        => esc_html__( 'Off canvas sidebar for desktop', 'basel' ),
		'description' => esc_html__( 'You can can hide sidebar and show nicely on button click on the shop page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => false,
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'shop_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_filter_button',
		'name'        => esc_html__( 'Sticky off canvas sidebar button', 'basel' ),
		'description' => esc_html__( 'Display the filters button fixed on the screen for mobile and tablet devices.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => false,
		'priority'    => 51,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_title',
		'name'        => esc_html__( 'Shop title', 'basel' ),
		'description' => esc_html__( 'Show title for shop page, product categories or tags.', 'basel' ),
		'group'       => esc_html__( 'Shop page title options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => false,
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_categories',
		'name'        => esc_html__( 'Categories in page title', 'basel' ),
		'description' => esc_html__( 'This categories menu is generated automatically based on all categories in the shop. You are not able to manage this menu as other WordPress menus.', 'basel' ),
		'group'       => esc_html__( 'Shop page title options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => '1',
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_categories_ancestors',
		'name'        => esc_html__( 'Show current category ancestors', 'basel' ),
		'description' => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'basel' ),
		'group'       => esc_html__( 'Shop page title options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => false,
		'priority'    => 80,
		'requires'    => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'show_categories_neighbors',
		'name'        => esc_html__( 'Show category neighbors if there is no children', 'basel' ),
		'description' => esc_html__( 'If the category you visit doesn\'t contain any subcategories, the page title menu will display this category\'s neighbors categories.', 'basel' ),
		'group'       => esc_html__( 'Shop page title options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_layout_section',
		'default'     => false,
		'priority'    => 90,
		'requires'    => array(
			array(
				'key'     => 'shop_categories_ancestors',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'shop_page_title_hide_empty_categories',
		'name'     => esc_html__( 'Hіde empty categories', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'shop_layout_section',
		'default'  => false,
		'requires' => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority' => 91,
	)
);

Options::add_field(
	array(
		'id'           => 'shop_page_title_categories_exclude',
		'type'         => 'select',
		'section'      => 'shop_layout_section',
		'name'         => esc_html__( 'Exclude categories', 'basel' ),
		'select2'      => true,
		'empty_option' => true,
		'multiple'     => true,
		'autocomplete' => array(
			'type'   => 'term',
			'value'  => 'product_cat',
			'search' => 'basel_get_taxonomies_by_query_autocomplete',
			'render' => 'basel_get_taxonomies_by_ids_autocomplete',
		),
		'requires'     => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
			array(
				'key'     => 'shop_categories_ancestors',
				'compare' => 'not_equals',
				'value'   => true,
			),
		),
		'priority'     => 92,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_view',
		'name'        => esc_html__( 'Shop products view', 'basel' ),
		'description' => esc_html__( 'You can set different view mode for the shop page', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_layout_section',
		'options'     => array(
			'grid'      => array(
				'name'  => esc_html__( 'Grid', 'basel' ),
				'value' => 'grid',
			),
			'list'      => array(
				'name'  => esc_html__( 'List', 'basel' ),
				'value' => 'list',
			),
			'grid_list' => array(
				'name'  => esc_html__( 'Grid / List', 'basel' ),
				'value' => 'grid_list',
			),
			'list_grid' => array(
				'name'  => esc_html__( 'List / Grid', 'basel' ),
				'value' => 'list_grid',
			),
		),
		'default'     => 'grid',
		'priority'    => 52,
	)
);

/**
 * Attribute swatches
 */
Options::add_section(
	array(
		'id'       => 'shop_swatches_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Attribute swatches', 'basel' ),
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'           => 'grid_swatches_attribute',
		'name'         => esc_html__( 'Grid swatch attribute to display', 'basel' ),
		'description'  => esc_html__( 'Choose attribute that will be shown on products grid', 'basel' ),
		'type'         => 'select',
		'section'      => 'shop_swatches_section',
		'options'      => basel_product_attributes_array(),
		'default'      => 'pa_color',
		'priority'     => 10,
		'empty_option' => true,
	)
);

Options::add_field(
	array(
		'id'          => 'swatches_use_variation_images',
		'name'        => esc_html__( 'Use images from product variations', 'basel' ),
		'description' => esc_html__( 'If enabled swatches buttons will be filled with images choosed for product variations and not with images uploaded to attribute terms.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_swatches_section',
		'default'     => false,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'swatches_limit',
		'name'     => esc_html__( 'Limit swatches on grid', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'shop_swatches_section',
		'default'  => false,
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'swatches_limit_count',
		'name'     => esc_html__( 'Number of visible swatches', 'basel' ),
		'type'     => 'range',
		'section'  => 'shop_swatches_section',
		'default'  => 5,
		'min'      => 1,
		'step'     => 1,
		'max'      => 20,
		'priority' => 40,
		'requires' => array(
			array(
				'key'     => 'swatches_limit',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

/**
 * Brands
 */
Options::add_section(
	array(
		'id'       => 'shop_brand_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Brands', 'basel' ),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'           => 'brands_attribute',
		'name'         => esc_html__( 'Brand attribute', 'basel' ),
		'description'  => esc_html__( 'If you want to show brand image on your product page select desired attribute here', 'basel' ),
		'type'         => 'select',
		'section'      => 'shop_brand_section',
		'options'      => basel_product_attributes_array(),
		'priority'     => 10,
		'default'      => 'pa_brand',
		'empty_option' => true,
	)
);

Options::add_field(
	array(
		'id'          => 'product_page_brand',
		'name'        => esc_html__( 'Show brand on the single product page', 'basel' ),
		'description' => esc_html__( 'You can disable/enable product\'s brand image on the single page.', 'basel' ),
		'group'       => esc_html__( 'Brand on the single product page', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_brand_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'product_brand_location',
		'name'        => esc_html__( 'Brand position on the product page', 'basel' ),
		'description' => esc_html__( 'Select a position of the brand image on the single product page.', 'basel' ),
		'group'       => esc_html__( 'Brand on the single product page', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_brand_section',
		'options'     => array(
			'about_title' => array(
				'name'  => esc_html__( 'Above product title', 'basel' ),
				'value' => 'about_title',
			),
			'sidebar'     => array(
				'name'  => esc_html__( 'Sidebar', 'basel' ),
				'value' => 'sidebar',
			),
		),
		'priority'    => 30,
		'default'     => 'about_title',
	)
);

Options::add_field(
	array(
		'id'          => 'brand_tab',
		'name'        => esc_html__( 'Show tab with brand information', 'basel' ),
		'description' => esc_html__( 'If enabled you will see additional tab with brand description on the single product page. Text will be taken from "Description" field for each brand (attribute term).', 'basel' ),
		'group'       => esc_html__( 'Brand on the single product page', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_brand_section',
		'default'     => '1',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'brand_tab_name',
		'name'        => esc_html__( 'Use brand name for tab title', 'basel' ),
		'description' => esc_html__( 'If you enable this option, the tab with brand\'s information will be called like "About Nike".', 'basel' ),
		'group'       => esc_html__( 'Brand on the single product page', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_brand_section',
		'default'     => false,
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'brand_tab',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'brands_under_title',
		'name'     => esc_html__( 'Show product brands next to title', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'shop_brand_section',
		'default'  => false,
		'priority' => 60,
	)
);

/**
 * My Account
 */
Options::add_section(
	array(
		'id'       => 'shop_account_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'My Account', 'basel' ),
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'login_tabs',
		'name'        => esc_html__( 'Login page tabs', 'basel' ),
		'description' => esc_html__( 'Enable tabs for login and register forms', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_account_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'reg_title',
		'name'     => esc_html__( 'Registration title', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'shop_account_section',
		'default'  => 'Register',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'reg_text',
		'name'        => esc_html__( 'Registration text', 'basel' ),
		'description' => esc_html__( 'Show some information about registration on your web-site', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'shop_account_section',
		'default'     => 'Registering for this site allows you to access your order status and history. Just fill in the fields below, and we\'ll get a new account set up for you in no time. We will only ask you for information necessary to make the purchase process faster and easier.',
		'priority'    => 30,
	)
);


Options::add_field(
	array(
		'id'       => 'login_title',
		'name'     => esc_html__( 'Login title', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'shop_account_section',
		'default'  => 'Login',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'login_text',
		'name'        => esc_html__( 'Login text', 'basel' ),
		'description' => esc_html__( 'Show some information about login on your web-site', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'shop_account_section',
		'default'     => '',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'my_account_links',
		'name'        => esc_html__( 'Dashboard icons menu', 'basel' ),
		'description' => esc_html__( 'Adds icons blocks to the my account page as a navigation.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_account_section',
		'default'     => '1',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'my_account_wishlist',
		'name'        => esc_html__( 'Wishlist on my account page', 'basel' ),
		'description' => esc_html__( 'Add wishlist item to default WooCommerce account navigation.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_account_section',
		'default'     => '1',
		'priority'    => 70,
	)
);

/**
 * Compare
 */
Options::add_section(
	array(
		'id'       => 'shop_compare_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Compare', 'basel' ),
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'compare',
		'name'        => esc_html__( 'Enable compare', 'basel' ),
		'description' => esc_html__( 'Enable compare functionality built in with the theme. Read more information in our documentation.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_compare_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'compare_page',
		'name'         => esc_html__( 'Compare page', 'basel' ),
		'description'  => esc_html__( 'Select a page for compare table. It should contain the shortcode shortcode: [basel_compare]', 'basel' ),
		'type'         => 'select',
		'section'      => 'shop_compare_section',
		'options'      => basel_get_pages_array(),
		'empty_option' => true,
		'default'      => 1274,
		'priority'     => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'compare_on_grid',
		'name'        => esc_html__( 'Show button on product grid', 'basel' ),
		'description' => esc_html__( 'Display compare product button on all products grids and lists.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_compare_section',
		'default'     => '1',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'fields_compare',
		'name'        => esc_html__( 'Select fields for compare table', 'basel' ),
		'description' => esc_html__( 'Choose which fields should be presented on the product compare page with table.', 'basel' ),
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'section'     => 'shop_compare_section',
		'options'     => basel_compare_available_fields( true ),
		'default'     => array(
			'description',
			'sku',
			'availability',
		),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'empty_compare_text',
		'name'        => esc_html__( 'Empty compare text', 'basel' ),
		'description' => esc_html__( 'Text will be displayed if user don\'t add any products to compare', 'basel' ),
		'default'     => 'No products added in the compare list. You must add some products to compare them.<br> You will find a lot of interesting products on our "Shop" page.',
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'section'     => 'shop_compare_section',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'header_compare',
		'type'     => 'switcher',
		'name'     => esc_html__( 'Display compare icon in header', 'basel' ),
		'section'  => 'shop_compare_section',
		'default'  => '0',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'compare_product_count',
		'type'     => 'switcher',
		'name'     => esc_html__( 'Product count label', 'basel' ),
		'section'  => 'shop_compare_section',
		'requires' => array(
			array(
				'key'     => 'header_compare',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => '1',
		'priority' => 70,
	)
);

/**
 * Wishlist (60)
 */

/**
 * Catalog mode
 */
Options::add_section(
	array(
		'id'       => 'shop_catalog_mode_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Catalog mode', 'basel' ),
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'catalog_mode',
		'name'        => esc_html__( 'Enable catalog mode', 'basel' ),
		'description' => esc_html__( 'You can hide all "Add to cart" buttons, cart widget, cart and checkout pages. This will allow you to showcase your products as an online catalog without ability to make a purchase.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_catalog_mode_section',
		'default'     => false,
		'priority'    => 10,
	)
);

/**
 * Login to see prices
 */
Options::add_section(
	array(
		'id'       => 'shop_login_prices_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Login to see prices', 'basel' ),
		'priority' => 80,
		'icon'     => 'dashicons dashicons-cart',
	)
);

Options::add_field(
	array(
		'id'          => 'login_prices',
		'name'        => esc_html__( 'Login to see add to cart and prices', 'basel' ),
		'description' => esc_html__( 'You can restrict shopping functions only for logged in customers.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_login_prices_section',
		'default'     => false,
		'priority'    => 10,
	)
);

/**
 * Cookie
 */
Options::add_section(
	array(
		'id'       => 'shop_cookie_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Cookie Law Info', 'basel' ),
		'priority' => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'cookies_info',
		'name'        => esc_html__( 'Show cookies info', 'basel' ),
		'description' => esc_html__( 'Under EU privacy regulations, websites must make it clear to visitors what information about them is being stored. This specifically includes cookies. Turn on this option and user will see info box at the bottom of the page that your web-site is using cookies.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_cookie_section',
		'default'     => true,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'cookies_text',
		'name'        => esc_html__( 'Popup text', 'basel' ),
		'description' => esc_html__( 'Place here some information about cookies usage that will be shown in the popup.', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'shop_cookie_section',
		'default'     => esc_html__( 'We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.', 'basel' ),
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'           => 'cookies_policy_page',
		'name'         => esc_html__( 'Page with details', 'basel' ),
		'description'  => esc_html__( 'Choose page that will contain detailed information about your Privacy Policy', 'basel' ),
		'type'         => 'select',
		'section'      => 'shop_cookie_section',
		'options'      => basel_get_pages_array(),
		'empty_option' => true,
		'priority'     => 30,
	)
);

Options::add_field(
	array(
		'id'           => 'cookies_version',
		'name'         => esc_html__( 'Cookies version', 'basel' ),
		'description'  => esc_html__( 'If you change your cookie policy information you can increase their version to show the popup to all visitors again.', 'basel' ),
		'type'         => 'text_input',
		'section'      => 'shop_cookie_section',
		'empty_option' => true,
		'default'      => 1,
		'priority'     => 40,
	)
);

/**
 * Popup
 */
Options::add_section(
	array(
		'id'       => 'shop_popup_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Promo popup', 'basel' ),
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'promo_popup',
		'name'        => esc_html__( 'Enable promo popup', 'basel' ),
		'description' => esc_html__( 'Show promo popup to users when they enter the site.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_popup_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'popup_text',
		'name'        => esc_html__( 'Promo popup text', 'basel' ),
		'description' => esc_html__( 'Place here some promo text or use HTML block and place here it\'s shortcode', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'default'     => '
<div class="vc_row">
	<div class="vc_column_container vc_col-sm-6">
		<div class="vc_column-inner ">
			<figure style="margin: -20px;">
				<img src="http://placehold.it/760x800" alt="placeholder">
			</figure>
		</div>
	</div>
	<div class="vc_column_container vc_col-sm-6">
		<div style="padding: 70px 25px 70px 40px;">
			<h1 style="margin-bottom: 0; text-align: center;"><strong>HELLO USER, JOIN OUR</strong></h1>
			<h1 style="text-align: center;"><strong>NEWSLETTER<span style="color: #0f8a7e;"> BASEL &amp; CO.</span></strong></h1>
			<p style="text-align: center; font-size: 16px;">Be the first to learn about our latest trends and get exclusive offers.</p>
			[mc4wp_form id="173"]
		</div>
	</div>
</div>
				',
		'section'     => 'shop_popup_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'popup_event',
		'name'     => esc_html__( 'Show popup after', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'shop_popup_section',
		'default'  => 'time',
		'options'  => array(
			'time'   => array(
				'name'  => esc_html__( 'some time', 'basel' ),
				'value' => 'time',
			),
			'scroll' => array(
				'name'  => esc_html__( 'user scroll', 'basel' ),
				'value' => 'scroll',
			),
		),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'           => 'promo_timeout',
		'name'         => esc_html__( 'Popup delay', 'basel' ),
		'description'  => esc_html__( 'Show popup after some time (in milliseconds)', 'basel' ),
		'type'         => 'text_input',
		'section'      => 'shop_popup_section',
		'empty_option' => true,
		'default'      => '2000',
		'priority'     => 40,
		'requires'     => array(
			array(
				'key'     => 'popup_event',
				'compare' => 'equals',
				'value'   => 'time',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'popup_scroll',
		'name'        => esc_html__( 'Show after user scroll down the page', 'basel' ),
		'description' => esc_html__( 'Set the number of pixels users have to scroll down before popup opens', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_popup_section',
		'default'     => 1000,
		'min'         => 100,
		'step'        => 50,
		'max'         => 5000,
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'popup_event',
				'compare' => 'equals',
				'value'   => 'scroll',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'promo_version',
		'name'        => esc_html__( 'Popup version', 'basel' ),
		'description' => esc_html__( 'If you change your promo popup you can increase its version to show the popup to all visitors again.', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'shop_popup_section',
		'default'     => 1,
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'popup_pages',
		'name'        => esc_html__( 'Show after number of pages visited', 'basel' ),
		'description' => esc_html__( 'You can choose how much pages user should change before popup will be shown.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_popup_section',
		'default'     => 0,
		'min'         => 0,
		'step'        => 1,
		'max'         => 10,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'popup-background',
		'name'        => esc_html__( 'Popup background', 'basel' ),
		'description' => esc_html__( 'Set background image or color for promo popup', 'basel' ),
		'type'        => 'background',
		'section'     => 'shop_popup_section',
		'selector'    => '.basel-promo-popup',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'popup_width',
		'name'        => esc_html__( 'Popup width', 'basel' ),
		'description' => esc_html__( 'Set width of the promo popup in pixels.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_popup_section',
		'default'     => 900,
		'min'         => 400,
		'step'        => 10,
		'max'         => 1000,
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'promo_popup_hide_mobile',
		'name'        => esc_html__( 'Hide for mobile devices', 'basel' ),
		'description' => esc_html__( 'You can disable this option for mobile devices completely.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_popup_section',
		'default'     => '1',
		'priority'    => 100,
	)
);

/**
 * Header banner
 */
Options::add_section(
	array(
		'id'       => 'shop_header_banner_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Header banner', 'basel' ),
		'priority' => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner',
		'name'        => esc_html__( 'Header banner', 'basel' ),
		'description' => esc_html__( 'Header banner above the header', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_header_banner_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_link',
		'name'        => esc_html__( 'Banner link', 'basel' ),
		'description' => esc_html__( 'The link will be added to the whole banner area.', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'shop_header_banner_section',
		'tags'        => 'header banner text link',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_shortcode',
		'name'        => esc_html__( 'Banner content', 'basel' ),
		'description' => esc_html__( 'Place here shortcodes you want to see in the banner above the header. You can use shortcodes. Ex.: [social_buttons] or place an HTML Block built with WPBakery Page Builder builder there like [html_block id="258"]', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'shop_header_banner_section',
		'tags'        => 'header banner text content',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_height',
		'name'        => esc_html__( 'Banner height for desktop', 'basel' ),
		'description' => esc_html__( 'The height for the banner area in pixels on desktop devices.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_header_banner_section',
		'default'     => 40,
		'min'         => 0,
		'step'        => 1,
		'max'         => 200,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_mobile_height',
		'name'        => esc_html__( 'Banner height for mobile', 'basel' ),
		'description' => esc_html__( 'The height for the banner area in pixels on mobile devices.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_header_banner_section',
		'default'     => 40,
		'min'         => 0,
		'step'        => 1,
		'max'         => 200,
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_color',
		'name'        => esc_html__( 'Banner text color', 'basel' ),
		'description' => esc_html__( 'Set light or dark text color scheme depending on the banner\'s background color.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'shop_header_banner_section',
		'default'     => 'light',
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
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'header_banner_bg',
		'name'     => esc_html__( 'Banner background', 'basel' ),
		'type'     => 'background',
		'section'  => 'shop_header_banner_section',
		'selector' => '.header-banner',
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'header_close_btn',
		'name'        => esc_html__( 'Close button', 'basel' ),
		'description' => esc_html__( 'Show close banner button', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_header_banner_section',
		'default'     => '1',
		'tags'        => 'header banner color background',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'header_banner_version',
		'name'        => esc_html__( 'Banner version', 'basel' ),
		'description' => esc_html__( 'If you change your banner you can increase their version to show the banner to all visitors again.', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'shop_header_banner_section',
		'default'     => '1',
		'priority'    => 90,
		'requires'    => array(
			array(
				'key'     => 'header_close_btn',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

/**
 * Widgets
 */
Options::add_section(
	array(
		'id'       => 'shop_widgets_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Widgets', 'basel' ),
		'priority' => 120,
	)
);

Options::add_field(
	array(
		'id'          => 'categories_toggle',
		'name'        => esc_html__( 'Toggle function for categories widget', 'basel' ),
		'description' => esc_html__( 'Turn it on to enable accordion JS for the WooCommerce Product Categories widget. Useful if you have a lot of categories and subcategories.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_widgets_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'widgets_scroll',
		'name'        => esc_html__( 'Scroll for filters widgets', 'basel' ),
		'description' => esc_html__( 'You can limit your Layered Navigation widgets by height and enable nice scroll for them. Useful if you have a lot of product colors/sizes or other attributes for filters.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_widgets_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'widget_heights',
		'name'        => esc_html__( 'Height for filters widgets', 'basel' ),
		'description' => esc_html__( 'Set widgets height in pixels.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_widgets_section',
		'default'     => 280,
		'min'         => 100,
		'step'        => 1,
		'max'         => 800,
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'widgets_scroll',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

/**
 * Product labels
 */
Options::add_section(
	array(
		'id'       => 'shop_labels_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Product labels', 'basel' ),
		'priority' => 130,
	)
);

Options::add_field(
	array(
		'id'       => 'label_shape',
		'name'     => esc_html__( 'Label shape', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'shop_labels_section',
		'default'  => 'rounded',
		'options'  => array(
			'rounded'     => array(
				'name'  => esc_html__( 'Rounded', 'basel' ),
				'value' => 'rounded',
			),
			'rectangular' => array(
				'name'  => esc_html__( 'Rectangular', 'basel' ),
				'value' => 'rectangular',
			),
		),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'percentage_label',
		'name'        => esc_html__( 'Shop sale label in percentage', 'basel' ),
		'description' => esc_html__( 'Works with Simple, Variable and External products only.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_labels_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'new_label',
		'name'        => esc_html__( '"New" label on products', 'basel' ),
		'description' => esc_html__( 'This label is displayed for products if you enabled this option for particular items.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_labels_section',
		'default'     => '1',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'new_label_days_after_create',
		'name'        => esc_html__( 'Automatic "New" label period', 'basel' ),
		'description' => esc_html__( 'Set a number of days to keep your products marked as "New" after creation.', 'basel' ),
		'type'        => 'range',
		'section'     => 'shop_labels_section',
		'default'     => 0,
		'min'         => 0,
		'max'         => 365,
		'step'        => 1,
		'priority'    => 31,
	)
);

Options::add_field(
	array(
		'id'          => 'hot_label',
		'name'        => esc_html__( '"Hot" label on products', 'basel' ),
		'description' => esc_html__( 'Your products marked as "Featured" will have a badge with "Hot" label.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'shop_labels_section',
		'default'     => '1',
		'priority'    => 40,
	)
);

Options::add_section(
	array(
		'id'       => 'thank_you_page_section',
		'parent'   => 'shop_section',
		'name'     => esc_html__( 'Thank you page', 'basel' ),
		'priority' => 140,
	)
);

Options::add_field(
	array(
		'id'          => 'thank_you_page_extra_content',
		'name'        => esc_html__( 'Extra content for "Thank you page"', 'basel' ),
		'description' => esc_html__( 'Add any extra content to the order received page', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'thank_you_page_section',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'thank_you_page_default_content',
		'name'        => esc_html__( 'Default "Thank you page" content', 'basel' ),
		'description' => esc_html__( 'If you use custom extra content you can disable default WooCommerce order details on the thank you page', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'thank_you_page_section',
		'default'     => '1',
		'priority'    => 20,
	)
);
