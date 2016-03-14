<?php
/**
 * Pixie Campbell Theme Options
 *
 * @package Pixie Campbell
 */

function aob_options_init() {
    register_setting(
        'ashevilleonbikes_options',                 // Options group, see settings_fields() call in aob_render_page()
        'ashevilleonbikes_theme_options',           // Database option, see aob_get_theme_options()
        'ashevilleonbikes_theme_options_validate'   // The sanitization callback, see ashevilleonbikes_theme_options_validate()
    );

    // Register Social Settings Group
    add_settings_section( 'social', 'Social Settings', '__return_false', 'theme_options' );

        add_settings_field(
            'facebook_input',
            __( 'Facebook page name:', 'aob' ),
            'aob_settings_facebook_input',
            'theme_options',
            'social'
        );
        add_settings_field(
            'twitter_input',
            __( 'Twitter username:', 'aob' ),
            'ashevilleonbikes_settings_twitter_input',
            'theme_options',
            'social'
        );
        add_settings_field(
            'google_input',
            __( 'Google Plus user ID:', 'aob' ),
            'ashevilleonbikes_settings_field_google_input',
            'theme_options',
            'social'
        );
        add_settings_field(
            'insta_input',
            __( 'Instagram user name:', 'aob' ),
            'ashevilleonbikes_settings_field_insta_input',
            'theme_options',
            'social'
     );

    // Additional Settings
    add_settings_section( 'aob_urls', 'Donation and Newsletter Fields', '__return_false', 'theme_options' );

        add_settings_field(
            'donate_url',
            __( 'Donation URL', 'aob' ),
            'ashevilleonbikes_settings_donate',
            'theme_options',
            'aob_urls'
        );
        add_settings_field(
            'newsletter_url',
            __( 'Newsletter Sign Up URL', 'aob' ),
            'ashevilleonbikes_settings_newsletter',
            'theme_options',
            'aob_urls'
        );
        add_settings_field(
            'email_address',
            __( 'Enter Your Email Address', 'aob' ),
            'ashevilleonbikes_settings_email',
            'theme_options',
            'aob_urls'
        );
}

add_action( 'admin_init', 'aob_options_init' );

/**
 * Change the capability required to save the 'ashevilleonbikes_options' options group.
 *
 * @see aob_options_init() First parameter to register_setting() is the name of the options group.
 * @see aob_add_options_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */

function aob_options_caps( $capability ) {
    return 'edit_theme_options';
}

add_filter( 'option_page_capability_aob_options', 'aob_options_caps' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since ashevilleonbikes 1.0
 */
function aob_add_options_page() {
    $theme_page = add_menu_page(
        __( 'AoB Settings', 'aob' ),                  // Page Title
        __( 'AoB Settings', 'aob' ),                  // Menu Title
        'edit_theme_options',                         // Capability
        'aob-options',                                // Menu slug
        'aob_render_page', // Function that renders the options page
        'dashicons-heart'
    );
}
add_action( 'admin_menu', 'aob_add_options_page' );

/**
 * Returns the options array for ashevilleonbikes.
 *
 * @since ashevilleonbikes 1.0
 */
function aob_get_theme_options() {
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
function aob_settings_facebook_input() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[facebook_input]" id="facebook-input" size="30" value="<?php echo esc_attr( $options['facebook_input'] ); ?>" />
    <label class="description" for="facebook-input"><?php _e( 'Example: http://facebook.com/<strong>YourFacebookPageName</strong>', 'aob' ); ?></label>
    <?php
}
/**
 * Renders the Twitter input setting field.
 */
function ashevilleonbikes_settings_twitter_input() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[twitter_input]" id="twitter-input" size="30" value="<?php echo esc_attr( $options['twitter_input'] ); ?>" />
    <label class="description" for="twitter-input"><?php _e( '', 'aob' ); ?></label>
    <?php
}
/**
 * Renders the Google+ input setting field.
 */
function ashevilleonbikes_settings_field_google_input() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[google_input]" id="google_input" size="30" value="<?php echo esc_attr( $options['google_input'] ); ?>" />
    <label class="description" for="google_input"><?php _e( '', 'aob' ); ?></label>
    <?php
}
/**
 * Renders the Instagram input setting field.
 */
function ashevilleonbikes_settings_field_insta_input() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[insta_input]" id="insta_input" size="30" value="<?php echo esc_attr( $options['insta_input'] ); ?>" />
    <label class="description" for="insta_input"><?php _e( '', 'aob' ); ?></label>
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
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[donate_url]" id="donate-url" size="30" value="<?php echo esc_attr( $options['donate_url'] ); ?>" />
    <label class="description" for="donate-url"><?php _e( '', 'aob' ); ?></label>
    <?php
}

function ashevilleonbikes_settings_newsletter() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[newsletter_url]" id="newsletter-url" size="30" value="<?php echo esc_attr( $options['newsletter_url'] ); ?>" />
    <label class="description" for="newsletter-url"><?php _e( '', 'aob' ); ?></label>
    <?php
}

function ashevilleonbikes_settings_email() {
    $options = aob_get_theme_options();
    ?>
    <input type="text" name="ashevilleonbikes_theme_options[email_address]" id="email-address" size="30" value="<?php echo esc_attr( $options['email_address'] ); ?>" />
    <label class="description" for="email-address"><?php _e( 'Enter your email address for use in the email icon in the header and footer.', 'aob' ); ?></label>
    <?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since ashevilleonbikes 1.0
 */
function aob_render_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php esc_html_e( 'Asheville on Bikes Theme Settings', 'aob' ); ?></h2>
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
 * @see aob_options_init()
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

    if ( isset( $input['insta_input'] ) && ! empty( $input['insta_input'] ) )
        $output['insta_input'] = wp_filter_nohtml_kses( $input['insta_input'] );

    if ( isset( $input['donate_url'] ) && ! empty( $input['donate_url'] ) )
        $output['donate_url'] = esc_url_raw( wp_filter_nohtml_kses( $input['donate_url'] ) );

    if ( isset( $input['newsletter_url'] ) && ! empty( $input['newsletter_url'] ) )
        $output['newsletter_url'] = esc_url_raw( wp_filter_nohtml_kses( $input['newsletter_url'] ) );

    if ( isset( $input['email_address'] ) && ! empty( $input['email_address'] ) )
        $output['email_address'] = sanitize_email( $input['email_address'] );

    return apply_filters( 'ashevilleonbikes_theme_options_validate', $output, $input );
}
