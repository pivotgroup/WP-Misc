<?php class Helpers {
	protected $colors = array();
	protected $commonClasses = array(
		// bootstrap visibility classes
		'hidden-xs', 'hidden-sm', 'hidden-md', 'hidden-lg', 'visible-xs', 'visible-sm', 'visible-md', 'visible-lg',
		// utility
		'align' => 'text-align-%s',
		'class' => '%s'
	);
	protected $commonAttributes = array(
		'id' => '%s',
		'style' => '%s',
		'href' => '%s',
		'target' => '%s',
		// just for reference...special behavior
		'data' => '%s'
	);

	public function __construct( $options = array() ){
		$defaultOptions = array(
			'ABS' => __DIR__,
			'url' => '',
			'componentFolder' => 'components',
			'commonClasses' => false,
			'commonAttributes' => false,
			'colors' => false
		);
		$settings = array_merge( $defaultOptions, $options );
		$this->ABS = $settings['ABS'];
		$this->dir = $settings['url'];
		$this->settings = $settings;
		// common classes to pass through (or format first) and then add to the element
		if ( $settings['commonClasses'] ){
			$this->commonClasses = array_merge( $this->commonClasses, $settings['commonClasses'] );
		}
		// common attributes to pass through according to a format and then add to the element
		if ( $settings['commonAttributes'] ){
			$this->commonAttributes = array_merge( $this->commonAttributes, $settings['commonAttributes'] );
		}
		if ( is_array( $settings['colors'] ) ){
			$this->colors = $settings['colors'];
		}
	}
	/* ==== FUNCTIONS ============================================= */

	public function printAttributes( $atts ){
		$atts_array = array();
		foreach( $atts as $name => $value ){
			if ( $name === 'data' ){
				foreach( $value as $key => $val ){
					if ( is_array( $val ) ){
						$atts_array[] = 'data-'.$key.'=\''.json_encode( $val ).'\'' ;
					} else {
						$atts_array[] = 'data-'.$key.'=\''.$val .'\'' ;
					}
				}
			} else {
				if ( is_array( $value ) && $name === 'class' ){
					$atts_array[] = $name .'="'.implode( ' ', $value ).'"';
				} else {
					$atts_array[] = $name .'="'.htmlentities( $value ).'"';
				}
			}
		}
		return implode( ' ', $atts_array );
	}
	public function addCommonAttributes( $atts = array(), $attributes = array() ){
		if ( !is_array( $atts ) ) return $attributes;

		$classes = isset( $attributes['class'] ) ? $attributes['class'] : array();
		$attributes['class'] = $this->addCommonClasses( $atts, $classes );
		foreach( $this->commonAttributes as $attName => $attValue ){
			if( !empty( $atts[ $attName ] ) ){
				$attributes[$attName] = $attName === 'data' ? $atts[$attName] : sprintf( $attValue, $atts[ $attName ] ) ;
			}
		}
		return $attributes;
	}
	// 1) scan the $atts and then
	// 2) return an array of all the common classes
	public function addCommonClasses( $atts = array(), $classes = array() ){
		if ( !is_array( $atts ) ) return $classes;
		
		if ( is_string( $classes ) ){
			$classes = array( $classes );
		}
		foreach( $atts as $i => $att ){
			if ( is_string( $i ) ){
				if ( $i === 'class' ){
					if ( is_string( $att ) ){
						$classes[] = $att;
					} else if ( is_array( $att ) ){
						$classes = array_merge( $classes, $att );
					}
				} else if ( $i !== 'data' && !empty( $this->commonClasses[ $i ])){
					$classes[] = sprintf( $this->commonClasses[ $i ], $att );
				}
			} else if( array_search( $att, $this->commonClasses, true ) !== false ){
				$classes[] = $att;
			}
		}
		foreach( $this->colors as $color ){
			if ( array_search( $color, $atts, true ) !== false ){
				$classes[] = 'color-' . $color;
			}
		}
		return $classes;
	}

	/* ==== FUNCTIONS ============================================= */
	public function tag( $tag, $atts = array(), $content = false ){
		echo $this->getTag( $tag, $atts, $content );
		return true;
	}
	public function getTag( $tag = 'div', $atts = array(), $content = false ){
		$tags = array( 'h1', 'h2',  'h3', 'h4', 'h5', 'h6', 'p', 'div', 'blockquote', 'span', 'em', 'strong', 'a' );
		$tagToUse = 'div';
		if ( array_search( $tag, $tags ) !== false ){
			$tagToUse = $tag;
		}
		$attributes = $this->addCommonAttributes( $atts );
		return '<'.$tagToUse.' '.$this->printAttributes( $attributes ).' >'.$content.'</'.$tagToUse.'>';
	}

	public function component( $file_name, $template_vars = array() ){
		if ( strpos($file_name, '/') === 0 ){
			$file_abs_path = basename( $file_name );
		} else {
			$file_abs_path = $this->ABS .'/'.$this->settings['componentFolder'].'/'.$file_name ;
		}
		if ( strpos( $file_abs_path, '.php' ) !== strlen( $file_abs_path ) - 4 ){
			$file_abs_path .= '.php';
		}
		if ( file_exists( $file_abs_path ) ){
			$atts['classes'] = $this->addCommonclasses( $template_vars );
			extract( $template_vars );
			include( $file_abs_path );
		}
	}
	public function getComponent( $file_name, $template_vars = array() ){
		ob_start();
			$this->component( $file_name, $template_vars );
		return ob_get_clean();
	}

	public function text( $tag, $atts = array(), $content = false ){
		echo $this->getText( $tag, $atts, $content );
		return true;
	}
	public function getText( $tag, $atts = array(), $content = false ){
		$sizeAtts = array();
		if ( !empty( $atts['xxs'] )){
			$sizeAtts['xxs'] = intVal( $atts['xxs'] );
		}
		if ( !empty( $atts['xs'] )){
			$sizeAtts['xs'] = intVal( $atts['xs'] );
		}
		if ( !empty( $atts['sm'] )){
			$sizeAtts['sm'] = intVal( $atts['sm'] );
		}
		if ( !empty( $atts['md'] )){
			$sizeAtts['md'] = intVal( $atts['md'] );
		}
		if ( !empty( $atts['lg'] )){
			$sizeAtts['lg'] = intVal( $atts['lg'] );
		}
		if ( empty( $atts['class'] ) ){
			$atts['class'] = array();
		} else {
			$atts['class'] = is_array( $atts['class'] ) ? $atts['class'] : array( $atts['class'] );
		}
		foreach( $sizeAtts as $name => $size ){
			$atts[ 'class' ][] = 'size-'.$name . '-'.$size;
		}
		return $this->getTag( $tag, $atts, $content );
	}
	public function button( $atts = array(), $content = '' ){
		echo $this->getButton( $atts, $content );
		return true;
	}
	public function getButton( $atts = array(), $content = '' ){
		$atts['name'] = 'button';
		
		if ( ! $content ) return;

		$classes = array( 'button' );

		$sizes = array( 'small', 'large' );
		$quick_types = array( 'solid', 'hollow' );
		
		foreach( $sizes as $size ){
			if ( in_array( $size, $atts )){
				$classes[] = 'button-'.$size;
			}
		}
		foreach( $quick_types as $quick_type ){
			if ( in_array( $quick_type, $atts )){
				$classes[] = 'type-'.$quick_type;
			}
		}
		if ( !empty( $atts['type'] )){
			$classes[] = 'type-'.$atts['type'];
		}
		$link = '';
		foreach( $atts as $att ){
			if ( strpos( $att, 'http://' ) === 0 || strpos( $att, '#' ) === 0 ){
				$link = $att;
			}
		}
		$atts['class'] = $classes;
		$atts['href'] = $link;
		return $this->getTag( 'a', $atts, $content );
	}
	/* ---- bootstrap -------------------------------------- */
	public function section( $atts = array(), $content = '' ){
		$html_attributes = array();
		$atts['name'] = 'section' ;
		$padding = !empty( $atts['padding'] ) ? $atts['padding'] : '';
		$bg_color = !empty( $atts['bg_color'] ) ? $atts['bg_color'] : '';
		$bg_img = !empty( $atts['bg_image'] ) ? $atts['bg_image'] : '';
		$style = '';
		if ( $padding ) $style .= 'padding-top: '.$padding . 'px; padding-bottom: ' .$atts['padding'] .'px;' ;
		if ( $bg_color ) $style .= 'background-color: '.$bg_color.'; ';
		if ( $bg_img ) $style .= 'background-image: url('.$bg_img .');';
		if ( $style ){
			$html_attributes['style'] = $style;
		}
		$attributes = $this->addCommonAttributes( $atts, $html_attributes ); ?>
		<section <?php echo $this->printAttributes( $attributes ); ?>>
			<div class="container">
				<?php echo $content; ?>
			</div>
		</section>
		<?php return true;
	}
	public function getSection( $atts = array(), $content = '' ){
		ob_start();
			$this->section( $atts, $content );
		return ob_get_clean();
	}
	public function row( $atts = array(), $content = '' ){
		echo $this->getRow( $atts, $content );
		return true;
	}
	public function getRow( $atts = array(), $content = '' ){
		$attributes = $this->addCommonAttributes( $atts, array(
			'class' => array( 'row' )
		));

		return '<div '.$this->printAttributes( $attributes ).' >' . $content .'</div>';
	}
	public function col( $atts = array(), $content = '' ){
		echo $this->getCol( $atts, $content );
		return true;
	}
	public function getCol( $atts = array(), $content = '' ){
		$gridAtts = array();
		if ( !empty( $atts['xxs'] ) ){
			$gridAtts['xxs'] = intval( $atts['xxs'] );
		}
		$gridAtts['xs'] = !empty( $atts['xs'] ) ? intval( $atts['xs'] ) : 12;
		$gridAtts['sm'] = !empty( $atts['sm'] ) ? intval( $atts['sm'] ) : false;
		$gridAtts['md'] = !empty( $atts['md'] ) ? intval( $atts['md'] ) : false;
		$gridAtts['lg'] = !empty( $atts['lg'] ) ? intval( $atts['lg'] ) : false;
		$gridAtts['sm-push'] = !empty( $atts['smpush'] ) ? intval( $atts['smpush'] ) : false;
		$gridAtts['md-push'] = !empty( $atts['mdpush'] ) ? intval( $atts['mdpush'] ) : false;
		$gridAtts['lg-push'] = !empty( $atts['lgpush'] ) ? intval( $atts['lgpush'] ) : false;
		$gridAtts['sm-pull'] = !empty( $atts['smpull'] ) ? intval( $atts['smpull'] ) : false;
		$gridAtts['md-pull'] = !empty( $atts['mdpull'] ) ? intval( $atts['mdpull'] ) : false;
		$gridAtts['lg-pull'] = !empty( $atts['lgpull'] ) ? intval( $atts['lgpull'] ) : false;
		$gridAtts['sm-offset'] = !empty( $atts['smoffset'] ) ? intval( $atts['smoffset'] ) : false;
		$gridAtts['md-offset'] = !empty( $atts['mdoffset'] ) ? intval( $atts['mdoffset'] ) : false;
		$gridAtts['lg-offset'] = !empty( $atts['lgoffset'] ) ? intval( $atts['lgoffset'] ) : false;

		$classes = array();
		foreach( $gridAtts as $size => $num ){
			if ( $num && $num > 0 && $num < 13){
				$classes[] = 'col-'.$size.'-'.$num;
			}
		}
		$attributes = $this->addCommonAttributes( $atts, array(
			'class' => $classes
		) ) ;
		$output = '<div '.$this->printAttributes( $attributes ).'>'."\n";
		$output .= $content ."\n";
		$output .= '</div>';
		return $output;
	}
	public function gap( $atts = 30 ){
		echo $this->getGap( $atts );
		return true;
	}
	public function getGap( $atts = 30 ){
		$classes = array( 'gap' );
		if ( is_array( $atts ) ){
			$number = 0;
			if ( isset( $atts[0]) && is_numeric( $atts[0]) ){
				$number = intval( $atts[0] );
			}
			$attributes['class'] = $this->addCommonClasses( $atts, $classes );
		} else {
			$number = $atts;
		}
		$atts = array();
		if ( $number > 0 ){
			$atts['height'] = $number;
		} else {
			$atts['margin-top'] = $number;
			$atts['height'] = 0;
		}
		$style = '';
		if ( !empty( $atts['height'] ) || $atts['height'] === 0 ) $style .= 'padding-bottom: '.$atts['height'].'px; ';
		if ( !empty( $atts['margin-top'] ) ) $style .= 'margin-top: '.$atts['margin-top'].'px; ';

		$attributes = array();
		if ( $style ){
			$attributes[ 'style' ] = $style;
		}
		return $this->getTag( 'div', $attributes );
	}
}