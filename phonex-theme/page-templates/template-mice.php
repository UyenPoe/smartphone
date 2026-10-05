<?php
/**
 * Template Name: PhoneX Chuột Máy Tính Chính Hãng
 *
 * Dedicated Mouse Catalog Page
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
 *    - Button CTA chính: 15-16px / 600, radius 8px, touch target >= 44x44px
 *    - Badge: 11-12px / 600-700, radius 6px
 *    - Hero Promo Card: background-color: var(--px-primary-fixed);
 *    - Hoàn toàn KHÔNG để bất kỳ thông tin nào liên quan đến Thế Giới Di Động ở phía người dùng.
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD MICE DATA FROM LOCAL CACHE
// =========================================================================
$json_path = get_template_directory() . '/data/mice.json';
$crawled_products = array();

if ( file_exists( $json_path ) ) {
	$json_content    = file_get_contents( $json_path );
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

// Category Types Filter
$cat_types = array(
	'all'              => 'Tất cả chuột',
	'chuot-gaming'     => 'Chuột Gaming',
	'chuot-bluetooth'  => 'Chuột Bluetooth',
	'chuot-khong-day'  => 'Chuột Không dây',
	'chuot-co-day'     => 'Chuột Có dây',
);

// Brand list for filter bar
$brands = array(
	'all'        => 'Tất cả hãng',
	'Logitech'   => 'Logitech',
	'Razer'      => 'Razer',
	'Apple'      => 'Apple',
	'Asus'       => 'Asus',
	'Rapoo'      => 'Rapoo',
	'DareU'      => 'DareU',
	'EDRA'       => 'EDRA',
	'HP'         => 'HP',
	'Corsair'    => 'Corsair',
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
  display: inline-flex;
  align-items: center;
  transition: background-color 0.18s ease, box-shadow 0.18s ease;
}

/* Touch target minimum */
.px-touch-target {
  min-height: 44px;
  min-width: 44px;
}

/* Chip active state */
.cat-chip.active,
.brand-chip.active {
  background-color: #b7000c !important;
  color: #ffffff !important;
  border-color: #b7000c !important;
  box-shadow: 0 2px 8px rgba(183, 0, 12, 0.25);
}

/* No scrollbar utility */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Line clamp */
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

/* Unibody Spacious Product Card */
.phonex-mouse-card {
  transition: transform 0.24s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.24s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.24s ease;
  will-change: transform, box-shadow;
  display: flex;
  flex-direction: column;
}
.phonex-mouse-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px -6px rgba(183, 0, 12, 0.12), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
  border-color: #ffb4aa;
}
.phonex-mouse-card.hidden {
  display: none !important;
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
        <span class="text-[#222222] font-semibold">Chuột Máy Tính</span>
      </nav>
    </div>
  </div>

  <!-- =========================================================================
       2. HERO PROMOTIONS GRID
       HERO CARD: background-color: var(--px-primary-fixed);
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <!-- MAIN PROMO CARD (2 COLUMNS) -->
      <div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]" style="background-color: var(--px-primary-fixed);">
        
        <!-- Ambient glow effects -->
        <div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
          <span class="material-symbols-outlined text-[240px] text-[#b7000c]">mouse</span>
        </div>

        <div class="relative z-10 max-w-2xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/90 border border-[#b7000c]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-[#e60012] animate-pulse"></span>
            PHONEX PERIPHERAL STORE • CHUỘT CHÍNH HÃNG
          </div>
          <h1 class="px-ds-h1 font-bold text-[#222222] tracking-tight mb-3">
            Chuột Máy Tính Chính Hãng: Gaming, Bluetooth & Không Dây PhoneX
          </h1>
          <p class="text-[14px] sm:text-[16px] text-[#444444] leading-relaxed mb-6 font-normal">
            Tuyển chọn <?php echo esc_html( $total_crawled ); ?> mẫu chuột chính hãng từ Logitech, Razer, Apple, Asus, Rapoo... Từ chuột gaming DPI siêu cao đến chuột Bluetooth mỏng nhẹ văn phòng, phù hợp mọi nhu cầu làm việc và giải trí.
          </p>
          <div class="flex flex-wrap items-center gap-3">
            <a href="#catalog-grid" class="px-ds-btn-cta bg-[#b7000c] hover:bg-[#C90010] text-white px-6 py-2.5 shadow-md hover:shadow-lg inline-flex items-center gap-2">
              <span class="material-symbols-outlined text-[19px]">mouse</span>
              <span>Xem <?php echo esc_html( $total_crawled ); ?> sản phẩm</span>
            </a>
            <div class="inline-flex items-center gap-1.5 text-[13px] text-[#6d1316] font-medium bg-white/70 px-3 py-2 rounded-lg border border-[#ffb4aa]/60">
              <span class="material-symbols-outlined text-[17px] text-[#b7000c]">wifi</span>
              <span>Không dây 2.4GHz & Bluetooth 5.0</span>
            </div>
          </div>
        </div>

        <!-- Trust Badges inside Hero -->
        <div class="relative z-10 mt-6 pt-4 border-t border-[#ffb4aa]/80 grid grid-cols-2 sm:grid-cols-4 gap-2 text-[12px] sm:text-[13px] font-medium text-[#4a1c1d]">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">sports_esports</span>
            <span>Chuột Gaming RGB</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">bluetooth</span>
            <span>Bluetooth đa thiết bị</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">battery_charging_full</span>
            <span>Pin sạc USB-C</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#b7000c] text-[18px]">verified</span>
            <span>Bảo hành 1 đổi 1 12T</span>
          </div>
        </div>
      </div>

      <!-- SIDE PROMO CARD -->
      <div class="relative rounded-2xl p-6 sm:p-7 shadow-xs flex flex-col justify-between overflow-hidden bg-white border border-[#E5E7EB]">
        <div>
          <div class="flex items-center justify-between mb-4">
            <span class="text-[12px] font-bold text-white bg-[#e60012] px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Bán Chạy Nhất
            </span>
            <span class="text-[12px] text-[#5f5e5e] font-medium flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px] text-amber-500">stars</span>
              PhoneX Store
            </span>
          </div>
          <h2 class="px-ds-h3 font-bold text-[#222222] mb-2">
            Top Chuột Không Dây Bán Chạy
          </h2>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] mb-5 leading-normal">
            Những mẫu chuột không dây được yêu thích nhất – thiết kế ergonomic, tín hiệu ổn định, pin bền.
          </p>

          <div class="space-y-2.5 bg-[#f8f9fb] p-3.5 rounded-xl border border-gray-100 mb-5">
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                Logitech Signature M650 Silent
              </span>
              <span class="font-bold text-[#b7000c]">Từ 645.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                Apple Magic Mouse USB C
              </span>
              <span class="font-bold text-[#b7000c]">Từ 1.890.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>
                Logitech MX Anywhere 3S
              </span>
              <span class="font-bold text-[#b7000c]">Từ 1.390.000₫</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?php echo esc_url( home_url( '/hub-chuyen-doi/' ) ); ?>" class="w-full px-ds-btn-cta bg-[#f8f9fb] hover:bg-[#ffdad5]/40 text-[#b7000c] border border-[#ffb4aa] px-4 py-2.5 text-center font-semibold text-[14px] flex items-center justify-center gap-2">
            <span>Xem Hub & Cáp Chuyển Đổi</span>
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
    
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs">

      <!-- Row 1: Search + Category Chips -->
      <div class="flex flex-col md:flex-row md:items-center gap-3.5 pb-4 border-b border-[#E5E7EB]">
        
        <!-- Live Search -->
        <div class="relative w-full md:w-80 shrink-0">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <span class="material-symbols-outlined text-[20px]">search</span>
          </span>
          <input type="text"
                 id="mouseSearchInput"
                 placeholder="Tìm chuột (Logitech, Razer, gaming, bluetooth...)"
                 class="w-full px-ds-input pl-10 pr-9 bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl text-[15px] sm:text-[16px] text-[#222222] placeholder-gray-400 focus:outline-none focus:border-[#b7000c] focus:bg-white transition-all" />
          <button type="button"
                  id="clearSearchBtn"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden px-touch-target">
            <span class="material-symbols-outlined text-[18px]">cancel</span>
          </button>
        </div>

        <!-- Category Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
          <?php foreach ( $cat_types as $c_key => $c_label ) : ?>
            <button type="button"
                    class="cat-chip px-touch-target whitespace-nowrap px-4 py-2 rounded-xl text-[13px] sm:text-[14px] font-medium border border-[#E5E7EB] bg-[#f8f9fb] text-[#5f5e5e] hover:bg-[#ffdad5]/30 hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ( 'all' === $c_key ) ? 'active' : ''; ?>"
                    data-cat="<?php echo esc_attr( $c_key ); ?>">
              <?php echo esc_html( $c_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>

      </div>

      <!-- Row 2: Brand Chips + Price + Sort -->
      <div class="pt-3.5 flex flex-wrap items-center justify-between gap-3">
        
        <!-- Brand Chips -->
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wider hidden sm:inline">Hãng:</span>
          <?php foreach ( array_slice( $brands, 0, 7 ) as $b_key => $b_label ) : ?>
            <button type="button"
                    class="brand-chip px-touch-target whitespace-nowrap px-3.5 py-1.5 rounded-lg text-[12px] sm:text-[13px] font-medium border border-[#E5E7EB] bg-white text-[#5f5e5e] hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ( 'all' === $b_key ) ? 'active' : ''; ?>"
                    data-brand="<?php echo esc_attr( $b_key ); ?>">
              <?php echo esc_html( $b_label ); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- Right: Brand Select + Price + Sort -->
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
              <option value="under-200">Dưới 200.000₫</option>
              <option value="200-500">200.000₫ - 500.000₫</option>
              <option value="500-1000">500.000₫ - 1.000.000₫</option>
              <option value="above-1000">Trên 1.000.000₫</option>
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

          <!-- Reset Button -->
          <button type="button"
                  id="resetAllFiltersBtn"
                  class="px-touch-target px-3 py-1.5 rounded-lg text-[13px] font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 hidden transition-all">
            <span class="material-symbols-outlined text-[16px] mr-1">restart_alt</span>
            <span>Đặt lại</span>
          </button>
        </div>

      </div>

      <!-- Active Filter Status & Counter -->
      <div class="mt-3.5 pt-3.5 border-t border-[#E5E7EB] flex flex-wrap items-center justify-between text-[13px] sm:text-[14px] text-[#5f5e5e] gap-2">
        <div>
          <span>Đang hiển thị: </span>
          <strong id="resultsCount" class="text-[#b7000c] font-bold"><?php echo esc_html( $total_crawled ); ?></strong>
          <span> / <?php echo esc_html( $total_crawled ); ?> chuột máy tính PhoneX</span>
        </div>
        <div class="flex items-center gap-1.5 text-[12px] sm:text-[13px] text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/60">
          <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
          <span>100% Chính hãng • Bảo hành 12 tháng tại PhoneX</span>
        </div>
      </div>
    </div>

  </div>

  <!-- =========================================================================
       4. PRODUCT CATALOG GRID
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">

    <!-- Catalog Title -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="px-ds-h2 font-bold text-[#222222] tracking-tight">
          Danh mục Chuột Máy Tính
        </h2>
        <p class="text-[14px] text-[#5f5e5e] mt-1">
          Tuyển chọn chuột gaming, bluetooth, không dây và có dây chính hãng – bảo hành đầy đủ
        </p>
      </div>
    </div>

    <!-- Products Grid -->
    <div id="catalog-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 sm:gap-4 md:gap-5">
      
      <?php if ( ! empty( $crawled_products ) ) : ?>
        <?php foreach ( $crawled_products as $idx => $prod ) : ?>
          <?php
          $name         = $prod['name'];
          $price_num    = (int) $prod['price'];
          $old_num      = (int) $prod['old_price'];
          $discount_pct = (int) $prod['discount_pct'];
          $brand        = $prod['brand'];
          $subfolder    = $prod['subfolder'];
          $type_name    = $prod['type'];
          $specs        = $prod['specs'];
          $img_src      = get_template_directory_uri() . '/' . ltrim( $prod['image'], '/' );

          $price_fmt    = number_format( $price_num, 0, ',', '.' ) . '₫';
          $old_fmt      = $old_num ? number_format( $old_num, 0, ',', '.' ) . '₫' : '';

          $is_hidden_initial = ( $idx >= 20 );
          ?>
          <div class="phonex-mouse-card bg-white rounded-2xl p-3.5 sm:p-4 border border-[#E5E7EB] shadow-2xs relative group <?php echo $is_hidden_initial ? 'hidden' : ''; ?>"
               style="<?php echo $is_hidden_initial ? 'display: none !important;' : ''; ?>"
               data-idx="<?php echo esc_attr( $idx ); ?>"
               data-brand="<?php echo esc_attr( $brand ); ?>"
               data-cat="<?php echo esc_attr( $subfolder ); ?>"
               data-price="<?php echo esc_attr( $price_num ); ?>"
               data-discount="<?php echo esc_attr( $discount_pct ); ?>"
               data-name="<?php echo esc_attr( mb_strtolower( $name, 'UTF-8' ) ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode( ' ', $specs ), 'UTF-8' ) ); ?>">

            <!-- Card Badges -->
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

            <!-- Product Image -->
            <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-[#f8f9fb] mb-3 flex items-center justify-center">
              <img src="<?php echo esc_url( $img_src ); ?>"
                   alt="<?php echo esc_attr( $name ); ?>"
                   class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300"
                   loading="lazy"
                   width="300" height="300" />
              <!-- Type Badge Overlay -->
              <?php
              $type_icon = 'mouse';
              if ( $subfolder === 'chuot-gaming' ) $type_icon = 'sports_esports';
              elseif ( $subfolder === 'chuot-bluetooth' ) $type_icon = 'bluetooth';
              elseif ( $subfolder === 'chuot-khong-day' ) $type_icon = 'wifi';
              elseif ( $subfolder === 'chuot-co-day' ) $type_icon = 'usb';
              ?>
              <div class="absolute bottom-2 left-2 flex items-center gap-1 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-full text-[10px] font-semibold text-[#5f5e5e] shadow-2xs">
                <span class="material-symbols-outlined text-[12px] text-[#b7000c]"><?php echo $type_icon; ?></span>
                <span class="line-clamp-1 max-w-[90px]"><?php echo esc_html( $type_name ); ?></span>
              </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col flex-1 gap-1.5">
              <!-- Product Name -->
              <h3 class="px-ds-prod-title">
                <?php echo esc_html( $name ); ?>
              </h3>

              <!-- Specs (1 item preview) -->
              <?php if ( ! empty( $specs[0] ) ) : ?>
                <p class="text-[11px] sm:text-[12px] text-[#5f5e5e] leading-snug line-clamp-1 mt-0.5">
                  <?php echo esc_html( $specs[0] ); ?>
                </p>
              <?php endif; ?>

              <!-- Price Block -->
              <div class="mt-auto pt-2">
                <?php if ( $old_num > $price_num ) : ?>
                  <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="px-ds-price-primary"><?php echo esc_html( $price_fmt ); ?></span>
                    <span class="px-ds-price-old"><?php echo esc_html( $old_fmt ); ?></span>
                  </div>
                <?php else : ?>
                  <span class="px-ds-price-primary"><?php echo esc_html( $price_fmt ); ?></span>
                <?php endif; ?>
              </div>

              <!-- CTA Button -->
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
              <div class="mt-2 flex flex-col gap-1.5 w-full">
                <a href="<?php echo esc_url( home_url( '/lien-he/?product=' . rawurlencode( $name ) ) ); ?>"
                   class="w-full px-ds-btn-cta bg-[#b7000c] hover:bg-[#C90010] text-white text-center justify-center text-[13px] sm:text-[14px] px-3 py-2 shadow-sm">
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
        <div class="col-span-full text-center py-20 text-[#5f5e5e]">
          <span class="material-symbols-outlined text-[64px] text-gray-200 block mb-3">mouse</span>
          <p class="text-[16px] font-semibold">Chưa có dữ liệu sản phẩm</p>
          <p class="text-[14px] mt-1">Vui lòng kiểm tra lại sau.</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- No Results State -->
    <div id="noResultsState" class="hidden flex-col items-center justify-center py-20 text-[#5f5e5e]">
      <span class="material-symbols-outlined text-[64px] text-gray-200 block mb-3">search_off</span>
      <p class="text-[17px] font-semibold text-[#222222]">Không tìm thấy sản phẩm phù hợp</p>
      <p class="text-[14px] mt-1 mb-5">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
      <button type="button" id="noResultsResetBtn"
              class="px-ds-btn-cta bg-[#b7000c] text-white px-5 py-2.5 text-[14px]">
        Xóa bộ lọc
      </button>
    </div>

    <!-- Load More Section -->
    <div id="loadMoreSection" class="mt-10 flex flex-col items-center gap-4">
      <!-- Progress bar -->
      <div class="w-full max-w-sm">
        <div class="flex items-center justify-between text-[12px] text-[#5f5e5e] mb-1.5">
          <span>Đang hiển thị <strong id="shownCount" class="text-[#222222]">20</strong> / <strong><?php echo esc_html( $total_crawled ); ?></strong> sản phẩm</span>
        </div>
        <div class="w-full bg-[#E5E7EB] rounded-full h-1.5 overflow-hidden">
          <div id="progressBar" class="bg-[#b7000c] h-1.5 rounded-full transition-all duration-500" style="width: <?php echo min( 100, round( 20 / max( 1, $total_crawled ) * 100 ) ); ?>%"></div>
        </div>
      </div>
      <!-- Load More Button -->
      <button type="button"
              id="loadMoreBtn"
              class="px-ds-btn-cta bg-white hover:bg-[#ffdad5]/30 text-[#b7000c] border-2 border-[#b7000c] px-8 py-3 text-[15px] gap-2">
        <span class="material-symbols-outlined text-[20px]">expand_more</span>
        <span>Xem thêm chuột máy tính</span>
      </button>
    </div>

  </div>

  <!-- =========================================================================
       5. BUYING GUIDE — CÁCH CHỌN CHUỘT PHÙ HỢP NHU CẦU
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-16">
    <div class="bg-white rounded-2xl p-6 sm:p-8 md:p-10 border border-[#E5E7EB] shadow-xs">

      <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="text-[12px] font-bold text-[#b7000c] bg-[#ffdad5] px-3 py-1 rounded-full uppercase tracking-wider">Hướng Dẫn Lựa Chọn</span>
        <h2 class="px-ds-h2 font-bold text-[#222222] mt-3 mb-2">Cách Chọn Chuột Máy Tính Phù Hợp Nhu Cầu</h2>
        <p class="text-[14px] sm:text-[15px] text-[#5f5e5e]">Tuỳ theo nhu cầu gaming, làm việc văn phòng hay di chuyển mà bạn có thể lựa chọn loại chuột tối ưu nhất.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Pillar 1 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">sports_esports</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Chuột Gaming — DPI Siêu Cao</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Chọn chuột gaming nếu bạn cần độ chính xác tuyệt đối trong từng game FPS, MOBA. Ưu tiên chuột có DPI từ 3200 trở lên, switch bền 50 triệu lần bấm, tốc độ polling ≥ 1000Hz để không bỏ lỡ bất kỳ khoảnh khắc nào.
          </p>
        </div>

        <!-- Pillar 2 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">bluetooth</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Chuột Bluetooth — Đa Thiết Bị</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Làm việc với nhiều thiết bị cùng lúc (laptop, iPad, điện thoại)? Chọn chuột Bluetooth hỗ trợ kết nối đồng thời tối đa 3 thiết bị và chuyển đổi bằng một nút bấm. Pin sạc USB-C dùng hàng tháng.
          </p>
        </div>

        <!-- Pillar 3 -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">wifi</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Chuột Không Dây 2.4GHz — Tín Hiệu Cực Ổn</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Nếu cần sự ổn định tuyệt đối mà không muốn dây vướng víu, chuột không dây 2.4GHz qua USB Nano Receiver là lựa chọn tốt nhất cho văn phòng và học tập — độ trễ gần như bằng 0.
          </p>
        </div>

      </div>
    </div>
  </div>

  <!-- =========================================================================
       6. XEM THÊM DANH MỤC PHỤ KIỆN LIÊN QUAN
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-4">

    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="px-ds-h2 font-bold text-[#222222] tracking-tight">Khám Phá Thêm Phụ Kiện Chính Hãng</h2>
        <p class="text-[14px] text-[#5f5e5e] mt-1">Bộ sưu tập phụ kiện chính hãng đa dạng — cáp sạc, ốp lưng, bàn phím, hub chuyển đổi & nhiều hơn nữa.</p>
      </div>
      <a href="<?php echo esc_url( home_url('/phu-kien/') ); ?>"
         class="hidden sm:inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#b7000c] hover:text-[#C90010] transition-colors whitespace-nowrap">
        Xem tất cả phụ kiện
        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

      <!-- Card 1: Bàn phím -->
      <a href="<?php echo esc_url( home_url('/ban-phim/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">keyboard</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Bàn phím</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Bàn Phím Gaming, Bluetooth & Văn Phòng</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Switch cơ, Bluetooth đa thiết bị, không dây 2.4GHz từ Logitech, Razer, Apple, Keychron.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 2: Hub, Cáp Chuyển Đổi -->
      <a href="<?php echo esc_url( home_url('/hub-chuyen-doi/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">hub</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Hub & Cáp</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Hub Type-C, Cáp HDMI & Đầu Chuyển Đổi</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Mở rộng cổng kết nối 4K, sạc PD 100W, cổng LAN Gigabit từ Ugreen, HyperDrive, Belkin.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 3: Sạc & Cáp -->
      <a href="<?php echo esc_url( home_url('/sac-cap/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">cable</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Cáp sạc</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Củ Sạc, Cáp Sạc Nhanh GaN & Type-C</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Sạc nhanh 65W–140W, cáp USB-C bền bỉ từ Anker, Ugreen, Baseus, Apple.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 4: Ốp lưng -->
      <a href="<?php echo esc_url( home_url('/op-lung-flipcover/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">phone_iphone</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Ốp lưng</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Ốp Lưng & Flip Cover Điện Thoại</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Bảo vệ toàn diện cho iPhone, Samsung, Xiaomi với chất liệu cao cấp chống sốc tốt nhất.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

    </div>

    <!-- Mobile: Xem tất cả link -->
    <div class="mt-6 sm:hidden text-center">
      <a href="<?php echo esc_url( home_url('/phu-kien/') ); ?>"
         class="inline-flex items-center gap-1.5 text-[14px] font-semibold text-[#b7000c] hover:text-[#C90010]">
        Xem tất cả phụ kiện <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
      </a>
    </div>

  </div>

</main>

<script>
(function() {
  'use strict';

  // =========================================================================
  // PHONEX MOUSE CATALOG FILTER ENGINE
  // =========================================================================
  const allCards    = Array.from(document.querySelectorAll('.phonex-mouse-card'));
  const searchInput = document.getElementById('mouseSearchInput');
  const clearBtn    = document.getElementById('clearSearchBtn');
  const catChips    = document.querySelectorAll('.cat-chip');
  const brandChips  = document.querySelectorAll('.brand-chip');
  const brandSelect = document.getElementById('brandFilterSelect');
  const priceSelect = document.getElementById('priceFilterSelect');
  const sortSelect  = document.getElementById('sortFilterSelect');
  const resetBtn    = document.getElementById('resetAllFiltersBtn');
  const loadMoreBtn = document.getElementById('loadMoreBtn');
  const loadMoreSec = document.getElementById('loadMoreSection');
  const noResults   = document.getElementById('noResultsState');
  const resultsCount = document.getElementById('resultsCount');
  const shownCount  = document.getElementById('shownCount');
  const progressBar = document.getElementById('progressBar');
  const noResultsResetBtn = document.getElementById('noResultsResetBtn');

  let currentCat   = 'all';
  let currentBrand = 'all';
  let currentPrice = 'all';
  let currentSort  = 'featured';
  let searchQuery  = '';
  let visibleLimit = 20;

  function matchesPrice(priceNum, range) {
    if (range === 'all') return true;
    if (range === 'under-200')  return priceNum < 200000;
    if (range === '200-500')    return priceNum >= 200000 && priceNum <= 500000;
    if (range === '500-1000')   return priceNum >= 500000 && priceNum <= 1000000;
    if (range === 'above-1000') return priceNum > 1000000;
    return true;
  }

  function filterAndSortProducts() {
    // Filter pass
    let filtered = allCards.filter(card => {
      const cat      = card.dataset.cat || '';
      const brand    = card.dataset.brand || '';
      const priceNum = parseInt(card.dataset.price, 10) || 0;
      const name     = card.dataset.name || '';
      const specs    = card.dataset.specs || '';

      if (currentCat !== 'all' && cat !== currentCat) return false;
      if (currentBrand !== 'all' && brand.toLowerCase() !== currentBrand.toLowerCase()) return false;
      if (!matchesPrice(priceNum, currentPrice)) return false;
      if (searchQuery) {
        const q = searchQuery.toLowerCase();
        if (!name.includes(q) && !specs.includes(q) && !brand.toLowerCase().includes(q)) return false;
      }
      return true;
    });

    // Sort pass
    filtered.sort((a, b) => {
      const aPrice    = parseInt(a.dataset.price, 10) || 0;
      const bPrice    = parseInt(b.dataset.price, 10) || 0;
      const aDiscount = parseInt(a.dataset.discount, 10) || 0;
      const bDiscount = parseInt(b.dataset.discount, 10) || 0;
      const aIdx      = parseInt(a.dataset.idx, 10) || 0;
      const bIdx      = parseInt(b.dataset.idx, 10) || 0;

      if (currentSort === 'price-asc')      return aPrice - bPrice;
      if (currentSort === 'price-desc')     return bPrice - aPrice;
      if (currentSort === 'discount-desc')  return bDiscount - aDiscount;
      return aIdx - bIdx; // featured
    });

    // Show/hide all cards, then apply visible limit
    allCards.forEach(c => {
      c.classList.add('hidden');
      c.style.display = 'none';
    });

    const visible = filtered.slice(0, visibleLimit);
    visible.forEach(c => {
      c.classList.remove('hidden');
      c.style.removeProperty('display');
    });

    // Update UI
    const total    = filtered.length;
    const shown    = Math.min(total, visibleLimit);
    const totalAll = allCards.length;

    if (resultsCount) resultsCount.textContent = shown;
    if (shownCount)   shownCount.textContent   = shown;
    if (progressBar) {
      const pct = totalAll > 0 ? Math.min(100, Math.round(shown / totalAll * 100)) : 100;
      progressBar.style.width = pct + '%';
    }

    // Load more visibility
    if (loadMoreSec) {
      if (shown < total) {
        loadMoreSec.style.display = 'flex';
      } else {
        loadMoreSec.style.display = 'none';
      }
    }

    // No results state
    if (noResults) {
      if (total === 0) {
        noResults.classList.remove('hidden');
        noResults.style.display = 'flex';
      } else {
        noResults.classList.add('hidden');
        noResults.style.display = '';
      }
    }

    // Reset button visibility
    const isFiltered = currentCat !== 'all' || currentBrand !== 'all' || currentPrice !== 'all' || currentSort !== 'featured' || searchQuery;
    if (resetBtn) {
      resetBtn.classList.toggle('hidden', !isFiltered);
    }
  }

  // Category chip clicks
  catChips.forEach(chip => {
    chip.addEventListener('click', function() {
      currentCat = this.dataset.cat;
      catChips.forEach(c => {
        if (c.dataset.cat === currentCat) c.classList.add('active');
        else c.classList.remove('active');
      });
      visibleLimit = 20;
      filterAndSortProducts();
    });
  });

  // Brand chip clicks
  brandChips.forEach(chip => {
    chip.addEventListener('click', function() {
      currentBrand = this.dataset.brand;
      brandChips.forEach(c => {
        if (c.dataset.brand === currentBrand) c.classList.add('active');
        else c.classList.remove('active');
      });
      if (brandSelect) brandSelect.value = currentBrand;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  });

  // Brand select
  if (brandSelect) {
    brandSelect.addEventListener('change', function() {
      currentBrand = this.value;
      brandChips.forEach(c => {
        if (c.dataset.brand === currentBrand) c.classList.add('active');
        else c.classList.remove('active');
      });
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  // Price select
  if (priceSelect) {
    priceSelect.addEventListener('change', function() {
      currentPrice = this.value;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  // Sort select
  if (sortSelect) {
    sortSelect.addEventListener('change', function() {
      currentSort = this.value;
      visibleLimit = 20;
      filterAndSortProducts();
    });
  }

  // Search
  let searchTimer;
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimer);
      searchQuery = this.value.trim();
      if (clearBtn) {
        if (searchQuery.length > 0) clearBtn.classList.remove('hidden');
        else clearBtn.classList.add('hidden');
      }
      searchTimer = setTimeout(() => {
        visibleLimit = 20;
        filterAndSortProducts();
      }, 150);
    });
  }

  // Clear search
  if (clearBtn) {
    clearBtn.addEventListener('click', function() {
      if (searchInput) {
        searchInput.value = '';
        searchQuery = '';
        clearBtn.classList.add('hidden');
        visibleLimit = 20;
        filterAndSortProducts();
        searchInput.focus();
      }
    });
  }

  // Load More
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
      visibleLimit += 20;
      filterAndSortProducts();
    });
  }

  function resetAll() {
    currentCat   = 'all';
    currentBrand = 'all';
    currentPrice = 'all';
    currentSort  = 'featured';
    searchQuery  = '';

    if (searchInput) searchInput.value = '';
    if (clearBtn) clearBtn.classList.add('hidden');
    if (brandSelect) brandSelect.value = 'all';
    if (priceSelect) priceSelect.value = 'all';
    if (sortSelect) sortSelect.value = 'featured';

    catChips.forEach(c => {
      if (c.dataset.cat === 'all') c.classList.add('active');
      else c.classList.remove('active');
    });
    brandChips.forEach(c => {
      if (c.dataset.brand === 'all') c.classList.add('active');
      else c.classList.remove('active');
    });

    visibleLimit = 20;
    filterAndSortProducts();
  }

  if (resetBtn)          resetBtn.addEventListener('click', resetAll);
  if (noResultsResetBtn) noResultsResetBtn.addEventListener('click', resetAll);

  // Initial render
  filterAndSortProducts();
})();
</script>

<?php
get_footer();
