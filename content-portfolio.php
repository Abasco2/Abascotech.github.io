<?php
/**
 * The default template for displaying content
 */

global $basel_portfolio_loop;

$size = 'large';

$classes[] = 'portfolio-entry';

if( !empty($basel_portfolio_loop['columns']) )

	$columns = ( ! empty( $basel_portfolio_loop['columns'] ) ) ? $basel_portfolio_loop['columns'] : 3;

$classes[] = basel_get_grid_el_class(0, $columns, false, 12);
$classes[] = 'portfolio-single';
$classes[] = 'masonry-item';

$cats = wp_get_post_terms( get_the_ID(), 'project-cat' );

if( ! empty( $cats ) ) {
	foreach ($cats as $key => $cat) {
		$classes[] = 'proj-cat-' . $cat->slug;
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
	<header class="entry-header">
		<figure class="entry-thumbnail">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="portfolio-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</a>
			<a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); ?>" class="portfolio-enlarge"><?php _e('View Large', 'basel'); ?></a>
		</figure>
		<?php endif; ?>

		<div class="portfolio-info">
			<h3 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h3>
			<?php if ( ! empty( $cats ) ) : ?>
				<ul class="proj-cats-list font-alt">
					<?php foreach ( $cats as $key => $cat ) : ?>
						<?php $classes[] = 'proj-cat-' . $cat->slug; ?>

						<li><?php echo esc_html( $cat->name ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</header>
</article><!-- #post -->