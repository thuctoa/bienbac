<?php


// don't load directly
if ( !function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}



if ( !class_exists( "Tocka_Walker_Nav_Menu_Edit" ) && class_exists( 'Walker_Nav_Menu_Edit' ) ):

class Tocka_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
	
	
	function start_el(&$output, $item, $depth, $args) {
		
		// append next menu element to $output
		parent::start_el($output, $item, $depth, $args);
		
		
		// now let's add a custom form field
		
		if ( ! class_exists( 'phpQuery') ) {
			// load phpQuery at the last moment, to minimise chance of conflicts (ok, it's probably a bit too defensive)
			require_once 'phpQuery-onefile.php';
		}
		
		$_doc = phpQuery::newDocumentHTML( $output );
		$_li = phpQuery::pq( 'li.menu-item:last' ); // ":last" is important, because $output will contain all the menu elements before current element
		
		// if the last <li>'s id attribute doesn't match $item->ID something is very wrong, don't do anything
		// just a safety, should never happen...
		$menu_item_id = str_replace( 'menu-item-', '', $_li->attr( 'id' ) );
		if( $menu_item_id != $item->ID ) {
			return;
		}
		
		// fetch previously saved meta for the post (menu_item is just a post type)
		$icon = esc_attr( get_post_meta( $menu_item_id, 'moztheme_fa_icon', TRUE ) );
		
		// by means of phpQuery magic, inject a new input field
		$_li->find( '.field-move' )
			->after(  "<p style='display: block; width: 100%; float: left;'>Icon: <input type='text' value='$icon' name='moztheme_fa_icon_$menu_item_id' />
				<br /><span style='font-size: 11px'>You can go to <a target='_blank' href='http://kb.vietmoz.info/?p=119'>http://kb.vietmoz.info/?p=119</a> to choose the suitable icon, then put its name ( without fa- prefix ) in the textbox above.</span><br />For example: home </p>" );
		
		// swap the $output
		$output = $_doc->html();
		
	}

}

endif;
