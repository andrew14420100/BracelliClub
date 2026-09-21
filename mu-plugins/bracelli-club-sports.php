<?php
/**
 * Plugin Name: Bracelli Club - Sports Archive Fix
 * Description: Mostra tutti gli sport pubblicati nell'archivio ThemeREX Services (/services/) senza limite di 4 elementi.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bracelli_show_all_sports_archive' ) ) {
	function bracelli_show_all_sports_archive( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		$services_post_type = defined( 'TRX_ADDONS_CPT_SERVICES_PT' )
			? TRX_ADDONS_CPT_SERVICES_PT
			: 'cpt_services';

		if ( $query->is_post_type_archive( $services_post_type ) ) {
			$query->set( 'posts_per_page', -1 );
			$query->set( 'nopaging', true );
			$query->set( 'paged', 1 );
		}
	}
	add_action( 'pre_get_posts', 'bracelli_show_all_sports_archive', 999 );
}
