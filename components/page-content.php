<?php
// meant to be used inside the loop
if ( ! isset( $post ) ){
	global $post;
}
$info = get_metabox_options( 'page-info' );

// title
if ( empty( $info['hide_title']) ){
	$title = !empty( $info['title']) ? $info['title'] : $post->post_title;
} else {
	$title = false;
}
// content
if ( !isset( $content ) ){
	$content = apply_filters( 'the_content', $post->post_content );
}
$has_sidebar = !empty( $info['has_sidebar'] );
if ( $has_sidebar && empty( $sidebar ) ){
	$sidebar = $info['sidebar'];
}

$classes = array(
	'page-content'
);
if ( $has_sidebar ) $classes[] = 'has-sidebar';
if ( !empty( $info['remove_bottom_padding'] ) ) $classes[] = 'no-bottom-padding'; ?>
<div class="<?= implode( ' ', $classes ); ?>">
	<article <?php post_class(); ?>>
		<?php if ( $title ){ ?>
		<h1 class="post-title"><?= $title; ?></h1>
		<?php } ?>
		<div class="post-content">
			<?= $content; ?>
		</div>
	</article>
<?php if( $has_sidebar ){ ?>
	<aside class="sidebar page-sidebar">
		<ul class="widgets">
			<?php dynamic_sidebar( $sidebar ); ?>
		</ul>
	</aside>
<?php } ?>
</div>
