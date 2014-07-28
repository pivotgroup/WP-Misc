<?php get_header(); ?>

	<div id="content">
		<div class="container">
			<?php if( have_posts() ) : while( have_posts() ) : the_post();
				$options = get_metabox_options( "page_options" );
				$has_sidebar = !empty( $options['has_sidebar'] ) && $options['has_sidebar'] === 'yes' && !empty( $options['sidebar'] ) ? 'has-sidebar' : false; 
				$sidebar_position = !empty( $options['sidebar_position'] ) ? $options['sidebar_position'] : 'right'; ?>
			<div id="breadcrumbs"><?php the_breadcrumb(); ?></div>
			<article <?php post_class( $has_sidebar . ' sidebar-' .$sidebar_position ); ?>>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php if ( $has_sidebar ){ ?>
				<div class="row">
					<?php if ( $sidebar_position === 'right' ){
						$contentClasses = '';
						$sidebarClasses = '';
					} else {
						$contentClasses = 'col-sm-push-4 col-md-push-3';
						$sidebarClasses = 'col-sm-pull-8 col-md-pull-9';
					} ?>
					<div class="post-content col-sm-8 col-md-9 <?php echo $contentClasses; ?>">
						<?php the_content(); ?>
					</div>
					<aside class="page-sidebar col-sm-4 col-md-3 <?php echo $sidebarClasses; ?>">
						<ul class="widgets">
							<?php dynamic_sidebar( $options['sidebar'] ); ?>
						</ul>
					</aside>
				</div>
				<?php } else { ?>
				<div class="post-content">
					<?php the_content(); ?>
				</div>
				<?php } ?>
			</article>
			<?php endwhile; endif; ?>
		</div>
	</div>
	
<?php get_footer(); ?>
