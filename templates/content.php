<?php
/**
 * @package aob
 */

$i = aob_get_var( 'i' ); // get the post count
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( ( ! empty( $i ) && 1 === $i ) || is_sticky() ) : ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'blog-thumb' ); ?>
				</a>
			<?php endif; ?>
			<?php aob_get_template_part( 'templates/post-header' ); ?>
		<?php else : ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-story">
					<?php aob_get_template_part( 'templates/post-header' ); ?>
				</div>
				<figure class="post-thumb">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
						<?php the_post_thumbnail( 'image-4' ); ?>
					</a>
				</figure>
			<?php else : ?>
				<?php aob_get_template_part( 'templates/post-header' ); ?>
			<?php endif; ?>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php if ( ! empty( $i ) && 1 === $i ) : ?>
			<?php the_excerpt(); ?>
		<?php else : ?>
			<?php echo aob_get_the_excerpt( get_the_id(), 30 ); ?>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php if ( ! is_home() ) : ?>
		<footer class="entry-footer">
			<?php _aob_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
