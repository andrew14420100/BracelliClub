<?php
/**
 * Skin Setup
 *
 * @package SWEAT
 * @since SWEAT 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'sweat_theme_defaults' ) ) {
	function sweat_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'sweat_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'sweat_filter_load_woocommerce_extensions', 'sweat_skin_woocommerce_allow_extensions' );
	function sweat_skin_woocommerce_allow_extensions( $allow ) {
		return true;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'sweat_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'sweat_skin_setup', 1 );
	function sweat_skin_setup() {

		$GLOBALS['SWEAT_STORAGE'] = array_merge( $GLOBALS['SWEAT_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-ancora',

			'theme_doc_url'       => '//doc.themerex.net/sweat/',

			'theme_demofiles_url' => '//demofiles.ancorathemes.com/sweat/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Ancora

			'theme_privacy_url'   => '//ancorathemes.com/privacy-policy/',                   // Ancora

			'portfolio_url'       => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'sweat_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'sweat_skin_setup_settings', 1 );
	function sweat_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		sweat_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		sweat_storage_set_array2( 'required_plugins', 'latepoint', 'install', false);
		sweat_storage_set_array2( 'required_plugins', 'woo-smart-quick-view', 'install', true );

	}
}

// Update Theme Options elements
if ( ! function_exists( 'sweat_skin_options_theme_setup2' ) ) {
	add_action( 'after_setup_theme', 'sweat_skin_options_theme_setup2', 4 );
	function sweat_skin_options_theme_setup2() {
		sweat_storage_set_array2( 'options', 'color_scheme', 'std', 'light');
		sweat_storage_set_array2( 'options', 'sidebar_scheme', 'std', 'light');
	}
}


//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'sweat_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'sweat_skin_setup_fonts', 1 );
	function sweat_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		sweat_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Oswald',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'wght@300;400;500;600;700',
				),
                array(
                    'name'   => 'Roboto',
                    'family' => 'sans-serif',
                    'link'   => '',
                    'styles' => 'ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700',
                ),
                array(
					'name'   => 'Lora',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		sweat_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => sweat_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'sweat' );

		sweat_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'sweat' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'sweat' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '3.167em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.08em',
					'margin-bottom'   => '0.52em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '2.611em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.77em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.944em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.556em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.333em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.056em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.2px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'sweat' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.1px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'sweat' ) ),
					'font-family'     => 'Oswald,sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.65px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'sweat' ) ),
					'font-family'     => 'Roboto,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'sweat' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'sweat' ) ),
					'font-family'     => 'Lora,sans-serif',
				),
			)
		);

		// Font presets
		sweat_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'sweat' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'sweat' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'sweat' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'sweat_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'sweat_skin_setup_schemes', 1 );
	function sweat_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		sweat_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'sweat' ),
					'description' => esc_html__( 'Colors of the main content area', 'sweat' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'sweat' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'sweat' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'sweat' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'sweat' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'sweat' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'sweat' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'sweat' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'sweat' ),
				),
			)
		);

		sweat_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'sweat' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'sweat' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'sweat' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'sweat' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'sweat' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'sweat' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'sweat' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'sweat' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'sweat' ),
					'description' => esc_html__( 'Color of the text inside this block', 'sweat' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'sweat' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'sweat' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'sweat' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'sweat' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'sweat' ),
					'description' => esc_html__( 'Color of the links inside this block', 'sweat' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'sweat' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'sweat' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'sweat' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'sweat' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'sweat' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'sweat' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'sweat' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'sweat' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'sweat' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'sweat' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F4F4', //
					'bd_color'         => '#C6C6C6', //

					// Text and links colors
					'text'             => '#6B6B6B', //
					'text_light'       => '#8B8686', //
					'text_dark'        => '#060303', //
					'text_link'        => '#FFAB00', //
					'text_hover'       => '#E39903', //
					'text_link2'       => '#C10000', //
					'text_hover2'      => '#A20000', //
					'text_link3'       => '#28B8CD', //
					'text_hover3'      => '#12A7BC', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#E8E8E8', //
					'alter_bd_color'   => '#C6C6C6', //
					'alter_bd_hover'   => '#A6A6A6', //
					'alter_text'       => '#6B6B6B', //
					'alter_light'      => '#8B8686', //
					'alter_dark'       => '#060303', //
					'alter_link'       => '#FFAB00', //
					'alter_hover'      => '#E39903', //
					'alter_link2'      => '#C10000', //
					'alter_hover2'     => '#A20000', //
					'alter_link3'      => '#28B8CD', //
					'alter_hover3'     => '#12A7BC', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //
					'extra_bg_hover'   => '#212121', //
					'extra_bd_color'   => '#3A3A3A', //
					'extra_bd_hover'   => '#525252', //
					'extra_text'       => '#CDCDCD', //
					'extra_light'      => '#9C9C9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#FFAB00', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C6C6C6', //
					'input_bd_hover'   => '#060303', //
					'input_text'       => '#8B8686', //
					'input_light'      => '#8B8686', //
					'input_dark'       => '#060303', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#060303', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#FFFEFE', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#090909', //
					'bd_color'         => '#3A3A3A', //

					// Text and links colors
					'text'             => '#CDCDCD', //
					'text_light'       => '#9C9C9C', //
					'text_dark'        => '#FFFEFE', //
					'text_link'        => '#FFAB00', //
					'text_hover'       => '#E39903', //
					'text_link2'       => '#C10000', //
					'text_hover2'      => '#A20000', //
					'text_link3'       => '#28B8CD', //
					'text_hover3'      => '#12A7BC', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#060303', //
					'alter_bg_hover'   => '#090909', //
					'alter_bd_color'   => '#212121', //
					'alter_bd_hover'   => '#525252', //
					'alter_text'       => '#CDCDCD', //
					'alter_light'      => '#9C9C9C', //
					'alter_dark'       => '#FFFEFE', //
					'alter_link'       => '#FFAB00', //
					'alter_hover'      => '#E39903', //
					'alter_link2'      => '#C10000', //
					'alter_hover2'     => '#A20000', //
					'alter_link3'      => '#28B8CD', //
					'alter_hover3'     => '#12A7BC', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //
					'extra_bg_hover'   => '#212121', //
					'extra_bd_color'   => '#3A3A3A', //
					'extra_bd_hover'   => '#525252', //
					'extra_text'       => '#CDCDCD', //
					'extra_light'      => '#9C9C9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#FFAB00', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#212121', //
					'input_bd_hover'   => '#212121', //
					'input_text'       => '#CDCDCD', //
					'input_light'      => '#CDCDCD', //
					'input_dark'       => '#FFFEFE', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650', //
					'inverse_bd_hover' => '#cb5b47', //
					'inverse_text'     => '#FFFEFE', //
					'inverse_light'    => '#6f6f6f', //
					'inverse_dark'     => '#060303', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#060303', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#C6C6C6', //

					// Text and links colors
					'text'             => '#6B6B6B', //
					'text_light'       => '#8B8686', //
					'text_dark'        => '#060303', //
					'text_link'        => '#FFAB00', //
					'text_hover'       => '#E39903', //
					'text_link2'       => '#C10000', //
					'text_hover2'      => '#A20000', //
					'text_link3'       => '#28B8CD', //
					'text_hover3'      => '#12A7BC', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F4F4F4', //
					'alter_bg_hover'   => '#ffffff', //
					'alter_bd_color'   => '#C6C6C6', //
					'alter_bd_hover'   => '#A6A6A6', //
					'alter_text'       => '#6B6B6B', //
					'alter_light'      => '#8B8686', //
					'alter_dark'       => '#060303', //
					'alter_link'       => '#FFAB00', //
					'alter_hover'      => '#E39903', //
					'alter_link2'      => '#C10000', //
					'alter_hover2'     => '#A20000', //
					'alter_link3'      => '#28B8CD', //
					'alter_hover3'     => '#12A7BC', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //
					'extra_bg_hover'   => '#212121', //
					'extra_bd_color'   => '#3A3A3A', //
					'extra_bd_hover'   => '#525252', //
					'extra_text'       => '#CDCDCD', //
					'extra_light'      => '#9C9C9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#FFAB00', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C6C6C6', //
					'input_bd_hover'   => '#060303', //
					'input_text'       => '#8B8686', //
					'input_light'      => '#8B8686', //
					'input_dark'       => '#060303', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#060303', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#FFFEFE', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'beige'
			'beige' => array(
				'title'    => esc_html__( 'Beige', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F2EBE1', //
					'bd_color'         => '#C1BCB4', //

					// Text and links colors
					'text'             => '#716F6E', //
					'text_light'       => '#918D87', //
					'text_dark'        => '#17130E', //
					'text_link'        => '#D72D26', //
					'text_hover'       => '#C12822', //
					'text_link2'       => '#187A83', //
					'text_hover2'      => '#156D75', //
					'text_link3'       => '#8DC823', //
					'text_hover3'      => '#7EB41F', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#EDE4D7', //
					'alter_bd_color'   => '#C1BCB4', //
					'alter_bd_hover'   => '#A9A49D', //
					'alter_text'       => '#716F6E', //
					'alter_light'      => '#918D87', //
					'alter_dark'       => '#17130E', //
					'alter_link'       => '#D72D26', //
					'alter_hover'      => '#C12822', //
					'alter_link2'      => '#187A83', //
					'alter_hover2'     => '#156D75', //
					'alter_link3'      => '#8DC823', //
					'alter_hover3'     => '#7EB41F', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#242424', //
					'extra_bg_hover'   => '#2E2E2E', //
					'extra_bd_color'   => '#3B3B3B', //
					'extra_bd_hover'   => '#494949', //
					'extra_text'       => '#CBC9C9', //
					'extra_light'      => '#AEADAD', //
					'extra_dark'       => '#FCF9F9', //
					'extra_link'       => '#D72D26', //
					'extra_hover'      => '#FCF9F9', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C1BCB4', //
					'input_bd_hover'   => '#17130E', //
					'input_text'       => '#918D87', //
					'input_light'      => '#918D87', //
					'input_dark'       => '#17130E', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#17130E', //
					'inverse_link'     => '#FCF9F9', //
					'inverse_hover'    => '#FCF9F9', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'beige_dark'
			'beige_dark'    => array(
				'title'    => esc_html__( 'Beige Dark', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#161616', //
					'bd_color'         => '#3B3B3B', //

					// Text and links colors
					'text'             => '#CBC9C9', //
					'text_light'       => '#AEADAD', //
					'text_dark'        => '#FCF9F9', //
					'text_link'        => '#D72D26', //
					'text_hover'       => '#C12822', //
					'text_link2'       => '#187A83', //
					'text_hover2'      => '#156D75', //
					'text_link3'       => '#8DC823', //
					'text_hover3'      => '#7EB41F', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#17130E', //
					'alter_bg_hover'   => '#161616', //
					'alter_bd_color'   => '#3B3B3B', //
					'alter_bd_hover'   => '#494949', //
					'alter_text'       => '#CBC9C9', //
					'alter_light'      => '#AEADAD', //
					'alter_dark'       => '#FCF9F9', //
					'alter_link'       => '#D72D26', //
					'alter_hover'      => '#C12822', //
					'alter_link2'      => '#187A83', //
					'alter_hover2'     => '#156D75', //
					'alter_link3'      => '#8DC823', //
					'alter_hover3'     => '#7EB41F', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#242424', //
					'extra_bg_hover'   => '#2E2E2E', //
					'extra_bd_color'   => '#3B3B3B', //
					'extra_bd_hover'   => '#494949', //
					'extra_text'       => '#CBC9C9', //
					'extra_light'      => '#AEADAD', //
					'extra_dark'       => '#FCF9F9', //
					'extra_link'       => '#D72D26', //
					'extra_hover'      => '#FCF9F9', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#2E2E2E', //
					'input_bd_hover'   => '#2E2E2E', //
					'input_text'       => '#CBC9C9', //
					'input_light'      => '#CBC9C9', //
					'input_dark'       => '#FCF9F9', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650', //
					'inverse_bd_hover' => '#cb5b47', //
					'inverse_text'     => '#FCF9F9', //
					'inverse_light'    => '#6f6f6f', //
					'inverse_dark'     => '#17130E', //
					'inverse_link'     => '#FCF9F9', //
					'inverse_hover'    => '#17130E', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'beige_default'
			'beige_light' => array(
				'title'    => esc_html__( 'Beige Light', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#C1BCB4', //

					// Text and links colors
					'text'             => '#716F6E', //
					'text_light'       => '#918D87', //
					'text_dark'        => '#17130E', //
					'text_link'        => '#D72D26', //
					'text_hover'       => '#C12822', //
					'text_link2'       => '#187A83', //
					'text_hover2'      => '#156D75', //
					'text_link3'       => '#8DC823', //
					'text_hover3'      => '#7EB41F', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F2EBE1', //
					'alter_bg_hover'   => '#ffffff', //
					'alter_bd_color'   => '#C1BCB4', //
					'alter_bd_hover'   => '#A9A49D', //
					'alter_text'       => '#716F6E', //
					'alter_light'      => '#918D87', //
					'alter_dark'       => '#17130E', //
					'alter_link'       => '#D72D26', //
					'alter_hover'      => '#C12822', //
					'alter_link2'      => '#187A83', //
					'alter_hover2'     => '#156D75', //
					'alter_link3'      => '#8DC823', //
					'alter_hover3'     => '#7EB41F', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#242424', //
					'extra_bg_hover'   => '#2E2E2E', //
					'extra_bd_color'   => '#3B3B3B', //
					'extra_bd_hover'   => '#494949', //
					'extra_text'       => '#CBC9C9', //
					'extra_light'      => '#AEADAD', //
					'extra_dark'       => '#FCF9F9', //
					'extra_link'       => '#D72D26', //
					'extra_hover'      => '#FCF9F9', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C1BCB4', //
					'input_bd_hover'   => '#17130E', //
					'input_text'       => '#918D87', //
					'input_light'      => '#918D87', //
					'input_dark'       => '#17130E', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#17130E', //
					'inverse_link'     => '#FCF9F9', //
					'inverse_hover'    => '#FCF9F9', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'green'
			'green' => array(
				'title'    => esc_html__( 'Green', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F3FCF8', //
					'bd_color'         => '#C9D9D3', //

					// Text and links colors
					'text'             => '#797F7C', //
					'text_light'       => '#A5AAA7', //
					'text_dark'        => '#041910', //
					'text_link'        => '#147E52', //
					'text_hover'       => '#36906B', //
					'text_link2'       => '#2F39D3', //
					'text_hover2'      => '#212BC3', //
					'text_link3'       => '#D14734', //
					'text_hover3'      => '#B83E2D', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#E7F2ED', //
					'alter_bd_color'   => '#C9D9D3', //
					'alter_bd_hover'   => '#B3C0BB', //
					'alter_text'       => '#797F7C', //
					'alter_light'      => '#A5AAA7', //
					'alter_dark'       => '#041910', //
					'alter_link'       => '#147E52', //
					'alter_hover'      => '#36906B', //
					'alter_link2'      => '#2F39D3', //
					'alter_hover2'     => '#212BC3', //
					'alter_link3'      => '#D14734', //
					'alter_hover3'     => '#B83E2D', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020C08', //
					'extra_bg_hover'   => '#16241E', //
					'extra_bd_color'   => '#3C4744', //
					'extra_bd_hover'   => '#535C59', //
					'extra_text'       => '#D2D5D4', //
					'extra_light'      => '#969F9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#147E52', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C9D9D3', //
					'input_bd_hover'   => '#041910', //
					'input_text'       => '#A5AAA7', //
					'input_light'      => '#A5AAA7', //
					'input_dark'       => '#041910', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#041910', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#FFFEFE', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'green_dark'
			'green_dark'    => array(
				'title'    => esc_html__( 'Green Dark', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#062518', //
					'bd_color'         => '#3C4744', //

					// Text and links colors
					'text'             => '#D2D5D4', //
					'text_light'       => '#969F9C', //
					'text_dark'        => '#FFFEFE', //
					'text_link'        => '#147E52', //
					'text_hover'       => '#36906B', //
					'text_link2'       => '#2F39D3', //
					'text_hover2'      => '#212BC3', //
					'text_link3'       => '#D14734', //
					'text_hover3'      => '#B83E2D', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#172D24', //
					'alter_bg_hover'   => '#384B43', //
					'alter_bd_color'   => '#3C4744', //
					'alter_bd_hover'   => '#535C59', //
					'alter_text'       => '#D2D5D4', //
					'alter_light'      => '#969F9C', //
					'alter_dark'       => '#FFFEFE', //
					'alter_link'       => '#147E52', //
					'alter_hover'      => '#36906B', //
					'alter_link2'      => '#2F39D3', //
					'alter_hover2'     => '#212BC3', //
					'alter_link3'      => '#D14734', //
					'alter_hover3'     => '#B83E2D', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020C08', //
					'extra_bg_hover'   => '#16241E', //
					'extra_bd_color'   => '#3C4744', //
					'extra_bd_hover'   => '#535C59', //
					'extra_text'       => '#D2D5D4', //
					'extra_light'      => '#969F9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#147E52', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#3C4744', //
					'input_bd_hover'   => '#3C4744', //
					'input_text'       => '#D2D5D4', //
					'input_light'      => '#D2D5D4', //
					'input_dark'       => '#FFFEFE', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650', //
					'inverse_bd_hover' => '#cb5b47', //
					'inverse_text'     => '#FFFEFE', //
					'inverse_light'    => '#6f6f6f', //
					'inverse_dark'     => '#041910', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#041910', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'green_default'
			'green_light' => array(
				'title'    => esc_html__( 'Green Light', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#C9D9D3', //

					// Text and links colors
					'text'             => '#797F7C', //
					'text_light'       => '#A5AAA7', //
					'text_dark'        => '#041910', //
					'text_link'        => '#147E52', //
					'text_hover'       => '#36906B', //
					'text_link2'       => '#2F39D3', //
					'text_hover2'      => '#212BC3', //
					'text_link3'       => '#D14734', //
					'text_hover3'      => '#B83E2D', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F3FCF8', //
					'alter_bg_hover'   => '#ffffff', //
					'alter_bd_color'   => '#C9D9D3', //
					'alter_bd_hover'   => '#B3C0BB', //
					'alter_text'       => '#797F7C', //
					'alter_light'      => '#A5AAA7', //
					'alter_dark'       => '#041910', //
					'alter_link'       => '#147E52', //
					'alter_hover'      => '#36906B', //
					'alter_link2'      => '#2F39D3', //
					'alter_hover2'     => '#212BC3', //
					'alter_link3'      => '#D14734', //
					'alter_hover3'     => '#B83E2D', //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#020C08', //
					'extra_bg_hover'   => '#16241E', //
					'extra_bd_color'   => '#3C4744', //
					'extra_bd_hover'   => '#535C59', //
					'extra_text'       => '#D2D5D4', //
					'extra_light'      => '#969F9C', //
					'extra_dark'       => '#FFFEFE', //
					'extra_link'       => '#147E52', //
					'extra_hover'      => '#FFFEFE', //
					'extra_link2'      => '#80d572', //
					'extra_hover2'     => '#8be77c', //
					'extra_link3'      => '#ddb837', //
					'extra_hover3'     => '#eec432', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C9D9D3', //
					'input_bd_hover'   => '#041910', //
					'input_text'       => '#A5AAA7', //
					'input_light'      => '#A5AAA7', //
					'input_dark'       => '#041910', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1', //
					'inverse_bd_hover' => '#5aa4a9', //
					'inverse_text'     => '#1d1d1d', //
					'inverse_light'    => '#333333', //
					'inverse_dark'     => '#041910', //
					'inverse_link'     => '#FFFEFE', //
					'inverse_hover'    => '#FFFEFE', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'ghost_smoke'
			'ghost_smoke' => array(
				'title'    => esc_html__( 'Ghost Smoke', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F9F9F9',
					'bd_color'         => '#E3E3E3',

					// Text and links colors
					'text'             => '#7F7979',
					'text_light'       => '#AAA5A5',
					'text_dark'        => '#171414',
					'text_link'        => '#D7362A',
					'text_hover'       => '#C32F24',
					'text_link2'       => '#1C7784',
					'text_hover2'      => '#126B77',
					'text_link3'       => '#D78D2A',
					'text_hover3'      => '#C98325',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff',
					'alter_bg_hover'   => '#F0F0F0',
					'alter_bd_color'   => '#E3E3E3',
					'alter_bd_hover'   => '#C3C3C3',
					'alter_text'       => '#7F7979',
					'alter_light'      => '#AAA5A5',
					'alter_dark'       => '#171414',
					'alter_link'       => '#D7362A',
					'alter_hover'      => '#C32F24',
					'alter_link2'      => '#1C7784',
					'alter_hover2'     => '#126B77',
					'alter_link3'      => '#D78D2A',
					'alter_hover3'     => '#C98325',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1D1E22',
					'extra_bg_hover'   => '#131416',
					'extra_bd_color'   => '#3A3A3A',
					'extra_bd_hover'   => '#525252',
					'extra_text'       => '#CCCBC9',
					'extra_light'      => '#A5A19F',
					'extra_dark'       => '#F7F7F7',
					'extra_link'       => '#D7362A',
					'extra_hover'      => '#F7F7F7',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#E3E3E3',
					'input_bd_hover'   => '#171414',
					'input_text'       => '#AAA5A5',
					'input_light'      => '#AAA5A5',
					'input_dark'       => '#171414',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#171414',
					'inverse_link'     => '#F7F7F7',
					'inverse_hover'    => '#F7F7F7',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'ghost_smoke_dark'
			'ghost_smoke_dark'    => array(
				'title'    => esc_html__( 'Ghost Smoke Dark', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#0D0D0D',
					'bd_color'         => '#3A3A3A',

					// Text and links colors
					'text'             => '#CCCBC9',
					'text_light'       => '#A5A19F',
					'text_dark'        => '#F7F7F7',
					'text_link'        => '#D7362A',
					'text_hover'       => '#C32F24',
					'text_link2'       => '#1C7784',
					'text_hover2'      => '#126B77',
					'text_link3'       => '#D78D2A',
					'text_hover3'      => '#C98325',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#040404',
					'alter_bg_hover'   => '#0D0D0D',
					'alter_bd_color'   => '#3A3A3A',
					'alter_bd_hover'   => '#525252',
					'alter_text'       => '#CCCBC9',
					'alter_light'      => '#A5A19F',
					'alter_dark'       => '#F7F7F7',
					'alter_link'       => '#D7362A',
					'alter_hover'      => '#C32F24',
					'alter_link2'      => '#1C7784',
					'alter_hover2'     => '#126B77',
					'alter_link3'      => '#D78D2A',
					'alter_hover3'     => '#C98325',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1D1E22',
					'extra_bg_hover'   => '#131416',
					'extra_bd_color'   => '#3A3A3A',
					'extra_bd_hover'   => '#525252',
					'extra_text'       => '#CCCBC9',
					'extra_light'      => '#A5A19F',
					'extra_dark'       => '#F7F7F7',
					'extra_link'       => '#D7362A',
					'extra_hover'      => '#F7F7F7',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#3A3A3A',
					'input_bd_hover'   => '#3A3A3A',
					'input_text'       => '#CCCBC9',
					'input_light'      => '#CCCBC9',
					'input_dark'       => '#F7F7F7',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F7F7F7',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#171414',
					'inverse_link'     => '#F7F7F7',
					'inverse_hover'    => '#171414',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'ghost_smoke_default'
			'ghost_smoke_light' => array(
				'title'    => esc_html__( 'Ghost Smoke Light', 'sweat' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff',
					'bd_color'         => '#E3E3E3',

					// Text and links colors
					'text'             => '#7F7979',
					'text_light'       => '#AAA5A5',
					'text_dark'        => '#171414',
					'text_link'        => '#D7362A',
					'text_hover'       => '#C32F24',
					'text_link2'       => '#1C7784',
					'text_hover2'      => '#126B77',
					'text_link3'       => '#D78D2A',
					'text_hover3'      => '#C98325',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F9F9',
					'alter_bg_hover'   => '#ffffff',
					'alter_bd_color'   => '#E3E3E3',
					'alter_bd_hover'   => '#C3C3C3',
					'alter_text'       => '#7F7979',
					'alter_light'      => '#AAA5A5',
					'alter_dark'       => '#171414',
					'alter_link'       => '#D7362A',
					'alter_hover'      => '#C32F24',
					'alter_link2'      => '#1C7784',
					'alter_hover2'     => '#126B77',
					'alter_link3'      => '#D78D2A',
					'alter_hover3'     => '#C98325',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1D1E22',
					'extra_bg_hover'   => '#131416',
					'extra_bd_color'   => '#3A3A3A',
					'extra_bd_hover'   => '#525252',
					'extra_text'       => '#CCCBC9',
					'extra_light'      => '#A5A19F',
					'extra_dark'       => '#F7F7F7',
					'extra_link'       => '#D7362A',
					'extra_hover'      => '#F7F7F7',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#E3E3E3',
					'input_bd_hover'   => '#171414',
					'input_text'       => '#AAA5A5',
					'input_light'      => '#AAA5A5',
					'input_dark'       => '#171414',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#171414',
					'inverse_link'     => '#F7F7F7',
					'inverse_hover'    => '#F7F7F7',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		sweat_storage_set( 'schemes', $schemes );
		sweat_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> sweat_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'sweat' ),
		//---> 	'description' => __( 'Description of the new color 1', 'sweat' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		sweat_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_08' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.8,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		sweat_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		sweat_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		sweat_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'sweat' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'sweat' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}

// Enqueue extra styles for frontend
if ( ! function_exists( 'sweat_clone_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'sweat_clone_frontend_scripts', 1350 );
	function sweat_clone_frontend_scripts() {
		$sweat_url = sweat_get_file_url( sweat_skins_get_current_skin_dir() . 'extra-styles.css' );
		if ( '' != $sweat_url ) {
			wp_enqueue_style( 'sweat-extra-skin-' . esc_attr( sweat_skins_get_current_skin_name() ), $sweat_url, array(), null );
		}
	}
}

// Add additional height for Spacer and Divider
if ( ! function_exists( 'sweat_clone_add_additional_spacer' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_empty_space_heights', 'sweat_clone_add_additional_spacer' );
	function sweat_clone_add_additional_spacer( $spaser ) {
		sweat_array_insert_after( $spaser, 'huge', [ 'extra_huge' => esc_html__( 'Extra Huge', 'sweat' ) ] );
		return $spaser;
	}
}

// Activation methods
if ( ! function_exists( 'sweat_skin_filter_activation_methods2' ) ) {
	add_filter( 'trx_addons_filter_activation_methods', 'sweat_skin_filter_activation_methods2', 11, 1 );
	function sweat_skin_filter_activation_methods2( $args ) {
		$args['elements_key'] = true;
		return $args;
	}
}