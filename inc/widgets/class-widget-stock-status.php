<?php
if ( ! defined( 'BASEL_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! class_exists( 'BASEL_Stock_Status' ) ) {
	class BASEL_Stock_Status extends WPH_Widget {
		function __construct() {
			if ( ! basel_woocommerce_installed() ) {
				return;
			}

			$args = array(
				'label'       => esc_html__( 'BASEL Stock status', 'basel' ),
				'description' => esc_html__( 'Filter stock and on-sale products', 'basel' ),
				'slug'        => 'basel-widget-stock-status',
			);

			$args['fields'] = array(
				array(
					'id'      => 'title',
					'type'    => 'text',
					'default' => esc_html__( 'Stock status', 'basel' ),
					'name'    => esc_html__( 'Title', 'basel' ),
				),

				array(
					'id'      => 'instock',
					'type'    => 'checkbox',
					'default' => 1,
					'name'    => esc_html__( 'On Sale filter', 'basel' ),
				),

				array(
					'id'      => 'onsale',
					'type'    => 'checkbox',
					'default' => 1,
					'name'    => esc_html__( 'In Stock filter', 'basel' ),
				),
			);

			$this->create_widget( $args );
			$this->hooks();
		}

		function hooks() {
			add_action( 'woocommerce_product_query', array( $this, 'show_in_stock_products' ) );
			add_filter( 'loop_shop_post_in', array( $this, 'show_on_sale_products' ) );
		}

		public function show_in_stock_products( $query ) {
			$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
			if ( in_array( 'instock', $current_stock_status ) ) {
				$meta_query = array(
					'relation' => 'AND',
					array(
						'key'     => '_stock_status',
						'value'   => 'instock',
						'compare' => '=',
					),
				);

				$query->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
			}
		}

		public function show_on_sale_products( $ids ) {
			$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
			if ( in_array( 'onsale', $current_stock_status ) ) {
				$ids = array_merge( $ids, wc_get_product_ids_on_sale() );
			}

			return $ids;
		}

		function get_link( $status ) {
			$base_link            = basel_shop_page_link( true );
			$link                 = remove_query_arg( 'stock_status', $base_link );
			$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
			$option_is_set        = in_array( $status, $current_stock_status );

			if ( ! in_array( $status, $current_stock_status ) ) {
				$current_stock_status[] = $status;
			}

			foreach ( $current_stock_status as $key => $value ) {
				if ( $option_is_set && $value === $status ) {
					unset( $current_stock_status[ $key ] );
				}
			}

			if ( $current_stock_status ) {
				asort( $current_stock_status );
				$link = add_query_arg( 'stock_status', implode( ',', $current_stock_status ), $link );
				$link = str_replace( '%2C', ',', $link );
			}

			return $link;
		}

		function widget( $args, $instance ) {
			extract( $args );

			echo wp_kses_post( $before_widget );

			if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
				echo wp_kses_post( $before_title ) . $title . wp_kses_post( $after_title );
			}

			$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();

			?>
			<ul>
				<?php if ( $instance['onsale'] ) : ?>
					<?php $this->get_link( 'onsale' ); ?>
					<li>
						<a href="<?php echo esc_attr( $this->get_link( 'onsale' ) ); ?>" class="<?php echo in_array( 'onsale', $current_stock_status ) ? 'basel-active' : ''; ?>">
							<?php esc_html_e( 'On sale', 'basel' ); ?>
						</a>
					</li>
				<?php endif; ?>

				<?php if ( $instance['instock'] ) : ?>
					<?php $this->get_link( 'instock' ); ?>
					<li>
						<a href="<?php echo esc_attr( $this->get_link( 'instock' ) ); ?>" class="<?php echo in_array( 'instock', $current_stock_status ) ? 'basel-active' : ''; ?>">
							<?php esc_html_e( 'In stock', 'basel' ); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
			<?php

			echo wp_kses_post( $after_widget );
		}

		function form( $instance ) {
			parent::form( $instance );
		}
	}
}

