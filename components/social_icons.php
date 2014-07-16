<?php
if ( !isset( $social_icons ) ){
  $social_icons = get_theme_options( 'cloud_options', 'global', 'social_icons' );
}
if ( ! $social_icons ) return; ?>
<ul class="social-icons">
	<?php foreach( $social_icons as $icon ){ ?>
	<li><?php echo sprintf( $icon['link']['sprintf'], $icon['icon'] ); ?></li>
	<?php } ?>
</ul>
