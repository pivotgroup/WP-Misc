var toggling = ( function( ){
	var init = function( $button, $item, args ){
		args = $.extend( {}, {
			openSpeed: 200,
			closeSpeed: 200,
			activeClass: 'active',
			effect: 'slide',
			onOpen: function(){},
			onAfterOpen: function(){},
			onClose: function(){},
			onAfterClose: function(){}
		}, args);
		var _open = false;
		if ( args.effect === 'fade' ){
			var hideFunction = 'fadeOut';
			var showFunction = 'fadeIn';
		} else {
			var hideFunction = 'slideUp';
			var showFunction = 'slideDown';
		}

		var open = function(){
			_open = true;
			$item[ showFunction ]( args.openSpeed, function(){
				args.onAfterOpen.apply( $item[0] );
			});
			$button.addClass( args.activeClass );
			args.onOpen.apply( $item[0] );
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
			args.onClose.apply( $item[0] );
			$item[ hideFunction ]( args.closeSpeed, function(){
				_open = false;
				args.onAfterClose.apply( $item[0] );
			});
			$window.unbind( 'mousedown.mobile-menu touchstart.mobile-menu' );
		}
		function toggleItem(e) {
			if ( $(e.target).prop( 'tagName' ) === 'A' &&  $(e.target).attr('href') ){
				return;
			}
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