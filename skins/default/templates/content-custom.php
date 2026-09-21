<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package SWEAT
 * @since SWEAT 1.0.50
 */

$sweat_template_args = get_query_var( 'sweat_template_args' );
if ( is_array( $sweat_template_args ) ) {
	$sweat_columns    = empty( $sweat_template_args['columns'] ) ? 2 : max( 1, $sweat_template_args['columns'] );
	$sweat_blog_style = array( $sweat_template_args['type'], $sweat_columns );
} else {
	$sweat_template_args = array();
	$sweat_blog_style = explode( '_', sweat_get_theme_option( 'blog_style' ) );
	$sweat_columns    = empty( $sweat_blog_style[1] ) ? 2 : max( 1, $sweat_blog_style[1] );
}
$sweat_blog_id       = sweat_get_custom_blog_id( join( '_', $sweat_blog_style ) );
$sweat_blog_style[0] = str_replace( 'blog-custom-', '', $sweat_blog_style[0] );
$sweat_expanded      = ! sweat_sidebar_present() && sweat_get_theme_option( 'expand_content' ) == 'expand';
$sweat_components    = ! empty( $sweat_template_args['meta_parts'] )
							? ( is_array( $sweat_template_args['meta_parts'] )
								? join( ',', $sweat_template_args['meta_parts'] )
								: $sweat_template_args['meta_parts']
								)
							: sweat_array_get_keys_by_value( sweat_get_theme_option( 'meta_parts' ) );
$sweat_post_format   = get_post_format();
$sweat_post_format   = empty( $sweat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $sweat_post_format );

$sweat_blog_meta     = sweat_get_custom_layout_meta( $sweat_blog_id );
$sweat_custom_style  = ! empty( $sweat_blog_meta['scripts_required'] ) ? $sweat_blog_meta['scripts_required'] : 'none';

if ( ! empty( $sweat_template_args['slider'] ) || $sweat_columns > 1 || ! sweat_is_off( $sweat_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $sweat_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( sweat_is_off( $sweat_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $sweat_custom_style ) ) . "-1_{$sweat_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $sweat_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $sweat_columns )
					. ' post_layout_' . esc_attr( $sweat_blog_style[0] )
					. ' post_layout_' . esc_attr( $sweat_blog_style[0] ) . '_' . esc_attr( $sweat_columns )
					. ( ! sweat_is_off( $sweat_custom_style )
						? ' post_layout_' . esc_attr( $sweat_custom_style )
							. ' post_layout_' . esc_attr( $sweat_custom_style ) . '_' . esc_attr( $sweat_columns )
						: ''
						)
		);
	sweat_add_blog_animation( $sweat_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'sweat_action_show_layout', $sweat_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $sweat_template_args['slider'] ) || $sweat_columns > 1 || ! sweat_is_off( $sweat_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
