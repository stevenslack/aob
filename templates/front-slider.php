<?php
/**
 * Front Page Slider support by the soliloquy slider
 */

// get the slider ID from the theme customizer selection
$slider_id = get_theme_mod( 'select_slider' );

// if soliloquy is activated and the slider is set display the slider
if ( function_exists( 'soliloquy' ) && ! empty( $slider_id ) ) : ?>
    <div id="main-slider" class="aob-slider-container"><span class="overlay"></span><?php soliloquy( intval( $slider_id ) ); ?></div><!-- /.aob-slider-container -->
<?php endif; // end if soliloquy is installed


