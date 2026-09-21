<?php
/**
 * The template to display the attachment
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/content', 'single-' . sweat_get_theme_option( 'single_style' ) ), 'single-' . sweat_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$sweat_posts_navigation = sweat_get_theme_option( 'posts_navigation' );
	if ( 'links' == $sweat_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! sweat_is_off( sweat_get_theme_option( 'posts_navigation_fixed', 0 ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'sweat_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'sweat' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'sweat' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'sweat_action_before_comments' );
	comments_template();
	do_action( 'sweat_action_after_comments' );
}

get_footer();
