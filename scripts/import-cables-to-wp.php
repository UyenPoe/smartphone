<?php
/**
 * Import Crawled Chargers & Cables into WooCommerce
 *
 * Reads phonex-theme/data/cables.json and creates/updates products
 * in categories 'sac-cap', 'cu-sac', 'cap-sac' and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/cables.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/cables.json';
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

echo "Found " . count( $data ) . " cable/charger products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'sac-cap' exists
$term_sac_cap = term_exists( 'sac-cap', 'product_cat' );
if ( ! $term_sac_cap ) {
	$term_sac_cap = wp_insert_term(
		'Sạc Cáp & Củ Cáp Sạc',
		'product_cat',
		array(
			'slug'        => 'sac-cap',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập củ sạc nhanh GaN, dây cáp sạc Type-C, Lightning chính hãng Apple, Anker, Samsung, Baseus, Ugreen giá tốt nhất.',
		)
	);
}
$sac_cap_id = is_array( $term_sac_cap ) ? $term_sac_cap['term_id'] : $term_sac_cap;

// Subcategory 'cu-sac' (Củ sạc - Adapter)
$term_cusac = term_exists( 'cu-sac', 'product_cat' );
if ( ! $term_cusac ) {
	$term_cusac = wp_insert_term(
		'Củ sạc - Adapter',
		'product_cat',
		array(
			'slug'        => 'cu-sac',
			'parent'      => $sac_cap_id,
			'description' => 'Củ sạc nhanh Type-C Power Delivery, sạc GaN siêu nhỏ gọn 20W - 140W.',
		)
	);
}
$cusac_id = is_array( $term_cusac ) ? $term_cusac['term_id'] : $term_cusac;

// Subcategory 'cap-sac' (Dây cáp sạc)
$term_capsac = term_exists( 'cap-sac', 'product_cat' );
if ( ! $term_capsac ) {
	$term_capsac = wp_insert_term(
		'Dây cáp sạc',
		'product_cat',
		array(
			'slug'        => 'cap-sac',
			'parent'      => $sac_cap_id,
			'description' => 'Dây cáp sạc Type-C to Lightning, Type-C to Type-C, cáp bọc dù siêu bền.',
		)
	);
}
$capsac_id = is_array( $term_capsac ) ? $term_capsac['term_id'] : $term_capsac;

$imported = 0;
// Import top 50 products to WP database for admin catalog management
$batch = array_slice( $data, 0, 50 );

foreach ( $batch as $item ) {
	$name        = $item['name'];
	$source_url  = $item['source_url'];
	$price_num   = $item['price'];
	$old_num     = $item['price_old'];
	$brand       = $item['brand'];
	$prod_type   = $item['type'];
	$wattage     = $item['wattage'];
	$length      = $item['length'];
	$specs       = is_array( $item['specs'] ) ? implode( ' • ', $item['specs'] ) : $item['specs'];
	$updated_at  = $item['updated_at'];
	$image_url   = $item['image'];

	// Determine specific category ID
	$item_cat_ids = array( $phukien_id, $sac_cap_id );
	if ( stripos( $prod_type, 'cáp' ) !== false ) {
		$item_cat_ids[] = $capsac_id;
	} else {
		$item_cat_ids[] = $cusac_id;
	}

	// Check if already exists
	$existing = get_posts( array(
		'post_type'   => 'product',
		'meta_key'    => '_source_url',
		'meta_value'  => $source_url,
		'post_status' => 'any',
		'numberposts' => 1,
	) );

	if ( ! empty( $existing ) ) {
		$post_id = $existing[0]->ID;
		wp_update_post( array(
			'ID'         => $post_id,
			'post_title' => $name,
		) );
	} else {
		$post_id = wp_insert_post( array(
			'post_title'   => $name,
			'post_content' => "<p><strong>Tên sản phẩm:</strong> {$name}</p><p><strong>Thương hiệu:</strong> {$brand}</p><p><strong>Phân loại:</strong> {$prod_type}</p><p><strong>Công suất:</strong> {$wattage}</p><p><strong>Chiều dài:</strong> {$length}</p><p><strong>Thông số kỹ thuật:</strong> {$specs}</p><p><strong>Bảo hành:</strong> 12 tháng 1 đổi 1 chính hãng tại PhoneX.</p>",
			'post_status'  => 'publish',
			'post_type'    => 'product',
		) );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		// Category assignment
		wp_set_object_terms( $post_id, array_map( 'intval', $item_cat_ids ), 'product_cat' );

		// Brand assignment
		if ( ! empty( $brand ) ) {
			wp_set_object_terms( $post_id, sanitize_text_field( $brand ), 'product_brand' );
		}

		// Pricing & inventory meta
		update_post_meta( $post_id, '_price', $price_num );
		update_post_meta( $post_id, '_regular_price', $old_num );
		if ( $price_num < $old_num ) {
			update_post_meta( $post_id, '_sale_price', $price_num );
		} else {
			delete_post_meta( $post_id, '_sale_price' );
		}

		update_post_meta( $post_id, '_manage_stock', 'no' );
		update_post_meta( $post_id, '_stock_status', 'instock' );
		update_post_meta( $post_id, '_visibility', 'visible' );

		// Crawler metadata (Admin only)
		update_post_meta( $post_id, '_source_url', esc_url_raw( $source_url ) );
		update_post_meta( $post_id, '_phonex_is_crawled', 'yes' );
		update_post_meta( $post_id, '_phonex_crawled_at', $updated_at );
		update_post_meta( $post_id, '_phonex_specs', $specs );
		update_post_meta( $post_id, '_phonex_wattage', $wattage );
		update_post_meta( $post_id, '_phonex_length', $length );
		update_post_meta( $post_id, '_phonex_type', $prod_type );
		update_post_meta( $post_id, '_external_thumbnail_url', esc_url_raw( $image_url ) );

		$imported++;
	}
}

echo "Successfully imported/updated {$imported} products into categories 'sac-cap', 'cu-sac', 'cap-sac' and assigned brands.\n";
