var tabs = ( function(){
	var $tabsContainers = $('.tabs-container');
	var init = function(){
		$tabsContainers.each( function(){
			var $container = $(this);
			var $tabs = $container.find( '.tabs .tab' );
			var $panelsContainer = $container.find( '.tab-panels' );
			var $panels = $container.find( '.tab-panels .tab-panel' );

			var $activePanel = $();
			var $activeTab = $();
			var speed = 400;
			function activatePanel( id ){
				var $panelToActivate = $panels.filter( '#panel-' + id );
				if ( ! $panelToActivate.size() > 0 ) return;

				$panelsContainer.height( $panelsContainer.outerHeight() );
				$activePanel.hide();
				$activeTab.removeClass('selected');
				$activePanel = $panelToActivate.css({
					opacity: 0
				}).show().animate({
					opacity: 1
				}, speed );
				$activeTab = $tabs.filter( function(){
					return $(this).children('a').attr('href') === '#'+id
				}).addClass('selected');
				$panelsContainer.animate({
					height: $activePanel.outerHeight()
				}, speed, function(){
				});
			}
			$window.hashchange( function( e ){
				var id = window.location.hash ? window.location.hash.substr(1) : false;
				if ( id ){
					activatePanel( id );
				}
			});
			$panels.each( function(){
				$(this).attr('id', 'panel-' + $(this).attr('id'));
			});
			$window.hashchange();
			if ( ! $activePanel.size() > 0 ){
				activatePanel( $tabs.first().find( 'a' ).attr('href').substr(1) );
			}
		});
	};
	return {
		init: init
	};
}() );
