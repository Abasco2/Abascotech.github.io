<?php if ( ! defined('BASEL_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Autload classes from classes/ folder
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'basel_load_classes' ) ) {
	function basel_load_classes() {
		$classes = array(
			'Singleton.php',
			'Ajaxresponse.php',
			'Api.php',
			'Catalog.php',
			'Dynamiccss.php',
			'Googlefonts.php',
//			'Gradient.php',
			'Import.php',
			'Importversion.php',
			'Layout.php',
			'License.php',
			'Maintenance.php',
			'Metaboxes.php',
			'Notices.php',
			'Options.php',
			'Pagecssfiles.php',
			'Registry.php',
			'Search.php',
			'Swatches.php',
			'Theme.php',
		);

		foreach ( $classes as $class ) {
			$file_name = BASEL_CLASSES . DIRECTORY_SEPARATOR . $class;
			if ( file_exists( $file_name ) ) {
				require $file_name;
			}
		}
	}
}

basel_load_classes();

