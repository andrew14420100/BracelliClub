<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package SWEAT
 * @since SWEAT 1.0
 */

if ( sweat_sidebar_present() ) {
	
	$sweat_sidebar_type = sweat_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $sweat_sidebar_type && ! sweat_is_layouts_available() ) {
		$sweat_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $sweat_sidebar_type ) {
		// Default sidebar with widgets
		$sweat_sidebar_name = sweat_get_theme_option( 'sidebar_widgets' );
		sweat_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $sweat_sidebar_name ) ) {
			dynamic_sidebar( $sweat_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$sweat_sidebar_id = sweat_get_custom_sidebar_id();
		do_action( 'sweat_action_show_layout', $sweat_sidebar_id );
	}
	$sweat_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $sweat_out ) ) {
		$sweat_sidebar_position    = sweat_get_theme_option( 'sidebar_position' );
		$sweat_sidebar_position_ss = sweat_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $sweat_sidebar_position );
			echo ' sidebar_' . esc_attr( $sweat_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $sweat_sidebar_type );

			$sweat_sidebar_scheme = apply_filters( 'sweat_filter_sidebar_scheme', sweat_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $sweat_sidebar_scheme ) && ! sweat_is_inherit( $sweat_sidebar_scheme ) && 'custom' != $sweat_sidebar_type ) {
				echo ' scheme_' . esc_attr( $sweat_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<span id="sidebar_skip_link_anchor" class="sweat_skip_link_anchor"></span>
			<?php

			do_action( 'sweat_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $sweat_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$sweat_title = apply_filters( 'sweat_filter_sidebar_control_title', 'float' == $sweat_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'sweat' ) : '' );
				$sweat_text  = apply_filters( 'sweat_filter_sidebar_control_text', 'above' == $sweat_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'sweat' ) : '' );
				?>
				<a href="#" role="button" class="sidebar_control" title="<?php echo esc_attr( $sweat_title ); ?>"><?php echo esc_html( $sweat_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'sweat_action_before_sidebar', 'sidebar' );
				sweat_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $sweat_out ) );
				do_action( 'sweat_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'sweat_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
