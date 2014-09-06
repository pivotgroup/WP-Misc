	var imageCarousels = ( function(){
		var $sliders = $( '.collection-items' );
		var init = function(){
			$sliders.each( function(){
				var $slider = $(this);
				var $origEl = $slider.clone();
				var $items = $slider.find( '.touchcarousel-item' );
				var maxItemWidth = $items.width();
							
				function getNumCols(){
					var numCols = 2;
					var container_width = $slider.width();
					numCols = Math.ceil( container_width/maxItemWidth );

					if ( numCols < 1 ) numCols = 1;
					return numCols;
				}
				function getColWidth(){
					var container_width = $slider.width();
					return Math.floor( container_width / getNumCols() );
				}
				var refreshSlider = function(){
					if ( $slider.data( 'touchCarousel' ) ){
						var $newSlider = $origEl.clone() ;
						$slider.after( $newSlider );
						$slider.data( 'touchCarousel' ).destroy();
						$slider = $newSlider ;
						$items = $slider.find( '.touchcarousel-item' );
						general.init( $slider );
					}
					$items.css('width', getColWidth() );
					if ( getNumCols() < $items.size() ){
						$slider.removeClass('no-carousel');
						$slider.touchCarousel({
							itemsPerMove : getNumCols(),
							snapToItems : true,
							scrollBar : false,
							autoplay : true,
							loopItems : true
						});
					} else {
						$slider.addClass('no-carousel');
					}
				}
				$window.on( 'resized-w resized-init', refreshSlider );
			});
		}
		return {
			init : init
		}
	}() );
