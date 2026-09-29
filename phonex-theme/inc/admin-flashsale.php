<?php
/**
 * PhoneX Flash Sale Giờ Vàng - Admin Settings & Management (Hybrid Model)
 *
 * Provides the BEST of both worlds:
 * 1. Pulls real products directly from WooCommerce Catalog (1-click auto-fill or dropdown per card)
 * 2. Connects "Mua Ngay" directly to real WooCommerce product checkout/cart
 * 3. Keeps full marketing flexibility: Custom special flash-price override, scarcity progress bars ("Đã bán 45/50")
 * 4. Manages 5 timeline slots (09:00, 12:00, 14:00, 18:00, 21:00) with live ticking countdown
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Flash Sale Settings & 12 Flagship Products (8 default + 4 on 'Xem thêm')
 */
function phonex_get_default_flashsale_settings() {
	return array(
		'enabled'              => '1',
		'title'                => 'FLASH SALE GIỜ VÀNG',
		'subtitle'             => 'Khung giờ vàng giảm sốc - Số lượng có hạn',
		'bg_preset'            => 'brand_rose', // 'brand_rose' (#fff5f5), 'warm_cream' (#fff6e3), 'clean_white' (#ffffff), 'custom'
		'bg_custom'            => '#fff5f5',
		'view_more_enabled'    => '1',
		'view_more_text'       => 'Xem thêm deal Flash Sale',
		'all_deals_text'       => 'Xem tất cả khuyến mãi',
		'all_deals_url'        => '/khuyen-mai/',
		'auto_slot'            => '1', // Automatically switch slot based on server time
		'active_slot_index'    => 1,   // Default to 12:00 slot
		'countdown_mode'       => 'auto', // 'auto' (until slot end_time) or 'custom'
		'countdown_hours'      => 2,
		'countdown_minutes'    => 45,
		'countdown_seconds'    => 0,
		'slots'                => array(
			array(
				'time'        => '09:00',
				'end_time'    => '11:59',
				'label'       => 'Vừa kết thúc',
				'status'      => 'ended',
			),
			array(
				'time'        => '12:00',
				'end_time'    => '13:59',
				'label'       => 'Đang diễn ra',
				'status'      => 'active',
			),
			array(
				'time'        => '14:00',
				'end_time'    => '17:59',
				'label'       => 'Sắp diễn ra',
				'status'      => 'upcoming',
			),
			array(
				'time'        => '18:00',
				'end_time'    => '20:59',
				'label'       => 'Sắp diễn ra',
				'status'      => 'upcoming',
			),
			array(
				'time'        => '21:00',
				'end_time'    => '23:59',
				'label'       => 'Sắp diễn ra',
				'status'      => 'upcoming',
			),
		),
		'products'             => array(
			// HÀNG 1 (Row 1: 4 Products - Hiển thị ban đầu)
			array(
				'id'          => 1,
				'product_id'  => 16,
				'name'        => 'iPhone 16 Pro Max 256GB VN/A',
				'specs'       => '256GB | A18 Pro Bionic',
				'badge'       => '-15%',
				'price_sale'  => '33.490.000₫',
				'price_orig'  => '39.400.000₫',
				'sold'        => 45,
				'total_stock' => 50,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H',
				'link'        => '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/',
			),
			array(
				'id'          => 2,
				'product_id'  => 17,
				'name'        => 'Galaxy S25 Ultra 512GB SSVN',
				'specs'       => '512GB | Snapdragon 8 Elite',
				'badge'       => '-18%',
				'price_sale'  => '34.990.000₫',
				'price_orig'  => '42.600.000₫',
				'sold'        => 38,
				'total_stock' => 50,
				'stock_text'  => 'Còn 12 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn',
				'link'        => '/product/samsung-galaxy-s25-ultra-512gb-chinh-hang-ssvn/',
			),
			array(
				'id'          => 3,
				'product_id'  => 18,
				'name'        => 'Xiaomi 15 Pro 256GB Leica Edition',
				'specs'       => '256GB | Snapdragon 8 Elite',
				'badge'       => '-22%',
				'price_sale'  => '15.490.000₫',
				'price_orig'  => '19.990.000₫',
				'sold'        => 45,
				'total_stock' => 50,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp',
				'link'        => '/product/xiaomi-15-pro-256gb-leica-optics-edition/',
			),
			array(
				'id'          => 4,
				'product_id'  => 21,
				'name'        => 'iPhone 15 Pro Max 256GB Like New',
				'specs'       => 'Pin 98% | Titan Tự Nhiên 99%',
				'badge'       => '#USED-99%',
				'price_sale'  => '24.890.000₫',
				'price_orig'  => '27.500.000₫',
				'sold'        => 19,
				'total_stock' => 20,
				'stock_text'  => 'Duy nhất 1 chiếc',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPT8j9gPDdQw803_EjHE9CrxcBd9ByYWch8rA3iK2EBwUlD-AYBurDY51Zuw1-Qsp9Vt7q1Pd3TVFYZSrTi9fCyrBWkDC5RcYBn8JZgRzAewL2GfxpWRIqXsBv_xwE0rndJ5hkpIutccJGL_JBkwS1NztjDieoZb_RoQt57EclFFLXTYI0bltlq5jZN_GOmx2UWCj1fqYtciRolzYGtW8p2r7rv-v-M7usKZhT8cNXKavd4vLaz8TF',
				'link'        => '/product/iphone-15-pro-max-256gb-titan-tu-nhien-may-cu-99/',
			),
			// HÀNG 2 (Row 2: 4 Products - Hiển thị ban đầu)
			array(
				'id'          => 5,
				'product_id'  => 19,
				'name'        => 'OPPO Find X8 Pro 512GB Hasselblad',
				'specs'       => '512GB | Camera Kép Kính Tiềm Vọng',
				'badge'       => '-20%',
				'price_sale'  => '23.990.000₫',
				'price_orig'  => '29.990.000₫',
				'sold'        => 28,
				'total_stock' => 35,
				'stock_text'  => 'Đang bán chạy',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn',
				'link'        => '/product/oppo-find-x8-pro-512gb-hasselblad-camera-master/',
			),
			array(
				'id'          => 6,
				'product_id'  => 20,
				'name'        => 'vivo X200 Pro 256GB ZEISS APO',
				'specs'       => '256GB | Cảm biến 200MP Chân Dung',
				'badge'       => '-25%',
				'price_sale'  => '19.990.000₫',
				'price_orig'  => '23.990.000₫',
				'sold'        => 15,
				'total_stock' => 20,
				'stock_text'  => 'Còn 5 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp',
				'link'        => '/product/vivo-x200-pro-256gb-zeiss-apo-telephoto/',
			),
			array(
				'id'          => 7,
				'product_id'  => 23,
				'name'        => 'Tai Nghe Apple AirPods Pro 2 MagSafe Type-C',
				'specs'       => 'Chống ồn 2X | Chip H2 Chính Hãng',
				'badge'       => '-30%',
				'price_sale'  => '4.890.000₫',
				'price_orig'  => '5.690.000₫',
				'sold'        => 89,
				'total_stock' => 100,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5',
				'link'        => '/product/tai-nghe-apple-airpods-pro-2-magsafe-usb-c/',
			),
			array(
				'id'          => 8,
				'product_id'  => 24,
				'name'        => 'Pin Sạc Dự Phòng Anker MagGo Qi2 10.000mAh',
				'specs'       => 'Hỗ Trợ MagSafe 15W Siêu Nhanh',
				'badge'       => '-25%',
				'price_sale'  => '990.000₫',
				'price_orig'  => '1.290.000₫',
				'sold'        => 62,
				'total_stock' => 80,
				'stock_text'  => 'Còn 18 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H',
				'link'        => '/product/pin-sac-du-phong-anker-maggo-qi2-10000mah/',
			),
			// HÀNG 3 (Row 3: 4 Products - Mở rộng khi bấm 'Xem thêm')
			array(
				'id'          => 9,
				'product_id'  => 22,
				'name'        => 'Củ Sạc Nhanh Apple 20W Type-C VN/A',
				'specs'       => 'PD 20W | Chuẩn Apple Chính Hãng',
				'badge'       => '-24%',
				'price_sale'  => '449.000₫',
				'price_orig'  => '590.000₫',
				'sold'        => 78,
				'total_stock' => 100,
				'stock_text'  => 'Bán chạy',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5',
				'link'        => '/product/cu-sac-nhanh-apple-20w-type-c-chinh-hang-apple-vn-a/',
			),
			array(
				'id'          => 10,
				'product_id'  => 25,
				'name'        => 'Kính Cường Lực Mipow Kingbull HD iPhone 16 Pro Max',
				'specs'       => 'Chống nhìn trộm | Siêu mượt 9H',
				'badge'       => '-24%',
				'price_sale'  => '319.000₫',
				'price_orig'  => '420.000₫',
				'sold'        => 95,
				'total_stock' => 100,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H',
				'link'        => '/product/kinh-cuong-luc-mipow-kingbull-hd-chong-nhin-trom-iphone-16-pro-max/',
			),
			array(
				'id'          => 11,
				'product_id'  => 26,
				'name'        => 'Apple Watch Series 10 Nhôm GPS 46mm',
				'specs'       => 'OLED Góc Rộng | Sạc Nhanh 80%',
				'badge'       => '-17%',
				'price_sale'  => '9.990.000₫',
				'price_orig'  => '11.990.000₫',
				'sold'        => 14,
				'total_stock' => 25,
				'stock_text'  => 'Còn 11 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn',
				'link'        => '/product/apple-watch-series-10-nhom-gps-46mm/',
			),
			array(
				'id'          => 12,
				'product_id'  => 27,
				'name'        => 'iPad Air 11 inch M2 WiFi 128GB',
				'specs'       => 'Chip M2 | Liquid Retina | Chuẩn Apple',
				'badge'       => '-15%',
				'price_sale'  => '14.490.000₫',
				'price_orig'  => '16.990.000₫',
				'sold'        => 18,
				'total_stock' => 30,
				'stock_text'  => 'Còn 12 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp',
				'link'        => '/product/ipad-air-11-inch-m2-wifi-128gb/',
			),
		),
	);
}

/**
 * Retrieve current Flash Sale settings
 */
function phonex_get_flashsale_settings() {
	$defaults = phonex_get_default_flashsale_settings();
	$settings = get_option( 'phonex_flashsale_settings', $defaults );

	if ( ! is_array( $settings ) ) {
		return $defaults;
	}

	return wp_parse_args( $settings, $defaults );
}

/**
 * Register Admin Menu for Flash Sale Giờ Vàng
 */
function phonex_flashsale_add_admin_menu() {
	add_menu_page(
		__( 'Cài Đặt Flash Sale Giờ Vàng', 'phonex' ),
		__( '⚡ Flash Sale Giờ Vàng', 'phonex' ),
		'manage_options',
		'phonex-flashsale',
		'phonex_flashsale_render_admin_page',
		'dashicons-flame',
		26
	);
}
add_action( 'admin_menu', 'phonex_flashsale_add_admin_menu' );

/**
 * Render Admin Page
 */
function phonex_flashsale_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Fetch all published WooCommerce products for instant selection
	$wc_products = function_exists( 'wc_get_products' ) ? wc_get_products( array(
		'limit'   => -1,
		'status'  => 'publish',
		'orderby' => 'date',
		'order'   => 'DESC',
	) ) : array();

	// Handle Save Action
	if ( isset( $_POST['phonex_flashsale_save_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['phonex_flashsale_save_nonce'] ), 'phonex_flashsale_save_action' ) ) {
		$current = phonex_get_flashsale_settings();

		// Basic options
		$current['enabled']           = isset( $_POST['enabled'] ) ? '1' : '0';
		$current['title']             = sanitize_text_field( wp_unslash( $_POST['title'] ?? 'FLASH SALE GIỜ VÀNG' ) );
		$current['subtitle']          = sanitize_text_field( wp_unslash( $_POST['subtitle'] ?? '' ) );
		$current['bg_preset']         = sanitize_text_field( wp_unslash( $_POST['bg_preset'] ?? 'brand_rose' ) );
		$current['bg_custom']         = sanitize_hex_color( wp_unslash( $_POST['bg_custom'] ?? '#fff5f5' ) ) ?: '#fff5f5';
		$current['view_more_enabled'] = isset( $_POST['view_more_enabled'] ) ? '1' : '0';
		$current['view_more_text']    = sanitize_text_field( wp_unslash( $_POST['view_more_text'] ?? 'Xem thêm deal Flash Sale' ) );
		$current['all_deals_text']    = sanitize_text_field( wp_unslash( $_POST['all_deals_text'] ?? 'Xem tất cả khuyến mãi' ) );
		$current['all_deals_url']     = sanitize_text_field( wp_unslash( $_POST['all_deals_url'] ?? '/khuyen-mai/' ) );

		$current['auto_slot']         = isset( $_POST['auto_slot'] ) ? '1' : '0';
		$current['active_slot_index'] = intval( $_POST['active_slot_index'] ?? 1 );
		$current['countdown_mode']    = sanitize_text_field( wp_unslash( $_POST['countdown_mode'] ?? 'auto' ) );
		$current['countdown_hours']   = max( 0, intval( $_POST['countdown_hours'] ?? 2 ) );
		$current['countdown_minutes'] = max( 0, min( 59, intval( $_POST['countdown_minutes'] ?? 45 ) ) );
		$current['countdown_seconds'] = max( 0, min( 59, intval( $_POST['countdown_seconds'] ?? 0 ) ) );

		// Timeline Slots
		if ( isset( $_POST['slots'] ) && is_array( $_POST['slots'] ) ) {
			$cleaned_slots = array();
			foreach ( $_POST['slots'] as $slot ) {
				$cleaned_slots[] = array(
					'time'     => sanitize_text_field( $slot['time'] ?? '12:00' ),
					'end_time' => sanitize_text_field( $slot['end_time'] ?? '13:59' ),
					'label'    => sanitize_text_field( $slot['label'] ?? 'Đang diễn ra' ),
					'status'   => sanitize_text_field( $slot['status'] ?? 'upcoming' ),
				);
			}
			$current['slots'] = $cleaned_slots;
		}

		// Products (8 items = 2 rows x 4 cols)
		if ( isset( $_POST['products'] ) && is_array( $_POST['products'] ) ) {
			$cleaned_products = array();
			foreach ( $_POST['products'] as $idx => $prod ) {
				$prod_id = intval( $prod['product_id'] ?? 0 );
				$cleaned_products[] = array(
					'id'          => $idx + 1,
					'product_id'  => $prod_id,
					'name'        => sanitize_text_field( $prod['name'] ?? '' ),
					'specs'       => sanitize_text_field( $prod['specs'] ?? '' ),
					'badge'       => sanitize_text_field( $prod['badge'] ?? '' ),
					'price_sale'  => sanitize_text_field( $prod['price_sale'] ?? '' ),
					'price_orig'  => sanitize_text_field( $prod['price_orig'] ?? '' ),
					'sold'        => max( 0, intval( $prod['sold'] ?? 0 ) ),
					'total_stock' => max( 1, intval( $prod['total_stock'] ?? 50 ) ),
					'stock_text'  => sanitize_text_field( $prod['stock_text'] ?? 'Còn hàng' ),
					'image'       => esc_url_raw( $prod['image'] ?? '' ),
					'link'        => sanitize_text_field( $prod['link'] ?? '#' ),
				);
			}
			$current['products'] = $cleaned_products;
		}

		// If user clicked reset
		if ( isset( $_POST['phonex_reset_default'] ) ) {
			$current = phonex_get_default_flashsale_settings();
		}

		update_option( 'phonex_flashsale_settings', $current );
		echo '<div class="notice notice-success is-dismissible" style="border-left-color: #ba0d1a;"><p><strong>Đã lưu thành công cài đặt Flash Sale Giờ Vàng!</strong></p></div>';
	}

	$settings = phonex_get_flashsale_settings();
	?>
	<div class="wrap phonex-admin-wrap" style="max-width: 1240px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
		<!-- HEADER BANNER -->
		<div style="background: linear-gradient(135deg, #ba0d1a 0%, #e60012 100%); color: #fff; padding: 24px 30px; border-radius: 14px; margin: 20px 0 25px 0; box-shadow: 0 10px 25px rgba(186, 13, 26, 0.25); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
			<div>
				<h1 style="color: #fff; margin: 0; font-size: 26px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
					<span class="dashicons dashicons-flame" style="font-size: 32px; width: 32px; height: 32px; color: #ffd700;"></span>
					Quản Trị Flash Sale Giờ Vàng - PhoneX (Mô Hình Lai Tối Ưu)
				</h1>
				<p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">
					Kết hợp tốt nhất giữa <strong>Sản phẩm thật trong WooCommerce</strong> và <strong>Số liệu kích cầu linh hoạt</strong> (Giá sale sốc, % giảm, thanh tiến trình "Gần cháy hàng").
				</p>
			</div>
			<div style="display: flex; gap: 10px;">
				<div style="background: rgba(255,255,255,0.15); padding: 10px 18px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.25); text-align: center;">
					<div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Quy mô</div>
					<div style="font-size: 18px; font-weight: 800; color: #ffd700;">2 Hàng (8 Sản Phẩm)</div>
				</div>
				<div style="background: rgba(255,255,255,0.15); padding: 10px 18px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.25); text-align: center;">
					<div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Kho WooCommerce</div>
					<div style="font-size: 18px; font-weight: 800; color: #fff;"><?php echo count( $wc_products ); ?> Sản phẩm</div>
				</div>
			</div>
		</div>

		<form method="post" action="" id="phonex-flashsale-form">
			<?php wp_nonce_field( 'phonex_flashsale_save_action', 'phonex_flashsale_save_nonce' ); ?>

			<!-- SECTION 1: CẤU HÌNH CHUNG & ĐỒNG HỒ COUNTDOWN -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-admin-settings" style="color: #ba0d1a;"></span>
					1. Cài Đặt Chung &amp; Đồng Hồ Đếm Ngược
				</h2>

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row"><label for="enabled">Hiển thị trên Trang chủ</label></th>
							<td>
								<label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
									<input type="checkbox" id="enabled" name="enabled" value="1" <?php checked( $settings['enabled'], '1' ); ?>>
									<span>Bật khối "FLASH SALE GIỜ VÀNG" trên trang chủ</span>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="title">Tiêu đề Flash Sale</label></th>
							<td>
								<input type="text" id="title" name="title" value="<?php echo esc_attr( $settings['title'] ); ?>" class="regular-text" style="font-weight: 700; color: #ba0d1a;">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="subtitle">Mô tả phụ</label></th>
							<td>
								<input type="text" id="subtitle" name="subtitle" value="<?php echo esc_attr( $settings['subtitle'] ); ?>" class="large-text">
							</td>
						</tr>
						<tr>
							<th scope="row">Đồng hồ đếm ngược (Countdown)</th>
							<td>
								<div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
									<label style="display: flex; align-items: center; gap: 6px;">
										<strong>Giờ:</strong>
										<input type="number" name="countdown_hours" value="<?php echo esc_attr( $settings['countdown_hours'] ); ?>" min="0" max="99" style="width: 70px;">
									</label>
									<label style="display: flex; align-items: center; gap: 6px;">
										<strong>Phút:</strong>
										<input type="number" name="countdown_minutes" value="<?php echo esc_attr( $settings['countdown_minutes'] ); ?>" min="0" max="59" style="width: 70px;">
									</label>
									<label style="display: flex; align-items: center; gap: 6px;">
										<strong>Giây:</strong>
										<input type="number" name="countdown_seconds" value="<?php echo esc_attr( $settings['countdown_seconds'] ); ?>" min="0" max="59" style="width: 70px;">
									</label>
									<span class="description" style="color: #64748b;">(Đồng hồ sẽ chạy lùi theo giây theo thời gian này trên giao diện thực tế)</span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- SECTION 2: TÙY CHỌN MÀU NỀN SECTION FLASH SALE -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-art" style="color: #ba0d1a;"></span>
					2. Màu Nền Section Flash Sale (Đồng Bộ Nhận Diện Thương Hiệu Website)
				</h2>
				<p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
					Chọn tông màu nền cho toàn bộ khối Flash Sale. Màu sắc được phối theo chuẩn phong cách pastel sang trọng giúp các thẻ sản phẩm màu trắng nổi bật rực rỡ.
				</p>

				<?php 
					$cur_preset = $settings['bg_preset'] ?? 'brand_rose';
					$cur_custom = $settings['bg_custom'] ?? '#fff5f5';
				?>
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 16px;">
					<!-- Option 1: PhoneX Brand Rose Pastel (Default) -->
					<label style="display: flex; flex-direction: column; border: 2px solid <?php echo $cur_preset === 'brand_rose' ? '#ba0d1a' : '#e2e8f0'; ?>; border-radius: 12px; padding: 14px; background: #fff5f5; cursor: pointer; position: relative;">
						<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
							<div style="display: flex; align-items: center; gap: 8px;">
								<input type="radio" name="bg_preset" value="brand_rose" <?php checked( $cur_preset, 'brand_rose' ); ?>>
								<strong style="color: #ba0d1a; font-size: 14px;">Hồng Phấn Pastel PhoneX</strong>
							</div>
							<span style="background: #ba0d1a; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 9999px;">KHUYÊN DÙNG</span>
						</div>
						<div style="height: 38px; border-radius: 8px; background: linear-gradient(180deg, #fff5f5 0%, #fff0f1 100%); border: 1px solid #fecdd3; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #ba0d1a;">
							#fff5f5 (Màu website PhoneX)
						</div>
						<p style="font-size: 12px; color: #475569; margin: 0; line-height: 1.4;">
							Chuẩn nhận diện thương hiệu đỏ PhoneX kết hợp nền pastel hồng phấn dịu mắt, thẻ sản phẩm trắng nổi bật đẳng cấp.
						</p>
					</label>

					<!-- Option 2: Warm Cream (Image Reference) -->
					<label style="display: flex; flex-direction: column; border: 2px solid <?php echo $cur_preset === 'warm_cream' ? '#ba0d1a' : '#e2e8f0'; ?>; border-radius: 12px; padding: 14px; background: #fffbf2; cursor: pointer;">
						<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
							<input type="radio" name="bg_preset" value="warm_cream" <?php checked( $cur_preset, 'warm_cream' ); ?>>
							<strong style="color: #b45309; font-size: 14px;">Kem Vàng Nhạt Ấm Áp</strong>
						</div>
						<div style="height: 38px; border-radius: 8px; background: linear-gradient(180deg, #fffcf5 0%, #fff6e3 100%); border: 1px solid #fde68a; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #b45309;">
							#fff6e3 (Y hệt ảnh bạn gửi)
						</div>
						<p style="font-size: 12px; color: #475569; margin: 0; line-height: 1.4;">
							Màu vàng kem ấm áp chuẩn 100% theo tông màu bức ảnh mẫu e-commerce bạn đã tải lên.
						</p>
					</label>

					<!-- Option 3: Clean White -->
					<label style="display: flex; flex-direction: column; border: 2px solid <?php echo $cur_preset === 'clean_white' ? '#ba0d1a' : '#e2e8f0'; ?>; border-radius: 12px; padding: 14px; background: #ffffff; cursor: pointer;">
						<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
							<input type="radio" name="bg_preset" value="clean_white" <?php checked( $cur_preset, 'clean_white' ); ?>>
							<strong style="color: #0f172a; font-size: 14px;">Trắng Hiện Đại</strong>
						</div>
						<div style="height: 38px; border-radius: 8px; background: #ffffff; border: 1px solid #e2e8f0; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #64748b;">
							#ffffff (Nền trắng tinh)
						</div>
						<p style="font-size: 12px; color: #475569; margin: 0; line-height: 1.4;">
							Khung viền mỏng hiện đại, nền trong suốt hòa quyện với bố cục trang web.
						</p>
					</label>

					<!-- Option 4: Custom Hex -->
					<label style="display: flex; flex-direction: column; border: 2px solid <?php echo $cur_preset === 'custom' ? '#ba0d1a' : '#e2e8f0'; ?>; border-radius: 12px; padding: 14px; background: #f8fafc; cursor: pointer;">
						<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
							<input type="radio" name="bg_preset" value="custom" <?php checked( $cur_preset, 'custom' ); ?>>
							<strong style="color: #0f172a; font-size: 14px;">Tùy Chỉnh Mã Màu HEX</strong>
						</div>
						<div style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
							<input type="color" id="bg_custom_picker" value="<?php echo esc_attr( $cur_custom ); ?>" style="width: 38px; height: 38px; padding: 2px; border-radius: 6px; border: 1px solid #cbd5e1; cursor: pointer;" oninput="document.getElementById('bg_custom').value = this.value">
							<input type="text" id="bg_custom" name="bg_custom" value="<?php echo esc_attr( $cur_custom ); ?>" style="font-size: 13px; font-weight: 700; width: 100%; height: 38px;" placeholder="#fff5f5" oninput="document.getElementById('bg_custom_picker').value = this.value">
						</div>
						<p style="font-size: 12px; color: #475569; margin: 0; line-height: 1.4;">
							Nhập bất kỳ mã màu nền HEX nào bạn muốn áp dụng cho khối Flash Sale.
						</p>
					</label>
				</div>
			</div>

			<!-- SECTION 3: CẤU HÌNH NÚT 'XEM THÊM' & 'TẤT CẢ DEAL' -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-plus-alt2" style="color: #ba0d1a;"></span>
					3. Cấu Hình Nút "Xem Thêm" Khi Có Nhiều Sản Phẩm Flash Sale
				</h2>
				<p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
					Khi bạn có nhiều hơn 8 sản phẩm Flash Sale, trang chủ sẽ hiển thị 8 sản phẩm đầu tiên và có nút <strong>"Xem thêm deal Flash Sale ▾"</strong>. Khách bấm vào sẽ mở rộng thêm 4 sản phẩm tiếp theo mượt mà ngay tại chỗ!
				</p>

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row"><label for="view_more_enabled">Bật nút "Xem thêm"</label></th>
							<td>
								<label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
									<input type="checkbox" id="view_more_enabled" name="view_more_enabled" value="1" <?php checked( $settings['view_more_enabled'] ?? '1', '1' ); ?>>
									<span>Hiển thị cụm nút "Xem thêm deal Flash Sale" &amp; "Xem tất cả khuyến mãi"</span>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="view_more_text">Chữ trên nút Xem Thêm</label></th>
							<td>
								<input type="text" id="view_more_text" name="view_more_text" value="<?php echo esc_attr( $settings['view_more_text'] ?? 'Xem thêm deal Flash Sale' ); ?>" class="regular-text" style="font-weight: 600;">
								<span class="description" style="color: #64748b; margin-left: 10px;">(Mặc định: Xem thêm deal Flash Sale)</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="all_deals_text">Chữ trên nút Xem Tất Cả</label></th>
							<td>
								<input type="text" id="all_deals_text" name="all_deals_text" value="<?php echo esc_attr( $settings['all_deals_text'] ?? 'Xem tất cả khuyến mãi' ); ?>" class="regular-text">
								<span class="description" style="color: #64748b; margin-left: 10px;">(Mặc định: Xem tất cả khuyến mãi)</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="all_deals_url">Link trang khuyến mãi</label></th>
							<td>
								<input type="text" id="all_deals_url" name="all_deals_url" value="<?php echo esc_attr( $settings['all_deals_url'] ?? '/khuyen-mai/' ); ?>" class="regular-text">
								<span class="description" style="color: #64748b; margin-left: 10px;">(Ví dụ: /khuyen-mai/ hoặc link tùy ý)</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- SECTION 4: QUẢN LÝ CÁC KHUNG GIỜ VÀNG (TIMELINE TABS) -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-clock" style="color: #ba0d1a;"></span>
					4. Quản Lý Khung Giờ Vàng (09:00, 12:00, 14:00, 18:00, 21:00...)
				</h2>
				<p style="color: #64748b; font-size: 13px; margin-bottom: 16px;">
					Tùy chỉnh giờ bắt đầu, kết thúc và trạng thái hiển thị cho từng khung giờ trên thanh tab ngang của website.
				</p>

				<table class="widefat fixed striped" style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
					<thead>
						<tr style="background: #f8fafc;">
							<th style="width: 70px; text-align: center; font-weight: 700;">Kích hoạt</th>
							<th style="width: 140px; font-weight: 700;">Khung Giờ Bắt Đầu</th>
							<th style="width: 140px; font-weight: 700;">Giờ Kết Thúc</th>
							<th style="font-weight: 700;">Nhãn Hiển Thị</th>
							<th style="width: 180px; font-weight: 700;">Trạng Thái</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $settings['slots'] as $i => $slot ) : ?>
							<tr>
								<td style="text-align: center; vertical-align: middle;">
									<input type="radio" name="active_slot_index" value="<?php echo esc_attr( $i ); ?>" <?php checked( $settings['active_slot_index'], $i ); ?> title="Chọn khung giờ này làm khung giờ mặc định đang diễn ra">
								</td>
								<td>
									<input type="text" name="slots[<?php echo esc_attr( $i ); ?>][time]" value="<?php echo esc_attr( $slot['time'] ); ?>" style="font-weight: 700; font-size: 15px; width: 100%;">
								</td>
								<td>
									<input type="text" name="slots[<?php echo esc_attr( $i ); ?>][end_time]" value="<?php echo esc_attr( $slot['end_time'] ?? '' ); ?>" style="font-size: 14px; width: 100%;">
								</td>
								<td>
									<input type="text" name="slots[<?php echo esc_attr( $i ); ?>][label]" value="<?php echo esc_attr( $slot['label'] ); ?>" style="width: 100%;">
								</td>
								<td>
									<select name="slots[<?php echo esc_attr( $i ); ?>][status]" style="width: 100%;">
										<option value="ended" <?php selected( $slot['status'], 'ended' ); ?>>Vừa kết thúc (Xám)</option>
										<option value="active" <?php selected( $slot['status'], 'active' ); ?>>Đang diễn ra (Đỏ PhoneX)</option>
										<option value="upcoming" <?php selected( $slot['status'], 'upcoming' ); ?>>Sắp diễn ra (Trắng/Viền)</option>
									</select>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- SECTION 5: QUẢN LÝ 12 SẢN PHẨM FLASH SALE (8 HIỂN THỊ BAN ĐẦU + 4 MỞ RỘNG KHI BẤM XEM THÊM) -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 14px; border-bottom: 2px solid #f3f4f6; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
					<div>
						<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0; display: flex; align-items: center; gap: 8px;">
							<span class="dashicons dashicons-products" style="color: #ba0d1a;"></span>
							5. Danh Sách Sản Phẩm Flash Sale (8 Hiển Thị Ban Đầu + 4 Mở Rộng Khi Bấm 'Xem Thêm')
						</h2>
						<p style="color: #64748b; font-size: 13px; margin: 4px 0 0 0;">
							Bạn có thể <strong>chọn sản phẩm từ kho WooCommerce</strong> để tự động điền Tên, Giá, Link mua hàng; đồng thời <strong>tùy biến giá sốc &amp; thanh tiến trình</strong> theo ý bạn.
						</p>
					</div>

					<div style="display: flex; gap: 8px; flex-wrap: wrap;">
						<button type="button" id="btn-autofill-wc" class="button" style="background: #0284c7; color: #fff; border-color: #0369a1; font-weight: 600; display: flex; align-items: center; gap: 5px;">
							<span class="dashicons dashicons-update-alt" style="font-size: 16px; width: 16px; height: 16px;"></span>
							⚡ Tự Động Điền 12 Sản Phẩm Từ WooCommerce
						</button>
						<span style="background: #fee2e2; color: #ba0d1a; font-weight: 700; font-size: 12px; padding: 6px 14px; border-radius: 9999px; display: inline-flex; align-items: center;">
							Tổng cộng: <?php echo count( $settings['products'] ); ?> Sản phẩm
						</span>
					</div>
				</div>

				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 18px;">
					<?php foreach ( $settings['products'] as $idx => $prod ) : ?>
						<?php 
							$row_num = ( $idx < 4 ) ? 1 : ( ( $idx < 8 ) ? 2 : 3 );
							$is_extra_row = ( $idx >= 8 );
							$saved_pid = intval( $prod['product_id'] ?? 0 );
						?>
						<div class="phonex-prod-card" data-idx="<?php echo esc_attr( $idx ); ?>" style="border: 1.5px solid <?php echo $is_extra_row ? '#d8b4fe' : ( $row_num === 2 ? '#fecdd3' : '#e2e8f0' ); ?>; border-radius: 12px; padding: 16px; background: <?php echo $is_extra_row ? '#faf5ff' : ( $row_num === 2 ? '#fff9f9' : '#ffffff' ); ?>; box-shadow: 0 2px 6px rgba(0,0,0,0.04); transition: border-color 0.2s; position: relative;">
							<input type="hidden" name="products[<?php echo esc_attr( $idx ); ?>][product_id]" class="field-product-id" value="<?php echo esc_attr( $saved_pid ); ?>">

							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
								<div>
									<span style="font-weight: 800; font-size: 13px; color: <?php echo $is_extra_row ? '#7c3aed' : ( $row_num === 2 ? '#ba0d1a' : '#0f172a' ); ?>;">
										#<?php echo esc_html( $idx + 1 ); ?> - Hàng <?php echo esc_html( $row_num ); ?> (Cột <?php echo esc_html( ( $idx % 4 ) + 1 ); ?>)
									</span>
									<div style="font-size: 10px; font-weight: 700; color: <?php echo $is_extra_row ? '#9333ea' : '#16a34a'; ?>; margin-top: 2px;">
										<?php echo $is_extra_row ? '⚡ Mở rộng khi bấm "Xem thêm"' : '✓ Hiển thị mặc định ban đầu'; ?>
									</div>
								</div>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][badge]" class="field-badge" value="<?php echo esc_attr( $prod['badge'] ); ?>" style="width: 75px; text-align: center; font-weight: 700; font-size: 12px; background: <?php echo $is_extra_row ? '#f3e8ff' : '#fee2e2'; ?>; color: <?php echo $is_extra_row ? '#7c3aed' : '#ba0d1a'; ?>; border: 1px solid <?php echo $is_extra_row ? '#d8b4fe' : '#fecaca'; ?>; border-radius: 6px; padding: 2px 6px;" placeholder="-15%">
							</div>

							<!-- WOOCOMMERCE PRODUCT PICKER DROPDOWN -->
							<div style="background: <?php echo $is_extra_row ? '#f5f3ff' : '#f1f5f9'; ?>; padding: 8px 10px; border-radius: 8px; margin-bottom: 12px; border: 1.5px dashed <?php echo $is_extra_row ? '#c4b5fd' : '#cbd5e1'; ?>;">
								<label style="font-size: 11px; font-weight: 700; color: <?php echo $is_extra_row ? '#6d28d9' : '#0369a1'; ?>; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
									<span class="dashicons dashicons-cart" style="font-size: 14px; width: 14px; height: 14px;"></span>
									Chọn nhanh từ Sản Phẩm WooCommerce:
								</label>
								<select class="wc-product-picker" data-idx="<?php echo esc_attr( $idx ); ?>" style="width: 100%; font-size: 12px; height: 32px; border-color: #cbd5e1;">
									<option value="">-- Tự nhập thủ công (hoặc chọn để tự điền) --</option>
									<?php foreach ( $wc_products as $wcp ) : 
										$wcp_id = $wcp->get_id();
										$wcp_name = $wcp->get_name();
										$wcp_reg_price = $wcp->get_regular_price();
										$wcp_sale_price = $wcp->get_sale_price();
										$wcp_cur_price = $wcp->get_price();
										$wcp_img = wp_get_attachment_image_url( $wcp->get_image_id(), 'full' );
										$wcp_url = $wcp->get_permalink();
										$wcp_badge = '';
										if ( ! empty( $wcp_reg_price ) && ! empty( $wcp_sale_price ) && floatval( $wcp_reg_price ) > 0 ) {
											$pct = round( ( ( floatval( $wcp_reg_price ) - floatval( $wcp_sale_price ) ) / floatval( $wcp_reg_price ) ) * 100 );
											if ( $pct > 0 ) {
												$wcp_badge = '-' . $pct . '%';
											}
										}
									?>
										<option value="<?php echo esc_attr( $wcp_id ); ?>"
											data-name="<?php echo esc_attr( $wcp_name ); ?>"
											data-price-orig="<?php echo esc_attr( ! empty( $wcp_reg_price ) ? number_format( $wcp_reg_price, 0, ',', '.' ) . '₫' : '' ); ?>"
											data-price-sale="<?php echo esc_attr( ! empty( $wcp_sale_price ) ? number_format( $wcp_sale_price, 0, ',', '.' ) . '₫' : ( ! empty( $wcp_cur_price ) ? number_format( $wcp_cur_price, 0, ',', '.' ) . '₫' : '' ) ); ?>"
											data-badge="<?php echo esc_attr( $wcp_badge ); ?>"
											data-img="<?php echo esc_attr( $wcp_img ); ?>"
											data-url="<?php echo esc_attr( $wcp_url ); ?>"
											<?php selected( $saved_pid, $wcp_id ); ?>
										>
											#<?php echo esc_html( $wcp_id ); ?> - <?php echo esc_html( $wcp_name ); ?> (<?php echo esc_html( number_format( $wcp_cur_price, 0, ',', '.' ) . '₫' ); ?>)
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<div style="margin-bottom: 8px;">
								<label style="font-size: 11px; color: #475569; font-weight: 600;">Tên sản phẩm:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][name]" class="field-name" value="<?php echo esc_attr( $prod['name'] ); ?>" style="width: 100%; font-weight: 600; font-size: 13px;">
							</div>

							<div style="margin-bottom: 8px;">
								<label style="font-size: 11px; color: #475569; font-weight: 600;">Thông số (Dung lượng | Chip):</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][specs]" class="field-specs" value="<?php echo esc_attr( $prod['specs'] ); ?>" style="width: 100%; font-size: 12px;">
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
								<div>
									<label style="font-size: 11px; color: #ba0d1a; font-weight: 700;">Giá Flash Sale:</label>
									<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][price_sale]" class="field-price-sale" value="<?php echo esc_attr( $prod['price_sale'] ); ?>" style="width: 100%; font-weight: 700; color: #ba0d1a;">
								</div>
								<div>
									<label style="font-size: 11px; color: #64748b; font-weight: 600;">Giá gốc:</label>
									<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][price_orig]" class="field-price-orig" value="<?php echo esc_attr( $prod['price_orig'] ); ?>" style="width: 100%; color: #64748b;">
								</div>
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
								<div>
									<label style="font-size: 11px; color: #475569; font-weight: 600;">Đã bán:</label>
									<input type="number" name="products[<?php echo esc_attr( $idx ); ?>][sold]" class="field-sold" value="<?php echo esc_attr( $prod['sold'] ); ?>" style="width: 100%;">
								</div>
								<div>
									<label style="font-size: 11px; color: #475569; font-weight: 600;">Tổng suất:</label>
									<input type="number" name="products[<?php echo esc_attr( $idx ); ?>][total_stock]" class="field-total-stock" value="<?php echo esc_attr( $prod['total_stock'] ); ?>" style="width: 100%;">
								</div>
							</div>

							<div style="margin-bottom: 8px;">
								<label style="font-size: 11px; color: #475569; font-weight: 600;">Trạng thái tồn kho:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][stock_text]" class="field-stock-text" value="<?php echo esc_attr( $prod['stock_text'] ); ?>" style="width: 100%; font-size: 12px;" placeholder="Gần cháy hàng">
							</div>

							<div style="margin-bottom: 8px;">
								<label style="font-size: 11px; color: #475569; font-weight: 600;">Link ảnh URL:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][image]" class="field-image" value="<?php echo esc_attr( $prod['image'] ); ?>" style="width: 100%; font-size: 11px;">
							</div>

							<div>
								<label style="font-size: 11px; color: #475569; font-weight: 600;">Link mua hàng / chi tiết:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][link]" class="field-link" value="<?php echo esc_attr( $prod['link'] ); ?>" style="width: 100%; font-size: 11px;">
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- SUBMIT BUTTONS -->
			<div style="display: flex; align-items: center; gap: 15px; margin-top: 25px; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<button type="submit" class="button button-primary" style="background: #ba0d1a; border-color: #9b0b15; font-size: 15px; font-weight: 700; padding: 8px 32px; height: auto; box-shadow: 0 4px 12px rgba(186, 13, 26, 0.3);">
					Lưu Thay Đổi Flash Sale
				</button>

				<button type="submit" name="phonex_reset_default" value="1" class="button button-secondary" onclick="return confirm('Bạn có chắc chắn muốn khôi phục về 12 sản phẩm và 5 khung giờ mặc định ban đầu không?');">
					Khôi Phục 12 Flagship Mẫu PhoneX
				</button>
			</div>
		</form>
	</div>

	<!-- CLIENT-SIDE SCRIPT FOR SELECTION & AUTO-FILL -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// When individual picker changes
		document.querySelectorAll('.wc-product-picker').forEach(function(select) {
			select.addEventListener('change', function() {
				const opt = this.options[this.selectedIndex];
				const card = this.closest('.phonex-prod-card');
				if (!card) return;

				if (opt && opt.value) {
					const name = opt.dataset.name || '';
					const priceOrig = opt.dataset.priceOrig || '';
					const priceSale = opt.dataset.priceSale || '';
					const badge = opt.dataset.badge || '';
					const img = opt.dataset.img || '';
					const url = opt.dataset.url || '';

					const fId = card.querySelector('.field-product-id');
					const fName = card.querySelector('.field-name');
					const fPriceOrig = card.querySelector('.field-price-orig');
					const fPriceSale = card.querySelector('.field-price-sale');
					const fBadge = card.querySelector('.field-badge');
					const fLink = card.querySelector('.field-link');
					const fImg = card.querySelector('.field-image');

					if (fId) fId.value = opt.value;
					if (fName && name) fName.value = name;
					if (fPriceOrig && priceOrig) fPriceOrig.value = priceOrig;
					if (fPriceSale && priceSale) fPriceSale.value = priceSale;
					if (fBadge && badge) fBadge.value = badge;
					if (fLink && url) fLink.value = url;
					if (fImg && img) fImg.value = img;

					// Visual highlight
					card.style.borderColor = '#0284c7';
					setTimeout(() => { card.style.borderColor = '#e2e8f0'; }, 1000);
				}
			});
		});

		// 1-Click Master Autofill from WooCommerce
		const btnAutofill = document.getElementById('btn-autofill-wc');
		if (btnAutofill) {
			btnAutofill.addEventListener('click', function() {
				const cards = document.querySelectorAll('.phonex-prod-card');
				const firstPicker = document.querySelector('.wc-product-picker');
				if (!firstPicker) return;

				const availableOpts = Array.from(firstPicker.options).filter(o => o.value !== '');
				if (availableOpts.length === 0) {
					alert('Chưa tìm thấy sản phẩm nào trong WooCommerce để tự động điền!');
					return;
				}

				cards.forEach(function(card, idx) {
					if (idx < availableOpts.length) {
						const opt = availableOpts[idx];
						const picker = card.querySelector('.wc-product-picker');
						if (picker) {
							picker.value = opt.value;
							picker.dispatchEvent(new Event('change'));
						}
					}
				});

				alert('Đã tự động tải thành công các sản phẩm từ kho WooCommerce vào 12 ô sản phẩm!');
			});
		}

		// Preset radio border highlighter
		document.querySelectorAll('input[name="bg_preset"]').forEach(function(radio) {
			radio.addEventListener('change', function() {
				document.querySelectorAll('input[name="bg_preset"]').forEach(function(r) {
					const lbl = r.closest('label');
					if (lbl) lbl.style.borderColor = r.checked ? '#ba0d1a' : '#e2e8f0';
				});
			});
		});
	});
	</script>
	<?php
}
