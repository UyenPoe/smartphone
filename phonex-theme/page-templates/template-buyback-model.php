<?php
/**
 * Template Name: PhoneX Buyback Model Page
 *
 * Route: /thu-mua-dien-thoai/{brand}/{model}/
 * Description: Trang chi tiết thu mua & định giá một model cụ thể.
 *
 * @package PhoneX
 */

get_header();

global $phonex_buyback_current_brand, $phonex_buyback_current_model, $wpdb;

$brand = $phonex_buyback_current_brand;
$model = $phonex_buyback_current_model;

if ( ! $model || ! $brand ) {
	echo '<div class="p-12 text-center text-gray-700">Không tìm thấy model điện thoại. <a href="' . esc_url( home_url( '/thu-mua-dien-thoai/' ) ) . '" class="text-[#e60012] font-bold">Quay lại danh mục</a></div>';
	get_footer();
	exit;
}

$base_price    = (float) $model->base_buyback_price;
$storages      = json_decode( $model->storage_options ?? '[]', true );
$colors        = json_decode( $model->color_options ?? '[]', true );
$default_img   = ! empty( $model->image_url ) ? $model->image_url : get_template_directory_uri() . '/assets/images/phones/generic-phone.png';

// Grade pricing references
$p_grade_a = $base_price;
$p_grade_b = round( $base_price * 0.88 / 10000 ) * 10000;
$p_grade_c = round( $base_price * 0.72 / 10000 ) * 10000;
$p_grade_d = round( $base_price * 0.45 / 10000 ) * 10000;

// Enrich Technical Specifications
$spec_groups = ! empty( $model->spec_groups ) ? $model->spec_groups : array();
if ( empty( $spec_groups ) && function_exists( 'phonex_buyback_find_catalog_phone_by_slug' ) ) {
	$matched_specs = phonex_buyback_find_catalog_phone_by_slug( $model->slug, $brand->slug );
	if ( $matched_specs && ! empty( $matched_specs['item']['spec_groups'] ) ) {
		$spec_groups = $matched_specs['item']['spec_groups'];
	}
}

// Structured Data (Schema.org) JSON-LD for Google Rich Results
$model_canonical_url = home_url( '/thu-mua-dien-thoai/' . $brand->slug . '/' . $model->slug . '/' );
$schema_data = array(
	'@context' => 'https://schema.org',
	'@graph'   => array(
		array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Trang chủ',
					'item'     => home_url( '/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => 'Bảng Giá Thu Mua',
					'item'     => home_url( '/bang-gia-thu-mua/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 3,
					'name'     => $brand->name,
					'item'     => home_url( '/thu-mua-dien-thoai/' . $brand->slug . '/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 4,
					'name'     => 'Thu mua ' . $model->name . ' cũ',
					'item'     => $model_canonical_url,
				),
			),
		),
		array(
			'@type'       => 'Product',
			'name'        => 'Thu mua ' . $model->name . ' cũ giá cao',
			'image'       => ! empty( $default_img ) ? esc_url( $default_img ) : '',
			'description' => sprintf( 'Dịch vụ thu mua %s cũ giá cao nhất thị trường tại PhoneX. Báo giá công khai theo 5 cấp độ tình trạng, kiểm tra 30 bước, thanh toán trong 5 phút.', $model->name ),
			'brand'       => array(
				'@type' => 'Brand',
				'name'  => $brand->name,
			),
			'offers'      => array(
				'@type'           => 'Offer',
				'price'           => (int) $base_price,
				'priceCurrency'   => 'VND',
				'priceValidUntil' => gmdate( 'Y-12-31' ),
				'itemCondition'   => 'https://schema.org/UsedCondition',
				'availability'    => 'https://schema.org/InStock',
				'url'             => $model_canonical_url,
				'seller'          => array(
					'@type' => 'Organization',
					'name'  => 'PhoneX Smartphone Store',
					'url'   => home_url( '/' ),
				),
			),
		),
		array(
			'@type'      => 'FAQPage',
			'mainEntity' => array(
				array(
					'@type'          => 'Question',
					'name'           => sprintf( 'Giá thu mua %s cũ tại PhoneX được tính như thế nào?', $model->name ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => sprintf( 'PhoneX áp dụng bảng giá barem công khai chia thành 5 cấp độ tình trạng (Loại 1 đến Loại 5). Mức giá cao nhất lên đến %s cho máy đẹp như mới 99%% đầy đủ phụ kiện. Kỹ thuật viên kiểm tra 30 bước công khai trước mặt khách, cam kết không ép giá.', number_format( $base_price, 0, ',', '.' ) . '₫' ),
					),
				),
				array(
					'@type'          => 'Question',
					'name'           => sprintf( '%s bị vỡ màn hình, trầy xước nặng PhoneX có thu không?', $model->name ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => sprintf( 'PhoneX vẫn nhận thu mua %s trong mọi tình trạng như cấn móp, trầy xước hoặc hư hỏng màn hình (xếp vào Loại 4 hoặc Loại 5) miễn là máy vẫn còn nguồn và kiểm tra được linh kiện.', $model->name ),
					),
				),
				array(
					'@type'          => 'Question',
					'name'           => sprintf( 'Bán %s cũ cho PhoneX thì bao lâu nhận được tiền?', $model->name ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => 'Ngay sau khi kỹ thuật viên kiểm định xong và khách hàng đồng ý với mức giá báo, PhoneX sẽ tiến hành chuyển khoản nhanh 24/7 tới mọi ngân hàng hoặc thanh toán tiền mặt trực tiếp trong vòng 5 phút.',
					),
				),
				array(
					'@type'          => 'Question',
					'name'           => 'Dữ liệu cá nhân và tài khoản trên máy có được bảo mật không?',
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => 'Kỹ thuật viên PhoneX sẽ hướng dẫn và hỗ trợ khách hàng đăng xuất toàn bộ tài khoản iCloud / Google, sao lưu dữ liệu sang máy mới và thực hiện khôi phục cài đặt gốc xóa trắng dữ liệu theo tiêu chuẩn quốc tế.',
					),
				),
				array(
					'@type'          => 'Question',
					'name'           => sprintf( 'Đổi %s cũ lên đời máy khác tại PhoneX có được trợ giá không?', $model->name ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => sprintf( 'Có! Khi tham gia chương trình Thu Cũ Đổi Mới (Trade-in), khách hàng bán %s sẽ được trợ giá thêm từ 500.000₫ đến 3.000.000₫ trực tiếp vào giá máy mới hoặc máy cũ tại Kho Máy Cũ PhoneX.', $model->name ),
					),
				),
			),
		),
	),
);
?>

<!-- Schema.org JSON-LD Structured Data for Google Rich Results -->
<script type="application/ld+json">
<?php echo wp_json_encode( $schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
</script>

<main id="primary" class="site-main bg-background min-h-screen font-sans pb-16">

	<!-- 1. BREADCRUMBS -->
	<nav class="bg-white border-b border-gray-100 py-3" aria-label="Breadcrumb">
		<div class="max-w-[1440px] mx-auto px-4 flex items-center gap-2 text-xs md:text-sm text-gray-500 overflow-x-auto whitespace-nowrap">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#e60012] flex items-center gap-1 transition-colors">
				<span class="material-symbols-outlined text-[16px]">home</span>
				<span>Trang chủ</span>
			</a>
			<span class="text-gray-300">/</span>
			<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="hover:text-[#e60012] transition-colors">
				Bảng Giá Thu Mua
			</a>
			<span class="text-gray-300">/</span>
			<a href="<?php echo esc_url( home_url( '/thu-mua-dien-thoai/' . $brand->slug . '/' ) ); ?>" class="hover:text-[#e60012] transition-colors inline-flex items-center gap-1 font-semibold">
				<?php if ( function_exists( 'phonex_get_brand_logo_img' ) ) : ?>
					<?php echo phonex_get_brand_logo_img( $brand, 'w-3.5 h-3.5 object-contain inline-block' ); ?>
				<?php endif; ?>
				<span><?php echo esc_html( $brand->name ); ?></span>
			</a>
			<span class="text-gray-300">/</span>
			<span class="text-gray-900 font-semibold"><?php echo esc_html( $model->name ); ?></span>
		</div>
	</nav>

	<!-- 2. MODEL OVERVIEW & QUICK ESTIMATOR SECTION -->
	<section class="max-w-[1440px] mx-auto px-4 mt-6">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

			<!-- LEFT COL: PRODUCT MEDIA & GRADE PRICE TABLE (5 cols) -->
			<div class="lg:col-span-5 space-y-4">
				<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 text-center shadow-2xs">
					<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-50 text-slate-800 text-xs font-bold uppercase mb-4 border border-slate-200/80">
						<img src="<?php echo esc_url( phonex_get_brand_logo_url( $brand ) ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" class="w-4 h-4 object-contain" />
						<span><?php echo esc_html( $brand->name ); ?></span>
						<span class="text-slate-300">•</span>
						<span class="text-[#e60012] font-black">Giá Thu Tối Đa</span>
					</div>

					<div class="py-4">
						<img 
							src="<?php echo esc_url( $default_img ); ?>" 
							alt="<?php echo esc_attr( $model->name ); ?>" 
							class="h-64 sm:h-72 mx-auto object-contain transition-transform hover:scale-105 duration-300"
							id="modelMainImage"
						/>
					</div>

					<h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-2">
						Thu Mua <?php echo esc_html( $model->name ); ?> Cũ
					</h1>
					<p class="text-xs text-gray-500 mt-1">Định giá công khai • Không ép giá • Chuyển khoản trong 5 phút</p>
				</div>

				<!-- Grade Reference Price Card -->
				<div class="bg-white rounded-3xl border border-gray-200/90 p-5 shadow-2xs">
					<div class="flex items-center justify-between mb-3">
						<h2 class="text-sm font-bold text-gray-900 flex items-center gap-1.5">
							<span class="material-symbols-outlined text-[#e60012] text-[18px]">table_chart</span>
							<span>Bảng Giá Thu Mua Theo Grade</span>
						</h2>
						<a href="<?php echo esc_url( home_url( '/tieu-chuan-kiem-dinh/' ) ); ?>" class="text-[11px] font-bold text-[#e60012] hover:underline">
							Tiêu chuẩn &rarr;
						</a>
					</div>

					<div class="space-y-2 text-xs">
						<div class="flex items-center justify-between p-2.5 rounded-xl bg-green-50 border border-green-200/70">
							<div class="flex items-center gap-2">
								<span class="px-2 py-0.5 rounded-md bg-[#198754] text-white font-black text-[10px]">GRADE A</span>
								<span class="font-bold text-gray-800">Like New 99%</span>
							</div>
							<span class="font-black text-[#198754] text-sm" id="gradePriceA">
								<?php echo esc_html( number_format( $p_grade_a, 0, ',', '.' ) ); ?>₫
							</span>
						</div>

						<div class="flex items-center justify-between p-2.5 rounded-xl bg-blue-50/70 border border-blue-200/70">
							<div class="flex items-center gap-2">
								<span class="px-2 py-0.5 rounded-md bg-blue-600 text-white font-black text-[10px]">GRADE B</span>
								<span class="font-bold text-gray-800">Very Good 95%</span>
							</div>
							<span class="font-black text-blue-700 text-sm" id="gradePriceB">
								<?php echo esc_html( number_format( $p_grade_b, 0, ',', '.' ) ); ?>₫
							</span>
						</div>

						<div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/70">
							<div class="flex items-center gap-2">
								<span class="px-2 py-0.5 rounded-md bg-amber-600 text-white font-black text-[10px]">GRADE C</span>
								<span class="font-bold text-gray-800">Good 90%</span>
							</div>
							<span class="font-black text-amber-700 text-sm" id="gradePriceC">
								<?php echo esc_html( number_format( $p_grade_c, 0, ',', '.' ) ); ?>₫
							</span>
						</div>

						<div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-200">
							<div class="flex items-center gap-2">
								<span class="px-2 py-0.5 rounded-md bg-gray-600 text-white font-black text-[10px]">GRADE D</span>
								<span class="font-bold text-gray-800">Linh kiện / Lỗi</span>
							</div>
							<span class="font-black text-gray-700 text-sm" id="gradePriceD">
								<?php echo esc_html( number_format( $p_grade_d, 0, ',', '.' ) ); ?>₫
							</span>
						</div>
					</div>
				</div>

				<!-- PhoneX Inspection Commitments -->
				<div class="rounded-3xl p-5 shadow-2xs border border-[#ffb4aa] text-[#1F1F1F]" style="background-color: var(--px-primary-fixed, #FFF0F2);">
					<div class="text-xs font-bold text-[#b7000c] uppercase tracking-wider mb-2">Cam kết dịch vụ</div>
					<h3 class="text-sm font-bold text-[#1F1F1F] mb-3">An Tâm Tuyệt Đối Khi Bán Máy</h3>
					<ul class="text-xs text-gray-800 space-y-2 font-medium">
						<li class="flex items-center gap-2">
							<span class="material-symbols-outlined text-[#00875A] text-[16px]">check_circle</span>
							<span>Kiểm định công khai 30 bước trước mặt khách</span>
						</li>
						<li class="flex items-center gap-2">
							<span class="material-symbols-outlined text-[#00875A] text-[16px]">check_circle</span>
							<span>Tuyệt đối không tráo đổi hoặc mở máy khi chưa đồng ý</span>
						</li>
						<li class="flex items-center gap-2">
							<span class="material-symbols-outlined text-[#00875A] text-[16px]">check_circle</span>
							<span>Hỗ trợ xóa sạch dữ liệu iCloud / Google theo chuẩn quốc tế</span>
						</li>
						<li class="flex items-center gap-2">
							<span class="material-symbols-outlined text-[#00875A] text-[16px]">check_circle</span>
							<span>Chuyển khoản 24/7 mọi ngân hàng trong 5 phút</span>
						</li>
					</ul>
				</div>
			</div>

			<!-- RIGHT COL: INTERACTIVE VALUATION WIZARD & REQUEST FORM (7 cols) -->
			<div class="lg:col-span-7" id="request-form">
				<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 shadow-sm">
					<div class="border-b border-gray-100 pb-4 mb-6">
						<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-[#b7000c] text-xs font-bold uppercase mb-2">
							<span class="material-symbols-outlined text-[15px]">tune</span>
							<span>Công Cụ Định Giá Nhanh 30 Giây</span>
						</div>
						<h2 class="text-xl sm:text-2xl font-black text-gray-900">
							Tự Định Giá Máy Của Bạn
						</h2>
						<p class="text-xs sm:text-sm text-gray-500 mt-1">
							Chọn chính xác tình trạng thực tế để nhận mức định giá sát nhất.
						</p>
					</div>

					<form id="valuationEngineForm" onsubmit="return false;" class="space-y-6">

						<!-- STEP 1: DUNG LƯỢNG (STORAGE) -->
						<?php if ( ! empty( $storages ) && is_array( $storages ) ) : ?>
							<div>
								<label class="block text-xs sm:text-sm font-bold text-gray-900 mb-2.5">
									1. Chọn Dung Lượng Máy:
								</label>
								<div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="storageSelector">
									<?php foreach ( $storages as $idx => $st ) : ?>
										<button 
											type="button" 
											class="storage-option-btn h-12 rounded-xl border <?php echo 0 === $idx ? 'border-[#e60012] bg-red-50 text-[#e60012] font-black' : 'border-gray-200 bg-white text-gray-700 font-bold'; ?> text-xs sm:text-sm transition-all flex items-center justify-center gap-1 hover:border-[#e60012]"
											data-storage="<?php echo esc_attr( $st ); ?>"
											data-storage-idx="<?php echo esc_attr( $idx ); ?>"
										>
											<span><?php echo esc_html( $st ); ?></span>
										</button>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- STEP 2: MÀU SẮC (COLOR) -->
						<?php if ( ! empty( $colors ) && is_array( $colors ) ) : ?>
							<div>
								<label class="block text-xs sm:text-sm font-bold text-gray-900 mb-2.5">
									2. Chọn Màu Sắc Máy:
								</label>
								<div class="flex flex-wrap gap-2" id="colorSelector">
									<?php foreach ( $colors as $idx => $cl ) : ?>
										<button 
											type="button" 
											class="color-option-btn px-4 py-2 rounded-xl border <?php echo 0 === $idx ? 'border-[#e60012] bg-red-50 text-[#e60012] font-black' : 'border-gray-200 bg-white text-gray-700 font-medium'; ?> text-xs sm:text-sm transition-all hover:border-[#e60012]"
											data-color="<?php echo esc_attr( $cl ); ?>"
										>
											<?php echo esc_html( $cl ); ?>
										</button>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- STEP 3: NGOẠI HÌNH & VỎ MÁY -->
						<div>
							<label class="block text-xs sm:text-sm font-bold text-gray-900 mb-2.5">
								3. Ngoại Hình Vỏ Máy:
							</label>
							<div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5" id="bodyConditionSelector">
								<label class="condition-option relative flex items-start p-3.5 rounded-2xl border-2 border-[#e60012] bg-red-50/50 cursor-pointer transition-all">
									<input type="radio" name="body_condition" value="like_new" class="sr-only" checked />
									<span class="w-4 h-4 rounded-full border-2 border-[#e60012] flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-[#e60012]"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Đẹp như mới (99%)</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Không trầy xước hoặc xước cực nhẹ khó thấy.</div>
									</div>
								</label>

								<label class="condition-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="body_condition" value="minor_scratches" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Trầy xước nhẹ (95%)</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Có vết xước dăm nhẹ viền hoặc lưng.</div>
									</div>
								</label>

								<label class="condition-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="body_condition" value="dented" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Cấn móp / Trầy rõ (90%)</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Vết cấn góc, trầy sơn rõ ràng nhưng không vỡ.</div>
									</div>
								</label>

								<label class="condition-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="body_condition" value="cracked" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Nứt vỡ / Biến dạng</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Lưng nứt, viền móp nặng hoặc cong sườn.</div>
									</div>
								</label>
							</div>
						</div>

						<!-- STEP 4: MÀN HÌNH (SCREEN) -->
						<div>
							<label class="block text-xs sm:text-sm font-bold text-gray-900 mb-2.5">
								4. Tình Trạng Màn Hình:
							</label>
							<div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5" id="screenConditionSelector">
								<label class="screen-option relative flex items-start p-3.5 rounded-2xl border-2 border-[#e60012] bg-red-50/50 cursor-pointer transition-all">
									<input type="radio" name="screen_condition" value="perfect" class="sr-only" checked />
									<span class="w-4 h-4 rounded-full border-2 border-[#e60012] flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-[#e60012]"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Màn hình hoàn hảo</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Hiển thị trong trẻo, không trầy, không ám ố.</div>
									</div>
								</label>

								<label class="screen-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="screen_condition" value="scratched" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Màn hình trầy xước nhẹ</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Có vài vết trầy lông mèo nhưng hiển thị đẹp.</div>
									</div>
								</label>

								<label class="screen-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="screen_condition" value="burn_in" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Ám màu / Lưu ảnh nhẹ</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Màn hình bị ố vàng, ám hồng hoặc lưu ảnh.</div>
									</div>
								</label>

								<label class="screen-option relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300">
									<input type="radio" name="screen_condition" value="broken" class="sr-only" />
									<span class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0">
										<span class="w-2 h-2 rounded-full bg-transparent"></span>
									</span>
									<div>
										<div class="text-xs sm:text-sm font-bold text-gray-900">Bể kính / Sọc / Chảy mực</div>
										<div class="text-[11px] text-gray-500 mt-0.5">Vỡ kính ngoài, sọc màn hoặc liệt cảm ứng.</div>
									</div>
								</label>
							</div>
						</div>

						<!-- STEP 5: TÍNH NĂNG & PIN -->
						<div>
							<label class="block text-xs sm:text-sm font-bold text-gray-900 mb-2.5">
								5. Tính Năng &amp; Pin:
							</label>
							<div class="space-y-2 text-xs sm:text-sm">
								<label class="flex items-center gap-2.5 p-3 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer">
									<input type="checkbox" name="feature_faceid" class="rounded text-[#e60012] focus:ring-red-400 w-4 h-4" checked />
									<span class="font-bold text-gray-800">Face ID / Cảm biến vân tay hoạt động bình thường</span>
								</label>
								<label class="flex items-center gap-2.5 p-3 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer">
									<input type="checkbox" name="feature_cameras" class="rounded text-[#e60012] focus:ring-red-400 w-4 h-4" checked />
									<span class="font-bold text-gray-800">Camera trước &amp; sau chụp sắc nét, không đốm mờ</span>
								</label>
								<label class="flex items-center gap-2.5 p-3 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer">
									<input type="checkbox" name="feature_battery_good" class="rounded text-[#e60012] focus:ring-red-400 w-4 h-4" checked />
									<span class="font-bold text-gray-800">Dung lượng pin còn tốt (&gt; 80%, chưa báo bảo trì)</span>
								</label>
							</div>
						</div>

						<!-- VALUATION RESULT SUMMARY BOX -->
						<div class="rounded-2xl bg-gradient-to-br from-red-50 to-orange-50/60 border-2 border-red-200 p-5">
							<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
								<div>
									<div class="text-xs font-bold uppercase tracking-wider text-gray-500">Phân hạng ước tính:</div>
									<div class="inline-flex items-center gap-2 mt-1">
										<span class="px-2.5 py-1 rounded-lg bg-[#e60012] text-white font-black text-xs uppercase" id="estimatedGradeBadge">
											GRADE A
										</span>
										<span class="text-xs font-bold text-gray-700" id="estimatedGradeDesc">
											Like New 99%
										</span>
									</div>
								</div>
								<div class="sm:text-right">
									<div class="text-xs font-semibold text-gray-500">Giá thu ước tính:</div>
									<div class="text-2xl sm:text-3xl font-black text-[#e60012] leading-none mt-1" id="estimatedPriceVal">
										<?php echo esc_html( number_format( $p_grade_a, 0, ',', '.' ) ); ?>₫
									</div>
									<div class="text-[11px] text-gray-400 mt-1">Cam kết không ép giá khi kiểm tra đúng mô tả</div>
								</div>
							</div>
						</div>

						<!-- STEP 6: CUSTOMER CONTACT & SUBMISSION (NO LOGIN REQUIRED) -->
						<div class="border-t border-gray-100 pt-5 space-y-4">
							<h3 class="text-sm sm:text-base font-black text-gray-900">
								Thông Tin Người Bán (Nhận Tiền Nhanh)
							</h3>

							<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
								<div>
									<label class="block text-xs font-bold text-gray-700 mb-1">Họ và tên *</label>
									<input 
										type="text" 
										id="custName" 
										required 
										placeholder="Ví dụ: Nguyễn Văn A" 
										class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] focus:ring-2 focus:ring-red-100 text-xs sm:text-sm text-gray-900 outline-none"
									/>
								</div>
								<div>
									<label class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại * (Dùng để tra cứu)</label>
									<input 
										type="tel" 
										id="custPhone" 
										required 
										placeholder="Ví dụ: 0912345678" 
										class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] focus:ring-2 focus:ring-red-100 text-xs sm:text-sm text-gray-900 outline-none"
									/>
								</div>
							</div>

							<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
								<div>
									<label class="block text-xs font-bold text-gray-700 mb-1">Hình thức giao dịch</label>
									<select id="inspectionMethod" class="w-full h-11 px-3 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm text-gray-900 outline-none bg-white font-medium">
										<option value="store">Đến Showroom PhoneX gần nhất</option>
										<option value="home">Thu mua tận nhà (Hà Nội, TP.HCM, Đà Nẵng)</option>
									</select>
								</div>
								<div>
									<label class="block text-xs font-bold text-gray-700 mb-1">Địa chỉ / Khu vực của bạn</label>
									<input 
										type="text" 
										id="custAddress" 
										placeholder="Quận/Huyện hoặc Chi nhánh thuận tiện" 
										class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] focus:ring-2 focus:ring-red-100 text-xs sm:text-sm text-gray-900 outline-none"
									/>
								</div>
							</div>

							<div>
								<label class="block text-xs font-bold text-gray-700 mb-1">Ghi chú thêm về máy (tùy chọn)</label>
								<textarea 
									id="custNotes" 
									rows="2" 
									placeholder="Ví dụ: Máy còn hộp, cáp sạc zin, máy bản VN/A..." 
									class="w-full p-3 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm text-gray-900 outline-none"
								></textarea>
							</div>

							<button 
								type="button" 
								id="btnSubmitBuybackRequest"
								class="w-full h-13 rounded-2xl bg-[#e60012] hover:bg-[#b7000c] text-white font-black text-sm sm:text-base flex items-center justify-center gap-2 shadow-lg shadow-red-600/30 transition-all cursor-pointer min-h-[48px]"
							>
								<span class="material-symbols-outlined text-[20px]">send</span>
								<span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>
							</button>

							<p class="text-[11px] text-center text-gray-400">
								Nhấn "Gửi yêu cầu", bạn sẽ nhận được Mã Phiếu Tra Cứu và nhân viên kỹ thuật sẽ gọi lại trong vòng 10 phút.
							</p>
						</div>

					</form>
				</div>
			</div>

		</div>
	</section>

	<?php if ( ! empty( $spec_groups ) && is_array( $spec_groups ) ) : ?>
		<!-- 3. TECHNICAL SPECIFICATIONS SECTION (FULL 8 GROUPS) -->
		<section class="max-w-[1440px] mx-auto px-4 mt-12" id="thong-so-ky-thuat">
			<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 md:p-10 shadow-xs">
				<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-5 mb-8">
					<div>
						<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-[#b7000c] text-xs font-bold uppercase mb-2">
							<span class="material-symbols-outlined text-[15px]">memory</span>
							<span>Thông Số Kỹ Thuật Chuẩn</span>
						</div>
						<h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
							Cấu Hình &amp; Đặc Điểm Kỹ Thuật <?php echo esc_html( $model->name ); ?>
						</h2>
						<p class="text-xs sm:text-sm text-gray-500 mt-1">
							Dữ liệu phần cứng chính xác hỗ trợ thẩm định và định giá chuẩn xác 100%.
						</p>
					</div>

					<div class="flex items-center gap-2">
						<a href="#request-form" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs transition-colors shadow-2xs">
							<span class="material-symbols-outlined text-[16px]">price_check</span>
							<span>Định Giá Máy Này Ngay</span>
						</a>
					</div>
				</div>

				<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
					<?php foreach ( $spec_groups as $group_idx => $group_data ) : 
						$group_title = $group_data['group'] ?? ( 'Nhóm thông số ' . ( $group_idx + 1 ) );
						$items       = $group_data['items'] ?? array();
						if ( empty( $items ) ) continue;
					?>
						<div class="rounded-2xl border border-gray-200/90 overflow-hidden bg-white shadow-2xs">
							<div class="px-5 py-3.5 bg-gray-50/90 border-b border-gray-200/80 flex items-center justify-between">
								<h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
									<span class="w-2 h-2 rounded-full bg-[#e60012]"></span>
									<span><?php echo esc_html( $group_title ); ?></span>
								</h3>
								<span class="text-[11px] font-bold text-gray-400"><?php echo count( $items ); ?> mục</span>
							</div>

							<div class="divide-y divide-gray-100 text-xs sm:text-[13px]">
								<?php foreach ( $items as $it_idx => $attr ) : ?>
									<div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-1 <?php echo 0 === $it_idx % 2 ? 'bg-white' : 'bg-gray-50/40'; ?>">
										<span class="font-medium text-gray-600 sm:w-2/5 shrink-0">
											<?php echo esc_html( $attr['name'] ?? '' ); ?>
										</span>
										<span class="font-bold text-gray-900 sm:w-3/5 text-left sm:text-right">
											<?php echo esc_html( $attr['value'] ?? 'Đang cập nhật' ); ?>
										</span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 4. TRADE-IN CROSS-SELL BANNER (THU CŨ LÊN ĐỜI MÁY MỚI) -->
	<section class="max-w-[1440px] mx-auto px-4 mt-12">
		<div class="relative overflow-hidden rounded-3xl border border-[#ffb4aa] p-6 sm:p-8 md:p-10 text-[#1F1F1F] shadow-xs" style="background-color: var(--px-primary-fixed, #FFF0F2);">
			<!-- Ambient lighting & decorative icon -->
			<div class="absolute -right-12 -top-12 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
			<div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
			<div class="absolute right-4 top-1/2 -translate-y-1/2 hidden md:block opacity-5 pointer-events-none select-none">
				<span class="material-symbols-outlined text-[200px] text-[#FF001F]">change_circle</span>
			</div>

			<div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
				<div class="max-w-2xl text-center lg:text-left">
					<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/95 text-[#b7000c] border border-[#FF001F]/20 text-xs font-bold uppercase mb-3 shadow-2xs">
						<span class="material-symbols-outlined text-[16px] text-[#FF001F]">change_circle</span>
						<span>Trợ Giá Lên Đời Đến 3.000.000₫</span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-3xl font-black text-[#1F1F1F] tracking-tight">
						Bán <?php echo esc_html( $model->name ); ?> • Đổi Lên Đời Máy Khác Trợ Giá Thêm
					</h2>
					<p class="text-xs sm:text-sm text-gray-800 mt-2 leading-relaxed font-medium">
						Khi tham gia chương trình Thu Cũ Đổi Mới tại PhoneX, bạn được cộng thêm trực tiếp từ <strong class="text-gray-900 font-bold">500.000₫ đến 3.000.000₫</strong> vào giá thu mua để lên đời các dòng máy Flagship Like New 99% tại Kho Máy Cũ.
					</p>
				</div>

				<div class="flex flex-col sm:flex-row items-center gap-3 shrink-0 w-full sm:w-auto">
					<a 
						href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" 
						class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-[#FF001F] hover:bg-[#D9001B] text-white font-bold text-xs sm:text-sm uppercase tracking-wider flex items-center justify-center gap-2 shadow-sm transition-all text-center"
					>
						<span class="material-symbols-outlined text-[18px]">shopping_bag</span>
						<span>Khám Phá Kho Máy Cũ</span>
					</a>
					<a 
						href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" 
						class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-white hover:bg-gray-50 text-[#1F1F1F] hover:text-[#FF001F] font-bold text-xs sm:text-sm flex items-center justify-center gap-2 border border-gray-300 transition-all text-center shadow-2xs"
					>
						<span class="material-symbols-outlined text-[18px]">list_alt</span>
						<span>Bảng Giá Máy Khác</span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- 5. 5-TIER CONDITION STANDARDS -->
	<section class="max-w-[1440px] mx-auto px-4 mt-12">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 md:p-10 shadow-xs">
			<div class="text-center max-w-2xl mx-auto mb-8">
				<span class="text-xs font-bold uppercase tracking-wider text-[#b7000c] bg-[#FFF0F2] border border-[#ffb4aa]/40 px-3 py-1 rounded-full">
					Barem Minh Bạch
				</span>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-2.5 mb-2">
					Bảng Quy Chuẩn Định Giá 5 Cấp Độ <?php echo esc_html( $model->name ); ?>
				</h2>
				<p class="text-xs sm:text-sm text-gray-600 font-medium">
					Mọi thiết bị đều được áp dụng mức giá niêm yết rõ ràng, kỹ thuật viên không tự ý trừ phụ phí.
				</p>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
				<div class="p-4 rounded-2xl bg-green-50/70 border border-green-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-green-800 bg-green-100 px-2.5 py-0.5 rounded-full mb-2">
							100% Giá Barem
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 1 (Như Mới 99%)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Máy chính hãng VN/A, màn hình đẹp keng không vết xước, đầy đủ hộp &amp; phụ kiện, pin &gt; 85%.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-green-200 text-xs font-black text-green-800">
						Giá thu: <?php echo esc_html( number_format( $p_grade_a, 0, ',', '.' ) ); ?>₫
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-blue-800 bg-blue-100 px-2.5 py-0.5 rounded-full mb-2">
							~88% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 2 (Đẹp 98%)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Máy hoạt động mượt mà ổn định, màn hình hiển thị trong trẻo, thân vỏ có vết dăm siêu nhẹ khó thấy.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-blue-200 text-xs font-black text-blue-800">
						Giá thu: <?php echo esc_html( number_format( $p_grade_b, 0, ',', '.' ) ); ?>₫
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full mb-2">
							~78% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 3 (Trầy Xước Nhẹ)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Đầy đủ tính năng 10/10, màn hình sáng đẹp không ám ố, viền thân máy có trầy xước nhẹ qua quá trình sử dụng.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-amber-200 text-xs font-black text-amber-800">
						Giá thu: <?php echo esc_html( number_format( $p_grade_c, 0, ',', '.' ) ); ?>₫
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-orange-50/70 border border-orange-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-orange-800 bg-orange-100 px-2.5 py-0.5 rounded-full mb-2">
							~65% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 4 (Cấn Móp Nhẹ)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Phần cứng nguyên bản, màn hình trầy nhẹ, viền có cấn móp góc cạnh do va quẹt nhưng không cong sườn.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-orange-200 text-xs font-black text-orange-800">
						Giá thu: <?php echo esc_html( number_format( round( $base_price * 0.65 / 10000 ) * 10000, 0, ',', '.' ) ); ?>₫
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-red-50/70 border border-red-200 flex flex-col justify-between">
					<div>
						<div class="inline-flex items-center gap-1 text-[11px] font-black text-red-800 bg-red-100 px-2.5 py-0.5 rounded-full mb-2">
							~45% Giá
						</div>
						<h3 class="font-extrabold text-sm text-gray-900 mb-1">Loại 5 (Lỗi / Màn Hỏng)</h3>
						<p class="text-xs text-gray-700 leading-relaxed font-medium">
							Lỗi chức năng, màn hình sọc, mực hoặc nứt vỡ nặng nhưng máy vẫn còn lên nguồn để kiểm tra linh kiện.
						</p>
					</div>
					<div class="mt-3 pt-2 border-t border-red-200 text-xs font-black text-red-800">
						Giá thu: <?php echo esc_html( number_format( $p_grade_d, 0, ',', '.' ) ); ?>₫
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 6. FREQUENTLY ASKED QUESTIONS (FAQ) -->
	<section class="max-w-[1440px] mx-auto px-4 mt-12 mb-8">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 md:p-10 shadow-xs">
			<div class="text-center max-w-2xl mx-auto mb-8">
				<span class="text-xs font-bold uppercase tracking-wider text-[#b7000c] bg-[#FFF0F2] border border-[#ffb4aa]/40 px-3 py-1 rounded-full">
					Hỏi Đáp Thu Mua
				</span>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-2.5 mb-2">
					Câu Hỏi Thường Gặp Khi Bán <?php echo esc_html( $model->name ); ?> Cũ
				</h2>
				<p class="text-xs sm:text-sm text-gray-600 font-medium">
					Giải đáp chi tiết mọi thắc mắc về quy trình định giá, thanh toán và bảo mật thông tin.
				</p>
			</div>

			<div class="max-w-3xl mx-auto space-y-3" id="faqAccordion">
				<details class="group bg-gray-50/70 rounded-2xl border border-gray-200/80 p-4 open:bg-white open:shadow-xs transition-all">
					<summary class="flex items-center justify-between font-bold text-gray-900 text-sm sm:text-base cursor-pointer list-none">
						<span>1. Giá thu mua <?php echo esc_html( $model->name ); ?> tại PhoneX được tính như thế nào?</span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform text-[20px]">expand_more</span>
					</summary>
					<div class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						PhoneX áp dụng bảng giá barem công khai chia thành 5 cấp độ tình trạng (Loại 1 đến Loại 5). Mức giá cao nhất lên đến <strong><?php echo esc_html( number_format( $base_price, 0, ',', '.' ) ); ?>₫</strong> cho máy đẹp như mới 99% đầy đủ phụ kiện. Kỹ thuật viên kiểm tra 30 bước công khai trước mặt khách, cam kết không ép giá.
					</div>
				</details>

				<details class="group bg-gray-50/70 rounded-2xl border border-gray-200/80 p-4 open:bg-white open:shadow-xs transition-all">
					<summary class="flex items-center justify-between font-bold text-gray-900 text-sm sm:text-base cursor-pointer list-none">
						<span>2. <?php echo esc_html( $model->name ); ?> bị vỡ màn hình hoặc trầy xước nặng PhoneX có thu không?</span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform text-[20px]">expand_more</span>
					</summary>
					<div class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						PhoneX vẫn nhận thu mua <?php echo esc_html( $model->name ); ?> trong mọi tình trạng như cấn móp, trầy xước hoặc hư hỏng màn hình (xếp vào Loại 4 hoặc Loại 5) miễn là máy vẫn còn nguồn và kiểm tra được linh kiện.
					</div>
				</details>

				<details class="group bg-gray-50/70 rounded-2xl border border-gray-200/80 p-4 open:bg-white open:shadow-xs transition-all">
					<summary class="flex items-center justify-between font-bold text-gray-900 text-sm sm:text-base cursor-pointer list-none">
						<span>3. Bán máy cho PhoneX thì bao lâu nhận được tiền?</span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform text-[20px]">expand_more</span>
					</summary>
					<div class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						Ngay sau khi kỹ thuật viên kiểm định xong và bạn đồng ý với mức giá báo, PhoneX sẽ tiến hành chuyển khoản nhanh 24/7 tới mọi ngân hàng hoặc thanh toán tiền mặt trực tiếp trong vòng <strong>5 phút</strong>.
					</div>
				</details>

				<details class="group bg-gray-50/70 rounded-2xl border border-gray-200/80 p-4 open:bg-white open:shadow-xs transition-all">
					<summary class="flex items-center justify-between font-bold text-gray-900 text-sm sm:text-base cursor-pointer list-none">
						<span>4. Dữ liệu cá nhân và tài khoản trên máy có được bảo mật xóa sạch không?</span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform text-[20px]">expand_more</span>
					</summary>
					<div class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						Tuyệt đối bảo mật! Kỹ thuật viên PhoneX sẽ hướng dẫn và hỗ trợ bạn sao lưu toàn bộ dữ liệu, đăng xuất sạch sẽ iCloud / Google và thực hiện khôi phục cài đặt gốc theo tiêu chuẩn quốc tế trước khi nhận máy.
					</div>
				</details>

				<details class="group bg-gray-50/70 rounded-2xl border border-gray-200/80 p-4 open:bg-white open:shadow-xs transition-all">
					<summary class="flex items-center justify-between font-bold text-gray-900 text-sm sm:text-base cursor-pointer list-none">
						<span>5. Đổi <?php echo esc_html( $model->name ); ?> lên đời máy khác có được trợ giá không?</span>
						<span class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform text-[20px]">expand_more</span>
					</summary>
					<div class="mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
						Có! Khi tham gia chương trình Thu Cũ Đổi Mới (Trade-in), khách hàng bán <?php echo esc_html( $model->name ); ?> sẽ được trợ giá thêm từ <strong>500.000₫ đến 3.000.000₫</strong> trực tiếp vào giá máy mua mới hoặc máy cũ like new tại Kho Máy Cũ PhoneX.
					</div>
				</details>
			</div>
		</div>
	</section>

	<!-- 7. SUCCESS SUBMISSION MODAL -->
	<div id="buybackSuccessModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
		<div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 text-center shadow-2xl relative animate-in fade-in zoom-in-95 duration-200">
			<div class="w-16 h-16 rounded-full bg-green-100 text-green-600 mx-auto flex items-center justify-center mb-4">
				<span class="material-symbols-outlined text-[36px]">check_circle</span>
			</div>

			<h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-1">
				Tiếp Nhận Thành Công!
			</h3>
			<p class="text-xs text-gray-500 mb-4">
				Yêu cầu thu mua thiết bị của bạn đã được ghi nhận vào hệ thống CRM PhoneX.
			</p>

			<!-- Request Code Display -->
			<div class="bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-4 mb-5">
				<div class="text-xs font-semibold text-gray-400 uppercase">Mã phiếu tra cứu của bạn:</div>
				<div class="text-xl sm:text-2xl font-black text-[#e60012] tracking-wider mt-1 select-all" id="modalRequestCode">
					PX-TM-2026-XXXX
				</div>
				<div class="text-[11px] text-gray-500 mt-1">Dùng mã này hoặc SĐT để theo dõi tiến độ kiểm định</div>
			</div>

			<div class="space-y-2">
				<a id="modalLookupBtn" href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="w-full h-11 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-colors">
					<span class="material-symbols-outlined text-[18px]">track_changes</span>
					<span>Xem tiến độ kiểm định ngay</span>
				</a>
				<button type="button" onclick="document.getElementById('buybackSuccessModal').classList.add('hidden')" class="w-full h-10 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-colors">
					Đóng cửa sổ
				</button>
			</div>
		</div>
	</div>

</main>

<!-- Valuation Interactive Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	var basePrice = <?php echo (float) $base_price; ?>;
	var modelId   = <?php echo (int) $model->id; ?>;
	var brandId   = <?php echo (int) $brand->id; ?>;
	var modelName = <?php echo json_encode( $model->name ); ?>;
	var brandName = <?php echo json_encode( $brand->name ); ?>;

	var selectedStorage = document.querySelector('.storage-option-btn.font-black')?.getAttribute('data-storage') || '128GB';
	var selectedColor   = document.querySelector('.color-option-btn.font-black')?.getAttribute('data-color') || 'Tiêu chuẩn';

	// Storage buttons
	var storageBtns = document.querySelectorAll('.storage-option-btn');
	storageBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			storageBtns.forEach(function(b) {
				b.className = 'storage-option-btn h-12 rounded-xl border border-gray-200 bg-white text-gray-700 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-1 hover:border-[#e60012]';
			});
			this.className = 'storage-option-btn h-12 rounded-xl border border-[#e60012] bg-red-50 text-[#e60012] font-black text-xs sm:text-sm transition-all flex items-center justify-center gap-1';
			selectedStorage = this.getAttribute('data-storage');
			recalculate();
		});
	});

	// Color buttons
	var colorBtns = document.querySelectorAll('.color-option-btn');
	colorBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			colorBtns.forEach(function(b) {
				b.className = 'color-option-btn px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 font-medium text-xs sm:text-sm transition-all hover:border-[#e60012]';
			});
			this.className = 'color-option-btn px-4 py-2 rounded-xl border border-[#e60012] bg-red-50 text-[#e60012] font-black text-xs sm:text-sm transition-all';
			selectedColor = this.getAttribute('data-color');
		});
	});

	// Radio condition styling
	function setupRadioStyling(selectorName) {
		var radios = document.querySelectorAll('input[name="' + selectorName + '"]');
		radios.forEach(function(radio) {
			radio.addEventListener('change', function() {
				radios.forEach(function(r) {
					var parent = r.closest('label');
					var circle = parent.querySelector('span');
					var dot = circle.querySelector('span');
					parent.className = 'relative flex items-start p-3.5 rounded-2xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300';
					circle.className = 'w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 mt-0.5 shrink-0';
					dot.className = 'w-2 h-2 rounded-full bg-transparent';
				});

				var activeParent = radio.closest('label');
				var activeCircle = activeParent.querySelector('span');
				var activeDot = activeCircle.querySelector('span');
				activeParent.className = 'relative flex items-start p-3.5 rounded-2xl border-2 border-[#e60012] bg-red-50/50 cursor-pointer transition-all';
				activeCircle.className = 'w-4 h-4 rounded-full border-2 border-[#e60012] flex items-center justify-center mr-3 mt-0.5 shrink-0';
				activeDot.className = 'w-2 h-2 rounded-full bg-[#e60012]';

				recalculate();
			});
		});
	}

	setupRadioStyling('body_condition');
	setupRadioStyling('screen_condition');

	// Checkbox triggers
	document.querySelectorAll('input[type="checkbox"]').forEach(function(chk) {
		chk.addEventListener('change', recalculate);
	});

	function recalculate() {
		var bodyCond = document.querySelector('input[name="body_condition"]:checked')?.value || 'like_new';
		var screenCond = document.querySelector('input[name="screen_condition"]:checked')?.value || 'perfect';
		var faceidOk = document.querySelector('input[name="feature_faceid"]')?.checked;
		var cameraOk = document.querySelector('input[name="feature_cameras"]')?.checked;
		var battOk = document.querySelector('input[name="feature_battery_good"]')?.checked;

		var grade = 'A';
		var rate = 1.0;

		// Deductions & grading rules
		if (screenCond === 'broken' || !faceidOk || !cameraOk || bodyCond === 'cracked') {
			grade = 'D';
			rate = 0.45;
		} else if (screenCond === 'burn_in' || bodyCond === 'dented' || !battOk) {
			grade = 'C';
			rate = 0.72;
		} else if (screenCond === 'scratched' || bodyCond === 'minor_scratches') {
			grade = 'B';
			rate = 0.88;
		} else {
			grade = 'A';
			rate = 1.0;
		}

		// Storage factor: 256GB (+1M), 512GB (+2M), 1TB (+3.5M) approx
		var storageBonus = 0;
		if (selectedStorage && selectedStorage.indexOf('256') !== -1) storageBonus = 1000000;
		else if (selectedStorage && selectedStorage.indexOf('512') !== -1) storageBonus = 2200000;
		else if (selectedStorage && selectedStorage.indexOf('1TB') !== -1) storageBonus = 3500000;

		var finalEstimate = Math.round( ( (basePrice + storageBonus) * rate ) / 10000 ) * 10000;
		if (finalEstimate < 500000) finalEstimate = 500000;

		// Update UI elements
		var badge = document.getElementById('estimatedGradeBadge');
		var desc = document.getElementById('estimatedGradeDesc');
		var val = document.getElementById('estimatedPriceVal');

		if (badge) badge.textContent = 'GRADE ' + grade;
		if (desc) {
			if (grade === 'A') desc.textContent = 'Like New 99%';
			else if (grade === 'B') desc.textContent = 'Very Good 95%';
			else if (grade === 'C') desc.textContent = 'Good 90%';
			else desc.textContent = 'Linh kiện / Cần sửa';
		}
		if (val) {
			val.textContent = new Intl.NumberFormat('vi-VN').format(finalEstimate) + '₫';
		}
	}

	// Submit buyback request
	var submitBtn = document.getElementById('btnSubmitBuybackRequest');
	if (submitBtn) {
		submitBtn.addEventListener('click', function() {
			var name = document.getElementById('custName').value.trim();
			var phone = document.getElementById('custPhone').value.trim();
			var method = document.getElementById('inspectionMethod').value;
			var address = document.getElementById('custAddress').value.trim();
			var notes = document.getElementById('custNotes').value.trim();

			if (!name) {
				alert('Vui lòng nhập họ và tên của bạn.');
				document.getElementById('custName').focus();
				return;
			}
			if (!phone || phone.length < 9) {
				alert('Vui lòng nhập số điện thoại hợp lệ (từ 10 số) để nhận mã tra cứu.');
				document.getElementById('custPhone').focus();
				return;
			}

			var bodyCond = document.querySelector('input[name="body_condition"]:checked')?.value || 'like_new';
			var screenCond = document.querySelector('input[name="screen_condition"]:checked')?.value || 'perfect';
			var grade = document.getElementById('estimatedGradeBadge').textContent.replace('GRADE', '').trim();
			var estPriceText = document.getElementById('estimatedPriceVal').textContent.replace(/[^0-9]/g, '');

			submitBtn.disabled = true;
			submitBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span> Đang tạo phiếu thu mua...';

			var payload = {
				customer_name: name,
				customer_phone: phone,
				brand_id: brandId,
				brand_name: brandName,
				model_id: modelId,
				model_name: modelName,
				storage: selectedStorage,
				color: selectedColor,
				condition_grade: grade,
				condition_details: JSON.stringify({ body: bodyCond, screen: screenCond }),
				estimated_price: parseInt(estPriceText, 10) || 0,
				inspection_method: method,
				store_name: address,
				customer_notes: notes
			};

			fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/submit-request' ) ); ?>', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(payload)
			})
			.then(function(res) { return res.json(); })
			.then(function(data) {
				submitBtn.disabled = false;
				submitBtn.innerHTML = '<span class="material-symbols-outlined text-[20px]">send</span><span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>';

				if (data && data.success && data.request_code) {
					document.getElementById('modalRequestCode').textContent = data.request_code;
					var lookupUrl = '<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>?phone=' + encodeURIComponent(phone) + '&code=' + encodeURIComponent(data.request_code);
					document.getElementById('modalLookupBtn').setAttribute('href', lookupUrl);
					document.getElementById('buybackSuccessModal').classList.remove('hidden');
				} else {
					alert(data.message || 'Không thể tạo yêu cầu thu mua. Vui lòng thử lại sau.');
				}
			})
			.catch(function(err) {
				submitBtn.disabled = false;
				submitBtn.innerHTML = '<span class="material-symbols-outlined text-[20px]">send</span><span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>';
				alert('Có lỗi mạng xảy ra khi gửi yêu cầu. Vui lòng gọi trực tiếp hotline 1800.6868');
			});
		});
	}
});
</script>

<?php
get_footer();
