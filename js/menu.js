	/* ==== mobile menu ============================================= */
	var mobileMenu = ( function(){
		var $menu = $('.mobile-menu .menu' );
		var $button = $('.mobile-menu-button' );
		var openSpeed = 300;
		var closeSpeed = 300;
		var _open = false;
		var open = function(){
			_open = true;
			$menu.slideDown( openSpeed );
			setTimeout( function(){
				$window.on( 'mousedown.mobile-menu touchstart.mobile-menu', function(e){
					if ( $(e.target).closest( '.menu' ).size() === 0 ){
						close();
					}
				});
			}, 100 );
		}
		var close = function(){
			_open = false;
			$menu.slideUp( closeSpeed );
			$window.unbind( 'mousedown.mobile-menu touchstart.mobile-menu' );
		}
		function toggleOverlay(e) {
			e.preventDefault();
			e.stopPropagation();
			if( _open ) {
				close();
			} else {
				open();
			}
		}
		var init = function(){
			$button.on( 'click touchstart', toggleOverlay );
		};
		return {
			init: init
		};
	}() );
