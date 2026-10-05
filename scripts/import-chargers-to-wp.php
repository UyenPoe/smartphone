<?php
/**
 * Import Crawled Chargers into WooCommerce
 *
 * Reads phonex-theme/data/chargers.json and creates/updates products
 * in category 'sac-dtdd' and 'sac-du-phong'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/chargers.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/chargers.json';
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

echo "Found " . count( $data ) . " products to import.\n";

// Ensure category 'sac-dtdd' exists
$term_sac_dtdd = term_exists( 'sac-dtdd', 'product_cat' );
if ( ! $term_sac_dtdd ) {
	$term_sac_dtdd = wp_insert_term(
		'Sạc Điện Thoại Di Động & Pin Dự Phòng',
		'product_cat',
		array(
			'slug'        => 'sac-dtdd',
			'description' => 'Bộ sưu tập củ sạc, pin sạc dự phòng chính hãng Anker, Samsung, Apple, Xmobile, Baseus, Ugreen giá tốt nhất thị trường.',
		)
	);
}
$sac_dtdd_id = is_array( $term_sac_dtdd ) ? $term_sac_dtdd['term_id'] : $term_sac_dtdd;

// Also category 'phu-kien'
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
$phukien_id   = $term_phukien ? ( is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien ) : 0;

// Also category 'sac-du-phong'
$term_sacdp = term_exists( 'sac-du-phong', 'product_cat' );
$sacdp_id   = $term_sacdp ? ( is_array( $term_sacdp ) ? $term_sacdp['term_id'] : $term_sacdp ) : 0;

$cat_ids = array_filter( array( $sac_dtdd_id, $sacdp_id, $phukien_id ) );

$imported = 0;
// Import the top 40 products to keep DB responsive while the template provides all 164 instantly
$batch = array_slice( $data, 0, 40 );

foreach ( $batch as $item ) {
	$name        = $item['product_name'];
	$source_url  = $item['source_url'];
	$price_num   = $item['current_price_num'];
	$old_num     = $item['old_price_num'];
	$brand       = $item['brand'];
	$model       = $item['model'];
	$capacity    = $item['capacity'];
	$specs       = is_array( $item['specs'] ) ? implode( ' • ', $item['specs'] ) : $item['specs'];
	$updated_at  = $item['updated_at'];
	$image_url   = $item['image'];

	// Check if already exists by source_url or title
	$existing = get_posts( array(
		'post_type'   => 'product',
		'meta_key'    => '_source_url',
		'meta_value'  => $source_url,
		'post_status' => 'any',
		'numberposts' => 1,
	) );

	if ( ! empty( $existing ) ) {
		$post_id = $existing[0]->ID;
	} else {
		$post_id = wp_insert_post( array(
			'post_title'   => $name,
			'post_content' => "<p><strong>Tên sản phẩm:</strong> {$name}</p><p><strong>Thương hiệu:</strong> {$brand}</p><p><strong>Model:</strong> {$model}</p><p><strong>Dung lượng:</strong> {$capacity}</p><p><strong>Thông số kỹ thuật:</strong> {$specs}</p><p><strong>Bảo hành:</strong> 12 tháng 1 đổi 1 chính hãng tại PhoneX.</p>",
			'post_status'  => 'publish',
			'post_type'    => 'product',
		) );
	}

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		wp_set_object_terms( $post_id, array_map( 'intval', $cat_ids ), 'product_cat' );
		if ( ! empty( $brand ) ) {
			wp_set_object_terms( $post_id, sanitize_text_field( $brand ), 'product_brand' );
		}

		// Update WooCommerce pricing and meta
		update_post_meta( $post_id, '_price', $price_num );
		update_post_meta( $post_id, '_regular_price', $old_num );
		if ( $price_num < $old_num ) {
			update_post_meta( $post_id, '_sale_price', $price_num );
		}
		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock' );
		update_post_meta( $post_id, '_source_url', $source_url );
		update_post_meta( $post_id, '_brand', $brand );
		update_post_meta( $post_id, '_model', $model );
		update_post_meta( $post_id, '_capacity', $capacity );
		update_post_meta( $post_id, '_specs', $specs );
		update_post_meta( $post_id, '_crawled_updated_at', $updated_at );
		update_post_meta( $post_id, '_is_crawled_from_db', 'yes' );
		update_post_meta( $post_id, '_admin_crawl_note', 'Sản phẩm crawl từ cơ sở dữ liệu phụ kiện sạc điện thoại di động (Cập nhật: ' . $updated_at . ')' );

		$imported++;
	}
}

echo "Successfully imported/updated {$imported} charger products into WooCommerce!\n";
