<?php
/**
 * Import Crawled Tablet Cases into WooCommerce
 *
 * Reads phonex-theme/data/tablet-cases.json and creates/updates products
 * in categories 'op-lung-may-tinh-bang', 'bao-da-ipad', 'bao-da-galaxy-tab'
 * and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/tablet-cases.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/tablet-cases.json';
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

echo "Found " . count( $data ) . " tablet case products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'op-lung-may-tinh-bang' exists
$term_tab = term_exists( 'op-lung-may-tinh-bang', 'product_cat' );
if ( ! $term_tab ) {
	$term_tab = wp_insert_term(
		'Ốp Lưng & Bao Da Máy Tính Bảng',
		'product_cat',
		array(
			'slug'        => 'op-lung-may-tinh-bang',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập bao da thông minh Auto Sleep/Wake, bao da kèm bàn phím cho iPad, Galaxy Tab, Xiaomi Pad.',
		)
	);
}
$tab_id = is_array( $term_tab ) ? $term_tab['term_id'] : $term_tab;

// Subcategory 'bao-da-ipad'
$term_ipad = term_exists( 'bao-da-ipad', 'product_cat' );
if ( ! $term_ipad ) {
	$term_ipad = wp_insert_term(
		'Bao Da iPad',
		'product_cat',
		array(
			'slug'        => 'bao-da-ipad',
			'parent'      => $tab_id,
			'description' => 'Bao da iPad Pro, iPad Air, iPad Gen 10/9/11 cao cấp có khay giữ bút Apple Pencil.',
		)
	);
}
$ipad_id = is_array( $term_ipad ) ? $term_ipad['term_id'] : $term_ipad;

// Subcategory 'bao-da-galaxy-tab'
$term_ss = term_exists( 'bao-da-galaxy-tab', 'product_cat' );
if ( ! $term_ss ) {
	$term_ss = wp_insert_term(
		'Bao Da Galaxy Tab',
		'product_cat',
		array(
			'slug'        => 'bao-da-galaxy-tab',
			'parent'      => $tab_id,
			'description' => 'Bao da Galaxy Tab S9, S10, Tab A Series chính hãng Samsung, chống sốc và kèm bàn phím AI.',
		)
	);
}
$ss_id = is_array( $term_ss ) ? $term_ss['term_id'] : $term_ss;

$imported = 0;
// Import all 64 products
foreach ( $data as $item ) {
	$name        = $item['name'];
	$source_url  = $item['source_url'];
	$price_num   = $item['price'];
	$old_num     = $item['price_old'];
	$brand       = $item['brand'];
	$dev_brand   = $item['device_brand'];
	$dev_model   = $item['device_model'];
	$prod_type   = $item['type'];
	$material    = $item['material'];
	$specs       = is_array( $item['specs'] ) ? implode( ' • ', $item['specs'] ) : $item['specs'];
	$updated_at  = $item['updated_at'];
	$image_rel   = $item['image'];

	// Category assignment
	$item_cat_ids = array( $phukien_id, $tab_id );
	if ( 'iPad' === $dev_brand ) {
		$item_cat_ids[] = $ipad_id;
	} elseif ( 'Galaxy Tab' === $dev_brand ) {
		$item_cat_ids[] = $ss_id;
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
			'post_content' => "<p><strong>Tên sản phẩm:</strong> {$name}</p><p><strong>Thương hiệu bao da:</strong> {$brand}</p><p><strong>Dòng máy tương thích:</strong> {$dev_model}</p><p><strong>Phân loại:</strong> {$prod_type}</p><p><strong>Chất liệu:</strong> {$material}</p><p><strong>Đặc điểm nổi bật:</strong> {$specs}</p><p><strong>Cam kết:</strong> 100% chính hãng nguyên seal, bảo vệ màn hình tối ưu tại PhoneX.</p>",
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

echo "Successfully imported/updated {$imported} tablet case products into categories 'op-lung-may-tinh-bang', 'bao-da-ipad', 'bao-da-galaxy-tab' and assigned brands.\n";
