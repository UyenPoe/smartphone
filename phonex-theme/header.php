<?php
/**
 * The header template for PhoneX WordPress Theme
 * Designed with PhoneX Flagship structure & PhoneX flagship color scheme
 *
 * @package PhoneX
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="referrer" content="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
  <style>@layer base{html,body{margin:0;padding:0;width:100%;max-width:100vw;overflow-x:hidden;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style>
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-background font-body-regular text-body-regular text-on-surface antialiased overflow-x-hidden'); ?>>
<?php wp_body_open(); ?>

<!-- PhoneX Flagship Unified Header (PhoneX Brand Red & Clean Aesthetics) -->
<header class="sticky top-0 left-0 w-full z-50 bg-white shadow-xs font-sans" data-component="header">
  
  <!-- 1. TOP CAMPAIGN BANNER (2400x88 Image Banner) -->
  <div id="pxTopCampaignBanner" class="w-full bg-[#b7000c] relative z-40 border-b border-[#b7000c]/40 shadow-xs overflow-hidden leading-none">
    <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>" class="block w-full text-center relative group" title="72 Model Giá Sốc - Giảm đến 35%">
      <img 
        src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/banners/top-campaign-banner-2400x88.png'); ?>" 
        alt="72 Model Giá Sốc - Duy nhất 3 ngày (28 – 30.09.2026): Giảm khủng đến 35% cho Điện Thoại, Tablet & Phụ Kiện - Mua Ngay" 
        class="w-full h-auto max-h-[44px] sm:max-h-[50px] md:max-h-[56px] object-cover mx-auto block" 
        width="2400" 
        height="88" 
        loading="eager" 
      />
    </a>
    <button type="button" aria-label="Đóng banner" onclick="PhoneXTopBanner.dismiss()" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-black/30 hover:bg-black/60 text-white/90 hover:text-white flex items-center justify-center transition-all z-10" title="Đóng thông báo">
      <span class="material-symbols-outlined text-[15px] sm:text-[17px]">close</span>
    </button>
  </div>

  <!-- 2. MAIN HEADER ROW (Logo | Pill Search Bar | 4 Actions: User, Voucher, Cart, Location) -->
  <div class="bg-white border-b border-gray-100 relative z-30">
    <div class="max-w-[1440px] mx-auto px-4 h-16 md:h-18 flex items-center justify-between gap-3 md:gap-6">
      
      <!-- Left: Mobile Hamburger + PhoneX Logo -->
      <div class="flex items-center gap-2 md:gap-3.5 shrink-0">
        <!-- Mobile Menu Hamburger Button -->
        <button type="button" aria-label="<?php esc_attr_e('Mở menu', 'phonex'); ?>" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors" onclick="PhoneXPopups.openMenu()">
          <span class="material-symbols-outlined text-[28px]">menu</span>
        </button>

        <!-- PhoneX Brand Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5 group">
          <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-[#e60012] group-hover:bg-[#b7000c] flex items-center justify-center text-white shadow-sm shadow-red-200 transition-all">
            <span class="material-symbols-outlined text-[22px] md:text-[24px]">smartphone</span>
          </div>
          <div class="flex flex-col leading-none">
            <span class="text-2xl md:text-[26px] font-black text-gray-900 tracking-tight flex items-center">
              Phone<span class="text-[#e60012]">X</span>
              <span class="text-[11px] text-gray-600 font-bold ml-0.5">.vn</span>
            </span>
            <span class="text-[10px] text-gray-700 font-bold tracking-wider mt-0.5 hidden xl:inline">Thu Mua &amp; Bán Sỉ Điện Thoại Cũ</span>
          </div>
        </a>
      </div>

      <!-- Center: Pill-shaped Search Bar for Selling Phones -->
      <div class="hidden sm:flex flex-1 max-w-lg lg:max-w-xl mx-2 relative" id="headerBuybackSearchWrapper">
        <div class="relative w-full flex items-center">
          <span class="absolute left-4 text-gray-600 pointer-events-none material-symbols-outlined text-[20px]">search</span>
          <input 
            id="headerBuybackSearchInput"
            name="s" 
            class="w-full h-11 md:h-12 pl-11 pr-12 bg-gray-100/90 hover:bg-gray-100 focus:bg-white rounded-full text-[15px] text-gray-900 placeholder-gray-500 border border-gray-300 focus:border-[#e60012] focus:ring-2 focus:ring-[#ffdad5] transition-all outline-none font-medium" 
            placeholder="Tìm điện thoại bạn muốn bán (vd: iPhone 15 Pro Max, Galaxy S25...)" 
            type="search"
            autocomplete="off"
          >
          <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" aria-label="<?php esc_attr_e('Định giá ngay', 'phonex'); ?>" class="absolute right-1.5 w-8 h-8 flex items-center justify-center bg-[#e60012] hover:bg-[#b7000c] text-white rounded-full transition-colors shadow-xs">
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </a>
        </div>
        <!-- Live Search Dropdown -->
        <div id="headerBuybackSearchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 p-2 z-50 text-left max-h-80 overflow-y-auto"></div>
      </div>

      <!-- Right: Utility Actions (Tra cứu đơn | Vị trí Hồ Chí Minh) -->
      <div class="flex items-center gap-2 sm:gap-3 shrink-0">
        
        <!-- Mobile Search Button -->
        <button type="button" aria-label="<?php esc_attr_e('Tìm kiếm', 'phonex'); ?>" onclick="PhoneXPopups.openSearch()" class="sm:hidden w-11 h-11 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors">
          <span class="material-symbols-outlined text-[24px]">search</span>
        </button>

        <!-- Tra cứu đơn thu mua / yêu cầu -->
        <a href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="hidden md:flex items-center gap-1.5 text-gray-800 hover:text-[#e60012] transition-colors text-[13px] md:text-[14px] font-semibold group px-2.5 py-1.5 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-200">
          <span class="material-symbols-outlined text-[20px] text-gray-700 group-hover:text-[#e60012] transition-transform group-hover:scale-105">track_changes</span>
          <span class="hidden sm:inline">Tra cứu đơn</span>
        </a>

        <!-- Location Selector (Hồ Chí Minh >) -->
        <button type="button" onclick="PhoneXLocation.openModal()" class="flex items-center gap-1 p-2 sm:px-3 sm:py-1.5 rounded-full border border-gray-200 bg-gray-50/90 hover:bg-gray-100 hover:border-[#e60012] text-gray-800 hover:text-[#e60012] text-[12px] sm:text-[13px] md:text-[14px] font-semibold transition-all shrink-0 shadow-2xs" title="Bấm để chọn vị trí xem giá &amp; tồn kho">
          <span class="material-symbols-outlined text-[#e60012] text-[18px]">location_on</span>
          <span id="pxLocationLabel" class="hidden sm:inline max-w-[75px] sm:max-w-none truncate font-bold">Hồ Chí Minh</span>
          <span class="hidden sm:inline material-symbols-outlined text-gray-600 text-[16px]">chevron_right</span>
        </button>

      </div>
    </div>
  </div>

  <!-- 3. MAIN NAVIGATION BAR & PHONE BUYBACK MEGA MENU -->
  <div class="w-full bg-white border-b border-gray-200/80 shadow-2xs relative z-30 overflow-x-clip">
    <div class="max-w-[1440px] mx-auto px-4 relative flex items-center justify-between">
      <nav class="flex items-center gap-1.5 md:gap-2 xl:gap-2.5 py-1.5 overflow-x-auto lg:overflow-visible whitespace-nowrap text-[13px] xl:text-[14px] font-bold text-gray-800 scrollbar-none min-w-0" aria-label="<?php esc_attr_e('Menu chính PhoneX', 'phonex'); ?>">
        
        <!-- 1. THU MUA ĐIỆN THOẠI (MAIN BUTTON & MEGA MENU TRIGGER) -->
        <div class="relative shrink-0" id="pxBuybackMenuWrapper" onmouseenter="PhoneXBuybackMegaMenu.onEnter()" onmouseleave="PhoneXBuybackMegaMenu.onLeave()">
          <a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" id="pxBuybackMenuBtn" onclick="PhoneXBuybackMegaMenu.toggle(event)" class="px-3.5 xl:px-4 py-2 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white flex items-center gap-1.5 shrink-0 transition-colors shadow-xs font-black cursor-pointer text-[13px] xl:text-[14px]">
            <span class="material-symbols-outlined text-[19px]">currency_exchange</span>
            <span>THU MUA ĐIỆN THOẠI</span>
            <span id="pxBuybackMenuArrow" class="material-symbols-outlined text-[17px] transition-transform duration-200">keyboard_arrow_down</span>
          </a>
        </div>

        <!-- 2. BẢNG GIÁ THU MUA (CHUẨN SEO & CATALOG 300+ MÁY) -->
        <a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-3 xl:px-3.5 py-2 rounded-xl bg-red-50/80 hover:bg-red-100 text-[#b7000c] hover:text-[#e60012] border border-red-200/80 transition-colors flex items-center gap-1.5 shrink-0 font-extrabold shadow-2xs">
          <span class="material-symbols-outlined text-[18px] text-[#e60012]">table_chart</span>
          <span>BẢNG GIÁ THU MUA</span>
          <span class="text-[10px] bg-[#e60012] text-white px-1.5 py-0.5 rounded-full font-black">300+ máy</span>
        </a>

        <!-- 3. KHO MÁY CŨ (PRE-OWNED INVENTORY) -->
        <div class="relative group shrink-0" id="pxUsedPhonesMenuWrapper" onmouseenter="document.getElementById('pxUsedPhonesDropdown').classList.remove('hidden')" onmouseleave="document.getElementById('pxUsedPhonesDropdown').classList.add('hidden')">
          <a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="px-3 xl:px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-[#ffdad5] text-gray-900 hover:text-[#b7000c] flex items-center gap-1.5 shrink-0 transition-colors shadow-2xs font-bold border border-gray-200/80 hover:border-[#ffb4aa] text-[13px] xl:text-[14px]">
            <span class="material-symbols-outlined text-[19px] text-[#e60012]">inventory_2</span>
            <span>KHO MÁY CŨ</span>
            <span class="text-[9.5px] uppercase font-extrabold px-1.5 py-0.5 rounded-full bg-[#e60012] text-white">99%</span>
            <span class="material-symbols-outlined text-[15px] text-gray-600 group-hover:text-[#b7000c] transition-transform group-hover:rotate-180">keyboard_arrow_down</span>
          </a>
          <!-- Dropdown for Kho Máy Cũ -->
          <div id="pxUsedPhonesDropdown" class="hidden group-hover:block absolute top-full left-0 z-50 mt-1 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 p-3 text-gray-800 transition-all">
            <div class="text-[11px] font-bold text-gray-700 uppercase tracking-wider px-2 py-1">Phân loại máy cũ theo thương hiệu</div>
            <div class="grid grid-cols-2 gap-1 mb-2">
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=iphone' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'apple', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>iPhone cũ (99%)</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=samsung' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'samsung', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>Samsung cũ</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=oppo' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'oppo', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>OPPO cũ</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=xiaomi' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'xiaomi', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>Xiaomi cũ</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=vivo' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'vivo', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>Vivo cũ</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/?cat=realme' ) ); ?>" class="flex items-center gap-2 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
                <?php echo phonex_get_brand_logo_img( 'realme', 'w-4 h-4 object-contain inline-block shrink-0' ); ?>
                <span>Realme cũ</span>
              </a>
            </div>
            <div class="border-t border-gray-100 my-1"></div>
            <div class="space-y-0.5">
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 text-xs font-bold text-gray-900 hover:text-[#e60012]">
                <span class="flex items-center gap-2">
                  <span class="material-symbols-outlined text-[17px] text-[#e60012]">grid_view</span>
                  <span>Tất cả kho máy cũ</span>
                </span>
                <span class="text-[11px] text-gray-600 font-bold">307 máy</span>
              </a>
              <a href="<?php echo esc_url( home_url( '/kho-may-cu/#b2b' ) ); ?>" class="flex items-center justify-between p-2 rounded-xl bg-red-50/60 hover:bg-red-50 text-xs font-bold text-[#b7000c]">
                <span class="flex items-center gap-2">
                  <span class="material-symbols-outlined text-[17px] text-[#e60012]">storefront</span>
                  <span>Bán sỉ B2B số lượng</span>
                </span>
                <span class="text-[10px] bg-[#e60012] text-white px-1.5 py-0.5 rounded-full font-bold">Giá tốt</span>
              </a>
            </div>
          </div>
        </div>

        <!-- 4. TRẢ GÓP 0% & THU CŨ LÊN ĐỜI (MỞ TRANG RIÊNG) -->
        <a href="<?php echo esc_url( home_url( '/tra-gop/' ) ); ?>" class="px-3 xl:px-3.5 py-2 rounded-xl text-gray-800 hover:text-[#e60012] hover:bg-gray-100 transition-colors flex items-center gap-1.5 shrink-0 font-bold text-[13px] xl:text-[14px]">
          <span class="material-symbols-outlined text-[19px] text-[#e60012]">credit_card</span>
          <span>TRẢ GÓP 0%</span>
          <span class="text-[9.5px] uppercase font-extrabold px-1.5 py-0.5 rounded-full bg-emerald-500 text-white">Duyệt 5p</span>
        </a>

        <!-- 5. HƯỚNG DẪN & CHÍNH SÁCH -->
        <div class="relative group shrink-0" onmouseenter="document.getElementById('pxServicesDropdown').classList.remove('hidden')" onmouseleave="document.getElementById('pxServicesDropdown').classList.add('hidden')">
          <button type="button" class="px-3 xl:px-3.5 py-2 rounded-xl text-gray-800 hover:text-[#e60012] hover:bg-gray-100 transition-colors flex items-center gap-1 shrink-0 font-bold cursor-pointer">
            <span class="material-symbols-outlined text-[18px] text-gray-600 group-hover:text-[#e60012]">verified_user</span>
            <span>Hướng dẫn &amp; Chính sách</span>
            <span class="material-symbols-outlined text-[16px] text-gray-500 group-hover:rotate-180 transition-transform">keyboard_arrow_down</span>
          </button>
          <!-- Dropdown Services -->
          <div id="pxServicesDropdown" class="hidden group-hover:block absolute top-full left-0 z-50 mt-1 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-gray-800 transition-all">
            <a href="<?php echo esc_url( home_url( '/quy-trinh-thu-mua/' ) ); ?>" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
              <span class="material-symbols-outlined text-[19px] text-[#e60012]">sync</span>
              <div>
                <div>Quy trình thu mua 7 bước</div>
                <div class="text-[10px] text-gray-500 font-normal">Minh bạch • Công khai 30 bước test</div>
              </div>
            </a>
            <a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-red-50 text-xs font-bold text-gray-800 hover:text-[#e60012] transition-colors">
              <span class="material-symbols-outlined text-[19px] text-[#e60012]">rule</span>
              <div>
                <div>Tiêu chuẩn Grade A / B / C / D</div>
                <div class="text-[10px] text-gray-500 font-normal">Quy chuẩn thẩm định phần cứng</div>
              </div>
            </a>
            <div class="border-t border-gray-100 my-1"></div>
            <a href="<?php echo esc_url( home_url( '/kho-may-cu/#b2b' ) ); ?>" class="flex items-center gap-2.5 p-2 rounded-xl bg-red-50/50 hover:bg-red-50 text-xs font-bold text-[#b7000c] transition-colors">
              <span class="material-symbols-outlined text-[19px] text-[#e60012]">storefront</span>
              <div>
                <div class="flex items-center gap-1.5">
                  <span>Bán sỉ B2B đại lý</span>
                  <span class="text-[9px] bg-[#e60012] text-white px-1.5 py-0.2 rounded-full font-bold">Giá sỉ</span>
                </div>
                <div class="text-[10px] text-gray-600 font-normal">Nguồn hàng ổn định số lượng toàn quốc</div>
              </div>
            </a>
          </div>
        </div>

        <!-- 5. ĐỊNH GIÁ NGAY (Hiển thị trong thanh trượt ngang trên Mobile) -->
        <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="md:hidden px-3.5 py-2 rounded-xl bg-gradient-to-r from-[#e60012] to-[#b7000c] text-white flex items-center gap-1.5 shrink-0 font-black shadow-xs text-xs">
          <span class="material-symbols-outlined text-[17px]">calculate</span>
          <span>ĐỊNH GIÁ NGAY</span>
          <span class="text-[9.5px] bg-white/20 text-white px-1.5 py-0.5 rounded-full font-bold">30s</span>
        </a>

      </nav>

      <!-- Right: Hotline + Nút CTA Desktop [ ĐỊNH GIÁ NGAY 30s ] -->
      <div class="hidden md:flex items-center gap-2 sm:gap-3 shrink-0 pl-2">
        <a href="tel:18006868" class="hidden 2xl:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 hover:bg-red-100 border border-red-200/80 text-[#e60012] font-black text-xs transition-all shadow-2xs whitespace-nowrap">
          <span class="material-symbols-outlined text-[16px] text-[#e60012]">call</span>
          <span>1800.6868</span>
        </a>

        <!-- Nút CTA Định Giá Ngay Nổi Bật (Desktop & Tablet) -->
        <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-3.5 xl:px-4 py-2 rounded-xl bg-gradient-to-r from-[#e60012] to-[#b7000c] hover:from-[#b7000c] hover:to-[#910009] text-white flex items-center gap-1.5 shrink-0 transition-all shadow-sm hover:shadow-md font-black text-[12.5px] xl:text-[13.5px] group">
          <span class="material-symbols-outlined text-[18px] group-hover:rotate-12 transition-transform">calculate</span>
          <span>ĐỊNH GIÁ NGAY</span>
          <span class="text-[10px] bg-white/25 text-white px-1.5 py-0.5 rounded-full font-bold leading-none">30s</span>
        </a>
      </div>

      <!-- ===================================================
           PHONEX BUYBACK MEGA MENU (DỰA TRÊN YÊU CẦU ĐẶC TẢ)
           Nhóm 1: Định giá & Thu mua
           Nhóm 2: Thương hiệu phổ biến (Lấy ĐỘNG từ DB)
           =================================================== -->
      <?php
      global $wpdb;
      $t_brands = $wpdb->prefix . 'phonex_buyback_brands';
      $featured_brands = $wpdb->get_results( "SELECT * FROM $t_brands WHERE is_active = 1 AND is_featured = 1 ORDER BY sort_order ASC, name ASC LIMIT 12" );
      if ( empty( $featured_brands ) ) {
          $featured_brands = $wpdb->get_results( "SELECT * FROM $t_brands WHERE is_active = 1 ORDER BY sort_order ASC, name ASC LIMIT 12" );
      }
      ?>
      <div id="pxBuybackMegaMenu" onmouseenter="PhoneXBuybackMegaMenu.onEnter()" onmouseleave="PhoneXBuybackMegaMenu.onLeave()" class="hidden absolute top-full left-0 right-0 z-50 mt-1 bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 md:p-8 text-gray-800 transition-all duration-200">
        
        <!-- Mega Menu Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-red-50 text-[#e60012] flex items-center justify-center">
              <span class="material-symbols-outlined text-[22px]">currency_exchange</span>
            </div>
            <div>
              <h3 class="font-black text-gray-900 text-lg md:text-xl tracking-tight">Hệ Thống Thu Mua Điện Thoại PhoneX</h3>
              <p class="text-xs text-gray-700 font-semibold">Định giá công khai • Kiểm định 30 bước • Thanh toán trong 5 phút</p>
            </div>
          </div>
          <button type="button" aria-label="<?php esc_attr_e('Đóng menu', 'phonex'); ?>" onclick="PhoneXBuybackMegaMenu.close()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-colors">
            <span class="material-symbols-outlined text-[18px]">close</span>
          </button>
        </div>

        <!-- 2 Groups Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
          
          <!-- NHÓM 1: DỊCH VỤ & QUY CHUẨN THU MUA (5 cols) -->
          <div class="lg:col-span-5 space-y-4">
            <h4 class="font-black text-gray-900 text-sm md:text-base flex items-center gap-2 uppercase tracking-wider text-[#e60012]">
              <span class="w-2 h-4 bg-[#e60012] rounded-full"></span>
              <span>Dịch Vụ &amp; Quy Chuẩn Thu Mua</span>
            </h4>

            <div class="space-y-2">
              <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="flex items-start gap-3.5 p-3 rounded-2xl hover:bg-red-50/60 border border-transparent hover:border-red-100 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-[#b7000c] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                  <span class="material-symbols-outlined text-[22px]">calculate</span>
                </div>
                <div>
                  <div class="text-sm font-bold text-gray-900 group-hover:text-[#e60012] transition-colors">Công cụ định giá tự động 30s</div>
                  <div class="text-xs text-gray-700 font-medium mt-0.5">Tự đánh giá tình trạng máy và nhận báo giá trong 30 giây</div>
                </div>
              </a>

              <a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="flex items-start gap-3.5 p-3 rounded-2xl hover:bg-red-50/60 border border-transparent hover:border-red-100 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                  <span class="material-symbols-outlined text-[22px]">table_chart</span>
                </div>
                <div>
                  <div class="text-sm font-bold text-gray-900 group-hover:text-[#e60012] transition-colors">Bảng giá thu mua chi tiết</div>
                  <div class="text-xs text-gray-700 font-medium mt-0.5">Tổng hợp 300+ model điện thoại theo Grade A/B/C/D</div>
                </div>
              </a>

              <a href="<?php echo esc_url( home_url( '/quy-trinh-thu-mua/' ) ); ?>" class="flex items-start gap-3.5 p-3 rounded-2xl hover:bg-red-50/60 border border-transparent hover:border-red-100 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                  <span class="material-symbols-outlined text-[22px]">sync</span>
                </div>
                <div>
                  <div class="text-sm font-bold text-gray-900 group-hover:text-[#e60012] transition-colors">Quy trình thu mua 7 bước</div>
                  <div class="text-xs text-gray-700 font-medium mt-0.5">Kiểm định minh bạch, công khai, giải ngân 5 phút</div>
                </div>
              </a>

              <a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="flex items-start gap-3.5 p-3 rounded-2xl hover:bg-red-50/60 border border-transparent hover:border-red-100 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                  <span class="material-symbols-outlined text-[22px]">rule</span>
                </div>
                <div>
                  <div class="text-sm font-bold text-gray-900 group-hover:text-[#e60012] transition-colors">Tiêu chuẩn kiểm định (Grade A, B, C, D)</div>
                  <div class="text-xs text-gray-700 font-medium mt-0.5">Barem 30 bước phân loại tình trạng máy chi tiết</div>
                </div>
              </a>
            </div>
          </div>

          <!-- NHÓM 2: THƯƠNG HIỆU PHỔ BIẾN (LẤY ĐỘNG TỪ DATABASE) (7 cols) -->
          <div class="lg:col-span-7 lg:border-l lg:border-gray-100 lg:pl-8 space-y-4">
            <div class="flex items-center justify-between">
              <h4 class="font-black text-gray-900 text-sm md:text-base flex items-center gap-2 uppercase tracking-wider text-[#e60012]">
                <span class="w-2 h-4 bg-[#e60012] rounded-full"></span>
                <span>Nhóm Thương Hiệu Phổ Biến</span>
              </h4>
              <a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="text-xs font-bold text-[#e60012] hover:underline flex items-center gap-1">
                <span>Xem tất cả thương hiệu</span>
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
              </a>
            </div>

            <!-- Dynamic Brand Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
              <?php if ( ! empty( $featured_brands ) ) : ?>
                <?php foreach ( $featured_brands as $fb ) : 
                  $b_url = home_url( '/thu-mua-dien-thoai/' . $fb->slug . '/' );
                ?>
                  <a href="<?php echo esc_url( $b_url ); ?>" class="flex flex-col items-center p-3 rounded-2xl border border-gray-100 hover:border-[#e60012] hover:bg-red-50/30 transition-all text-center group shadow-2xs">
                    <div class="w-14 h-12 rounded-xl bg-gray-50 group-hover:bg-white flex items-center justify-center p-2 mb-2 transition-colors">
                      <?php echo phonex_get_brand_logo_img( $fb, 'max-w-full max-h-full object-contain' ); ?>
                    </div>
                    <span class="text-xs font-bold text-gray-800 group-hover:text-[#e60012] transition-colors"><?php echo esc_html( $fb->name ); ?></span>
                    <span class="text-[10px] text-gray-600 font-semibold mt-0.5">Bảng giá 2026</span>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <!-- Bottom Promo Banner in Mega Menu -->
            <div class="mt-4 p-4 rounded-2xl bg-gradient-to-r from-gray-900 to-[#1e2329] text-white flex items-center justify-between gap-4">
              <div>
                <div class="text-xs font-bold text-red-400 uppercase">Đối tác B2B &amp; Khách Sỉ</div>
                <div class="text-sm font-bold text-white mt-0.5">Thu mua số lượng lớn từ công ty, doanh nghiệp với mức giá chiết khấu ưu đãi</div>
              </div>
              <a href="tel:18006868" class="px-4 py-2 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs shrink-0 transition-colors">
                Liên hệ sỉ
              </a>
            </div>

          </div>

        </div>

        <!-- Footer Notice -->
        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between text-xs gap-2">
          <div class="text-gray-700 font-medium flex items-center gap-1.5">
            <span class="material-symbols-outlined text-green-600 text-[18px]">verified</span>
            <span>Cam kết 100% kiểm định công khai &bull; Không ép giá &bull; Chuyển khoản trong 5 phút</span>
          </div>
          <a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="font-bold text-[#e60012] hover:underline flex items-center gap-1">
            <span>Xem tất cả thương hiệu &rarr;</span>
          </a>
        </div>

      </div>

    </div>
  </div>

  <!-- Buyback Mega Menu Controller & Header Search Autocomplete -->
  <script>
  var PhoneXBuybackMegaMenu = (function() {
    var timer = null;
    var menu = null;
    var arrow = null;

    function getEls() {
      if (!menu) menu = document.getElementById('pxBuybackMegaMenu');
      if (!arrow) arrow = document.getElementById('pxBuybackMenuArrow');
    }

    return {
      open: function() {
        getEls();
        if (timer) clearTimeout(timer);
        if (menu) {
          menu.classList.remove('hidden');
          menu.style.display = 'block';
        }
        if (arrow) arrow.style.transform = 'rotate(180deg)';
      },
      close: function() {
        getEls();
        if (menu) {
          menu.classList.add('hidden');
          menu.style.display = 'none';
        }
        if (arrow) arrow.style.transform = 'rotate(0deg)';
      },
      toggle: function(e) {
        if (e) e.preventDefault();
        getEls();
        if (menu && menu.classList.contains('hidden')) {
          this.open();
        } else {
          this.close();
        }
      },
      onEnter: function() {
        if (timer) clearTimeout(timer);
        this.open();
      },
      onLeave: function() {
        var self = this;
        timer = setTimeout(function() {
          self.close();
        }, 200);
      }
    };
  })();

  // Header Search Autocomplete Logic
  document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('headerBuybackSearchInput');
    var searchResults = document.getElementById('headerBuybackSearchResults');
    var debounceTimer = null;

    if (searchInput && searchResults) {
      searchInput.addEventListener('input', function() {
        var query = searchInput.value.trim();
        clearTimeout(debounceTimer);

        if (query.length < 2) {
          searchResults.classList.add('hidden');
          searchResults.innerHTML = '';
          return;
        }

        debounceTimer = setTimeout(function() {
          fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/search?q=' ) ); ?>' + encodeURIComponent(query))
            .then(function(res) { return res.json(); })
            .then(function(data) {
              if (data && data.results && data.results.length > 0) {
                var html = '';
                data.results.forEach(function(item) {
                  html += '<a href="' + item.url + '" class="flex items-center justify-between p-2.5 hover:bg-red-50 rounded-xl transition-colors border-b border-gray-50 last:border-0">';
                  html += '<div class="flex items-center gap-3">';
                  html += '<img src="' + item.image_url + '" class="w-10 h-10 object-contain rounded-lg bg-gray-50 p-1" alt="' + item.model_name + '" />';
                  html += '<div>';
                  html += '<div class="text-sm font-bold text-gray-900">' + item.model_name + '</div>';
                  html += '<div class="text-xs text-gray-700 font-medium flex items-center gap-1.5 mt-0.5">';
                  if (item.brand_logo) {
                    html += '<img src="' + item.brand_logo + '" class="w-3.5 h-3.5 object-contain inline-block" alt="' + item.brand_name + '" />';
                  }
                  html += '<span>' + item.brand_name + (item.series_name ? ' • ' + item.series_name : '') + '</span>';
                  html += '</div>';
                  html += '</div>';
                  html += '</div>';
                  html += '<div class="text-right">';
                  html += '<div class="text-[10px] font-bold text-gray-600">Giá thu tới</div>';
                  html += '<div class="text-sm font-black text-[#e60012]">' + item.base_buyback_price_formatted + '</div>';
                  html += '</div>';
                  html += '</a>';
                });
                searchResults.innerHTML = html;
                searchResults.classList.remove('hidden');
              } else {
                searchResults.innerHTML = '<div class="p-4 text-center text-xs text-gray-700 font-medium">Không tìm thấy thiết bị phù hợp. Thử tìm với iPhone 15, Galaxy S24...</div>';
                searchResults.classList.remove('hidden');
              }
            })
            .catch(function(err) {
              console.error('Header search error:', err);
            });
        }, 250);
      });

      document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
          searchResults.classList.add('hidden');
        }
      });
    }
  });
  </script>

  <!-- 4. TOP CAMPAIGN SLIDER (Sau Menu: Nằm gọn trong container max-w-[1440px], không tràn màn hình, tỷ lệ 2400x480, có nút X đóng) -->
  <?php if ( is_front_page() || is_home() ) : ?>
  <div id="pxTopCampaignSlider" class="w-full relative z-20 transition-all duration-300 overflow-hidden" style="transition: max-height 0.4s ease-in-out, opacity 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;">
    <div class="max-w-[1440px] mx-auto px-4 pt-3 pb-1">
      <div class="relative w-full rounded-2xl md:rounded-3xl overflow-hidden bg-[#7d000a] shadow-md border border-red-950/30">
        <!-- Close "X" Button -->
        <button 
          type="button" 
          id="pxTopCampaignSliderClose"
          onclick="PhoneXCampaignSlider.close(event)" 
          class="absolute top-2 right-2 sm:top-3 sm:right-3.5 z-30 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center backdrop-blur-xs transition-all duration-200 shadow-md group cursor-pointer" 
          title="<?php esc_attr_e('Đóng slide khuyến mãi', 'phonex'); ?>"
          aria-label="<?php esc_attr_e('Đóng slide khuyến mãi', 'phonex'); ?>"
        >
          <span class="material-symbols-outlined text-[18px] sm:text-[20px] group-hover:rotate-90 transition-transform duration-200">close</span>
        </button>

        <!-- Slides Track -->
        <div id="pxCampaignSliderTrack" class="relative w-full flex transition-transform duration-500 ease-out" style="transform: translateX(0%);">
          <!-- Slide 1: Thu Cũ Đổi Mới -->
          <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="w-full shrink-0 block relative group" style="aspect-ratio: 2400 / 600;">
            <img 
              src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/banners/slider-banner-1-2400x600.png' ); ?>" 
              alt="PhoneX Thu Cũ Đổi Mới - Định Giá Online 30 Giây - Trợ Giá Lên Đời Đến 3 Triệu - Giải Ngân Chuyển Khoản 5 Phút" 
              class="w-full h-full object-cover select-none"
              width="2400" 
              height="600"
              loading="eager"
            />
          </a>
          <!-- Slide 2: Kho Máy Cũ Like New 99% -->
          <a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="w-full shrink-0 block relative group" style="aspect-ratio: 2400 / 600;">
            <img 
              src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/banners/slider-banner-2-2400x600.png' ); ?>" 
              alt="Kho Máy Cũ PhoneX - Like New 99% Zin Nguyên Bản - Tiết Kiệm Đến 50% - Bảo Hành 12 Tháng 1 Đổi 1 - Nguồn Sỉ Chiết Khấu Cao" 
              class="w-full h-full object-cover select-none"
              width="2400" 
              height="600"
              loading="lazy"
            />
          </a>
        </div>

        <!-- Prev & Next Arrows -->
        <button 
          type="button"
          onclick="PhoneXCampaignSlider.prev(event)" 
          class="absolute left-2 sm:left-3.5 top-1/2 -translate-y-1/2 z-20 w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-black/40 hover:bg-black/75 text-white flex items-center justify-center backdrop-blur-xs transition-all duration-200 shadow-md cursor-pointer hover:scale-105"
          aria-label="<?php esc_attr_e('Slide trước', 'phonex'); ?>"
        >
          <span class="material-symbols-outlined text-[18px] sm:text-[22px]">chevron_left</span>
        </button>
        <button 
          type="button" 
          onclick="PhoneXCampaignSlider.next(event)" 
          class="absolute right-10 sm:right-13 top-1/2 -translate-y-1/2 z-20 w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-black/40 hover:bg-black/75 text-white flex items-center justify-center backdrop-blur-xs transition-all duration-200 shadow-md cursor-pointer hover:scale-105"
          aria-label="<?php esc_attr_e('Slide tiếp theo', 'phonex'); ?>"
        >
          <span class="material-symbols-outlined text-[18px] sm:text-[22px]">chevron_right</span>
        </button>

        <!-- Indicators / Dots -->
        <div class="absolute bottom-2 sm:bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-1 rounded-full bg-black/30 backdrop-blur-xs">
          <button type="button" onclick="PhoneXCampaignSlider.goTo(0)" class="px-slider-dot w-5 sm:w-6 h-1.5 sm:h-2 rounded-full bg-white shadow-xs transition-all duration-300" aria-label="Slide 1"></button>
          <button type="button" onclick="PhoneXCampaignSlider.goTo(1)" class="px-slider-dot w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" aria-label="Slide 2"></button>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ===================================================
       LOCATION PICKER MODAL (Strictly Hidden by Default)
       =================================================== -->
  <div id="pxLocationModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4" style="display: none;" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Chọn tỉnh thành', 'phonex'); ?>">
    <!-- Backdrop Overlay -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" onclick="PhoneXLocation.closeModal()"></div>
    
    <!-- Modal Dialog Sheet -->
    <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100 flex flex-col max-h-[85vh]">
      <!-- Modal Header -->
      <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/80 shrink-0">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-[#ffdad5] text-[#e60012] flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]">location_on</span>
          </div>
          <div>
            <h3 class="text-base sm:text-lg font-extrabold text-gray-900 leading-tight">Chọn Khu Vực Của Bạn</h3>
            <p class="text-xs text-gray-700 font-medium mt-0.5">Hiển thị giá ưu đãi và tồn kho tại showroom gần bạn nhất</p>
          </div>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Đóng', 'phonex'); ?>" onclick="PhoneXLocation.closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-700 transition-colors">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <!-- Quick Search City Input -->
      <div class="p-3 border-b border-gray-100 shrink-0">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-gray-600 text-[20px]">search</span>
          <input 
            type="text" 
            id="pxCitySearchInput" 
            oninput="PhoneXLocation.filterCities(this.value)" 
            class="w-full h-10 pl-10 pr-4 bg-gray-100 rounded-xl text-sm text-gray-900 placeholder-gray-500 border border-transparent focus:border-[#e60012] focus:bg-white focus:outline-none transition-all" 
            placeholder="Nhập tên tỉnh, thành phố..."
          >
        </div>
      </div>

      <!-- Province / City List -->
      <div id="pxCityListContainer" class="p-4 overflow-y-auto max-h-[50vh] grid grid-cols-2 sm:grid-cols-3 gap-2">
        <button type="button" onclick="PhoneXLocation.selectCity('Hồ Chí Minh')" class="px-city-btn p-3 rounded-xl border border-[#ffdad5] bg-[#ffdad5] text-[#b7000c] font-bold text-sm text-left hover:border-[#e60012] hover:bg-[#ffdad5] transition-all flex items-center justify-between">
          <span>Hồ Chí Minh</span>
          <span class="text-[10px] bg-[#e60012] text-white font-extrabold px-1.5 py-0.2 rounded-full">128 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Hà Nội')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Hà Nội</span>
          <span class="text-[10px] text-gray-600 font-bold">85 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Đà Nẵng')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Đà Nẵng</span>
          <span class="text-[10px] text-gray-600 font-bold">24 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Cần Thơ')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Cần Thơ</span>
          <span class="text-[10px] text-gray-600 font-bold">18 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Hải Phòng')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Hải Phòng</span>
          <span class="text-[10px] text-gray-600 font-bold">16 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Bình Dương')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Bình Dương</span>
          <span class="text-[10px] text-gray-600 font-bold">22 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Đồng Nai')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Đồng Nai</span>
          <span class="text-[10px] text-gray-600 font-bold">19 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Vũng Tàu')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Vũng Tàu</span>
          <span class="text-[10px] text-gray-600 font-bold">12 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Nha Trang')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Nha Trang</span>
          <span class="text-[10px] text-gray-600 font-bold">10 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Huế')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Huế</span>
          <span class="text-[10px] text-gray-600 font-bold">8 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Quảng Ninh')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Quảng Ninh</span>
          <span class="text-[10px] text-gray-600 font-bold">9 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Thanh Hóa')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-[#e60012] hover:bg-[#ffdad5] text-gray-800 hover:text-[#b7000c] font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Thanh Hóa</span>
          <span class="text-[10px] text-gray-600 font-bold">7 shop</span>
        </button>
      </div>

      <!-- Modal Footer -->
      <div class="p-3 sm:p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between text-xs shrink-0">
        <a href="<?php echo esc_url(home_url('/showroom/')); ?>" class="font-bold text-[#e60012] hover:underline flex items-center gap-1">
          <span>Xem 128 Showroom toàn quốc</span>
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
        <span class="text-gray-700 font-semibold">Giao nhanh 2h</span>
      </div>
    </div>
  </div>

  <!-- ===================================================
       MOBILE BOTTOM SHEET POPUP MENU (Strictly Hidden by Default)
       =================================================== -->
  <div id="pxMenuPopup" class="fixed inset-0 z-[9999] hidden items-end md:items-center justify-center" style="display: none;" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Menu điều hướng di động', 'phonex'); ?>">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-xs" onclick="PhoneXPopups.closeMenu()"></div>
    <div class="relative z-10 w-full md:max-w-md bg-white rounded-t-3xl md:rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">
      <div class="w-14 h-1.5 bg-gray-300 rounded-full mx-auto mt-3 mb-1 md:hidden shrink-0"></div>
      
      <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-[#e60012] flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-[18px]">smartphone</span>
          </div>
          <span class="text-2xl font-black text-gray-900 tracking-tight">Phone<span class="text-[#e60012]">X</span></span>
          <span class="text-xs bg-[#ffdad5] text-[#b7000c] font-bold px-2 py-0.5 rounded-full uppercase">Menu</span>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Đóng popup', 'phonex'); ?>" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 active:scale-95 transition-all" onclick="PhoneXPopups.closeMenu()">
          <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
      </div>

      <div class="overflow-y-auto p-4 space-y-4">
        <!-- User Banner Card -->
        <div class="p-4 rounded-2xl bg-gradient-to-r from-[#e60012] to-[#b7000c] text-white flex items-center justify-between shadow-md">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-sm ring-2 ring-white/40">
              <?php echo is_user_logged_in() ? esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 2))) : 'MQ'; ?>
            </div>
            <div>
              <div class="font-extrabold text-base leading-tight"><?php echo is_user_logged_in() ? esc_html(wp_get_current_user()->display_name) : 'Minh Quân'; ?></div>
              <div class="text-xs text-red-100 mt-0.5">Thành viên VIP (14.850 PX)</div>
            </div>
          </div>
          <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/tai-khoan/')); ?>" class="px-3 py-1.5 bg-white text-[#e60012] rounded-xl text-xs font-bold shadow-xs hover:bg-gray-50 transition-colors">
            Hồ sơ &rarr;
          </a>
        </div>

        <!-- Location Quick Change -->
        <div class="p-3 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#e60012] text-[18px]">location_on</span>
            <span class="text-xs text-gray-600">Khu vực: <strong id="pxMobileLocationLabel" class="text-gray-900 font-bold">Hồ Chí Minh</strong></span>
          </div>
          <button type="button" onclick="PhoneXPopups.closeMenu(); PhoneXLocation.openModal();" class="text-xs text-[#e60012] font-bold hover:underline">
            Đổi khu vực &rarr;
          </button>
        </div>

        <!-- Quick Action Grid -->
        <div>
          <div class="text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Tiện ích nhanh</div>
          <div class="grid grid-cols-2 gap-2">
            <a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-[#e60012] text-[22px]">local_shipping</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">Tra cứu đơn</div><div class="text-[11px] text-gray-700 font-medium">Tiến độ giao hàng</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-green-600 text-[22px]">verified_user</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">Bảo hành</div><div class="text-[11px] text-gray-700 font-medium">Tra cứu IMEI/SĐT</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="p-3 rounded-xl bg-[#ffdad5] hover:bg-[#ffdad5] border border-[#ffdad5] flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-[#e60012] text-[22px]">sync_alt</span>
              <div class="text-left"><div class="text-xs font-bold text-[#b7000c]">Thu cũ đổi mới</div><div class="text-[11px] text-[#e60012]">Trợ giá 3Tr</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/showroom/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-purple-600 text-[22px]">store</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">128 Cửa hàng</div><div class="text-[11px] text-gray-700 font-medium">Gần bạn nhất</div></div>
            </a>
          </div>
        </div>

        <!-- Requested Main Menu Links for Mobile -->
        <div>
          <div class="text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Danh mục chính</div>
          <div class="grid grid-cols-2 gap-2 text-xs font-bold text-gray-800">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-[#ffdad5] hover:text-[#e60012] border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-[#e60012] text-[18px]">home</span>
              <span>Trang chủ</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="p-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-[#b7000c] border border-red-200 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-[#e60012] text-[18px]">currency_exchange</span>
              <span>Thu mua máy</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="p-2.5 rounded-xl bg-red-50/80 hover:bg-red-100 text-[#b7000c] border border-red-200/90 transition-colors flex items-center justify-between">
              <span class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[#e60012] text-[18px]">table_chart</span>
                <span>Bảng giá thu</span>
              </span>
              <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded-full bg-[#e60012] text-white">300+</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="p-2.5 rounded-xl bg-amber-50/80 hover:bg-amber-100 text-amber-900 border border-amber-200 transition-colors flex items-center justify-between">
              <span class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-amber-700 text-[18px]">inventory_2</span>
                <span>Kho máy cũ</span>
              </span>
              <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded-full bg-[#e60012] text-white">99%</span>
            </a>
            <!-- CTA Button Định Giá Máy Nổi Bật -->
            <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="p-3 rounded-xl bg-gradient-to-r from-[#e60012] to-[#b7000c] text-white hover:from-[#b7000c] hover:to-[#910009] transition-all flex items-center justify-center gap-2 col-span-2 shadow-xs font-black text-sm">
              <span class="material-symbols-outlined text-white text-[20px]">calculate</span>
              <span>Định giá máy online ngay (30 giây) &rarr;</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/quy-trinh-thu-mua/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-[#ffdad5] hover:text-[#e60012] border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-teal-600 text-[18px]">sync</span>
              <span>Quy trình 7 bước</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-[#ffdad5] hover:text-[#e60012] border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-emerald-600 text-[18px]">rule</span>
              <span>Chuẩn Grade A-D</span>
            </a>
          </div>

          <!-- Phụ kiện PhoneX 4 Groups Quick Access -->
          <div class="mt-4 pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between mb-2">
              <div class="text-[11px] font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[#e60012] text-[16px]">headphones</span>
                <span>Phụ Kiện Chính Hãng PhoneX</span>
              </div>
              <a href="<?php echo esc_url( home_url( '/product-category/phu-kien/' ) ); ?>" class="text-[11px] text-[#e60012] font-bold hover:underline">Tất cả &rarr;</a>
            </div>
            
            <div class="space-y-2 text-xs">
              <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                <div class="font-bold text-gray-900 mb-1.5 flex items-center gap-1 text-[11px]">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#e60012]"></span> Phụ kiện di động
                </div>
                <div class="flex flex-wrap gap-1">
                  <a href="<?php echo esc_url(home_url('/sac-dtdd/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Sạc dự phòng</a>
                  <a href="<?php echo esc_url(home_url('/sac-cap/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Sạc cáp</a>
                  <a href="<?php echo esc_url(home_url('/op-lung-flipcover/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Ốp lưng</a>
                  <a href="<?php echo esc_url(home_url('/mieng-dan-man-hinh/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Kính cường lực</a>
                  <a href="<?php echo esc_url(home_url('/mieng-dan-camera/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Dán Camera</a>
                  <a href="<?php echo esc_url(home_url('/op-lung-may-tinh-bang/')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Bao da iPad</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=tui-dung-airpods')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Túi AirPods</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=gia-do-dien-thoai-laptop')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Giá đỡ</a>
                </div>
              </div>

              <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                <div class="font-bold text-gray-900 mb-1.5 flex items-center gap-1 text-[11px]">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#e60012]"></span> Nghe nhìn &amp; Lưu trữ
                </div>
                <div class="flex flex-wrap gap-1">
                  <a href="<?php echo esc_url(home_url('/shop/?category=tai-nghe-bluetooth')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Tai nghe Bluetooth</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=loa')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Loa</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=the-nho')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Thẻ nhớ</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=o-cung')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Ổ cứng</a>
                </div>
              </div>

              <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                <div class="font-bold text-gray-900 mb-1.5 flex items-center gap-1 text-[11px]">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#e60012]"></span> Laptop, PC &amp; Camera
                </div>
                <div class="flex flex-wrap gap-1">
                  <a href="<?php echo esc_url(home_url('/shop/?category=chuot-may-tinh')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Chuột</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=ban-phim')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Bàn phím</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=hub-cap-chuyen-doi')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Hub chuyển đổi</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=camera-giam-sat')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Camera giám sát</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Hotline Call Support -->
        <div class="pt-1">
          <a href="tel:18006868" class="w-full py-3 px-4 bg-gray-900 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-black transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px] text-[#e60012]">call</span>
            Gọi tư vấn miễn phí: 1800.6868
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================================================
       MOBILE TOP SEARCH POPUP MODAL (Strictly Hidden by Default)
       =================================================== -->
  <div id="pxSearchPopup" class="fixed inset-0 z-[9999] hidden items-start justify-center p-4 pt-16" style="display: none;" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Tìm kiếm di động', 'phonex'); ?>">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-xs" onclick="PhoneXPopups.closeSearch()"></div>
    <div class="relative z-10 w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="p-3 border-b border-gray-100 flex items-center gap-2 bg-white">
        <span class="material-symbols-outlined text-gray-400 pl-1 text-[22px]">search</span>
        <input id="pxMobileSearchInput" name="s" value="<?php echo get_search_query(); ?>" class="w-full h-10 text-sm md:text-base text-gray-900 placeholder-gray-400 focus:outline-none bg-transparent" placeholder="Bạn tìm gì? iPhone 16, S25 Ultra..." type="search">
        <?php if (function_exists('is_woocommerce')) : ?><input type="hidden" name="post_type" value="product" /><?php endif; ?>
        <button type="button" aria-label="<?php esc_attr_e('Đóng tìm kiếm', 'phonex'); ?>" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500" onclick="PhoneXPopups.closeSearch()">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </form>
      <div class="p-3 bg-gray-50">
        <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1">
          <span class="material-symbols-outlined text-[#e60012] text-[15px]">local_fire_department</span>
          Tìm kiếm xu hướng
        </div>
        <div class="flex flex-wrap gap-1.5 text-xs">
          <a href="<?php echo esc_url(home_url('/?s=iPhone+16+Pro+Max&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-[#e60012] hover:text-[#e60012] transition-colors font-medium">iPhone 16 Pro Max</a>
          <a href="<?php echo esc_url(home_url('/?s=Galaxy+S25+Ultra&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-[#e60012] hover:text-[#e60012] transition-colors font-medium">Galaxy S25 Ultra</a>
          <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="px-2.5 py-1 bg-[#ffdad5] border border-[#ffdad5] rounded-full text-[#e60012] font-bold hover:bg-[#ffdad5] transition-colors">Thu cũ trợ giá 3Tr</a>
          <a href="<?php echo esc_url(home_url('/?s=Xiaomi+15&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-[#e60012] hover:text-[#e60012] transition-colors font-medium">Xiaomi 15 Pro</a>
          <a href="<?php echo esc_url(home_url('/dien-thoai-cu/')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-[#e60012] hover:text-[#e60012] transition-colors font-medium">Máy cũ 99%</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================================================
       HEADER SCRIPTS (Popups, Location & Banner Controller)
       =================================================== -->
  <script>
    // 1. Mobile Popups Controller
    window.PhoneXPopups = {
      openMenu: function() {
        const p = document.getElementById('pxMenuPopup');
        if (p) { 
          p.style.display = 'flex'; 
          p.classList.remove('hidden'); 
          document.body.style.overflow = 'hidden'; 
        }
      },
      closeMenu: function() {
        const p = document.getElementById('pxMenuPopup');
        if (p) { 
          p.style.display = 'none'; 
          p.classList.add('hidden'); 
          document.body.style.overflow = ''; 
        }
      },
      openSearch: function() {
        const p = document.getElementById('pxSearchPopup');
        if (p) {
          p.style.display = 'flex';
          p.classList.remove('hidden');
          document.body.style.overflow = 'hidden';
          setTimeout(() => { const input = document.getElementById('pxMobileSearchInput'); if (input) input.focus(); }, 150);
        }
      },
      closeSearch: function() {
        const p = document.getElementById('pxSearchPopup');
        if (p) { 
          p.style.display = 'none'; 
          p.classList.add('hidden'); 
          document.body.style.overflow = ''; 
        }
      }
    };

    // 2. Location Picker Controller
    window.PhoneXLocation = {
      openModal: function() {
        const m = document.getElementById('pxLocationModal');
        if (m) { 
          m.style.display = 'flex'; 
          m.classList.remove('hidden'); 
          document.body.style.overflow = 'hidden'; 
        }
      },
      closeModal: function() {
        const m = document.getElementById('pxLocationModal');
        if (m) { 
          m.style.display = 'none'; 
          m.classList.add('hidden'); 
          document.body.style.overflow = ''; 
        }
      },
      selectCity: function(cityName) {
        localStorage.setItem('phonex_user_location', cityName);
        const label = document.getElementById('pxLocationLabel');
        const mLabel = document.getElementById('pxMobileLocationLabel');
        if (label) label.textContent = cityName;
        if (mLabel) mLabel.textContent = cityName;
        this.closeModal();
      },
      filterCities: function(keyword) {
        const term = keyword.toLowerCase().trim();
        const buttons = document.querySelectorAll('#pxCityListContainer .px-city-btn');
        buttons.forEach(btn => {
          const text = btn.textContent.toLowerCase();
          btn.style.display = text.includes(term) ? 'flex' : 'none';
        });
      },
      init: function() {
        const saved = localStorage.getItem('phonex_user_location');
        if (saved) {
          const label = document.getElementById('pxLocationLabel');
          const mLabel = document.getElementById('pxMobileLocationLabel');
          if (label) label.textContent = saved;
          if (mLabel) mLabel.textContent = saved;
        }
      }
    };

    // 3. Top Banner Controller
    window.PhoneXTopBanner = {
      dismiss: function() {
        const b = document.getElementById('pxTopCampaignBanner');
        if (b) {
          b.style.display = 'none';
          sessionStorage.setItem('phonex_top_banner_dismissed', '1');
        }
      },
      init: function() {
        if (sessionStorage.getItem('phonex_top_banner_dismissed') === '1') {
          const b = document.getElementById('pxTopCampaignBanner');
          if (b) b.style.display = 'none';
        }
      }
    };

    // 4. Accessories Mega Menu Controller
    window.PhoneXAccessoriesMegaMenu = {
      timer: null,
      open: function() {
        if (this.timer) clearTimeout(this.timer);
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (!menu) return;
        menu.classList.remove('hidden');
        menu.style.display = 'block';
        if (arrow) arrow.style.transform = 'rotate(180deg)';
        if (btn) btn.classList.add('bg-[#ffdad5]', 'text-[#e60012]');
      },
      close: function() {
        if (this.timer) clearTimeout(this.timer);
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (menu) {
          menu.classList.add('hidden');
          menu.style.display = 'none';
        }
        if (arrow) arrow.style.transform = 'rotate(0deg)';
        if (btn) btn.classList.remove('bg-[#ffdad5]', 'text-[#e60012]');
      },
      toggle: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden') || menu.style.display === 'none';
        if (isHidden) {
          this.open();
        } else {
          this.close();
        }
      },
      onEnter: function() {
        if (this.timer) clearTimeout(this.timer);
        this.open();
      },
      onLeave: function() {
        if (this.timer) clearTimeout(this.timer);
        const self = this;
        this.timer = setTimeout(function() {
          self.close();
        }, 180);
      }
    };

    // Campaign Slider Controller (2400x480)
    const PhoneXCampaignSlider = {
      currentIndex: 0,
      totalSlides: 2,
      autoPlayTimer: null,
      isPaused: false,

      init: function() {
        const slider = document.getElementById('pxTopCampaignSlider');
        if (!slider) return;
        
        try {
          if (sessionStorage.getItem('phonex_top_slider_dismissed') === '1') {
            slider.style.display = 'none';
            return;
          }
        } catch (e) {}

        this.updateUI();
        this.startAutoPlay();

        const self = this;
        slider.addEventListener('mouseenter', function() { self.isPaused = true; });
        slider.addEventListener('mouseleave', function() { self.isPaused = false; });

        let touchStartX = 0;
        slider.addEventListener('touchstart', function(e) {
          touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        slider.addEventListener('touchend', function(e) {
          const touchEndX = e.changedTouches[0].screenX;
          if (touchStartX - touchEndX > 45) {
            self.next();
          } else if (touchEndX - touchStartX > 45) {
            self.prev();
          }
        }, { passive: true });
      },

      goTo: function(index) {
        this.currentIndex = (index + this.totalSlides) % this.totalSlides;
        this.updateUI();
        this.resetAutoPlay();
      },

      next: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
        this.updateUI();
        this.resetAutoPlay();
      },

      prev: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
        this.updateUI();
        this.resetAutoPlay();
      },

      updateUI: function() {
        const track = document.getElementById('pxCampaignSliderTrack');
        if (track) {
          track.style.transform = 'translateX(-' + (this.currentIndex * 100) + '%)';
        }
        const dots = document.querySelectorAll('.px-slider-dot');
        dots.forEach((dot, idx) => {
          if (idx === this.currentIndex) {
            dot.className = 'px-slider-dot w-5 sm:w-6 h-1.5 sm:h-2 rounded-full bg-white shadow-xs transition-all duration-300';
          } else {
            dot.className = 'px-slider-dot w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300';
          }
        });
      },

      startAutoPlay: function() {
        if (this.autoPlayTimer) clearInterval(this.autoPlayTimer);
        const self = this;
        this.autoPlayTimer = setInterval(function() {
          if (!self.isPaused) {
            self.currentIndex = (self.currentIndex + 1) % self.totalSlides;
            self.updateUI();
          }
        }, 4500);
      },

      resetAutoPlay: function() {
        this.startAutoPlay();
      },

      close: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const slider = document.getElementById('pxTopCampaignSlider');
        if (!slider) return;
        if (this.autoPlayTimer) clearInterval(this.autoPlayTimer);

        slider.style.maxHeight = slider.offsetHeight + 'px';
        slider.offsetHeight; // trigger reflow
        slider.style.maxHeight = '0px';
        slider.style.opacity = '0';
        slider.style.padding = '0';
        slider.style.margin = '0';
        slider.style.borderWidth = '0';
        slider.style.pointerEvents = 'none';

        setTimeout(function() {
          slider.style.display = 'none';
        }, 400);

        try {
          sessionStorage.setItem('phonex_top_slider_dismissed', '1');
        } catch (err) {}
      }
    };

    // Close accessories mega menu on outside click
    document.addEventListener('click', function(e) {
      const menu = document.getElementById('pxAccessoriesMegaMenu');
      const btn = document.getElementById('pxAccessoriesBtn');
      if (menu && menu.style.display === 'block') {
        if (!menu.contains(e.target) && btn && !btn.contains(e.target)) {
          PhoneXAccessoriesMegaMenu.close();
        }
      }
    });

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
      PhoneXLocation.init();
      PhoneXTopBanner.init();
      PhoneXCampaignSlider.init();
    });

    // Escape key listener for closing modals & mega menu
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') { 
        PhoneXPopups.closeMenu(); 
        PhoneXPopups.closeSearch(); 
        PhoneXLocation.closeModal(); 
        PhoneXAccessoriesMegaMenu.close();
      }
    });
  </script>
</header>
