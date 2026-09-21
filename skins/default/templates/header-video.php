<?php
/**
 * The template to display the background video in the header
 *
 * @package SWEAT
 * @since SWEAT 1.0.14
 */
$sweat_header_video = sweat_get_header_video();
$sweat_embed_video  = '';
if ( ! empty( $sweat_header_video ) && ! sweat_is_from_uploads( $sweat_header_video ) ) {
	if ( sweat_is_youtube_url( $sweat_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $sweat_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php sweat_show_layout( sweat_get_embed_video( $sweat_header_video ) ); ?></div>
		<?php
	}
}
