<?php

/**
 * White Label Soliloquy
 */
add_filter( 'gettext', 'aob_soliloquy_whitelabel', 10, 3 );
function aob_soliloquy_whitelabel( $translated_text, $source_text, $domain ) {

    // If not in the admin, return the default string.
    if ( ! is_admin() ) {
        return $translated_text;
    }

    if ( strpos( $source_text, 'Soliloquy Slider' ) !== false ) {
        return str_replace( 'Soliloquy Slider', 'Slider', $translated_text );
    }

    if ( strpos( $source_text, 'Soliloquy Sliders' ) !== false ) {
        return str_replace( 'Soliloquy Sliders', 'Sliders', $translated_text );
    }

    if ( strpos( $source_text, 'Soliloquy slider' ) !== false ) {
        return str_replace( 'Soliloquy slider', 'slider', $translated_text );
    }

    if ( strpos( $source_text, 'Soliloquy' ) !== false ) {
        return str_replace( 'Soliloquy', 'Sliders', $translated_text );
    }

    return $translated_text;
}


/**
 * Soliloquy
 */
add_filter( 'soliloquy_defaults', 'aob_soliloquy_default_settings', 20, 2 );
function aob_soliloquy_default_settings( $defaults, $post_id ) {
    $defaults['slider_width']  = 1400; // Slider width.
    $defaults['slider_height'] = 787;  // Slider height.
    $defaults['transition']    = 'horizontal';
    $defaults['arrows']        = 0;
    $defaults['auto']          = 0;
    $defaults['gutter']        = 0;

    return $defaults;
}

add_filter( 'soliloquy_output_caption', 'soliloquy_title_before_caption', 10, 5 );
function soliloquy_title_before_caption( $caption, $id, $slide, $data, $i ) {

	// Check if current slide has a title specified
	if ( isset( $slide['title'] ) && !empty( $slide['title'] ) ) {
		$caption = '<h4 class="title">' . $slide['title'] . '</h4>';
                $caption .= '<div class="caption">' . $slide['caption'] . '</div>';
        }
        return $caption;
}

add_filter( 'soliloquy_output_item_classes', 'aob_output_item_classes', 10, 4 );
function aob_output_item_classes( $classes, $item, $i, $data ) {
	if ( ! empty( $item['caption'] ) ) {
		$classes[] = 'slide-has-caption';
	}
	return $classes;
}

/**
 * Events Calendar
 */
if ( function_exists( 'tribe_get_start_date' ) ) {
	/**
	 * [aob_event_widget_before_title description]
	 * @see  tribe_get_start_date in the-events-calendar plugin
	 * @return [type] [description]
	 */
	function aob_event_widget_before_title() {
		global $post;

		/**
		 * Tribe Start Date
		 *
		 * Returns the event start date and time
		 *
		 * @category Events
		 * @param int    $event       (optional)
		 * @param bool   $display_time If true shows date and time, if false only shows date
		 * @param string $date_format  Allows date and time formating using standard php syntax (http://php.net/manual/en/function.date.php)
		 * @param string $timezone    Timezone in which to present the date/time (or default behaviour if not set)
		 * @return string|null Date
		 */
		$start_month = tribe_get_start_date( $post->ID, false, 'M' );
		$start_day   = tribe_get_start_date( $post->ID, false, 'd' );

		if ( ! empty( $start_month ) && ! empty( $start_day ) ) {
			?>
				<div class="aob-list-date">
					<span class="list-monthname"><?php echo esc_html( $start_month ); ?></span>
					<span class="list-daynumber"><?php echo esc_html( $start_day ); ?></span>
				</div>
				<div class="aob-list-info">
			<?php
		}

	}
	add_action( 'tribe_events_list_widget_before_the_event_title', 'aob_event_widget_before_title' );

	function aob_event_widget_after_meta() {
		?></div><!--/.aob-list-info--><?php
	}
	add_action( 'tribe_events_list_widget_after_the_meta', 'aob_event_widget_after_meta' );
}
