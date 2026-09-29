<?php
/**
 * Template Name: PhoneX Danh Mục Điện Thoại (TGDD Style)
 *
 * Dedicated Phone Category Page modeled after thegioididong.com/dtdd
 * Uses PhoneX brand colors (#b7000c primary, clean modern styling)
 * Integrates directly with WooCommerce products & TGDD crawled phones.
 *
 * @package PhoneX
 */

get_header();

// 1. FETCH ALL PHONE PRODUCTS FROM WOOCOMMERCE
$phone_categories = array( 'dien-thoai', 'apple-iphone', 'samsung-galaxy', 'xiaomi', 'oppo', 'vivo', 'realme', 'motorola', 'nothing-phone', 'may-cu-99' );

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
			'terms'    => $phone_categories,
			'operator' => 'IN',
		),
	),
);

$query = new WP_Query( $args );

// Fallback: If no products found via taxonomy, query all products
if ( ! $query->have_posts() ) {
	$args['tax_query'] = array();
	$query             = new WP_Query( $args );
}

$phones_list = array();
$all_brands  = array();

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$pid     = get_the_ID();
		$product = wc_get_product( $pid );
		if ( ! $product ) {
			continue;
		}

		// Detect Brand
		$brand = get_post_meta( $pid, '_brand_name', true );
		if ( empty( $brand ) ) {
			$terms = wp_get_post_terms( $pid, 'product_cat', array( 'fields' => 'names' ) );
			$title = get_the_title();
			if ( stripos( $title, 'iPhone' ) !== false || in_array( 'Apple iPhone', $terms, true ) ) {
				$brand = 'Apple';
			} elseif ( stripos( $title, 'Samsung' ) !== false || stripos( $title, 'Galaxy' ) !== false ) {
				$brand = 'Samsung';
			} elseif ( stripos( $title, 'Xiaomi' ) !== false || stripos( $title, 'Redmi' ) !== false ) {
				$brand = 'Xiaomi';
			} elseif ( stripos( $title, 'OPPO' ) !== false ) {
				$brand = 'OPPO';
			} elseif ( stripos( $title, 'Vivo' ) !== false ) {
				$brand = 'Vivo';
			} elseif ( stripos( $title, 'Realme' ) !== false ) {
				$brand = 'Realme';
			} elseif ( stripos( $title, 'Motorola' ) !== false ) {
				$brand = 'Motorola';
			} elseif ( stripos( $title, 'Nothing' ) !== false ) {
				$brand = 'Nothing Phone';
			} else {
				$brand = 'Khác';
			}
		}

		// Collect unique brands
		$brand_clean = trim( $brand );
		if ( ! empty( $brand_clean ) && ! in_array( $brand_clean, $all_brands, true ) ) {
			$all_brands[] = $brand_clean;
		}

		// Capacity
		$capacity = get_post_meta( $pid, '_storage_capacity', true );
		if ( empty( $capacity ) ) {
			if ( preg_match( '/\b(64GB|128GB|256GB|512GB|1TB)\b/i', get_the_title(), $cap_m ) ) {
				$capacity = strtoupper( $cap_m[1] );
			}
		}

		// Prices
		$price_current = floatval( $product->get_price() );
		$price_reg     = floatval( $product->get_regular_price() );
		$price_sale    = floatval( $product->get_sale_price() );

		if ( $price_sale > 0 && $price_reg > $price_sale ) {
			$display_price = $price_sale;
			$display_old   = $price_reg;
			$discount_pct  = round( ( ( $price_reg - $price_sale ) / $price_reg ) * 100 );
		} else {
			$display_price = $price_current > 0 ? $price_current : $price_reg;
			$display_old   = 0;
			$discount_pct  = 0;
		}

		// Image
		$image_url = get_the_post_thumbnail_url( $pid, 'medium' );
		if ( ! $image_url ) {
			$image_url = get_post_meta( $pid, '_crawler_image_url', true );
		}
		if ( ! $image_url ) {
			$image_url = wc_placeholder_img_src();
		}

		// Specs
		$specs = get_post_meta( $pid, '_basic_specs', true );
		if ( empty( $specs ) ) {
			$specs = $product->get_short_description();
		}
		$specs = wp_strip_all_tags( $specs );

		// OS Detection
		$os = ( 'Apple' === $brand_clean || stripos( get_the_title(), 'iPhone' ) !== false ) ? 'ios' : 'android';

		// Demand Tags Detection
		$demands = array();
		if ( $display_price >= 20000000 || stripos( $specs, 'Pro' ) !== false || stripos( $specs, 'Ultra' ) !== false ) {
			$demands[] = 'gaming';
			$demands[] = 'camera';
			$demands[] = 'luxury';
		}
		if ( stripos( $specs, 'Fold' ) !== false || stripos( $specs, 'Flip' ) !== false || stripos( get_the_title(), 'Fold' ) !== false ) {
			$demands[] = 'foldable';
		}
		if ( $display_price <= 10000000 ) {
			$demands[] = 'budget';
			$demands[] = 'battery';
		}

		$phones_list[] = array(
			'id'           => $pid,
			'name'         => get_the_title(),
			'permalink'    => get_permalink( $pid ),
			'image'        => $image_url,
			'price'        => $display_price,
			'price_old'    => $display_old,
			'discount_pct' => $discount_pct,
			'brand'        => $brand_clean,
			'capacity'     => $capacity,
			'specs'        => $specs,
			'os'           => $os,
			'demands'      => implode( ',', $demands ),
			'rating'       => '5.0',
			'reviews'      => rand( 12, 186 ),
			'is_new'       => ( $display_old == 0 || $pid >= 30 ),
		);
	}
	wp_reset_postdata();
}

// Brand Logos & Icons mapping
$brand_meta = array(
	'Apple'         => array(
		'label' => 'iPhone (Apple)',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/logo-iphone-220x48.png',
	),
	'Samsung'       => array(
		'label' => 'Samsung',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/samsungnew-220x48-1.png',
	),
	'OPPO'          => array(
		'label' => 'OPPO',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/OPPO42-b_5.jpg',
	),
	'Xiaomi'        => array(
		'label' => 'Xiaomi',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/logo-xiaomi-220x48-5.png',
	),
	'Vivo'          => array(
		'label' => 'vivo',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/vivo-logo-220-220x48-3.png',
	),
	'Realme'        => array(
		'label' => 'realme',
		'icon'  => 'https://cdn.tgdd.vn/Brand/1/Realme42-b_37.png',
	),
	'Motorola'      => array(
		'label' => 'Motorola',
		'icon'  => '',
	),
	'Nothing Phone' => array(
		'label' => 'Nothing',
		'icon'  => '',
	),
);
?>

<div class="bg-[#f8f9fb] min-h-screen pb-16 text-text-main font-sans">

  <!-- ================= BREADCRUMB ================= -->
  <div class="border-b border-gray-200 bg-white">
    <div class="max-w-[1240px] mx-auto px-4 py-2.5 flex items-center gap-2 text-xs text-gray-500">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">home</span> Trang chủ
      </a>
      <span class="text-gray-300">/</span>
      <span class="font-bold text-gray-800">Điện thoại</span>
    </div>
  </div>

  <div class="max-w-[1240px] mx-auto px-4 pt-4 sm:pt-6 space-y-5">

    <!-- ================= 1. PROMOTION HERO BANNER (TGDD Style) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
      <!-- Main Featured Banner -->
      <div class="md:col-span-2 relative rounded-2xl overflow-hidden shadow-sm bg-gradient-to-r from-red-700 via-rose-700 to-red-800 text-white p-6 sm:p-8 flex flex-col justify-between min-h-[200px]">
        <div class="relative z-10 max-w-[420px]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-bold text-amber-300 mb-2.5">
            <span class="material-symbols-outlined text-[16px]">local_fire_department</span> ĐẠI TIỆC SMARTPHONE 2026
          </span>
          <h1 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
            ĐIỆN THOẠI CHÍNH HÃNG<br/>GIẢM SỐC ĐẾN 35%
          </h1>
          <p class="text-xs sm:text-sm text-red-100 mt-2 line-clamp-2">
            Thu cũ đổi mới trợ giá 3 triệu &bull; Trả góp 0% lãi suất &bull; Bảo hành 12 tháng 1 đổi 1 trong 30 ngày.
          </p>
        </div>
        <div class="relative z-10 mt-4 flex items-center gap-3">
          <a href="#phone-catalog" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-red-950 font-black text-xs sm:text-sm transition-all shadow-md inline-flex items-center gap-1.5">
            Săn Deal Ngay <span class="material-symbols-outlined text-[18px]">arrow_downward</span>
          </a>
          <span class="text-xs text-red-200 font-medium">Cam kết rẻ nhất thị trường</span>
        </div>
        <!-- Decorative graphic elements -->
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-6 hidden sm:block opacity-25">
          <span class="material-symbols-outlined text-[120px]">smartphone</span>
        </div>
      </div>

      <!-- Right Sub-Banners -->
      <div class="flex flex-col gap-3">
        <div class="rounded-2xl p-4 bg-gradient-to-r from-blue-700 to-indigo-800 text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-[11px] font-extrabold uppercase text-blue-200 tracking-wider">Hệ Sinh Thái Apple</div>
            <div class="text-base font-black">iPhone 17 | 18 Pro Max</div>
            <div class="text-xs text-blue-100 mt-0.5">Sẵn hàng VN/A &bull; Giao hỏa tốc 1H</div>
          </div>
          <span class="material-symbols-outlined text-[36px] text-blue-200 shrink-0">verified</span>
        </div>
        <div class="rounded-2xl p-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-[11px] font-extrabold uppercase text-amber-200 tracking-wider">Trợ Giá Lên Đời</div>
            <div class="text-base font-black">Thu Cũ Giá Cao Nhất</div>
            <div class="text-xs text-amber-100 mt-0.5">Trợ giá thêm đến 3.000.000₫</div>
          </div>
          <span class="material-symbols-outlined text-[36px] text-amber-200 shrink-0">sync_alt</span>
        </div>
      </div>
    </div>

    <!-- ================= 2. BRAND LOGOS & QUICK PILLS (TGDD Brand Slider) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-2xs border border-gray-100" id="phone-catalog">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-sm sm:text-base font-black text-gray-800 uppercase tracking-tight flex items-center gap-1.5">
          <span class="material-symbols-outlined text-primary text-[20px]">apps</span>
          Chọn Thương Hiệu Điện Thoại
        </h2>
        <span class="text-xs text-gray-400 font-medium">Hiện có <?php echo count( $all_brands ); ?> hãng hàng đầu</span>
      </div>

      <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none" id="brand-selector-list">
        <!-- Button: Tất cả -->
        <button type="button" class="brand-btn active shrink-0 px-4 py-2 rounded-xl border border-primary bg-primary text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer" data-brand="all">
          <span>Tất cả</span>
          <span class="px-1.5 py-0.2 rounded-full bg-white/20 text-[10px]"><?php echo count( $phones_list ); ?></span>
        </button>

        <?php foreach ( $all_brands as $b ) : ?>
          <?php
          $b_slug  = sanitize_title( $b );
          $b_count = 0;
          foreach ( $phones_list as $pl ) {
			  if ( $pl['brand'] === $b ) {
				  $b_count++;
			  }
		  }
			?>
          <button type="button" class="brand-btn shrink-0 px-3.5 py-2 rounded-xl border border-gray-200 hover:border-primary bg-white hover:bg-red-50/50 text-gray-700 hover:text-primary text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5 cursor-pointer" data-brand="<?php echo esc_attr( $b ); ?>">
            <span><?php echo esc_html( $b ); ?></span>
            <span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-gray-600 text-[10px]"><?php echo $b_count; ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 3. QUICK DEMANDS (Nhu cầu tìm kiếm - TGDD Style) ================= -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold scrollbar-none" id="demand-selector-list">
      <span class="text-gray-400 shrink-0 font-bold text-[11px] uppercase mr-1">Nhu cầu:</span>
      <button type="button" class="demand-btn shrink-0 px-3 py-1.5 rounded-full border border-gray-200 bg-white hover:border-primary hover:text-primary transition-all text-gray-600 cursor-pointer" data-demand="gaming">
        🎮 Chơi game / Cấu hình cao
      </button>
      <button type="button" class="demand-btn shrink-0 px-3 py-1.5 rounded-full border border-gray-200 bg-white hover:border-primary hover:text-primary transition-all text-gray-600 cursor-pointer" data-demand="camera">
        📸 Chụp ảnh, quay phim đẹp
      </button>
      <button type="button" class="demand-btn shrink-0 px-3 py-1.5 rounded-full border border-gray-200 bg-white hover:border-primary hover:text-primary transition-all text-gray-600 cursor-pointer" data-demand="foldable">
        📱 Màn hình gập cao cấp
      </button>
      <button type="button" class="demand-btn shrink-0 px-3 py-1.5 rounded-full border border-gray-200 bg-white hover:border-primary hover:text-primary transition-all text-gray-600 cursor-pointer" data-demand="battery">
        🔋 Pin trâu dùng cả ngày
      </button>
      <button type="button" class="demand-btn shrink-0 px-3 py-1.5 rounded-full border border-gray-200 bg-white hover:border-primary hover:text-primary transition-all text-gray-600 cursor-pointer" data-demand="budget">
        💰 Giá rẻ học sinh, sinh viên
      </button>
    </div>

    <!-- ================= 4. COMPREHENSIVE FILTER BOX (Bộ lọc đa tiêu chí) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-2xs border border-gray-100 space-y-4">
      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
          <span class="font-bold text-gray-800 text-sm sm:text-base">Bộ Lọc Tìm Kiếm Chi Tiết</span>
        </div>
        <button type="button" id="btn-reset-filters" class="text-xs text-primary font-bold hover:underline hidden flex items-center gap-1">
          <span class="material-symbols-outlined text-[14px]">refresh</span> Xóa tất cả bộ lọc
        </button>
      </div>

      <!-- Filter Controls Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
        
        <!-- Price Range Filter -->
        <div>
          <label class="block font-bold text-gray-700 mb-1.5">Mức Giá:</label>
          <select id="filter-price" class="w-full h-9 rounded-xl border border-gray-200 px-3 font-medium bg-gray-50 focus:bg-white focus:border-primary outline-hidden transition-all">
            <option value="all">Tất cả mức giá</option>
            <option value="under-10m">Dưới 10 triệu</option>
            <option value="10m-20m">Từ 10 - 20 triệu</option>
            <option value="20m-35m">Từ 20 - 35 triệu</option>
            <option value="over-35m">Flagship trên 35 triệu</option>
          </select>
        </div>

        <!-- Storage Filter -->
        <div>
          <label class="block font-bold text-gray-700 mb-1.5">Dung Lượng Bộ Nhớ:</label>
          <select id="filter-storage" class="w-full h-9 rounded-xl border border-gray-200 px-3 font-medium bg-gray-50 focus:bg-white focus:border-primary outline-hidden transition-all">
            <option value="all">Tất cả dung lượng</option>
            <option value="128GB">128 GB</option>
            <option value="256GB">256 GB</option>
            <option value="512GB">512 GB</option>
            <option value="1TB">1 TB</option>
          </select>
        </div>

        <!-- OS Filter -->
        <div>
          <label class="block font-bold text-gray-700 mb-1.5">Hệ Điều Hành:</label>
          <select id="filter-os" class="w-full h-9 rounded-xl border border-gray-200 px-3 font-medium bg-gray-50 focus:bg-white focus:border-primary outline-hidden transition-all">
            <option value="all">Tất cả hệ điều hành</option>
            <option value="ios">iOS (Apple iPhone)</option>
            <option value="android">Android (Samsung, Xiaomi, OPPO...)</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div>
          <label class="block font-bold text-gray-700 mb-1.5">Sắp Xếp Theo:</label>
          <select id="filter-sort" class="w-full h-9 rounded-xl border border-gray-200 px-3 font-medium bg-gray-50 focus:bg-white focus:border-primary outline-hidden transition-all">
            <option value="default">Nổi bật nhất</option>
            <option value="price-asc">Giá: Thấp đến Cao</option>
            <option value="price-desc">Giá: Cao đến Thấp</option>
            <option value="discount-desc">% Giảm giá nhiều nhất</option>
          </select>
        </div>
      </div>
    </div>

    <!-- ================= 5. SORT & RESULTS COUNTER BAR ================= -->
    <div class="flex items-center justify-between flex-wrap gap-3 pt-1">
      <div class="text-sm font-bold text-gray-800">
        Tìm thấy <span id="results-count" class="text-primary font-black"><?php echo count( $phones_list ); ?></span> điện thoại chính hãng
      </div>
      <div class="flex items-center gap-1.5 text-xs text-gray-500 font-medium">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
        Sẵn hàng toàn quốc &bull; Trả góp 0%
      </div>
    </div>

    <!-- ================= 6. PRODUCT GRID (TGDD Style Grid) ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4" id="phones-grid">
      <?php foreach ( $phones_list as $p ) : ?>
        <div class="phone-item bg-white rounded-2xl p-3 sm:p-4 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-gray-200 hover:border-primary relative hover:-translate-y-1 duration-200"
             data-id="<?php echo esc_attr( $p['id'] ); ?>"
             data-name="<?php echo esc_attr( mb_strtolower( $p['name'] ) ); ?>"
             data-brand="<?php echo esc_attr( $p['brand'] ); ?>"
             data-price="<?php echo esc_attr( $p['price'] ); ?>"
             data-price-old="<?php echo esc_attr( $p['price_old'] ); ?>"
             data-discount="<?php echo esc_attr( $p['discount_pct'] ); ?>"
             data-storage="<?php echo esc_attr( $p['capacity'] ); ?>"
             data-os="<?php echo esc_attr( $p['os'] ); ?>"
             data-demands="<?php echo esc_attr( $p['demands'] ); ?>">

          <div>
            <!-- Thumbnail Box with Badge -->
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-gray-50/80 rounded-xl mb-3 overflow-hidden">
              <?php if ( $p['discount_pct'] > 0 ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded-md bg-primary text-white text-[10px] sm:text-[11px] font-black shadow-xs">
                  -<?php echo esc_html( $p['discount_pct'] ); ?>%
                </span>
              <?php elseif ( $p['is_new'] ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded-md bg-blue-600 text-white text-[10px] sm:text-[11px] font-black shadow-xs">
                  Mẫu Mới
                </span>
              <?php endif; ?>

              <span class="absolute top-2 right-2 z-10 px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px] font-bold">
                Trả góp 0%
              </span>

              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="w-full h-full flex items-center justify-center">
                <img class="w-full h-full object-contain group-hover:scale-108 transition-transform duration-300"
                     alt="<?php echo esc_attr( $p['name'] ); ?>"
                     src="<?php echo esc_url( $p['image'] ); ?>"
                     loading="lazy" />
              </a>
            </div>

            <!-- Specs tag -->
            <?php if ( ! empty( $p['specs'] ) ) : ?>
              <div class="mb-1.5 flex items-center gap-1 overflow-hidden">
                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-[10px] font-medium truncate max-w-full">
                  <?php echo esc_html( $p['specs'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 class="text-[13px] sm:text-[14px] leading-snug font-bold text-gray-900 line-clamp-2 min-h-[38px] group-hover:text-primary transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="hover:text-primary transition-colors">
                <?php echo esc_html( $p['name'] ); ?>
              </a>
            </h3>

            <!-- Storage pill -->
            <?php if ( ! empty( $p['capacity'] ) ) : ?>
              <div class="mt-1.5 flex items-center gap-1">
                <span class="px-1.5 py-0.5 rounded border border-gray-200 text-gray-600 text-[10px] font-bold">
                  <?php echo esc_html( $p['capacity'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Price Display -->
            <div class="mt-2.5">
              <div class="text-[16px] sm:text-[18px] font-black text-primary leading-tight">
                <?php echo number_format( $p['price'], 0, ',', '.' ); ?>₫
              </div>
              <?php if ( $p['price_old'] > $p['price'] ) : ?>
                <div class="text-[11px] sm:text-[12px] text-gray-400 line-through">
                  <?php echo number_format( $p['price_old'], 0, ',', '.' ); ?>₫
                </div>
              <?php endif; ?>
            </div>

            <!-- Star rating & Reviews -->
            <div class="mt-2 flex items-center gap-1 text-[11px] text-amber-500 font-bold">
              <span>★</span>
              <span>5.0</span>
              <span class="text-gray-400 font-normal">(<?php echo esc_html( $p['reviews'] ); ?>)</span>
            </div>
          </div>

          <!-- Bottom Button -->
          <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="mt-3 w-full h-8.5 rounded-xl bg-red-50 hover:bg-primary text-primary hover:text-white text-xs font-bold transition-all flex items-center justify-center gap-1 shadow-2xs">
            Xem Chi Tiết
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div id="no-products-msg" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-200 space-y-3">
      <span class="material-symbols-outlined text-[48px] text-gray-300">search_off</span>
      <h3 class="text-base font-bold text-gray-800">Không tìm thấy điện thoại nào phù hợp</h3>
      <p class="text-xs text-gray-500 max-w-md mx-auto">
        Hãy thử thay đổi hoặc xóa các tiêu chí bộ lọc để xem thêm các mẫu điện thoại khác.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-5 py-2 rounded-xl bg-primary text-white text-xs font-bold cursor-pointer">
        Xóa Tất Cả Bộ Lọc
      </button>
    </div>

    <!-- ================= 7. BUYING GUIDE & ACCORDION (TGDD Style SEO Content) ================= -->
    <div class="bg-white rounded-2xl p-6 shadow-2xs border border-gray-100 space-y-4 mt-8">
      <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">menu_book</span>
        Cẩm Nang &amp; Tiêu Chí Chọn Mua Điện Thoại Thông Minh Tại PhoneX
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs leading-relaxed text-gray-600">
        <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
          <h3 class="font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-blue-600 text-[18px]">verified</span> 1. Chọn theo Hệ điều hành
          </h3>
          <p>
            <strong>iOS (iPhone):</strong> Ổn định, mượt mà lâu dài, bảo mật cao và đồng bộ hoàn hảo trong hệ sinh thái Apple.<br/>
            <strong>Android:</strong> Đa dạng mẫu mã (Samsung, Xiaomi, OPPO), nhiều tính năng mới lạ như màn hình gập, sạc siêu tốc.
          </p>
        </div>

        <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
          <h3 class="font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-amber-600 text-[18px]">memory</span> 2. Chọn Dung lượng lưu trữ
          </h3>
          <p>
            <strong>128GB:</strong> Phù hợp nhu cầu cơ bản, chụp ảnh vừa phải và ứng dụng hàng ngày.<br/>
            <strong>256GB - 512GB:</strong> Tiêu chuẩn lý tưởng cho người dùng quay video 4K, lưu trữ nhiều game nặng và dữ liệu công việc.
          </p>
        </div>

        <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
          <h3 class="font-bold text-gray-900 mb-1.5 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-emerald-600 text-[18px]">shield</span> 3. Quyền lợi tại PhoneX
          </h3>
          <p>
            100% điện thoại chính hãng VN/A, nguyên seal mới 100%. Bảo hành 12 tháng chính hãng toàn quốc, lỗi 1 đổi 1 trong 30 ngày đầu, giao hỏa tốc 1 giờ.
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
  const osSelect = document.getElementById('filter-os');
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
        b.classList.remove('active', 'border-primary', 'bg-primary', 'text-white');
        b.classList.add('border-gray-200', 'bg-white', 'text-gray-700');
        const countBadge = b.querySelector('span:last-child');
        if (countBadge) {
          countBadge.className = 'px-1.5 py-0.2 rounded-full bg-gray-100 text-gray-600 text-[10px]';
        }
      });

      this.classList.add('active', 'border-primary', 'bg-primary', 'text-white');
      this.classList.remove('border-gray-200', 'bg-white', 'text-gray-700');
      const activeBadge = this.querySelector('span:last-child');
      if (activeBadge) {
        activeBadge.className = 'px-1.5 py-0.2 rounded-full bg-white/20 text-white text-[10px]';
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
        this.classList.remove('border-primary', 'bg-red-50', 'text-primary', 'font-bold');
        this.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
      } else {
        document.querySelectorAll('.demand-btn').forEach(b => {
          b.classList.remove('border-primary', 'bg-red-50', 'text-primary', 'font-bold');
          b.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
        });
        activeDemand = demand;
        this.classList.add('border-primary', 'bg-red-50', 'text-primary', 'font-bold');
        this.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
      }
      applyFilters();
    });
  });

  // Select changes
  priceSelect.addEventListener('change', applyFilters);
  storageSelect.addEventListener('change', applyFilters);
  osSelect.addEventListener('change', applyFilters);
  sortSelect.addEventListener('change', applyFilters);

  if (resetBtn) {
    resetBtn.addEventListener('click', resetAllFilters);
  }

  window.resetAllFilters = function() {
    activeBrand = 'all';
    activeDemand = '';
    priceSelect.value = 'all';
    storageSelect.value = 'all';
    osSelect.value = 'all';
    sortSelect.value = 'default';

    document.querySelectorAll('.brand-btn').forEach(b => {
      b.classList.remove('active', 'border-primary', 'bg-primary', 'text-white');
      b.classList.add('border-gray-200', 'bg-white', 'text-gray-700');
      const countBadge = b.querySelector('span:last-child');
      if (countBadge) {
        countBadge.className = 'px-1.5 py-0.2 rounded-full bg-gray-100 text-gray-600 text-[10px]';
      }
      if (b.getAttribute('data-brand') === 'all') {
        b.classList.add('active', 'border-primary', 'bg-primary', 'text-white');
        b.classList.remove('border-gray-200', 'bg-white', 'text-gray-700');
        const activeBadge = b.querySelector('span:last-child');
        if (activeBadge) activeBadge.className = 'px-1.5 py-0.2 rounded-full bg-white/20 text-white text-[10px]';
      }
    });

    document.querySelectorAll('.demand-btn').forEach(b => {
      b.classList.remove('border-primary', 'bg-red-50', 'text-primary', 'font-bold');
      b.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
    });

    applyFilters();
  };

  function applyFilters() {
    const priceVal = priceSelect.value;
    const storageVal = storageSelect.value;
    const osVal = osSelect.value;
    const sortVal = sortSelect.value;

    let visibleItems = [];

    items.forEach(item => {
      const b = item.dataset.brand;
      const p = parseFloat(item.dataset.price) || 0;
      const s = item.dataset.storage || '';
      const os = item.dataset.os;
      const demands = (item.dataset.demands || '').split(',');

      let pass = true;

      // Brand
      if (activeBrand !== 'all' && b !== activeBrand) {
        pass = false;
      }

      // Demand
      if (pass && activeDemand && !demands.includes(activeDemand)) {
        pass = false;
      }

      // Price
      if (pass && priceVal !== 'all') {
        if (priceVal === 'under-10m' && p >= 10000000) pass = false;
        else if (priceVal === '10m-20m' && (p < 10000000 || p >= 20000000)) pass = false;
        else if (priceVal === '20m-35m' && (p < 20000000 || p >= 35000000)) pass = false;
        else if (priceVal === 'over-35m' && p < 35000000) pass = false;
      }

      // Storage
      if (pass && storageVal !== 'all' && s !== storageVal) {
        pass = false;
      }

      // OS
      if (pass && osVal !== 'all' && os !== osVal) {
        pass = false;
      }

      if (pass) {
        item.style.display = '';
        visibleItems.push(item);
      } else {
        item.style.display = 'none';
      }
    });

    // Sắp xếp
    if (sortVal === 'price-asc') {
      visibleItems.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    } else if (sortVal === 'price-desc') {
      visibleItems.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
    } else if (sortVal === 'discount-desc') {
      visibleItems.sort((a, b) => parseFloat(b.dataset.discount) - parseFloat(a.dataset.discount));
    }

    // Re-append sorted
    visibleItems.forEach(item => grid.appendChild(item));

    // Update Counter & Empty state
    resultsCount.textContent = visibleItems.length;
    if (visibleItems.length === 0) {
      grid.classList.add('hidden');
      noProductsMsg.classList.remove('hidden');
    } else {
      grid.classList.remove('hidden');
      noProductsMsg.classList.add('hidden');
    }

    // Reset button visibility
    const isFiltered = (activeBrand !== 'all' || activeDemand !== '' || priceVal !== 'all' || storageVal !== 'all' || osVal !== 'all' || sortVal !== 'default');
    if (resetBtn) {
      if (isFiltered) resetBtn.classList.remove('hidden');
      else resetBtn.classList.add('hidden');
    }
  }

  // Read URL search params on load (e.g. ?brand=apple or ?demand=gaming)
  const urlParams = new URLSearchParams(window.location.search);
  const paramBrand = urlParams.get('brand');
  const paramDemand = urlParams.get('demand');
  if (paramBrand) {
    document.querySelectorAll('.brand-btn').forEach(btn => {
      const b = (btn.getAttribute('data-brand') || '').toLowerCase();
      if (b === paramBrand.toLowerCase() || b.includes(paramBrand.toLowerCase())) {
        btn.click();
      }
    });
  }
  if (paramDemand) {
    document.querySelectorAll('.demand-btn').forEach(btn => {
      if (btn.getAttribute('data-demand') === paramDemand) {
        btn.click();
      }
    });
  }

})();
</script>

<?php get_footer(); ?>
