<?php
/* ==== TEMPLATE ============================================= */
if ( empty( $boxes ) ){
	return;
}
?>
<div class="link-boxes number-<?= sizeof( $boxes ); ?> cf">
	<?php foreach( $boxes as $box ){
		$target = $box['link']['target'] ? 'target="_blank"' : '';
		$title = $box['link']['title'] ? $box['link']['title'] : '';
		$image = !empty( $box['image'] ) ? getMediaFromID( $box['image'], 'image' ) : '';
	?><div class="link-box">
		<a href="<?= $box['link']['url']; ?>" <?= $target; ?>>
			<span class="image">
				<?= $image; ?>
			</span>
			<span class="title"><?= $title; ?></span>
		</a>
	</div><?php
	} ?>
</div>

/* ==== TO ADD ============================================= */
$Forms->add_shortcode( 'link_boxes', array(
	'fields' => array(
		'boxes' => array(
			'type' => 'group',
			'cloneable' => true,
			'subfields' => array(
				'image' => array(
					'type' => 'media',
					'get' => 'image',
					'size' => 'full'
				),
				'link' => array(
					'type' => 'link'
				)
			)
		)
	)
));

/* ==== SCSS ============================================= */
/* ==== LINK BOXES ============================================= */
.link-boxes {
	margin: 0 -15px;
	text-align: center;
	.link-box {
		display: inline-block;
		padding: 0 15px;
	}
	&.number-2 {
		.link-box {
			width: 50%;
		}
	}
	&.number-3 {
		.link-box {
			width: 33.333%;
		}
	}
	&.number-4 {
		.link-box {
			width: 25%;
		}
	}
	&.number-5 {
		.link-box {
			width: 33.33%;
		}
	}
}
.link-box {
	text-align: center;
	.image {
		display: block;
		img {
			transform: scale( .96 );
			@include transition( .3s ease all );
		}
	}
	.title {
		display: block;
		font-size: 22px;
		color: $darkGray;
		margin-top: .5em;
	}
	&:hover {
		.image {
			img {
				transform: scale( 1 );
			}
		}
	}
}
