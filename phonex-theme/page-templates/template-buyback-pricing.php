<?php
/**
 * Template Name: PhoneX Buyback Pricing Table & Projected Price Catalog (Giá Thu Mua Dự Kiến)
 *
 * Route: /bang-gia-thu-mua/ & /gia-thu-mua-du-kien/
 * Description: Danh mục giá thu mua dự kiến tổng hợp toàn bộ smartphone PhoneX và FastMobile.
 *
 * @package PhoneX
 */

get_header();

// 1. Load Crawled Smartphone Catalog (100% Genuine Phones)
$json_path = get_template_directory() . '/data/used-phones.json';
$raw_products = array();
if ( file_exists( $json_path ) ) {
    $raw_products = json_decode( file_get_contents( $json_path ), true ) ?: array();
}

// 2. Normalize and enrich products for buyback pricing
$pricing_catalog = array();
$brand_counts    = array( 'all' => 0 );

foreach ( $raw_products as $idx => $item ) {
    $raw_name = $item['name'] ?? '';
    // Clean name from [Grade ...] tag
    $clean_name = trim( preg_replace( '/^\[[^\]]+\]\s*/', '', $raw_name ) );
    if ( empty( $clean_name ) ) {
        continue;
    }

    $brand = trim( $item['brand'] ?? 'Khác' );
    if ( empty( $brand ) ) {
        $brand = 'Khác';
    }

    // Standardize brand slugs
    $brand_slug = strtolower( $brand );
    if ( 'apple' === $brand_slug || 'iphone' === $brand_slug ) {
        $brand = 'Apple';
        $brand_slug = 'apple';
    } elseif ( 'samsung' === $brand_slug ) {
        $brand = 'Samsung';
    } elseif ( 'xiaomi' === $brand_slug ) {
        $brand = 'Xiaomi';
    } elseif ( 'oppo' === $brand_slug ) {
        $brand = 'OPPO';
    } elseif ( 'vivo' === $brand_slug ) {
        $brand = 'Vivo';
    } elseif ( 'realme' === $brand_slug ) {
        $brand = 'Realme';
    } elseif ( 'honor' === $brand_slug ) {
        $brand = 'Honor';
    }

    // Storage ROM
    $rom = $item['summary_specs']['rom'] ?? '';
    if ( empty( $rom ) ) {
        if ( preg_match( '/(\d+\s*(?:GB|TB))/i', $clean_name, $m ) ) {
            $rom = strtoupper( $m[1] );
        } else {
            $rom = 'Tiêu chuẩn';
        }
    }

    // Base Price
    $base_price = (float) ( $item['price'] ?? 0 );
    if ( $base_price <= 0 ) {
        $base_price = 5000000;
    }

    // Calculate 5 condition prices
    $p_type1 = $base_price;
    $p_type2 = round( ( $base_price * 0.88 ) / 10000 ) * 10000;
    $p_type3 = round( ( $base_price * 0.78 ) / 10000 ) * 10000;
    $p_type4 = round( ( $base_price * 0.65 ) / 10000 ) * 10000;
    $p_type5 = round( ( $base_price * 0.45 ) / 10000 ) * 10000;

    // Image URL
    $img_path = $item['image'] ?? '';
    if ( ! empty( $img_path ) && strpos( $img_path, 'http' ) !== 0 ) {
        $img_url = get_template_directory_uri() . '/' . ltrim( $img_path, '/' );
    } elseif ( ! empty( $img_path ) ) {
        $img_url = $img_path;
    } else {
        $img_url = get_template_directory_uri() . '/assets/images/phones/generic-phone.png';
    }

    $buyback_url = function_exists( 'phonex_get_buyback_url_for_product' ) ? phonex_get_buyback_url_for_product( $item ) : home_url( '/thu-mua-dien-thoai/' . $brand_slug . '/' . sanitize_title( $clean_name ) . '/' );
    $brand_url   = home_url( '/thu-mua-dien-thoai/' . $brand_slug . '/' );

    $pricing_catalog[] = array(
        'id'         => $item['id'] ?? ( 'px-' . $idx ),
        'name'       => $clean_name,
        'full_name'  => $raw_name,
        'brand'      => $brand,
        'brand_slug' => $brand_slug,
        'brand_url'  => $brand_url,
        'rom'        => $rom,
        'image'      => $img_url,
        'url'        => $buyback_url,
        'price'      => (int) $base_price,
        'p1'         => (int) $p_type1,
        'p2'         => (int) $p_type2,
        'p3'         => (int) $p_type3,
        'p4'         => (int) $p_type4,
        'p5'         => (int) $p_type5,
    );

    $brand_counts['all']++;
    $brand_counts[ $brand_slug ] = ( $brand_counts[ $brand_slug ] ?? 0 ) + 1;
}

$total_pricing_items = count( $pricing_catalog );
// Brand statistics and quick-filter setup
$total_pricing_items = count( $pricing_catalog );
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

.px-ds-btn-cta { font-size:15px; font-weight:600; min-height:48px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }

.cat-chip.active, .brand-chip.active {
  background-color:#FF001F !important; color:#fff !important; border-color:#FF001F !important;
  box-shadow:0 2px 8px rgba(255,0,31,.25);
}
.cat-chip.active img, .brand-chip.active img {
  filter: brightness(0) invert(1);
}
.no-scrollbar::-webkit-scrollbar{display:none;}
.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
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
</style>

<main id="primary" class="site-main bg-[#F6F7F9] min-h-screen font-sans pb-16 text-[#1F1F1F]">

	<!-- 1. BREADCRUMBS -->
	<div class="w-full bg-white border-b border-[#E5E7EB]">
		<div class="max-w-[1440px] mx-auto px-4 py-3">
			<nav class="flex items-center gap-2 text-[13px] sm:text-[14px] text-[#374151] font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#FF001F] transition-colors flex items-center gap-1 font-semibold">
					<span class="material-symbols-outlined text-[17px]">home</span>
					<span>Trang chủ</span>
				</a>
				<span class="text-gray-400 font-bold">/</span>
				<a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="hover:text-[#FF001F] transition-colors font-semibold">
					Thu Mua Điện Thoại
				</a>
				<span class="text-gray-400 font-bold">/</span>
				<span class="text-[#1F1F1F] font-bold">Bảng Giá Thu Mua Dự Kiến 2026</span>
			</nav>
		</div>
	</div>

	<!-- 2. HERO SHOWCASE (ĐỒNG BỘ 100% VỚI KHO MÁY CŨ) -->
	<div class="max-w-[1440px] mx-auto px-4 pt-6 pb-2">
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

			<!-- MAIN HERO CARD -->
			<div class="lg:col-span-2 relative rounded-2xl p-6 sm:p-8 md:p-9 shadow-xs flex flex-col justify-between overflow-hidden border border-[#ffb4aa]"
			     style="background-color: var(--px-primary-fixed, #FFF0F2);">
				<div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
				<div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
				<div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-10 pointer-events-none select-none">
					<span class="material-symbols-outlined text-[240px] text-[#FF001F]">receipt_long</span>
				</div>
				<div class="relative z-10 max-w-2xl">
					<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/95 border border-[#FF001F]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
						<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
						BẢNG GIÁ THU MUA DỰ KIẾN • <?php echo esc_html( $total_pricing_items ); ?>+ DÒNG SMARTPHONE CẬP NHẬT 2026
					</div>
					<h1 class="px-ds-h1 font-black text-[#1F1F1F] tracking-tight mb-3">
						Bảng Giá Thu Mua Điện Thoại Dự Kiến Mới Nhất
					</h1>
					<p class="text-[14px] sm:text-[16px] text-gray-800 leading-relaxed mb-6 font-medium">
						PhoneX niêm yết công khai biểu phí thu mua cho <strong><?php echo esc_html( $total_pricing_items ); ?>+ dòng máy</strong> (iPhone, Samsung, Xiaomi, OPPO, Vivo, Realme...). 
						Báo giá minh bạch theo <strong>5 cấp độ tình trạng máy</strong>. Nhấp vào bất kỳ sản phẩm nào để thẩm định ngay và nhận chuyển khoản trong 5 phút.
					</p>
					<div class="flex flex-wrap gap-2.5 sm:gap-3 text-[12px] sm:text-[13px] font-semibold text-[#1F1F1F]">
						<span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
							<span class="material-symbols-outlined text-[16px] text-[#FF001F]">verified</span>
							Kiểm định 30 bước PhoneX Lab
						</span>
						<span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
							<span class="material-symbols-outlined text-[16px] text-[#FF001F]">currency_exchange</span>
							Chuyển khoản 24/7 trong 5 phút
						</span>
						<span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
							<span class="material-symbols-outlined text-[16px] text-[#198754]">price_check</span>
							Báo giá 5 cấp độ minh bạch
						</span>
						<span class="inline-flex items-center gap-1.5 bg-white/95 px-3 py-1.5 rounded-lg border border-[#ffb4aa]/60 shadow-2xs">
							<span class="material-symbols-outlined text-[16px] text-[#198754]">local_shipping</span>
							Thu mua tận nơi 60 phút
						</span>
					</div>
				</div>
			</div>

			<!-- RIGHT COMMITMENT CARDS -->
			<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-3.5">

				<!-- Card 1 -->
				<div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs flex items-start gap-4">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[26px]">calculate</span>
					</div>
					<div>
						<h2 class="text-[15px] font-bold text-[#1F1F1F] mb-1">Định Giá Trực Tuyến 30 Giây</h2>
						<p class="text-[13px] text-[#374151] font-medium leading-snug">
							Tra cứu biểu phí ngay tức thì, chính xác theo từng phiên bản dung lượng và tình trạng trầy xước.
						</p>
					</div>
				</div>

				<!-- Card 2 -->
				<div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs flex items-start gap-4">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[26px]">no_sim</span>
					</div>
					<div>
						<h2 class="text-[15px] font-bold text-[#1F1F1F] mb-1">Không Ép Giá • Báo Giá Chuẩn</h2>
						<p class="text-[13px] text-[#374151] font-medium leading-snug">
							Cam kết 100% đúng giá barem niêm yết, nhân viên không tự ý hạ giá hay trừ phụ phí vô lý.
						</p>
					</div>
				</div>

				<!-- Card 3 -->
				<div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E7EB] shadow-xs flex items-start gap-4">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] text-[#FF001F] flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[26px]">electric_moped</span>
					</div>
					<div>
						<h2 class="text-[15px] font-bold text-[#1F1F1F] mb-1">Thu Tận Nơi Hoặc Tại Showroom</h2>
						<p class="text-[13px] text-[#374151] font-medium leading-snug">
							Kỹ thuật viên đến tận nhà sau 60 phút hoặc phục vụ tại 128 cửa hàng PhoneX trên toàn quốc.
						</p>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- 3. STICKY FILTER BAR (TINH GỌN, KHÔNG BỊ DÀI RA) -->
	<div class="sticky top-0 z-30 bg-[#F6F7F9]/95 backdrop-blur-md border-b border-[#E5E7EB] mt-4 py-2.5 overflow-x-clip shadow-xs">
		<div class="max-w-[1440px] mx-auto px-4 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 w-full">
			
			<!-- Left: Search Input -->
			<div class="relative w-full md:w-64 lg:w-72 shrink-0">
				<input 
					type="search" 
					id="pricingSearchInput" 
					placeholder="Tìm máy cần bán (iPhone 15, S24...)..." 
					class="w-full bg-white border border-[#E5E7EB] rounded-xl pl-9 pr-9 py-2 text-xs sm:text-[14px] text-[#1F1F1F] placeholder-gray-500 focus:outline-none focus:border-[#FF001F] focus:ring-2 focus:ring-[#ffdad5] transition-all font-medium"
				/>
				<span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
				<button type="button" id="clearPricingSearch" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
					<span class="material-symbols-outlined text-[16px]">close</span>
				</button>
			</div>

			<!-- Center: Brand Quick Filters with Official SVG Logos (1 Dải nút cuộn mượt mà, không bị dài ra) -->
			<div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-1 min-w-0 flex-1 scroll-smooth" id="pricingBrandPills">
				<button 
					type="button" 
					class="brand-chip whitespace-nowrap px-3 py-1.5 rounded-full text-[12px] font-bold border border-[#E5E7EB] bg-white text-[#1F1F1F] hover:border-[#FF001F] hover:text-[#FF001F] transition-all inline-flex items-center gap-1.5 shrink-0 active cursor-pointer"
					data-brand="all"
					onclick="PhoneXPricingPage.setBrand('all')"
				>
					<span>Tất cả (<?php echo esc_html( $total_pricing_items ); ?>)</span>
				</button>

				<?php 
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
				foreach ( $main_brands as $b_key => $b_data ) : 
					$count = $brand_counts[ $b_data['slug'] ] ?? 0;
					if ( 'other' === $b_key ) {
						$count = $total_pricing_items - (
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
					<button 
						type="button" 
						class="brand-chip whitespace-nowrap px-3 py-1.5 rounded-full text-[12px] font-semibold border border-[#E5E7EB] bg-white text-[#1F1F1F] hover:border-[#FF001F] hover:text-[#FF001F] transition-all inline-flex items-center gap-1.5 shrink-0 cursor-pointer"
						data-brand="<?php echo esc_attr( $b_data['slug'] ); ?>"
						onclick="PhoneXPricingPage.setBrand('<?php echo esc_attr( $b_data['slug'] ); ?>')"
					>
						<?php if ( function_exists( 'phonex_get_brand_logo_img' ) && 'other' !== $b_key ) : ?>
							<?php echo phonex_get_brand_logo_img( $b_data['slug'], 'w-3.5 h-3.5 object-contain inline-block shrink-0' ); ?>
						<?php endif; ?>
						<span><?php echo esc_html( $b_data['name'] ); ?> (<?php echo esc_html( $count ); ?>)</span>
					</button>
				<?php endforeach; ?>
			</div>

			<!-- Right Controls: Counter + Sort Dropdown + View Switcher -->
			<div class="flex items-center gap-2 shrink-0 justify-between md:justify-end">
				
				<!-- Counter -->
				<span class="hidden xl:inline-block text-xs font-semibold text-gray-500 whitespace-nowrap">
					<strong id="pricingCountDisplay" class="text-[#FF001F] font-bold"><?php echo esc_html( $total_pricing_items ); ?></strong> máy
				</span>

				<!-- Sort Select -->
				<div class="relative shrink-0">
					<select id="pricingSortSelect" class="bg-white border border-[#E5E7EB] rounded-xl px-2.5 py-1.5 text-xs sm:text-[13px] text-[#1F1F1F] font-semibold focus:outline-none focus:border-[#FF001F] cursor-pointer">
						<option value="price_desc">Giá thu: Cao &rarr; Thấp</option>
						<option value="price_asc">Giá thu: Thấp &rarr; Cao</option>
						<option value="name_asc">Tên máy: A &rarr; Z</option>
					</select>
				</div>

				<!-- View Mode Switcher -->
				<div class="inline-flex rounded-xl border border-[#E5E7EB] bg-white p-0.5 shadow-2xs shrink-0">
					<button 
						type="button" 
						id="viewModeGrid" 
						onclick="PhoneXPricingPage.switchView('grid')" 
						class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 bg-[#FF001F] text-white shadow-2xs cursor-pointer"
						title="Dạng lưới thẻ"
					>
						<span class="material-symbols-outlined text-[15px]">grid_view</span>
						<span class="hidden sm:inline">Lưới thẻ</span>
					</button>
					<button 
						type="button" 
						id="viewModeTable" 
						onclick="PhoneXPricingPage.switchView('table')" 
						class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 text-gray-700 hover:text-[#FF001F] cursor-pointer"
						title="Dạng bảng tra cứu"
					>
						<span class="material-symbols-outlined text-[15px]">table_rows</span>
						<span class="hidden sm:inline">Bảng chi tiết</span>
					</button>
				</div>

			</div>

		</div>
	</div>

	<!-- 4. PRODUCT CATALOG CONTAINER (GRID VIEW & TABLE VIEW) -->
	<section class="max-w-[1440px] mx-auto px-4 pt-8">
		
		<div class="flex items-center justify-between mb-6">
			<div>
				<h2 class="px-ds-h2 font-black text-[#1F1F1F] tracking-tight">Danh Sách Giá Thu Mua Dự Kiến PhoneX</h2>
				<p class="text-[14px] text-[#374151] font-medium mt-1">Định giá công khai • Thẩm định 30 bước • Bấm vào máy để xem 5 cấp độ tình trạng</p>
			</div>
		</div>

		<!-- VIEW 1: MODERN GRID CARDS (ĐỒNG BỘ 100% VỚI PHONEX-PHONE-CARD) -->
		<div id="pricingGridView" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 sm:gap-4 md:gap-5">
			<!-- Rendered dynamically by JavaScript -->
		</div>

		<!-- VIEW 2: MASTER TABLE VIEW -->
		<div id="pricingTableView" class="hidden bg-white rounded-2xl border border-gray-200/90 overflow-hidden shadow-2xs">
			<div class="overflow-x-auto">
				<table class="w-full text-left text-xs sm:text-sm">
					<thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-200 select-none">
						<tr>
							<th class="py-3.5 px-4 sm:px-6">Điện thoại / Thiết bị</th>
							<th class="py-3.5 px-3 text-center">Dung lượng</th>
							<th class="py-3.5 px-3 text-[#198754] font-black">Loại 1 (Như mới 99%)</th>
							<th class="py-3.5 px-3 text-blue-600 font-bold">Loại 2 (Ổn định đẹp)</th>
							<th class="py-3.5 px-3 text-amber-600 font-bold">Loại 3 (Trầy xước)</th>
							<th class="py-3.5 px-3 text-gray-500 font-bold">Loại 4 / 5</th>
							<th class="py-3.5 px-4 text-center">Định giá &amp; Bán</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-100" id="pricingTableBody">
						<!-- Rendered dynamically by JavaScript -->
					</tbody>
				</table>
			</div>
		</div>

		<!-- Empty Search State -->
		<div id="pricingEmptyState" class="hidden py-16 text-center bg-white rounded-2xl border border-gray-200 mt-4 p-8">
			<span class="material-symbols-outlined text-[48px] text-gray-300 mb-2">search_off</span>
			<h3 class="text-base font-bold text-gray-800">Không tìm thấy dòng máy phù hợp</h3>
			<p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Vui lòng thử tìm kiếm bằng từ khóa khác hoặc chọn tất cả thương hiệu để xem toàn bộ danh mục.</p>
			<button type="button" onclick="PhoneXPricingPage.resetFilters()" class="mt-4 px-4 py-2 rounded-xl bg-[#FFF0F2] text-[#FF001F] font-bold text-xs hover:bg-[#ffdad5] transition-colors">
				Xem lại tất cả dòng máy
			</button>
		</div>

		<!-- Load More Section (Đồng bộ 100% với Kho Máy Cũ) -->
		<div id="pricingPaginationWrapper" class="mt-10 flex flex-col items-center gap-4">
			<div class="w-full max-w-sm">
				<div class="flex items-center justify-between text-[12px] text-[#374151] font-medium mb-1.5">
					<span>Đang hiển thị <strong id="pricingShownCount" class="text-[#1F1F1F]">20</strong> / <strong id="pricingTotalCount"><?php echo esc_html( $total_pricing_items ); ?></strong> máy</span>
				</div>
				<div class="w-full bg-[#E5E7EB] rounded-full h-1.5 overflow-hidden">
					<div id="pricingProgressBar" class="bg-[#FF001F] h-1.5 rounded-full transition-all duration-500"
					     style="width:<?php echo min( 100, round( 20 / max( 1, $total_pricing_items ) * 100 ) ); ?>%"></div>
				</div>
			</div>
			<button 
				type="button" 
				id="pricingLoadMoreBtn" 
				onclick="PhoneXPricingPage.loadMore()" 
				class="px-ds-btn-cta bg-white hover:bg-[#FFF0F2] text-[#FF001F] border-2 border-[#FF001F] px-8 py-3 text-[15px] gap-2 rounded-xl shadow-xs transition-colors font-bold inline-flex items-center justify-center cursor-pointer"
			>
				<span class="material-symbols-outlined text-[20px]">expand_more</span>
				<span>Xem thêm máy thu mua dự kiến</span>
			</button>
		<!-- CRAWLER ACCESSIBLE CATALOG & ITEMLIST STRUCTURED DATA (GOOGLE SEARCH BOT) -->
		<div class="sr-only" aria-hidden="true">
			<h2>Danh Mục 300+ Dòng Điện Thoại Thu Mua Tại PhoneX</h2>
			<nav aria-label="Danh sách máy thu mua">
				<ul>
					<?php foreach ( $pricing_catalog as $p_bot_item ) : ?>
						<li>
							<a href="<?php echo esc_url( $p_bot_item['url'] ); ?>">
								Thu mua <?php echo esc_html( $p_bot_item['name'] ); ?> cũ giá từ <?php echo esc_html( number_format( $p_bot_item['p5'], 0, ',', '.' ) ); ?>₫ đến <?php echo esc_html( number_format( $p_bot_item['p1'], 0, ',', '.' ) ); ?>₫
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>

	</section>

	<!-- 5. 5-TIER CONDITION STANDARDS EXPLANATION -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 md:p-10 shadow-xs">
			<div class="text-center max-w-2xl mx-auto mb-8">
				<span class="text-xs font-bold uppercase tracking-wider text-[#b7000c] bg-[#FFF0F2] border border-[#ffb4aa]/40 px-3 py-1 rounded-full">
					Chuẩn Hóa Phân Loại
				</span>
				<h2 class="px-ds-h2 font-black text-[#1F1F1F] tracking-tight mt-2.5 mb-2">
					Quy Chuẩn Phân Loại 5 Cấp Độ Tình Trạng Máy PhoneX
				</h2>
				<p class="text-xs sm:text-sm text-gray-600 font-medium">
					Tất cả thiết bị thu mua đều được định giá chính xác theo 5 cấp độ tiêu chuẩn công khai, không kỳ kèo ép giá.
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3.5">
				
				<div class="p-4 rounded-2xl bg-green-50/60 border border-green-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-green-800 bg-green-100 px-2.5 py-0.5 rounded-full mb-2">
							100% Giá Thu
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 1 (Như Mới 99%)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Máy chính hãng VN, màn hình đẹp keng, ngoại hình không vết xước, đầy đủ hộp phụ kiện zin, kích hoạt dưới 90 ngày.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-green-200/60 text-[11px] font-bold text-green-800">
						Khuyên chọn: Tối đa giá trị
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-blue-800 bg-blue-100 px-2.5 py-0.5 rounded-full mb-2">
							~88% - 90% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 2 (Đẹp 98%)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Máy hoạt động mượt mà, ổn định; màn hình hiển thị trong trẻo, không trầy xước; thân máy còn rất mới.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-blue-200/60 text-[11px] font-bold text-blue-800">
						Phổ biến nhất: 98% Like New
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full mb-2">
							~78% - 80% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 3 (Trầy Xước Nhẹ)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Chức năng hoạt động đầy đủ 10/10, màn hình đẹp không ám ố, viền thân máy có trầy xước nhẹ qua quá trình sử dụng.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-amber-200/60 text-[11px] font-bold text-amber-800">
						Hao mòn ngoại hình nhẹ
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-orange-50/60 border border-orange-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-orange-800 bg-orange-100 px-2.5 py-0.5 rounded-full mb-2">
							~65% - 70% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 4 (Cấn Móp Nhẹ)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Máy hoạt động ổn định mọi tính năng phần cứng, màn hình trầy nhẹ, thân viền có cấn móp nhẹ góc cạnh.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-orange-200/60 text-[11px] font-bold text-orange-800">
						Máy cấn viền vẫn thu giá tốt
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-red-50/60 border border-red-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-red-800 bg-red-100 px-2.5 py-0.5 rounded-full mb-2">
							~45% - 50% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 5 (Hỏng Màn / Lỗi)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Lỗi một số chức năng (camera, loa rè...), màn hình hư nặng (sọc, bầm sâu...) nhưng mainboard còn nguồn kiểm tra được.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-red-200/60 text-[11px] font-bold text-red-800">
						Hỗ trợ tận cùng, không bỏ rơi
					</div>
				</div>

			</div>
		</div>
	</section>

</main>

<!-- Injected JSON Catalog & Page Controller -->
<script>
window.PhoneXPricingData = <?php echo wp_json_encode( $pricing_catalog, JSON_UNESCAPED_UNICODE ); ?>;

window.PhoneXPricingPage = (function() {
	var catalog = window.PhoneXPricingData || [];
	var currentBrand = 'all';
	var currentQuery = '';
	var currentSort = 'price_desc';
	var currentView = 'grid'; // 'grid' | 'table'
	var pageSize = 20;
	var currentPage = 1;

	var filteredItems = [];

	function formatVnd(val) {
		return (Math.round(Number(val) / 1000) * 1000).toLocaleString('vi-VN') + '₫';
	}

	function filterAndSort() {
		var q = currentQuery.toLowerCase().trim();
		var b = currentBrand.toLowerCase();

		filteredItems = catalog.filter(function(item) {
			var matchBrand = (b === 'all');
			if (!matchBrand) {
				if (b === 'other' || b === 'khac') {
					matchBrand = !['apple', 'samsung', 'xiaomi', 'oppo', 'vivo', 'realme', 'honor'].includes(item.brand_slug);
				} else {
					matchBrand = (item.brand_slug === b);
				}
			}

			var matchQuery = true;
			if (q) {
				var hay = (item.name + ' ' + item.brand + ' ' + item.rom).toLowerCase();
				matchQuery = hay.indexOf(q) !== -1;
			}

			return matchBrand && matchQuery;
		});

		// Sort
		filteredItems.sort(function(a, b) {
			if (currentSort === 'price_desc') return b.price - a.price;
			if (currentSort === 'price_asc') return a.price - b.price;
			if (currentSort === 'name_asc') return a.name.localeCompare(b.name);
			return 0;
		});

		currentPage = 1;
		render();
	}

	function render() {
		var countEl = document.getElementById('pricingCountDisplay');
		if (countEl) countEl.textContent = filteredItems.length;

		var emptyEl = document.getElementById('pricingEmptyState');
		var paginationEl = document.getElementById('pricingPaginationWrapper');

		if (filteredItems.length === 0) {
			if (emptyEl) emptyEl.classList.remove('hidden');
			if (paginationEl) paginationEl.classList.add('hidden');
			document.getElementById('pricingGridView').innerHTML = '';
			document.getElementById('pricingTableBody').innerHTML = '';
			return;
		}

		if (emptyEl) emptyEl.classList.add('hidden');

		var visibleItems = filteredItems.slice(0, currentPage * pageSize);

		if (visibleItems.length >= filteredItems.length) {
			if (paginationEl) paginationEl.classList.add('hidden');
		} else {
			if (paginationEl) paginationEl.classList.remove('hidden');
		}

		// Update progress bar & count display (đồng bộ 100% với Kho Máy Cũ)
		var shownEl = document.getElementById('pricingShownCount');
		var totalEl = document.getElementById('pricingTotalCount');
		var barEl   = document.getElementById('pricingProgressBar');
		var currentShown = Math.min(visibleItems.length, filteredItems.length);
		if (shownEl) shownEl.textContent = currentShown;
		if (totalEl) totalEl.textContent = filteredItems.length;
		if (barEl) {
			var pct = filteredItems.length > 0 ? Math.min(100, Math.round(currentShown / filteredItems.length * 100)) : 100;
			barEl.style.width = pct + '%';
		}

		if (currentView === 'grid') {
			renderGrid(visibleItems);
		} else {
			renderTable(visibleItems);
		}
	}

	function renderGrid(items) {
		var container = document.getElementById('pricingGridView');
		if (!container) return;

		var html = items.map(function(item) {
			var jsonStr = JSON.stringify(item).replace(/"/g, '&quot;');
			var p1 = formatVnd(item.p1);

			return `
				<div 
					class="phonex-phone-card group bg-white rounded-2xl border border-[#E5E7EB] p-3.5 sm:p-4 flex flex-col justify-between transition-all"
				>
					<div>
						<!-- Top Badges -->
						<div class="flex items-center justify-between gap-1.5 mb-2.5">
							<a href="${item.brand_url || '#'}" class="inline-flex items-center gap-1 text-[11px] font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 px-2 py-0.5 rounded-md transition-colors" title="Xem bảng giá ${item.brand}">
								<span>${item.brand}</span>
							</a>
							<span class="text-[11px] font-bold text-gray-500 bg-gray-50 border border-gray-200/80 px-2 py-0.5 rounded-md">
								${item.rom}
							</span>
						</div>

						<!-- Phone Image with SEO Anchor Link -->
						<a 
							href="${item.url}" 
							title="Bảng giá thu mua &amp; định giá ${item.name} cũ"
							class="py-3 px-2 text-center h-36 sm:h-40 flex items-center justify-center overflow-hidden block"
						>
							<img 
								src="${item.image}" 
								alt="${item.name}" 
								class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300 select-none drop-shadow-sm" 
								loading="lazy" 
							/>
						</a>

						<!-- Model Name with SEO Anchor Link (px-ds-prod-title) -->
						<h3 class="px-ds-prod-title text-gray-900 group-hover:text-[#FF001F] transition-colors mb-2 leading-snug" title="${item.name}">
							<a href="${item.url}" class="hover:text-[#FF001F] transition-colors" title="Thu mua ${item.name} cũ giá cao">
								${item.name}
							</a>
						</h3>
					</div>

					<!-- Price & Action -->
					<div class="pt-2 border-t border-gray-100">
						<div class="text-[11px] text-gray-500 font-semibold mb-0.5">Giá thu Loại 1 dự kiến:</div>
						<div class="px-ds-price-primary text-[#FF001F] leading-tight mb-2.5">
							${p1}
						</div>
						
						<div class="grid grid-cols-2 gap-1.5">
							<!-- Action 1: Quick 5-grade modal estimation -->
							<button 
								type="button" 
								class="w-full py-2.5 px-2 rounded-xl bg-[#FFF0F2] hover:bg-[#ffdad5] text-[#FF001F] font-bold text-xs flex items-center justify-center gap-1 transition-colors cursor-pointer"
								onclick="PhoneXConditionPopup.open(${jsonStr})"
								title="Xem 5 cấp độ tình trạng"
							>
								<span class="material-symbols-outlined text-[15px]">tune</span>
								<span>Xem 5 Loại</span>
							</button>

							<!-- Action 2: Direct SEO landing page -->
							<a 
								href="${item.url}" 
								class="w-full py-2.5 px-2 rounded-xl bg-[#FF001F] hover:bg-[#D9001B] text-white font-bold text-xs flex items-center justify-center gap-1 transition-colors shadow-2xs text-center"
								title="Xem chi tiết định giá dòng máy này"
							>
								<span>Chi tiết</span>
								<span class="material-symbols-outlined text-[15px]">arrow_forward</span>
							</a>
						</div>
					</div>
				</div>
			`;
		}).join('');

		container.innerHTML = html;
	}

	function renderTable(items) {
		var tbody = document.getElementById('pricingTableBody');
		if (!tbody) return;

		var html = items.map(function(item) {
			var jsonStr = JSON.stringify(item).replace(/"/g, '&quot;');
			return `
				<tr class="hover:bg-red-50/30 transition-colors">
					<td class="py-3.5 px-4 sm:px-6">
						<div class="flex items-center gap-3">
							<a href="${item.url}" class="shrink-0 block" title="${item.name}">
								<img src="${item.image}" alt="${item.name}" class="w-11 h-11 object-contain rounded-lg p-1 bg-gray-50 border border-gray-100 hover:scale-105 transition-transform" loading="lazy" />
							</a>
							<div>
								<span class="inline-block text-[10px] font-bold text-gray-600 bg-gray-100 px-1.5 py-0.2 rounded mb-0.5">${item.brand}</span>
								<div class="font-bold text-gray-900 leading-tight text-xs sm:text-sm">
									<a href="${item.url}" class="hover:text-[#FF001F] transition-colors" title="${item.name}">
										${item.name}
									</a>
								</div>
							</div>
						</div>
					</td>
					<td class="py-3.5 px-3 text-center text-gray-600 font-semibold text-xs">
						${item.rom}
					</td>
					<td class="py-3.5 px-3 font-black text-[#198754] text-xs sm:text-sm whitespace-nowrap">
						${formatVnd(item.p1)}
					</td>
					<td class="py-3.5 px-3 font-bold text-blue-600 text-xs sm:text-sm whitespace-nowrap">
						${formatVnd(item.p2)}
					</td>
					<td class="py-3.5 px-3 font-bold text-amber-600 text-xs sm:text-sm whitespace-nowrap">
						${formatVnd(item.p3)}
					</td>
					<td class="py-3.5 px-3 font-semibold text-gray-500 text-xs whitespace-nowrap">
						${formatVnd(item.p4)} - ${formatVnd(item.p5)}
					</td>
					<td class="py-3.5 px-4 text-center">
						<div class="inline-flex items-center gap-1.5">
							<button 
								type="button" 
								class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-[#FFF0F2] text-[#FF001F] hover:bg-[#ffdad5] text-xs font-bold transition-colors cursor-pointer"
								onclick="PhoneXConditionPopup.open(${jsonStr})"
								title="Định giá 5 loại"
							>
								<span class="material-symbols-outlined text-[14px]">tune</span>
								<span>5 Loại</span>
							</button>
							<a 
								href="${item.url}" 
								class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#FF001F] hover:bg-[#D9001B] text-white text-xs font-bold transition-colors shadow-2xs"
								title="Chi tiết dòng máy"
							>
								<span>Chi tiết</span>
								<span class="material-symbols-outlined text-[14px]">arrow_forward</span>
							</a>
						</div>
					</td>
				</tr>
			`;
		}).join('');

		tbody.innerHTML = html;
	}

	function switchView(mode) {
		currentView = mode;
		var gridBtn = document.getElementById('viewModeGrid');
		var tableBtn = document.getElementById('viewModeTable');
		var gridEl = document.getElementById('pricingGridView');
		var tableEl = document.getElementById('pricingTableView');

		if (mode === 'grid') {
			gridEl.classList.remove('hidden');
			tableEl.classList.add('hidden');
			gridBtn.className = 'px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 bg-[#FF001F] text-white shadow-2xs cursor-pointer';
			tableBtn.className = 'px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 text-gray-700 hover:text-[#FF001F] cursor-pointer';
		} else {
			gridEl.classList.add('hidden');
			tableEl.classList.remove('hidden');
			tableBtn.className = 'px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 bg-[#FF001F] text-white shadow-2xs cursor-pointer';
			gridBtn.className = 'px-2.5 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1 text-gray-700 hover:text-[#FF001F] cursor-pointer';
		}
		render();
	}

	function setBrand(brandSlug) {
		currentBrand = brandSlug;
		var pills = document.querySelectorAll('#pricingBrandPills .brand-chip');
		pills.forEach(function(pill) {
			if (pill.getAttribute('data-brand') === brandSlug) {
				pill.classList.add('active');
			} else {
				pill.classList.remove('active');
			}
		});
		filterAndSort();
	}

	function resetFilters() {
		currentBrand = 'all';
		currentQuery = '';
		var searchInput = document.getElementById('pricingSearchInput');
		if (searchInput) searchInput.value = '';
		var clearBtn = document.getElementById('clearPricingSearch');
		if (clearBtn) clearBtn.classList.add('hidden');

		document.querySelectorAll('#pricingBrandPills .brand-chip').forEach(function(p, i) {
			if (i === 0) p.classList.add('active');
			else p.classList.remove('active');
		});

		filterAndSort();
	}

	function loadMore() {
		currentPage++;
		render();
	}

	// Initialization
	document.addEventListener('DOMContentLoaded', function() {
		var searchInput = document.getElementById('pricingSearchInput');
		var clearBtn = document.getElementById('clearPricingSearch');
		var sortSelect = document.getElementById('pricingSortSelect');

		if (searchInput) {
			searchInput.addEventListener('input', function() {
				currentQuery = searchInput.value;
				if (currentQuery.length > 0) {
					if (clearBtn) clearBtn.classList.remove('hidden');
				} else {
					if (clearBtn) clearBtn.classList.add('hidden');
				}
				filterAndSort();
			});
		}

		if (clearBtn) {
			clearBtn.addEventListener('click', function() {
				if (searchInput) searchInput.value = '';
				clearBtn.classList.add('hidden');
				currentQuery = '';
				filterAndSort();
			});
		}

		if (sortSelect) {
			sortSelect.addEventListener('change', function() {
				currentSort = sortSelect.value;
				filterAndSort();
			});
		}

		filterAndSort();
	});

	return {
		setBrand: setBrand,
		switchView: switchView,
		resetFilters: resetFilters,
		loadMore: loadMore,
		filterAndSort: filterAndSort
	};
})();
</script>

<?php get_footer(); ?>
