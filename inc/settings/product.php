<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * Product page
 */
Options::add_section(
	array(
		'id'       => 'product',
		'name'     => esc_html__( 'Product page', 'basel' ),
		'priority' => 100,
		'icon'     => 'dashicons dashicons-products',
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_layout',
		'name'        => esc_html__( 'Single Product Sidebar', 'basel' ),
		'description' => esc_html__( 'Select main content and sidebar alignment for single product pages.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
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
		'default'     => 'full-width',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'single_sidebar_width',
		'name'        => esc_html__( 'Sidebar size', 'basel' ),
		'description' => esc_html__( 'You can set different sizes for your single product pages sidebar', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
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
		'default'     => 3,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'product_design',
		'name'        => esc_html__( 'Product page design', 'basel' ),
		'description' => esc_html__( 'Choose between different predefined designs', 'basel' ),
		'type'        => 'select',
		'section'     => 'product',
		'options'     => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'basel' ),
				'value' => 'default',
			),
			'alt'     => array(
				'name'  => esc_html__( 'Alternative', 'basel' ),
				'value' => 'alt',
			),
			'sticky'  => array(
				'name'  => esc_html__( 'Images scroll', 'basel' ),
				'value' => 'sticky',
			),
			'compact' => array(
				'name'  => esc_html__( 'Compact', 'basel' ),
				'value' => 'compact',
			),
		),
		'default'     => 'default',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_style',
		'name'        => esc_html__( 'Product image width', 'basel' ),
		'description' => esc_html__( 'You can choose different page layout depending on the product image size you need', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
		'options'     => array(
			1 => array(
				'name'  => esc_html__( 'Small image', 'basel' ),
				'value' => 1,
			),
			2 => array(
				'name'  => esc_html__( 'Medium', 'basel' ),
				'value' => 2,
			),
			3 => array(
				'name'  => esc_html__( 'Large', 'basel' ),
				'value' => 3,
			),
		),
		'requires'    => array(
			array(
				'key'     => 'product_design',
				'compare' => 'not_equals', // equals
				'value'   => 'sticky',
			),
		),
		'default'     => 2,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'thums_position',
		'name'        => esc_html__( 'Thumbnails position', 'basel' ),
		'description' => esc_html__( 'Use vertical or horizontal position for thumbnails', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
		'options'     => array(
			'left'   => array(
				'name'  => esc_html__( 'Left (vertical position)', 'basel' ),
				'value' => 'left',
			),
			'bottom' => array(
				'name'  => esc_html__( 'Bottom (horizontal carousel)', 'basel' ),
				'value' => 'bottom',
			),
		),
		'requires'    => array(
			array(
				'key'     => 'product_design',
				'compare' => 'not_equals', // equals
				'value'   => 'sticky',
			),
		),
		'default'     => 'bottom',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'product_slider_auto_height',
		'name'        => esc_html__( 'Main carousel auto height', 'basel' ),
		'description' => esc_html__( 'Useful when you have product images with different height.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_variations_price',
		'type'        => 'switcher',
		'name'        => esc_html__( 'Remove duplicate price for variable product', 'basel' ),
		'description' => esc_html__( 'When you will select any variation, the price on the single product page will be updated with an actual variation price.', 'basel' ),
		'section'     => 'product',
		'default'     => '0',
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'force_header_full_width',
		'type'     => 'switcher',
		'section'  => 'product',
		'tags'     => 'full width header product page',
		'name'     => esc_html__( 'Force full width header for product page', 'xts_theme' ),
		'requires' => array(
			array(
				'key'     => 'product_design',
				'compare' => 'equals', // equals
				'value'   => 'sticky',
			),
		),
		'default'  => false,
		'priority' => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'variation_gallery',
		'name'        => esc_html__( 'Additional variations images', 'basel' ),
		'description' => esc_html__( 'Add an ability to upload additional images for each variation in variable products.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 81,
	)
);

Options::add_field(
	array(
		'id'          => 'ajax_variation_threshold',
		'name'        => esc_html__( 'AJAX variation threshold', 'basel' ),
		'description' => esc_html__( 'Increase this value if you noticed a problem with additional variations images function.', 'basel' ),
		'type'        => 'range',
		'section'     => 'product',
		'requires'    => array(
			array(
				'key'     => 'variation_gallery',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'     => 30,
		'min'         => 10,
		'max'         => 500,
		'step'        => 1,
		'priority'    => 82,
	)
);

Options::add_field(
	array(
		'id'          => 'image_action',
		'name'        => esc_html__( 'Main image click action', 'basel' ),
		'description' => esc_html__( 'Enable/disable zoom option or switch to photoswipe popup.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
		'options'     => array(
			'zoom'  => array(
				'name'  => esc_html__( 'Zoom', 'basel' ),
				'value' => 'zoom',
			),
			'popup' => array(
				'name'  => esc_html__( 'Photoswipe popup', 'basel' ),
				'value' => 'popup',
			),
			'none'  => array(
				'name'  => esc_html__( 'None', 'basel' ),
				'value' => 'none',
			),
		),
		'default'     => 'zoom',
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'photoswipe_icon',
		'name'        => esc_html__( 'Show "Zoom image" icon', 'basel' ),
		'description' => esc_html__( 'Click to open image in popup and swipe to zoom', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 100,
		'requires'    => array(
			array(
				'key'     => 'image_action',
				'compare' => 'not_equals',
				'value'   => 'zoom',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'product-background',
		'type'        => 'background',
		'section'     => 'product',
		'tags'        => 'color background',
		'name'        => esc_html__( 'Product background', 'xts_theme' ),
		'description' => esc_html__( 'Set background for your products page. You can also specify different background for particular products while editing it.', 'xts_theme' ),
		'selector'    => '.single-product .site-content',
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'product_share',
		'name'        => esc_html__( 'Show share buttons', 'basel' ),
		'description' => esc_html__( 'Display share buttons icons on the single product page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 120,
	)
);

Options::add_field(
	array(
		'id'          => 'product_share_type',
		'name'        => esc_html__( 'Share buttons type', 'basel' ),
		'description' => esc_html__( 'You can switch between share and follow buttons on the single product page.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
		'options'     => array(
			'share'  => array(
				'name'  => esc_html__( 'Share', 'basel' ),
				'value' => 'share',
			),
			'follow' => array(
				'name'  => esc_html__( 'Follow', 'basel' ),
				'value' => 'follow',
			),
		),
		'default'     => 'share',
		'priority'    => 130,
	)
);

Options::add_field(
	array(
		'id'          => 'attr_after_short_desc',
		'name'        => esc_html__( 'Show attributes table after short description', 'basel' ),
		'description' => esc_html__( 'You can display attributes table instead of short description.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 140,
	)
);

Options::add_field(
	array(
		'id'          => 'single_stock_progress_bar',
		'name'        => esc_html__( 'Stock progress bar', 'basel' ),
		'description' => esc_html__( 'Display a number of sold and in stock products as a progress bar.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 150,
	)
);

Options::add_field(
	array(
		'id'          => 'swatches_scroll_top_desktop',
		'name'        => esc_html__( 'Scroll top on variation select [desktop]', 'basel' ),
		'description' => esc_html__( 'When you turn on this option and click on some variation with image, the page will be scrolled up to show that variation image in the main product gallery.', 'basel' ),
		'group'       => esc_html__( 'Single product page layout and style', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 160,
	)
);

Options::add_field(
	array(
		'id'          => 'swatches_scroll_top_mobile',
		'name'        => esc_html__( 'Scroll top on variation select [mobile]', 'basel' ),
		'description' => esc_html__( 'When you turn on this option and click on some variation with image, the page will be scrolled up to show that variation image in the main product gallery.', 'basel' ),
		'group'       => esc_html__( 'Single product page layout and style', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 170,
	)
);

Options::add_field(
	array(
		'id'          => 'product_countdown',
		'name'        => esc_html__( 'Countdown timer', 'basel' ),
		'description' => esc_html__( 'Show timer for products that have scheduled date for the sale price', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 180,
	)
);

Options::add_field(
	array(
		'id'          => 'sale_countdown_variable',
		'name'        => esc_html__( 'Countdown for variable products', 'basel' ),
		'description' => esc_html__( 'Sale end date will be based on the first variation date of the product.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 190,
	)
);

Options::add_field(
	array(
		'id'          => 'hide_tabs_titles',
		'name'        => esc_html__( 'Hide tabs headings', 'basel' ),
		'description' => esc_html__( 'Don\'t show duplicated titles for product tabs.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 200,
	)
);

Options::add_field(
	array(
		'id'       => 'hide_products_nav',
		'name'     => esc_html__( 'Hide products navigation', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'product',
		'default'  => false,
		'priority' => 210,
	)
);

Options::add_field(
	array(
		'id'          => 'product_images_captions',
		'name'        => esc_html__( 'Images captions on Photo Swipe lightbox', 'basel' ),
		'description' => esc_html__( 'Display caption texts below images when you open the photoswipe popup. Captions can be added to your images via the Media library.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 220,
	)
);

Options::add_field(
	array(
		'id'          => 'size_guides',
		'name'        => esc_html__( 'Size guides', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'description' => wp_kses(
			__( 'Turn on the size guide feature on the website. Read more information about this function in <a href="https://xtemos.com/docs/basel/faq-guides/create-size-guide-table/" target="_blank">our documentation</a>.', 'basel' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
			)
		),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 230,
	)
);

Options::add_field(
	array(
		'id'          => 'single_ajax_add_to_cart',
		'name'        => esc_html__( 'AJAX Add to cart', 'basel' ),
		'description' => esc_html__( 'Turn on the AJAX add to cart option on the single product page. Will not work with plugins that add some custom fields to the add to cart form.', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 240,
	)
);

Options::add_field(
	array(
		'id'          => 'single_sticky_add_to_cart',
		'name'        => esc_html__( 'Sticky add to cart', 'basel' ),
		'description' => esc_html__( 'Add to cart section will be displayed at the bottom of your screen when you scroll down the page.', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 250,
	)
);

Options::add_field(
	array(
		'id'          => 'mobile_single_sticky_add_to_cart',
		'name'        => esc_html__( 'Sticky add to cart on mobile', 'basel' ),
		'description' => esc_html__( 'You can leave this option for desktop only or enable it for all devices sizes.', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => false,
		'priority'    => 260,
		'requires'    => array(
			array(
				'key'     => 'single_sticky_add_to_cart',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'content_before_add_to_cart',
		'name'        => esc_html__( 'Before "Add to cart button" text area', 'basel' ),
		'description' => esc_html__( 'Place any text, HTML or shortcodes here.', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'product',
		'priority'    => 270,
	)
);

Options::add_field(
	array(
		'id'          => 'content_after_add_to_cart',
		'name'        => esc_html__( 'After "Add to cart button" text area', 'basel' ),
		'description' => esc_html__( 'Place any text, HTML or shortcodes here.', 'basel' ),
		'group'       => esc_html__( 'Single product page options', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'product',
		'priority'    => 280,
	)
);

Options::add_field(
	array(
		'id'          => 'additional_tab_title',
		'name'        => esc_html__( 'Additional tab title', 'basel' ),
		'description' => esc_html__( 'Leave empty to disable custom tab', 'basel' ),
		'type'        => 'text_input',
		'default'     => 'Shipping & Delivery',
		'section'     => 'product',
		'priority'    => 290,
	)
);

Options::add_field(
	array(
		'id'          => 'additional_tab_text',
		'name'        => esc_html__( 'Additional tab content', 'basel' ),
		'description' => esc_html__( 'You can use any text, HTML or shortcodes here.', 'basel' ),
		'type'        => 'textarea',
		'wysiwyg'     => false,
		'default'     => '
<img src="http://placehold.it/250x200" class="alignleft" /> <p>Vestibulum curae torquent diam diam commodo parturient penatibus nunc dui adipiscing convallis bulum parturient suspendisse parturient a.Parturient in parturient scelerisque nibh lectus quam a natoque adipiscing a vestibulum hendrerit et pharetra fames.Consequat net</p>

<p>Vestibulum parturient suspendisse parturient a.Parturient in parturient scelerisque  nibh lectus quam a natoque adipiscing a vestibulum hendrerit et pharetra fames.Consequat netus.</p>

<p>Scelerisque adipiscing bibendum sem vestibulum et in a a a purus lectus faucibus lobortis tincidunt purus lectus nisl class eros.Condimentum a et ullamcorper dictumst mus et tristique elementum nam inceptos hac vestibulum amet elit</p>

<div class="clearfix"></div>
				',
		'section'     => 'product',
		'priority'    => 300,
	)
);

Options::add_field(
	array(
		'id'          => 'related_products',
		'name'        => esc_html__( 'Show related products', 'basel' ),
		'description' => esc_html__( 'Related Products is a section that pulls products from your store that share the same tags or categories as the current product.', 'basel' ),
		'group'       => esc_html__( 'Related products options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'product',
		'default'     => '1',
		'priority'    => 310,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_count',
		'name'        => esc_html__( 'Related product count', 'basel' ),
		'description' => esc_html__( 'The total number of related products to display.', 'basel' ),
		'group'       => esc_html__( 'Related products options', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'product',
		'default'     => 8,
		'priority'    => 320,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_columns',
		'name'        => esc_html__( 'Related product columns', 'basel' ),
		'description' => esc_html__( 'How many products you want to show per row.', 'basel' ),
		'group'       => esc_html__( 'Related products options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
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
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'     => 4,
		'priority'    => 330,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_view',
		'name'        => esc_html__( 'Related product view', 'basel' ),
		'description' => esc_html__( 'You can set different view mode for the related products. These settings will be applied for upsells products as well.', 'basel' ),
		'group'       => esc_html__( 'Related products options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'product',
		'options'     => array(
			'grid'   => array(
				'name'  => esc_html__( 'Grid', 'basel' ),
				'value' => 'grid',
			),
			'slider' => array(
				'name'  => esc_html__( 'Slider', 'basel' ),
				'value' => 'slider',
			),
		),
		'default'     => 'slider',
		'priority'    => 340,
	)
);
