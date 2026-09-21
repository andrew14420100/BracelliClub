<?php
/**
 * Skin Demo importer
 *
 * @package SWEAT
 * @since SWEAT 1.76.0
 */


// Theme storage
//-------------------------------------------------------------------------

sweat_storage_set( 'theme_demo_url', '//sweat.ancorathemes.com' );


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'sweat_skin_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'sweat_skin_importer_set_options', 9 );
	function sweat_skin_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			$demo_type = function_exists( 'sweat_skins_get_current_skin_name' ) ? sweat_skins_get_current_skin_name() : 'default';
			if ( 'default' != $demo_type ) {
				$options['demo_type'] = $demo_type;
				$options['files'][ $demo_type ] = $options['files']['default'];
				unset($options['files']['default']);
			}
			$options['files'][ $demo_type ]['title']       = esc_html__( 'Sweat Demo', 'sweat' );
			$options['files'][ $demo_type ]['domain_dev']  = '';  // Developers domain
			$options['files'][ $demo_type ]['domain_demo'] = sweat_storage_get( 'theme_demo_url' ); // Demo-site domain

			if ( substr( $options['files'][ $demo_type ]['domain_demo'], 0, 2 ) === '//' ) {
				$options['files'][ $demo_type ]['domain_demo'] = sweat_get_protocol() . ':' . $options['files'][ $demo_type ]['domain_demo'];
			}
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'sweat_skin_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'sweat_skin_ocdi_set_options', 9 );
	function sweat_skin_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Sweat OCDI Demo', 'sweat' );
			$options['files']['ocdi']['domain_demo'] = sweat_storage_get( 'theme_demo_url' );
			if ( substr( $options['files']['ocdi']['domain_demo'], 0, 2 ) === '//' ) {
				$options['files']['ocdi']['domain_demo'] = sweat_get_protocol() . ':' . $options['files']['ocdi']['domain_demo'];
			}
			// If theme need more demo - just copy 'default' and change required parameters
		}
		return $options;
	}
}
