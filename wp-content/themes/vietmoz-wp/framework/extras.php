<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package moztheme
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function moztheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'moztheme_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function moztheme_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'moztheme_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function moztheme_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'moztheme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'moztheme_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function moztheme_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'moztheme_setup_author' );

function moztheme_new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'moztheme_new_excerpt_more');


if( !function_exists('moztheme_fix_shortcodes') ) {
    function moztheme_fix_shortcodes($content){   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']',
            '<p style="text-align: center;">[' => '[',
            '<p style="text-align: left;">[' => ']',
            '<p style="text-align: right;">[' => ']'

        );
        $content = strtr($content, $array);
        return $content;
    }
    add_filter('the_content', 'moztheme_fix_shortcodes');
}

function removeDemoModeLink() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'removeDemoModeLink');


//Custom Loign form
function moztheme_login_logo_url() {
    return "http://thietkeweb.vietmoz.com";
}
add_filter( 'login_headerurl', 'moztheme_login_logo_url' );

function moztheme_login_logo_url_title() {
    return 'VietMoz Web Design';
}
add_filter( 'login_headertitle', 'moztheme_login_logo_url_title' );

function moztheme_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/style-login.css' );
    // wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/css/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'moztheme_login_stylesheet' );

