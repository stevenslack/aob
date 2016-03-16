<?php
/**
 * Theme Header
 *
 * @package aob
 */
?><!DOCTYPE html>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'aob' ); ?></a>

	<!-- Site Header -->
	<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
		<div class="inner-wrap">
			<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php get_template_part( 'templates/logo' ); ?></a>
				<h1><span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span></h1>
				<h2 class="site-description"><span class="screen-reader-text"><?php bloginfo( 'description' ); ?></span></h2>
			</div>

			<?php
				$aob_options = get_option( 'ashevilleonbikes_theme_options' );
				if ( ! empty( $aob_options['donate_url'] ) || ! empty( $aob_options['newsletter_url'] ) ) :
			?>
				<div class="donate-signup">
					<?php if ( ! empty( $aob_options['donate_url'] ) && $donate = $aob_options['donate_url'] ) : ?>
						<a href="<?php echo esc_url( $donate ); ?>" class="donate" target="_blank"><?php esc_html_e( 'DONATE', 'aob' ); ?></a>
					<?php endif;
						if ( ! empty( $aob_options['newsletter_url'] ) && $newsletter = $aob_options['newsletter_url'] ) : ?>
						<a href="<?php echo esc_url( $newsletter ); ?>" class="newsletter-signup" target="_blank"><?php esc_html_e( 'JOIN', 'aob' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

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
					if ( ! empty( $aob_options['email_address'] ) && is_email( $aob_options['email_address'] ) && $email = $aob_options['email_address'] ) : ?>
					<a href="mailto://<?php echo antispambot( $email ); ?>" class="aob-email" target="_blank"><span class="screen-reader-text"><?php esc_html_e( 'Contact Asheville on Bikes', 'aob' ); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
		<!-- /.inner-wrap -->
	</header><!-- #masthead -->

	<?php
		get_template_part( 'templates/main', 'navigation' );

		if ( is_front_page() ) {
			get_template_part( 'templates/front', 'slider' );
		}
	?>

	<!-- Site Content -->
	<div id="content" class="site-content">
		<div class="inner-wrap">
