<?php
/**
 * PhoneX Flash Sale Giờ Vàng - Admin Settings & Management
 *
 * Provides full control in WP Admin for:
 * - Enabling/disabling Flash Sale section
 * - Managing timeline slots (e.g. 09:00, 12:00, 14:00, 18:00, 21:00)
 * - Real-time countdown timer settings
 * - Managing 8 products (2 rows x 4 columns) with discounts, sold quantities, and stock
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Flash Sale Settings & 8 Flagship Products (2 rows x 4 cols)
 */
function phonex_get_default_flashsale_settings() {
	return array(
		'enabled'              => '1',
		'title'                => 'FLASH SALE GIỜ VÀNG',
		'subtitle'             => 'Khung giờ vàng giảm sốc - Số lượng có hạn',
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
			// HÀNG 1 (Row 1: 4 Products)
			array(
				'id'          => 1,
				'name'        => 'iPhone 18 Pro Max 256GB VN/A',
				'specs'       => '256GB | A19 Pro Bionic',
				'badge'       => '-15%',
				'price_sale'  => '33.490.000₫',
				'price_orig'  => '39.400.000₫',
				'sold'        => 45,
				'total_stock' => 50,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 2,
				'name'        => 'Galaxy S25 Ultra 512GB SSVN',
				'specs'       => '512GB | Snapdragon 8 Elite',
				'badge'       => '-18%',
				'price_sale'  => '34.990.000₫',
				'price_orig'  => '42.600.000₫',
				'sold'        => 38,
				'total_stock' => 50,
				'stock_text'  => 'Còn 12 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 3,
				'name'        => 'Xiaomi 14T Pro 5G Leica 512GB',
				'specs'       => '512GB | Dimensity 9300+',
				'badge'       => '-22%',
				'price_sale'  => '15.490.000₫',
				'price_orig'  => '19.990.000₫',
				'sold'        => 45,
				'total_stock' => 50,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 4,
				'name'        => 'iPhone 16 Pro Max 256GB Like New',
				'specs'       => 'Pin 98% | Grade A 99%',
				'badge'       => '#USED-99%',
				'price_sale'  => '24.890.000₫',
				'price_orig'  => '27.500.000₫',
				'sold'        => 19,
				'total_stock' => 20,
				'stock_text'  => 'Duy nhất 1 chiếc',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPT8j9gPDdQw803_EjHE9CrxcBd9ByYWch8rA3iK2EBwUlD-AYBurDY51Zuw1-Qsp9Vt7q1Pd3TVFYZSrTi9fCyrBWkDC5RcYBn8JZgRzAewL2GfxpWRIqXsBv_xwE0rndJ5hkpIutccJGL_JBkwS1NztjDieoZb_RoQt57EclFFLXTYI0bltlq5jZN_GOmx2UWCj1fqYtciRolzYGtW8p2r7rv-v-M7usKZhT8cNXKavd4vLaz8TF',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			// HÀNG 2 (Row 2: 4 Products - DÒNG BỔ SUNG MỚI)
			array(
				'id'          => 5,
				'name'        => 'iPad Pro M4 11 inch 256GB Wifi',
				'specs'       => '256GB | Apple M4 Chip 3nm',
				'badge'       => '-20%',
				'price_sale'  => '23.990.000₫',
				'price_orig'  => '28.990.000₫',
				'sold'        => 28,
				'total_stock' => 35,
				'stock_text'  => 'Đang bán chạy',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 6,
				'name'        => 'Samsung Galaxy Z Fold6 512GB AI',
				'specs'       => '512GB | Màn hình gập Dynamic AMOLED',
				'badge'       => '-25%',
				'price_sale'  => '36.990.000₫',
				'price_orig'  => '45.490.000₫',
				'sold'        => 15,
				'total_stock' => 20,
				'stock_text'  => 'Còn 5 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 7,
				'name'        => 'Apple AirPods Pro 2 Type-C MagSafe',
				'specs'       => 'Chống ồn 2X | Chip H2',
				'badge'       => '-30%',
				'price_sale'  => '4.890.000₫',
				'price_orig'  => '6.190.000₫',
				'sold'        => 89,
				'total_stock' => 100,
				'stock_text'  => 'Gần cháy hàng',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5',
				'link'        => '/pages/shop/product-detail/index.html',
			),
			array(
				'id'          => 8,
				'name'        => 'Apple Watch Ultra 2 GPS + Cellular 49mm',
				'specs'       => 'Titanium | Pin 72 giờ | Lặn 40m',
				'badge'       => '-18%',
				'price_sale'  => '17.990.000₫',
				'price_orig'  => '21.990.000₫',
				'sold'        => 22,
				'total_stock' => 30,
				'stock_text'  => 'Còn 8 suất',
				'image'       => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H',
				'link'        => '/pages/shop/product-detail/index.html',
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

	// Handle Save Action
	if ( isset( $_POST['phonex_flashsale_save_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['phonex_flashsale_save_nonce'] ), 'phonex_flashsale_save_action' ) ) {
		$current = phonex_get_flashsale_settings();

		// Basic options
		$current['enabled']           = isset( $_POST['enabled'] ) ? '1' : '0';
		$current['title']             = sanitize_text_field( wp_unslash( $_POST['title'] ?? 'FLASH SALE GIỜ VÀNG' ) );
		$current['subtitle']          = sanitize_text_field( wp_unslash( $_POST['subtitle'] ?? '' ) );
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
				$cleaned_products[] = array(
					'id'          => $idx + 1,
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
	<div class="wrap phonex-admin-wrap" style="max-width: 1200px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
		<div style="background: linear-gradient(135deg, #ba0d1a 0%, #e60012 100%); color: #fff; padding: 24px 30px; border-radius: 14px; margin: 20px 0 25px 0; box-shadow: 0 10px 25px rgba(186, 13, 26, 0.25); display: flex; align-items: center; justify-content: space-between;">
			<div>
				<h1 style="color: #fff; margin: 0; font-size: 26px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
					<span class="dashicons dashicons-flame" style="font-size: 32px; width: 32px; height: 32px; color: #ffd700;"></span>
					Quản Trị Flash Sale Giờ Vàng - PhoneX
				</h1>
				<p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">
					Quản lý các khung giờ vàng (12:00, 14:00, 18:00...), đồng hồ đếm ngược trực tiếp và 2 dòng sản phẩm giảm giá cực sốc.
				</p>
			</div>
			<div style="background: rgba(255,255,255,0.15); padding: 10px 18px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.25); text-align: center;">
				<div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Quy mô sản phẩm</div>
				<div style="font-size: 20px; font-weight: 800; color: #ffd700;">2 Dòng (8 Sản Phẩm)</div>
			</div>
		</div>

		<form method="post" action="">
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
									<span>Bật khối "FLASH SALE GIỜ VÀNG"</span>
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

			<!-- SECTION 2: QUẢN LÝ CÁC KHUNG GIỜ VÀNG (TIMELINE TABS) -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-clock" style="color: #ba0d1a;"></span>
					2. Quản Lý Khung Giờ Vàng (09:00, 12:00, 14:00, 18:00, 21:00...)
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

			<!-- SECTION 3: QUẢN LÝ 8 SẢN PHẨM FLASH SALE (2 HÀNG X 4 CỘT) -->
			<div style="background: #fff; border-radius: 12px; padding: 25px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
				<div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 2px solid #f3f4f6; margin-bottom: 16px;">
					<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0; display: flex; align-items: center; gap: 8px;">
						<span class="dashicons dashicons-products" style="color: #ba0d1a;"></span>
						3. Danh Sách 8 Sản Phẩm Flash Sale (2 Dòng x 4 Cột)
					</h2>
					<span style="background: #fee2e2; color: #ba0d1a; font-weight: 700; font-size: 12px; padding: 4px 12px; border-radius: 9999px;">
						Đầy đủ 2 hàng trên trang chủ
					</span>
				</div>

				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
					<?php foreach ( $settings['products'] as $idx => $prod ) : ?>
						<?php $row_num = ( $idx < 4 ) ? 1 : 2; ?>
						<div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; background: <?php echo $row_num === 2 ? '#fff9f9' : '#ffffff'; ?>; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
								<span style="font-weight: 800; font-size: 13px; color: <?php echo $row_num === 2 ? '#ba0d1a' : '#0f172a'; ?>;">
									#<?php echo esc_html( $idx + 1 ); ?> - Hàng <?php echo esc_html( $row_num ); ?> (Cột <?php echo esc_html( ( $idx % 4 ) + 1 ); ?>)
								</span>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][badge]" value="<?php echo esc_attr( $prod['badge'] ); ?>" style="width: 70px; text-align: center; font-weight: 700; font-size: 11px; background: #fee2e2; color: #ba0d1a; border: none; border-radius: 4px; padding: 2px 4px;" placeholder="-15%">
							</div>

							<div style="margin-bottom: 6px;">
								<label style="font-size: 11px; color: #64748b; font-weight: 600;">Tên sản phẩm:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $prod['name'] ); ?>" style="width: 100%; font-weight: 600; font-size: 13px;">
							</div>

							<div style="margin-bottom: 6px;">
								<label style="font-size: 11px; color: #64748b; font-weight: 600;">Thông số (Dung lượng | Chip):</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][specs]" value="<?php echo esc_attr( $prod['specs'] ); ?>" style="width: 100%; font-size: 12px;">
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 6px;">
								<div>
									<label style="font-size: 11px; color: #ba0d1a; font-weight: 700;">Giá Sale:</label>
									<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][price_sale]" value="<?php echo esc_attr( $prod['price_sale'] ); ?>" style="width: 100%; font-weight: 700; color: #ba0d1a;">
								</div>
								<div>
									<label style="font-size: 11px; color: #64748b; font-weight: 600;">Giá gốc:</label>
									<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][price_orig]" value="<?php echo esc_attr( $prod['price_orig'] ); ?>" style="width: 100%; color: #64748b;">
								</div>
							</div>

							<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 6px;">
								<div>
									<label style="font-size: 11px; color: #64748b; font-weight: 600;">Đã bán:</label>
									<input type="number" name="products[<?php echo esc_attr( $idx ); ?>][sold]" value="<?php echo esc_attr( $prod['sold'] ); ?>" style="width: 100%;">
								</div>
								<div>
									<label style="font-size: 11px; color: #64748b; font-weight: 600;">Tổng suất:</label>
									<input type="number" name="products[<?php echo esc_attr( $idx ); ?>][total_stock]" value="<?php echo esc_attr( $prod['total_stock'] ); ?>" style="width: 100%;">
								</div>
							</div>

							<div style="margin-bottom: 6px;">
								<label style="font-size: 11px; color: #64748b; font-weight: 600;">Trạng thái tồn kho:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][stock_text]" value="<?php echo esc_attr( $prod['stock_text'] ); ?>" style="width: 100%; font-size: 12px;" placeholder="Gần cháy hàng">
							</div>

							<div>
								<label style="font-size: 11px; color: #64748b; font-weight: 600;">Link ảnh URL:</label>
								<input type="text" name="products[<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $prod['image'] ); ?>" style="width: 100%; font-size: 11px;">
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- SUBMIT BUTTONS -->
			<div style="display: flex; align-items: center; gap: 15px; margin-top: 20px;">
				<button type="submit" class="button button-primary" style="background: #ba0d1a; border-color: #9b0b15; font-size: 15px; font-weight: 700; padding: 6px 28px; height: auto; box-shadow: 0 4px 12px rgba(186, 13, 26, 0.3);">
					Lưu Thay Đổi Flash Sale
				</button>

				<button type="submit" name="phonex_reset_default" value="1" class="button button-secondary" onclick="return confirm('Bạn có chắc chắn muốn khôi phục về 8 sản phẩm và 5 khung giờ mặc định ban đầu không?');">
					Khôi Phục Mặc Định (8 Sản Phẩm Flagship)
				</button>
			</div>
		</form>
	</div>
	<?php
}
