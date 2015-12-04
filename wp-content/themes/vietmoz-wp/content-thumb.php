<?php
/**
 * @package moztheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail', true);
		if( $thumb_id ) :
		?>
			<img class="excerpt-img" src="<?php echo $thumb_url['0']; ?>" alt="<?php the_title(); ?>" />
		<?php
		endif; ?>

	<p class="entry-content">
		<?php
		the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );

		echo get_the_excerpt();
		?>
	</p><!-- .entry-content -->
</article><!-- #post-## -->
