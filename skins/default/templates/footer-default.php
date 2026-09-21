<?php
/**
 * The template to display default site footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$sweat_footer_scheme = sweat_get_theme_option( 'footer_scheme' );
if ( ! empty( $sweat_footer_scheme ) && ! sweat_is_inherit( $sweat_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $sweat_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
