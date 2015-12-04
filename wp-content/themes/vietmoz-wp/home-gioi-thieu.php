<?php
/**
 * Template name: Trang chủ web giới thiệu
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
	<div class="clearfix">

	<?php
		$col = $_moz_opts['opt_gioithieu_service_num'];
		$col_w = 12/$col;
		if( $col == 2 || $col == 4 ) {
			$col_w_sm = 6;
		}
		else {
			$col_w_sm = 12;
		}
		$type = $_moz_opts['opt_gioithieu_service_style'];
		if( $type == 'img' && ! empty( $_moz_opts['opt_gioithieu_service_1_img'] ) ) {
			$max_w = $_moz_opts['opt_gioithieu_service_1_img']['width'];
		}
	?>

	<div class="row services type-<?php echo $type; ?>">
		<?php
		for ($i=1; $i < $col + 1; $i++) { ?>
			<div class="col-sm-<?php echo $col_w_sm; ?> col-md-<?php echo $col_w; ?> text-center">
			<?php if( $type == 'ico' ) {
				echo '<div class="icon-wrap">';
				echo '<a href="'.$_moz_opts['opt_gioithieu_service_'.$i.'_link'].'"><i class="fa '.$_moz_opts['opt_gioithieu_service_'.$i.'_ico'].'"></i></a>';
				echo '</div>';
			}
			?>
			<?php if( $type == 'img' && ! empty( $_moz_opts['opt_gioithieu_service_'.$i.'_img'] ) ) {
				echo '<a href="'.$_moz_opts['opt_gioithieu_service_'.$i.'_link'].'"><img src="'.$_moz_opts['opt_gioithieu_service_'.$i.'_img']['url'].'"></a>';
			}
			?>
			<h4 style="max-width: <?php echo $max_w; ?>px; margin-left: auto; margin-right: auto;"><a href="<?php echo $_moz_opts['opt_gioithieu_service_'.$i.'_link']; ?>"><?php echo $_moz_opts['opt_gioithieu_service_'.$i.'_title']; ?></a></h4>
			<p style="max-width: <?php echo $max_w; ?>px; text-align: justify; margin: 0 auto;">
				<?php echo $_moz_opts['opt_gioithieu_service_'.$i.'_desc']; ?>
			</p>
			</div>
		<?php } //end for ?>
	</div>

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
	<div id="primary">
	<main id="main" class="site-main" role="main">

		<div class="featured-post row">
			<?php
				$featured = get_post( $_moz_opts['opt_gioithieu_featured'] );
			?>
			<a class="col-sm-5 hidden-xs" href="<?php echo get_permalink( $featured->ID ); ?>" title="<?php echo $featured->post_title; ?>"><?php echo get_the_post_thumbnail( $featured->ID, 'medium' ); ?></a>
			<div class="col-sm-7">
				<h2><a href="<?php echo get_permalink( $featured->ID ); ?>" title="<?php echo $featured->post_title; ?>"><?php echo $featured->post_title; ?></a></h2>
				<p><?php echo wp_trim_words( strip_shortcodes( $featured->post_content ), 80, '..' ); ?></p>

			</div>
		</div>
		
		<?php if( ! empty( $_moz_opts['opt_gioithieu_banner_img'] ) ) : ?>
			<a class="hidden-xs" href="<?php echo $_moz_opts['opt_gioithieu_banner_url']; ?>"><img src="<?php echo $_moz_opts['opt_gioithieu_banner_img']['url']; ?>"></a>
		<?php endif; ?>

		<?php
		$args = array(
			'posts_per_page' => $_moz_opts['opt_gioithieu_home_post_num'],
		);             
		$the_query = new WP_Query( $args );
		if($the_query->have_posts() ) : ?>

		<div class="news">

		<h2>Tin tức</h2>

		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<article class="clearfix">
				
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="img"><?php the_post_thumbnail( 'thumbnail' ); ?></a>

				<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>

				<p class="hidden-xs"><?php echo get_the_excerpt(); ?></p>

			</article>

		<?php endwhile;?>

		</div>

		<?php endif; ?>

		<?php wp_reset_query(); ?>

			

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
