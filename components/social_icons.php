<?php
if ( !isset( $social_icons ) ){
  $social_icons = get_theme_options( 'theme_options', 'global', 'social_icons' );
}
if ( ! $social_icons ) return; ?>
<ul class="social-icons">
	<?php foreach( $social_icons as $icon ){ ?>
	<li class="<?= sanitize_title( $icon['link']['title'] ); ?>"><?php echo sprintf( $icon['link']['sprintf'], $icon['icon'], '' ); ?></li>
	<?php } ?>
</ul>
