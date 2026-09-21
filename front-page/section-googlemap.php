<div class="front_page_section front_page_section_googlemap<?php
	$sweat_scheme = sweat_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $sweat_scheme ) && ! sweat_is_inherit( $sweat_scheme ) ) {
		echo ' scheme_' . esc_attr( $sweat_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( sweat_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( sweat_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$sweat_css      = '';
		$sweat_bg_image = sweat_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$sweat_anchor_icon = sweat_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$sweat_anchor_text = sweat_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $sweat_anchor_icon ) || ! empty( $sweat_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $sweat_anchor_icon ) ? ' icon="' . esc_attr( $sweat_anchor_icon ) . '"' : '' )
									. ( ! empty( $sweat_anchor_text ) ? ' title="' . esc_attr( $sweat_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$sweat_layout = sweat_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $sweat_layout );
		if ( sweat_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' sweat-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$sweat_css      = '';
			$sweat_bg_mask  = sweat_get_theme_option( 'front_page_googlemap_bg_mask' );
			$sweat_bg_color_type = sweat_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $sweat_bg_color_type ) {
				$sweat_bg_color = sweat_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $sweat_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$sweat_caption     = sweat_get_theme_option( 'front_page_googlemap_caption' );
			$sweat_description = sweat_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $sweat_caption ) || ! empty( $sweat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $sweat_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $sweat_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $sweat_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $sweat_caption, 'sweat_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $sweat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $sweat_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $sweat_description ), 'sweat_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $sweat_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$sweat_content = sweat_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $sweat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $sweat_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $sweat_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $sweat_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $sweat_content, 'sweat_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $sweat_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $sweat_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! sweat_exists_trx_addons() ) {
						sweat_customizer_need_trx_addons_message();
					} else {
						sweat_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $sweat_layout && ( ! empty( $sweat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
