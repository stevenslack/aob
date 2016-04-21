<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package aob
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _aob_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', '_aob_body_classes' );


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function _aob_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		global $page, $paged;
		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'aob' ), max( $paged, $page ) );
		}
		return $title;
	}
	add_filter( 'wp_title', '_aob_wp_title', 10, 2 );
	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function _aob_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', '_aob_render_title' );
endif;

/**
 * Body class manipulation
 * @param  array $classes array of class names
 * @return array
 */
add_filter( 'body_class', 'aob_body_classes' , 20, 2);
function aob_body_classes( $classes ) {
	if ( is_front_page() ) {
		foreach( $classes as $key => $value ) {
			if ( $value == 'page-template-default' ) unset( $classes[$key] );
		}
	}
	return $classes;
}

/**
 * Delete front page news query
 *
 * @return void
 */
function aob_news_transient_flusher() {
	global $post;

	if ( ( 'post' || 'tribe_events' ) == get_post_type() ) {
		delete_transient( 'front_page_news' );
	}
}
add_action( 'save_post', 'aob_news_transient_flusher' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 */
function custom_excerpt_more( $more ) {
	$text = ( 'tribe_events' === get_post_type() ) ? __( 'See Event Details', 'aob' ) : __( 'Read More', 'aob' );

	return sprintf( '<br><a class="read-more" href="%1$s">%2$s</a>',
        esc_url( get_permalink( get_the_ID() ) ),
        $text
    );
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Transient Key
 *
 * @param  mixed $key identifiable key
 * @return string
 */
function aob_get_transient_key( $key ) {
	return 'aob_' . md5( join( '.', func_get_args() )  );
}

/**
 * Get the banner text for the front page
 *
 * @return array The banner text
 */
function aob_get_banner_text() {
	if ( ! is_front_page() ) {
		return;
	}

	$post_id = get_the_id();

	$main_text = get_post_meta( $post_id, 'aob_banner_text', true );
	$sup_text  = get_post_meta( $post_id, 'aob_banner_supporting', true );
	$disable   = get_post_meta( $post_id, 'aob_display_banner', true );
	$btn_txt   = get_post_meta( $post_id, 'aob_banner_button_text', true );
	$btn_url   = get_post_meta( $post_id, 'aob_banner_button_url', true );

	$key = aob_get_transient_key( $post_id, $main_text, $sup_text, $disable, $btn_txt, $btn_url );

    if ( ( $text = get_transient( $key ) ) === false ) {
        $text = array(
			'main_text' => $main_text,
			'sub_text'  => $sup_text,
			'disable'   => $disable,
			'btn_txt'   => $btn_txt,
			'btn_url'   => $btn_url,
    	);
    	// save for 12 hours
        set_transient( $key, $text, 12 * HOUR_IN_SECONDS );
    }

    return $text;
}
