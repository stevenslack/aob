<?php
/**
 * All registration of custom fields and metaboxes
 */

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' parameter
 *
 * @param  object $cmb object
 *
 * @return bool             True if metabox should show
 */
function aob_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the options array
 */
function aob_post_type_select( $query_args ) {

    $args = wp_parse_args( $query_args, array(
        'post_type' => 'post'
    ) );

    $posts = get_posts( $args );

    $post_options = array( '' => __( '-- Select --', 'aob' ) );
    if ( $posts ) {
        foreach ( $posts as $post ) {
          $post_options[ $post->ID ] = $post->post_title;
        }
    }

    return $post_options;
}


add_action( 'cmb2_admin_init', 'aob_banner_options' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function aob_banner_options() {
	$prefix = 'aob_';
	/**
	 * registration of meta field
	 */
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'banner_options',
		'title'         => __( 'Banner Layout', 'aob' ),
		'object_types'  => array( 'page' ),
		'show_on_cb'    => 'aob_show_if_front_page', // function should return a bool value
		'context'       => 'normal',
	) );

	$cmb->add_field( array(
		'name'             => __( 'Select Homepage Banner Layout (top section)', 'aob' ),
		'desc'             => __( '', 'aob' ),
		'id'               => $prefix . 'banner_layout',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'slider'    => __( 'Slider', 'aob' ),
			'hero'      => __( 'Hero Image', 'aob' )
		),
	) );

	$cmb->add_field( array(
		'name' => __( 'Use Banner Text', 'aob' ),
		'desc' => __( 'yes - This will add text fields and a dark overlay on top of hero image or slider', 'aob' ),
		'id'   => $prefix . 'display_banner_text',
		'type' => 'checkbox',
	) );

	$cmb->add_field( array(
		'name'       => __( 'Main Banner Text', 'aob' ),
		'desc'       => __( 'The main text which appears in the banner area', 'aob' ),
		'id'         => $prefix . 'banner_text',
		'type'       => 'text',
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'display_banner_text',
			'data-conditional-value' => 'on',
		)
	) );

	$cmb->add_field( array(
		'name' => __( 'Supporting Text', 'aob' ),
		'desc' => __( 'This supporting text appears below the main banner text', 'aob' ),
		'id'   => $prefix . 'banner_supporting',
		'type' => 'textarea_small',
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'display_banner_text',
			'data-conditional-value' => 'on',
		)
	) );

	$cmb->add_field( array(
		'name'       => __( 'Button Text', 'aob' ),
		'desc'       => __( 'The text for the button which displays below the main banner text', 'aob' ),
		'id'         => $prefix . 'banner_button_text',
		'type'       => 'text',
		'default'    => __( 'Join the movement', 'aob' ),
		'attributes' => array(
			'data-conditional-id'    => $prefix . 'display_banner_text',
			'data-conditional-value' => 'on',
		)
	) );

	$cmb->add_field( array(
		'name'       => __( 'Button URL', 'aob' ),
		'desc'       => __( 'The URL for the button to direct to.', 'aob' ),
		'id'         => $prefix . 'banner_button_url',
		'type'       => 'text_url',
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'display_banner_text',
			'data-conditional-value' => 'on',
		)
	) );

	$cmb->add_field( array(
		'name' => __( 'Banner Image', 'aob' ),
		'desc' => __( 'Upload an image that is at least 1400 pixels wide in order for the image to remain crip', 'aob' ),
		'id'   => $prefix . 'banner_image',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __( 'Add Banner Image', 'aob' )
		),
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'banner_layout',
			'data-conditional-value' => 'hero'
		)
	) );

	$cmb->add_field( array(
		'name'             => __( 'Select which slider to use', 'aob' ),
		'desc'             => __( '', 'aob' ),
		'id'               => $prefix . 'slider',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => aob_post_type_select( array( 'post_type' => 'soliloquy' ) ),
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'banner_layout',
			'data-conditional-value' => 'slider',
		)
	) );

	$cmb->add_field( array(
		'name' => __( 'Use Slider Title and Caption instead of banner text?', 'aob' ),
		'desc' => __( 'yes - This will overwrite the banner text and default to each slides title and caption', 'aob' ),
		'id'   => $prefix . 'slider_text',
		'type' => 'checkbox',
		'attributes'       => array(
			'data-conditional-id'    => $prefix . 'banner_layout',
			'data-conditional-value' => 'slider',
		)
	) );
}
