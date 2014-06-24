
$features = array(
	'feature_slug' => array(
	  // field spec
	),
	'feature2_slug' => array(
	  // field spec
	)
);

$features_field = array(
	'title' => 'Page Features',
	'type' => 'checkbox',
	'options' => array_fill_keys( array_keys( $features ), '' )
);
/* ==== PAGE ============================================= */
$Forms->add_metabox( array( 'post_type' => 'page' ), 'page-info', array(
	'fields' => array(
	    // other fields can go here.
		'---enabled_features' => 'Enabled Features',
		'features' => $features_field
	)
));

/* ==== ENABLED FEATURES ============================================= */
$features_to_add = false;
if ( is_admin() && $Forms->wp_context_matches( array( 'post_type' => 'page' )) && !empty( $_GET['post'] )) {
	if( $enabled_features = get_metabox_options( $_GET['post'], "page-info", "features" ) ){
		$features_to_add = array_intersect_key( $features, $enabled_features );
	}
} else {
	$features_to_add = $features;
}
if ( $features_to_add ){
	foreach( $features_to_add as $slug => $feature_to_add ){
		$features_to_add[$slug]['description'] = '['.$slug.']  <-- to insert on page';
	}
	$Forms->add_metabox( array( 'post_type' => 'page'), 'page_features', array(
		'defaults' => array(
			'field' => array(
				'layout' => array(
					'title', 'description', 'input', 'error'
				)
			)
		),
		'fields' => $features_to_add
	));
}
