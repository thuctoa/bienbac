<?php
/**
 * Wordpress Post slider Widget using Slick carousel.
 *
 * @package MOz Theme
 */

class moztheme_singlepost_widget extends WP_Widget {
	/* Constructor functions */
	function moztheme_singlepost_widget() {
		parent::WP_Widget( false, $name = 'Moztheme Single Post Widget' );
	}

	/** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );

	// these are our widget options
    $title = apply_filters('widget_title', $instance['title']);
	$posturl = $instance['posturl'];
	$length = $instance['length'];
	$posttype = $instance['posttype'];
	$heading = $instance['heading'];
	$showthumb = $instance['showthumb'];
    echo $before_widget;
    
	$singlepost = get_page_by_path( $posturl, OBJECT, $posttype );
	?>
	<div class="moztheme-single-post-widget">
		<<?php echo $heading; ?> class="singlepost-title">
			<a href="<?php echo get_permalink( $singlepost->ID ); ?>" title="<?php echo $singlepost->post_title; ?>">
				<?php echo $title; ?>
			</a>
		</<?php echo $heading; ?>>
		<?php if( $showthumb == 1 ): ?>
			<?php //Post Thumbnail
			$thumb_id = get_post_thumbnail_id( $singlepost->ID );
			$thumb_url = wp_get_attachment_image_src($thumb_id,'medium', true);
			?>
			<a href="<?php echo get_permalink( $singlepost->ID ); ?>" title="<?php echo $singlepost->post_title; ?>" class="singlepost-thumb">
				<img src="<?php echo $thumb_url['0']; ?>" alt="<?php echo $singlepost->post_title; ?>" />
			</a>
		<?php endif; ?>
		<div class="singlepost-excerpt">
			<?php echo wp_trim_words( $singlepost->post_content, $length ); ?>
		</div>
	</div>
	<?php
	echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['posturl'] = strip_tags($new_instance['posturl']);
	$instance['length'] = strip_tags($new_instance['length']);
	$instance['posttype'] = strip_tags($new_instance['posttype']);
	$instance['heading'] = strip_tags($new_instance['heading']);
	$instance['showthumb'] = strip_tags($new_instance['showthumb']);
    return $instance;
    }

 /** @see WP_Widget::form */
function form($instance) {	

    $title = esc_attr($instance['title']);
	$posturl = esc_attr($instance['posturl']);
	$length = esc_attr($instance['length']);
	$posttype = esc_attr($instance['posttype']);
	$heading = esc_attr($instance['heading']);
	$showthumb = esc_attr($instance['showthumb']);
    ?>

	 <p>
      	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

     <p>
      	<label for="<?php echo $this->get_field_id('posturl'); ?>"><?php _e('Post/Page URL'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('posturl'); ?>" name="<?php echo $this->get_field_name('posturl'); ?>" type="text" value="<?php echo $posturl; ?>" />
    </p>

    <p>
    	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt Length:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" value="<?php echo $length; ?>" />
    </p>

    <p>
    	<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e('Postype:'); ?></label>

		<select name="<?php echo $this->get_field_name('posttype'); ?>" id="<?php echo $this->get_field_id('posttype'); ?>" class="widefat">
			<option value="post" <?php echo $posttype == 'post' ? 'selected="selected"' : ''; ?>>Post</option>
			<option value="page" <?php echo $posttype == 'page' ? 'selected="selected"' : ''; ?>>Page</option>
		</select>
    </p>

    <p>
    	<label for="<?php echo $this->get_field_id('heading'); ?>"><?php _e('Heading:'); ?></label>

		<select name="<?php echo $this->get_field_name('heading'); ?>" id="<?php echo $this->get_field_id('heading'); ?>" class="widefat">
			<option value="h1" <?php echo $heading == 'h1' ? 'selected="selected"' : ''; ?>>H1</option>
			<option value="h2" <?php echo $heading == 'h2' ? 'selected="selected"' : ''; ?>>H2</option>
			<option value="h3" <?php echo $heading == 'h3' ? 'selected="selected"' : ''; ?>>H3</option>
			<option value="h4" <?php echo $heading == 'h4' ? 'selected="selected"' : ''; ?>>H4</option>
			<option value="h5" <?php echo $heading == 'h5' ? 'selected="selected"' : ''; ?>>H5</option>
			<option value="h6" <?php echo $heading == 'h6' ? 'selected="selected"' : ''; ?>>H6</option>
		</select>
    </p>

	<p>
      	<input id="<?php echo $this->get_field_id('showthumb'); ?>" name="<?php echo $this->get_field_name('showthumb'); ?>" type="checkbox" value="1" <?php checked( '1', $showthumb ); ?>/>
    	<label for="<?php echo $this->get_field_id('showthumb'); ?>"><?php _e('Show Thumbnail?'); ?></label>
    </p>

    <?php
}


}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("moztheme_singlepost_widget");'));