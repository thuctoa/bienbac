<?php
/**
 * Wordpress Post slider Widget using Slick carousel.
 *
 * @package MOz Theme
 */

class moztheme_categoryposts_widget extends WP_Widget {
	/* Constructor functions */
	function moztheme_categoryposts_widget() {
		parent::WP_Widget( false, $name = 'Moztheme Category Posts Widget' );
	}

	/** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );

	// these are our widget options
    $title = apply_filters('widget_title', $instance['title']);
	$catsl = $instance['catsl'];
	$postnumber = $instance['postnumber'];
	$thumbcheck = $instance['thumbcheck'];
	$bexcerptlength = $instance['bexcerptlength'];
	$sexcerptlength = $instance['sexcerptlength'];

    echo $before_widget;

	if ( $title ) {
	echo $before_title .'<a href="'. get_category_link( $catsl ) .'"><span>'. $title .'</span></a>'. $after_title;
	}
	?>
	<div class="newsblock row">
	<?php
	// Start the Loop.
	$args = array(
	'order'    => 'DESC',
	'posts_per_page' => $postnumber,
	'cat' => $catsl
	);             
	$the_query = new WP_Query( $args );
	if($the_query->have_posts() ) :
		$c = 0;
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$c++;
			if( $c == 1 ) :
			?>
			<div class="featured col-xs-5">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
				<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<p><?php echo wp_trim_words( get_the_excerpt(), $bexcerptlength ); ?></p>
			</div>
			<ul class="newsblock-small col-xs-7 nogutter"> 
			<?php
			else : ?>
				<li class="clearfix">
					<?php if( $thumbcheck == 1 ) { ?><div class="col-xs-4 nogutter"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div><?php } ?>
					<?php if( $thumbcheck == 1 ) { ?><div class="col-xs-8 info"><?php } else { ?><div class="info"><?php } ?>
						<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo wp_trim_words( get_the_excerpt(), $sexcerptlength ); ?></p>
					</div>
				</li>	
			<?php endif;
		endwhile;
		?>
			</ul>
		<?php
	endif;
	?>
	</div>
	<?php
	echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['catsl'] = strip_tags($new_instance['catsl']);
	$instance['postnumber'] = strip_tags($new_instance['postnumber']);
	$instance['thumbcheck'] = strip_tags($new_instance['thumbcheck']);
	$instance['bexcerptlength'] = strip_tags($new_instance['bexcerptlength']);
	$instance['sexcerptlength'] = strip_tags($new_instance['sexcerptlength']);
    return $instance;
    }

 /** @see WP_Widget::form */
function form($instance) {	

    $title = esc_attr($instance['title']);
	$catsl = esc_attr($instance['catsl']);
	$postnumber = esc_attr($instance['postnumber']);
	$thumbcheck = esc_attr($instance['thumbcheck']);
	$bexcerptlength = esc_attr($instance['bexcerptlength']);
	$sexcerptlength = esc_attr($instance['sexcerptlength']);
    ?>

	 <p>
      	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

	<p>
		<label for="<?php echo $this->get_field_id('catsl'); ?>"><?php _e('Category'); ?></label>
		<select name="<?php echo $this->get_field_name('catsl'); ?>" id="<?php echo $this->get_field_id('catsl'); ?>" class="widefat">
		<?php 
			$categories = get_categories(); 
			foreach ($categories as $category) {
				$option = '<option value="'.$category->cat_ID.'"';
				if ($catsl == $category->cat_ID) {
					$option .= ' selected="selected"';
				}
				$option .= '>';
				$option .= $category->cat_name;
				$option .= ' ('.$category->category_count.')';
				$option .= '</option>';
				echo $option;
			}
		?>
		</select>
	</p>

     <p>
      	<label for="<?php echo $this->get_field_id('postnumber'); ?>"><?php _e('Number of Post:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('postnumber'); ?>" name="<?php echo $this->get_field_name('postnumber'); ?>" type="text" value="<?php echo $postnumber; ?>" />
    </p>

     <p>
      	<label for="<?php echo $this->get_field_id('bexcerptlength'); ?>"><?php _e('Featured Excerpt Length:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('bexcerptlength'); ?>" name="<?php echo $this->get_field_name('bexcerptlength'); ?>" type="text" value="<?php echo $bexcerptlength; ?>" />
    </p>

     <p>
      	<label for="<?php echo $this->get_field_id('sexcerptlength'); ?>"><?php _e('Small Post Excerpt Length:'); ?></label>
      	<input class="widefat" id="<?php echo $this->get_field_id('sexcerptlength'); ?>" name="<?php echo $this->get_field_name('sexcerptlength'); ?>" type="text" value="<?php echo $sexcerptlength; ?>" />
    </p>

	<p>
      	<input id="<?php echo $this->get_field_id('thumbcheck'); ?>" name="<?php echo $this->get_field_name('thumbcheck'); ?>" type="checkbox" value="1" <?php checked( '1', $thumbcheck ); ?>/>
    	<label for="<?php echo $this->get_field_id('thumbcheck'); ?>"><?php _e('Display thumbnail for small Post?'); ?></label>
    </p>

    <?php
}


}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("moztheme_categoryposts_widget");'));