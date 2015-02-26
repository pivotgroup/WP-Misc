<?php /* ==== TEMPLATE ============================================= */ ?>
<?php if ( !$feeds ) return; ?>
<div class="news-feeds">
	<ul class="tabs cf">
		<?php foreach( $feeds as $feed ){
			$tab_text = !empty( $feed['tab_title'] ) ? $feed['tab_title'] : $feed['title'] ; ?>
		<li class="tab"><a href="#feed-<?= sanitize_title( $feed['title'] ); ?>"><?= $tab_text; ?></a></li>
		<?php } ?>
	</ul>
	<div class="tabs-content">
		<?php foreach( $feeds as $feed ){ ?>
		<div class="tab-content" id="feed-<?= sanitize_title( $feed['title'] ); ?>">
			<div class="news-feed">
				<?php the_widget( 'WP_Widget_RSS', array(
					'title' => $feed['title'],
					'url' => $feed['feed_url'],
					'items' => 5,
					'show_summary' => false,
					'show_author' => false,
					'show_date' => true
				) ); ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<?php
/* ==== TO ADD ============================================= */
	'news_feed_tabs' => array(
		'fields' => array(
			'feeds' => array(
				'type' => 'group',
				'cloneable' => true,
				'subfields' => array(
					'title' => array(
						'required' => true
					),
					'tab_title' => array(
						'placeholder' => 'Defaults to title (above)'
					),
					'feed_url' => array(
						'required' => true,
						'description' => 'Ex. http://www.startribune.com/local/index.rss2'
					)
				)
			)
		)
	)
