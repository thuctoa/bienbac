<?php
function shortcode_loop( $atts ) {
    extract( shortcode_atts( array(
        'cat'    => '0',
        'per_page'  => '3',
        'width' => '100',
        'length'  => '20',
        'showdate'  => '',
        'heading'   => 'h4',
        'cat_slug'  => '',
        'size'  => 'thumbnail',
        'class' => 'sc-loop',
        'title_length' => ''
    ), $atts ) );
    ob_start();
    // Start the Loop.
    $args = array();
    if( $cat_slug == '' ) {
        $args = array(
        'order'    => 'DESC',
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'cat'   => $cat
        );
    }
    else {
        $args = array(
        'order'    => 'DESC',
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'category_name'   => $cat_slug
        );
    }
    $the_query = new WP_Query( $args );
    if($the_query->have_posts() ) : ?>
        <div class="<?php echo $class; ?>">
        <?php
            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <article class="clearfix">
                <?php
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id, $size, true);
                ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $thumb_url['0']; ?>" alt="<?php the_title(); ?>" width="<?php echo $width; ?>"/></a>
                <<?php echo $heading; ?> class="heading"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo $title_length == '' ? get_the_title() : wp_trim_words( get_the_title(), $title_length ); ?></a></<?php echo $heading; ?>>
                <p><?php echo $length != 0 ? wp_trim_words( get_the_excerpt(), $length ) : ''; ?></p>
                <?php if( $showdate == 'yes' ) {
                    moztheme_posted_on();
                    } ?>
            </article>
        <?php
        endwhile;
        wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    endif;
}
add_shortcode( 'loop', 'shortcode_loop' );