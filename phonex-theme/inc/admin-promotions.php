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

		// 4. PINNED PRODUCT IDS (HYBRID AUTO + PIN)
		'sec_phone_pinned'       => '16, 17, 18, 19, 20, 21',
		'sec_apple_pinned'       => '16, 27, 23, 26, 22',
		'sec_tablet_pinned'      => '27',
		'sec_accessory_pinned'   => '24, 25, 22, 23',
		'sec_watch_pinned'       => '26',
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

			// Pinned Product IDs
			'sec_phone_pinned'       => sanitize_text_field( wp_unslash( $_POST['sec_phone_pinned'] ?? '' ) ),
			'sec_apple_pinned'       => sanitize_text_field( wp_unslash( $_POST['sec_apple_pinned'] ?? '' ) ),
			'sec_tablet_pinned'      => sanitize_text_field( wp_unslash( $_POST['sec_tablet_pinned'] ?? '' ) ),
			'sec_accessory_pinned'   => sanitize_text_field( wp_unslash( $_POST['sec_accessory_pinned'] ?? '' ) ),
			'sec_watch_pinned'       => sanitize_text_field( wp_unslash( $_POST['sec_watch_pinned'] ?? '' ) ),
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
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_phone_title" value="<?php echo esc_attr( $settings['sec_phone_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_phone_subtitle" value="<?php echo esc_attr( $settings['sec_phone_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
						<div style="padding-top: 8px; border-top: 1px dashed #e5e7eb;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #ba0d1a; margin-bottom: 2px;">📌 Ghim ID sản phẩm hiển thị ưu tiên (cách nhau dấu phẩy):</label>
							<input type="text" name="sec_phone_pinned" value="<?php echo esc_attr( $settings['sec_phone_pinned'] ); ?>" placeholder="VD: 16, 17, 18, 19, 20, 21" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace; font-weight: 600;" />
							<p style="margin: 3px 0 0 0; font-size: 11px; color: #6b7280;">Hệ thống sẽ hiển thị các ID này trước, sau đó tự động bù đắp các vị trí còn lại bằng điện thoại đang có <strong>Giá khuyến mãi</strong> trong kho WooCommerce.</p>
						</div>
					</div>

					<!-- 3.2: Apple -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #111827; font-size: 13px; margin-bottom: 8px;">🍎 Phân đoạn 2: Hệ Sinh Thái Apple VN/A</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 10px;">
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
						<div style="padding-top: 8px; border-top: 1px dashed #e5e7eb;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #111827; margin-bottom: 2px;">📌 Ghim ID sản phẩm Apple ưu tiên (cách nhau dấu phẩy):</label>
							<input type="text" name="sec_apple_pinned" value="<?php echo esc_attr( $settings['sec_apple_pinned'] ); ?>" placeholder="VD: 16, 27, 23, 26, 22" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace; font-weight: 600;" />
							<p style="margin: 3px 0 0 0; font-size: 11px; color: #6b7280;">Hiển thị thiết bị Apple (iPhone, iPad, Watch, AirPods, Sạc Apple...) theo ID bạn chọn.</p>
						</div>
					</div>

					<!-- 3.3: Tablet & Laptop -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #1d4ed8; font-size: 13px; margin-bottom: 8px;">💻 Phân đoạn 3: Tablet & Laptop Học Tập</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_tablet_title" value="<?php echo esc_attr( $settings['sec_tablet_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_tablet_subtitle" value="<?php echo esc_attr( $settings['sec_tablet_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
						<div style="padding-top: 8px; border-top: 1px dashed #e5e7eb;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #1d4ed8; margin-bottom: 2px;">📌 Ghim ID sản phẩm Tablet & Laptop (cách nhau dấu phẩy):</label>
							<input type="text" name="sec_tablet_pinned" value="<?php echo esc_attr( $settings['sec_tablet_pinned'] ); ?>" placeholder="VD: 27" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace; font-weight: 600;" />
						</div>
					</div>

					<!-- 3.4: Accessories -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #d97706; font-size: 13px; margin-bottom: 8px;">🎧 Phân đoạn 4: Phụ Kiện Chính Hãng</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_accessory_title" value="<?php echo esc_attr( $settings['sec_accessory_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_accessory_subtitle" value="<?php echo esc_attr( $settings['sec_accessory_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
						<div style="padding-top: 8px; border-top: 1px dashed #e5e7eb;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #d97706; margin-bottom: 2px;">📌 Ghim ID sản phẩm Phụ Kiện (cách nhau dấu phẩy):</label>
							<input type="text" name="sec_accessory_pinned" value="<?php echo esc_attr( $settings['sec_accessory_pinned'] ); ?>" placeholder="VD: 24, 25, 22, 23" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace; font-weight: 600;" />
						</div>
					</div>

					<!-- 3.5: Smartwatch -->
					<div style="padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; background: #fafafa;">
						<div style="font-weight: 700; color: #047857; font-size: 13px; margin-bottom: 8px;">⌚ Phân đoạn 5: Đồng Hồ Thông Minh & Sức Khỏe</div>
						<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px;">
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Tiêu đề chính:</label>
								<input type="text" name="sec_watch_title" value="<?php echo esc_attr( $settings['sec_watch_title'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-weight: bold;" />
							</div>
							<div>
								<label style="display: block; font-size: 11px; font-weight: bold; color: #6b7280; margin-bottom: 2px;">Mô tả phụ:</label>
								<input type="text" name="sec_watch_subtitle" value="<?php echo esc_attr( $settings['sec_watch_subtitle'] ); ?>" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db;" />
							</div>
						</div>
						<div style="padding-top: 8px; border-top: 1px dashed #e5e7eb;">
							<label style="display: block; font-size: 11px; font-weight: bold; color: #047857; margin-bottom: 2px;">📌 Ghim ID sản phẩm Smartwatch (cách nhau dấu phẩy):</label>
							<input type="text" name="sec_watch_pinned" value="<?php echo esc_attr( $settings['sec_watch_pinned'] ); ?>" placeholder="VD: 26" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #d1d5db; font-family: monospace; font-weight: 600;" />
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

			<!-- SECTION 4: PRODUCT LOOKUP TABLE -->
			<div style="background: white; border-radius: 14px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
				<div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f3f4f6; padding-bottom: 14px; margin-bottom: 16px;">
					<div style="display: flex; align-items: center; gap: 10px;">
						<span class="dashicons dashicons-products" style="font-size: 24px; color: #ba0d1a;"></span>
						<div>
							<h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #111827;">4. Tra Cứu Nhanh ID Sản Phẩm WooCommerce Trong Kho</h2>
							<p style="margin: 3px 0 0 0; color: #6b7280; font-size: 13px;">Bấm nút <strong>Copy ID</strong> để dán nhanh vào các ô Ghim ID ở trên mà không cần mở tab khác.</p>
						</div>
					</div>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>" target="_blank" class="button button-secondary" style="font-weight: 700;">+ Thêm Sản Phẩm Mới</a>
				</div>

				<div style="max-height: 380px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
					<table class="wp-list-table widefat fixed striped" style="border: none;">
						<thead>
							<tr>
								<th style="width: 70px; font-weight: 800;">ID</th>
								<th style="font-weight: 800;">Tên Sản Phẩm</th>
								<th style="width: 130px; font-weight: 800;">Giá Niêm Yết</th>
								<th style="width: 130px; font-weight: 800; color: #ba0d1a;">Giá Khuyến Mãi</th>
								<th style="width: 150px; font-weight: 800;">Danh Mục</th>
								<th style="width: 80px; text-align: center; font-weight: 800;">Thao Tác</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$wc_items = function_exists( 'wc_get_products' ) ? wc_get_products( array( 'limit' => 50, 'status' => 'publish', 'orderby' => 'ID', 'order' => 'ASC' ) ) : array();
							if ( empty( $wc_items ) ) : ?>
								<tr><td colspan="6" style="text-align: center; color: #6b7280; padding: 20px;">Chưa có sản phẩm nào trong WooCommerce.</td></tr>
							<?php else :
								foreach ( $wc_items as $p_item ) :
									$pid   = $p_item->get_id();
									$pname = $p_item->get_name();
									$reg   = $p_item->get_regular_price();
									$sale  = $p_item->get_sale_price();
									$cats  = wc_get_product_category_list( $pid );
							?>
								<tr>
									<td style="font-weight: 900; font-family: monospace; color: #ba0d1a;">#<?php echo esc_html( $pid ); ?></td>
									<td>
										<strong><?php echo esc_html( $pname ); ?></strong>
										<div class="row-actions"><a href="<?php echo esc_url( get_edit_post_link( $pid ) ); ?>" target="_blank">Sửa giá</a> | <a href="<?php echo esc_url( get_permalink( $pid ) ); ?>" target="_blank">Xem ngoài web</a></div>
									</td>
									<td><?php echo $reg ? number_format( floatval( $reg ), 0, ',', '.' ) . '₫' : '-'; ?></td>
									<td style="color: #ba0d1a; font-weight: bold;"><?php echo $sale ? number_format( floatval( $sale ), 0, ',', '.' ) . '₫' : '<span style="color:#9ca3af; font-weight:normal;">Chưa giảm</span>'; ?></td>
									<td style="font-size: 12px; color: #6b7280;"><?php echo wp_strip_all_tags( $cats ); ?></td>
									<td style="text-align: center;">
										<button type="button" class="button button-small" onclick="navigator.clipboard.writeText('<?php echo esc_js( $pid ); ?>'); alert('Đã sao chép ID <?php echo esc_js( $pid ); ?>!');" style="font-size: 11px;">Copy ID</button>
									</td>
								</tr>
							<?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- SUBMIT BUTTON -->
			<div style="position: sticky; bottom: 20px; z-index: 50; background: white; padding: 18px 24px; border-radius: 14px; border: 2px solid #ba0d1a; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; justify-content: space-between; align-items: center; gap: 16px;">
				<div style="color: #4b5563; font-size: 13px; font-weight: 600;">
					💡 Sau khi bấm lưu, toàn bộ Banner, Voucher, Sản phẩm ghim và Tiêu đề chuyên trang Khuyến Mãi ngoài Frontend sẽ tự động cập nhật ngay lập tức!
				</div>
				<button type="submit" class="button button-primary button-large" style="background: #ba0d1a; border-color: #ba0d1a; font-size: 15px; font-weight: 800; padding: 6px 28px; height: auto; border-radius: 8px; box-shadow: 0 4px 12px rgba(186,13,26,0.3); cursor: pointer;">
					💾 LƯU CÀI ĐẶT TRANG KHUYẾN MÃI
				</button>
			</div>

		</form>
	</div>
	<?php
}

/**
 * =========================================================================
 * HYBRID PRODUCT QUERY HELPER FOR MEGA PROMOTIONS PAGE
 * =========================================================================
 */

/**
 * Get products for a promotion section with hybrid smart fallback.
 *
 * 1. Takes pinned product IDs first (if set in admin).
 * 2. Fetches on-sale WooCommerce products in matching categories.
 * 3. Fallbacks to newest WooCommerce products in category if not enough on-sale.
 * 4. Fallbacks to curated mockup items if WooCommerce doesn't have enough products yet.
 *
 * @param array $args
 * @return array
 */
function phonex_get_promotion_products( $args = array() ) {
	$defaults = array(
		'pinned_ids'     => '',
		'category_slugs' => array(),
		'limit'          => 6,
		'fallbacks'      => array(),
	);
	$args = wp_parse_args( $args, $defaults );

	$products = array();
	$used_ids = array();

	// 1. Process Pinned IDs
	if ( ! empty( $args['pinned_ids'] ) ) {
		$ids = is_array( $args['pinned_ids'] ) ? $args['pinned_ids'] : explode( ',', $args['pinned_ids'] );
		foreach ( $ids as $raw_id ) {
			$id = intval( trim( $raw_id ) );
			if ( $id <= 0 || in_array( $id, $used_ids, true ) ) {
				continue;
			}
			if ( function_exists( 'wc_get_product' ) ) {
				$wc_prod = wc_get_product( $id );
				if ( $wc_prod && 'publish' === $wc_prod->get_status() ) {
					$item = phonex_format_wc_promotion_item( $wc_prod );
					if ( $item ) {
						$products[] = $item;
						$used_ids[] = $id;
					}
				}
			}
		}
	}

	// 2. Query WooCommerce on-sale products if count < limit
	if ( count( $products ) < $args['limit'] && function_exists( 'wc_get_products' ) ) {
		$needed     = $args['limit'] - count( $products );
		$query_args = array(
			'status'  => 'publish',
			'limit'   => $needed,
			'exclude' => $used_ids,
			'orderby' => 'date',
			'order'   => 'DESC',
		);

		if ( ! empty( $args['category_slugs'] ) ) {
			$query_args['category'] = (array) $args['category_slugs'];
		}

		// First try on-sale products
		$query_args['on_sale'] = true;
		$wc_prods = wc_get_products( $query_args );

		// If not enough on-sale, query general products in category
		if ( count( $wc_prods ) < $needed ) {
			unset( $query_args['on_sale'] );
			$more_prods = wc_get_products( $query_args );
			$wc_prods   = array_merge( $wc_prods, $more_prods );
		}

		foreach ( $wc_prods as $wc_prod ) {
			$pid = $wc_prod->get_id();
			if ( in_array( $pid, $used_ids, true ) ) {
				continue;
			}
			$item = phonex_format_wc_promotion_item( $wc_prod );
			if ( $item ) {
				$products[] = $item;
				$used_ids[] = $pid;
			}
			if ( count( $products ) >= $args['limit'] ) {
				break;
			}
		}
	}

	// 3. Backfill with fallback mockups if still < limit (ensures no empty grid slots)
	if ( count( $products ) < $args['limit'] && ! empty( $args['fallbacks'] ) ) {
		foreach ( $args['fallbacks'] as $fb ) {
			$products[] = $fb;
			if ( count( $products ) >= $args['limit'] ) {
				break;
			}
		}
	}

	return $products;
}

/**
 * Format a WooCommerce Product into clean array for promotion cards
 *
 * @param WC_Product $wc_prod
 * @return array|null
 */
function phonex_format_wc_promotion_item( $wc_prod ) {
	if ( ! $wc_prod ) {
		return null;
	}

	$id   = $wc_prod->get_id();
	$name = $wc_prod->get_name();
	$link = get_permalink( $id );

	// Image
	$image_id  = $wc_prod->get_image_id();
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';

	// Prices
	$reg  = floatval( $wc_prod->get_regular_price() );
	$sale = floatval( $wc_prod->get_sale_price() );
	if ( $sale <= 0 ) {
		$sale = floatval( $wc_prod->get_price() );
	}
	if ( $reg <= 0 ) {
		$reg = $sale;
	}

	// Discount percentage
	$badge = '-15%';
	if ( $reg > 0 && $sale > 0 && $sale < $reg ) {
		$discount = round( ( ( $reg - $sale ) / $reg ) * 100 );
		$badge    = '-' . $discount . '%';
	}

	// Detect Brand for filtering
	$brand      = 'all';
	$name_lower = mb_strtolower( $name, 'UTF-8' );
	if ( strpos( $name_lower, 'iphone' ) !== false || strpos( $name_lower, 'apple' ) !== false ) {
		$brand = 'iphone';
	} elseif ( strpos( $name_lower, 'samsung' ) !== false || strpos( $name_lower, 'galaxy' ) !== false ) {
		$brand = 'samsung';
	} elseif ( strpos( $name_lower, 'xiaomi' ) !== false || strpos( $name_lower, 'redmi' ) !== false ) {
		$brand = 'xiaomi';
	} elseif ( strpos( $name_lower, 'oppo' ) !== false ) {
		$brand = 'oppo';
	} elseif ( strpos( $name_lower, 'vivo' ) !== false ) {
		$brand = 'vivo';
	}

	// Specs / Description
	$specs = $wc_prod->get_short_description();
	if ( empty( $specs ) ) {
		$specs = 'Chính hãng VN/A';
	} else {
		$specs = wp_strip_all_tags( $specs );
		if ( mb_strlen( $specs ) > 28 ) {
			$specs = mb_substr( $specs, 0, 25 ) . '...';
		}
	}

	// Image fallback if no media attachment
	if ( empty( $image_url ) ) {
		$image_url = phonex_get_default_product_image_by_title( $name );
	}

	return array(
		'id'         => $id,
		'name'       => $name,
		'link'       => $link,
		'image'      => $image_url,
		'price_sale' => number_format( $sale, 0, ',', '.' ) . '₫',
		'price_orig' => number_format( $reg, 0, ',', '.' ) . '₫',
		'badge'      => $badge,
		'sub_badge'  => 'Trả góp 0%',
		'specs'      => $specs,
		'rating'     => $wc_prod->get_average_rating() ? number_format( floatval( $wc_prod->get_average_rating() ), 1 ) : '4.9',
		'reviews'    => ( $wc_prod->get_review_count() ?: 180 ) . ' đánh giá',
		'brand'      => $brand,
	);
}

/**
 * Intelligent Image Fallback based on Product Title
 *
 * @param string $title
 * @return string
 */
function phonex_get_default_product_image_by_title( $title ) {
	$t = mb_strtolower( $title, 'UTF-8' );

	if ( strpos( $t, 'iphone 16 pro max' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H';
	}
	if ( strpos( $t, 's25' ) !== false || strpos( $t, 'galaxy' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn';
	}
	if ( strpos( $t, 'xiaomi' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp';
	}
	if ( strpos( $t, 'iphone 15' ) !== false || strpos( $t, 'used' ) !== false || strpos( $t, 'cũ' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPT8j9gPDdQw803_EjHE9CrxcBd9ByYWch8rA3iK2EBwUlD-AYBurDY51Zuw1-Qsp9Vt7q1Pd3TVFYZSrTi9fCyrBWkDC5RcYBn8JZgRzAewL2GfxpWRIqXsBv_xwE0rndJ5hkpIutccJGL_JBkwS1NztjDieoZb_RoQt57EclFFLXTYI0bltlq5jZN_GOmx2UWCj1fqYtciRolzYGtW8p2r7rv-v-M7usKZhT8cNXKavd4vLaz8TF';
	}
	if ( strpos( $t, 'oppo' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuBu_9AXg1F-hNXVDThacap6KkD1w0RouLY7G5_x1hInqKGQ7k1LBUyXtFtqS2Wzb4XNJDUvoETcEZ1bV0hQpFwFump0hX5v0sX9yBwzUfavEMyguH2xelmCSR1blBQv942EFdLpC79AzVGFQG2i7FV_QPGw_tw7TDgobOrNWqS53JP8tRMgtEifRLNz_CflR9NIygo4ggcNHqNOsmT9_dMdSBAcRvAnODB7V0SL9u7hIBjKYH5n1iBT';
	}
	if ( strpos( $t, 'vivo' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRBzg3aq6sxZduVxZ6TuiFGHjC7CrATsVyVLV2sk8mjnmSygK6XWcgic3TYrHutR2Eb38VNmKw9T59VYW7vAQCmTRGiT7tJtgKRsjs9WJT-xaH2S_FOwMzaGGzNQczvNgdo-wbIn-IwLheyG9Rb3CzoVz915kikp3H8Nx-tSF-ET7RmXgv3H67L7bAdw0Q9eGwRY9XfLmP-TlJWChtjO9riOWRRuyKRBMEUZzYQ1sgrG-QZOpp-4Ey';
	}
	if ( strpos( $t, 'airpods' ) !== false || strpos( $t, 'tai nghe' ) !== false ) {
		return 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5';
	}
	if ( strpos( $t, 'watch' ) !== false || strpos( $t, 'đồng hồ' ) !== false ) {
		return get_template_directory_uri() . '/assets/images/categories/accessories/kinh-thong-minh.png';
	}
	if ( strpos( $t, 'ipad' ) !== false || strpos( $t, 'tablet' ) !== false ) {
		return get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-may-tinh-bang.png';
	}
	if ( strpos( $t, 'pin' ) !== false || strpos( $t, 'dự phòng' ) !== false ) {
		return get_template_directory_uri() . '/assets/images/categories/accessories/sac-du-phong.png';
	}
	if ( strpos( $t, 'sạc' ) !== false || strpos( $t, 'cáp' ) !== false ) {
		return get_template_directory_uri() . '/assets/images/categories/accessories/sac-cap.png';
	}
	if ( strpos( $t, 'kính' ) !== false || strpos( $t, 'dán' ) !== false ) {
		return get_template_directory_uri() . '/assets/images/categories/accessories/mieng-dan.png';
	}

	return get_template_directory_uri() . '/assets/images/categories/accessories/hub-cap-chuyen-doi.png';
}

