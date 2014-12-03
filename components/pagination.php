<?php
if ( ! isset( $query ) ){
	global $wp_query;
	$query = $wp_query;
}

$big = 999999999; // need an unlikely integer

$pagination = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $query->max_num_pages
) );
if ( $pagination ){ ?>
<div class="pagination">
<?php echo $pagination; ?>
</div>
<?php } ?>
