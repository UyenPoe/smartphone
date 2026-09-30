<?php
/**
 * Template Name: PhoneX Danh Mục Phụ Kiện (TGDD Style - Loa, Micro, Tai nghe, Sạc cáp...)
 *
 * Dedicated Accessories Catalog Page modeled after thegioididong.com/phu-kien
 * Uses Google Stitch Design Tokens (#b7000c primary, #e60012 container, #ffdad5 fixed)
 * Seamlessly handles all subcategories: Loa, Micro, Tai nghe, Sạc dự phòng, Sạc cáp, Camera, v.v.
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. DETERMINE CURRENT CATEGORY CONTEXT (phu-kien, loa, micro, etc.)
// =========================================================================
$current_term = null;
$current_slug = 'phu-kien';
$current_name = 'Phụ Kiện';

if ( is_tax( 'product_cat' ) ) {
	$current_term = get_queried_object();
	if ( $current_term && ! is_wp_error( $current_term ) ) {
		$current_slug = $current_term->slug;
		$current_name = $current_term->name;
	}
} elseif ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
	$param_slug = sanitize_text_field( wp_unslash( $_GET['category'] ) );
	$found_term = get_term_by( 'slug', $param_slug, 'product_cat' );
	if ( $found_term && ! is_wp_error( $found_term ) ) {
		$current_term = $found_term;
		$current_slug = $found_term->slug;
		$current_name = $found_term->name;
	}
}

// Subcategory definitions for navigation pills (matching TGDD & PhoneX)
$subcategories = array(
	'loa' => array(
		'name'  => 'Loa',
		'slug'  => 'loa',
		'icon'  => 'loa.png',
		'badge' => 'Hot',
	),
	'micro' => array(
		'name'  => 'Micro',
		'slug'  => 'micro',
		'icon'  => 'micro.png',
		'badge' => 'Mới',
	),
	'tai-nghe-bluetooth' => array(
		'name'  => 'Tai nghe',
		'slug'  => 'tai-nghe-bluetooth',
		'icon'  => 'tai-nghe-bluetooth.png',
		'badge' => 'Hot',
	),
	'sac-du-phong' => array(
		'name'  => 'Sạc dự phòng',
		'slug'  => 'sac-du-phong',
		'icon'  => 'sac-du-phong.png',
	),
	'sac-cap' => array(
		'name'  => 'Sạc, cáp',
		'slug'  => 'sac-cap',
		'icon'  => 'sac-cap.png',
	),
	'chuot-may-tinh' => array(
		'name'  => 'Chuột máy tính',
		'slug'  => 'chuot-may-tinh',
		'icon'  => 'chuot-may-tinh.png',
	),
	'ban-phim' => array(
		'name'  => 'Bàn phím',
		'slug'  => 'ban-phim',
		'icon'  => 'ban-phim.png',
	),
	'camera-giam-sat' => array(
		'name'  => 'Camera Giám Sát',
		'slug'  => 'camera-giam-sat',
		'icon'  => 'camera-giam-sat.png',
		'badge' => 'Hot',
	),
	'hub-cap-chuyen-doi' => array(
		'name'  => 'Hub, Cáp chuyển',
		'slug'  => 'hub-cap-chuyen-doi',
		'icon'  => 'hub-cap-chuyen-doi.png',
	),
	'op-lung-dien-thoai' => array(
		'name'  => 'Ốp lưng',
		'slug'  => 'op-lung-dien-thoai',
		'icon'  => 'op-lung-dien-thoai.png',
	),
	'mieng-dan' => array(
		'name'  => 'Miếng dán',
		'slug'  => 'mieng-dan',
		'icon'  => 'mieng-dan.png',
	),
);

// =========================================================================
// 2. QUERY ACCESSORIES PRODUCTS (From DB with Curated Fallback)
// =========================================================================
$query_terms = array();
if ( 'phu-kien' === $current_slug ) {
	$query_terms = array( 'phu-kien', 'loa', 'micro', 'tai-nghe-bluetooth', 'sac-cap', 'sac-du-phong', 'camera-giam-sat', 'chuot-may-tinh', 'ban-phim', 'thiet-bi-nghe-nhin-luu-tru', 'phu-kien-di-dong', 'phu-kien-laptop-pc' );
} else {
	$query_terms = array( $current_slug );
	// If subcategory has children or synonyms
	if ( 'loa' === $current_slug ) {
		$query_terms[] = 'loa-laptop';
		$query_terms[] = 'loa-bluetooth';
	} elseif ( 'micro' === $current_slug ) {
		$query_terms[] = 'micro-thu-am';
		$query_terms[] = 'micro-karaoke';
	}
}

$args = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $query_terms,
			'operator' => 'IN',
		),
	),
);

$query = new WP_Query( $args );

// Fallback: If no products found via taxonomy and we are in phu-kien, query all accessories
if ( ! $query->have_posts() && 'phu-kien' === $current_slug ) {
	$args['tax_query'] = array();
	$query             = new WP_Query( $args );
}

$products_list = array();
$all_brands    = array();

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
			$title = get_the_title();
			if ( stripos( $title, 'JBL' ) !== false ) {
				$brand = 'JBL';
			} elseif ( stripos( $title, 'Marshall' ) !== false ) {
				$brand = 'Marshall';
			} elseif ( stripos( $title, 'Sony' ) !== false ) {
				$brand = 'Sony';
			} elseif ( stripos( $title, 'Boya' ) !== false ) {
				$brand = 'BOYA';
			} elseif ( stripos( $title, 'Rode' ) !== false ) {
				$brand = 'Rode';
			} elseif ( stripos( $title, 'Shure' ) !== false ) {
				$brand = 'Shure';
			} elseif ( stripos( $title, 'DJI' ) !== false ) {
				$brand = 'DJI';
			} elseif ( stripos( $title, 'Anker' ) !== false ) {
				$brand = 'Anker';
			} elseif ( stripos( $title, 'Ugreen' ) !== false ) {
				$brand = 'Ugreen';
			} elseif ( stripos( $title, 'Baseus' ) !== false ) {
				$brand = 'Baseus';
			} elseif ( stripos( $title, 'Logitech' ) !== false ) {
				$brand = 'Logitech';
			} elseif ( stripos( $title, 'Apple' ) !== false || stripos( $title, 'AirPods' ) !== false ) {
				$brand = 'Apple';
			} elseif ( stripos( $title, 'Xiaomi' ) !== false ) {
				$brand = 'Xiaomi';
			} elseif ( stripos( $title, 'Ezviz' ) !== false ) {
				$brand = 'EZVIZ';
			} else {
				$brand = 'Chính hãng';
			}
		}

		$brand_clean = trim( $brand );
		if ( ! empty( $brand_clean ) && ! in_array( $brand_clean, $all_brands, true ) ) {
			$all_brands[] = $brand_clean;
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
			$display_old   = $price_reg > $display_price ? $price_reg : 0;
			$discount_pct  = $display_old > 0 ? round( ( ( $display_old - $display_price ) / $display_old ) * 100 ) : 0;
		}

		// Image
		$image_url = get_the_post_thumbnail_url( $pid, 'medium' );
		if ( ! $image_url ) {
			$image_url = get_post_meta( $pid, '_crawler_image_url', true );
		}
		if ( ! $image_url ) {
			$image_url = wc_placeholder_img_src();
		}

		// Specs & Type
		$specs = get_post_meta( $pid, '_basic_specs', true );
		if ( empty( $specs ) ) {
			$specs = $product->get_short_description();
		}
		$specs = wp_strip_all_tags( $specs );

		$type = get_post_meta( $pid, '_accessory_type', true );
		if ( empty( $type ) ) {
			$type = $current_name;
		}

		$badge = get_post_meta( $pid, '_accessory_badge', true );

		$products_list[] = array(
			'id'           => $pid,
			'name'         => get_the_title(),
			'permalink'    => get_permalink( $pid ),
			'image'        => $image_url,
			'price'        => $display_price,
			'price_old'    => $display_old,
			'discount_pct' => $discount_pct,
			'brand'        => $brand_clean,
			'specs'        => $specs,
			'type'         => $type,
			'badge'        => $badge,
			'rating'       => '5.0',
			'reviews'      => rand( 18, 260 ),
			'sold'         => rand( 85, 980 ),
		);
	}
	wp_reset_postdata();
}

// Banner headlines and content customization based on active category
$banner_tag = 'ĐẠI TIỆC PHỤ KIỆN 2026';
$banner_title = 'PHỤ KIỆN CÔNG NGHỆ CHÍNH HÃNG<br/>GIẢM SỐC ĐẾN 50%';
$banner_desc = 'Cam kết 100% chính hãng &bull; Bảo hành 12 tháng 1 đổi 1 &bull; Trả góp 0% &bull; Giao nhanh 1H.';

if ( 'loa' === $current_slug ) {
	$banner_tag = 'LOA CHÍNH HÃNG - SIÊU BASS';
	$banner_title = 'LOA BLUETOOTH & KARAOKE<br/>ÂM BASS BÙNG NỔ - GIẢM ĐẾN 40%';
	$banner_desc = 'JBL, Marshall, Sony, Harman Kardon &bull; Bảo hành 12 tháng 1 đổi 1 &bull; Tặng kèm Micro cao cấp &bull; Giao hỏa tốc 1H.';
} elseif ( 'micro' === $current_slug ) {
	$banner_tag = 'MICRO THU ÂM & LIVESTREAM';
	$banner_title = 'MICRO THU ÂM & KARAOKE<br/>CHUẨN PHÒNG THU - GIẢM ĐẾN 35%';
	$banner_desc = 'Boya, Rode, Shure, DJI, JBL &bull; Khử ồn AI thông minh &bull; Sóng UHF ổn định &bull; Chống hú rít tuyệt đối.';
} elseif ( 'tai-nghe-bluetooth' === $current_slug ) {
	$banner_tag = 'TAI NGHE TRUE WIRELESS';
	$banner_title = 'TAI NGHE KHÔNG DÂY CHỐNG ỒN<br/>ÂM THANH HI-RES - GIẢM ĐẾN 45%';
	$banner_desc = 'AirPods, Sony WH-1000XM5, Marshall Major V &bull; Chống ồn chủ động ANC &bull; Pin bền cả tuần.';
}
?>

<div class="bg-[#f8f9fb] min-h-screen pb-16 text-[#222222] font-sans">

  <!-- ================= BREADCRUMB ================= -->
  <div class="border-b border-[#E5E7EB] bg-white">
    <div class="max-w-[1240px] mx-auto px-4 py-3 flex items-center gap-2 text-sm text-[#5f5e5e]">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#e60012] transition-colors flex items-center gap-1 font-medium">
        <span class="material-symbols-outlined text-[18px]">home</span> Trang chủ
      </a>
      <span class="text-[#E5E7EB]">/</span>
      <?php if ( 'phu-kien' === $current_slug ) : ?>
        <span class="font-bold text-[#222222]">Phụ kiện</span>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/product-category/phu-kien/' ) ); ?>" class="hover:text-[#e60012] transition-colors font-medium">
          Phụ kiện
        </a>
        <span class="text-[#E5E7EB]">/</span>
        <span class="font-bold text-[#222222]"><?php echo esc_html( $current_name ); ?></span>
      <?php endif; ?>
    </div>
  </div>

  <div class="max-w-[1240px] mx-auto px-4 pt-4 sm:pt-6 space-y-6">

    <!-- ================= 1. PROMOTION HERO BANNER (TGDD Style with Stitch Palette) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
      <!-- Main Featured Banner -->
      <div class="md:col-span-2 relative rounded-2xl overflow-hidden shadow-sm bg-gradient-to-r from-[#e60012] via-[#b7000c] to-[#b7000c] text-white p-6 sm:p-8 flex flex-col justify-between min-h-[220px]">
        <div class="relative z-10 max-w-[500px]">
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs sm:text-sm font-bold text-[#FF9800] mb-2.5">
            <span class="material-symbols-outlined text-[18px]">local_fire_department</span> <?php echo esc_html( $banner_tag ); ?>
          </span>
          <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
            <?php echo wp_kses_post( $banner_title ); ?>
          </h1>
          <p class="text-xs sm:text-sm text-[#ffdad5] mt-2.5 line-clamp-2 leading-relaxed">
            <?php echo wp_kses_post( $banner_desc ); ?>
          </p>
        </div>
        <div class="relative z-10 mt-5 flex items-center gap-4 flex-wrap">
          <a href="#accessory-catalog" class="px-6 py-3 rounded-xl bg-[#FF9800] hover:bg-[#e68900] text-white font-black text-xs sm:text-sm transition-all shadow-md inline-flex items-center gap-1.5 cursor-pointer">
            Khám Phá Ngay <span class="material-symbols-outlined text-[20px]">arrow_downward</span>
          </a>
          <span class="text-xs sm:text-sm text-[#ffdad5] font-semibold">100% Hàng chính hãng &bull; 1 Đổi 1 12T</span>
        </div>
        <!-- Decorative graphic elements -->
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-6 hidden sm:block opacity-20">
          <span class="material-symbols-outlined text-[130px]">
            <?php echo ( 'loa' === $current_slug ) ? 'speaker' : ( ( 'micro' === $current_slug ) ? 'mic' : 'headphones' ); ?>
          </span>
        </div>
      </div>

      <!-- Right Sub-Banners -->
      <div class="flex flex-col gap-3">
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#b7000c] to-[#e60012] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#ffdad5] tracking-wider">Độc Quyền PhoneX</div>
            <div class="text-base sm:text-lg font-black mt-0.5">Bảo Hành 1 Đổi 1 Trong 12T</div>
            <div class="text-xs sm:text-sm text-[#ffdad5]/90 mt-1">Lỗi phần cứng đổi ngay sản phẩm mới</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#ffdad5] shrink-0">verified</span>
        </div>
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#222222] to-[#b7000c] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-xs font-black uppercase text-[#FF9800] tracking-wider">Giao Nhanh Siêu Tốc</div>
            <div class="text-base sm:text-lg font-black mt-0.5">Giao Hỏa Tốc 1 Giờ</div>
            <div class="text-xs sm:text-sm text-[#ffdad5]/90 mt-1">Đồng kiểm hàng tận nhà rồi mới thanh toán</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#FF9800] shrink-0">local_shipping</span>
        </div>
      </div>
    </div>

    <!-- ================= 2. CATEGORY GROUP SWITCHER (TGDD Style .cate-groupmenu) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB]" id="accessory-catalog">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-base sm:text-lg font-black text-[#222222] uppercase tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[22px]">category</span>
          Danh Mục Phụ Kiện Nổi Bật
        </h2>
        <a href="<?php echo esc_url( home_url( '/product-category/phu-kien/' ) ); ?>" class="text-xs sm:text-sm text-[#e60012] font-bold hover:underline flex items-center gap-0.5">
          <span>Xem tất cả</span> &rarr;
        </a>
      </div>

      <!-- Quick Subcategories Grid with PNG Icons -->
      <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-11 gap-2.5 sm:gap-3">
        <?php foreach ( $subcategories as $sc ) : ?>
          <?php
          $is_active = ( $current_slug === $sc['slug'] );
          $card_link = home_url( '/product-category/' . $sc['slug'] . '/' );
          $icon_url  = get_template_directory_uri() . '/assets/images/categories/accessories/' . $sc['icon'];
          ?>
          <a href="<?php echo esc_url( $card_link ); ?>" class="group flex flex-col items-center text-center p-2 rounded-2xl transition-all relative <?php echo $is_active ? 'bg-[#ffdad5]/50 border-2 border-[#e60012] shadow-xs' : 'bg-[#f8f9fb] hover:bg-[#ffdad5]/30 border border-[#E5E7EB] hover:border-[#e9bcb6]'; ?>">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-white flex items-center justify-center shadow-2xs p-1.5 transition-transform group-hover:scale-105">
              <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( $sc['name'] ); ?>" class="w-9 h-9 sm:w-10 sm:h-10 object-contain" loading="lazy" />
              <?php if ( ! empty( $sc['badge'] ) ) : ?>
                <span class="absolute -top-1.5 -right-1 text-[9.5px] font-extrabold bg-[#e60012] text-white px-1.5 py-0.2 rounded-full shadow-xs">
                  <?php echo esc_html( $sc['badge'] ); ?>
                </span>
              <?php endif; ?>
            </div>
            <span class="mt-2 text-[12px] sm:text-[13px] font-bold <?php echo $is_active ? 'text-[#e60012]' : 'text-[#222222] group-hover:text-[#e60012]'; ?> leading-snug line-clamp-2">
              <?php echo esc_html( $sc['name'] ); ?>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 3. BRAND PILLS FILTER (TGDD Style .top-manu) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-2xs border border-[#E5E7EB]">
      <div class="flex items-center justify-between mb-3.5">
        <h3 class="text-sm sm:text-base font-black text-[#222222] uppercase tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[20px]">verified_user</span>
          Thương Hiệu Hàng Đầu
        </h3>
        <span class="text-xs text-[#5f5e5e] font-medium">Hiện có <?php echo count( $all_brands ); ?> thương hiệu</span>
      </div>

      <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none" id="brand-selector-list">
        <!-- Button: Tất cả -->
        <button type="button" class="brand-btn active shrink-0 px-4 py-2 rounded-xl border border-[#e60012] bg-[#e60012] text-white text-[13px] sm:text-[14px] font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer" data-brand="all">
          <span>Tất cả</span>
          <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px]"><?php echo count( $products_list ); ?></span>
        </button>

        <?php foreach ( $all_brands as $b ) : ?>
          <?php
          $b_count = 0;
          foreach ( $products_list as $pl ) {
			  if ( $pl['brand'] === $b ) {
				  $b_count++;
			  }
		  }
			?>
          <button type="button" class="brand-btn shrink-0 px-3.5 py-2 rounded-xl border border-[#E5E7EB] hover:border-[#e60012] bg-white hover:bg-[#ffdad5]/30 text-[#222222] hover:text-[#e60012] text-[13px] sm:text-[14px] font-bold transition-all shadow-2xs flex items-center gap-1.5 cursor-pointer" data-brand="<?php echo esc_attr( $b ); ?>">
            <span><?php echo esc_html( $b ); ?></span>
            <span class="px-1.5 py-0.5 rounded-full bg-[#f8f9fb] text-[#5f5e5e] text-[11px]"><?php echo $b_count; ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 4. FILTER TOOLBAR & SORTING ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-2xs border border-[#E5E7EB] flex flex-wrap items-center justify-between gap-3">
      <!-- Left Filters -->
      <div class="flex items-center gap-2.5 flex-wrap">
        <span class="font-bold text-[#222222] text-xs sm:text-sm flex items-center gap-1">
          <span class="material-symbols-outlined text-[18px] text-[#e60012]">tune</span> Bộ lọc:
        </span>

        <!-- Filter Mức Giá -->
        <select id="filter-price" class="px-3 py-1.5 rounded-xl border border-[#E5E7EB] bg-[#f8f9fb] text-xs sm:text-sm font-semibold text-[#222222] focus:border-[#e60012] focus:outline-none cursor-pointer">
          <option value="all">Mức giá: Tất cả</option>
          <option value="under-500k">Dưới 500.000₫</option>
          <option value="500k-1m">500.000₫ - 1.000.000₫</option>
          <option value="1m-2m">1.000.000₫ - 2.000.000₫</option>
          <option value="2m-5m">2.000.000₫ - 5.000.000₫</option>
          <option value="over-5m">Trên 5.000.000₫</option>
        </select>

        <!-- Filter Phân Loại -->
        <select id="filter-type" class="px-3 py-1.5 rounded-xl border border-[#E5E7EB] bg-[#f8f9fb] text-xs sm:text-sm font-semibold text-[#222222] focus:border-[#e60012] focus:outline-none cursor-pointer">
          <option value="all">Loại sản phẩm: Tất cả</option>
          <option value="Loa Bluetooth">Loa Bluetooth</option>
          <option value="Loa Karaoke">Loa Karaoke kèm Mic</option>
          <option value="Loa Vi tính">Loa Vi tính</option>
          <option value="Micro Cài Áo">Micro Cài Áo Livestream</option>
          <option value="Micro Không Dây">Micro Không Dây</option>
          <option value="Micro Thu Âm">Micro Thu Âm Podcast</option>
          <option value="Tai nghe">Tai nghe không dây</option>
          <option value="Sạc">Sạc & Cáp nhanh</option>
        </select>

        <!-- Reset Button -->
        <button type="button" id="btn-reset-filters" class="hidden px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700 items-center gap-1 cursor-pointer transition-colors">
          <span class="material-symbols-outlined text-[14px]">refresh</span> Xóa bộ lọc
        </button>
      </div>

      <!-- Right Sorting & Counter -->
      <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
        <div class="text-xs sm:text-sm text-[#5f5e5e] font-medium">
          Tìm thấy <span id="results-count" class="font-bold text-[#e60012]"><?php echo count( $products_list ); ?></span> sản phẩm
        </div>
        <select id="filter-sort" class="px-3 py-1.5 rounded-xl border border-[#E5E7EB] bg-[#f8f9fb] text-xs sm:text-sm font-semibold text-[#222222] focus:border-[#e60012] focus:outline-none cursor-pointer">
          <option value="default">Sắp xếp: Bán chạy nhất</option>
          <option value="price-asc">Giá: Thấp đến Cao</option>
          <option value="price-desc">Giá: Cao đến Thấp</option>
          <option value="discount-desc">% Giảm nhiều nhất</option>
        </select>
      </div>
    </div>

    <!-- ================= 5. PRODUCTS GRID ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-3 sm:gap-4" id="accessory-grid">
      <?php foreach ( $products_list as $item ) : ?>
        <div class="accessory-item bg-white rounded-2xl p-3.5 sm:p-4.5 border border-[#E5E7EB] hover:border-[#e9bcb6] hover:shadow-lg transition-all duration-200 flex flex-col justify-between group relative"
             data-id="<?php echo esc_attr( $item['id'] ); ?>"
             data-brand="<?php echo esc_attr( $item['brand'] ); ?>"
             data-price="<?php echo esc_attr( $item['price'] ); ?>"
             data-discount="<?php echo esc_attr( $item['discount_pct'] ); ?>"
             data-type="<?php echo esc_attr( $item['type'] ); ?>">

          <!-- Top Badges -->
          <div class="flex items-center justify-between gap-1 mb-2 relative z-10">
            <?php if ( ! empty( $item['badge'] ) ) : ?>
              <span class="text-[10px] sm:text-[11px] font-black uppercase px-2 py-0.5 rounded-md bg-[#ffdad5] text-[#b7000c] shadow-2xs">
                <?php echo esc_html( $item['badge'] ); ?>
              </span>
            <?php else : ?>
              <span class="text-[10px] font-semibold text-[#5f5e5e] uppercase">
                <?php echo esc_html( $item['brand'] ); ?>
              </span>
            <?php endif; ?>

            <?php if ( $item['discount_pct'] > 0 ) : ?>
              <span class="text-[10px] sm:text-[11px] font-black px-1.5 py-0.5 rounded-md bg-[#e60012] text-white">
                -<?php echo esc_html( $item['discount_pct'] ); ?>%
              </span>
            <?php endif; ?>
          </div>

          <!-- Product Image -->
          <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="block overflow-hidden rounded-xl mb-3 text-center my-auto py-2">
            <img src="<?php echo esc_url( $item['image'] ); ?>" 
                 alt="<?php echo esc_attr( $item['name'] ); ?>" 
                 class="w-full h-36 sm:h-44 object-contain mx-auto transform group-hover:scale-105 transition-transform duration-300" 
                 loading="lazy" />
          </a>

          <!-- Product Info -->
          <div>
            <div class="text-[11px] font-semibold text-[#5f5e5e] mb-1">
              <?php echo esc_html( $item['type'] ); ?>
            </div>
            <h3 class="text-[13px] sm:text-[14.5px] leading-snug font-bold text-[#222222] line-clamp-2 min-h-[38px] group-hover:text-[#e60012] transition-colors" title="<?php echo esc_attr( $item['name'] ); ?>">
              <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                <?php echo esc_html( $item['name'] ); ?>
              </a>
            </h3>

            <!-- Price -->
            <div class="mt-2.5 flex items-baseline gap-2 flex-wrap">
              <span class="text-base sm:text-lg font-black text-[#e60012]">
                <?php echo number_format( $item['price'], 0, ',', '.' ); ?>₫
              </span>
              <?php if ( $item['price_old'] > $item['price'] ) : ?>
                <span class="text-xs text-[#5f5e5e] line-through">
                  <?php echo number_format( $item['price_old'], 0, ',', '.' ); ?>₫
                </span>
              <?php endif; ?>
            </div>

            <!-- Specs Tag -->
            <?php if ( ! empty( $item['specs'] ) ) : ?>
              <div class="mt-2 p-1.5 rounded-lg bg-[#f8f9fb] border border-[#E5E7EB] text-[11px] text-[#5f5e5e] line-clamp-1">
                <?php echo esc_html( $item['specs'] ); ?>
              </div>
            <?php endif; ?>

            <!-- Rating & Sold count -->
            <div class="mt-2.5 flex items-center justify-between text-[11px] text-[#5f5e5e]">
              <div class="flex items-center gap-1 text-[#b7000c] font-bold">
                <span class="material-symbols-outlined text-[14px] text-amber-500 fill-1">star</span>
                <span><?php echo esc_html( $item['rating'] ); ?></span>
                <span class="text-[#5f5e5e] font-normal">(<?php echo esc_html( $item['reviews'] ); ?>)</span>
              </div>
              <span class="text-gray-400">&bull; Đã bán <?php echo esc_html( $item['sold'] ); ?></span>
            </div>

            <!-- Action Buttons -->
            <div class="mt-3 pt-2.5 border-t border-[#E5E7EB] flex items-center gap-1.5">
              <a href="<?php echo esc_url( $item['permalink'] ); ?>" class="w-full py-2 rounded-xl bg-[#e60012] hover:bg-[#C90010] text-white text-xs font-bold text-center transition-colors shadow-2xs">
                Mua Ngay
              </a>
            </div>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div id="no-products-msg" class="hidden bg-white rounded-2xl p-12 text-center border border-[#E5E7EB] space-y-3">
      <span class="material-symbols-outlined text-[48px] text-[#5f5e5e]">search_off</span>
      <h3 class="text-base sm:text-lg font-bold text-[#222222]">Không tìm thấy phụ kiện nào phù hợp</h3>
      <p class="text-xs sm:text-sm text-[#5f5e5e] max-w-md mx-auto">
        Hãy thử chọn lại thương hiệu hoặc xóa các tiêu chí bộ lọc để xem thêm các mẫu phụ kiện khác.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-5 py-2.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white text-xs sm:text-sm font-bold cursor-pointer shadow-xs transition-colors">
        Xóa Tất Cả Bộ Lọc
      </button>
    </div>

    <!-- Centered "Xem thêm X Phụ Kiện" Button -->
    <div class="flex justify-center pt-3 pb-2">
      <button type="button" id="btn-load-more" onclick="window.scrollTo({top: document.getElementById('accessory-grid').offsetTop - 80, behavior: 'smooth'})" class="inline-flex items-center justify-center gap-1.5 px-8 py-3 rounded-xl border border-[#e60012] bg-white hover:bg-[#ffdad5] text-[#e60012] font-bold text-sm sm:text-base shadow-2xs transition-all cursor-pointer">
        <span>Xem thêm <span id="load-more-counter"><?php echo count( $products_list ); ?></span> <?php echo esc_html( $current_name ); ?></span>
        <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
      </button>
    </div>

    <!-- Centered Satisfaction Feedback Box (TGDD Yellow Border Box) -->
    <div class="max-w-[540px] mx-auto my-5 p-3.5 sm:p-4 rounded-xl bg-white border border-[#fcd34d] shadow-2xs flex items-center justify-between gap-4">
      <span class="text-xs sm:text-sm font-semibold text-[#222222] leading-snug">
        Bạn có hài lòng với thông tin và sản phẩm phụ kiện trên website không?
      </span>
      <div class="flex items-center gap-5 shrink-0 text-xs sm:text-sm">
        <button type="button" onclick="this.classList.toggle('scale-125'); alert('Cảm ơn bạn đã phản hồi hài lòng!')" class="flex flex-col items-center gap-0.5 hover:scale-110 transition-transform cursor-pointer group" title="Hài lòng">
          <span class="text-2xl leading-none">🥰</span>
          <span class="text-[#f59e0b] font-bold text-[11px] group-hover:underline">Hài lòng</span>
        </button>
        <button type="button" onclick="this.classList.toggle('scale-125'); alert('PhoneX đã ghi nhận ý kiến đóng góp của bạn để ngày càng hoàn thiện hơn!')" class="flex flex-col items-center gap-0.5 hover:scale-110 transition-transform cursor-pointer group" title="Không hài lòng">
          <span class="text-2xl leading-none">😞</span>
          <span class="text-[#f59e0b] font-bold text-[11px] group-hover:underline">Không hài lòng</span>
        </button>
      </div>
    </div>

    <!-- ================= 8. THÔNG TIN NGÀNH HÀNG PHỤ KIỆN (SEO DYNAMIC FROM TERM META / DEFAULTS) ================= -->
    <?php
    $cat_term_id = 23;
    if ( $current_term && ! is_wp_error( $current_term ) ) {
      $cat_term_id = $current_term->term_id;
    } elseif ( 'loa' === $current_slug ) {
      $cat_term_id = 62;
    } elseif ( 'micro' === $current_slug ) {
      $cat_term_id = 63;
    }

    if ( function_exists( 'phonex_render_category_seo_frontend' ) ) {
      phonex_render_category_seo_frontend( $cat_term_id );
    }
    ?>

    <!-- ================= 9. BUYING GUIDE & TIÊU CHÍ CHỌN PHỤ KIỆN (Centered Reading Column) ================= -->
    <div class="max-w-[820px] mx-auto bg-white rounded-2xl p-6 sm:p-8 shadow-2xs border border-[#E5E7EB] space-y-4 mt-8">
      <h2 class="text-base sm:text-lg font-black text-[#222222] border-b border-[#E5E7EB] pb-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-[#e60012] text-[22px]">verified</span>
        Cẩm Nang &amp; Tiêu Chí Chọn Mua Phụ Kiện Chính Hãng Tại PhoneX
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm leading-relaxed text-[#5f5e5e]">
        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">shield</span> 1. Chọn Chứng Chỉ An Toàn
          </h3>
          <p>
            Ưu tiên phụ kiện đạt chứng chỉ <strong class="text-[#222222]">Apple MFi</strong> cho iPhone/iPad, chuẩn <strong class="text-[#222222]">Qi2</strong> sạc không dây 15W hít nam châm, công nghệ <strong class="text-[#222222]">GaN</strong> giảm nhiệt độ và kích thước.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#FF9800] text-[20px]">equalizer</span> 2. Âm Thanh &amp; Công Suất
          </h3>
          <p>
            Với <strong class="text-[#222222]">Loa</strong>, chọn công suất 20W - 40W cho phòng ngủ, 60W - 100W cho phòng khách. Với <strong class="text-[#222222]">Micro</strong>, chọn loại có lọc ồn AI và sóng UHF ổn định.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#198754] text-[20px]">task_alt</span> 3. Đặc Quyền PhoneX
          </h3>
          <p>
            100% phụ kiện chính hãng, bảo hành <strong class="text-[#222222]">1 đổi 1 từ 12 - 24 tháng</strong> nếu có lỗi nhà sản xuất, dán cường lực miễn phí và giao hàng siêu tốc 1 giờ.
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
  const priceSelect = document.getElementById('filter-price');
  const typeSelect = document.getElementById('filter-type');
  const sortSelect = document.getElementById('filter-sort');
  const resultsCount = document.getElementById('results-count');
  const loadMoreCounter = document.getElementById('load-more-counter');
  const noProductsMsg = document.getElementById('no-products-msg');
  const resetBtn = document.getElementById('btn-reset-filters');
  const grid = document.getElementById('accessory-grid');
  const items = Array.from(grid.querySelectorAll('.accessory-item'));

  // Brand click
  document.querySelectorAll('.brand-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.brand-btn').forEach(b => {
        b.classList.remove('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
        b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      });
      this.classList.add('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
      this.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      activeBrand = this.getAttribute('data-brand') || 'all';
      applyFilters();
    });
  });

  // Select changes
  if (priceSelect) priceSelect.addEventListener('change', applyFilters);
  if (typeSelect) typeSelect.addEventListener('change', applyFilters);
  if (sortSelect) sortSelect.addEventListener('change', applyFilters);

  if (resetBtn) {
    resetBtn.addEventListener('click', resetAllFilters);
  }

  window.resetAllFilters = function() {
    activeBrand = 'all';
    if (priceSelect) priceSelect.value = 'all';
    if (typeSelect) typeSelect.value = 'all';
    if (sortSelect) sortSelect.value = 'default';

    document.querySelectorAll('.brand-btn').forEach(b => {
      b.classList.remove('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
      b.classList.add('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      if (b.getAttribute('data-brand') === 'all') {
        b.classList.add('active', 'border-[#e60012]', 'bg-[#e60012]', 'text-white');
        b.classList.remove('border-[#E5E7EB]', 'bg-white', 'text-[#222222]');
      }
    });

    applyFilters();
  };

  function applyFilters() {
    const priceVal = priceSelect ? priceSelect.value : 'all';
    const typeVal = typeSelect ? typeSelect.value : 'all';
    const sortVal = sortSelect ? sortSelect.value : 'default';

    let visibleItems = [];

    items.forEach(item => {
      const b = item.dataset.brand;
      const p = parseFloat(item.dataset.price) || 0;
      const t = item.dataset.type || '';

      let pass = true;

      // Brand
      if (activeBrand !== 'all' && b !== activeBrand) {
        pass = false;
      }

      // Type
      if (pass && typeVal !== 'all' && !t.toLowerCase().includes(typeVal.toLowerCase())) {
        pass = false;
      }

      // Price
      if (pass && priceVal !== 'all') {
        if (priceVal === 'under-500k' && p >= 500000) pass = false;
        else if (priceVal === '500k-1m' && (p < 500000 || p >= 1000000)) pass = false;
        else if (priceVal === '1m-2m' && (p < 1000000 || p >= 2000000)) pass = false;
        else if (priceVal === '2m-5m' && (p < 2000000 || p >= 5000000)) pass = false;
        else if (priceVal === 'over-5m' && p < 5000000) pass = false;
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
    if (resultsCount) resultsCount.textContent = visibleItems.length;
    if (loadMoreCounter) loadMoreCounter.textContent = visibleItems.length;

    if (visibleItems.length === 0) {
      grid.classList.add('hidden');
      if (noProductsMsg) noProductsMsg.classList.remove('hidden');
    } else {
      grid.classList.remove('hidden');
      if (noProductsMsg) noProductsMsg.classList.add('hidden');
    }

    // Reset button visibility
    const isFiltered = (activeBrand !== 'all' || priceVal !== 'all' || typeVal !== 'all' || sortVal !== 'default');
    if (resetBtn) {
      if (isFiltered) resetBtn.classList.remove('hidden');
      else resetBtn.classList.add('hidden');
    }
  }

  // Read URL search params on load (e.g. ?brand=JBL)
  const urlParams = new URLSearchParams(window.location.search);
  const paramBrand = urlParams.get('brand');
  if (paramBrand) {
    document.querySelectorAll('.brand-btn').forEach(btn => {
      const b = (btn.getAttribute('data-brand') || '').toLowerCase();
      if (b === paramBrand.toLowerCase() || b.includes(paramBrand.toLowerCase())) {
        btn.click();
      }
    });
  }

})();
</script>

<?php get_footer(); ?>
