<?php if ( !$link ) return;
if ( ! $content ) return;
global $lightboxContentID;
if ( ! $lightboxContentID ){
	$lightboxContentID = 0;
}
$id = 'lightboxcontent-'.$lightboxContentID;
?>
<div class="lightboxcontent-link"><a href="#<?php echo $id; ?>"><?php echo $link; ?></a></div>
<div id="<?php echo $id; ?>" class="lightboxcontent-content">
	<article class="lightboxcontent-inner"><?php echo $content; ?></article>
</div>

// js
var lightboxContent = ( function(){
	var init = function(){
		$('.lightboxcontent-link' ).each( function(){
			var $link = $(this).children( 'a' );
			var $content = $(this).next( '.lightboxcontent-content');
			$link.magnificPopup({
				type: 'inline'
			});
		});
	};
	return {
		init: init
	};
}() );
lightboxContent.init();

// css
/* ==== LIGHTBOX CONTENT ============================================= */
.mfp-hide {
  display: none;
}
.lightboxcontent-link {
  margin: 1em 0;
}
.lightboxcontent-content {
  display: none;
  max-width: 768px;
  margin: 0 auto;
}
.lightboxcontent-content .lightboxcontent-inner {
  background: #fff;
  border-radius: 10px;
  padding: 1em 30px;
}
.mfp-content {
  padding: 50px;
  width: auto !important;
}
.mfp-content .lightboxcontent-content {
  display: block;
}
