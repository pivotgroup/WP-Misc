/* ==== FULL-HEIGHT SECTIONS ============================================= */
var sections = ( function(){
	var init = function( $sections ){
		var i = 0;
		$sections.each( function(){
			var $section = $(this);
			var $content = $section.children( '.vc_column_container, .container' );
			var getTextHeight = function(){
				$content.height( '' );
				var h = getMaxHeight( $content ) + 100;
				$content.height( '100%' );
				return h;
			}
			var textHeight = getTextHeight();
			function makeSectionsWindowHeight( e, info ){
				textHeight = getTextHeight();
				$section.height( $window.height() > textHeight ? $window.height() : textHeight );
			}
			// make height full height when window resizes
			$window.on( 'resized-h resized-init', makeSectionsWindowHeight );
			makeSectionsWindowHeight();
		});
	};
	return {
		init: init
	};
}() );