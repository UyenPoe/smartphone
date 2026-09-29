<?php
/**
 * The header template for PhoneX WordPress Theme
 * Designed with TGDD-style structure & PhoneX flagship color scheme
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
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
  <style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style>
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-background font-body-regular text-body-regular text-on-surface antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- PhoneX Flagship Unified Header (TGDD Structure with PhoneX Brand Red & Clean Aesthetics) -->
<header class="sticky top-0 left-0 w-full z-50 bg-white shadow-xs font-sans" data-component="header">
  
  <!-- 1. TOP CAMPAIGN BANNER (TGDD Top Banner Structure) -->
  <div id="pxTopCampaignBanner" class="w-full bg-gradient-to-r from-red-700 via-red-600 to-rose-600 text-white text-sm md:text-base py-2.5 md:py-3 px-4 relative z-40 border-b border-red-800/40 shadow-xs">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
      <div class="flex items-center gap-2.5 overflow-hidden truncate">
        <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-xs text-white text-xs md:text-sm font-black px-3.5 py-1 rounded-full uppercase shrink-0 animate-pulse tracking-wide">
          <span class="material-symbols-outlined text-[18px]">bolt</span>
          72 Model Giá Sốc
        </span>
        <span class="font-extrabold hidden sm:inline text-sm md:text-[15px]">Duy nhất 3 ngày (28 – 30.09.2026):</span>
        <span class="truncate font-semibold text-sm md:text-[15px]">Giảm khủng đến <strong class="text-amber-300 font-black text-base md:text-lg px-0.5">35%</strong> cho Điện Thoại, Tablet &amp; Phụ Kiện</span>
      </div>
      <div class="flex items-center gap-2.5 shrink-0">
        <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>" class="px-4 md:px-5 py-1.5 md:py-2 bg-white text-red-600 hover:bg-gray-100 rounded-full font-black text-xs md:text-sm shadow-sm transition-all hover:scale-105 active:scale-95 shrink-0 uppercase tracking-tight flex items-center gap-1.5">
          <span>Mua Ngay</span>
          <span class="material-symbols-outlined text-[16px] md:text-[18px]">arrow_forward</span>
        </a>
        <button type="button" aria-label="Đóng banner" onclick="PhoneXTopBanner.dismiss()" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full hover:bg-white/20 text-white/90 hover:text-white transition-colors" title="Đóng thông báo">
          <span class="material-symbols-outlined text-[18px] md:text-[20px]">close</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. MAIN HEADER ROW (Logo | Pill Search Bar | 4 Actions: User, Voucher, Cart, Location) -->
  <div class="bg-white border-b border-gray-100 relative z-30">
    <div class="max-w-7xl mx-auto px-4 h-16 md:h-18 flex items-center justify-between gap-3 md:gap-6">
      
      <!-- Left: Mobile Hamburger + PhoneX Logo -->
      <div class="flex items-center gap-2 md:gap-3.5 shrink-0">
        <!-- Mobile Menu Hamburger Button -->
        <button type="button" aria-label="<?php esc_attr_e('Mở menu', 'phonex'); ?>" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors" onclick="PhoneXPopups.openMenu()">
          <span class="material-symbols-outlined text-[28px]">menu</span>
        </button>

        <!-- PhoneX Brand Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5 group">
          <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-red-600 group-hover:bg-red-700 flex items-center justify-center text-white shadow-sm shadow-red-200 transition-all">
            <span class="material-symbols-outlined text-[22px] md:text-[24px]">smartphone</span>
          </div>
          <div class="flex flex-col leading-none">
            <span class="text-2xl md:text-[26px] font-black text-gray-900 tracking-tight flex items-center">
              Phone<span class="text-red-600">X</span>
              <span class="text-[11px] text-gray-400 font-bold ml-0.5">.vn</span>
            </span>
            <span class="text-[10px] text-gray-500 font-semibold tracking-wider mt-0.5 hidden xl:inline">Hệ Thống 128 Showroom Toàn Quốc</span>
          </div>
        </a>
      </div>

      <!-- Center: Pill-shaped Search Bar (TGDD Structure) -->
      <div class="hidden sm:flex flex-1 max-w-lg lg:max-w-xl mx-2">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative w-full flex items-center">
          <span class="absolute left-4 text-gray-400 pointer-events-none material-symbols-outlined text-[20px]">search</span>
          <input 
            name="s" 
            value="<?php echo get_search_query(); ?>" 
            class="w-full h-11 pl-11 pr-12 bg-gray-100/90 hover:bg-gray-100 focus:bg-white rounded-full text-sm md:text-[15px] text-gray-900 placeholder-gray-400 border border-gray-200 focus:border-red-600 focus:ring-2 focus:ring-red-100 transition-all outline-none" 
            placeholder="Bạn tìm gì? iPhone 16 Pro Max, Galaxy S25, Xiaomi 15..." 
            type="search"
          >
          <?php if (function_exists('is_woocommerce')) : ?><input type="hidden" name="post_type" value="product" /><?php endif; ?>
          <button type="submit" aria-label="<?php esc_attr_e('Tìm kiếm', 'phonex'); ?>" class="absolute right-1.5 w-8 h-8 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors shadow-xs">
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </button>
        </form>
      </div>

      <!-- Right: 4 Action Items (Đăng nhập | Voucher | Giỏ hàng | Hồ Chí Minh >) -->
      <div class="flex items-center gap-2 sm:gap-4 shrink-0">
        
        <!-- Mobile Search Button -->
        <button type="button" aria-label="<?php esc_attr_e('Tìm kiếm', 'phonex'); ?>" onclick="PhoneXPopups.openSearch()" class="sm:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors">
          <span class="material-symbols-outlined text-[24px]">search</span>
        </button>

        <!-- 1. Đăng nhập / Tài khoản -->
        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/tai-khoan/')); ?>" class="flex items-center gap-1.5 text-gray-800 hover:text-red-600 transition-colors text-xs md:text-sm font-semibold group px-1 py-1">
          <?php if (is_user_logged_in()) : ?>
            <div class="w-7 h-7 rounded-full bg-red-100 text-red-600 font-bold text-xs flex items-center justify-center ring-2 ring-red-200">
              <?php echo esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 2))); ?>
            </div>
            <div class="hidden lg:flex flex-col text-left leading-tight">
              <span class="max-w-[85px] truncate font-bold"><?php echo esc_html(wp_get_current_user()->display_name); ?></span>
              <span class="text-[10px] text-red-600 font-bold uppercase">VIP Member</span>
            </div>
          <?php else : ?>
            <span class="material-symbols-outlined text-[24px] text-gray-700 group-hover:text-red-600 transition-colors">person</span>
            <span class="hidden sm:inline">Đăng nhập</span>
          <?php endif; ?>
        </a>

        <!-- 2. Voucher / Khuyến mãi -->
        <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>" class="flex items-center gap-1.5 text-gray-800 hover:text-red-600 transition-colors text-xs md:text-sm font-semibold group px-1 py-1">
          <div class="relative flex items-center">
            <span class="material-symbols-outlined text-[22px] text-red-600 group-hover:scale-110 transition-transform">confirmation_number</span>
            <span class="hidden xl:inline-block absolute -top-1 -right-2 px-1.5 py-0.2 bg-red-100 text-red-700 text-[9px] font-black rounded-full uppercase">Hot</span>
          </div>
          <span class="hidden sm:inline">Voucher</span>
        </a>

        <!-- 3. Giỏ hàng (Dynamic WooCommerce Cart Count) -->
        <?php
        $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
        $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
        $cart_total = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_total() : '0₫';
        ?>
        <a href="<?php echo esc_url($cart_url); ?>" class="flex items-center gap-1.5 text-gray-800 hover:text-red-600 transition-colors text-xs md:text-sm font-semibold group px-1 py-1">
          <div class="relative flex items-center">
            <span class="material-symbols-outlined text-[24px] text-gray-800 group-hover:text-red-600 transition-colors">shopping_cart</span>
            <span class="absolute -top-1.5 -right-2.5 bg-red-600 text-white text-[10px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center shadow-xs" data-cart-count><?php echo esc_html($cart_count); ?></span>
          </div>
          <span class="hidden sm:inline">Giỏ hàng</span>
        </a>

        <!-- 4. Location Selector (Hồ Chí Minh >) -->
        <button type="button" onclick="PhoneXLocation.openModal()" class="flex items-center gap-1 px-3 py-1.5 rounded-full border border-gray-200 bg-gray-50/90 hover:bg-gray-100 hover:border-red-400 text-gray-800 hover:text-red-600 text-xs md:text-[13px] font-semibold transition-all shrink-0 shadow-2xs" title="Bấm để chọn vị trí xem giá &amp; tồn kho">
          <span class="material-symbols-outlined text-red-600 text-[18px]">location_on</span>
          <span id="pxLocationLabel" class="max-w-[85px] sm:max-w-none truncate font-bold">Hồ Chí Minh</span>
          <span class="material-symbols-outlined text-gray-400 text-[16px]">chevron_right</span>
        </button>

      </div>
    </div>
  </div>

  <!-- 3. CATEGORY NAVIGATION BAR (Row 2: Requested Categories & TGDD-style Accessories Mega Menu) -->
  <div class="w-full bg-white border-b border-gray-200/80 shadow-2xs relative z-30">
    <div class="max-w-7xl mx-auto px-4 relative">
      <nav class="flex items-center gap-1 md:gap-2 py-1.5 overflow-x-auto whitespace-nowrap text-[13px] md:text-sm font-bold text-gray-800 scrollbar-none" aria-label="<?php esc_attr_e('Danh mục ngành hàng', 'phonex'); ?>">
        
        <!-- 1. Trang chủ -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-gray-600 hover:text-red-600">home</span>
          <span>Trang chủ</span>
        </a>

        <!-- 2. Điện thoại (với dropdown thương hiệu) -->
        <div class="relative group">
          <a href="<?php echo esc_url( home_url( '/shop/?category=smartphone' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1 shrink-0">
            <span class="material-symbols-outlined text-[18px] text-gray-600 group-hover:text-red-600">smartphone</span>
            <span>Điện thoại</span>
            <span class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-red-600 transition-transform group-hover:rotate-180">keyboard_arrow_down</span>
          </a>
          <!-- Dropdown thương hiệu -->
          <div class="hidden group-hover:block absolute top-full left-0 z-50 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-gray-800">
            <div class="font-bold text-gray-400 text-[11px] uppercase px-3 py-1.5">Thương hiệu điện thoại</div>
            <a href="<?php echo esc_url( home_url( '/product-category/apple/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
              <span>Apple iPhone (VN/A)</span>
              <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">Mới</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/product-category/samsung/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>Samsung Galaxy</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/xiaomi/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>Xiaomi &amp; POCO</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/oppo/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>OPPO</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/vivo/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>vivo</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/realme/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>realme</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/google-pixel/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>Google Pixel</span></a>
            <a href="<?php echo esc_url( home_url( '/product-category/nothing/' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors"><span>Nothing Phone</span></a>
            <div class="border-t border-gray-100 my-1"></div>
            <a href="<?php echo esc_url( home_url( '/shop/?category=smartphone' ) ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-bold text-red-600 hover:bg-red-50 transition-colors">
              <span>Xem tất cả điện thoại</span>
              <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
          </div>
        </div>

        <!-- 3. Điện thoại cũ giá tốt -->
        <a href="<?php echo esc_url( home_url( '/product-category/used/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-red-600">sync_alt</span>
          <span>Điện thoại cũ giá tốt</span>
          <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">99%</span>
        </a>

        <!-- 4. Phụ Kiện (Click để mở Mega Menu) -->
        <div class="relative" id="pxAccessoriesWrapper">
          <button type="button" id="pxAccessoriesBtn" onclick="PhoneXAccessoriesMegaMenu.toggle(event)" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1 shrink-0 cursor-pointer">
            <span class="material-symbols-outlined text-[18px] text-gray-600 group-hover:text-red-600">headphones</span>
            <span>Phụ Kiện</span>
            <span id="pxAccessoriesArrow" class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-red-600 transition-transform duration-200">keyboard_arrow_down</span>
          </button>
        </div>

        <!-- 5. Khuyến mãi Hot -->
        <a href="<?php echo esc_url( home_url( '/khuyen-mai/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-red-600">local_fire_department</span>
          <span>Khuyến mãi Hot</span>
          <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">Hot</span>
        </a>

        <!-- 6. Thu cũ đổi mới -->
        <a href="<?php echo esc_url( home_url( '/thu-cu-doi-moi/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-red-600">currency_exchange</span>
          <span>Thu cũ đổi mới</span>
          <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">Trợ giá 3Tr</span>
        </a>

        <!-- 7. Trả góp 0% -->
        <a href="<?php echo esc_url( home_url( '/tra-gop/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-amber-600">credit_card</span>
          <span>Trả góp 0%</span>
          <span class="text-[10px] bg-amber-100 text-amber-800 px-1.5 py-0.2 rounded-full font-bold">0% LS</span>
        </a>

        <!-- 8. Dịch vụ tiện ích ⌃ -->
        <div class="relative group ml-auto">
          <button type="button" class="border border-gray-200 bg-gray-50/90 hover:bg-red-50 hover:border-red-300 hover:text-red-600 text-gray-800 rounded-lg px-2.5 py-1 text-xs md:text-sm font-bold flex items-center gap-1.5 transition-all shadow-2xs">
            <span class="material-symbols-outlined text-[18px] text-red-600">receipt_long</span>
            <span>Dịch vụ tiện ích</span>
            <span class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-red-600 transition-transform group-hover:rotate-180">keyboard_arrow_down</span>
          </button>
          <div class="hidden group-hover:block absolute top-full right-0 z-50 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-gray-800">
            <div class="font-bold text-gray-400 text-[11px] uppercase px-3 py-1">Dịch vụ PhoneX</div>
            <a href="<?php echo esc_url( home_url( '/bao-hanh/' ) ); ?>" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
              <span class="material-symbols-outlined text-[18px] text-green-600">verified_user</span>
              <span>Tra cứu bảo hành điện tử</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/tra-cuu-don-hang/' ) ); ?>" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
              <span class="material-symbols-outlined text-[18px] text-blue-600">local_shipping</span>
              <span>Tra cứu tiến độ đơn hàng</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/showroom/' ) ); ?>" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
              <span class="material-symbols-outlined text-[18px] text-red-600">store</span>
              <span>Hệ thống 128 Showroom</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/tra-gop/' ) ); ?>" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
              <span class="material-symbols-outlined text-[18px] text-amber-600">credit_card</span>
              <span>Trả góp 0% duyệt siêu tốc</span>
            </a>
            <div class="border-t border-gray-100 my-1"></div>
            <a href="tel:18006868" class="flex items-center gap-2 px-3 py-2 rounded-xl text-[13px] font-bold text-red-600 hover:bg-red-50 transition-colors">
              <span class="material-symbols-outlined text-[18px]">call</span>
              <span>Hotline miễn phí: 1800.6868</span>
            </a>
          </div>
        </div>

      </nav>

      <!-- ===================================================
           THẾ GIỚI DI ĐỘNG STYLE ACCESSORIES MEGA MENU
           (Hiển thị khi click vào mục Phụ Kiện)
           =================================================== -->
      <?php
      $pk_di_dong = array(
          array('name' => 'Sạc dự phòng', 'slug' => 'sac-du-phong', 'icon' => 'battery_charging_full'),
          array('name' => 'Sạc, cáp', 'slug' => 'sac-cap', 'icon' => 'bolt'),
          array('name' => 'Ốp lưng điện thoại', 'slug' => 'op-lung-dien-thoai', 'icon' => 'phone_iphone'),
          array('name' => 'Ốp lưng máy tính bảng', 'slug' => 'op-lung-may-tinh-bang', 'icon' => 'tablet_mac'),
          array('name' => 'Miếng dán', 'slug' => 'mieng-dan', 'icon' => 'screen_lock_portrait'),
          array('name' => 'Miếng dán Camera', 'slug' => 'mieng-dan-camera', 'icon' => 'camera_alt'),
          array('name' => 'Túi đựng AirPods', 'slug' => 'tui-dung-airpods', 'icon' => 'headset'),
          array('name' => 'Quạt mini', 'slug' => 'quat-mini', 'icon' => 'toys', 'badge' => 'Hot'),
          array('name' => 'Bút tablet', 'slug' => 'but-tablet', 'icon' => 'draw'),
          array('name' => 'Giá đỡ điện thoại/laptop', 'slug' => 'gia-do-dien-thoai-laptop', 'icon' => 'laptop_mac'),
          array('name' => 'Dây đeo điện thoại', 'slug' => 'day-deo-dien-thoai', 'icon' => 'cable'),
          array('name' => 'Ống kính điện thoại', 'slug' => 'ong-kinh-dien-thoai', 'icon' => 'center_focus_strong', 'badge' => 'Mới'),
      );

      $pk_laptop = array(
          array('name' => 'Hub, cáp chuyển đổi', 'slug' => 'hub-cap-chuyen-doi', 'icon' => 'hub'),
          array('name' => 'Chuột máy tính', 'slug' => 'chuot-may-tinh', 'icon' => 'mouse'),
          array('name' => 'Bàn phím', 'slug' => 'ban-phim', 'icon' => 'keyboard'),
          array('name' => 'Router - Thiết bị mạng', 'slug' => 'router-thiet-bi-mang', 'icon' => 'router'),
          array('name' => 'Balo, túi chống sốc', 'slug' => 'balo-tui-chong-soc', 'icon' => 'backpack'),
          array('name' => 'Túi đựng phụ kiện', 'slug' => 'tui-dung-phu-kien', 'icon' => 'business_center'),
          array('name' => 'Phủ phím laptop', 'slug' => 'phu-phim-laptop', 'icon' => 'keyboard_alt'),
          array('name' => 'Phần mềm', 'slug' => 'phan-mem', 'icon' => 'terminal'),
          array('name' => 'Giá treo màn hình', 'slug' => 'gia-treo-man-hinh', 'icon' => 'fit_screen'),
          array('name' => 'Miếng lót chuột', 'slug' => 'mieng-lot-chuot', 'icon' => 'crop_landscape'),
          array('name' => 'Bảng vẽ điện tử', 'slug' => 'bang-ve-dien-tu', 'icon' => 'gesture'),
      );

      $pk_audio = array(
          array('name' => 'Tai nghe Bluetooth', 'slug' => 'tai-nghe-bluetooth', 'icon' => 'headphones'),
          array('name' => 'Tai nghe dây', 'slug' => 'tai-nghe-day', 'icon' => 'headset_mic'),
          array('name' => 'Tai nghe chụp tai', 'slug' => 'tai-nghe-chup-tai', 'icon' => 'headphones'),
          array('name' => 'Tai nghe thể thao', 'slug' => 'tai-nghe-the-thao', 'icon' => 'directions_run'),
          array('name' => 'Loa', 'slug' => 'loa', 'icon' => 'speaker', 'badge' => 'Hot'),
          array('name' => 'Micro', 'slug' => 'micro', 'icon' => 'mic'),
          array('name' => 'Máy chiếu', 'slug' => 'may-chieu', 'icon' => 'videocam'),
          array('name' => 'Kính thông minh', 'slug' => 'kinh-thong-minh', 'icon' => 'visibility'),
          array('name' => 'Ổ cứng', 'slug' => 'o-cung', 'icon' => 'dns'),
          array('name' => 'Thẻ nhớ', 'slug' => 'the-nho', 'icon' => 'sd_card'),
          array('name' => 'USB', 'slug' => 'usb', 'icon' => 'usb'),
      );

      $pk_camera = array(
          array('name' => 'Camera Giám Sát', 'slug' => 'camera-giam-sat', 'icon' => 'videocam', 'badge' => 'Hot'),
          array('name' => 'Camera trong nhà', 'slug' => 'camera-trong-nha', 'icon' => 'camera_indoor'),
          array('name' => 'Camera ngoài trời', 'slug' => 'camera-ngoai-troi', 'icon' => 'camera_outdoor'),
          array('name' => 'Camera Năng Lượng Mặt Trời', 'slug' => 'camera-nang-luong-mat-troi', 'icon' => 'solar_power'),
          array('name' => 'Camera 4G', 'slug' => 'camera-4g', 'icon' => 'cell_tower'),
          array('name' => 'Chuông cửa Camera', 'slug' => 'chuong-cua-camera', 'icon' => 'doorbell'),
          array('name' => 'Webcam', 'slug' => 'webcam', 'icon' => 'webcam'),
      );

      if ( ! function_exists('phonex_render_tgdd_item') ) {
          function phonex_render_tgdd_item($item) {
              $term = get_term_by('slug', $item['slug'], 'product_cat');
              $url  = ($term && !is_wp_error(get_term_link($term))) ? get_term_link($term) : home_url('/shop/?category=' . $item['slug']);
              $badge = $item['badge'] ?? '';
              $badge_bg = ($badge === 'Hot') ? 'bg-red-500 text-white' : 'bg-rose-500 text-white';
              ?>
              <a href="<?php echo esc_url($url); ?>" class="group flex flex-col items-center text-center p-1 rounded-xl hover:bg-red-50/40 transition-all relative">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-gray-50 border border-gray-100 group-hover:border-red-300 group-hover:bg-red-50/70 flex items-center justify-center text-gray-700 group-hover:text-red-600 transition-all relative shrink-0 shadow-2xs">
                  <span class="material-symbols-outlined text-[24px] sm:text-[26px]"><?php echo esc_html($item['icon']); ?></span>
                  <?php if ($badge) : ?>
                    <span class="absolute -top-1.5 -right-1.5 text-[9px] font-extrabold <?php echo esc_attr($badge_bg); ?> px-1.5 py-0.2 rounded-full leading-none shadow-xs">
                      <?php echo esc_html($badge); ?>
                    </span>
                  <?php endif; ?>
                </div>
                <span class="mt-1.5 text-[11px] font-medium text-gray-700 group-hover:text-red-600 leading-tight max-w-[76px] line-clamp-2 transition-colors">
                  <?php echo esc_html($item['name']); ?>
                </span>
              </a>
              <?php
          }
      }
      ?>

      <div id="pxAccessoriesMegaMenu" class="hidden absolute top-full left-0 right-0 z-50 mt-1 bg-white rounded-2xl shadow-2xl border border-gray-100 p-5 md:p-6 text-gray-800 transition-all duration-200" style="display: none;">
        <!-- Mega Menu Header -->
        <div class="flex items-center justify-between pb-3 mb-5 border-b border-gray-100">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600 text-[22px]">headphones</span>
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg">Danh Mục Phụ Kiện Chính Hãng</h3>
            <span class="text-xs bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full">TGDD Standard</span>
          </div>
          <button type="button" aria-label="<?php esc_attr_e('Đóng menu phụ kiện', 'phonex'); ?>" onclick="PhoneXAccessoriesMegaMenu.close()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition-colors">
            <span class="material-symbols-outlined text-[18px]">close</span>
          </button>
        </div>

        <!-- 2-Column Responsive Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
          
          <!-- LEFT COLUMN -->
          <div class="space-y-6">
            <!-- 1. Phụ kiện di động -->
            <div>
              <h4 class="font-extrabold text-gray-900 text-sm md:text-[15px] mb-3 flex items-center gap-1.5">
                <span class="w-1.5 h-3.5 bg-red-600 rounded-full"></span>
                <span>Phụ kiện di động</span>
              </h4>
              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">
                <?php foreach ($pk_di_dong as $it) phonex_render_tgdd_item($it); ?>
              </div>
            </div>

            <!-- 2. Thiết bị nghe nhìn, lưu trữ, thu âm -->
            <div class="pt-4 border-t border-gray-100">
              <h4 class="font-extrabold text-gray-900 text-sm md:text-[15px] mb-3 flex items-center gap-1.5">
                <span class="w-1.5 h-3.5 bg-red-600 rounded-full"></span>
                <span>Thiết bị nghe nhìn, lưu trữ, thu âm</span>
              </h4>
              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">
                <?php foreach ($pk_audio as $it) phonex_render_tgdd_item($it); ?>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN -->
          <div class="space-y-6 lg:pl-8 pt-6 lg:pt-0">
            <!-- 3. Phụ kiện laptop, PC -->
            <div>
              <h4 class="font-extrabold text-gray-900 text-sm md:text-[15px] mb-3 flex items-center gap-1.5">
                <span class="w-1.5 h-3.5 bg-red-600 rounded-full"></span>
                <span>Phụ kiện laptop, PC</span>
              </h4>
              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">
                <?php foreach ($pk_laptop as $it) phonex_render_tgdd_item($it); ?>
              </div>
            </div>

            <!-- 4. Camera -->
            <div class="pt-4 border-t border-gray-100">
              <h4 class="font-extrabold text-gray-900 text-sm md:text-[15px] mb-3 flex items-center gap-1.5">
                <span class="w-1.5 h-3.5 bg-red-600 rounded-full"></span>
                <span>Camera</span>
              </h4>
              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">
                <?php foreach ($pk_camera as $it) phonex_render_tgdd_item($it); ?>
              </div>
            </div>
          </div>

        </div>

        <!-- Footer Notice -->
        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between text-xs gap-2">
          <div class="text-gray-500 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-green-600 text-[18px]">verified</span>
            <span>Cam kết 100% phụ kiện chính hãng &bull; Bảo hành 12-24 tháng 1 đổi 1 &bull; Giao siêu tốc 2 giờ</span>
          </div>
          <a href="<?php echo esc_url( home_url( '/product-category/phu-kien/' ) ); ?>" class="font-bold text-red-600 hover:underline flex items-center gap-1">
            <span>Xem tất cả danh mục phụ kiện</span>
            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>

    </div>
  </div>

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
          <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]">location_on</span>
          </div>
          <div>
            <h3 class="text-base sm:text-lg font-extrabold text-gray-900 leading-tight">Chọn Khu Vực Của Bạn</h3>
            <p class="text-xs text-gray-500 mt-0.5">Hiển thị giá ưu đãi và tồn kho tại showroom gần bạn nhất</p>
          </div>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Đóng', 'phonex'); ?>" onclick="PhoneXLocation.closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-500 transition-colors">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <!-- Quick Search City Input -->
      <div class="p-3 border-b border-gray-100 shrink-0">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-gray-400 text-[20px]">search</span>
          <input 
            type="text" 
            id="pxCitySearchInput" 
            oninput="PhoneXLocation.filterCities(this.value)" 
            class="w-full h-10 pl-10 pr-4 bg-gray-100 rounded-xl text-sm text-gray-900 placeholder-gray-400 border border-transparent focus:border-red-600 focus:bg-white focus:outline-none transition-all" 
            placeholder="Nhập tên tỉnh, thành phố..."
          >
        </div>
      </div>

      <!-- Province / City List -->
      <div id="pxCityListContainer" class="p-4 overflow-y-auto max-h-[50vh] grid grid-cols-2 sm:grid-cols-3 gap-2">
        <button type="button" onclick="PhoneXLocation.selectCity('Hồ Chí Minh')" class="px-city-btn p-3 rounded-xl border border-red-200 bg-red-50 text-red-700 font-bold text-sm text-left hover:border-red-600 hover:bg-red-100 transition-all flex items-center justify-between">
          <span>Hồ Chí Minh</span>
          <span class="text-[10px] bg-red-600 text-white font-extrabold px-1.5 py-0.2 rounded-full">128 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Hà Nội')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Hà Nội</span>
          <span class="text-[10px] text-gray-400 font-normal">85 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Đà Nẵng')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Đà Nẵng</span>
          <span class="text-[10px] text-gray-400 font-normal">24 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Cần Thơ')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Cần Thơ</span>
          <span class="text-[10px] text-gray-400 font-normal">18 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Hải Phòng')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Hải Phòng</span>
          <span class="text-[10px] text-gray-400 font-normal">16 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Bình Dương')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Bình Dương</span>
          <span class="text-[10px] text-gray-400 font-normal">22 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Đồng Nai')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Đồng Nai</span>
          <span class="text-[10px] text-gray-400 font-normal">19 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Vũng Tàu')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Vũng Tàu</span>
          <span class="text-[10px] text-gray-400 font-normal">12 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Nha Trang')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Nha Trang</span>
          <span class="text-[10px] text-gray-400 font-normal">10 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Huế')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Huế</span>
          <span class="text-[10px] text-gray-400 font-normal">8 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Quảng Ninh')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Quảng Ninh</span>
          <span class="text-[10px] text-gray-400 font-normal">9 shop</span>
        </button>
        <button type="button" onclick="PhoneXLocation.selectCity('Thanh Hóa')" class="px-city-btn p-3 rounded-xl border border-gray-200 hover:border-red-600 hover:bg-red-50 text-gray-800 hover:text-red-700 font-bold text-sm text-left transition-all flex items-center justify-between">
          <span>Thanh Hóa</span>
          <span class="text-[10px] text-gray-400 font-normal">7 shop</span>
        </button>
      </div>

      <!-- Modal Footer -->
      <div class="p-3 sm:p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between text-xs shrink-0">
        <a href="<?php echo esc_url(home_url('/showroom/')); ?>" class="font-bold text-red-600 hover:underline flex items-center gap-1">
          <span>Xem 128 Showroom toàn quốc</span>
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
        <span class="text-gray-400">Giao nhanh 2h</span>
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
          <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-[18px]">smartphone</span>
          </div>
          <span class="text-2xl font-black text-gray-900 tracking-tight">Phone<span class="text-red-600">X</span></span>
          <span class="text-xs bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full uppercase">Menu</span>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Đóng popup', 'phonex'); ?>" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 active:scale-95 transition-all" onclick="PhoneXPopups.closeMenu()">
          <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
      </div>

      <div class="overflow-y-auto p-4 space-y-4">
        <!-- User Banner Card -->
        <div class="p-4 rounded-2xl bg-gradient-to-r from-red-600 to-red-700 text-white flex items-center justify-between shadow-md">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-sm ring-2 ring-white/40">
              <?php echo is_user_logged_in() ? esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 2))) : 'MQ'; ?>
            </div>
            <div>
              <div class="font-extrabold text-base leading-tight"><?php echo is_user_logged_in() ? esc_html(wp_get_current_user()->display_name) : 'Minh Quân'; ?></div>
              <div class="text-xs text-red-100 mt-0.5">Thành viên VIP (14.850 PX)</div>
            </div>
          </div>
          <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/tai-khoan/')); ?>" class="px-3 py-1.5 bg-white text-red-600 rounded-xl text-xs font-bold shadow-xs hover:bg-gray-50 transition-colors">
            Hồ sơ &rarr;
          </a>
        </div>

        <!-- Location Quick Change -->
        <div class="p-3 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600 text-[18px]">location_on</span>
            <span class="text-xs text-gray-600">Khu vực: <strong id="pxMobileLocationLabel" class="text-gray-900 font-bold">Hồ Chí Minh</strong></span>
          </div>
          <button type="button" onclick="PhoneXPopups.closeMenu(); PhoneXLocation.openModal();" class="text-xs text-red-600 font-bold hover:underline">
            Đổi khu vực &rarr;
          </button>
        </div>

        <!-- Quick Action Grid -->
        <div>
          <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Tiện ích nhanh</div>
          <div class="grid grid-cols-2 gap-2">
            <a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-blue-600 text-[22px]">local_shipping</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">Tra cứu đơn</div><div class="text-[11px] text-gray-500">Tiến độ giao hàng</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-green-600 text-[22px]">verified_user</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">Bảo hành</div><div class="text-[11px] text-gray-500">Tra cứu IMEI/SĐT</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="p-3 rounded-xl bg-red-50 hover:bg-red-100 border border-red-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-red-600 text-[22px]">sync_alt</span>
              <div class="text-left"><div class="text-xs font-bold text-red-700">Thu cũ đổi mới</div><div class="text-[11px] text-red-500">Trợ giá 3Tr</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/showroom/')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-2.5 transition-colors">
              <span class="material-symbols-outlined text-purple-600 text-[22px]">store</span>
              <div class="text-left"><div class="text-xs font-bold text-gray-900">128 Cửa hàng</div><div class="text-[11px] text-gray-500">Gần bạn nhất</div></div>
            </a>
          </div>
        </div>

        <!-- Requested Main Menu Links for Mobile -->
        <div>
          <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Danh mục chính</div>
          <div class="grid grid-cols-2 gap-2 text-xs font-bold text-gray-800">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 text-[18px]">home</span>
              <span>Trang chủ</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/shop/?category=smartphone' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 text-[18px]">smartphone</span>
              <span>Điện thoại</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/product-category/used/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 text-[18px]">sync_alt</span>
              <span>Máy cũ giá tốt</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/khuyen-mai/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 text-[18px]">local_fire_department</span>
              <span>Khuyến mãi Hot</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/thu-cu-doi-moi/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-red-600 text-[18px]">currency_exchange</span>
              <span>Thu cũ đổi mới</span>
            </a>
            <a href="<?php echo esc_url( home_url( '/tra-gop/' ) ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-amber-600 text-[18px]">credit_card</span>
              <span>Trả góp 0%</span>
            </a>
          </div>

          <!-- Phụ kiện TGDD 4 Groups Quick Access -->
          <div class="mt-4 pt-3 border-t border-gray-100">
            <div class="flex items-center justify-between mb-2">
              <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                <span class="material-symbols-outlined text-red-600 text-[16px]">headphones</span>
                <span>Phụ Kiện Chính Hãng (TGDD)</span>
              </div>
              <a href="<?php echo esc_url( home_url( '/product-category/phu-kien/' ) ); ?>" class="text-[11px] text-red-600 font-bold hover:underline">Tất cả &rarr;</a>
            </div>
            
            <div class="space-y-2 text-xs">
              <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                <div class="font-bold text-gray-900 mb-1.5 flex items-center gap-1 text-[11px]">
                  <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Phụ kiện di động
                </div>
                <div class="flex flex-wrap gap-1">
                  <a href="<?php echo esc_url(home_url('/shop/?category=sac-du-phong')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Sạc dự phòng</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=sac-cap')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Sạc cáp</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=op-lung-dien-thoai')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Ốp lưng</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=mieng-dan')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Kính cường lực</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=tui-dung-airpods')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Túi AirPods</a>
                  <a href="<?php echo esc_url(home_url('/shop/?category=gia-do-dien-thoai-laptop')); ?>" class="px-2 py-0.5 bg-white rounded border border-gray-200 text-[10px] font-medium text-gray-700">Giá đỡ</a>
                </div>
              </div>

              <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                <div class="font-bold text-gray-900 mb-1.5 flex items-center gap-1 text-[11px]">
                  <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Nghe nhìn &amp; Lưu trữ
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
                  <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Laptop, PC &amp; Camera
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
            <span class="material-symbols-outlined text-[18px] text-red-500">call</span>
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
          <span class="material-symbols-outlined text-red-600 text-[15px]">local_fire_department</span>
          Tìm kiếm xu hướng
        </div>
        <div class="flex flex-wrap gap-1.5 text-xs">
          <a href="<?php echo esc_url(home_url('/?s=iPhone+16+Pro+Max&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">iPhone 16 Pro Max</a>
          <a href="<?php echo esc_url(home_url('/?s=Galaxy+S25+Ultra&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Galaxy S25 Ultra</a>
          <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="px-2.5 py-1 bg-red-50 border border-red-200 rounded-full text-red-600 font-bold hover:bg-red-100 transition-colors">Thu cũ trợ giá 3Tr</a>
          <a href="<?php echo esc_url(home_url('/?s=Xiaomi+15&post_type=product')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Xiaomi 15 Pro</a>
          <a href="<?php echo esc_url(home_url('/shop/?condition=used')); ?>" class="px-2.5 py-1 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Máy cũ 99%</a>
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
      toggle: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden') || menu.style.display === 'none';
        if (isHidden) {
          menu.classList.remove('hidden');
          menu.style.display = 'block';
          if (arrow) arrow.style.transform = 'rotate(180deg)';
          if (btn) btn.classList.add('bg-red-50', 'text-red-600');
        } else {
          this.close();
        }
      },
      close: function() {
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (menu) {
          menu.classList.add('hidden');
          menu.style.display = 'none';
        }
        if (arrow) arrow.style.transform = 'rotate(0deg)';
        if (btn) btn.classList.remove('bg-red-50', 'text-red-600');
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
