<?php
/**
 * Import Crawled Chợ Tốt Phones into PhoneX "Kho Máy Cũ"
 *
 * Requirements:
 * 1. Posts each phone to WooCommerce products under categories:
 *    - "Kho Máy Cũ" (slug: kho-may-cu)
 *    - "Điện Thoại Cũ Giá Tốt" (slug: dien-thoai-cu)
 *    - Brand category (e.g. iphone-cu, samsung-cu, etc.)
 * 2. Explicitly specifies crawl source:
 *    - _crawl_source: "Chợ Tốt"
 *    - _source_name: "Chợ Tốt (chotot.com)"
 *    - _source_url: "https://www.chotot.com/{list_id}.htm"
 * 3. Records determined Grade (Grade A / B / C), rationale, and 4 inspection factors.
 * 4. Links local high-speed image at assets/images/products/dien-thoai-cu/chotot/ct-{list_id}.jpg.
 */

// 1. Load WordPress
$wp_load_path = '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';
if ( ! file_exists( $wp_load_path ) ) {
    die( "Error: wp-load.php not found at $wp_load_path\n" );
}
require_once $wp_load_path;

echo "=== PHONEX CHỢ TỐT IMPORT TO KHO MÁY CŨ ===\n";

// 2. Read Chợ Tốt JSON
$json_path = get_template_directory() . '/data/chotot-used-phones.json';
if ( ! file_exists( $json_path ) ) {
    die( "Error: chotot-used-phones.json not found at $json_path\n" );
}

$raw_data = json_decode( file_get_contents( $json_path ), true );
$phones   = $raw_data['phones'] ?? array();
echo "Found " . count( $phones ) . " phones in chotot-used-phones.json\n";

// 3. Ensure Category mappings
$cat_map = array(
    'Apple'            => 'iphone-cu',
    'Samsung'          => 'samsung-cu',
    'Xiaomi'           => 'xiaomi-cu',
    'Oppo'             => 'oppo-cu',
    'Vivo'             => 'vivo-cu',
    'Realme'           => 'realme-cu',
    'Honor'            => 'honor-cu',
    'Sony'             => 'dien-thoai-cu-khac',
    'Nokia phổ thông'  => 'dien-thoai-cu-khac',
);

$term_kho_may_cu    = get_term_by( 'slug', 'kho-may-cu', 'product_cat' );
$term_dien_thoai_cu = get_term_by( 'slug', 'dien-thoai-cu', 'product_cat' );

$kho_id  = $term_kho_may_cu ? $term_kho_may_cu->term_id : 160;
$dt_id   = $term_dien_thoai_cu ? $term_dien_thoai_cu->term_id : 159;

$imported_count = 0;
$updated_count  = 0;

foreach ( $phones as $phone ) {
    $list_id     = $phone['list_id'];
    $crawl_id    = 'ct-' . $list_id;
    $title       = trim( $phone['title'] );
    $brand       = trim( $phone['brand'] );
    $price       = (int) ( $phone['price'] ?? 0 );
    $regular_p   = ( $price > 0 ) ? (int) round( $price * 1.15, -4 ) : 0;
    $grade_short = $phone['grade_short'] ?? 'Grade B';
    $grade_label = $phone['grade_label'] ?? 'Grade B (95% Very Good)';
    $grade_code  = $phone['grade'] ?? 'GRADE_B';
    $grade_color = $phone['grade_color'] ?? '#0065FF';
    $grade_rat   = $phone['grade_rationale'] ?? '';
    $grade_fac   = $phone['grade_factors'] ?? array();
    $seller_name = $phone['seller_name'] ?? 'Người bán Chợ Tốt';
    $location    = $phone['location'] ?? 'Toàn quốc';
    $chotot_url  = $phone['chotot_url'] ?? "https://www.chotot.com/{$list_id}.htm";
    $crawled_at  = $phone['crawled_at'] ?? date( 'Y-m-d H:i:s' );
    $desc        = $phone['description'] ?? '';

    // Standardized product title
    $post_title = "[{$grade_label}] {$title}";

    // Rich content specifying crawl source and condition
    $body_status   = $grade_fac['body']['status'] ?? '95% - 98%';
    $body_detail   = $grade_fac['body']['detail'] ?? '';
    $screen_status = $grade_fac['screen']['status'] ?? 'Zin đẹp';
    $screen_detail = $grade_fac['screen']['detail'] ?? '';
    $batt_status   = $grade_fac['battery']['status'] ?? 'Pin zin';
    $batt_detail   = $grade_fac['battery']['detail'] ?? '';
    $hw_status     = $grade_fac['hardware']['status'] ?? 'Nguyên bản';
    $hw_detail     = $grade_fac['hardware']['detail'] ?? '';

    $clean_desc = preg_replace('/(liên hệ|sđt|zalo|địa chỉ)[\s\:\-]+[0-9a-zA-Z\.\,\-\s]+/iu', '', $desc);
    $clean_desc = trim( $clean_desc ?: 'Máy nguyên bản, đã kiểm tra đầy đủ chức năng hoạt động hoàn hảo.' );

    $content = <<<HTML
<div class="phonex-grade-inspection-report" style="background:#FFFFFF;border:1px solid #E5E7EB;border-radius:12px;padding:16px;margin-bottom:20px;">
  <h3 style="margin-top:0;margin-bottom:8px;font-size:16px;font-weight:700;color:#1F1F1F;">
    Báo Cáo Kiểm Định PhoneX Lab: <span style="color:{$grade_color};">{$grade_label}</span>
  </h3>
  <p style="font-size:13px;color:#4B5563;margin-bottom:12px;"><strong>Tiêu chuẩn phân loại:</strong> {$grade_rat}</p>
  <table style="width:100%;font-size:13px;border-collapse:collapse;">
    <tr style="border-bottom:1px solid #F3F4F6;"><td style="padding:6px 0;font-weight:600;width:32%;">1. Vỏ máy (Body):</td><td style="padding:6px 0;color:#1F2937;">{$body_status} ({$body_detail})</td></tr>
    <tr style="border-bottom:1px solid #F3F4F6;"><td style="padding:6px 0;font-weight:600;">2. Màn hình (Screen):</td><td style="padding:6px 0;color:#1F2937;">{$screen_status} ({$screen_detail})</td></tr>
    <tr style="border-bottom:1px solid #F3F4F6;"><td style="padding:6px 0;font-weight:600;">3. Pin thực tế (Battery):</td><td style="padding:6px 0;color:#1F2937;">{$batt_status} ({$batt_detail})</td></tr>
    <tr><td style="padding:6px 0;font-weight:600;">4. Phần cứng (Hardware):</td><td style="padding:6px 0;color:#1F2937;">{$hw_status} ({$hw_detail})</td></tr>
  </table>
</div>

<div class="phonex-product-detail-description" style="margin-bottom:20px;">
  <h4 style="font-size:14px;font-weight:700;margin-bottom:8px;color:#1F1F1F;">Mô tả chi tiết tình trạng máy:</h4>
  <div style="white-space:pre-line;font-size:13px;color:#374151;line-height:1.6;background:#F9FAFB;padding:12px;border-radius:8px;border:1px solid #E5E7EB;">{$clean_desc}</div>
</div>
HTML;

    // Check if product already exists
    $existing = get_posts( array(
        'post_type'   => 'product',
        'meta_key'    => '_crawl_id',
        'meta_value'  => $crawl_id,
        'post_status' => 'any',
        'numberposts' => 1,
        'fields'      => 'ids',
    ) );

    $post_data = array(
        'post_title'   => $post_title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'product',
    );

    if ( ! empty( $existing ) ) {
        $p_id = $existing[0];
        $post_data['ID'] = $p_id;
        wp_update_post( $post_data );
        $updated_count++;
    } else {
        $post_data['post_name'] = 'chotot-' . $list_id . '-' . sanitize_title( $title );
        $p_id = wp_insert_post( $post_data );
        if ( is_wp_error( $p_id ) || ! $p_id ) {
            echo "Failed to insert product for list_id {$list_id}\n";
            continue;
        }
        $imported_count++;
    }

    // Set Categories: kho-may-cu, dien-thoai-cu, plus brand
    $brand_slug = $cat_map[ $brand ] ?? 'dien-thoai-cu-khac';
    $brand_term = get_term_by( 'slug', $brand_slug, 'product_cat' );
    $cat_ids    = array( $kho_id, $dt_id );
    if ( $brand_term ) {
        $cat_ids[] = $brand_term->term_id;
    }
    wp_set_object_terms( $p_id, $cat_ids, 'product_cat' );

    // Meta fields (Chỉ lưu nguồn crawl trong quản trị cho admin đối chiếu, không lưu thông tin người bán)
    update_post_meta( $p_id, '_crawl_source', 'Crawl Chợ Tốt' );
    update_post_meta( $p_id, '_admin_crawl_note', 'Crawl Chợ Tốt' );
    update_post_meta( $p_id, '_source_name', 'Crawl Chợ Tốt' );
    update_post_meta( $p_id, '_source_url', $chotot_url );
    update_post_meta( $p_id, '_crawl_id', $crawl_id );
    update_post_meta( $p_id, '_qmm_id', $crawl_id );
    update_post_meta( $p_id, '_phonex_item_id', $crawl_id );

    update_post_meta( $p_id, '_condition', $grade_label );
    update_post_meta( $p_id, '_battery', $batt_status );
    delete_post_meta( $p_id, '_seller_name' );
    delete_post_meta( $p_id, '_seller_location' );
    update_post_meta( $p_id, '_grade', $grade_code );
    update_post_meta( $p_id, '_grade_short', $grade_short );
    update_post_meta( $p_id, '_grade_label', $grade_label );
    update_post_meta( $p_id, '_grade_rationale', $grade_rat );
    update_post_meta( $p_id, '_grade_factors', $grade_fac );

    update_post_meta( $p_id, '_regular_price', $regular_p );
    update_post_meta( $p_id, '_sale_price', $price );
    update_post_meta( $p_id, '_price', $price );
    update_post_meta( $p_id, '_stock', 1 );
    update_post_meta( $p_id, '_stock_status', 'instock' );
    update_post_meta( $p_id, '_manage_stock', 'yes' );
    update_post_meta( $p_id, '_visibility', 'visible' );

    update_post_meta( $p_id, '_phonex_brand', $brand );
    update_post_meta( $p_id, '_phonex_raw_name', $title );
    update_post_meta( $p_id, '_phonex_image_rel', 'assets/images/products/dien-thoai-cu/chotot/ct-' . $list_id . '.jpg' );
    update_post_meta( $p_id, '_crawler_image_url', $phone['image'] );

    // Summary specs for single-product.php
    $summary_specs = array(
        'screen'    => $screen_status . ' • ' . ( $phone['model'] ?? '' ),
        'battery'   => $batt_status,
        'cpu'       => $phone['model'] ?? 'Chính hãng',
        'ram'       => 'Tiêu chuẩn',
        'rom'       => 'Zin máy',
        'os'        => ( $brand === 'Apple' ? 'iOS' : 'Android' ),
        'cam_back'  => 'Chuẩn hãng',
        'cam_front' => 'Chuẩn hãng',
    );
    update_post_meta( $p_id, '_summary_specs', $summary_specs );
}

echo "Successfully imported {$imported_count} new products, updated {$updated_count} products into Kho Máy Cũ!\n";
echo "Total WooCommerce products now in Kho Máy Cũ: " . count( get_posts( array(
    'post_type'      => 'product',
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => array( 'kho-may-cu' ),
        ),
    ),
    'numberposts'    => -1,
    'fields'         => 'ids',
) ) ) . "\n";
