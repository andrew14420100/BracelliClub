<?php
/**
 * The template to display the widgets area in the header
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

// Header sidebar
$sweat_header_name    = sweat_get_theme_option( 'header_widgets' );
$sweat_header_present = ! sweat_is_off( $sweat_header_name ) && is_active_sidebar( $sweat_header_name );
if ( $sweat_header_present ) {
	sweat_storage_set( 'current_sidebar', 'header' );
	$sweat_header_wide = sweat_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $sweat_header_name ) ) {
		dynamic_sidebar( $sweat_header_name );
	}
	$sweat_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $sweat_widgets_output ) ) {
		$sweat_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $sweat_widgets_output );
		$sweat_need_columns   = strpos( $sweat_widgets_output, 'columns_wrap' ) === false;
		if ( $sweat_need_columns ) {
			$sweat_columns = max( 0, (int) sweat_get_theme_option( 'header_columns' ) );
			if ( 0 == $sweat_columns ) {
				$sweat_columns = min( 6, max( 1, sweat_tags_count( $sweat_widgets_output, 'aside' ) ) );
			}
			if ( $sweat_columns > 1 ) {
				$sweat_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $sweat_columns ) . ' widget', $sweat_widgets_output );
			} else {
				$sweat_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $sweat_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'sweat_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $sweat_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $sweat_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'sweat_action_before_sidebar', 'header' );
				sweat_show_layout( $sweat_widgets_output );
				do_action( 'sweat_action_after_sidebar', 'header' );
				if ( $sweat_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $sweat_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'sweat_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
