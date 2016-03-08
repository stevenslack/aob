<?php
/**
 * Pixie Campbell Theme Options
 *
 * @package Pixie Campbell
 */

function ashevilleonbikes_theme_options_init() {
    register_setting(
        'ashevilleonbikes_options',                 // Options group, see settings_fields() call in ashevilleonbikes_theme_options_render_page()
        'ashevilleonbikes_theme_options',           // Database option, see ashevilleonbikes_get_theme_options()
        'ashevilleonbikes_theme_options_validate'   // The sanitization callback, see ashevilleonbikes_theme_options_validate()
    );

    // Register Social Settings Group
    add_settings_section( 'social', 'Social Settings', '__return_false', 'theme_options' );

        add_settings_field( 'facebook_input', __( 'Facebook page name:', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_facebook_input', 'theme_options', 'social' );
        add_settings_field( 'twitter_input', __( 'Twitter username:', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_twitter_input', 'theme_options', 'social' );
        add_settings_field( 'google_input', __( 'Google Plus user ID:', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_field_google_input', 'theme_options', 'social' );

    // Additional Settings
    add_settings_section( 'aob_urls', 'Additional Settings', '__return_false', 'theme_options' );

        add_settings_field( 'donate_url', __( 'Donation URL', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_donate', 'theme_options', 'aob_urls' );
        add_settings_field( 'newsletter_url', __( 'Newsletter Sign Up URL', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_newsletter', 'theme_options', 'aob_urls' );
        add_settings_field( 'email_address', __( 'Enter Your Email Address', 'ashevilleonbikes' ), 'ashevilleonbikes_settings_email', 'theme_options', 'aob_urls' );
}

add_action( 'admin_init', 'ashevilleonbikes_theme_options_init' );

/**
 * Change the capability required to save the 'ashevilleonbikes_options' options group.
 *
 * @see ashevilleonbikes_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see ashevilleonbikes_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */

function ashevilleonbikes_option_page_capability( $capability ) {
    return 'edit_theme_options';
}

add_filter( 'option_page_capability_ashevilleonbikes_options', 'ashevilleonbikes_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since ashevilleonbikes 1.0
 */
function ashevilleonbikes_theme_options_add_page() {
    $theme_page = add_theme_page(
        __( 'Social Settings', 'ashevilleonbikes' ),    // Name of page
        __( 'Social Settings', 'ashevilleonbikes' ),    // Label in menu
        'edit_theme_options',                       // Capability required
        'theme_options',                            // Menu slug, used to uniquely identify the page
        'ashevilleonbikes_theme_options_render_page'    // Function that renders the options page
    );
}
add_action( 'admin_menu', 'ashevilleonbikes_theme_options_add_page' );

/**
 * Returns the options array for ashevilleonbikes.
 *
 * @since ashevilleonbikes 1.0
 */
function ashevilleonbikes_get_theme_options() {
    $saved = (array) get_option( 'ashevilleonbikes_theme_options' );
    $defaults = array(
        'facebook_input'    => '',
        'twitter_input'     => '',
        'google_input'      => '',
        'donate_url'        => '',
        'newsletter_url'    => '',
        'email_address'     => '',
    );

    $defaults = apply_filters( 'ashevilleonbikes_default_theme_options', $defaults );

    $options = wp_parse_args( $saved, $defaults );
    $options = array_intersect_key( $options, $defaults );

    return $options;
}

/**
 * Renders the Facebook input setting field.
 */
function ashevilleonbikes_settings_facebook_input() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[facebook_input]" id="facebook-input" size="30" value="<?php echo esc_attr( $options['facebook_input'] ); ?>" />
    <label class="description" for="facebook-input"><?php _e( 'Example: http://facebook.com/<strong>YourFacebookPageName</strong>', 'ashevilleonbikes' ); ?></label>
    <?php
}
/**
 * Renders the Twitter input setting field.
 */
function ashevilleonbikes_settings_twitter_input() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[twitter_input]" id="twitter-input" size="30" value="<?php echo esc_attr( $options['twitter_input'] ); ?>" />
    <label class="description" for="twitter-input"><?php _e( '', 'ashevilleonbikes' ); ?></label>
    <?php
}
/**
 * Renders the phone number input setting field.
 */
function ashevilleonbikes_settings_field_google_input() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[google_input]" id="google_input" size="30" value="<?php echo esc_attr( $options['google_input'] ); ?>" />
    <label class="description" for="google_input"><?php _e( '', 'ashevilleonbikes' ); ?></label>
    <?php
}

/**
 * ***************************************************************************************
 * Additional settings
 * ***************************************************************************************
 */

/**
 * Renders the phone number input setting field.
 */
function ashevilleonbikes_settings_donate() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[donate_url]" id="donate-url" size="30" value="<?php echo esc_attr( $options['donate_url'] ); ?>" />
    <label class="description" for="donate-url"><?php _e( '', 'ashevilleonbikes' ); ?></label>
    <?php
}

function ashevilleonbikes_settings_newsletter() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[newsletter_url]" id="newsletter-url" size="30" value="<?php echo esc_attr( $options['newsletter_url'] ); ?>" />
    <label class="description" for="newsletter-url"><?php _e( '', 'ashevilleonbikes' ); ?></label>
    <?php
}

function ashevilleonbikes_settings_email() {
    $options = ashevilleonbikes_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[email_address]" id="email-address" size="30" value="<?php echo esc_attr( $options['email_address'] ); ?>" />
    <label class="description" for="email-address"><?php _e( 'Enter your email address for use in the email icon in the header and footer.', 'ashevilleonbikes' ); ?></label>
    <?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since ashevilleonbikes 1.0
 */
function ashevilleonbikes_theme_options_render_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
        <h2><?php printf( __( '%s Social Settings', 'ashevilleonbikes' ), $theme_name ); ?></h2>
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
                settings_fields( 'ashevilleonbikes_options' );
                do_settings_sections( 'theme_options' );
                submit_button();
            ?>
        </form>
    </div>
    <?php
}


/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see ashevilleonbikes_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since ashevilleonbikes 1.0
 */
function ashevilleonbikes_theme_options_validate( $input ) {
    $output = array();

    if ( isset( $input['facebook_input'] ) && ! empty( $input['facebook_input'] ) )
        $output['facebook_input'] = wp_filter_nohtml_kses( $input['facebook_input'] );

    if ( isset( $input['twitter_input'] ) && ! empty( $input['twitter_input'] ) )
        $output['twitter_input'] = wp_filter_nohtml_kses( $input['twitter_input'] );

    if ( isset( $input['google_input'] ) && ! empty( $input['google_input'] ) )
        $output['google_input'] = wp_filter_nohtml_kses( $input['google_input'] );

    if ( isset( $input['donate_url'] ) && ! empty( $input['donate_url'] ) )
        $output['donate_url'] = esc_url_raw( wp_filter_nohtml_kses( $input['donate_url'] ) );

    if ( isset( $input['newsletter_url'] ) && ! empty( $input['newsletter_url'] ) )
        $output['newsletter_url'] = esc_url_raw( wp_filter_nohtml_kses( $input['newsletter_url'] ) );

    if ( isset( $input['email_address'] ) && ! empty( $input['email_address'] ) )
        $output['email_address'] = sanitize_email( $input['email_address'] );

    return apply_filters( 'ashevilleonbikes_theme_options_validate', $output, $input );
}
