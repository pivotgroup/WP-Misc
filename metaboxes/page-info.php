$Forms->add_metabox( array( 'post-type' => 'page' ), 'page-info', array(
	'fields' => array(
		'has_sidebar' => array(
			'type' => 'radio',
			'inline' => true,
			'options' => array(
				'no' => 'No',
				'yes' => 'Yes'
			),
			'default' => 'no'
		),
		'sidebar' => array(
			'type' => 'select',
			'options' => 'sidebars',
			'toggle' => array(
				'has_sidebar' => 'yes'
			)
		),
		'sidebar_position' => array(
			'type' => 'radio',
			'inline' => true,
			'options' => array(
				'left' => 'Left',
				'right' => 'Right'
			),
			'default' => 'right',
			'toggle' => array(
				'has_sidebar' => 'yes'
			)
		)
	)
));
