<?php
/**
 * The Header: Logo and main menu
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( sweat_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}

	$sweat_full_post_loading = ( sweat_is_singular( 'post' ) || sweat_is_singular( 'attachment' ) ) && sweat_get_value_gp( 'action' ) == 'full_post_loading';
	$sweat_prev_post_loading = ( sweat_is_singular( 'post' ) || sweat_is_singular( 'attachment' ) ) && sweat_get_value_gp( 'action' ) == 'prev_post_loading';

	// Don't display the short links while actions 'full_post_loading' and 'prev_post_loading'
	if ( ! $sweat_full_post_loading && ! $sweat_prev_post_loading ) {
		// Short links to fast access to the content, sidebar and footer from the keyboard
		?><a class="skip-link sweat_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'sweat_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to content", 'sweat' ); ?></a><?php
		if ( sweat_sidebar_present() ) {
			?><a class="skip-link sweat_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'sweat_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'sweat' ); ?></a><?php
		}
		?><a class="skip-link sweat_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'sweat_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to footer", 'sweat' ); ?></a><?php
	}

	do_action( 'sweat_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'sweat_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('sweat_action_body_wrap_attributes'); ?>>

		<?php do_action( 'sweat_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'sweat_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('sweat_action_page_wrap_attributes'); ?>>

			<?php do_action( 'sweat_action_page_wrap_start' ); ?>

			<?php

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $sweat_full_post_loading && ! $sweat_prev_post_loading ) {

				do_action( 'sweat_action_before_header' );

				// Header
				$sweat_header_type = sweat_get_theme_option( 'header_type' );
				if ( 'custom' == $sweat_header_type && ! sweat_is_layouts_available() ) {
					$sweat_header_type = 'default';
				}
				get_template_part( apply_filters( 'sweat_filter_get_template_part', "templates/header-" . sanitize_file_name( $sweat_header_type ) ) );

				// Side menu
				if ( in_array( sweat_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'sweat_filter_use_navi_mobile', sweat_sc_layouts_showed( 'menu_button' ) || $sweat_header_type == 'default' ) ) {
					get_template_part( apply_filters( 'sweat_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'sweat_action_after_header' );

			}
			?>

			<?php do_action( 'sweat_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( sweat_is_off( sweat_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $sweat_header_type ) ) {
						$sweat_header_type = sweat_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $sweat_header_type && sweat_is_layouts_available() ) {
						$sweat_header_id = sweat_get_custom_header_id();
						if ( $sweat_header_id > 0 ) {
							$sweat_header_meta = sweat_get_custom_layout_meta( $sweat_header_id );
							if ( ! empty( $sweat_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$sweat_footer_type = sweat_get_theme_option( 'footer_type' );
					if ( 'custom' == $sweat_footer_type && sweat_is_layouts_available() ) {
						$sweat_footer_id = sweat_get_custom_footer_id();
						if ( $sweat_footer_id ) {
							$sweat_footer_meta = sweat_get_custom_layout_meta( $sweat_footer_id );
							if ( ! empty( $sweat_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'sweat_action_page_content_wrap_class', $sweat_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'sweat_filter_is_prev_post_loading', $sweat_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( sweat_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'sweat_action_page_content_wrap_data', $sweat_prev_post_loading );
			?>>
				<?php
				do_action( 'sweat_action_page_content_wrap', $sweat_full_post_loading || $sweat_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'sweat_filter_single_post_header', sweat_is_singular( 'post' ) || sweat_is_singular( 'attachment' ) ) ) {
					if ( $sweat_prev_post_loading ) {
						if ( sweat_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'sweat_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$sweat_path = apply_filters( 'sweat_filter_get_template_part', 'templates/single-styles/' . sweat_get_theme_option( 'single_style' ) );
					if ( sweat_get_file_dir( $sweat_path . '.php' ) != '' ) {
						get_template_part( $sweat_path );
					}
				}

				// Widgets area above page
				$sweat_body_style   = sweat_get_theme_option( 'body_style' );
				$sweat_widgets_name = sweat_get_theme_option( 'widgets_above_page', 'hide' );
				$sweat_show_widgets = ! sweat_is_off( $sweat_widgets_name ) && is_active_sidebar( $sweat_widgets_name );
				if ( $sweat_show_widgets ) {
					if ( 'fullscreen' != $sweat_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					sweat_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $sweat_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'sweat_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $sweat_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'sweat_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'sweat_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<span id="content_skip_link_anchor" class="sweat_skip_link_anchor"></span>
						<?php
						// Single posts banner between prev/next posts
						if ( ( sweat_is_singular( 'post' ) || sweat_is_singular( 'attachment' ) )
							&& $sweat_prev_post_loading 
							&& sweat_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'sweat_action_between_posts' );
						}

						// Widgets area above content
						sweat_create_widgets_area( 'widgets_above_content' );

						do_action( 'sweat_action_page_content_start_text' );
