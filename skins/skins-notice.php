<?php
/**
 * The template to display Admin notices
 *
 * @package SWEAT
 * @since SWEAT 1.0.64
 */

$sweat_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$sweat_skins_args = get_query_var( 'sweat_skins_notice_args' );
?>
<div class="sweat_admin_notice sweat_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'sweat' ); ?>
	</h3>
	<?php

	// Description
	$sweat_total      = $sweat_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$sweat_skins_msg  = $sweat_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $sweat_total, 'sweat' ), $sweat_total ) . '</strong>'
							: '';
	$sweat_total      = $sweat_skins_args['free'];
	$sweat_skins_msg .= $sweat_total > 0
							? ( ! empty( $sweat_skins_msg ) ? ' ' . esc_html__( 'and', 'sweat' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $sweat_total, 'sweat' ), $sweat_total ) . '</strong>'
							: '';
	$sweat_total      = $sweat_skins_args['pay'];
	$sweat_skins_msg .= $sweat_skins_args['pay'] > 0
							? ( ! empty( $sweat_skins_msg ) ? ' ' . esc_html__( 'and', 'sweat' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $sweat_total, 'sweat' ), $sweat_total ) . '</strong>'
							: '';
	?>
	<div class="sweat_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'sweat' ), $sweat_skins_msg ) );
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
			esc_html_e( 'Go to Skins manager', 'sweat' );
			?>
		</a>
		<?php
		// Dismiss notice for 7 days
		?>
		<a href="#" role="button" class="button button-secondary sweat_notice_button_dismiss" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Dismiss', 'sweat' );
			?>
		</a>
		<?php
		// Hide notice forever
		?>
		<a href="#" role="button" class="button button-secondary sweat_notice_button_hide" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Never show again', 'sweat' );
			?>
		</a>
	</div>
</div>
