<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package moztheme
 */

global $_moz_opts;

if ( ! function_exists( 'moztheme_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function moztheme_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'moztheme' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'moztheme' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'moztheme' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'moztheme_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function moztheme_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'moztheme' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'moztheme' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'moztheme_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function moztheme_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'd/m/y' ) )
	);

	$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);
	$cmt_num = get_comments_number( '0', '1', '%' );

	$author = '<span class=”vcard author”><span class=”fn”>'. get_the_author() .'</span></span>';

	printf( __( '<span class="posted-on"><i class="fa fa-calendar"></i> %1$s - <i class="fa fa-comments"></i> %2$d - <i class="fa fa-user"></i> %3$s</span>', 'moztheme' ),
		$time_string,
		$cmt_num,
		$author
	);

}
endif;

if ( ! function_exists( 'moztheme_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function moztheme_entry_footer() {
	// Hide category and tag text for pages.
	// if ( 'post' == get_post_type() ) {
	// 	/* translators: used between list items, there is a space after the comma */
	// 	$categories_list = get_the_category_list( __( ', ', 'moztheme' ) );
	// 	if ( $categories_list && moztheme_categorized_blog() ) {
	// 		printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'moztheme' ) . '</span>', $categories_list );
	// 	}

	// 	/* translators: used between list items, there is a space after the comma */
	// 	$tags_list = get_the_tag_list( '', __( ', ', 'moztheme' ) );
	// 	if ( $tags_list ) {
	// 		printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'moztheme' ) . '</span>', $tags_list );
	// 	}
	// }

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'moztheme' ), __( '1 Comment', 'moztheme' ), __( '% Comments', 'moztheme' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'moztheme' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function moztheme_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'moztheme_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'moztheme_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so moztheme_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so moztheme_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in moztheme_categorized_blog.
 */
function moztheme_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'moztheme_categories' );
}
add_action( 'edit_category', 'moztheme_category_transient_flusher' );
add_action( 'save_post',     'moztheme_category_transient_flusher' );


// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
if( ! function_exists( 'moztheme_pagination') ) :
function moztheme_pagination()
{
    global $wp_query;
    $big = 999999999; // need an unlikely integer
    $pages = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_next' => false,
            'type'  => 'array',
            'prev_next'   => TRUE,
			'prev_text'    => __('«'),
			'next_text'    => __('»'),
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<ul class="moztheme-pagination pagination">';
            foreach ( $pages as $page ) {
                    echo "<li>$page</li>";
            }
           echo '</ul>';
        }
}

endif;

if( ! function_exists( '_moz_like') ) :
function _moz_like() {
  ?>
  <ul class="_moz_like clearfix">
    <li><iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px; width:140px;" allowTransparency="true"></iframe></li>
    <li><iframe allowtransparency="true" text="<?php the_title(); ?>" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/tweet_button.html?url=<?php the_permalink(); ?>" style="width:80px; height:20px;"></iframe></li>
    <li><iframe src="https://apis.google.com/u/0/se/0/_/+1/fastbutton?usegapi=1&amp;size=medium&amp;hl=vi&amp;origin=<?php home_url( '/' ); ?>&amp;url=<?php the_permalink(); ?>" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" style="border:0;width:70px;height:20px;"></iframe></li>
  </ul>
  <?php
}
endif;
if( ! function_exists( '_moz_social_sharing') ) :
function _moz_social_sharing( $class = NULL ) {
  $_tags = get_tags();
  $_taglist = '';
  foreach ( $_tags as $tag ) {
    $_taglist = $_taglist.$tag->name.',';
  }
  $_taglist = str_replace( ' ', '', $_taglist);
  if ( has_post_thumbnail() ) {
    $_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
  }
  ?>
  <ul class="no-print _moz_sharing <?php echo $class; ?>">
    <li class="fb"><a href="#" onclick="window.open('https://www.facebook.com/dialog/share?display=popup&href=<?php the_permalink(); ?>&redirect_uri=http://mask2go.vn/fbshare', 'newwindow', 'width=555, height=333, left=200'); return false;"><i class="fa fa-facebook"></i></a></li>
    <li class="tw"><a href="#" onclick="window.open('http://twitter.com/share?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&hashtags=<?php echo $_taglist; ?>', 'newwindow', 'width=555, height=333, left=200'); return false;"><i class="fa fa-twitter"></i></a></li>
    <li class="gg"><a href="#" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>', 'newwindow', 'width=555, height=333, left=200'); return false;"><i class="fa fa-google-plus"></i></a></li>
    <li class="pt"><a href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $_image_url[0]; ?>&description=<?php echo get_the_excerpt(); ?>', 'newwindow', 'width=555, height=333, left=200'); return false;"><i class="fa fa-pinterest"></i></a></li>
    <li class="print"><a href="javascript:if(window.print)window.print()"><i class="fa fa-print"></i></a></li>
  </ul>
  <?php
}
endif;

if( ! function_exists( '_moz_slider' ) ) :
	function _moz_slider() {
		include get_template_directory() . '/framework/templates/slider.php';
	}
endif;

if( ! function_exists( '_moz_logo' ) ) :
	function _moz_logo() {
		include get_template_directory() . '/framework/templates/headers/logo.php';
	}
endif;

if( ! function_exists( '_moz_top_menu' ) ) :
	function _moz_top_menu() {
		include get_template_directory() . '/framework/templates/headers/top-menu.php';
	}
endif;

if( ! function_exists( '_moz_nav' ) ) :
	function _moz_nav() {
		include get_template_directory() . '/framework/templates/headers/nav.php';
	}
endif;

if( ! function_exists( '_moz_float_ads' ) ) :
	function _moz_float_ads() {
		include get_template_directory() . '/framework/ads.php';
	}
	if( $_moz_opts[ 'opt_ads_floating' ] == 1 ) {
		add_action('wp_footer', '_moz_float_ads');
	}
endif;


if ( ! function_exists( '_moz_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function _moz_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', '_moz' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', '_moz' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body media">
			<a class="pull-left" href="#">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</a>

			<div class="media-body">
				<div class="media-body-wrap panel panel-default">

					<div class="panel-heading">
						<h5 class="media-heading">
							<?php printf( __( '%s', '_moz' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
							<span class="comment-meta">
								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
									<time datetime="<?php comment_time( 'c' ); ?>">
										<?php
										printf( _x( '%1$s - %2$s', '1: date, 2: time', '_moz' ), get_comment_date(), get_comment_time() );
										?>
									</time>
								</a>
								<?php edit_comment_link( __( '<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', '_moz' ), '<span class="edit-link">', '</span>' ); ?>
							</span>
						</h5>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', '_moz' ); ?></p>
					<?php endif; ?>

					<div class="comment-content panel-body">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php comment_reply_link(
						array_merge(
							$args, array(
								'add_below' => 'div-comment',
								'depth' 	=> $depth,
								'max_depth' => $args['max_depth'],
								'before' 	=> '<footer class="reply comment-reply panel-footer">',
								'after' 	=> '</footer><!-- .reply -->'
							)
						)
					); ?>

				</div>
			</div><!-- .media-body -->

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for _moz_comment()