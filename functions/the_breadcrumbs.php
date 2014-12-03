<?php
function the_breadcrumbs( $links = false ){ ?>
	<div class="breadcrumb-container">
		<div class="container">
	<?php if ( $links ){ ?>
			<span class="trail-begin"><a href="<?php bloginfo( 'url' ); ?>">Home</a></span>
			<span class='sep'>></span>
			<?php foreach( $links as $i => $link ){
				$title = is_object( $link ) ? $link->post_title : $link['title'];
				$url = is_object( $link ) ? get_permalink( $link->ID ) : $link['url'];
				if ( $i < sizeof( $links ) - 1 ){ ?>
				<span class="trail-end"><a href="<?= $url; ?>"><?= $title; ?></a></span>
				<span class="sep">></span>
				<?php } else { ?>
				<span class="trail-end"><?= $title; ?></span>
				<?php } ?>
			<?php } ?>
	<?php } else if ( function_exists( 'breadcrumb_trail' ) ){ ?>
		<?php breadcrumb_trail( array(
			'separator' => '>',
			'labels' => array(
				'browse' => false
			)
		)); ?>
	<?php } ?>
		</div>
	</div>
	<?php return '';
}