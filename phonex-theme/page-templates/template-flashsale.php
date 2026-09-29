<?php
/**
 * Template Name: PhoneX Flash Sale & Khuyến Mãi (TGDD Mega Sale Style)
 *
 * @package PhoneX
 */

get_header();

// Fetch live Flash Sale settings from Admin Panel ("⚡ Flash Sale Giờ Vàng")
$flashsale_settings = get_option( 'phonex_flashsale_settings', array() );
$fs_enabled         = ( ( $flashsale_settings['enabled'] ?? '1' ) === '1' );
$fs_title           = $flashsale_settings['title'] ?? 'FLASH SALE GIỜ VÀNG';
$fs_subtitle        = $flashsale_settings['subtitle'] ?? 'Khung giờ vàng giảm sốc - Số lượng có hạn';
$cd_hours           = intval( $flashsale_settings['countdown_hours'] ?? 2 );
$cd_minutes         = intval( $flashsale_settings['countdown_minutes'] ?? 45 );
$cd_seconds         = intval( $flashsale_settings['countdown_seconds'] ?? 18 );

// Fetch live Mega Promotions settings from Admin Panel ("🎁 Trang Khuyến Mãi")
$promo_settings = function_exists( 'phonex_get_promotions_settings' ) ? phonex_get_promotions_settings() : array();
$hero_badge     = $promo_settings['hero_badge'] ?? 'ĐẠI HỘI FLASH SALE 2026 • ĐỘC QUYỀN TẠI PHONEX';
$hero_title_1   = $promo_settings['hero_title_1'] ?? 'TỰU TRƯỜNG DEAL THƠMMM';
$hero_title_2   = $promo_settings['hero_title_2'] ?? 'GIẢM SỐC ĐẾN 50%';
$hero_desc      = $promo_settings['hero_desc'] ?? 'Hàng nghìn siêu phẩm Smartphone Flagship, Tablet, Laptop, Phụ kiện & Smartwatch chính hãng VN/A đồng loạt hạ giá khung giờ vàng. Trợ giá thu cũ đổi mới lên đến 3.000.000đ, trả góp 0% lãi suất.';
$hero_hours     = intval( $promo_settings['hero_hours'] ?? $cd_hours );
$hero_minutes   = intval( $promo_settings['hero_minutes'] ?? $cd_minutes );
$hero_seconds   = intval( $promo_settings['hero_seconds'] ?? $cd_seconds );
$badge_1_text   = $promo_settings['badge_1_text'] ?? '100% Chính Hãng VN/A';
$badge_2_text   = $promo_settings['badge_2_text'] ?? '1 Đổi 1 Trong 30 Ngày';
$badge_3_text   = $promo_settings['badge_3_text'] ?? 'Giao Hỏa Tốc 1H';

$v1_badge       = $promo_settings['voucher_1_badge'] ?? '500K';
$v1_title       = $promo_settings['voucher_1_title'] ?? 'Giảm 500.000₫ cho Điện Thoại';
$v1_desc        = $promo_settings['voucher_1_desc'] ?? 'Đơn từ 10.000.000₫ • HSD: Hôm nay';
$v1_code        = $promo_settings['voucher_1_code'] ?? 'PHONEX500K';

$v2_badge       = $promo_settings['voucher_2_badge'] ?? '200K';
$v2_title       = $promo_settings['voucher_2_title'] ?? 'Giảm 200.000₫ cho Phụ Kiện';
$v2_desc        = $promo_settings['voucher_2_desc'] ?? 'Đơn từ 800.000₫ • HSD: Hôm nay';
$v2_code        = $promo_settings['voucher_2_code'] ?? 'PHONEX200K';

$sec_phone_t    = $promo_settings['sec_phone_title'] ?? 'ĐIỆN THOẠI GIÁ RẺ QUÁ - GIẢM ĐẾN 35%';
$sec_phone_s    = $promo_settings['sec_phone_subtitle'] ?? 'Bảo hành 12 tháng chính hãng • Thu cũ đổi mới trợ giá 3 triệu';

$sec_apple_t    = $promo_settings['sec_apple_title'] ?? 'HỆ SINH THÁI APPLE CHÍNH HÃNG VN/A';
$sec_apple_s    = $promo_settings['sec_apple_subtitle'] ?? 'Đại lý ủy quyền chính thức • Trợ giá học sinh sinh viên đến 3 triệu';
$sec_apple_b    = $promo_settings['sec_apple_badge'] ?? 'Apple Authorised Reseller';

$sec_tablet_t   = $promo_settings['sec_tablet_title'] ?? 'TABLET & LAPTOP HỌC TẬP - VĂN PHÒNG';
$sec_tablet_s   = $promo_settings['sec_tablet_subtitle'] ?? 'Ưu đãi sinh viên giảm thêm 500.000₫ • Tặng kèm túi chống sốc';

$sec_acc_t      = $promo_settings['sec_accessory_title'] ?? 'PHỤ KIỆN CHÍNH HÃNG - ĐỒNG GIÁ TỪ 99K';
$sec_acc_s      = $promo_settings['sec_accessory_subtitle'] ?? 'Bảo hành 1 đổi 1 trong 12 tháng • Mua 2 giảm thêm 10%';

$sec_watch_t    = $promo_settings['sec_watch_title'] ?? 'ĐỒNG HỒ THÔNG MINH & SỨC KHỎE 24/7';
$sec_watch_s    = $promo_settings['sec_watch_subtitle'] ?? 'Đo điện tâm đồ ECG • Huyết áp • GPS đa băng tần chính xác';

$sec_trade_t    = $promo_settings['sec_tradein_title'] ?? 'Lên Đời Smartphone Mới – Trợ Giá Đến 3.000.000đ';
$sec_trade_s    = $promo_settings['sec_tradein_subtitle'] ?? 'PhoneX tiếp nhận thu mua máy cũ tất cả các dòng iPhone, Samsung, Xiaomi,... Thẩm định chuẩn AI 60 giây, giải ngân nhận tiền mặt hoặc trừ tiếp vào giá máy mới.';

// Timeline slots from settings
$fs_slots = $flashsale_settings['slots'] ?? array(
	array( 'time' => '09:00', 'end_time' => '11:59', 'label' => 'Vừa kết thúc', 'status' => 'ended' ),
	array( 'time' => '12:00', 'end_time' => '13:59', 'label' => 'Đang diễn ra', 'status' => 'active' ),
	array( 'time' => '14:00', 'end_time' => '17:59', 'label' => 'Sắp diễn ra', 'status' => 'upcoming' ),
	array( 'time' => '18:00', 'end_time' => '20:59', 'label' => 'Sắp diễn ra', 'status' => 'upcoming' ),
	array( 'time' => '21:00', 'end_time' => '23:59', 'label' => 'Sắp diễn ra', 'status' => 'upcoming' ),
);

$fs_products = $flashsale_settings['products'] ?? array();

// Hybrid Promotion Products (Pinned IDs + WooCommerce On-Sale Auto-fill + Fallback)
$phone_pinned = $promo_settings['sec_phone_pinned'] ?? '16, 17, 18, 19, 20, 21';
$apple_pinned = $promo_settings['sec_apple_pinned'] ?? '16, 27, 23, 26, 22';
$tablet_pinned = $promo_settings['sec_tablet_pinned'] ?? '27';
$acc_pinned = $promo_settings['sec_accessory_pinned'] ?? '24, 25, 22, 23';
$watch_pinned = $promo_settings['sec_watch_pinned'] ?? '26';

$phone_prods = function_exists( 'phonex_get_promotion_products' ) ? phonex_get_promotion_products( array(
	'pinned_ids'     => $phone_pinned,
	'category_slugs' => array( 'apple', 'samsung', 'xiaomi', 'oppo', 'vivo' ),
	'limit'          => 12,
) ) : array();

$apple_prods = function_exists( 'phonex_get_promotion_products' ) ? phonex_get_promotion_products( array(
	'pinned_ids'     => $apple_pinned,
	'category_slugs' => array( 'apple', 'phu-kien-apple' ),
	'limit'          => 6,
) ) : array();

$tablet_fallbacks = array(
	array( 'name' => 'iPad 10.9 inch Gen 10 WiFi 64GB', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-may-tinh-bang.png', 'price_sale' => '8.990.000₫', 'price_orig' => '10.990.000₫', 'badge' => '-18%', 'specs' => '10.9 inch • A14 Bionic', 'rating' => '4.8', 'reviews' => '540 đánh giá' ),
	array( 'name' => 'Samsung Galaxy Tab S9 FE WiFi', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/but-tablet.png', 'price_sale' => '7.990.000₫', 'price_orig' => '9.990.000₫', 'badge' => '-20%', 'specs' => 'Bút S-Pen • 128GB', 'rating' => '4.7', 'reviews' => '320 đánh giá' ),
	array( 'name' => 'Xiaomi Pad 6 8GB/128GB', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-may-tinh-bang.png', 'price_sale' => '6.990.000₫', 'price_orig' => '8.990.000₫', 'badge' => '-25%', 'specs' => '144Hz • Snapdragon 870', 'rating' => '4.9', 'reviews' => '410 đánh giá' ),
	array( 'name' => 'Laptop Asus Vivobook 15 OLED i5', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/balo-tui-chong-soc.png', 'price_sale' => '16.490.000₫', 'price_orig' => '19.490.000₫', 'badge' => '-15%', 'specs' => 'Core i5 • OLED FHD', 'rating' => '4.8', 'reviews' => '190 đánh giá' ),
	array( 'name' => 'Lenovo IdeaPad Slim 3 i5 12450H', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/balo-tui-chong-soc.png', 'price_sale' => '13.990.000₫', 'price_orig' => '15.990.000₫', 'badge' => '-12%', 'specs' => '16GB RAM • 512GB', 'rating' => '4.7', 'reviews' => '210 đánh giá' ),
	array( 'name' => 'Màn hình Asus VY249HGR 24 inch FHD', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/gia-treo-man-hinh.png', 'price_sale' => '2.390.000₫', 'price_orig' => '3.190.000₫', 'badge' => '-22%', 'specs' => '120Hz • 1ms IPS', 'rating' => '4.9', 'reviews' => '650 đánh giá' ),
);

$tablet_prods = function_exists( 'phonex_get_promotion_products' ) ? phonex_get_promotion_products( array(
	'pinned_ids'     => $tablet_pinned,
	'category_slugs' => array( 'tablet', 'laptop', 'phu-kien-laptop-pc', 'but-tablet' ),
	'limit'          => 6,
	'fallbacks'      => $tablet_fallbacks,
) ) : $tablet_fallbacks;

$acc_fallbacks = array(
	array( 'name' => 'Pin Dự Phòng Anker MagGo Qi2 10.000mAh', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/sac-du-phong.png', 'price_sale' => '990.000₫', 'price_orig' => '1.290.000₫', 'badge' => '-25%', 'specs' => 'Qi2 • 15W', 'rating' => '4.9', 'reviews' => '720 đánh giá' ),
	array( 'name' => 'Kính Cường Lực Mipow Kingbull HD IP16', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/mieng-dan.png', 'price_sale' => '319.000₫', 'price_orig' => '420.000₫', 'badge' => '-24%', 'specs' => 'Chống trộm 9H', 'rating' => '4.8', 'reviews' => '1.400 đánh giá' ),
	array( 'name' => 'Loa Bluetooth JBL Clip 4 Bass Cực Căng', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/loa.png', 'price_sale' => '1.090.000₫', 'price_orig' => '1.690.000₫', 'badge' => '-35%', 'specs' => 'Chống nước IP67', 'rating' => '4.9', 'reviews' => '850 đánh giá' ),
	array( 'name' => 'Cáp Type-C to Type-C Baseus 100W 1.2m', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/sac-cap.png', 'price_sale' => '149.000₫', 'price_orig' => '250.000₫', 'badge' => '-40%', 'specs' => 'PD 100W • Bọc Dù', 'rating' => '4.7', 'reviews' => '3.100 đánh giá' ),
	array( 'name' => 'Củ Sạc Nhanh TORRAS ICENANO 20W Kèm Cáp', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/sac-cap.png', 'price_sale' => '390.000₫', 'price_orig' => '550.000₫', 'badge' => '-30%', 'specs' => 'ICENANO Siêu Nhỏ', 'rating' => '4.8', 'reviews' => '620 đánh giá' ),
	array( 'name' => 'Ốp Lưng MagSafe Apple iPhone 15 Pro', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-dien-thoai.png', 'price_sale' => '1.090.000₫', 'price_orig' => '1.490.000₫', 'badge' => '-25%', 'specs' => 'Chính Hãng Apple', 'rating' => '4.9', 'reviews' => '910 đánh giá' ),
);

$acc_prods = function_exists( 'phonex_get_promotion_products' ) ? phonex_get_promotion_products( array(
	'pinned_ids'     => $acc_pinned,
	'category_slugs' => array( 'phu-kien', 'sac-cap', 'pin-du-phong', 'tai-nghe-loa', 'kinh-cuong-luc' ),
	'limit'          => 6,
	'fallbacks'      => $acc_fallbacks,
) ) : $acc_fallbacks;

$watch_fallbacks = array(
	array( 'name' => 'Apple Watch Series 10 Nhôm GPS 46mm', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/kinh-thong-minh.png', 'price_sale' => '9.990.000₫', 'price_orig' => '11.990.000₫', 'badge' => '-17%', 'specs' => 'GPS 46mm • OLED', 'rating' => '4.9', 'reviews' => '380 đánh giá' ),
	array( 'name' => 'Garmin Fenix 8 Sapphire 51mm Titanium', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/day-deo-dien-thoai.png', 'price_sale' => '28.990.000₫', 'price_orig' => '31.990.000₫', 'badge' => '-10%', 'specs' => 'Titanium • Sapphire', 'rating' => '4.9', 'reviews' => '150 đánh giá' ),
	array( 'name' => 'Samsung Galaxy Watch 7 40mm Bluetooth', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/kinh-thong-minh.png', 'price_sale' => '6.190.000₫', 'price_orig' => '7.990.000₫', 'badge' => '-22%', 'specs' => 'Galaxy AI • 40mm', 'rating' => '4.8', 'reviews' => '290 đánh giá' ),
	array( 'name' => 'Huawei Watch GT 5 Pro 46mm Dây Cao Su', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/kinh-thong-minh.png', 'price_sale' => '5.990.000₫', 'price_orig' => '7.490.000₫', 'badge' => '-20%', 'specs' => 'Pin 14 Ngày • Titanium', 'rating' => '4.8', 'reviews' => '180 đánh giá' ),
	array( 'name' => 'Xiaomi Watch S3 Viền Khung Có Thể Đổi', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/kinh-thong-minh.png', 'price_sale' => '2.690.000₫', 'price_orig' => '3.490.000₫', 'badge' => '-23%', 'specs' => 'HyperOS • AMOLED 1.43"', 'rating' => '4.7', 'reviews' => '240 đánh giá' ),
	array( 'name' => 'Vòng Đeo Tay Xiaomi Smart Band 9 Active', 'link' => home_url( '/shop/' ), 'image' => get_template_directory_uri() . '/assets/images/categories/accessories/day-deo-dien-thoai.png', 'price_sale' => '590.000₫', 'price_orig' => '790.000₫', 'badge' => '-25%', 'specs' => 'Pin 18 Ngày • 5ATM', 'rating' => '4.9', 'reviews' => '890 đánh giá' ),
);

$watch_prods = function_exists( 'phonex_get_promotion_products' ) ? phonex_get_promotion_products( array(
	'pinned_ids'     => $watch_pinned,
	'category_slugs' => array( 'smartwatch', 'dong-ho' ),
	'limit'          => 6,
	'fallbacks'      => $watch_fallbacks,
) ) : $watch_fallbacks;
?>

<!-- PhoneX Mega Campaign Flash Sale Page (Designed after thegioididong.com/flashsale with PhoneX Brand Red & White) -->
<main class="w-full bg-[#f8f9fb] pb-16 font-sans text-text-main" id="phonex-campaign-page">

  <!-- ================= 1. HERO CAMPAIGN TOP BANNER ================= -->
  <section class="w-full bg-gradient-to-b from-[#7a0008] via-[#ba0d1a] to-[#93000a] text-white relative overflow-hidden py-6 sm:py-8 lg:py-10 border-b border-red-900/30">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 relative z-10">
      
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-rose-200/90 mb-4" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-white transition-colors flex items-center gap-1">
          <span class="material-symbols-outlined text-[16px]">home</span>
          <span>Trang chủ</span>
        </a>
        <span>/</span>
        <span class="text-white font-bold">Flash Sale &amp; Khuyến Mãi</span>
      </nav>

      <!-- Main Banner Content -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
        <div class="lg:col-span-8 space-y-3.5">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-amber-300 text-xs font-black uppercase tracking-wider border border-white/25">
            <span class="material-symbols-outlined text-[16px] animate-pulse">local_fire_department</span>
            <span><?php echo esc_html( $hero_badge ); ?></span>
          </div>

          <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black tracking-tight leading-tight">
            <?php echo esc_html( $hero_title_1 ); ?> <br class="hidden sm:inline" />
            <span class="text-amber-300 drop-shadow-sm"><?php echo esc_html( $hero_title_2 ); ?></span>
          </h1>

          <p class="text-rose-100 text-sm sm:text-base max-w-2xl leading-relaxed">
            <?php echo esc_html( $hero_desc ); ?>
          </p>

          <!-- Highlights Pills -->
          <div class="flex flex-wrap items-center gap-2 pt-1 text-xs font-bold">
            <span class="bg-black/30 border border-white/20 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-white">
              <span class="material-symbols-outlined text-amber-300 text-[16px]">verified</span>
              <span><?php echo esc_html( $badge_1_text ); ?></span>
            </span>
            <span class="bg-black/30 border border-white/20 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-white">
              <span class="material-symbols-outlined text-amber-300 text-[16px]">cached</span>
              <span><?php echo esc_html( $badge_2_text ); ?></span>
            </span>
            <span class="bg-black/30 border border-white/20 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-white">
              <span class="material-symbols-outlined text-amber-300 text-[16px]">local_shipping</span>
              <span><?php echo esc_html( $badge_3_text ); ?></span>
            </span>
          </div>
        </div>

        <!-- Right Box: Countdown Timer & Quick Voucher Collector (TGDD Style) -->
        <div class="lg:col-span-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 sm:p-5 shadow-xl text-white">
          <div class="flex items-center justify-between pb-3 border-b border-white/15">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-amber-300 text-[22px] animate-bounce">alarm</span>
              <span class="font-extrabold text-sm uppercase tracking-wide">KẾT THÚC SAU</span>
            </div>
            <div class="flex items-center gap-1 font-mono font-black" id="px-hero-countdown">
              <span class="bg-black/40 px-2 py-1 rounded text-base min-w-[32px] text-center" id="hero-cd-h"><?php echo sprintf( '%02d', $hero_hours ); ?></span>
              <span>:</span>
              <span class="bg-black/40 px-2 py-1 rounded text-base min-w-[32px] text-center" id="hero-cd-m"><?php echo sprintf( '%02d', $hero_minutes ); ?></span>
              <span>:</span>
              <span class="bg-amber-400 text-red-900 px-2 py-1 rounded text-base min-w-[32px] text-center font-black" id="hero-cd-s"><?php echo sprintf( '%02d', $hero_seconds ); ?></span>
            </div>
          </div>

          <!-- Coupon Claim Cards (TGDD PMH Voucher widget) -->
          <div class="mt-3.5 space-y-2">
            <div class="text-xs font-bold text-rose-100 uppercase tracking-wider flex items-center justify-between">
              <span>Mã giảm giá độc quyền:</span>
              <button type="button" onclick="claimAllVouchers()" class="text-amber-300 hover:underline cursor-pointer text-[11px] font-bold">Lấy tất cả mã</button>
            </div>

            <!-- Coupon 1 -->
            <div class="bg-white text-text-main rounded-xl p-2.5 flex items-center justify-between gap-2 shadow-xs border border-rose-100">
              <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-red-100 text-primary flex items-center justify-center font-black text-sm shrink-0">
                  <?php echo esc_html( $v1_badge ); ?>
                </div>
                <div>
                  <div class="font-bold text-xs leading-tight"><?php echo esc_html( $v1_title ); ?></div>
                  <div class="text-[10px] text-secondary"><?php echo esc_html( $v1_desc ); ?></div>
                </div>
              </div>
              <button type="button" class="btn-claim-voucher px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-all shrink-0 cursor-pointer" onclick="claimVoucher(this, '<?php echo esc_js( $v1_code ); ?>')">
                Lưu mã
              </button>
            </div>

            <!-- Coupon 2 -->
            <div class="bg-white text-text-main rounded-xl p-2.5 flex items-center justify-between gap-2 shadow-xs border border-rose-100">
              <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-black text-sm shrink-0">
                  <?php echo esc_html( $v2_badge ); ?>
                </div>
                <div>
                  <div class="font-bold text-xs leading-tight"><?php echo esc_html( $v2_title ); ?></div>
                  <div class="text-[10px] text-secondary"><?php echo esc_html( $v2_desc ); ?></div>
                </div>
              </div>
              <button type="button" class="btn-claim-voucher px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-all shrink-0 cursor-pointer" onclick="claimVoucher(this, '<?php echo esc_js( $v2_code ); ?>')">
                Lưu mã
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ================= 2. STICKY CATEGORY NAVIGATION (TGDD Style wrapmenu-scroll) ================= -->
  <nav class="sticky top-[60px] md:top-[68px] z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-xs" id="px-sticky-campaign-nav">
    <div class="max-w-[1440px] mx-auto px-4 overflow-x-auto no-scrollbar py-2.5">
      <div class="flex items-center gap-2 sm:gap-2.5 min-w-max text-xs sm:text-[13px] font-bold">
        <a href="#flash-sale" class="px-nav-link active px-4 py-2 rounded-xl bg-primary text-white shadow-xs flex items-center gap-1.5 transition-all">
          <span class="material-symbols-outlined text-[17px] text-amber-300">local_fire_department</span>
          <span>Flash Sale</span>
        </a>
        <a href="#dtdd" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">smartphone</span>
          <span>Điện Thoại</span>
        </a>
        <a href="#apple" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">phone_iphone</span>
          <span>Hệ Sinh Thái Apple</span>
        </a>
        <a href="#tablet-laptop" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">tablet_mac</span>
          <span>Tablet &amp; Laptop</span>
        </a>
        <a href="#phu-kien" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">headphones</span>
          <span>Phụ Kiện</span>
        </a>
        <a href="#smartwatch" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">watch</span>
          <span>Đồng Hồ Thông Minh</span>
        </a>
        <a href="#thu-cu" class="px-nav-link px-4 py-2 rounded-xl bg-gray-100 hover:bg-rose-50 text-gray-800 hover:text-primary transition-all flex items-center gap-1.5 border border-transparent hover:border-rose-200">
          <span class="material-symbols-outlined text-[17px]">sync_saved_locally</span>
          <span>Máy Cũ &amp; Thu Cũ</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content Wrap -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 pt-6 sm:pt-8 space-y-10 lg:space-y-12">

    <!-- ================= SECTION 1: FLASH SALE GIỜ VÀNG (TGDD Style #flash-sale) ================= -->
    <section id="flash-sale" class="scroll-mt-28">
      <div class="rounded-2xl p-4 sm:p-6 lg:p-7 shadow-xs border border-rose-200" style="background: linear-gradient(180deg, #fff5f5 0%, #fff0f2 100%);">
        
        <!-- Header Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pb-4 border-b border-rose-200/80">
          <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-primary-container text-on-primary font-black text-lg sm:text-xl shadow-xs">
              <span class="material-symbols-outlined text-[24px] text-amber-300 animate-pulse">local_fire_department</span>
              <span>FLASH SALE GIỜ VÀNG</span>
            </div>
            <span class="text-xs sm:text-sm text-secondary font-medium hidden sm:inline">Khung giờ vàng giảm sốc - Độc quyền trong ngày</span>
          </div>

          <!-- Countdown Box -->
          <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-rose-200 shadow-2xs">
            <span class="text-secondary text-xs sm:text-sm font-semibold">Kết thúc sau:</span>
            <div class="flex items-center gap-1 font-mono text-white font-bold" id="phonex-fs-main-countdown">
              <span class="bg-inverse-surface px-2 py-0.5 rounded text-xs sm:text-sm min-w-[26px] text-center" id="fs-main-cd-h"><?php echo sprintf( '%02d', $cd_hours ); ?></span>
              <span class="text-text-main">:</span>
              <span class="bg-inverse-surface px-2 py-0.5 rounded text-xs sm:text-sm min-w-[26px] text-center" id="fs-main-cd-m"><?php echo sprintf( '%02d', $cd_minutes ); ?></span>
              <span class="text-text-main">:</span>
              <span class="bg-primary-container px-2 py-0.5 rounded text-xs sm:text-sm min-w-[26px] text-center text-amber-300 font-extrabold" id="fs-main-cd-s"><?php echo sprintf( '%02d', $cd_seconds ); ?></span>
            </div>
          </div>
        </div>

        <!-- Timeline Slots Navigation -->
        <div class="mt-4 mb-6 overflow-x-auto no-scrollbar">
          <div class="flex items-center gap-2 sm:gap-3 min-w-[620px] pb-2">
            <?php foreach ( $fs_slots as $idx => $slot ) : 
              $is_active = ( ( $slot['status'] ?? '' ) === 'active' );
              $is_ended = ( ( $slot['status'] ?? '' ) === 'ended' );
            ?>
              <div class="flex-1 py-2.5 px-3 rounded-xl flex flex-col items-center justify-center text-center relative border <?php echo $is_active ? 'bg-primary-container text-on-primary shadow-sm border-primary-container font-extrabold scale-[1.02]' : ( $is_ended ? 'bg-surface-container text-secondary/70 border-transparent' : 'bg-white text-text-main border-border-subtle shadow-2xs' ); ?>">
                <span class="text-lg sm:text-xl font-black leading-none mb-1"><?php echo esc_html( $slot['time'] ); ?></span>
                <span class="text-[11px] font-bold uppercase tracking-wider flex items-center gap-1 <?php echo $is_active ? 'text-amber-300' : ''; ?>">
                  <?php if ( $is_active ) : ?>
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                  <?php endif; ?>
                  <?php echo esc_html( $slot['label'] ); ?>
                </span>
                <?php if ( $is_active ) : ?>
                  <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-primary-container rotate-45"></div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Flash Sale Grid: 2 Distinct Rows (Row 1 Smartphone + Row 2 Accessories) -->
        <?php 
          $row1_prods = array_slice( $fs_products, 0, 6 );
          $row2_prods = array_slice( $fs_products, 6, 6 );
        ?>

        <!-- Dòng 1 Header -->
        <div class="flex items-center justify-between flex-wrap gap-2 pt-1 pb-2 border-b border-rose-200">
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-primary-container text-on-primary text-xs font-black uppercase tracking-wider">
              <span class="material-symbols-outlined text-[15px]">smartphone</span>
              <span>DÒNG 1 • SMARTPHONE FLAGSHIP GIẢM SỐC</span>
            </span>
            <span class="text-xs text-secondary font-medium hidden sm:inline">6 mẫu điện thoại cao cấp bán chạy nhất</span>
          </div>
          <span class="text-xs font-bold text-primary bg-rose-100 border border-rose-300 px-3 py-1 rounded-full flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">local_fire_department</span>
            <span>Giảm Đến 25% • Trợ Giá Thu Cũ 3Tr</span>
          </span>
        </div>

        <!-- Row 1 Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4 mt-3">
          <?php foreach ( $row1_prods as $idx => $prod ) : 
            $sold = intval( $prod['sold'] ?? 45 );
            $total = max( 1, intval( $prod['total_stock'] ?? 50 ) );
            $pct = min( 100, round( ( $sold / $total ) * 100 ) );
            $link = ! empty( $prod['link'] ) ? esc_url( $prod['link'] ) : '#';
          ?>
            <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group border border-rose-200/90 hover:border-primary relative hover:-translate-y-1 duration-200">
              <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-surface-container-low rounded-lg mb-2 overflow-hidden">
                <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary-container text-on-primary text-[10px] font-extrabold shadow-sm">
                  <?php echo esc_html( $prod['badge'] ?? '-15%' ); ?>
                </span>
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $prod['name'] ); ?>" src="<?php echo esc_url( $prod['image'] ); ?>" loading="lazy"/>
              </div>
              <div class="flex-1 flex flex-col justify-between">
                <div>
                  <div class="flex items-center gap-1 mb-1">
                    <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-rose-50 text-primary border border-rose-200/80">Flagship</span>
                    <span class="px-1.5 py-0.5 bg-surface-container rounded text-[10px] text-secondary font-medium truncate max-w-full"><?php echo esc_html( $prod['specs'] ?? 'Chính hãng VN/A' ); ?></span>
                  </div>
                  <h4 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $prod['name'] ); ?>">
                    <?php echo esc_html( $prod['name'] ); ?>
                  </h4>
                </div>
                <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                  <span class="text-[15px] sm:text-[16px] xl:text-[17px] font-black text-primary leading-tight"><?php echo esc_html( $prod['price_sale'] ); ?></span>
                  <span class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $prod['price_orig'] ); ?></span>
                </div>
                <div class="mt-2.5 space-y-1">
                  <div class="flex justify-between text-[10px] text-secondary">
                    <span>Đã bán <?php echo esc_html( $sold ); ?>/<?php echo esc_html( $total ); ?></span>
                    <span class="text-primary font-bold truncate ml-1"><?php echo esc_html( $prod['stock_text'] ?? 'Bán chạy' ); ?></span>
                  </div>
                  <div class="w-full h-1.5 rounded-full bg-surface-container overflow-hidden">
                    <div class="h-full bg-primary-container rounded-full" style="width: <?php echo esc_attr( $pct ); ?>%;"></div>
                  </div>
                </div>
              </div>
              <a href="<?php echo $link; ?>" class="mt-3 w-full h-9 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary text-xs sm:text-[13px] font-bold transition-colors flex items-center justify-center gap-1 shadow-sm">
                Mua Ngay
              </a>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Dòng 2 Header & Divider -->
        <?php if ( ! empty( $row2_prods ) ) : ?>
          <div class="mt-7 pt-6 border-t-2 border-dashed border-rose-300/80">
            <div class="flex items-center justify-between flex-wrap gap-2 pt-1 pb-2 border-b border-amber-200">
              <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-600 text-white text-xs font-black uppercase tracking-wider">
                  <span class="material-symbols-outlined text-[15px]">headphones</span>
                  <span>DÒNG 2 • PHỤ KIỆN CAO CẤP &amp; HỆ SINH THÁI THÔNG MINH</span>
                </span>
                <span class="text-xs text-secondary font-medium hidden sm:inline">Apple Watch, iPad, Tai nghe AirPods &amp; Củ sạc nhanh</span>
              </div>
              <span class="text-xs font-bold text-amber-800 bg-amber-100 border border-amber-300 px-3 py-1 rounded-full flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">verified</span>
                <span>Giảm Sốc Đến 30% • Bảo Hành 1 Đổi 1</span>
              </span>
            </div>

            <!-- Row 2 Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4 mt-3">
              <?php foreach ( $row2_prods as $idx => $prod ) : 
                $sold = intval( $prod['sold'] ?? 30 );
                $total = max( 1, intval( $prod['total_stock'] ?? 50 ) );
                $pct = min( 100, round( ( $sold / $total ) * 100 ) );
                $link = ! empty( $prod['link'] ) ? esc_url( $prod['link'] ) : '#';
              ?>
                <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group border border-amber-200/90 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
                  <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-surface-container-low rounded-lg mb-2 overflow-hidden">
                    <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-gradient-to-r from-amber-500 to-orange-500 text-white text-[10px] font-extrabold shadow-sm">
                      <?php echo esc_html( $prod['badge'] ?? '-20%' ); ?>
                    </span>
                    <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $prod['name'] ); ?>" src="<?php echo esc_url( $prod['image'] ); ?>" loading="lazy"/>
                  </div>
                  <div class="flex-1 flex flex-col justify-between">
                    <div>
                      <div class="flex items-center gap-1 mb-1">
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200/80">Ecosystem</span>
                        <span class="px-1.5 py-0.5 bg-surface-container rounded text-[10px] text-secondary font-medium truncate max-w-full"><?php echo esc_html( $prod['specs'] ?? 'Chính hãng VN/A' ); ?></span>
                      </div>
                      <h4 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $prod['name'] ); ?>">
                        <?php echo esc_html( $prod['name'] ); ?>
                      </h4>
                    </div>
                    <div class="mt-2 flex flex-wrap items-baseline gap-1.5">
                      <span class="text-[15px] sm:text-[16px] xl:text-[17px] font-black text-amber-800 leading-tight"><?php echo esc_html( $prod['price_sale'] ); ?></span>
                      <span class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $prod['price_orig'] ); ?></span>
                    </div>
                    <div class="mt-2.5 space-y-1">
                      <div class="flex justify-between text-[10px] text-secondary">
                        <span>Đã bán <?php echo esc_html( $sold ); ?>/<?php echo esc_html( $total ); ?></span>
                        <span class="text-amber-700 font-bold truncate ml-1"><?php echo esc_html( $prod['stock_text'] ?? 'Bán chạy' ); ?></span>
                      </div>
                      <div class="w-full h-1.5 rounded-full bg-surface-container overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-full" style="width: <?php echo esc_attr( $pct ); ?>%;"></div>
                      </div>
                    </div>
                  </div>
                  <a href="<?php echo $link; ?>" class="mt-3 w-full h-9 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs sm:text-[13px] font-bold transition-colors flex items-center justify-center gap-1 shadow-sm">
                    Mua Ngay
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </section>

    <!-- ================= SECTION 2: ĐIỆN THOẠI FLAGSHIP GIẢM ĐẾN 35% (TGDD Style #dtdd) ================= -->
    <section id="dtdd" class="scroll-mt-28 space-y-4">
      <!-- Section Category Banner -->
      <div class="bg-gradient-to-r from-red-600 via-rose-600 to-red-700 rounded-2xl p-4 sm:p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px] text-amber-300">smartphone</span>
          </div>
          <div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight"><?php echo esc_html( $sec_phone_t ); ?></h2>
            <p class="text-xs sm:text-sm text-rose-100"><?php echo esc_html( $sec_phone_s ); ?></p>
          </div>
        </div>

        <!-- Brand Filter Pills -->
        <div class="flex items-center gap-1.5 flex-wrap text-xs font-bold" id="brand-filters-phone">
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white text-red-700 shadow-xs cursor-pointer active-filter" onclick="filterCategory(this, 'all', '#phone-grid')">Tất cả</button>
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white text-white hover:text-red-700 transition-colors cursor-pointer" onclick="filterCategory(this, 'iphone', '#phone-grid')">iPhone</button>
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white text-white hover:text-red-700 transition-colors cursor-pointer" onclick="filterCategory(this, 'samsung', '#phone-grid')">Samsung</button>
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white text-white hover:text-red-700 transition-colors cursor-pointer" onclick="filterCategory(this, 'xiaomi', '#phone-grid')">Xiaomi</button>
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white text-white hover:text-red-700 transition-colors cursor-pointer" onclick="filterCategory(this, 'oppo', '#phone-grid')">OPPO</button>
          <button type="button" class="px-3.5 py-1.5 rounded-full bg-white/20 hover:bg-white text-white hover:text-red-700 transition-colors cursor-pointer" onclick="filterCategory(this, 'vivo', '#phone-grid')">vivo</button>
        </div>
      </div>

      <!-- Product Grid (6 columns desktop) -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4" id="phone-grid">
        <?php foreach ( $phone_prods as $p ) : ?>
          <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="<?php echo esc_attr( $p['brand'] ?? 'all' ); ?>">
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">
                <?php echo esc_html( $p['badge'] ?? '-15%' ); ?>
              </span>
              <?php if ( ! empty( $p['sub_badge'] ) ) : ?>
                <span class="absolute bottom-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-rose-50 text-red-700 border border-rose-200 text-[9px] font-bold">
                  <?php echo esc_html( $p['sub_badge'] ); ?>
                </span>
              <?php endif; ?>
              <a href="<?php echo esc_url( $p['link'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $p['name'] ); ?>" src="<?php echo esc_url( $p['image'] ); ?>" loading="lazy"/>
              </a>
            </div>
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-1">
                  <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium truncate max-w-full">
                    <?php echo esc_html( $p['specs'] ?? 'Chính hãng VN/A' ); ?>
                  </span>
                </div>
                <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
                  <a href="<?php echo esc_url( $p['link'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $p['name'] ); ?>
                  </a>
                </h3>
              </div>
              <div class="mt-2">
                <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight"><?php echo esc_html( $p['price_sale'] ); ?></div>
                <div class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $p['price_orig'] ); ?></div>
              </div>
              <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
                <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
                <span class="font-bold text-gray-700"><?php echo esc_html( $p['rating'] ?? '4.9' ); ?></span>
                <span>(<?php echo esc_html( $p['reviews'] ?? '180 đánh giá' ); ?>)</span>
              </div>
            </div>
            <a href="<?php echo esc_url( $p['link'] ); ?>" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors flex items-center justify-center gap-1 shadow-xs">
              Mua Ngay
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ================= SECTION 3: HỆ SINH THÁI APPLE CHÍNH HÃNG VN/A (TGDD Style #apple) ================= -->
    <section id="apple" class="scroll-mt-28 space-y-4">
      <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-black rounded-2xl p-4 sm:p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px] text-amber-300">phone_iphone</span>
          </div>
          <div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight"><?php echo esc_html( $sec_apple_t ); ?></h2>
            <p class="text-xs sm:text-sm text-gray-300"><?php echo esc_html( $sec_apple_s ); ?></p>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <span class="px-3 py-1.5 rounded-full bg-white/15 text-xs font-bold text-white"><?php echo esc_html( $sec_apple_b ); ?></span>
        </div>
      </div>

      <!-- Apple Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4">
        <?php foreach ( $apple_prods as $p ) : ?>
          <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-gray-900 text-white text-[10px] font-extrabold shadow-xs">
                <?php echo esc_html( $p['badge'] ?? 'APPLE' ); ?>
              </span>
              <a href="<?php echo esc_url( $p['link'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $p['name'] ); ?>" src="<?php echo esc_url( $p['image'] ); ?>" loading="lazy"/>
              </a>
            </div>
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-1">
                  <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium truncate max-w-full">
                    <?php echo esc_html( $p['specs'] ?? 'Chính Hãng VN/A' ); ?>
                  </span>
                </div>
                <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
                  <a href="<?php echo esc_url( $p['link'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $p['name'] ); ?>
                  </a>
                </h3>
              </div>
              <div class="mt-2">
                <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight"><?php echo esc_html( $p['price_sale'] ); ?></div>
                <div class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $p['price_orig'] ); ?></div>
              </div>
            </div>
            <a href="<?php echo esc_url( $p['link'] ); ?>" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors flex items-center justify-center gap-1 shadow-xs">
              Mua Ngay
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ================= SECTION 4: TABLET & LAPTOP HỌC TẬP (TGDD Style #tablet #laptop) ================= -->
    <section id="tablet-laptop" class="scroll-mt-28 space-y-4">
      <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-800 rounded-2xl p-4 sm:p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px] text-amber-300">tablet_mac</span>
          </div>
          <div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight"><?php echo esc_html( $sec_tablet_t ); ?></h2>
            <p class="text-xs sm:text-sm text-blue-100"><?php echo esc_html( $sec_tablet_s ); ?></p>
          </div>
        </div>
      </div>

      <!-- Tablet Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4">
        <?php foreach ( $tablet_prods as $p ) : ?>
          <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-blue-600 text-white text-[10px] font-extrabold shadow-xs">
                <?php echo esc_html( $p['badge'] ?? '-15%' ); ?>
              </span>
              <a href="<?php echo esc_url( $p['link'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $p['name'] ); ?>" src="<?php echo esc_url( $p['image'] ); ?>" loading="lazy"/>
              </a>
            </div>
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-1">
                  <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium truncate max-w-full">
                    <?php echo esc_html( $p['specs'] ?? 'Chính hãng VN/A' ); ?>
                  </span>
                </div>
                <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
                  <a href="<?php echo esc_url( $p['link'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $p['name'] ); ?>
                  </a>
                </h3>
              </div>
              <div class="mt-2">
                <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight"><?php echo esc_html( $p['price_sale'] ); ?></div>
                <div class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $p['price_orig'] ); ?></div>
              </div>
            </div>
            <a href="<?php echo esc_url( $p['link'] ); ?>" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors flex items-center justify-center gap-1 shadow-xs">
              Mua Ngay
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ================= SECTION 5: PHỤ KIỆN XẢ KHO - ĐỒNG GIÁ TỪ 99K (TGDD Style #phu-kien) ================= -->
    <section id="phu-kien" class="scroll-mt-28 space-y-4">
      <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700 rounded-2xl p-4 sm:p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px] text-white">headphones</span>
          </div>
          <div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight"><?php echo esc_html( $sec_acc_t ); ?></h2>
            <p class="text-xs sm:text-sm text-amber-100"><?php echo esc_html( $sec_acc_s ); ?></p>
          </div>
        </div>
      </div>

      <!-- Accessories Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4">
        <?php foreach ( $acc_prods as $p ) : ?>
          <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">
                <?php echo esc_html( $p['badge'] ?? '-20%' ); ?>
              </span>
              <a href="<?php echo esc_url( $p['link'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $p['name'] ); ?>" src="<?php echo esc_url( $p['image'] ); ?>" loading="lazy"/>
              </a>
            </div>
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-1">
                  <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium truncate max-w-full">
                    <?php echo esc_html( $p['specs'] ?? 'Chính Hãng' ); ?>
                  </span>
                </div>
                <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
                  <a href="<?php echo esc_url( $p['link'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $p['name'] ); ?>
                  </a>
                </h3>
              </div>
              <div class="mt-2">
                <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight"><?php echo esc_html( $p['price_sale'] ); ?></div>
                <div class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $p['price_orig'] ); ?></div>
              </div>
            </div>
            <a href="<?php echo esc_url( $p['link'] ); ?>" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors flex items-center justify-center gap-1 shadow-xs">
              Mua Ngay
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ================= SECTION 6: SMARTWATCH & THỂ THAO (TGDD Style #smartwatch) ================= -->
    <section id="smartwatch" class="scroll-mt-28 space-y-4">
      <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 rounded-2xl p-4 sm:p-5 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[28px] text-amber-300">watch</span>
          </div>
          <div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight"><?php echo esc_html( $sec_watch_t ); ?></h2>
            <p class="text-xs sm:text-sm text-emerald-100"><?php echo esc_html( $sec_watch_s ); ?></p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4">
        <?php foreach ( $watch_prods as $p ) : ?>
          <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-emerald-600 relative hover:-translate-y-1 duration-200">
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
              <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-emerald-700 text-white text-[10px] font-extrabold shadow-xs">
                <?php echo esc_html( $p['badge'] ?? '-15%' ); ?>
              </span>
              <a href="<?php echo esc_url( $p['link'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $p['name'] ); ?>" src="<?php echo esc_url( $p['image'] ); ?>" loading="lazy"/>
              </a>
            </div>
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-1">
                  <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-800 rounded text-[10px] font-medium truncate max-w-full">
                    <?php echo esc_html( $p['specs'] ?? 'Chính Hãng' ); ?>
                  </span>
                </div>
                <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
                  <a href="<?php echo esc_url( $p['link'] ); ?>" class="hover:text-primary transition-colors">
                    <?php echo esc_html( $p['name'] ); ?>
                  </a>
                </h3>
              </div>
              <div class="mt-2">
                <div class="text-[16px] sm:text-[17px] font-black text-emerald-800 leading-tight"><?php echo esc_html( $p['price_sale'] ); ?></div>
                <div class="text-[11px] sm:text-[12px] text-secondary line-through"><?php echo esc_html( $p['price_orig'] ); ?></div>
              </div>
            </div>
            <a href="<?php echo esc_url( $p['link'] ); ?>" class="mt-3 w-full h-8.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors flex items-center justify-center gap-1 shadow-xs">
              Mua Ngay
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ================= SECTION 7: THU CŨ ĐỔI MỚI & MÁY CŨ 99% TUYỂN CHỌN (TGDD Style #thu-cu) ================= -->
    <section id="thu-cu" class="scroll-mt-28">
      <div class="rounded-2xl p-6 sm:p-8 bg-white border border-gray-200 shadow-sm relative overflow-hidden">
        <div class="max-w-3xl space-y-4">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 text-primary text-xs font-black uppercase">
            <span class="material-symbols-outlined text-[16px]">sync_saved_locally</span>
            <span>CHÍNH SÁCH THU CŨ ĐỔI MỚI TRỢ GIÁ KHỦNG</span>
          </div>
          <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
            <?php echo esc_html( $sec_trade_t ); ?>
          </h2>
          <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
            <?php echo esc_html( $sec_trade_s ); ?>
          </p>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
            <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-sm shrink-0">1</div>
              <div>
                <h4 class="font-bold text-xs text-gray-900">Định giá online</h4>
                <p class="text-[11px] text-gray-500">Chỉ mất 60 giây để biết giá thu</p>
              </div>
            </div>
            <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-sm shrink-0">2</div>
              <div>
                <h4 class="font-bold text-xs text-gray-900">Kiểm tra 68 bước</h4>
                <p class="text-[11px] text-gray-500">Kỹ thuật viên kiểm tra tận nơi</p>
              </div>
            </div>
            <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
              <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-sm shrink-0">3</div>
              <div>
                <h4 class="font-bold text-xs text-gray-900">Nhận máy mới</h4>
                <p class="text-[11px] text-gray-500">Nhận máy liền tay, bảo hành 12T</p>
              </div>
            </div>
          </div>

          <div class="pt-2 flex flex-wrap gap-3">
            <a href="<?php echo esc_url( home_url( '/thu-cu-doi-moi/' ) ); ?>" class="px-6 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold text-sm shadow-sm transition-all flex items-center gap-2">
              <span>Định Giá Máy Cũ Ngay</span>
              <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-sm transition-all flex items-center gap-2">
              <span>Khám Phá Máy Cũ Tuyển Chọn 99%</span>
            </a>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>

<!-- Sticky Navigation Active State Script & Coupon Script -->
<script>
  // Countdown Timer
  (function initCampaignCountdown() {
    const hoursEl = document.getElementById('hero-cd-h');
    const minsEl = document.getElementById('hero-cd-m');
    const secsEl = document.getElementById('hero-cd-s');

    const mainHoursEl = document.getElementById('fs-main-cd-h');
    const mainMinsEl = document.getElementById('fs-main-cd-m');
    const mainSecsEl = document.getElementById('fs-main-cd-s');

    if (!hoursEl || !minsEl || !secsEl) return;

    let h = parseInt(hoursEl.textContent) || 2;
    let m = parseInt(minsEl.textContent) || 45;
    let s = parseInt(secsEl.textContent) || 18;

    setInterval(function() {
      s--;
      if (s < 0) {
        s = 59;
        m--;
        if (m < 0) {
          m = 59;
          h--;
          if (h < 0) {
            h = 23;
            m = 59;
            s = 59;
          }
        }
      }
      const pad = n => String(n).padStart(2, '0');
      hoursEl.textContent = pad(h);
      minsEl.textContent = pad(m);
      secsEl.textContent = pad(s);

      if (mainHoursEl) mainHoursEl.textContent = pad(h);
      if (mainMinsEl) mainMinsEl.textContent = pad(m);
      if (mainSecsEl) mainSecsEl.textContent = pad(s);
    }, 1000);
  })();

  // Voucher claim function
  function claimVoucher(btn, code) {
    if (btn.classList.contains('claimed')) return;
    btn.classList.add('claimed', 'bg-emerald-600', 'hover:bg-emerald-600');
    btn.classList.remove('bg-primary', 'hover:bg-primary-hover');
    btn.innerHTML = 'Đã lưu ✓';
    
    // Toast notification
    showToast('Đã lưu mã ' + code + ' vào ví ưu đãi của bạn!');
  }

  function claimAllVouchers() {
    document.querySelectorAll('.btn-claim-voucher').forEach(btn => {
      btn.click();
    });
  }

  // Toast notification
  function showToast(msg) {
    let toast = document.getElementById('px-campaign-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'px-campaign-toast';
      toast.className = 'fixed bottom-6 right-6 z-50 px-5 py-3 rounded-xl bg-gray-900 text-white font-bold text-xs sm:text-sm shadow-xl flex items-center gap-2 transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-none';
      document.body.appendChild(toast);
    }
    toast.innerHTML = '<span class="material-symbols-outlined text-amber-400 text-[20px]">check_circle</span><span>' + msg + '</span>';
    toast.classList.remove('translate-y-10', 'opacity-0', 'pointer-events-none');
    setTimeout(() => {
      toast.classList.add('translate-y-10', 'opacity-0', 'pointer-events-none');
    }, 2800);
  }

  // Sticky Category Nav Scroll Spy
  window.addEventListener('scroll', function() {
    const navLinks = document.querySelectorAll('.px-nav-link');
    const sections = document.querySelectorAll('main > div > section[id]');
    
    let currentId = '';
    const scrollPos = window.scrollY + 140;

    sections.forEach(sec => {
      const top = sec.offsetTop;
      const height = sec.offsetHeight;
      if (scrollPos >= top && scrollPos < top + height) {
        currentId = sec.getAttribute('id');
      }
    });

    if (currentId) {
      navLinks.forEach(link => {
        const href = link.getAttribute('href').replace('#', '');
        if (href === currentId) {
          link.classList.add('bg-primary', 'text-white');
          link.classList.remove('bg-gray-100', 'text-gray-800');
        } else {
          link.classList.remove('bg-primary', 'text-white');
          link.classList.add('bg-gray-100', 'text-gray-800');
        }
      });
    }
  });

  // Category brand filter function
  function filterCategory(btn, brand, gridSelector) {
    const grid = document.querySelector(gridSelector);
    if (!grid) return;

    btn.parentElement.querySelectorAll('button').forEach(b => {
      b.classList.remove('bg-white', 'text-red-700');
      b.classList.add('bg-white/20', 'text-white');
    });
    btn.classList.add('bg-white', 'text-red-700');
    btn.classList.remove('bg-white/20', 'text-white');

    const items = grid.querySelectorAll('.prod-filter-item');
    items.forEach(item => {
      if (brand === 'all' || item.dataset.brand === brand) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  }
</script>

<?php get_footer(); ?>
