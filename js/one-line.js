var oneLine = ( function(){
	var isOneLine = function( $container ){
		return $container[0].scrollWidth <= $container.outerWidth();
	}
	var init = function( $containers, args ){
		var settings = $.extend({
			fontSizeSelector: false,
			minSize: 8,
			maxSize: 60
		}, args );
		var _fontSize = false;

		$containers.each( function(){
			var $container = $(this)
				.css({
					whiteSpace: 'nowrap',
					width: '100%'
				})
				.resizedEvent({
					interval: 300
				});
			var $toAdjust = settings.fontSizeSelector ? $container.find( fontSizeSelector ) : $container;
			if ( $toAdjust.size() === 0 ) return;
			
			var _changingSize = false;
			$container.on( 'resized-w resized-init', function(e, info){
				clearInterval( _changingSize );
				if ( !_fontSize ){
					_fontSize = parseInt( $toAdjust.css('fontSize' ) );
				}
				var i = _fontSize;
				if ( isOneLine( $container ) ){
					_changingSize = setInterval( function(){
						if ( isOneLine( $container ) || i >= settings.maxSize ){
							i++;
							$toAdjust.css({
								fontSize: i
							});
						} else {
							clearInterval( _changingSize );
							_fontSize = i - 1;
							$toAdjust.css({
								fontSize: _fontSize
							});
						}
					}, 1 );
				} else {
					_changingSize = setInterval( function(){
						if ( isOneLine( $container ) || i <= settings.minSize ){
							clearInterval( _changingSize );
							_fontSize = i;
							return;
						} else {
							i--;
							$toAdjust.css({
								fontSize: i
							});
						}
					}, 1 );
				}
			});
		});
		
	};
	return {
		init: init
	};
}() );