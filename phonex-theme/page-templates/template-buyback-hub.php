<?php
/**
 * Template Name: PhoneX Buyback Hub (Trang Chủ Thu Mua)
 *
 * Route: /thu-mua-dien-thoai/
 * Description: Hub trung tâm thu mua điện thoại cũ của PhoneX.
 *
 * @package PhoneX
 */

get_header();

global $wpdb;
$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
$t_models = $wpdb->prefix . 'phonex_buyback_models';

// Fetch active brands
$brands = $wpdb->get_results( "SELECT * FROM $t_brands WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, name ASC" );

// Fetch popular models for price highlights
$popular_models = $wpdb->get_results(
	"SELECT m.*, b.name as brand_name, b.slug as brand_slug 
	 FROM $t_models m 
	 JOIN $t_brands b ON m.brand_id = b.id 
	 WHERE m.is_active = 1 AND m.is_popular = 1 
	 ORDER BY m.sort_order ASC, m.base_buyback_price DESC 
	 LIMIT 8"
);
?>

<main id="primary" class="site-main bg-background min-h-screen font-sans pb-16">

	<!-- 1. BREADCRUMBS -->
	<nav class="bg-white border-b border-gray-100 py-3" aria-label="Breadcrumb">
		<div class="max-w-[1440px] mx-auto px-4 flex items-center gap-2 text-xs md:text-sm text-gray-500">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#e60012] flex items-center gap-1 transition-colors">
				<span class="material-symbols-outlined text-[16px]">home</span>
				<span>Trang chủ</span>
			</a>
			<span class="text-gray-300">/</span>
			<span class="text-gray-900 font-semibold">Thu Mua Điện Thoại</span>
		</div>
	</nav>

	<!-- 2. HERO BANNER & VALUATION LAUNCHER -->
	<section class="relative border-b border-[#ffb4aa]/80 pt-10 pb-14 px-4 overflow-hidden" style="background-color: var(--px-primary-fixed, #FFF0F2);">
		<!-- Background decorative glow & faint watermark -->
		<div class="absolute -top-24 -right-24 w-96 h-96 bg-white/60 rounded-full blur-3xl pointer-events-none"></div>
		<div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#ffb4aa]/30 rounded-full blur-3xl pointer-events-none"></div>
		<div class="absolute right-8 top-1/2 -translate-y-1/2 hidden xl:block opacity-5 pointer-events-none select-none">
			<span class="material-symbols-outlined text-[320px] text-[#FF001F]">receipt_long</span>
		</div>

		<div class="max-w-[1280px] mx-auto relative z-10 text-center">
			<!-- Tagline Badge -->
			<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/95 border border-[#FF001F]/20 text-xs md:text-sm font-bold text-[#b7000c] mb-5 tracking-wide shadow-2xs">
				<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
				<span>TRUNG TÂM THU MUA &amp; KIỂM ĐỊNH ĐIỆN THOẠI CHUẨN QUỐC TẾ</span>
			</div>

			<!-- Main H1 Title -->
			<h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight text-[#1F1F1F] mb-4 leading-tight">
				Thu Mua Điện Thoại Cũ Giá Cao Nhất Thị Trường
			</h1>

			<!-- Subtitle -->
			<p class="max-w-2xl mx-auto text-sm sm:text-base md:text-lg text-gray-800 mb-8 leading-relaxed font-medium">
				Kiểm định 30 bước chuẩn <span class="text-gray-900 font-bold">Grade A / B / C / D</span>. Báo giá công khai, không ép giá. Giải ngân chuyển khoản 24/7 chỉ sau <span class="text-[#FF001F] font-bold underline decoration-[#FF001F] decoration-2">5 phút</span>.
			</p>

			<!-- Quick Search Box with Auto-complete Dropdown -->
			<div class="max-w-xl mx-auto mb-8 relative">
				<div class="relative flex items-center shadow-lg rounded-2xl bg-white p-1.5 border border-gray-200/90 focus-within:ring-2 focus-within:ring-[#FF001F] transition-all">
					<span class="material-symbols-outlined text-gray-500 text-[24px] pl-3">search</span>
					<input 
						id="buybackHubSearchInput"
						type="search" 
						placeholder="Nhập tên điện thoại bạn muốn bán (VD: iPhone 15 Pro Max, Galaxy S24...)" 
						class="w-full h-12 px-3 text-sm md:text-base text-gray-900 placeholder-gray-500 bg-transparent outline-none font-medium"
						autocomplete="off"
					/>
					<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-5 h-11 bg-[#FF001F] hover:bg-[#D9001B] text-white rounded-xl font-bold text-sm flex items-center justify-center gap-1.5 shrink-0 transition-colors shadow-sm">
						<span class="hidden sm:inline">Định giá</span>
						<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
					</a>
				</div>
				<!-- Search results dropdown -->
				<div id="buybackHubSearchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 p-2 z-50 text-left max-h-80 overflow-y-auto"></div>
			</div>

			<!-- Action Buttons -->
			<div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
				<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-7 py-3.5 rounded-xl bg-[#FF001F] hover:bg-[#D9001B] text-white text-sm sm:text-base font-bold shadow-sm flex items-center gap-2 transition-all transform hover:-translate-y-0.5 min-h-[48px]">
					<span class="material-symbols-outlined text-[20px]">calculate</span>
					<span>ĐỊNH GIÁ ĐIỆN THOẠI NGAY</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="px-6 py-3.5 rounded-xl bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] text-sm sm:text-base font-bold flex items-center gap-2 transition-all min-h-[48px] shadow-2xs">
					<span class="material-symbols-outlined text-[20px] text-[#FF001F]">track_changes</span>
					<span>TRA CỨU YÊU CẦU THU MUA</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-6 py-3.5 rounded-xl bg-white hover:bg-gray-50 border border-gray-300/90 text-[#1F1F1F] hover:text-[#FF001F] text-sm sm:text-base font-bold flex items-center gap-2 transition-all min-h-[48px] shadow-2xs">
					<span class="material-symbols-outlined text-[20px] text-[#FF001F]">table_chart</span>
					<span>BẢNG GIÁ THU MUA 2026</span>
				</a>
			</div>

			<!-- Highlight Stats Bar -->
			<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 pt-8 border-t border-[#ffb4aa]/60 max-w-4xl mx-auto">
				<div class="flex flex-col items-center">
					<span class="text-2xl sm:text-3xl font-black text-[#b7000c]">128+</span>
					<span class="text-xs text-gray-800 font-bold mt-1">Showroom toàn quốc</span>
				</div>
				<div class="flex flex-col items-center">
					<span class="text-2xl sm:text-3xl font-black text-[#b7000c]">30 Giây</span>
					<span class="text-xs text-gray-800 font-bold mt-1">Định giá tức thì</span>
				</div>
				<div class="flex flex-col items-center">
					<span class="text-2xl sm:text-3xl font-black text-[#b7000c]">5 Phút</span>
					<span class="text-xs text-gray-800 font-bold mt-1">Nhận tiền qua thẻ 24/7</span>
				</div>
				<div class="flex flex-col items-center">
					<span class="text-2xl sm:text-3xl font-black text-[#b7000c]">100%</span>
					<span class="text-xs text-gray-800 font-bold mt-1">Bảo mật xóa sạch dữ liệu</span>
				</div>
			</div>
		</div>
	</section>

	<!-- 3. BRAND SELECTION GRID (DYNAMICALLY DRIVEN FROM DATABASE) -->
	<section class="max-w-[1440px] mx-auto px-4 mt-12">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
			<div>
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Thương hiệu hỗ trợ</div>
				<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
					Chọn Thương Hiệu Cần Bán
				</h2>
			</div>
			<p class="text-xs sm:text-sm text-gray-500 max-w-md">
				PhoneX thu mua tất cả dòng máy chính hãng và xách tay với mức giá cạnh tranh nhất.
			</p>
		</div>

		<!-- Dynamic Brand Cards Grid (6 cols desktop, 4 cols tablet, 2-3 mobile) -->
		<div id="buybackBrandGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
			<?php if ( ! empty( $brands ) ) : ?>
				<?php foreach ( $brands as $index => $b ) : 
					$brand_url = home_url( '/thu-mua-dien-thoai/' . $b->slug . '/' );
					$is_hidden_item = ( $index >= 12 );
				?>
					<a href="<?php echo esc_url( $brand_url ); ?>" class="buyback-brand-card group bg-white border border-gray-200/80 hover:border-[#e60012] rounded-2xl p-4 sm:p-5 flex flex-col items-center text-center transition-all hover:shadow-md hover:-translate-y-1 relative <?php echo $is_hidden_item ? 'hidden' : ''; ?>" data-brand-index="<?php echo esc_attr( $index ); ?>">
						<?php if ( $b->is_featured ) : ?>
							<span class="absolute top-2.5 right-2.5 px-1.5 py-0.5 rounded-full bg-[#ffdad5] text-[#b7000c] text-[10px] font-extrabold uppercase">Hot</span>
						<?php endif; ?>

						<!-- Brand Logo / Badge -->
						<div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gray-50 group-hover:bg-red-50 flex items-center justify-center p-2.5 transition-colors mb-3">
							<?php echo phonex_get_brand_logo_img( $b, 'max-w-[44px] max-h-[44px] object-contain' ); ?>
						</div>

						<!-- Brand Name -->
						<h3 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-[#e60012] transition-colors mb-1">
							<?php echo esc_html( $b->name ); ?>
						</h3>
						<span class="text-xs text-gray-600 font-bold">Bảng giá mới nhất</span>

						<!-- Hover arrow indicator -->
						<div class="mt-3 flex items-center text-xs font-bold text-[#e60012] opacity-0 group-hover:opacity-100 transition-opacity">
							<span>Xem bảng giá</span>
							<span class="material-symbols-outlined text-[14px] ml-0.5">arrow_forward</span>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<?php if ( count( $brands ) > 12 ) : ?>
			<div class="text-center mt-6">
				<button type="button" id="buybackToggleBrandsBtn" class="px-6 py-2.5 rounded-xl border border-gray-300 hover:border-[#e60012] text-gray-700 hover:text-[#e60012] font-bold text-sm inline-flex items-center gap-2 transition-all bg-white shadow-2xs">
					<span>Xem tất cả thương hiệu (<?php echo esc_html( count( $brands ) ); ?>)</span>
					<span class="material-symbols-outlined text-[18px]">expand_more</span>
				</button>
			</div>
		<?php endif; ?>
	</section>

	<!-- 4. POPULAR MODELS BUYBACK PRICE HIGHLIGHTS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-14">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
			<div>
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Bảng giá cập nhật hôm nay</div>
				<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
					Giá Thu Mua Điện Thoại Nổi Bật
				</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="text-xs sm:text-sm font-bold text-[#e60012] hover:text-[#b7000c] inline-flex items-center gap-1 transition-colors">
				<span>Xem toàn bộ bảng giá thu mua</span>
				<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
			</a>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
			<?php if ( ! empty( $popular_models ) ) : ?>
				<?php foreach ( $popular_models as $pm ) : 
					$model_url = home_url( '/thu-mua-dien-thoai/' . $pm->brand_slug . '/' . $pm->slug . '/' );
					$img_url   = ! empty( $pm->image_url ) ? $pm->image_url : get_template_directory_uri() . '/assets/images/phones/generic-phone.png';
					$price_max = number_format( (float) $pm->base_buyback_price, 0, ',', '.' ) . '₫';
				?>
					<div class="bg-white rounded-2xl border border-gray-200/90 p-4 sm:p-5 flex flex-col justify-between hover:border-[#e60012] hover:shadow-lg transition-all group">
						<div>
							<!-- Brand Badge & Grade Badge -->
							<div class="flex items-center justify-between gap-2 mb-3">
								<span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">
									<img src="<?php echo esc_url( phonex_get_brand_logo_url( $pm->brand_slug ) ); ?>" alt="<?php echo esc_attr( $pm->brand_name ); ?>" class="w-3.5 h-3.5 object-contain" />
									<span><?php echo esc_html( $pm->brand_name ); ?></span>
								</span>
								<span class="text-[11px] font-black text-[#198754] bg-green-50 px-2 py-0.5 rounded-md border border-green-200">
									Grade A (99%)
								</span>
							</div>

							<!-- Image -->
							<a href="<?php echo esc_url( $model_url ); ?>" class="block py-4 text-center">
								<img 
									src="<?php echo esc_url( $img_url ); ?>" 
									alt="<?php echo esc_attr( $pm->name ); ?>" 
									class="h-36 sm:h-40 mx-auto object-contain group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								/>
							</a>

							<!-- Title -->
							<h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 group-hover:text-[#e60012] transition-colors mb-2">
								<a href="<?php echo esc_url( $model_url ); ?>">
									<?php echo esc_html( $pm->name ); ?>
								</a>
							</h3>

							<!-- Price Display -->
							<div class="bg-red-50/60 rounded-xl p-3 mb-4 border border-red-100">
								<div class="text-[11px] text-gray-700 font-bold mb-0.5">Giá thu lên đến:</div>
								<div class="text-lg sm:text-xl font-black text-[#e60012] leading-none">
									<?php echo esc_html( $price_max ); ?>
								</div>
								<div class="text-[10px] text-gray-700 font-bold mt-1">Đã áp dụng định giá Grade A</div>
							</div>
						</div>

						<!-- Action CTA -->
						<a href="<?php echo esc_url( $model_url ); ?>" class="w-full h-11 rounded-xl bg-gray-900 group-hover:bg-[#e60012] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-colors shadow-2xs">
							<span>Định giá thiết bị này</span>
							<span class="material-symbols-outlined text-[16px]">chevron_right</span>
						</a>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 5. 7-STEP INSPECTION & BUYBACK PROCESS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-10 shadow-sm">
			<div class="text-center max-w-2xl mx-auto mb-10">
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Minh bạch &amp; Chuẩn hóa</div>
				<h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mb-3">
					Quy Trình Thu Mua 7 Bước Chuẩn PhoneX
				</h2>
				<p class="text-xs sm:text-sm text-gray-500">
					Toàn bộ quá trình kiểm định thực hiện công khai dưới sự chứng kiến của quý khách, cam kết không tráo đổi linh kiện, không ép giá.
				</p>
			</div>

			<!-- 7 Steps Visual Timeline -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 relative">
				<?php 
				$steps = array(
					array( 'num' => '01', 'icon' => 'calculate', 'title' => 'Định giá online', 'desc' => 'Chọn model & tình trạng để nhận giá ước tính trong 30s.' ),
					array( 'num' => '02', 'icon' => 'calendar_month', 'title' => 'Đặt lịch thu mua', 'desc' => 'Chọn mang máy ra showroom hoặc thu tận nhà.' ),
					array( 'num' => '03', 'icon' => 'assignment', 'title' => 'Tiếp nhận máy', 'desc' => 'In phiếu thu có mã QR tra cứu tiến độ thời gian thực.' ),
					array( 'num' => '04', 'icon' => 'rule', 'title' => 'Kiểm định 30 bước', 'desc' => 'Kiểm tra màn hình, main, pin, camera, cảm biến chuyên sâu.' ),
					array( 'num' => '05', 'icon' => 'grade', 'title' => 'Phân hạng Grade', 'desc' => 'Xếp hạng A, B, C, D theo barem kỹ thuật niêm yết.' ),
					array( 'num' => '06', 'icon' => 'handshake', 'title' => 'Chốt giá thu', 'desc' => 'Báo giá chính xác nhất. Khách đồng ý mới tiến hành thu.' ),
					array( 'num' => '07', 'icon' => 'payments', 'title' => 'Chuyển khoản ngay', 'desc' => 'Giải ngân 24/7 trong 5 phút. Xóa sạch dữ liệu an toàn.' ),
				);
				foreach ( $steps as $st ) : ?>
					<div class="bg-gray-50 rounded-2xl p-4 flex flex-col justify-between border border-gray-100 hover:border-[#e60012] transition-colors relative">
						<div>
							<div class="flex items-center justify-between mb-3">
								<span class="text-xs font-black text-gray-300"><?php echo esc_html( $st['num'] ); ?></span>
								<div class="w-8 h-8 rounded-lg bg-white text-[#e60012] flex items-center justify-center shadow-2xs">
									<span class="material-symbols-outlined text-[18px]"><?php echo esc_html( $st['icon'] ); ?></span>
								</div>
							</div>
							<h3 class="text-sm font-bold text-gray-900 mb-1.5 leading-snug">
								<?php echo esc_html( $st['title'] ); ?>
							</h3>
							<p class="text-[12px] text-gray-500 leading-relaxed">
								<?php echo esc_html( $st['desc'] ); ?>
							</p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="text-center mt-8">
				<a href="<?php echo esc_url( home_url( '/quy-trinh-thu-mua/' ) ); ?>" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#e60012] hover:text-[#b7000c] transition-colors">
					<span>Xem quy trình kiểm định chi tiết &amp; cam kết dịch vụ</span>
					<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 6. GRADE STANDARDS OVERVIEW (GRADE A / B / C / D) -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">
			<div>
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Minh bạch định giá</div>
				<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
					Tiêu Chuẩn Phân Loại Grade Tại PhoneX
				</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="text-xs sm:text-sm font-bold text-[#e60012] hover:text-[#b7000c] inline-flex items-center gap-1 transition-colors">
				<span>Xem chi tiết barem kiểm định 30 bước</span>
				<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
			</a>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
			<!-- Grade A -->
			<div class="bg-white rounded-2xl border-2 border-emerald-500/80 p-5 flex flex-col justify-between shadow-xs relative">
				<span class="absolute -top-3 right-4 px-2.5 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-black uppercase">
					Giá Thu Cao Nhất
				</span>
				<div>
					<div class="flex items-center gap-2 mb-2">
						<span class="text-xl font-black text-emerald-600">GRADE A</span>
						<span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">99% Like New</span>
					</div>
					<p class="text-xs text-gray-600 mb-4">Máy đẹp như mới, không trầy xước hoặc xước lông mèo cực nhỏ, pin cao, linh kiện nguyên zin 100%.</p>
					<ul class="text-xs text-gray-600 space-y-1.5 mb-4">
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-500 text-[16px]">check_circle</span> Màn hình đẹp, không ám ố</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-500 text-[16px]">check_circle</span> Vỏ không cấn móp, không tróc sơn</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-500 text-[16px]">check_circle</span> Dung lượng pin &gt; 85%</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-500 text-[16px]">check_circle</span> Đầy đủ Face ID / Vân tay / Camera</li>
					</ul>
				</div>
				<div class="pt-3 border-t border-gray-100 text-xs font-bold text-emerald-700">
					Thu mua 100% giá niêm yết
				</div>
			</div>

			<!-- Grade B -->
			<div class="bg-white rounded-2xl border border-blue-400 p-5 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center gap-2 mb-2">
						<span class="text-xl font-black text-blue-600">GRADE B</span>
						<span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">95% Very Good</span>
					</div>
					<p class="text-xs text-gray-600 mb-4">Ngoại hình trầy nhẹ viền hoặc lưng qua thời gian sử dụng, màn hình đẹp, mọi tính năng hoạt động hoàn hảo.</p>
					<ul class="text-xs text-gray-600 space-y-1.5 mb-4">
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-blue-500 text-[16px]">check_circle</span> Màn hình trầy nhẹ dăm</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-blue-500 text-[16px]">check_circle</span> Vỏ trầy xước nhẹ góc cạnh</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-blue-500 text-[16px]">check_circle</span> Dung lượng pin 80% - 85%</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-blue-500 text-[16px]">check_circle</span> Chưa qua sửa chữa mainboard</li>
					</ul>
				</div>
				<div class="pt-3 border-t border-gray-100 text-xs font-bold text-blue-700">
					Thu mua 85% - 90% giá Grade A
				</div>
			</div>

			<!-- Grade C -->
			<div class="bg-white rounded-2xl border border-amber-400 p-5 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center gap-2 mb-2">
						<span class="text-xl font-black text-amber-600">GRADE C</span>
						<span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">90% Good</span>
					</div>
					<p class="text-xs text-gray-600 mb-4">Ngoại hình cấn móp hoặc trầy xước nhiều, màn hình có vết trầy rõ, tuy nhiên tính năng chính vẫn ổn định.</p>
					<ul class="text-xs text-gray-600 space-y-1.5 mb-4">
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-amber-500 text-[16px]">check_circle</span> Vỏ cấn móp, trầy xước rõ</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-amber-500 text-[16px]">check_circle</span> Màn có trầy xước hoặc ám nhẹ</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-amber-500 text-[16px]">check_circle</span> Pin dưới 80% (cần bảo trì)</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-amber-500 text-[16px]">check_circle</span> Máy nghe gọi, kết nối tốt</li>
					</ul>
				</div>
				<div class="pt-3 border-t border-gray-100 text-xs font-bold text-amber-700">
					Thu mua 70% - 75% giá Grade A
				</div>
			</div>

			<!-- Grade D -->
			<div class="bg-white rounded-2xl border border-gray-300 p-5 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center gap-2 mb-2">
						<span class="text-xl font-black text-gray-700">GRADE D</span>
						<span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">Linh kiện / Lỗi</span>
					</div>
					<p class="text-xs text-gray-600 mb-4">Máy rơi vỡ nứt kính, màn hình sọc hoặc chảy mực, mất Face ID / vân tay, vỏ biến dạng hoặc lỗi tính năng.</p>
					<ul class="text-xs text-gray-600 space-y-1.5 mb-4">
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-gray-400 text-[16px]">build</span> Màn hình sọc, mực, vỡ kính</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-gray-400 text-[16px]">build</span> Hỏng camera hoặc mất Face ID</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-gray-400 text-[16px]">build</span> Vỏ nứt vỡ, cong vênh</li>
						<li class="flex items-center gap-1.5"><span class="material-symbols-outlined text-gray-400 text-[16px]">build</span> Thu gom phục vụ rã xác linh kiện</li>
					</ul>
				</div>
				<div class="pt-3 border-t border-gray-100 text-xs font-bold text-gray-700">
					Định giá theo linh kiện thực tế
				</div>
			</div>
		</div>
	</section>

	<!-- 7. WHY CHOOSE PHONEX BUYBACK -->
	<section class="max-w-[1440px] mx-auto px-4 mt-16">
		<div class="rounded-3xl p-6 sm:p-12 relative overflow-hidden border border-[#ffb4aa] text-[#1F1F1F] shadow-xs" style="background-color: var(--px-primary-fixed, #FFF0F2);">
			<!-- Ambient lighting & decorative icon -->
			<div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
			<div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
			<div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-5 pointer-events-none select-none">
				<span class="material-symbols-outlined text-[240px] text-[#FF001F]">verified</span>
			</div>

			<div class="max-w-3xl relative z-10">
				<div class="text-xs font-bold uppercase tracking-wider text-[#b7000c] mb-2">Lợi ích vượt trội</div>
				<h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-[#1F1F1F] tracking-tight mb-4">
					Tại Sao Nên Bán Điện Thoại Cũ Cho PhoneX?
				</h2>
				<p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed mb-8">
					PhoneX hoạt động theo mô hình khép kín: Thu mua số lượng lớn trực tiếp từ khách hàng cá nhân &amp; doanh nghiệp, kiểm định phân Grade và phân phối trực tiếp cho hệ thống đối tác bán sỉ toàn quốc, cắt bỏ mọi trung gian để mang lại mức giá thu mua cao nhất cho bạn.
				</p>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
				<div class="bg-white rounded-2xl p-5 border border-[#ffb4aa]/60 shadow-2xs">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] border border-[#ffdad5] flex items-center justify-center text-[#FF001F] mb-4">
						<span class="material-symbols-outlined text-[24px]">trending_up</span>
					</div>
					<h3 class="text-base font-bold text-[#1F1F1F] mb-2">Giá Thu Cao Nhất</h3>
					<p class="text-xs text-gray-700 font-medium leading-relaxed">Cập nhật theo biến động giá sỉ quốc tế hàng ngày, cao hơn từ 500k - 2 triệu so với các chuỗi bán lẻ thông thường.</p>
				</div>

				<div class="bg-white rounded-2xl p-5 border border-[#ffb4aa]/60 shadow-2xs">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] border border-[#ffdad5] flex items-center justify-center text-[#FF001F] mb-4">
						<span class="material-symbols-outlined text-[24px]">security</span>
					</div>
					<h3 class="text-base font-bold text-[#1F1F1F] mb-2">Bảo Mật Tuyệt Đối</h3>
					<p class="text-xs text-gray-700 font-medium leading-relaxed">Hỗ trợ khách sao lưu iCloud/Google Drive và thực hiện xóa vĩnh viễn dữ liệu cá nhân theo chuẩn DoD quốc tế.</p>
				</div>

				<div class="bg-white rounded-2xl p-5 border border-[#ffb4aa]/60 shadow-2xs">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] border border-[#ffdad5] flex items-center justify-center text-[#FF001F] mb-4">
						<span class="material-symbols-outlined text-[24px]">electric_bolt</span>
					</div>
					<h3 class="text-base font-bold text-[#1F1F1F] mb-2">Giải Ngân 5 Phút</h3>
					<p class="text-xs text-gray-700 font-medium leading-relaxed">Chuyển khoản ngay sau khi kiểm tra xong, hỗ trợ mọi ngân hàng 24/7 hoặc nhận tiền mặt tại chỗ theo yêu cầu.</p>
				</div>

				<div class="bg-white rounded-2xl p-5 border border-[#ffb4aa]/60 shadow-2xs">
					<div class="w-12 h-12 rounded-xl bg-[#FFF0F2] border border-[#ffdad5] flex items-center justify-center text-[#FF001F] mb-4">
						<span class="material-symbols-outlined text-[24px]">home_pin</span>
					</div>
					<h3 class="text-base font-bold text-[#1F1F1F] mb-2">Thu Tận Nơi Miễn Phí</h3>
					<p class="text-xs text-gray-700 font-medium leading-relaxed">Kỹ thuật viên đến tận nhà, cơ quan định giá và nhận máy trong vòng 1 giờ tại Hà Nội, TP.HCM, Đà Nẵng.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. FREQUENTLY ASKED QUESTIONS (BUYBACK FAQ) -->
	<section class="max-w-[1000px] mx-auto px-4 mt-16">
		<div class="text-center mb-8">
			<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Giải đáp thắc mắc</div>
			<h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
				Câu Hỏi Thường Gặp Về Thu Mua
			</h2>
		</div>

		<div class="space-y-3" id="buybackFaqAccordion">
			<?php 
			$faqs = array(
				array(
					'q' => 'PhoneX thu mua những loại điện thoại nào?',
					'a' => 'PhoneX thu mua tất cả các dòng smartphone chính hãng và xách tay của Apple, Samsung, Xiaomi, OPPO, vivo, realme, Google Pixel, Huawei, Sony... từ máy đẹp như mới (Grade A) đến máy cấn móp, trầy xước, pin chai, lỗi tính năng hoặc bể kính (Grade D).'
				),
				array(
					'q' => 'Tôi cần chuẩn bị những giấy tờ và phụ kiện gì khi bán máy?',
					'a' => 'Bạn chỉ cần mang theo CMND/CCCD hoặc VNeID để xác thực quyền sở hữu thiết bị. Phụ kiện như hộp, cáp sạc không bắt buộc nhưng nếu có sẽ được cộng thêm tiền vào giá thu.'
				),
				array(
					'q' => 'Dữ liệu cá nhân, hình ảnh và tài khoản trên máy có an toàn không?',
					'a' => 'PhoneX cam kết an toàn 100%. Kỹ thuật viên sẽ hướng dẫn bạn đăng xuất hoàn toàn tài khoản iCloud/Google/Samsung Account, hỗ trợ sao lưu dữ liệu sang máy mới và tiến hành khôi phục cài đặt gốc xóa sạch dữ liệu ngay trước mặt bạn.'
				),
				array(
					'q' => 'Thời gian kiểm định và nhận tiền mất bao lâu?',
					'a' => 'Quá trình kiểm định kỹ thuật 30 bước diễn ra từ 10 đến 15 phút. Ngay khi bạn đồng ý mức giá, tiền sẽ được chuyển khoản tức thì vào tài khoản ngân hàng của bạn trong vòng 3 - 5 phút.'
				),
				array(
					'q' => 'Nếu tôi không đồng ý bán sau khi kiểm định thì có mất phí không?',
					'a' => 'Hoàn toàn KHÔNG. Kiểm định tại PhoneX là 100% miễn phí. Nếu bạn chưa hài lòng với mức giá đề xuất, chúng tôi sẽ hoàn trả lại thiết bị nguyên trạng mà không thu bất kỳ chi phí nào.'
				),
			);
			foreach ( $faqs as $i => $faq ) : ?>
				<details class="bg-white rounded-2xl border border-gray-200/90 p-4 sm:p-5 group transition-all" <?php echo ( 0 === $i ) ? 'open' : ''; ?>>
					<summary class="flex items-center justify-between font-bold text-sm sm:text-base text-gray-900 cursor-pointer list-none select-none">
						<span><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
					</summary>
					<p class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						<?php echo esc_html( $faq['a'] ); ?>
					</p>
				</details>
			<?php endforeach; ?>
		</div>
	</section>

</main>

<!-- Live Search Auto-complete Script for Buyback Hub -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	var input = document.getElementById('buybackHubSearchInput');
	var resultsBox = document.getElementById('buybackHubSearchResults');
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
								html += '<div class="text-xs text-gray-500 flex items-center gap-1.5 mt-0.5">';
								if (item.brand_logo) {
									html += '<img src="' + item.brand_logo + '" class="w-3.5 h-3.5 object-contain inline-block" alt="' + item.brand_name + '" />';
								}
								html += '<span>' + item.brand_name + (item.series_name ? ' • ' + item.series_name : '') + '</span>';
								html += '</div>';
								html += '</div>';
								html += '</div>';
								html += '<div class="text-right">';
								html += '<div class="text-xs font-semibold text-gray-400">Giá thu tới</div>';
								html += '<div class="text-sm font-black text-[#e60012]">' + item.base_buyback_price_formatted + '</div>';
								html += '</div>';
								html += '</a>';
							});
							resultsBox.innerHTML = html;
							resultsBox.classList.remove('hidden');
						} else {
							resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-gray-500">Không tìm thấy thiết bị phù hợp. Thử tìm với từ khóa khác (ví dụ: iPhone 15, Galaxy S24).</div>';
							resultsBox.classList.remove('hidden');
						}
					})
					.catch(function(err) {
						console.error('Search error:', err);
					});
			}, 250);
		});

		// Close dropdown on click outside
		document.addEventListener('click', function(e) {
			if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
				resultsBox.classList.add('hidden');
			}
		});
	}

	// Toggle Brand Grid expand
	var toggleBtn = document.getElementById('buybackToggleBrandsBtn');
	if (toggleBtn) {
		toggleBtn.addEventListener('click', function() {
			var hiddenCards = document.querySelectorAll('.buyback-brand-card.hidden');
			if (hiddenCards.length > 0) {
				hiddenCards.forEach(function(card) {
					card.classList.remove('hidden');
				});
				toggleBtn.innerHTML = '<span>Thu gọn bớt thương hiệu</span><span class="material-symbols-outlined text-[18px]">expand_less</span>';
			} else {
				var allCards = document.querySelectorAll('.buyback-brand-card');
				allCards.forEach(function(card, idx) {
					if (idx >= 12) {
						card.classList.add('hidden');
					}
				});
				toggleBtn.innerHTML = '<span>Xem tất cả thương hiệu</span><span class="material-symbols-outlined text-[18px]">expand_more</span>';
			}
		});
	}
});
</script>

<?php
get_footer();
