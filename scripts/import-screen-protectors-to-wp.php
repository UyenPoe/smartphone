<?php
/**
 * Import Crawled Screen Protectors into WooCommerce
 *
 * Reads phonex-theme/data/screen-protectors.json and creates/updates products
 * in categories 'mieng-dan-man-hinh', 'mieng-dan-iphone', 'mieng-dan-samsung', etc.
 * and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/screen-protectors.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/screen-protectors.json';
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

echo "Found " . count( $data ) . " screen protector products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'mieng-dan-man-hinh' exists
$term_dan = term_exists( 'mieng-dan-man-hinh', 'product_cat' );
if ( ! $term_dan ) {
	$term_dan = wp_insert_term(
		'Miếng Dán Màn Hình & Kính Cường Lực',
		'product_cat',
		array(
			'slug'        => 'mieng-dan-man-hinh',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập kính cường lực 9H, kính chống nhìn trộm, chống bám vân tay và bảo vệ camera cho iPhone, Samsung, iPad.',
		)
	);
}
$dan_id = is_array( $term_dan ) ? $term_dan['term_id'] : $term_dan;

// Subcategories
$sub_cats = array(
	'mieng-dan-iphone'  => array( 'name' => 'Kính Cường Lực iPhone', 'desc' => 'Kính cường lực iPhone 16, 15, 14, 13 series chính hãng' ),
	'mieng-dan-samsung' => array( 'name' => 'Kính Cường Lực Samsung', 'desc' => 'Kính cường lực Samsung Galaxy S24, Z Fold, A series' ),
	'mieng-dan-ipad'    => array( 'name' => 'Kính Cường Lực iPad', 'desc' => 'Dán màn hình và kính cường lực cho iPad Pro, Air, Mini' ),
	'mieng-dan-dong-ho' => array( 'name' => 'Dán Màn Hình Đồng Hồ', 'desc' => 'Miếng dán cường lực Apple Watch, Garmin, Galaxy Watch' ),
);

$cat_ids = array();
foreach ( $sub_cats as $slug => $info ) {
	$term = term_exists( $slug, 'product_cat' );
	if ( ! $term ) {
		$term = wp_insert_term(
			$info['name'],
			'product_cat',
			array(
				'slug'        => $slug,
				'parent'      => $dan_id,
				'description' => $info['desc'],
			)
		);
	}
	$cat_ids[ $slug ] = is_array( $term ) ? $term['term_id'] : $term;
}

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
	$type     = $prod['type'] ?? 'Kính cường lực';
	$specs    = $prod['specs'] ?? array();
	$img_rel  = $prod['image'] ?? '';
	$source   = $prod['source_url'] ?? '';

	// Determine category assignments
	$assigned_cats = array( $phukien_id, $dan_id );
	if ( 'iPhone' === $device ) {
		$assigned_cats[] = $cat_ids['mieng-dan-iphone'];
	} elseif ( 'Samsung' === $device ) {
		$assigned_cats[] = $cat_ids['mieng-dan-samsung'];
	} elseif ( 'iPad' === $device ) {
		$assigned_cats[] = $cat_ids['mieng-dan-ipad'];
	} elseif ( strpos( $device, 'Watch' ) !== false ) {
		$assigned_cats[] = $cat_ids['mieng-dan-dong-ho'];
	}

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
	update_post_meta( $product_id, '_sku', 'PX-DAN-' . str_pad( $idx + 1, 4, '0', STR_PAD_LEFT ) );
	update_post_meta( $product_id, '_phonex_specs', json_encode( $specs, JSON_UNESCAPED_UNICODE ) );
	update_post_meta( $product_id, '_phonex_local_image', $img_rel );
	update_post_meta( $product_id, '_phonex_device_brand', $device );
	update_post_meta( $product_id, '_phonex_type', $type );

	// Admin-only internal note
	if ( ! empty( $source ) ) {
		update_post_meta( $product_id, '_phonex_internal_source_url', esc_url_raw( $source ) );
	}

	if ( ( $imported + $updated ) % 100 === 0 ) {
		echo "Processed " . ( $imported + $updated ) . " products...\n";
	}
}

echo "Successfully imported {$imported} new products and updated {$updated} existing products into WooCommerce.\n";
