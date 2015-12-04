<?php global $_moz_opts; ?>
	<header id="masthead" class="site-header header-v3" role="banner">
		<?php _moz_top_menu(); ?>
		<div class="container">
			<div class="row">
				<div class="site-branding col-sm-3">
					<div class="site-title clearfix">
						<?php _moz_logo(); ?>
					</div>
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				</div>
				<?php
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if( is_plugin_active( 'yith-woocommerce-ajax-search/init.php' ) ) : ?>
				<div class="top-search col-xs-12 visible-xs">
					<?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?> 
				</div>
				<?php else: ?>
				<div class="top-search col-xs-12 visible-xs">
					<?php get_search_form(); ?>
				</div>
				<?php endif; ?>
				<div class="col-sm-9">
				<?php _moz_nav(); ?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</header><!-- #masthead -->
	<?php if( is_front_page() && $_moz_opts['opt_home_slides_check'] == 1 ) : ?>
		<div id="home-slider" class="cleafix">
			<div class="container">
				<?php _moz_slider(); ?>
			</div>
		</div>
	<?php endif; ?>