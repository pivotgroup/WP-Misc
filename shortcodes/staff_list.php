<?php
/* ==== TEMPLATE ============================================= */
$query_args = array(
	'post_type' => 'staff_member',
	'posts_per_page' => -1,
	'orderby' => 'title'
);
if ( $show_all === 'pick' ){
	$query_args[ 'post__in' ] = $items;
	$query_args[ 'orderby'] = 'post__in';
}
$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) return; ?>
<div class="staff-list">
	<?php
	global $post;
	while( $query->have_posts() ) : $query->the_post(); ?>
	<div <?php post_class(); ?> >
		<?php if ( $image = get_the_post_thumbnail( $post->ID, 'large' )){ ?>
		<div class="image">
			<?= $image; ?>
		</div>
		<?php } ?>
		<div class="info">
			<h3 class="name"><?php the_title(); ?></h3>
			<div class="content">
				<?php the_content(); ?>
			</div>
			<a class="expand-link">
				<span class="more">More</span>
				<span class="less">Less</span>
			</a>
		</div>
	</div>
	<?php endwhile; ?>
</div>

/* ==== TO ADD ============================================= */
	'staff_list' => array(
		'fields' => array(
			'show_all' => array(
				'type' => 'radio',
				'options' => array( 'all' => 'Show All', 'pick' => 'Nah, pick and reorder' ),
				'default' => 'all'
			),
			'items' => array(
				'type' => 'listPick',
				'options' => 'staff_member',
				'toggle' => array(
					'show_all' => 'pick'
				)
			)
		)
	)
