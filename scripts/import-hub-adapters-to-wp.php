<?php
/**
 * Import Crawled Hub & Adapters into WooCommerce
 *
 * Reads phonex-theme/data/hub-adapters.json and creates/updates products
 * in categories 'hub-cap-chuyen-doi', 'hub-usb-c', 'cap-chuyen-hinh-anh'
 * and assigns 'product_brand'.
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$json_path = WP_CONTENT_DIR . '/themes/phonex-theme/data/hub-adapters.json';
if ( ! file_exists( $json_path ) ) {
	$json_path = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme/data/hub-adapters.json';
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

echo "Found " . count( $data ) . " hub & adapter products to import.\n";

// Ensure Parent Category 'phu-kien' exists
$term_phukien = term_exists( 'phu-kien', 'product_cat' );
if ( ! $term_phukien ) {
	$term_phukien = wp_insert_term( 'Phụ kiện', 'product_cat', array( 'slug' => 'phu-kien' ) );
}
$phukien_id = is_array( $term_phukien ) ? $term_phukien['term_id'] : $term_phukien;

// Ensure category 'hub-cap-chuyen-doi' exists
$term_hub = term_exists( 'hub-cap-chuyen-doi', 'product_cat' );
if ( ! $term_hub ) {
	$term_hub = term_exists( 'hub-chuyen-doi', 'product_cat' );
}
if ( ! $term_hub ) {
	$term_hub = wp_insert_term(
		'Hub, Cáp Chuyển Đổi',
		'product_cat',
		array(
			'slug'        => 'hub-cap-chuyen-doi',
			'parent'      => $phukien_id,
			'description' => 'Bộ sưu tập Hub USB-C đa năng, cáp xuất hình HDMI 4K/8K, cáp âm thanh và đầu chuyển đổi OTG cao cấp.',
		)
	);
}
$hub_id = is_array( $term_hub ) ? $term_hub['term_id'] : $term_hub;

// Subcategories
$term_usbc = term_exists( 'hub-usb-c', 'product_cat' );
if ( ! $term_usbc ) {
	$term_usbc = wp_insert_term(
		'Hub USB-C Đa Năng',
		'product_cat',
		array(
			'slug'        => 'hub-usb-c',
			'parent'      => $hub_id,
			'description' => 'Hub Type-C 4-in-1, 6-in-1, 8-in-1 mở rộng HDMI, USB 3.0, khe thẻ nhớ và sạc nhanh PD 100W.',
		)
	);
}
$usbc_id = is_array( $term_usbc ) ? $term_usbc['term_id'] : $term_usbc;

$term_video = term_exists( 'cap-chuyen-hinh-anh', 'product_cat' );
if ( ! $term_video ) {
	$term_video = wp_insert_term(
		'Cáp Chuyển Hình Ảnh',
		'product_cat',
		array(
			'slug'        => 'cap-chuyen-hinh-anh',
			'parent'      => $hub_id,
			'description' => 'Cáp chuyển Type-C sang HDMI, DisplayPort, VGA độ phân giải 4K, 8K cho MacBook và Laptop.',
		)
	);
}
$video_id = is_array( $term_video ) ? $term_video['term_id'] : $term_video;

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
	$brand    = sanitize_text_field( $prod['brand'] ?? 'PhoneX Link' );
	$type     = $prod['type'] ?? 'Hub USB-C đa năng';
	$cat_slug = $prod['category_slug'] ?? 'hub-usb-c';
	$specs    = $prod['specs'] ?? array();
	$img_rel  = $prod['image'] ?? '';
	$source   = $prod['source_url'] ?? '';

	// Assigned categories
	$assigned_cats = array( $phukien_id, $hub_id );
	if ( 'hub-usb-c' === $cat_slug ) {
		$assigned_cats[] = $usbc_id;
	} elseif ( 'cap-xuat-hinh' === $cat_slug ) {
		$assigned_cats[] = $video_id;
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
	update_post_meta( $product_id, '_sku', 'PX-HUB-' . str_pad( $idx + 1, 4, '0', STR_PAD_LEFT ) );
	update_post_meta( $product_id, '_phonex_specs', json_encode( $specs, JSON_UNESCAPED_UNICODE ) );
	update_post_meta( $product_id, '_phonex_local_image', $img_rel );
	update_post_meta( $product_id, '_phonex_type', $type );

	// Admin-only internal note
	if ( ! empty( $source ) ) {
		update_post_meta( $product_id, '_phonex_internal_source_url', esc_url_raw( $source ) );
	}
}

echo "Successfully imported {$imported} new hub products and updated {$updated} existing products into WooCommerce.\n";
