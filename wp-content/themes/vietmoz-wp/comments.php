<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to _moz_comment() which is
 * located in the includes/template-tags.php file.
 *
 * @package _moz
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

		<h2 class="comments-title">
			<?php $fbcmt = fb_comment_count(); ?>
			<?php
				printf( _nx( '<span>Ý kiến bạn đọc</span>', '<span>Ý kiến bạn đọc (%1$s)</span>', get_comments_number(), 'comments title', '_moz' ),
					number_format_i18n( get_comments_number() + $fbcmt ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
	<?php if ( have_comments() ) : ?>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h5 class="screen-reader-text"><?php _e( 'Comment navigation', '_moz' ); ?></h5>
			<ul class="pager">
				<li class="nav-previous"><?php previous_comments_link( __( '&larr; Bình luận cũ hơn', '_moz' ) ); ?></li>
				<li class="nav-next"><?php next_comments_link( __( 'Bình luận mới hơn &rarr;', '_moz' ) ); ?></li>
			</ul>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ul class="comment-list moz-comment">
			<?php
				wp_list_comments( array( 'callback' => '_moz_comment', 'avatar_size' => 50 ) );
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', '_moz' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Bình luận cũ hơn', '_moz' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Bình luận mới hơn &rarr;', '_moz' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Bình luận bị khóa.', '_moz' ); ?></p>
	<?php endif; ?>

	<?php comment_form( $args = array(
			  'id_form'           => 'commentform',  // that's the wordpress default value! delete it or edit it ;)
			  'id_submit'         => 'commentsubmit',
			  'title_reply'       => '',  // that's the wordpress default value! delete it or edit it ;)
			  'title_reply_to'    => __( 'Bình luận về %s' ),  // that's the wordpress default value! delete it or edit it ;)
			  'cancel_reply_link' => __( 'Hủy' ),  // that's the wordpress default value! delete it or edit it ;)
			  'label_submit'      => __( 'Gửi' ),  // that's the wordpress default value! delete it or edit it ;)
			
			  'comment_field' =>  '<p style="width: 100%; float: left;"><textarea placeholder="Ý kiến của bạn.." id="comment" class="form-control" name="comment" cols="45" rows="3" aria-required="true"></textarea></p>', 
			  'comment_notes_before' => '',
			  'comment_notes_after' => '',
				'fields' => apply_filters( 'comment_form_default_fields', array(

					'author' =>
					  '<p class="comment-form-author">' .
					  '<label for="author">' . __( 'Họ tên', 'domainreference' ) .
					  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					  '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					  '" size="30"' . $aria_req . ' /></p>',

					'email' =>
					  '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) .
					  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					  '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					  '" size="30"' . $aria_req . ' /></p>',

					'url' =>''
				))
			  //<p class="form-allowed-tags">' . __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:' ) . '</p><div class="alert alert-info">' . allowed_tags() . '</div>

			  // So, that was the needed stuff to have bootstrap basic styles for the form elements and buttons 

			  // Basically you can edit everything here! 
			  // Checkout the docs for more: http://codex.wordpress.org/Function_Reference/comment_form
			  // Another note: some classes are added in the bootstrap-wp.js - ckeck from line 1 
			  
	)); 
	
	?>

</div><!-- #comments -->
