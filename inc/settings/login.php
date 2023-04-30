<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

/**
 * Login/register section.
 */
Options::add_section(
	array(
		'id'       => 'login_section',
		'name'     => esc_html__( 'Login/Register', 'basel' ),
		'priority' => 110,
		'icon'     => 'dashicons dashicons-admin-users',
	)
);

Options::add_field(
	array(
		'id'          => 'alt_social_login_btns_style',
		'name'        => esc_html__( 'Alternative social login buttons style', 'basel' ),
		'description' => esc_html__( 'Solves the problem with style guidelines notices.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '1',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'alt_auth_method',
		'name'        => esc_html__( 'Alternative login mechanism', 'basel' ),
		'description' => esc_html__( 'Enable it if you are redirected to my account page without signing in after click on the social login button.', 'basel' ),
		'type'        => 'switcher',
		'section'     => 'login_section',
		'default'     => '0',
		'priority'    => 81,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => 'Enable login/register with Facebook on your web-site.
			To do that you need to create an APP on the Facebook <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a>.
			Then go to APP settings and copy App ID and App Secret there. You also need to insert Redirect URI like this example <strong>' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'facebook/int_callback</strong> More information you can get in our <a href="https://xtemos.com/docs/basel/faq-guides/configure-facebook-login/" target="_blank">documentation</a>.',
		'section'  => 'login_section',
		'priority' => 81,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_app_id',
		'name'     => esc_html__( 'Facebook App ID', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 90,
	)
);

Options::add_field(
	array(
		'id'       => 'fb_app_secret',
		'name'     => esc_html__( 'Facebook App Secret', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'       => 'goo_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => 'You can enable login/register with Google on your web-site.
			To do that you need to Create a Google APIs project at <a href="https://code.google.com/apis/console/" target="_blank">https://console.developers.google.com/apis/dashboard/</a>.
			Make sure to go to API Access tab and Create an OAuth 2.0 client ID. Choose Web application for Application type. Make sure that redirect URI is set to actual OAuth 2.0 callback URL, usually <strong>' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'google/oauth2callback </strong> More information you can get in our <a href="https://xtemos.com/docs/basel/faq-guides/configure-google-login/" target="_blank">documentation</a>.',
		'section'  => 'login_section',
		'priority' => 110,
	)
);

Options::add_field(
	array(
		'id'       => 'goo_app_id',
		'name'     => esc_html__( 'Google App ID', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 120,
	)
);

Options::add_field(
	array(
		'id'       => 'goo_app_secret',
		'name'     => esc_html__( 'Google App Secret', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 130,
	)
);

Options::add_field(
	array(
		'id'       => 'vk_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => 'To enable login/register with vk.com you need to create an APP here <a href="https://vk.com/dev" target="_blank">https://vk.com/dev</a>.
			Then go to APP settings and copy App ID and App Secret there.
			You also need to insert Redirect URI like this example <strong>' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'vkontakte/int_callback</strong>',
		'section'  => 'login_section',
		'priority' => 131,
	)
);

Options::add_field(
	array(
		'id'       => 'vk_app_id',
		'name'     => esc_html__( 'VKontakte App ID', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 140,
	)
);

Options::add_field(
	array(
		'id'       => 'vk_app_secret',
		'name'     => esc_html__( 'VKontakte App Secret', 'basel' ),
		'type'     => 'text_input',
		'section'  => 'login_section',
		'priority' => 150,
	)
);
