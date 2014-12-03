var matchHeights = ( function(){
	var init = function( $item1, $item2 ){
		if ( $item1.size() === 0 || $item2.size() === 0 ) return;
		function matchHeight( info ){
			$item1.height( '' );
			$item2.height( '' );
			if ( $window.width() < 768 ) return;
			var h1 = $item1.outerHeight();
			var h2 = $item2.outerHeight();
			if ( h1 > h2 ){
				$item2.height( h1 );
			} else {
				$item2.height( h2 );
			}
		}
		var _handling = false;
		$window.on( 'resized-w resized-init', matchHeight );
	};
	return {
		init: init
	};
}() );