<?php
/**
 * Script to sync all used phones from data/used-phones.json into WooCommerce product posts in WordPress,
 * saving rich specifications (_spec_groups), summary specs (_summary_specs), and detailed descriptions.
 */

define( 'WP_USE_THEMES', false );
require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
	echo "WooCommerce is not active.\n";
	exit( 1 );
}

$theme_dir = get_template_directory();
$json_file = $theme_dir . '/data/used-phones.json';

if ( ! file_exists( $json_file ) ) {
	echo "JSON file not found: $json_file\n";
	exit( 1 );
}

$items = json_decode( file_get_contents( $json_file ), true );
if ( empty( $items ) ) {
	echo "No items in JSON.\n";
	exit( 1 );
}

echo "Found " . count( $items ) . " total items in JSON to sync.\n";

// 1. Ensure parent category: Kho Máy Cũ
$parent_term = term_exists( 'kho-may-cu', 'product_cat' );
if ( ! $parent_term ) {
	$parent_term = wp_insert_term( 'Kho Máy Cũ', 'product_cat', array(
		'slug'        => 'kho-may-cu',
		'description' => 'Kho máy cũ Like New 99% đã qua kiểm định 30 bước PhoneX Certified.',
	) );
}
$parent_id = is_array( $parent_term ) ? $parent_term['term_id'] : $parent_term;

// 2. Ensure brand categories
$brand_slugs = array(
	'Apple'    => array( 'name' => 'iPhone cũ', 'slug' => 'iphone-cu' ),
	'Samsung'  => array( 'name' => 'Samsung cũ', 'slug' => 'samsung-cu' ),
	'OPPO'     => array( 'name' => 'OPPO cũ', 'slug' => 'oppo-cu' ),
	'Xiaomi'   => array( 'name' => 'Xiaomi cũ', 'slug' => 'xiaomi-cu' ),
	'Vivo'     => array( 'name' => 'Vivo cũ', 'slug' => 'vivo-cu' ),
	'Realme'   => array( 'name' => 'Realme cũ', 'slug' => 'realme-cu' ),
	'Honor'    => array( 'name' => 'Honor cũ', 'slug' => 'honor-cu' ),
	'Infinix'  => array( 'name' => 'Infinix cũ', 'slug' => 'infinix-cu' ),
	'Nubia'    => array( 'name' => 'Nubia cũ', 'slug' => 'nubia-cu' ),
	'Oukitel'  => array( 'name' => 'Oukitel cũ', 'slug' => 'oukitel-cu' ),
	'Khác'     => array( 'name' => 'Điện thoại cũ khác', 'slug' => 'dien-thoai-cu-khac' ),
);

$cat_term_ids = array();
foreach ( $brand_slugs as $b_key => $b_info ) {
	$t = term_exists( $b_info['slug'], 'product_cat' );
	if ( ! $t ) {
		$t = wp_insert_term( $b_info['name'], 'product_cat', array(
			'slug'   => $b_info['slug'],
			'parent' => $parent_id,
		) );
	}
	$cat_term_ids[ $b_key ] = is_array( $t ) ? $t['term_id'] : $t;
}

$count_synced = 0;
$updated_items = array();

foreach ( $items as $item ) {
	$item_id   = $item['id'] ?? '';
	$title     = $item['name'];
	$raw_name  = $item['raw_name'] ?? $title;
	$brand     = $item['brand'] ?? 'Khác';
	$price     = (float) ( $item['price'] ?? 0 );
	$old_price = (float) ( $item['old_price'] ?? 0 );
	$condition = $item['condition'] ?? 'Grade A 99%';
	$battery   = $item['battery'] ?? 'Pin 95% - 100%';
	$stock_qty = (int) ( $item['stock_quantity'] ?? 5 );
	$specs     = $item['specs'] ?? array();
	$img_rel   = $item['image'] ?? '';
	$desc_html = $item['description_html'] ?? '';
	$spec_grp  = $item['spec_groups'] ?? array();
	$sum_specs = $item['summary_specs'] ?? array();

	if ( empty( $desc_html ) ) {
		$desc_html = "<h3>" . esc_html( $title ) . " — PhoneX Kho Máy Cũ Like New 99%</h3>";
		$desc_html .= "<p>Điện thoại cũ chính hãng tuyển chọn, kiểm định 30 bước PhoneX Certified, bảo hành VIP 12 tháng 1 đổi 1 trong 30 ngày.</p>";
		$desc_html .= "<h4>Thông tin kiểm định &amp; Tình trạng:</h4><ul>";
		foreach ( $specs as $sp ) {
			$desc_html .= "<li>" . esc_html( $sp ) . "</li>";
		}
		$desc_html .= "<li>Tình trạng thẩm mỹ: " . esc_html( $condition ) . "</li>";
		$desc_html .= "<li>Tình trạng pin: " . esc_html( $battery ) . "</li>";
		$desc_html .= "<li>Xuất kho tại: 128 Showroom PhoneX toàn quốc</li>";
		$desc_html .= "</ul>";
	}

	// Check if already created by searching meta _phonex_item_id or _qmm_id
	$existing = get_posts( array(
		'post_type'      => 'product',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'   => '_phonex_item_id',
				'value' => $item_id,
			),
			array(
				'key'   => '_qmm_id',
				'value' => $item_id,
			),
		),
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );

	$post_data = array(
		'post_title'   => $title,
		'post_content' => $desc_html,
		'post_status'  => 'publish',
		'post_type'    => 'product',
	);

	if ( ! empty( $existing ) ) {
		$post_id = $existing[0];
		$post_data['ID'] = $post_id;
		wp_update_post( $post_data );
	} else {
		$post_id = wp_insert_post( $post_data );
	}

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		$updated_items[] = $item;
		continue;
	}

	// Update WooCommerce product metas
	update_post_meta( $post_id, '_phonex_item_id', $item_id );
	if ( strpos( $item_id, 'qmm-' ) === 0 ) {
		update_post_meta( $post_id, '_qmm_id', $item_id );
	}
	update_post_meta( $post_id, '_visibility', 'visible' );
	update_post_meta( $post_id, '_stock_status', 'instock' );
	update_post_meta( $post_id, '_manage_stock', 'yes' );
	update_post_meta( $post_id, '_stock', $stock_qty );
	update_post_meta( $post_id, '_condition', $condition );
	update_post_meta( $post_id, '_battery', $battery );
	update_post_meta( $post_id, '_phonex_brand', $brand );
	update_post_meta( $post_id, '_phonex_raw_name', $raw_name );
	update_post_meta( $post_id, '_phonex_image_rel', $img_rel );
	update_post_meta( $post_id, '_spec_groups', $spec_grp );
	update_post_meta( $post_id, '_summary_specs', $sum_specs );

	if ( $old_price > $price && $price > 0 ) {
		update_post_meta( $post_id, '_regular_price', $old_price );
		update_post_meta( $post_id, '_sale_price', $price );
		update_post_meta( $post_id, '_price', $price );
	} else {
		update_post_meta( $post_id, '_regular_price', $price );
		update_post_meta( $post_id, '_sale_price', '' );
		update_post_meta( $post_id, '_price', $price );
	}

	// Assign categories: parent kho-may-cu, brand subcategory, and dien-thoai-cu
	$assigned_terms = array( (int) $parent_id );
	$brand_term_id = $cat_term_ids[ $brand ] ?? ( $cat_term_ids['Khác'] ?? null );
	if ( $brand_term_id ) {
		$assigned_terms[] = (int) $brand_term_id;
	}
	$dtc_term = term_exists( 'dien-thoai-cu', 'product_cat' );
	if ( $dtc_term ) {
		$assigned_terms[] = (int) ( is_array( $dtc_term ) ? $dtc_term['term_id'] : $dtc_term );
	}
	wp_set_object_terms( $post_id, $assigned_terms, 'product_cat' );

	$permalink = get_permalink( $post_id );
	$item['permalink'] = $permalink;
	$updated_items[] = $item;

	$count_synced++;
	if ( $count_synced % 50 === 0 || $count_synced === count( $items ) ) {
		echo "Synced: $count_synced / " . count( $items ) . " products...\n";
	}
}

// Save back updated permalinks into used-phones.json
file_put_contents( $json_file, json_encode( $updated_items, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) );

echo "Successfully synced all $count_synced products with full specs and descriptions to WooCommerce!\n";
