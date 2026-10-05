<?php
/**
 * Template Name: PhoneX Túi Đựng Phụ Kiện Chính Hãng
 *
 * Dedicated Accessory Bags, Sling Bags & Tech Organizers Catalog Page
 *
 * Strictly adheres to:
 * 1. Google Stitch Design System Palette (#b7000c, #e60012, #ffdad5, #ffb4aa, #f8f9fb...)
 * 2. PHONEX – UI/UX DESIGN SYSTEM (touch target ≥44×44px, max-w-[1440px])
 *    - Hero Card: background-color: var(--px-primary-fixed); (#ffdad5)
 *    - KHÔNG có bất kỳ thông tin nào của Thế Giới Di Động phía người dùng
 *    - 100% hình ảnh nội bộ theo thư mục phụ kiện
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD PRODUCT DATA
// =========================================================================
$json_path        = get_template_directory() . '/data/accessory-bags.json';
$crawled_products = array();
if ( file_exists( $json_path ) ) {
	$crawled_products = json_decode( file_get_contents( $json_path ), true ) ?: array();
}

$client_products = array_map( function( $item ) {
	unset( $item['source_url'], $item['image_remote'] );
	if ( ! empty( $item['image'] ) && strpos( $item['image'], 'http' ) !== 0 ) {
		$item['image'] = get_template_directory_uri() . '/' . ltrim( $item['image'], '/' );
	}
	return $item;
}, $crawled_products );

// Category filter types
$cat_types = array(
	'all'               => 'Tất cả sản phẩm',
	'tui-deo-cheo-edc'  => 'Túi Đeo Chéo EDC',
	'tui-dung-tech'     => 'Túi Đựng Tech & Cáp Sạc',
	'tui-bao-tu-mini'   => 'Túi Bao Tử & Đeo Hông',
	'khac'              => 'Phụ Kiện Du Lịch & Khác',
);

// Brand quick-filter
$brands = array(
	'all'          => 'Tất cả hãng',
	'TOMTOC'       => 'Tomtoc',
	'Jansport'     => 'Jansport',
	'Innostyle'    => 'Innostyle',
	'Topo Designs' => 'Topo Designs',
	'THULE'        => 'Thule',
	'Mazer'        => 'Mazer',
	'Divoom'       => 'Divoom',
);

$total_crawled = count( $crawled_products );
?>

<style>
:root {
  --px-primary: #b7000c;
  --px-primary-container: #e60012;
  --px-primary-hover: #C90010;
  --px-primary-fixed: #ffdad5;
  --px-primary-fixed-dim: #ffb4aa;
  --px-surface: #f8f9fb;
  --px-surface-pure: #ffffff;
  --px-border-subtle: #E5E7EB;
  --px-text-main: #222222;
  --px-text-secondary: #5f5e5e;
}
.px-ds-h1 { font-size:26px;line-height:1.25;font-weight:700; }
@media(min-width:768px){.px-ds-h1{font-size:30px;}}
@media(min-width:1024px){.px-ds-h1{font-size:34px;line-height:1.2;}}
.px-ds-h2 { font-size:22px;line-height:1.35;font-weight:700; }
@media(min-width:768px){.px-ds-h2{font-size:24px;}}
@media(min-width:1024px){.px-ds-h2{font-size:26px;}}
.px-ds-h3 { font-size:18px;line-height:1.35;font-weight:600; }
@media(min-width:768px){.px-ds-h3{font-size:20px;}}
.px-ds-prod-title {
  font-size:14px;line-height:1.45;font-weight:600;color:var(--px-text-main);
  min-height:44px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
@media(min-width:768px){.px-ds-prod-title{font-size:15px;}}
.px-ds-price-primary { font-size:18px;line-height:1.2;font-weight:700;color:var(--px-primary-container); }
@media(min-width:768px){.px-ds-price-primary{font-size:20px;}}
@media(min-width:1024px){.px-ds-price-primary{font-size:22px;}}
.px-ds-price-old { font-size:13px;color:var(--px-text-secondary);text-decoration:line-through;font-weight:400; }
@media(min-width:768px){.px-ds-price-old{font-size:14px;}}
.px-ds-input { font-size:16px;line-height:1.5;min-height:44px; }
.px-ds-btn-cta { font-size:15px;font-weight:600;min-height:44px;min-width:44px;border-radius:8px;display:inline-flex;align-items:center;transition:background-color .18s ease,box-shadow .18s ease; }
.px-touch-target { min-height:44px;min-width:44px; }
.cat-chip.active,.brand-chip.active {
  background-color:#b7000c !important;color:#fff !important;border-color:#b7000c !important;
  box-shadow:0 2px 8px rgba(183,0,12,.25);
}
.no-scrollbar::-webkit-scrollbar{display:none;}
.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
.line-clamp-1{display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;}
.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.phonex-accbag-card {
  transition:transform .24s cubic-bezier(.4,0,.2,1),box-shadow .24s cubic-bezier(.4,0,.2,1),border-color .24s ease;
  will-change:transform,box-shadow;display:flex;flex-direction:column;
}
.phonex-accbag-card:hover {
  transform:translateY(-4px);
  box-shadow:0 12px 28px -6px rgba(183,0,12,.12),0 4px 12px -2px rgba(0,0,0,.04);
  border-color:#ffb4aa;
}
.phonex-accbag-card.hidden { display:none !important; }
</style>

<main class="w-full min-h-screen bg-[#f8f9fb] pb-16 font-sans text-[#222222]">

  <!-- BREADCRUMB -->
  <div class="w-full bg-white border-b border-[#E5E7EB]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <nav class="flex items-center gap-2 text-[13px] sm:text-[14px] text-[#5f5e5e] overflow-x-auto no-scrollbar whitespace-nowrap">
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="hover:text-[#b7000c] transition-colors flex items-center gap-1">
          <span class="material-symbols-outlined text-[17px]">home</span><span>Trang chủ</span>
        </a>
        <span class="text-gray-300">/</span>
        <a href="<?php echo esc_url( home_url('/phu-kien/') ); ?>" class="hover:text-[#b7000c] transition-colors">Phụ kiện</a>
        <span class="text-gray-300">/</span>
        <span class="text-[#222222] font-semibold">Túi Đựng Phụ Kiện</span>
      </nav>
    </div>
  </div>

  <!-- HERO GRID -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <!-- MAIN HERO CARD -->
      <div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]"
           style="background-color: var(--px-primary-fixed);">
        <div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
          <span class="material-symbols-outlined text-[240px] text-[#b7000c]">local_mall</span>
        </div>
        <div class="relative z-10 max-w-2xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/90 border border-[#b7000c]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-[#e60012] animate-pulse"></span>
            PHONEX BAGS STORE • TÚI ĐỰNG PHỤ KIỆN & ĐEO CHÉO EDC
          </div>
          <h1 class="px-ds-h1 font-bold text-[#222222] tracking-tight mb-3">
            Túi Đựng Phụ Kiện, Túi Đeo Chéo EDC & Hộp Đựng Công Nghệ Chính Hãng
          </h1>
          <p class="text-[14px] sm:text-[16px] text-[#444444] leading-relaxed mb-6 font-normal">
            Tuyển chọn <?php echo esc_html($total_crawled); ?> mẫu túi đeo chéo thời trang, túi đựng phụ kiện cáp sạc và tech organizer cao cấp từ Tomtoc, Innostyle, Jansport, Thule... Khóa kéo YKK Nhật Bản mượt mà, vải Cordura & X-Pac chống thấm nước, phân ngăn khoa học cho mọi thiết bị công nghệ.
          </p>
          <div class="flex flex-wrap items-center gap-3">
            <a href="#catalog-grid" class="px-ds-btn-cta bg-[#b7000c] hover:bg-[#C90010] text-white px-6 py-2.5 shadow-md hover:shadow-lg inline-flex items-center gap-2">
              <span class="material-symbols-outlined text-[19px]">local_mall</span>
              <span>Xem <?php echo esc_html($total_crawled); ?> sản phẩm</span>
            </a>
            <div class="inline-flex items-center gap-1.5 text-[13px] text-[#6d1316] font-medium bg-white/70 px-3 py-2 rounded-lg border border-[#ffb4aa]/60">
              <span class="material-symbols-outlined text-[17px] text-[#b7000c]">shield</span>
              <span>Vải X-Pac & Khóa Kéo YKK</span>
            </div>
          </div>
        </div>
        <!-- Trust Badges -->
        <div class="relative z-10 mt-6 pt-4 border-t border-[#ffb4aa]/80 grid grid-cols-2 sm:grid-cols-4 gap-2 text-[12px] sm:text-[13px] font-medium text-[#4a1c1d]">
          <div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#b7000c] text-[18px]">verified_user</span><span>Vải Cordura / X-Pac</span></div>
          <div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#b7000c] text-[18px]">lock</span><span>Khóa kéo YKK mượt mà</span></div>
          <div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#b7000c] text-[18px]">contactless</span><span>Bảo mật chống trộm RFID</span></div>
          <div class="flex items-center gap-2"><span class="material-symbols-outlined text-[#b7000c] text-[18px]">verified</span><span>Bảo hành 1 đổi 1 12T</span></div>
        </div>
      </div>

      <!-- SIDE PROMO CARD -->
      <div class="relative rounded-2xl p-6 sm:p-7 shadow-xs flex flex-col justify-between overflow-hidden bg-white border border-[#E5E7EB]">
        <div>
          <div class="flex items-center justify-between mb-4">
            <span class="text-[12px] font-bold text-white bg-[#e60012] px-2.5 py-0.5 rounded-full uppercase tracking-wider">Bán Chạy Nhất</span>
            <span class="text-[12px] text-[#5f5e5e] font-medium flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px] text-amber-500">stars</span>PhoneX Store
            </span>
          </div>
          <h2 class="px-ds-h3 font-bold text-[#222222] mb-2">Top Túi Đeo Chéo EDC Hot Nhất</h2>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] mb-5 leading-normal">
            Những mẫu túi đeo chéo công nghệ nhỏ gọn, đựng vừa iPad Mini, điện thoại và sạc cáp.
          </p>
          <div class="space-y-2.5 bg-[#f8f9fb] p-3.5 rounded-xl border border-gray-100 mb-5">
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>Tomtoc Aviator-T37
              </span>
              <span class="font-bold text-[#b7000c]">Từ 918.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>Innostyle VersalSling
              </span>
              <span class="font-bold text-[#b7000c]">Từ 505.000₫</span>
            </div>
            <div class="flex items-center justify-between text-[13px]">
              <span class="text-gray-600 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-[#b7000c]">check</span>Jansport Move Sling 6L
              </span>
              <span class="font-bold text-[#b7000c]">Từ 854.000₫</span>
            </div>
          </div>
        </div>
        <div class="pt-2">
          <a href="<?php echo esc_url( home_url('/tui-chong-soc/') ); ?>" class="w-full px-ds-btn-cta bg-[#f8f9fb] hover:bg-[#ffdad5]/40 text-[#b7000c] border border-[#ffb4aa] px-4 py-2.5 text-center font-semibold text-[14px] flex items-center justify-center gap-2">
            <span>Xem thêm Balo & Túi Chống Sốc</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
      </div>

    </div>
  </div>

  <!-- FILTER BAR -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-2">
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs">

      <!-- Row 1: Search + Category Chips -->
      <div class="flex flex-col md:flex-row md:items-center gap-3.5 pb-4 border-b border-[#E5E7EB]">
        <div class="relative w-full md:w-80 shrink-0">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <span class="material-symbols-outlined text-[20px]">search</span>
          </span>
          <input type="text" id="accBagSearchInput"
                 placeholder="Tìm túi phụ kiện (Tomtoc, Sling, chống nước, RFID...)"
                 class="w-full px-ds-input pl-10 pr-9 bg-[#f8f9fb] border border-[#E5E7EB] rounded-xl text-[15px] sm:text-[16px] text-[#222222] placeholder-gray-400 focus:outline-none focus:border-[#b7000c] focus:bg-white transition-all" />
          <button type="button" id="clearSearchBtn"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden px-touch-target">
            <span class="material-symbols-outlined text-[18px]">cancel</span>
          </button>
        </div>
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
          <?php foreach ( $cat_types as $c_key => $c_label ) : ?>
            <button type="button"
                    class="cat-chip px-touch-target whitespace-nowrap px-4 py-2 rounded-xl text-[13px] sm:text-[14px] font-medium border border-[#E5E7EB] bg-[#f8f9fb] text-[#5f5e5e] hover:bg-[#ffdad5]/30 hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ('all' === $c_key) ? 'active' : ''; ?>"
                    data-cat="<?php echo esc_attr($c_key); ?>">
              <?php echo esc_html($c_label); ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Row 2: Brand Chips + Selects -->
      <div class="pt-3.5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wider hidden sm:inline">Hãng:</span>
          <?php foreach ( $brands as $b_key => $b_label ) : ?>
            <button type="button"
                    class="brand-chip px-touch-target whitespace-nowrap px-3.5 py-1.5 rounded-lg text-[12px] sm:text-[13px] font-medium border border-[#E5E7EB] bg-white text-[#5f5e5e] hover:border-[#ffb4aa] hover:text-[#b7000c] transition-all <?php echo ('all' === $b_key) ? 'active' : ''; ?>"
                    data-brand="<?php echo esc_attr($b_key); ?>">
              <?php echo esc_html($b_label); ?>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto justify-end">
          <select id="brandFilterSelect"
                  class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
            <option value="all">Tất cả thương hiệu</option>
            <?php foreach ( array_slice($brands, 1) as $b_key => $b_label ) : ?>
              <option value="<?php echo esc_attr($b_key); ?>"><?php echo esc_html($b_label); ?></option>
            <?php endforeach; ?>
          </select>
          <select id="priceFilterSelect"
                  class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
            <option value="all">Mọi mức giá</option>
            <option value="under-700">Dưới 700.000₫</option>
            <option value="700-1000">700.000₫ – 1.000.000₫</option>
            <option value="1000-1500">1.000.000₫ – 1.500.000₫</option>
            <option value="above-1500">Trên 1.500.000₫</option>
          </select>
          <select id="sortFilterSelect"
                  class="px-touch-target pl-3 pr-8 py-1.5 bg-[#f8f9fb] border border-[#E5E7EB] rounded-lg text-[13px] sm:text-[14px] text-[#222222] font-medium focus:outline-none focus:border-[#b7000c] cursor-pointer">
            <option value="featured">Nổi bật / Bán chạy</option>
            <option value="price-asc">Giá thấp đến cao</option>
            <option value="price-desc">Giá cao đến thấp</option>
            <option value="discount-desc">% Giảm giá nhiều nhất</option>
          </select>
          <button type="button" id="resetAllFiltersBtn"
                  class="px-touch-target px-3 py-1.5 rounded-lg text-[13px] font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 hidden transition-all">
            <span class="material-symbols-outlined text-[16px] mr-1">restart_alt</span><span>Đặt lại</span>
          </button>
        </div>
      </div>

      <!-- Counter -->
      <div class="mt-3.5 pt-3.5 border-t border-[#E5E7EB] flex flex-wrap items-center justify-between text-[13px] sm:text-[14px] text-[#5f5e5e] gap-2">
        <div>
          <span>Đang hiển thị: </span>
          <strong id="resultsCount" class="text-[#b7000c] font-bold"><?php echo esc_html($total_crawled); ?></strong>
          <span> / <?php echo esc_html($total_crawled); ?> sản phẩm PhoneX</span>
        </div>
        <div class="flex items-center gap-1.5 text-[12px] sm:text-[13px] text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/60">
          <span class="material-symbols-outlined text-[15px] text-emerald-600">check_circle</span>
          <span>100% Chính hãng • Bảo hành đổi trả tại PhoneX</span>
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUCT GRID -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="px-ds-h2 font-bold text-[#222222] tracking-tight">Danh mục Túi Đựng Phụ Kiện</h2>
        <p class="text-[14px] text-[#5f5e5e] mt-1">Túi đeo chéo EDC công nghệ, túi đựng cáp sạc, tech organizer và túi bao tử cao cấp</p>
      </div>
    </div>

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
          $is_hidden    = ( $idx >= 20 );

          $type_icon = 'local_mall';
          if ( $subfolder === 'tui-dung-tech' )       $type_icon = 'cable';
          elseif ( $subfolder === 'tui-bao-tu-mini' ) $type_icon = 'work';
          elseif ( $subfolder === 'khac' )            $type_icon = 'travel_explore';
          ?>
          <div class="phonex-accbag-card bg-white rounded-2xl p-3.5 sm:p-4 border border-[#E5E7EB] shadow-2xs relative group <?php echo $is_hidden ? 'hidden' : ''; ?>"
               style="<?php echo $is_hidden ? 'display:none !important;' : ''; ?>"
               data-idx="<?php echo esc_attr($idx); ?>"
               data-brand="<?php echo esc_attr($brand); ?>"
               data-cat="<?php echo esc_attr($subfolder); ?>"
               data-price="<?php echo esc_attr($price_num); ?>"
               data-discount="<?php echo esc_attr($discount_pct); ?>"
               data-name="<?php echo esc_attr( mb_strtolower($name, 'UTF-8') ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode(' ', $specs), 'UTF-8' ) ); ?>">

            <!-- Badges -->
            <div class="flex items-center justify-between gap-1 mb-2">
              <span class="text-[11px] font-bold text-gray-600 bg-[#f2f4f6] px-2 py-0.5 rounded-md line-clamp-1"><?php echo esc_html($brand); ?></span>
              <?php if ( $discount_pct > 0 ) : ?>
                <span class="text-[11px] font-bold text-white bg-[#e60012] px-2 py-0.5 rounded-md shadow-2xs">-<?php echo esc_html($discount_pct); ?>%</span>
              <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-[#f8f9fb] mb-3 flex items-center justify-center">
              <img src="<?php echo esc_url($img_src); ?>"
                   alt="<?php echo esc_attr($name); ?>"
                   class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300"
                   loading="lazy" width="300" height="300" />
              <div class="absolute bottom-2 left-2 flex items-center gap-1 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-full text-[10px] font-semibold text-[#5f5e5e] shadow-2xs">
                <span class="material-symbols-outlined text-[12px] text-[#b7000c]"><?php echo $type_icon; ?></span>
                <span class="line-clamp-1 max-w-[95px]"><?php echo esc_html($type_name); ?></span>
              </div>
            </div>

            <!-- Info -->
            <div class="flex flex-col flex-1 gap-1.5">
              <h3 class="px-ds-prod-title"><?php echo esc_html($name); ?></h3>
              <?php if ( ! empty($specs[0]) ) : ?>
                <p class="text-[11px] sm:text-[12px] text-[#5f5e5e] leading-snug line-clamp-1 mt-0.5"><?php echo esc_html($specs[0]); ?></p>
              <?php endif; ?>
              <div class="mt-auto pt-2">
                <?php if ( $old_num > $price_num ) : ?>
                  <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="px-ds-price-primary"><?php echo esc_html($price_fmt); ?></span>
                    <span class="px-ds-price-old"><?php echo esc_html($old_fmt); ?></span>
                  </div>
                <?php else : ?>
                  <span class="px-ds-price-primary"><?php echo esc_html($price_fmt); ?></span>
                <?php endif; ?>
              </div>
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
                <a href="<?php echo esc_url( home_url('/lien-he/?product=' . rawurlencode($name)) ); ?>"
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
          <span class="material-symbols-outlined text-[64px] text-gray-200 block mb-3">local_mall</span>
          <p class="text-[16px] font-semibold">Chưa có dữ liệu sản phẩm</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- No Results -->
    <div id="noResultsState" class="hidden flex-col items-center justify-center py-20 text-[#5f5e5e]">
      <span class="material-symbols-outlined text-[64px] text-gray-200 block mb-3">search_off</span>
      <p class="text-[17px] font-semibold text-[#222222]">Không tìm thấy sản phẩm phù hợp</p>
      <p class="text-[14px] mt-1 mb-5">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
      <button type="button" id="noResultsResetBtn" class="px-ds-btn-cta bg-[#b7000c] text-white px-5 py-2.5 text-[14px]">Xóa bộ lọc</button>
    </div>

    <!-- Load More -->
    <div id="loadMoreSection" class="mt-10 flex flex-col items-center gap-4">
      <div class="w-full max-w-sm">
        <div class="flex items-center justify-between text-[12px] text-[#5f5e5e] mb-1.5">
          <span>Đang hiển thị <strong id="shownCount" class="text-[#222222]">20</strong> / <strong><?php echo esc_html($total_crawled); ?></strong> sản phẩm</span>
        </div>
        <div class="w-full bg-[#E5E7EB] rounded-full h-1.5 overflow-hidden">
          <div id="progressBar" class="bg-[#b7000c] h-1.5 rounded-full transition-all duration-500"
               style="width:<?php echo min(100, round(20 / max(1,$total_crawled) * 100)); ?>%"></div>
        </div>
      </div>
      <button type="button" id="loadMoreBtn"
              class="px-ds-btn-cta bg-white hover:bg-[#ffdad5]/30 text-[#b7000c] border-2 border-[#b7000c] px-8 py-3 text-[15px] gap-2">
        <span class="material-symbols-outlined text-[20px]">expand_more</span>
        <span>Xem thêm túi phụ kiện</span>
      </button>
    </div>
  </div>

  <!-- =========================================================================
       5. BUYING GUIDE — CÁCH CHỌN TÚI ĐỰNG PHỤ KIỆN PHÙ HỢP NHU CẦU
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-16">
    <div class="bg-white rounded-2xl p-6 sm:p-8 md:p-10 border border-[#E5E7EB] shadow-xs">

      <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="text-[12px] font-bold text-[#b7000c] bg-[#ffdad5] px-3 py-1 rounded-full uppercase tracking-wider">Hướng Dẫn Lựa Chọn</span>
        <h2 class="px-ds-h2 font-bold text-[#222222] mt-3 mb-2">Cách Chọn Túi Đựng Phụ Kiện Phù Hợp Nhu Cầu</h2>
        <p class="text-[14px] sm:text-[15px] text-[#5f5e5e]">Bảo quản phụ kiện công nghệ ngăn nắp, chống thất lạc và mang theo tiện lợi mỗi ngày.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Pillar 1: Túi Đeo Chéo EDC -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">local_mall</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Túi Đeo Chéo EDC — Năng Động & Tiện Dụng Mỗi Ngày</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Lựa chọn hoàn hảo cho nhu cầu đi làm, dạo phố hoặc cà phê cuối tuần. Chứa gọn iPad Mini, điện thoại, sạc dự phòng, ví và kính mắt với quai đeo chéo êm ái, khóa YKK và ngăn chống trộm RFID an toàn.
          </p>
        </div>

        <!-- Pillar 2: Tech Pouch / Organizer -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">cable</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Tech Organizer — Ngăn Nắp Cáp Sạc & Chuột Máy Tính</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Nếu bạn thường xuyên mang theo nhiều dây cáp, củ sạc GaN, tai nghe, USB hay chuột máy tính, túi Tech Pouch với các dải thun đàn hồi và ngăn lưới thông minh sẽ giúp bàn làm việc và balo luôn gọn gàng.
          </p>
        </div>

        <!-- Pillar 3: Túi Bao Tử & Phụ Kiện Du Lịch -->
        <div class="p-5 rounded-xl bg-[#f8f9fb] border border-gray-100 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#ffdad5] text-[#b7000c] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">work</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#222222] mb-2">Túi Bao Tử & Du Lịch — Nhỏ Gọn, Bền Bỉ Kháng Nước</h3>
          <p class="text-[13px] sm:text-[14px] text-[#5f5e5e] leading-relaxed">
            Thiết kế đeo hông hoặc đeo chéo ngực tiện lợi khi chạy xe hoặc du lịch. Vải Cordura & X-Pac cao cấp kháng nước tuyệt đối khi gặp mưa bất chợt, bảo vệ giấy tờ, hộ chiếu và phụ kiện an toàn 100%.
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
        <p class="text-[14px] text-[#5f5e5e] mt-1">Hệ sinh thái phụ kiện công nghệ đa dạng — balo laptop, chuột, bàn phím & hub chuyển đổi.</p>
      </div>
      <a href="<?php echo esc_url( home_url('/phu-kien/') ); ?>"
         class="hidden sm:inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#b7000c] hover:text-[#C90010] transition-colors whitespace-nowrap">
        Xem tất cả phụ kiện
        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
      </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

      <!-- Card 1: Balo, Túi Chống Sốc -->
      <a href="<?php echo esc_url( home_url('/tui-chong-soc/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">backpack</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Balo & Túi</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Balo Laptop & Túi Chống Sốc 360°</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Đệm khí 360° bảo vệ MacBook, laptop 13"–16", vải trượt nước từ Tomtoc, Tucano.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 2: Bàn Phím -->
      <a href="<?php echo esc_url( home_url('/ban-phim/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">keyboard</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Bàn phím</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Bàn Phím Gaming, Bluetooth & Cơ</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Switch cơ 50tr lần bấm, kết nối đa thiết bị từ Logitech, Razer, Keychron.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 3: Chuột Máy Tính -->
      <a href="<?php echo esc_url( home_url('/chuot-may-tinh/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">mouse</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Chuột</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Chuột Gaming & Bluetooth Không Dây</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">DPI cao, kết nối Bluetooth 3 thiết bị cùng lúc từ Logitech, Apple, Razer.</p>
        </div>
        <div class="px-4 pb-4">
          <span class="inline-flex items-center gap-1 text-[13px] font-semibold text-[#b7000c] group-hover:gap-2 transition-all">
            Xem ngay <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </span>
        </div>
      </a>

      <!-- Card 4: Hub, Cáp Chuyển Đổi -->
      <a href="<?php echo esc_url( home_url('/hub-chuyen-doi/') ); ?>"
         class="group relative rounded-2xl overflow-hidden bg-white border border-[#E5E7EB] shadow-xs hover:border-[#ffb4aa] hover:shadow-md transition-all duration-200 flex flex-col">
        <div class="h-28 sm:h-36 flex items-center justify-center" style="background-color: var(--px-primary-fixed);">
          <span class="material-symbols-outlined text-[64px] sm:text-[80px] text-[#b7000c] opacity-80 group-hover:scale-110 transition-transform duration-200">hub</span>
        </div>
        <div class="p-4 flex flex-col flex-1">
          <span class="text-[11px] font-bold text-[#b7000c] bg-[#ffdad5] px-2 py-0.5 rounded-full w-fit mb-2 uppercase tracking-wide">Hub & Cáp</span>
          <h3 class="text-[14px] sm:text-[15px] font-bold text-[#222222] mb-1 leading-snug">Hub Type-C, Cáp HDMI & Đầu Chuyển</h3>
          <p class="text-[12px] sm:text-[13px] text-[#5f5e5e] leading-snug mt-auto">Mở rộng cổng kết nối 4K, sạc PD 100W, LAN Gigabit từ Ugreen, HyperDrive.</p>
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
(function(){
'use strict';
const allCards   = Array.from(document.querySelectorAll('.phonex-accbag-card'));
const searchInput= document.getElementById('accBagSearchInput');
const clearBtn   = document.getElementById('clearSearchBtn');
const catChips   = document.querySelectorAll('.cat-chip');
const brandChips = document.querySelectorAll('.brand-chip');
const brandSelect= document.getElementById('brandFilterSelect');
const priceSelect= document.getElementById('priceFilterSelect');
const sortSelect = document.getElementById('sortFilterSelect');
const resetBtn   = document.getElementById('resetAllFiltersBtn');
const loadMoreBtn= document.getElementById('loadMoreBtn');
const loadMoreSec= document.getElementById('loadMoreSection');
const noResults  = document.getElementById('noResultsState');
const resultsCount=document.getElementById('resultsCount');
const shownCount = document.getElementById('shownCount');
const progressBar= document.getElementById('progressBar');
const noResultsResetBtn=document.getElementById('noResultsResetBtn');
let currentCat='all',currentBrand='all',currentPrice='all',currentSort='featured',searchQuery='',visibleLimit=20;

function matchPrice(p,r){
  if(r==='all')return true;
  if(r==='under-700')return p<700000;
  if(r==='700-1000')return p>=700000&&p<=1000000;
  if(r==='1000-1500')return p>=1000000&&p<=1500000;
  if(r==='above-1500')return p>1500000;
  return true;
}

function run(){
  let filtered=allCards.filter(c=>{
    const cat=c.dataset.cat||'',brand=c.dataset.brand||'',
          price=parseInt(c.dataset.price,10)||0,
          name=c.dataset.name||'',specs=c.dataset.specs||'';
    if(currentCat!=='all'&&cat!==currentCat)return false;
    if(currentBrand!=='all'&&brand.toLowerCase()!==currentBrand.toLowerCase())return false;
    if(!matchPrice(price,currentPrice))return false;
    if(searchQuery){const q=searchQuery.toLowerCase();if(!name.includes(q)&&!specs.includes(q)&&!brand.toLowerCase().includes(q))return false;}
    return true;
  });
  filtered.sort((a,b)=>{
    const ap=parseInt(a.dataset.price,10)||0,bp=parseInt(b.dataset.price,10)||0,
          ad=parseInt(a.dataset.discount,10)||0,bd=parseInt(b.dataset.discount,10)||0,
          ai=parseInt(a.dataset.idx,10)||0,bi=parseInt(b.dataset.idx,10)||0;
    if(currentSort==='price-asc')return ap-bp;
    if(currentSort==='price-desc')return bp-ap;
    if(currentSort==='discount-desc')return bd-ad;
    return ai-bi;
  });
  allCards.forEach(c=>{c.classList.add('hidden');c.style.display='none';});
  filtered.slice(0,visibleLimit).forEach(c=>{c.classList.remove('hidden');c.style.removeProperty('display');});
  const total=filtered.length,shown=Math.min(total,visibleLimit),totalAll=allCards.length;
  if(resultsCount)resultsCount.textContent=shown;
  if(shownCount)shownCount.textContent=shown;
  if(progressBar)progressBar.style.width=(totalAll>0?Math.min(100,Math.round(shown/totalAll*100)):100)+'%';
  if(loadMoreSec)loadMoreSec.style.display=shown<total?'flex':'none';
  if(noResults){noResults.classList.toggle('hidden',total!==0);noResults.style.display=total===0?'flex':'';}
  const isF=currentCat!=='all'||currentBrand!=='all'||currentPrice!=='all'||currentSort!=='featured'||searchQuery;
  if(resetBtn)resetBtn.classList.toggle('hidden',!isF);
}

catChips.forEach(c=>c.addEventListener('click',function(){
  currentCat=this.dataset.cat;
  catChips.forEach(x=>x.classList.toggle('active',x.dataset.cat===currentCat));
  visibleLimit=20;run();
}));
brandChips.forEach(c=>c.addEventListener('click',function(){
  currentBrand=this.dataset.brand;
  brandChips.forEach(x=>x.classList.toggle('active',x.dataset.brand===currentBrand));
  if(brandSelect)brandSelect.value=currentBrand;
  visibleLimit=20;run();
}));
if(brandSelect)brandSelect.addEventListener('change',function(){
  currentBrand=this.value;
  brandChips.forEach(x=>x.classList.toggle('active',x.dataset.brand===currentBrand));
  visibleLimit=20;run();
});
if(priceSelect)priceSelect.addEventListener('change',function(){currentPrice=this.value;visibleLimit=20;run();});
if(sortSelect)sortSelect.addEventListener('change',function(){currentSort=this.value;visibleLimit=20;run();});
let searchTimer;
if(searchInput)searchInput.addEventListener('input',function(){
  clearTimeout(searchTimer);searchQuery=this.value.trim();
  if(clearBtn)clearBtn.classList.toggle('hidden',searchQuery.length===0);
  searchTimer=setTimeout(()=>{visibleLimit=20;run();},150);
});
if(clearBtn)clearBtn.addEventListener('click',function(){
  if(searchInput){searchInput.value='';searchQuery='';clearBtn.classList.add('hidden');visibleLimit=20;run();searchInput.focus();}
});
if(loadMoreBtn)loadMoreBtn.addEventListener('click',function(){visibleLimit+=20;run();});
function resetAll(){
  currentCat='all';currentBrand='all';currentPrice='all';currentSort='featured';searchQuery='';
  if(searchInput)searchInput.value='';
  if(clearBtn)clearBtn.classList.add('hidden');
  if(brandSelect)brandSelect.value='all';
  if(priceSelect)priceSelect.value='all';
  if(sortSelect)sortSelect.value='featured';
  catChips.forEach(c=>c.classList.toggle('active',c.dataset.cat==='all'));
  brandChips.forEach(c=>c.classList.toggle('active',c.dataset.brand==='all'));
  visibleLimit=20;run();
}
if(resetBtn)resetBtn.addEventListener('click',resetAll);
if(noResultsResetBtn)noResultsResetBtn.addEventListener('click',resetAll);
run();
})();
</script>

<?php get_footer(); ?>
