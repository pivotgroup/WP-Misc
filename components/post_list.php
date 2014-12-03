<?php
// args to pass in
// array(
// 		'query' => false,
// 		'number' => 5,
// 		'pagination' => true,
// 		'excerpt_length' => 100,
// 		'class' => false,
// 		'list_component' => 'post-single-list',
// 		'query_args' => array(),
// )

if( isset( $query ) ){
	// if query was passed in, just use that.
} else {
	// otherwise set one up.
	if ( !isset( $number ) ) $number = 5;
	
	$default_query_args = array(
		'post_type' => 'post',
		'posts_per_page' => $number
	);
	$query_args = isset( $query_args ) ? array_merge( $default_query_args, $query_args ) : $default_query_args ;

	// array of post_ids passed in
	if ( isset( $posts ) ){
		$query_args[ 'post__in' ] = $posts;
		$query_args[ 'orderby' ] = 'post__in';
	}

	$query = new WP_Query( $query_args );
}
if ( ! isset( $pagination ) ){
	$pagination = true;
}
if ( ! isset( $excerpt_length ) ){
	$excerpt_length = 100;
}
if ( !$query->have_posts() ) return;

if ( !isset( $list_component ) ) $list_component =  'post-single-list';
$classes = array(
	'post-list'
);
if ( isset( $class ) ){
	$classes[] = $class;
}
global $post, $Theme; ?>
<div class="<?= implode( ' ', $classes ); ?>">
<?php
	while( $query->have_posts() ): $query->the_post();
		$Theme->theComponent( $list_component );
	endwhile;
	if ( $pagination ){
		$Theme->theComponent( 'pagination', array( 'query' => $query ) );
	} ?>
</div>
<?php wp_reset_query(); ?>