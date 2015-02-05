<?php if ( empty( $boxes ) ){
	return;
}
?>
<div class="icon-boxes number-boxes-<?= sizeof( $boxes ); ?> cf">
	<?php foreach( $boxes as $box ){
		$target = $box['link']['target'] ? 'target="_blank"' : '';
		$title = $box['link']['title'] ? 'title="'.$box['link']['title'].'"' : ''; ?>
	<div class="icon-box">
		<a href="<?= $box['link']['url']; ?>" <?= $target; ?> <?= $title; ?>>
			<span class="icon">
				<?php if ( !empty( $box['icon_type']) && $box['icon_type'] === 'svg' ){ ?>
					<span class="image-container"><?= getMediaFromID( $box['svg'], 'image' ); ?></span>
				<?php } else if ( !empty( $box['icon'] ) ){ ?>
					<i class="fa fa-<?= $box['icon']; ?>"></i>
				<?php } ?>
			</span>
			<span class="title"><?= $box['title']; ?></span>
		</a>
	</div>
	<?php } ?>
</div>

// to add
	'icon_boxes' => array(
		'fields' => array(
			'boxes' => array(
				'type' => 'group',
				'cloneable' => true,
				'subfields' => array(
					'title' => array(),
					'icon_type' => array(
						'type' => 'radio',
						'default' => 'fa',
						'options' => array( 'fa' => 'FontAwesome', 'svg' => 'SVG upload' )
					),
					'icon' => array(
						'description' => 'FontAwesome Icon. eg. camera',
						'toggle' => array( 'icon_type' => '!svg' )
					),
					'svg' => array(
						'type' => 'media',
						'mime' => 'image',
						'description' => 'SVG image here, please',
						'toggle' => array( 'icon_type' => 'svg' )
					),
					'link' => array(
						'type' => 'link'
					)
				)
			)
		)
	),
