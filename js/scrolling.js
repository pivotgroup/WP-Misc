	/* ==== SCROLLING ============================================= */
	var scrolling = ( function( args ){
		var scrolling = {};
		_.extend( scrolling, Backbone.Events);

		var settings = $.extend( true, {}, {
			trackers: {
				pageTop: function( info ){
					return info.progress.percent <= 0;
				},
				pageBottom: function( info ){
					return info.progress.percent >= 100;
				}
			}
		}, args );

		// object for storing all the information associated with scrolling and screenheight.
		var info = {
			windowHeight: $window.height(),
			bodyHeight: $body.height(),
			scrollTop: $window.scrollTop(),
			direction: 'down',
			progress: {
				px: 0,
				percent: 0
			},
			screenBottom: {
				px: $window.height(),
				percent: 0
			}
		};

		var TrackerM = Backbone.Model.extend({
			defaults: {
				id: name,
				type: 'point',
				value: false,
				inView: false
			},
			initialize: function(){

			},
			handleScroll: function(){
				this.set( 'inView', this.isInView() );
			},
			getInfo: function( pixelsOrPercent){
				var trackerInfo = {
					progress: _.extend( {}, info.progress ),
					direction: info.direction,
					inView: this.get('inView'),
				}
				switch( this.get('type' ) ){
					case 'pixel':
						trackerInfo.pointInfo = scrolling.getPxScreenInfo( tracker.get('value') );
						break;
					case 'percent':
						trackerInfo.pointInfo = scrolling.getPxScreenInfo( getPercentInPx( tracker.get('value') ) );
						break;
					case 'element':
						trackerInfo.elementInfo = scrolling.getElementScreenInfo( tracker.get('value') );
						break;
					case 'custom':
						break;
				}
				return trackerInfo;
			},
			isInView: function(){
				switch( this.get('type') ){
					case 'pixel':
						return scrolling.isPxInView( this.get('value') );
						break;
					case 'percent':
						return scrolling.isPercentInView( this.get('value') );
						break;
					case 'element':
						return scrolling.isElementInView( this.get('value' ) );
						break;
					case 'custom':
						return scrolling.isCustomInView( this.get('value' ) );
				}
			},
			getTopPos: function( unit ){
				if ( unit === 'percent' ) unit = '%';
				switch( this.get('type') ){
					case 'pixel':
						return unit === '%' ? scrolling.getPxInPercent( this.get('value') ) : this.get('value');
					case 'percent':
						return unit === '%' ? this.get('value') : scrolling.getPercentInPx( this.get('value') );
					case 'element':
						return unit === '%' ? scrolling.getPxInPercent( this.get('value').offset().top ) : this.get('value').offset().top ;
					case 'custom':
						// nada
				}
				return undefined;
			},
			getBottomPos: function( unit ){
				if ( unit === 'percent' ) unit = '%';
				switch( this.get('type') ){
					case 'pixel':
					case 'percent':
						return this.getTopPos( unit );
					case 'element':
						return unit === '%' ? scrolling.getPxInPercent( this.get('value').offset().top + this.get('value').outerHeight() ) : this.get('value').offset().top + this.get('value').outerHeight() ;
					case 'custom':
						// nada
				}
				return undefined;
			},
			getScreenPos: function( unit, fromBottomOfElement ){
				if ( !fromBottomOfElement ) fromBottomOfElement = false;
				if ( unit === 'percent' ) unit = '%';

				var fromScreenTop = fromBottomOfElement ? this.getBottomPos( 'px' ) - info.progress.px : this.getTopPos( 'px' ) - info.progress.px ;
				return unit === '%' ? fromScreenTop / info.windowHeight : fromScreenTop;
			},
			getBottomScreenPos: function( unit, fromBottomOfElement ){
				if ( !fromBottomOfElement ) fromBottomOfElement = false;
				if ( unit === 'percent' ) unit = '%';

				var fromScreenBottom = fromBottomOfElement ? info.screenBottom.px - this.getBottomPos( 'px' ) : info.screenBottom.px - this.getTopPos( 'px' ) ;
				return unit === '%' ? fromScreenBottom / info.windowHeight : fromScreenBottom;
			}
		});
		var trackers = new Backbone.Collection( [], {
			model: TrackerM
		});

		function getScrollHeight(){
			return ( info.bodyHeight - info.windowHeight );
		}
		function getPxInPercent( px ){
			return px / getScrollHeight()
		}
		function getPercentInPx( percent ){
			return percent * getScrollHeight();
		}
		function isPxInView( px ){
			return info.progress.px <= px && px <= info.screenBottom.px;
		}
		function isPercentInView( percent ){
			return info.progress.percent <= percent && percent <= info.screenBottom.percent;
		}
		function isElementCoveringView( $element ){
			return ( $element.offset().top <= info.progress.px && ( $element.offset().top + $element.outerHeight() ) >= info.progress.px )
		}
		function isElementInView( $element ){
			if( isPxInView( $element.offset().top ) || isPxInView( $element.offset().top + $element.outerHeight() ) ){
				return true;
			} else if ( isElementCoveringView( $element ) ){
				return true;
			}
			return false;
		}
		function isCustomInView( isInViewTest ){
			return isInViewTest( info );
		}

		/* ==== ADDING TRACKERS ============================================= */
		function addPointTracker( name, point ){
			var type = false;
			if ( _.isString( point ) && point.indexOf( '%' ) === (point.length - 1) ){
				type = 'percent';
				value = parseInt( point );
			} else if ( _.isNumber( point ) ) {
				type = 'pixel';
				value = parseInt( point );
			}
			trackers.add({
				id: name,
				type: type,
				value: value,
				inView: false
			});
		}
		function addElementTracker( name, $element ){
			if ( $element instanceof jQuery && $element.size() > 0 ){
				// just pass through
			} else if ( _.isElement( $element ) ){
				$element = $( $element );
			} else {
				return;
			}
			trackers.add({
				id: name,
				type: 'element',
				value: $element,
				inView: false
			});
		}
		function addCustomTracker( name, inViewTest ){
			trackers.add({
				id: name,
				type: 'custom',
				value: inViewTest,
				inView: false
			});
		}

		function addTracker( name, value ){
			if ( _.isString( value ) || _.isNumber( value ) ){
				addPointTracker( name, value );
			} else if ( _.isFunction( value ) ){
				addCustomTracker( name, value );
			} else {
				addElementTracker( name, value );
			}
		}

		/* ==== INITIALIZE! ============================================= */
		function handleScroll(e){
			var s = $body.scrollTop();
			info.direction = info.progress.px < s ? 'down' : 'up';
			info.progress.px = s;
			info.progress.percent = info.progress.px / getScrollHeight() * 100;
			info.screenBottom.px = s + info.windowHeight;
			info.screenBottom.percent = info.screenBottom.px / getScrollHeight() * 100;
			
			// assign events
			trackers.each( function( tracker, id ){
				tracker.handleScroll();
				if ( tracker.get('inView') ){
					scrolling.trigger( tracker.get('id') + ':inView', tracker );
				}
			});
		}
		// you got it, track all the information on resize.
		$window.on( 'resized-h resized-init', function(){
			// wait just a bit to make sure sections are full-height
			setTimeout( function(){
				info.windowHeight = $window.height();
				info.bodyHeight = $body.height();
			}, 10 );
		});
		$window.on( 'resized-w resized-init', function(){
			// wait just a bit to make sure sections are full-height
			setTimeout( function(){
				info.bodyHeight = $body.height();
			}, 10 );
		});
		$window.on( 'scroll', handleScroll);
		_.each( settings.trackers, function( value, name ){
			addTracker( name, value );
		});
		trackers.on( 'change:inView', function( tracker ){
			var eventName = tracker.get('id');
			eventName += tracker.get('inView') ? ':enteredView' : ':leftView';
			scrolling.trigger( eventName, tracker );
		});

		/* ==== API ============================================= */
		scrolling.getScrollHeight = getScrollHeight;
		scrolling.getPxInPercent = getPxInPercent;
		scrolling.getPercentInPx = getPercentInPx;
		scrolling.isPxInView = isPxInView;
		scrolling.isPercentInView = isPercentInView;
		scrolling.isElementCoveringView = isElementCoveringView;
		scrolling.isElementInView = isElementInView;
		scrolling.isCustomInView = isCustomInView;
		scrolling.addTracker = addTracker;
		scrolling.getTracker = function( name ){
			return trackers.get( name );
		};
		scrolling.getProgress = function(){
			return info.progress;
		}
		return scrolling;
	}({}) );