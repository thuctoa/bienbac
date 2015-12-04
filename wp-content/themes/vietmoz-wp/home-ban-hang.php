<?php
/**
 * Template name: Trang chủ web bán hàng
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
	<div id="primary">
	<?php _moz_slider(); ?>

	<main id="main" class="site-main" role="main">
		<?php if( $_moz_opts['opt_banhang_home_desc_desc'] ) : ?>
		<div class="home-desc clearfix">
			<h2 style="background: <?php echo $_moz_opts['opt_banhang_home_desc_color']; ?>;"><a href="<?php echo $_moz_opts['opt_banhang_home_desc_url']; ?>" title="<?php echo $_moz_opts['opt_banhang_home_desc_title']; ?>"><?php echo $_moz_opts['opt_banhang_home_desc_title']; ?></a></h2>
			<div class="row desc">
				<?php if( ! empty( $_moz_opts['opt_banhang_home_desc_img'] ) ) : ?>
				<div class="col-sm-4">
					<a href="<?php echo $_moz_opts['opt_banhang_home_desc_url']; ?>" title="<?php echo $_moz_opts['opt_banhang_home_desc_title']; ?>">
						<img src="<?php echo $_moz_opts['opt_banhang_home_desc_img']['url']; ?>" alt="<?php echo $_moz_opts['opt_banhang_home_desc_title']; ?>" />
					</a>
				</div>
				<div class="col-sm-8">
				<?php else : ?>
				<div class="col-sm-12">
				<?php endif; ?>
					<?php echo $_moz_opts['opt_banhang_home_desc_desc']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="home-products">
		<?php foreach( $_moz_opts['opt_banhang_home_taxs'] as $home_cat ) {
			$term = get_term( $home_cat, 'product_cat' );
			$term_link = get_term_link( $term );
			$term_name = $term->name;
			$term_slug = $term->slug;
		?>
		<div class="item">
		<h2><a href="<?php echo $term_link; ?>" title="<?php echo $term_name; ?>"><?php echo $term_name; ?></a></h2>
		<?php echo do_shortcode( '[product_category category="'. $term_slug .'" per_page="'. $_moz_opts['opt_banhang_pro_total'] .'" columns="'. $_moz_opts['opt_banhang_column'] .'" orderby="date" order="desc"]' ); ?>
		</div>
		<?php } ?>
		</div>
	</main><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>