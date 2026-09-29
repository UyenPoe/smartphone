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

<div class="bg-[#F6F7F9] min-h-screen pb-16 text-[#1F1F1F] font-sans">

  <!-- ================= BREADCRUMB ================= -->
  <div class="border-b border-[#E5E7EB] bg-white">
    <div class="max-w-[1240px] mx-auto px-4 py-3 flex items-center gap-2 text-sm text-[#6B7280]">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#FF001F] transition-colors flex items-center gap-1 font-medium">
        <span class="material-symbols-outlined text-[18px]">home</span> Trang chủ
      </a>
      <span class="text-[#E5E7EB]">/</span>
      <span class="font-bold text-[#1F1F1F]">Điện thoại</span>
    </div>
  </div>

  <div class="max-w-[1240px] mx-auto px-4 pt-4 sm:pt-6 space-y-5">

    <!-- ================= 1. PROMOTION HERO BANNER (TGDD Style with PhoneX Palette) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
      <!-- Main Featured Banner -->
      <div class="md:col-span-2 relative rounded-2xl overflow-hidden shadow-sm bg-gradient-to-r from-[#FF001F] via-[#D9001B] to-[#D9001B] text-white p-6 sm:p-8 flex flex-col justify-between min-h-[220px]">
        <div class="relative z-10 max-w-[480px]">
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs sm:text-sm font-bold text-[#FF9800] mb-2.5">
            <span class="material-symbols-outlined text-[18px]">local_fire_department</span> ĐẠI TIỆC SMARTPHONE 2026
          </span>
          <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
            ĐIỆN THOẠI CHÍNH HÃNG<br/>GIẢM SỐC ĐẾN 35%
          </h1>
          <p class="text-xs sm:text-sm text-[#FFF0F2] mt-2.5 line-clamp-2 leading-relaxed">
            Thu cũ đổi mới trợ giá 3 triệu &bull; Trả góp 0% lãi suất &bull; Bảo hành 12 tháng 1 đổi 1 trong 30 ngày.
          </p>
        </div>
        <div class="relative z-10 mt-5 flex items-center gap-4 flex-wrap">
          <a href="#phone-catalog" class="px-6 py-3 rounded-xl bg-[#FF9800] hover:bg-[#e68900] text-white font-black text-xs sm:text-sm transition-all shadow-md inline-flex items-center gap-1.5 cursor-pointer">
            Săn Deal Ngay <span class="material-symbols-outlined text-[20px]">arrow_downward</span>
          </a>
          <span class="text-xs sm:text-sm text-[#FFF0F2] font-semibold">Cam kết giá rẻ nhất thị trường</span>
        </div>
        <!-- Decorative graphic elements -->
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-6 hidden sm:block opacity-20">
          <span class="material-symbols-outlined text-[130px]">smartphone</span>
        </div>
      </div>

      <!-- Right Sub-Banners -->
      <div class="flex flex-col gap-3">
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#D9001B] to-[#FF001F] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#FFF0F2] tracking-wider">Hệ Sinh Thái Apple</div>
            <div class="text-base sm:text-lg font-black mt-0.5">iPhone 17 | 18 Pro Max</div>
            <div class="text-xs sm:text-sm text-[#FFF0F2]/90 mt-1">Sẵn hàng VN/A &bull; Giao hỏa tốc 1H</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#FFF0F2] shrink-0">verified</span>
        </div>
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#1F1F1F] to-[#D9001B] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#FF9800] tracking-wider">Trợ Giá Lên Đời</div>
            <div class="text-base sm:text-lg font-black mt-0.5">Thu Cũ Giá Cao Nhất</div>
            <div class="text-xs sm:text-sm text-[#FFF0F2]/90 mt-1">Trợ giá thêm đến 3.000.000₫</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#FF9800] shrink-0">sync_alt</span>
        </div>
      </div>
    </div>

    <!-- ================= 2. BRAND LOGOS & QUICK PILLS (TGDD Brand Slider) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB]" id="phone-catalog">
      <div class="flex items-center justify-between mb-3.5">
        <h2 class="text-base sm:text-lg font-black text-[#1F1F1F] uppercase tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-[#FF001F] text-[22px]">apps</span>
          Chọn Thương Hiệu Điện Thoại
        </h2>
        <span class="text-xs sm:text-sm text-[#6B7280] font-medium">Hiện có <?php echo count( $all_brands ); ?> hãng hàng đầu</span>
      </div>

      <div class="flex items-center gap-2.5 overflow-x-auto pb-1 scrollbar-none" id="brand-selector-list">
        <!-- Button: Tất cả -->
        <button type="button" class="brand-btn active shrink-0 px-4 sm:px-5 py-2.5 rounded-xl border border-[#FF001F] bg-[#FF001F] text-white text-[13px] sm:text-[14px] font-bold transition-all shadow-xs flex items-center gap-2 cursor-pointer" data-brand="all">
          <span>Tất cả</span>
          <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px]"><?php echo count( $phones_list ); ?></span>
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
          <button type="button" class="brand-btn shrink-0 px-4 sm:px-4.5 py-2.5 rounded-xl border border-[#E5E7EB] hover:border-[#FF001F] bg-white hover:bg-[#FFF0F2]/30 text-[#1F1F1F] hover:text-[#FF001F] text-[13px] sm:text-[14px] font-bold transition-all shadow-2xs flex items-center gap-2 cursor-pointer" data-brand="<?php echo esc_attr( $b ); ?>">
            <span><?php echo esc_html( $b ); ?></span>
            <span class="px-2 py-0.5 rounded-full bg-[#F6F7F9] text-[#6B7280] text-[11px]"><?php echo $b_count; ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 3. QUICK DEMANDS (Nhu cầu tìm kiếm - TGDD Style) ================= -->
    <div class="flex items-center gap-2.5 overflow-x-auto pb-1 text-xs sm:text-sm font-bold scrollbar-none" id="demand-selector-list">
      <span class="text-[#6B7280] shrink-0 font-extrabold text-xs uppercase mr-1">Nhu cầu:</span>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#FF001F] hover:text-[#FF001F] transition-all text-[#1F1F1F] cursor-pointer" data-demand="gaming">
        🎮 Chơi game / Cấu hình cao
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#FF001F] hover:text-[#FF001F] transition-all text-[#1F1F1F] cursor-pointer" data-demand="camera">
        📸 Chụp ảnh, quay phim đẹp
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#FF001F] hover:text-[#FF001F] transition-all text-[#1F1F1F] cursor-pointer" data-demand="foldable">
        📱 Màn hình gập cao cấp
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#FF001F] hover:text-[#FF001F] transition-all text-[#1F1F1F] cursor-pointer" data-demand="battery">
        🔋 Pin trâu dùng cả ngày
      </button>
      <button type="button" class="demand-btn shrink-0 px-3.5 py-2 rounded-full border border-[#E5E7EB] bg-white hover:border-[#FF001F] hover:text-[#FF001F] transition-all text-[#1F1F1F] cursor-pointer" data-demand="budget">
        💰 Giá rẻ học sinh, sinh viên
      </button>
    </div>

    <!-- ================= 4. COMPREHENSIVE FILTER BOX (Bộ lọc đa tiêu chí) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB] space-y-4">
      <div class="flex items-center justify-between border-b border-[#E5E7EB] pb-3">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[#FF001F] text-[22px]">tune</span>
          <span class="font-black text-[#1F1F1F] text-sm sm:text-base">Bộ Lọc Tìm Kiếm Chi Tiết</span>
        </div>
        <button type="button" id="btn-reset-filters" class="text-xs sm:text-sm text-[#FF001F] font-bold hover:underline hidden flex items-center gap-1 cursor-pointer">
          <span class="material-symbols-outlined text-[16px]">refresh</span> Xóa tất cả bộ lọc
        </button>
      </div>

      <!-- Filter Controls Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3.5 text-xs sm:text-sm">
        
        <!-- Price Range Filter -->
        <div>
          <label class="block font-bold text-[#1F1F1F] mb-1.5">Mức Giá:</label>
          <select id="filter-price" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#F6F7F9] text-[#1F1F1F] focus:bg-white focus:border-[#FF001F] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả mức giá</option>
            <option value="under-10m">Dưới 10 triệu</option>
            <option value="10m-20m">Từ 10 - 20 triệu</option>
            <option value="20m-35m">Từ 20 - 35 triệu</option>
            <option value="over-35m">Flagship trên 35 triệu</option>
          </select>
        </div>

        <!-- Storage Filter -->
        <div>
          <label class="block font-bold text-[#1F1F1F] mb-1.5">Dung Lượng Bộ Nhớ:</label>
          <select id="filter-storage" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#F6F7F9] text-[#1F1F1F] focus:bg-white focus:border-[#FF001F] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả dung lượng</option>
            <option value="128GB">128 GB</option>
            <option value="256GB">256 GB</option>
            <option value="512GB">512 GB</option>
            <option value="1TB">1 TB</option>
          </select>
        </div>

        <!-- OS Filter -->
        <div>
          <label class="block font-bold text-[#1F1F1F] mb-1.5">Hệ Điều Hành:</label>
          <select id="filter-os" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#F6F7F9] text-[#1F1F1F] focus:bg-white focus:border-[#FF001F] outline-hidden transition-all text-xs sm:text-sm">
            <option value="all">Tất cả hệ điều hành</option>
            <option value="ios">iOS (Apple iPhone)</option>
            <option value="android">Android (Samsung, Xiaomi, OPPO...)</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div>
          <label class="block font-bold text-[#1F1F1F] mb-1.5">Sắp Xếp Theo:</label>
          <select id="filter-sort" class="w-full h-10 rounded-xl border border-[#E5E7EB] px-3 font-semibold bg-[#F6F7F9] text-[#1F1F1F] focus:bg-white focus:border-[#FF001F] outline-hidden transition-all text-xs sm:text-sm">
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
      <div class="text-sm sm:text-base font-extrabold text-[#1F1F1F]">
        Tìm thấy <span id="results-count" class="text-[#FF001F] font-black"><?php echo count( $phones_list ); ?></span> điện thoại chính hãng
      </div>
      <div class="flex items-center gap-1.5 text-xs sm:text-sm text-[#6B7280] font-medium">
        <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#198754]"></span>
        Sẵn hàng toàn quốc &bull; Trả góp 0%
      </div>
    </div>

    <!-- ================= 6. PRODUCT GRID (TGDD Style Grid) ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4.5" id="phones-grid">
      <?php foreach ( $phones_list as $p ) : ?>
        <div class="phone-item bg-white rounded-2xl p-3 sm:p-4 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-[#E5E7EB] hover:border-[#FF001F] relative hover:-translate-y-1 duration-200"
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
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-[#F6F7F9] rounded-xl mb-3 overflow-hidden">
              <?php if ( $p['discount_pct'] > 0 ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2.5 py-0.5 rounded-md bg-[#FF001F] text-white text-[11px] sm:text-[12px] font-black shadow-xs">
                  -<?php echo esc_html( $p['discount_pct'] ); ?>%
                </span>
              <?php elseif ( $p['is_new'] ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2.5 py-0.5 rounded-md bg-[#FF001F] text-white text-[11px] sm:text-[12px] font-black shadow-xs">
                  Mẫu Mới
                </span>
              <?php endif; ?>

              <span class="absolute top-2 right-2 z-10 px-2 py-0.5 rounded bg-white text-[#6B7280] border border-[#E5E7EB] text-[11px] font-bold">
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
                <span class="px-2 py-0.5 rounded bg-[#F6F7F9] text-[#6B7280] border border-[#E5E7EB] text-[11px] sm:text-[12px] font-medium truncate max-w-full">
                  <?php echo esc_html( $p['specs'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 class="text-[14px] sm:text-[16px] leading-snug font-extrabold text-[#1F1F1F] line-clamp-2 min-h-[42px] group-hover:text-[#FF001F] transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="hover:text-[#FF001F] transition-colors">
                <?php echo esc_html( $p['name'] ); ?>
              </a>
            </h3>

            <!-- Storage pill -->
            <?php if ( ! empty( $p['capacity'] ) ) : ?>
              <div class="mt-2 flex items-center gap-1">
                <span class="px-2 py-0.5 rounded border border-[#E5E7EB] text-[#1F1F1F] text-[11px] sm:text-[12px] font-bold bg-[#F6F7F9]">
                  <?php echo esc_html( $p['capacity'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Price Display -->
            <div class="mt-2.5">
              <div class="text-[17px] sm:text-[19px] font-black text-[#FF001F] leading-tight">
                <?php echo number_format( $p['price'], 0, ',', '.' ); ?>₫
              </div>
              <?php if ( $p['price_old'] > $p['price'] ) : ?>
                <div class="text-[12px] sm:text-[13px] text-[#6B7280] line-through font-medium">
                  <?php echo number_format( $p['price_old'], 0, ',', '.' ); ?>₫
                </div>
              <?php endif; ?>
            </div>

            <!-- Star rating & Reviews -->
            <div class="mt-2 flex items-center gap-1 text-[12px] sm:text-[13px] text-[#FF9800] font-bold">
              <span>★</span>
              <span>5.0</span>
              <span class="text-[#6B7280] font-normal">(<?php echo esc_html( $p['reviews'] ); ?>)</span>
            </div>
          </div>

          <!-- Bottom Button -->
          <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="mt-3.5 w-full h-9 sm:h-10 rounded-xl bg-[#FFF0F2] hover:bg-[#FF001F] text-[#FF001F] hover:text-white text-xs sm:text-sm font-extrabold transition-all flex items-center justify-center gap-1 shadow-2xs">
            Xem Chi Tiết
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Centered "Xem thêm X Điện thoại" Button (As in Screenshot) -->
    <div class="flex justify-center pt-3 pb-2">
      <button type="button" id="btn-load-more-phones" onclick="window.scrollTo({top: document.getElementById('phones-grid').offsetTop - 80, behavior: 'smooth'})" class="inline-flex items-center justify-center gap-1.5 px-8 py-3 rounded-xl border border-[#FF001F] bg-white hover:bg-[#FFF0F2] text-[#FF001F] font-bold text-sm sm:text-base shadow-2xs transition-all cursor-pointer">
        <span>Xem thêm <span id="load-more-counter"><?php echo count( $phones_list ); ?></span> Điện thoại</span>
        <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
      </button>
    </div>

    <!-- Centered Satisfaction Feedback Box (TGDD Yellow Border Box as in Screenshot) -->
    <div class="max-w-[540px] mx-auto my-5 p-3.5 sm:p-4 rounded-xl bg-white border border-[#fcd34d] shadow-2xs flex items-center justify-between gap-4">
      <span class="text-xs sm:text-sm font-semibold text-[#1F1F1F] leading-snug">
        Bạn có hài lòng với trải nghiệm tìm kiếm thông tin, sản phẩm trên website không?
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
      <span class="material-symbols-outlined text-[48px] text-[#6B7280]">search_off</span>
      <h3 class="text-base sm:text-lg font-bold text-[#1F1F1F]">Không tìm thấy điện thoại nào phù hợp</h3>
      <p class="text-xs sm:text-sm text-[#6B7280] max-w-md mx-auto">
        Hãy thử thay đổi hoặc xóa các tiêu chí bộ lọc để xem thêm các mẫu điện thoại khác.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-5 py-2.5 rounded-xl bg-[#FF001F] hover:bg-[#D9001B] text-white text-xs sm:text-sm font-bold cursor-pointer shadow-xs transition-colors">
        Xóa Tất Cả Bộ Lọc
      </button>
    </div>

    <!-- ================= 8. THÔNG TIN NGÀNH HÀNG (LẤY TỪ QUẢN TRỊ DANH MỤC SẢN PHẨM - Directly below survey box as in TGDD) ================= -->
    <?php
    $cat_seo_term_id = 0;
    if ( is_tax( 'product_cat' ) ) {
      $cat_seo_term_id = get_queried_object_id();
    } else {
      $cat_seo_obj = get_term_by( 'slug', 'dien-thoai', 'product_cat' );
      $cat_seo_term_id = ( $cat_seo_obj && ! is_wp_error( $cat_seo_obj ) ) ? $cat_seo_obj->term_id : 77;
    }
    if ( function_exists( 'phonex_render_category_seo_frontend' ) ) {
      phonex_render_category_seo_frontend( $cat_seo_term_id );
    }
    ?>

    <!-- ================= 7. BUYING GUIDE & ACCORDION (TGDD Style SEO Content - Centered Reading Column) ================= -->
    <div class="max-w-[820px] mx-auto bg-white rounded-2xl p-6 sm:p-8 shadow-2xs border border-[#E5E7EB] space-y-4 mt-8">
      <h2 class="text-base sm:text-lg font-black text-[#1F1F1F] border-b border-[#E5E7EB] pb-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-[#FF001F] text-[22px]">menu_book</span>
        Cẩm Nang &amp; Tiêu Chí Chọn Mua Điện Thoại Thông Minh Tại PhoneX
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm leading-relaxed text-[#6B7280]">
        <div class="p-4 rounded-xl bg-[#F6F7F9] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#1F1F1F] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#FF001F] text-[20px]">verified</span> 1. Chọn theo Hệ điều hành
          </h3>
          <p>
            <strong class="text-[#1F1F1F]">iOS (iPhone):</strong> Ổn định, mượt mà lâu dài, bảo mật cao và đồng bộ hoàn hảo trong hệ sinh thái Apple.<br/>
            <strong class="text-[#1F1F1F]">Android:</strong> Đa dạng mẫu mã (Samsung, Xiaomi, OPPO), nhiều tính năng mới lạ như màn hình gập, sạc siêu tốc.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#F6F7F9] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#1F1F1F] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#FF9800] text-[20px]">memory</span> 2. Chọn Dung lượng lưu trữ
          </h3>
          <p>
            <strong class="text-[#1F1F1F]">128GB:</strong> Phù hợp nhu cầu cơ bản, chụp ảnh vừa phải và ứng dụng hàng ngày.<br/>
            <strong class="text-[#1F1F1F]">256GB - 512GB:</strong> Tiêu chuẩn lý tưởng cho người dùng quay video 4K, lưu trữ nhiều game nặng và dữ liệu công việc.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#F6F7F9] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#1F1F1F] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#198754] text-[20px]">shield</span> 3. Quyền lợi tại PhoneX
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
        b.classList.remove('active', 'border-[#FF001F]', 'bg-[#FF001F]', 'text-white');
        b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
        const countBadge = b.querySelector('span:last-child');
        if (countBadge) {
          countBadge.className = 'px-2 py-0.5 rounded-full bg-[#F6F7F9] text-[#6B7280] text-[11px]';
        }
      });

      this.classList.add('active', 'border-[#FF001F]', 'bg-[#FF001F]', 'text-white');
      this.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
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
        this.classList.remove('border-[#FF001F]', 'bg-[#FFF0F2]', 'text-[#FF001F]', 'font-bold');
        this.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
      } else {
        document.querySelectorAll('.demand-btn').forEach(b => {
          b.classList.remove('border-[#FF001F]', 'bg-[#FFF0F2]', 'text-[#FF001F]', 'font-bold');
          b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
        });
        activeDemand = demand;
        this.classList.add('border-[#FF001F]', 'bg-[#FFF0F2]', 'text-[#FF001F]', 'font-bold');
        this.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
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
      b.classList.remove('active', 'border-[#FF001F]', 'bg-[#FF001F]', 'text-white');
      b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
      const countBadge = b.querySelector('span:last-child');
      if (countBadge) {
        countBadge.className = 'px-2 py-0.5 rounded-full bg-[#F6F7F9] text-[#6B7280] text-[11px]';
      }
      if (b.getAttribute('data-brand') === 'all') {
        b.classList.add('active', 'border-[#FF001F]', 'bg-[#FF001F]', 'text-white');
        b.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
        const activeBadge = b.querySelector('span:last-child');
        if (activeBadge) activeBadge.className = 'px-2 py-0.5 rounded-full bg-white/20 text-white text-[11px]';
      }
    });

    document.querySelectorAll('.demand-btn').forEach(b => {
      b.classList.remove('border-[#FF001F]', 'bg-[#FFF0F2]', 'text-[#FF001F]', 'font-bold');
      b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#1F1F1F]');
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
