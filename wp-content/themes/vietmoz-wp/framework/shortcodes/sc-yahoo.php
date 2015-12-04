<?php
function shortcode_yahoo( $atts ) {
    extract( shortcode_atts( array(
        'nick'    => ''
    ), $atts ) );

    return "<a class='yahoo_sp' href='ymsgr:sendim?". $nick . "''><img src='http://opi.yahoo.com/online?u=". $nick ."&m=g&t=2' /></a>";
}
add_shortcode( 'yahoo', 'shortcode_yahoo' );