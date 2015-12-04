<?php
/**
 * @package moztheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php if ( 'post' == get_post_type() ) : ?>
	<div class="entry-meta">
		<?php moztheme_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<p class="entry-content">
		<?php
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'archive-thumb', true);
		if( $thumb_id ) :
		?>
			<img class="excerpt-img" src="<?php echo $thumb_url['0']; ?>" alt="<?php the_title(); ?>" />
		<?php
		endif;
		echo get_the_excerpt();
		?>
	</p><!-- .entry-content -->
</article><!-- #post-## -->
