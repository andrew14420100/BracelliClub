<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

$sweat_template = apply_filters( 'sweat_filter_get_template_part', sweat_blog_archive_get_template() );

if ( ! empty( $sweat_template ) && 'index' != $sweat_template ) {

	get_template_part( $sweat_template );

} else {

	sweat_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$sweat_stickies   = is_home()
								|| ( in_array( sweat_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) sweat_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$sweat_post_type  = sweat_get_theme_option( 'post_type' );
		$sweat_args       = array(
								'blog_style'     => sweat_get_theme_option( 'blog_style' ),
								'post_type'      => $sweat_post_type,
								'taxonomy'       => sweat_get_post_type_taxonomy( $sweat_post_type ),
								'parent_cat'     => sweat_get_theme_option( 'parent_cat' ),
								'posts_per_page' => sweat_get_theme_option( 'posts_per_page' ),
								'sticky'         => sweat_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $sweat_stickies )
															&& count( $sweat_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		sweat_blog_archive_start();

		do_action( 'sweat_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'sweat_action_before_page_author' );
			get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'sweat_action_after_page_author' );
		}

		if ( sweat_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'sweat_action_before_page_filters' );
			sweat_show_filters( $sweat_args );
			do_action( 'sweat_action_after_page_filters' );
		} else {
			do_action( 'sweat_action_before_page_posts' );
			sweat_show_posts( array_merge( $sweat_args, array( 'cat' => $sweat_args['parent_cat'] ) ) );
			do_action( 'sweat_action_after_page_posts' );
		}

		do_action( 'sweat_action_blog_archive_end' );

		sweat_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
