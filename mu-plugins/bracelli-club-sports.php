<?php
/**
 * Plugin Name: Bracelli Club - Sports Display Fix
 * Description: Mostra tutti gli sport pubblicati e li dispone 4 per riga nella pagina /our-services/.
 * Version: 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pagina "I nostri sport" (/our-services/):
 * - mostra tutti i Services pubblicati
 * - 4 colonne desktop, 2 tablet, 1 mobile
 * - nessun limite, slider o paginazione a 4 elementi
 */
if ( ! function_exists( 'bracelli_show_all_sports_on_our_services' ) ) {
	function bracelli_show_all_sports_on_our_services( $atts, $sc ) {
		if ( 'trx_sc_services' !== $sc || ! is_page( 'our-services' ) ) {
			return $atts;
		}

		$post_type = defined( 'TRX_ADDONS_CPT_SERVICES_PT' )
			? TRX_ADDONS_CPT_SERVICES_PT
			: 'cpt_services';
		$counts    = wp_count_posts( $post_type );
		$published = isset( $counts->publish ) ? (int) $counts->publish : 0;

		// Non limitare il widget a 4 sport o a una selezione manuale.
		$atts['ids']        = '';
		$atts['cat']        = '';
		$atts['offset']     = 0;
		$atts['count']      = $published > 0 ? $published : 999;
		$atts['pagination'] = 'none';
		$atts['slider']     = 0;

		// Griglia richiesta: 4 + 4 + 4 ...
		$atts['columns']        = 4;
		$atts['columns_tablet'] = 2;
		$atts['columns_mobile'] = 1;

		return $atts;
	}
	add_filter( 'trx_addons_filter_sc_prepare_atts', 'bracelli_show_all_sports_on_our_services', 999, 2 );
}

/**
 * Mantiene inoltre senza limite l'eventuale archivio nativo Services (/services/).
 */
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
