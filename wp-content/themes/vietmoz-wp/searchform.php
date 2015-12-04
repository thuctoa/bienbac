<?php global $_moz_opts; ?>
<form role="search" method="get" class="search-form clearfix sf-v1" action="<?php echo home_url( '/' ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo sprintf( esc_attr_x( '%s', 'placeholder' ), $_moz_opts['opt_searchform_placeholder'] ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	<input type="submit" class="search-submit fa" value="<?php echo sprintf( esc_attr_x( '%s', 'submit button' ), '&#xf002;' ); ?>" />
</form>