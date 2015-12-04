<?php
function shortcode_sslide( $args, $content ) {
    ob_start();
    $id = moztheme_rand_str( 'sslide' );
    ?>
    <div id="<?php echo $id; ?>" class="moz-sslide">
        <?php echo do_shortcode( $content ); ?>
    </div>
    <script>
        jQuery(function($) {
            $( '#<?php echo $id; ?>' ).slick({
                slide: 'a',
                autoplay: true,
                dots: true
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode( 'sslide', 'shortcode_sslide' );

function shortcode_sslide_item( $args) {
    ob_start();
    ?>
          <a href="<?php echo $args['url']; ?>" title="<?php echo $args['title']; ?>"><img src="<?php echo $args['img']; ?>" alt="<?php echo $args['title']; ?>" /></a>
    <?php
    return ob_get_clean();
}
add_shortcode( 'sslide_item', 'shortcode_sslide_item' );