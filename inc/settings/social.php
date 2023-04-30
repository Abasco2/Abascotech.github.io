<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

/**
 * Share buttons configuration.
 */
Options::add_section(
	array(
		'id'       => 'social_profiles',
		'name'     => esc_html__( 'Social profiles', 'basel' ),
		'priority' => 140,
		'icon'     => 'dashicons dashicons-networking',
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_social',
		'name'        => esc_html__( 'Sticky social links', 'basel' ),
		'description' => esc_html__( 'Social buttons will be fixed on the screen when you scroll the page.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'social_profiles',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'sticky_social_type',
		'name'     => esc_html__( 'Sticky social links type', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'social_profiles',
		'default'  => 'follow',
		'options'  => array(
			'share'  => array(
				'name'  => esc_html__( 'Share', 'basel' ),
				'value' => 'share',
			),
			'follow' => array(
				'name'  => esc_html__( 'Follow', 'basel' ),
				'value' => 'follow',
			),
		),
		'priority' => 20,
		'requires' => array(
			array(
				'key'     => 'sticky_social',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'sticky_social_position',
		'name'     => esc_html__( 'Sticky social links position', 'basel' ),
		'type'     => 'buttons',
		'section'  => 'social_profiles',
		'default'  => 'right',
		'options'  => array(
			'left'  => array(
				'name'  => esc_html__( 'Left', 'basel' ),
				'value' => 'left',
			),
			'right' => array(
				'name'  => esc_html__( 'Right', 'basel' ),
				'value' => 'right',
			),
		),
		'priority' => 20,
		'requires' => array(
			array(
				'key'     => 'sticky_social',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_section(
	array(
		'id'       => 'social_links',
		'parent'   => 'social_profiles',
		'name'     => esc_html__( 'Links to social profiles', 'basel' ),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'social_follow_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => esc_html__( 'Configurate your [social_buttons] shortcode. You can leave field empty to remove particular link. Note that there are two types of social buttons. First one is SHARE buttons [social_buttons type="share"]. It displays icons that share your page in social media. And the second one is FOLLOW buttons [social_buttons type="follow"]. Simply displays links to your social profiles. You can configure both types here.', 'basel' ),
		'section'  => 'social_links',
		'priority' => 9,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_link',
		'name'     => esc_html__( 'Facebook link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '#',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'twitter_link',
		'name'     => esc_html__( 'Twitter link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '#',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'isntagram_link',
		'name'     => esc_html__( 'Instagram', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '#',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'pinterest_link',
		'name'     => esc_html__( 'Pinterest link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '#',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'youtube_link',
		'name'     => esc_html__( 'Youtube link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '#',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'tumblr_link',
		'name'     => esc_html__( 'Tumblr link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'linkedin_link',
		'name'     => esc_html__( 'LinkedIn link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'vimeo_link',
		'name'     => esc_html__( 'Vimeo link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'flickr_link',
		'name'     => esc_html__( 'Flickr link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 80,
	)
);

Options::add_field(
	array(
		'id'       => 'github_link',
		'name'     => esc_html__( 'Github link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 90,
	)
);

Options::add_field(
	array(
		'id'       => 'dribbble_link',
		'name'     => esc_html__( 'Dribbble link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'       => 'behance_link',
		'name'     => esc_html__( 'Behance link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 110,
	)
);

Options::add_field(
	array(
		'id'       => 'soundcloud_link',
		'name'     => esc_html__( 'SoundCloud link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 120,
	)
);

Options::add_field(
	array(
		'id'       => 'spotify_link',
		'name'     => esc_html__( 'Spotify link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 130,
	)
);

Options::add_field(
	array(
		'id'       => 'ok_link',
		'name'     => esc_html__( 'OK link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 140,
	)
);

Options::add_field(
	array(
		'id'       => 'vk_link',
		'name'     => esc_html__( 'VK link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 150,
	)
);

Options::add_field(
	array(
		'id'       => 'whatsapp_link',
		'name'     => esc_html__( 'WhatsApp link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 160,
	)
);

Options::add_field(
	array(
		'id'       => 'snapchat_link',
		'name'     => esc_html__( 'Snapchat link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 170,
	)
);

Options::add_field(
	array(
		'id'       => 'tg_link',
		'name'     => esc_html__( 'Telegram link', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'social_links',
		'default'  => '',
		'priority' => 180,
	)
);

Options::add_field(
	array(
		'id'       => 'social_email',
		'name'     => esc_html__( 'Email for social links', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_links',
		'default'  => false,
		'priority' => 190,
	)
);

Options::add_section(
	array(
		'id'       => 'social_share',
		'parent'   => 'social_profiles',
		'name'     => esc_html__( 'Share buttons', 'basel' ),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'social_share_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => esc_html__( 'Configurate your [social_buttons] shortcode. You can leave field empty to remove particular link. Note that there are two types of social buttons. First one is SHARE buttons [social_buttons type="share"]. It displays icons that share your page in social media. And the second one is FOLLOW buttons [social_buttons type="follow"]. Simply displays links to your social profiles. You can configure both types here.', 'basel' ),
		'section'  => 'social_share',
		'priority' => 9,
	)
);

Options::add_field(
	array(
		'id'       => 'share_fb',
		'name'     => esc_html__( 'Share in facebook', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => '1',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'share_twitter',
		'name'     => esc_html__( 'Share in twitter', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => '1',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'share_pinterest',
		'name'     => esc_html__( 'Share in pinterest', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => '1',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'share_linkedin',
		'name'     => esc_html__( 'Share in linkedin', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => '1',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'share_ok',
		'name'     => esc_html__( 'Share in OK', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => false,
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'share_whatsapp',
		'name'     => esc_html__( 'Share in whatsapp', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => false,
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'share_vk',
		'name'     => esc_html__( 'Share in VK', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => false,
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'share_tg',
		'name'     => esc_html__( 'Share in Telegram', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => '1',
		'priority' => 90,
	)
);


Options::add_field(
	array(
		'id'       => 'share_email',
		'name'     => esc_html__( 'Email for share links', 'basel' ),
		'type'     => 'switcher',
		'section'  => 'social_share',
		'default'  => false,
		'priority' => 90,
	)
);
