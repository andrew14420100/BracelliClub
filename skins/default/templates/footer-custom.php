<?php
/**
 * The template to display default site footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */

$sweat_footer_id = sweat_get_custom_footer_id();
$sweat_footer_meta = get_post_meta( $sweat_footer_id, 'trx_addons_options', true );
if ( ! empty( $sweat_footer_meta['margin'] ) ) {
	sweat_add_inline_css( sprintf( '.page_content_wrap.page_content_wrap_custom_footer_margin{padding-bottom:%s}', esc_attr( sweat_prepare_css_value( $sweat_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $sweat_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $sweat_footer_id ) ) ); ?>
						<?php
						$sweat_footer_scheme = sweat_get_theme_option( 'footer_scheme' );
						if ( ! empty( $sweat_footer_scheme ) && ! sweat_is_inherit( $sweat_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $sweat_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'sweat_action_show_layout', $sweat_footer_id );
	?>
</footer><!-- /.footer_wrap -->
