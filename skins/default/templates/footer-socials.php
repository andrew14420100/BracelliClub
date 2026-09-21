<?php
/**
 * The template to display the socials in the footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */


// Socials
if ( sweat_is_on( sweat_get_theme_option( 'socials_in_footer' ) ) ) {
	$sweat_output = sweat_get_socials_links();
	if ( '' != $sweat_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php sweat_show_layout( $sweat_output ); ?>
			</div>
		</div>
		<?php
	}
}
