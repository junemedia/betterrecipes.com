<?php
/**
Plugin Name: Default HTML Skin
**/
?>


<div class="flexslider ssp_slider_default_html" id="slider_<?php echo esc_attr( $slider_id ) ?>" data-slider_id="<?php echo esc_attr( $slider_id ) ?>">

<ul class="slides ssp_slider wsp_default_skin">

<?php foreach( $slides as $slide ): ?>
  <li class="slide type_html">
    <?php if ( $slide['type'] == 'html' ): ?>
    <?php echo $slide['html']; ?>
    <?php else: ?>
    <img class="slide_image" src="<?php echo $slide['image']['url']; ?>" />
    <?php if ( $slider_settings['caption_box'] ): ?>
      <p class="flex-caption">
        <?php if ( $slider_settings['linkable'] ): ?>
          <a href="<?php echo $slide['image']['link'] ?>">
            <strong><?php echo $slide['image']['caption'] ?></strong>
          </a>
        <?php else: ?>
          <strong>
            <?php echo $slide['image']['caption'] ?>
          </strong>
        <?php endif; ?>
      </p>
    <?php endif; ?>
  <?php endif; ?>
  </li>
<?php endforeach; ?>

</ul>

</div>

<script type="text/javascript">
  
  jQuery(function ($) {
      
      $(window).load( function() {

        id = "<?php echo esc_js( $slider_id ) ?>";
        
        options = <?php echo json_encode( $slider_settings ) ?>;

        selector = $('div[data-slider_id=' + id + ' ]');

        height = options.height.replace(/[^\d.]/g, "");

        width = options.width.replace(/[^\d.]/g, "");

        if ( ! options.chrome )
          selector.addClass('ssp_no_chrome_slider_default');
        
        if ( options.h_responsive == false || options.h_responsive == '' ) {
          
          $('.slides .slide', selector).each( function() {

            if ( ! Number( height ) <= 0 )
             $(this).css( 'height', height + 'px' );

          });
          
        }

        if ( options.w_responsive == false || options.w_responsive == '' ) {
          
          if ( ! Number( width ) <= 0 )
            $( selector ).css( 'width', width + 'px' );
        
        }
        
        $(selector).flexslider( {

          smoothHeight: options.h_responsive,

          animation: options.animation,
    
          direction: options.direction,

          slideshow: options.slideshow,

          slideshowSpeed: Number( options.cycle_speed ) * 1000,

          animationSpeed: Number( options.animation_speed ) * 1000,

          pauseOnHover: options.pause_on_hover,

          controlNav: options.control_nav,

          directionNav: options.direction_nav,

          keyboard: options.keyboard_nav,

          touch: options.touch_nav

        });

      });

  });

</script>