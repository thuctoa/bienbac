<?php
function shortcode_carousel( $atts, $content ) {
    extract( shortcode_atts( array(
        'show' => '5',
        'scroll' => '1',
        'arrows' => 'false'
    ), $atts ) );
    ob_start();
    $id = moztheme_rand_str( 'carousel' );
    ?>
    <div id="<?php echo $id; ?>" class="moz-carousel show-<?php echo $show; ?>">
        <?php echo do_shortcode( $content ); ?>
    </div>
    <script>
        jQuery(function($) {
            $( '#<?php echo $id; ?>' ).slick({
                slide: 'a',
                autoplay: true,
                dots: true,
                infinite: true,
                dots: false,
                arrows: <?php echo $arrows; ?>,
                slidesToShow: <?php echo $show; ?>,
                slidesToScroll: <?php echo $scroll; ?>
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode( 'carousel', 'shortcode_carousel' );

function shortcode_carousel_item( $atts ) {
    extract( shortcode_atts( array(
        'url' => '#',
        'title' => '',
        'img' => '/wp-content/themes/moztheme/img/df-carousel.png'
    ), $atts ) );
    ob_start();
    ?>
          <a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><img src="<?php echo $img; ?>" alt="<?php echo $title; ?>" /></a>
    <?php
    return ob_get_clean();
}
add_shortcode( 'carousel_item', 'shortcode_carousel_item' );
