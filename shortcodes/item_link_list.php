/* ==== TO ADD ============================================= */
$Forms->add_shortcode( 'item_list', array(
	'inline' => true,
	'fields' => array(
		'items' => array(
			'type' => 'group',
			'cloneable' => true,
			'subfields' => array(
				'text' => array(
					'required' => true,
				),
				'link' => array(
					'type' => 'link',
					'description' => 'Optional'
				)
			)
		)
	)
));

/* ==== TEMPLATE ============================================= */
<?php if ( ! $items ) return; ?>
<div class="items-list">
	<?php foreach( $items as $item ){
		if ( ! $item['text'] ) continue; ?>
		<div class="item">
			<h4 class="item-title">
			<?php if ( $item['link']['url'] ){ ?>
				<?= sprintfLink( $item['link'], $item['text'] ); ?>
			<?php } else { ?>
				<span class="no-link"><?= $item['text']; ?></span>
			<?php } ?>
			</h4>
		</div>
	<?php } ?>
</div>
