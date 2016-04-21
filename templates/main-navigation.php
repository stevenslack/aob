<?php // the main site navigation
	$layout = aob_get_var( 'layout' );
	$class  = ( $layout === 'hero' || 'slider' ) ? ' centered' : '';
?>
		<button id="toggle" class="nav-toggle" aria-controls="nav-primary" data-nav-toggle="#nav-primary" href="#">
			<?php _e( 'Menu', 'aob' ); ?> <span class="burger-icon" aria-hidden="true"></span>
		</button>

		<nav id="site-navigation" class="nav" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
			<div class="inner-wrap">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_id'        => 'nav-primary',
						'menu_class'     => 'nav-menu' . esc_attr( $class ),
						'fallback_cb'    => '',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">' . aob_header_buttons() . '%3$s</ul>',
						"walker"         => new Drop_Menu_Walker(),
					)
				); ?>
			</div>
        </nav>
