<?php
/**
 * The Hero Image template part
 */
$image = get_post_meta( get_the_id(), 'aob_banner_image', true );

if ( ! empty( $image ) ) : ?>
	<div class="hero">
		<div class="header-img">
			<?php aob_get_template_part( 'templates/banner-text' ); ?>
			<div class="overlay" aria-hidden="true"></div>
		</div><!-- /the main banner image -->
	</div>
<?php endif; ?>
