<?php
/**
 * Template Name: PhoneX Chợ Tốt Market Intelligence & Grade Scanner (Frontend)
 *
 * Route: /thi-truong-chotot/
 * Description: Trang công khai khảo sát giá thị trường Chợ Tốt & đối chiếu chuẩn Grade A/B/C/D PhoneX.
 *
 * @package PhoneX
 */

get_header();

$json_file = get_template_directory() . '/data/chotot-used-phones.json';
$data = array(
	'metadata' => array(
		'source' => 'https://www.chotot.com/mua-ban-dien-thoai',
		'crawled_at' => '',
		'total_items' => 0,
		'grade_counts' => array(
			'GRADE_A' => 0,
			'GRADE_B' => 0,
			'GRADE_C' => 0,
			'GRADE_D' => 0,
		)
	),
	'phones' => array()
);

if ( file_exists( $json_file ) ) {
	$raw = file_get_contents( $json_file );
	$decoded = json_decode( $raw, true );
	if ( ! empty( $decoded ) && is_array( $decoded ) ) {
		$data = $decoded;
	}
}

$phones = $data['phones'] ?? array();
$meta   = $data['metadata'] ?? array();
$counts = $meta['grade_counts'] ?? array(
	'GRADE_A' => 0,
	'GRADE_B' => 0,
	'GRADE_C' => 0,
	'GRADE_D' => 0,
);

// Collect unique brands
$brands = array();
foreach ( $phones as $p ) {
	$b = trim( $p['brand'] ?? 'Khác' );
	if ( ! empty( $b ) && ! in_array( $b, $brands, true ) ) {
		$brands[] = $b;
	}
}
sort( $brands );
?>

<main id="primary" class="site-main bg-[#F6F7F9] min-h-screen font-sans pb-16">

	<!-- 1. BREADCRUMBS -->
	<nav class="bg-white border-b border-gray-200/80 py-3" aria-label="Breadcrumb">
		<div class="max-w-[1440px] mx-auto px-4 flex items-center gap-2 text-xs md:text-sm text-gray-500">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#FF001F] flex items-center gap-1 transition-colors">
				<span class="material-symbols-outlined text-[16px]">home</span>
				<span>Trang chủ</span>
			</a>
			<span class="text-gray-300">/</span>
			<a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="hover:text-[#FF001F] transition-colors">
				Thu Mua Điện Thoại
			</a>
			<span class="text-gray-300">/</span>
			<span class="text-gray-900 font-semibold">Khảo Sát Thị Trường Chợ Tốt &amp; Phân Tích Grade</span>
		</div>
	</nav>

	<!-- 2. HERO -->
	<section class="bg-white border-b border-gray-200/80 py-10 px-4">
		<div class="max-w-[1000px] mx-auto text-center">
			<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-[#b7000c] text-xs font-bold uppercase tracking-wider mb-3">
				<span class="w-2 h-2 rounded-full bg-[#FF001F] animate-pulse"></span>
				<span>DỮ LIỆU THỰC TẾ • CẬP NHẬT TỪ CHỢ TỐT</span>
			</div>
			<h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight">
				Khảo Sát Giá Thị Trường Chợ Tốt &amp; Thẩm Định Grade
			</h1>
			<p class="text-xs sm:text-base text-gray-600 mt-3 max-w-2xl mx-auto leading-relaxed font-medium">
				Hệ thống PhoneX tự động quét và phân tích sâu các tin rao bán điện thoại cũ từ <a href="https://www.chotot.com/mua-ban-dien-thoai" target="_blank" rel="noopener noreferrer" class="text-[#FF001F] font-bold hover:underline">Chợ Tốt</a> theo 4 tiêu chí cốt lõi (Vỏ, Màn hình, Pin, Phần cứng) để phân loại chuẩn <strong class="text-gray-900">Grade A / B / C / D</strong>.
			</p>
			
			<div class="flex flex-wrap items-center justify-center gap-3 mt-6">
				<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-6 py-3 rounded-xl bg-[#FF001F] hover:bg-[#D9001B] text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-sm transition-all">
					<span class="material-symbols-outlined text-[18px]">calculate</span>
					<span>Định giá máy của bạn ngay</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-6 py-3 rounded-xl bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs sm:text-sm border border-gray-200 flex items-center gap-2 transition-all">
					<span class="material-symbols-outlined text-[18px]">table_chart</span>
					<span>Xem bảng giá thu PhoneX</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 3. KPI GRADE STATS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-8">
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
			<!-- GRADE A -->
			<div class="bg-white rounded-2xl border-2 border-emerald-500/80 p-4 sm:p-5 shadow-xs flex flex-col justify-between">
				<div>
					<div class="flex items-center justify-between gap-1 mb-2">
						<span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-[11px] font-black uppercase">Grade A</span>
						<span class="text-[11px] font-bold text-emerald-700">99% Like New</span>
					</div>
					<div class="text-2xl sm:text-3xl font-black text-emerald-900"><?php echo esc_html( $counts['GRADE_A'] ?? 0 ); ?> <span class="text-xs font-bold text-gray-600">máy</span></div>
					<p class="text-xs text-gray-600 mt-1 line-clamp-2">Nguyên zin 100%, không cấn móp, pin &ge; 85%.</p>
				</div>
				<div class="mt-3 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded text-center">Thu mua 100% giá niêm yết</div>
			</div>

			<!-- GRADE B -->
			<div class="bg-white rounded-2xl border border-blue-400 p-4 sm:p-5 shadow-xs flex flex-col justify-between">
				<div>
					<div class="flex items-center justify-between gap-1 mb-2">
						<span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-800 border border-blue-200 text-[11px] font-black uppercase">Grade B</span>
						<span class="text-[11px] font-bold text-blue-700">95% Very Good</span>
					</div>
					<div class="text-2xl sm:text-3xl font-black text-blue-900"><?php echo esc_html( $counts['GRADE_B'] ?? 0 ); ?> <span class="text-xs font-bold text-gray-600">máy</span></div>
					<p class="text-xs text-gray-600 mt-1 line-clamp-2">Máy zin qua sử dụng, xước dăm nhẹ, pin 80-84%.</p>
				</div>
				<div class="mt-3 text-[11px] font-bold text-blue-700 bg-blue-50 px-2 py-1 rounded text-center">Thu mua 85% - 90% giá Grade A</div>
			</div>

			<!-- GRADE C -->
			<div class="bg-white rounded-2xl border border-amber-400 p-4 sm:p-5 shadow-xs flex flex-col justify-between">
				<div>
					<div class="flex items-center justify-between gap-1 mb-2">
						<span class="px-2.5 py-1 rounded-md bg-amber-50 text-amber-800 border border-amber-200 text-[11px] font-black uppercase">Grade C</span>
						<span class="text-[11px] font-bold text-amber-700">90% Good</span>
					</div>
					<div class="text-2xl sm:text-3xl font-black text-amber-900"><?php echo esc_html( $counts['GRADE_C'] ?? 0 ); ?> <span class="text-xs font-bold text-gray-600">máy</span></div>
					<p class="text-xs text-gray-600 mt-1 line-clamp-2">Cấn góc, xước nhiều, ám nhẹ, pin &lt; 80%.</p>
				</div>
				<div class="mt-3 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded text-center">Thu mua 70% - 75% giá Grade A</div>
			</div>

			<!-- GRADE D -->
			<div class="bg-white rounded-2xl border border-red-300 p-4 sm:p-5 shadow-xs flex flex-col justify-between">
				<div>
					<div class="flex items-center justify-between gap-1 mb-2">
						<span class="px-2.5 py-1 rounded-md bg-red-50 text-red-800 border border-red-200 text-[11px] font-black uppercase">Grade D</span>
						<span class="text-[11px] font-bold text-red-700">Lỗi / Linh kiện</span>
					</div>
					<div class="text-2xl sm:text-3xl font-black text-red-900"><?php echo esc_html( $counts['GRADE_D'] ?? 0 ); ?> <span class="text-xs font-bold text-gray-600">máy</span></div>
					<p class="text-xs text-gray-600 mt-1 line-clamp-2">Sọc màn, đốm mực, mất FaceID, dính iCloud.</p>
				</div>
				<div class="mt-3 text-[11px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded text-center">Thu mua theo giá linh kiện</div>
			</div>
		</div>
	</section>

	<!-- 4. FILTER TABS & SEARCH -->
	<section class="max-w-[1440px] mx-auto px-4 mt-8">
		<div class="bg-white rounded-2xl border border-gray-200/90 p-4 sm:p-5 mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
			<!-- Grade Filter Tabs -->
			<div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 no-scrollbar">
				<button type="button" class="ct-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#FF001F] text-white shadow-xs shrink-0 flex items-center gap-1.5" data-grade="all">
					<span>Tất cả</span>
					<span class="px-1.5 py-0.2 rounded-full bg-white/20 text-[11px] font-black"><?php echo count( $phones ); ?></span>
				</button>
				<button type="button" class="ct-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-grade="GRADE_A">
					<span>Grade A</span>
					<span class="px-1.5 py-0.2 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-black"><?php echo esc_html( $counts['GRADE_A'] ?? 0 ); ?></span>
				</button>
				<button type="button" class="ct-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-grade="GRADE_B">
					<span>Grade B</span>
					<span class="px-1.5 py-0.2 rounded-full bg-blue-100 text-blue-800 text-[11px] font-black"><?php echo esc_html( $counts['GRADE_B'] ?? 0 ); ?></span>
				</button>
				<button type="button" class="ct-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-grade="GRADE_C">
					<span>Grade C</span>
					<span class="px-1.5 py-0.2 rounded-full bg-amber-100 text-amber-800 text-[11px] font-black"><?php echo esc_html( $counts['GRADE_C'] ?? 0 ); ?></span>
				</button>
				<button type="button" class="ct-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shrink-0 flex items-center gap-1.5" data-grade="GRADE_D">
					<span>Grade D</span>
					<span class="px-1.5 py-0.2 rounded-full bg-red-100 text-red-800 text-[11px] font-black"><?php echo esc_html( $counts['GRADE_D'] ?? 0 ); ?></span>
				</button>
			</div>

			<!-- Brand Filter & Text Search -->
			<div class="flex items-center gap-3 flex-wrap">
				<select id="ctBrandSelect" class="px-3 py-2 rounded-xl border border-gray-200 text-xs sm:text-sm font-bold text-gray-700 bg-white focus:outline-none focus:border-[#FF001F]">
					<option value="all">Tất cả thương hiệu</option>
					<?php foreach ( $brands as $b ) : ?>
						<option value="<?php echo esc_attr( strtolower( $b ) ); ?>"><?php echo esc_html( $b ); ?></option>
					<?php endforeach; ?>
				</select>

				<div class="relative grow sm:grow-0">
					<input 
						type="text" 
						id="ctSearchBox" 
						placeholder="Tìm tên máy, dòng máy..." 
						class="w-full sm:w-64 pl-9 pr-3 py-2 rounded-xl border border-gray-200 text-xs sm:text-sm bg-white focus:outline-none focus:border-[#FF001F]"
					/>
					<span class="material-symbols-outlined text-[18px] text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
				</div>
			</div>
		</div>

		<!-- 5. PRODUCTS CARDS GRID -->
		<div id="ctProductsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
			<?php if ( ! empty( $phones ) ) : ?>
				<?php foreach ( $phones as $p ) : 
					$factors = $p['grade_factors'] ?? array();
					$grade_class = $p['grade'];
					$brand_lower = strtolower( $p['brand'] ?? '' );
				?>
					<div 
						class="ct-card bg-white rounded-2xl border border-gray-200/90 p-4 sm:p-5 flex flex-col justify-between hover:border-[#FF001F] hover:shadow-lg transition-all relative"
						data-grade="<?php echo esc_attr( $grade_class ); ?>"
						data-brand="<?php echo esc_attr( $brand_lower ); ?>"
						data-title="<?php echo esc_attr( strtolower( $p['title'] . ' ' . $p['model'] . ' ' . $p['description'] ) ); ?>"
					>
						<div>
							<!-- Header Row: Brand & Grade Badge -->
							<div class="flex items-center justify-between gap-2 mb-3">
								<span class="text-[11px] font-bold uppercase tracking-wider text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md truncate max-w-[140px]">
									<?php echo esc_html( $p['brand'] ); ?>
								</span>
								<span class="text-[11px] font-black px-2.5 py-0.5 rounded-md border shrink-0" style="background-color: <?php echo esc_attr( $p['grade_bg'] ); ?>; color: <?php echo esc_attr( $p['grade_color'] ); ?>; border-color: <?php echo esc_attr( $p['grade_border'] ); ?>;">
									<?php echo esc_html( $p['grade_short'] ); ?> (<?php echo esc_html( $p['grade_percent'] ); ?>)
								</span>
							</div>

							<!-- Image & Title -->
							<div class="flex gap-3.5 mb-3">
								<div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-gray-50 border border-gray-100 shrink-0 overflow-hidden flex items-center justify-center p-1">
									<?php if ( ! empty( $p['image'] ) ) : ?>
										<img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['title'] ); ?>" class="w-full h-full object-cover rounded-lg" loading="lazy" />
									<?php else : ?>
										<span class="material-symbols-outlined text-[32px] text-gray-300">smartphone</span>
									<?php endif; ?>
								</div>
								<div class="grow">
									<h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 mb-1 hover:text-[#FF001F] transition-colors">
										<a href="<?php echo esc_url( $p['chotot_url'] ); ?>" target="_blank" rel="noopener noreferrer">
											<?php echo esc_html( $p['title'] ); ?>
										</a>
									</h3>
									<div class="text-xs text-gray-600 line-clamp-1 mb-1">
										Dòng máy: <strong class="text-gray-900"><?php echo esc_html( $p['model'] ); ?></strong>
									</div>
									<div class="text-xs text-gray-500 line-clamp-1 flex items-center gap-1">
										<span class="material-symbols-outlined text-[13px]">location_on</span>
										<span><?php echo esc_html( $p['location'] ); ?></span>
									</div>
								</div>
							</div>

							<!-- Price Box -->
							<div class="bg-gray-50 rounded-xl p-3 mb-3 border border-gray-100 flex items-center justify-between">
								<div>
									<div class="text-[10px] font-bold text-gray-600 uppercase tracking-wider">Giá rao bán Chợ Tốt</div>
									<div class="text-base sm:text-lg font-black text-[#FF001F] leading-tight">
										<?php echo esc_html( $p['price_formatted'] ); ?>
									</div>
								</div>
								<div class="text-right">
									<div class="text-[10px] font-bold text-gray-600 uppercase tracking-wider">Khai báo</div>
									<div class="text-xs font-bold text-gray-800">
										<?php echo esc_html( $p['condition_declared'] ); ?>
									</div>
								</div>
							</div>

							<!-- 4-point Criteria Matrix -->
							<div class="bg-white rounded-xl border border-gray-100 p-2.5 mb-3 text-[11px] grid grid-cols-2 gap-1.5">
								<div>
									<span class="text-gray-600">Vỏ máy:</span>
									<strong class="text-gray-900 block truncate"><?php echo esc_html( $factors['body']['status'] ?? 'Bình thường' ); ?></strong>
								</div>
								<div>
									<span class="text-gray-600">Màn hình:</span>
									<strong class="text-gray-900 block truncate"><?php echo esc_html( $factors['screen']['status'] ?? 'Zin đẹp' ); ?></strong>
								</div>
								<div>
									<span class="text-gray-600">Pin:</span>
									<strong class="text-gray-900 block truncate"><?php echo esc_html( $factors['battery']['status'] ?? 'Tốt' ); ?></strong>
								</div>
								<div>
									<span class="text-gray-600">Phần cứng:</span>
									<strong class="text-gray-900 block truncate"><?php echo esc_html( $factors['hardware']['status'] ?? 'Nguyên bản' ); ?></strong>
								</div>
							</div>

							<!-- Rationale -->
							<div class="text-xs text-gray-600 bg-red-50/50 border border-red-100 rounded-lg p-2.5 mb-3">
								<strong class="text-[#b7000c]">Căn cứ xác định Grade:</strong><br>
								<span><?php echo esc_html( $p['grade_rationale'] ); ?></span>
							</div>
						</div>

						<!-- Action Row -->
						<div class="pt-2 border-t border-gray-100 flex items-center justify-between gap-2">
							<a href="<?php echo esc_url( $p['chotot_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-gray-600 hover:text-[#FF001F] flex items-center gap-1">
								<span>Xem tin Chợ Tốt</span>
								<span class="material-symbols-outlined text-[14px]">open_in_new</span>
							</a>
							<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-3 py-1.5 rounded-lg bg-[#FF001F] hover:bg-[#D9001B] text-white text-xs font-bold transition-colors">
								Định giá bán ngay
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const cards = document.querySelectorAll('.ct-card');
	const tabs = document.querySelectorAll('.ct-tab-btn');
	const brandSelect = document.getElementById('ctBrandSelect');
	const searchBox = document.getElementById('ctSearchBox');

	let currentGrade = 'all';
	let currentBrand = 'all';
	let currentSearch = '';

	function filterCards() {
		cards.forEach(function(card) {
			const cGrade = card.dataset.grade;
			const cBrand = card.dataset.brand;
			const cTitle = card.dataset.title || '';

			const matchGrade = (currentGrade === 'all' || cGrade === currentGrade);
			const matchBrand = (currentBrand === 'all' || cBrand === currentBrand);
			const matchSearch = (!currentSearch || cTitle.includes(currentSearch));

			if (matchGrade && matchBrand && matchSearch) {
				card.style.display = '';
			} else {
				card.style.display = 'none';
			}
		});
	}

	tabs.forEach(function(tab) {
		tab.addEventListener('click', function() {
			tabs.forEach(function(t) {
				t.classList.remove('active', 'bg-[#FF001F]', 'text-white');
				t.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
			});
			this.classList.add('active', 'bg-[#FF001F]', 'text-white');
			this.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
			currentGrade = this.dataset.grade;
			filterCards();
		});
	});

	if (brandSelect) {
		brandSelect.addEventListener('change', function() {
			currentBrand = this.value;
			filterCards();
		});
	}

	if (searchBox) {
		searchBox.addEventListener('input', function() {
			currentSearch = this.value.toLowerCase().trim();
			filterCards();
		});
	}
});
</script>

<?php
get_footer();
