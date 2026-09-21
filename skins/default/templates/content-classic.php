<?php
/**
 * The Classic template to display the content
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
$sweat_expanded   = ! sweat_sidebar_present() && sweat_get_theme_option( 'expand_content' ) == 'expand';

$sweat_post_format = get_post_format();
$sweat_post_format = empty( $sweat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $sweat_post_format );

?><div class="<?php
	if ( ! empty( $sweat_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( sweat_is_blog_style_use_masonry( $sweat_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $sweat_columns ) : esc_attr( $sweat_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $sweat_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $sweat_columns )
				. ' post_layout_' . esc_attr( $sweat_blog_style[0] )
				. ' post_layout_' . esc_attr( $sweat_blog_style[0] ) . '_' . esc_attr( $sweat_columns )
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

	// Featured image
	$sweat_hover      = ! empty( $sweat_template_args['hover'] ) && ! sweat_is_inherit( $sweat_template_args['hover'] )
							? $sweat_template_args['hover']
							: sweat_get_theme_option( 'image_hover' );

	$sweat_components = ! empty( $sweat_template_args['meta_parts'] )
							? ( is_array( $sweat_template_args['meta_parts'] )
								? $sweat_template_args['meta_parts']
								: explode( ',', $sweat_template_args['meta_parts'] )
								)
							: sweat_array_get_keys_by_value( sweat_get_theme_option( 'meta_parts' ) );

	sweat_show_post_featured( apply_filters( 'sweat_filter_args_featured',
		array(
			'thumb_size' => ! empty( $sweat_template_args['thumb_size'] )
				? $sweat_template_args['thumb_size']
				: sweat_get_thumb_size(
					'classic' == $sweat_blog_style[0]
						? ( strpos( sweat_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $sweat_columns > 2 ? 'big' : 'huge' )
								: ( $sweat_columns > 2
									? ( $sweat_expanded ? 'square' : 'square' )
									: ($sweat_columns > 1 ? 'square' : ( $sweat_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( sweat_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $sweat_columns > 2 ? 'masonry-big' : 'full' )
								: ($sweat_columns === 1 ? ( $sweat_expanded ? 'huge' : 'big' ) : ( $sweat_columns <= 2 && $sweat_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $sweat_hover,
			'meta_parts' => $sweat_components,
			'no_links'   => ! empty( $sweat_template_args['no_links'] ),
        ),
        'content-classic',
        $sweat_template_args
    ) );

	// Title and post meta
	$sweat_show_title = get_the_title() != '';
	$sweat_show_meta  = count( $sweat_components ) > 0 && ! in_array( $sweat_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $sweat_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'sweat_filter_show_blog_meta', $sweat_show_meta, $sweat_components, 'classic' ) ) {
				if ( count( $sweat_components ) > 0 ) {
					do_action( 'sweat_action_before_post_meta' );
					sweat_show_post_meta(
						apply_filters(
							'sweat_filter_post_meta_args', array(
							'components' => join( ',', $sweat_components ),
							'seo'        => false,
							'echo'       => true,
						), $sweat_blog_style[0], $sweat_columns
						)
					);
					do_action( 'sweat_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'sweat_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'sweat_action_before_post_title' );
				if ( empty( $sweat_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'sweat_action_after_post_title' );
			}

			if( !in_array( $sweat_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'sweat_filter_show_blog_readmore', ! $sweat_show_title || ! empty( $sweat_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $sweat_template_args['no_links'] ) ) {
						do_action( 'sweat_action_before_post_readmore' );
						sweat_show_post_more_link( $sweat_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'sweat_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $sweat_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('sweat_filter_show_blog_excerpt', empty($sweat_template_args['hide_excerpt']) && sweat_get_theme_option('excerpt_length') > 0, 'classic')) {
			sweat_show_post_content($sweat_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $sweat_template_args['more_button'] )) {
			if ( empty( $sweat_template_args['no_links'] ) ) {
				do_action( 'sweat_action_before_post_readmore' );
				sweat_show_post_more_link( $sweat_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'sweat_action_after_post_readmore' );
			}
		}
		$sweat_content = ob_get_contents();
		ob_end_clean();
		sweat_show_layout($sweat_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
