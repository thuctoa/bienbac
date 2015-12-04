<?php global $_moz_opts; ?>
<div class="logo type-<?php echo $_moz_opts['opt_logo_type']; ?>">
<?php if( $_moz_opts['opt_logo_type'] == 2 ): ?>
	<?php if( is_front_page() ) : ?>
		<h1>
		<a class="img" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php echo $_moz_opts['opt_logo_img']['url'] ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" />
		</a>
		</h1>
	<?php else: ?>
		<a class="img" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php echo $_moz_opts['opt_logo_img']['url'] ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" />
		</a>
	<?php endif; ?>
<?php elseif( $_moz_opts['opt_logo_type'] == 3 ): ?>
	<a class="img" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php echo $_moz_opts['opt_logo_img']['url'] ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" />
	</a>
	<div class="brand">
		<?php if( is_front_page() ) : ?>
		<h1>
		<a class="text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php echo $_moz_opts['opt_logo_text']; ?>
		</a>
		</h1>
		<?php else: ?>
		<a class="text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php echo $_moz_opts['opt_logo_text']; ?>
		</a>
		<?php endif; ?>
		<?php if( $_moz_opts['opt_logo_slogan'] ) : ?>
		<p class="slogan">
			<?php echo $_moz_opts['opt_logo_slogan']; ?>
		</p>
		<?php endif; ?>
	</div>
<?php else: ?>
	<?php if( is_front_page() ) : ?>
	<h1>
	<a class="text"> href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<?php echo $_moz_opts['opt_logo_text']; ?>
	</a>
	</h1>
	<?php else: ?>
	<a class="text"> href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<?php echo $_moz_opts['opt_logo_text']; ?>
	</a>
	<?php endif; ?>
<?php endif; ?>
</div><!-- /.logo -->