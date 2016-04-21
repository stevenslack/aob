<?php
/**
 * aob functions and definitions
 *
 * @package aob
 */

define( 'AOB_STATIC_VERSION', '1.0.0' );

if ( ! function_exists( '_aob_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function _aob_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'aob', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 200, 200 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'aob' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// adds theme support for title tag
	add_theme_support( 'title-tag' );

	// WordPress TinyMCE editor Stylesheet
	add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.css' );
}
endif; // _aob_setup
add_action( 'after_setup_theme', '_aob_setup' );

// banner image
add_image_size( 'banner', 1400, 400, true );

// image sizes used for scaling
add_image_size( 'image_1', 1400, 1400 );
add_image_size( 'image_2', 1100, 1100 );
add_image_size( 'image_3', 800, 800 );
add_image_size( 'image_4', 500, 500 );

// post and page featured image
add_image_size( 'post-thumb', 1313, 738 );
// the featured image on the blog page 16:9 ratio
add_image_size( 'blog-thumb', 921, 518 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _aob_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_aob_content_width', 1313 );
}
add_action( 'after_setup_theme', '_aob_content_width', 0 );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function _aob_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'aob' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', '_aob_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _aob_scripts() {
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700', '', '', '' );

	wp_enqueue_style( 'aob-style', get_stylesheet_uri(), null, AOB_STATIC_VERSION, 'all' );

	wp_enqueue_script( 'aob-scripts', get_template_directory_uri() . '/assets/js/main.js', array(), AOB_STATIC_VERSION, true );

	// Load comments script for single pages only
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_aob_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/plugins.php';
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/img-functions.php';
require get_template_directory() . '/inc/class-drop-walker-nav.php';

/**
 * Custom Meta Boxes - CMB2 v2.2.1
 */
if ( file_exists( get_template_directory() . '/inc/cmb2/init.php' ) ) {

  require_once get_template_directory() . '/inc/cmb2/init.php';
  require get_template_directory() . '/inc/cmb2-conditionals.php';
  require get_template_directory() . '/inc/custom-fields.php';

} elseif ( file_exists( get_template_directory() . '/inc/CMB2/init.php' ) ) {

  require_once get_template_directory() . '/inc/CMB2/init.php';
  require get_template_directory() . '/inc/cmb2-conditionals.php';
  require get_template_directory() . '/inc/custom-fields.php';
}


/**
 * Custom Login Page Styles
 */
function aob_login_css() {
	wp_enqueue_style( 'aob_login_css', get_template_directory_uri() . '/assets/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function aob_login_url() { return home_url(); }

// changing the alt text on the logo to show your site name
function aob_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'aob_login_css', 10 );
add_filter( 'login_headerurl', 'aob_login_url' );
add_filter( 'login_headertitle', 'aob_login_title' );
