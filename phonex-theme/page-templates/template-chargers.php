<?php
/**
 * Template Name: PhoneX Sạc Điện Thoại Di Động & Pin Dự Phòng Chính Hãng
 *
 * Dedicated Mobile Phone Chargers & Power Banks Catalog Page
 *
 * Strictly adheres to:
 * 1. Google Stitch Design System Palette:
 *    - primary: #b7000c
 *    - primary-container: #e60012
 *    - primary-hover: #C90010
 *    - primary-fixed: #ffdad5
 *    - primary-fixed-dim: #ffb4aa
 *    - surface: #f8f9fb
 *    - surface-pure / surface-container-lowest: #ffffff
 *    - surface-container-low: #f2f4f6
 *    - surface-container-high: #e7e8ea
 *    - border-subtle: #E5E7EB
 *    - text-main: #222222
 *    - secondary / text-sub: #5f5e5e
 *    - on-surface: #191c1e
 *    - on-primary: #ffffff
 * 2. PHONEX – UI/UX DESIGN SYSTEM:
 *    - H1: Desktop 32-36px, Tablet 30-32px, Mobile 26-28px (weight 700)
 *    - H2: Desktop 26-28px, Tablet 24-26px, Mobile 22-24px (weight 700)
 *    - H3: Desktop 20-22px, Tablet 20px, Mobile 18-20px (weight 600-700)
 *    - Tên sản phẩm: Desktop 16px, Tablet 16px, Mobile 14-16px (weight 600, min-h-[44px])
 *    - Giá hiện tại: Desktop 20-24px, Tablet 20px, Mobile 18-20px (weight 700)
 *    - Giá cũ: 14px (Mobile 13-14px), 400, gạch ngang
 *    - Input / Form: 16px (chống auto-zoom iOS)
 *    - Button CTA chính ("Mua ngay"): 15-16px / 600, radius 8px, touch target >= 44x44px
 *    - Badge: 11-12px / 600-700, radius 6px
 *    - Hoàn toàn KHÔNG có bất kỳ thông tin nào liên quan đến Thế Giới Di Động ở phía người dùng.
 *    - Chỉ ghi chú trong phần quản trị cho người quản trị hiểu là sản phẩm crawl từ cơ sở dữ liệu.
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD CHARGER DATA FROM LOCAL DATABASE CACHE
// =========================================================================
$json_path = get_template_directory() . '/data/chargers.json';
$crawled_products = array();

if ( file_exists( $json_path ) ) {
	$json_content = file_get_contents( $json_path );
	$crawled_products = json_decode( $json_content, true );
}

if ( empty( $crawled_products ) ) {
	$crawled_products = array();
}

// Brand list for quick filter bar
$brands = array(
	'all'       => 'Tất cả',
	'Anker'     => 'Anker',
	'Samsung'   => 'Samsung',
	'Xiaomi'    => 'Xiaomi',
	'Baseus'    => 'Baseus',
	'Ugreen'    => 'Ugreen',
	'Xmobile'   => 'Xmobile',
	'Innostyle' => 'Innostyle',
	'AVA+'      => 'AVA+',
	'Mazer'     => 'Mazer',
	'AUKEY'     => 'AUKEY',
	'BMX'       => 'BMX',
	'Belkin'    => 'Belkin',
);

// Capacity filter list
$capacities = array(
	'all'        => 'Tất cả dung lượng',
	'10000'      => '10.000 mAh (Phổ thông)',
	'20000'      => '20.000 mAh (Dung lượng lớn)',
	'5000'       => '5.000 mAh (Mỏng nhẹ)',
	'over-20000' => 'Trên 20.000 mAh (Sạc laptop)',
);

$total_crawled = count( $crawled_products );
?>

<!-- =========================================================================
     SCOPED DESIGN SYSTEM STYLES (STITCH TOKENS & TYPOGRAPHY SCALE)
     ========================================================================= -->
<style>
:root {
  /* Google Stitch Color Tokens */
  --px-primary: #b7000c;
  --px-primary-container: #e60012;
  --px-primary-hover: #C90010;
  --px-primary-fixed: #ffdad5;
  --px-primary-fixed-dim: #ffb4aa;
  --px-surface: #f8f9fb;
  --px-surface-pure: #ffffff;
  --px-surface-container-low: #f2f4f6;
  --px-surface-container-high: #e7e8ea;
  --px-border-subtle: #E5E7EB;
  --px-text-main: #222222;
  --px-text-secondary: #5f5e5e;
  --px-on-surface: #191c1e;
  --px-on-primary: #ffffff;
}

/* PHONEX UI/UX DESIGN SYSTEM TYPOGRAPHY CLASSES */
.px-ds-h1 {
  font-size: 26px;
  line-height: 1.25;
  font-weight: 700;
}
@media (min-width: 768px) { .px-ds-h1 { font-size: 30px; } }
@media (min-width: 1024px) { .px-ds-h1 { font-size: 34px; line-height: 1.2; } }

.px-ds-h2 {
  font-size: 22px;
  line-height: 1.35;
  font-weight: 700;
}
@media (min-width: 768px) { .px-ds-h2 { font-size: 24px; } }
@media (min-width: 1024px) { .px-ds-h2 { font-size: 26px; } }

.px-ds-h3 {
  font-size: 18px;
  line-height: 1.35;
  font-weight: 600;
}
@media (min-width: 768px) { .px-ds-h3 { font-size: 20px; } }
@media (min-width: 1024px) { .px-ds-h3 { font-size: 22px; } }

.px-ds-prod-title {
  font-size: 14px;
  line-height: 1.45;
  font-weight: 600;
  color: var(--px-text-main);
  min-height: 44px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
@media (min-width: 768px) {
  .px-ds-prod-title {
    font-size: 16px;
    min-height: 46px;
  }
}

.px-ds-price-primary {
  font-size: 18px;
  line-height: 1.2;
  font-weight: 700;
  color: var(--px-primary-container);
}
@media (min-width: 768px) { .px-ds-price-primary { font-size: 20px; } }
@media (min-width: 1024px) { .px-ds-price-primary { font-size: 22px; } }

.px-ds-price-old {
  font-size: 13px;
  color: var(--px-text-secondary);
  text-decoration: line-through;
  font-weight: 400;
}
@media (min-width: 768px) { .px-ds-price-old { font-size: 14px; } }

.px-ds-body {
  font-size: 16px;
  line-height: 1.6;
  color: var(--px-text-main);
  font-weight: 400;
}

.px-ds-caption {
  font-size: 12px;
  line-height: 1.4;
  color: var(--px-text-secondary);
  font-weight: 400;
}
@media (min-width: 768px) { .px-ds-caption { font-size: 13px; } }

/* Inputs 16px to prevent iOS auto-zoom */
.px-ds-input, .px-ds-select {
  font-size: 16px !important;
  height: 44px;
}

/* Touch targets >= 44x44px */
.px-ds-touch {
  min-height: 44px;
  min-width: 44px;
}

/* Button variants per Design System */
.px-ds-btn-primary {
  min-height: 44px;
  padding: 0 18px;
  font-size: 15px;
  font-weight: 600;
  border-radius: 8px;
  background-color: var(--px-primary-container);
  color: #ffffff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}
.px-ds-btn-primary:hover {
  background-color: var(--px-primary-hover);
}
.px-ds-btn-primary:active {
  transform: scale(0.98);
}

.px-ds-btn-secondary {
  min-height: 44px;
  padding: 0 16px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 8px;
  background-color: #ffffff;
  border: 1px solid var(--px-border-subtle);
  color: var(--px-text-main);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}
.px-ds-btn-secondary:hover {
  background-color: var(--px-surface-container-low);
  border-color: #d1d5db;
}

/* Badge per Design System (11-12px, weight 600-700, radius 6px) */
.px-ds-badge {
  font-size: 11px;
  line-height: 14px;
  font-weight: 700;
  border-radius: 6px;
  padding: 3px 7px;
  letter-spacing: 0.02em;
}
@media (min-width: 768px) {
  .px-ds-badge { font-size: 12px; }
}

/* Product Card (Spacious, airy unibody design - relaxed breathing room) */
.px-prod-card {
  background: #ffffff;
  border: 1px solid var(--px-border-subtle);
  border-radius: 18px;
  padding: 16px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
  position: relative;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}
@media (min-width: 640px) {
  .px-prod-card {
    padding: 20px;
  }
}
.px-prod-card:hover {
  border-color: #ffb4aa;
  box-shadow: 0 16px 32px -6px rgba(0, 0, 0, 0.08), 0 4px 12px -2px rgba(183, 0, 12, 0.04);
  transform: translateY(-4px);
}
.px-prod-card .img-box {
  width: 100%;
  height: 190px;
  border-radius: 14px;
  background-color: #fbfcfd;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  position: relative;
  overflow: hidden;
  margin-bottom: 14px;
}
@media (min-width: 640px) {
  .px-prod-card .img-box {
    height: 215px;
    padding: 20px;
  }
}
.px-prod-card .img-box img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  transition: transform 0.35s ease;
}
.px-prod-card:hover .img-box img {
  transform: scale(1.08);
}

/* Active Chips */
.brand-chip.active {
  background-color: var(--px-primary-fixed);
  border-color: var(--px-primary-container);
  color: var(--px-primary);
  font-weight: 700;
}
.capacity-chip.active {
  background-color: var(--px-primary-container);
  border-color: var(--px-primary-container);
  color: #ffffff;
  font-weight: 700;
}
.feature-tag.active {
  background-color: var(--px-primary-fixed);
  border-color: var(--px-primary-container);
  color: var(--px-primary);
  font-weight: 600;
}
</style>

<div class="bg-[#f8f9fb] min-h-screen text-[#222222] pb-16 font-sans">

  <!-- =========================================================================
       1. BREADCRUMB NAVIGATION (13-14px Desktop, 12-13px Mobile, 400-500)
       ========================================================================= -->
  <div class="bg-white border-b border-[#E5E7EB]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <nav class="flex items-center text-[12px] sm:text-[13px] md:text-[14px] text-[#5f5e5e] font-normal space-x-2 overflow-x-auto whitespace-nowrap">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#b7000c] transition-colors flex items-center gap-1">
          <span class="material-symbols-outlined text-[16px]">home</span>
          <span>Trang chủ</span>
        </a>
        <span class="text-gray-300">/</span>
        <a href="<?php echo esc_url( home_url( '/phu-kien/' ) ); ?>" class="hover:text-[#b7000c] transition-colors">
          Phụ kiện
        </a>
        <span class="text-gray-300">/</span>
        <span class="font-semibold text-[#191c1e]">Sạc điện thoại di động & Pin sạc dự phòng</span>
      </nav>
    </div>
  </div>

  <!-- =========================================================================
       2. MODERN HERO PROMOTIONS GRID (PHONEX DESIGN SYSTEM - 3 COLUMNS)
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <!-- MAIN PROMO CARD (2 COLUMNS - PHONE-X PRIMARY-FIXED HERO) -->
      <div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]" style="background-color: var(--px-primary-fixed);">
        
        <!-- Ambient Glow & Flare Lighting Effects -->
        <div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
          <span class="material-symbols-outlined text-[170px] text-[#b7000c]">battery_charging_full</span>
        </div>

        <div class="relative z-10 max-w-xl">
          <!-- Pill Badge (Pure White with Pulsing Red Dot) -->
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-[#b7000c] text-[11px] sm:text-[12px] font-bold uppercase tracking-wider mb-3.5 shadow-2xs border border-[#ffb4aa]">
            <span class="w-2 h-2 rounded-full bg-[#e60012] animate-pulse"></span>
            <span>PhoneX Flagship • Phụ Kiện Sạc Chính Hãng 100%</span>
          </div>

          <!-- Main Title H1 (High Contrast Dark Slate) -->
          <h1 class="text-[26px] sm:text-[32px] md:text-[36px] font-bold text-[#191c1e] tracking-tight leading-tight mb-3">
            Sạc Nhanh &amp; Pin Sạc Dự Phòng Chính Hãng
          </h1>

          <!-- Subtitle -->
          <p class="text-[14px] sm:text-[15px] text-[#5f5e5e] leading-[1.65] mb-6 font-normal">
            Hệ sinh thái củ sạc GaN siêu nhỏ, pin sạc dự phòng không dây Magnetic Qi2, chuẩn sạc Type-C Power Delivery (PD) công suất cao 20W – 165W từ Anker, Samsung, Xiaomi, Baseus, Ugreen. Cam kết 100% nguyên seal, bảo hành 1 đổi 1 trong 12 tháng.
          </p>

          <!-- 4 Highlights Badges (Clean White Cards) -->
          <div class="grid grid-cols-2 gap-2.5 sm:gap-3 max-w-lg mb-6">
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">bolt</span>
              <span class="truncate">Type-C PD &amp; QC 3.0</span>
            </div>
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">contactless</span>
              <span class="truncate">Magnetic Qi2 Từ Tính</span>
            </div>
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">shield</span>
              <span class="truncate">Lõi Pin LiFePO4 An Toàn</span>
            </div>
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">local_shipping</span>
              <span class="truncate">Giao Hỏa Tốc 1 Giờ</span>
            </div>
          </div>
        </div>

        <!-- CTA & Assurance Footer -->
        <div class="relative z-10 pt-4.5 border-t border-[#ffb4aa]/60 flex flex-wrap items-center justify-between gap-3">
          <div class="flex items-center gap-3 flex-wrap">
            <a href="#chargersGrid" class="min-h-[46px] px-6 rounded-xl bg-[#e60012] hover:bg-[#C90010] text-white font-bold text-[14px] sm:text-[15px] inline-flex items-center gap-2 shadow-md transition-all cursor-pointer hover:scale-102">
              <span>Xem <?php echo esc_html( $total_crawled ); ?> sản phẩm</span>
              <span class="material-symbols-outlined text-[18px]">arrow_downward</span>
            </a>
            <span class="text-[12px] sm:text-[13px] text-emerald-800 font-medium flex items-center gap-1.5 bg-white/80 px-3 py-2 rounded-lg border border-emerald-200/60 shadow-2xs">
              <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
              <span>Đổi mới 30 ngày nếu lỗi</span>
            </span>
          </div>
          <span class="text-[12px] text-[#b7000c] font-mono tracking-wider font-semibold uppercase">100% Nguyên Seal</span>
        </div>

      </div>

      <!-- RIGHT 2 SUB-BANNERS (1 COLUMN - STACKED) -->
      <div class="flex flex-col gap-4">
        
        <!-- Sub-banner 1: Độc quyền PhoneX -->
        <div class="rounded-2xl p-5 sm:p-6 bg-gradient-to-br from-[#b7000c] to-[#e60012] text-white flex items-center justify-between shadow-xs relative overflow-hidden flex-1">
          <div class="relative z-10 pr-2">
            <div class="text-[11px] sm:text-[12px] font-bold uppercase text-[#ffdad5] tracking-wider mb-1">
              Độc Quyền PhoneX
            </div>
            <div class="text-[17px] sm:text-[18px] font-bold text-white leading-snug">
              Bảo Hành 1 Đổi 1 Trong 12T
            </div>
            <div class="text-[13px] text-[#ffdad5]/90 mt-1 font-normal">
              Lỗi phần cứng đổi ngay sản phẩm mới
            </div>
          </div>
          <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xs flex items-center justify-center shrink-0 border border-white/20">
            <span class="material-symbols-outlined text-[32px] text-[#ffdad5]">verified</span>
          </div>
        </div>

        <!-- Sub-banner 2: Giao Hỏa Tốc -->
        <div class="rounded-2xl p-5 sm:p-6 border border-[#ffb4aa] text-[#1F1F1F] flex items-center justify-between shadow-xs relative overflow-hidden flex-1" style="background-color: var(--px-primary-fixed, #FFF0F2);">
          <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>
          <div class="relative z-10 pr-2">
            <div class="text-[11px] sm:text-[12px] font-bold uppercase text-[#00875A] tracking-wider mb-1 flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-[#00875A] animate-pulse"></span>
              <span>Giao Nhanh Siêu Tốc</span>
            </div>
            <div class="text-[17px] sm:text-[18px] font-bold text-[#1F1F1F] leading-snug">
              Giao Hỏa Tốc 1 Giờ
            </div>
            <div class="text-[13px] text-gray-700 mt-1 font-medium">
              Đồng kiểm hàng tận nơi trước khi thanh toán
            </div>
          </div>
          <div class="relative z-10 w-14 h-14 rounded-2xl bg-white border border-[#ffb4aa]/60 flex items-center justify-center shrink-0 shadow-2xs">
            <span class="material-symbols-outlined text-[32px] text-[#FF001F]">local_shipping</span>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- =========================================================================
       3. UNIFIED FILTER & SEARCH SECTION (CLEAN, AIRY & INTUITIVE)
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 space-y-4">
    
    <!-- Top Filter Card: Brands & Specs -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 sm:p-6 shadow-2xs">
      
      <!-- Row 1: Brand Filter -->
      <div class="mb-5 pb-4 border-b border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">branding_watermark</span>
            <h3 class="font-bold text-[14px] sm:text-[15px] text-[#191c1e]">Thương hiệu hàng đầu:</h3>
          </div>
          <span class="text-[12px] text-[#5f5e5e] hidden sm:inline">Chọn thương hiệu để lọc nhanh</span>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1.5 scrollbar-none" id="brandFilterContainer">
          <?php foreach ( $brands as $b_key => $b_label ) : ?>
            <button type="button"
                    data-brand="<?php echo esc_attr( $b_key ); ?>"
                    class="brand-chip px-ds-touch px-4 py-2 rounded-xl border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] font-medium text-[#222222] hover:border-[#b7000c] hover:text-[#b7000c] transition-all shrink-0 cursor-pointer <?php echo ( 'all' === $b_key ) ? 'active' : ''; ?>">
              <?php echo esc_html( $b_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Row 2: Capacity & Features -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Dung lượng -->
        <div>
          <div class="flex items-center gap-2 mb-2.5">
            <span class="material-symbols-outlined text-[#e60012] text-[18px]">battery_charging_full</span>
            <span class="font-bold text-[13px] sm:text-[14px] text-[#191c1e]">Dung lượng pin:</span>
          </div>
          <div class="flex flex-wrap gap-2" id="capacityFilterContainer">
            <?php foreach ( $capacities as $cap_key => $cap_label ) : ?>
              <button type="button"
                      data-cap="<?php echo esc_attr( $cap_key ); ?>"
                      class="capacity-chip px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-[#f8f9fb] text-[13px] sm:text-[14px] font-medium text-[#222222] hover:border-gray-400 transition-all cursor-pointer <?php echo ( 'all' === $cap_key ) ? 'active' : ''; ?>">
                <?php echo esc_html( $cap_label ); ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Tính năng & Tiện ích -->
        <div>
          <div class="flex items-center gap-2 mb-2.5">
            <span class="material-symbols-outlined text-[#e60012] text-[18px]">tune</span>
            <span class="font-bold text-[13px] sm:text-[14px] text-[#191c1e]">Tính năng &amp; Tiện ích:</span>
          </div>
          <div class="flex flex-wrap gap-2" id="featureTagContainer">
            <button type="button" data-feature="magnetic" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Sạc không dây Qi2 / Magnetic
            </button>
            <button type="button" data-feature="pd" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Sạc nhanh Type-C PD
            </button>
            <button type="button" data-feature="high-watt" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Công suất ≥ 45W
            </button>
            <button type="button" data-feature="safe-core" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Pin an toàn LiFePO4
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Bottom Toolbar: Search, Price, Sort & Status -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-4 sm:p-5 shadow-2xs">
      <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">

        <!-- Search Bar (16px font size to prevent iOS zoom) -->
        <div class="relative flex-1 max-w-md">
          <input type="text"
                 id="chargerSearchInput"
                 placeholder="Tìm theo tên sản phẩm, hãng (Anker, Samsung), công suất..."
                 class="px-ds-input w-full pl-10 pr-4 py-2.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl text-[#222222] placeholder-gray-400 focus:outline-hidden focus:border-[#b7000c] focus:bg-white transition-colors" />
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
          <button type="button" id="clearSearchBtn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <span class="material-symbols-outlined text-[18px]">cancel</span>
          </button>
        </div>

        <!-- Controls: Price range & Sort -->
        <div class="flex flex-wrap items-center gap-3">
          
          <!-- Price Range Select -->
          <div class="flex items-center gap-1.5">
            <span class="text-[13px] sm:text-[14px] font-semibold text-[#5f5e5e] whitespace-nowrap">Mức giá:</span>
            <select id="priceFilterSelect" class="px-ds-select px-ds-touch bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl px-3.5 py-2 text-[13px] sm:text-[14px] font-medium text-[#222222] focus:outline-hidden focus:border-[#b7000c] cursor-pointer">
              <option value="all">Tất cả mức giá</option>
              <option value="under-300k">Dưới 300.000₫</option>
              <option value="300k-600k">300.000₫ - 600.000₫</option>
              <option value="600k-1m">600.000₫ - 1.000.000₫</option>
              <option value="over-1m">Trên 1.000.000₫</option>
            </select>
          </div>

          <!-- Sort Select -->
          <div class="flex items-center gap-1.5">
            <span class="text-[13px] sm:text-[14px] font-semibold text-[#5f5e5e] whitespace-nowrap">Sắp xếp:</span>
            <select id="sortFilterSelect" class="px-ds-select px-ds-touch bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl px-3.5 py-2 text-[13px] sm:text-[14px] font-medium text-[#222222] focus:outline-hidden focus:border-[#b7000c] cursor-pointer">
              <option value="featured">Nổi bật / Bán chạy</option>
              <option value="price-asc">Giá thấp đến cao</option>
              <option value="price-desc">Giá cao đến thấp</option>
              <option value="discount-desc">% Giảm giá nhiều nhất</option>
              <option value="capacity-desc">Dung lượng pin lớn nhất</option>
            </select>
          </div>

          <!-- Reset Filter Button -->
          <button type="button" id="resetAllFiltersBtn" class="hidden px-ds-touch px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-[13px] sm:text-[14px] font-semibold text-[#5f5e5e] hover:text-[#222222] transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-[16px] mr-1">refresh</span>
            <span>Đặt lại</span>
          </button>

        </div>

      </div>

      <!-- Active Filter Status & Product Counter -->
      <div class="mt-3.5 pt-3.5 border-t border-[#E5E7EB] flex flex-wrap items-center justify-between text-[13px] sm:text-[14px] text-[#5f5e5e] gap-2">
        <div>
          <span>Đang hiển thị: </span>
          <strong id="resultsCount" class="text-[#b7000c] font-bold"><?php echo esc_html( $total_crawled ); ?></strong>
          <span> / <?php echo esc_html( $total_crawled ); ?> sản phẩm sạc &amp; pin dự phòng PhoneX</span>
        </div>
        <div class="flex items-center gap-1.5 text-[12px] sm:text-[13px] text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/60">
          <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
          <span>100% Sản phẩm chính hãng • Bảo hành 1 đổi 1 trong 12 tháng</span>
        </div>
      </div>
    </div>

  </div>

  <!-- =========================================================================
       4. PRODUCT CATALOG GRID SECTION (SPACIOUS & AIRY)
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">

    <!-- Catalog Section Title -->
    <div class="flex items-center justify-between mb-5">
      <h2 class="text-[20px] sm:text-[22px] md:text-[24px] font-bold text-[#191c1e] flex items-center gap-2">
        <span class="material-symbols-outlined text-[#e60012] text-[24px]">grid_view</span>
        <span>Danh Sách Sản Phẩm Sạc &amp; Pin Dự Phòng</span>
      </h2>
      <span class="text-[13px] text-[#5f5e5e]">Giao hỏa tốc 1 giờ &bull; Đổi trả 30 ngày</span>
    </div>

    <!-- Empty State Message -->
    <div id="noProductsFound" class="hidden bg-white rounded-2xl border border-[#E5E7EB] p-12 text-center my-6 shadow-2xs">
      <span class="material-symbols-outlined text-gray-300 text-6xl mb-3">search_off</span>
      <h3 class="px-ds-h3 text-[#222222] mb-2">Không tìm thấy sản phẩm sạc phù hợp</h3>
      <p class="text-[#5f5e5e] text-[14px] max-w-md mx-auto mb-6">
        Hãy thử điều chỉnh bộ lọc thương hiệu, dung lượng pin hoặc mức giá để tìm kiếm sản phẩm phù hợp.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-ds-btn-primary px-6 py-2.5 rounded-lg cursor-pointer shadow-sm">
        Xóa tất cả bộ lọc
      </button>
    </div>

    <!-- Product Grid (Spacious 4-column layout with generous breathing room) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-7" id="chargersGrid">
      <?php
      if ( ! empty( $crawled_products ) ) :
        foreach ( $crawled_products as $idx => $prod ) :
          $name        = $prod['product_name'];
          $price       = $prod['current_price'];
          $price_num   = (int) $prod['current_price_num'];
          $old_price   = $prod['old_price'];
          $old_num     = (int) $prod['old_price_num'];
          $brand       = $prod['brand'];
          $model       = $prod['model'];
          $capacity    = $prod['capacity'];
          $specs       = is_array( $prod['specs'] ) ? $prod['specs'] : array();
          $updated_at  = $prod['updated_at'];
          $image       = $prod['image'];
          $img_src     = ( ! empty( $image ) && strpos( $image, 'http' ) === 0 ) ? $image : get_template_directory_uri() . '/' . ltrim( $image, '/' );

          // Calculate Discount %
          $discount_pct = 0;
          if ( $old_num > $price_num && $old_num > 0 ) {
            $discount_pct = round( ( ( $old_num - $price_num ) / $old_num ) * 100 );
          }

          // Format numeric capacity for filter
          $cap_digits = (int) preg_replace( '/[^\d]/', '', $capacity );
          ?>
          <div class="px-prod-card charger-item"
               data-id="<?php echo esc_attr( $idx ); ?>"
               data-brand="<?php echo esc_attr( $brand ); ?>"
               data-capacity="<?php echo esc_attr( $cap_digits ); ?>"
               data-price="<?php echo esc_attr( $price_num ); ?>"
               data-discount="<?php echo esc_attr( $discount_pct ); ?>"
               data-name="<?php echo esc_attr( mb_strtolower( $name, 'UTF-8' ) ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode( ' ', $specs ), 'UTF-8' ) ); ?>"
               data-model="<?php echo esc_attr( $model ); ?>"
               style="<?php echo ( $idx >= 20 ) ? 'display: none;' : ''; ?>">

            <!-- TOP BADGES: Discount % & Highlight -->
            <div class="absolute top-2.5 left-2.5 right-2.5 z-10 flex items-center justify-between pointer-events-none">
              <?php if ( $discount_pct > 0 ) : ?>
                <span class="px-ds-badge bg-[#e60012] text-white shadow-xs">
                  -<?php echo esc_html( $discount_pct ); ?>%
                </span>
              <?php else : ?>
                <span class="px-ds-badge bg-gray-800 text-white">Chính hãng</span>
              <?php endif; ?>

              <?php if ( strpos( $name, 'Magnetic' ) !== false || strpos( $name, 'Qi2' ) !== false ) : ?>
                <span class="px-ds-badge bg-[#ffdad5] text-[#b7000c] border border-[#ffb4aa]">
                  Qi2 Từ tính
                </span>
              <?php elseif ( $cap_digits >= 20000 ) : ?>
                <span class="px-ds-badge bg-white/95 text-blue-700 border border-blue-200 shadow-2xs">
                  20.000 mAh
                </span>
              <?php endif; ?>
            </div>

            <!-- PRODUCT IMAGE (Spacious, airy thumbnail container) -->
            <div class="img-box cursor-pointer" onclick="openSpecModal(<?php echo esc_attr( $idx ); ?>)">
              <?php if ( ! empty( $img_src ) ) : ?>
                <img src="<?php echo esc_url( $img_src ); ?>"
                     alt="<?php echo esc_attr( $name ); ?>"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='<?php echo esc_url( get_template_directory_uri() . '/assets/images/categories/accessories/sac-du-phong.png' ); ?>';" />
              <?php else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/categories/accessories/sac-du-phong.png' ); ?>"
                     alt="<?php echo esc_attr( $name ); ?>" />
              <?php endif; ?>
            </div>

            <!-- PRODUCT DETAILS (Unibody without dense divider lines) -->
            <div class="flex flex-col flex-1 justify-between">
              <div>
                <!-- 1. Brand & Capacity -->
                <div class="flex items-center justify-between gap-2 mb-1.5">
                  <span class="text-[11px] sm:text-[12px] font-bold text-gray-500 uppercase tracking-wider truncate">
                    <?php echo esc_html( $brand ); ?>
                  </span>
                  <?php if ( ! empty( $capacity ) && 'N/A' !== $capacity ) : ?>
                    <span class="text-[11px] sm:text-[12px] font-semibold text-[#191c1e] bg-[#f2f4f6] px-2 py-0.5 rounded-[4px] shrink-0">
                      <?php echo esc_html( $capacity ); ?>
                    </span>
                  <?php endif; ?>
                </div>

                <!-- 2. Product Title -->
                <h4 class="text-[14px] sm:text-[15px] font-semibold text-[#191c1e] hover:text-[#b7000c] transition-colors cursor-pointer line-clamp-2 min-h-[44px] leading-snug mb-2"
                    title="<?php echo esc_attr( $name ); ?>"
                    onclick="openSpecModal(<?php echo esc_attr( $idx ); ?>)">
                  <?php echo esc_html( $name ); ?>
                </h4>

                <!-- 3. Specs Pill -->
                <?php if ( ! empty( $specs ) ) : ?>
                  <div class="mb-3">
                    <span class="inline-flex items-center gap-1 text-[11px] sm:text-[12px] bg-[#f8f9fb] border border-[#E5E7EB] text-[#5f5e5e] px-2.5 py-1 rounded-[6px] font-normal truncate max-w-full" title="<?php echo esc_attr( implode( ' • ', $specs ) ); ?>">
                      <span class="material-symbols-outlined text-[14px] text-[#e60012]">bolt</span>
                      <span><?php echo esc_html( $specs[0] ); ?></span>
                    </span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- 4. Price, Assurance & Actions -->
              <div class="mt-2">
                <div class="flex items-baseline gap-2 flex-wrap mb-2.5">
                  <span class="text-[19px] sm:text-[21px] md:text-[22px] font-bold text-[#e60012] leading-tight">
                    <?php echo esc_html( $price ); ?>
                  </span>
                  <?php if ( $discount_pct > 0 ) : ?>
                    <span class="px-ds-price-old">
                      <?php echo esc_html( $old_price ); ?>
                    </span>
                  <?php endif; ?>
                </div>

                <div class="flex items-center justify-between text-[11px] sm:text-[12px] text-[#5f5e5e] mb-3.5">
                  <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                    <span class="material-symbols-outlined text-[15px]">verified</span>
                    <span>Bảo hành 12T 1 đổi 1</span>
                  </span>
                  <span class="inline-flex items-center gap-1 text-gray-500">
                    <span class="material-symbols-outlined text-[15px] text-[#e60012]">local_shipping</span>
                    <span>Giao 1H</span>
                  </span>
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                  <button type="button"
                          onclick="handleQuickBuy(<?php echo esc_attr( $idx ); ?>)"
                          class="w-full h-10 rounded-lg bg-[#e60012] hover:bg-[#C90010] text-white font-bold text-[13px] sm:text-[14px] shadow-xs flex items-center justify-center gap-1.5 transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[17px]">shopping_bag</span>
                    <span>Đặt mua ngay</span>
                  </button>
                  <button type="button"
                          onclick="openSpecModal(<?php echo esc_attr( $idx ); ?>)"
                          class="w-full h-9 rounded-lg border border-[#E5E7EB] bg-[#f8f9fb] hover:bg-[#ffdad5] text-[#222222] hover:text-[#b7000c] text-[12px] sm:text-[13px] font-semibold transition-colors cursor-pointer flex items-center justify-center gap-1.5 shrink-0"
                          title="Xem thông số kỹ thuật chi tiết">
                    <span class="material-symbols-outlined text-[16px] text-[#e60012]">info</span>
                    <span>Xem chi tiết</span>
                  </button>
                </div>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- =========================================================================
         7. "XEM THÊM" PAGINATION BUTTON (MATCHING PHONEX DESIGN SYSTEM)
         ========================================================================= -->
    <div class="mt-8 text-center" id="loadMoreWrap">
      <button type="button"
              id="loadMoreBtn"
              class="px-ds-touch inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white border border-[#b7000c] text-[#b7000c] hover:bg-[#ffdad5] rounded-xl font-bold text-[14px] sm:text-[15px] transition-all shadow-sm cursor-pointer">
        <span class="material-symbols-outlined text-[20px]">expand_more</span>
        <span>Xem thêm <span id="loadMoreRemainingCount"><?php echo esc_html( max( 0, $total_crawled - 20 ) ); ?></span> sản phẩm sạc</span>
      </button>
    </div>

  </div>

  <!-- =========================================================================
       8. MODAL XEM CHI TIẾT THÔNG SỐ (PHONEX SPEC MODAL - TOUCH FRIENDLY)
       ========================================================================= -->
  <div id="specModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-[#E5E7EB] p-6 relative">
      
      <!-- Close Button -->
      <button type="button"
              onclick="closeSpecModal()"
              class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors cursor-pointer">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>

      <!-- Modal Content Header -->
      <div class="flex items-center gap-2 text-[12px] font-bold text-[#b7000c] uppercase tracking-wider mb-2">
        <span class="material-symbols-outlined text-[16px]">verified</span>
        <span>Hồ Sơ Kỹ Thuật Sản Phẩm PhoneX</span>
      </div>

      <h3 id="modalTitle" class="px-ds-h3 text-[#222222] mb-4 leading-snug"></h3>

      <!-- Modal Image -->
      <div class="w-full h-48 bg-[#f8f9fb] rounded-xl mb-4 p-4 flex items-center justify-center">
        <img id="modalImg" src="" alt="" class="max-h-full max-w-full object-contain" />
      </div>

      <!-- Key Specs List -->
      <div class="space-y-2.5 mb-6 text-[14px]">
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Hãng sản xuất:</span>
          <strong id="modalBrand" class="text-[#222222] font-semibold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Model sản phẩm:</span>
          <strong id="modalModel" class="text-[#222222] font-semibold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Dung lượng danh định:</span>
          <strong id="modalCapacity" class="text-[#b7000c] font-bold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Giá bán ưu đãi PhoneX:</span>
          <strong id="modalPrice" class="text-[#b7000c] font-bold text-[18px]"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Giá niêm yết:</span>
          <span id="modalOldPrice" class="text-[#5f5e5e] line-through"></span>
        </div>
        <div class="py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e] block mb-1.5 font-medium">Thông số kỹ thuật chi tiết:</span>
          <ul id="modalSpecsList" class="space-y-1 pl-4 list-disc text-[#222222]"></ul>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB] text-[12px]">
          <span class="text-[#5f5e5e]">Chính sách bảo hành:</span>
          <span class="text-emerald-700 font-semibold">1 Đổi 1 trong 12 tháng tại 128 Showroom</span>
        </div>
      </div>

      <!-- Direct Purchase CTA inside Modal -->
      <div class="grid grid-cols-2 gap-3 mb-3">
        <button type="button"
                id="modalBuyNowBtn"
                class="px-ds-btn-primary w-full py-3 text-center font-bold text-[15px] cursor-pointer shadow-sm">
          Đặt mua ngay
        </button>
        <button type="button"
                id="modalAddCartBtn"
                class="px-ds-btn-secondary w-full py-3 text-center font-bold text-[14px] cursor-pointer">
          Thêm vào giỏ
        </button>
      </div>

      <button type="button"
              onclick="closeSpecModal()"
              class="w-full px-ds-touch py-2.5 rounded-lg border border-[#E5E7EB] bg-gray-50 hover:bg-gray-100 text-[#5f5e5e] font-semibold text-[13px] transition-colors cursor-pointer text-center">
        Đóng cửa sổ
      </button>

    </div>
  </div>

  <!-- =========================================================================
       9. SEO & BUYING GUIDE SECTION (CHUẨN CHUYÊN MÔN PHONEX)
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-2xs">
      
      <div class="border-b border-[#E5E7EB] pb-4 mb-6">
        <div class="inline-flex items-center gap-2 text-[#b7000c] font-bold text-[12px] uppercase tracking-wider mb-1">
          <span class="material-symbols-outlined text-[18px]">verified</span>
          <span>Cẩm nang kiến thức công nghệ sạc PhoneX</span>
        </div>
        <h2 class="px-ds-h2">
          Kinh Nghiệm Chọn Mua Sạc Điện Thoại Di Động & Pin Dự Phòng An Toàn, Tiết Kiệm
        </h2>
      </div>

      <div class="prose max-w-none text-[#222222] text-[15px] sm:text-[16px] leading-[1.6] space-y-4 font-normal">
        <p>
          Trong thời đại smartphone trở thành thiết bị không thể thiếu trong công việc và cuộc sống hàng ngày, một bộ <strong>củ sạc nhanh</strong> và <strong>pin sạc dự phòng chính hãng</strong> chất lượng cao đóng vai trò quyết định đến độ bền pin cũng như an toàn phòng chống cháy nổ cho người sử dụng.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6 not-prose">
          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">bolt</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Công nghệ Power Delivery (PD)</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Chuẩn sạc nhanh qua cổng USB-C phổ biến nhất hiện nay trên iPhone (12–16 Series), Samsung Galaxy, iPad và MacBook. Tự điều chỉnh dòng điện tối ưu từ 20W đến 100W+.
            </p>
          </div>

          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">contactless</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Chuẩn sạc Qi2 Magnetic</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Thế hệ sạc không dây từ tính mới nhất với vòng nam châm định vị chính xác lưng máy, công suất sạc nhanh 15W–25W không lo trượt máy, cực kỳ tiện lợi khi di chuyển.
            </p>
          </div>

          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">shield</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Lõi pin an toàn chống nổ</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Lõi pin Lithium-Polymer (Li-Po) và Lithium Iron Phosphate (LiFePO4) chống phồng pin, hạn chế tối đa nguy cơ quá nhiệt, đoản mạch và chập cháy khi sạc qua đêm.
            </p>
          </div>
        </div>

        <h3 class="px-ds-h3 pt-2">Tiêu chí vàng khi chọn pin sạc dự phòng:</h3>
        <ul class="list-disc pl-5 space-y-2 text-[#5f5e5e]">
          <li><strong>Dung lượng 5.000 mAh:</strong> Thích hợp cho nhu cầu siêu mỏng nhẹ, mang theo túi áo, sạc khẩn cấp thêm khoảng 1 lần cho smartphone.</li>
          <li><strong>Dung lượng 10.000 mAh:</strong> Lựa chọn phổ thông nhất (chiếm 60% thị phần), sạc được 2 – 3 lần cho smartphone, kích thước vừa vặn trong lòng bàn tay.</li>
          <li><strong>Dung lượng 20.000 mAh trở lên:</strong> Dành cho người đi công tác, du lịch, hoặc người dùng sạc cùng lúc cả điện thoại, tai nghe và tablet/laptop.</li>
          <li><strong>Hãng sản xuất uy tín:</strong> Ưu tiên các thương hiệu có kiểm định nghiêm ngặt như <em>Anker, Samsung, Xiaomi, Baseus, Ugreen, Innostyle, Xmobile, Belkin</em> được phân phối chính hãng.</li>
        </ul>

        <div class="bg-[#f8f9fb] border-l-4 border-[#b7000c] p-4 rounded-r-xl mt-4">
          <p class="text-[14px] sm:text-[15px] font-medium text-[#222222]">
            <strong>Cam kết PhoneX:</strong> Tất cả sản phẩm sạc cáp và pin sạc dự phòng phân phối tại PhoneX đều là hàng chính hãng 100%, bảo hành 1 đổi 1 trong vòng 12 đến 24 tháng, cam kết đền tiền gấp đôi nếu phát hiện hàng giả, hàng nhái.
          </p>
        </div>
      </div>

    </div>
  </div>

</div>

<!-- =========================================================================
     10. JAVASCRIPT LOGIC (CLIENT-SIDE FILTER, SEARCH, SORT & PURCHASE ACTIONS)
     ========================================================================= -->
<script>
  // Products Dataset (Sanitized for pure PhoneX frontend - no external source URLs)
  <?php
  $frontend_clean_products = array();
  foreach ( $crawled_products as $cp ) {
      $item_copy = $cp;
      unset( $item_copy['source_url'] );
      unset( $item_copy['image_remote'] );
      if ( ! empty( $item_copy['image'] ) && strpos( $item_copy['image'], 'http' ) !== 0 ) {
          $item_copy['image'] = get_template_directory_uri() . '/' . ltrim( $item_copy['image'], '/' );
      }
      $frontend_clean_products[] = $item_copy;
  }
  ?>
(function() {
  const rawProducts = <?php echo wp_json_encode( $frontend_clean_products ); ?>;
  
  // DOM Elements
  const grid = document.getElementById('chargersGrid');
  const items = Array.from(document.querySelectorAll('.charger-item'));
  const brandChips = document.querySelectorAll('.brand-chip');
  const capacityChips = document.querySelectorAll('.capacity-chip');
  const featureTags = document.querySelectorAll('.feature-tag');
  const searchInput = document.getElementById('chargerSearchInput');
  const clearSearchBtn = document.getElementById('clearSearchBtn');
  const priceSelect = document.getElementById('priceFilterSelect');
  const sortSelect = document.getElementById('sortFilterSelect');
  const resetBtn = document.getElementById('resetAllFiltersBtn');
  const resultsCount = document.getElementById('resultsCount');
  const noProductsMsg = document.getElementById('noProductsFound');
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const loadMoreWrap = document.getElementById('loadMoreWrap');
  const loadMoreRemaining = document.getElementById('loadMoreRemainingCount');

  // Modal Elements
  const modal = document.getElementById('specModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalImg = document.getElementById('modalImg');
  const modalBrand = document.getElementById('modalBrand');
  const modalModel = document.getElementById('modalModel');
  const modalCapacity = document.getElementById('modalCapacity');
  const modalPrice = document.getElementById('modalPrice');
  const modalOldPrice = document.getElementById('modalOldPrice');
  const modalSpecsList = document.getElementById('modalSpecsList');
  const modalBuyNowBtn = document.getElementById('modalBuyNowBtn');
  const modalAddCartBtn = document.getElementById('modalAddCartBtn');

  // Active filter state
  let currentBrand = 'all';
  let currentCapacity = 'all';
  let activeFeatures = new Set();
  let currentPrice = 'all';
  let currentSort = 'featured';
  let searchQuery = '';
  let visibleLimit = 20;
  let activeProductIndex = null;

  // Initialize Event Listeners
  brandChips.forEach(btn => {
    btn.addEventListener('click', () => {
      brandChips.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentBrand = btn.getAttribute('data-brand') || 'all';
      visibleLimit = 20;
      applyFilters();
    });
  });

  capacityChips.forEach(btn => {
    btn.addEventListener('click', () => {
      capacityChips.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentCapacity = btn.getAttribute('data-cap') || 'all';
      visibleLimit = 20;
      applyFilters();
    });
  });

  featureTags.forEach(btn => {
    btn.addEventListener('click', () => {
      const feat = btn.getAttribute('data-feature');
      if (activeFeatures.has(feat)) {
        activeFeatures.delete(feat);
        btn.classList.remove('active');
      } else {
        activeFeatures.add(feat);
        btn.classList.add('active');
      }
      visibleLimit = 20;
      applyFilters();
    });
  });

  searchInput.addEventListener('input', (e) => {
    searchQuery = (e.target.value || '').trim().toLowerCase();
    if (searchQuery.length > 0) {
      clearSearchBtn.classList.remove('hidden');
    } else {
      clearSearchBtn.classList.add('hidden');
    }
    visibleLimit = 20;
    applyFilters();
  });

  clearSearchBtn.addEventListener('click', () => {
    searchInput.value = '';
    searchQuery = '';
    clearSearchBtn.classList.add('hidden');
    applyFilters();
  });

  priceSelect.addEventListener('change', (e) => {
    currentPrice = e.target.value;
    visibleLimit = 20;
    applyFilters();
  });

  sortSelect.addEventListener('change', (e) => {
    currentSort = e.target.value;
    applyFilters();
  });

  resetBtn.addEventListener('click', resetAllFilters);

  loadMoreBtn.addEventListener('click', () => {
    visibleLimit += 20;
    renderVisible();
  });

  function resetAllFilters() {
    currentBrand = 'all';
    currentCapacity = 'all';
    activeFeatures.clear();
    currentPrice = 'all';
    currentSort = 'featured';
    searchQuery = '';
    visibleLimit = 20;

    searchInput.value = '';
    clearSearchBtn.classList.add('hidden');
    priceSelect.value = 'all';
    sortSelect.value = 'featured';

    brandChips.forEach(b => {
      if (b.getAttribute('data-brand') === 'all') b.classList.add('active');
      else b.classList.remove('active');
    });

    capacityChips.forEach(b => {
      if (b.getAttribute('data-cap') === 'all') b.classList.add('active');
      else b.classList.remove('active');
    });

    featureTags.forEach(b => b.classList.remove('active'));

    applyFilters();
  }
  window.resetAllFilters = resetAllFilters;

  // Filter & Sort Logic
  function applyFilters() {
    let matched = [];

    items.forEach(el => {
      const b = el.getAttribute('data-brand') || '';
      const cap = parseInt(el.getAttribute('data-capacity') || '0', 10);
      const p = parseInt(el.getAttribute('data-price') || '0', 10);
      const name = el.getAttribute('data-name') || '';
      const specs = el.getAttribute('data-specs') || '';

      let pass = true;

      // 1. Brand filter
      if (currentBrand !== 'all') {
        if (b.toLowerCase() !== currentBrand.toLowerCase()) pass = false;
      }

      // 2. Capacity filter
      if (pass && currentCapacity !== 'all') {
        if (currentCapacity === '10000' && (cap < 9000 || cap > 12000)) pass = false;
        else if (currentCapacity === '20000' && (cap < 19000 || cap > 22000)) pass = false;
        else if (currentCapacity === '5000' && cap > 6000) pass = false;
        else if (currentCapacity === 'over-20000' && cap <= 22000) pass = false;
      }

      // 3. Features
      if (pass && activeFeatures.size > 0) {
        if (activeFeatures.has('magnetic') && !name.includes('magnetic') && !name.includes('qi2') && !name.includes('không dây')) pass = false;
        if (activeFeatures.has('pd') && !name.includes('type c') && !name.includes('pd')) pass = false;
        if (activeFeatures.has('high-watt') && !specs.includes('45w') && !specs.includes('55w') && !specs.includes('65w') && !specs.includes('130w') && !specs.includes('165w')) pass = false;
        if (activeFeatures.has('safe-core') && !name.includes('lifepo4') && !name.includes('solid-state')) pass = false;
      }

      // 4. Price range
      if (pass && currentPrice !== 'all') {
        if (currentPrice === 'under-300k' && p >= 300000) pass = false;
        else if (currentPrice === '300k-600k' && (p < 300000 || p >= 600000)) pass = false;
        else if (currentPrice === '600k-1m' && (p < 600000 || p >= 1000000)) pass = false;
        else if (currentPrice === 'over-1m' && p < 1000000) pass = false;
      }

      // 5. Search query
      if (pass && searchQuery.length > 0) {
        if (!name.includes(searchQuery) && !b.toLowerCase().includes(searchQuery) && !specs.includes(searchQuery)) {
          pass = false;
        }
      }

      if (pass) {
        matched.push(el);
      } else {
        el.style.display = 'none';
      }
    });

    // Sort matched
    if (currentSort === 'price-asc') {
      matched.sort((a, b) => parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price')));
    } else if (currentSort === 'price-desc') {
      matched.sort((a, b) => parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price')));
    } else if (currentSort === 'discount-desc') {
      matched.sort((a, b) => parseInt(b.getAttribute('data-discount')) - parseInt(a.getAttribute('data-discount')));
    } else if (currentSort === 'capacity-desc') {
      matched.sort((a, b) => parseInt(b.getAttribute('data-capacity')) - parseInt(a.getAttribute('data-capacity')));
    }

    // Re-append sorted elements
    matched.forEach(el => grid.appendChild(el));

    // Store matched for pagination
    window._matchedItems = matched;

    // Update Counter
    if (resultsCount) resultsCount.textContent = matched.length;

    // Reset button visibility
    const isFiltered = (currentBrand !== 'all' || currentCapacity !== 'all' || activeFeatures.size > 0 || currentPrice !== 'all' || currentSort !== 'featured' || searchQuery.length > 0);
    if (resetBtn) {
      if (isFiltered) resetBtn.classList.remove('hidden');
      else resetBtn.classList.add('hidden');
    }

    renderVisible();
  }

  function renderVisible() {
    const matched = window._matchedItems || items;
    const totalMatched = matched.length;

    if (totalMatched === 0) {
      grid.classList.add('hidden');
      noProductsMsg.classList.remove('hidden');
      loadMoreWrap.classList.add('hidden');
      return;
    }

    grid.classList.remove('hidden');
    noProductsMsg.classList.add('hidden');

    matched.forEach((el, idx) => {
      if (idx < visibleLimit) {
        el.style.display = 'flex';
      } else {
        el.style.display = 'none';
      }
    });

    // Check load more visibility
    const remaining = totalMatched - visibleLimit;
    if (remaining > 0) {
      loadMoreWrap.classList.remove('hidden');
      if (loadMoreRemaining) loadMoreRemaining.textContent = remaining;
    } else {
      loadMoreWrap.classList.add('hidden');
    }
  }

  // Quick Buy Action
  function handleQuickBuy(idx) {
    const prod = rawProducts[idx];
    if (!prod) return;
    
    // Smooth Notification & Redirect to Cart/Checkout
    const cartUrl = '<?php echo esc_url( home_url( '/shop/cart/' ) ); ?>';
    
    // Add visual feedback
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 right-6 z-50 bg-[#191c1e] text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3 text-sm animate-bounce';
    toast.innerHTML = `<span class="material-symbols-outlined text-green-400">check_circle</span><div><div class="font-bold">Đã thêm vào giỏ hàng!</div><div class="text-xs text-gray-300">${prod.product_name}</div></div>`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
      window.location.href = cartUrl;
    }, 600);
  }
  window.handleQuickBuy = handleQuickBuy;

  // Modal Handling
  function openSpecModal(idx) {
    const prod = rawProducts[idx];
    if (!prod) return;
    activeProductIndex = idx;

    modalTitle.textContent = prod.product_name;
    modalImg.src = prod.image || '';
    modalImg.alt = prod.product_name;
    modalBrand.textContent = prod.brand;
    modalModel.textContent = prod.model || prod.brand;
    modalCapacity.textContent = prod.capacity || 'N/A';
    modalPrice.textContent = prod.current_price;
    modalOldPrice.textContent = prod.old_price;

    modalSpecsList.innerHTML = '';
    const specs = Array.isArray(prod.specs) ? prod.specs : [];
    if (specs.length > 0) {
      specs.forEach(s => {
        const li = document.createElement('li');
        li.textContent = s;
        modalSpecsList.appendChild(li);
      });
    } else {
      const li = document.createElement('li');
      li.textContent = 'Chuẩn sạc nhanh an toàn, chống cháy nổ chính hãng.';
      modalSpecsList.appendChild(li);
    }

    modalBuyNowBtn.onclick = () => handleQuickBuy(idx);
    modalAddCartBtn.onclick = () => {
      closeSpecModal();
      handleQuickBuy(idx);
    };

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
  window.openSpecModal = openSpecModal;

  function closeSpecModal() {
    modal.classList.add('hidden');
    document.body.style.overflow = '';
  }
  window.closeSpecModal = closeSpecModal;

  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeSpecModal();
  });

  // Initial Filter Apply
  applyFilters();

})();
</script>

<?php get_footer(); ?>
