<?php
/**
 * Template name: Trang chủ web tin tức
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package moztheme
 */
global $_moz_opts;
get_header(); ?>
	<div class="container">
	<div class="row">
	<div class="main-content
	<?php
		if ( $_moz_opts['opt_main_layout'] > 3 ) {
			$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
			$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
		}
		else {
			$_main_width = 12 - $_moz_opts['opt_col_width_1'];
			$_side_width = $_moz_opts['opt_col_width_1'];
		}
		if( $_moz_opts['opt_main_layout'] == 1 || is_page_template( 'home-full-width.php' ) ) {
			echo "col-md-12";
		}
		elseif ( $_moz_opts['opt_main_layout'] == 2 ) {
			echo "col-md-$_main_width col-md-push-$_side_width";
		}
		elseif ( $_moz_opts['opt_main_layout'] == 3 ) {
			echo "col-md-$_main_width";
		}
		elseif ( $_moz_opts['opt_main_layout'] == 4 ) {
			echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
		}
		elseif ( $_moz_opts['opt_main_layout'] == 5 ) {
			echo "col-md-$_main_width col-md-push-$_side_width";
		}
		elseif ( $_moz_opts['opt_main_layout'] == 6 ) {
			echo "col-md-$_main_width";
		}
	?>">
	<div id="primary" >
	<main id="main" class="site-main" role="main">
	
		<?php echo do_shortcode( '[latest_posts]' ); ?>
		<?php $order = 1; ?>
		<?php foreach( $_moz_opts['opt_tintuc_home_cats'] as $home_cat ) {
			$cate = get_category( $home_cat );
			$cate_link = get_category_link( $home_cat );
			$cate_name = $cate->name;
		?>
		<?php if( $order == $_moz_opts['opt_tintuc_home_banner_order'] ) : ?>
			<div style="padding-left: 10px; padding-right: 10px;">
				<a href="<?php echo $_moz_opts['opt_tintuc_home_banner_url']; ?>">
					<img src="<?php echo $_moz_opts['opt_tintuc_home_banner_img']['url']; ?>" alt="">
				</a>
			</div>
		<?php endif; ?>
		<div class="widget_moztheme_categoryposts_widget">
			<h2 class="widget-title"><a href="<?php echo $cate_link; ?>" title="<?php echo $cate_name; ?>"><span><?php echo $cate_name; ?></span></a></h2>
			<div class="newsblock row">
			<?php
			// Start the Loop.
			$args = array(
			'order'    => 'DESC',
			'posts_per_page' => 4,
			'cat' => $home_cat,
			);             
			$the_query = new WP_Query( $args );
			if($the_query->have_posts() ) :
				$c = 0;
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$c++;
					if( $c == 1 ) :
					?>
					<div class="featured col-sm-5">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
						<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo wp_trim_words( get_the_excerpt(), 50, '' ); ?></p>
					</div>
					<ul class="newsblock-small col-sm-7"> 
					<?php
					else : ?>
						<li class="clearfix">
							<?php if( has_post_thumbnail() ) { ?><div class="col-sm-4 hidden-xs nogutter-left"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div><?php } ?>
							<?php if( has_post_thumbnail() ) { ?><div class="col-sm-8 info"><?php } else { ?><div class="info"><?php } ?>
								<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
								<p class="hidden-xs"><?php echo wp_trim_words( get_the_excerpt(), 20, '' ); ?></p>
							</div>
						</li>	
					<?php endif;
				endwhile;
				?>
					</ul>
				<?php
			endif;
			?>
			</div>
		</div>
		<?php
		$order += 1;
		}//foreach
		?>
	</main><!-- #main -->
	
<?php get_sidebar(); ?>
<?php
	if( $_moz_opts['opt_main_layout'] == 1 || is_page_template( 'home-full-width.php' ) ) {
		echo '</div><!-- /#primary -->';
	}
	elseif( $_moz_opts['opt_main_layout'] > 3 ) {
		echo '</div><!-- #territory -->';
	}
	else {
		echo '</div><!-- #secondary -->';
	}
?>
	</div><!-- /.clearfix -->
	</div><!-- /.container -->
<?php get_footer(); ?>
