/* ==== TO ADD ============================================= */
$Forms->add_shortcode( 'content_with_sideblock', array(
	'fields' => array(
		'content' => array(
			'type' => 'wysiwyg'
		),
		'sideblock' => array(
			'type' => 'wysiwyg'
		),
		'sideblock_position' => array(
			'type' => 'radio',
			'inline' => true,
			'options' => array( 'Left', 'Right' ),
			'default' => 'Left'
		),
		'border' => array(
			'type' => 'group',
			'subfields' => array(
				'width' => array(
					'placeholder' => '3px'
				),
				'color' => array(
					'type' => 'color',
					'default' => '#f5a21f'
				)
			)
		)
	)
));

/* ==== TEMPLATE ============================================= */
<?php $border = isset( $border ) ? $border : array(
	'color' => '#f6a320',
	'width' => '3px'
); ?>
<div class="content-w-side-block position-<?= strtolower( $sideblock_position ); ?>">
	<div class="row">
		<?php $grid_classes = array( 'col-sm-4' );
		if ( $sideblock_position === 'Right') $grid_classes[] = 'col-sm-push-8';

		$border_style = false;
		$border_width = !empty( $border['width'] ) ? $border['width'] : '3px';
		if ( $border_width !== '0px' ){
			$border_style = $sideblock_position === 'Right' ? 'border-left-width: '.$border_width . ';' : 'border-right-width: '.$border_width . ';' ;
			$border_style .= 'border-style: solid;';
			$border_style .= 'border-color: '.$border['color'] . ';';
		} ?>
		<div class="side-block <?= implode( ' ', $grid_classes ); ?>" style="<?= $border_style; ?>">
			<?= do_shortcode( $sideblock ); ?>
		</div>
		<?php $grid_classes = array( 'col-sm-8' );
		if ( $sideblock_position === 'Right') $grid_classes[] = 'col-sm-pull-4'; ?>
		<div class="content-block <?= implode( ' ', $grid_classes ); ?>">
			<?= $content; ?>
		</div>
	</div>
</div>


/* ==== SCSS ============================================= */
/* ==== CONTENT w SIDE BLOCK ============================================= */
.content-w-side-block {
	> .row {
		display: table;
		table-layout: fixed;
		> * {
			display: table-cell;
			vertical-align: middle;
			float: none;
		}
	}
	&.position-left {
		.side-block {
			text-align: right;
		}
		.content-block {
			text-align: left;
		}
		> .row {
			> * {
				padding-left: 30px;
				&:first-child {
					padding-right: 30px;
					padding-left: 15px;
				}
			}
		}
	}
	&.position-right {
		.side-block {
			text-align: left;
		}
		.content-block {
			text-align: right;
		}
		> .row {
			> * {
				padding-right: 30px;
				&:first-child {
					padding-left: 30px;
					padding-right: 15px;
				}
			}
		}
	}
}
