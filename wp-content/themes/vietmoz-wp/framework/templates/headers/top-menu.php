<?php global $_moz_opts; ?>
<?php if ( ! empty ($_moz_opts['opt_topbar_menu_left']) || ! empty ($_moz_opts['opt_topbar_menu_right']) ) : ?>
<nav class="navbar topbar">
	<div class="container"><div class="row">
	<div class="col-xs-12">
		<?php if ( ! empty ($_moz_opts['opt_topbar_menu_left']) ) : ?>
		<?php wp_nav_menu( array( 'menu' => $_moz_opts['opt_topbar_menu_left'], 'items_wrap' => '<ul id="%1$s" class="%2$s nav navbar-nav">%3$s</ul>', 'container' => '' ) ); ?>
		<?php endif; ?>

		<?php if ( ! empty ($_moz_opts['opt_topbar_menu_right']) ) : ?>
		<?php wp_nav_menu( array( 'menu' => $_moz_opts['opt_topbar_menu_right'], 'items_wrap' => '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>', 'container' => '' ) ); ?>
		<?php endif; ?>
	</div></div></div>	
</nav>
<?php endif; ?>