<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

$sweat_template_args = get_query_var( 'sweat_template_args' );
if ( is_array( $sweat_template_args ) ) {
	$sweat_columns    = empty( $sweat_template_args['columns'] ) ? 2 : max( 1, $sweat_template_args['columns'] );
	$sweat_blog_style = array( $sweat_template_args['type'], $sweat_columns );
    $sweat_columns_class = sweat_get_column_class( 1, $sweat_columns, ! empty( $sweat_template_args['columns_tablet']) ? $sweat_template_args['columns_tablet'] : '', ! empty($sweat_template_args['columns_mobile']) ? $sweat_template_args['columns_mobile'] : '' );
} else {
	$sweat_template_args = array();
	$sweat_blog_style = explode( '_', sweat_get_theme_option( 'blog_style' ) );
	$sweat_columns    = empty( $sweat_blog_style[1] ) ? 2 : max( 1, $sweat_blog_style[1] );
    $sweat_columns_class = sweat_get_column_class( 1, $sweat_columns );
}

$sweat_post_format = get_post_format();
$sweat_post_format = empty( $sweat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $sweat_post_format );

?><div class="
<?php
if ( ! empty( $sweat_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( sweat_is_blog_style_use_masonry( $sweat_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $sweat_columns ) : esc_attr( $sweat_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $sweat_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $sweat_columns )
		. ( 'portfolio' != $sweat_blog_style[0] ? ' ' . esc_attr( $sweat_blog_style[0] )  . '_' . esc_attr( $sweat_columns ) : '' )
	);
	sweat_add_blog_animation( $sweat_template_args );
	?>
>
<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$sweat_hover   = ! empty( $sweat_template_args['hover'] ) && ! sweat_is_inherit( $sweat_template_args['hover'] )
								? $sweat_template_args['hover']
								: sweat_get_theme_option( 'image_hover' );

	if ( 'dots' == $sweat_hover ) {
		$sweat_post_link = empty( $sweat_template_args['no_links'] )
								? ( ! empty( $sweat_template_args['link'] )
									? $sweat_template_args['link']
									: get_permalink()
									)
								: '';
		$sweat_target    = ! empty( $sweat_post_link ) && sweat_is_external_url( $sweat_post_link ) && function_exists( 'sweat_external_links_target' )
								? sweat_external_links_target()
								: '';
	}
	
	// Meta parts
	$sweat_components = ! empty( $sweat_template_args['meta_parts'] )
							? ( is_array( $sweat_template_args['meta_parts'] )
								? $sweat_template_args['meta_parts']
								: explode( ',', $sweat_template_args['meta_parts'] )
								)
							: sweat_array_get_keys_by_value( sweat_get_theme_option( 'meta_parts' ) );

	// Featured image
	sweat_show_post_featured( apply_filters( 'sweat_filter_args_featured', 
        array(
			'hover'         => $sweat_hover,
			'no_links'      => ! empty( $sweat_template_args['no_links'] ),
			'thumb_size'    => ! empty( $sweat_template_args['thumb_size'] )
								? $sweat_template_args['thumb_size']
								: sweat_get_thumb_size(
									sweat_is_blog_style_use_masonry( $sweat_blog_style[0] )
										? (	strpos( sweat_get_theme_option( 'body_style' ), 'full' ) !== false || $sweat_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( sweat_get_theme_option( 'body_style' ), 'full' ) !== false || $sweat_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => sweat_is_blog_style_use_masonry( $sweat_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $sweat_components,
			'class'         => 'dots' == $sweat_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $sweat_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $sweat_post_link )
												? '<a href="' . esc_url( $sweat_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $sweat_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $sweat_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $sweat_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!