<?php
	$text = aob_get_banner_text();
	$display_text = aob_get_var( 'display_text' );
?>
<div class="banner-text">
	<?php if ( false !== aob_get_var( 'logo_display' ) ) :
		aob_get_template_part( 'templates/logo' );
	endif; ?>
	<?php if ( ! empty( $text['main_text'] ) ) : ?>
		<h1><?php echo esc_html( $text['main_text'] ); ?></h1>
	<?php endif; ?>
	<?php if ( ! empty( $text['sub_text'] ) ) : ?>
		<p><?php echo esc_html( $text['sub_text'] ); ?></p>
	<?php endif; ?>
	<?php if ( ! empty( $text['btn_url'] ) ) : ?>
		<a href="<?php echo esc_url( $text['btn_url'] ); ?>" class="action-btn"><?php echo esc_html( $text['btn_txt'] ); ?></a>
	<?php endif; ?>
</div>
