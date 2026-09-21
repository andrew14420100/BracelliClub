<?php
/**
 * The template to display single post
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

// Full post loading
$full_post_loading          = sweat_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = sweat_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = sweat_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$sweat_related_position   = sweat_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$sweat_posts_navigation   = sweat_get_theme_option( 'posts_navigation' );
$sweat_prev_post          = false;
$sweat_prev_post_same_cat = (int)sweat_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( sweat_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	sweat_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'sweat_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $sweat_posts_navigation ) {
		$sweat_prev_post = get_previous_post( $sweat_prev_post_same_cat );  // Get post from same category
		if ( ! $sweat_prev_post && $sweat_prev_post_same_cat ) {
			$sweat_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $sweat_prev_post ) {
			$sweat_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $sweat_prev_post ) ) {
		sweat_sc_layouts_showed( 'featured', false );
		sweat_sc_layouts_showed( 'title', false );
		sweat_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $sweat_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/content', 'single-' . sweat_get_theme_option( 'single_style' ) ), 'single-' . sweat_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $sweat_related_position, 'inside' ) === 0 ) {
		$sweat_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'sweat_action_related_posts' );
		$sweat_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $sweat_related_content ) ) {
			$sweat_related_position_inside = max( 0, min( 9, sweat_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $sweat_related_position_inside ) {
				$sweat_related_position_inside = mt_rand( 1, 9 );
			}

			$sweat_p_number         = 0;
			$sweat_related_inserted = false;
			$sweat_in_block         = false;
			$sweat_content_start    = strpos( $sweat_content, '<div class="post_content' );
			$sweat_content_end      = strrpos( $sweat_content, '</div>' );

			for ( $i = max( 0, $sweat_content_start ); $i < min( strlen( $sweat_content ) - 3, $sweat_content_end ); $i++ ) {
				if ( $sweat_content[ $i ] != '<' ) {
					continue;
				}
				if ( $sweat_in_block ) {
					if ( strtolower( substr( $sweat_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$sweat_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $sweat_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $sweat_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$sweat_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $sweat_content[ $i + 1 ] && in_array( $sweat_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$sweat_p_number++;
					if ( $sweat_related_position_inside == $sweat_p_number ) {
						$sweat_related_inserted = true;
						$sweat_content = ( $i > 0 ? substr( $sweat_content, 0, $i ) : '' )
											. $sweat_related_content
											. substr( $sweat_content, $i );
					}
				}
			}
			if ( ! $sweat_related_inserted ) {
				if ( $sweat_content_end > 0 ) {
					$sweat_content = substr( $sweat_content, 0, $sweat_content_end ) . $sweat_related_content . substr( $sweat_content, $sweat_content_end );
				} else {
					$sweat_content .= $sweat_related_content;
				}
			}
		}

		sweat_show_layout( $sweat_content );
	}

	// Comments
	do_action( 'sweat_action_before_comments' );
	comments_template();
	do_action( 'sweat_action_after_comments' );

	// Related posts
	if ( 'below_content' == $sweat_related_position
		&& ( 'scroll' != $sweat_posts_navigation || (int)sweat_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)sweat_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'sweat_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $sweat_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $sweat_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $sweat_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $sweat_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'sweat_action_nav_links_single_scroll_data', $sweat_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
