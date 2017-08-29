<?php
/*
Template Name: Search Page
*/
get_header(); ?>

		<!-- START CONTENT -->
		<div class="content container clearfix">
			<div class="newspage">
				
				<?php if ( have_posts() ) : ?>
					<div class="title sm"><?php printf( __( 'Search: "%s"' ), get_search_query() ); ?></div>

					<?php
					// Start the loop.
					while ( have_posts() ) : the_post(); ?>

					<div class="item clearfix">
						<?php echo get_the_post_thumbnail( $page->ID, 'thumbnail' ); ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="name"><?php the_title(); ?></a>
						<div class="date"><?php the_date(); ?><?php the_time(); ?><br/></div>
						<div class="txt"><?php the_excerpt(); ?></div>
					</div>
						

						
					
					<?php
					// End the loop.
					endwhile;

					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
						'next_text'          => __( 'Next page', 'twentyfifteen' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
					) );

				// If no content, include the "No posts found" template.
				else :
					echo '<div class="title sm">Nothing found</div>';

				endif;
				?>

			</div>
		</div>
		<!-- END CONTENT -->

<?php get_footer(); ?>