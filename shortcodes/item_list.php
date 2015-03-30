/* ==== TO ADD ============================================= */
$Forms->add_shortcode( 'item_list', array(
	'inline' => true,
	'icon' => 'list',
	'fields' => array(
		'items' => array(
			'cloneable' => true
		)
	)
));


/* ==== TEMPLATE ============================================= */
<?php if ( ! $items ) return; ?>
<ul class="items-list">
<?php foreach( $items as $item ){
	if ( ! $item['text'] ) continue; ?>
	<li class="item"><?= $item; ?></li>
<?php } ?>
</ul>
