<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

$sweat_args = get_query_var( 'sweat_logo_args' );

// Site logo
$sweat_logo_type   = isset( $sweat_args['type'] ) ? $sweat_args['type'] : '';
$sweat_logo_image  = sweat_get_logo_image( $sweat_logo_type );
$sweat_logo_text   = sweat_is_on( sweat_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$sweat_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $sweat_logo_image['logo'] ) || ! empty( $sweat_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $sweat_logo_image['logo'] ) ) {
			if ( empty( $sweat_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($sweat_logo_image['logo']) && (int) $sweat_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$sweat_attr = sweat_getimagesize( $sweat_logo_image['logo'] );
				echo '<img src="' . esc_url( $sweat_logo_image['logo'] ) . '"'
						. ( ! empty( $sweat_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $sweat_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $sweat_logo_text ) . '"'
						. ( ! empty( $sweat_attr[3] ) ? ' ' . wp_kses_data( $sweat_attr[3] ) : '' )
						. '>';
			}
		} else {
			sweat_show_layout( sweat_prepare_macros( $sweat_logo_text ), '<span class="logo_text">', '</span>' );
			sweat_show_layout( sweat_prepare_macros( $sweat_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
