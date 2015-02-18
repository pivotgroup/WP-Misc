	var expandableContent = ( function(){
		var init = function($containers, args ){
			var settings = $.extend({},{
				speed: 200,
				height: 210,
				toExpandSelector: '.content',
				expandLinkSelector: '.expand-link',
				expandedClass: 'expanded',
			}, args );
			$containers.each( function(){
				var fullHeight;
				var $container = $(this);
				var $toExpand = $container.find( settings.toExpandSelector );
				var $expandLink = $container.find( settings.expandLinkSelector );
				var getFullHeight = function(){
					var oh = $toExpand.height( '' ).outerHeight();
					$toExpand.height( settings.height );
					return oh;
				}
				var show = function(){
					$container.addClass( settings.expandedClass );
					if ( ! fullHeight ){
						fullHeight = getFullHeight();
					}
					$toExpand.animate({
						height: fullHeight
					}, settings.speed, function(){
						$toExpand.css({
							height: ''
						});
					});
				}
				var hide = function(){
					$container.removeClass('expanded');
					$toExpand.animate({
						height: settings.height
					}, settings.speed, function(){
					});
				}
				$toExpand.css({
					height: settings.height
				});
				$expandLink.on( 'click', function(e){
					e.preventDefault();
					if ( $container.hasClass( settings.expandedClass ) ){
						hide();
					} else {
						show();
					}
				});
			});
		};
		return {
			init: init
		};
	}() );
