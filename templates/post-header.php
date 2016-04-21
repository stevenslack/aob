<?php
/**
 * The post header
 */

aob_categories( 'post-categories' );
the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
if ( class_exists( 'Tribe__Events__Main' ) && 'tribe_events' === get_post_type() ) : ?>
	<div class="entry-meta event-time">
		<?php echo tribe_events_event_schedule_details(); ?>
	</div><!-- .entry-meta -->
<?php endif;
if ( 'post' == get_post_type() ) : ?>
	<div class="entry-meta">
		<?php _aob_posted_on(); ?>
	</div><!-- .entry-meta -->
<?php endif;
