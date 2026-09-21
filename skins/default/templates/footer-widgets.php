<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package SWEAT
 * @since SWEAT 1.0.10
 */

// Footer sidebar
$sweat_footer_name    = sweat_get_theme_option( 'footer_widgets' );
$sweat_footer_present = ! sweat_is_off( $sweat_footer_name ) && is_active_sidebar( $sweat_footer_name );
if ( $sweat_footer_present ) {
	sweat_storage_set( 'current_sidebar', 'footer' );
	$sweat_footer_wide = sweat_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $sweat_footer_name ) ) {
		dynamic_sidebar( $sweat_footer_name );
	}
	$sweat_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $sweat_out ) ) {
		$sweat_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $sweat_out );
		$sweat_need_columns = true;   //or check: strpos($sweat_out, 'columns_wrap')===false;
		if ( $sweat_need_columns ) {
			$sweat_columns = max( 0, (int) sweat_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $sweat_columns ) {
				$sweat_columns = min( 4, max( 1, sweat_tags_count( $sweat_out, 'aside' ) ) );
			}
			if ( $sweat_columns > 1 ) {
				$sweat_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $sweat_columns ) . ' widget', $sweat_out );
			} else {
				$sweat_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $sweat_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'sweat_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $sweat_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $sweat_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'sweat_action_before_sidebar', 'footer' );
				sweat_show_layout( $sweat_out );
				do_action( 'sweat_action_after_sidebar', 'footer' );
				if ( $sweat_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $sweat_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'sweat_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
