<?php
function shortcode_accordion( $args, $content ) {
    ob_start(); ?>
    <div class="panel-group moz-accordion" id="accordion" role="tablist" aria-multiselectable="true">
        <?php echo do_shortcode( $content ); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'accordion', 'shortcode_accordion' );

function shortcode_accordion_item( $args) {
    ob_start();
      $length = 8;
      $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $acc_id = 'accordion-'.substr( str_shuffle( $chars ), 0, $length );
      $head_id = 'heading-'.substr( str_shuffle( $chars ), 0, $length );
      ?>

      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="<?php echo $head_id; ?>">
          <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $acc_id; ?>" aria-expanded="true" aria-controls="<?php echo $acc_id; ?>" class="collapsed"><?php echo $args['tieude']; ?></a>
        </div>
        <div id="<?php echo $acc_id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $head_id; ?>">
          <div class="panel-body"><?php echo $args['noidung']; ?></div>
        </div>
      </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'accordion_item', 'shortcode_accordion_item' );