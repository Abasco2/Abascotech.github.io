<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * Main Theme class that initialize all
 * other classes like assets, layouts, options
 *
 * Also includes files with theme functions
 * template tags, 3d party plugins etc.
 */
class BASEL_Theme {

	/**
	 * Classes array to register in BASEL_Registery object
	 *
	 * @var array
	 */
	private $register_classes = array();

	/**
	 * Files array to include from inc/ folder
	 *
	 * @var array
	 */
	private $files_include = array();

	/**
	 * Array of files to include in admin area
	 *
	 * @var array
	 */
	private $admin_files_include = array();

	/**
	 * 3d party plugins array
	 *
	 * @var array
	 */
	private $third_party_plugins = array();


	/**
	 * Call init methods
	 */
	public function __construct() {

		$this->register_classes = array(
			'options',
			'ajaxresponse',
			'notices',
			'layout',
			'import',
			'swatches',
			'search',
			'catalog',
			'maintenance',
			'api',
			'license',
			'dynamiccss',
			'pagecssfiles',
		);

		$this->files_include = array(
			'classes/Singleton',

			'functions',
			'theme-setup',
			'template-tags',
			'woocommerce',
			'woocommerce/attributes-meta-boxes',
			'woocommerce/product-360-view',
			'woocommerce/progress-bar',
			'woocommerce/variation-gallery',
			'woocommerce/size-guide',
			'woocommerce/compare',
			'woocommerce/wishlist/class-wc-wishlist',
			'woocommerce/shipping-progress-bar/class-main',
			'woocommerce/class-adjacent-products',
			'woocommerce/comment-images/class-wc-comment-images',
			'widgets',
			'styles',
			'configs/assets',

			'modules/patcher/class-main',

			'integrations/imagify',
			'integrations/yoast',
			'integrations/aioseo',

			'third-party/cmb2-conditionals/cmb2-conditionals',
			'third-party/cmb2-fields/images-select',
			'third-party/cmb2-fields/slider',

			'vc-fields/vc-functions',
			'vc-fields/slider',
			'vc-fields/responsive-size',
			'vc-fields/image-select',
			'vc-fields/dropdown',
			'vc-fields/css-id',
			'vc-fields/colorpicker',

			'classes/Googlefonts',
			'classes/Config',

			'options/class-field',
			'options/class-metabox',
			'options/class-metaboxes',
			'options/class-options',
			'options/class-presets',
			'options/class-sanitize',
			'options/class-page',

			'options/controls/background/class-background',
			'options/controls/buttons/class-buttons',
			'options/controls/checkbox/class-checkbox',
			'options/controls/color/class-color',
			'options/controls/custom-fonts/class-custom-fonts',
			'options/controls/editor/class-editor',
			'options/controls/image-dimensions/class-image-dimensions',
			'options/controls/notice/class-notice',
			'options/controls/import/class-import',
			'options/controls/range/class-range',
			'options/controls/select/class-select',
			'options/controls/switcher/class-switcher',
			'options/controls/border/class-border',
			'options/controls/text-input/class-text-input',
			'options/controls/textarea/class-textarea',
			'options/controls/typography/google-fonts',
			'options/controls/typography/class-typography',
			'options/controls/upload/class-upload',
			'options/controls/upload-list/class-upload-list',
			'options/controls/color/class-color',
			'options/controls/instagram-api/class-instagram-api',

			'settings/general',
			'settings/general-layout',
			'settings/page-title',
			'settings/header',
			'settings/footer',
			'settings/typography',
			'settings/colors',
			'settings/blog',
			'settings/portfolio',
			'settings/shop',
			'settings/product',
			'settings/login',
			'settings/custom-css',
			'settings/custom-js',
			'settings/social',
			'settings/performance',
			'settings/other',
			'settings/maintenance',
			'settings/import',

			'metaboxes/pages',
			'metaboxes/products',
			'metaboxes/slider',
		);

		$this->admin_files_include = array(
			'admin/dashboard/dashboard',
			'admin/init',
			'admin/functions',
		);

		$this->third_party_plugins = array(
			'plugin-activation/class-tgm-plugin-activation',
			'nav-menu-images/nav-menu-images',
			'wph-widget-class',
		);

		$this->shortcodes = array(
			'shortcodes',
			'popup',
			'responsive-text-block',
		);

		$this->woo_shortcodes = array(
			'product-filters',
			'size-guide',
			'compare',
			'wishlist',
		);

		$this->vc_elements = array(
			'vc-config',
			'popup',
			'responsive-text-block',
		);

		$this->_third_party_plugins();
		$this->_core_plugin_classes();
		$this->_include_files();
		$this->_register_classes();

		$this->_include_vc_elements();
		$this->_include_shortcodes();

		if ( is_admin() ) {
			$this->_include_admin_files();
		}

	}

	/**
	 * Include files from inc/ vc-element
	 */
	private function _include_vc_elements() {
		$vc_elements = $this->vc_elements;

		if ( basel_woocommerce_installed() ) {
			$vc_elements = array_merge( $this->vc_elements, $this->woo_shortcodes );
		}
		foreach ( $vc_elements as $file ) {
			$path = get_template_directory() . '/inc/vc-element/' . $file . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}

	/**
	 * Include files from inc/ shortcodes
	 */
	private function _include_shortcodes() {
		$shortcodes = $this->shortcodes;

		if ( basel_woocommerce_installed() ) {
			$shortcodes = array_merge( $this->shortcodes, $this->woo_shortcodes );
		}

		foreach ( $shortcodes as $file ) {
			$path = get_template_directory() . '/inc/shortcodes/' . $file . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}

	/**
	 * Register classes in BASEL_Registry
	 */
	private function _register_classes() {

		foreach ( $this->register_classes as $class ) {
			BASEL_Registry::getInstance()->$class;
		}

	}

	/**
	 * Include files from inc/ folder
	 */
	private function _include_files() {
		foreach ( $this->files_include as $file ) {
			$path = apply_filters( 'basel_require', BASEL_FRAMEWORK . '/' . $file . '.php' );
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Include files in admin area
	 */
	private function _include_admin_files() {

		foreach ( $this->admin_files_include as $file ) {
			$path = apply_filters( 'basel_require', BASEL_FRAMEWORK . '/' . $file . '.php' );
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Register 3d party plugins
	 */
	private function _third_party_plugins() {

		foreach ( $this->third_party_plugins as $file ) {
			$path = apply_filters( 'basel_require', BASEL_3D . '/' . $file . '.php' );
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	private function _core_plugin_classes() {
		if ( class_exists( 'BASEL_Auth' ) ) {
			$file_path = array(
				'vendor/autoload',
			);
			foreach ( $file_path as $file ) {
				$path = apply_filters( 'basel_require', BASEL_PT_3D . $file . '.php' );
				if ( file_exists( $path ) ) {
					require_once $path;
				}
			}
			$this->register_classes[] = 'auth';
		}
	}
}
