<?php
/**
 * moztheme functions and definitions
 *
 * @package moztheme
 */


/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'moztheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function moztheme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on moztheme, use a find and replace
	 * to change 'moztheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'moztheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'moztheme' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	/*
	 * Enable support for Featured Image.
	 */
	add_theme_support( 'post-thumbnails' ); 
	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	// add_theme_support( 'post-formats', array(
	// 	'aside', 'video', 'chat'
	// ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'moztheme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // moztheme_setup
add_action( 'after_setup_theme', 'moztheme_setup' );

//Add image size
add_image_size( 'archive-thumb', 360, 240, true );

//Suport shortcodes for text widget
add_filter('widget_text', 'do_shortcode');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function moztheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar 1', 'moztheme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'moztheme' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	// register_sidebar( array(
	// 	'name'          => __( 'Header Widgets', 'moztheme' ),
	// 	'id'            => 'header-sidebar',
	// 	'description'   => 'This sidebar works only if header v4 is activated.',
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ) );

	// register_sidebar( array(
	// 	'name'          => __( 'Footer Padding Top', 'moztheme' ),
	// 	'id'            => 'footer-padding-top',
	// 	'description'   => '',
	// 	'before_widget' => '<div id="%1$s" class="padft-widget %2$s">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h3 class="widget-title">',
	// 	'after_title'   => '</h3>',
	// ) );
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'moztheme' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="ft-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'moztheme' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="ft-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'moztheme' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="ft-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'moztheme' ),
		'id'            => 'footer-4',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="ft-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Padding Bottom', 'moztheme' ),
		'id'            => 'footer-padding-bottom',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="padft-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'moztheme_widgets_init' );


function moztheme_scripts() {
	wp_enqueue_script('jquery');

	wp_enqueue_style( 'moztheme-bootstrap-css', get_template_directory_uri() . '/framework/resources/bootstrap/css/bootstrap.min.css' );

	wp_enqueue_style( 'moztheme-slick-css', get_template_directory_uri() . '/framework/resources/slick/slick.css' );

	wp_enqueue_style( 'moztheme-fontawesome', get_template_directory_uri() . '/framework/resources/fontawesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'moztheme-style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_script( 'moztheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'moztheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'moztheme-bootstrap-js', get_template_directory_uri() . '/framework/resources/bootstrap/js/bootstrap.min.js', array(), '20141010', true );

	wp_enqueue_script( 'moztheme-slick-js', get_template_directory_uri() . '/framework/resources/slick/slick.min.js', array(), '20141010', false );

	wp_enqueue_script( 'moztheme-custom-js', get_template_directory_uri() . '/js/moztheme.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'moztheme_scripts' );

/* Custom funcions */
function moztheme_rand_str( $prefix ) {
	$length = 8;
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	return $prefix."-".substr( str_shuffle( $chars ), 0, $length );
}


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/framework/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/framework/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/framework/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/framework/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// require get_template_directory() . '/framework/jetpack.php';

/**
 * Register Post Type
 */
// require get_template_directory() . '/framework/register-post-type.php';

/**
 * Load Bootstrap Walker
 *
 * @package moztheme
 *
 */
require get_template_directory() . '/framework/bootstrap-wp-navwalker.php';

/**
 * Load Woocommerce extra functions
 *
 * @package moztheme
 *
 */
require get_template_directory() . '/framework/woo-scripts.php';

/**
 * Load Shortcode
 *
 * @package moztheme
 *
 */
foreach (glob( get_template_directory()."/framework/shortcodes/*.php") as $filename)
{
    include $filename;
}

/**
 * Load Widget
 *
 * @package moztheme
 *
 */
foreach (glob( get_template_directory()."/framework/widgets/*.php") as $filename)
{
    include $filename;
}

/**
 * Load Menu Item plugin
 *
 * @package moztheme
 *
 */
require get_template_directory() . '/framework/plugins/tocka-menu-items/tocka-menu-items.php';

/** remove redux menu under the tools **/
add_action( 'admin_menu', 'remove_redux_menu',12 );

function remove_redux_menu() {
    remove_submenu_page('tools.php','redux-about');
}

function fb_comment_count( $posturl = null ) {
	$url = 'https://graph.facebook.com/';
	if( ! $posturl ) {
		global $post;
		$posturl = get_permalink($post->ID);
	}
	$url .= $posturl;

	$filecontent = wp_remote_retrieve_body(wp_remote_get($url, array('sslverify'=>false)));
	$json = json_decode($filecontent);
	$count = $json->comments;
	if ($count == 0 || !isset($count)) {
	    $count = 0;
	}

	return $count;
}