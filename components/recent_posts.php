<?php if ( !isset( $number ) ) $number = 5;
$query_args = array(
	'post_type' => 'post',
	'posts_per_page' => $number
);
// array of post_ids
if ( isset( $posts ) ){
	$query_args[ 'post__in' ] = $posts;
	$query_args[ 'orderby' ] = 'post__in';
}
$query = new WP_Query( $query_args );
if ( !$query->have_posts() ) return;
global $post, $Theme; ?>
<div class="post-list latest-posts">
<?php while( $query->have_posts() ): $query->the_post();
	$excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
	$featured_image = wp_get_attachment_image( $post ); ?>
	<div <?php post_class(); ?>>
		<div class="date"><?php the_time( 'F j, Y' ); ?></div>
		<?php if ( $featured_image ){ ?>
		<div class="featured-image">
			<a href="<?php the_permalink(); ?>"><?= $featured_image; ?></a>
		</div>
		<?php } ?>
		<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="excerpt">
			<?= $Theme->trim_excerpt( $excerpt, 20 ); ?>
			<a href="<?php the_permalink(); ?>" class="read-more">Read More <i class="fa fa-arrow-right"></i></a>
		</div>
	</div>
<?php endwhile; ?>
</div>
<?php wp_reset_query(); ?>