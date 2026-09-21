<?php
/**
 * The template to display the site logo in the footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */

// Logo
if ( sweat_is_on( sweat_get_theme_option( 'logo_in_footer' ) ) ) {
	$sweat_logo_image = sweat_get_logo_image( 'footer' );
	$sweat_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $sweat_logo_image['logo'] ) || ! empty( $sweat_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $sweat_logo_image['logo'] ) ) {
					$sweat_attr = sweat_getimagesize( $sweat_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $sweat_logo_image['logo'] ) . '"'
								. ( ! empty( $sweat_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $sweat_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'sweat' ) . '"'
								. ( ! empty( $sweat_attr[3] ) ? ' ' . wp_kses_data( $sweat_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $sweat_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $sweat_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
