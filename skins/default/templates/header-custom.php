<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package SWEAT
 * @since SWEAT 1.0.06
 */

$sweat_header_css   = '';
$sweat_header_image = get_header_image();
$sweat_header_video = sweat_get_header_video();
if ( ! empty( $sweat_header_image ) && sweat_trx_addons_featured_image_override( is_singular() || sweat_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$sweat_header_image = sweat_get_current_mode_image( $sweat_header_image );
}

$sweat_header_id = sweat_get_custom_header_id();
$sweat_header_meta = get_post_meta( $sweat_header_id, 'trx_addons_options', true );
if ( ! empty( $sweat_header_meta['margin'] ) ) {
	sweat_add_inline_css( sprintf( '.page_content_wrap.page_content_wrap_custom_header_margin{padding-top:%s}', esc_attr( sweat_prepare_css_value( $sweat_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $sweat_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $sweat_header_id ) ) ); ?>
				<?php
				echo ! empty( $sweat_header_image ) || ! empty( $sweat_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $sweat_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $sweat_header_image ) {
					echo ' ' . esc_attr( sweat_add_inline_css_class( 'background-image: url(' . esc_url( $sweat_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( sweat_is_on( sweat_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight sweat-full-height';
				}
				$sweat_header_scheme = sweat_get_theme_option( 'header_scheme' );
				if ( ! empty( $sweat_header_scheme ) && ! sweat_is_inherit( $sweat_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $sweat_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $sweat_header_video ) ) {
		get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'sweat_action_show_layout', $sweat_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
