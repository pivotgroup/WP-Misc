<?php
/*
Template name: Redirect Page
 */
$info = get_metabox_options( 'tpl-redirect-page' );
$redirect = get_bloginfo( 'url' );
if ( !empty( $info['redirect_to'] ) ){
	if ( $info['redirect_to'] === 'subpage' ){
		$subpages = get_pages( array(
			'child_of' => $post->ID,
			'parent' => $post->ID,
			'sort_column' => 'menu_order',
			'sort_order' => 'ASC'
		));
		if ( $subpages ){
			$redirect = get_permalink( $subpages[0]->ID );
		}
	} else {
		if ( $info['id'] ){
			$redirect = get_permalink( $info['id'] );
		}
	}
} wp_redirect( $redirect );
die;

// metabox

/* ==== Template: Redirect Page ============================================= */
$Forms->remove_supports( array( 'template' => 'tpl-redirect-page'), array( 'editor', 'revisions' ) );
$Forms->add_template_metabox( 'tpl-redirect-page', array(
	'fields' => array(
		'redirect_to' => array(
			'type' => 'radio',
			'inline' => true,
			'default' => 'id',
			'options' => array(
				'id' => 'Any Post',
				'subpage' => 'First Subpage'
			)
		),
		'id' => array(
			'title' => 'Post to redirect to',
			'type' => 'post',
			'toggle' => array(
				'redirect_to' => 'id'
			)
		),
	)
));
