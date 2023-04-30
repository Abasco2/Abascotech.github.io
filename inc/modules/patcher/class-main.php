<?php
/**
 * The main patcher class.
 *
 * @package Basel
 */

namespace XTS\Modules\Patcher;

use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * The main patcher class.
 */
class Main extends Singleton {
	/**
	 * Register hooks.
	 */
	public function init() {
		add_action( 'init', array( $this, 'include_files' ) );
		add_action( 'wp_ajax_basel_patch_action', array( $this, 'patch_process' ) );
	}

	/**
	 * Include files.
	 */
	public function include_files() {
		require_once BASEL_FRAMEWORK . '/modules/patcher/class-client.php';
		require_once BASEL_FRAMEWORK . '/modules/patcher/class-patch.php';
	}

	/**
	 * Patch process.
	 */
	public function patch_process() {
		check_ajax_referer( 'patcher_nonce', 'security' );

		if ( empty( $_GET['id'] ) ) {
			wp_send_json(
				array(
					'message' => esc_html__( 'Empty path ID, please, try again.', 'basel' ),
					'status'  => 'error',
				)
			);
		}

		$patch_id          = sanitize_text_field( $_GET['id'] ); //phpcs:ignore
		$patches_installed = get_option( 'xts_successfully_installed_patches' );

		if ( isset( $patches_installed[ basel_get_theme_info( 'Version' ) ][ $patch_id ] ) ) {
			wp_send_json(
				array(
					'message' => esc_html__( 'The patch is already applied.', 'basel' ),
					'status'  => 'success',
				)
			);
		}

		new Patch( $patch_id );
	}
}

Main::get_instance();
