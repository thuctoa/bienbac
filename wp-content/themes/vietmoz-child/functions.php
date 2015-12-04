<?php
/**
 * Enqueue scripts and styles for child themes.
 */
if( ! function_exists( 'moztheme_child_scripts' ) ) :
function moztheme_child_scripts() {
	wp_enqueue_style( 'moztheme-style-child', get_stylesheet_uri() );
    wp_enqueue_script( 'moztheme-child-js', get_stylesheet_directory_uri() . '/child.js', array(), '20141012', true );
}
endif;
add_action( 'wp_enqueue_scripts', 'moztheme_child_scripts', 20 );