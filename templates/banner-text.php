<?php
$main_text = get_post_meta( get_the_id(), 'aob_banner_text', true );
$sup_text  = get_post_meta( get_the_id(), 'aob_banner_supporting', true );
$disable   = get_post_meta( get_the_id(), 'aob_display_banner', true );
$btn_txt   = get_post_meta( get_the_id(), 'aob_banner_button_text', true );
$btn_url   = get_post_meta( get_the_id(), 'aob_banner_button_url', true );
?>

<div class="banner-text">
	<?php aob_get_template_part( 'templates/logo' ); ?>
	<?php if ( ! empty( $main_text ) ) : ?>
		<h1><?php echo esc_html( $main_text ); ?></h1>
	<?php endif; ?>
	<?php if ( ! empty( $sup_text ) ) : ?>
		<p><?php echo esc_html( $sup_text ); ?></p>
	<?php endif; ?>
	<?php if ( ! empty( $btn_url ) ) : ?>
		<a href="<?php echo esc_url( $btn_url ); ?>" class="action-btn"><?php echo esc_html( $btn_txt ); ?></a>
	<?php endif; ?>
</div>
