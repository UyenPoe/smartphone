<?php
/**
 * Template Name: PhoneX Kính & Miếng Dán Bảo Vệ Camera Chính Hãng
 *
 * Dedicated Camera Lens Protectors Catalog Page
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
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD CAMERA LENS DATA FROM LOCAL CACHE
// =========================================================================
$json_path = get_template_directory() . '/data/camera-lens.json';
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

// Device Series Filter
$series_list = array(
	'all'        => 'Tất cả dòng máy',
	'iphone-16'  => 'iPhone 16 Series',
	'iphone-15'  => 'iPhone 15 Series',
	'iphone-14'  => 'iPhone 14 Series',
	'iphone-13'  => 'iPhone 13 / Cũ hơn',
	'iphone-air' => 'iPhone Air',
);

// Material / Type Filter
$materials = array(
	'all'       => 'Tất cả chất liệu',
	'titanium'  => 'Viền Titanium',
	'aluminium' => 'Viền nhôm Aluminium',
	'sapphire'  => 'Kính Sapphire',
	'pc'        => 'Khung PC quang học',
);

// Brand list for quick filter bar
$brands = array(
	'all'    => 'Tất cả hãng',
	'Dekey'  => 'Dekey',
	'UNIQ'   => 'UNIQ',
	'JCPAL'  => 'JCPAL',
	'Mipow'  => 'Mipow',
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
.px-ds-input {
  font-size: 16px;
  line-height: 1.5;
  min-height: 44px;
}

/* Primary CTA Buttons */
.px-ds-btn-cta {
  font-size: 15px;
  font-weight: 600;
  min-height: 44px;
  min-width: 44px;
  border-radius: 8px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Touch Targets: All Interactive Elements >= 44x44px */
.px-touch-target {
  min-height: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

/* Unibody Spacious Product Card */
.phonex-cam-card {
  transition: transform 0.24s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.24s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.24s ease;
  will-change: transform, box-shadow;
  display: flex;
  flex-direction: column;
}
.phonex-cam-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px -6px rgba(183, 0, 12, 0.12), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
  border-color: #ffb4aa;
}
.phonex-cam-card.hidden {
  display: none !important;
}

/* Line Clamp */
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Smooth Horizontal Scroll for Mobile Chips */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Active Chips */
.series-chip.active {
  background-color: var(--px-primary-container);
  border-color: var(--px-primary-container);
  color: #ffffff;
  font-weight: 700;
}
.mat-chip.active {
  background-color: var(--px-primary-fixed);
  border-color: var(--px-primary-container);
  color: var(--px-primary);
  font-weight: 700;
}
</style>

<main class="w-full min-h-screen bg-[#f8f9fb] pb-16 font-sans text-[#222222]">

  <!-- =========================================================================
       1. BREADCRUMB NAVIGATION (PHONEX DESIGN SYSTEM)
       ========================================================================= -->
  <div class="w-full bg-white border-b border-[#E5E7EB]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <nav class="flex items-center gap-2 text-[13px] sm:text-[14px] text-[#5f5e5e] overflow-x-auto no-scrollbar whitespace-nowrap">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#b7000c] transition-colors flex items-center gap-1">
          <span class="material-symbols-outlined text-[17px]">home</span>
          <span>Trang chủ</span>
        </a>
        <span class="text-gray-300">/</span>
        <a href="<?php echo esc_url( home_url( '/phu-kien/' ) ); ?>" class="hover:text-[#b7000c] transition-colors">
          Phụ kiện
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-[#222222] font-semibold">Miếng dán bảo vệ Camera</span>
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
          <span class="material-symbols-outlined text-[240px] text-[#b7000c]">photo_camera</span>
        </div>

        <div class="relative z-10 max-w-2xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/90 border border-[#b7000c]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-[#e60012] animate-pulse"></span>
            PHONEX OPTICAL LAB • BẢO VỆ ỐNG KÍNH TOÀN DIỆN
          </div>
          <h1 class="px-ds-h1 font-bold text-[#222222] tracking-tight mb-3">
            Miếng Dán & Kính Cường Lực Bảo Vệ Camera PhoneX
          </h1>
          <p class="text-[14px] sm:text-[16px] text-[#444444] leading-relaxed mb-6 font-normal">
            Bảo vệ hoàn hảo cụm ống kính lồi trước va quẹt và nứt vỡ. Vật liệu kính Sapphire & viền Titanium hàng không siêu bền, công nghệ thấu kính quang học chống lóa ban đêm giữ trọn 100% chất lượng ảnh chụp và video 4K sắc nét.
          </p>
          <div class="flex flex-wrap items-center gap-3">
            <a href="#catalog-grid" class="px-ds-btn-cta bg-[#b7000c] hover:bg-[#C90010] text-white px-6 py-2.5 shadow-md hover:shadow-lg inline-flex items-center gap-2">
              <span class="material-symbols-outlined text-[19px]">verified</span>
              <span>Xem <?php echo esc_html( $total_crawled ); ?> sản phẩm</span>
            </a>
            <div class="inline-flex items-center gap-1.5 text-[13px] text-[#6d1316] font-medium bg-white/70 px-3 py-2 rounded-lg border border-[#ffb4aa]/60">
              <span class="material-symbols-outlined text-[17px] text-[#b7000c]">camera</span>
              <span>Không lóa đèn Flash khi chụp đêm</span>
            </div>
          </div>
        </div>

        <!-- Trust Badges Bar inside Hero -->
        <div class="relative z-10 mt-6 pt-4 border-t border-[#ffb4aa]/80 grid grid-cols-2 sm:grid-cols-4 gap-2 text-[12px] sm:text-[13px] font-medium text-[#4a1c1d]">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">verified_user</span>
            <span>Viền Titanium 9H</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">nightlight</span>
            <span>Chống lóa Flash ban đêm</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">lens_blur</span>
            <span>Kính quang học 99.9%</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">build_circle</span>
            <span>Khung tự dán chuẩn xác</span>
          </div>
        </div>
      </div>

      <!-- SIDE PROMO CARD (1 COLUMN - QUICK GUIDE & SPECIAL OFFERS) -->
      <div class="relative rounded-2xl p-6 sm:p-7 shadow-xs flex flex-col justify-between overflow-hidden bg-white border border-[#E5E7EB]">
        <div>
          <div class="flex items-center justify-between mb-4">
            <span class="text-[12px] font-bold text-white bg-[#e60012] px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Ưu Đãi Combo
            </span>
            <span class="text-[12px] text-[#5f5e5e] font-medium flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px] text-amber-500">stars</span>
              PhoneX Care
            </span>
          </div>
          <h2 class="px-ds-h3 font-bold text-[#222222] mb-2">
            Bảo Vệ Toàn Diện Cùng Màn Hình & Ốp Lưng
          </h2>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] mb-5 leading-normal">
            Bảo vệ trọn vẹn cụm camera lồi đắt giá khỏi trầy xước khi đặt điện thoại trên mặt bàn gồ ghề.
          </p>

          <div class="space-y-2.5 bg-[#f8f9fb] p-3.5 rounded-xl border border-gray-100 mb-5">
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                Dán Camera iPhone 16 Pro/Max
              </span>
              <span class="font-bold text-[#b7000c]">Từ 195.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                Viền Dekey 3D Titanium
              </span>
              <span class="font-bold text-[#b7000c]">Từ 131.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                UNIQ Optix Aluminium
              </span>
              <span class="font-bold text-[#b7000c]">Từ 195.000₫</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?php echo esc_url( home_url( '/mieng-dan-man-hinh/' ) ); ?>" class="w-full px-ds-btn-cta bg-[#f8f9fb] hover:bg-[#ffdad5]/40 text-[#b7000c] border border-[#ffb4aa] px-4 py-2.5 text-center font-semibold text-[14px] flex items-center justify-center gap-2">
            <span>Xem thêm Kính cường lực màn hình</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
      </div>

    </div>
  </div>

  <!-- =========================================================================
       3. INTERACTIVE FILTER & SEARCH BAR
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-2">
    
    <!-- Filter Card Container -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs">

      <!-- Row 1: Search + Quick Device Series Chips -->
      <div class="flex flex-col md:flex-row md:items-center gap-3.5 pb-4 border-b border-[#E5E7EB]">
        
        <!-- Live Search Input -->
        <div class="relative w-full md:w-80 shrink-0">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <span class="material-symbols-outlined text-[20px]">search</span>
          </span>
          <input type="text"
                 id="camSearchInput"
                 placeholder="Tìm theo máy (16 Pro, 15 Pro Max, Titan...)"
                 class="w-full px-ds-input pl-10 pr-9 bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl text-[15px] sm:text-[16px] text-[#222222] placeholder-gray-400 focus:outline-none focus:border-[#b7000c] focus:bg-white transition-all" />
          <button type="button"
                  id="clearSearchBtn"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden px-touch-target">
            <span class="material-symbols-outlined text-[18px]">cancel</span>
          </button>
        </div>

        <!-- Series Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
          <?php foreach ( $series_list as $s_key => $s_label ) : ?>
            <button type="button"
                    class="series-chip px-touch-target whitespace-nowrap px-4 py-2 rounded-xl text-[13px] sm:text-[14px] font-medium border border-[#E5E7EB] bg-[#f8f9fb] text-[#5f5e5e] hover:bg-[#ffdad5]/30 hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ( 'all' === $s_key ) ? 'active' : ''; ?>"
                    data-series="<?php echo esc_attr( $s_key ); ?>">
              <?php echo esc_html( $s_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>

      </div>

      <!-- Row 2: Material Filter + Brand Filter + Price + Sort -->
      <div class="pt-3.5 flex flex-wrap items-center justify-between gap-3">
        
        <!-- Material Chips -->
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wider hidden sm:inline">Chất liệu:</span>
          <?php foreach ( $materials as $m_key => $m_label ) : ?>
            <button type="button"
                    class="mat-chip px-touch-target whitespace-nowrap px-3.5 py-1.5 rounded-lg text-[12px] sm:text-[13px] font-medium border border-[#E5E7EB] bg-white text-[#5f5e5e] hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ( 'all' === $m_key ) ? 'active' : ''; ?>"
                    data-mat="<?php echo esc_attr( $m_key ); ?>">
              <?php echo esc_html( $m_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- Right Side: Brand + Price Range + Sort -->
        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto justify-end">
          
          <!-- Brand Select -->
          <div class="relative shrink-0">
            <select id="brandFilterSelect"
                    class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
              <option value="all">Tất cả thương hiệu</option>
              <?php foreach ( array_slice( $brands, 1 ) as $b_key => $b_label ) : ?>
                <option value="<?php echo esc_attr( $b_key ); ?>"><?php echo esc_html( $b_label ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Price Select -->
          <div class="relative shrink-0">
            <select id="priceFilterSelect"
                    class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
              <option value="all">Mọi mức giá</option>
              <option value="under-150">Dưới 150.000₫</option>
              <option value="150-250">150.000₫ - 250.000₫</option>
              <option value="250-350">250.000₫ - 350.000₫</option>
              <option value="above-350">Trên 350.000₫</option>
            </select>
          </div>

          <!-- Sort Select -->
          <div class="relative shrink-0">
            <select id="sortFilterSelect"
                    class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
              <option value="featured">Nổi bật / Bán chạy</option>
              <option value="price-asc">Giá thấp đến cao</option>
              <option value="price-desc">Giá cao đến thấp</option>
              <option value="discount-desc">% Giảm giá nhiều nhất</option>
            </select>
          </div>

          <!-- Reset Filter Button -->
          <button type="button"
                  id="resetAllFiltersBtn"
                  class="px-touch-target px-3 py-1.5 rounded-lg text-[13px] font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 hidden transition-all">
            <span class="material-symbols-outlined text-[16px] mr-1">restart_alt</span>
            <span>Đặt lại</span>
          </button>
        </div>

      </div>

      <!-- Active Filter Status & Product Counter -->
      <div class="mt-3.5 pt-3.5 border-t border-[#E5E7EB] flex flex-wrap items-center justify-between text-[13px] sm:text-[14px] text-[#5f5e5e] gap-2">
        <div>
          <span>Đang hiển thị: </span>
          <strong id="resultsCount" class="text-[#b7000c] font-bold"><?php echo esc_html( $total_crawled ); ?></strong>
          <span> / <?php echo esc_html( $total_crawled ); ?> sản phẩm dán camera PhoneX</span>
        </div>
        <div class="flex items-center gap-1.5 text-[12px] sm:text-[13px] text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/60">
          <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
          <span>100% Sản phẩm chính hãng • Bảo vệ ống kính, chống lóa flash</span>
        </div>
      </div>
    </div>

  </div>

  <!-- =========================================================================
       4. PRODUCT CATALOG GRID SECTION (SPACIOUS & AIRY)
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">

    <!-- Catalog Section Title -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="px-ds-h2 font-bold text-[#222222] tracking-tight">
          Danh mục Miếng Dán Bảo Vệ Camera
        </h2>
        <p class="text-[14px] text-[#5f5e5e] mt-1">
          Tuyển chọn kính và viền kim loại cao cấp, bảo vệ tuyệt đối camera lồi, giữ trọn chất lượng ảnh chụp
        </p>
      </div>
    </div>

    <!-- Products Grid (2 cols mobile, 3 cols tablet, 4 cols desktop, 5 cols 2xl) -->
    <div id="catalog-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 sm:gap-4 md:gap-5">
      
      <?php if ( ! empty( $crawled_products ) ) : ?>
        <?php foreach ( $crawled_products as $idx => $prod ) : ?>
          <?php
          $name         = $prod['name'];
          $price_fmt    = $prod['price_formatted'];
          $price_num    = (int) $prod['price'];
          $old_price    = $prod['price_old_formatted'];
          $old_num      = (int) $prod['price_old'];
          $discount_pct = (int) $prod['discount_percent'];
          $brand        = $prod['brand'];
          $dev_brand    = $prod['device_brand'];
          $dev_model    = $prod['device_model'];
          $type_name    = $prod['type'];
          $material     = $prod['material'];
          $specs        = $prod['specs'];
          $img_src      = get_template_directory_uri() . '/' . ltrim( $prod['image'], '/' );

          // Classify Series
          $name_lower = mb_strtolower( $name, 'UTF-8' );
          $series_slug = 'other';
          if ( strpos( $name_lower, '16' ) !== false ) {
              $series_slug = 'iphone-16';
          } elseif ( strpos( $name_lower, '15' ) !== false ) {
              $series_slug = 'iphone-15';
          } elseif ( strpos( $name_lower, '14' ) !== false ) {
              $series_slug = 'iphone-14';
          } elseif ( strpos( $name_lower, '13' ) !== false || strpos( $name_lower, '12' ) !== false || strpos( $name_lower, '11' ) !== false ) {
              $series_slug = 'iphone-13';
          } elseif ( strpos( $name_lower, 'air' ) !== false ) {
              $series_slug = 'iphone-air';
          }

          // Classify Material
          $mat_slug = 'other';
          if ( strpos( $name_lower, 'titan' ) !== false ) {
              $mat_slug = 'titanium';
          } elseif ( strpos( $name_lower, 'aluminium' ) !== false || strpos( $name_lower, 'nhôm' ) !== false ) {
              $mat_slug = 'aluminium';
          } elseif ( strpos( $name_lower, 'sapphire' ) !== false ) {
              $mat_slug = 'sapphire';
          } elseif ( strpos( $name_lower, 'pc' ) !== false || strpos( $name_lower, 'thuỷ tinh' ) !== false ) {
              $mat_slug = 'pc';
          }

          $is_hidden_initial = ( $idx >= 20 );
          ?>
          <div class="phonex-cam-card bg-white rounded-2xl p-3.5 sm:p-4 border border-[#E5E7EB] shadow-2xs relative group <?php echo $is_hidden_initial ? 'hidden' : ''; ?>"
               style="<?php echo $is_hidden_initial ? 'display: none !important;' : ''; ?>"
               data-idx="<?php echo esc_attr( $idx ); ?>"
               data-brand="<?php echo esc_attr( $brand ); ?>"
               data-series="<?php echo esc_attr( $series_slug ); ?>"
               data-mat="<?php echo esc_attr( $mat_slug ); ?>"
               data-price="<?php echo esc_attr( $price_num ); ?>"
               data-discount="<?php echo esc_attr( $discount_pct ); ?>"
               data-name="<?php echo esc_attr( $name_lower ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode( ' ', $specs ), 'UTF-8' ) ); ?>">

            <!-- Card Badges (Discount & Brand) -->
            <div class="flex items-center justify-between gap-1 mb-2">
              <span class="text-[11px] font-bold text-gray-600 bg-[#f2f4f6] px-2 py-0.5 rounded-md line-clamp-1">
                <?php echo esc_html( $brand ); ?>
              </span>
              <?php if ( $discount_pct > 0 ) : ?>
                <span class="text-[11px] font-bold text-white bg-[#e60012] px-2 py-0.5 rounded-md shadow-2xs">
                  -<?php echo esc_html( $discount_pct ); ?>%
                </span>
              <?php endif; ?>
            </div>

            <!-- Product Image Container -->
            <div class="relative w-full aspect-square bg-[#f8f9fb] rounded-xl overflow-hidden flex items-center justify-center p-3 mb-3 group-hover:bg-[#ffdad5]/10 transition-colors">
              <img src="<?php echo esc_url( $img_src ); ?>"
                   alt="<?php echo esc_attr( $name ); ?>"
                   loading="lazy"
                   class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                   onerror="this.src='https://placehold.co/400x400/f8f9fb/b7000c?text=PhoneX+Camera+Lens';" />
              
              <!-- Quick Badge Tag: Device Model -->
              <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur-xs px-2 py-0.5 rounded text-[10px] font-semibold text-gray-700 border border-gray-100 shadow-2xs line-clamp-1 max-w-[85%]">
                <?php echo esc_html( $dev_model ?: 'iPhone' ); ?>
              </div>
            </div>

            <!-- Product Title -->
            <h3 class="px-ds-prod-title mb-2" title="<?php echo esc_attr( $name ); ?>">
              <?php echo esc_html( $name ); ?>
            </h3>

            <!-- Key Feature Tags (First 2 specs) -->
            <div class="space-y-1 mb-3">
              <?php foreach ( array_slice( $specs, 0, 2 ) as $sp ) : ?>
                <div class="flex items-center gap-1.5 text-[11px] sm:text-[12px] text-[#5f5e5e] line-clamp-1">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#b7000c] shrink-0"></span>
                  <span class="truncate"><?php echo esc_html( $sp ); ?></span>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- Pricing Box -->
            <div class="mt-auto pt-2 border-t border-gray-100">
              <div class="flex items-baseline gap-2 mb-3">
                <span class="px-ds-price-primary">
                  <?php echo esc_html( $price_fmt ); ?>
                </span>
                <?php if ( $old_num > $price_num ) : ?>
                  <span class="px-ds-price-old">
                    <?php echo esc_html( $old_price ); ?>
                  </span>
                <?php endif; ?>
              </div>

              <!-- CTA Buy Button (touch target >= 44x44px) -->
              <?php
              $modal_data = array(
                  'name'         => $name,
                  'brand'        => $brand,
                  'image'        => $img_src,
                  'price'        => $price_num,
                  'price_old'    => $old_num,
                  'discount_pct' => $discount_pct,
                  'specs'        => $specs,
                  'permalink'    => home_url( '/lien-he/?product=' . rawurlencode( $name ) )
              );
              ?>
              <div class="flex flex-col gap-1.5 w-full">
                <a href="<?php echo esc_url( home_url( '/lien-he/?product=' . rawurlencode( $name ) ) ); ?>"
                   class="w-full px-ds-btn-cta bg-[#b7000c] hover:bg-[#C90010] text-white px-4 py-2 font-semibold text-[13px] sm:text-[14px] flex items-center justify-center gap-1.5 shadow-2xs hover:shadow-md">
                  <span class="material-symbols-outlined text-[17px]">shopping_bag</span>
                  <span>Đặt mua ngay</span>
                </a>
                <button type="button"
                        class="open-specs-modal-btn w-full min-h-[36px] rounded-[8px] border border-[#E5E7EB] bg-[#f8f9fb] hover:bg-[#ffdad5] text-[#222222] hover:text-[#b7000c] text-[12px] sm:text-[13px] font-semibold transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                        data-product="<?php echo esc_attr(wp_json_encode($modal_data)); ?>">
                  <span class="material-symbols-outlined text-[16px] text-[#e60012]">info</span>
                  Xem chi tiết
                </button>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col-span-full py-16 text-center text-gray-500">
          <span class="material-symbols-outlined text-[48px] text-gray-300 mb-2">photo_camera</span>
          <p class="text-[16px] font-medium">Chưa có dữ liệu dán camera. Vui lòng tải lại trang sau.</p>
        </div>
      <?php endif; ?>

    </div>

    <!-- Empty State Notification (Filtered Results = 0) -->
    <div id="noProductsFound" class="hidden py-16 text-center bg-white rounded-2xl border border-gray-200 mt-6 shadow-2xs">
      <span class="material-symbols-outlined text-[54px] text-gray-300 mb-3">filter_alt_off</span>
      <h3 class="text-[18px] font-bold text-gray-800 mb-1">Không tìm thấy sản phẩm phù hợp</h3>
      <p class="text-[14px] text-gray-500 mb-4">Vui lòng thay đổi từ khóa tìm kiếm hoặc điều chỉnh lại bộ lọc dòng máy.</p>
      <button type="button"
              onclick="document.getElementById('resetAllFiltersBtn').click();"
              class="px-ds-btn-cta bg-[#b7000c] text-white px-5 py-2.5 font-semibold text-[14px] inline-flex items-center gap-1.5 shadow-xs">
        <span class="material-symbols-outlined text-[18px]">refresh</span>
        <span>Xóa bộ lọc & xem lại tất cả</span>
      </button>
    </div>

    <!-- Load More / Pagination Button -->
    <?php if ( $total_crawled > 20 ) : ?>
      <div id="loadMoreWrap" class="mt-10 flex flex-col items-center justify-center">
        <button type="button"
                id="loadMoreBtn"
                class="px-ds-btn-cta bg-white hover:bg-[#ffdad5]/40 text-[#b7000c] border-2 border-[#b7000c] px-8 py-3 rounded-xl font-bold text-[15px] shadow-xs hover:shadow-md inline-flex items-center gap-2 transition-all">
          <span class="material-symbols-outlined text-[20px]">expand_more</span>
          <span>Xem thêm <span id="loadMoreRemainingCount"><?php echo esc_html( max( 0, $total_crawled - 20 ) ); ?></span> sản phẩm dán camera</span>
        </button>
      </div>
    <?php endif; ?>

  </div>

  <!-- =========================================================================
       5. BUYING GUIDE & WHY CHOOSE PHONEX CAMERA PROTECTORS
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-16">
    <div class="bg-white rounded-2xl p-6 sm:p-8 md:p-10 border border-[#E5E7EB] shadow-xs">
      
      <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="text-[12px] font-bold text-[#b7000c] bg-[#ffdad5] px-3 py-1 rounded-full uppercase tracking-wider">
          Tiêu Chuẩn PhoneX Care
        </span>
        <h2 class="px-ds-h2 font-bold text-[#222222] mt-3 mb-2">
          Vì Sao Cần Dán Bảo Vệ Cụm Camera Cho Smartphone?
        </h2>
        <p class="text-[14px] sm:text-[15px] text-[#5f5e5e]">
          Cụm camera trên các thế hệ iPhone, Samsung mới ngày càng lồi cao và có chi phí thay thế rất lớn. Miếng dán camera PhoneX mang lại giải pháp bảo vệ toàn diện không làm giảm chất lượng ảnh.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Pillar 1 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">photo_camera</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">
            Độ Trong Suốt Thấu Kính Quang Học 99.9%
          </h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Mặt kính quang học cao cấp phủ lớp chống phản xạ AR, bảo toàn độ sắc nét, màu sắc và khả năng zoom quang học của cảm biến máy ảnh.
          </p>
        </div>

        <!-- Pillar 2 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">flash_on</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">
            Vòng Đệm Cách Ly Chống Lóa Flash Đêm
          </h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Thiết kế vòng đệm đen chuyên dụng quanh lỗ flash và ống kính ngăn hiện tượng phản quang quầng trắng khi chụp đêm hoặc quay video thiếu sáng.
          </p>
        </div>

        <!-- Pillar 3 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">shield</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">
            Khung Viền Hợp Kim Titanium & Nhôm CNC
          </h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Gia công chuẩn xác từng milimet khớp trọn với màu viền máy của iPhone, hấp thụ chấn động và chống trầy xước cạnh viền camera khi đặt lên bàn.
          </p>
        </div>

      </div>

    </div>
  </div>

</main>

<!-- =========================================================================
     FAST CLIENT JAVASCRIPT: FILTERING, SORTING, SEARCH & PAGINATION
     ========================================================================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const allCards = Array.from(document.querySelectorAll('.phonex-cam-card'));
  const seriesChips = Array.from(document.querySelectorAll('.series-chip'));
  const matChips = Array.from(document.querySelectorAll('.mat-chip'));
  const brandSelect = document.getElementById('brandFilterSelect');
  const priceSelect = document.getElementById('priceFilterSelect');
  const sortSelect = document.getElementById('sortFilterSelect');
  const searchInput = document.getElementById('camSearchInput');
  const clearSearchBtn = document.getElementById('clearSearchBtn');
  const resetBtn = document.getElementById('resetAllFiltersBtn');
  const resultsCount = document.getElementById('resultsCount');
  const noProducts = document.getElementById('noProductsFound');
  const loadMoreWrap = document.getElementById('loadMoreWrap');
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const loadMoreRemaining = document.getElementById('loadMoreRemainingCount');

  let currentSeries = 'all';
  let currentMat = 'all';
  let currentBrand = 'all';
  let currentPrice = 'all';
  let currentSort = 'featured';
  let searchQuery = '';
  let visibleLimit = 20;

  function filterAndSortProducts() {
    let matched = allCards.filter(card => {
      const series = card.dataset.series || '';
      const mat = card.dataset.mat || '';
      const brand = card.dataset.brand || '';
      const price = parseInt(card.dataset.price || '0', 10);
      const name = card.dataset.name || '';
      const specs = card.dataset.specs || '';

      // Filter by Series
      if (currentSeries !== 'all' && series !== currentSeries) {
        return false;
      }

      // Filter by Material
      if (currentMat !== 'all' && mat !== currentMat) {
        return false;
      }

      // Filter by Brand
      if (currentBrand !== 'all' && brand !== currentBrand) {
        return false;
      }

      // Filter by Price
      if (currentPrice === 'under-150' && price >= 150000) return false;
      if (currentPrice === '150-250' && (price < 150000 || price > 250000)) return false;
      if (currentPrice === '250-350' && (price < 250000 || price > 350000)) return false;
      if (currentPrice === 'above-350' && price <= 350000) return false;

      // Filter by Search Query
      if (searchQuery.length > 0) {
        const q = searchQuery.toLowerCase();
        if (!name.includes(q) && !specs.includes(q) && !brand.toLowerCase().includes(q)) {
          return false;
        }
      }

      return true;
    });

    // Sorting
    matched.sort((a, b) => {
      const priceA = parseInt(a.dataset.price || '0', 10);
      const priceB = parseInt(b.dataset.price || '0', 10);
      const discA = parseInt(a.dataset.discount || '0', 10);
      const discB = parseInt(b.dataset.discount || '0', 10);
      const idxA = parseInt(a.dataset.idx || '0', 10);
      const idxB = parseInt(b.dataset.idx || '0', 10);

      if (currentSort === 'price-asc') return priceA - priceB;
      if (currentSort === 'price-desc') return priceB - priceA;
      if (currentSort === 'discount-desc') return discB - discA;
      return idxA - idxB;
    });

    // Update Counter
    if (resultsCount) resultsCount.textContent = matched.length;

    // Toggle Empty State
    if (matched.length === 0) {
      allCards.forEach(c => {
        c.style.display = 'none';
        c.classList.add('hidden');
      });
      if (noProducts) noProducts.classList.remove('hidden');
      if (loadMoreWrap) loadMoreWrap.classList.add('hidden');
      return;
    } else {
      if (noProducts) noProducts.classList.add('hidden');
    }

    // Render sorted elements
    const grid = document.getElementById('catalog-grid');
    matched.forEach((card, i) => {
      grid.appendChild(card);
      if (i < visibleLimit) {
        card.style.display = 'flex';
        card.classList.remove('hidden');
      } else {
        card.style.display = 'none';
        card.classList.add('hidden');
      }
    });

    // Hide untouched cards
    allCards.forEach(card => {
      if (!matched.includes(card)) {
        card.style.display = 'none';
        card.classList.add('hidden');
      }
    });

    // Update Load More Button
    const remaining = matched.length - visibleLimit;
    if (remaining > 0) {
      if (loadMoreWrap) loadMoreWrap.classList.remove('hidden');
      if (loadMoreRemaining) loadMoreRemaining.textContent = remaining;
    } else {
      if (loadMoreWrap) loadMoreWrap.classList.add('hidden');
    }

    // Toggle Reset Button
    const isFiltered = (currentSeries !== 'all' || currentMat !== 'all' || currentBrand !== 'all' || currentPrice !== 'all' || currentSort !== 'featured' || searchQuery.length > 0);
    if (resetBtn) {
      if (isFiltered) resetBtn.classList.remove('hidden');
      else resetBtn.classList.add('hidden');
    }
  }

  // Series Chip Click
  seriesChips.forEach(chip => {
    chip.addEventListener('click', function() {
      seriesChips.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      currentSeries = this.dataset.series;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  });

  // Material Chip Click
  matChips.forEach(chip => {
    chip.addEventListener('click', function() {
      matChips.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      currentMat = this.dataset.mat;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  });

  // Select Filters
  if (brandSelect) {
    brandSelect.addEventListener('change', function() {
      currentBrand = this.value;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  if (priceSelect) {
    priceSelect.addEventListener('change', function() {
      currentPrice = this.value;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  if (sortSelect) {
    sortSelect.addEventListener('change', function() {
      currentSort = this.value;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  // Search Input
  let searchDebounceTimer;
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      clearTimeout(searchDebounceTimer);
      searchQuery = this.value.trim();
      if (clearSearchBtn) {
        if (searchQuery.length > 0) clearSearchBtn.classList.remove('hidden');
        else clearSearchBtn.classList.add('hidden');
      }
      searchDebounceTimer = setTimeout(() => {
        visibleLimit = 20;
        filterAndSortProducts();
      }, 150);
    });
  }

  // Clear Search
  if (clearSearchBtn) {
    clearSearchBtn.addEventListener('click', function() {
      if (searchInput) {
        searchInput.value = '';
        searchQuery = '';
        clearSearchBtn.classList.add('hidden');
        visibleLimit = 20;
        filterAndSortProducts();
        searchInput.focus();
      }
    });
  }

  // Load More Button
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
      visibleLimit += 20;
      filterAndSortProducts();
    });
  }

  // Reset Button
  if (resetBtn) {
    resetBtn.addEventListener('click', function() {
      currentSeries = 'all';
      currentMat = 'all';
      currentBrand = 'all';
      currentPrice = 'all';
      currentSort = 'featured';
      searchQuery = '';

      if (searchInput) searchInput.value = '';
      if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
      if (brandSelect) brandSelect.value = 'all';
      if (priceSelect) priceSelect.value = 'all';
      if (sortSelect) sortSelect.value = 'featured';

      seriesChips.forEach(c => {
        if (c.dataset.series === 'all') c.classList.add('active');
        else c.classList.remove('active');
      });

      matChips.forEach(c => {
        if (c.dataset.mat === 'all') c.classList.add('active');
        else c.classList.remove('active');
      });

      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  // Initial render on page load
  filterAndSortProducts();
});
</script>

<?php
get_footer();
