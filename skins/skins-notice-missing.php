<?php
/**
 * The template to display Admin notices
 *
 * @package SWEAT
 * @since SWEAT 1.98.0
 */

$sweat_skins_url   = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$sweat_active_skin = sweat_skins_get_active_skin_name();
?>
<div class="sweat_admin_notice sweat_skins_notice notice notice-error">
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
		<?php esc_html_e( 'Active skin is missing!', 'sweat' ); ?>
	</h3>
	<div class="sweat_notice_text">
		<p>
			<?php
			// Translators: Add a current skin name to the message
			echo wp_kses_data( sprintf( __( "Your active skin <b>'%s'</b> is missing. Usually this happens when the theme is updated directly through the server or FTP.", 'sweat' ), ucfirst( $sweat_active_skin ) ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "Please use only <b>'ThemeREX Updater v.1.6.0+'</b> plugin for your future updates.", 'sweat' ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "But no worries! You can re-download the skin via 'Skins Manager' ( Theme Panel - Theme Dashboard - Skins ).", 'sweat' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="sweat_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $sweat_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'sweat' );
			?>
		</a>
	</div>
</div>
