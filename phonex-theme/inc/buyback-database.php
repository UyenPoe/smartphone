<?php
/**
 * PhoneX Buyback (Thu mua điện thoại) Database Schema & Seeder
 *
 * Implements dedicated dynamic tables for PhoneX Buyback & Wholesale operations:
 * - wp_phonex_buyback_brands
 * - wp_phonex_buyback_series
 * - wp_phonex_buyback_models
 * - wp_phonex_buyback_requests (CRM)
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PHONEX_BUYBACK_DB_VERSION = '1.0.1';

/**
 * Returns the official brand logo URL for any phone brand.
 * Supports Apple, Samsung, Xiaomi, OPPO, vivo, realme, Google, Huawei, Sony, Honor, Motorola, Nothing...
 * Automatically falls back to high-res vector SVGs in assets/images/brands/
 *
 * @param object|string $brand_or_slug Brand object or slug/name.
 * @return string Logo URL.
 */
function phonex_get_brand_logo_url( $brand_or_slug ) {
	$slug = '';
	if ( is_object( $brand_or_slug ) ) {
		$slug = $brand_or_slug->slug ?? '';
	} elseif ( is_string( $brand_or_slug ) ) {
		$slug = sanitize_title( $brand_or_slug );
	}

	$slug = strtolower( trim( $slug ) );

	// Normalize aliases
	$aliases = array(
		'iphone'  => 'apple',
		'ipad'    => 'apple',
		'galaxy'  => 'samsung',
		'redmi'   => 'xiaomi',
		'poco'    => 'xiaomi',
		'pixel'   => 'google',
		'xperia'  => 'sony',
	);
	if ( isset( $aliases[ $slug ] ) ) {
		$slug = $aliases[ $slug ];
	}

	$svg_path = get_template_directory() . '/assets/images/brands/' . $slug . '.svg';
	if ( file_exists( $svg_path ) ) {
		return get_template_directory_uri() . '/assets/images/brands/' . $slug . '.svg';
	}

	return get_template_directory_uri() . '/assets/images/brands/apple.svg';
}

/**
 * Returns an HTML img element of the brand logo
 *
 * @param object|string $brand_or_slug Brand object or slug.
 * @param string        $class CSS classes for the img element.
 * @param string        $alt Custom alt text (optional).
 * @return string HTML img tag.
 */
function phonex_get_brand_logo_img( $brand_or_slug, $class = 'max-w-full max-h-full object-contain', $alt = '' ) {
	$url = phonex_get_brand_logo_url( $brand_or_slug );
	$name = '';
	if ( is_object( $brand_or_slug ) && ! empty( $brand_or_slug->name ) ) {
		$name = $brand_or_slug->name;
	} elseif ( is_string( $brand_or_slug ) ) {
		$name = ucfirst( $brand_or_slug );
	}
	if ( empty( $alt ) ) {
		$alt = $name;
	}
	return '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" class="' . esc_attr( $class ) . '" loading="lazy" />';
}

/**
 * Creates buyback tables using dbDelta
 */
function phonex_buyback_install_tables() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$sql = "
	CREATE TABLE {$wpdb->prefix}phonex_buyback_brands (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		name varchar(100) NOT NULL,
		slug varchar(100) NOT NULL,
		logo_url text DEFAULT NULL,
		description text DEFAULT NULL,
		seo_title varchar(255) DEFAULT NULL,
		seo_description text DEFAULT NULL,
		seo_content longtext DEFAULT NULL,
		faq_json longtext DEFAULT NULL,
		sort_order int(11) DEFAULT 0,
		is_featured tinyint(1) DEFAULT 1,
		is_active tinyint(1) DEFAULT 1,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_brand_slug (slug),
		KEY idx_sort_active (sort_order, is_active)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_buyback_series (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		brand_id bigint(20) unsigned NOT NULL,
		name varchar(100) NOT NULL,
		slug varchar(100) NOT NULL,
		sort_order int(11) DEFAULT 0,
		is_active tinyint(1) DEFAULT 1,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		KEY idx_brand_series (brand_id, sort_order)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_buyback_models (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		brand_id bigint(20) unsigned NOT NULL,
		series_id bigint(20) unsigned DEFAULT 0,
		name varchar(255) NOT NULL,
		slug varchar(100) NOT NULL,
		image_url text DEFAULT NULL,
		storage_options text DEFAULT NULL,
		color_options text DEFAULT NULL,
		base_buyback_price decimal(12,2) NOT NULL DEFAULT 0.00,
		grade_rates text DEFAULT NULL,
		deductions_json text DEFAULT NULL,
		seo_title varchar(255) DEFAULT NULL,
		seo_description text DEFAULT NULL,
		seo_content longtext DEFAULT NULL,
		faq_json longtext DEFAULT NULL,
		is_popular tinyint(1) DEFAULT 1,
		is_active tinyint(1) DEFAULT 1,
		sort_order int(11) DEFAULT 0,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		KEY idx_brand_model_slug (brand_id, slug),
		KEY idx_series_model (series_id, sort_order)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_buyback_requests (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		request_code varchar(32) NOT NULL,
		customer_name varchar(150) NOT NULL,
		customer_phone varchar(20) NOT NULL,
		brand_id bigint(20) unsigned DEFAULT 0,
		brand_name varchar(100) NOT NULL,
		model_id bigint(20) unsigned DEFAULT 0,
		model_name varchar(255) NOT NULL,
		storage varchar(50) DEFAULT '',
		color varchar(50) DEFAULT '',
		condition_grade varchar(10) DEFAULT 'A',
		condition_details longtext DEFAULT NULL,
		estimated_price decimal(12,2) NOT NULL DEFAULT 0.00,
		final_price decimal(12,2) DEFAULT NULL,
		device_images text DEFAULT NULL,
		inspection_method varchar(50) DEFAULT 'store',
		store_id bigint(20) unsigned DEFAULT 0,
		store_name varchar(255) DEFAULT '',
		appointment_date date DEFAULT NULL,
		appointment_time varchar(50) DEFAULT '',
		customer_notes text DEFAULT NULL,
		staff_notes text DEFAULT NULL,
		status varchar(50) DEFAULT 'new',
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_request_code (request_code),
		KEY idx_customer_phone (customer_phone),
		KEY idx_status (status)
	) $charset_collate;
	";

	dbDelta( $sql );
	update_option( 'phonex_buyback_db_version', PHONEX_BUYBACK_DB_VERSION );
}

add_action( 'after_switch_theme', 'phonex_buyback_install_tables' );
add_action( 'init', 'phonex_buyback_check_install' );

function phonex_buyback_check_install() {
	if ( get_option( 'phonex_buyback_db_version' ) !== PHONEX_BUYBACK_DB_VERSION ) {
		phonex_buyback_install_tables();
		phonex_buyback_seed_initial_data();
	}
}

/**
 * Seeds comprehensive initial brands, series and models
 */
function phonex_buyback_seed_initial_data( $force = false ) {
	global $wpdb;
	$t_brands  = $wpdb->prefix . 'phonex_buyback_brands';
	$t_series  = $wpdb->prefix . 'phonex_buyback_series';
	$t_models  = $wpdb->prefix . 'phonex_buyback_models';

	$count = intval( $wpdb->get_var( "SELECT COUNT(*) FROM $t_brands" ) );
	if ( $count > 0 && ! $force ) {
		return;
	}

	// 1. BRANDS
	$brands_data = array(
		array(
			'name'        => 'Apple',
			'slug'        => 'apple',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/apple.svg',
			'description' => 'PhoneX chuyên thu mua iPhone cũ mọi tình trạng: từ máy lướt nguyên seal 99%, máy trầy xước, chai pin đến máy hỏng màn hình. Định giá minh bạch theo tiêu chuẩn quốc tế, thanh toán ngay trong 5 phút.',
			'seo_title'   => 'Thu Mua iPhone Cũ Giá Cao Nhất Thị Trường | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua iPhone cũ giá cao tại PhoneX: Thu mua iPhone 16, 15, 14, 13 Pro Max. Báo giá online tức thì, thanh toán 5 phút, kiểm định tận nơi.',
			'sort_order'  => 1,
			'is_featured' => 1,
		),
		array(
			'name'        => 'Samsung',
			'slug'        => 'samsung',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/samsung.svg',
			'description' => 'Thu mua điện thoại Samsung Galaxy cũ giá cao: Galaxy S25, S24, S23 Ultra, Galaxy Z Fold6, Z Flip6. Thu mua tận nơi hoặc tại 128 showroom toàn quốc.',
			'seo_title'   => 'Thu Mua Điện Thoại Samsung Cũ Giá Tốt Nhất | PhoneX',
			'seo_description'    => 'PhoneX thu mua điện thoại Samsung cũ giá cao: Galaxy S Series, Z Fold, Z Flip, Galaxy A. Thẩm định nhanh, tiền mặt hoặc chuyển khoản liền tay.',
			'sort_order'  => 2,
			'is_featured' => 1,
		),
		array(
			'name'        => 'Xiaomi',
			'slug'        => 'xiaomi',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/xiaomi.svg',
			'description' => 'Thu mua điện thoại Xiaomi, Redmi, POCO cũ: Xiaomi 15, 14 Ultra, 13T, Redmi Note series. Không giới hạn số lượng, thanh toán sỉ và lẻ uy tín.',
			'seo_title'   => 'Thu Mua Điện Thoại Xiaomi Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua điện thoại Xiaomi, Redmi, POCO cũ giá tốt nhất. Định giá nhanh chóng trong 3 phút, thu tận nhà.',
			'sort_order'  => 3,
			'is_featured' => 1,
		),
		array(
			'name'        => 'OPPO',
			'slug'        => 'oppo',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/oppo.svg',
			'description' => 'Thu mua điện thoại OPPO cũ mọi phiên bản: Find N3 Fold, Find X8 Pro, Reno series, OPPO A series giá cao vượt trội.',
			'seo_title'   => 'Thu Mua Điện Thoại OPPO Cũ Uy Tín | PhoneX',
			'seo_description'    => 'PhoneX thu mua OPPO cũ giá cao: Find X, Reno, Find N Flip. Kiểm tra máy tận nơi, tiền về tài khoản trong 5 phút.',
			'sort_order'  => 4,
			'is_featured' => 1,
		),
		array(
			'name'        => 'vivo',
			'slug'        => 'vivo',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/vivo.svg',
			'description' => 'Thu mua điện thoại vivo cũ: X200 Pro, X100, V40, Y series. Bảng giá cập nhật theo giờ, trợ giá thu đổi cực tốt.',
			'seo_title'   => 'Thu Mua Điện Thoại vivo Cũ Giá Tốt | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua vivo cũ giá cao tại PhoneX: X Series, V Series, Y Series. Định giá chuẩn xác, không ép giá.',
			'sort_order'  => 5,
			'is_featured' => 1,
		),
		array(
			'name'        => 'realme',
			'slug'        => 'realme',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/realme.svg',
			'description' => 'Thu mua smartphone realme cũ giá cao: realme GT series, realme 12 series, C series.',
			'seo_title'   => 'Thu Mua Điện Thoại realme Cũ | PhoneX',
			'seo_description'    => 'Thu mua realme cũ giá cao tại PhoneX. Nhận máy tận nơi, thanh toán tức thì.',
			'sort_order'  => 6,
			'is_featured' => 1,
		),
		array(
			'name'        => 'Google',
			'slug'        => 'google',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/google.svg',
			'description' => 'Thu mua Google Pixel cũ: Pixel 9 Pro XL, Pixel 8 Pro, Pixel 7, Pixel 6. Định giá cao cho các dòng máy quốc tế và xách tay.',
			'seo_title'   => 'Thu Mua Google Pixel Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Chuyên thu mua Google Pixel cũ giá tốt nhất. Định giá nhanh chóng, thanh toán tức thời.',
			'sort_order'  => 7,
			'is_featured' => 1,
		),
		array(
			'name'        => 'Huawei',
			'slug'        => 'huawei',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/huawei.svg',
			'description' => 'Thu mua điện thoại Huawei cũ: Mate 60 Pro, Pura 70, P60 Pro, Nova series giá cạnh tranh.',
			'seo_title'   => 'Thu Mua Điện Thoại Huawei Cũ | PhoneX',
			'seo_description'    => 'Thu mua điện thoại Huawei cũ giá cao toàn quốc tại PhoneX.',
			'sort_order'  => 8,
			'is_featured' => 1,
		),
		array(
			'name'        => 'Sony',
			'slug'        => 'sony',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/sony.svg',
			'description' => 'Thu mua Sony Xperia cũ: Xperia 1 VI, Xperia 1 V, Xperia 5, Xperia 10 series.',
			'seo_title'   => 'Thu Mua Sony Xperia Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua Sony Xperia cũ uy tín hàng đầu.',
			'sort_order'  => 9,
			'is_featured' => 0,
		),
		array(
			'name'        => 'Honor',
			'slug'        => 'honor',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/honor.svg',
			'description' => 'Thu mua điện thoại Honor cũ: Magic V3, Magic 6 Pro, Honor 200 series.',
			'seo_title'   => 'Thu Mua Điện Thoại Honor Cũ | PhoneX',
			'seo_description'    => 'Thu mua điện thoại Honor cũ giá cao, kiểm định công khai.',
			'sort_order'  => 10,
			'is_featured' => 0,
		),
		array(
			'name'        => 'Motorola',
			'slug'        => 'motorola',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/motorola.svg',
			'description' => 'Thu mua Motorola Razr series, Edge series cũ giá tốt.',
			'seo_title'   => 'Thu Mua Điện Thoại Motorola Cũ | PhoneX',
			'seo_description'    => 'Thu mua Motorola cũ mọi phiên bản.',
			'sort_order'  => 11,
			'is_featured' => 0,
		),
		array(
			'name'        => 'Nothing',
			'slug'        => 'nothing',
			'logo_url'    => '/wp-content/themes/phonex-theme/assets/images/brands/nothing.svg',
			'description' => 'Thu mua Nothing Phone (1), Phone (2), Phone (2a) cũ giá cao.',
			'seo_title'   => 'Thu Mua Nothing Phone Cũ Giá Tốt | PhoneX',
			'seo_description'    => 'Thu mua Nothing Phone cũ uy tín tại PhoneX.',
			'sort_order'  => 12,
			'is_featured' => 0,
		),
	);

	foreach ( $brands_data as $b ) {
		$wpdb->insert( $t_brands, $b );
	}

	// Fetch brand IDs
	$apple_id   = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'apple' ) );
	$samsung_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'samsung' ) );
	$xiaomi_id  = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'xiaomi' ) );
	$oppo_id    = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'oppo' ) );
	$vivo_id    = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'vivo' ) );
	$google_id  = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", 'google' ) );

	// 2. SERIES
	$series_data = array(
		// Apple Series
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 16 Series', 'slug' => 'iphone-16-series', 'sort_order' => 1 ),
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 15 Series', 'slug' => 'iphone-15-series', 'sort_order' => 2 ),
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 14 Series', 'slug' => 'iphone-14-series', 'sort_order' => 3 ),
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 13 Series', 'slug' => 'iphone-13-series', 'sort_order' => 4 ),
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 12 Series', 'slug' => 'iphone-12-series', 'sort_order' => 5 ),
		array( 'brand_id' => $apple_id, 'name' => 'iPhone 11 Series', 'slug' => 'iphone-11-series', 'sort_order' => 6 ),

		// Samsung Series
		array( 'brand_id' => $samsung_id, 'name' => 'Galaxy S25 Series', 'slug' => 'galaxy-s25-series', 'sort_order' => 1 ),
		array( 'brand_id' => $samsung_id, 'name' => 'Galaxy S24 Series', 'slug' => 'galaxy-s24-series', 'sort_order' => 2 ),
		array( 'brand_id' => $samsung_id, 'name' => 'Galaxy Z Fold / Flip', 'slug' => 'galaxy-z-series', 'sort_order' => 3 ),
		array( 'brand_id' => $samsung_id, 'name' => 'Galaxy S23 Series', 'slug' => 'galaxy-s23-series', 'sort_order' => 4 ),
		array( 'brand_id' => $samsung_id, 'name' => 'Galaxy A Series', 'slug' => 'galaxy-a-series', 'sort_order' => 5 ),

		// Xiaomi Series
		array( 'brand_id' => $xiaomi_id, 'name' => 'Xiaomi 15 / 14 Series', 'slug' => 'xiaomi-15-14-series', 'sort_order' => 1 ),
		array( 'brand_id' => $xiaomi_id, 'name' => 'Redmi Note Series', 'slug' => 'redmi-note-series', 'sort_order' => 2 ),

		// Google Series
		array( 'brand_id' => $google_id, 'name' => 'Pixel 9 Series', 'slug' => 'pixel-9-series', 'sort_order' => 1 ),
		array( 'brand_id' => $google_id, 'name' => 'Pixel 8 Series', 'slug' => 'pixel-8-series', 'sort_order' => 2 ),
	);

	foreach ( $series_data as $s ) {
		$wpdb->insert( $t_series, $s );
	}

	// 3. MODELS
	$models_data = array(
		// --- APPLE MODELS ---
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 1, // 16 Series
			'name'               => 'iPhone 16 Pro Max',
			'slug'               => 'iphone-16-pro-max',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329149/iphone-16-pro-max-titan-trang-0-639175378937464054.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Sa Mạc', 'Titan Tự Nhiên', 'Titan Trắng', 'Titan Đen' ) ),
			'base_buyback_price' => 28500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.88, 'C' => 0.72, 'D' => 0.50 ) ),
			'seo_title'          => 'Thu Mua iPhone 16 Pro Max Cũ Giá Cao Nhất Đến 28.5 Tr | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua iPhone 16 Pro Max cũ tại PhoneX. Báo giá trực tuyến chuẩn xác, hỗ trợ thu máy tại nhà hoặc 128 showroom toàn quốc, tiền về trong 5 phút.',
			'is_popular'         => 1,
			'sort_order'         => 1,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 1,
			'name'               => 'iPhone 16 Pro',
			'slug'               => 'iphone-16-pro',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329149/iphone-16-pro-max-titan-trang-1-638638963299331292.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Sa Mạc', 'Titan Tự Nhiên', 'Titan Trắng', 'Titan Đen' ) ),
			'base_buyback_price' => 24000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.88, 'C' => 0.72, 'D' => 0.50 ) ),
			'seo_title'          => 'Thu Mua iPhone 16 Pro Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua iPhone 16 Pro cũ giá tốt nhất thị trường. Kiểm định chuyên nghiệp, thanh toán nhanh.',
			'is_popular'         => 1,
			'sort_order'         => 2,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 2, // 15 Series
			'name'               => 'iPhone 15 Pro Max',
			'slug'               => 'iphone-15-pro-max',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Tự Nhiên', 'Titan Xanh', 'Titan Trắng', 'Titan Đen' ) ),
			'base_buyback_price' => 23500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.86, 'C' => 0.70, 'D' => 0.48 ) ),
			'seo_title'          => 'Thu Mua iPhone 15 Pro Max Cũ Giá Cao Đến 23.5 Triệu | PhoneX',
			'seo_description'    => 'Thu mua iPhone 15 Pro Max cũ mọi tình trạng giá cao nhất. Báo giá tức thì, tiền về tài khoản trong 5 phút.',
			'is_popular'         => 1,
			'sort_order'         => 3,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 2,
			'name'               => 'iPhone 15 Pro',
			'slug'               => 'iphone-15-pro',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Tự Nhiên', 'Titan Xanh', 'Titan Trắng', 'Titan Đen' ) ),
			'base_buyback_price' => 19500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.86, 'C' => 0.70, 'D' => 0.48 ) ),
			'seo_title'          => 'Thu Mua iPhone 15 Pro Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua iPhone 15 Pro cũ giá cao toàn quốc tại PhoneX.',
			'is_popular'         => 1,
			'sort_order'         => 4,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 2,
			'name'               => 'iPhone 15 Plus',
			'slug'               => 'iphone-15-plus',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB' ) ),
			'color_options'      => wp_json_encode( array( 'Hồng', 'Xanh Lá', 'Xanh Dương', 'Vàng', 'Đen' ) ),
			'base_buyback_price' => 15500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua iPhone 15 Plus Cũ Giá Tốt | PhoneX',
			'seo_description'    => 'Thu mua iPhone 15 Plus cũ giá cao, thẩm định minh bạch.',
			'is_popular'         => 1,
			'sort_order'         => 5,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 2,
			'name'               => 'iPhone 15',
			'slug'               => 'iphone-15',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB' ) ),
			'color_options'      => wp_json_encode( array( 'Hồng', 'Xanh Lá', 'Xanh Dương', 'Vàng', 'Đen' ) ),
			'base_buyback_price' => 14000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua iPhone 15 Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua iPhone 15 cũ uy tín tại PhoneX.',
			'is_popular'         => 1,
			'sort_order'         => 6,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 3, // 14 Series
			'name'               => 'iPhone 14 Pro Max',
			'slug'               => 'iphone-14-pro-max',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Tím Deep Purple', 'Vàng Gold', 'Bạc Silver', 'Đen Space Black' ) ),
			'base_buyback_price' => 18000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua iPhone 14 Pro Max Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua iPhone 14 Pro Max cũ giá cao nhất, thanh toán ngay.',
			'is_popular'         => 1,
			'sort_order'         => 7,
		),
		array(
			'brand_id'           => $apple_id,
			'series_id'          => 4, // 13 Series
			'name'               => 'iPhone 13 Pro Max',
			'slug'               => 'iphone-13-pro-max',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/305659/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Xanh Sierra Blue', 'Vàng Gold', 'Bạc Silver', 'Xám Graphite', 'Xanh Alpine Green' ) ),
			'base_buyback_price' => 14500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua iPhone 13 Pro Max Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua iPhone 13 Pro Max cũ giá cao, kiểm định chuẩn xác.',
			'is_popular'         => 1,
			'sort_order'         => 8,
		),

		// --- SAMSUNG MODELS ---
		array(
			'brand_id'           => $samsung_id,
			'series_id'          => 7, // S25 Series
			'name'               => 'Samsung Galaxy S25 Ultra',
			'slug'               => 'galaxy-s25-ultra',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/333347/samsung-galaxy-s25-ultra-blue-thumbai-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Xanh Dương', 'Titan Đen', 'Titan Bạc', 'Titan Xám' ) ),
			'base_buyback_price' => 25000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua Galaxy S25 Ultra Cũ Giá Cao Nhất Đến 25 Tr | PhoneX',
			'seo_description'    => 'Thu mua Samsung Galaxy S25 Ultra cũ giá cao nhất. Báo giá trong 3 phút, kiểm định tận nơi.',
			'is_popular'         => 1,
			'sort_order'         => 10,
		),
		array(
			'brand_id'           => $samsung_id,
			'series_id'          => 8, // S24 Series
			'name'               => 'Samsung Galaxy S24 Ultra',
			'slug'               => 'galaxy-s24-ultra',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/333347/samsung-galaxy-s25-ultra-blue-thumbai-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Titan Xám', 'Titan Đen', 'Titan Tím', 'Titan Vàng' ) ),
			'base_buyback_price' => 20500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua Galaxy S24 Ultra Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua Samsung Galaxy S24 Ultra cũ giá tốt nhất toàn quốc.',
			'is_popular'         => 1,
			'sort_order'         => 11,
		),
		array(
			'brand_id'           => $samsung_id,
			'series_id'          => 9, // Z Series
			'name'               => 'Samsung Galaxy Z Fold6',
			'slug'               => 'galaxy-z-fold6',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/333347/samsung-galaxy-s25-ultra-blue-thumbai-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Xám Metal', 'Hồng Rose', 'Xanh Navy' ) ),
			'base_buyback_price' => 26000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.82, 'C' => 0.65, 'D' => 0.40 ) ),
			'seo_title'          => 'Thu Mua Galaxy Z Fold6 Cũ Giá Cao Đến 26 Triệu | PhoneX',
			'seo_description'    => 'Chuyên thu mua điện thoại gập Samsung Galaxy Z Fold6 cũ giá cao, an tâm uy tín.',
			'is_popular'         => 1,
			'sort_order'         => 12,
		),
		array(
			'brand_id'           => $samsung_id,
			'series_id'          => 9,
			'name'               => 'Samsung Galaxy Z Flip6',
			'slug'               => 'galaxy-z-flip6',
			'image_url'          => 'https://cdn.tgdd.vn/Products/Images/42/333347/samsung-galaxy-s25-ultra-blue-thumbai-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB' ) ),
			'color_options'      => wp_json_encode( array( 'Xanh Maya', 'Vàng Solar', 'Xám Metal', 'Xanh Mint' ) ),
			'base_buyback_price' => 15000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.82, 'C' => 0.65, 'D' => 0.40 ) ),
			'seo_title'          => 'Thu Mua Galaxy Z Flip6 Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua điện thoại gập Z Flip6 cũ giá cao nhất, thanh toán 5 phút.',
			'is_popular'         => 1,
			'sort_order'         => 13,
		),

		// --- XIAOMI MODELS ---
		array(
			'brand_id'           => $xiaomi_id,
			'series_id'          => 12,
			'name'               => 'Xiaomi 15 Pro',
			'slug'               => 'xiaomi-15-pro',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/371548/xiaomi-18-pro-12gb-256gb-220926-023514-400-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Đen', 'Trắng', 'Xanh Lá', 'Bản Titan' ) ),
			'base_buyback_price' => 16500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua Xiaomi 15 Pro Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Dịch vụ thu mua flagship Xiaomi 15 Pro cũ giá cao nhất thị trường.',
			'is_popular'         => 1,
			'sort_order'         => 14,
		),
		array(
			'brand_id'           => $xiaomi_id,
			'series_id'          => 12,
			'name'               => 'Xiaomi 14 Ultra',
			'slug'               => 'xiaomi-14-ultra',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/361270/xiaomi-17-ultra-den-thumb-600x600.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Đen', 'Trắng' ) ),
			'base_buyback_price' => 17000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua Xiaomi 14 Ultra Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua siêu phẩm camera Leica Xiaomi 14 Ultra cũ giá cao.',
			'is_popular'         => 1,
			'sort_order'         => 15,
		),

		// --- OPPO & GOOGLE ---
		array(
			'brand_id'           => $oppo_id,
			'series_id'          => 0,
			'name'               => 'OPPO Find X8 Pro',
			'slug'               => 'oppo-find-x8-pro',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/365402/oppo-find-x9s-12gb512gb.jpg',
			'storage_options'    => wp_json_encode( array( '256GB', '512GB' ) ),
			'color_options'      => wp_json_encode( array( 'Trắng Ngọc Trai', 'Đen Không Gian' ) ),
			'base_buyback_price' => 17500000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua OPPO Find X8 Pro Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua OPPO Find X8 Pro cũ chính hãng giá cao.',
			'is_popular'         => 1,
			'sort_order'         => 16,
		),
		array(
			'brand_id'           => $google_id,
			'series_id'          => 14,
			'name'               => 'Google Pixel 9 Pro XL',
			'slug'               => 'pixel-9-pro-xl',
			'image_url'          => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329149/iphone-16-pro-max-titan-trang-0-639175378937464054.jpg',
			'storage_options'    => wp_json_encode( array( '128GB', '256GB', '512GB', '1TB' ) ),
			'color_options'      => wp_json_encode( array( 'Obsidian', 'Porcelain', 'Hazel', 'Rose Quartz' ) ),
			'base_buyback_price' => 19000000,
			'grade_rates'        => wp_json_encode( array( 'A' => 1.0, 'B' => 0.85, 'C' => 0.68, 'D' => 0.45 ) ),
			'seo_title'          => 'Thu Mua Google Pixel 9 Pro XL Cũ Giá Cao | PhoneX',
			'seo_description'    => 'Thu mua Google Pixel 9 Pro XL cũ giá tốt nhất thị trường.',
			'is_popular'         => 1,
			'sort_order'         => 17,
		),
	);

	foreach ( $models_data as $m ) {
		$wpdb->insert( $t_models, $m );
	}
}
