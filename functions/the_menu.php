<?php function the_menu( $items ){
	if ( ! $items ) return; ?>
	<ul class="menu">
		<?php foreach( $items as $item ){
			the_menu_item( $item );
		} ?>
	</ul>
<?php
}
function the_menu_item( $item ){
	global $url;
	$children = false;
	$defaults = array(
		'title' => 'Menu Item',
		'class' => array(),
		'href' => false,
		'id' => false,
		'target' => '',
		'children' => array()
	);
	if ( is_string( $item ) ){
		$item = array(
			'title' => $item
		);
	}
	if ( isset( $item['class'] ) && !is_array( $item['class'] ) ){
		$item['class'] = explode( ' ', $item['class'] );
	}
	$menu_item = array_merge( $defaults, $item );
	$menu_item['class'][] = 'menu-item';
	if ( ! $menu_item['href'] ){
		$menu_item['href'] = $url . '#' . strtolower( str_replace( ' ', '-', $menu_item['title'] ) );
	}
	$atts = array(
		'class' => $menu_item['class']
	);
	$children = $menu_item['children'];
	if ( $children ){
		$atts['class'][] = 'has-children';
	}
	if ( $menu_item['target'] ){
		$atts['target'] = $menu_item['target'];
	}

	?>
	<li <?= get_atts( $atts ); ?>>
		<a href="<?= $menu_item['href']; ?>" title="<?= $menu_item['title']; ?>"><?= $menu_item['title']; ?></a>
		<?php if ( $children ){ ?>
		<ul class="sub-menu">
			<?php foreach( $children as $child ){
				the_menu_item( $child );
			} ?>
		</ul>
		<?php } ?>
	</li>
<?php }