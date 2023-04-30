<?php

if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
};

use XTS\Options;

/**
 * Dynamic css class
 *
 * @since 1.0.0
 */
class BASEL_Dynamiccss {

	/**
	 * Set up all properties
	 */
	public function __construct() {
		$this->_notices = BASEL_Registry()->notices;
		add_action( 'admin_init', array( $this, 'save_css' ), 100 );
		add_action( 'xts_after_theme_settings', array( $this, 'write_file' ), 200 );
		add_action( 'wp', array( $this, 'print_styles' ), 100 );
	}

	/**
	 * Print styles.
	 *
	 * @since 1.0.0
	 */
	public function print_styles() {
		$file = get_option( 'basel-dynamic-css-file' );

		if ( isset( $file['path'] ) && file_exists( $file['path'] ) && 'valid' === get_option( 'basel-dynamic-css-file-status' ) && 'file' === apply_filters( 'basel_dynamic_css_output', 'file' ) && version_compare( basel_get_theme_info( 'Version' ), $file['theme_version'], '==' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'file_css' ), 100001 );
		} else {
			add_action( 'wp_head', array( $this, 'inline_css' ), 200 );
		}
	}

	/**
	 * FIle css.
	 *
	 * @since 1.0.0
	 */
	public function file_css() {
		$file = get_option( 'basel-dynamic-css-file' );

		if ( isset( $file['url'] ) ) {
			if ( is_ssl() ) {
				$file['url'] = str_replace( 'http://', 'https://', $file['url'] );
			}

			wp_enqueue_style( 'basel-dynamic-style', $file['url'], array(), basel_get_theme_info( 'Version' ) );
		}
	}

	/**
	 * Inline css.
	 *
	 * @since 1.0.0
	 */
	public function inline_css() {
		$css = '';

		if ( get_option( 'basel-dynamic-css-data' ) && 'file' === apply_filters( 'basel_dynamic_css_output', 'file' ) ) {
			$css .= get_option( 'basel-dynamic-css-data' );
		} else {
			$css .= Options::get_instance()->get_css_output();
		}

		$css .= $this->icons_font_css();
		$css .= $this->custom_css();
		$css .= $this->custom_fonts_css();

		if ( $css ) {
			echo '<style data-type="basel-dynamic-css">' . apply_filters( 'basel_get_all_theme_settings_css', $css ) . '</style>'; // phpcs:ignore
		}
	}

	/**
	 * Write file.
	 *
	 * @since 1.0.0
	 */
	public function write_file() {
		global $wp_filesystem;

		if ( ! isset( $_GET['page'] ) || ( isset( $_GET['page'] ) && 'xtemos_options' !== $_GET['page'] ) ) {
			return;
		}

		if ( ( function_exists( 'request_filesystem_credentials' ) && ! $this->check_credentials() ) || ! $wp_filesystem ) {
			return;
		}

		$file = get_option( 'basel-dynamic-css-file' );

		if ( $file && $file['path'] ) {
			$wp_filesystem->delete( $file['path'] );
			delete_option( 'basel-dynamic-css-file' );
		}

		$css = get_option( 'basel-dynamic-css-data' );

		if ( ! $css ) {
			return;
		}

		$css .= $this->icons_font_css();
		$css .= $this->custom_css();
		$css .= $this->custom_fonts_css();

		$result = $wp_filesystem->put_contents(
			$this->get_file_info( 'path' ),
			apply_filters( 'basel_get_all_theme_settings_css', $css )
		);

		if ( $result ) {
			update_option(
				'basel-dynamic-css-file',
				array(
					'url'           => $this->get_file_info( 'url' ),
					'path'          => $this->get_file_info( 'path' ),
					'theme_version' => basel_get_theme_info( 'Version' ),
				)
			);

			update_option( 'basel-dynamic-css-file-status', 'valid' );
		} else {
			$this->_notices->add_warning( 'Can\'t move file to uploads folder with wp_filesystem class.' );
			$this->_notices->show_msgs();
		}
	}

	/**
	 * Save css data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $css Css data.
	 */
	public function save_css( $css ) {
		if ( ! isset( $_GET['settings-updated'] ) ) {
			return;
		}

		$css = Options::get_instance()->get_css_output();

		update_option( 'basel-dynamic-css-data', $css );
		update_option( 'basel-dynamic-css-file-status', 'invalid' );
		delete_option( 'basel-dynamic-css-file-credentials' );
	}

	/**
	 * Check credentials.
	 *
	 * @since 1.0.0
	 */
	public function check_credentials() {
		if ( ( 'valid' === get_option( 'basel-dynamic-css-file-status' ) || 'requested' === get_option( 'basel-dynamic-css-file-credentials' ) ) && ! $_POST ) { // phpcs:ignore
			return false;
		}

		update_option( 'basel-dynamic-css-file-credentials', 'requested' );

		echo '<div class="basel-request-credentials">';
			$creds = request_filesystem_credentials( false, '', false, false, array_keys( $_POST ) );
		echo '</div>';

		if ( ! $creds ) {
			return false;
		}

		if ( ! WP_Filesystem( $creds ) ) {
			$this->_notices->add_warning( 'Can\'t access your file system. The FTP access is wrong.' );
			$this->_notices->show_msgs();
			return false;
		}

		return true;
	}

	/**
	 * Get file info.
	 *
	 * @since 1.0.0
	 *
	 * @param string $target File info target.
	 *
	 * @return string
	 */
	public function get_file_info( $target ) {
		$file_name = 'basel-dynamic-' . time() . '.css';
		$uploads   = wp_upload_dir();

		if ( 'filename' === $target ) {
			return $file_name;
		}

		if ( 'path' === $target ) {
			return $uploads['path'] . '/' . $file_name;
		}

		return $uploads['url'] . '/' . $file_name;
	}

	/**
	 * Get custom css.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function custom_css() {
		$output          = '';
		$custom_css      = basel_get_opt( 'custom_css' );
		$css_desktop     = basel_get_opt( 'css_desktop' );
		$css_tablet      = basel_get_opt( 'css_tablet' );
		$css_wide_mobile = basel_get_opt( 'css_wide_mobile' );
		$css_mobile      = basel_get_opt( 'css_mobile' );

		if ( $custom_css ) {
			$output .= $custom_css;
		}

		if ( $css_desktop ) {
			$output .= '@media (min-width: 1025px) { ' . $css_desktop . ' }';
		}

		if ( $css_tablet ) {
			$output .= '@media (min-width: 768px) and (max-width: 1024px) {' . $css_tablet . ' }';
		}

		if ( $css_wide_mobile ) {
			$output .= '@media (min-width: 577px) and (max-width: 767px) { ' . $css_wide_mobile . ' }';
		}

		if ( $css_mobile ) {
			$output .= '@media (max-width: 576px) { ' . $css_mobile . ' }';
		}

		return $output;
	}

	/**
	 * Get custom fonts css.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function custom_fonts_css() {
		$fonts = basel_get_opt( 'multi_custom_fonts' );

		$output       = '';
		$font_display = basel_get_opt( 'google_font_display' );

		if ( isset( $fonts['{{index}}'] ) ) {
			unset( $fonts['{{index}}'] );
		}

		if ( ! $fonts ) {
			return $output;
		}

		foreach ( $fonts as $key => $value ) {
			$eot   = isset( $value['font-eot'] ) ? $this->get_custom_font_url( $value['font-eot'] ) : '';
			$woff  = isset( $value['font-woff'] ) ? $this->get_custom_font_url( $value['font-woff'] ) : '';
			$woff2 = isset( $value['font-woff2'] ) ? $this->get_custom_font_url( $value['font-woff2'] ) : '';
			$ttf   = isset( $value['font-ttf'] ) ? $this->get_custom_font_url( $value['font-ttf'] ) : '';
			$svg   = isset( $value['font-svg'] ) ? $this->get_custom_font_url( $value['font-svg'] ) : '';

			if ( ! $value['font-name'] ) {
				continue;
			}

			$output .= '@font-face {' . "\n";
			$output .= "\t" . 'font-family: "' . sanitize_text_field( $value['font-name'] ) . '";' . "\n";

			if ( $eot ) {
				$output .= "\t" . 'src: url("' . esc_url( $eot ) . '");' . "\n";
			}

			if ( $eot || $woff || $woff2 || $ttf || $svg ) {
				$output .= "\t" . 'src: ';

				if ( $eot ) {
					$output .= 'url("' . esc_url( $eot ) . '#iefix") format("embedded-opentype")';
				}

				if ( $woff ) {
					if ( $eot ) {
						$output .= ', ' . "\n";
					}
					$output .= 'url("' . esc_url( $woff ) . '") format("woff")';
				}

				if ( $woff2 ) {
					if ( $woff || $eot ) {
						$output .= ', ' . "\n";
					}
					$output .= 'url("' . esc_url( $woff2 ) . '") format("woff2")';
				}

				if ( $ttf ) {
					if ( $woff2 || $woff || $eot ) {
						$output .= ', ' . "\n";
					}
					$output .= 'url("' . esc_url( $ttf ) . '") format("truetype")';
				}

				if ( $svg ) {
					if ( $ttf || $woff2 || $woff || $eot ) {
						$output .= ', ' . "\n";
					}
					$output .= 'url("' . esc_url( $svg ) . '#' . sanitize_text_field( $value['font-name'] ) . '") format("svg")';
				}

				$output .= ';' . "\n";
			}

			if ( $value['font-weight'] ) {
				$output .= 'font-weight: ' . sanitize_text_field( $value['font-weight'] ) . ';';
			} else {
				$output .= 'font-weight: normal;';
			}

			if ( 'disable' !== $font_display ) {
				$output .= 'font-display:' . $font_display . ';';
			}

			$output .= 'font-style: normal;';
			$output .= '}';
		}

		return $output;
	}

	/**
	 * Icons font css.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function icons_font_css() {
		$output = '';

		$url          = basel_remove_https( BASEL_THEME_DIR );
		$font_display = basel_get_opt( 'icons_font_display' );
		$current_theme_version = basel_get_theme_info( 'Version' );

		if ( apply_filters( 'basel_old_icon_font_style', false ) ) {
			// Our font.
			$output .= '@font-face {
			font-weight: normal;
			font-style: normal;
			font-family: "simple-line-icons";
			src: url("' . $url . '/fonts/Simple-Line-Icons.eot?v=' . $current_theme_version . '");
			src: url("' . $url . '/fonts/Simple-Line-Icons.eot?#iefix&v=' . $current_theme_version . '") format("embedded-opentype"),
			url("' . $url . '/fonts/Simple-Line-Icons.woff?v=' . $current_theme_version . '") format("woff"),
			url("' . $url . '/fonts/Simple-Line-Icons.woff2?v=' . $current_theme_version . '") format("woff2"),
			url("' . $url . '/fonts/Simple-Line-Icons.ttf?v=' . $current_theme_version . '") format("truetype"),
			url("' . $url . '/fonts/Simple-Line-Icons.svg?v=' . $current_theme_version . '#simple-line-icons") format("svg");';

			if ('disable' !== $font_display) {
				$output .= 'font-display:' . $font_display . ';';
			}

			$output .= '}';

			// Basel font.
			$output .= '@font-face {
			font-weight: normal;
			font-style: normal;
			font-family: "basel-font";
			src: url("' . $url . '/fonts/basel-font.eot?v=' . $current_theme_version . '");
			src: url("' . $url . '/fonts/basel-font.eot?#iefix&v=' . $current_theme_version . '") format("embedded-opentype"),
			url("' . $url . '/fonts/basel-font.woff?v=' . $current_theme_version . '") format("woff"),
			url("' . $url . '/fonts/basel-font.woff2?v=' . $current_theme_version . '") format("woff2"),
			url("' . $url . '/fonts/basel-font.ttf?v=' . $current_theme_version . '") format("truetype"),
			url("' . $url . '/fonts/basel-font.svg?v=' . $current_theme_version . '#basel-font") format("svg");';

			if ('disable' !== $font_display) {
				$output .= 'font-display:' . $font_display . ';';
			}

			$output .= '}';
		} else {
			// Our font.
			$output .= '@font-face {
			font-weight: normal;
			font-style: normal;
			font-family: "simple-line-icons";
			src: url("' . $url . '/fonts/Simple-Line-Icons.woff2?v=' . $current_theme_version . '") format("woff2"),
			url("' . $url . '/fonts/Simple-Line-Icons.woff?v=' . $current_theme_version . '") format("woff");';

			if ('disable' !== $font_display) {
				$output .= 'font-display:' . $font_display . ';';
			}

			$output .= '}';

			// Basel font.
			$output .= '@font-face {
			font-weight: normal;
			font-style: normal;
			font-family: "basel-font";
			src: url("' . $url . '/fonts/basel-font.woff2?v=' . $current_theme_version . '") format("woff2"),
			url("' . $url . '/fonts/basel-font.woff?v=' . $current_theme_version . '") format("woff");';

			if ('disable' !== $font_display) {
				$output .= 'font-display:' . $font_display . ';';
			}

			$output .= '}';
		}

		return $output;
	}

	/**
	 * Get custom font url.
	 *
	 * @since 1.0.0
	 *
	 * @param array $font Font data.
	 *
	 * @return string
	 */
	public function get_custom_font_url( $font ) {
		$url = '';

		if ( isset( $font['id'] ) && $font['id'] ) {
			$url = wp_get_attachment_url( $font['id'] );
		} elseif ( is_array( $font ) ) {
			$url = $font['url'];
		}

		return basel_remove_https( $url );
	}
}
