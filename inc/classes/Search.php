<?php if ( ! defined( 'BASEL_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
 * Ajax search
 */


class BASEL_Search {

	public function __construct() {
		add_action( 'wp_ajax_basel_ajax_search', array( $this, 'ajax_suggestions') );
		add_action( 'wp_ajax_nopriv_basel_ajax_search', array( $this, 'ajax_suggestions') );
		add_action( 'init', array( $this, 'sku_init') );
	}

	public function sku_init() {
		if( apply_filters('basel_search_by_sku', basel_get_opt('search_by_sku') ) && basel_woocommerce_installed() ) {
			add_filter('posts_search', array( $this, 'product_search_sku'), 9);
		}
	}

	public function ajax_suggestions() {

		if( apply_filters('basel_search_by_sku', basel_get_opt('search_by_sku') ) && basel_woocommerce_installed() ) {
			add_filter('posts_search', array( $this, 'product_ajax_search_sku'), 10);
		}

		$allowed_types = array( 'post', 'product', 'portfolio' );
		$post_type = 'product';

		$query_args = array(
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'post_type'      => $post_type,
			'no_found_rows'  => 1,
		);

		if ( ! empty( $_REQUEST['post_type'] ) && in_array( $_REQUEST['post_type'], $allowed_types ) ) {
			$post_type = strip_tags( $_REQUEST['post_type'] );
			$query_args['post_type'] = $post_type;
		}

		if ( $post_type == 'product' && basel_woocommerce_installed() ) {
			
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			$query_args['tax_query']['relation'] = 'AND';
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			);

			if ( apply_filters( 'basel_ajax_search_product_cat_args_old_style', false ) ) {
				if ( ! empty( $_REQUEST['product_cat'] ) ) {
					$query_args['product_cat'] = strip_tags( $_REQUEST['product_cat'] );
				}
			} else {
				if ( ! empty( $_REQUEST['product_cat'] ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => strip_tags( $_REQUEST['product_cat'] ),
					);
				}
			}
		}

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && $post_type == 'product' ) {
			$query_args['meta_query'][] = array( 'key' => '_stock_status', 'value' => 'outofstock', 'compare' => 'NOT IN' );
		}

		if ( ! empty( $_REQUEST['query'] ) ) {
			$query_args['s'] = sanitize_text_field( $_REQUEST['query'] );
		}

		if ( ! empty( $_REQUEST['number'] ) ) {
			$query_args['posts_per_page'] = (int) $_REQUEST['number'];
		}

		$results = new WP_Query( apply_filters( 'basel_ajax_search_args', $query_args ) );

		if ( basel_get_opt( 'relevanssi_search' ) && function_exists( 'relevanssi_do_query' ) ) {
			relevanssi_do_query( $results );
		}

		$suggestions = array();

		if ( $results->have_posts() ) {

			if ( $post_type == 'product' && basel_woocommerce_installed() ) {
				$factory = new WC_Product_Factory();
			}

			while ( $results->have_posts() ) {
				$results->the_post();

				if ( $post_type == 'product' && basel_woocommerce_installed() ) {
					$product = $factory->get_product( get_the_ID() );

					$suggestions[] = array(
						'value' => html_entity_decode( get_the_title() ),
						'permalink' => get_the_permalink(),
						'price' => $product->get_price_html(),
						'thumbnail' => $product->get_image(),
						'sku' => $product->get_sku() ? esc_html__( 'SKU:', 'basel' ) . ' ' . $product->get_sku() : '',
					);
				} else {
					$suggestions[] = array(
						'value' => html_entity_decode( get_the_title() ),
						'permalink' => get_the_permalink(),
						'thumbnail' => get_the_post_thumbnail( null, 'medium', '' ),
					);
				}
			}

			wp_reset_postdata();
		} else {
			$suggestions[] = array(
				'value' => ( $post_type == 'product' ) ? esc_html__( 'No products found', 'basel' ) : esc_html__( 'No posts found', 'basel' ),
				'no_found' => true,
				'permalink' => ''
			);
		}

		if ( basel_get_opt( 'enqueue_posts_results' ) && 'post' !== $post_type ) {
			$post_suggestions = basel_get_post_suggestions();
			$suggestions = array_merge( $suggestions, $post_suggestions );
		}

		echo json_encode( array(
			'suggestions' => $suggestions
		) );

		die();
	}

	public function product_search_sku($where, $class = false) {
	    global $pagenow, $wpdb, $wp;

	    //VAR_DUMP(http_build_query(array('post_type' => array('product','boobs'))));die();
	    $type = array('product', 'jam');
	    
	    //var_dump(in_array('product', $wp->query_vars['post_type']));
	    if ((is_admin() ) //if ((is_admin() && 'edit.php' != $pagenow) 
	            || !is_search()  
	            || !isset($wp->query_vars['s']) 
	            //post_types can also be arrays..
	            || (isset($wp->query_vars['post_type']) && 'product' != $wp->query_vars['post_type'])
	            || (isset($wp->query_vars['post_type']) && is_array($wp->query_vars['post_type']) && !in_array('product', $wp->query_vars['post_type']) ) 
	            ) {
	        return $where;
	    }

	    $s = $wp->query_vars['s'];

		//WC 3.6.0
		if ( function_exists( 'WC' ) && version_compare( WC()->version, '3.6.0', '<' ) ) {
			return $this->sku_search_query( $where, $s );
		} else {
			return $this->sku_search_query_new( $where, $s );
		}
	}

	public function product_ajax_search_sku( $where ) {

		if( ! empty( $_REQUEST['query'] ) ) {
			$s = sanitize_text_field( $_REQUEST['query'] );

			//WC 3.6.0
			if ( function_exists( 'WC' ) && version_compare( WC()->version, '3.6.0', '<' ) ) {
				return $this->sku_search_query( $where, $s );
			} else {
				return $this->sku_search_query_new( $where, $s );
			}
		}

		return $where;
	}

	public function sku_search_query( $where, $s ) {
	    global $wpdb;

	    $search_ids = array();
	    $terms = explode(',', $s);

	    foreach ($terms as $term) {
	        //Include the search by id if admin area.
	        if (is_admin() && is_numeric($term)) {
	            $search_ids[] = $term;
	        }
	        // search for variations with a matching sku and return the parent.

	        $sku_to_parent_id = $wpdb->get_col($wpdb->prepare("SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean($term)));

	        //Search for a regular product that matches the sku.
	        $sku_to_id = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';", wc_clean($term)));

	        $search_ids = array_merge($search_ids, $sku_to_id, $sku_to_parent_id);
	    }

	    $search_ids = array_filter(array_map('absint', $search_ids));

	    if (sizeof($search_ids) > 0) {
	        $where = str_replace(')))', ") OR ({$wpdb->posts}.ID IN (" . implode(',', $search_ids) . "))))", $where);
	    }
	    
	    #remove_actions_for_anonymous_class('posts_search', 'WC_Admin_Post_Types', 'product_search', 10);
	    return $where;

	}

	public function sku_search_query_new( $where, $s ) {
		global $wpdb;

		$search_ids = array();
		$terms = explode( ',', $s );

		foreach ( $terms as $term ) {
			//Include the search by id if admin area.
			if ( is_admin() && is_numeric( $term ) ) {
				$search_ids[] = $term;
			}
			// search for variations with a matching sku and return the parent.

			$sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->wc_product_meta_lookup} ml on p.ID = ml.product_id and ml.sku LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $term ) ) );

			//Search for a regular product that matches the sku.
			$sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT product_id FROM {$wpdb->wc_product_meta_lookup} WHERE sku LIKE '%%%s%%';", wc_clean( $term ) ) );

			$search_ids = array_merge( $search_ids, $sku_to_id, $sku_to_parent_id );
		}

		$search_ids = array_filter( array_map( 'absint', $search_ids ) );

		if ( sizeof( $search_ids ) > 0 ) {
			$where = str_replace( ')))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . "))))", $where );
		}
		
		#remove_filters_for_anonymous_class('posts_search', 'WC_Admin_Post_Types', 'product_search', 10);
		return $where;

	}
}

if ( ! function_exists( 'basel_rlv_index_variation_skus' ) ) {
	function basel_rlv_index_variation_skus( $content, $post ) {
		if ( ! basel_get_opt( 'search_by_sku' ) || ! basel_get_opt( 'relevanssi_search' ) || ! function_exists( 'relevanssi_do_query' ) ) {
			return $content;
		}

		if ( $post->post_type == 'product' ) {

			$args = array( 'post_parent' => $post->ID, 'post_type' => 'product_variation', 'posts_per_page' => -1 );
			$variations = get_posts( $args );
			if ( !empty( $variations)) {
				foreach ( $variations as $variation ) {
					$sku = get_post_meta( $variation->ID, '_sku', true );
					$content .= " $sku";
				}
			}
		}

		return $content;
	}

	add_filter( 'relevanssi_content_to_index', 'basel_rlv_index_variation_skus', 10, 2 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Blog results on search page
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'basel_show_blog_results_on_search_page' ) ) {
	function basel_show_blog_results_on_search_page() {
		if ( ! is_search() || ! basel_get_opt( 'enqueue_posts_results' ) ) {
			return;
		}

		$search_query = get_search_query();
		$column = basel_get_opt( 'search_posts_results_column' );

		ob_start();

		?>
		<div class="basel-blog-search-results">
			<h4 class="slider-title">
				<?php esc_html_e( 'Results from blog', 'basel' ); ?>
			</h4>

			<?php echo do_shortcode( '[basel_posts slides_per_view="' . $column . '" search="' . $search_query . '" items_per_page="10"]' ); ?>

			<div class="basel-search-show-all">
				<a href="<?php echo esc_url( home_url() ) ?>?s=<?php echo esc_attr( $search_query ); ?>&post_type=post" class="button">
					<?php esc_html_e( 'Show all blog results', 'basel' ); ?>
				</a>
			</div>
		</div>
		<?php

		echo ob_get_clean();
	}

	add_action( 'woocommerce_after_shop_loop', 'basel_show_blog_results_on_search_page', 100 );
	add_action( 'basel_after_portfolio_loop', 'basel_show_blog_results_on_search_page', 100 );
	add_action( 'basel_after_no_product_found', 'basel_show_blog_results_on_search_page', 100 );
}

if ( ! function_exists( 'basel_get_post_suggestions' ) ) {
	function basel_get_post_suggestions() {
		$query_args = array(
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'no_found_rows'  => 1,
		);

		if ( ! empty( $_REQUEST['query'] ) ) {
			$query_args['s'] = sanitize_text_field( $_REQUEST['query'] );
		}

		if ( ! empty( $_REQUEST['number'] ) ) {
			$query_args['posts_per_page'] = (int) $_REQUEST['number'];
		}

		$results = new WP_Query( $query_args );
		$suggestions = array();

		if ( $results->have_posts() ) {

			$suggestions[] = array(
				'value' => '',
				'divider' => esc_html__( 'Results from blog', 'basel' ),
			);

			while ( $results->have_posts() ) {
				$results->the_post();

				$suggestions[] = array(
					'value' => html_entity_decode( get_the_title() ),
					'permalink' => get_the_permalink(),
					'thumbnail' => get_the_post_thumbnail( null, 'medium', '' ),
				);
			}

			wp_reset_postdata();
		}

		return $suggestions;
	}
}