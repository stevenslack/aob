<?php
/**
 * Blog Page
 *
 * @package aob
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : $i = 0; // iterate through each post and count ?>

			<?php while ( have_posts() ) : the_post(); $i++; ?>

				<?php aob_get_template_part( 'templates/content', array( 'i' => $i ) ); ?>

			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'templates/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
