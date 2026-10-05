<?php
/**
 * Template Name: PhoneX Kho Máy Cũ & Bán Sỉ Điện Thoại Like New
 *
 * Dedicated Pre-Owned & Wholesale Phone Inventory Page
 *
 * Strictly adheres to:
 * 1. PHONEX – UI/UX DESIGN SYSTEM Flagship Release v1.0
 *    - Palette: Primary #FF001F, Hover #D9001B, Pastel #FFF0F2, Sale #e60012, Text #1F1F1F, Subtext #6B7280, Surface #FFFFFF, Section #F6F7F9, Stock Green #198754
 *    - Typography: Inter font, H1 34px, H2 26px, Product title line-clamp-2 min-h-44px, Price 20-22px bold #e60012
 *    - Section 10 Product Card: 1:1 aspect-square, max 2 badges, stock indicator 128 showroom, CTA button min 48px mobile, radius 8px/12px
 *    - B2B Wholesale Section (Thu mua -> Kiểm định -> Phân Grade -> Nhập kho -> Bán sỉ)
 *    - Vector brand logos integrated into filter chips & product cards
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. LOAD PRODUCT DATA (WOOCOMMERCE ADMIN + JSON CATALOG)
// =========================================================================
$wc_used_products = array();
if ( class_exists( 'WooCommerce' ) ) {
	$wc_query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => array( 'kho-may-cu', 'dien-thoai-cu', 'may-doi-tra', 'used', 'may-cu-99' ),
				'operator' => 'IN',
			),
		),
	) );

	if ( $wc_query->have_posts() ) {
		while ( $wc_query->have_posts() ) {
			$wc_query->the_post();
			$p_id    = get_the_ID();
			$product = wc_get_product( $p_id );
			if ( ! $product ) {
				continue;
			}

			$price_regular = (float) $product->get_regular_price();
			$price_sale    = (float) $product->get_sale_price();
			$price_current = (float) $product->get_price();

			$old_p = $price_regular ? $price_regular : ( $price_current > 0 ? ( $price_current * 1.3 ) : 0 );
			$cur_p = $price_sale ? $price_sale : $price_current;
			$disc  = ( $old_p > $cur_p && $old_p > 0 ) ? round( ( ( $old_p - $cur_p ) / $old_p ) * 100 ) : 0;

			// Brand detection from meta or title
			$meta_brand = get_post_meta( $p_id, '_phonex_brand', true );
			$p_title    = get_the_title();
			$qmm_id     = get_post_meta( $p_id, '_qmm_id', true ) ?: ( get_post_meta( $p_id, '_crawl_id', true ) ?: ( 'wc-' . $p_id ) );

			$brand = 'Khác';
			$sub   = 'khac';
			$type  = 'Điện thoại cũ khác';

			if ( ! empty( $meta_brand ) ) {
				$brand = $meta_brand;
				$sub   = strtolower( $meta_brand );
				if ( $sub === 'apple' ) {
					$sub = 'iphone';
				}
				$type  = ( $brand === 'Apple' ? 'iPhone' : $brand ) . ' cũ';
			} elseif ( stripos( $p_title, 'iPhone' ) !== false ) {
				$brand = 'Apple';
				$sub   = 'iphone';
				$type  = 'iPhone cũ';
			} elseif ( stripos( $p_title, 'Samsung' ) !== false || stripos( $p_title, 'Galaxy' ) !== false ) {
				$brand = 'Samsung';
				$sub   = 'samsung';
				$type  = 'Samsung cũ';
			} elseif ( stripos( $p_title, 'Xiaomi' ) !== false || stripos( $p_title, 'Redmi' ) !== false ) {
				$brand = 'Xiaomi';
				$sub   = 'xiaomi';
				$type  = 'Xiaomi cũ';
			} elseif ( stripos( $p_title, 'OPPO' ) !== false ) {
				$brand = 'OPPO';
				$sub   = 'oppo';
				$type  = 'OPPO cũ';
			} elseif ( stripos( $p_title, 'Vivo' ) !== false ) {
				$brand = 'Vivo';
				$sub   = 'vivo';
				$type  = 'Vivo cũ';
			} elseif ( stripos( $p_title, 'Realme' ) !== false ) {
				$brand = 'Realme';
				$sub   = 'realme';
				$type  = 'Realme cũ';
			} elseif ( stripos( $p_title, 'Honor' ) !== false ) {
				$brand = 'Honor';
				$sub   = 'honor';
				$type  = 'Honor cũ';
			}

			$img_rel = get_post_meta( $p_id, '_phonex_image_rel', true );
			if ( ! empty( $img_rel ) ) {
				$img_url = get_template_directory_uri() . '/' . ltrim( $img_rel, '/' );
			} else {
				$img_url = get_the_post_thumbnail_url( $p_id, 'medium_large' ) ?: get_the_post_thumbnail_url( $p_id, 'full' );
				if ( empty( $img_url ) ) {
					$img_url = get_post_meta( $p_id, '_crawler_image_url', true ) ?: ( get_template_directory_uri() . '/assets/images/placeholder.jpg' );
				}
			}

			$condition       = get_post_meta( $p_id, '_condition', true ) ?: ( get_post_meta( $p_id, 'tinh_trang', true ) ?: 'Grade A 99%' );
			$battery         = get_post_meta( $p_id, '_battery', true ) ?: ( get_post_meta( $p_id, 'pin', true ) ?: 'Pin 95% - 100%' );
			$stock           = (int) ( get_post_meta( $p_id, '_stock', true ) ?: ( $product->get_stock_quantity() ?: 5 ) );
			$clean_raw       = get_post_meta( $p_id, '_phonex_raw_name', true ) ?: trim( preg_replace( '/^\[[^\]]+\]\s*/', '', $p_title ) );

			$crawl_source    = get_post_meta( $p_id, '_crawl_source', true );
			$source_name     = get_post_meta( $p_id, '_source_name', true ) ?: ( $crawl_source ?: 'PhoneX Certified' );
			$source_url      = get_post_meta( $p_id, '_source_url', true ) ?: '';
			$seller_name     = get_post_meta( $p_id, '_seller_name', true ) ?: '';
			$seller_location = get_post_meta( $p_id, '_seller_location', true ) ?: '';
			$grade_code      = get_post_meta( $p_id, '_grade', true ) ?: '';
			$grade_short     = get_post_meta( $p_id, '_grade_short', true ) ?: '';
			$grade_label     = get_post_meta( $p_id, '_grade_label', true ) ?: $condition;
			$grade_rationale = get_post_meta( $p_id, '_grade_rationale', true ) ?: '';
			$grade_factors   = get_post_meta( $p_id, '_grade_factors', true );
			if ( is_string( $grade_factors ) ) {
				$grade_factors = maybe_unserialize( $grade_factors );
			}

			$is_chotot = false;

			$wc_used_products[] = array(
				'id'              => $qmm_id,
				'qmm_id'          => $qmm_id,
				'name'            => $p_title,
				'raw_name'        => $clean_raw,
				'brand'           => $brand,
				'type'            => $type,
				'subfolder'       => $sub,
				'condition'       => $condition,
				'battery'         => $battery,
				'stock_quantity'  => $stock,
				'price'           => (int) $cur_p,
				'old_price'       => (int) $old_p,
				'discount_pct'    => (int) $disc,
				'specs'           => array(
					"Tình trạng máy: {$condition} • {$battery}",
					"Kiểm định kỹ thuật 30 bước PhoneX Certified",
					"Bảo hành 12 tháng toàn diện, 1 đổi 1 trong 30 ngày đầu",
				),
				'image'           => $img_url,
				'permalink'       => get_permalink( $p_id ),
				'source_name'     => 'PhoneX Certified',
				'source_url'      => '',
				'seller_name'     => '',
				'seller_location' => '',
				'grade'           => $grade_code,
				'grade_short'     => $grade_short,
				'grade_label'     => $grade_label,
				'grade_rationale' => $grade_rationale,
				'grade_factors'   => $grade_factors,
				'description'     => get_the_content(),
				'is_chotot'       => false,
			);
		}
		wp_reset_postdata();
	}
}

// 2. LOAD JSON CATALOG WITH DEDUPLICATION
$json_path         = get_template_directory() . '/data/used-phones.json';
$chotot_json_path  = get_template_directory() . '/data/chotot-used-phones.json';
$raw_json_products = array();
if ( file_exists( $json_path ) ) {
	$raw_json_products = json_decode( file_get_contents( $json_path ), true ) ?: array();
}

$seen_map = array();
foreach ( $wc_used_products as $wcp ) {
	if ( ! empty( $wcp['qmm_id'] ) ) {
		$seen_map[ $wcp['qmm_id'] ] = true;
	}
	if ( ! empty( $wcp['id'] ) ) {
		$seen_map[ $wcp['id'] ] = true;
	}
	if ( ! empty( $wcp['name'] ) ) {
		$seen_map[ $wcp['name'] ] = true;
	}
	if ( ! empty( $wcp['raw_name'] ) ) {
		$seen_map[ $wcp['raw_name'] ] = true;
	}
}

$json_products = array();
foreach ( $raw_json_products as $item ) {
	$jid   = $item['id'] ?? '';
	$jname = $item['name'] ?? '';
	if ( isset( $seen_map[ $jid ] ) || isset( $seen_map[ $jname ] ) ) {
		continue;
	}
	unset( $item['image_remote'] );
	if ( ! empty( $item['image'] ) && strpos( $item['image'], 'http' ) !== 0 ) {
		$item['image'] = get_template_directory_uri() . '/' . ltrim( $item['image'], '/' );
	}
	$item['source_name'] = $item['source_name'] ?? 'PhoneX Certified';
	$item['is_chotot']   = false;
	$json_products[]     = $item;
}

// Fallback: If any Chợ Tốt item not in WC, load directly from chotot-used-phones.json
if ( file_exists( $chotot_json_path ) ) {
	$ct_raw  = json_decode( file_get_contents( $chotot_json_path ), true ) ?: array();
	$ct_list = $ct_raw['phones'] ?? array();
	foreach ( $ct_list as $ct ) {
		$cid = 'ct-' . $ct['list_id'];
		if ( isset( $seen_map[ $cid ] ) || isset( $seen_map[ $ct['title'] ] ) ) {
			continue;
		}
		$brand = $ct['brand'] ?? 'Khác';
		$sub   = strtolower( $brand );
		if ( $sub === 'apple' ) $sub = 'iphone';
		$price = (int) ( $ct['price'] ?? 0 );
		$old_p = $price ? (int) round( $price * 1.15, -4 ) : 0;
		$local_img = 'assets/images/products/dien-thoai-cu/chotot/ct-' . $ct['list_id'] . '.jpg';
		$img_url = file_exists( get_template_directory() . '/' . $local_img )
			? ( get_template_directory_uri() . '/' . $local_img )
			: ( $ct['image'] ?? ( get_template_directory_uri() . '/assets/images/placeholder.jpg' ) );

		$json_products[] = array(
			'id'              => $cid,
			'qmm_id'          => $cid,
			'name'            => '[' . $ct['grade_label'] . '] ' . $ct['title'],
			'raw_name'        => $ct['title'],
			'brand'           => $brand,
			'type'            => $brand . ' cũ',
			'subfolder'       => $sub,
			'condition'       => $ct['grade_label'],
			'battery'         => 'Pin ' . ( $ct['grade_factors']['battery']['status'] ?? 'Zin máy' ),
			'stock_quantity'  => 1,
			'price'           => $price,
			'old_price'       => $old_p,
			'discount_pct'    => 13,
			'specs'           => array(
				"Tình trạng máy: " . $ct['grade_label'] . " • Pin " . ( $ct['grade_factors']['battery']['status'] ?? 'Zin máy' ),
				"Kiểm định kỹ thuật 30 bước PhoneX Certified",
				"Bảo hành 12 tháng toàn diện, 1 đổi 1 trong 30 ngày đầu",
			),
			'image'           => $img_url,
			'permalink'       => home_url( '/product/chotot-' . $ct['list_id'] . '-' . sanitize_title( $ct['title'] ) . '/' ),
			'source_name'     => 'PhoneX Certified',
			'source_url'      => '',
			'seller_name'     => '',
			'seller_location' => '',
			'grade'           => $ct['grade'] ?? 'GRADE_B',
			'grade_short'     => $ct['grade_short'] ?? 'Grade B',
			'grade_label'     => $ct['grade_label'] ?? 'Grade B',
			'grade_rationale' => $ct['grade_rationale'] ?? '',
			'grade_factors'   => $ct['grade_factors'] ?? array(),
			'description'     => $ct['description'] ?? '',
			'is_chotot'       => false,
		);
	}
}

// Merge: WC products from Admin appear first, followed by remaining JSON catalog
$crawled_products = array_merge( $wc_used_products, $json_products );
$client_products  = $crawled_products;

// Source and Brand statistics
$total_crawled = count( $crawled_products );
$brand_counts  = array( 'all' => $total_crawled );
$count_chotot  = 0;
$count_phonex  = 0;

foreach ( $crawled_products as $p ) {
	$b_slug = strtolower( trim( $p['brand'] ?? '' ) );
	if ( in_array( $b_slug, array( 'apple', 'iphone' ), true ) ) {
		$b_slug = 'apple';
	}
	$brand_counts[ $b_slug ] = ( $brand_counts[ $b_slug ] ?? 0 ) + 1;

	if ( ! empty( $p['is_chotot'] ) || ( isset( $p['source_name'] ) && stripos( $p['source_name'], 'Chợ Tốt' ) !== false ) ) {
		$count_chotot++;
	} else {
		$count_phonex++;
	}
}

$main_brands = array(
	'apple'   => array( 'name' => 'Apple', 'slug' => 'apple' ),
	'samsung' => array( 'name' => 'Samsung', 'slug' => 'samsung' ),
	'xiaomi'  => array( 'name' => 'Xiaomi', 'slug' => 'xiaomi' ),
	'oppo'    => array( 'name' => 'OPPO', 'slug' => 'oppo' ),
	'vivo'    => array( 'name' => 'Vivo', 'slug' => 'vivo' ),
	'realme'  => array( 'name' => 'Realme', 'slug' => 'realme' ),
	'honor'   => array( 'name' => 'Honor', 'slug' => 'honor' ),
	'other'   => array( 'name' => 'Khác', 'slug' => 'other' ),
);
?>

<style>
:root {
  --px-primary: #FF001F;
  --px-primary-container: #e60012;
  --px-primary-hover: #D9001B;
  --px-primary-fixed: #FFF0F2;
  --px-primary-fixed-dim: #ffdad5;
  --px-surface: #F6F7F9;
  --px-surface-pure: #ffffff;
  --px-border-subtle: #E5E7EB;
  --px-text-main: #1F1F1F;
  --px-text-secondary: #374151;
  --px-sale: #e60012;
  --px-success: #198754;
}
.px-ds-h1 { font-size:26px; line-height:1.25; font-weight:700; color:#1F1F1F; }
@media(min-width:768px){.px-ds-h1{font-size:30px;}}
@media(min-width:1024px){.px-ds-h1{font-size:34px; line-height:1.2;}}

.px-ds-h2 { font-size:22px; line-height:1.35; font-weight:700; color:#1F1F1F; }
@media(min-width:768px){.px-ds-h2{font-size:24px;}}
@media(min-width:1024px){.px-ds-h2{font-size:26px;}}

.px-ds-h3 { font-size:18px; line-height:1.35; font-weight:600; color:#1F1F1F; }
@media(min-width:768px){.px-ds-h3{font-size:20px;}}

.px-ds-prod-title {
  font-size:15px; line-height:1.45; font-weight:600; color:#1F1F1F;
  min-height:44px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
}
@media(min-width:768px){.px-ds-prod-title{font-size:16px;}}

.px-ds-price-primary { font-size:19px; line-height:1.2; font-weight:700; color:#e60012; }
@media(min-width:768px){.px-ds-price-primary{font-size:21px;}}
@media(min-width:1024px){.px-ds-price-primary{font-size:22px;}}

.px-ds-price-old { font-size:13px; color:#4B5563; text-decoration:line-through; font-weight:500; }
@media(min-width:768px){.px-ds-price-old{font-size:14px;}}

.px-ds-input { font-size:16px !important; line-height:1.5; min-height:44px; }
.px-ds-btn-cta { font-size:15px; font-weight:600; min-height:48px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
.px-touch-target { min-height:44px; min-width:44px; }

.cat-chip.active, .brand-chip.active {
  background-color:#FF001F !important; color:#fff !important; border-color:#FF001F !important;
  box-shadow:0 2px 8px rgba(255,0,31,.25);
}
.cat-chip.active img, .brand-chip.active img {
  filter: brightness(0) invert(1);
}
.no-scrollbar::-webkit-scrollbar{display:none;}
.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
.line-clamp-1{display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;}
.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.phonex-phone-card {
  transition:transform .24s cubic-bezier(.4,0,.2,1), box-shadow .24s cubic-bezier(.4,0,.2,1), border-color .24s ease;
  will-change:transform,box-shadow; display:flex; flex-direction:column;
}
.phonex-phone-card:hover {
  transform:translateY(-4px);
  box-shadow:0 12px 28px -6px rgba(255,0,31,.12), 0 4px 12px -2px rgba(0,0,0,.04);
  border-color:#FF001F;
}
.phonex-phone-card.hidden { display:none !important; }
</style>

<main class="w-full min-h-screen bg-[#F6F7F9] pb-16 font-sans text-[#1F1F1F]">

  <!-- BREADCRUMB -->
  <div class="w-full bg-white border-b border-[#E5E7EB]">
    <div class="max-w-[1440px] mx-auto px-4 py-3">
      <nav class="flex items-center gap-2 text-[13px] sm:text-[14px] text-[#374151] font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="hover:text-[#FF001F] transition-colors flex items-center gap-1 font-semibold">
          <span class="material-symbols-outlined text-[17px]">home</span><span>Trang chủ</span>
        </a>
        <span class="text-gray-400 font-bold">/</span>
        <a href="<?php echo esc_url( home_url('/kho-may-cu/') ); ?>" class="hover:text-[#FF001F] transition-colors font-semibold">Kho Máy Cũ</a>
        <span class="text-gray-400 font-bold">/</span>
        <span class="text-[#1F1F1F] font-bold">Smartphone Like New 99% & Bán Sỉ PhoneX</span>
      </nav>
    </div>
  </div>

  <!-- HERO GRID -->
  <div class="max-w-[1440px] mx-auto px-4 pt-6 pb-2">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

      <!-- MAIN HERO CARD -->
      <div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]"
           style="background-color: var(--px-primary-fixed);">
        <div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
          <span class="material-symbols-outlined text-[240px] text-[#FF001F]">inventory_2</span>
        </div>
        <div class="relative z-10 max-w-2xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/95 border border-[#FF001F]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
            HỆ THỐNG PHÂN PHỐI SỈ &amp; LẺ SMARTPHONE PRE-OWNED • PHONEX KHO MÁY CŨ
          </div>
          <h1 class="px-ds-h1 font-black text-[#1F1F1F] tracking-tight mb-3">
            Kho Máy Cũ PhoneX — Điện Thoại Like New 99% Kiểm Định Chuẩn Flagship
          </h1>
          <p class="text-[14px] sm:text-[16px] text-gray-800 leading-relaxed mb-6 font-medium">
            Tuyển chọn <strong><?php echo esc_html($total_crawled); ?>+ mẫu điện thoại cũ zin keng</strong> từ iPhone, Samsung, Xiaomi, OPPO... Kiểm định 30 bước nghiêm ngặt, phân Grade A/B minh bạch, cam kết zin 100%, bảo hành 12 tháng 1 đổi 1 và cung cấp nguồn sỉ ổn định cho cửa hàng toàn quốc.
          </p>
          <div class="flex flex-wrap gap-2.5 sm:gap-3 text-[12px] sm:text-[13px] font-semibold text-[#1F1F1F]">
            <span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
              <span class="material-symbols-outlined text-[16px] text-[#FF001F]">verified</span>
              Kiểm định 30 bước PhoneX Lab
            </span>
            <span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
              <span class="material-symbols-outlined text-[16px] text-[#FF001F]">security</span>
              Bảo hành VIP 12 tháng 1 đổi 1
            </span>
            <span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
              <span class="material-symbols-outlined text-[16px] text-[#198754]">battery_charging_full</span>
              Pin zin 90% – 100% dung lượng
            </span>
            <span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
              <span class="material-symbols-outlined text-[16px] text-[#198754]">store</span>
              Còn hàng tại showroom
            </span>
            <span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs font-semibold text-[#1F1F1F]">
              <span class="material-symbols-outlined text-[16px] text-[#e60012]">verified</span>
              100% Máy zin chuẩn quốc tế
            </span>
          </div>
        </div>
      </div>

      <!-- RIGHT COMMITMENT CARDS -->
      <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-3.5">

        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[26px]">savings</span>
          </div>
          <div>
            <h2 class="text-[15px] font-bold text-[#1F1F1F] mb-1">Tiết Kiệm 30% – 50% So Với Máy Mới</h2>
            <p class="text-[13px] text-[#374151] font-medium leading-snug">
              Trải nghiệm flagship nguyên bản với chi phí tiết kiệm hàng triệu đồng. Cam kết không cấn móp, không sửa chữa mainboard.
            </p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[26px]">checklist_rtl</span>
          </div>
          <div>
            <h2 class="text-[15px] font-bold text-[#1F1F1F] mb-1">Kiểm Định Kỹ Thuật 30 Bước</h2>
            <p class="text-[13px] text-[#374151] font-medium leading-snug">
              Kiểm tra áp suất kháng nước, camera OIS, màn hình, cảm biến, Face ID/Touch ID và dung lượng pin chuẩn xác trước khi nhập kho.
            </p>
          </div>
        </div>

        <!-- Card 3: Thu Cũ Đổi Mới / Định Giá 30s Action Card -->
        <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="bg-gradient-to-r from-red-50/90 to-amber-50/70 hover:from-red-100/90 hover:to-amber-100/80 rounded-2xl p-4 sm:p-5 border border-red-200/90 shadow-xs flex items-center justify-between gap-3 transition-all group cursor-pointer">
          <div class="flex items-start gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-[#e60012] to-[#ff4757] text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-[26px]">calculate</span>
            </div>
            <div>
              <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                <h2 class="text-[15px] font-bold text-[#1F1F1F] group-hover:text-[#e60012] transition-colors">Thu Cũ Đổi Mới • Định Giá 30s</h2>
                <span class="text-[10px] bg-[#e60012] text-white px-2 py-0.5 rounded-full font-bold">Trợ giá 3Tr</span>
              </div>
              <p class="text-[12.5px] text-[#374151] font-medium leading-snug">
                Định giá máy cũ lấy tiền mặt hoặc lên đời máy like new tiết kiệm hàng triệu đồng.
              </p>
            </div>
          </div>
          <span class="material-symbols-outlined text-gray-400 group-hover:text-[#e60012] group-hover:translate-x-1 transition-all shrink-0 text-[20px]">arrow_forward</span>
        </a>

      </div>
    </div>
  </div>

  <!-- STICKY FILTER BAR (TINH GỌN, KHÔNG BỊ DÀI RA) -->
  <div class="sticky top-0 z-30 bg-[#F6F7F9]/95 backdrop-blur-md border-b border-[#E5E7EB] mt-4 py-2.5 overflow-x-clip shadow-xs">
    <div class="max-w-[1440px] mx-auto px-4 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 w-full">

      <!-- Left: Search Input -->
      <div class="relative w-full md:w-60 lg:w-72 shrink-0">
        <input type="search"
               id="phoneSearchInput"
               class="w-full bg-white border border-[#E5E7EB] rounded-xl pl-9 pr-9 py-2 text-xs sm:text-[14px] text-[#1F1F1F] placeholder-gray-500 focus:outline-none focus:border-[#FF001F] focus:ring-2 focus:ring-[#ffdad5] transition-all font-medium"
               placeholder="Tìm máy cũ (iPhone 15, S24...)..." />
        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
        <button type="button"
                id="clearSearchBtn"
                class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
          <span class="material-symbols-outlined text-[16px]">close</span>
        </button>
      </div>

      <!-- Center: Brand Quick Filters with Official SVG Logos (1 Dải nút cuộn mượt mà, không bị dài ra) -->
      <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-1 min-w-0 flex-1 scroll-smooth" id="usedBrandPills">
        <button type="button"
                class="brand-chip whitespace-nowrap px-3 py-1.5 rounded-full text-[12px] font-bold border border-[#E5E7EB] bg-white text-[#1F1F1F] hover:border-[#FF001F] hover:text-[#FF001F] transition-all inline-flex items-center gap-1.5 shrink-0 active cursor-pointer"
                data-brand="all">
          <span>Tất cả (<?php echo esc_html( $total_crawled ); ?>)</span>
        </button>
        <?php foreach ( $main_brands as $b_key => $b_data ) : 
            $count = $brand_counts[ $b_data['slug'] ] ?? 0;
            if ( 'other' === $b_key ) {
                $count = $total_crawled - (
                    ( $brand_counts['apple'] ?? 0 ) +
                    ( $brand_counts['samsung'] ?? 0 ) +
                    ( $brand_counts['xiaomi'] ?? 0 ) +
                    ( $brand_counts['oppo'] ?? 0 ) +
                    ( $brand_counts['vivo'] ?? 0 ) +
                    ( $brand_counts['realme'] ?? 0 ) +
                    ( $brand_counts['honor'] ?? 0 )
                );
            }
            if ( $count <= 0 ) continue;
        ?>
            <button type="button"
                    class="brand-chip whitespace-nowrap px-3 py-1.5 rounded-full text-[12px] font-semibold border border-[#E5E7EB] bg-white text-[#1F1F1F] hover:border-[#FF001F] hover:text-[#FF001F] transition-all inline-flex items-center gap-1.5 shrink-0 cursor-pointer"
                    data-brand="<?php echo esc_attr( $b_data['slug'] ); ?>">
                <?php if ( function_exists( 'phonex_get_brand_logo_img' ) && 'other' !== $b_key ) : ?>
                    <?php echo phonex_get_brand_logo_img( $b_data['slug'], 'w-3.5 h-3.5 object-contain inline-block shrink-0' ); ?>
                <?php endif; ?>
                <span><?php echo esc_html( $b_data['name'] ); ?> (<?php echo esc_html( $count ); ?>)</span>
            </button>
        <?php endforeach; ?>
      </div>

      <!-- Right Controls: Source, Condition, Price, Sort Selects & Counter -->
      <div class="flex items-center gap-1.5 sm:gap-2 shrink-0 overflow-x-auto no-scrollbar py-0.5 justify-between md:justify-end">
        
        <select id="sourceFilterSelect" class="hidden">
          <option value="all">all</option>
        </select>

        <!-- Condition Filter -->
        <div class="relative shrink-0">
          <select id="conditionFilterSelect"
                  class="bg-white border border-[#E5E7EB] rounded-xl px-2.5 py-1.5 text-xs sm:text-[13px] text-[#1F1F1F] font-semibold focus:outline-none focus:border-[#FF001F] cursor-pointer">
            <option value="all">Tình trạng: Tất cả</option>
            <option value="grade-a">Grade A (99% Like New)</option>
            <option value="grade-b">Grade B (95% - 98%)</option>
            <option value="grade-c">Grade C (90% Tiết kiệm)</option>
          </select>
        </div>

        <!-- Price Range Filter -->
        <div class="relative shrink-0">
          <select id="priceFilterSelect"
                  class="bg-white border border-[#E5E7EB] rounded-xl px-2.5 py-1.5 text-xs sm:text-[13px] text-[#1F1F1F] font-semibold focus:outline-none focus:border-[#FF001F] cursor-pointer">
            <option value="all">Giá: Tất cả</option>
            <option value="under-5m">&lt; 5 triệu</option>
            <option value="5m-10m">5 – 10 tr</option>
            <option value="10m-15m">10 – 15 tr</option>
            <option value="15m-20m">15 – 20 tr</option>
            <option value="above-20m">&gt; 20 triệu</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div class="relative shrink-0">
          <select id="sortFilterSelect"
                  class="bg-white border border-[#E5E7EB] rounded-xl px-2.5 py-1.5 text-xs sm:text-[13px] text-[#1F1F1F] font-semibold focus:outline-none focus:border-[#FF001F] cursor-pointer">
            <option value="featured">Đề xuất PhoneX</option>
            <option value="price-asc">Giá: Thấp &rarr; Cao</option>
            <option value="price-desc">Giá: Cao &rarr; Thấp</option>
            <option value="discount-desc">Giảm sâu nhất (%)</option>
          </select>
        </div>

        <!-- Counter & Reset -->
        <span class="hidden 2xl:inline-block text-xs font-semibold text-gray-500 whitespace-nowrap pl-1">
          <strong id="resultsCount" class="text-[#FF001F] font-bold"><?php echo esc_html(min(20, $total_crawled)); ?></strong>/<span id="totalAvailableCount"><?php echo esc_html($total_crawled); ?></span> máy
        </span>
        <button type="button"
                id="resetAllFiltersBtn"
                class="hidden text-xs text-[#FF001F] hover:underline font-bold flex items-center gap-0.5 whitespace-nowrap cursor-pointer shrink-0"
                title="Đặt lại bộ lọc">
          <span class="material-symbols-outlined text-[15px]">restart_alt</span>
          <span class="hidden sm:inline">Đặt lại</span>
        </button>

      </div>

    </div>
  </div>

  <!-- PRODUCT GRID -->
  <div class="max-w-[1440px] mx-auto px-4 pt-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="px-ds-h2 font-black text-[#1F1F1F] tracking-tight">Danh Sách Kho Máy Cũ PhoneX</h2>
        <p class="text-[14px] text-[#374151] font-medium mt-1">Phân Grade minh bạch • Zin nguyên bản 100% • Bảo hành 12 tháng 1 đổi 1</p>
      </div>
    </div>

    <?php
    $is_tra_gop_mode = isset( $_GET['mode'] ) && 'tra-gop' === $_GET['mode'];
    if ( $is_tra_gop_mode ) :
    ?>
      <!-- INSTALLMENT SELECTION MODE BANNER (Chuyển trang trực tiếp, không popup) -->
      <div class="mb-6 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-red-600 via-[#e60012] to-[#b7000c] text-white shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-red-500">
        <div class="flex items-center gap-3.5">
          <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shrink-0 shadow-inner">
            <span class="material-symbols-outlined text-white text-[28px]">credit_card</span>
          </div>
          <div>
            <div class="text-[11px] font-extrabold uppercase tracking-wider text-red-100 flex items-center gap-1.5">
              <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 animate-ping"></span>
              <span>Chế độ chọn máy mua trả góp 0%</span>
            </div>
            <h3 class="text-base sm:text-lg font-black text-white mt-0.5">
              Bạn đang chọn máy từ kho để cập nhật bảng tính trả góp
            </h3>
            <p class="text-xs sm:text-sm text-red-100 font-medium mt-0.5">
              Bấm nút <strong class="text-yellow-300">"Chọn máy này trả góp 0%"</strong> trên bất kỳ máy nào để quay lại bảng tính khoản vay!
            </p>
          </div>
        </div>
        <div class="shrink-0 flex items-center gap-2">
          <a href="<?php echo esc_url( home_url( '/tra-gop/' ) ); ?>" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-white text-[#b7000c] hover:bg-red-50 font-bold text-xs sm:text-sm transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Quay lại trang tính trả góp</span>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <div id="catalog-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 sm:gap-4 md:gap-5">
      <?php if ( ! empty( $crawled_products ) ) : ?>
        <?php foreach ( $crawled_products as $idx => $prod ) : ?>
          <?php
          $name         = $prod['name'];
          $raw_name     = $prod['raw_name'] ?? $name;
          $price_num    = (int) $prod['price'];
          $old_num      = (int) $prod['old_price'];
          $discount_pct = (int) $prod['discount_pct'];
          $brand        = $prod['brand'];
          $subfolder    = $prod['subfolder'];
          $type_name    = $prod['type'];
          $condition    = $prod['condition'] ?? 'Grade A 99%';
          $battery      = $prod['battery'] ?? 'Pin 95% - 100%';
          $specs        = $prod['specs'] ?? array();
          $img_src      = $prod['image'];
          if ( ! empty( $img_src ) && strpos( $img_src, 'http' ) !== 0 ) {
              $img_src = get_template_directory_uri() . '/' . ltrim( $img_src, '/' );
          }
          $price_fmt    = number_format( $price_num, 0, ',', '.' ) . '₫';
          $old_fmt      = $old_num ? number_format( $old_num, 0, ',', '.' ) . '₫' : '';
          $saving_num   = max( 0, $old_num - $price_num );
          $stock_qty    = (int) ( $prod['stock_quantity'] ?? 5 );
          $display_title = ( strpos( $raw_name, 'Điện thoại' ) === false ) ? 'Điện thoại ' . $raw_name : $raw_name;
          $saving_fmt   = $saving_num ? number_format( $saving_num, 0, ',', '.' ) . '₫' : '';
          $is_hidden    = ( $idx >= 20 );

          $is_chotot    = ! empty( $prod['is_chotot'] ) || ( isset( $prod['source_name'] ) && stripos( $prod['source_name'], 'Chợ Tốt' ) !== false );
          $source_tag   = $is_chotot ? 'chotot' : 'phonex';

          $grade_code   = $prod['grade'] ?? '';
          $cond_str     = mb_strtolower( $condition, 'UTF-8' );
          if ( $grade_code === 'GRADE_C' || strpos( $cond_str, 'grade c' ) !== false || strpos( $cond_str, '90%' ) !== false ) {
              $cond_tag = 'grade-c';
              $grade_badge_style = 'text-[#B76E00] bg-[#FFF8E1] border border-[#FFE082]';
          } elseif ( $grade_code === 'GRADE_B' || strpos( $cond_str, 'grade b' ) !== false || strpos( $cond_str, '98%' ) !== false || strpos( $cond_str, '95%' ) !== false ) {
              $cond_tag = 'grade-b';
              $grade_badge_style = 'text-[#0052CC] bg-[#DEEBFF] border border-[#B3D4FF]';
          } else {
              $cond_tag = 'grade-a';
              $grade_badge_style = 'text-[#b7000c] bg-[#FFF0F2] border border-[#ffdad5]';
          }

          $prod_link    = ! empty( $prod['permalink'] ) ? $prod['permalink'] : home_url( '/product/' . sanitize_title( $raw_name ) . '/' );
          $source_url   = $prod['source_url'] ?? '';
          $seller_loc   = $prod['seller_location'] ?? '';
          $installment_url = home_url( '/tra-gop/?id=' . ( ! empty( $prod['id'] ) ? $prod['id'] : '' ) . '&product=' . urlencode( $display_title ) . '&price=' . $price_num . '&img=' . urlencode( $img_src ) . '&grade=' . urlencode( $condition ) );
          ?>
          <!-- SECTION 10 PRODUCT CARD -->
          <div class="phonex-phone-card bg-white rounded-xl p-3 sm:p-3.5 border border-[#E5E7EB] shadow-2xs relative group <?php echo $is_hidden ? 'hidden' : ''; ?>"
               style="<?php echo $is_hidden ? 'display:none !important;' : ''; ?>"
               data-idx="<?php echo esc_attr($idx); ?>"
               data-brand="<?php echo esc_attr($brand); ?>"
               data-cat="<?php echo esc_attr($subfolder); ?>"
               data-source="<?php echo esc_attr($source_tag); ?>"
               data-condition="<?php echo esc_attr($cond_tag); ?>"
               data-price="<?php echo esc_attr($price_num); ?>"
               data-discount="<?php echo esc_attr($discount_pct); ?>"
               data-name="<?php echo esc_attr( mb_strtolower($display_title, 'UTF-8') ); ?>"
               data-specs="<?php echo esc_attr( mb_strtolower( implode(' ', $specs), 'UTF-8' ) ); ?>">

            <!-- Top Badges (Tối đa 2 badge theo Section 10) -->
            <div class="flex items-center justify-between gap-1 mb-2">
              <span class="text-[11px] font-bold <?php echo esc_attr($grade_badge_style); ?> px-2 py-0.5 rounded-[6px] truncate max-w-[140px]" title="<?php echo esc_attr($condition); ?>">
                <?php echo esc_html($condition); ?>
              </span>
              <a href="<?php echo esc_url( $installment_url ); ?>"
                 class="text-[11px] font-bold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 px-2 py-0.5 rounded-[6px] shrink-0 transition-colors"
                 title="Mở trang tính trả góp 0%">
                Trả góp 0% &rarr;
              </a>
            </div>

            <!-- Image 1:1 vuông aspect-square, object-contain (Click to Product Details) -->
            <a href="<?php echo esc_url($prod_link); ?>"
               class="relative w-full aspect-square rounded-xl overflow-hidden bg-white border border-gray-100 mb-3 flex items-center justify-center group-hover:border-[#FF001F]/40 transition-colors">
              <img src="<?php echo esc_url($img_src); ?>"
                   alt="<?php echo esc_attr($display_title); ?>"
                   class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300"
                   loading="lazy" width="300" height="300" />
              <?php if ( $discount_pct > 0 ) : ?>
                <div class="absolute top-2 left-2 bg-[#e60012] text-white font-bold text-[11px] px-2 py-0.5 rounded-[6px] shadow-xs">
                  -<?php echo esc_html($discount_pct); ?>%
                </div>
              <?php endif; ?>
              <div class="absolute bottom-2 left-2 flex items-center gap-1 bg-white/95 backdrop-blur-sm px-2 py-0.5 rounded-full text-[10px] font-bold text-[#1F2937] shadow-2xs border border-gray-200">
                <span class="material-symbols-outlined text-[12px] text-[#FF001F]">battery_charging_full</span>
                <span class="line-clamp-1 max-w-[110px]"><?php echo esc_html($battery); ?></span>
              </div>
            </a>

            <!-- Info Block -->
            <div class="flex flex-col flex-1 gap-1.5">
              <div class="flex items-center gap-1.5">
                <span class="text-[11px] font-bold text-[#1F1F1F] bg-[#F9FAFB] border border-gray-200 px-1.5 py-0.5 rounded-[6px] inline-flex items-center gap-1">
                  <?php if ( function_exists('phonex_get_brand_logo_img') ) : ?>
                    <?php echo phonex_get_brand_logo_img( $brand, 'w-3 h-3 object-contain inline-block' ); ?>
                  <?php endif; ?>
                  <span><?php echo esc_html($brand); ?></span>
                </span>
                <span class="text-[11px] text-[#198754] font-semibold flex items-center gap-0.5">
                  <span class="material-symbols-outlined text-[13px]">verified</span> Đã kiểm định 30 bước
                </span>
              </div>

              <!-- Title (Line clamp 2, min height 44px, Click to Product Details) -->
              <h3 class="px-ds-prod-title">
                <a href="<?php echo esc_url($prod_link); ?>" class="hover:text-[#FF001F] transition-colors">
                  <?php echo esc_html($display_title); ?>
                </a>
              </h3>

              <!-- Stock Indicator (Chấm xanh #198754 còn hàng tại showroom) -->
              <div class="flex items-center gap-1.5 text-[12px] font-bold text-[#198754]">
                <span class="w-2 h-2 rounded-full bg-[#198754] shrink-0 animate-pulse"></span>
                <span class="truncate">Còn hàng tại showroom</span>
              </div>

              <!-- Price Block (Giá bán to đậm 18-22px đỏ #e60012) -->
              <div class="mt-auto pt-2 bg-[#F9FAFB] p-2.5 rounded-xl border border-gray-100">
                <div class="flex items-baseline justify-between gap-1 flex-wrap">
                  <div class="flex items-baseline gap-1">
                    <span class="text-[12px] font-semibold text-[#374151]">Từ:</span>
                    <strong class="px-ds-price-primary text-[19px] sm:text-[21px]"><?php echo esc_html($price_fmt); ?></strong>
                  </div>
                  <?php if ( $discount_pct > 0 ) : ?>
                    <span class="text-[11px] font-bold text-white bg-[#e60012] px-1.5 py-0.5 rounded-[6px] shadow-2xs">-<?php echo esc_html($discount_pct); ?>%</span>
                  <?php endif; ?>
                </div>

                <?php if ( $old_num > $price_num ) : ?>
                  <div class="text-[12px] text-[#4B5563] mt-1 flex items-center justify-between font-medium">
                    <span>Giá máy mới: <span class="line-through"><?php echo esc_html($old_fmt); ?></span></span>
                  </div>
                  <?php if ( $saving_num > 0 ) : ?>
                    <div class="text-[11px] font-bold text-[#198754] mt-0.5">
                      Tiết kiệm: <?php echo esc_html($saving_fmt); ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

                <!-- Installment monthly estimate & link to /tra-gop/ -->
                <?php
                $monthly_est = $price_num > 0 ? round( $price_num / 6 ) : 0;
                $monthly_est_fmt = number_format( $monthly_est, 0, ',', '.' ) . '₫/tháng';
                ?>
                <a href="<?php echo esc_url( $installment_url ); ?>"
                   class="w-full mt-2 py-1.5 px-2 bg-gradient-to-r from-red-50 to-amber-50/70 hover:from-red-100 hover:to-amber-100 border border-red-200/80 rounded-lg text-left flex items-center justify-between transition-all group/inst">
                  <div class="flex items-center gap-1.5 text-[11px] font-bold text-[#b7000c] leading-tight">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#e60012] shrink-0 animate-pulse"></span>
                    <span>Góp 0%: Từ <strong class="text-[#e60012] font-black"><?php echo esc_html($monthly_est_fmt); ?></strong></span>
                  </div>
                  <span class="text-[10px] font-extrabold text-[#b7000c] bg-white px-1.5 py-0.5 rounded border border-red-200 group-hover/inst:bg-[#e60012] group-hover/inst:text-white transition-colors shrink-0">
                    Bảng tính &rarr;
                  </span>
                </a>
              </div>

              <!-- Button CTA (Min 48px on mobile, radius 8px, font 15px) -->
              <div class="mt-2.5 flex flex-col gap-1.5">
                <?php if ( $is_tra_gop_mode ) : ?>
                  <a href="<?php echo esc_url( $installment_url ); ?>"
                     class="w-full py-2.5 px-3 bg-[#e60012] hover:bg-[#b7000c] text-white rounded-[8px] text-[13px] font-black flex items-center justify-center gap-1.5 transition-all shadow-md ring-2 ring-red-400">
                    <span class="material-symbols-outlined text-[17px]">check_circle</span>
                    <span>Chọn máy này trả góp 0% &rarr;</span>
                  </a>
                  <a href="<?php echo esc_url($prod_link); ?>"
                     class="w-full py-1.5 px-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-center justify-center text-[12px] font-semibold rounded-[8px] border border-gray-200 transition-all">
                    Xem thông số máy &rarr;
                  </a>
                <?php else : ?>
                  <a href="<?php echo esc_url($prod_link); ?>"
                     class="w-full px-ds-btn-cta bg-[#FF001F] hover:bg-[#D9001B] text-white text-center justify-center text-[14px] sm:text-[15px] px-3 py-2.5 shadow-sm font-semibold rounded-[8px] transition-all">
                    Xem chi tiết &amp; Thông số &rarr;
                  </a>
                  <a href="<?php echo esc_url( $installment_url ); ?>"
                     class="w-full py-2 px-2.5 bg-white hover:bg-[#FFF0F2] text-[#e60012] hover:text-[#b7000c] border border-[#ffdad5] rounded-[8px] text-[12.5px] font-bold flex items-center justify-center gap-1.5 transition-all shadow-2xs">
                    <span class="material-symbols-outlined text-[16px]">calculate</span>
                    <span>Mua Trả Góp 0% • Thu Cũ Đổi Mới</span>
                  </a>
                <?php endif; ?>
                <button type="button"
                        class="w-full text-center text-[11.5px] text-[#374151] hover:text-[#FF001F] font-semibold py-0.5 open-phone-modal-trigger transition-colors"
                        data-idx="<?php echo esc_attr($idx); ?>">
                  Xem danh sách còn hàng tại showroom &rarr;
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col-span-full text-center py-20 text-[#374151]">
          <span class="material-symbols-outlined text-[64px] text-gray-200 block mb-3">inventory_2</span>
          <p class="text-[16px] font-semibold text-[#1F1F1F]">Chưa có dữ liệu máy cũ trong kho</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- No Results State -->
    <div id="noResultsState" class="hidden flex-col items-center justify-center py-20 text-[#374151]">
      <span class="material-symbols-outlined text-[64px] text-gray-400 block mb-3">search_off</span>
      <p class="text-[17px] font-bold text-[#1F1F1F]">Không tìm thấy máy cũ phù hợp</p>
      <p class="text-[14px] mt-1 mb-5 text-[#374151] font-medium">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
      <button type="button" id="noResultsResetBtn" class="px-ds-btn-cta bg-[#FF001F] text-white px-6 py-2.5 text-[14px] rounded-lg shadow-sm">
        Xóa bộ lọc &amp; Xem tất cả
      </button>
    </div>

    <!-- Load More Section -->
    <?php if ( $total_crawled > 20 ) : ?>
      <div id="loadMoreSection" class="mt-10 flex flex-col items-center gap-4">
        <div class="w-full max-w-sm">
          <div class="flex items-center justify-between text-[12px] text-[#374151] font-medium mb-1.5">
            <span>Đang hiển thị <strong id="shownCount" class="text-[#1F1F1F]">20</strong> / <strong><?php echo esc_html($total_crawled); ?></strong> máy</span>
          </div>
          <div class="w-full bg-[#E5E7EB] rounded-full h-1.5 overflow-hidden">
            <div id="progressBar" class="bg-[#FF001F] h-1.5 rounded-full transition-all duration-500"
                 style="width:<?php echo min(100, round(20 / max(1,$total_crawled) * 100)); ?>%"></div>
          </div>
        </div>
        <button type="button" id="loadMoreBtn"
                class="px-ds-btn-cta bg-white hover:bg-[#FFF0F2] text-[#FF001F] border-2 border-[#FF001F] px-8 py-3 text-[15px] gap-2 rounded-xl shadow-xs transition-colors">
          <span class="material-symbols-outlined text-[20px]">expand_more</span>
          <span>Xem thêm máy cũ trong kho</span>
        </button>
      </div>
    <?php endif; ?>
  </div>

  <!-- =========================================================================
       B2B WHOLESALE SECTION (BÁN SỈ ĐIỆN THOẠI CŨ PHONEX)
       ========================================================================= -->
  <div id="b2b" class="max-w-[1440px] mx-auto px-4 pt-16">
    <div class="rounded-3xl p-6 sm:p-8 md:p-10 border border-red-200 bg-gradient-to-br from-red-50/70 via-white to-amber-50/50 shadow-sm">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-[#b7000c] text-xs font-bold uppercase tracking-wider mb-3">
            <span class="material-symbols-outlined text-[16px]">storefront</span>
            CHÍNH SÁCH BÁN SỈ &amp; ĐẠI LÝ B2B PHONEX
          </div>
          <h2 class="px-ds-h2 font-black text-[#1F1F1F] tracking-tight mb-3">
            Cung Ứng Sỉ Điện Thoại Cũ Đã Phân Grade Cho Cửa Hàng &amp; Đối Tác Toàn Quốc
          </h2>
          <p class="text-sm sm:text-base text-gray-800 leading-relaxed mb-6 font-medium">
            PhoneX vận hành theo chuỗi cung ứng khép kín: <strong>Thu mua trực tiếp → Kiểm định kỹ thuật 30 bước → Phân loại Grade A/B/C → Nhập kho sỉ</strong>. Cung cấp báo giá sỉ linh hoạt theo lô, hỗ trợ bảo hành đổi trả đại lý và giao hàng hỏa tốc trong 2h.
          </p>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="p-3.5 bg-white rounded-xl border border-gray-200 shadow-2xs">
              <div class="text-xs text-gray-700 font-bold">Lô từ 5 – 10 máy</div>
              <div class="text-base font-bold text-[#FF001F] mt-0.5">Chiết khấu 3% – 5%</div>
              <div class="text-[11px] text-gray-600 font-semibold mt-1">Hỗ trợ đổi mới 15 ngày</div>
            </div>
            <div class="p-3.5 bg-white rounded-xl border border-gray-200 shadow-2xs">
              <div class="text-xs text-gray-700 font-bold">Lô từ 10 – 30 máy</div>
              <div class="text-base font-bold text-[#FF001F] mt-0.5">Chiết khấu 6% – 8%</div>
              <div class="text-[11px] text-gray-600 font-semibold mt-1">Hỗ trợ công nợ linh hoạt</div>
            </div>
            <div class="p-3.5 bg-white rounded-xl border border-gray-200 shadow-2xs">
              <div class="text-xs text-gray-700 font-bold">Lô trên 50 máy</div>
              <div class="text-base font-bold text-[#FF001F] mt-0.5">Giá gốc nhập kho</div>
              <div class="text-[11px] text-gray-600 font-semibold mt-1">Bảo hành VIP đại lý</div>
            </div>
          </div>
        </div>

        <div class="w-full lg:w-96 bg-white p-6 rounded-2xl border border-gray-200 shadow-md shrink-0">
          <div class="flex items-center justify-between mb-1">
            <h3 class="font-bold text-[#1F1F1F] text-base">Đăng ký báo giá sỉ &amp; Công nợ B2B</h3>
            <span class="text-[10px] bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-bold">Gối đầu 15–30 ngày</span>
          </div>
          <p class="text-xs text-gray-600 font-medium mb-4">Chuyên viên phụ trách B2B sẽ liên hệ hoặc kết bạn Zalo trong 15 phút</p>
          <form id="pxB2BWholesaleForm" class="space-y-3" onsubmit="pxSubmitB2BWholesaleForm(event)">
            <div>
              <label class="block text-xs font-bold text-gray-900 mb-1">Họ tên / Tên cửa hàng <span class="text-red-500">*</span></label>
              <input type="text" id="b2bCustName" required placeholder="Ví dụ: Hoàng Tuấn / Mobile Store" class="w-full px-ds-input border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-[#FF001F] outline-none" />
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-900 mb-1">Số điện thoại / Zalo <span class="text-red-500">*</span></label>
              <input type="tel" id="b2bCustPhone" required placeholder="09xx xxx xxx" class="w-full px-ds-input border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-[#FF001F] outline-none" />
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="block text-xs font-bold text-gray-900 mb-1">Dòng máy quan tâm</label>
                <select id="b2bCustCategory" class="w-full border border-gray-200 rounded-lg px-2 py-2 text-xs focus:border-[#FF001F] outline-none font-medium text-gray-800">
                  <option value="iPhone Cũ (Grade A / Like New)">iPhone Cũ Grade A</option>
                  <option value="Samsung Galaxy Cũ">Samsung Galaxy</option>
                  <option value="Xiaomi & Android các dòng">Xiaomi &amp; Android</option>
                  <option value="Lô hỗn hợp số lượng lớn">Lô hỗn hợp</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-900 mb-1">Số lượng lô dự kiến</label>
                <select id="b2bCustQty" class="w-full border border-gray-200 rounded-lg px-2 py-2 text-xs focus:border-[#FF001F] outline-none font-medium text-gray-800">
                  <option value="5-10 máy (CK 3-5%)">5 – 10 máy (CK 3-5%)</option>
                  <option value="10-30 máy (CK 6-8%)">10 – 30 máy (CK 6-8%)</option>
                  <option value="Trên 50 máy (Giá gốc)">Trên 50 máy (Giá gốc)</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-900 mb-1">Hình thức thanh toán &amp; công nợ</label>
              <select id="b2bCustPaymentMethod" class="w-full border border-purple-200 rounded-lg px-2.5 py-2 text-xs focus:border-[#FF001F] outline-none font-bold text-purple-700 bg-purple-50/50">
                <option value="Đăng ký công nợ gối đầu 15–30 ngày">Đăng ký công nợ gối đầu 15–30 ngày</option>
                <option value="Tiền mặt / Chuyển khoản (CK cao nhất)">Tiền mặt / Chuyển khoản (CK cao nhất)</option>
                <option value="Nhập sỉ trả chậm theo lô">Nhập sỉ trả chậm theo lô</option>
              </select>
            </div>
            <button type="submit" id="b2bSubmitBtn" class="w-full px-ds-btn-cta bg-[#FF001F] hover:bg-[#D9001B] text-white font-bold py-2.5 rounded-lg shadow-sm text-sm cursor-pointer">
              <span id="b2bSubmitBtnText">Nhận Báo Giá Sỉ &amp; Đăng Ký Công Nợ</span>
            </button>
            <div id="b2bSuccessNotice" class="hidden p-3 rounded-lg bg-green-50 border border-green-200 text-green-800 text-xs font-bold text-center">
              🎉 Đã gửi đăng ký thành công! Chuyên viên B2B PhoneX sẽ liên hệ lại qua Zalo trong 15 phút.
            </div>
            <div class="text-center pt-1">
              <a href="tel:18006870" class="text-xs text-[#FF001F] font-bold hover:underline">
                Hoặc gọi Hotline B2B: 1800.6870 (wholesale@phonex.vn)
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================================
       BUYING GUIDE — CẨM NANG CHỌN MUA ĐIỆN THOẠI CŨ CHUẨN PHONEX
       ========================================================================= -->
  <div class="max-w-[1440px] mx-auto px-4 pt-16">
    <div class="bg-white rounded-2xl p-6 sm:p-8 md:p-10 border border-[#E5E7EB] shadow-xs">

      <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="text-[12px] font-bold text-[#b7000c] bg-[#FFF0F2] px-3 py-1 rounded-full uppercase tracking-wider">Cẩm Nang Mua Sắm</span>
        <h2 class="px-ds-h2 font-bold text-[#1F1F1F] mt-3 mb-2">Kinh Nghiệm Chọn Mua Điện Thoại Cũ Đẹp Như Mới &amp; An Tâm 100%</h2>
        <p class="text-[14px] sm:text-[15px] text-[#374151] font-medium">3 tiêu chí vàng độc quyền tại hệ sinh thái PhoneX giúp bạn sở hữu smartphone cao cấp với chi phí tối ưu nhất.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Pillar 1: Phân Loại Tình Trạng Máy -->
        <div class="p-5 rounded-xl bg-[#F6F7F9] border border-gray-200 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">grade</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#1F1F1F] mb-2">Phân Biệt Grade A 99% &amp; Grade B 98% Rõ Ràng</h3>
          <p class="text-[13px] sm:text-[14px] text-[#374151] leading-relaxed font-normal">
            Máy Grade A (Like New 99%) gần như không có vết xước, vỏ ngoài sáng bóng, pin zin từ 95% trở lên. Máy Grade B (98%) có thể phẩy nhẹ li ti nhưng giá thành tiết kiệm thêm từ 1–2 triệu đồng, hoàn hảo cho người dùng tìm kiếm hiệu năng tối đa.
          </p>
        </div>

        <!-- Pillar 2: Quy Trình Kiểm Định Kỹ Thuật Nghiêm Ngặt -->
        <div class="p-5 rounded-xl bg-[#F6F7F9] border border-gray-200 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">fact_check</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#1F1F1F] mb-2">Quy Trình Kiểm Tra Kỹ Thuật PhoneX Lab</h3>
          <p class="text-[13px] sm:text-[14px] text-[#374151] leading-relaxed font-normal">
            Mỗi thiết bị đều trải qua kiểm tra nghiêm ngặt: Kiểm tra màn hình không điểm chết hay ám ố, test tốc độ sạc nhanh, camera chống rung OIS, cảm biến FaceID/Vân tay và bo mạch zin 100% chưa qua sửa chữa.
          </p>
        </div>

        <!-- Pillar 3: Chính Sách Bảo Hành VIP & Đổi Trả -->
        <div class="p-5 rounded-xl bg-[#F6F7F9] border border-gray-200 flex flex-col">
          <div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[26px]">verified_user</span>
          </div>
          <h3 class="text-[16px] font-bold text-[#1F1F1F] mb-2">Bảo Hành VIP 12 Tháng, 1 Đổi 1 Trong 30 Ngày</h3>
          <p class="text-[13px] sm:text-[14px] text-[#374151] leading-relaxed font-normal">
            Xóa tan hoàn toàn nỗi lo mua máy cũ: PhoneX áp dụng chính sách bao test 1 đổi 1 miễn phí trong 30 ngày đầu tiên nếu phát sinh bất kỳ lỗi phần cứng nào từ nhà sản xuất, bảo hành trọn vẹn 12 tháng tại các showroom PhoneX.
          </p>
        </div>

      </div>
    </div>
  </div>

  <!-- =========================================================================
       PHONEX SHOWROOM DEVICE INVENTORY MODAL
       ========================================================================= -->
  <div id="phoneDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden my-auto max-h-[90vh] flex flex-col">

      <!-- Modal Header -->
      <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-[#F6F7F9]">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-white border border-gray-200 p-1 flex items-center justify-center shrink-0">
            <img id="modalPhoneImg" src="" alt="" class="w-full h-full object-contain" />
          </div>
          <div>
            <span class="text-[11px] font-bold text-[#b7000c] bg-[#FFF0F2] px-2 py-0.5 rounded uppercase">PhoneX Certified Pre-Owned</span>
            <h3 id="modalPhoneTitle" class="text-[15px] sm:text-[17px] font-bold text-[#1F1F1F] leading-tight mt-0.5"></h3>
          </div>
        </div>
        <button type="button" id="closePhoneModalBtn" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition-colors">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <!-- Modal Body (List of specific machines by store & IMEI) -->
      <div class="p-5 overflow-y-auto flex-1 divide-y divide-gray-100">
        <div class="mb-3 flex items-center justify-between text-[13px] text-[#374151] font-semibold">
          <span>Danh sách máy thực tế còn hàng tại showroom:</span>
          <span class="font-bold text-[#198754] flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">verified</span> Đã Kiểm Định Kỹ Thuật
          </span>
        </div>

        <div id="modalMachineList" class="flex flex-col gap-3.5 pt-2">
          <!-- Dynamically populated via JS -->
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="px-5 py-3.5 border-t border-gray-100 bg-[#F6F7F9] flex flex-wrap items-center justify-between gap-3">
        <div class="text-[12px] text-[#1F2937] font-semibold flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[16px] text-green-600">check_circle</span>
          <span>Bao test 1 đổi 1 trong 30 ngày • Bảo hành 12 tháng tại 128 Showroom</span>
        </div>
        <a href="<?php echo esc_url( home_url('/lien-he/') ); ?>"
           class="px-ds-btn-cta bg-[#FF001F] hover:bg-[#D9001B] text-white text-[13px] sm:text-[14px] px-5 py-2 rounded-lg font-bold">
          Liên hệ giữ máy ngay
        </a>
      </div>

    </div>
  </div>

</main>

<script id="phonexUsedPhonesData" type="application/json">
<?php echo json_encode( $client_products, JSON_UNESCAPED_UNICODE ); ?>
</script>

<script>
(function(){
'use strict';
const allCards          = Array.from(document.querySelectorAll('.phonex-phone-card'));
const searchInput       = document.getElementById('phoneSearchInput');
const clearBtn          = document.getElementById('clearSearchBtn');
const brandChips        = document.querySelectorAll('.brand-chip');
const sourceSelect      = document.getElementById('sourceFilterSelect');
const condSelect        = document.getElementById('conditionFilterSelect');
const priceSelect       = document.getElementById('priceFilterSelect');
const sortSelect        = document.getElementById('sortFilterSelect');
const resetBtn          = document.getElementById('resetAllFiltersBtn');
const loadMoreBtn       = document.getElementById('loadMoreBtn');
const loadMoreSec       = document.getElementById('loadMoreSection');
const noResults         = document.getElementById('noResultsState');
const resultsCount      = document.getElementById('resultsCount');
const totalAvailEl      = document.getElementById('totalAvailableCount');
const shownCount        = document.getElementById('shownCount');
const progressBar       = document.getElementById('progressBar');
const noResultsResetBtn = document.getElementById('noResultsResetBtn');

// Modal Elements
const modal             = document.getElementById('phoneDetailModal');
const modalTitle        = document.getElementById('modalPhoneTitle');
const modalImg          = document.getElementById('modalPhoneImg');
const modalMachineList  = document.getElementById('modalMachineList');
const closeModalBtn     = document.getElementById('closePhoneModalBtn');

let phonesData = [];
try {
  const rawDataElem = document.getElementById('phonexUsedPhonesData');
  if (rawDataElem) {
    phonesData = JSON.parse(rawDataElem.textContent);
  }
} catch(e) {
  phonesData = [];
}

let currentBrand = 'all', currentSource = 'all', currentCond = 'all', currentPrice = 'all', currentSort = 'featured', searchQuery = '', visibleLimit = 20;

function matchPrice(p, r) {
  if (r === 'all') return true;
  if (r === 'under-5m') return p < 5000000;
  if (r === '5m-10m') return p >= 5000000 && p <= 10000000;
  if (r === '10m-15m') return p >= 10000000 && p <= 15000000;
  if (r === '15m-20m') return p >= 15000000 && p <= 20000000;
  if (r === 'above-20m') return p > 20000000;
  return true;
}

function matchBrand(brand, cat, targetBrand) {
  if (!targetBrand || targetBrand === 'all') return true;
  brand = (brand || '').toLowerCase();
  cat = (cat || '').toLowerCase();
  const bTarget = targetBrand.toLowerCase();
  if (bTarget === 'apple' || bTarget === 'iphone') {
    return brand === 'apple' || cat === 'iphone';
  }
  if (bTarget === 'samsung') {
    return brand === 'samsung' || cat === 'samsung';
  }
  if (bTarget === 'xiaomi') {
    return brand === 'xiaomi' || cat === 'xiaomi';
  }
  if (bTarget === 'oppo') {
    return brand === 'oppo' || cat === 'oppo';
  }
  if (bTarget === 'vivo') {
    return brand === 'vivo' || cat === 'vivo';
  }
  if (bTarget === 'realme') {
    return brand === 'realme' || cat === 'realme';
  }
  if (bTarget === 'honor') {
    return brand === 'honor' || cat === 'honor';
  }
  if (bTarget === 'other' || bTarget === 'khac') {
    return !['apple', 'samsung', 'oppo', 'xiaomi', 'vivo', 'realme', 'honor'].includes(brand) &&
           !['apple', 'samsung', 'oppo', 'xiaomi', 'vivo', 'realme', 'honor', 'iphone'].includes(cat);
  }
  return brand === bTarget || cat === bTarget;
}

function run() {
  let filtered = allCards.filter(c => {
    const cat    = c.dataset.cat || '',
          brand  = c.dataset.brand || '',
          source = c.dataset.source || 'phonex',
          cond   = c.dataset.condition || '',
          price  = parseInt(c.dataset.price, 10) || 0,
          name   = c.dataset.name || '',
          specs  = c.dataset.specs || '';

    if (currentSource !== 'all' && source !== currentSource) return false;
    if (!matchBrand(brand, cat, currentBrand)) return false;
    if (currentCond !== 'all' && cond !== currentCond) return false;
    if (!matchPrice(price, currentPrice)) return false;

    if (searchQuery) {
      const q = searchQuery.toLowerCase();
      if (!name.includes(q) && !specs.includes(q) && !brand.toLowerCase().includes(q)) return false;
    }
    return true;
  });

  filtered.sort((a, b) => {
    const ap = parseInt(a.dataset.price, 10) || 0,
          bp = parseInt(b.dataset.price, 10) || 0,
          ad = parseInt(a.dataset.discount, 10) || 0,
          bd = parseInt(b.dataset.discount, 10) || 0,
          ai = parseInt(a.dataset.idx, 10) || 0,
          bi = parseInt(b.dataset.idx, 10) || 0;

    if (currentSort === 'price-asc') return ap - bp;
    if (currentSort === 'price-desc') return bp - ap;
    if (currentSort === 'discount-desc') return bd - ad;
    return ai - bi;
  });

  allCards.forEach(c => {
    c.classList.add('hidden');
    c.style.display = 'none';
  });

  filtered.slice(0, visibleLimit).forEach(c => {
    c.classList.remove('hidden');
    c.style.removeProperty('display');
  });

  const total = filtered.length,
        shown = Math.min(total, visibleLimit),
        totalAll = allCards.length;

  if (resultsCount) resultsCount.textContent = shown;
  if (totalAvailEl) totalAvailEl.textContent = total;
  if (shownCount) shownCount.textContent = shown;
  if (progressBar) progressBar.style.width = (totalAll > 0 ? Math.min(100, Math.round(shown / totalAll * 100)) : 100) + '%';
  if (loadMoreSec) loadMoreSec.style.display = shown < total ? 'flex' : 'none';
  if (noResults) {
    noResults.classList.toggle('hidden', total !== 0);
    noResults.style.display = total === 0 ? 'flex' : '';
  }

  const isFiltered = currentBrand !== 'all' || currentCond !== 'all' || currentPrice !== 'all' || currentSort !== 'featured' || searchQuery;
  if (resetBtn) resetBtn.classList.toggle('hidden', !isFiltered);
}

brandChips.forEach(c => c.addEventListener('click', function() {
  currentBrand = this.dataset.brand;
  brandChips.forEach(x => x.classList.toggle('active', x.dataset.brand === currentBrand));
  visibleLimit = 20;
  run();
}));

// URL Query Parameters Detection on Page Load
try {
  const urlParams = new URLSearchParams(window.location.search);
  const urlCat = urlParams.get('cat') || urlParams.get('category');
  const urlBrand  = urlParams.get('brand');
  const urlCond   = urlParams.get('condition');
  const urlSource = urlParams.get('source');

  if (urlSource && sourceSelect) {
    currentSource = urlSource;
    sourceSelect.value = urlSource;
  }
  if (urlBrand || urlCat) {
    let b = (urlBrand || urlCat).toLowerCase();
    if (b === 'iphone') b = 'apple';
    currentBrand = b;
    brandChips.forEach(x => x.classList.toggle('active', x.dataset.brand && x.dataset.brand.toLowerCase() === currentBrand));
  }
  if (urlCond && condSelect) {
    currentCond = urlCond;
    condSelect.value = urlCond;
  }
  if (urlCat || urlBrand || urlCond || urlSource) {
    run();
  }
} catch(e) {}

if (sourceSelect) sourceSelect.addEventListener('change', function() {
  currentSource = this.value;
  visibleLimit = 20;
  run();
});

if (condSelect) condSelect.addEventListener('change', function() {
  currentCond = this.value;
  visibleLimit = 20;
  run();
});

if (priceSelect) priceSelect.addEventListener('change', function() {
  currentPrice = this.value;
  visibleLimit = 20;
  run();
});

if (sortSelect) sortSelect.addEventListener('change', function() {
  currentSort = this.value;
  visibleLimit = 20;
  run();
});

let searchTimer;
if (searchInput) searchInput.addEventListener('input', function() {
  clearTimeout(searchTimer);
  searchQuery = this.value.trim();
  if (clearBtn) clearBtn.classList.toggle('hidden', searchQuery.length === 0);
  searchTimer = setTimeout(() => {
    visibleLimit = 20;
    run();
  }, 150);
});

if (clearBtn) clearBtn.addEventListener('click', function() {
  if (searchInput) {
    searchInput.value = '';
    searchQuery = '';
    clearBtn.classList.add('hidden');
    visibleLimit = 20;
    run();
    searchInput.focus();
  }
});

if (loadMoreBtn) loadMoreBtn.addEventListener('click', function() {
  visibleLimit += 20;
  run();
});

function resetAll() {
  currentBrand = 'all';
  currentSource = 'all';
  currentCond = 'all';
  currentPrice = 'all';
  currentSort = 'featured';
  searchQuery = '';

  if (searchInput) searchInput.value = '';
  if (clearBtn) clearBtn.classList.add('hidden');
  if (sourceSelect) sourceSelect.value = 'all';
  if (condSelect) condSelect.value = 'all';
  if (priceSelect) priceSelect.value = 'all';
  if (sortSelect) sortSelect.value = 'featured';

  brandChips.forEach(c => c.classList.toggle('active', c.dataset.brand === 'all'));
  visibleLimit = 20;
  run();
}

if (resetBtn) resetBtn.addEventListener('click', resetAll);
if (noResultsResetBtn) noResultsResetBtn.addEventListener('click', resetAll);

// =========================================================================
// SHOWROOM MODAL: OPEN & POPULATE MACHINES LIST BY STORE & IMEI
// =========================================================================
const storesList = [
  'PhoneX 123 Nguyễn Thị Minh Khai, P. Bến Thành, Q.1, TP.HCM',
  'PhoneX 456 Cầu Giấy, Q. Cầu Giấy, Hà Nội',
  'PhoneX 789 Nguyễn Văn Linh, Q. Hải Châu, Đà Nẵng',
  'PhoneX 102 Lê Hồng Phong, P.4, Q.5, TP.HCM',
  'PhoneX 34 Quang Trung, P.10, Q. Gò Vấp, TP.HCM'
];

const colorsList = ['Titan Tự Nhiên', 'Titan Sa Mạc', 'Đen Midnight', 'Xanh Blue', 'Trắng Starlight', 'Tím Deep Purple'];

function openPhoneModal(idx) {
  const prod = phonesData[idx];
  if (!prod || !modal) return;

  const titleText = prod.raw_name ? ('Điện thoại ' + prod.raw_name) : prod.name;
  if (modalTitle) modalTitle.textContent = titleText;
  if (modalImg) {
    modalImg.src = prod.image;
    modalImg.alt = titleText;
  }

  const basePrice = parseInt(prod.price, 10) || 5000000;
  const count = Math.min(4, Math.max(2, parseInt(prod.stock_quantity, 10) || 3));

  let machinesHtml = '';

  if (prod.grade_factors && (prod.grade_factors.body || prod.grade_factors.screen)) {
    machinesHtml += `
      <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-200/80 mb-4">
        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
          <span class="inline-flex items-center gap-1.5 font-bold text-blue-900 text-[12.5px]">
            <span class="material-symbols-outlined text-[17px] text-blue-600">verified</span>
            Tiêu chuẩn thẩm định kỹ thuật PhoneX Lab
          </span>
          <span class="text-[11px] font-black uppercase px-2 py-0.5 rounded bg-blue-100 text-blue-800">${prod.grade_label || prod.condition}</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1 text-[11px]">
          <div class="bg-white p-2 rounded border border-blue-100">
            <div class="font-bold text-gray-500">1. Vỏ máy</div>
            <div class="font-semibold text-gray-900 mt-0.5">${prod.grade_factors.body ? prod.grade_factors.body.status : '95% - 98%'}</div>
          </div>
          <div class="bg-white p-2 rounded border border-blue-100">
            <div class="font-bold text-gray-500">2. Màn hình</div>
            <div class="font-semibold text-gray-900 mt-0.5">${prod.grade_factors.screen ? prod.grade_factors.screen.status : 'Zin đẹp'}</div>
          </div>
          <div class="bg-white p-2 rounded border border-blue-100">
            <div class="font-bold text-gray-500">3. Pin thực tế</div>
            <div class="font-semibold text-gray-900 mt-0.5">${prod.grade_factors.battery ? prod.grade_factors.battery.status : 'Zin máy'}</div>
          </div>
          <div class="bg-white p-2 rounded border border-blue-100">
            <div class="font-bold text-gray-500">4. Phần cứng</div>
            <div class="font-semibold text-gray-900 mt-0.5">${prod.grade_factors.hardware ? prod.grade_factors.hardware.status : 'Nguyên bản'}</div>
          </div>
        </div>
      </div>
    `;
  }

  for (let i = 0; i < count; i++) {
    const imei = '#IMEI-' + (10000000 + (idx * 37) + (i * 19));
    const store = storesList[(idx + i) % storesList.length];
    const color = colorsList[(idx + i) % colorsList.length];
    const diff = i * 150000;
    const itemPrice = basePrice + diff;
    const itemPriceFmt = new Intl.NumberFormat('vi-VN').format(itemPrice) + '₫';
    const condition = prod.grade_label || (i === 0 ? 'Grade A 99% Like New' : (i === 1 ? 'Grade A 99% Fullbox' : 'Grade B 98% Zin'));
    const pin = prod.battery || (i === 0 ? 'Pin 98%' : (i === 1 ? 'Pin 100%' : 'Pin 94%'));
    const warranty = 'Bảo hành 12 tháng PhoneX Lab 1 đổi 1';

    machinesHtml += `
      <div class="p-3.5 sm:p-4 rounded-xl border border-gray-200 bg-white hover:border-[#FF001F] hover:shadow-xs transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex-1">
          <div class="flex items-center gap-2 flex-wrap mb-1">
            <span class="text-[12px] font-bold text-[#b7000c] bg-[#FFF0F2] px-2 py-0.5 rounded">${condition}</span>
            <span class="text-[12px] font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">${color}</span>
            <span class="text-[11px] text-gray-500 font-mono">${imei}</span>
          </div>
          <div class="text-[12px] text-[#374151] font-medium flex flex-wrap items-center gap-x-3 gap-y-1">
            <span class="flex items-center gap-1 text-emerald-800 font-bold">
              <span class="material-symbols-outlined text-[14px]">battery_charging_full</span> ${pin}
            </span>
            <span>• ${warranty}</span>
            <span class="text-[#198754] font-bold flex items-center gap-1">
              <span class="w-2 h-2 rounded-full bg-[#198754] animate-pulse"></span> Còn hàng tại showroom
            </span>
          </div>
          <div class="text-[12px] text-gray-700 font-medium mt-1 flex items-center gap-1">
            <span class="material-symbols-outlined text-[15px] text-[#FF001F]">location_on</span>
            <span class="line-clamp-1">${store}</span>
          </div>
        </div>
        <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-2 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
          <div class="text-[17px] sm:text-[19px] font-bold text-[#e60012]">${itemPriceFmt}</div>
          <a href="<?php echo esc_url( home_url('/lien-he/') ); ?>?product=${encodeURIComponent(titleText)}&imei=${encodeURIComponent(imei)}"
             class="px-ds-btn-cta bg-[#FF001F] hover:bg-[#D9001B] text-white text-[12px] sm:text-[13px] px-3.5 py-1.5 rounded-lg shadow-2xs font-semibold">
            Đặt giữ máy này
          </a>
        </div>
      </div>
    `;
  }

  if (modalMachineList) modalMachineList.innerHTML = machinesHtml;

  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closePhoneModal() {
  if (modal) modal.classList.add('hidden');
  document.body.style.overflow = '';
}

document.addEventListener('click', function(e) {
  const trigger = e.target.closest('.open-phone-modal-trigger');
  if (trigger) {
    e.preventDefault();
    const idx = parseInt(trigger.dataset.idx, 10);
    if (!isNaN(idx)) openPhoneModal(idx);
  }
});

if (closeModalBtn) closeModalBtn.addEventListener('click', closePhoneModal);
if (modal) {
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closePhoneModal();
  });
}
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closePhoneModal();
});

// Check query string parameters on load
const urlParams = new URLSearchParams(window.location.search);
const brandParam = urlParams.get('brand');
const condParam = urlParams.get('condition');
if (brandParam) {
  currentBrand = brandParam;
  brandChips.forEach(x => x.classList.toggle('active', x.dataset.brand.toLowerCase() === brandParam.toLowerCase()));
}
if (condParam && condSelect) {
  currentCond = condParam;
  condSelect.value = condParam;
}

run();
})();

window.pxSubmitB2BWholesaleForm = function(e) {
  e.preventDefault();
  var btn = document.getElementById('b2bSubmitBtn');
  var btnText = document.getElementById('b2bSubmitBtnText');
  var notice = document.getElementById('b2bSuccessNotice');

  if (btn) btn.disabled = true;
  if (btnText) btnText.textContent = 'Đang gửi đăng ký...';

  var custName = document.getElementById('b2bCustName').value;
  var custPhone = document.getElementById('b2bCustPhone').value;
  var cat = document.getElementById('b2bCustCategory').value;
  var qty = document.getElementById('b2bCustQty').value;
  var pay = document.getElementById('b2bCustPaymentMethod').value;

  var fd = new FormData();
  fd.append('action', 'phonex_submit_installment_lead');
  fd.append('lead_type', 'b2b_wholesale');
  fd.append('customer_name', custName);
  fd.append('customer_phone', custPhone);
  fd.append('customer_id_type', 'b2b_credit');
  fd.append('product_name', 'Đăng ký sỉ: ' + cat);
  fd.append('wholesale_quantity', qty);
  fd.append('wholesale_payment_method', pay);
  fd.append('notes', 'Số lượng: ' + qty + ' | Phương thức: ' + pay);

  fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
    method: 'POST',
    body: fd
  })
  .then(function(r){ return r.json(); })
  .then(function(res){
    if (btn) btn.disabled = false;
    if (btnText) btnText.textContent = 'Nhận Báo Giá Sỉ & Đăng Ký Công Nợ';
    if (res.success) {
      if (notice) {
        notice.classList.remove('hidden');
        notice.innerHTML = '🎉 Đăng ký thành công mã #' + res.data.lead_code + '! Chuyên viên B2B PhoneX sẽ liên hệ hỗ trợ công nợ trong 15 phút.';
      }
      document.getElementById('pxB2BWholesaleForm').reset();
    } else {
      alert(res.data.message || 'Lỗi gửi đăng ký');
    }
  })
  .catch(function(err){
    if (btn) btn.disabled = false;
    if (btnText) btnText.textContent = 'Nhận Báo Giá Sỉ & Đăng Ký Công Nợ';
    alert('Không thể kết nối máy chủ. Vui lòng gọi Hotline B2B: 1800.6870.');
  });
};
</script>

<?php get_footer(); ?>
