<?php
function shortcode_event( $atts ) {
    extract( shortcode_atts( array(
        'cat'    => '0',
        'per_page'  => '3',
        'heading'   => 'h4',
        'cat_slug'  => '',
        'date_field' => '',
        'duration_field' => ''

    ), $atts ) );
    ob_start();
    // Start the Loop.
        $today = date('Ymd');
        if( $cat_slug == '' ) {
            $args = array(
            'post_type' => 'post',
            'posts_per_page'    => $per_page,
            'meta_key'      => $date_field,
            'orderby'       => 'meta_value_num',
            'order'         => 'ASC',
            'meta_query' => array(
                array(
                    'key'       => $date_field,
                    'compare'   => '>=',
                    'value'     => $today
                ),
            ),
            'cat' => $cat
            );
        }
        else {
            $args = array(
            'post_type' => 'post',
            'posts_per_page'    => $per_page,
            'meta_key'      => $date_field,
            'orderby'       => 'meta_value_num',
            'order'         => 'ASC',
            'meta_query' => array(
                array(
                    'key'       => $date_field,
                    'compare'   => '>=',
                    'value'     => $today
                ),
            ),
            'category_name' => $cat_slug
            );
        }
        $the_query = new WP_Query( $args );
        if($the_query->have_posts() ) : ?>
        <div class="sc-event">
        <?php
            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <div class="item clearfix">
                <div class="cal">
                    <?php
                    $_date = get_field('dt_date');
                    $y = substr($_date, 0, 4);
                    $m = substr($_date, 4, 2);
                    $d = substr($_date, 6, 2);
                    $date = strtotime("{$d}-{$m}-{$y}");
                    echo '<span class="month">'. date('M', $date) .'</span>';
                    echo '<span class="day">'. date('d', $date) .'</span>';
                    ?>
                </div>
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    <span class="length">Thời lượng: <?php the_field( $duration_field ); ?></span>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    endif;
}
add_shortcode( 'event', 'shortcode_event' );