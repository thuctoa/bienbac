<?php global $_moz_opts; ?>
<div class="sslider">
<?php foreach ($_moz_opts['opt_home_slides'] as $slide ) { ?>
	<a href="<?php echo $slide['url']; ?>">
		<img src="<?php echo $slide['image']; ?>">
		<?php if( $slide['title'] ) : ?>
		<div class="info hidden-xs hidden-sm">
			<h3><?php echo $slide['title']; ?></h3>
			<p><?php echo $slide['description']; ?></p>
		</div>
		<?php endif; ?>
	</a>
<?php } ?>
</div>