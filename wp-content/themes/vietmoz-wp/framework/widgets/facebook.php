<?php
/**
 * Wordpress Post slider Widget using Slick carousel.
 *
 * @package MOz Theme
 */

class moztheme_likebox_widget extends WP_Widget {
	/* Constructor functions */
	function moztheme_likebox_widget() {
		parent::WP_Widget( false, $name = 'Moztheme Likebox' );
	}

	/** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );

	// these are our widget options
    $title = apply_filters('widget_title', $instance['title']);
	$fanpageurl = $instance['fanpageurl'];
	$boxwidth = $instance['boxwidth'];
	$boxheight = $instance['boxheight'];
	$showfriend = $instance['showfriend'];
	$showfriend == 1 ? $showfriend = 'true' : $showfriend = 'false';
	$hidecover = $instance['hidecover'];
	$hidecover == 1 ? $hidecover = 'true' : $hidecover = 'false';
	$showposts = $instance['showposts'];
	$showposts == 1 ? $showposts = 'true' : $showposts = 'false';

	echo '<div class="hidden-xs hidden-sm">';

    echo $before_widget;

	if ( $title ) {
	echo $before_title . $title . $after_title;
	}
	?>
	<div id="likebox" style="width: <?php echo $boxwidth; ?>px; overflow-x: hidden;">
		<div class="fb-page" data-href="<?php echo $fanpageurl; ?>" data-hide-cover="<?php echo $hidecover; ?>" data-show-facepile="<?php echo $showfriend; ?>" data-show-posts="<?php echo $showposts; ?>" data-width="<?php echo $boxwidth; ?>" data-height="<?php $boxheight; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $fanpageurl; ?>"><a href="<?php echo $fanpageurl; ?>">Facebook</a></blockquote></div></div>
	</div>
	<?php
	echo $after_widget;
	echo '</div>';
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['fanpageurl'] = strip_tags($new_instance['fanpageurl']);
	$instance['boxwidth'] = strip_tags($new_instance['boxwidth']);
	$instance['boxheight'] = strip_tags($new_instance['boxheight']);
	$instance['showfriend'] = strip_tags($new_instance['showfriend']);
	$instance['hidecover'] = strip_tags($new_instance['hidecover']);
	$instance['showposts'] = strip_tags($new_instance['showposts']);
    return $instance;
    }

 /** @see WP_Widget::form */
function form($instance) {	

    $title = esc_attr($instance['title']);
	$fanpageurl = esc_attr($instance['fanpageurl']);
	$boxwidth = esc_attr($instance['boxwidth']);
	$boxheight = esc_attr($instance['boxheight']);
	$showfriend = esc_attr($instance['showfriend']);
	$hidecover = esc_attr($instance['hidecover']);
	$showposts = esc_attr($instance['showposts']);
    ?>

	 <p>
      	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

     <p>
      	<label for="<?php echo $this->get_field_id('fanpageurl'); ?>"><?php _e('Fanpage URL'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('fanpageurl'); ?>" name="<?php echo $this->get_field_name('fanpageurl'); ?>" type="text" value="<?php echo $fanpageurl; ?>" />
    </p>

    <p>
    	<label for="<?php echo $this->get_field_id('boxwidth'); ?>"><?php _e('Width:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('boxwidth'); ?>" name="<?php echo $this->get_field_name('boxwidth'); ?>" type="text" value="<?php echo $boxwidth; ?>" placeholder="Min. 280 to Max. 500"/>
    </p>

    <p>
    	<label for="<?php echo $this->get_field_id('boxheight'); ?>"><?php _e('Height:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('boxheight'); ?>" name="<?php echo $this->get_field_name('boxheight'); ?>" type="text" value="<?php echo $boxheight; ?>" placeholder"Min. 130"/>
    </p>

	<p>
      	<input id="<?php echo $this->get_field_id('showfriend'); ?>" name="<?php echo $this->get_field_name('showfriend'); ?>" type="checkbox" value="1" <?php checked( '1', $showfriend ); ?>/>
    	<label for="<?php echo $this->get_field_id('showfriend'); ?>"><?php _e('Show Friends Faces?'); ?></label>
    </p>

	<p>
      	<input id="<?php echo $this->get_field_id('hidecover'); ?>" name="<?php echo $this->get_field_name('hidecover'); ?>" type="checkbox" value="1" <?php checked( '1', $hidecover ); ?>/>
    	<label for="<?php echo $this->get_field_id('hidecover'); ?>"><?php _e('Hide Cover Photo?'); ?></label>
    </p>

	<p>
      	<input id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="checkbox" value="1" <?php checked( '1', $showposts ); ?>/>
    	<label for="<?php echo $this->get_field_id('showposts'); ?>"><?php _e('Show Posts?'); ?></label>
    </p>

    <?php
}


}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("moztheme_likebox_widget");'));