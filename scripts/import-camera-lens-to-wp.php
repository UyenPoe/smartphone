<?php
/**
 * Import Crawled Camera Lens Protectors into WooCommerce
 *
 * Reads phonex-theme/data/camera-lens.json and creates/updates products
 * in categories 'mieng-dan-camera', 'dan-camera-iphone'
 * and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/camera-lens.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/camera-lens.json';
}

if ( ! file_exists( $json_path ) ) {
	echo "JSON file not found: {$json_path}\n";
	exit( 1 );
}

$data = json_decode( file_get_contents( $json_path ), true );
if ( empty( $data ) ) {
	echo "Empty JSON data.\n";
	exit( 1 );
}

echo "Found " . count( $data ) . " camera lens protector products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'mieng-dan-camera' exists
$term_cam = term_exists( 'mieng-dan-camera', 'product_cat' );
if ( ! $term_cam ) {
	$term_cam = wp_insert_term(
		'Miếng Dán Bảo Vệ Camera',
		'product_cat',
		array(
			'slug'        => 'mieng-dan-camera',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập kính cường lực bảo vệ cụm camera, viền hợp kim nhôm, viền Titanium và kính Sapphire cho iPhone, Samsung.',
		)
	);
}
$cam_id = is_array( $term_cam ) ? $term_cam['term_id'] : $term_cam;

// Subcategory 'dan-camera-iphone'
$term_iphone = term_exists( 'dan-camera-iphone', 'product_cat' );
if ( ! $term_iphone ) {
	$term_iphone = wp_insert_term(
		'Dán Camera iPhone',
		'product_cat',
		array(
			'slug'        => 'dan-camera-iphone',
			'parent'      => $cam_id,
			'description' => 'Miếng dán camera viền Titanium, viền nhôm cho iPhone 16 Pro, 15 Pro Max, 14, 13.',
		)
	);
}
$iphone_id = is_array( $term_iphone ) ? $term_iphone['term_id'] : $term_iphone;

// Brand taxonomy registration check
if ( ! taxonomy_exists( 'product_brand' ) ) {
	register_taxonomy( 'product_brand', 'product', array(
		'hierarchical' => false,
		'label'        => 'Thương hiệu',
		'query_var'    => true,
		'rewrite'      => array( 'slug' => 'brand' ),
	) );
}

$imported = 0;
$updated  = 0;

foreach ( $data as $idx => $prod ) {
	$name     = sanitize_text_field( $prod['name'] );
	$price    = (float) ( $prod['price'] ?? 0 );
	$old_p    = (float) ( $prod['price_old'] ?? 0 );
	$brand    = sanitize_text_field( $prod['brand'] ?? 'PhoneX Care' );
	$device   = $prod['device_brand'] ?? 'iPhone';
	$type     = $prod['type'] ?? 'Kính bảo vệ Camera';
	$material = $prod['material'] ?? '';
	$specs    = $prod['specs'] ?? array();
	$img_rel  = $prod['image'] ?? '';
	$source   = $prod['source_url'] ?? '';

	// Assigned categories
	$assigned_cats = array( $phukien_id, $cam_id, $iphone_id );

	// Check if product exists by title
	$existing = get_page_by_title( $name, OBJECT, 'product' );
	$product_id = 0;

	if ( $existing ) {
		$product_id = $existing->ID;
		$updated++;
	} else {
		$post_data = array(
			'post_title'   => $name,
			'post_content' => '<p>' . esc_html( implode( ' • ', $specs ) ) . '</p>',
			'post_status'  => 'publish',
			'post_type'    => 'product',
		);
		$product_id = wp_insert_post( $post_data );
		if ( is_wp_error( $product_id ) ) {
			continue;
		}
		$imported++;
	}

	// Update WooCommerce product metas
	wp_set_object_terms( $product_id, 'simple', 'product_type' );
	wp_set_object_terms( $product_id, $assigned_cats, 'product_cat' );

	if ( ! empty( $brand ) ) {
		wp_set_object_terms( $product_id, $brand, 'product_brand' );
	}

	update_post_meta( $product_id, '_visibility', 'visible' );
	update_post_meta( $product_id, '_stock_status', 'instock' );
	update_post_meta( $product_id, '_regular_price', $old_p > $price ? $old_p : $price );
	update_post_meta( $product_id, '_sale_price', $old_p > $price ? $price : '' );
	update_post_meta( $product_id, '_price', $price );
	update_post_meta( $product_id, '_sku', 'PX-CAM-' . str_pad( $idx + 1, 4, '0', STR_PAD_LEFT ) );
	update_post_meta( $product_id, '_phonex_specs', json_encode( $specs, JSON_UNESCAPED_UNICODE ) );
	update_post_meta( $product_id, '_phonex_local_image', $img_rel );
	update_post_meta( $product_id, '_phonex_device_brand', $device );
	update_post_meta( $product_id, '_phonex_material', $material );
	update_post_meta( $product_id, '_phonex_type', $type );

	// Admin-only internal note
	if ( ! empty( $source ) ) {
		update_post_meta( $product_id, '_phonex_internal_source_url', esc_url_raw( $source ) );
	}
}

echo "Successfully imported {$imported} new camera lens products and updated {$updated} existing products into WooCommerce.\n";
