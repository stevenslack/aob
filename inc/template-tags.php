<?php
/**
 * Custom template tags for this theme.
 *
 * @package aob
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'aob' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'aob' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'aob' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'aob' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( '_aob_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function _aob_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		_x( 'by %s', 'post author', 'aob' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

/**
 * Primary Categories for blog posts
 *
 * @return string
 */
function aob_categories( $class_name = 'cat-links', $deliminator = ', ' ) {

	$output_string = '<span class="%1$s">' . __( '%2$s', 'aob' ) . '</span>';

	// if this is an event
	if ( 'tribe_events' === get_post_type() ) {
		printf( $output_string, $class_name, get_the_term_list( get_the_id(), 'tribe_events_cat', '', $deliminator ) );
	}

	if ( $categories_list && _aob_categorized_blog() ) {
		printf( $output_string, $class_name, get_the_category_list( $deliminator ) );
	}
}

if ( ! function_exists( '_aob_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function _aob_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'aob' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( '%1$s', 'aob' ) . '</span>', $tags_list );
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'aob' ), __( '1 Comment', 'aob' ), __( '% Comments', 'aob' ) );
		echo '</span>';
	}
	edit_post_link( __( 'Edit', 'aob' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function _aob_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( '_aob_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( '_aob_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so _aob_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so _aob_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in _aob_categorized_blog.
 */
function _aob_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( '_aob_categories' );
}
add_action( 'edit_category', '_aob_category_transient_flusher' );
add_action( 'save_post',     '_aob_category_transient_flusher' );


/**
 * Retrieve a post excerpt whether or not you're inside The Loop
 * @param WP_Post|int $post A WP_Post object or post ID
 * @param int $length Optional number of words, if excerpt is being trimmed from post_content
 * @return string The excerpt
 */
function aob_get_the_excerpt( $post, $length = 0 ) {
	// Always get the post object
	if ( is_numeric( $post ) ) {
		$post = get_post( $post );
	}

	// If the excerpt is set, use it. Otherwise, use the post content.
	if ( ! empty( $post->post_excerpt ) ) {
		$excerpt = $post->post_excerpt;
	} else {
		$excerpt = $post->post_content;
		// Use the same logic as wp_trim_excerpt to finalize
		$excerpt = strip_shortcodes( $excerpt );
		$excerpt = apply_filters( 'the_content', $excerpt );
		$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
		$excerpt_length = ( is_numeric( $length ) && $length > 0 ) ? $length : apply_filters( 'excerpt_length', 55 );
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
		$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
	}

	return $excerpt;
}

if ( ! function_exists( 'aob_get_template_part' ) ) :

	/**
	 * Get a template part while setting a global variable that can be read from within the template.
	 *
	 * $name can be ommitted, and $variables can optionally be the second function argument. e.g.
	 *      aob_get_template_part( 'sidebar', array( 'image_size' => 'thumbnail' ) )
	 *
	 * @param string $slug Template slug. @see get_template_part().
	 * @param string $name Optional. Template name. @see get_template_part().
	 * @param array $variables Optional. key => value pairs you want to access from the template.
	 * @return void
	 */
	function aob_get_template_part( $slug, $name = null, $variables = array() ) {
		global $aob_vars, $post;
		if ( ! is_array( $aob_vars ) ) {
			$aob_vars = array();
		}

		list( $name, $variables ) = _aob_fix_template_part_args( $name, $variables );

		// We add the variables to the end of the array, as variables will
		// always be pulled from the top (the currently activate template). This
		// allows us to nest templates without crossing our streams.
		$aob_vars[] = $variables;

		// We store the current global post to ensure that our template part
		// doesn't modify it.
		$current_post = $post;

		get_template_part( $slug, $name );

		// If our template part changed the global post, we'll reset it to what
		// it was before loading the template part. Note that we're not calling
		// wp_reset_postdata() because $post may not have been the current post
		// from the global query.
		if ( $current_post !== $post ) {
			$post = $current_post;

			if ( $post instanceof WP_Post ) {
				setup_postdata( $post );
			}
		}

		// Lastly, we pop the variables off the top of the array
		array_pop( $aob_vars );
	}

endif;


if ( ! function_exists( 'aob_get_var' ) ) :

	/**
	 * Get a value from the global aob_vars array.
	 *
	 * @param  string $key The key from the variables.
	 * @param  mixed $default Optional. If the key is not in $aob_vars, the function returns this value. Defaults to null.
	 * @return mixed Returns $default.
	 */
	function aob_get_var( $key, $default = null ) {
		global $aob_vars;
		if ( empty( $aob_vars ) ) {
			return $default;
		}

		$current_template = end( $aob_vars );
		if ( isset( $current_template[ $key ] ) ) {
			return $current_template[ $key ];
		}
		return $default;
	}

endif;

if ( ! function_exists( '_aob_fix_template_part_args' ) ) {

	/**
	 * Sort out `$name` and `$variables` for all of the custom template part
	 * functions.
	 *
	 * `$name` comes before `$variables` in the argument order, but is optional.
	 * This helper determines if `$name` was actually provided or not.
	 *
	 * @access private
	 *
	 * @param  mixed $name Technically, `$name` should be a string or null.
	 *                     However, because it's optional, it might be an array.
	 *                     In that case, it will be reset to null and its value
	 *                     transferred to `$variables`.
	 * @param  array $variables Variables to pass to template partials.
	 * @return array In the format: `array( $name, $variables )`. This can be
	 *               used with `list()` very easily.
	 */
	function _aob_fix_template_part_args( $name, $variables ) {
		if ( is_array( $name ) ) {
			$variables = $name;
			$name = null;
		}

		return array( $name, $variables );
	}
}

/**
 * Header button output
 *
 * @return string
 */
function aob_header_buttons() {
	// get the options
	$aob_options = get_option( 'ashevilleonbikes_theme_options' );
	$out = '';

	if ( ! empty( $aob_options['donate_url'] ) || ! empty( $aob_options['newsletter_url'] ) ) {

		if ( ! empty( $aob_options['donate_url'] ) && $donate = $aob_options['donate_url'] ) {
			$out .= sprintf( '<a href="%s" class="donate" target="_blank">%s</a>', esc_url( $donate ), esc_html( 'DONATE', 'aob' ) );
		}
		if ( ! empty( $aob_options['newsletter_url'] ) && $newsletter = $aob_options['newsletter_url'] ) {
			$out .= sprintf( '<a href="%s" class="newsletter-signup" target="_blank">%s</a>', esc_url( $newsletter ), esc_html( 'JOIN', 'aob' ) );
		}

		return sprintf( '<div class="donate-signup">%s</div>', $out );
	}
}

function aob_get_social() {
	$aob_options = get_option( 'ashevilleonbikes_theme_options' );

	$social = array();

	if ( empty( $aob_options ) ) {
		return false;
	}

	if ( ! empty( $aob_options['facebook_input'] ) ) {
		$social['facebook'] = $aob_options['facebook_input'];
	}

	if ( ! empty( $aob_options['google_input'] ) ) {
		$social['google+'] = $aob_options['google_input'];
	}

	if ( ! empty( $aob_options['twitter_input'] ) ) {
		$social['twitter'] = $aob_options['twitter_input'];
	}

	if ( ! empty( $aob_options['insta_input'] ) ) {
		$social['instagram'] = $aob_options['insta_input'];
	}

	if ( ! empty( $aob_options['email_address'] ) ) {
		$social['email'] = $aob_options['email_address'];
	}

	if ( ! empty( $social ) ) {
		return $social;
	} else {
		return false;
	}
}

function aob_has_social() {
	if ( false === aob_get_social() ) {
		return false;
	} else {
		return true;
	}
}

function aob_get_blog_url( ) {
	if ( 'page' === get_option( 'show_on_front' ) ) {
		$blog_id = get_option( 'page_for_posts' );

		return get_the_permalink( $blog_id );
	}
}
