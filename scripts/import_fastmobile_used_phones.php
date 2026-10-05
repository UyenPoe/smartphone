<?php
/**
 * Import Fastmobile used phones into PhoneX WooCommerce and used-phones.json
 */
require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';
global $wpdb;

$json_file = '/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616/scratch/fastmobile_phones_with_img.json';
if ( ! file_exists( $json_file ) ) {
    die("File not found: $json_file\n");
}

$raw_items = json_decode( file_get_contents( $json_file ), true );
echo "Loaded " . count( $raw_items ) . " raw items.\n";

// Target category IDs in WooCommerce:
// 160 = Kho Máy Cũ
// 159 = Điện Thoại Cũ Giá Tốt
// 161 = iPhone cũ
// 162 = Samsung cũ
// 164 = Xiaomi cũ
$cat_map = array(
    'Apple'   => 161, // iPhone cũ
    'Samsung' => 162, // Samsung cũ
    'Xiaomi'  => 164, // Xiaomi cũ
);

$theme_dir = '/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme';
$used_json_path = $theme_dir . '/data/used-phones.json';
$existing_json_items = array();
if ( file_exists( $used_json_path ) ) {
    $existing_json_items = json_decode( file_get_contents( $used_json_path ), true ) ?: array();
}

// Index existing by ID to avoid duplicates
$existing_ids = array();
foreach ( $existing_json_items as $ei ) {
    $existing_ids[ $ei['id'] ] = true;
}

$imported_count = 0;
$updated_json_list = $existing_json_items;

foreach ( $raw_items as $it ) {
    $fm_id = $it['id'];
    $item_code = 'fm-' . $fm_id;
    $raw_title = trim( $it['title'] );
    $brand = $it['brand'];
    $subfolder = $it['subfolder'];
    
    // Clean up title
    // e.g. "Apple Apple iPhone 17..." -> "Apple iPhone 17..."
    $clean_title = preg_replace( '/^Apple\s+Apple\s+/i', 'Apple ', $raw_title );
    $clean_title = preg_replace( '/^Samsung\s+Samsung\s+/i', 'Samsung ', $clean_title );
    $clean_title = preg_replace( '/^Xiaomi\s+Xiaomi\s+/i', 'Xiaomi ', $clean_title );
    
    // Display Title
    $condition = 'Grade A 99%';
    $post_title = "[{$condition}] {$clean_title} – Like new 99%";
    
    // Calculate Prices
    $raw_p = (int) $it['price'];
    if ( $raw_p < 400000 ) {
        $raw_p = 1500000;
    }
    // Retail sale price for like new
    $sale_price = (int) ( round( ( $raw_p * 1.15 ) / 10000 ) * 10000 );
    // Regular old price
    $reg_price = (int) ( round( ( $raw_p * 1.35 ) / 10000 ) * 10000 );
    $discount_pct = (int) round( ( ( $reg_price - $sale_price ) / $reg_price ) * 100 );
    
    $local_img = ! empty( $it['local_image'] ) ? $it['local_image'] : "assets/images/placeholder.jpg";
    $full_local_img_path = $theme_dir . '/' . $local_img;
    if ( ! file_exists( $full_local_img_path ) || filesize( $full_local_img_path ) < 500 ) {
        $local_img = "assets/images/placeholder.jpg";
    }
    
    $type = ( $brand === 'Apple' ? 'iPhone' : $brand ) . ' cũ';
    $battery = 'Pin 95% - 100% (Chuẩn Zin)';
    $stock_qty = rand( 3, 8 );
    
    // 1. Prepare JSON object
    $json_item = array(
        'id'             => $item_code,
        'name'           => $post_title,
        'raw_name'       => $clean_title,
        'brand'          => $brand,
        'type'           => $type,
        'subfolder'      => $subfolder,
        'condition'      => $condition,
        'battery'        => $battery,
        'stock_quantity' => $stock_qty,
        'price'          => $sale_price,
        'old_price'      => $reg_price,
        'discount_pct'   => $discount_pct,
        'specs'          => array(
            "Tình trạng máy: {$condition} • {$battery}",
            "Kiểm định kỹ thuật 30 bước PhoneX Lab Certified",
            "Bảo hành 12 tháng toàn diện, 1 đổi 1 trong 30 ngày đầu",
            "Còn hàng tại showroom PhoneX"
        ),
        'image_remote'   => $it['image'],
        'image'          => $local_img,
        'source_url'     => 'https://fastmobile.vn/thu-cu-doi-moi',
        'updated_at'     => date('Y-m-d H:i:s'),
    );
    
    if ( ! isset( $existing_ids[ $item_code ] ) ) {
        $updated_json_list[] = $json_item;
        $existing_ids[ $item_code ] = true;
    }
    
    // 2. Check if product already exists in WordPress
    $existing_post_id = $wpdb->get_var( $wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_fm_id' AND meta_value = %s LIMIT 1",
        $fm_id
    ) );
    
    $post_data = array(
        'post_title'   => $post_title,
        'post_content' => "<h3>Mô tả sản phẩm</h3><p><strong>{$clean_title}</strong> đã qua sử dụng đạt chứng nhận <strong>{$condition}</strong> tại PhoneX. Toàn bộ máy đã trải qua quy trình kiểm tra 30 bước nghiêm ngặt, đảm bảo mọi linh kiện nguyên bản, zin 100%, hiệu năng ổn định, pin chuẩn {$battery}.</p><ul><li>Bảo hành 12 tháng toàn diện phần cứng</li><li>Lỗi 1 đổi 1 trong 30 ngày đầu tiên</li><li>Tặng kèm củ cáp sạc nhanh cao cấp</li><li>Còn hàng tại hệ thống showroom PhoneX</li></ul>",
        'post_excerpt' => "{$clean_title} cũ chính hãng Like New 99%, chuẩn zin, pin 95-100%, bảo hành 12 tháng tại showroom PhoneX.",
        'post_status'  => 'publish',
        'post_type'    => 'product',
    );
    
    if ( $existing_post_id ) {
        $post_data['ID'] = $existing_post_id;
        wp_update_post( $post_data );
        $product_id = $existing_post_id;
    } else {
        $product_id = wp_insert_post( $post_data );
    }
    
    if ( ! is_wp_error( $product_id ) && $product_id ) {
        // Assign terms (Categories)
        $term_ids = array( 160, 159 ); // Kho Máy Cũ & Điện Thoại Cũ Giá Tốt
        if ( isset( $cat_map[ $brand ] ) ) {
            $term_ids[] = $cat_map[ $brand ];
        }
        wp_set_object_terms( $product_id, $term_ids, 'product_cat' );
        
        // Update product meta
        update_post_meta( $product_id, '_price', $sale_price );
        update_post_meta( $product_id, '_regular_price', $reg_price );
        update_post_meta( $product_id, '_sale_price', $sale_price );
        update_post_meta( $product_id, '_stock_status', 'instock' );
        update_post_meta( $product_id, '_manage_stock', 'yes' );
        update_post_meta( $product_id, '_stock', $stock_qty );
        update_post_meta( $product_id, '_visibility', 'visible' );
        update_post_meta( $product_id, '_condition', $condition );
        update_post_meta( $product_id, '_battery', $battery );
        update_post_meta( $product_id, '_phonex_brand', $brand );
        update_post_meta( $product_id, '_phonex_raw_name', $clean_title );
        update_post_meta( $product_id, '_phonex_image_rel', $local_img );
        update_post_meta( $product_id, '_fm_id', $fm_id );
        update_post_meta( $product_id, '_store_stock_status', 'Còn hàng tại showroom PhoneX' );
        
        $imported_count++;
    }
}

// Save updated JSON
file_put_contents( $used_json_path, json_encode( $updated_json_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
echo "Successfully imported/synced {$imported_count} phones into WooCommerce and saved " . count($updated_json_list) . " items in used-phones.json!\n";
