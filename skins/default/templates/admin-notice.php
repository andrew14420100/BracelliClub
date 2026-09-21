<?php
/**
 * The template to display Admin notices
 *
 * @package SWEAT
 * @since SWEAT 1.0.1
 */

$sweat_theme_slug = get_option( 'template' );
$sweat_theme_obj  = wp_get_theme( $sweat_theme_slug );
?>
<div class="sweat_admin_notice sweat_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$sweat_theme_img = sweat_get_file_url( 'screenshot.jpg' );
	if ( '' != $sweat_theme_img ) {
		?>
		<div class="sweat_notice_image"><img src="<?php echo esc_url( $sweat_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'sweat' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="sweat_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'sweat' ),
				$sweat_theme_obj->get( 'Name' ) . ( SWEAT_THEME_FREE ? ' ' . __( 'Free', 'sweat' ) : '' ),
				$sweat_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="sweat_notice_text">
		<p class="sweat_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $sweat_theme_obj->description ) );
			?>
		</p>
		<p class="sweat_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'sweat' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="sweat_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=sweat_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'sweat' );
			?>
		</a>
	</div>
</div>
