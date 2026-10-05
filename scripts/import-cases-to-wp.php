<?php
/**
 * Import Crawled Phone Cases into WooCommerce
 *
 * Reads phonex-theme/data/cases.json and creates/updates products
 * in categories 'op-lung-flipcover', 'op-lung-iphone', 'op-lung-samsung'
 * and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/cases.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/cases.json';
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

echo "Found " . count( $data ) . " phone case products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'op-lung-flipcover' exists
$term_oplung = term_exists( 'op-lung-flipcover', 'product_cat' );
if ( ! $term_oplung ) {
	$term_oplung = wp_insert_term(
		'Ốp Lưng & Bao Da Điện Thoại',
		'product_cat',
		array(
			'slug'        => 'op-lung-flipcover',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập ốp lưng chống sốc, ốp lưng MagSafe, bao da chính hãng cho iPhone, Samsung Galaxy.',
		)
	);
}
$oplung_id = is_array( $term_oplung ) ? $term_oplung['term_id'] : $term_oplung;

// Subcategory 'op-lung-iphone'
$term_op_ip = term_exists( 'op-lung-iphone', 'product_cat' );
if ( ! $term_op_ip ) {
	$term_op_ip = wp_insert_term(
		'Ốp Lưng iPhone',
		'product_cat',
		array(
			'slug'        => 'op-lung-iphone',
			'parent'      => $oplung_id,
			'description' => 'Ốp lưng iPhone 16, 15, 14 Series hỗ trợ MagSafe, chống ố vàng, chống va đập.',
		)
	);
}
$op_ip_id = is_array( $term_op_ip ) ? $term_op_ip['term_id'] : $term_op_ip;

// Subcategory 'op-lung-samsung'
$term_op_ss = term_exists( 'op-lung-samsung', 'product_cat' );
if ( ! $term_op_ss ) {
	$term_op_ss = wp_insert_term(
		'Ốp Lưng Samsung Galaxy',
		'product_cat',
		array(
			'slug'        => 'op-lung-samsung',
			'parent'      => $oplung_id,
			'description' => 'Ốp lưng Galaxy S24, S23, Z Fold, Z Flip, Galaxy A Series chính hãng ôm khít, bảo vệ tối ưu.',
		)
	);
}
$op_ss_id = is_array( $term_op_ss ) ? $term_op_ss['term_id'] : $term_op_ss;

$imported = 0;
// Import top 50 products to WP database for admin catalog management
$batch = array_slice( $data, 0, 50 );

foreach ( $batch as $item ) {
	$name        = $item['name'];
	$source_url  = $item['source_url'];
	$price_num   = $item['price'];
	$old_num     = $item['price_old'];
	$brand       = $item['brand'];
	$dev_brand   = $item['device_brand'];
	$dev_model   = $item['device_model'];
	$material    = $item['material'];
	$specs       = is_array( $item['specs'] ) ? implode( ' • ', $item['specs'] ) : $item['specs'];
	$updated_at  = $item['updated_at'];
	$image_rel   = $item['image'];

	// Category assignment
	$item_cat_ids = array( $phukien_id, $oplung_id );
	if ( 'iPhone' === $dev_brand ) {
		$item_cat_ids[] = $op_ip_id;
	} elseif ( 'Samsung' === $dev_brand ) {
		$item_cat_ids[] = $op_ss_id;
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
			'post_content' => "<p><strong>Tên sản phẩm:</strong> {$name}</p><p><strong>Thương hiệu ốp:</strong> {$brand}</p><p><strong>Dòng máy tương thích:</strong> {$dev_model}</p><p><strong>Chất liệu:</strong> {$material}</p><p><strong>Đặc điểm nổi bật:</strong> {$specs}</p><p><strong>Cam kết:</strong> 100% chính hãng nguyên seal, ôm khít từng chi tiết máy tại PhoneX.</p>",
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
		update_post_meta( $post_id, '_phonex_material', $material );
		update_post_meta( $post_id, '_phonex_device_model', $dev_model );
		update_post_meta( $post_id, '_phonex_local_image', $image_rel );
		update_post_meta( $post_id, '_external_thumbnail_url', home_url( '/wp-content/themes/phonex-theme/' . ltrim( $image_rel, '/' ) ) );

		$imported++;
	}
}

echo "Successfully imported/updated {$imported} phone case products into categories 'op-lung-flipcover', 'op-lung-iphone', 'op-lung-samsung' and assigned brands.\n";
