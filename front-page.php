<?php
/**
 * Front Page Template
 *
 * @package aob
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="news-stories">
				<?php

					if ( false === ( $news = get_transient( 'front_page_news' ) ) ) :
						$args = array(
							'post_type'      => array( 'post', 'tribe_events' ),
							'order'          => 'DESC',
							'orderby'        => 'date',
							'posts_per_page' => 3,
						);
						$news = new WP_Query( $args );

					    set_transient( 'front_page_news', $news, 12 * HOUR_IN_SECONDS );

					endif;

					if ( $news->have_posts() ) : $i = 1;
						while ( $news->have_posts() ) : $news->the_post(); $i++;
							aob_get_template_part( 'templates/content', array( 'i' => $i ) );
						endwhile;
					endif;

					wp_reset_postdata();
				?>
				<?php if ( '' !== aob_get_blog_url() && $blog_url = aob_get_blog_url() ) : ?>
					<a href="<?php echo esc_url( $blog_url ); ?>" class="view-all button"><?php _e( 'View All Posts', 'aob' ) ?></a>
				<?php endif; ?>

				<?php // echo do_shortcode( '[instagram-feed]' ); ?>
			</section>
		</main><!-- #main -->
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
