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
	<?php $aob_options = get_option( 'ashevilleonbikes_theme_options' ); ?>

	<?php

		$display_text = '';
		$layout = '';

		if ( is_front_page() ) {
			// get the front page layout option and banner text
			$layout       = get_post_meta( get_the_id(), 'aob_banner_layout', true );
			$display_text = get_post_meta( get_the_id(), 'aob_display_banner_text', true );

			if ( ! empty( $layout ) ) {
			 	// The Hero Image Layout
				if ( 'hero' === $layout ) {
					$path = 'templates/header-hero';
				// The Soliloquy Slider Layout
				} elseif ( 'slider' === $layout ) {
					$path = 'templates/front-slider';
				}
			} else {
				$path = 'templates/header-default';
			}

		} else {
			$path = 'templates/header-default';
		}
		aob_get_template_part( $path, array(
			'aob_options'  => $aob_options,
			'display_text' => $display_text
		) );
		aob_get_template_part( 'templates/main-navigation', array( 'layout' => $layout ) );
	?>

	<!-- Site Content -->
	<div id="content" class="site-content">
		<div class="inner-wrap">
