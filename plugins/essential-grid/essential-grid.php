<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'sweat_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'sweat_essential_grid_theme_setup9', 9 );
	function sweat_essential_grid_theme_setup9() {
		if ( sweat_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'sweat_essential_grid_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'sweat_essential_grid_frontend_scripts', 10, 1 );
			add_filter( 'sweat_filter_merge_styles', 'sweat_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'sweat_filter_tgmpa_required_plugins', 'sweat_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'sweat_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('sweat_filter_tgmpa_required_plugins',	'sweat_essential_grid_tgmpa_required_plugins');
	function sweat_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( sweat_storage_isset( 'required_plugins', 'essential-grid' ) && sweat_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && sweat_is_theme_activated() ) {
			$path = sweat_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || sweat_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => sweat_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '2.2.4.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'sweat_exists_essential_grid' ) ) {
	function sweat_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'sweat_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'sweat_essential_grid_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'sweat_essential_grid_frontend_scripts', 10, 1 );
	function sweat_essential_grid_frontend_scripts( $force = false ) {
		sweat_enqueue_optimized( 'essential_grid', $force, array(
			'css' => array(
				'sweat-essential-grid' => array( 'src' => 'plugins/essential-grid/essential-grid.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'sweat_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('sweat_filter_merge_styles', 'sweat_essential_grid_merge_styles');
	function sweat_essential_grid_merge_styles( $list ) {
		$list[ 'plugins/essential-grid/essential-grid.css' ] = false;
		return $list;
	}
}
