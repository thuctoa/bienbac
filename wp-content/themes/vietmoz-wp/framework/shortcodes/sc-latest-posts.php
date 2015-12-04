<?php
function shortcode_latest_posts() {
    ob_start();
    $count = 1;
	$args = array(
	'post_type'=> 'post',
	'order'    => 'DESC',
	'posts_per_page' => 11
	);
	$the_query = new WP_Query( $args );
	if($the_query->have_posts() ) : ?>
	<div class="moztheme-latest-posts container">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<?php if( $count == 1 ) { ?>
		<div class="row">
			<div class="col-md-8">
				<div class="featured">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail( 'large' ); ?>
						<div class="info">
							<h3 class="title"><?php the_title(); ?></h3>
							<time><?php the_time('H:i, d-m-Y'); ?></time>
						</div>
					</a>
				</div><!-- /.featured -->
			</div><!-- /.col-md-8 -->
		<?php }
		elseif( $count == 2 ) { ?>
			<div class="col-md-4 small">
				<div class="item">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</div><!-- /.item -->
		<?php }
		elseif( $count > 2 && $count < 7 ) { ?>
				<div class="item">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</div><!-- /.item -->
		<?php }
		elseif( $count == 7 ) { ?>
				<div class="item">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</div><!-- /.item -->
			</div><!-- /.col-md-4 -->
		</div><!-- /.row -->
		<?php }
		elseif ( $count == 8 ) { ?>
		<div class="row hidden-xs">
			<div class="thumb-item col-md-3 col-sm-6 clearfix">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'medium' ); ?>
					<span><?php the_title(); ?></span>
				</a>
			</div><!-- /.thumb-item -->
		<?php }
		elseif( $count == 9 || $count == 10 ) { ?>
			<div class="thumb-item col-md-3 col-sm-6 clearfix">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'medium' ); ?>
					<span><?php the_title(); ?></span>
				</a>
			</div><!-- /.thumb-item -->
		<?php }
		elseif( $count == 11 ) { ?>
			<div class="thumb-item col-md-3 col-sm-6 clearfix">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( 'medium' ); ?>
					<span><?php the_title(); ?></span>
				</a>
			</div><!-- /.thumb-item -->
		</div><!-- /.row -->
		<?php }
    $count++;
    endwhile; ?>
	</div><!-- /.moztheme-latest-posts -->
    <?php
    endif;
    return ob_get_clean();
}
add_shortcode( 'latest_posts', 'shortcode_latest_posts' );