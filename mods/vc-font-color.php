/* ==== ADD FONT COLOR TO VC ROWS ============================================= */
add_action( 'vc_after_init', 'add_font_color_to_vc_rows');
function add_font_color_to_vc_rows(){
	global $vc_manager;
	$row_shortcode = $vc_manager->vc()->getShortcode( 'vc_row' );
	$params = $vc_manager->vc()->getShortcode( 'vc_row' )->settings( 'params' );
	array_unshift( $params, array(
		'type' => 'colorpicker',
		'heading' => __( 'Font Color', 'js_composer' ),
		'param_name' => 'font_color',
		'description' => __( 'Select font color', 'js_composer' ),
		'edit_field_class' => 'vc_col-md-6 vc_column'
	) );
	vc_map_update( 'vc_row', array(
		'params' => $params
	));
}
