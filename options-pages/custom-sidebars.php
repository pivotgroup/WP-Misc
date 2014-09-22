// options-pages.php
'sidebars' => array(
	'fields' => array(
		'sidebars' => array(
			'cloneable' => array(
				'sort' => false,
			),
			'description' => 'Only letters, numbers, and spaces. Must start with a letter',
			'validation' => '/^[A-Za-z][A-Za-z0-9 ]+$/',
			'required' => 'Please give your sidebar a name',
			'error' => 'Only letters, numbers, and spaces. Must start with a letter'
		)
	)
)

// in Theme.php

	protected static function get_sidebars(){
		$sidebars = array() ;

		// add in dynamic, custom sidebars
		$custom_sidebars =  get_theme_options( 'theme_options', 'sidebars', 'sidebars' );
		foreach( $custom_sidebars as $key => $value ){
			self::$sidebars['theme-sidebar-'.$key] = $value;
		}
		
		foreach( self::$sidebars as $slug => $sidebar_name ){
			$slug = is_numeric( $slug ) ? strtolower( preg_replace( '/ /', '-',  $sidebar_name ) ) : $slug;
			$sidebars[] = array(
				'id' => $slug,
				'name'	=> $sidebar_name,
				'before_title' => '<h3 class="title">' ,
				'after_title' => '</h3>',
				'before_widget' => '<li id="%1$s" class="widget text-content %2$s" >' ,
				'after_widget'	=> '</li>'
			);
		}
		return $sidebars ;
	}
