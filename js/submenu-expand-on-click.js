	$('nav .menu > li').each( function(){
		var $item = $(this);
		var $submenu = $item.find( '.sub-menu');
		if ( $submenu.size() === 0 ) return;

		var $link = $item.children('a');
		$link.on( 'click', function(e){
			if ( $window.width() < 768 && !$submenu.is(':visible') ){
				e.preventDefault();
				$submenu.slideDown('fast');
			}
		});
	});
