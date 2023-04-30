<?php if ( ! defined('BASEL_THEME_DIR')) exit('No direct script access allowed');

/**
 * Register recent posts widget 
 */

if ( ! class_exists( 'BASEL_Recent_Posts' ) ) {
	class BASEL_Recent_Posts extends WPH_Widget {
	
		function __construct() {		
			// Configure widget array
			$args = array( 
				// Widget Backend label
				'label' => esc_html__( 'BASEL Recent Posts', 'basel' ),
				// Widget Backend Description								
				'description' => esc_html__( 'An advanced widget that gives you total control over the output of your site’s most recent Posts.', 'basel' ),
				'slug' => 'basel-recent-posts',
			 );

			// create widget
			$this->create_widget( $args );
		}

		
		// Output function

		function widget( $args, $instance )	{

			extract($args);

			echo wp_kses_post( $before_widget );

			if( ! empty( $instance['title'] ) ) {
				echo wp_kses_post( $before_title ) . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . wp_kses_post( $after_title );
			}

			// Get the recent posts query.
			$offset              = ( isset( $instance['offset'] ) ) ? $instance['offset'] : 0;
			$posts_per_page      = ( isset( $instance['limit'] ) ) ? $instance['limit'] : 5;
			$orderby             = ( isset( $instance['orderby'] ) ) ? $instance['orderby'] : 'date';
			$category            = ( isset( $instance['category'] ) ) ? $instance['category'] : 'all';
			$order               = ( isset( $instance['order'] ) ) ? $instance['order'] : 'DESC';
			$thumb_height        = ( isset( $instance['thumb_height'] ) ) ? $instance['thumb_height'] : 45;
			$thumb_width         = ( isset( $instance['thumb_width'] ) ) ? $instance['thumb_width'] : 45;
			$thumb         		 = ( isset( $instance['thumb'] ) ) ? $instance['thumb'] : true;
			$comment_count       = ( isset( $instance['comment_count'] ) ) ? $instance['comment_count'] : true;
			$date         		 = ( isset( $instance['date'] ) ) ? $instance['date'] : true;

			$query = array(
				'offset'              => $offset,
				'posts_per_page'      => $posts_per_page,
				'orderby'             => $orderby,
				'order'               => $order
			);

			if ( 'all' !== $category ) {
				$query['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $category
					)
				);
			}

			$posts = new WP_Query( $query );

			?>
			<?php if ( $posts->have_posts() ): ?>
				<ul class="basel-recent-posts-list">
					<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
						<li>
							<?php if ( $thumb ): ?>
								<?php if ( has_post_thumbnail() ): ?>
									<a class="recent-posts-thumbnail" href="<?php echo esc_url( get_permalink() ); ?>"  rel="bookmark">
										<?php echo basel_get_post_thumbnail( array( $thumb_width, $thumb_height ) ); ?>
									</a>
								<?php endif ?>
							<?php endif ?>						
							<div class="recent-posts-info">
								<h5 class="entry-title"><a href="<?php echo esc_url( get_permalink() ) ?>" title="<?php echo sprintf( esc_attr__( 'Permalink to %s', 'basel' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo esc_attr( get_the_title() ); ?></a></h5>

								<?php if ( $date ): ?>
									<?php $date = get_the_date(); ?>
									<time class="recent-posts-time" datetime="<?php echo esc_html( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $date ); ?></time>
								<?php endif ?>

								<?php 
								if ( $comment_count ) {
									if ( get_comments_number() == 0 ) {
											$comments = esc_html__( 'No Comments', 'basel' );
										} elseif ( get_comments_number() > 1 ) {
											$comments = sprintf( esc_html__( '%s Comments', 'basel' ), get_comments_number() );
										} else {
											$comments = esc_html__( '1 Comment', 'basel' );
										}
									echo '<a class="recent-posts-comment" href="' . get_comments_link() . '">' . $comments . '</a>';
								}
								?>
							</div>
						</li>

					<?php endwhile; ?> 

				</ul>
			<?php endif ?>

			<?php
			wp_reset_postdata();

			echo wp_kses_post( $after_widget );
		}

		public function update( $new_instance, $old_instance ) {

			$instance                     = $old_instance;
			$instance['title']            = sanitize_text_field( $new_instance['title'] );
			$instance['limit']            = intval( $new_instance['limit'] );
			$instance['offset']           = intval( $new_instance['offset'] );
			$instance['order']            = stripslashes( $new_instance['order'] );
			$instance['orderby']          = stripslashes( $new_instance['orderby'] );
			$instance['category']         = $new_instance['category'];
			$instance['date']             = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : '';
			$instance['comment_count']    = isset( $new_instance['comment_count'] ) ? (bool) $new_instance['comment_count'] : '';
			$instance['thumb']            = isset( $new_instance['thumb'] ) ? (bool) $new_instance['thumb'] : '';
			$instance['thumb_height']     = intval( $new_instance['thumb_height'] );
			$instance['thumb_width']      = intval( $new_instance['thumb_width'] );

			return $instance;
		}

		function form( $instance ) {
			$defaults = array(
				'title'             => esc_attr__( 'Recent Posts', 'basel' ),
				'limit'            => 5,
				'offset'           => 0,
				'order'            => 'DESC',
				'orderby'          => 'date',
				'category'         => 'all',
				'thumb'            => true,
				'thumb_height'     => 45,
				'thumb_width'      => 45,
				'date'             => true,
				'comment_count'    => true,
			);
			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Title', 'basel' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
					<?php esc_html_e( 'Order', 'basel' ); ?>
				</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' )); ?>" style="width:100%;">
					<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php esc_html_e( 'Descending', 'basel' ) ?></option>
					<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php esc_html_e( 'Ascending', 'basel' ) ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ) ; ?>">
					<?php esc_html_e( 'Orderby', 'basel' ); ?>
				</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ) ; ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" style="width:100%;">
					<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php esc_html_e( 'ID', 'basel' ) ?></option>
					<option value="author" <?php selected( $instance['orderby'], 'author' ); ?>><?php esc_html_e( 'Author', 'basel' ) ?></option>
					<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php esc_html_e( 'Title', 'basel' ) ?></option>
					<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php esc_html_e( 'Date', 'basel' ) ?></option>
					<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php esc_html_e( 'Modified', 'basel' ) ?></option>
					<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php esc_html_e( 'Random', 'basel' ) ?></option>
					<option value="comment_count" <?php selected( $instance['orderby'], 'comment_count' ); ?>><?php esc_html_e( 'Comment Count', 'basel' ) ?></option>
					<option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php esc_html_e( 'Menu Order', 'basel' ) ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ) ; ?>">
					<?php esc_html_e( 'Category', 'basel' ); ?>
				</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ) ; ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" style="width:100%;">
					<option value="all" <?php selected( $instance['category'], 'all' ); ?>><?php esc_html_e( 'All', 'basel' ); ?></option>
					<?php foreach ( get_categories() as $category ) : ?>
						<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $instance['category'], $category->term_id	 ); ?>><?php echo esc_attr( $category->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>">
					<?php esc_html_e( 'Number of posts to show', 'basel' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' )); ?>" type="number" step="1" min="-1" value="<?php echo esc_attr( (int)$instance['limit'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>">
					<?php esc_html_e( 'Offset', 'basel' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo esc_attr( (int) $instance['offset'] ); ?>" />
				<small><?php esc_html_e( 'The number of posts to skip', 'basel' ); ?></small>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb' ) ); ?>" type="checkbox" <?php checked( $instance['thumb'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>">
					<?php esc_html_e( 'Display Thumbnail', 'basel' ); ?>
				</label>
			</p>

			<p>
				<label style="display: block;" class="basel-block" for="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>">
					<?php esc_html_e( 'Thumbnail (height)', 'basel' ); ?>
				</label>
				<input style="display: block;" class= "small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_height' ) ); ?>" type="number" step="1" min="0" value="<?php echo esc_attr( (int)$instance['thumb_height'] ); ?>" />
				<label style="display: block;" class="basel-block" for="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>">
					<?php esc_html_e( 'Thumbnail (width)', 'basel' ); ?>
				</label>
				<input style="display: block;" class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_width' ) ); ?>" type="number" step="1" min="0" value="<?php echo esc_attr( (int)$instance['thumb_width'] ); ?>"/>
			</p>
			
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'comment_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_count' ) ); ?>" type="checkbox" <?php checked( $instance['comment_count'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'comment_count' ) ); ?>">
					<?php esc_html_e( 'Display Comment Count', 'basel' ); ?>
				</label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" <?php checked( $instance['date'] ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>">
					<?php esc_html_e( 'Display Date', 'basel' ); ?>
				</label>
			</p>
			<?php
		}
	}
}
