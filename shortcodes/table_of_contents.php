/* ==== SHORTCODE ============================================= */
$toc_items_template = array(
	'type' => 'group',
	'cloneable' => true,
	'subfields' => array(
		'title' => array(
			'title' => false,
			'placeholder' => 'Title'
		),
		'page_number' => array(
			'title' => false,
			'placeholder' => 'Page',
			'size' => 5,
		),
		'has_sub_items' => array(
			'title' => false,
			'type' => 'checkbox',
			'checkbox_label' => 'Sub-items?'
		),
		'subitems' => array(
			'cloneable' => true,
			'title' => 'Sub-items',
			'type' => 'group',
			'toggle' => 'has_sub_items',
			'subfields' => null // replaced below
		)
	)
);
$toc_items = $toc_items_template;
$toc_items['subfields']['subitems']['subfields'] = $toc_items_template['subfields'];
unset( $toc_items_template['subfields']['has_sub_items'] );
unset( $toc_items_template['subfields']['subitems'] );
$toc_items['subfields']['subitems']['subfields']['subitems']['subfields'] = $toc_items_template[ 'subfields' ];
$Forms->add_shortcodes( array(
	'staff_list' => array(
		'fields' => array(
			'show_all' => array(
				'type' => 'radio',
				'options' => array( 'all' => 'Show All', 'pick' => 'Nah, pick and reorder' ),
				'default' => 'all'
			),
			'items' => array(
				'type' => 'listPick',
				'options' => 'staff_member',
				'toggle' => array(
					'show_all' => 'pick'
				)
			)
		)
	),
	'table_of_contents' => array(
		'icon' => 'list-ol',
		'fields' => array(
			'title' => array(
				'placeholder' => 'Table of Contents'
			),
			'items' => $toc_items
		)
	)
));

/* ==== TEMPLATE ============================================= */
<?php if ( ! $items ) return; ?>
<div class="table-of-contents">
	<h3 class="title"><?= empty( $title ) ? 'Table of Contents' : $title; ?></h3>
<?php foreach( $items as $item ){ ?>
	<div class="line-item cf">
		<div class="title"><span class="text"><?= $item['title']; ?></span><span class="underline"></span></div>
		<div class="page"><?= $item['page_number']; ?></div>
	</div>
	<?php if ( !empty( $item['has_sub_items'] ) && $item['subitems'] ){
		foreach( $item['subitems'] as $item ){ ?>
		<div class="line-item sub-item cf">
			<div class="title"><span class="text"><?= $item['title']; ?></span><span class="underline"></span></div>
			<?php if ( !empty( $item['page_number'])){ ?>
			<div class="page"><?= $item['page_number']; ?></div>
			<?php } ?>
		</div>
		<?php if ( !empty( $item['has_sub_items'] ) && $item['subitems'] ){
			foreach( $item['subitems'] as $item ){ ?>
			<div class="line-item sub-sub-item cf">
				<div class="title"><span class="text"><?= $item['title']; ?></span></div>
				<?php if ( !empty( $item['page_number'])){ ?>
				<div class="page"><?= $item['page_number']; ?></div>
				<?php } ?>
			</div>
			<?php }
		} ?>
		<?php }
	} ?>
<?php } ?>
</div>

/* ==== SCSS ============================================= */
/* ==== TABLE OF CONTENTS ============================================= */
.table-of-contents {
	padding: 2em 30px;
	border: 1px solid #efefef;
	border-radius: 10px;
	margin: 1.5em 0;
	> .title {
		text-align: center;
		text-decoration: underline;
		color: #333;
	}
	.line-item {
		position: relative;
		padding: .5em 30px .5em 0;
		.title {
			display: block;
			border-bottom: 1px solid #ddd;
			line-height: 1em;
			> * {
				display: table-cell;
			}
			.text {
				line-height: 1em;
				padding-right: 10px;
				display: inline-block;
				background: #fff;
				position: relative;
				top: 3px;
			}
		}
		.page {
			position: absolute;
			top: .375em;
			right: 0;
			margin-top: 2px;
		}
		&.sub-item {
			.text {
				white-space: normal;
			}
			.title {
				border-bottom: none;
				padding-left: 30px;
			}
		}
		&.sub-sub-item {
			.text {
				white-space: normal;
			}
			.title {
				padding-left: 60px;
				border-bottom: none;
			}
		}
	}
}
