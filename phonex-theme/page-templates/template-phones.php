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

// 1.1 LOAD CRAWLED JSON CATALOG & BUILD LOCAL IMAGE MAPS
$json_path           = get_template_directory() . '/data/phones.json';
$raw_phones          = array();
$remote_to_local_map = array();
$name_to_local_map   = array();
$name_to_specs_map   = array();

if ( file_exists( $json_path ) ) {
	$raw_phones = json_decode( file_get_contents( $json_path ), true ) ?: array();
	foreach ( $raw_phones as $jp ) {
		$l_img = $jp['image'] ?? '';
		if ( ! empty( $l_img ) && strpos( $l_img, 'http' ) !== 0 ) {
			$l_img = get_template_directory_uri() . '/' . ltrim( $l_img, '/' );
		}
		if ( ! empty( $jp['image_remote'] ) ) {
			$remote_to_local_map[ $jp['image_remote'] ] = $l_img;
		}
		if ( ! empty( $jp['name'] ) ) {
			$c_name = mb_strtolower( trim( $jp['name'] ) );
			$name_to_local_map[ $c_name ] = $l_img;
			$spec_data = array(
				'spec_groups'   => $jp['spec_groups'] ?? array(),
				'summary_specs' => $jp['summary_specs'] ?? null,
			);
			$name_to_specs_map[ $c_name ] = $spec_data;
			$clean_key = preg_replace( '/^điện thoại\s+/iu', '', $c_name );
			$name_to_specs_map[ $clean_key ] = $spec_data;
		}
	}
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

		// Image: resolve to local theme asset
		$image_url = get_the_post_thumbnail_url( $pid, 'medium_large' ) ?: get_the_post_thumbnail_url( $pid, 'full' );
		if ( ! $image_url ) {
			$image_url = get_post_meta( $pid, '_crawler_image_url', true );
		}
		if ( empty( $image_url ) || strpos( $image_url, 'cdn.tgdd.vn' ) !== false ) {
			$clean_title = mb_strtolower( trim( get_the_title() ) );
			if ( ! empty( $image_url ) && isset( $remote_to_local_map[ $image_url ] ) ) {
				$image_url = $remote_to_local_map[ $image_url ];
			} elseif ( isset( $name_to_local_map[ $clean_title ] ) ) {
				$image_url = $name_to_local_map[ $clean_title ];
			}
		}
		if ( ! $image_url ) {
			$image_url = get_template_directory_uri() . '/assets/images/placeholder.jpg';
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

		$c_title = mb_strtolower( trim( get_the_title() ) );
		$c_title_clean = preg_replace( '/\s*[-–]\s*chính hãng.*$/iu', '', $c_title );
		$c_title_clean = preg_replace( '/^điện thoại\s+/iu', '', $c_title_clean );

		$item_spec_groups = get_post_meta( $pid, '_spec_groups', true );
		if ( empty( $item_spec_groups ) ) {
			$base_m = preg_replace( '/\s*(256gb|512gb|128gb|64gb|1tb).*$/iu', '', $c_title_clean );
			$base_m = trim( $base_m );
			if ( isset( $name_to_specs_map[ $c_title ] ) ) {
				$item_spec_groups = $name_to_specs_map[ $c_title ]['spec_groups'];
			} elseif ( isset( $name_to_specs_map[ $c_title_clean ] ) ) {
				$item_spec_groups = $name_to_specs_map[ $c_title_clean ]['spec_groups'];
			} elseif ( isset( $name_to_specs_map[ $base_m ] ) ) {
				$item_spec_groups = $name_to_specs_map[ $base_m ]['spec_groups'];
			} else {
				foreach ( $name_to_specs_map as $sm_k => $sm_val ) {
					if ( ! empty( $sm_val['spec_groups'] ) && ! empty( $base_m ) && ( stripos( $sm_k, $base_m ) !== false || stripos( $base_m, $sm_k ) !== false ) ) {
						$item_spec_groups = $sm_val['spec_groups'];
						break;
					}
				}
			}
		}
		$item_summary_specs = get_post_meta( $pid, '_summary_specs', true );
		if ( empty( $item_summary_specs ) ) {
			if ( isset( $name_to_specs_map[ $c_title ] ) ) {
				$item_summary_specs = $name_to_specs_map[ $c_title ]['summary_specs'];
			} elseif ( isset( $name_to_specs_map[ $c_title_clean ] ) ) {
				$item_summary_specs = $name_to_specs_map[ $c_title_clean ]['summary_specs'];
			}
		}

		$phones_list[] = array(
			'id'            => $pid,
			'name'          => get_the_title(),
			'permalink'     => get_permalink( $pid ),
			'image'         => $image_url,
			'price'         => $display_price,
			'price_old'     => $display_old,
			'discount_pct'  => $discount_pct,
			'brand'         => $brand_clean,
			'capacity'      => $capacity,
			'specs'         => $specs,
			'spec_groups'   => $item_spec_groups ?: array(),
			'summary_specs' => $item_summary_specs ?: null,
			'os'            => $os,
			'demands'       => implode( ',', $demands ),
			'rating'        => '5.0',
			'reviews'       => rand( 12, 186 ),
			'is_new'        => ( $display_old == 0 || $pid >= 30 ),
		);
	}
	wp_reset_postdata();
}

// 2. MERGE CRAWLED PHONE CATALOG
if ( ! empty( $raw_phones ) ) {
	$existing_names = array_map( function( $p ) {
		return mb_strtolower( trim( $p['name'] ) );
	}, $phones_list );

	foreach ( $raw_phones as $jp ) {
		$clean_name = mb_strtolower( trim( $jp['name'] ?? '' ) );
		if ( empty( $clean_name ) || in_array( $clean_name, $existing_names, true ) ) {
			continue;
		}

		$img = $jp['image'] ?? '';
		if ( ! empty( $img ) && strpos( $img, 'http' ) !== 0 ) {
			$img = get_template_directory_uri() . '/' . ltrim( $img, '/' );
		}
		if ( empty( $img ) ) {
			$img = get_template_directory_uri() . '/assets/images/placeholder.jpg';
		}

		$brand_c = trim( $jp['brand'] ?? 'Khác' );
		if ( ! empty( $brand_c ) && ! in_array( $brand_c, $all_brands, true ) ) {
			$all_brands[] = $brand_c;
		}

		$phones_list[] = array(
			'id'            => $jp['id'] ?? uniqid(),
			'name'          => $jp['name'],
			'permalink'     => home_url( '/lien-he/?product=' . rawurlencode( $jp['name'] ) ),
			'image'         => $img,
			'price'         => floatval( $jp['price'] ?? 0 ),
			'price_old'     => floatval( $jp['price_old'] ?? 0 ),
			'discount_pct'  => intval( $jp['discount_pct'] ?? 0 ),
			'brand'         => $brand_c,
			'capacity'      => $jp['capacity'] ?? '',
			'specs'         => $jp['specs'] ?? '',
			'spec_groups'   => $jp['spec_groups'] ?? array(),
			'summary_specs' => $jp['summary_specs'] ?? null,
			'os'            => $jp['os'] ?? 'android',
			'demands'       => $jp['demands'] ?? '',
			'rating'        => $jp['rating'] ?? '5.0',
			'reviews'       => intval( $jp['reviews'] ?? 48 ),
			'is_new'        => ! empty( $jp['is_new'] ),
		);
	}
}

// Sort brands with major manufacturers first
$priority_brands = array( 'Apple', 'Samsung', 'OPPO', 'Xiaomi', 'Vivo', 'Realme', 'Honor', 'Tecno', 'Nokia', 'Motorola', 'Nothing Phone', 'Masstel', 'Mobell' );
usort( $all_brands, function( $a, $b ) use ( $priority_brands ) {
	$pos_a = array_search( $a, $priority_brands, true );
	$pos_b = array_search( $b, $priority_brands, true );
	if ( false !== $pos_a && false !== $pos_b ) {
		return $pos_a - $pos_b;
	}
	if ( false !== $pos_a ) {
		return -1;
	}
	if ( false !== $pos_b ) {
		return 1;
	}
	return strcmp( $a, $b );
} );
?>
<script>
window.pxPhoneSpecsCatalog = <?php echo wp_json_encode( $phones_list ); ?>;
</script>

<div class="bg-[#f8f9fb] min-h-screen pb-16 text-[#222222] font-sans">

  <!-- ================= BREADCRUMB ================= -->
  <div class="border-b border-[#E5E7EB] bg-white">
    <div class="max-w-[1240px] mx-auto px-4 py-3 flex items-center gap-2 text-[12px] sm:text-[13px] md:text-[14px] text-[#5f5e5e]">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#e60012] transition-colors flex items-center gap-1 font-medium">
        <span class="material-symbols-outlined text-[18px]">home</span> Trang chủ
      </a>
      <span class="text-[#E5E7EB]">/</span>
      <span class="font-bold text-[#222222]">Điện thoại</span>
    </div>
  </div>

  <div class="max-w-[1240px] mx-auto px-4 pt-4 sm:pt-6 space-y-5">

    <!-- ================= 1. PROMOTION HERO BANNER (TGDD Style with PhoneX Palette) ================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
      <!-- Main Featured Banner -->
      <div class="md:col-span-2 relative rounded-2xl overflow-hidden shadow-sm bg-gradient-to-r from-[#e60012] via-[#b7000c] to-[#b7000c] text-white p-6 sm:p-8 flex flex-col justify-between min-h-[220px]">
        <div class="relative z-10 max-w-[480px]">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-[6px] bg-white/20 backdrop-blur-sm text-[11px] sm:text-[12px] font-bold text-[#FF9800] mb-2.5">
            <span class="material-symbols-outlined text-[16px]">local_fire_department</span> ĐẠI TIỆC SMARTPHONE 2026
          </span>
          <h1 class="text-[26px] sm:text-[30px] md:text-[34px] font-bold tracking-tight leading-tight">
            ĐIỆN THOẠI CHÍNH HÃNG<br/>GIẢM SỐC ĐẾN 35%
          </h1>
          <p class="text-[14px] text-[#ffdad5] mt-2.5 line-clamp-2 leading-relaxed font-normal">
            Thu cũ đổi mới trợ giá 3 triệu &bull; Trả góp 0% lãi suất &bull; Bảo hành 12 tháng 1 đổi 1 trong 30 ngày.
          </p>
        </div>
        <div class="relative z-10 mt-5 flex items-center gap-4 flex-wrap">
          <a href="#phone-catalog" class="min-h-[48px] px-6 rounded-[8px] bg-[#FF9800] hover:bg-[#e68900] text-white font-semibold text-[15px] sm:text-[16px] transition-all shadow-md inline-flex items-center gap-1.5 cursor-pointer">
            Săn Deal Ngay <span class="material-symbols-outlined text-[20px]">arrow_downward</span>
          </a>
          <span class="text-[13px] sm:text-[14px] text-[#ffdad5] font-medium">Cam kết giá rẻ nhất thị trường</span>
        </div>
        <!-- Decorative graphic elements -->
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-4 right-6 hidden sm:block opacity-20">
          <span class="material-symbols-outlined text-[130px]">smartphone</span>
        </div>
      </div>

      <!-- Right Sub-Banners -->
      <div class="flex flex-col gap-3">
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#b7000c] to-[#e60012] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-[11px] sm:text-[12px] font-bold uppercase text-[#ffdad5] tracking-wider">Hệ Sinh Thái Apple</div>
            <div class="text-[16px] sm:text-[18px] font-bold mt-0.5">iPhone 17 | 18 Pro Max</div>
            <div class="text-[13px] sm:text-[14px] text-[#ffdad5]/90 mt-1 font-normal">Sẵn hàng VN/A &bull; Giao hỏa tốc 1H</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#ffdad5] shrink-0">verified</span>
        </div>
        <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#222222] to-[#b7000c] text-white flex items-center justify-between shadow-xs">
          <div>
            <div class="text-[11px] sm:text-[12px] font-bold uppercase text-[#FF9800] tracking-wider">Trợ Giá Lên Đời</div>
            <div class="text-[16px] sm:text-[18px] font-bold mt-0.5">Thu Cũ Giá Cao Nhất</div>
            <div class="text-[13px] sm:text-[14px] text-[#ffdad5]/90 mt-1 font-normal">Trợ giá thêm đến 3.000.000₫</div>
          </div>
          <span class="material-symbols-outlined text-[40px] text-[#FF9800] shrink-0">sync_alt</span>
        </div>
      </div>
    </div>

    <!-- ================= 2. BRAND LOGOS & QUICK PILLS (TGDD Brand Slider) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB]" id="phone-catalog">
      <div class="flex items-center justify-between mb-3.5">
        <h2 class="text-[22px] sm:text-[24px] md:text-[26px] font-bold text-[#222222] uppercase tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[24px]">apps</span>
          Chọn Thương Hiệu Điện Thoại
        </h2>
        <span class="text-[13px] sm:text-[14px] text-[#5f5e5e] font-medium">Hiện có <?php echo count( $all_brands ); ?> hãng hàng đầu</span>
      </div>

      <div class="flex items-center gap-2.5 overflow-x-auto pb-1 scrollbar-none" id="brand-selector-list">
        <!-- Button: Tất cả -->
        <button type="button" class="brand-btn active shrink-0 min-h-[40px] px-4 sm:px-5 py-2 rounded-full border border-[#e60012] bg-[#e60012] text-white text-[13px] sm:text-[14px] font-semibold transition-all shadow-xs flex items-center gap-2 cursor-pointer" data-brand="all">
          <span>Tất cả</span>
          <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px] sm:text-[12px] font-bold"><?php echo count( $phones_list ); ?></span>
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
          <button type="button" class="brand-btn shrink-0 min-h-[40px] px-4 sm:px-4.5 py-2 rounded-full border border-[#E5E7EB] hover:border-[#e60012] bg-white hover:bg-[#ffdad5]/30 text-[#222222] hover:text-[#e60012] text-[13px] sm:text-[14px] font-semibold transition-all shadow-2xs flex items-center gap-2 cursor-pointer" data-brand="<?php echo esc_attr( $b ); ?>">
            <span><?php echo esc_html( $b ); ?></span>
            <span class="px-2 py-0.5 rounded-full bg-[#f8f9fb] text-[#5f5e5e] text-[11px] sm:text-[12px] font-medium"><?php echo $b_count; ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ================= 3. QUICK DEMANDS (Nhu cầu tìm kiếm - TGDD Style) ================= -->
    <div class="flex items-center gap-2.5 overflow-x-auto pb-1 text-[13px] sm:text-[14px] font-medium scrollbar-none" id="demand-selector-list">
      <span class="text-[#5f5e5e] shrink-0 font-bold text-[12px] sm:text-[13px] uppercase mr-1">Nhu cầu:</span>
      <button type="button" class="demand-btn shrink-0 min-h-[38px] px-3.5 py-1.5 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="gaming">
        🎮 Chơi game / Cấu hình cao
      </button>
      <button type="button" class="demand-btn shrink-0 min-h-[38px] px-3.5 py-1.5 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="camera">
        📸 Chụp ảnh, quay phim đẹp
      </button>
      <button type="button" class="demand-btn shrink-0 min-h-[38px] px-3.5 py-1.5 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="foldable">
        📱 Màn hình gập cao cấp
      </button>
      <button type="button" class="demand-btn shrink-0 min-h-[38px] px-3.5 py-1.5 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="battery">
        🔋 Pin trâu dùng cả ngày
      </button>
      <button type="button" class="demand-btn shrink-0 min-h-[38px] px-3.5 py-1.5 rounded-full border border-[#E5E7EB] bg-white hover:border-[#e60012] hover:text-[#e60012] transition-all text-[#222222] cursor-pointer" data-demand="budget">
        💰 Giá rẻ học sinh, sinh viên
      </button>
    </div>

    <!-- ================= 4. COMPREHENSIVE FILTER BOX (Bộ lọc đa tiêu chí) ================= -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-2xs border border-[#E5E7EB] space-y-4">
      <div class="flex items-center justify-between border-b border-[#E5E7EB] pb-3">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[#e60012] text-[22px]">tune</span>
          <span class="font-semibold text-[#222222] text-[18px] sm:text-[20px]">Bộ Lọc Tìm Kiếm Chi Tiết</span>
        </div>
        <button type="button" id="btn-reset-filters" class="text-[13px] sm:text-[14px] text-[#e60012] font-semibold hover:underline hidden flex items-center gap-1 cursor-pointer">
          <span class="material-symbols-outlined text-[16px]">refresh</span> Xóa tất cả bộ lọc
        </button>
      </div>

      <!-- Filter Controls Grid (16px Input text to avoid iOS auto-zoom) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3.5">
        
        <!-- Price Range Filter -->
        <div>
          <label class="block font-semibold text-[#222222] text-[14px] mb-1.5">Mức Giá:</label>
          <select id="filter-price" class="w-full h-[44px] sm:h-[48px] rounded-[8px] border border-[#E5E7EB] px-3.5 font-normal bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-none transition-all text-[16px]">
            <option value="all">Tất cả mức giá</option>
            <option value="under-10m">Dưới 10 triệu</option>
            <option value="10m-20m">Từ 10 - 20 triệu</option>
            <option value="20m-35m">Từ 20 - 35 triệu</option>
            <option value="over-35m">Flagship trên 35 triệu</option>
          </select>
        </div>

        <!-- Storage Filter -->
        <div>
          <label class="block font-semibold text-[#222222] text-[14px] mb-1.5">Dung Lượng Bộ Nhớ:</label>
          <select id="filter-storage" class="w-full h-[44px] sm:h-[48px] rounded-[8px] border border-[#E5E7EB] px-3.5 font-normal bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-none transition-all text-[16px]">
            <option value="all">Tất cả dung lượng</option>
            <option value="64GB">64 GB</option>
            <option value="128GB">128 GB</option>
            <option value="256GB">256 GB</option>
            <option value="512GB">512 GB</option>
            <option value="1TB">1 TB</option>
          </select>
        </div>

        <!-- OS Filter -->
        <div>
          <label class="block font-semibold text-[#222222] text-[14px] mb-1.5">Hệ Điều Hành:</label>
          <select id="filter-os" class="w-full h-[44px] sm:h-[48px] rounded-[8px] border border-[#E5E7EB] px-3.5 font-normal bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-none transition-all text-[16px]">
            <option value="all">Tất cả hệ điều hành</option>
            <option value="ios">iOS (Apple iPhone)</option>
            <option value="android">Android (Samsung, Xiaomi, OPPO...)</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div>
          <label class="block font-semibold text-[#222222] text-[14px] mb-1.5">Sắp Xếp Theo:</label>
          <select id="filter-sort" class="w-full h-[44px] sm:h-[48px] rounded-[8px] border border-[#E5E7EB] px-3.5 font-normal bg-[#f8f9fb] text-[#222222] focus:bg-white focus:border-[#e60012] outline-none transition-all text-[16px]">
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
      <div class="text-[14px] sm:text-[15px] font-semibold text-[#222222]">
        Tìm thấy <span id="results-count" class="text-[#e60012] font-bold"><?php echo count( $phones_list ); ?></span> điện thoại chính hãng
      </div>
      <div class="flex items-center gap-1.5 text-[13px] sm:text-[14px] text-[#5f5e5e] font-normal">
        <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#198754]"></span>
        Sẵn hàng toàn quốc &bull; Trả góp 0%
      </div>
    </div>

    <!-- ================= 5.1 USED PHONES CROSS-SELL BANNER (TGDD Style) ================= -->
    <div class="rounded-2xl p-4 sm:p-5 bg-gradient-to-r from-[#fff1f0] via-[#ffe4e6] to-[#fff1f0] border border-[#ffb4aa]/60 flex items-center justify-between gap-4 flex-wrap shadow-2xs">
      <div class="flex items-center gap-3.5">
        <div class="w-12 h-12 rounded-xl bg-[#b7000c] text-white flex items-center justify-center shrink-0 shadow-sm">
          <span class="material-symbols-outlined text-[28px]">phone_android</span>
        </div>
        <div>
          <div class="flex items-center gap-2 flex-wrap">
            <span class="text-[15px] sm:text-[16px] font-bold text-[#222222]">Bạn tìm kiếm Điện Thoại Cũ Giá Tốt?</span>
            <span class="px-2 py-0.5 rounded-full bg-[#b7000c] text-white text-[11px] font-bold">Tiết kiệm đến 60%</span>
          </div>
          <p class="text-[13px] text-[#5f5e5e] mt-0.5">Máy chính hãng like new 99%, pin cao, kiểm định nghiêm ngặt, bảo hành 12 tháng 1 đổi 1.</p>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( '/dien-thoai-cu/' ) ); ?>" class="min-h-[44px] px-5 rounded-[8px] bg-[#b7000c] hover:bg-[#C90010] text-white text-[13px] sm:text-[14px] font-semibold transition-all inline-flex items-center gap-1.5 shadow-xs cursor-pointer">
        Xem 195+ Điện Thoại Cũ <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
      </a>
    </div>

    <!-- ================= 6. PRODUCT GRID (TGDD Style Grid) ================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4.5" id="phones-grid">
      <?php foreach ( $phones_list as $idx => $p ) : ?>
        <div class="phone-item bg-white rounded-[12px] p-3 sm:p-4 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between group border border-[#E5E7EB] hover:border-[#e60012] relative hover:-translate-y-1 duration-200"
             style="<?php echo ( $idx >= 20 ) ? 'display: none;' : ''; ?>"
             data-id="<?php echo esc_attr( $p['id'] ); ?>"
             data-phone-id="<?php echo esc_attr( $p['id'] ); ?>"
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
            <div class="relative w-full aspect-square flex items-center justify-center p-2 bg-[#f8f9fb] rounded-[10px] mb-3 overflow-hidden">
              <?php if ( $p['discount_pct'] > 0 ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded-[6px] bg-[#e60012] text-white text-[11px] sm:text-[12px] font-bold shadow-xs">
                  -<?php echo esc_html( $p['discount_pct'] ); ?>%
                </span>
              <?php elseif ( ! empty( $p['is_new'] ) ) : ?>
                <span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded-[6px] bg-[#e60012] text-white text-[11px] sm:text-[12px] font-bold shadow-xs">
                  Mẫu Mới
                </span>
              <?php endif; ?>

              <span class="absolute top-2 right-2 z-10 px-2 py-0.5 rounded-[6px] bg-white text-[#5f5e5e] border border-[#E5E7EB] text-[11px] font-semibold">
                Trả góp 0%
              </span>

              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="open-specs-modal-btn w-full h-full flex items-center justify-center cursor-pointer" data-product="<?php echo esc_attr( wp_json_encode( $p ) ); ?>" title="Xem thông số kỹ thuật <?php echo esc_attr( $p['name'] ); ?>">
                <img class="w-full h-full object-contain group-hover:scale-108 transition-transform duration-300"
                     alt="<?php echo esc_attr( $p['name'] ); ?>"
                     src="<?php echo esc_url( $p['image'] ); ?>"
                     width="300" height="300"
                     loading="lazy" />
              </a>
            </div>

            <!-- Specs tag -->
            <?php if ( ! empty( $p['specs'] ) ) : ?>
              <div class="mb-1.5 flex items-center gap-1 overflow-hidden">
                <span class="open-specs-modal-btn px-2 py-0.5 rounded-[6px] bg-[#f8f9fb] hover:bg-[#ffdad5] text-[#5f5e5e] hover:text-[#b7000c] border border-[#E5E7EB] text-[11px] sm:text-[12px] font-normal truncate max-w-full cursor-pointer transition-colors" data-product="<?php echo esc_attr( wp_json_encode( $p ) ); ?>" title="Click xem chi tiết thông số">
                  <?php echo esc_html( $p['specs'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 class="text-[14px] sm:text-[16px] leading-snug font-semibold text-[#222222] line-clamp-2 min-h-[44px] group-hover:text-[#e60012] transition-colors" title="<?php echo esc_attr( $p['name'] ); ?>">
              <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="open-specs-modal-btn hover:text-[#e60012] transition-colors cursor-pointer" data-product="<?php echo esc_attr( wp_json_encode( $p ) ); ?>">
                <?php echo esc_html( $p['name'] ); ?>
              </a>
            </h3>

            <!-- Storage pill -->
            <?php if ( ! empty( $p['capacity'] ) ) : ?>
              <div class="mt-2 flex items-center gap-1">
                <span class="px-2 py-0.5 rounded-[6px] border border-[#E5E7EB] text-[#222222] text-[11px] sm:text-[12px] font-semibold bg-[#f8f9fb]">
                  <?php echo esc_html( $p['capacity'] ); ?>
                </span>
              </div>
            <?php endif; ?>

            <!-- Price Display (Desktop 20-24px, Tablet 20px, Mobile 18-20px) -->
            <div class="mt-2.5">
              <div class="text-[18px] sm:text-[20px] md:text-[22px] font-bold text-[#e60012] leading-tight">
                <?php echo number_format( $p['price'], 0, ',', '.' ); ?>₫
              </div>
              <?php if ( $p['price_old'] > $p['price'] ) : ?>
                <div class="text-[13px] sm:text-[14px] text-[#5f5e5e] line-through font-normal">
                  <?php echo number_format( $p['price_old'], 0, ',', '.' ); ?>₫
                </div>
              <?php endif; ?>
            </div>

            <!-- Star rating & Reviews -->
            <div class="mt-2 flex items-center gap-1 text-[12px] sm:text-[13px] text-[#FF9800] font-semibold">
              <span>★</span>
              <span>5.0</span>
              <span class="text-[#5f5e5e] font-normal">(<?php echo esc_html( $p['reviews'] ); ?>)</span>
            </div>
          </div>

          <!-- Card Action Buttons: Đặt mua ngay + Xem chi tiết -->
          <div class="mt-3.5 flex flex-col gap-1.5 w-full">
            <a href="<?php echo esc_url( $p['permalink'] ); ?>" class="w-full min-h-[40px] rounded-[8px] bg-[#b7000c] hover:bg-[#C90010] text-white text-[13px] sm:text-[14px] font-semibold transition-all flex items-center justify-center gap-1.5 shadow-xs">
              <span class="material-symbols-outlined text-[17px]">shopping_bag</span>
              Đặt mua ngay
            </a>
            <button type="button" class="open-specs-modal-btn w-full min-h-[38px] rounded-[8px] border border-[#E5E7EB] bg-[#f8f9fb] hover:bg-[#ffdad5] text-[#222222] hover:text-[#b7000c] text-[13px] font-semibold transition-all flex items-center justify-center gap-1.5 cursor-pointer" data-product="<?php echo esc_attr( wp_json_encode( $p ) ); ?>">
              <span class="material-symbols-outlined text-[16px] text-[#e60012]">info</span>
              Xem chi tiết
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Centered "Xem thêm X Điện thoại" Button (TGDD Style Progressive Loading) -->
    <div class="flex justify-center pt-3 pb-2" id="load-more-container">
      <button type="button" id="btn-load-more-phones" onclick="window.loadMorePhones &amp;&amp; window.loadMorePhones(event)" class="inline-flex items-center justify-center gap-1.5 px-8 min-h-[48px] rounded-[8px] border border-[#e60012] bg-white hover:bg-[#ffdad5] text-[#e60012] font-semibold text-[15px] sm:text-[16px] shadow-2xs transition-all cursor-pointer">
        <span>Xem thêm <span id="load-more-counter"><?php echo max( 0, count( $phones_list ) - 20 ); ?></span> Điện thoại</span>
        <span class="material-symbols-outlined text-[18px]">keyboard_arrow_down</span>
      </button>
    </div>

    <!-- Centered Satisfaction Feedback Box (TGDD Yellow Border Box as in Screenshot) -->
    <div class="max-w-[540px] mx-auto my-5 p-3.5 sm:p-4 rounded-xl bg-white border border-[#fcd34d] shadow-2xs flex items-center justify-between gap-4">
      <span class="text-xs sm:text-sm font-semibold text-[#222222] leading-snug">
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
      <span class="material-symbols-outlined text-[48px] text-[#5f5e5e]">search_off</span>
      <h3 class="text-base sm:text-lg font-bold text-[#222222]">Không tìm thấy điện thoại nào phù hợp</h3>
      <p class="text-xs sm:text-sm text-[#5f5e5e] max-w-md mx-auto">
        Hãy thử thay đổi hoặc xóa các tiêu chí bộ lọc để xem thêm các mẫu điện thoại khác.
      </p>
      <button type="button" onclick="resetAllFilters()" class="px-5 py-2.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white text-xs sm:text-sm font-bold cursor-pointer shadow-xs transition-colors">
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
      <h2 class="text-base sm:text-lg font-black text-[#222222] border-b border-[#E5E7EB] pb-3 flex items-center gap-2">
        <span class="material-symbols-outlined text-[#e60012] text-[22px]">menu_book</span>
        Cẩm Nang &amp; Tiêu Chí Chọn Mua Điện Thoại Thông Minh Tại PhoneX
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs sm:text-sm leading-relaxed text-[#5f5e5e]">
        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#e60012] text-[20px]">verified</span> 1. Chọn theo Hệ điều hành
          </h3>
          <p>
            <strong class="text-[#222222]">iOS (iPhone):</strong> Ổn định, mượt mà lâu dài, bảo mật cao và đồng bộ hoàn hảo trong hệ sinh thái Apple.<br/>
            <strong class="text-[#222222]">Android:</strong> Đa dạng mẫu mã (Samsung, Xiaomi, OPPO), nhiều tính năng mới lạ như màn hình gập, sạc siêu tốc.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
            <span class="material-symbols-outlined text-[#FF9800] text-[20px]">memory</span> 2. Chọn Dung lượng lưu trữ
          </h3>
          <p>
            <strong class="text-[#222222]">128GB:</strong> Phù hợp nhu cầu cơ bản, chụp ảnh vừa phải và ứng dụng hàng ngày.<br/>
            <strong class="text-[#222222]">256GB - 512GB:</strong> Tiêu chuẩn lý tưởng cho người dùng quay video 4K, lưu trữ nhiều game nặng và dữ liệu công việc.
          </p>
        </div>

        <div class="p-4 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB]">
          <h3 class="font-bold text-[#222222] mb-1.5 flex items-center gap-1.5 text-sm sm:text-base">
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
  const loadMoreBtn = document.getElementById('btn-load-more-phones');
  const loadMoreContainer = document.getElementById('load-more-container');
  const loadMoreCounter = document.getElementById('load-more-counter');

  const PAGE_SIZE = 20;
  let visibleLimit = PAGE_SIZE;
  let currentMatching = [];

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
  priceSelect.addEventListener('change', applyFilters);
  storageSelect.addEventListener('change', applyFilters);
  osSelect.addEventListener('change', applyFilters);
  sortSelect.addEventListener('change', applyFilters);

  function resetAllFilters() {
    activeBrand = 'all';
    activeDemand = '';
    priceSelect.value = 'all';
    storageSelect.value = 'all';
    osSelect.value = 'all';
    sortSelect.value = 'default';

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
  }
  window.resetAllFilters = resetAllFilters;

  if (resetBtn) {
    resetBtn.addEventListener('click', resetAllFilters);
  }

  function renderPage() {
    currentMatching.forEach((item, index) => {
      if (index < visibleLimit) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });

    if (loadMoreContainer && loadMoreCounter) {
      const remaining = currentMatching.length - visibleLimit;
      if (remaining > 0) {
        loadMoreContainer.classList.remove('hidden');
        loadMoreCounter.textContent = remaining;
      } else {
        loadMoreContainer.classList.add('hidden');
      }
    }
  }

  function loadMorePhones(e) {
    if (e && e.preventDefault) e.preventDefault();
    visibleLimit += PAGE_SIZE;
    renderPage();
  }
  window.loadMorePhones = loadMorePhones;

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', loadMorePhones);
  }

  function applyFilters() {
    const priceVal = priceSelect.value;
    const storageVal = storageSelect.value;
    const osVal = osSelect.value;
    const sortVal = sortSelect.value;

    visibleLimit = PAGE_SIZE;
    currentMatching = [];

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
        currentMatching.push(item);
      } else {
        item.style.display = 'none';
      }
    });

    // Sắp xếp
    if (sortVal === 'price-asc') {
      currentMatching.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
    } else if (sortVal === 'price-desc') {
      currentMatching.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
    } else if (sortVal === 'discount-desc') {
      currentMatching.sort((a, b) => parseFloat(b.dataset.discount) - parseFloat(a.dataset.discount));
    }

    // Re-append sorted
    currentMatching.forEach(item => grid.appendChild(item));

    // Render first visible batch
    renderPage();

    // Update Counter & Empty state
    resultsCount.textContent = currentMatching.length;
    if (currentMatching.length === 0) {
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

  // Initial render
  applyFilters();

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
