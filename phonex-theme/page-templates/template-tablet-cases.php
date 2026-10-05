<?php
/**
 * Template Name: PhoneX Ốp Lưng & Bao Da Máy Tính Bảng Chính Hãng
 *
 * Dedicated Tablet Cases & Covers Catalog Page
 *
 * Strictly adheres to:
 * 1. Google Stitch Design System Palette:
 *    - primary: #b7000c
 *    - primary-container: #e60012
 *    - primary-hover: #C90010
 *    - primary-fixed: #ffdad5
 *    - primary-fixed-dim: #ffb4aa
 *    - surface: #f8f9fb
 *    - surface-pure: #ffffff
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
 *    - Tên sản phẩm: Desktop 15-16px, Mobile 14-15px (weight 600, min-h-[44px])
 *    - Giá hiện tại: Desktop 20-24px, Mobile 18-20px (weight 700)
 *    - Giá cũ: 14px (Mobile 13-14px), 400, gạch ngang
 *    - Input / Form: 16px (chống auto-zoom iOS)
 *    - Button CTA chính ("Mua ngay"): 15-16px / 600, radius 8px, touch target >= 44x44px
 *    - Badge: 11-12px / 600-700, radius 6px
 *    - Hero Promo Card: background-color: var(--px-primary-fixed);
 *    - Hoàn toàn KHÔNG để bất kỳ thông tin nào liên quan đến Thế Giới Di Động ở phía người dùng.
 *    - 100% Ảnh sản phẩm tải cục bộ từ assets/images/products/op-lung-tablet/...
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD TABLET CASES DATA FROM LOCAL CACHE
// =========================================================================
$json_path = get_template_directory() . '/data/tablet-cases.json';
$crawled_products = array();

if ( file_exists( $json_path ) ) {
	$json_content = file_get_contents( $json_path );
	$crawled_products = json_decode( $json_content, true );
}

if ( empty( $crawled_products ) ) {
	$crawled_products = array();
}

$client_products = array_map( function( $item ) {
	unset( $item['source_url'] );
	unset( $item['image_remote'] );
	if ( ! empty( $item['image'] ) && strpos( $item['image'], 'http' ) !== 0 ) {
		$item['image'] = get_template_directory_uri() . '/' . ltrim( $item['image'], '/' );
	}
	return $item;
}, $crawled_products );

// Compatible Tablet Device Brands
$device_brands = array(
	'all'         => 'Tất cả dòng tablet',
	'iPad'        => 'iPad (Apple)',
	'Galaxy Tab'  => 'Samsung Galaxy Tab',
	'Xiaomi Pad'  => 'Xiaomi Pad / Khác',
);

// Product Types
$types = array(
	'all'       => 'Tất cả phân loại',
	'smart'     => 'Bao da thông minh gập',
	'keyboard'  => 'Bao da kèm bàn phím',
	'case'      => 'Ốp lưng chống sốc',
);

// Brand list for quick filter bar
$brands = array(
	'all'      => 'Tất cả hãng',
	'Samsung'  => 'Samsung',
	'Apple'    => 'Apple',
	'UNIQ'     => 'UNIQ',
	'AVA+'     => 'AVA+',
	'JCPAL'    => 'JCPAL',
	'ESR'      => 'ESR',
	'Laut'     => 'Laut',
	'Tucano'   => 'Tucano',
	'JM'       => 'JM',
);

$total_crawled = count( $crawled_products );
?>

<!-- =========================================================================
     SCOPED DESIGN SYSTEM STYLES (STITCH TOKENS & TYPOGRAPHY SCALE)
     ========================================================================= -->
<style>
:root {
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
    font-size: 15px;
    min-height: 44px;
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

/* Inputs and Selects (iOS zoom-safe: min 16px) */
.px-ds-input,
.px-ds-select {
  font-size: 16px !important;
  min-height: 44px;
}

/* Touch Targets: minimum 44x44px */
.px-ds-touch {
  min-height: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

/* Buttons per Design System */
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

/* Badge per Design System */
.px-ds-badge {
  font-size: 11px;
  font-weight: 700;
  border-radius: 6px;
  padding: 2px 7px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  letter-spacing: 0.02em;
}
@media (min-width: 768px) {
  .px-ds-badge {
    font-size: 12px;
    padding: 3px 8px;
  }
}

/* PhoneX Card Design - Spacious, Airy & Unibody */
.px-prod-card {
  background-color: #ffffff;
  border-radius: 18px;
  border: 1px solid #E5E7EB;
  padding: 16px;
  display: flex;
  flex-direction: column;
  position: relative;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
@media (min-width: 640px) {
  .px-prod-card {
    padding: 18px;
  }
}
.px-prod-card:hover {
  border-color: #cbd5e1;
  transform: translateY(-4px);
  box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.03);
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
.device-chip.active {
  background-color: var(--px-primary-container);
  border-color: var(--px-primary-container);
  color: #ffffff;
  font-weight: 700;
}
.type-chip.active {
  background-color: var(--px-primary-fixed);
  border-color: var(--px-primary-container);
  color: var(--px-primary);
  font-weight: 700;
}
.brand-chip.active {
  background-color: var(--px-primary-fixed);
  border-color: var(--px-primary-container);
  color: var(--px-primary);
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
       1. BREADCRUMB NAVIGATION
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
        <span class="font-semibold text-[#191c1e]">Ốp Lưng &amp; Bao Da Máy Tính Bảng</span>
      </nav>
    </div>
  </div>

  <!-- =========================================================================
       2. MODERN HERO PROMOTIONS GRID (PHONEX DESIGN SYSTEM - 3 COLUMNS)
       HERO CARD: background-color: var(--px-primary-fixed);
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <!-- MAIN PROMO CARD (2 COLUMNS - PHONE-X PRIMARY-FIXED HERO) -->
      <div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]" style="background-color: var(--px-primary-fixed);">
        
        <!-- Ambient Glow & Flare Lighting Effects -->
        <div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
          <span class="material-symbols-outlined text-[170px] text-[#b7000c]">tablet_mac</span>
        </div>

        <div class="relative z-10 max-w-xl">
          <!-- Pill Badge -->
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white text-[#b7000c] text-[11px] sm:text-[12px] font-bold uppercase tracking-wider mb-3.5 shadow-2xs border border-[#ffb4aa]">
            <span class="w-2 h-2 rounded-full bg-[#e60012] animate-pulse"></span>
            <span>PhoneX Flagship • Phụ Kiện Tablet Chính Hãng 100%</span>
          </div>

          <!-- Main Title H1 -->
          <h1 class="text-[26px] sm:text-[32px] md:text-[36px] font-bold text-[#191c1e] tracking-tight leading-tight mb-3">
            Bao Da &amp; Ốp Lưng Máy Tính Bảng Cao Cấp
          </h1>

          <!-- Subtitle -->
          <p class="text-[14px] sm:text-[15px] text-[#5f5e5e] leading-[1.65] mb-6 font-normal">
            Bảo vệ toàn diện máy tính bảng với bao da thông minh Auto Sleep/Wake, bao da kèm bàn phím AI không dây, ốp lưng chống sốc 360 độ tích hợp khay giữ bút Apple Pencil &amp; S-Pen cho iPad, Galaxy Tab, Xiaomi Pad. Cam kết 100% nguyên seal, bảo hành 1 đổi 1.
          </p>

          <!-- 4 Highlights Badges -->
          <div class="grid grid-cols-2 gap-2.5 sm:gap-3 max-w-lg mb-6">
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">power_settings_new</span>
              <span class="truncate">Tự Động Tắt/Mở Auto Sleep</span>
            </div>
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">edit</span>
              <span class="truncate">Khay Đựng Bút Pencil &amp; S-Pen</span>
            </div>
            <div class="flex items-center gap-2.5 bg-white/90 hover:bg-white border border-[#ffb4aa]/60 px-3.5 py-2.5 rounded-xl text-[12px] sm:text-[13px] text-[#222222] font-semibold transition-all shadow-2xs">
              <span class="material-symbols-outlined text-[#e60012] text-[20px]">keyboard</span>
              <span class="truncate">Kèm Bàn Phím AI Không Dây</span>
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
            <a href="#tabletCasesGrid" class="min-h-[46px] px-6 rounded-xl bg-[#e60012] hover:bg-[#C90010] text-white font-bold text-[14px] sm:text-[15px] inline-flex items-center gap-2 shadow-md transition-all cursor-pointer hover:scale-102">
              <span>Xem <?php echo esc_html( $total_crawled ); ?> sản phẩm</span>
              <span class="material-symbols-outlined text-[18px]">arrow_downward</span>
            </a>
            <span class="text-[12px] sm:text-[13px] text-emerald-800 font-medium flex items-center gap-1.5 bg-white/80 px-3 py-2 rounded-lg border border-emerald-200/60 shadow-2xs">
              <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
              <span>Đổi mới 30 ngày nếu không vừa</span>
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
              Bong tróc, gãy bản lề đổi ngay bao da mới
            </div>
          </div>
          <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xs flex items-center justify-center shrink-0 border border-white/20">
            <span class="material-symbols-outlined text-[32px] text-[#ffdad5]">verified_user</span>
          </div>
        </div>

        <!-- Sub-banner 2: Giao hàng hỏa tốc -->
        <div class="rounded-2xl p-5 sm:p-6 border border-[#ffb4aa] text-[#1F1F1F] flex items-center justify-between shadow-xs relative overflow-hidden flex-1" style="background-color: var(--px-primary-fixed, #FFF0F2);">
          <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>
          <div class="relative z-10 pr-2">
            <div class="text-[11px] sm:text-[12px] font-bold uppercase text-[#00875A] tracking-wider mb-1 flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-[#00875A] animate-pulse"></span>
              <span>Nội thành nhận ngay</span>
            </div>
            <div class="text-[17px] sm:text-[18px] font-bold text-[#1F1F1F] leading-snug">
              Giao Hỏa Tốc 1 Giờ
            </div>
            <div class="text-[13px] text-gray-700 mt-1 font-medium">
              Lắp thử bao da vừa vặn trước khi trả tiền
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
       3. UNIFIED FILTER & SEARCH SECTION
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 space-y-4">
    
    <!-- Top Filter Card: Device, Type & Brand -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 sm:p-6 shadow-2xs">
      
      <!-- Row 1: Compatible Tablet Brand (iPad vs Galaxy Tab vs Xiaomi Pad) -->
      <div class="mb-5 pb-4 border-b border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">tablet</span>
            <h3 class="font-bold text-[14px] sm:text-[15px] text-[#191c1e]">Dòng máy tính bảng tương thích:</h3>
          </div>
          <span class="text-[12px] text-[#5f5e5e] hidden sm:inline">Chọn máy để lọc bao da vừa vặn</span>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1.5 scrollbar-none" id="deviceFilterContainer">
          <?php foreach ( $device_brands as $d_key => $d_label ) : ?>
            <button type="button"
                    data-device="<?php echo esc_attr( $d_key ); ?>"
                    class="device-chip px-ds-touch px-4 py-2 rounded-xl border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] font-medium text-[#222222] hover:border-[#e60012] transition-all shrink-0 cursor-pointer <?php echo ( 'all' === $d_key ) ? 'active' : ''; ?>">
              <?php echo esc_html( $d_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Row 2: Product Type Filter (Bao da thông minh vs Bao da bàn phím vs Ốp lưng) -->
      <div class="mb-5 pb-4 border-b border-[#E5E7EB]">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">category</span>
            <h3 class="font-bold text-[14px] sm:text-[15px] text-[#191c1e]">Phân loại bao da &amp; ốp:</h3>
          </div>
          <span class="text-[12px] text-[#5f5e5e] hidden sm:inline">Chọn theo nhu cầu sử dụng</span>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1.5 scrollbar-none" id="typeFilterContainer">
          <?php foreach ( $types as $t_key => $t_label ) : ?>
            <button type="button"
                    data-type="<?php echo esc_attr( $t_key ); ?>"
                    class="type-chip px-ds-touch px-4 py-2 rounded-xl border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] font-medium text-[#222222] hover:border-[#b7000c] hover:text-[#b7000c] transition-all shrink-0 cursor-pointer <?php echo ( 'all' === $t_key ) ? 'active' : ''; ?>">
              <?php echo esc_html( $t_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Row 3: Brand & Features -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Thương hiệu -->
        <div>
          <div class="flex items-center gap-2 mb-2.5">
            <span class="material-symbols-outlined text-[#e60012] text-[18px]">branding_watermark</span>
            <span class="font-bold text-[13px] sm:text-[14px] text-[#191c1e]">Thương hiệu sản xuất:</span>
          </div>
          <div class="flex flex-wrap gap-2" id="brandFilterContainer">
            <?php foreach ( $brands as $b_key => $b_label ) : ?>
              <button type="button"
                      data-brand="<?php echo esc_attr( $b_key ); ?>"
                      class="brand-chip px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-[#f8f9fb] text-[13px] sm:text-[14px] font-medium text-[#222222] hover:border-gray-400 transition-all cursor-pointer <?php echo ( 'all' === $b_key ) ? 'active' : ''; ?>">
                <?php echo esc_html( $b_label ); ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Tính năng & Tiện ích -->
        <div>
          <div class="flex items-center gap-2 mb-2.5">
            <span class="material-symbols-outlined text-[#e60012] text-[18px]">tune</span>
            <span class="font-bold text-[13px] sm:text-[14px] text-[#191c1e]">Tính năng nổi bật:</span>
          </div>
          <div class="flex flex-wrap gap-2" id="featureTagContainer">
            <button type="button" data-feature="auto-sleep" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Auto Sleep / Wake
            </button>
            <button type="button" data-feature="pen-slot" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Khay cất bút cảm ứng
            </button>
            <button type="button" data-feature="keyboard" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Kèm bàn phím không dây
            </button>
            <button type="button" data-feature="stand" class="feature-tag px-ds-touch px-3.5 py-1.5 rounded-lg border border-[#E5E7EB] bg-white text-[13px] sm:text-[14px] text-[#222222] hover:border-[#b7000c] transition-all cursor-pointer">
              Gập tam giác 2 góc
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Bottom Toolbar: Search, Price, Sort & Counter -->
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-4 sm:p-5 shadow-2xs">
      <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">

        <!-- Search Bar (16px font size) -->
        <div class="relative flex-1 max-w-md">
          <input type="text"
                 id="tabletCaseSearchInput"
                 placeholder="Tìm theo tên máy (iPad 10, Tab S9...), tên bao da, hãng..."
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
              <option value="under-400k">Dưới 400.000₫</option>
              <option value="400k-800k">400.000₫ - 800.000₫</option>
              <option value="800k-1500k">800.000₫ - 1.500.000₫</option>
              <option value="over-1500k">Trên 1.500.000₫</option>
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
            </select>
          </div>

          <!-- Reset Filter Button -->
          <button type="button" id="resetAllFiltersBtn" class="hidden px-ds-touch px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-[13px] sm:text-[14px] font-semibold text-[#5f5e5e] hover:text-[#222222] transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-[16px] mr-1">refresh</span>
            <span>Đặt lại</span>
          </button>

        </div>

      </div>

      <!-- Counter -->
      <div class="mt-3.5 pt-3.5 border-t border-[#E5E7EB] flex flex-wrap items-center justify-between text-[13px] sm:text-[14px] text-[#5f5e5e] gap-2">
        <div>
          <span>Đang hiển thị: </span>
          <strong id="resultsCount" class="text-[#b7000c] font-bold"><?php echo esc_html( $total_crawled ); ?></strong>
          <span> / <?php echo esc_html( $total_crawled ); ?> sản phẩm bao da máy tính bảng PhoneX</span>
        </div>
        <div class="flex items-center gap-1.5 text-[12px] sm:text-[13px] text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/60">
          <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
          <span>100% Sản phẩm chính hãng • Bảo vệ toàn diện 360 độ</span>
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
        <span>Danh Sách Bao Da &amp; Ốp Lưng Máy Tính Bảng</span>
      </h2>
      <span class="text-[13px] text-[#5f5e5e]">Giao hỏa tốc 1 giờ &bull; Thử tại chỗ trước khi thanh toán</span>
    </div>

    <!-- Empty State Message -->
    <div id="noProductsFound" class="hidden bg-white rounded-2xl border border-[#E5E7EB] p-12 text-center my-6 shadow-2xs">
      <span class="material-symbols-outlined text-gray-300 text-6xl mb-3">search_off</span>
      <h3 class="px-ds-h3 text-[#222222] mb-2">Không tìm thấy bao da tablet phù hợp</h3>
      <p class="text-[#5f5e5e] text-[14px] max-w-md mx-auto mb-6">
        Hãy thử điều chỉnh bộ lọc dòng máy tính bảng, thương hiệu, hoặc mức giá để tìm kiếm sản phẩm phù hợp.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-ds-btn-primary px-6 py-2.5 rounded-lg cursor-pointer shadow-sm">
        Xóa tất cả bộ lọc
      </button>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-7" id="tabletCasesGrid">
      <?php
      if ( ! empty( $crawled_products ) ) :
        foreach ( $crawled_products as $idx => $prod ) :
          $name         = $prod['name'];
          $price        = $prod['price_formatted'];
          $price_num    = (int) $prod['price'];
          $old_price    = $prod['price_old_formatted'];
          $old_num      = (int) $prod['price_old'];
          $discount_pct = (int) $prod['discount_percent'];
          $brand        = $prod['brand'];
          $dev_brand    = $prod['device_brand'];
          $dev_model    = $prod['device_model'];
          $prod_type    = $prod['type'];
          $material     = $prod['material'];
          $specs        = is_array( $prod['specs'] ) ? $prod['specs'] : array();
          $updated_at   = $prod['updated_at'];
          $image        = $prod['image'];
          $img_src      = ( ! empty( $image ) && strpos( $image, 'http' ) === 0 ) ? $image : get_template_directory_uri() . '/' . ltrim( $image, '/' );

          // Type slug for filter
          $type_slug = 'smart';
          if ( stripos( $prod_type, 'bàn phím' ) !== false ) $type_slug = 'keyboard';
          elseif ( stripos( $prod_type, 'ốp lưng' ) !== false ) $type_slug = 'case';
          ?>
          <div class="px-prod-card tablet-case-item"
               data-id="<?php echo esc_attr( $idx ); ?>"
               data-brand="<?php echo esc_attr( $brand ); ?>"
               data-device="<?php echo esc_attr( $dev_brand ); ?>"
               data-type="<?php echo esc_attr( $type_slug ); ?>"
               data-price="<?php echo esc_attr( $price_num ); ?>"
               data-discount="<?php echo esc_attr( $discount_pct ); ?>"
               data-name="<?php echo esc_attr( mb_strtolower( $name, 'UTF-8' ) ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode( ' ', $specs ), 'UTF-8' ) ); ?>"
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

              <?php if ( 'keyboard' === $type_slug ) : ?>
                <span class="px-ds-badge bg-[#ffdad5] text-[#b7000c] border border-[#ffb4aa]">
                  Kèm Bàn Phím
                </span>
              <?php elseif ( stripos( $name, 'Bút' ) !== false || stripos( $name, 'Pencil' ) !== false || stripos( $name, 'S-Pen' ) !== false ) : ?>
                <span class="px-ds-badge bg-white/95 text-blue-700 border border-blue-200 shadow-2xs">
                  Khay Bút
                </span>
              <?php elseif ( ! empty( $dev_brand ) ) : ?>
                <span class="px-ds-badge bg-[#f2f4f6] text-gray-700 border border-gray-200 truncate max-w-[120px]">
                  <?php echo esc_html( $dev_brand ); ?>
                </span>
              <?php endif; ?>
            </div>

            <!-- PRODUCT IMAGE (Spacious, airy thumbnail container) -->
            <div class="img-box cursor-pointer" onclick="openSpecModal(<?php echo esc_attr( $idx ); ?>)">
              <?php if ( ! empty( $img_src ) ) : ?>
                <img src="<?php echo esc_url( $img_src ); ?>"
                     alt="<?php echo esc_attr( $name ); ?>"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='<?php echo esc_url( get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-may-tinh-bang.png' ); ?>';" />
              <?php else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/categories/accessories/op-lung-may-tinh-bang.png' ); ?>"
                     alt="<?php echo esc_attr( $name ); ?>" />
              <?php endif; ?>
            </div>

            <!-- PRODUCT DETAILS -->
            <div class="flex flex-col flex-1 justify-between">
              <div>
                <!-- 1. Brand & Compatible Model -->
                <div class="flex items-center justify-between gap-2 mb-1.5">
                  <span class="text-[11px] sm:text-[12px] font-bold text-gray-500 uppercase tracking-wider truncate">
                    <?php echo esc_html( $brand ); ?>
                  </span>
                  <span class="text-[11px] sm:text-[12px] font-semibold text-[#191c1e] bg-[#f2f4f6] px-2 py-0.5 rounded-[4px] shrink-0 truncate max-w-[130px]">
                    <?php echo esc_html( $dev_model ); ?>
                  </span>
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
                      <span class="material-symbols-outlined text-[14px] text-[#e60012]">shield</span>
                      <span><?php echo esc_html( $specs[0] ); ?></span>
                    </span>
                  </div>
                <?php endif; ?>
              </div>

              <!-- 4. Price & Actions -->
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
                    <span>Ôm khít máy 100%</span>
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

    <!-- Pagination Button -->
    <div class="mt-8 text-center" id="loadMoreWrap">
      <button type="button"
              id="loadMoreBtn"
              class="px-ds-touch inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white border border-[#b7000c] text-[#b7000c] hover:bg-[#ffdad5] rounded-xl font-bold text-[14px] sm:text-[15px] transition-all shadow-sm cursor-pointer">
        <span class="material-symbols-outlined text-[20px]">expand_more</span>
        <span>Xem thêm <span id="loadMoreRemainingCount"><?php echo esc_html( max( 0, $total_crawled - 20 ) ); ?></span> sản phẩm bao da</span>
      </button>
    </div>

  </div>

  <!-- =========================================================================
       5. SPECIFICATIONS MODAL DIALOG
       ========================================================================= -->
  <div id="specModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-6 relative shadow-2xl border border-gray-100">
      
      <button type="button"
              onclick="closeSpecModal()"
              class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors cursor-pointer">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>

      <div class="flex items-center gap-2 text-[12px] font-bold text-[#b7000c] uppercase tracking-wider mb-2">
        <span class="material-symbols-outlined text-[16px]">verified</span>
        <span>Hồ Sơ Kỹ Thuật Sản Phẩm PhoneX</span>
      </div>

      <h3 id="modalTitle" class="px-ds-h3 text-[#222222] mb-4 leading-snug"></h3>

      <div class="w-full h-48 bg-[#f8f9fb] rounded-xl mb-4 p-4 flex items-center justify-center">
        <img id="modalImg" src="" alt="" class="max-h-full max-w-full object-contain" />
      </div>

      <div class="space-y-2.5 mb-6 text-[14px]">
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Hãng sản xuất:</span>
          <strong id="modalBrand" class="text-[#222222] font-semibold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Dòng máy tính bảng:</span>
          <strong id="modalModel" class="text-[#222222] font-semibold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Chất liệu cấu tạo:</span>
          <strong id="modalMaterial" class="text-[#b7000c] font-bold"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Giá ưu đãi PhoneX:</span>
          <strong id="modalPrice" class="text-[#b7000c] font-bold text-[18px]"></strong>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e]">Giá niêm yết:</span>
          <span id="modalOldPrice" class="text-[#5f5e5e] line-through"></span>
        </div>
        <div class="py-2 border-b border-[#E5E7EB]">
          <span class="text-[#5f5e5e] block mb-1.5 font-medium">Đặc điểm kỹ thuật &amp; tiện ích:</span>
          <ul id="modalSpecsList" class="space-y-1 pl-4 list-disc text-[#222222]"></ul>
        </div>
        <div class="flex justify-between py-2 border-b border-[#E5E7EB] text-[12px]">
          <span class="text-[#5f5e5e]">Chính sách bảo hành:</span>
          <span class="text-emerald-700 font-semibold">1 Đổi 1 trong 30 ngày nếu không vừa</span>
        </div>
      </div>

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
       6. QUICK BUY MODAL
       ========================================================================= -->
  <div id="quickBuyModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 relative shadow-2xl border border-gray-100">
      
      <button type="button"
              onclick="closeQuickBuyModal()"
              class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition-colors cursor-pointer">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>

      <div class="flex items-center gap-2 text-[12px] font-bold text-[#e60012] uppercase tracking-wider mb-2">
        <span class="material-symbols-outlined text-[16px]">bolt</span>
        <span>Đặt Hàng Nhanh 1-Click PhoneX</span>
      </div>

      <h3 id="quickBuyTitle" class="px-ds-h3 text-[#222222] mb-3 leading-snug"></h3>
      
      <div class="flex items-center justify-between p-3.5 bg-[#f8f9fb] rounded-xl mb-4 border border-[#E5E7EB]">
        <div>
          <span class="text-[12px] text-[#5f5e5e] block">Giá thanh toán ưu đãi:</span>
          <strong id="quickBuyPrice" class="text-[20px] font-bold text-[#e60012]"></strong>
        </div>
        <div class="text-right">
          <span class="text-[11px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold border border-emerald-200">
            Miễn phí ship hỏa tốc
          </span>
        </div>
      </div>

      <form id="quickBuyForm" onsubmit="submitQuickBuy(event)" class="space-y-3.5">
        <div>
          <label class="block text-[13px] font-semibold text-[#191c1e] mb-1">Họ tên người nhận *</label>
          <input type="text" required placeholder="Ví dụ: Nguyễn Văn A" class="px-ds-input w-full px-3.5 py-2.5 border border-[#E5E7EB] rounded-lg text-[16px] text-[#222222] focus:outline-hidden focus:border-[#b7000c]" />
        </div>
        <div>
          <label class="block text-[13px] font-semibold text-[#191c1e] mb-1">Số điện thoại *</label>
          <input type="tel" required placeholder="Ví dụ: 0901 234 567" class="px-ds-input w-full px-3.5 py-2.5 border border-[#E5E7EB] rounded-lg text-[16px] text-[#222222] focus:outline-hidden focus:border-[#b7000c]" />
        </div>
        <div>
          <label class="block text-[13px] font-semibold text-[#191c1e] mb-1">Địa chỉ giao hàng *</label>
          <input type="text" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." class="px-ds-input w-full px-3.5 py-2.5 border border-[#E5E7EB] rounded-lg text-[16px] text-[#222222] focus:outline-hidden focus:border-[#b7000c]" />
        </div>
        
        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg text-[12px] text-blue-900 flex items-start gap-2">
          <span class="material-symbols-outlined text-[16px] text-blue-600 mt-0.5 shrink-0">info</span>
          <span>Khách hàng được mở hộp lắp thử vào tablet trước khi thanh toán cho shipper PhoneX.</span>
        </div>

        <button type="submit" class="px-ds-btn-primary w-full py-3.5 text-center font-bold text-[15px] cursor-pointer shadow-md">
          Xác Nhận Đặt Hàng Ngay
        </button>
      </form>

    </div>
  </div>

  <!-- =========================================================================
       7. SEO & BUYING GUIDE SECTION
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="bg-white rounded-2xl border border-[#E5E7EB] p-6 sm:p-8 shadow-2xs">
      
      <div class="border-b border-[#E5E7EB] pb-4 mb-6">
        <div class="inline-flex items-center gap-2 text-[#b7000c] font-bold text-[12px] uppercase tracking-wider mb-1">
          <span class="material-symbols-outlined text-[18px]">verified</span>
          <span>Cẩm nang kiến thức bao da tablet PhoneX</span>
        </div>
        <h2 class="px-ds-h2">
          Kinh Nghiệm Chọn Mua Bao Da &amp; Ốp Lưng Máy Tính Bảng Chuẩn Xác, Tiện Dụng
        </h2>
      </div>

      <div class="prose max-w-none text-[#222222] text-[15px] sm:text-[16px] leading-[1.6] space-y-4 font-normal">
        <p>
          Máy tính bảng sở hữu kích thước màn hình lớn từ 10 inch đến 14.6 inch, khiến nguy cơ nứt vỡ khi va chạm tăng cao gấp nhiều lần so với điện thoại. Một chiếc <strong>bao da máy tính bảng</strong> hay <strong>ốp lưng tablet thông minh</strong> vừa là lớp giáp bảo vệ, vừa đóng vai trò giá đỡ công thái học hỗ trợ gõ phím, vẽ hoặc xem phim tiện lợi.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6 not-prose">
          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">power_settings_new</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Cảm biến Auto Sleep / Wake</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Mặt nắp bao da tích hợp dải nam châm thông minh, tự động bật sáng màn hình khi mở nắp và khóa màn hình khi đóng lại, giúp tiết kiệm đến 30% pin cho máy.
            </p>
          </div>

          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">edit</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Khay giữ và sạc bút cảm ứng</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Thiết kế rãnh giữ bút Apple Pencil hoặc S-Pen riêng biệt, hỗ trợ sạc không dây từ tính trực tiếp qua thân ốp, tránh thất lạc phụ kiện đắt tiền.
            </p>
          </div>

          <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
            <div class="w-10 h-10 rounded-lg bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-3">
              <span class="material-symbols-outlined">keyboard</span>
            </div>
            <h4 class="font-bold text-[16px] mb-1 text-[#222222]">Bàn phím Bluetooth &amp; Trackpad</h4>
            <p class="text-[13px] text-[#5f5e5e] leading-relaxed">
              Biến tablet thành máy tính xách tay trong chớp mắt với bàn phím có đèn nền, hành trình phím nảy êm và bàn rê cảm ứng mượt mà.
            </p>
          </div>
        </div>

        <h3 class="px-ds-h3 text-[#191c1e] mt-6">3 Tiêu chí quan trọng khi chọn mua bao da máy tính bảng</h3>
        <ul class="list-disc pl-5 space-y-2">
          <li><strong>Xác định chính xác thế hệ tablet:</strong> iPad Gen 9 (10.2"), iPad Gen 10 (10.9"), iPad Air hay iPad Pro M2/M4 có vị trí camera và kích thước khác nhau. Tương tự với Galaxy Tab S9, S9 FE hay Tab A9.</li>
          <li><strong>Nhu cầu di chuyển:</strong> Nếu hay mang tablet đi làm hoặc học tập, hãy chọn bao da nắp gập 360 độ hoặc bao da kèm bàn phím để tối ưu hiệu suất công việc.</li>
          <li><strong>Thương hiệu uy tín:</strong> Chọn các dòng bao da chính hãng từ Apple, Samsung, ESR, UNIQ, JCPAL được phân phối chính ngạch tại PhoneX với cam kết đổi trả 30 ngày.</li>
        </ul>
      </div>

    </div>
  </div>

</div>

<!-- =========================================================================
     8. CLIENT JAVASCRIPT: FILTERING, SORTING, SEARCH & MODALS
     ========================================================================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const productsData = <?php echo json_encode( $client_products, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); ?>;
  
  const grid = document.getElementById('tabletCasesGrid');
  const items = Array.from(document.querySelectorAll('.tablet-case-item'));
  const searchInput = document.getElementById('tabletCaseSearchInput');
  const clearSearchBtn = document.getElementById('clearSearchBtn');
  const priceSelect = document.getElementById('priceFilterSelect');
  const sortSelect = document.getElementById('sortFilterSelect');
  const resetBtn = document.getElementById('resetAllFiltersBtn');
  const resultsCount = document.getElementById('resultsCount');
  const noProducts = document.getElementById('noProductsFound');
  const loadMoreWrap = document.getElementById('loadMoreWrap');
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const loadMoreRemaining = document.getElementById('loadMoreRemainingCount');

  // Filter States
  let currentDevice = 'all';
  let currentType = 'all';
  let currentBrand = 'all';
  let activeFeatures = new Set();
  let currentPrice = 'all';
  let currentSort = 'featured';
  let searchQuery = '';
  let visibleLimit = 20;

  // Chips Listeners
  const deviceChips = document.querySelectorAll('.device-chip');
  deviceChips.forEach(chip => {
    chip.addEventListener('click', () => {
      deviceChips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      currentDevice = chip.getAttribute('data-device');
      visibleLimit = 20;
      applyFilters();
    });
  });

  const typeChips = document.querySelectorAll('.type-chip');
  typeChips.forEach(chip => {
    chip.addEventListener('click', () => {
      typeChips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      currentType = chip.getAttribute('data-type');
      visibleLimit = 20;
      applyFilters();
    });
  });

  const brandChips = document.querySelectorAll('.brand-chip');
  brandChips.forEach(chip => {
    chip.addEventListener('click', () => {
      brandChips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      currentBrand = chip.getAttribute('data-brand');
      visibleLimit = 20;
      applyFilters();
    });
  });

  const featureTags = document.querySelectorAll('.feature-tag');
  featureTags.forEach(tag => {
    tag.addEventListener('click', () => {
      const feat = tag.getAttribute('data-feature');
      if (activeFeatures.has(feat)) {
        activeFeatures.delete(feat);
        tag.classList.remove('active');
      } else {
        activeFeatures.add(feat);
        tag.classList.add('active');
      }
      visibleLimit = 20;
      applyFilters();
    });
  });

  // Search Input
  searchInput.addEventListener('input', (e) => {
    searchQuery = e.target.value.trim().toLowerCase();
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
    currentDevice = 'all';
    currentType = 'all';
    currentBrand = 'all';
    activeFeatures.clear();
    currentPrice = 'all';
    currentSort = 'featured';
    searchQuery = '';
    visibleLimit = 20;

    searchInput.value = '';
    clearSearchBtn.classList.add('hidden');
    priceSelect.value = 'all';
    sortSelect.value = 'featured';

    deviceChips.forEach(b => {
      if (b.getAttribute('data-device') === 'all') b.classList.add('active');
      else b.classList.remove('active');
    });

    typeChips.forEach(t => {
      if (t.getAttribute('data-type') === 'all') t.classList.add('active');
      else t.classList.remove('active');
    });

    brandChips.forEach(b => {
      if (b.getAttribute('data-brand') === 'all') b.classList.add('active');
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
      const dev = el.getAttribute('data-device') || '';
      const t = el.getAttribute('data-type') || '';
      const b = el.getAttribute('data-brand') || '';
      const p = parseInt(el.getAttribute('data-price') || '0', 10);
      const name = el.getAttribute('data-name') || '';
      const specs = el.getAttribute('data-specs') || '';

      let pass = true;

      // 1. Device filter
      if (currentDevice !== 'all') {
        if (dev.toLowerCase() !== currentDevice.toLowerCase()) pass = false;
      }

      // 2. Type filter
      if (pass && currentType !== 'all') {
        if (t !== currentType) pass = false;
      }

      // 3. Brand filter
      if (pass && currentBrand !== 'all') {
        if (b.toLowerCase() !== currentBrand.toLowerCase()) pass = false;
      }

      // 4. Features filter
      if (pass && activeFeatures.size > 0) {
        if (activeFeatures.has('auto-sleep') && !name.includes('thông minh') && !specs.includes('auto sleep') && !specs.includes('sleep/wake')) pass = false;
        if (activeFeatures.has('pen-slot') && !name.includes('bút') && !name.includes('pencil') && !specs.includes('bút')) pass = false;
        if (activeFeatures.has('keyboard') && !name.includes('bàn phím') && !specs.includes('bàn phím')) pass = false;
        if (activeFeatures.has('stand') && !name.includes('tam giác') && !specs.includes('tam giác') && !specs.includes('góc')) pass = false;
      }

      // 5. Price range
      if (pass && currentPrice !== 'all') {
        if (currentPrice === 'under-400k' && p >= 400000) pass = false;
        else if (currentPrice === '400k-800k' && (p < 400000 || p >= 800000)) pass = false;
        else if (currentPrice === '800k-1500k' && (p < 800000 || p >= 1500000)) pass = false;
        else if (currentPrice === 'over-1500k' && p < 1500000) pass = false;
      }

      // 6. Search query
      if (pass && searchQuery.length > 0) {
        if (!name.includes(searchQuery) && !b.toLowerCase().includes(searchQuery) && !dev.toLowerCase().includes(searchQuery) && !specs.includes(searchQuery)) {
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
    }

    // Re-append sorted elements
    matched.forEach(el => grid.appendChild(el));

    // Store matched for pagination
    window._matchedItems = matched;

    // Update Counter
    if (resultsCount) resultsCount.textContent = matched.length;

    // Reset button visibility
    const isFiltered = (currentDevice !== 'all' || currentType !== 'all' || currentBrand !== 'all' || activeFeatures.size > 0 || currentPrice !== 'all' || currentSort !== 'featured' || searchQuery.length > 0);
    if (isFiltered) {
      resetBtn.classList.remove('hidden');
    } else {
      resetBtn.classList.add('hidden');
    }

    // Empty state
    if (matched.length === 0) {
      noProducts.classList.remove('hidden');
      loadMoreWrap.classList.add('hidden');
    } else {
      noProducts.classList.add('hidden');
      renderVisible();
    }
  }

  function renderVisible() {
    const list = window._matchedItems || items;
    list.forEach((el, idx) => {
      if (idx < visibleLimit) {
        el.style.display = 'flex';
      } else {
        el.style.display = 'none';
      }
    });

    const remaining = Math.max(0, list.length - visibleLimit);
    if (remaining > 0) {
      loadMoreWrap.classList.remove('hidden');
      if (loadMoreRemaining) loadMoreRemaining.textContent = remaining;
    } else {
      loadMoreWrap.classList.add('hidden');
    }
  }

  // Initial render
  window._matchedItems = items;
  renderVisible();

  // Modal Handlers
  window.openSpecModal = function(idx) {
    const p = productsData[idx];
    if (!p) return;

    document.getElementById('modalTitle').textContent = p.name;
    document.getElementById('modalBrand').textContent = p.brand;
    document.getElementById('modalModel').textContent = p.device_model || p.device_brand || 'Máy tính bảng';
    document.getElementById('modalMaterial').textContent = p.material || 'Da nhân tạo PU cao cấp';
    document.getElementById('modalPrice').textContent = p.price_formatted;
    document.getElementById('modalOldPrice').textContent = p.price_old_formatted;
    document.getElementById('modalImg').src = p.image || '';

    const ul = document.getElementById('modalSpecsList');
    ul.innerHTML = '';
    if (Array.isArray(p.specs)) {
      p.specs.forEach(s => {
        const li = document.createElement('li');
        li.textContent = s;
        ul.appendChild(li);
      });
    }

    const buyBtn = document.getElementById('modalBuyNowBtn');
    buyBtn.onclick = function() {
      closeSpecModal();
      handleQuickBuy(idx);
    };

    const addBtn = document.getElementById('modalAddCartBtn');
    addBtn.onclick = function() {
      alert('Đã thêm sản phẩm "' + p.name + '" vào giỏ hàng PhoneX!');
      closeSpecModal();
    };

    document.getElementById('specModal').classList.remove('hidden');
  };

  window.closeSpecModal = function() {
    document.getElementById('specModal').classList.add('hidden');
  };

  window.handleQuickBuy = function(idx) {
    const p = productsData[idx];
    if (!p) return;

    document.getElementById('quickBuyTitle').textContent = p.name;
    document.getElementById('quickBuyPrice').textContent = p.price_formatted;
    document.getElementById('quickBuyModal').classList.remove('hidden');
  };

  window.closeQuickBuyModal = function() {
    document.getElementById('quickBuyModal').classList.add('hidden');
  };

  window.submitQuickBuy = function(e) {
    e.preventDefault();
    alert('PhoneX đã nhận thông tin đặt bao da tablet của bạn! Chuyên viên sẽ liên hệ xác nhận đúng model máy và giao hàng hỏa tốc trong 1 giờ.');
    closeQuickBuyModal();
  };

  // Close modals on backdrop click
  document.getElementById('specModal').addEventListener('click', function(e) {
    if (e.target === this) closeSpecModal();
  });
  document.getElementById('quickBuyModal').addEventListener('click', function(e) {
    if (e.target === this) closeQuickBuyModal();
  });

});
</script>

<?php
get_footer();
