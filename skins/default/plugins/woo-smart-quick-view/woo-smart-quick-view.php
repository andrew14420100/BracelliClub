<?php
/* WPC Smart Quick View for WooCommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('sweat_quick_view_theme_setup9')) {
	add_action( 'after_setup_theme', 'sweat_quick_view_theme_setup9', 9 );
	function sweat_quick_view_theme_setup9() {
		if (sweat_exists_quick_view()) {
			add_action( 'wp_enqueue_scripts', 'sweat_quick_view_frontend_scripts', 1100 );
			add_filter( 'sweat_filter_merge_styles', 'sweat_quick_view_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'sweat_filter_tgmpa_required_plugins',		'sweat_quick_view_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'sweat_quick_view_tgmpa_required_plugins' ) ) {
	function sweat_quick_view_tgmpa_required_plugins($list=array()) {
		if (sweat_storage_isset( 'required_plugins', 'woocommerce' ) && sweat_storage_get_array( 'required_plugins', 'woocommerce', 'install' ) !== false &&
			sweat_storage_isset('required_plugins', 'woo-smart-quick-view') && sweat_storage_get_array( 'required_plugins', 'woo-smart-quick-view', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> sweat_storage_get_array('required_plugins', 'woo-smart-quick-view', 'title'),
				'slug' 		=> 'woo-smart-quick-view',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'sweat_exists_quick_view' ) ) {
	function sweat_exists_quick_view() {
		return function_exists('woosq_init');
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'sweat_quick_view_frontend_scripts' ) ) {
	function sweat_quick_view_frontend_scripts() {
		if ( sweat_is_on( sweat_get_theme_option( 'debug_mode' ) ) ) {
			$sweat_url = sweat_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.css' );
			if ( '' != $sweat_url ) {
				wp_enqueue_style( 'sweat-woo-smart-quick-view', $sweat_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'sweat_quick_view_merge_styles' ) ) {
	function sweat_quick_view_merge_styles( $list ) {
		$list['plugins/woo-smart-quick-view/woo-smart-quick-view.css'] = true;
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( sweat_exists_quick_view() ) {
	require_once sweat_get_file_dir( 'plugins/woo-smart-quick-view/woo-smart-quick-view-style.php' );
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'sweat_quick_view_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'sweat_quick_view_importer_required_plugins', 10, 2 );
    function sweat_quick_view_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'woo-smart-quick-view')!==false && !sweat_exists_quick_view() )
            $not_installed .= '<br>' . esc_html__('WPC Smart Quick View for WooCommerce', 'sweat');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'sweat_quick_view_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'sweat_quick_view_importer_set_options' );
    function sweat_quick_view_importer_set_options($options=array()) {
        if ( sweat_exists_quick_view() && in_array('woo-smart-quick-view', $options['required_plugins']) ) {
            $options['additional_options'][] = 'woosq_%';
        }
        return $options;
    }
}