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
        
        <!-- Phone 1 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="iphone">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-14%</span>
            <span class="absolute bottom-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-rose-50 text-red-700 border border-rose-200 text-[9px] font-bold">Trả góp 0%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="iPhone 16 Pro Max 256GB" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-4en2O7D4jSmK1F_307aWHglaOxV3xJ5ikX_dcyBMbBC3uzM1eWtcTda9qSNyj_KT_D8YCSigC9x6hikTgPPqmdR3mLvLBLqJqMdCYCFNFV-iKZDPMzZM55q5n6_dS9YSQZNoHMasEmcFfdqklJf7-jPcatAnEPC3J_GXTllmfXHFWQKdLUi65SnBrvmsXo1LKfT7q8zYI7Ep0IGPHGJ-iQ6Ty-EJsmkost536obrn0l6wLIwet8H" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">A18 Pro • 256GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                iPhone 16 Pro Max 256GB VN/A
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">33.490.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">34.990.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.9</span>
              <span>(1.280 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Phone 2 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="samsung">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-18%</span>
            <span class="absolute bottom-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-rose-50 text-red-700 border border-rose-200 text-[9px] font-bold">Thu cũ +3Tr</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Galaxy S25 Ultra" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZ8cuMHSs16BGSbqL3osP6m_454IdcEnFrET6PX-zB9G7FJ3N9j6g5f-O5mlEKAnKNCGzpjZHaPqDHk5eQ7aAUYTQSpL2T2BXsRZVBRIsmzpkd39YqtnzfYdn1xj2QRF58FGv3hauWnmQwJYu9fthOr04mXeo6X_TDY6z2u2dYJyX4gKVk_GIImuiFHFOgKWKAzCYuFW7dx2G-84U7j4r5HUvh1xOZ714bcFju9liesR5DmsXco6mn" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Snapdragon 8 Elite</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Samsung Galaxy S25 Ultra 512GB SSVN
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">34.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">42.600.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.8</span>
              <span>(890 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Phone 3 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="iphone">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-16%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="iPhone 16 128GB" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPT8j9gPDdQw803_EjHE9CrxcBd9ByYWch8rA3iK2EBwUlD-AYBurDY51Zuw1-Qsp9Vt7q1Pd3TVFYZSrTi9fCyrBWkDC5RcYBn8JZgRzAewL2GfxpWRIqXsBv_xwE0rndJ5hkpIutccJGL_JBkwS1NztjDieoZb_RoQt57EclFFLXTYI0bltlq5jZN_GOmx2UWCj1fqYtciRolzYGtW8p2r7rv-v-M7usKZhT8cNXKavd4vLaz8TF" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">A18 • 128GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                iPhone 16 128GB VN/A
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">21.890.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">22.990.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.9</span>
              <span>(640 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Phone 4 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="xiaomi">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-22%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Xiaomi 15 Pro" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Leica Optics • 256GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Xiaomi 15 Pro 5G Leica Edition
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">15.490.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">19.990.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.7</span>
              <span>(412 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Phone 5 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="oppo">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-20%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="OPPO Find X8 Pro" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBu_9AXg1F-hNXVDThacap6KkD1w0RouLY7G5_x1hInqKGQ7k1LBUyXtFtqS2Wzb4XNJDUvoETcEZ1bV0hQpFwFump0hX5v0sX9yBwzUfavEMyguH2xelmCSR1blBQv942EFdLpC79AzVGFQG2i7FV_QPGw_tw7TDgobOrNWqS53JP8tRMgtEifRLNz_CflR9NIygo4ggcNHqNOsmT9_dMdSBAcRvAnODB7V0SL9u7hIBjKYH5n1iBT" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Hasselblad • 512GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                OPPO Find X8 Pro 512GB Hasselblad
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">23.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">29.990.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.8</span>
              <span>(310 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Phone 6 -->
        <div class="prod-filter-item bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200" data-brand="vivo">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-25%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="vivo X200 Pro" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRBzg3aq6sxZduVxZ6TuiFGHjC7CrATsVyVLV2sk8mjnmSygK6XWcgic3TYrHutR2Eb38VNmKw9T59VYW7vAQCmTRGiT7tJtgKRsjs9WJT-xaH2S_FOwMzaGGzNQczvNgdo-wbIn-IwLheyG9Rb3CzoVz915kikp3H8Nx-tSF-ET7RmXgv3H67L7bAdw0Q9eGwRY9XfLmP-TlJWChtjO9riOWRRuyKRBMEUZzYQ1sgrG-QZOpp-4Ey" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">ZEISS APO • 256GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                vivo X200 Pro 256GB ZEISS APO
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-primary leading-tight">19.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">23.990.000₫</div>
            </div>
            <div class="mt-2 text-[10px] text-gray-500 bg-gray-50 p-1.5 rounded flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px] text-amber-500">star</span>
              <span class="font-bold text-gray-700">4.9</span>
              <span>(250 đánh giá)</span>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

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
        
        <!-- Apple 1: Mac mini M4 -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-gray-900 text-white text-[10px] font-extrabold shadow-xs">M4 CHIP</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Mac mini M4" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/hub-cap-chuyen-doi.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">16GB | 256GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Mac mini M4 16GB/256GB Chính Hãng
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">14.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">15.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Apple 2: iPad Air M2 -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-15%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="iPad Air 11 M2" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfb9IgGxJEJ2xwiFRabguXqW52iA82cPiloD2HdZ5f1f_VgP3OdsUljxxbatuahW7eAT0SAqJ8KIoki7bWG6PcATan8ckLOdPgZX2M_wnTFbmiPn5dRDEekn2y0g5VPGpoIUkBfXzEVuE7n9QvMnVO050dfoluQAN9SRijuSaZWFGOAm-yX8dJxQt4sYwWOQSfrWNTLogGFW5eaq1k2Xi2K89I4iYgDvTw-IDpMWpMgOWB84z9EpGp" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Apple M2 • 128GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                iPad Air 11 inch M2 WiFi 128GB
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">14.490.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">16.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Apple 3: AirPods Pro 2 Type-C -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-30%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="AirPods Pro 2" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Chống ồn 2X • Chip H2</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Tai Nghe Apple AirPods Pro 2 Type-C
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">4.890.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">5.690.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Apple 4: Apple Watch Series 10 -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-17%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Apple Watch Series 10" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/kinh-thong-minh.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">GPS 46mm • OLED</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Apple Watch Series 10 Nhôm GPS 46mm
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">9.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">11.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Apple 5: Củ sạc 20W -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-24%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Củ sạc Apple 20W" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/sac-cap.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">PD 20W • Type-C</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Củ Sạc Nhanh Apple 20W Type-C VN/A
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">449.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">590.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <!-- Apple 6: MacBook Air M3 -->
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-gray-900 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-10%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="MacBook Air M3" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/phu-phim-laptop.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Apple M3 • 16GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                MacBook Air 13 inch M3 16GB/256GB
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-gray-900 leading-tight">27.490.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">29.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

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
        
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-18%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="iPad 10.9 Gen 10" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/op-lung-may-tinh-bang.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">10.9 inch • A14 Bionic</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                iPad 10.9 inch Gen 10 WiFi 64GB
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">8.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">10.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-20%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Samsung Galaxy Tab S9 FE" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/but-tablet.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Bút S-Pen • 128GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Samsung Galaxy Tab S9 FE WiFi
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">7.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">9.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-25%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Xiaomi Pad 6" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/op-lung-may-tinh-bang.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">144Hz • Snapdragon 870</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Xiaomi Pad 6 8GB/128GB
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">6.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">8.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-15%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Laptop Asus Vivobook" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/balo-tui-chong-soc.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">Core i5 • OLED FHD</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Laptop Asus Vivobook 15 OLED i5 13500H
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">16.490.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">19.490.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-12%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Lenovo Ideapad Slim 3" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/balo-tui-chong-soc.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">16GB RAM • 512GB</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Lenovo IdeaPad Slim 3 i5 12450H
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">13.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">15.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-blue-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-22%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Màn hình Asus 24 inch" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/gia-treo-man-hinh.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-gray-100 rounded text-[10px] text-secondary font-medium">120Hz • 1ms IPS</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Màn hình Asus VY249HGR 24 inch FHD
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-blue-800 leading-tight">2.390.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">3.190.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

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
        
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-25%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Pin Anker MagGo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/sac-du-phong.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">Qi2 • 15W</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Pin Dự Phòng Anker MagGo Qi2 10.000mAh
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">1.290.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-24%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Kính Mipow Kingbull" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/mieng-dan.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">Chống trộm 9H</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Kính Cường Lực Mipow Kingbull HD IP16
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">319.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">420.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-35%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Loa JBL Clip 4" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/loa.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">Chống nước IP67</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Loa Bluetooth JBL Clip 4 Bass Cực Căng
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">1.090.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">1.690.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-40%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Cáp sạc Baseus Type-C" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/sac-cap.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">PD 100W • Bọc Dù</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Cáp Type-C to Type-C Baseus 100W 1.2m
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">149.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">250.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-30%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Củ sạc Torras 20W" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/sac-cap.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">ICENANO Siêu Nhỏ</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Củ Sạc Nhanh TORRAS ICENANO 20W Kèm Cáp
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">390.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">550.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-amber-500 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-amber-600 text-white text-[10px] font-extrabold shadow-xs">-25%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Ốp lưng MagSafe" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/op-lung-dien-thoai.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-800 rounded text-[10px] font-medium">Chính Hãng Apple</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Ốp Lưng MagSafe Apple iPhone 15 Pro
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-amber-800 leading-tight">1.090.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">1.490.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

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
        
        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-emerald-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-10%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Garmin Fenix 8" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/day-deo-dien-thoai.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-800 rounded text-[10px] font-medium">Titanium • Sapphire</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Garmin Fenix 8 Sapphire 51mm Titanium
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-emerald-800 leading-tight">28.990.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">31.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

        <div class="bg-white rounded-xl p-3 sm:p-3.5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-emerald-600 relative hover:-translate-y-1 duration-200">
          <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50 rounded-lg mb-2 overflow-hidden">
            <span class="absolute top-1.5 left-1.5 z-10 px-1.5 py-0.5 rounded bg-primary text-white text-[10px] font-extrabold shadow-xs">-22%</span>
            <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="Samsung Galaxy Watch 7" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/categories/accessories/kinh-thong-minh.png" loading="lazy"/>
          </div>
          <div class="flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center gap-1 mb-1">
                <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-800 rounded text-[10px] font-medium">Galaxy AI • 40mm</span>
              </div>
              <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-text-main line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors">
                Samsung Galaxy Watch 7 40mm Bluetooth
              </h3>
            </div>
            <div class="mt-2">
              <div class="text-[16px] sm:text-[17px] font-black text-emerald-800 leading-tight">6.190.000₫</div>
              <div class="text-[11px] sm:text-[12px] text-secondary line-through">7.990.000₫</div>
            </div>
          </div>
          <button type="button" class="mt-3 w-full h-8.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-colors">
            Mua Ngay
          </button>
        </div>

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
