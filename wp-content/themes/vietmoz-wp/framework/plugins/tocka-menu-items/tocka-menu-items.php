<?php
/*
Plugin Name: Tocka Menu Items
Plugin URI: http://changeset.hr/blog/
Description: 
Version: 0.1
Author: Fran Hrzenjak
Author URI: http://changeset.hr
License: GPLv2 or later
*/

/*  Copyright 2013  Fran Hrzenjak  (email : fran@changeset.hr)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// don't load directly
if ( !function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


if ( !class_exists( "Tocka_Menu_Items_Plugin" ) ):

class Tocka_Menu_Items_Plugin
{
	
	/**
	 * Hook da stuff!
	 */
	function __construct() {
		add_action( 'wp_edit_nav_menu_walker', array( $this, 'edit_nav_menu_walker' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'tocka_update_nav_menu_item' ), 10, 3 );
	}

	
	/**
	 * Change the admin menu walker class name.
	 * @param string $walker
	 * @return string
	 */
	function edit_nav_menu_walker( $walker ) {
		//@TODO this should be loaded somewhere sooner... 
		require_once 'tocka-nav-menu-walker.php';
		
		// swap the menu walker class only if it's the default wp class (just in case)
		if ( $walker === 'Walker_Nav_Menu_Edit' ) {
			$walker = 'Tocka_Walker_Nav_Menu_Edit';
		}
		return $walker;
	}

	
	/**
	 * Save post meta. Menu items are just posts of type "menu_item".
	 * 
	 * 
	 * @param type $menu_id
	 * @param type $menu_item_id
	 * @param type $args
	 */
	function tocka_update_nav_menu_item($menu_id, $menu_item_id, $args) {
		
		if ( isset( $_POST[ "moztheme_fa_icon_$menu_item_id" ] ) ) {
			update_post_meta( $menu_item_id, 'moztheme_fa_icon', $_POST[ "moztheme_fa_icon_$menu_item_id" ] );
		} else {
			#mfmfmf("DEL");
			delete_post_meta( $menu_item_id, 'moztheme_fa_icon' );
		}
	}
	
}

// ignition!
new Tocka_Menu_Items_Plugin();

endif;
