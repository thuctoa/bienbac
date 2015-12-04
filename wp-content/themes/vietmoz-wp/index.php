<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package moztheme
 */

global $_moz_opts;

get_header(); ?>
	<div class="container">
	<div class="row">
		<main id="primary" class="site-main <?php
			if ( $_moz_opts['opt_main_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}
			if( $_moz_opts['opt_main_layout'] == 1 || is_page_template( 'home-full-width.php' ) ) {
				echo "col-xs-12";
			}
			elseif ( $_moz_opts['opt_main_layout'] == 2 ) {
				echo "col-xs-$_main_width col-xs-push-$_side_width";
			}
			elseif ( $_moz_opts['opt_main_layout'] == 3 ) {
				echo "col-xs-$_main_width";
			}
			elseif ( $_moz_opts['opt_main_layout'] == 4 ) {
				echo "col-xs-$_main_width col-xs-push-".$_moz_opts['opt_col_width_1'];
			}
			elseif ( $_moz_opts['opt_main_layout'] == 5 ) {
				echo "col-xs-$_main_width col-xs-push-$_side_width";
			}
			elseif ( $_moz_opts['opt_main_layout'] == 6 ) {
				echo "col-xs-$_main_width";
			}
		?>" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php moztheme_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #primary -->

		<?php get_sidebar('home'); ?>
		<?php
			if( $_moz_opts['opt_main_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		?>
	</div><!-- /.row (home) -->
	</div><!-- /.container (home) -->

<?php get_footer(); ?>
