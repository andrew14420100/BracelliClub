<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

// Page (category, tag, archive, author) title

if ( sweat_need_page_title() ) {
	sweat_sc_layouts_showed( 'title', true );
	sweat_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								sweat_show_post_meta(
									apply_filters(
										'sweat_filter_post_meta_args', array(
											'components' => join( ',', sweat_array_get_keys_by_value( sweat_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', sweat_array_get_keys_by_value( sweat_get_theme_option( 'counters' ) ) ),
											'seo'        => sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$sweat_blog_title           = sweat_get_blog_title();
							$sweat_blog_title_text      = '';
							$sweat_blog_title_class     = '';
							$sweat_blog_title_link      = '';
							$sweat_blog_title_link_text = '';
							if ( is_array( $sweat_blog_title ) ) {
								$sweat_blog_title_text      = $sweat_blog_title['text'];
								$sweat_blog_title_class     = ! empty( $sweat_blog_title['class'] ) ? ' ' . $sweat_blog_title['class'] : '';
								$sweat_blog_title_link      = ! empty( $sweat_blog_title['link'] ) ? $sweat_blog_title['link'] : '';
								$sweat_blog_title_link_text = ! empty( $sweat_blog_title['link_text'] ) ? $sweat_blog_title['link_text'] : '';
							} else {
								$sweat_blog_title_text = $sweat_blog_title;
							}
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr( $sweat_blog_title_class ); ?>"<?php
								if ( sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ) ) {
									?> itemprop="headline"<?php
								}
							?>>
								<?php
								$sweat_top_icon = sweat_get_term_image_small();
								if ( ! empty( $sweat_top_icon ) ) {
									$sweat_attr = sweat_getimagesize( $sweat_top_icon );
									?>
									<img src="<?php echo esc_url( $sweat_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'sweat' ); ?>"
										<?php
										if ( ! empty( $sweat_attr[3] ) ) {
											sweat_show_layout( $sweat_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $sweat_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $sweat_blog_title_link ) && ! empty( $sweat_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $sweat_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $sweat_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'sweat_action_breadcrumbs' );
						$sweat_breadcrumbs = ob_get_contents();
						ob_end_clean();
						sweat_show_layout( $sweat_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
