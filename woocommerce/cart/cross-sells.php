<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.4.0
 */

defined( 'ABSPATH' ) || exit;

$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );

if ( $cross_sells ) : ?>

	<div class="cross-sells">

		<?php if ( $heading ) : ?>
            <h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php

			$slider_args = array(
				'slides_per_view' => apply_filters( 'basel_cross_sells_products_per_view', 3 ),
				'img_size' => 'woocommerce_thumbnail'
			);
			
			echo basel_generate_posts_slider( $slider_args, false, $cross_sells );
			
		?>

	</div>

<?php endif;

wp_reset_postdata();