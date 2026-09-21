<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$sweat_copyright_scheme = sweat_get_theme_option( 'copyright_scheme' );
if ( ! empty( $sweat_copyright_scheme ) && ! sweat_is_inherit( $sweat_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $sweat_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$sweat_copyright = sweat_get_theme_option( 'copyright' );
			if ( ! empty( $sweat_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$sweat_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $sweat_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$sweat_copyright = sweat_prepare_macros( $sweat_copyright );
				// Display copyright
				echo wp_kses( nl2br( $sweat_copyright ), 'sweat_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
