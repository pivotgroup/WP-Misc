	var toggling = ( function( ){
		var init = function( $button, $item, args ){
			args = $.extend( {}, {
				openSpeed: 200,
				closeSpeed: 200,
				activeClass: 'active'
			}, args);
			var _open = false;
			var open = function(){
				_open = true;
				$item.slideDown( args.openSpeed );
				$button.addClass( args.activeClass );
				setTimeout( function(){
					$window.on( 'mousedown.mobile-menu touchstart.mobile-menu', function(e){
						if ( $(e.target).closest( $item.add( $button ) ).size() === 0 ){
							close();
						}
					});
				}, 100 );
			}
			var close = function(){
				$button.removeClass( args.activeClass );
				$item.slideUp( args.closeSpeed, function(){
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
