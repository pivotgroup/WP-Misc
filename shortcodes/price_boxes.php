/* ==== ADD SHORTCODE ============================================= */
$Forms->add_shortcode( 'price_boxes', array(
	'fields' => array(
		'default_button' => array(
			'type' => 'link',
			'description' => 'Used if a particular box has no button url'
		),
		'boxes' => array(
			'type' => 'group',
			'cloneable' => true,
			'subfields' => array(
				'title' => array(
					'description' => 'Ex. "Economy"'
				),
				'price' => array(
					'required' => true,
					'description' => 'Ex. $19.99'
				),
				'per' => array(
					'placeholder' => '/per month'
				),
				'items' => array(
					'cloneable' => true,
					'required' => 'Cannot be empty'
				),
				'is_featured' => array(
					'title' => false,
					'type' => 'checkbox',
					'checkbox_label' => 'Mark as featured'
				),
				'button' => array(
					'type' => 'link'
				)
			)
		)
	)
));
/* ==== TEMPLATE ============================================= */
<?php if ( ! $boxes ) return; ?>
<div class="price-boxes number-<?= sizeof( $boxes ); ?> cf">
	<?php
	$default_button = !empty( $default_button['url'] ) ? sprintfLink( $default_button, $default_button['title'], 'button color-orange' ) : false;
	foreach( $boxes as $box ){
		if ( empty( $box['button']['url'] ) ){
			$button = $default_button;
		} else {
			$button = sprintfLink( $box['button'], $box['button']['title'], 'button color-orange' );
		}
		$classes = array( 'price-box' );
		if ( !empty( $box['is_featured'] ) ) $classes[] = 'featured';
		?>
		<div class="<?= implode( ' ', $classes ); ?>">
			<h3 class="title"><?= $box['title']; ?></h3>
			<div class="price">
				<h1 class="dollars"><?= $box['price']; ?></h1>
				<div class="per"><?= !empty( $box['per'] ) ? $box['per'] : '/per month' ; ?></div>
			</div>
			<div class="items">
				<?php foreach( $box['items'] as $item ){ ?>
				<div class="item"><?= $item; ?></div>
				<?php } ?>
			</div>
			<div class="button-container">
				<?= $button; ?>
			</div>
		</div>
	<?php } ?>
</div>

/* ==== SCSS ============================================= */
.price-boxes {
	width: 100%;
	.price-box {
		float: left;
		width: 33.3333%;
	}
	&.number-1 {
		.price-box {
			width: 100%;
		}
	}
	&.number-2 {
		.price-box {
			width: 50%;
		}
	}
	&.number-3 {
		.price-box {
			width: 33.3333%;
		}
	}
	&.number-4 {
		.price-box {
			width: 25%;
		}
	}
	&.number-5 {
		.price-box {
			width: 20%;
		}
	}
}
.price-box {
	text-align: center;
	box-shadow: 0 0 5px rgba( 0, 0, 0, .5 );
	transform: scale( 1 );
	position: relative;
	z-index: 0;
	> * {
		padding-left: 15px;
		padding-right: 15px;
	}
	> .title {
		color: #fff;
		padding: 1em 0;
		border-bottom: 1px solid #fff;
	}
	> .price {
		color: #fff;
		padding: 1em 0;
	}
	> .items {
		border-top: 3px solid #fff;
		border-bottom: 3px solid #fff;
		background: #f4f5f5;
		padding: 0;
		font-size: 14px;
		color: #808285;
		.item {
			padding: .25em 15px;
			+ .item {
				border-top: 1px solid #fff;
			}
		}
	}
	> .button-container {
		background: #ebecec;
		padding-top: 1em;
		padding-bottom: 1em;
	}
	&.featured {
		transform: scale(1.05 );
		z-index: 1;
		> .title,
		> .price {
		}
	}
}


/* ==== JS ============================================= */
$('.price-boxes').fauxTable({
	cellSelector: '.price-box',
	cellInnerSelector: false
});
