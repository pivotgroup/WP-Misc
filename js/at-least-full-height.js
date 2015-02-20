	var atLeastFullHeight = ( function(){
		var $header = $('header.site' );
		var $footer = $('footer.site' );
		var init = function( $el, minusHeaderAndFooter ){
			var getHeight = function(){
				var h = $window.height();
				if ( minusHeaderAndFooter ){
					h -= $header.outerHeight();
					h -= $footer.outerHeight();
				}
				return h;
			}
			function setHeight(){
				$el.css( 'minHeight', '' );
				var fullHeight = getHeight();
				if ( $el.outerHeight() < fullHeight ){
					$el.css('minHeight', fullHeight );
				}
			}
			$window.on( 'resized-h resized-init', setHeight );
			setHeight();
		};
		return {
			init: init
		};
	}() );
	atLeastFullHeight( $('#content' ) );
