<?php
/**
 * Template Name: PhoneX Buyback Brand Page
 *
 * Route: /thu-mua-dien-thoai/{brand}/
 * Description: Trang thu mua theo thương hiệu cụ thể (Apple, Samsung, Xiaomi, OPPO...)
 *
 * @package PhoneX
 */

get_header();

global $phonex_buyback_current_brand, $wpdb;

// Fallback if brand object not set
if ( empty( $phonex_buyback_current_brand ) ) {
	$b_slug = sanitize_title( get_query_var( 'brand_slug', '' ) );
	if ( empty( $b_slug ) ) {
		$path = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
		$parts = explode( '/', trim( $path, '/' ) );
		$b_slug = end( $parts );
	}
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$phonex_buyback_current_brand = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_brands WHERE slug = %s AND is_active = 1", $b_slug ) );
}

$brand = $phonex_buyback_current_brand;
if ( ! $brand ) {
	echo '<div class="p-12 text-center text-gray-700">Thương hiệu không tồn tại hoặc đã ngừng thu mua. <a href="' . esc_url( home_url( '/thu-mua-dien-thoai/' ) ) . '" class="text-[#e60012] font-bold">Xem tất cả thương hiệu</a></div>';
	get_footer();
	exit;
}

$t_series = $wpdb->prefix . 'phonex_buyback_series';
$t_models = $wpdb->prefix . 'phonex_buyback_models';

// Fetch series of this brand
$series_list = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $t_series WHERE brand_id = %d AND is_active = 1 ORDER BY sort_order ASC, name ASC", $brand->id ) );

// Fetch all models of this brand
$models = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT m.*, s.name as series_name, s.slug as series_slug 
		 FROM $t_models m 
		 LEFT JOIN $t_series s ON m.series_id = s.id 
		 WHERE m.brand_id = %d AND m.is_active = 1 
		 ORDER BY m.sort_order ASC, m.base_buyback_price DESC",
		$brand->id
	)
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
			<a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' ) ); ?>" class="hover:text-[#e60012] transition-colors">
				Thu Mua Điện Thoại
			</a>
			<span class="text-gray-300">/</span>
			<span class="text-gray-900 font-semibold"><?php echo esc_html( $brand->name ); ?></span>
		</div>
	</nav>

	<!-- 2. BRAND HERO HEADER -->
	<section class="bg-white border-b border-gray-200/80 py-8 px-4">
		<div class="max-w-[1440px] mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
			<div class="flex items-center gap-4">
				<div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white border border-gray-200 p-3 flex items-center justify-center shrink-0 shadow-sm">
					<?php echo phonex_get_brand_logo_img( $brand, 'max-w-full max-h-full object-contain' ); ?>
				</div>
				<div>
					<div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-50 text-[#e60012] text-xs font-bold uppercase tracking-wider mb-1">
						<span>Bảng giá thu mua chính hãng</span>
					</div>
					<h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
						Thu Mua Điện Thoại <?php echo esc_html( $brand->name ); ?> Cũ Giá Cao Nhất
					</h1>
					<p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
						Cam kết kiểm định chuẩn Grade A/B/C/D, thu đúng giá trị thực của máy, giải ngân sau 5 phút qua chuyển khoản hoặc tiền mặt.
					</p>
				</div>
			</div>

			<!-- Quick Actions -->
			<div class="flex items-center gap-3 shrink-0">
				<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-5 py-3 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 shadow-sm transition-colors">
					<span class="material-symbols-outlined text-[18px]">calculate</span>
					<span>Định giá trực tuyến</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="px-4 py-3 rounded-xl border border-gray-200 hover:border-gray-300 text-gray-700 font-bold text-xs sm:text-sm flex items-center gap-1.5 transition-colors bg-white">
					<span class="material-symbols-outlined text-[18px]">track_changes</span>
					<span>Tra cứu đơn</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 3. SERIES QUICK FILTER TABS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-6">
		<div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none" id="brandSeriesFilter">
			<button type="button" class="series-filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-gray-900 text-white shadow-2xs shrink-0" data-series-id="all">
				Tất cả dòng máy (<?php echo esc_html( count( $models ) ); ?>)
			</button>
			<?php if ( ! empty( $series_list ) ) : ?>
				<?php foreach ( $series_list as $s ) : ?>
					<button type="button" class="series-filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white border border-gray-200 text-gray-700 hover:border-[#e60012] hover:text-[#e60012] shrink-0" data-series-id="<?php echo esc_attr( $s->id ); ?>">
						<?php echo esc_html( $s->name ); ?>
					</button>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<!-- 4. MODELS GRID -->
	<section class="max-w-[1440px] mx-auto px-4 mt-6">
		<div id="brandModelsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
			<?php if ( ! empty( $models ) ) : ?>
				<?php foreach ( $models as $m ) : 
					$model_url = home_url( '/thu-mua-dien-thoai/' . $brand->slug . '/' . $m->slug . '/' );
					$img_url   = ! empty( $m->image_url ) ? $m->image_url : get_template_directory_uri() . '/assets/images/phones/generic-phone.png';
					$price_max = number_format( (float) $m->base_buyback_price, 0, ',', '.' ) . '₫';
					$storages  = json_decode( $m->storage_options ?? '[]', true );
				?>
					<div class="buyback-model-card bg-white rounded-2xl border border-gray-200/90 p-4 sm:p-5 flex flex-col justify-between hover:border-[#e60012] hover:shadow-lg transition-all group" data-series-id="<?php echo esc_attr( $m->series_id ); ?>">
						<div>
							<!-- Grade Badge -->
							<div class="flex items-center justify-between gap-2 mb-3">
								<span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">
									<img src="<?php echo esc_url( phonex_get_brand_logo_url( $brand ) ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" class="w-3.5 h-3.5 object-contain" />
									<span><?php echo esc_html( $m->series_name ?: $brand->name ); ?></span>
								</span>
								<span class="text-[11px] font-black text-[#198754] bg-green-50 px-2 py-0.5 rounded-md border border-green-200">
									Grade A (99%)
								</span>
							</div>

							<!-- Image -->
							<a href="<?php echo esc_url( $model_url ); ?>" class="block py-4 text-center">
								<img 
									src="<?php echo esc_url( $img_url ); ?>" 
									alt="<?php echo esc_attr( $m->name ); ?>" 
									class="h-36 sm:h-40 mx-auto object-contain group-hover:scale-105 transition-transform duration-300"
									loading="lazy"
								/>
							</a>

							<!-- Model Name -->
							<h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 group-hover:text-[#e60012] transition-colors mb-2">
								<a href="<?php echo esc_url( $model_url ); ?>">
									<?php echo esc_html( $m->name ); ?>
								</a>
							</h3>

							<!-- Storage Pills -->
							<?php if ( ! empty( $storages ) && is_array( $storages ) ) : ?>
								<div class="flex flex-wrap gap-1 mb-3">
									<?php foreach ( $storages as $st ) : ?>
										<span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
											<?php echo esc_html( $st ); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<!-- Price Display -->
							<div class="bg-red-50/60 rounded-xl p-3 mb-4 border border-red-100">
								<div class="text-[11px] text-gray-500 font-semibold mb-0.5">Giá thu tối đa:</div>
								<div class="text-lg sm:text-xl font-black text-[#e60012] leading-none">
									<?php echo esc_html( $price_max ); ?>
								</div>
								<div class="text-[10px] text-gray-400 font-medium mt-1">Đã áp dụng định giá Grade A</div>
							</div>
						</div>

						<!-- Action CTA -->
						<div class="grid grid-cols-2 gap-2">
							<a href="<?php echo esc_url( $model_url ); ?>" class="h-10 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs flex items-center justify-center gap-1 transition-colors shadow-2xs">
								<span class="material-symbols-outlined text-[15px]">calculate</span>
								<span>Định giá</span>
							</a>
							<a href="<?php echo esc_url( $model_url . '#request-form' ); ?>" class="h-10 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs flex items-center justify-center gap-1 transition-colors shadow-2xs">
								<span>Bán ngay</span>
								<span class="material-symbols-outlined text-[15px]">arrow_forward</span>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="col-span-full p-12 text-center bg-white rounded-2xl border border-gray-200">
					<span class="material-symbols-outlined text-gray-400 text-[48px] mb-2">search_off</span>
					<p class="text-gray-500 text-sm">Hiện chưa có sản phẩm nào thuộc thương hiệu này trong hệ thống thu mua.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- 5. REFERENCE BUYBACK PRICE TABLE -->
	<?php if ( ! empty( $models ) ) : ?>
		<section class="max-w-[1440px] mx-auto px-4 mt-14">
			<div class="bg-white rounded-2xl border border-gray-200/90 overflow-hidden shadow-2xs">
				<div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
					<div>
						<h2 class="text-lg sm:text-xl font-black text-gray-900">
							Bảng Giá Thu Mua Tham Khảo <?php echo esc_html( $brand->name ); ?> (Theo Grade)
						</h2>
						<p class="text-xs text-gray-500 mt-0.5">Bảng giá cập nhật theo ngày. Giá thực tế phụ thuộc kết quả kiểm định ngoại hình và pin.</p>
					</div>
					<a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="text-xs font-bold text-[#e60012] inline-flex items-center gap-1 hover:underline">
						<span>Xem tiêu chuẩn Grade A/B/C/D</span>
						<span class="material-symbols-outlined text-[14px]">arrow_forward</span>
					</a>
				</div>

				<div class="overflow-x-auto">
					<table class="w-full text-left text-xs sm:text-sm">
						<thead class="bg-gray-50 text-gray-700 font-bold border-b border-gray-200">
							<tr>
								<th class="py-3.5 px-4">Tên Model</th>
								<th class="py-3.5 px-4">Dung lượng</th>
								<th class="py-3.5 px-4 text-[#198754]">Grade A (99%)</th>
								<th class="py-3.5 px-4 text-blue-600">Grade B (95%)</th>
								<th class="py-3.5 px-4 text-amber-600">Grade C (90%)</th>
								<th class="py-3.5 px-4 text-center">Thao tác</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-100">
							<?php foreach ( $models as $m ) : 
								$base = (float) $m->base_buyback_price;
								$p_a = number_format( $base, 0, ',', '.' ) . '₫';
								$p_b = number_format( $base * 0.88, 0, ',', '.' ) . '₫';
								$p_c = number_format( $base * 0.72, 0, ',', '.' ) . '₫';
								$m_url = home_url( '/thu-mua-dien-thoai/' . $brand->slug . '/' . $m->slug . '/' );
								$storages = json_decode( $m->storage_options ?? '[]', true );
								$storage_str = ! empty( $storages ) ? implode( ', ', $storages ) : 'Tiêu chuẩn';
							?>
								<tr class="hover:bg-red-50/30 transition-colors">
									<td class="py-3.5 px-4 font-bold text-gray-900">
										<a href="<?php echo esc_url( $m_url ); ?>" class="hover:text-[#e60012]">
											<?php echo esc_html( $m->name ); ?>
										</a>
									</td>
									<td class="py-3.5 px-4 text-gray-600"><?php echo esc_html( $storage_str ); ?></td>
									<td class="py-3.5 px-4 font-bold text-[#198754]"><?php echo esc_html( $p_a ); ?></td>
									<td class="py-3.5 px-4 font-semibold text-blue-600"><?php echo esc_html( $p_b ); ?></td>
									<td class="py-3.5 px-4 font-semibold text-amber-600"><?php echo esc_html( $p_c ); ?></td>
									<td class="py-3.5 px-4 text-center">
										<a href="<?php echo esc_url( $m_url ); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#e60012] hover:bg-[#b7000c] text-white text-xs font-bold transition-colors">
											<span>Định giá</span>
											<span class="material-symbols-outlined text-[13px]">arrow_forward</span>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 6. BRAND SEO CONTENT BLOCK -->
	<?php if ( ! empty( $brand->description ) || ! empty( $brand->seo_content ) ) : ?>
		<section class="max-w-[1440px] mx-auto px-4 mt-14">
			<div class="bg-white rounded-2xl border border-gray-200/90 p-6 sm:p-8 prose max-w-none text-xs sm:text-sm text-gray-600 leading-relaxed">
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 not-prose mb-4">
					Dịch Vụ Thu Mua Điện Thoại <?php echo esc_html( $brand->name ); ?> Uy Tín Hàng Đầu
				</h2>
				<?php 
				if ( ! empty( $brand->seo_content ) ) {
					echo wp_kses_post( $brand->seo_content );
				} elseif ( ! empty( $brand->description ) ) {
					echo '<p>' . esc_html( $brand->description ) . '</p>';
				}
				?>
			</div>
		</section>
	<?php endif; ?>

</main>

<!-- Series Filter Interactivity -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterBtns = document.querySelectorAll('.series-filter-btn');
	var modelCards = document.querySelectorAll('.buyback-model-card');

	filterBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var seriesId = this.getAttribute('data-series-id');

			// Update active styling
			filterBtns.forEach(function(b) {
				b.className = 'series-filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-white border border-gray-200 text-gray-700 hover:border-[#e60012] hover:text-[#e60012] shrink-0';
			});
			this.className = 'series-filter-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-gray-900 text-white shadow-2xs shrink-0';

			// Filter cards
			modelCards.forEach(function(card) {
				var cardSeries = card.getAttribute('data-series-id');
				if (seriesId === 'all' || cardSeries === seriesId) {
					card.classList.remove('hidden');
				} else {
					card.classList.add('hidden');
				}
			});
		});
	});
});
</script>

<?php
get_footer();
