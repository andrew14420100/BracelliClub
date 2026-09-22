<?php
/**
 * Plugin Name: Bracelli Club - Sports Display Fix
 * Description: Gestisce la griglia degli sport, le immagini dedicate e la pagina Listino.
 * Version: 1.3.0
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

/**
 * Recupera la scheda "Ginnastica artistica" anche se lo slug fosse stato
 * modificato manualmente in WordPress.
 */
function bracelli_get_artistic_gymnastics_post() {
	$post_type = defined( 'TRX_ADDONS_CPT_SERVICES_PT' )
		? TRX_ADDONS_CPT_SERVICES_PT
		: 'cpt_services';
	$post = get_page_by_path( 'ginnastica-artistica', OBJECT, $post_type );

	if ( $post instanceof WP_Post ) {
		return $post;
	}

	$matches = get_posts(
		array(
			'post_type'              => $post_type,
			'post_status'            => 'publish',
			'title'                  => 'Ginnastica artistica',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'suppress_filters'       => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	return ! empty( $matches ) ? $matches[0] : null;
}

/**
 * Importa una risorsa del tema nella Media Library una sola volta.
 */
function bracelli_import_sport_image( $relative_path, $asset_key, $title, $alt ) {
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key'       => '_bracelli_asset_key',
			'meta_value'     => $asset_key,
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$source = trailingslashit( get_template_directory() ) . ltrim( $relative_path, '/' );
	if ( ! is_readable( $source ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$tmp = wp_tempnam( basename( $source ) );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		return 0;
	}

	$file = array(
		'name'     => basename( $source ),
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file, 0, $title );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp );
		return 0;
	}

	update_post_meta( $id, '_bracelli_asset_key', $asset_key );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	return (int) $id;
}

/**
 * Imposta la foto dell'atleta come immagine in evidenza e prepara la foto
 * dello staff per il corpo della scheda sportiva.
 */
function bracelli_setup_artistic_gymnastics_images() {
	$post = bracelli_get_artistic_gymnastics_post();
	if ( ! $post ) {
		return;
	}

	$featured_id = bracelli_import_sport_image(
		'images/bracelli/ginnastica-artistica-in-evidenza.jpg',
		'ginnastica-artistica-in-evidenza-v1',
		'Ginnastica artistica - Bracelli Club',
		'Atleta di ginnastica artistica in salto'
	);
	$inside_id = bracelli_import_sport_image(
		'images/bracelli/ginnastica-artistica-staff.jpg',
		'ginnastica-artistica-staff-v1',
		'Staff Ginnastica artistica - Bracelli Club',
		'Staff Bracelli Club nella palestra di ginnastica artistica'
	);

	if ( $featured_id && (int) get_post_thumbnail_id( $post->ID ) !== $featured_id ) {
		set_post_thumbnail( $post->ID, $featured_id );
	}
	if ( $inside_id ) {
		update_post_meta( $post->ID, '_bracelli_ginnastica_inside_image_id', $inside_id );
	}
}
add_action( 'init', 'bracelli_setup_artistic_gymnastics_images', 30 );

/**
 * Inserisce la seconda fotografia in fondo al contenuto della sola scheda
 * Ginnastica artistica, senza duplicarla nell'editor o nelle anteprime.
 */
function bracelli_add_artistic_gymnastics_inside_image( $content ) {
	if ( is_admin() || ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$post = bracelli_get_artistic_gymnastics_post();
	if ( ! $post || (int) get_the_ID() !== (int) $post->ID ) {
		return $content;
	}

	$image_id = (int) get_post_meta( $post->ID, '_bracelli_ginnastica_inside_image_id', true );
	if ( ! $image_id ) {
		return $content;
	}

	$image = wp_get_attachment_image(
		$image_id,
		'full',
		false,
		array(
			'class'   => 'bracelli-ginnastica-artistic-staff',
			'loading' => 'lazy',
		)
	);

	return $content . '<figure class="wp-block-image size-full bracelli-ginnastica-artistic-staff-wrap">' . $image . '</figure>';
}
add_filter( 'the_content', 'bracelli_add_artistic_gymnastics_inside_image', 20 );

/**
 * Crea la pagina pubblica /listino/ con i tre fogli informativi forniti dal
 * centro sportivo. Le fotografie vengono prima importate nella Media Library,
 * così WordPress può generare le dimensioni responsive per desktop e mobile.
 */
function bracelli_create_listino_page() {
	$images = array(
		array(
			'path'  => 'images/bracelli/listino-ginnastica-danza.jpg',
			'key'   => 'listino-ginnastica-danza-2026-v1',
			'title' => 'Listino Ginnastica, Danza e Ballo 2026-2027',
			'alt'   => 'Listino corsi di ginnastica, danza e ballo Bracelli Club 2026-2027',
		),
		array(
			'path'  => 'images/bracelli/listino-arti-marziali-pattinaggio-calcio.jpg',
			'key'   => 'listino-arti-marziali-pattinaggio-calcio-2026-v1',
			'title' => 'Listino Arti marziali, Pattinaggio e Calcio 2026-2027',
			'alt'   => 'Listino corsi di arti marziali, pattinaggio artistico e calcio Bracelli Club 2026-2027',
		),
		array(
			'path'  => 'images/bracelli/listino-inizio-corsi-2026-2027.jpg',
			'key'   => 'listino-inizio-corsi-2026-2027-v1',
			'title' => 'Inizio corsi stagione 2026-2027',
			'alt'   => 'Date di inizio dei corsi Bracelli Club per la stagione 2026-2027',
		),
	);

	$attachment_ids = array();
	foreach ( $images as $image ) {
		$id = bracelli_import_sport_image( $image['path'], $image['key'], $image['title'], $image['alt'] );
		if ( $id ) {
			$attachment_ids[] = $id;
		}
	}

	// Attende il caricamento di tutti e tre i file prima di creare la pagina.
	if ( 3 !== count( $attachment_ids ) ) {
		return;
	}

	$page = get_page_by_path( 'listino', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		return;
	}

	$blocks = "<!-- bracelli-listino-2026 -->\n";
	foreach ( $attachment_ids as $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );
		$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		$blocks .= sprintf(
			"<!-- wp:image {\"id\":%1\$d,\"sizeSlug\":\"full\",\"linkDestination\":\"media\",\"align\":\"center\"} -->\n<figure class=\"wp-block-image aligncenter size-full\"><a href=\"%2\$s\"><img src=\"%2\$s\" alt=\"%3\$s\" class=\"wp-image-%1\$d\"/></a></figure>\n<!-- /wp:image -->\n",
			$attachment_id,
			esc_url( $url ),
			esc_attr( $alt )
		);
	}

	wp_insert_post(
		array(
			'post_title'   => 'Listino',
			'post_name'    => 'listino',
			'post_content' => $blocks,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
		true
	);
}
add_action( 'init', 'bracelli_create_listino_page', 40 );
