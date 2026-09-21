<?php
/**
 * The template 'Style 3' to displaying related posts
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

$sweat_link        = get_permalink();
$sweat_post_format = get_post_format();
$sweat_post_format = empty( $sweat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $sweat_post_format );

?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $sweat_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $sweat_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'sweat' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $sweat_link ); ?>" class="post_meta_item post_date"><span class="icon-clock"></span><?php echo wp_kses_data( sweat_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
