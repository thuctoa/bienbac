
<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
	<div class="container">
	<div class="clearfix navinside">
	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '<ul id="%1$s" class="%2$s moztheme-nav nav navbar-nav">%3$s</ul>', 'container' => 'div', 'container_class' => 'collapse navbar-collapse', 'container_id' => 'main-nav', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
	</div><!-- /.row -->
	</div><!-- /.container navbar -->
</nav><!-- #site-navigation -->