<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * Blog
 */
Options::add_section(
	array(
		'id'       => 'blog',
		'name'     => esc_html__( 'Blog', 'basel' ),
		'priority' => 70,
		'icon'     => 'dashicons dashicons-welcome-write-blog',
	)
);

Options::add_field(
	array(
		'id'          => 'blog_layout',
		'name'        => esc_html__( 'Blog Layout', 'basel' ),
		'description' => esc_html__( 'Select main content and sidebar alignment for blog pages.', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'blog',
		'options'     => array(
			'full-width'    => array(
				'name'  => esc_html__( '1 Column', 'basel' ),
				'value' => 'full-width',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/none.png',
			),
			'sidebar-left'  => array(
				'name'  => esc_html__( '2 Columns Left', 'basel' ),
				'value' => 'sidebar-left',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/left.png',
			),
			'sidebar-right' => array(
				'name'  => esc_html__( '2 Columns Right', 'basel' ),
				'value' => 'sidebar-right',
				'image' => BASEL_ASSETS_IMAGES . '/settings/sidebar-layout/right.png',
			),
		),
		'default'     => 'sidebar-right',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_sidebar_width',
		'name'        => esc_html__( 'Blog Sidebar size', 'basel' ),
		'description' => esc_html__( 'You can set different sizes for your blog pages sidebar', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'blog',
		'options'     => array(
			2 => array(
				'name'  => esc_html__( 'Small', 'basel' ),
				'value' => 2,
			),
			3 => array(
				'name'  => esc_html__( 'Medium', 'basel' ),
				'value' => 2,
			),
			4 => array(
				'name'  => esc_html__( 'Large', 'basel' ),
				'value' => 2,
			),
		),
		'default'     => 3,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_design',
		'name'        => esc_html__( 'Blog Design', 'basel' ),
		'description' => esc_html__( 'You can use different design for your blog styled for the theme.', 'basel' ),
		'type'        => 'select',
		'section'     => 'blog',
		'options'     => array(
			'default'      => array(
				'name'  => esc_html__( 'Default', 'basel' ),
				'value' => 'default',
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
				'value' => 'masonry',
			),
			'mask'         => array(
				'name'  => esc_html__( 'Mask on image', 'basel' ),
				'value' => 'mask',
			),
		),
		'default'     => 'default',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_columns',
		'name'        => esc_html__( 'Blog items columns', 'basel' ),
		'description' => esc_html__( 'For masonry grid design', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'blog',
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
		'default'     => 3,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_excerpt',
		'name'        => esc_html__( 'Posts excerpt', 'basel' ),
		'description' => esc_html__( 'If you will set this option to "Excerpt" then you are able to set custom excerpt for each post or it will be cutted from the post content. If you choose "Full content" then all content will be shown, or you can also add "Read more button" while editing the post and by doing this cut your excerpt length as you need.', 'basel' ),
		'group'       => esc_html__( 'Blog post options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'blog',
		'options'     => array(
			'excerpt' => array(
				'name'  => esc_html__( 'Excerpt', 'basel' ),
				'value' => 'excerpt',
			),
			'full'    => array(
				'name'  => esc_html__( 'Full content', 'basel' ),
				'value' => 'full',
			),
		),
		'default'     => 'excerpt',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_excerpt_length',
		'name'        => esc_html__( 'Excerpt length', 'basel' ),
		'description' => esc_html__( 'Number of words or letters that will be displayed for each post if you use "Excerpt" mode and don\'t set custom excerpt for each post.', 'basel' ),
		'group'       => esc_html__( 'Blog post options', 'basel' ),
		'type'        => 'text_input',
		'section'     => 'blog',
		'requires'    => array(
			array(
				'key'     => 'blog_excerpt',
				'compare' => 'equals',
				'value'   => array( 'excerpt' ),
			),
		),
		'default'     => 35,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'single_post_design',
		'name'        => esc_html__( 'Single post design', 'basel' ),
		'description' => esc_html__( 'You can use different design for your single post page.', 'basel' ),
		'group'       => esc_html__( 'Single blog post options', 'basel' ),
		'type'        => 'buttons',
		'section'     => 'blog',
		'options'     => array(
			'default'     => array(
				'name'  => esc_html__( 'Default', 'basel' ),
				'value' => 'default',
			),
			'large_image' => array(
				'name'  => esc_html__( 'Large image', 'basel' ),
				'value' => 'large_image',
			),
		),
		'default'     => 'default',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_share',
		'name'        => esc_html__( 'Share buttons', 'basel' ),
		'description' => esc_html__( 'Display share icons on single post page', 'basel' ),
		'group'       => esc_html__( 'Single blog post options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'blog',
		'default'     => '1',
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_navigation',
		'name'        => esc_html__( 'Posts navigation', 'basel' ),
		'description' => esc_html__( 'Next and previous posts links on single post page', 'basel' ),
		'group'       => esc_html__( 'Single blog post options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'blog',
		'default'     => '1',
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_author_bio',
		'name'        => esc_html__( 'Author bio', 'basel' ),
		'description' => esc_html__( 'Display information about the post author', 'basel' ),
		'group'       => esc_html__( 'Single blog post options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'blog',
		'default'     => '1',
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'blog_related_posts',
		'name'        => esc_html__( 'Related posts', 'basel' ),
		'description' => esc_html__( 'Show related posts on single post page (by tags)', 'basel' ),
		'group'       => esc_html__( 'Single blog post options', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'blog',
		'default'     => '1',
		'priority'    => 120,
	)
);
