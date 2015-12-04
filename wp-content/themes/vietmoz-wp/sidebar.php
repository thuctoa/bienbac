<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package moztheme
 */


global $_moz_opts;
?>
	</div><!-- /#primary -->
	</div><!-- /.main-content -->
<?php
if( function_exists( 'is_woocommerce' ) ) { //checking plugins woocommmerce exist?
	if( is_product_category() || is_product_tag() ) {
		
		if ( $_moz_opts['opt_product_category_layout'] > 1 ) :
			if ( $_moz_opts['opt_product_category_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_product_category_layout'] == 2 || $_moz_opts['opt_product_category_layout'] == 4 || $_moz_opts['opt_product_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_product_category_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_product_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	elseif( is_category() || is_post_type_archive() || is_tag() ) {

		if ( $_moz_opts['opt_category_layout'] > 1 ) :
			if ( $_moz_opts['opt_category_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_category_layout'] == 2 || $_moz_opts['opt_category_layout'] == 4 || $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_category_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	elseif( is_product() ) {

		if ( $_moz_opts['opt_product_single_layout'] > 1 ) :
			if ( $_moz_opts['opt_product_single_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_product_single_layout'] == 2 || $_moz_opts['opt_product_single_layout'] == 4 || $_moz_opts['opt_product_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_product_single_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_product_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	elseif( is_single() ) {

		if ( $_moz_opts['opt_single_layout'] > 1 ) :
			if ( $_moz_opts['opt_single_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_single_layout'] == 2 || $_moz_opts['opt_single_layout'] == 4 || $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_single_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	else {

		if ( $_moz_opts['opt_main_layout'] > 1 ) :
			if ( $_moz_opts['opt_main_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_main_layout'] == 2 || $_moz_opts['opt_main_layout'] == 4 || $_moz_opts['opt_main_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_main_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_main_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
}
else {
	if( is_category() || is_post_type_archive() || is_tag() ) {

		if ( $_moz_opts['opt_category_layout'] > 1 ) :
			if ( $_moz_opts['opt_category_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_category_layout'] == 2 || $_moz_opts['opt_category_layout'] == 4 || $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_category_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	elseif( is_single() ) {

		if ( $_moz_opts['opt_single_layout'] > 1 ) :
			if ( $_moz_opts['opt_single_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_single_layout'] == 2 || $_moz_opts['opt_single_layout'] == 4 || $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_single_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
	else {

		if ( $_moz_opts['opt_main_layout'] > 1 ) :
			if ( $_moz_opts['opt_main_layout'] > 3 ) {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
				$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
			}
			else {
				$_main_width = 12 - $_moz_opts['opt_col_width_1'];
				$_side_width = $_moz_opts['opt_col_width_1'];
			}

			?>

			<div id="secondary" class="hidden-sm <?php echo ( $_moz_opts['opt_aside_wg_show'] == 1 ? '' : 'hidden-xs'); ?> widget-area col-md-<?php echo $_moz_opts['opt_col_width_1']; ?> <?php
				if( $_moz_opts['opt_main_layout'] == 2 || $_moz_opts['opt_main_layout'] == 4 || $_moz_opts['opt_main_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>

			<?php if( $_moz_opts['opt_main_layout'] > 3 ) : ?>
			</div><!-- #secondary -->
			<div id="territory" class="widget-area col-md-<?php echo $_moz_opts['opt_col_width_2']; ?> <?php
				if ( $_moz_opts['opt_main_layout'] == 5 ) {
					echo "col-md-pull-$_main_width";
				}
			?>" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php
			endif;
		endif;
	}
}	
?>