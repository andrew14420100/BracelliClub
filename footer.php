<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

							do_action( 'sweat_action_page_content_end_text' );
							
							// Widgets area below the content
							sweat_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'sweat_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'sweat_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'sweat_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'sweat_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$sweat_body_style = sweat_get_theme_option( 'body_style' );
					$sweat_widgets_name = sweat_get_theme_option( 'widgets_below_page', 'hide' );
					$sweat_show_widgets = ! sweat_is_off( $sweat_widgets_name ) && is_active_sidebar( $sweat_widgets_name );
					$sweat_show_related = sweat_is_single() && sweat_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $sweat_show_widgets || $sweat_show_related ) {
						if ( 'fullscreen' != $sweat_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $sweat_show_related ) {
							do_action( 'sweat_action_related_posts' );
						}

						// Widgets area below page content
						if ( $sweat_show_widgets ) {
							sweat_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $sweat_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'sweat_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'sweat_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! sweat_is_singular( 'post' ) && ! sweat_is_singular( 'attachment' ) ) || ! in_array ( sweat_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<span id="footer_skip_link_anchor" class="sweat_skip_link_anchor"></span>
				<?php

				do_action( 'sweat_action_before_footer' );

				// Footer
				$sweat_footer_type = sweat_get_theme_option( 'footer_type' );
				if ( 'custom' == $sweat_footer_type && ! sweat_is_layouts_available() ) {
					$sweat_footer_type = 'default';
				}
				get_template_part( apply_filters( 'sweat_filter_get_template_part', "templates/footer-" . sanitize_file_name( $sweat_footer_type ) ) );

				do_action( 'sweat_action_after_footer' );

			}
			?>

			<?php do_action( 'sweat_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'sweat_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'sweat_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>