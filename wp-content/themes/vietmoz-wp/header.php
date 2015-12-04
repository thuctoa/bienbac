<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package moztheme
 */

global $_moz_opts;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!-- Moztheme Favicon -->
<link rel="icon" type="image/png" href="<?php echo $_moz_opts['opt_general_favicon']['url']; ?>">
<!-- ./Moztheme Favicon -->

<?php echo $_moz_opts['opt_general_tracking']; ?>
<?php wp_head(); ?>
<?php echo $_moz_opts['opt_general_beforehead']; ?>
</head>
<!-- Moztheme custom CSS -->
<style type="text/css" media="screen">
	::-webkit-input-placeholder {
		color: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['color']; ?>;
		font-weight: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-weight']; ?>;
		font-size: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-size']; ?>;
	}
	:-moz-placeholder {
		color: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['color']; ?>;
		font-weight: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-weight']; ?>;
		font-size: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-size']; ?>;
	}
	::-moz-placeholder {
		color: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['color']; ?>;
		font-weight: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-weight']; ?>;
		font-size: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-size']; ?>;
	}
	:-ms-input-placeholde {
		color: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['color']; ?>;
		font-weight: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-weight']; ?>;
		font-size: <?php echo $_moz_opts['opt_searchform_placeholder_typo']['font-size']; ?>;
	}
	<?php echo $_moz_opts['opt_style_custom_css']; ?>
	.nav>li.current-menu-item>a, .nav .open>a, .nav .open>a:hover {
		color: <?php echo $_moz_opts['opt_nav_link_color']['hover']; ?>;
	}
	nav#site-navigation .moztheme-nav>li>a {
		padding-top: 0;
		padding-bottom: 0;
	}
</style>
<!-- Moztheme custom CSS -->
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<?php get_template_part( 'framework/templates/headers' ); ?>

	<div id="content" class="site-content">
<?php
if( ! is_front_page() ) : //start if?>
	<div class="container">
	<div class="row">
	<div class="main-content
	<?php //start checking layout option
		if( function_exists( 'is_woocommerce' ) ) { // checking woocommerce plugins exists?
			if( is_product_category() || is_product_tag() ) {
				if ( $_moz_opts['opt_product_category_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_product_category_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_product_category_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_product_category_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_product_category_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_product_category_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_product_category_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			elseif( is_category() || is_post_type_archive() || is_tag() ) {
				if ( $_moz_opts['opt_category_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_category_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			elseif( is_product() ) {
				if ( $_moz_opts['opt_product_single_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_product_single_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_product_single_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_product_single_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_product_single_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_product_single_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_product_single_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			elseif( is_single() ) {
				if ( $_moz_opts['opt_single_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_single_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			else {
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
			}
		}
		else {
			if( is_category() || is_post_type_archive() || is_tag() ) {
				if ( $_moz_opts['opt_category_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_category_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_category_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_category_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			elseif( is_single() ) {
				if ( $_moz_opts['opt_single_layout'] > 3 ) {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'] - $_moz_opts['opt_col_width_2'];
					$_side_width = $_moz_opts['opt_col_width_1'] + $_moz_opts['opt_col_width_2'];
				}
				else {
					$_main_width = 12 - $_moz_opts['opt_col_width_1'];
					$_side_width = $_moz_opts['opt_col_width_1'];
				}
				if( $_moz_opts['opt_single_layout'] == 1 ) {
					echo "col-md-12";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 2 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 3 ) {
					echo "col-md-$_main_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 4 ) {
					echo "col-md-$_main_width col-md-push-".$_moz_opts['opt_col_width_1'];
				}
				elseif ( $_moz_opts['opt_single_layout'] == 5 ) {
					echo "col-md-$_main_width col-md-push-$_side_width";
				}
				elseif ( $_moz_opts['opt_single_layout'] == 6 ) {
					echo "col-md-$_main_width";
				}
			}
			else {
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
			}
		}
	?>">
	<div id="primary">
<?php
	if ( function_exists('yoast_breadcrumb') ) {
		if ( function_exists( 'is_woocommerce' ) ) {
			if( !is_woocommerce() ) {
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			}
		}
		else {
			yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		}
	}
endif;
?>