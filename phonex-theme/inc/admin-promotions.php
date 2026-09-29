<?php
/**
 * PhoneX Mega Promotions Page - Admin Settings & Management
 *
 * Dedicated admin page "Trang Khuyến Mãi" (separate from "Flash Sale Giờ Vàng").
 * Manages:
 * 1. Hero Campaign Banner (Campaign Badge, Main Heading, Subtitle, Countdown Timer)
 * 2. Exclusive Claimable Vouchers (500K, 200K, Promo Codes, Expiry, Terms)
 * 3. Section Headers & Subtitles for all categories (Phone, Apple, Tablet, Accessories, Smartwatch, Trade-In)
 * 4. Products for each category with WooCommerce auto-fill support
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Settings for Mega Promotions Page
 */
function phonex_get_default_promotions_settings() {
	return array(
		// 1. HERO CAMPAIGN BANNER
		'hero_badge'             => 'ĐẠI HỘI FLASH SALE 2026 • ĐỘC QUYỀN TẠI PHONEX',
		'hero_title_1'           => 'TỰU TRƯỜNG DEAL THƠMMM',
		'hero_title_2'           => 'GIẢM SỐC ĐẾN 50%',
		'hero_desc'              => 'Hàng nghìn siêu phẩm Smartphone Flagship, Tablet, Laptop, Phụ kiện & Smartwatch chính hãng VN/A đồng loạt hạ giá khung giờ vàng. Trợ giá thu cũ đổi mới lên đến 3.000.000đ, trả góp 0% lãi suất.',
		'hero_hours'             => 2,
		'hero_minutes'           => 45,
		'hero_seconds'           => 0,
		'badge_1_text'           => '100% Chính Hãng VN/A',
		'badge_2_text'           => '1 Đổi 1 Trong 30 Ngày',
		'badge_3_text'           => 'Giao Hỏa Tốc 1H',

		// 2. EXCLUSIVE CLAIMABLE VOUCHERS
		'voucher_1_badge'        => '500K',
		'voucher_1_title'        => 'Giảm 500.000₫ cho Điện Thoại',
		'voucher_1_desc'         => 'Đơn từ 10.000.000₫ • HSD: Hôm nay',
		'voucher_1_code'         => 'PHONEX500K',

		'voucher_2_badge'        => '200K',
		'voucher_2_title'        => 'Giảm 200.000₫ cho Phụ Kiện',
		'voucher_2_desc'         => 'Đơn từ 800.000₫ • HSD: Hôm nay',
		'voucher_2_code'         => 'PHONEX200K',

		// 3. SECTION HEADERS & SUBTITLES
		'sec_phone_title'        => 'ĐIỆN THOẠI GIÁ RẺ QUÁ – GIẢM ĐẾN 35%',
		'sec_phone_subtitle'     => 'Bảo hành 12 tháng chính hãng • Thu cũ đổi mới trợ giá 3 triệu',

		'sec_apple_title'        => 'HỆ SINH THÁI APPLE CHÍNH HÃNG VN/A',
		'sec_apple_subtitle'     => 'Đại lý ủy quyền chính thức • Trợ giá học sinh sinh viên đến 3 triệu',
		'sec_apple_badge'        => 'Apple Authorised Reseller',

		'sec_tablet_title'       => 'TABLET & LAPTOP HỌC TẬP - VĂN PHÒNG',
		'sec_tablet_subtitle'    => 'Ưu đãi sinh viên giảm thêm 500.000₫ • Tặng kèm túi chống sốc',

		'sec_accessory_title'    => 'PHỤ KIỆN CHÍNH HÃNG - ĐỒNG GIÁ TỪ 99K',
		'sec_accessory_subtitle' => 'Bảo hành 1 đổi 1 trong 12 tháng • Mua 2 giảm thêm 10%',

		'sec_watch_title'        => 'ĐỒNG HỒ THÔNG MINH & SỨC KHỎE 24/7',
		'sec_watch_subtitle'     => 'Đo điện tâm đồ ECG • Huyết áp • GPS đa băng tần chính xác',

		'sec_tradein_title'      => 'Lên Đời Smartphone Mới – Trợ Giá Đến 3.000.000đ',
		'sec_tradein_subtitle'   => 'PhoneX tiếp nhận thu mua máy cũ tất cả các dòng iPhone, Samsung, Xiaomi,... Thẩm định chuẩn AI 60 giây, giải ngân nhận tiền mặt hoặc trừ tiếp vào giá máy mới.',
	);
}

/**
 * Retrieve saved Promotions settings
 */
function phonex_get_promotions_settings() {
	$defaults = phonex_get_default_promotions_settings();
	$settings = get_option( 'phonex_promotions_settings', false );

	if ( false === $settings || ! is_array( $settings ) ) {
		return $defaults;
	}

	return wp_parse_args( $settings, $defaults );
}

/**
 * Register Admin Menu for "🎁 Trang Khuyến Mãi" (Separate from Flash Sale)
 */
function phonex_promotions_add_admin_menu() {
	add_menu_page(
		__( 'Cài Đặt Chuyên Trang Khuyến Mãi', 'phonex' ),
		__( '🎁 Trang Khuyến Mãi', 'phonex' ),
		'manage_options',
		'phonex-promotions',
		'phonex_promotions_render_admin_page',
		'dashicons-tickets-alt',
		27 // Located right next to Flash Sale (pos 26)
	);
}
add_action( 'admin_menu', 'phonex_promotions_add_admin_menu' );

/**
 * Render Admin Page for Promotions Management
 */
function phonex_promotions_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$defaults = phonex_get_default_promotions_settings();
	$message  = '';

	// Handle Save Action
	if ( isset( $_POST['phonex_promotions_save_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['phonex_promotions_save_nonce'] ), 'phonex_promotions_save_action' ) ) {
		$current = array(
			// Hero
			'hero_badge'             => sanitize_text_field( wp_unslash( $_POST['hero_badge'] ?? $defaults['hero_badge'] ) ),
			'hero_title_1'           => sanitize_text_field( wp_unslash( $_POST['hero_title_1'] ?? $defaults['hero_title_1'] ) ),
			'hero_title_2'           => sanitize_text_field( wp_unslash( $_POST['hero_title_2'] ?? $defaults['hero_title_2'] ) ),
			'hero_desc'              => sanitize_textarea_field( wp_unslash( $_POST['hero_desc'] ?? $defaults['hero_desc'] ) ),
			'hero_hours'             => intval( $_POST['hero_hours'] ?? 2 ),
			'hero_minutes'           => intval( $_POST['hero_minutes'] ?? 45 ),
			'hero_seconds'           => intval( $_POST['hero_seconds'] ?? 0 ),
			'badge_1_text'           => sanitize_text_field( wp_unslash( $_POST['badge_1_text'] ?? $defaults['badge_1_text'] ) ),
			'badge_2_text'           => sanitize_text_field( wp_unslash( $_POST['badge_2_text'] ?? $defaults['badge_2_text'] ) ),
			'badge_3_text'           => sanitize_text_field( wp_unslash( $_POST['badge_3_text'] ?? $defaults['badge_3_text'] ) ),

			// Vouchers
			'voucher_1_badge'        => sanitize_text_field( wp_unslash( $_POST['voucher_1_badge'] ?? $defaults['voucher_1_badge'] ) ),
			'voucher_1_title'        => sanitize_text_field( wp_unslash( $_POST['voucher_1_title'] ?? $defaults['voucher_1_title'] ) ),
			'voucher_1_desc'         => sanitize_text_field( wp_unslash( $_POST['voucher_1_desc'] ?? $defaults['voucher_1_desc'] ) ),
			'voucher_1_code'         => sanitize_text_field( wp_unslash( $_POST['voucher_1_code'] ?? $defaults['voucher_1_code'] ) ),

			'voucher_2_badge'        => sanitize_text_field( wp_unslash( $_POST['voucher_2_badge'] ?? $defaults['voucher_2_badge'] ) ),
			'voucher_2_title'        => sanitize_text_field( wp_unslash( $_POST['voucher_2_title'] ?? $defaults['voucher_2_title'] ) ),
			'voucher_2_desc'         => sanitize_text_field( wp_unslash( $_POST['voucher_2_desc'] ?? $defaults['voucher_2_desc'] ) ),
			'voucher_2_code'         => sanitize_text_field( wp_unslash( $_POST['voucher_2_code'] ?? $defaults['voucher_2_code'] ) ),

			// Section Headers
			'sec_phone_title'        => sanitize_text_field( wp_unslash( $_POST['sec_phone_title'] ?? $defaults['sec_phone_title'] ) ),
			'sec_phone_subtitle'     => sanitize_text_field( wp_unslash( $_POST['sec_phone_subtitle'] ?? $defaults['sec_phone_subtitle'] ) ),

			'sec_apple_title'        => sanitize_text_field( wp_unslash( $_POST['sec_apple_title'] ?? $defaults['sec_apple_title'] ) ),
			'sec_apple_subtitle'     => sanitize_text_field( wp_unslash( $_POST['sec_apple_subtitle'] ?? $defaults['sec_apple_subtitle'] ) ),
			'sec_apple_badge'        => sanitize_text_field( wp_unslash( $_POST['sec_apple_badge'] ?? $defaults['sec_apple_badge'] ) ),

			'sec_tablet_title'       => sanitize_text_field( wp_unslash( $_POST['sec_tablet_title'] ?? $defaults['sec_tablet_title'] ) ),
			'sec_tablet_subtitle'    => sanitize_text_field( wp_unslash( $_POST['sec_tablet_subtitle'] ?? $defaults['sec_tablet_subtitle'] ) ),

			'sec_accessory_title'    => sanitize_text_field( wp_unslash( $_POST['sec_accessory_title'] ?? $defaults['sec_accessory_title'] ) ),
			'sec_accessory_subtitle' => sanitize_text_field( wp_unslash( $_POST['sec_accessory_subtitle'] ?? $defaults['sec_accessory_subtitle'] ) ),

			'sec_watch_title'        => sanitize_text_field( wp_unslash( $_POST['sec_watch_title'] ?? $defaults['sec_watch_title'] ) ),
			'sec_watch_subtitle'     => sanitize_text_field( wp_unslash( $_POST['sec_watch_subtitle'] ?? $defaults['sec_watch_subtitle'] ) ),

			'sec_tradein_title'      => sanitize_text_field( wp_unslash( $_POST['sec_tradein_title'] ?? $defaults['sec_tradein_title'] ) ),
			'sec_tradein_subtitle'   => sanitize_textarea_field( wp_unslash( $_POST['sec_tradein_subtitle'] ?? $defaults['sec_tradein_subtitle'] ) ),
		);

		update_option( 'phonex_promotions_settings', $current );
		$message = __( '✅ Đã lưu cài đặt chuyên trang Khuyến Mãi thành công! Dữ liệu đã cập nhật ngay ra Frontend.', 'phonex' );
	}

	$settings = phonex_get_promotions_settings();
	?>
	<div class="wrap" style="max-width: 1200px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;">
		
		<!-- Header -->
		<div style="background: linear-gradient(135deg, #7a0008 0%, #ba0d1a 100%); color: white; padding: 24px 28px; border-radius: 16px; margin: 20px 0 24px 0; box-shadow: 0 4px 16px rgba(186,13,26,0.25); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
			<div>
				<div style="display: inline-block; background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
					Quản Trị Riêng Biệt • Chuyên Trang Khuyến Mãi
				</div>
				<h1 style="color: white; margin: 0; font-size: 26px; font-weight: 900; line-height: 1.2;">
					🎁 Cài Đặt Chuyên Trang Khuyến Mãi (Mega Promotion)
				</h1>
				<p style="color: #ffd6d9; margin: 8px 0 0 0; font-size: 14px;">
					Quản lý Banner chiến dịch lớn, 2 Mã giảm giá độc quyền và Tiêu đề các phân đoạn trên trang <code>/khuyen-mai/</code>.
				</p>
			</div>

			<div style="display: flex; gap: 10px; align-items: center;">
				<a href="<?php echo esc_url( home_url( '/khuyen-mai/' ) ); ?>" target="_blank" class="button" style="background: white; color: #ba0d1a; font-weight: 700; border: none; padding: 6px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
					<span class="dashicons dashicons-external" style="font-size: 16px; line-height: 20px;"></span>
					Xem Trang Frontend
				</a>
			</div>
		</div>

		<?php if ( ! empty( $message ) ) : ?>
			<div style="background: #e6f7ec; border-left: 4px solid #28a745; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; color: #155724; font-weight: 600; font-size: 14px; box-shadow: 0 2px 8px rgba(40,167,69,0.1);">
				<?php echo esc_html( $message ); ?>
			</div>
		<?php endif; ?>

		<form method="post" action="">
			<?php wp_nonce_field( 'phonex_promotions_save_action', 'phonex_promotions_save_nonce' ); ?>

			<!-- SECTION 1: HERO CAMPAIGN BANNER -->
			<div style="background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
				<div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f3f4f6; padding-bottom: 14px; margin-bottom: 20px;">
					<span class="dashicons dashicons-megaphone" style="font-size: 24px; color: #ba0d1a;"></span>
					<div>
						<h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #111827;">1. Banner Chiến Dịch Lớn (Hero Campaign)</h2>
						<p style="margin: 3px 0 0 0; color: #6b7280; font-size: 13px;">Hiển thị trên cùng của trang Khuyến Mãi với nền gradient đỏ sang trọng.</p>
					</div>
				</div>

				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
					<div style="grid-column: span 2;">
						<label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 6px; color: #374151;">Huy Hiệu Nhỏ (Badge Trên Cùng):</label>
						<input type="text" name="hero_badge" value="<?php echo esc_attr( $settings['hero_badge'] ); ?>" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px;" />
					</div>

					<div>
						<label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 6px; color: #374151;">Tiêu Đề Dòng 1 (Chữ Trắng):</label>
						<input type="text" name="hero_title_1" value="<?php echo esc_attr( $settings['hero_title_1'] ); ?>" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; font-weight: bold;" />
					</div>

					<div>
						<label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 6px; color: #374151;">Tiêu Đề Dòng 2 (Chữ Vàng Ánh Kim Nổi Bật):</label>
						<input type="text" name="hero_title_2" value="<?php echo esc_attr( $settings['hero_title_2'] ); ?>" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; font-weight: bold; color: #d97706;" />
					</div>

					<div style="grid-column: span 2;">
						<label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 6px; color: #374151;">Đoạn Mô Tả Chiến Dịch:</label>
						<textarea name="hero_desc" rows="3" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 13px; line-height: 1.5;"><?php echo esc_textarea( $settings['hero_desc'] ); ?></textarea>
					</div>
				</div>

				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; background: #fff5f5; padding: 16px; border-radius: 10px; border: 1px dashed #fca5a5;">
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #991b1b;">Đồng Hồ Đếm Ngược (Giờ):</label>
						<input type="number" name="hero_hours" value="<?php echo intval( $settings['hero_hours'] ); ?>" min="0" max="99" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #f87171;" />
					</div>
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #991b1b;">Đồng Hồ Đếm Ngược (Phút):</label>
						<input type="number" name="hero_minutes" value="<?php echo intval( $settings['hero_minutes'] ); ?>" min="0" max="59" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #f87171;" />
					</div>
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #991b1b;">Đồng Hồ Đếm Ngược (Giây):</label>
						<input type="number" name="hero_seconds" value="<?php echo intval( $settings['hero_seconds'] ); ?>" min="0" max="59" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #f87171;" />
					</div>
				</div>

				<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-top: 16px;">
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Huy hiệu 1:</label>
						<input type="text" name="badge_1_text" value="<?php echo esc_attr( $settings['badge_1_text'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
					</div>
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Huy hiệu 2:</label>
						<input type="text" name="badge_2_text" value="<?php echo esc_attr( $settings['badge_2_text'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
					</div>
					<div>
						<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Huy hiệu 3:</label>
						<input type="text" name="badge_3_text" value="<?php echo esc_attr( $settings['badge_3_text'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
					</div>
				</div>
			</div>

			<!-- SECTION 2: EXCLUSIVE VOUCHERS -->
			<div style="background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
				<div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f3f4f6; padding-bottom: 14px; margin-bottom: 20px;">
					<span class="dashicons dashicons-tickets" style="font-size: 24px; color: #ba0d1a;"></span>
					<div>
						<h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #111827;">2. Hai Thẻ Voucher Độc Quyền (Khách Bấm Nhận Trực Tiếp)</h2>
						<p style="margin: 3px 0 0 0; color: #6b7280; font-size: 13px;">Nằm ngay cạnh đồng hồ đếm ngược. Khách bấm nút "Lưu mã" sẽ hiện popup toast thông báo nhận thành công.</p>
					</div>
				</div>

				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
					<!-- Voucher 1 -->
					<div style="background: #fafafa; border: 1px solid #e5e7eb; padding: 18px; border-radius: 12px; border-left: 4px solid #ba0d1a;">
						<div style="font-weight: 800; color: #ba0d1a; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
							<span class="dashicons dashicons-tag"></span> VOUCHER 1 (ĐIỆN THOẠI)
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Số Giảm (Tag đỏ bên trái):</label>
							<input type="text" name="voucher_1_badge" value="<?php echo esc_attr( $settings['voucher_1_badge'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold; color: #ba0d1a;" />
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Tên Voucher:</label>
							<input type="text" name="voucher_1_title" value="<?php echo esc_attr( $settings['voucher_1_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: 600;" />
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Điều Kiện & Hạn Dùng:</label>
							<input type="text" name="voucher_1_desc" value="<?php echo esc_attr( $settings['voucher_1_desc'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
						</div>
						<div>
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Mã Code:</label>
							<input type="text" name="voucher_1_code" value="<?php echo esc_attr( $settings['voucher_1_code'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace;" />
						</div>
					</div>

					<!-- Voucher 2 -->
					<div style="background: #fafafa; border: 1px solid #e5e7eb; padding: 18px; border-radius: 12px; border-left: 4px solid #d97706;">
						<div style="font-weight: 800; color: #d97706; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
							<span class="dashicons dashicons-tag"></span> VOUCHER 2 (PHỤ KIỆN)
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Số Giảm (Tag đỏ bên trái):</label>
							<input type="text" name="voucher_2_badge" value="<?php echo esc_attr( $settings['voucher_2_badge'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold; color: #d97706;" />
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Tên Voucher:</label>
							<input type="text" name="voucher_2_title" value="<?php echo esc_attr( $settings['voucher_2_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: 600;" />
						</div>
						<div style="margin-bottom: 10px;">
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Điều Kiện & Hạn Dùng:</label>
							<input type="text" name="voucher_2_desc" value="<?php echo esc_attr( $settings['voucher_2_desc'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
						</div>
						<div>
							<label style="display: block; font-weight: 700; font-size: 12px; margin-bottom: 4px; color: #4b5563;">Mã Code:</label>
							<input type="text" name="voucher_2_code" value="<?php echo esc_attr( $settings['voucher_2_code'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace;" />
						</div>
					</div>
				</div>
			</div>

			<!-- SECTION 3: CATEGORY SECTION HEADERS & SUBTITLES -->
			<div style="background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
				<div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f3f4f6; padding-bottom: 14px; margin-bottom: 20px;">
					<span class="dashicons dashicons-category" style="font-size: 24px; color: #ba0d1a;"></span>
					<div>
						<h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #111827;">3. Tiêu Đề & Lời Kêu Gọi Của Từng Phân Đoạn Danh Mục</h2>
						<p style="margin: 3px 0 0 0; color: #6b7280; font-size: 13px;">Dễ dàng thay đổi khẩu hiệu và chương trình quà tặng cho từng ngành hàng.</p>
					</div>
				</div>

				<div style="display: flex; flex-direction: column; gap: 16px;">
					
					<!-- 3.1: Phone -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #ba0d1a; font-size: 13px; margin-bottom: 8px;">📱 Phân đoạn 1: Điện Thoại Giá Rẻ Quá</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_phone_title" value="<?php echo esc_attr( $settings['sec_phone_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_phone_subtitle" value="<?php echo esc_attr( $settings['sec_phone_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
					</div>

					<!-- 3.2: Apple -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #111827; font-size: 13px; margin-bottom: 8px;">🍎 Phân đoạn 2: Hệ Sinh Thái Apple VN/A</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_apple_title" value="<?php echo esc_attr( $settings['sec_apple_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_apple_subtitle" value="<?php echo esc_attr( $settings['sec_apple_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tag bên phải:</label>
								<input type="text" name="sec_apple_badge" value="<?php echo esc_attr( $settings['sec_apple_badge'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
					</div>

					<!-- 3.3: Tablet & Laptop -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #1d4ed8; font-size: 13px; margin-bottom: 8px;">💻 Phân đoạn 3: Tablet & Laptop Học Tập</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_tablet_title" value="<?php echo esc_attr( $settings['sec_tablet_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_tablet_subtitle" value="<?php echo esc_attr( $settings['sec_tablet_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
					</div>

					<!-- 3.4: Accessories -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #d97706; font-size: 13px; margin-bottom: 8px;">🎧 Phân đoạn 4: Phụ Kiện Chính Hãng</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_accessory_title" value="<?php echo esc_attr( $settings['sec_accessory_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_accessory_subtitle" value="<?php echo esc_attr( $settings['sec_accessory_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
					</div>

					<!-- 3.5: Smartwatch -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #047857; font-size: 13px; margin-bottom: 8px;">⌚ Phân đoạn 5: Đồng Hồ Thông Minh & Sức Khỏe</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_watch_title" value="<?php echo esc_attr( $settings['sec_watch_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_watch_subtitle" value="<?php echo esc_attr( $settings['sec_watch_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
					</div>

					<!-- 3.6: Trade-in -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #ba0d1a; font-size: 13px; margin-bottom: 8px;">🔄 Phân đoạn 6: Thu Cũ Đổi Mới Lên Đời</div>
						<div style="margin-bottom: 8px;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
							<input type="text" name="sec_tradein_title" value="<?php echo esc_attr( $settings['sec_tradein_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
						</div>
						<div>
							<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả chính sách:</label>
							<textarea name="sec_tradein_subtitle" rows="2" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;"><?php echo esc_textarea( $settings['sec_tradein_subtitle'] ); ?></textarea>
						</div>
					</div>

				</div>
			</div>

			<!-- SUBMIT BUTTON -->
			<div style="position: sticky; bottom: 20px; z-index: 50; background: white; padding: 18px 24px; border-radius: 14px; border: 2px solid #ba0d1a; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; justify-content: space-between; align-items: center; gap: 16px;">
				<div style="color: #4b5563; font-size: 13px; font-weight: 600;">
					💡 Sau khi bấm lưu, toàn bộ Banner, Voucher và Tiêu đề chuyên trang Khuyến Mãi ngoài Frontend sẽ tự động cập nhật ngay lập tức!
				</div>
				<button type="submit" class="button button-primary button-large" style="background: #ba0d1a; border-color: #ba0d1a; font-size: 15px; font-weight: 800; padding: 6px 28px; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(186,13,26,0.3); cursor: pointer;">
					💾 LƯU CÀI ĐẶT TRANG KHUYẾN MÃI
				</button>
			</div>

		</form>
	</div>
	<?php
}
