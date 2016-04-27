<?php
/**
 * Front Page Slider support by the soliloquy slider
 */

// get the slider ID from the theme customizer selection
$slider_id    = get_theme_mod( 'select_slider' );
$display_text = aob_get_var( 'display_text' );

$class = ( 'on' === $display_text ) ? ' hero-text' : '';

// if soliloquy is activated and the slider is set display the slider
if ( function_exists( 'soliloquy' ) && ! empty( $slider_id ) ) : ?>
    <div id="main-slider" class="aob-slider-container<?php echo esc_attr( $class ); ?>">
    	<?php soliloquy( intval( $slider_id ) ); ?>
    	<?php aob_get_template_part( 'templates/logo' ); ?>
    	<?php if ( ! empty( $display_text ) ) : ?>
    		<?php aob_get_template_part( 'templates/banner-text', array( 'logo_display' => false ) ); ?>
		<?php endif; ?>
    </div><!-- /.aob-slider-container -->
<?php endif; // end if soliloquy is installed


