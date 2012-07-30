<?php
/**
 * Template Name: The Voting News
 * Description: Verified Voting Homepage
 */

get_header(); ?>

<?php // get_sidebar(); ?>

		<div id="primary">
			<div id="content" role="main">
			 <h1 class="entry-title">The Voting News</h1>

			<?php if ( have_posts() ) : ?>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ 
  				query_posts( array( 'meta_key' => 'the_voting_news', 'meta_value'=>true,'paged' => get_query_var('page') ) );
				?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>