<?php if ( empty( $boxes ) ){
	return;
}
?>
<div class="icon-boxes number-boxes-<?= sizeof( $boxes ); ?>">
	<?php foreach( $boxes as $box ){
		$target = $box['link']['target'] ? 'target="_blank"' : '';
		$title = $box['link']['title'] ? 'title="'.$box['link']['title'].'"' : ''; ?>
	<div class="box">
		<a href="<?= $box['link']['url']; ?>" <?= $target; ?> <?= $title; ?>>
			<span class="icon">
				<?php if ( !empty( $box['icon'] ) ){ ?>
				<i class="fa fa-<?= $box['icon']; ?>"></i>
				<?php } ?>
			</span>
			<span class="title"><?= $box['title']; ?></span>
		</a>
	</div>
	<?php } ?>
</div>

// to add
$Forms->add_shortcodes( array(
	'icon_boxes' => array(
		'fields' => array(
			'boxes' => array(
				'type' => 'group',
				'cloneable' => true,
				'subfields' => array(
					'title' => array(),
					'icon' => array(
						'description' => 'FontAwesome Icon. eg. camera'
					),
					'link' => array(
						'type' => 'link'
					)
				)
			)
		)
	)
));
