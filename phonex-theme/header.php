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

  <!-- 3. CATEGORY NAVIGATION BAR (Row 2: Dynamic from Database with TGDD-style Accessories Dropdown) -->
  <div class="w-full bg-white border-b border-gray-200/80 shadow-2xs relative z-20">
    <div class="max-w-7xl mx-auto px-4">
      <nav class="flex items-center gap-1 md:gap-1.5 py-1.5 overflow-x-auto whitespace-nowrap text-[13px] md:text-sm font-bold text-gray-800 scrollbar-none" aria-label="<?php esc_attr_e('Danh mục ngành hàng', 'phonex'); ?>">
        
        <?php
        // Fetch top-level categories from database
        $parent_cats = get_terms( array(
            'taxonomy'   => 'product_cat',
            'parent'     => 0,
            'hide_empty' => false,
            'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
        ) );

        $cat_order = array( 'apple', 'samsung', 'xiaomi', 'oppo', 'vivo', 'realme', 'google-pixel', 'nothing', 'used', 'phu-kien' );

        if ( ! is_wp_error( $parent_cats ) && ! empty( $parent_cats ) ) {
            usort( $parent_cats, function( $a, $b ) use ( $cat_order ) {
                $pos_a = array_search( $a->slug, $cat_order );
                $pos_b = array_search( $b->slug, $cat_order );
                if ( $pos_a === false ) $pos_a = 999;
                if ( $pos_b === false ) $pos_b = 999;
                return $pos_a <=> $pos_b;
            } );
        }

        $cat_icons = array(
            'apple'                => 'phone_iphone',
            'samsung'              => 'smartphone',
            'xiaomi'               => 'smartphone',
            'oppo'                 => 'smartphone',
            'vivo'                 => 'smartphone',
            'realme'               => 'smartphone',
            'google-pixel'         => 'smartphone',
            'nothing'              => 'smartphone',
            'used'                 => 'sync_alt',
            'phu-kien'             => 'headphones',
            'sac-cap'              => 'bolt',
            'pin-du-phong'         => 'battery_charging_full',
            'tai-nghe-loa'         => 'headphones',
            'op-lung-bao-da'       => 'phone_android',
            'kinh-cuong-luc'       => 'screen_lock_portrait',
            'phu-kien-apple'       => 'verified',
            'gia-do-gay-chup-anh'  => 'photo_camera',
        );

        if ( ! is_wp_error( $parent_cats ) && ! empty( $parent_cats ) ) :
            foreach ( $parent_cats as $pcat ) :
                $pcat_link = ! is_wp_error( get_term_link( $pcat ) ) ? get_term_link( $pcat ) : home_url( '/shop/?category=' . $pcat->slug );
                $pcat_icon = $cat_icons[ $pcat->slug ] ?? 'smartphone';

                // Check child terms
                $sub_cats = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'parent'     => $pcat->term_id,
                    'hide_empty' => false,
                ) );

                if ( ! is_wp_error( $sub_cats ) && ! empty( $sub_cats ) ) {
                    $sub_order = array( 'sac-cap', 'pin-du-phong', 'tai-nghe-loa', 'op-lung-bao-da', 'kinh-cuong-luc', 'phu-kien-apple', 'gia-do-gay-chup-anh' );
                    usort( $sub_cats, function( $a, $b ) use ( $sub_order ) {
                        $pos_a = array_search( $a->slug, $sub_order );
                        $pos_b = array_search( $b->slug, $sub_order );
                        if ( $pos_a === false ) $pos_a = 999;
                        if ( $pos_b === false ) $pos_b = 999;
                        return $pos_a <=> $pos_b;
                    } );
                }

                if ( ! is_wp_error( $sub_cats ) && ! empty( $sub_cats ) ) :
                    // Category WITH subcategories (e.g. Phụ kiện from TGDD)
                    ?>
                    <div class="relative group">
                      <a href="<?php echo esc_url( $pcat_link ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px] text-gray-600 group-hover:text-red-600"><?php echo esc_html( $pcat_icon ); ?></span>
                        <span><?php echo esc_html( $pcat->name ); ?></span>
                        <span class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-red-600 transition-transform group-hover:rotate-180">keyboard_arrow_down</span>
                      </a>
                      <!-- Dropdown Menu -->
                      <div class="hidden group-hover:block absolute top-full left-0 z-50 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-gray-800">
                        <div class="font-bold text-gray-400 text-[11px] uppercase px-3 py-1.5 flex items-center justify-between">
                          <span><?php echo esc_html( $pcat->name ); ?></span>
                          <span class="text-[10px] font-bold bg-red-100 text-red-600 px-1.5 py-0.5 rounded">TGDD Info</span>
                        </div>
                        <?php foreach ( $sub_cats as $scat ) : 
                            $scat_link = ! is_wp_error( get_term_link( $scat ) ) ? get_term_link( $scat ) : home_url( '/shop/?category=' . $scat->slug );
                            $scat_icon = $cat_icons[ $scat->slug ] ?? 'check_circle';
                        ?>
                          <a href="<?php echo esc_url( $scat_link ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 transition-colors">
                            <div class="flex items-center gap-2">
                              <span class="material-symbols-outlined text-[18px] text-gray-500"><?php echo esc_html( $scat_icon ); ?></span>
                              <span><?php echo esc_html( $scat->name ); ?></span>
                            </div>
                            <?php if ( $scat->slug === 'phu-kien-apple' ) : ?>
                              <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">Chính hãng</span>
                            <?php elseif ( $scat->slug === 'sac-cap' || $scat->slug === 'pin-du-phong' ) : ?>
                              <span class="text-[10px] bg-amber-100 text-amber-800 px-1.5 py-0.2 rounded-full font-semibold">Bán chạy</span>
                            <?php endif; ?>
                          </a>
                        <?php endforeach; ?>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="<?php echo esc_url( $pcat_link ); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-[13px] font-bold text-red-600 hover:bg-red-50 transition-colors">
                          <span>Xem tất cả <?php echo esc_html( $pcat->name ); ?></span>
                          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                      </div>
                    </div>
                <?php else : 
                    // Direct category link
                    $is_used = ($pcat->slug === 'used');
                    ?>
                    <a href="<?php echo esc_url( $pcat_link ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
                      <span class="material-symbols-outlined text-[18px] <?php echo $is_used ? 'text-red-600' : 'text-gray-600 group-hover:text-red-600'; ?>"><?php echo esc_html( $pcat_icon ); ?></span>
                      <span><?php echo esc_html( $pcat->name ); ?></span>
                    </a>
                <?php endif;
            endforeach;
        endif;
        ?>

        <!-- PhoneX Custom Action: Thu cũ đổi mới -->
        <a href="<?php echo esc_url( home_url( '/thu-cu-doi-moi/' ) ); ?>" class="px-2.5 py-1.5 rounded-lg text-gray-800 hover:text-red-600 hover:bg-red-50/80 transition-colors flex items-center gap-1.5 shrink-0">
          <span class="material-symbols-outlined text-[18px] text-red-600">sync_alt</span>
          <span>Thu cũ đổi mới</span>
          <span class="text-[10px] bg-red-100 text-red-700 px-1.5 py-0.2 rounded-full font-bold">Trợ giá 3Tr</span>
        </a>

        <!-- Dịch vụ tiện ích ⌃ (Distinctive Pill Button with Dropdown matching TGDD structure) -->
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

        <!-- Category Links (Dynamic from Database) -->
        <div>
          <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Danh mục thương hiệu &amp; Phụ kiện</div>
          <div class="grid grid-cols-2 gap-2 text-xs font-bold text-gray-800">
            <?php
            if ( ! empty( $parent_cats ) && ! is_wp_error( $parent_cats ) ) {
                foreach ( $parent_cats as $mcat ) {
                    $mcat_link = ! is_wp_error( get_term_link( $mcat ) ) ? get_term_link( $mcat ) : home_url( '/shop/?category=' . $mcat->slug );
                    $mcat_icon = $cat_icons[ $mcat->slug ] ?? 'smartphone';
                    ?>
                    <a href="<?php echo esc_url( $mcat_link ); ?>" class="p-2.5 rounded-xl bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-100 transition-colors flex items-center gap-2">
                      <span class="material-symbols-outlined text-red-600 text-[18px]"><?php echo esc_html( $mcat_icon ); ?></span>
                      <span class="truncate"><?php echo esc_html( $mcat->name ); ?></span>
                    </a>
                    <?php
                }
            }
            ?>
          </div>

          <?php 
          // Subcategories of Accessories from TGDD
          $pk_term = get_term_by( 'slug', 'phu-kien', 'product_cat' );
          if ( $pk_term ) {
              $pk_subterms = get_terms( array(
                  'taxonomy'   => 'product_cat',
                  'parent'     => $pk_term->term_id,
                  'hide_empty' => false,
              ) );
              if ( ! empty( $pk_subterms ) && ! is_wp_error( $pk_subterms ) ) {
                  ?>
                  <div class="mt-3">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Phụ kiện Thế Giới Di Động</div>
                    <div class="flex flex-wrap gap-1.5">
                      <?php foreach ( $pk_subterms as $ps ) : 
                          $ps_link = ! is_wp_error( get_term_link( $ps ) ) ? get_term_link( $ps ) : home_url( '/shop/?category=' . $ps->slug );
                      ?>
                        <a href="<?php echo esc_url( $ps_link ); ?>" class="text-[11px] font-semibold bg-gray-100 hover:bg-red-50 hover:text-red-600 px-2.5 py-1.5 rounded-lg text-gray-700 transition-colors">
                          <?php echo esc_html( $ps->name ); ?>
                        </a>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <?php
              }
          }
          ?>
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

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
      PhoneXLocation.init();
      PhoneXTopBanner.init();
    });

    // Escape key listener for closing modals
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') { 
        PhoneXPopups.closeMenu(); 
        PhoneXPopups.closeSearch(); 
        PhoneXLocation.closeModal(); 
      }
    });
  </script>
</header>
