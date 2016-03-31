<?php
/**
 * Banner Image Functions
 */

/**
 * Get Images Object
 *
 * @param  int    $post_thumbnail_id the post thumbnail ID
 * @return array
 */
function aob_get_images( $post_thumbnail_id ) {

    $img_sizes = array(
        'image_4' => 500,
        'image_3' => 800,
        'image_2' => 1100,
        'image_1' => 1400
    );

    $images = array();

    /**
     * grab the URL for each image size and store in a variable
     * http://codex.wordpress.org/Function_Reference/wp_get_attachment_image_src
     */
    foreach ( $img_sizes as $image => $width ) {
        ${ 'img_' . $image } = wp_get_attachment_image_src( $post_thumbnail_id, $image );
    }
    // create images object
    $images = array( $img_image_4, $img_image_3, $img_image_2, $img_image_1 );

    return $images;
}

/**
 * Calculate the slope
 * @param  array $image_object array of image objects
 * @return array
 */
function aob_the_slope( $image_object ) {

    if ( ! $image_object ) {
        return;
    }

    $slope = '';
    /**
     * Fluid aspect ratio
     *
     * http://voormedia.com/blog/2012/11/responsive-background-images-with-fixed-or-fluid-aspect-ratios
     *
     * The slope of the line corresponds to the padding-top attribute.
     * The start height corresponds to the min-height attribute.
     *
     * height(largest) - height(smallest) / width(largest) - width(smallest)
     */
    $slope = ( $image_object[3][2] - $image_object[0][2] ) / ( $image_object[3][1] - $image_object[0][1] );
    $padding_top = $slope * 100;

    return floatval( $padding_top );
}

/**
 * Banner Image CSS
 *
 * @param  int $post_thumbnail_id
 * @return string
 */
function aob_banner_image_css( $post_thumbnail_id ) {

    // if no post thumbnail ID is passed return early
    if ( empty( $post_thumbnail_id ) ) {
        return;
    }

    $images = aob_get_images( $post_thumbnail_id );
    $slope  = aob_the_slope( $images );

    $padding = ( $slope/2 ); // half of the picture height

    // initial output styles
    $output_css = '.header-img { width: 100%;padding-top:'.$padding.'%;height:50vh;position:relative;-webkit-background-size: cover;-moz-background-size: cover;background-size: cover;background-repeat: no-repeat;background-position: center center;}';

    $i = 0; // set the count var

    foreach ( $images as $img => $atts ) {
        $i++;

        $max = ' and ( max-width:%2$spx )';
        $min = ( $atts[1] - 300 );

        // if the max size picture is being displayed don't use a max width
        if ( $i === 4 ) {
            $max = '';
        }
        // set min size to zero if we are on the first image
        if( $i === 1 ) {
            $min = 0;
        }

        // set the media query string
        $media_query = '@media screen and ( min-width: %1$spx )'.$max.' {.header-img {max-height: %3$spx; background-image: url(%4$s);}}';

        // the output string
        $output_css .= sprintf(
            $media_query,       // the formatted string
            $min, // the min width value
            $atts[1],           // the max width value
            $atts[2],           // the img height
            esc_url( $atts[0] ) // the image URL
        );
    }

    return $output_css;

}

/**
 * Responsive Featured Image Background
 *
 */
function aob_print_banner_image() {
    if ( ! is_front_page() ) {
        return;
    }

    $layout = get_post_meta( get_the_id(), 'aob_banner_layout',   true );
    $img_id = get_post_meta( get_the_id(), 'aob_banner_image_id', true );

    if ( ! empty( $layout ) && ! empty( $img_id ) ) {
        // The Hero Image Layout
        if ( 'hero' === $layout ) {
            $output_css = aob_banner_image_css( intval( $img_id ) );

            if ( ! empty( $output_css ) ) {
                wp_add_inline_style( 'aob-style', $output_css );
            }
        }
    }
} // end function aob_print_banner_image
add_action( 'wp_enqueue_scripts', 'aob_print_banner_image' );
