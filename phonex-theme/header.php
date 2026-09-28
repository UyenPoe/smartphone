<?php
/**
 * The header template for PhoneX WordPress Theme
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

<!-- PhoneX Flagship Unified Header (Desktop, Tablet & Mobile with Popup Support) -->
<header class="sticky top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 font-sans" data-component="header">
  <!-- 1. Top Announcement Bar (Desktop & Tablet) -->
  <div class="hidden md:block w-full bg-gray-100 border-b border-gray-200 text-sm text-gray-700 py-2 px-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <span class="font-bold text-red-600">Hotline miễn phí: 1800.6868</span> (8h00 - 21h30)
        <span class="text-gray-300">|</span>
        <span class="font-medium text-gray-600">Hệ thống 128 cửa hàng toàn quốc</span>
      </div>
      <div class="flex items-center gap-5 text-sm">
        <a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="hover:text-red-600 font-medium transition-colors">Tra cứu bảo hành điện tử</a>
        <span class="text-gray-300">|</span>
        <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="hover:text-red-600 transition-colors text-red-600 font-bold">Thu cũ đổi mới trợ giá đến 3.000.000₫</a>
        <span class="text-gray-300">|</span>
        <a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>" class="hover:text-red-600 font-medium transition-colors">Tra cứu đơn hàng</a>
      </div>
    </div>
  </div>

  <!-- 2. Main Navigation Bar -->
  <div class="max-w-7xl mx-auto px-4 h-16 md:h-20 flex items-center justify-between gap-4">
    <!-- Left: Mobile Hamburger + Logo -->
    <div class="flex items-center gap-2 md:gap-4 shrink-0">
      <!-- Hamburger Button -> Triggers Mobile Popup Menu -->
      <button type="button" aria-label="<?php esc_attr_e('Mở danh mục menu', 'phonex'); ?>" class="md:hidden w-11 h-11 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors" onclick="PhoneXPopups.openMenu()">
        <span class="material-symbols-outlined text-[30px]">menu</span>
      </button>

      <!-- PhoneX Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
        <div class="flex flex-col">
          <span class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight leading-none">Phone<span class="text-red-600">X</span></span>
          <span class="text-[11px] md:text-xs text-gray-500 font-bold uppercase tracking-wider leading-none mt-1 hidden sm:inline">Smartphone Specialist</span>
        </div>
      </a>
    </div>

    <!-- Center: Search Bar (Desktop & Tablet) -->
    <div class="hidden sm:flex flex-1 max-w-xl mx-2">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative w-full flex items-center">
        <input name="s" value="<?php echo get_search_query(); ?>" class="w-full h-11 md:h-12 pl-4 pr-12 bg-gray-100 rounded-xl text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-red-600 transition-all border border-transparent focus:border-red-600" placeholder="Tìm kiếm smartphone, iPhone 16 Pro Max, Galaxy S25 Ultra, Xiaomi 15..." type="search">
        <?php if (function_exists('is_woocommerce')) : ?><input type="hidden" name="post_type" value="product" /><?php endif; ?>
        <button type="submit" aria-label="<?php esc_attr_e('Tìm kiếm', 'phonex'); ?>" class="absolute right-1.5 w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
          <span class="material-symbols-outlined text-[22px]">search</span>
        </button>
      </form>
    </div>

    <!-- Right: Action Icons & User Info -->
    <div class="flex items-center gap-1.5 sm:gap-3.5 shrink-0">
      <!-- Search Icon (Mobile only -> Triggers Search Popup) -->
      <button type="button" aria-label="<?php esc_attr_e('Tìm kiếm', 'phonex'); ?>" onclick="PhoneXPopups.openSearch()" class="sm:hidden w-11 h-11 flex items-center justify-center rounded-xl text-gray-800 hover:bg-gray-100 active:bg-gray-200 transition-colors">
        <span class="material-symbols-outlined text-[26px]">search</span>
      </button>

      <!-- So sánh (Tablet & Desktop) -->
      <a href="<?php echo esc_url(home_url('/so-sanh/')); ?>" class="hidden lg:flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-red-600 transition-colors">
        <div class="relative flex items-center justify-center">
          <span class="material-symbols-outlined text-[24px] text-gray-600">compare_arrows</span>
          <span class="absolute -top-1.5 -right-2 bg-red-600 text-white text-xs font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center">2</span>
        </div>
        <span class="text-sm font-semibold">So sánh</span>
      </a>

      <!-- Yêu thích (Tablet & Desktop) -->
      <a href="<?php echo esc_url(home_url('/yeu-thich/')); ?>" class="hidden lg:flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-red-600 transition-colors">
        <div class="relative flex items-center justify-center">
          <span class="material-symbols-outlined text-[24px] text-gray-600">favorite_border</span>
          <span class="absolute -top-1.5 -right-2 bg-red-600 text-white text-xs font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center">3</span>
        </div>
        <span class="text-sm font-semibold">Yêu thích</span>
      </a>

      <!-- Giỏ hàng (All platforms) -->
      <?php
      $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
      $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
      $cart_total = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_total() : '0₫';
      ?>
      <a href="<?php echo esc_url($cart_url); ?>" class="flex items-center gap-2.5 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
        <div class="relative flex items-center justify-center">
          <span class="material-symbols-outlined text-[26px] text-red-600">shopping_cart</span>
          <span class="absolute -top-1.5 -right-2 bg-red-600 text-white text-xs font-bold w-4.5 h-4.5 rounded-full flex items-center justify-center" data-cart-count><?php echo esc_html($cart_count); ?></span>
        </div>
        <div class="hidden sm:flex flex-col text-left">
          <span class="text-xs text-gray-500 uppercase font-bold leading-tight">Giỏ hàng</span>
          <span class="text-sm font-black text-red-600 leading-tight" data-cart-total><?php echo wp_kses_post($cart_total); ?></span>
        </div>
      </a>

      <!-- Tài khoản (Desktop) -->
      <div class="hidden sm:flex items-center pl-2">
        <a href="<?php echo esc_url(home_url('/tai-khoan/')); ?>" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity">
          <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-sm ring-2 ring-gray-200">
            <?php echo is_user_logged_in() ? esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 2))) : 'MQ'; ?>
          </div>
          <div class="hidden xl:flex flex-col text-left">
            <span class="text-sm font-bold text-gray-900 leading-tight"><?php echo is_user_logged_in() ? esc_html(wp_get_current_user()->display_name) : 'Minh Quân'; ?></span>
            <span class="text-xs text-red-600 font-bold leading-none mt-0.5"><?php echo is_user_logged_in() ? 'VIP Member' : 'VIP Member'; ?></span>
          </div>
        </a>
      </div>
    </div>
  </div>

  <!-- 3. Subnav: Brand Category Bar (Scrollable on Tablet & Mobile) -->
  <div class="w-full bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <nav class="flex items-center gap-1.5 sm:gap-2.5 py-2.5 overflow-x-auto whitespace-nowrap text-sm font-semibold scrollbar-none" aria-label="<?php esc_attr_e('Danh mục thương hiệu', 'phonex'); ?>">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="px-3.5 py-1.5 rounded-lg text-red-600 font-bold hover:bg-red-50 transition-colors">Trang chủ</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=apple')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">iPhone</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=samsung')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Samsung</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=xiaomi')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Xiaomi</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=oppo')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">OPPO</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=vivo')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">vivo</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=realme')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">realme</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=google-pixel')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Google Pixel</a>
        <a href="<?php echo esc_url(home_url('/shop/?brand=nothing')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Nothing Phone</a>
        <a href="<?php echo esc_url(home_url('/shop/?deals=1')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Điện thoại giá tốt</a>
        <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>" class="px-3.5 py-1.5 rounded-lg text-red-600 font-bold hover:bg-red-50 transition-colors">Khuyến mãi Hot</a>
        <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Thu cũ đổi mới</a>
        <a href="<?php echo esc_url(home_url('/tra-gop/')); ?>" class="px-3.5 py-1.5 rounded-lg text-gray-700 hover:text-red-600 hover:bg-gray-50 transition-colors">Trả góp 0%</a>
      </nav>
    </div>
  </div>

  <!-- 4. Mobile Bottom Sheet Popup Menu -->
  <div id="pxMenuPopup" class="px-popup px-popup-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Menu điều hướng di động', 'phonex'); ?>">
    <div class="px-popup-backdrop" onclick="PhoneXPopups.closeMenu()"></div>
    <div class="px-popup-dialog">
      <div class="w-14 h-1.5 bg-gray-300 rounded-full mx-auto mt-3 mb-1 md:hidden"></div>
      <div class="p-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="text-2xl font-black text-gray-900 tracking-tight">Phone<span class="text-red-600">X</span></span>
          <span class="text-xs bg-red-100 text-red-700 font-bold px-2.5 py-0.5 rounded-full uppercase">Menu Nhanh</span>
        </div>
        <button type="button" aria-label="<?php esc_attr_e('Đóng popup', 'phonex'); ?>" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 active:scale-95 transition-all" onclick="PhoneXPopups.closeMenu()">
          <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
      </div>

      <div class="overflow-y-auto p-4 space-y-5 max-h-[75vh]">
        <div class="p-4 rounded-2xl bg-gradient-to-r from-red-600 to-red-700 text-white flex items-center justify-between shadow-md">
          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-base ring-2 ring-white/40">
              <?php echo is_user_logged_in() ? esc_html(strtoupper(substr(wp_get_current_user()->display_name, 0, 2))) : 'MQ'; ?>
            </div>
            <div>
              <div class="font-extrabold text-base leading-tight"><?php echo is_user_logged_in() ? esc_html(wp_get_current_user()->display_name) : 'Minh Quân'; ?></div>
              <div class="text-sm text-red-100 mt-0.5">Thành viên VIP (14.850 PX)</div>
            </div>
          </div>
          <a href="<?php echo esc_url(home_url('/tai-khoan/')); ?>" class="px-3.5 py-2 bg-white text-red-600 rounded-xl text-xs font-bold shadow-sm hover:bg-gray-50 transition-colors">
            Hồ sơ &rarr;
          </a>
        </div>

        <div>
          <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2.5">Tiện ích nhanh</div>
          <div class="grid grid-cols-2 gap-2.5">
            <a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>" class="p-3.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-3 transition-colors">
              <span class="material-symbols-outlined text-red-600 text-[26px]">local_shipping</span>
              <div class="text-left"><div class="text-sm font-bold text-gray-900">Tra cứu đơn</div><div class="text-xs text-gray-500">Tiến độ giao hàng</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="p-3.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-3 transition-colors">
              <span class="material-symbols-outlined text-green-600 text-[26px]">verified_user</span>
              <div class="text-left"><div class="text-sm font-bold text-gray-900">Bảo hành</div><div class="text-xs text-gray-500">Tra cứu IMEI/SĐT</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="p-3.5 rounded-xl bg-red-50 hover:bg-red-100 border border-red-100 flex items-center gap-3 transition-colors">
              <span class="material-symbols-outlined text-red-600 text-[26px]">sync_alt</span>
              <div class="text-left"><div class="text-sm font-bold text-red-700">Thu cũ đổi mới</div><div class="text-xs text-red-500">Trợ giá đến 3tr</div></div>
            </a>
            <a href="<?php echo esc_url(home_url('/cua-hang/')); ?>" class="p-3.5 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-100 flex items-center gap-3 transition-colors">
              <span class="material-symbols-outlined text-blue-600 text-[26px]">store</span>
              <div class="text-left"><div class="text-sm font-bold text-gray-900">Cửa hàng</div><div class="text-xs text-gray-500">128 Showroom</div></div>
            </a>
          </div>
        </div>

        <div>
          <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2.5">Thương hiệu Smartphone</div>
          <div class="grid grid-cols-3 gap-2.5 text-center text-sm font-bold text-gray-800">
            <a href="<?php echo esc_url(home_url('/shop/?brand=apple')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">iPhone</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=samsung')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">Samsung</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=xiaomi')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">Xiaomi</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=oppo')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">OPPO</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=vivo')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">vivo</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=realme')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">realme</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=google-pixel')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">Pixel</a>
            <a href="<?php echo esc_url(home_url('/shop/?brand=nothing')); ?>" class="p-3 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors">Nothing</a>
            <a href="<?php echo esc_url(home_url('/tra-gop/')); ?>" class="p-3 rounded-xl bg-red-100 text-red-700 font-extrabold hover:bg-red-200 transition-colors">Trả góp 0%</a>
          </div>
        </div>

        <div class="pt-2">
          <a href="tel:18006868" class="w-full py-3.5 px-4 bg-gray-900 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-black transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px] text-red-500">call</span>
            Gọi tư vấn miễn phí: 1800.6868
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- 5. Mobile Top Search Popup Modal -->
  <div id="pxSearchPopup" class="px-popup px-popup-search" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Tìm kiếm di động', 'phonex'); ?>">
    <div class="px-popup-backdrop" onclick="PhoneXPopups.closeSearch()"></div>
    <div class="px-popup-dialog overflow-hidden">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="p-3.5 border-b border-gray-100 flex items-center gap-2.5">
        <span class="material-symbols-outlined text-gray-400 pl-1 text-[24px]">search</span>
        <input id="pxMobileSearchInput" name="s" value="<?php echo get_search_query(); ?>" class="w-full h-11 text-base text-gray-900 placeholder-gray-400 focus:outline-none bg-transparent" placeholder="Tìm iPhone, Samsung, Xiaomi..." type="search">
        <?php if (function_exists('is_woocommerce')) : ?><input type="hidden" name="post_type" value="product" /><?php endif; ?>
        <button type="button" aria-label="<?php esc_attr_e('Đóng tìm kiếm', 'phonex'); ?>" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500" onclick="PhoneXPopups.closeSearch()">
          <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
      </form>
      <div class="p-4 bg-gray-50">
        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
          <span class="material-symbols-outlined text-red-600 text-[16px]">local_fire_department</span>
          Tìm kiếm phổ biến
        </div>
        <div class="flex flex-wrap gap-2 text-sm">
          <a href="<?php echo esc_url(home_url('/?s=iPhone+16+Pro+Max&post_type=product')); ?>" class="px-3.5 py-1.5 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">iPhone 16 Pro Max</a>
          <a href="<?php echo esc_url(home_url('/?s=Galaxy+S25+Ultra&post_type=product')); ?>" class="px-3.5 py-1.5 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Galaxy S25 Ultra</a>
          <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="px-3.5 py-1.5 bg-red-50 border border-red-200 rounded-full text-red-600 font-bold hover:bg-red-100 transition-colors">Thu cũ trợ giá 3tr</a>
          <a href="<?php echo esc_url(home_url('/?s=Xiaomi+15&post_type=product')); ?>" class="px-3.5 py-1.5 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Xiaomi 15 Pro</a>
          <a href="<?php echo esc_url(home_url('/shop/?condition=used')); ?>" class="px-3.5 py-1.5 bg-white border border-gray-200 rounded-full text-gray-800 hover:border-red-600 hover:text-red-600 transition-colors font-medium">Máy cũ 99%</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.PhoneXPopups = {
      openMenu: function() {
        const p = document.getElementById('pxMenuPopup');
        if (p) { p.classList.add('active'); document.body.style.overflow = 'hidden'; }
      },
      closeMenu: function() {
        const p = document.getElementById('pxMenuPopup');
        if (p) { p.classList.remove('active'); document.body.style.overflow = ''; }
      },
      openSearch: function() {
        const p = document.getElementById('pxSearchPopup');
        if (p) {
          p.classList.add('active');
          document.body.style.overflow = 'hidden';
          setTimeout(() => { const input = document.getElementById('pxMobileSearchInput'); if (input) input.focus(); }, 150);
        }
      },
      closeSearch: function() {
        const p = document.getElementById('pxSearchPopup');
        if (p) { p.classList.remove('active'); document.body.style.overflow = ''; }
      }
    };
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') { PhoneXPopups.closeMenu(); PhoneXPopups.closeSearch(); }
    });
  </script>
</header>
