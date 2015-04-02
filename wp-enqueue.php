public function enqueue_royalslider(){
	wp_enqueue_style( 'royalslider', $this->getDir( '/_inc/royalslider/royalslider.css' ) );
	wp_enqueue_style( 'royalslider-default', $this->getDir( '/_inc/royalslider/skins/default/rs-default.css' ) );

	wp_enqueue_script( 'royalslider', $this->getDir( '/_inc/royalslider/jquery.royalslider.min.js' ), array( 'jquery' ), false, true );
}
public function enqueue_touchcarousel(){
	wp_enqueue_style( 'touchcarousel', $this->getDir( '/_inc/touchcarousel/touchcarousel.css' ) );
	wp_enqueue_script( 'touchcarousel', $this->getDir( '/_inc/touchcarousel/jquery.touchcarousel-1.2.min.js' ), array( 'jquery' ), false, true );
}
protected function enqueue_magnific(){
	wp_enqueue_script( 'magnific', $this->getDir( '_inc/js/magnific-popup/dist/jquery.magnific-popup.min.js'), array( 'jquery' ), false, true );
	wp_enqueue_style( 'magnific', $this->getDir( '_inc/js/magnific-popup/dist/magnific-popup.css') );
}
