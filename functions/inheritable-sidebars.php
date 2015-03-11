// function to retrieve correct sidebar
function get_page_sidebar( $post ){
	$sidebar = false;
	while ( $post && !$sidebar ){
		$has_sidebar = get_metabox_options( $post->ID, 'page-info', 'has_sidebar' );
		if ( $has_sidebar === 'no' ){
			return false;
		}
		$sidebar = get_metabox_options( $post->ID, 'page-info', 'sidebar' ); // false means to use parent's
		$post = $post->post_parent ? get_post( $post->post_parent ) : false;
	}
	return $sidebar;
}

// metabox
$Forms->add_metabox( array( 'post_type' => 'page' ), 'page-info', array(
		'---sidebar' => array(),
		'has_sidebar' => array(
			'type' => 'radio',
			'options' => array( 'yes' => 'Yes', 'no' => 'No' ),
			'default' => 'yes',
			'checkbox_label' => false
		),
		'sidebar' => array(
			'type' => 'select',
			'options' => 'sidebars',
			'first_option' => '- same as parent page -',
			'description' => 'Add new sidebars <a href="'.admin_url( 'admin.php?page=sidebar' ).'">here</a>',
			'toggle' => array(
				'has_sidebar' => 'yes'
			)
		),
	)
);
