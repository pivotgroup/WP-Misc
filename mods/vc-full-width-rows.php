/* ==== MAKE ALL ROWS FULL-WIDTH ============================================= */
function vc_theme_before_vc_row($atts, $content = null) {
	$output = '';
	
	// transfer class to container
	$class = '';
	if ( !empty( $atts['css'] ) ){
		$matches = array();
		preg_match_all( '/^\.(.+)\{/', $atts['css'], $matches );
		if ( isset( $matches[1] ) ){
			$class = $matches[1][0];
		}
		
	}

	$output .= '<div class="full-width-row '.$class.'">';
	$no_container = !empty( $atts['el_class'] ) && strpos( $atts['el_class'], 'no-container' ) !== false;
	if ( ! $no_container ){
		$output .= '<div class="container">';
	}
	return $output;
}
function vc_theme_after_vc_row($atts, $content = null) {
	$output = '';
	$no_container = !empty( $atts['el_class'] ) && strpos( $atts['el_class'], 'no-container' ) !== false;

	if ( ! $no_container ){
		$output .= '</div>';
	}
	$output .= '</div>';
	return $output;
}