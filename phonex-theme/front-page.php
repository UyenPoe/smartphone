<?php
/**
 * The template for displaying the PhoneX Front Page
 *
 * Pivot to: Thu Mua Điện Thoại Cũ -> Kiểm Định -> Phân Grade -> Nhập Kho -> Bán Sỉ
 *
 * @package PhoneX
 */

get_header();

global $wpdb;
$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
$t_models = $wpdb->prefix . 'phonex_buyback_models';

$brands = $wpdb->get_results( "SELECT * FROM $t_brands WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, name ASC" );

// Fetch prominent Grade A buyback models across top brands
$sql_popular = "
SELECT * FROM (
    SELECT m.*, b.name as brand_name, b.slug as brand_slug,
           ROW_NUMBER() OVER (PARTITION BY m.brand_id ORDER BY m.base_buyback_price DESC) as rn
    FROM $t_models m
    JOIN $t_brands b ON m.brand_id = b.id
    WHERE m.is_active = 1
) sub
WHERE (brand_slug = 'apple' AND rn <= 10)
   OR (brand_slug = 'samsung' AND rn <= 10)
   OR (brand_slug = 'xiaomi' AND rn <= 6)
   OR (brand_slug = 'oppo' AND rn <= 6)
   OR (brand_slug = 'vivo' AND rn <= 4)
   OR (brand_slug NOT IN ('apple', 'samsung', 'xiaomi', 'oppo', 'vivo') AND rn <= 2)
ORDER BY base_buyback_price DESC
";
$popular_models = $wpdb->get_results( $sql_popular );
if ( empty( $popular_models ) ) {
	$popular_models = $wpdb->get_results(
		"SELECT m.*, b.name as brand_name, b.slug as brand_slug 
		 FROM $t_models m 
		 JOIN $t_brands b ON m.brand_id = b.id 
		 WHERE m.is_active = 1 
		 ORDER BY m.is_popular DESC, m.base_buyback_price DESC 
		 LIMIT 40"
	);
}
?>

<main class="w-full bg-background font-sans pb-16">

	<!-- 1. HERO SHOWCASE: PHONEX BUYBACK PLATFORM -->
	<section class="relative border-b border-[#ffb4aa]/80 pt-10 pb-16 px-4 overflow-hidden" style="background-color: var(--px-primary-fixed, #FFF0F2);">
		<!-- Glow effects -->
		<div class="absolute -top-32 -right-32 w-[500px] h-[500px] bg-white/60 rounded-full blur-3xl pointer-events-none"></div>
		<div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-[#ffb4aa]/30 rounded-full blur-3xl pointer-events-none"></div>
		<div class="absolute right-10 top-1/2 -translate-y-1/2 hidden xl:block opacity-5 pointer-events-none select-none">
			<span class="material-symbols-outlined text-[360px] text-[#FF001F]">phone_iphone</span>
		</div>

		<div class="max-w-[1440px] mx-auto relative z-10">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
				
				<!-- Left Text & CTAs (7 cols) -->
				<div class="lg:col-span-7 space-y-5 text-center lg:text-left">
					<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/95 border border-[#FF001F]/20 text-xs md:text-sm font-bold text-[#b7000c] tracking-wide shadow-2xs">
						<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
						<span>NỀN TẢNG THU MUA &amp; BÁN SỈ ĐIỆN THOẠI CŨ SỐ 1 VIỆT NAM</span>
					</div>

					<h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight text-[#1F1F1F] leading-tight">
						Thu Mua Điện Thoại Cũ Giá Cao • Phân Grade Minh Bạch
					</h1>

					<p class="text-sm sm:text-base md:text-lg text-gray-800 max-w-2xl leading-relaxed font-medium">
						Kiểm định 30 bước công khai. Báo giá tức thì theo 4 hạng <strong class="text-gray-900 font-bold">Grade A / B / C / D</strong>. Nhận tiền chuyển khoản 24/7 chỉ trong <strong class="text-[#FF001F] underline decoration-[#FF001F] decoration-2 font-bold">5 phút</strong>. Tuyệt đối không ép giá.
					</p>

					<!-- Live Search Quick Input -->
					<div class="max-w-xl mx-auto lg:mx-0 relative">
						<div class="relative flex items-center shadow-lg rounded-xl bg-white p-1.5 border border-gray-200/90 focus-within:ring-2 focus-within:ring-[#FF001F] transition-all">
							<span class="material-symbols-outlined text-gray-600 text-[24px] pl-3">search</span>
							<input 
								id="homeBuybackSearchInput"
								type="search" 
								placeholder="Nhập tên máy muốn bán (VD: iPhone 15 Pro Max, Galaxy S24...)" 
								class="w-full h-12 px-3 text-sm md:text-base text-gray-900 placeholder-gray-500 bg-transparent outline-none font-medium"
								autocomplete="off"
							/>
							<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-5 h-11 bg-[#FF001F] hover:bg-[#D9001B] text-white rounded-[8px] font-semibold text-sm flex items-center justify-center gap-1.5 shrink-0 transition-all shadow-sm">
								<span class="hidden sm:inline">Định giá</span>
								<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
							</a>
						</div>
						<div id="homeBuybackSearchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 p-2 z-50 text-left max-h-80 overflow-y-auto"></div>
					</div>

					<!-- CTAs (Rounded 8px PhoneX DS) -->
					<div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 sm:gap-4 pt-2">
						<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-6 py-3.5 rounded-[8px] bg-[#FF001F] hover:bg-[#D9001B] text-white text-sm sm:text-base font-semibold shadow-sm flex items-center gap-2 transition-all transform hover:-translate-y-0.5 min-h-[48px]">
							<span class="material-symbols-outlined text-[20px]">calculate</span>
							<span>ĐỊNH GIÁ ĐIỆN THOẠI NGAY</span>
						</a>
						<a href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="px-5 py-3.5 rounded-[8px] bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] text-sm sm:text-base font-semibold flex items-center gap-2 transition-all min-h-[48px] shadow-2xs">
							<span class="material-symbols-outlined text-[20px] text-[#FF001F]">track_changes</span>
							<span>TRA CỨU YÊU CẦU</span>
						</a>
						<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-5 py-3.5 rounded-[8px] bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] text-sm sm:text-base font-semibold flex items-center gap-2 transition-all min-h-[48px] shadow-2xs">
							<span class="material-symbols-outlined text-[20px] text-[#FF001F]">table_chart</span>
							<span>BẢNG GIÁ THU MUA</span>
						</a>
					</div>
				</div>

				<!-- Right Quick Valuation Box (5 cols) -->
				<div class="lg:col-span-5">
					<div class="bg-white rounded-2xl p-6 sm:p-8 text-gray-900 shadow-xl border border-[#ffb4aa]/60">
						<div class="flex items-center justify-between mb-4">
							<div class="flex items-center gap-2">
								<span class="w-2.5 h-2.5 rounded-full bg-[#FF001F]"></span>
								<h2 class="text-base sm:text-lg font-black text-gray-900 uppercase tracking-tight">Định Giá Tức Thì</h2>
							</div>
							<span class="text-xs font-bold text-[#b7000c] bg-[#FFF0F2] border border-[#ffdad5] px-2.5 py-1 rounded-full">30 Giây</span>
						</div>

						<div class="space-y-3.5 text-xs sm:text-sm">
							<div>
								<label class="block font-bold text-gray-700 mb-1">1. Chọn thương hiệu máy:</label>
								<select id="quickBrandSelect" class="w-full h-11 px-3 rounded-xl border border-gray-300 focus:border-[#FF001F] outline-none font-bold bg-gray-50 text-gray-900">
									<?php foreach ( $brands as $b ) : ?>
										<option value="<?php echo esc_attr( $b->id ); ?>"><?php echo esc_html( $b->name ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div>
								<label class="block font-bold text-gray-700 mb-1">2. Chọn mẫu máy (Model):</label>
								<select id="quickModelSelect" class="w-full h-11 px-3 rounded-xl border border-gray-300 focus:border-[#FF001F] outline-none font-bold bg-gray-50 text-gray-900">
									<!-- Dynamic via JS -->
								</select>
							</div>

							<div class="p-4 rounded-xl bg-red-50/70 border border-red-100 flex items-center justify-between">
								<div>
									<div class="text-[11px] text-gray-700 font-bold">Giá thu Grade A lên tới:</div>
									<div class="text-xl sm:text-2xl font-black text-[#FF001F]" id="quickPriceDisplay">28.500.000₫</div>
								</div>
								<span class="px-2 py-1 rounded bg-green-100 text-green-800 text-[10px] font-black uppercase">99% Like New</span>
							</div>

							<a id="quickValuateBtn" href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/apple/iphone-16-pro-max/' ) ); ?>" class="w-full min-h-[48px] rounded-[8px] bg-[#FF001F] hover:bg-[#D9001B] text-white font-semibold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-all shadow-sm">
								<span>Xem Báo Giá Chi Tiết &amp; Bán Máy</span>
								<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- 2. BRAND SELECTION GRID (DYNAMICALLY DRIVEN FROM DATABASE) -->
	<section class="max-w-[1440px] mx-auto px-4 mt-12">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
			<div>
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Hệ thống mở rộng</div>
				<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
					Chọn Thương Hiệu Cần Bán
				</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="text-xs sm:text-sm font-bold text-[#e60012] hover:underline flex items-center gap-1">
				<span>Xem toàn bộ trung tâm thu mua</span>
				<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
			</a>
		</div>

		<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
			<?php if ( ! empty( $brands ) ) : ?>
				<?php foreach ( $brands as $b ) : 
					$brand_url = home_url( '/thu-mua-dien-thoai/' . $b->slug . '/' );
				?>
					<a href="<?php echo esc_url( $brand_url ); ?>" class="group bg-white border border-gray-200/80 hover:border-[#e60012] rounded-2xl p-4 sm:p-5 flex flex-col items-center text-center transition-all hover:shadow-md hover:-translate-y-1 relative">
						<?php if ( $b->is_featured ) : ?>
							<span class="absolute top-2.5 right-2.5 px-1.5 py-0.5 rounded-full bg-[#ffdad5] text-[#b7000c] text-[10px] font-extrabold uppercase">Hot</span>
						<?php endif; ?>

						<div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gray-50 group-hover:bg-red-50 flex items-center justify-center p-2.5 transition-colors mb-3">
							<?php echo phonex_get_brand_logo_img( $b, 'max-w-[44px] max-h-[44px] object-contain' ); ?>
						</div>

						<h3 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-[#e60012] transition-colors mb-1">
							<?php echo esc_html( $b->name ); ?>
						</h3>
						<span class="text-xs text-gray-600 font-bold">Bảng giá mới nhất</span>

						<div class="mt-3 flex items-center text-xs font-bold text-[#e60012] opacity-0 group-hover:opacity-100 transition-opacity">
							<span>Xem giá thu</span>
							<span class="material-symbols-outlined text-[14px] ml-0.5">arrow_forward</span>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 3. POPULAR MODELS HIGHLIGHTS -->
	<?php
	$brand_counts = array( 'all' => count( $popular_models ), 'apple' => 0, 'samsung' => 0, 'xiaomi' => 0, 'oppo' => 0, 'vivo' => 0, 'other' => 0 );
	foreach ( $popular_models as $pm_item ) {
		if ( in_array( $pm_item->brand_slug, array( 'apple', 'samsung', 'xiaomi', 'oppo', 'vivo' ) ) ) {
			$brand_counts[ $pm_item->brand_slug ]++;
		} else {
			$brand_counts['other']++;
		}
	}
	?>
	<section class="max-w-[1440px] mx-auto px-4 mt-16" id="grade-a-highlights">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
			<div>
				<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-200/80 text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#b7000c] mb-2 shadow-2xs">
					<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
					<span>CẬP NHẬT HÔM NAY • THÁNG <?php echo date( 'm/Y' ); ?></span>
				</div>
				<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
					Giá Thu Mua Nổi Bật Theo Chuẩn Grade A
				</h2>
				<p class="text-xs sm:text-sm text-gray-700 mt-1 max-w-2xl font-medium">
					Biểu phí thu mua các dòng máy Flagship &amp; bán chạy nhất theo tiêu chuẩn <strong class="text-gray-900 font-bold">Grade A (Like New 99% nguyên bản)</strong>. Báo giá tức thì, không ép giá, chuyển khoản 24/7 trong 5 phút.
				</p>
			</div>
			<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="text-xs sm:text-sm font-bold text-[#FF001F] inline-flex items-center gap-1 hover:underline shrink-0">
				<span>Xem toàn bộ bảng giá thu mua &rarr;</span>
			</a>
		</div>

		<!-- Interactive Brand Filter Tabs -->
		<div class="flex items-center gap-2 overflow-x-auto pb-3 mb-6 no-scrollbar">
			<button type="button" class="grade-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#FF001F] text-white shadow-sm shrink-0 flex items-center gap-1.5" data-brand="all">
				<span>Tất cả</span>
				<span class="px-1.5 py-0.2 rounded-full bg-white/20 text-[11px] font-black text-white"><?php echo esc_html( $brand_counts['all'] ); ?></span>
			</button>
			<?php if ( $brand_counts['apple'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="apple">
					<span>Apple</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['apple'] ); ?></span>
				</button>
			<?php endif; ?>
			<?php if ( $brand_counts['samsung'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="samsung">
					<span>Samsung</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['samsung'] ); ?></span>
				</button>
			<?php endif; ?>
			<?php if ( $brand_counts['xiaomi'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="xiaomi">
					<span>Xiaomi</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['xiaomi'] ); ?></span>
				</button>
			<?php endif; ?>
			<?php if ( $brand_counts['oppo'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="oppo">
					<span>OPPO</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['oppo'] ); ?></span>
				</button>
			<?php endif; ?>
			<?php if ( $brand_counts['vivo'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="vivo">
					<span>Vivo</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['vivo'] ); ?></span>
				</button>
			<?php endif; ?>
			<?php if ( $brand_counts['other'] > 0 ) : ?>
				<button type="button" class="grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-brand="other">
					<span>Thương hiệu khác</span>
					<span class="px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700"><?php echo esc_html( $brand_counts['other'] ); ?></span>
				</button>
			<?php endif; ?>
		</div>

		<!-- Products Grid -->
		<div id="gradeAModelsGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
			<?php if ( ! empty( $popular_models ) ) : ?>
				<?php 
				$m_idx = 0;
				foreach ( $popular_models as $pm ) : 
					$m_idx++;
					$model_url = function_exists( 'phonex_get_buyback_url_for_product' ) ? phonex_get_buyback_url_for_product( $pm ) : home_url( '/thu-mua-dien-thoai/' . $pm->brand_slug . '/' . $pm->slug . '/' );
					$img_url   = ! empty( $pm->image_url ) ? $pm->image_url : get_template_directory_uri() . '/assets/images/phones/generic-phone.png';
					$price_max = number_format( (float) $pm->base_buyback_price, 0, ',', '.' ) . '₫';
					$brand_cat = in_array( $pm->brand_slug, array( 'apple', 'samsung', 'xiaomi', 'oppo', 'vivo' ) ) ? $pm->brand_slug : 'other';
					$init_hide = ( $m_idx > 16 ) ? 'grade-initial-hidden hidden' : '';
				?>
					<div 
						class="grade-model-card bg-white rounded-2xl border border-gray-200/90 p-3 sm:p-5 flex flex-col justify-between hover:border-[#FF001F] hover:shadow-lg transition-all group relative <?php echo esc_attr( $init_hide ); ?>"
						data-brand="<?php echo esc_attr( $brand_cat ); ?>"
					>
						<div>
							<div class="flex items-center justify-between gap-1.5 mb-2.5">
								<span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md truncate max-w-[120px]">
									<img src="<?php echo esc_url( phonex_get_brand_logo_url( $pm->brand_slug ) ); ?>" alt="<?php echo esc_attr( $pm->brand_name ); ?>" class="w-3.5 h-3.5 object-contain" />
									<span><?php echo esc_html( $pm->brand_name ); ?></span>
								</span>
								<span class="text-[10px] sm:text-[11px] font-black text-[#00875A] bg-green-50 px-2 py-0.5 rounded-md border border-green-200/80 shrink-0">
									Grade A (99%)
								</span>
							</div>

							<a href="<?php echo esc_url( $model_url ); ?>" class="block py-2 sm:py-3 text-center">
								<img 
									src="<?php echo esc_url( $img_url ); ?>" 
									alt="<?php echo esc_attr( $pm->name ); ?>" 
									class="h-32 sm:h-40 mx-auto object-contain group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								/>
							</a>

							<h3 class="text-xs sm:text-sm md:text-base font-bold text-gray-900 line-clamp-2 group-hover:text-[#FF001F] transition-colors mb-2 min-h-[36px] sm:min-h-[44px]">
								<a href="<?php echo esc_url( $model_url ); ?>">
									<?php echo esc_html( $pm->name ); ?>
								</a>
							</h3>

							<div class="bg-red-50/70 rounded-xl p-2.5 sm:p-3 mb-3 border border-red-100/90">
								<div class="text-[10px] sm:text-[11px] text-gray-700 font-bold mb-0.5">Giá thu lên đến:</div>
								<div class="text-base sm:text-xl font-black text-[#FF001F] leading-none">
									<?php echo esc_html( $price_max ); ?>
								</div>
								<div class="text-[9px] sm:text-[10px] text-gray-700 font-medium mt-1">Chuẩn máy zin 99% Like New</div>
							</div>
						</div>

						<a href="<?php echo esc_url( $model_url ); ?>" class="w-full min-h-[40px] sm:min-h-[44px] rounded-[8px] bg-[#FF001F] hover:bg-[#D9001B] text-white font-semibold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-all shadow-sm">
							<span>Định giá thiết bị này</span>
							<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
						</a>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<!-- Action bar & Load More Button -->
		<div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
			<?php if ( count( $popular_models ) > 16 ) : ?>
				<button 
					type="button" 
					id="gradeALoadMoreBtn" 
					class="w-full sm:w-auto px-7 py-3.5 rounded-[8px] bg-[#FF001F] hover:bg-[#D9001B] text-white font-semibold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm transition-all"
				>
					<span class="material-symbols-outlined text-[18px]">expand_more</span>
					<span>Xem thêm +<?php echo ( count( $popular_models ) - 16 ); ?> sản phẩm nổi bật</span>
				</button>
			<?php endif; ?>
			<a 
				href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" 
				class="w-full sm:w-auto px-6 py-3.5 rounded-[8px] bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] font-semibold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-2xs transition-all"
			>
				<span class="material-symbols-outlined text-[18px] text-[#FF001F]">table_chart</span>
				<span>Xem toàn bộ bảng giá thu mua &rarr;</span>
			</a>
		</div>
	</section>

	<!-- 4. 7-STEP INSPECTION & BUYBACK PROCESS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-10 shadow-sm">
			<div class="text-center max-w-2xl mx-auto mb-10">
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Minh bạch &amp; Chuẩn hóa</div>
				<h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-3">
					Quy Trình Thu Mua 7 Bước Chuẩn PhoneX
				</h2>
				<p class="text-xs sm:text-sm text-gray-700 font-medium">
					Kiểm định công khai dưới sự chứng kiến của quý khách. Hoàn trả miễn phí 100% nếu bạn không hài lòng về mức giá.
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4">
				<?php 
				$steps = array(
					array( 'num' => '01', 'icon' => 'calculate', 'title' => 'Định giá online', 'desc' => '30s có ngay giá tham khảo.' ),
					array( 'num' => '02', 'icon' => 'calendar_month', 'title' => 'Đặt lịch hẹn', 'desc' => 'Tại showroom hoặc tận nhà.' ),
					array( 'num' => '03', 'icon' => 'assignment', 'title' => 'Tiếp nhận máy', 'desc' => 'In mã QR tra cứu tiến độ.' ),
					array( 'num' => '04', 'icon' => 'rule', 'title' => 'Test 30 bước', 'desc' => 'Kiểm định phần cứng công khai.' ),
					array( 'num' => '05', 'icon' => 'grade', 'title' => 'Phân hạng Grade', 'desc' => 'Theo chuẩn A / B / C / D.' ),
					array( 'num' => '06', 'icon' => 'handshake', 'title' => 'Chốt giá thu', 'desc' => 'Khách đồng ý mới tiến hành.' ),
					array( 'num' => '07', 'icon' => 'payments', 'title' => 'Giải ngân 5p', 'desc' => 'Chuyển khoản 24/7 tức thì.' ),
				);
				foreach ( $steps as $st ) : ?>
					<div class="bg-gray-50 rounded-2xl p-4 flex flex-col justify-between border border-gray-100 hover:border-[#e60012] transition-colors">
						<div>
							<div class="flex items-center justify-between mb-3">
								<span class="text-xs font-black text-gray-500"><?php echo esc_html( $st['num'] ); ?></span>
								<div class="w-8 h-8 rounded-lg bg-white text-[#e60012] flex items-center justify-center shadow-2xs">
									<span class="material-symbols-outlined text-[18px]"><?php echo esc_html( $st['icon'] ); ?></span>
								</div>
							</div>
							<h3 class="text-sm font-bold text-gray-900 mb-1 leading-snug">
								<?php echo esc_html( $st['title'] ); ?>
							</h3>
							<p class="text-[11px] text-gray-700 font-medium leading-relaxed">
								<?php echo esc_html( $st['desc'] ); ?>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="text-center mt-8">
				<a href="<?php echo esc_url( home_url( '/quy-trinh-thu-mua/' ) ); ?>" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#e60012] hover:text-[#b7000c] transition-colors">
					<span>Xem quy trình kiểm định chi tiết &rarr;</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 5. B2B WHOLESALE & PARTNER PROGRAM -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="relative rounded-2xl p-6 sm:p-10 md:p-12 border border-[#ffb4aa] shadow-xs overflow-hidden" style="background-color: var(--px-primary-fixed, #FFF0F2);">
			<!-- Ambient glows & Watermark icon -->
			<div class="absolute -right-12 -top-12 w-80 h-80 bg-white/50 rounded-full blur-3xl pointer-events-none"></div>
			<div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
			<div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:block opacity-10 pointer-events-none select-none">
				<span class="material-symbols-outlined text-[200px] text-[#FF001F]">handshake</span>
			</div>

			<div class="max-w-3xl relative z-10">
				<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/95 border border-[#FF001F]/20 text-[#b7000c] text-[12px] sm:text-[13px] font-bold tracking-wide uppercase mb-3 shadow-2xs">
					<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
					Hợp tác kinh doanh đại lý
				</div>
				<h2 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight mb-4 text-[#1F1F1F]">
					Bán Sỉ Điện Thoại Cũ Đã Phân Grade Cho Đại Lý &amp; Cửa Hàng
				</h2>
				<p class="text-xs sm:text-sm md:text-base text-gray-800 leading-relaxed mb-6 font-medium">
					PhoneX cung cấp nguồn hàng điện thoại cũ số lượng lớn đã qua kiểm định 30 bước, phân loại Grade A, B, C rõ ràng, xuất hóa đơn VAT đầy đủ, chính sách bảo hành bao test 1 đổi 1 cho đối tác sỉ toàn quốc.
				</p>
				<div class="flex flex-wrap items-center gap-3">
					<a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="px-6 py-3.5 rounded-[8px] bg-[#FF001F] hover:bg-[#D9001B] text-white font-semibold text-xs sm:text-sm flex items-center gap-2 transition-all shadow-sm min-h-[48px]">
						<span class="material-symbols-outlined text-[18px]">inventory_2</span>
						<span>Xem Kho Máy Cũ &amp; Báo Giá Sỉ &rarr;</span>
					</a>
					<a href="tel:18006868" class="px-5 py-3.5 rounded-[8px] bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] font-semibold text-xs sm:text-sm flex items-center gap-2 transition-all min-h-[48px] shadow-2xs">
						<span class="material-symbols-outlined text-[18px] text-[#FF001F]">call</span>
						<span>Hotline B2B: 1800.6868</span>
					</a>
					<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-5 py-3.5 rounded-[8px] bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] font-semibold text-xs sm:text-sm flex items-center gap-1.5 transition-all min-h-[48px] shadow-2xs">
						<span class="material-symbols-outlined text-[18px] text-[#FF001F]">table_chart</span>
						<span>Bảng giá thu mua &rarr;</span>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<!-- Live Search Auto-complete Script for Homepage -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	var input = document.getElementById('homeBuybackSearchInput');
	var resultsBox = document.getElementById('homeBuybackSearchResults');
	var debounceTimer = null;

	if (input && resultsBox) {
		input.addEventListener('input', function() {
			var query = input.value.trim();
			clearTimeout(debounceTimer);

			if (query.length < 2) {
				resultsBox.classList.add('hidden');
				resultsBox.innerHTML = '';
				return;
			}

			debounceTimer = setTimeout(function() {
				fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/search?q=' ) ); ?>' + encodeURIComponent(query))
					.then(function(res) { return res.json(); })
					.then(function(data) {
						if (data && data.results && data.results.length > 0) {
							var html = '';
							data.results.forEach(function(item) {
								html += '<a href="' + item.url + '" class="flex items-center justify-between p-2.5 hover:bg-red-50 rounded-xl transition-colors border-b border-gray-50 last:border-0">';
								html += '<div class="flex items-center gap-3">';
								html += '<img src="' + item.image_url + '" class="w-10 h-10 object-contain rounded-lg bg-gray-50 p-1" alt="' + item.model_name + '" />';
								html += '<div>';
								html += '<div class="text-sm font-bold text-gray-900">' + item.model_name + '</div>';
								html += '<div class="text-xs text-gray-700 font-medium">' + item.brand_name + (item.series_name ? ' • ' + item.series_name : '') + '</div>';
								html += '</div>';
								html += '</div>';
								html += '<div class="text-right">';
								html += '<div class="text-[10px] font-bold text-gray-600">Giá thu tới</div>';
								html += '<div class="text-sm font-black text-[#e60012]">' + item.base_buyback_price_formatted + '</div>';
								html += '</div>';
								html += '</a>';
							});
							resultsBox.innerHTML = html;
							resultsBox.classList.remove('hidden');
						} else {
							resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-gray-700 font-medium">Không tìm thấy thiết bị phù hợp. Thử tìm với iPhone 15, Galaxy S24...</div>';
							resultsBox.classList.remove('hidden');
						}
					})
					.catch(function(err) {
						console.error('Search error:', err);
					});
			}, 250);
		});

		document.addEventListener('click', function(e) {
			if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
				resultsBox.classList.add('hidden');
			}
		});
	}

	// Quick Valuate Widget
	var brandSelect = document.getElementById('quickBrandSelect');
	var modelSelect = document.getElementById('quickModelSelect');
	var priceDisplay = document.getElementById('quickPriceDisplay');
	var valuateBtn = document.getElementById('quickValuateBtn');

	function loadQuickModels(brandId) {
		fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/models?brand_id=' ) ); ?>' + brandId)
			.then(function(r) { return r.json(); })
			.then(function(data) {
				if (data && data.models && data.models.length > 0) {
					var html = '';
					data.models.forEach(function(m) {
						var priceFmt = m.base_buyback_price_formatted;
						if (!priceFmt && m.base_buyback_price) {
							priceFmt = Number(m.base_buyback_price).toLocaleString('vi-VN') + '₫';
						} else if (!priceFmt && m.price) {
							priceFmt = Number(m.price).toLocaleString('vi-VN') + '₫';
						}
						if (!priceFmt || priceFmt === 'undefined') {
							priceFmt = '28.500.000₫';
						}
						html += '<option value="' + m.id + '" data-price="' + priceFmt + '" data-url="' + (m.url || '#') + '">' + m.name + '</option>';
					});
					modelSelect.innerHTML = html;
					updateQuickModel();
				}
			});
	}

	function updateQuickModel() {
		var opt = modelSelect.options[modelSelect.selectedIndex];
		if (opt) {
			priceDisplay.textContent = opt.getAttribute('data-price') || '0₫';
			valuateBtn.setAttribute('href', opt.getAttribute('data-url') || '#');
		}
	}

	if (brandSelect && modelSelect) {
		brandSelect.addEventListener('change', function() {
			loadQuickModels(this.value);
		});
		modelSelect.addEventListener('change', updateQuickModel);
		loadQuickModels(brandSelect.value);
	}

	// Interactive Grade A Brand Filter Tabs & Load More Handler
	var gradeTabBtns = document.querySelectorAll('.grade-tab-btn');
	var gradeCards = document.querySelectorAll('.grade-model-card');
	var gradeLoadMoreBtn = document.getElementById('gradeALoadMoreBtn');
	var gradeIsExpanded = false;

	function filterGradeCards(brand) {
		gradeCards.forEach(function(card, idx) {
			var cardBrand = card.getAttribute('data-brand');
			if (brand === 'all') {
				if (!gradeIsExpanded && idx >= 16) {
					card.classList.add('hidden');
				} else {
					card.classList.remove('hidden');
				}
			} else if (cardBrand === brand) {
				card.classList.remove('hidden');
			} else {
				card.classList.add('hidden');
			}
		});

		if (gradeLoadMoreBtn) {
			if (brand === 'all' && !gradeIsExpanded) {
				gradeLoadMoreBtn.classList.remove('hidden');
			} else {
				gradeLoadMoreBtn.classList.add('hidden');
			}
		}
	}

	gradeTabBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			gradeTabBtns.forEach(function(b) {
				b.className = 'grade-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5';
				var badge = b.querySelector('span:last-child');
				if (badge) badge.className = 'px-1.5 py-0.2 rounded-full bg-gray-100 text-[11px] font-black text-gray-700';
			});
			this.className = 'grade-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#FF001F] text-white shadow-sm shrink-0 flex items-center gap-1.5';
			var activeBadge = this.querySelector('span:last-child');
			if (activeBadge) activeBadge.className = 'px-1.5 py-0.2 rounded-full bg-white/20 text-[11px] font-black text-white';

			var brand = this.getAttribute('data-brand');
			filterGradeCards(brand);
		});
	});

	if (gradeLoadMoreBtn) {
		gradeLoadMoreBtn.addEventListener('click', function() {
			gradeIsExpanded = true;
			document.querySelectorAll('.grade-initial-hidden').forEach(function(el) {
				el.classList.remove('hidden');
			});
			gradeLoadMoreBtn.classList.add('hidden');
		});
	}
});
</script>

<?php
get_footer();
