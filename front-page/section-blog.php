<div class="front_page_section front_page_section_blog<?php
	$sweat_scheme = sweat_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $sweat_scheme ) && ! sweat_is_inherit( $sweat_scheme ) ) {
		echo ' scheme_' . esc_attr( $sweat_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( sweat_get_theme_option( 'front_page_blog_paddings' ) );
	if ( sweat_get_theme_option( 'front_page_blog_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$sweat_css      = '';
		$sweat_bg_image = sweat_get_theme_option( 'front_page_blog_bg_image' );
		if ( ! empty( $sweat_bg_image ) ) {
			$sweat_css .= 'background-image: url(' . esc_url( sweat_get_attachment_url( $sweat_bg_image ) ) . ');';
		}
		if ( ! empty( $sweat_css ) ) {
			echo ' style="' . esc_attr( $sweat_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$sweat_anchor_icon = sweat_get_theme_option( 'front_page_blog_anchor_icon' );
	$sweat_anchor_text = sweat_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $sweat_anchor_icon ) || ! empty( $sweat_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $sweat_anchor_icon ) ? ' icon="' . esc_attr( $sweat_anchor_icon ) . '"' : '' )
									. ( ! empty( $sweat_anchor_text ) ? ' title="' . esc_attr( $sweat_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( sweat_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' sweat-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$sweat_css      = '';
			$sweat_bg_mask  = sweat_get_theme_option( 'front_page_blog_bg_mask' );
			$sweat_bg_color_type = sweat_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $sweat_bg_color_type ) {
				$sweat_bg_color = sweat_get_theme_option( 'front_page_blog_bg_color' );
			} elseif ( 'scheme_bg_color' == $sweat_bg_color_type ) {
				$sweat_bg_color = sweat_get_scheme_color( 'bg_color', $sweat_scheme );
			} else {
				$sweat_bg_color = '';
			}
			if ( ! empty( $sweat_bg_color ) && $sweat_bg_mask > 0 ) {
				$sweat_css .= 'background-color: ' . esc_attr(
					1 == $sweat_bg_mask ? $sweat_bg_color : sweat_hex2rgba( $sweat_bg_color, $sweat_bg_mask )
				) . ';';
			}
			if ( ! empty( $sweat_css ) ) {
				echo ' style="' . esc_attr( $sweat_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$sweat_caption = sweat_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $sweat_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $sweat_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $sweat_caption, 'sweat_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$sweat_description = sweat_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $sweat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $sweat_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $sweat_description ), 'sweat_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
				<?php
				if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! sweat_exists_trx_addons() ) {
						sweat_customizer_need_trx_addons_message();
					} else {
						sweat_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
