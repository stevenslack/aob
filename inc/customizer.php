<?php
/**
 * _s Theme Customizer
 *
 * @package aob
 */

/**
 * Clean Up customizer
 *
 * @param  $wp_customize
 */
function remove_customizer_settings( $wp_customize ) {

    // remove background image and background color
    $wp_customize->remove_section( 'background_image' );
    $wp_customize->remove_setting( 'background_color' );

}
add_action( 'customize_register', 'remove_customizer_settings', 20 );

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
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function aob_customizer_settings( $wp_customize ) {

    /**
     * Color Settings
     */
    $wp_customize->add_setting(
        'header_color',
        array(
            'default'   => 'light',
            'transport' => 'refresh',
        )
    );
    $wp_customize->add_control(
        'header_color',
        array(
            'label'     => __( 'Header background color', 'aob' ),
            'section'   => 'colors',
            'type'      => 'select',
            'choices'   => array(
                'light' => __( 'Default (light)', 'aob' ),
                'dark' => __( 'Dark', 'aob' ),
            ),
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
