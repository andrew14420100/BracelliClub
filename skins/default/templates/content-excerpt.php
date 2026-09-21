<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

$sweat_template_args = get_query_var( 'sweat_template_args' );
$sweat_columns = 1;
if ( is_array( $sweat_template_args ) ) {
	$sweat_columns    = empty( $sweat_template_args['columns'] ) ? 1 : max( 1, $sweat_template_args['columns'] );
	$sweat_blog_style = array( $sweat_template_args['type'], $sweat_columns );
	if ( ! empty( $sweat_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $sweat_columns > 1 ) {
	    $sweat_columns_class = sweat_get_column_class( 1, $sweat_columns, ! empty( $sweat_template_args['columns_tablet']) ? $sweat_template_args['columns_tablet'] : '', ! empty($sweat_template_args['columns_mobile']) ? $sweat_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $sweat_columns_class ); ?>">
		<?php
	}
} else {
	$sweat_template_args = array();
}
$sweat_expanded    = ! sweat_sidebar_present() && sweat_get_theme_option( 'expand_content' ) == 'expand';
$sweat_post_format = get_post_format();
$sweat_post_format = empty( $sweat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $sweat_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $sweat_post_format ) );
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
								: array_map( 'trim', explode( ',', $sweat_template_args['meta_parts'] ) )
								)
							: sweat_array_get_keys_by_value( sweat_get_theme_option( 'meta_parts' ) );
	sweat_show_post_featured( apply_filters( 'sweat_filter_args_featured',
		array(
			'no_links'   => ! empty( $sweat_template_args['no_links'] ),
			'hover'      => $sweat_hover,
			'meta_parts' => $sweat_components,
			'thumb_size' => ! empty( $sweat_template_args['thumb_size'] )
							? $sweat_template_args['thumb_size']
							: sweat_get_thumb_size( strpos( sweat_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $sweat_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$sweat_template_args
	) );

	// Title and post meta
	$sweat_show_title = get_the_title() != '';
	$sweat_show_meta  = count( $sweat_components ) > 0 && ! in_array( $sweat_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $sweat_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'sweat_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'sweat_action_before_post_title' );
				if ( empty( $sweat_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'sweat_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'sweat_filter_show_blog_excerpt', empty( $sweat_template_args['hide_excerpt'] ) && sweat_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'sweat_filter_show_blog_meta', $sweat_show_meta, $sweat_components, 'excerpt' ) ) {
				if ( count( $sweat_components ) > 0 ) {
					do_action( 'sweat_action_before_post_meta' );
					sweat_show_post_meta(
						apply_filters(
							'sweat_filter_post_meta_args', array(
								'components' => join( ',', $sweat_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'sweat_action_after_post_meta' );
				}
			}

			if ( sweat_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'sweat_action_before_full_post_content' );
					the_content( '' );
					do_action( 'sweat_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'sweat' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'sweat' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				sweat_show_post_content( $sweat_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'sweat_filter_show_blog_readmore',  ! isset( $sweat_template_args['more_button'] ) || ! empty( $sweat_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $sweat_template_args['no_links'] ) ) {
					do_action( 'sweat_action_before_post_readmore' );
					if ( sweat_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						sweat_show_post_more_link( $sweat_template_args, '<p>', '</p>' );
					} else {
						sweat_show_post_comments_link( $sweat_template_args, '<p>', '</p>' );
					}
					do_action( 'sweat_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $sweat_template_args ) ) {
	if ( ! empty( $sweat_template_args['slider'] ) || $sweat_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
