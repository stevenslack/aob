<?php
/**
 * Theme Header
 *
 * @package aob
 */
?><!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'aob' ); ?></a>

	<!-- Site Header -->
	<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
		<div class="inner-wrap">
			<?php
				$aob_options = get_option( 'ashevilleonbikes_theme_options' );
				if ( ! empty( $aob_options['donate_url'] ) || ! empty( $aob_options['newsletter_url'] ) ) :
			?>
				<div class="donate-signup">
					<?php if ( ! empty( $aob_options['donate_url'] ) && $donate = $aob_options['donate_url'] ) : ?>
						<a href="<?php echo esc_url( $donate ); ?>" class="donate" target="_blank"><?php esc_html_e( 'DONATE TO AOB', 'aob' ); ?></a>
					<?php endif;
						if ( ! empty( $aob_options['newsletter_url'] ) && $newsletter = $aob_options['newsletter_url'] ) : ?>
						<a href="<?php echo esc_url( $newsletter ); ?>" class="newsletter-signup" target="_blank"><?php esc_html_e( 'JOIN', 'aob' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php get_template_part( 'templates/logo' ); ?>
					<h1><span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span></h1>
				</a><br>
				<h2 class="site-description"><span class="screen-reader-text"><?php bloginfo( 'description' ); ?></span></h2>
			</div>

			<div class="social-head">
				<span class="social">
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
						if ( ! empty( $aob_options['email_address'] ) && is_email( $aob_options['email_address'] ) && $email = $aob_options['email_address'] ) : ?>
						<a href="mailto://<?php echo antispambot( $email ); ?>" class="aob-email" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Contact Asheville on Bikes', 'aob' ); ?></span></a>
					<?php endif; ?>
				</span>
			</div><!--foot-social-->
		</div>
		<!-- /.inner-wrap -->
	</header><!-- #masthead -->

	<?php get_template_part( 'templates/main', 'navigation' ); ?>

	<?php get_template_part( 'templates/front', 'slider' ); ?>

	<!-- Site Content -->
	<div id="content" class="site-content">
		<div class="inner-wrap">
