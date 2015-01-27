jQuery( function($){
	
	/* ==== SCROLLING ============================================= */
	// events mixin
	var Events = ( typeof( Backbone ) !== 'undefined' && Backbone.hasOwnProperty( 'Events' ) ) ? Backbone.Events : function(){var t=[],e=(t.push,t.slice),s=(t.splice,/\s+/),i=function(t,e,i,n){if(!i)return!0;if("object"==typeof i)for(var r in i)t[e].apply(t,[r,i[r]].concat(n));else{if(!s.test(i))return!0;for(var c=i.split(s),l=0,a=c.length;a>l;l++)t[e].apply(t,[c[l]].concat(n))}},n=function(t,e){var s,i=-1,n=t.length;switch(e.length){case 0:for(;++i<n;)(s=t[i]).callback.call(s.ctx);return;case 1:for(;++i<n;)(s=t[i]).callback.call(s.ctx,e[0]);return;case 2:for(;++i<n;)(s=t[i]).callback.call(s.ctx,e[0],e[1]);return;case 3:for(;++i<n;)(s=t[i]).callback.call(s.ctx,e[0],e[1],e[2]);return;default:for(;++i<n;)(s=t[i]).callback.apply(s.ctx,e)}},r={on:function(t,e,s){if(!i(this,"on",t,[e,s])||!e)return this;this._events||(this._events={});var n=this._events[t]||(this._events[t]=[]);return n.push({callback:e,context:s,ctx:s||this}),this},once:function(t,e,s){if(!i(this,"once",t,[e,s])||!e)return this;var n=this,r=_.once(function(){n.off(t,r),e.apply(this,arguments)});return r._callback=e,this.on(t,r,s),this},off:function(t,e,s){var n,r,c,l,a,h,f,o;if(!this._events||!i(this,"off",t,[e,s]))return this;if(!t&&!e&&!s)return this._events={},this;for(l=t?[t]:_.keys(this._events),a=0,h=l.length;h>a;a++)if(t=l[a],n=this._events[t]){if(c=[],e||s)for(f=0,o=n.length;o>f;f++)r=n[f],(e&&e!==r.callback&&e!==r.callback._callback||s&&s!==r.context)&&c.push(r);this._events[t]=c}return this},trigger:function(t){if(!this._events)return this;var s=e.call(arguments,1);if(!i(this,"trigger",t,s))return this;var r=this._events[t],c=this._events.all;return r&&n(r,s),c&&n(c,arguments),this},listenTo:function(t,e,s){var i=this._listeners||(this._listeners={}),n=t._listenerId||(t._listenerId=_.uniqueId("l"));return i[n]=t,t.on(e,"object"==typeof e?this:s,this),this},stopListening:function(t,e,s){var i=this._listeners;if(i){if(t)t.off(e,"object"==typeof e?this:s,this),e||s||delete i[t._listenerId];else{"object"==typeof e&&(s=this);for(var n in i)i[n].off(e,s,this);this._listeners={}}return this}}};return r}();
	var Scrolling = ( function( args ){

		var info = {};

		function WindowScrollInfo(){
			var $html = $('html');
			var $window = $(window);
			info = {
				windowHeight: $window.height(),
				fullHeight: $html.height(),
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
			function handleScroll(e){
				var s = $window.scrollTop();
				info.direction = info.progress.px < s ? 'down' : 'up';
				info.progress.px = s;
				info.scrollTop = s;
				info.progress.percent = info.progress.px / this.getScrollHeight();
				info.screenBottom.px = s + info.windowHeight;
				info.screenBottom.percent = info.screenBottom.px / this.getScrollHeight();
				
				this.trigger( 'scroll', this );
				this.trickerCheckPoints();
			}
			// you got it, track all the information on resize.
			$window.on( 'resize', function(){
				info.windowHeight = $window.height();
				info.fullHeight = $html.height();
			});
			$window.on( 'scroll', handleScroll.bind( this ) );
			$.extend( this, Events );
		}
		var p = WindowScrollInfo.prototype;
		p.get = function getData( name ){
			return info.hasOwnProperty( name ) ? info[name] : undefined;
		}
		p.getProgress = function getProgress(unit){
			if ( unit === 'percent' ) unit = '%';
			return unit === '%' ? info.progress.percent : info.progress.px;
		}
		p.getInfo = function getInfo(){
			// prevent access, copy object
			return $.extend( {}, info );
		}
		p.getScrollHeight = function getScrollHeight(){
			return ( info.fullHeight - info.windowHeight );
		}
		p.getPxInPercent = function getPxInPercent( px ){
			return px / this.getScrollHeight()
		}
		p.getPercentInPx = function getPercentInPx( percent ){
			return percent * this.getScrollHeight();
		}
		p.isPxInView = function isPxInView( px ){
			return info.progress.px <= px && px <= info.screenBottom.px;
		}
		p.isPercentInView = function isPercentInView( percent ){
			return info.progress.percent <= percent && percent <= info.screenBottom.percent;
		}
		p.isElementCoveringView = function isElementCoveringView( $element ){
			return ( $element.offset().top <= info.progress.px && ( $element.offset().top + $element.outerHeight() ) >= info.progress.px )
		}
		p.isElementInView = function isElementInView( $element ){
			if( this.isPxInView( $element.offset().top ) || this.isPxInView( $element.offset().top + $element.outerHeight() ) ){
				return true;
			} else if ( this.isElementCoveringView( $element ) ){
				return true;
			}
			return false;
		}
		p._checkPoints = {
			top: { type: 'function', value: function( s ){ return s.getProgress().percent <= 0; } },
			bottom: { type: 'function', value: function( s ){ return s.getProgress( '%' ) >= 1; }},
		};
		p.addCheckPoint = function( eventName, point ){
			var checkpoint = {
				type: false,
				value: point,
				inView: false
			};
			if ( typeof( point ) === 'string' ){
				if ( point.substr( point.length - 1 ) === '%' ){
					checkpoint.type = '%';
					checkpoint.value = parseFloat( point.substr( 0, point.length - 1 ) )/100;
				} else if ( point.substr( point.length - 2 ) === 'px' ){
					checkpoint.type = 'px';
					checkpoint.value = parseInt( point.substr( 0, point.length - 2 ) );
				}
			} else if ( typeof( point ) === 'number' ){
				checkpoint.type = 'px';
				checkpoint.value = parseInt( point );
			} else if ( typeof( point ) === 'function' ){
				checkpoint.type = 'function';
				checkpoint.value = point;
			}
			this._checkPoints[ eventName ] = checkpoint;
		}
		p.removeCheckPoint = function( eventName ){
			delete this._checkPoints[ eventName ];
		}
		p.trickerCheckPoints = function(){
			var inView;
			for ( eventName in this._checkPoints ){
				var cp = this._checkPoints[ eventName ];
				inView = false;
				switch( cp.type ){
					case 'px': inView = this.isPxInView( cp.value ); break;
					case '%': inView = this.isPercentInView( cp.value ); break;
					case 'function': inView = cp.value( this ); break;
					default: inView = false;
				}
				if ( inView !== cp.inView ){
					this.trigger( inView ? eventName + ':enteredView' : eventName + ':leftView' );
					cp.inView = inView;
				}
				if ( inView ){
					this.trigger( eventName + ':inView' );
				}
			}
		}
		/* ==== INITIALIZE! ============================================= */


		// ensure only one is created.
		var scrollInfo = false;
		return function init(){
			if ( ! scrollInfo ) scrollInfo = new WindowScrollInfo();
			return scrollInfo;
		}
	}() );
	jQuery.fn.scrollTracker = function( args ){
		var scrolling = Scrolling();
		var methods = {};
		methods.isInView = function(){
			return $(this).data('inView');
		}
		methods.isCoveringView = function(){
			return methods.getScreenPos.apply( this, ['%'] ) <= 0 && methods.getBottomScreenPos.apply( this, ['%'] ) >= 1;
		};
		methods.getPercentOfViewCovered = function(){
			if ( ! this.data('inView' ) ) return 0;
			
			if ( this.getScreenPos( '%' ) <= 0 ){
				amount = this.getScreenPos( '%', true );
			} else if ( this.getScreenPos( '%', true ) >= 1 ){
				amount = this.getBottomScreenPos( '%' );
			} else {
				amount = this.getScreenPos( '%', true ) - this.getScreenPos( '%' );
			}
			if ( amount > 1 ) amount = 1;
			return amount;
		};
		methods.getPos = function( unit, fromBottom ){
			if ( !fromBottom ) fromBottom = false;
			if ( unit === 'percent' ) unit = '%';
			
			if ( fromBottom ){
				return unit === '%' ? 1 - scrolling.getPxInPercent( $(this).offset().top ) : scrolling.get( 'fullHeight' ) - $(this).offset().top ;
			} else {
				return unit === '%' ? scrolling.getPxInPercent( $(this).offset().top ) : $(this).offset().top ;
			}
		}
		methods.getBottomPos = function( unit, fromBottom ){
			if ( !fromBottom ) fromBottom = false;
			if ( unit === 'percent' ) unit = '%';
			var $el = $(this);
			var bottomPos = $el.offset().top + $el.outerHeight();
			if ( fromBottom ){
				return unit === '%' ? 1 - scrolling.getPxInPercent( bottomPos ) : scrolling.get('fullHeight') - bottomPos ;
			} else {
				return unit === '%' ? scrolling.getPxInPercent( bottomPos ) : bottomPos ;
			}
		}
		methods.getScreenPos = function( unit, fromBottom ){
			if ( !fromBottom ) fromBottom = false;
			if ( unit === 'percent' ) unit = '%';

			var fromScreenTop = methods.getPos.apply( this, ['px'] ) - scrolling.getProgress( 'px' );
			if ( fromBottom ){
				return unit === '%' ? 1 - fromScreenTop / scrolling.get('windowHeight') : scrolling.get( 'windowHeight' ) - fromScreenTop;
			} else {
				return unit === '%' ? fromScreenTop / scrolling.get('windowHeight') : fromScreenTop;
			}
		}
		methods.getBottomScreenPos = function(unit, fromBottom){
			if ( !fromBottom ) fromBottom = false;
			if ( unit === 'percent' ) unit = '%';

			var fromScreenTop = methods.getBottomPos.apply( this, ['px'] ) - scrolling.getProgress( 'px' ) ;
			if ( fromBottom ){
				return unit === '%' ? 1 - fromScreenTop / scrolling.get('windowHeight') : scrolling.get( 'windowHeight' ) - fromScreenTop;
			} else {
				return unit === '%' ? fromScreenTop / scrolling.get('windowHeight') : fromScreenTop;
			}
		}
		$.extend( methods, Events );
		// calling a method
		function handleScroll( scrolling ){
			var inView = scrolling.isElementInView( $(this) );
			if ( $(this).data('inView') !== inView ){
				if ( inView ){
					methods.trigger.apply( this, [ 'enteredView' ] );
				} else {
					methods.trigger.apply( this, [ 'leftView' ] );
				}
				$(this).data('inView', scrolling.isElementInView( $(this) ) );
			}
			if ( inView ){
				methods.trigger.apply( this, [ 'inView' ] );
			}
		}
		this.each( function(){
			// scroll event is fired AFTER all the info object (on which all the calculations depend) is updated.
			scrolling.on( 'scroll', handleScroll.bind( this ) );
			var api = {};
			for( methodName in methods ){
				if ( methods.hasOwnProperty( methodName ) ){
					api[ methodName ] = methods[ methodName ].bind( this );
				}
			}
			$(this).data('scrollTracker', api );
		});
		return this;
	}
	/* ==== EXAMPLE USAGE ============================================= */
	// track elements
	s = $('.test-div').scrollTracker().data('scrollTracker');
	s.on( 'enteredView', function(){ $(this).addClass('inView'); } );
	s.on( 'inView', function(){} );
	s.on( 'leftView', function(){  $(this).removeClass('inView'); } );
	
	// or checkpoints
	var scrolling = Scrolling();
	scrolling.addCheckPoint( 'point1', 100);
	scrolling.addCheckPoint( 'point1', '100px');
	scrolling.addCheckPoint( 'point1', '100%');
	scrolling.addCheckPoint( 'point1', function(s){ return s.getProgress( '%' ) >= .5 });
	scrolling.on( 'point1:enteredView',function(s){});
	scrolling.on( 'point1:inView',function(s){});
	scrolling.on( 'point1:leftView',function(s){});
});
