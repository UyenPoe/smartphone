<?php
/**
 * Template Name: PhoneX Điện Thoại Cũ Giá Tốt (TGDD & Stitch Style)
 *
 * Dedicated Used Phones Category Page modeled after thegioididong.com & Google Stitch
 * Uses PhoneX Stitch Design Tokens (#b7000c primary, #e60012 CTA, #ffdad5 light, clean modern styling)
 * Integrates directly with WooCommerce products & Pre-Owned phone inspection data.
 *
 * @package PhoneX
 */

get_header();

// 1. FETCH USED PHONE PRODUCTS FROM WOOCOMMERCE
$used_categories = array( 'used', 'may-cu-99', 'dien-thoai-cu', 'may-cu', 'apple', 'samsung', 'dien-thoai' );

$args = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
	'tax_query'      => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( 'used', 'may-cu-99', 'dien-thoai-cu' ),
			'operator' => 'IN',
		),
	),
);

$query = new WP_Query( $args );

// If less than 4 products in 'used' taxonomy, query all products to detect used/phones
if ( $query->found_posts < 4 ) {
	$args['tax_query'] = array();
	$query             = new WP_Query( $args );
}

$phones_list = array();
$all_brands  = array();

// Realistic pre-owned devices dataset for PhoneX flagship catalog
$curated_used_phones = array(
	array(
		'id'          => 101,
		'name'        => '[Cũ 99%] iPhone 16 Pro Max 256GB Titan Sa Mạc (#USED-IP16PM-882)',
		'brand'       => 'Apple',
		'capacity'    => '256GB',
		'price'       => 27490000,
		'price_old'   => 34990000,
		'specs'       => 'Grade A 99% • Pin 98% (Sạc 42 lần) • Fullbox VN/A',
		'condition'   => 'grade-a',
		'battery'     => '98%',
		'applecare'   => true,
		'demand'      => 'gaming,camera,battery,grade-a,fullbox,applecare',
		'reviews'     => 142,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/' ),
		'serial'      => '#USED-IP16PM-882',
	),
	array(
		'id'          => 102,
		'name'        => '[Cũ 99%] Samsung Galaxy S24 Ultra 512GB Titan Xám (#USED-S24U-512)',
		'brand'       => 'Samsung',
		'capacity'    => '512GB',
		'price'       => 21990000,
		'price_old'   => 33990000,
		'specs'       => 'Grade A 99% • Pin 99% • Fullbox SSVN • Galaxy AI',
		'condition'   => 'grade-a',
		'battery'     => '99%',
		'applecare'   => false,
		'demand'      => 'gaming,camera,battery,grade-a,fullbox',
		'reviews'     => 89,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/367339/samsung-galaxy-s26-ultra-den-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/samsung-galaxy-s25-ultra-512gb-chinh-hang-ssvn/' ),
		'serial'      => '#USED-S24U-512',
	),
	array(
		'id'          => 103,
		'name'        => '[Cũ 99%] iPhone 15 Pro Max 256GB Titan Tự Nhiên (#USED-IP15PM-119)',
		'brand'       => 'Apple',
		'capacity'    => '256GB',
		'price'       => 22490000,
		'price_old'   => 29990000,
		'specs'       => 'Grade A 99% • Pin 96% Zin • Zin All 100%',
		'condition'   => 'grade-a',
		'battery'     => '96%',
		'applecare'   => false,
		'demand'      => 'gaming,camera,battery,grade-a',
		'reviews'     => 215,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-15-pro-max-256gb-titan-tu-nhien-may-cu-99/' ),
		'serial'      => '#USED-IP15PM-119',
	),
	array(
		'id'          => 104,
		'name'        => '[Cũ 98%] iPhone 14 Pro Max 128GB Tím Deep Purple (#USED-IP14PM-304)',
		'brand'       => 'Apple',
		'capacity'    => '128GB',
		'price'       => 16490000,
		'price_old'   => 26990000,
		'specs'       => 'Grade B 98% • Pin 91% • Dynamic Island mượt mà',
		'condition'   => 'grade-b',
		'battery'     => '91%',
		'applecare'   => false,
		'demand'      => 'camera,budget',
		'reviews'     => 342,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/251192/iphone-14-pro-max-purple-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/' ),
		'serial'      => '#USED-IP14PM-304',
	),
	array(
		'id'          => 105,
		'name'        => '[Cũ 99%] Xiaomi 14 Ultra 512GB Trắng Gốm Leica (#USED-MI14U-072)',
		'brand'       => 'Xiaomi',
		'capacity'    => '512GB',
		'price'       => 17890000,
		'price_old'   => 29990000,
		'specs'       => 'Grade A 99% • 1 Inch Sensor Leica • Sạc 90W Fullbox',
		'condition'   => 'grade-a',
		'battery'     => '98%',
		'applecare'   => false,
		'demand'      => 'camera,gaming,battery,grade-a,fullbox',
		'reviews'     => 64,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/369628/xiaomi-redmi-note-17-pro-max-5g-purple-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/xiaomi-15-pro-256gb-leica-optics-edition/' ),
		'serial'      => '#USED-MI14U-072',
	),
	array(
		'id'          => 106,
		'name'        => '[Cũ 99%] Samsung Galaxy Z Fold5 512GB Icy Blue (#USED-ZF5-992)',
		'brand'       => 'Samsung',
		'capacity'    => '512GB',
		'price'       => 20990000,
		'price_old'   => 40990000,
		'specs'       => 'Grade A 99% • Màn hình gập zin keng • Fullbox SSVN',
		'condition'   => 'grade-a',
		'battery'     => '97%',
		'applecare'   => false,
		'demand'      => 'foldable,grade-a,fullbox',
		'reviews'     => 78,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/368236/motorola-razr-fold-trang-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/samsung-galaxy-s25-ultra-512gb-chinh-hang-ssvn/' ),
		'serial'      => '#USED-ZF5-992',
	),
	array(
		'id'          => 107,
		'name'        => '[Cũ 99%] iPhone 13 Pro Max 128GB Sierra Blue (#USED-IP13PM-553)',
		'brand'       => 'Apple',
		'capacity'    => '128GB',
		'price'       => 13490000,
		'price_old'   => 23990000,
		'specs'       => 'Grade A 99% • Pin 94% Zin • 120Hz mượt mà',
		'condition'   => 'grade-a',
		'battery'     => '94%',
		'applecare'   => false,
		'demand'      => 'battery,camera,budget,grade-a',
		'reviews'     => 420,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/230529/iphone-13-pro-max-xanh-la-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/' ),
		'serial'      => '#USED-IP13PM-553',
	),
	array(
		'id'          => 108,
		'name'        => '[Cũ 99%] OPPO Find X7 Ultra 256GB Nâu Da (#USED-OPX7U-108)',
		'brand'       => 'OPPO',
		'capacity'    => '256GB',
		'price'       => 14990000,
		'price_old'   => 24990000,
		'specs'       => 'Grade A 99% • Dual Periscope Hasselblad • Sạc 100W',
		'condition'   => 'grade-a',
		'battery'     => '99%',
		'applecare'   => false,
		'demand'      => 'camera,battery,grade-a',
		'reviews'     => 52,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/333347/oppo-find-x8-pro-trang-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/oppo-find-x8-pro-512gb-hasselblad-camera-master/' ),
		'serial'      => '#USED-OPX7U-108',
	),
	array(
		'id'          => 109,
		'name'        => '[Cũ 99%] iPhone 15 128GB Hồng Pastel VN/A (#USED-IP15-812)',
		'brand'       => 'Apple',
		'capacity'    => '128GB',
		'price'       => 14290000,
		'price_old'   => 19990000,
		'specs'       => 'Grade A 99% • Pin 98% • Còn bảo hành AppleCare 2026',
		'condition'   => 'grade-a',
		'battery'     => '98%',
		'applecare'   => true,
		'demand'      => 'applecare,grade-a,budget',
		'reviews'     => 178,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/281570/iphone-15-pink-thumbnew-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/' ),
		'serial'      => '#USED-IP15-812',
	),
	array(
		'id'          => 110,
		'name'        => '[Cũ 99%] Samsung Galaxy S23 Ultra 256GB Đen (#USED-S23U-401)',
		'brand'       => 'Samsung',
		'capacity'    => '256GB',
		'price'       => 15290000,
		'price_old'   => 25990000,
		'specs'       => 'Grade A 99% • Camera 200MP Zoom 100x • Bút S-Pen',
		'condition'   => 'grade-a',
		'battery'     => '95%',
		'applecare'   => false,
		'demand'      => 'camera,gaming,grade-a',
		'reviews'     => 290,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/249948/samsung-galaxy-s23-ultra-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/samsung-galaxy-s25-ultra-512gb-chinh-hang-ssvn/' ),
		'serial'      => '#USED-S23U-401',
	),
	array(
		'id'          => 111,
		'name'        => '[Cũ 99%] Google Pixel 8 Pro 128GB Porcelain (#USED-P8P-093)',
		'brand'       => 'Google Pixel',
		'capacity'    => '128GB',
		'price'       => 12990000,
		'price_old'   => 21990000,
		'specs'       => 'Grade A 99% • Thuần Google AI • Chụp đêm siêu nét',
		'condition'   => 'grade-a',
		'battery'     => '97%',
		'applecare'   => false,
		'demand'      => 'camera,budget,grade-a',
		'reviews'     => 45,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg',
		'permalink'   => home_url( '/dien-thoai/' ),
		'serial'      => '#USED-P8P-093',
	),
	array(
		'id'          => 112,
		'name'        => '[Cũ 98%] iPhone 12 Pro Max 128GB Xanh Pacific (#USED-IP12PM-672)',
		'brand'       => 'Apple',
		'capacity'    => '128GB',
		'price'       => 10890000,
		'price_old'   => 18990000,
		'specs'       => 'Grade B 98% • Pin 89% • Khung thép không gỉ sang trọng',
		'condition'   => 'grade-b',
		'battery'     => '89%',
		'applecare'   => false,
		'demand'      => 'budget',
		'reviews'     => 512,
		'img'         => 'https://cdn.tgdd.vn/Products/Images/42/213033/iphone-12-pro-max-xanh-duong-thumb-600x600.jpg',
		'permalink'   => home_url( '/product/iphone-16-pro-max-256gb-chinh-hang-vn-a/' ),
		'serial'      => '#USED-IP12PM-672',
	),
);

// Populate list from DB if product ID 21 (used product) exists
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$pid     = get_the_ID();
		$product = wc_get_product( $pid );
		if ( ! $product ) {
			continue;
		}

		$title = get_the_title();
		// Only pick if product has 'Cũ' or 'used' or tag
		if ( stripos( $title, 'cũ' ) !== false || stripos( $title, 'used' ) !== false || has_term( 'used', 'product_cat', $pid ) ) {
			$brand = 'Apple';
			if ( stripos( $title, 'Samsung' ) !== false ) $brand = 'Samsung';
			elseif ( stripos( $title, 'Xiaomi' ) !== false ) $brand = 'Xiaomi';
			elseif ( stripos( $title, 'OPPO' ) !== false ) $brand = 'OPPO';
			elseif ( stripos( $title, 'vivo' ) !== false ) $brand = 'Vivo';

			$cap = '256GB';
			if ( preg_match( '/\b(128GB|256GB|512GB|1TB)\b/i', $title, $m ) ) {
				$cap = strtoupper( $m[1] );
			}

			$p_price = floatval( $product->get_price() );
			$p_reg   = floatval( $product->get_regular_price() );
			if ( $p_reg <= $p_price ) $p_reg = round( $p_price * 1.35, -4 );

			$db_item = array(
				'id'          => $pid,
				'name'        => $title,
				'brand'       => $brand,
				'capacity'    => $cap,
				'price'       => $p_price > 0 ? $p_price : 22490000,
				'price_old'   => $p_reg,
				'specs'       => 'Grade A 99% • Pin 98% Zin • Cam kết nguyên bản',
				'condition'   => 'grade-a',
				'battery'     => '98%',
				'applecare'   => false,
				'demand'      => 'grade-a,camera,battery',
				'reviews'     => 128,
				'img'         => wp_get_attachment_image_url( $product->get_image_id(), 'medium' ) ?: 'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-blue-thumbnew-600x600.jpg',
				'permalink'   => get_permalink( $pid ),
				'serial'      => '#USED-DB-' . $pid,
			);
			// Prepend DB product
			array_unshift( $curated_used_phones, $db_item );
		}
	}
	wp_reset_postdata();
}

$phones_list = $curated_used_phones;

// Collect unique brands
foreach ( $phones_list as $p ) {
	if ( ! empty( $p['brand'] ) && ! in_array( $p['brand'], $all_brands, true ) ) {
		$all_brands[] = $p['brand'];
	}
}

// Brand Meta dictionary
$brand_meta = array(
	'Apple'        => array( 'icon' => 'phone_iphone' ),
	'Samsung'      => array( 'icon' => 'smartphone' ),
	'Xiaomi'       => array( 'icon' => 'speed' ),
	'OPPO'         => array( 'icon' => 'photo_camera' ),
	'Vivo'         => array( 'icon' => 'portrait' ),
	'Google Pixel' => array( 'icon' => 'auto_awesome' ),
);
?>

<div class="bg-[#f8f9fb] min-h-screen pb-16 text-[#222222] font-sans">

  <!-- ================= BREADCRUMB ================= -->
  <div class="border-b border-[#E5E7EB] bg-white">
    <div class="max-w-[1240px] mx-auto px-4 py-3 flex items-center justify-between text-sm text-[#5f5e5e]">
      <div class="flex items-center gap-2">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#e60012] transition-colors flex items-center gap-1 font-medium">
          <span class="material-symbols-outlined text-[18px]">home</span> Trang chủ
        </a>
        <span class="text-[#E5E7EB]">/</span>
        <span class="font-bold text-[#222222]">Điện thoại cũ giá tốt</span>
      </div>
      <div class="hidden sm:flex items-center gap-4 text-xs font-semibold text-[#b7000c]">
        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">verified</span> Cam kết Zin 100%</span>
        <span>•</span>
        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">security</span> 1 Đổi 1 trong 30 ngày</span>
      </div>
    </div>
  </div>

  <div class="max-w-[1240px] mx-auto px-4 pt-4 sm:pt-6 space-y-5">

    <!-- ================= 1. PROMOTION HERO BANNER (TGDD Style with Stitch Palette) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
      <!-- Main Featured Banner -->
      <div class="md:col-span-2 relative rounded-2xl overflow-hidden shadow-sm bg-gradient-to-r from-[#e60012] via-[#b7000c] to-[#b7000c] text-white p-6 sm:p-8 flex flex-col justify-between min-h-[220px]">
        <div class="relative z-10 max-w-[480px]">
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs sm:text-sm font-bold text-[#FF9800] mb-2.5">
            <span class="material-symbols-outlined text-[18px]">verified</span> CHUYÊN TRANG ĐIỆN THOẠI CŨ PHONEX
          </span>
          <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
            MÁY CŨ LIKE NEW 99%<br/>TIẾT KIỆM ĐẾN 50%
          </h1>
          <p class="text-xs sm:text-sm text-[#ffdad5] mt-2.5 line-clamp-2 leading-relaxed">
            100% máy nguyên bản Zin All &bull; Kiểm định 45 bước độc bản &bull; Bảo hành VIP 12 tháng cả nguồn & màn hình.
          </p>
        </div>
        <div class="relative z-10 mt-5 flex items-center gap-4 flex-wrap">
          <a href="#used-catalog" class="px-6 py-3 rounded-xl bg-[#FF9800] hover:bg-[#e68900] text-white font-black text-xs sm:text-sm transition-all shadow-md inline-flex items-center gap-1.5 cursor-pointer">
            Xem Ngay Danh Sách Máy <span class="material-symbols-outlined text-[20px]">arrow_downward</span>
          </a>
          <span class="text-xs sm:text-sm text-[#ffdad5] font-semibold">Độc bản duy nhất 1 máy mỗi IMEI</span>
        </div>
        <!-- Decorative graphic elements -->
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-6 hidden sm:block opacity-20">
          <span class="material-symbols-outlined text-[130px]">sync_alt</span>
        </div>
      </div>

      <!-- Right Sub-Banners -->
      <div class="flex flex-col gap-3">
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#b7000c] to-[#e60012] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#ffdad5] tracking-wider">Hệ Sinh Thái iPhone Cũ</div>
            <div class="text-base sm:text-lg font-black mt-0.5">iPhone 14 | 15 | 16 Series</div>
            <div class="text-xs sm:text-sm text-[#ffdad5]/90 mt-1">Pin 95% - 100% &bull; Like New 99%</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#ffdad5] shrink-0">verified</span>
        </div>
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#222222] to-[#b7000c] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#FF9800] tracking-wider">Trợ Giá Lên Đời</div>
            <div class="text-base sm:text-lg font-black mt-0.5">Thu Cũ Giá Cao Nhất</div>
            <div class="text-xs sm:text-sm text-[#ffdad5]/90 mt-1">Trợ giá thêm đến 3.000.000₫</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#FF9800] shrink-0">published_with_changes</span>
        </div>
      </div>
    </div>

    <!-- ================= 2. BRAND LOGOS & QUICK PILLS (TGDD Brand Slider) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB]" id="used-catalog">
      <div class="flex items-center justify-between mb-3.5">
        <h2 class="text-base sm:text-lg font-black text-[#222222] uppercase tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[22px]">apps</span>
          Chọn Thương Hiệu Điện Thoại Cũ
        </h2>
        <span class="text-xs sm:text-sm text-[#5f5e5e] font-medium">Hiện có <?php echo count( $phones_list ); ?> máy sẵn hàng</span>
      </div>

      <div class="flex items-center gap-2.5 overflow-x-auto pb-1 scrollbar-none" id="brand-selector-list">
        <!-- Button: Tất cả -->
        <button type="button" class="brand-btn active shrink-0 px-4 sm:px-5 py-2.5 rounded-xl border border-[#e60012] bg-[#e60012] text-white text-[13px] sm:text-[14px] font-bold transition-all shadow-xs flex items-center gap-2 cursor-pointer" data-brand="all">
          <span>Tất cả</span>
          <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px]"><?php echo count( $phones_list ); ?></span>
        </button>

        <!-- Brand Buttons -->
        <?php foreach ( $all_brands as $b ) : 
          $b_count = 0;
          foreach ( $phones_list as $pl ) {
            if ( $pl['brand'] === $b ) $b_count++;
          }
        ?>
          <button type="button" class="brand-btn shrink-0 px-4 sm:px-4.5 py-2.5 rounded-xl border border-[#E5E7EB] hover:border-[#e60012] bg-white hover:bg-[#ffdad5]/30 text-[#222222] hover:text-[#e60012] text-[13px] sm:text-[14px] font-bold transition-all shadow-2xs flex items-center gap-2 cursor-pointer" data-brand="<?php echo esc_attr( $b ); ?>">
            <span><?php echo esc_html( $b ); ?> Cũ</span>
            <span class="px-2 py-0.5 rounded-full bg-[#f8f9fb] text-[#5f5e5e] text-[11px]"><?php echo $b_count; ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 3. QUICK CONDITION / DEMANDS (Phân loại tình trạng máy cũ) ================= -->
    <div class="flex items-center gap-2.5 overflow-x-auto pb-1 text-xs sm:text-sm font-bold scrollbar-none" id="demand-selector-list">
      <span class="text-[#5f5e5e] shrink-0 font-extrabold text-xs uppercase mr-1">Tình trạng:</span>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="grade-a">
        ⭐ Grade A 99% (Like New)
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="battery">
        🔋 Pin zin 95% - 100%
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="applecare">
        🍎 Còn bảo hành AppleCare
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="fullbox">
        📦 Fullbox phụ kiện zin
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="budget">
        💰 Giá rẻ dưới 15 triệu
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="camera">
        📸 Chụp ảnh quay video đẹp
      </button>
    </div>

    <!-- ================= 4. COMPREHENSIVE FILTER BOX (Bộ lọc đa tiêu chí máy cũ) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB] space-y-4">
      <div class="flex items-center justify-between border-b border-[#E5E7EB] pb-3">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[22px]">tune</span>
          <span class="font-black text-[#222222] text-sm sm:text-base">Bộ Lọc Tìm Kiếm Máy Cũ Chi Tiết</span>
        </div>
        <button type="button" id="btn-reset-filters" class="text-xs sm:text-sm text-[#e60012] font-bold hover:underline hidden flex items-center gap-1 cursor-pointer">
          <span class="material-symbols-outlined text-[16px]">refresh</span> Xóa tất cả bộ lọc
        </button>
      </div>

      <!-- Filter Controls Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3.5 text-xs sm:text-sm">
        <!-- Price Range Filter -->
        <div>
          <label class="block font-bold text-[#222222] mb-1.5">Mức Giá:</label>
          <select id="filter-price" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả mức giá</option>
            <option value="under-15m">Dưới 15 triệu</option>
            <option value="15m-20m">Từ 15 - 20 triệu</option>
            <option value="20m-25m">Từ 20 - 25 triệu</option>
            <option value="over-25m">Flagship cũ trên 25 triệu</option>
          </select>
        </div>

        <!-- Storage Filter -->
        <div>
          <label class="block font-bold text-[#222222] mb-1.5">Dung Lượng Bộ Nhớ:</label>
          <select id="filter-storage" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả dung lượng</option>
            <option value="128GB">128 GB</option>
            <option value="256GB">256 GB</option>
            <option value="512GB">512 GB</option>
            <option value="1TB">1 TB</option>
          </select>
        </div>

        <!-- Condition Filter -->
        <div>
          <label class="block font-bold text-[#222222] mb-1.5">Ngoại Hình / Tình Trạng:</label>
          <select id="filter-condition" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả phân loại</option>
            <option value="grade-a">Grade A (99% - Like New)</option>
            <option value="grade-b">Grade B (97% - 98%)</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div>
          <label class="block font-bold text-[#222222] mb-1.5">Sắp Xếp Theo:</label>
          <select id="filter-sort" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-hidden transition-all text-xs sm:text-sm">
            <option value="default">Nổi bật nhất</option>
            <option value="price-asc">Giá: Thấp đến Cao</option>
            <option value="price-desc">Giá: Cao đến Thấp</option>
            <option value="saving-desc">% Tiết kiệm nhiều nhất</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Active Filter Counter -->
    <div class="flex items-center justify-between text-xs sm:text-sm text-[#5f5e5e] px-1">
      <div>
        Tìm thấy <strong id="results-count" class="text-[#e60012] font-black text-sm sm:text-base"><?php echo count( $phones_list ); ?></strong> điện thoại cũ phù hợp
      </div>
      <div class="flex items-center gap-1.5 text-xs text-[#5f5e5e]">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>Cam kết máy thật 100% đúng serial</span>
      </div>
    </div>

    <!-- ================= 5. PRODUCT GRID (Google Stitch & TGDD Standards) ================= -->
    <div id="phones-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4.5">
      <?php foreach ( $phones_list as $p ) : 
        $savings = $p['price_old'] - $p['price'];
        $discount_pct = round( ( $savings / $p['price_old'] ) * 100 );
      ?>
        <div class="phone-item bg-white rounded-2xl p-3 sm:p-4 border border-[#E5E7EB] hover:border-[#e60012] shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group relative"
             data-brand="<?php echo esc_attr( $p['brand'] ); ?>"
             data-price="<?php echo esc_attr( $p['price'] ); ?>"
             data-storage="<?php echo esc_attr( $p['capacity'] ); ?>"
             data-condition="<?php echo esc_attr( $p['condition'] ); ?>"
             data-demand="<?php echo esc_attr( $p['demand'] ); ?>"
             data-savings="<?php echo esc_attr( $savings ); ?>">

          <!-- Top Image & Badges -->
          <div>
            <div class="relative w-full aspect-square rounded-xl bg-[#f8f9fb] p-3 flex items-center justify-center overflow-hidden mb-3">
              <!-- Discount Badge -->
              <span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded-md bg-[#ffdad5] text-[#b7000c] text-[11px] sm:text-[12px] font-black shadow-2xs">
                -<?php echo esc_html( $discount_pct ); ?>% Tiết Kiệm
              </span>

              <!-- Condition Tag -->
              <span class="absolute top-2 right-2 z-10 px-2 py-0.5 rounded-md bg-[#222222]/80 backdrop-blur-xs text-white text-[10px] font-bold uppercase">
                <?php echo ( 'grade-a' === $p['condition'] ) ? '99% LIKE NEW' : '98% ZIN'; ?>
              </span>

              <!-- Product Image -->
              <img src="<?php echo esc_url( $p['img'] ); ?>" 
                   alt="<?php echo esc_attr( $p['name'] ); ?>" 
                   class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300" 
                   loading="lazy" />
            </div>

            <!-- Specs tag -->
            <?php if ( ! empty( $p['specs'] ) ) : ?>
              <div class="mb-1.5 flex items-center gap-1 overflow-hidden">
                <span class="px-2 py-0.5 rounded bg-[#f2f4f6] text-[#5f5e5e] border border-[#E5E7EB] text-[11px] sm:text-[12px] font-medium truncate max-w-full">
                  <?php echo esc_html( $p['specs'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 class="text-[14px] sm:text-[15.5px] leading-snug font-bold text-[#222222] line-clamp-2 min-h-[42px] group-hover:text-[#e60012] transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="hover:text-[#e60012] transition-colors">
                <?php echo esc_html( $p['name'] ); ?>
              </a>
            </h3>

            <!-- Serial & Storage pill -->
            <div class="mt-2 flex items-center justify-between gap-1">
              <span class="text-[11px] font-mono font-semibold text-[#5f5e5e] bg-[#f8f9fb] px-2 py-0.5 rounded border border-[#E5E7EB]">
                <?php echo esc_html( $p['serial'] ?? '#USED' ); ?>
              </span>
              <span class="px-2 py-0.5 rounded border border-[#E5E7EB] text-[#222222] text-[11px] sm:text-[12px] font-bold bg-[#f8f9fb]">
                <?php echo esc_html( $p['capacity'] ); ?>
              </span>
            </div>

            <!-- Price Display -->
            <div class="mt-2.5">
              <div class="text-[17px] sm:text-[19px] font-black text-[#e60012] leading-tight">
                <?php echo number_format( $p['price'], 0, ',', '.' ); ?>₫
              </div>
              <div class="flex items-center gap-2 mt-0.5">
                <span class="text-[12px] sm:text-[13px] text-[#5f5e5e] line-through font-medium">
                  <?php echo number_format( $p['price_old'], 0, ',', '.' ); ?>₫
                </span>
                <span class="text-[11px] text-[#b7000c] font-bold">
                  Tiết kiệm <?php echo number_format( $savings, 0, ',', '.' ); ?>₫
                </span>
              </div>
            </div>

            <!-- Star rating & Reviews -->
            <div class="mt-2 flex items-center gap-1 text-[12px] sm:text-[13px] text-[#FF9800] font-bold">
              <span>★</span>
              <span>5.0</span>
              <span class="text-[#5f5e5e] font-normal">(<?php echo esc_html( $p['reviews'] ); ?>)</span>
            </div>
          </div>

          <!-- Bottom Button -->
          <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="mt-3.5 w-full h-9 sm:h-10 rounded-xl bg-[#ffdad5] hover:bg-[#e60012] text-[#e60012] hover:text-white text-xs sm:text-sm font-extrabold transition-all flex items-center justify-center gap-1 shadow-2xs">
            Xem Chi Tiết &amp; Giữ Máy
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Centered "Xem thêm X Điện thoại cũ" Button -->
    <div class="flex justify-center pt-3 pb-2">
      <button type="button" id="btn-load-more-phones" onclick="window.scrollTo({top: document.getElementById('phones-grid').offsetTop - 80, behavior: 'smooth'})" class="inline-flex items-center justify-center gap-1.5 px-8 py-3 rounded-xl border border-[#e60012] bg-white hover:bg-[#ffdad5] text-[#e60012] font-bold text-sm sm:text-base shadow-2xs transition-all cursor-pointer">
        <span>Xem thêm <span id="load-more-counter"><?php echo count( $phones_list ); ?></span> Điện thoại cũ</span>
        <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
      </button>
    </div>

    <!-- Centered Satisfaction Feedback Box (TGDD Yellow Border Box) -->
    <div class="max-w-[540px] mx-auto my-5 p-3.5 sm:p-4 rounded-xl bg-white border border-[#fcd34d] shadow-2xs flex items-center justify-between gap-4">
      <span class="text-xs sm:text-sm font-semibold text-[#222222] leading-snug">
        Bạn có hài lòng với trải nghiệm tìm kiếm thông tin máy cũ trên website không?
      </span>
      <div class="flex items-center gap-5 shrink-0 text-xs sm:text-sm">
        <button type="button" onclick="this.classList.toggle('scale-125'); alert('Cảm ơn bạn đã phản hồi hài lòng!')" class="flex flex-col items-center gap-0.5 hover:scale-110 transition-transform cursor-pointer group" title="Hài lòng">
          <span class="text-2xl leading-none">🥰</span>
          <span class="text-[#f59e0b] font-bold text-[11px] group-hover:underline">Hài lòng</span>
        </button>
        <button type="button" onclick="this.classList.toggle('scale-125'); alert('PhoneX đã ghi nhận ý kiến đóng góp của bạn để hoàn thiện hơn!')" class="flex flex-col items-center gap-0.5 hover:scale-110 transition-transform cursor-pointer group" title="Không hài lòng">
          <span class="text-2xl leading-none">😞</span>
          <span class="text-[#f59e0b] font-bold text-[11px] group-hover:underline">Không hài lòng</span>
        </button>
      </div>
    </div>

    <!-- Empty State -->
    <div id="no-products-msg" class="hidden bg-white rounded-2xl p-12 text-center border border-[#E5E7EB] space-y-3">
      <span class="material-symbols-outlined text-[48px] text-[#5f5e5e]">search_off</span>
      <h3 class="text-base sm:text-lg font-bold text-[#222222]">Không tìm thấy điện thoại cũ nào phù hợp</h3>
      <p class="text-xs sm:text-sm text-[#5f5e5e] max-w-md mx-auto">
        Hãy thử thay đổi hoặc xóa các tiêu chí bộ lọc để xem thêm các mẫu điện thoại cũ khác.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-5 py-2.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white text-xs sm:text-sm font-bold cursor-pointer shadow-xs transition-colors">
        Xóa Tất Cả Bộ Lọc
      </button>
    </div>

    <!-- ================= 8. THÔNG TIN NGÀNH HÀNG ĐIỆN THOẠI CŨ (LẤY TỪ QUẢN TRỊ DANH MỤC TERM 21 / USED) ================= -->
    <?php
    $cat_seo_term_id = 21; // Term ID for "Máy Cũ 99%"
    if ( is_tax( 'product_cat' ) ) {
      $cat_seo_term_id = get_queried_object_id();
    } else {
      $cat_seo_obj = get_term_by( 'slug', 'used', 'product_cat' );
      if ( ! $cat_seo_obj ) {
        $cat_seo_obj = get_term_by( 'slug', 'dien-thoai-cu', 'product_cat' );
      }
      $cat_seo_term_id = ( $cat_seo_obj && ! is_wp_error( $cat_seo_obj ) ) ? $cat_seo_obj->term_id : 21;
    }
    if ( function_exists( 'phonex_render_category_seo_frontend' ) ) {
      phonex_render_category_seo_frontend( $cat_seo_term_id );
    }
    ?>

    <!-- ================= 7. BUYING GUIDE & ACCORDION (TGDD Style SEO Content - Centered Reading Column) ================= -->
    <div class="max-w-[820px] mx-auto bg-white rounded-2xl p-6 sm:p-8 shadow-2xs border border-[#E5E7EB] space-y-4 mt-8">
      <h2 class="text-base sm:text-lg font-black text-[#222222] border-b border-[#E5E7EB] pb-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-[#e60012] text-[22px]">verified_user</span>
        Quy Chuẩn Kiểm Định &amp; Quyền Lợi Khi Mua Điện Thoại Cũ Tại PhoneX
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm leading-relaxed text-[#5f5e5e]">
        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">fact_check</span> 1. Thẩm Định 45 Bước Kỹ Thuật
          </h3>
          <p>
            Mỗi máy cũ tại PhoneX đều được kiểm tra độc lập 45 tiêu chuẩn: Áp suất chống nước, màn hình TrueTone zin, Face ID/Vân tay và mainboard nguyên bản 100%.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#FF9800] text-[20px]">battery_charging_full</span> 2. Cam Kết Pin Zin &gt; 90%
          </h3>
          <p>
            PhoneX chỉ tuyển chọn những máy có dung lượng pin thực tế cao (từ 90% - 100%), số chu kỳ sạc ít. Cam kết pin nguyên bản của Apple/Samsung, không kích pin ảo.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#198754] text-[20px]">shield</span> 3. Bảo Hành VIP Toàn Diện
          </h3>
          <p>
            Bảo hành 12 tháng phần cứng toàn diện (bao gồm cả nguồn và màn hình cảm ứng). Lỗi 1 đổi 1 trong 30 ngày đầu, hoàn tiền 100% nếu phát hiện máy không zin.
          </p>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ================= JAVASCRIPT CONTROLLER: REAL-TIME FILTERING & SORTING ================= -->
<script>
(function() {
  let activeBrand = 'all';
  let activeDemand = '';
  const priceSelect = document.getElementById('filter-price');
  const storageSelect = document.getElementById('filter-storage');
  const conditionSelect = document.getElementById('filter-condition');
  const sortSelect = document.getElementById('filter-sort');
  const resultsCount = document.getElementById('results-count');
  const noProductsMsg = document.getElementById('no-products-msg');
  const resetBtn = document.getElementById('btn-reset-filters');
  const grid = document.getElementById('phones-grid');
  const items = Array.from(grid.querySelectorAll('.phone-item'));

  // Brand click
  document.querySelectorAll('.brand-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.brand-btn').forEach(b => {
        b.classList.remove('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
        b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
        const countBadge = b.querySelector('span:last-child');
        if (countBadge) {
          countBadge.className = 'px-2 py-0.5 rounded-full bg-[#f8f9fb] text-[#5f5e5e] text-[11px]';
        }
      });

      this.classList.add('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
      this.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      const activeBadge = this.querySelector('span:last-child');
      if (activeBadge) {
        activeBadge.className = 'px-2 py-0.5 rounded-full bg-white/20 text-white text-[11px]';
      }

      activeBrand = this.getAttribute('data-brand');
      applyFilters();
    });
  });

  // Demand click
  document.querySelectorAll('.demand-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const demand = this.getAttribute('data-demand');
      if (activeDemand === demand) {
        activeDemand = '';
        this.classList.remove('border-[#e60012]', 'bg-[#ffdad5]', 'text-[#e60012]', 'font-bold');
        this.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      } else {
        document.querySelectorAll('.demand-btn').forEach(b => {
          b.classList.remove('border-[#e60012]', 'bg-[#ffdad5]', 'text-[#e60012]', 'font-bold');
          b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
        });
        activeDemand = demand;
        this.classList.add('border-[#e60012]', 'bg-[#ffdad5]', 'text-[#e60012]', 'font-bold');
        this.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      }
      applyFilters();
    });
  });

  // Select changes
  if (priceSelect) priceSelect.addEventListener('change', applyFilters);
  if (storageSelect) storageSelect.addEventListener('change', applyFilters);
  if (conditionSelect) conditionSelect.addEventListener('change', applyFilters);
  if (sortSelect) sortSelect.addEventListener('change', applyFilters);

  if (resetBtn) {
    resetBtn.addEventListener('click', resetAllFilters);
  }

  window.resetAllFilters = function() {
    activeBrand = 'all';
    activeDemand = '';
    if (priceSelect) priceSelect.value = 'all';
    if (storageSelect) storageSelect.value = 'all';
    if (conditionSelect) conditionSelect.value = 'all';
    if (sortSelect) sortSelect.value = 'default';

    document.querySelectorAll('.brand-btn').forEach(b => {
      b.classList.remove('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
      b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      const countBadge = b.querySelector('span:last-child');
      if (countBadge) {
        countBadge.className = 'px-2 py-0.5 rounded-full bg-[#f8f9fb] text-[#5f5e5e] text-[11px]';
      }
      if (b.getAttribute('data-brand') === 'all') {
        b.classList.add('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
        b.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
        const activeBadge = b.querySelector('span:last-child');
        if (activeBadge) activeBadge.className = 'px-2 py-0.5 rounded-full bg-white/20 text-white text-[11px]';
      }
    });

    document.querySelectorAll('.demand-btn').forEach(b => {
      b.classList.remove('border-[#e60012]', 'bg-[#ffdad5]', 'text-[#e60012]', 'font-bold');
      b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
    });

    applyFilters();
  };

  function applyFilters() {
    const priceVal = priceSelect ? priceSelect.value : 'all';
    const storageVal = storageSelect ? storageSelect.value : 'all';
    const conditionVal = conditionSelect ? conditionSelect.value : 'all';
    const sortVal = sortSelect ? sortSelect.value : 'default';

    let visibleCount = 0;

    // Check if any filter is active
    const hasActiveFilter = (activeBrand !== 'all') || (activeDemand !== '') || (priceVal !== 'all') || (storageVal !== 'all') || (conditionVal !== 'all');
    if (resetBtn) {
      if (hasActiveFilter) {
        resetBtn.classList.remove('hidden');
      } else {
        resetBtn.classList.add('hidden');
      }
    }

    items.forEach(item => {
      const brand = item.getAttribute('data-brand');
      const price = parseFloat(item.getAttribute('data-price')) || 0;
      const storage = item.getAttribute('data-storage');
      const condition = item.getAttribute('data-condition');
      const demands = (item.getAttribute('data-demand') || '').split(',');

      let show = true;

      // Brand
      if (activeBrand !== 'all' && brand !== activeBrand) {
        show = false;
      }

      // Quick Condition / Demand
      if (show && activeDemand !== '') {
        if (!demands.includes(activeDemand)) {
          show = false;
        }
      }

      // Price
      if (show && priceVal !== 'all') {
        if (priceVal === 'under-15m' && price >= 15000000) show = false;
        else if (priceVal === '15m-20m' && (price < 15000000 || price > 20000000)) show = false;
        else if (priceVal === '20m-25m' && (price < 20000000 || price > 25000000)) show = false;
        else if (priceVal === 'over-25m' && price <= 25000000) show = false;
      }

      // Storage
      if (show && storageVal !== 'all' && storage !== storageVal) {
        show = false;
      }

      // Condition
      if (show && conditionVal !== 'all' && condition !== conditionVal) {
        show = false;
      }

      if (show) {
        item.style.display = '';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    // Update Counter
    if (resultsCount) {
      resultsCount.textContent = visibleCount;
    }
    const loadMoreCounter = document.getElementById('load-more-counter');
    if (loadMoreCounter) {
      loadMoreCounter.textContent = visibleCount;
    }

    // Empty State message
    if (noProductsMsg) {
      if (visibleCount === 0) {
        noProductsMsg.classList.remove('hidden');
        grid.classList.add('hidden');
      } else {
        noProductsMsg.classList.add('hidden');
        grid.classList.remove('hidden');
      }
    }

    // Sort visible items
    if (sortVal !== 'default' && visibleCount > 0) {
      const visibleItems = items.filter(it => it.style.display !== 'none');
      visibleItems.sort((a, b) => {
        const pA = parseFloat(a.getAttribute('data-price')) || 0;
        const pB = parseFloat(b.getAttribute('data-price')) || 0;
        const sA = parseFloat(a.getAttribute('data-savings')) || 0;
        const sB = parseFloat(b.getAttribute('data-savings')) || 0;

        if (sortVal === 'price-asc') return pA - pB;
        if (sortVal === 'price-desc') return pB - pA;
        if (sortVal === 'saving-desc') return sB - sA;
        return 0;
      });

      visibleItems.forEach(it => grid.appendChild(it));
    }
  }
})();
</script>

<?php
get_footer();
