<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * Portfolio
 */
Options::add_section(
	array(
		'id'       => 'portfolio',
		'name'     => esc_html__( 'Portfolio', 'basel' ),
		'priority' => 80,
		'icon'     => 'dashicons dashicons-grid-view',
	)
);

Options::add_field(
	array(
		'id'          => 'disable_portfolio',
		'name'        => esc_html__( 'Disable portfolio', 'basel' ),
		'description' => esc_html__( 'You can disable the custom post type for portfolio projects completely.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'portfolio',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_item_slug',
		'name'        => esc_html__( 'Portfolio project URL slug', 'basel' ),
		'description' => esc_html__( 'IMPORTANT: You need to go to WordPress Settings -> Pemalinks and resave them to apply these settings.', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'portfolio',
		'priority'    => 11,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_cat_slug',
		'name'        => esc_html__( 'Portfolio category URL slug', 'basel' ),
		'description' => esc_html__( 'IMPORTANT: You need to go to WordPress Settings -> Pemalinks and resave them to apply these settings.', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'portfolio',
		'priority'    => 12,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_style',
		'name'        => esc_html__( 'Portfolio Style', 'basel' ),
		'description' => esc_html__( 'You can use different styles for your projects.', 'basel' ),
		'type'        => 'select',
		'section'     => 'portfolio',
		'options'     => array(
			'hover'         => array(
				'name'  => esc_html__( 'Show text on mouse over', 'basel' ),
				'value' => 'hover',
			),
			'hover-inverse' => array(
				'name'  => esc_html__( 'Alternative', 'basel' ),
				'value' => 'hover-inverse',
			),
			'bordered' => array(
				'name'  => esc_html__( 'Bordered style', 'basel' ),
				'value' => 'bordered',
			),
			'bordered-inverse' => array(
				'name'  => esc_html__( 'Bordered inverse', 'basel' ),
				'value' => 'bordered-inverse',
			),
			'text-shown' => array(
				'name'  => esc_html__( 'Text under image', 'basel' ),
				'value' => 'text-shown',
			),
			'with-bg' => array(
				'name'  => esc_html__( 'Text with background', 'basel' ),
				'value' => 'with-bg',
			),
			'with-bg-alt' => array(
				'name'  => esc_html__( 'Text with background alternative', 'basel' ),
				'value' => 'with-bg-alt',
			),
		),
		'default'     => 'hover',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_filters',
		'name'        => esc_html__( 'Show categories filters', 'basel' ),
		'description' => esc_html__( 'Display categories list that allows you to filter your portfolio projects with animation on click.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'portfolio',
		'default'     => '1',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_nav_color_scheme',
		'name'        => esc_html__( 'Color scheme for filters', 'basel' ),
		'description' => esc_html__( 'You can change colors of links in portfolio filters.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'select',
		'section'     => 'portfolio',
		'options'     => array(
			'dark' => array(
				'name'  => esc_html__( 'Dark', 'basel' ),
				'value' => 'dark',
			),
			'light'  => array(
				'name'  => esc_html__( 'Light', 'basel' ),
				'value' => 'light',
			),
		),
		'default'     => 'dark',
		'priority'    => 31,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_nav_background',
		'type'        => 'background',
		'section'     => 'portfolio',
		'tags'        => 'portfolio navigation background color filter',
		'name'        => esc_html__( 'Filter background', 'xts_theme' ),
		'selector'    => '.portfolio-filter',
		'priority'    => 32,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_full_width',
		'name'        => esc_html__( 'Full Width portfolio', 'basel' ),
		'description' => esc_html__( 'Makes container 100% width of the page', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'portfolio',
		'default'     => false,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'projects_columns',
		'name'        => esc_html__( 'Projects columns', 'basel' ),
		'description' => esc_html__( 'How many projects you want to show per row', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'portfolio',
		'options'     => array(
			2 => array(
				'name'  => '2',
				'value' => 2,
			),
			3 => array(
				'name'  => '3',
				'value' => 3,
			),
			4 => array(
				'name'  => '4',
				'value' => 4,
			),
			6 => array(
				'name'  => '6',
				'value' => 6,
			),
		),
		'default'     => 3,
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_spacing',
		'name'        => esc_html__( 'Space between projects', 'basel' ),
		'description' => esc_html__( 'You can set different spacing between blocks on portfolio page', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'portfolio',
		'options'     => array(
			0  => array(
				'name'  => '0',
				'value' => 0,
			),
			2  => array(
				'name'  => '2',
				'value' => 2,
			),
			6  => array(
				'name'  => '5',
				'value' => 6,
			),
			10 => array(
				'name'  => '10',
				'value' => 10,
			),
			20 => array(
				'name'  => '20',
				'value' => 20,
			),
			30 => array(
				'name'  => '30',
				'value' => 30,
			),
		),
		'default'     => 30,
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_per_page',
		'name'        => esc_html__( 'Items per page', 'basel' ),
		'description' => esc_html__( 'Number of portfolio projects that will be displayed on one page.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'portfolio',
		'default'     => 12,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_pagination',
		'name'        => esc_html__( 'Portfolio pagination', 'basel' ),
		'description' => esc_html__( 'Choose a type for the pagination on your portfolio page.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'portfolio',
		'options'     => array(
			'pagination' => array(
				'name'  => esc_html__( 'Pagination links', 'basel' ),
				'value' => 'pagination',
			),
			'load_more'  => array(
				'name'  => esc_html__( 'Load more button', 'basel' ),
				'value' => 'load_more',
			),
			'infinit'    => array(
				'name'  => esc_html__( 'Infinit scrolling', 'basel' ),
				'value' => 'infinit',
			),
		),
		'default'     => 'pagination',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_orderby',
		'name'        => esc_html__( 'Portfolio order by', 'basel' ),
		'description' => esc_html__( 'Select a parameter for projects order.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'select',
		'section'     => 'portfolio',
		'options'     => array(
			'date'       => array(
				'name'  => esc_html__( 'Date', 'basel' ),
				'value' => 'date',
			),
			'ID'         => array(
				'name'  => esc_html__( 'ID', 'basel' ),
				'value' => 'ID',
			),
			'title'      => array(
				'name'  => esc_html__( 'Title', 'basel' ),
				'value' => 'title',
			),
			'modified'   => array(
				'name'  => esc_html__( 'Modified', 'basel' ),
				'value' => 'modified',
			),
			'menu_order' => array(
				'name'  => esc_html__( 'Menu order', 'basel' ),
				'value' => 'menu_order',
			),
		),
		'default'     => 'date',
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'portoflio_order',
		'name'        => esc_html__( 'Portfolio order', 'basel' ),
		'description' => esc_html__( 'Choose ascending or descending order.', 'basel' ),
		'group'       => esc_html__( 'Project options', 'basel' ),
		'type'        => 'select',
		'section'     => 'portfolio',
		'options'     => array(
			'DESC' => array(
				'name'  => esc_html__( 'DESC', 'basel' ),
				'value' => 'DESC',
			),
			'ASC'  => array(
				'name'  => esc_html__( 'ASC', 'basel' ),
				'value' => 'ASC',
			),
		),
		'default'     => 'DESC',
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'portfolio_related',
		'name'        => esc_html__( 'Related Projects', 'basel' ),
		'description' => esc_html__( 'Show related projects carousel.', 'basel' ),
		'group'       => esc_html__( 'Single project options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'portfolio',
		'default'     => '1',
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'single_portfolio_title_in_page_title',
		'name'        => esc_html__( 'Project title in page heading', 'basel' ),
		'description' => esc_html__( 'Display project title instead of portfolio page title in page heading', 'basel' ),
		'group'       => esc_html__( 'Single project options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'portfolio',
		'default'     => false,
		'priority'    => 120,
	)
);