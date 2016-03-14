<?php
/**
 * _s Theme Customizer
 *
 * @package aob
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _aob_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', '_aob_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _aob_customize_preview_js() {
	wp_enqueue_script( '_aob_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', '_aob_customize_preview_js' );

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
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

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function aob_customizer_settings( $wp_customize ) {

    /**
     * Front Page Sections
     */
    $wp_customize->add_section(
        'front_page_settings',
        array(
            'title' => __( 'Home Page Settings', 'aob' ),
            'description' => __( 'The settings for the homepage', 'aob' ),
            'priority' => 200,
        )
    );

    // slider
    $wp_customize->add_setting(
        'select_slider',
        array(
            'default'           => '',
            'sanitize_callback' => 'aob_sanitize_integer',
            'transport'         => 'refresh',
        )
    );
    $wp_customize->add_control(
        'select_slider',
        array(
            'label'     => __( 'Select a Slider', 'aob' ),
            'section'   => 'front_page_settings',
            'type'      => 'select',
            'choices'   => aob_post_type_select( array( 'post_type' => 'soliloquy' ) ),
            'priority'  => 0
        )
    );
}
add_action( 'customize_register', 'aob_customizer_settings' );

/**
 * Sanitize Text Fields
 */
function aob_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize Email Address
 */
function aob_sanitize_email( $input ) {
    return wp_kses_post( sanitize_email( $input ) );
}

/**
 * Sanitize URL
 */
function aob_sanitize_url( $input ) {
    return wp_kses_post( esc_url_raw( $input ) );
}

/**
 * Sanitize Integers
 */
function aob_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
