<?php
function shortcode_cols( $atts, $content ) {
    extract( shortcode_atts( array(
        'class' => '',
        'align'	=> ''
    ), $atts ) );
    return "<div class='row ".$class." text-".$align."'>". do_shortcode($content) ."</div>";
}
add_shortcode( 'cols', 'shortcode_cols' );

function shortcode_col( $atts, $content ) {
    extract( shortcode_atts( array(
        'col'    => '3',
        'align'  => '',
        'class' => ''
    ), $atts ) );
        return "<div class='col-md-".$col." text-".$align." ".$class."'>". do_shortcode($content) ."</div>";
}
add_shortcode( 'col', 'shortcode_col' );