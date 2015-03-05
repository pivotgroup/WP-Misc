<?php
/* ==== TO ADD ============================================= */
$Forms->add_shortcode( 'social_icons', array(
	'fields' => array(
		'items' => array(
			"type" => 'group',
			'cloneable' => true,
			'subfields' => array(
				'icon_type' => array(
					'type' => 'radio',
					'options' => array(
						'font_awesome',
						'image'
					),
					'default' => 'font_awesome',
				),
				'icon' => array(
					'size' => 10,
					'description' => 'Example: <strong>fa-facebook</strong> (All <a href="http://fontawesome.io/icons/#brand" target="_blank">FontAwesome Icons</a> can be used)',
					'toggle' => array(
						'icon_type' => '!image',
					)
				),
				'image' => array(
					'type' => 'media',
					'get' => 'image',
					'size' => 'medium',
					'toggle' => array(
						'icon_type' => 'image',
					)
				),
				'link' => array(
					'type' => 'link',
					'exclude' => array( 'wpLink' )
				)
			)
		)
	)
));

/* ==== TEMPLATE ============================================= */
<?php if(!empty($items)){ ?>
	<ul class="social-icons">
		<?php foreach ($items as $icon) {
			$icon_html = $icon['icon_type'] === 'image' ? $icon['image'] : '<i class="fa '.$icon['icon'].'"></i>'; ?>
			<li class="icon-<?= sanitize_title( $icon['link']['title'] ); ?>">
				<?php echo sprintfLink( $icon['link'], $icon_html, '' ); ?>
			</li>
		<?php } ?>
	</ul>
<?php } ?>
