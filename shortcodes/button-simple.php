<?php
/* ==== TO ADD ============================================= */
	'button' => array(
		'icon' => 'hand-o-up',
		'fields' => array(
			'link' => array(
				'title' => false,
				'type' => 'link'
			),
			'color' => array(
				'type' => 'select',
				'options' => array( 'blue' => 'Blue', 'green' => 'Green', 'custom' => 'Custom' )
			),
			'custom_color' => array(
				'type' => 'group',
				'toggle' => array(
					'color' => 'custom'
				),
				'subfields' => array(
					'text' => array(
						'type' => 'color'
					),
					'background' => array(
						'type' => 'color'
					),
					'hover_background' => array(
						'type' => 'color'
					)
				)
			),
			'is_full_width' => array(
				'title' => false,
				'type' => 'checkbox',
				'checkbox_label' => 'Is full-width'
			)
		)
	)
	
/* ==== TEMPLATE ============================================= */
$inline_styles = array();
$inline_scripts = false;
if ( $color === 'custom' ){
	$inline_styles[ 'color' ] = $custom_color['text'];
	$inline_styles[ 'background-color' ] = $custom_color['background'];
	if ( $custom_color['hover_background'] ){
		$inline_scripts = "onMouseOver=this.style.backgroundColor='".$custom_color['hover_background']."' onMouseOut=this.style.backgroundColor='".$custom_color['background']."'";
	}
}
$target = !empty( $link['target'] ) ? 'target="_blank"' : '';
$inline_styles = createInlineStyle( $inline_styles ); ?>
<a class="button color-<?= $color; ?>" <?= $inline_styles; ?> <?= $inline_scripts; ?> href="<?= $link['url']; ?>" <?= $target; ?> ><?= $link['title']; ?></a>

