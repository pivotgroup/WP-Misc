<article <?php post_class( 'post-listing cf' ); ?>>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<div class="post-excerpt">
		<?php the_excerpt(); ?>
		<a class="read-more" href="<?php the_permalink(); ?>">Read More</a>
	</div>
</article>