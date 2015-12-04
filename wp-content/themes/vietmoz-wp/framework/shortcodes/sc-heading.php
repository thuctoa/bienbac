<?php
function shortcode_heading( $atts, $content ) {
    $a = shortcode_atts( array(
        'type'              => '1',
        'h'                 => '2',
        'border_color'      => '#DFE0E0',
        'border_color_2'    => '#DA1C5C',
        'font_size'         => '',
        'transform'         => '',
        'url'               => '#',
        'align'             => 'left'
    ), $atts );
    ob_start(); ?>
    <?php switch ( $a['type'] ) {
        case 2:
            echo "<h".$a['h']." align='".$a['align']."' class='moztheme-heading ".$a['class']." type-2' style='border-bottom: 1px solid ".$a['border_color']."; font-size:".$a['font_size']."; text-transform: ".$a['transform'].";'>";
            if( $a['url'] != '#') {
                echo "<a href='".$a['url']."' title='".strip_tags($content)."'>";
            }
            echo "<span>".$content."</span>";
            if( $a['url'] != '#') {
                echo "</a>";
            }
            echo "</h".$a['h'].">";
            break;
        
        default:
            echo "<h".$a['h']." align='".$a['align']."' class='moztheme-heading ".$a['class']." type-1' style='border-bottom: 1px solid ".$a['border_color']."; font-size:".$a['font_size']."; text-transform: ".$a['transform'].";'>";
            if( $a['url'] != '#') {
                echo "<a href='".$a['url']."' title='".strip_tags($content)."'>";
            }
            echo "<span style='border-bottom: 3px solid ".$a['border_color_2'].";'>".$content."</span>";
            if( $a['url'] != '#') {
                echo "</a>";
            }
            echo "</h".$a['h'].">";
            break;
        }
    return ob_get_clean();
}
add_shortcode( 'heading', 'shortcode_heading' );