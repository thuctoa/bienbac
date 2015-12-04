<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package moztheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php the_tags( '<div class="entry-meta"><span><i class="fa fa-tags"></i>Tags:</span><span class="tag-links">', '', '</span></div>' ); ?>

	<footer class="entry-footer">
		<?php _moz_like(); ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->
