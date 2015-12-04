<?php global $_moz_opts; ?>
	<header id="masthead" class="site-header header-v1" role="banner">
		<?php _moz_top_menu(); ?>
		<div class="container">
			<div class="site-branding row">
				<div class="site-title clearfix text-center">
					<?php _moz_logo(); ?>
				    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				    </button>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
	<?php _moz_nav(); ?>
	<?php if( is_front_page() && $_moz_opts['opt_home_slides_check'] == 1 ) : ?>
		<div id="home-slider" class="cleafix">
			<div class="container">
				<?php _moz_slider(); ?>
			</div>
		</div>
	<?php endif; ?>