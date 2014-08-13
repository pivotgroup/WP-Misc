var toggling = ( function( ){
	var init = function( $button, $item, args ){
		args = args || {};
		var openSpeed = args.openSpeed || 200;
		var closeSpeed = args.closeSpeed || 200;
		var _open = false;
		var open = function(){
			_open = true;
			$item.slideDown( openSpeed );
			setTimeout( function(){
				$window.on( 'mousedown.mobile-menu touchstart.mobile-menu', function(e){
					if ( $(e.target).closest( $item.add( $button ) ).size() === 0 ){
						close();
					}
				});
			}, 100 );
		}
		var close = function(){
			$item.slideUp( closeSpeed, function(){
				_open = false;
			});
			$window.unbind( 'mousedown.mobile-menu touchstart.mobile-menu' );
		}
		function toggleItem(e) {
			e.preventDefault();
			e.stopPropagation();
			if( _open ) {
				close();
			} else {
				open();
			}
		}
		$button.on( 'click touchstart', toggleItem );
	};
	return {
		init: init
	};
}() );
