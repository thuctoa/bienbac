<?php global $_moz_opts;
if( $_moz_opts['opt_header_layout'] == '3') {
	get_template_part( 'framework/templates/headers/header_v3' );
}
elseif( $_moz_opts['opt_header_layout'] == '4') {
	get_template_part( 'framework/templates/headers/header_v4' );
}
else {
	get_template_part( 'framework/templates/headers/header_v1' );
}