<?php
/**
 * Social Media output
 */

$aob_options = aob_get_var( 'aob_options' );

?>
	<div class="social-head social">
		<?php if ( ! empty( $aob_options['google_input'] ) && $google_plus = $aob_options['google_input'] ) : ?>
			<a href="<?php echo esc_url( 'https://plus.google.com/' . $google_plus ); ?>" class="aob-google" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Asheville on Bikes on Google+', 'aob' ); ?></span></a>
		<?php
			endif;
			if ( ! empty( $aob_options['facebook_input'] ) && $face_url = $aob_options['facebook_input'] ) : ?>
			<a href="<?php echo esc_url( 'http://facebook.com/' . $face_url ); ?>" class="aob-facebook" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Follow Asheville on Bikes on Facebook', 'aob' ); ?></span></a>
		<?php endif;
			if ( ! empty( $aob_options['twitter_input'] ) && $twit_url = $aob_options['twitter_input'] ) : ?>
			<a href="<?php echo esc_url( 'https://twitter.com/' . $twit_url ); ?>" class="aob-twitter" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Follow Asheville on Bikes on Twitter', 'aob' ); ?></span></a>
		<?php endif;
			if ( ! empty( $aob_options['insta_input'] ) && $instagram = $aob_options['insta_input'] ) : ?>
			<a href="<?php echo esc_url( 'https://instagram.com/' . $instagram ); ?>" class="aob-instagram" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Follow Asheville on Bikes on Instagram', 'aob' ); ?></span></a>
		<?php endif;
			if ( ! empty( $aob_options['email_address'] ) && is_email( $aob_options['email_address'] ) && $email = $aob_options['email_address'] ) : ?>
			<a href="mailto://<?php echo antispambot( $email ); ?>" class="aob-email" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Contact Asheville on Bikes', 'aob' ); ?></span></a>
		<?php endif; ?>
	</div>
