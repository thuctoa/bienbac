<?php
function shortcode_list( $atts, $content ) {
    $a = shortcode_atts( array(
        'type'              => '1',
    ), $atts );
    ob_start(); ?>
	<div class="moztheme-list type-<?php echo $a['type']; ?>"><?php echo do_shortcode( $content ); ?></div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'list', 'shortcode_list' );