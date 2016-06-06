<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package aob
 */
$aob_options = get_option( 'ashevilleonbikes_theme_options' );
?>
        </div><!-- .inner-wrap -->
	</div><!-- #content -->

    <?php if ( shortcode_exists( 'instagram-feed' ) && is_front_page() ) : ?>
        <div id="aob-intagram-feed">
            <?php echo do_shortcode( '[instagram-feed]' ); ?>
        </div>
    <?php endif; ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="inner-wrap">
            <div class="footer-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php get_template_part( 'templates/logo' ); ?></a>
            </div>
            <?php if ( aob_has_social() ) : ?>
                <?php aob_get_template_part( 'templates/social', array( 'aob_options' => $aob_options ) ); ?>
            <?php endif; ?>
            <div class="footer-nav">
                <nav class="nav" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_id'        => 'nav-primary',
                            'menu_class'     => 'nav-menu centered',
                            'fallback_cb'    => '',
                            'depth'          => 1,
                        )
                    ); ?>
                </nav>
            </div>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
