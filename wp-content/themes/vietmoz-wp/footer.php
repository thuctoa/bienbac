<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package moztheme
 */

global $_moz_opts;

if( ! is_front_page() || is_page_template('home-ban-hang.php') ) :
	if( function_exists( 'is_woocommerce' ) ) { //checking pluign woocommerce exist?
		if( is_product_category() || is_product_tag() ) {
			if( $_moz_opts['opt_product_category_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_product_category_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		elseif( is_category() || is_post_type_archive() || is_tag() ) {
			if( $_moz_opts['opt_category_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_category_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		elseif( is_product() ) {
			if( $_moz_opts['opt_product_single_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_product_single_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		elseif( is_single() ) {
			if( $_moz_opts['opt_single_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_single_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		else {
			if( $_moz_opts['opt_main_layout'] == 1 || is_page_template( 'home-full-width.php' ) ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_main_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}
	}
	else {

		if( is_category() || is_post_type_archive() || is_tag() ) {
			if( $_moz_opts['opt_category_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_category_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		elseif( is_single() ) {
			if( $_moz_opts['opt_single_layout'] == 1 ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_single_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}

		else {
			if( $_moz_opts['opt_main_layout'] == 1 || is_page_template( 'home-full-width.php' ) ) {
				echo '</div><!-- /#primary -->';
				echo '</div><!-- /.main-content -->';
			}
			elseif( $_moz_opts['opt_main_layout'] > 3 ) {
				echo '</div><!-- #territory -->';
			}
			else {
				echo '</div><!-- #secondary -->';
			}
		}
	}

?>
	</div><!-- /.row -->
	</div><!-- /.container -->
<?php endif; ?>

	</div><!-- /#content -->

<?php if( $_moz_opts['opt_home_brand_slides_check'] == 1 ) : ?>
	<div id="brandslider">
		<div class="container"><div class="row">
		<?php foreach ($_moz_opts['opt_home_brand_slides'] as $slide ) { ?>
			<a href="<?php echo $slide['url']; ?>"><img src="<?php echo $slide['image']; ?>"></a>
		<?php } ?>
		</div></div>
	</div><!-- /#brandslider -->
	<script>
	jQuery(function($) {
		$('#brandslider .row').slick({
			slide: 'a',
			slidesToShow: <?php echo $_moz_opts['opt_home_brand_slides_to_show']; ?>,
			autoplay: true,
		    slidesToScroll: 1
		});
	});
	</script>
<?php endif; ?>

<div id="footer-padding-top">
	<div class="container">
	<?php dynamic_sidebar( 'footer-padding-top' ); ?>
	</div>
</div>
	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php if( $_moz_opts['opt_footer_nav_check'] == 1 ) : ?>
	<nav id="footer-navigation" class="clearfix hidden-xs hidden-sm" role="navigation">
		<div class="container"><div class="row">
		<?php wp_nav_menu( array( 'menu' => $_moz_opts['opt_footer_nav_select'], 'items_wrap' => '<ul id="%1$s" class="%2$s nav moztheme-ft-nav navbar-nav">%3$s</ul>', 'container' => '', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
		</div></div><!-- /.container navbar -->
	</nav><!-- #site-navigation -->
	<?php endif; ?>
		<div class="container">
		<div class="inside">
		<div class="row">
			<div class="main-footer clearfix">
				<?php
					$_ft_col_width = 12/$_moz_opts['opt_footer_layout'];
					if( $_moz_opts['opt_footer_layout'] >= 1 ) {
						echo '<div class="ft-wg-area footer-1 col-sm-6 col-md-' . $_ft_col_width .' ';
						echo $_moz_opts['opt_footer_layout'] == 1 ? 'last' : '';
						echo '">';
						if( is_active_sidebar( 'footer-1' ) ) {
							dynamic_sidebar( 'footer-1' );
						}
						else {?>
						<div class="ft-widget">
							<h3 class="widget-title">About us</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco sed do eiusmod tempor.</p>
						</div>
						<?php }
						echo '</div><!-- /.footer-1 -->';
					}
					if( $_moz_opts['opt_footer_layout'] >= 2 ) {
						echo '<div class="ft-wg-area footer-2 col-sm-6 col-md-' . $_ft_col_width .' ';
						echo $_moz_opts['opt_footer_layout'] == 2 ? 'last' : '';
						echo '">';
						if( is_active_sidebar( 'footer-2' ) ) {
							dynamic_sidebar( 'footer-2' );
						}
						else {?>
						<div class="ft-widget">
							<h3 class="widget-title">Some Links</h3>
							<ul>
								<li><a href="#">About us</a></li>
								<li><a href="#">Login</a></li>
								<li><a href="#">Contact</a></li>
								<li><a href="#">Sitemap</a></li>
							</ul>
						</div>
						<?php }
						echo '</div><!-- /.footer-2 -->';
					}
					if( $_moz_opts['opt_footer_layout'] >= 3 ) {
						echo '<div class="ft-wg-area footer-3 col-sm-6 col-md-' . $_ft_col_width .' ';
						echo $_moz_opts['opt_footer_layout'] == 3 ? 'last' : '';
						echo '">';
						if( is_active_sidebar( 'footer-3' ) ) {
							dynamic_sidebar( 'footer-3' );
						}
						else {?>
						<div class="ft-widget">
							<h3 class="widget-title">Site Links</h3>
							<ul>
								<li><a href="http://dienlanhbienbac.com">dienlanhbienbac.com</a></li>
								<li><a href="#">bienbacgroup.com</a></li>
							</ul>
						</div>
						<?php }
						echo '</div><!-- /.footer-3 -->';
					}
					if( $_moz_opts['opt_footer_layout'] >= 4 ) {
						echo '<div class="ft-wg-area footer-4 col-sm-6 col-md-' . $_ft_col_width .' ';
						echo $_moz_opts['opt_footer_layout'] == 4 ? 'last' : '';
						echo '">';
						if( is_active_sidebar( 'footer-4' ) ) {
							dynamic_sidebar( 'footer-4' );
						}
						else {?>
						<div class="ft-widget">
							<h3 class="widget-title">Contact</h3>
							<ul>
								<li><i class="fa fa-home"></i> <span> No.735 Phuc Dien St., Nam Tu Liem, Ha Noi, VN</span></li>
								<li><i class="fa fa-phone"></i> (+84) 046 2543 777</li>
								<li><i class="fa fa-envelope"></i> dienlanhbienbac@gmail.com</li>
								<li><i class="fa fa-globe"></i> BienBacGroup.com</li>
							</ul>
						</div>
						<?php }
						echo '</div><!-- /.footer-4 -->';
					}
				?>
			</div>
			<div id="footer-padding-bottom" class="clearfix">
				<?php dynamic_sidebar( 'footer-padding-bottom' ); ?>
			</div>
		</div>
		</div><!-- .inside -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
	<div class="site-info">
		<div class="container">
		<div class="inside">
		<?php if( is_front_page() ) : ?>
			<?php printf( __( '&copy; %1$s %2$s. Thiết kế Website bởi %3$s.', 'moztheme' ), get_the_date('Y' ), get_bloginfo( 'name' ), '<a href="http://vietmoz.com" rel="nofollow">VietMoz</a>' ); ?>
		<?php else: ?>
			<?php printf( __( '&copy; %1$s %2$s. Thiết kế Website bởi %3$s.', 'moztheme' ), get_the_date('Y' ), get_bloginfo( 'name' ), 'VietMoz' ); ?>
		<?php endif; ?>
		</div>
		</div>
	</div><!-- .site-info -->
</div><!-- #page -->

<?php wp_footer(); ?>
<?php echo $_moz_opts['opt_general_beforebody']; ?>
<?php if( $_moz_opts['opt_genera_enable_fb'] == 1 ) : ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>
</body>
</html>
