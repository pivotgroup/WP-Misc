<?php
/* ==== TEMPLATE ============================================= */
$classes = array( 'button' );
if ( !empty( $has_arrow ) ) $classes[] = 'has-arrow';

echo sprintfLink( $link, $text, implode( ' ', $classes ) ); ?>

/* ==== TO ADD ============================================= */
	'button' => array(
		'fields' => array(
			'text' => array(),
			'link' => array(
				'type' => 'link'
			),
			'has_little_arrow' => array(
				'type' => 'checkbox',
				'title' => '',
				'checkbox_label' => 'Has Little Arrow'
			)
		)
	)
