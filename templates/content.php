<?php
/**
 * @package aob
 */

$i = aob_get_var( 'i' ); // get the post count
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ( ! empty( $i ) && 1 === $i ) || is_sticky() ) : ?>
		<header class="entry-header">
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'blog-thumb' ); ?>
				</a>
			<?php endif; ?>
			<?php aob_get_template_part( 'templates/post-header' ); ?>
		</header><!-- .entry-header -->
	<?php else : ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-story">
				<header class="entry-header">
					<?php aob_get_template_part( 'templates/post-header' ); ?>
				</header><!-- .entry-header -->
				<div class="entry-summary">
					<?php echo aob_get_the_excerpt( get_the_id(), 30 ); ?>
				</div>
			</div>
			<figure class="post-thumb">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_post_thumbnail( 'image-4' ); ?>
				</a>
			</figure>
		<?php else : ?>
			<header class="entry-header">
				<?php aob_get_template_part( 'templates/post-header' ); ?>
			</header><!-- .entry-header -->
			<div class="entry-summary">
				<?php echo aob_get_the_excerpt( get_the_id(), 30 ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $i ) && 1 === $i ) : ?>
		<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'aob' ),
					array( 'span' => array( 'class' => array() ) )
				),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
		</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->
