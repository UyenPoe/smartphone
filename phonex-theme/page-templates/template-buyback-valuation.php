<?php
/**
 * Template Name: PhoneX Buyback Valuation Wizard (Định Giá Trực Tuyến)
 *
 * Route: /dinh-gia-dien-thoai/
 * Description: Bộ công cụ định giá thu mua điện thoại trực tuyến toàn diện.
 *
 * @package PhoneX
 */

get_header();

global $wpdb;
$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
$t_models = $wpdb->prefix . 'phonex_buyback_models';

$brands = $wpdb->get_results( "SELECT id, name, slug, logo_url FROM $t_brands WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, name ASC" );
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
			<span class="text-gray-900 font-semibold">Định Giá Trực Tuyến</span>
		</div>
	</nav>

	<!-- 2. WIZARD HEADER -->
	<section class="max-w-[1000px] mx-auto px-4 pt-8 pb-4 text-center">
		<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-[#e60012] text-xs font-bold uppercase tracking-wider mb-2">
			<span class="material-symbols-outlined text-[15px]">calculate</span>
			<span>Công cụ định giá tự động</span>
		</div>
		<h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
			Định Giá Điện Thoại Cũ Trong 30 Giây
		</h1>
		<p class="text-xs sm:text-base text-gray-500 mt-2 max-w-xl mx-auto">
			Hệ thống tự động tính toán giá thu mua theo barem kỹ thuật niêm yết mới nhất năm 2026.
		</p>
	</section>

	<!-- 3. STEPPER PROGRESS BAR -->
	<section class="max-w-[1000px] mx-auto px-4 mb-6">
		<div class="bg-white rounded-2xl border border-gray-200/90 p-4 shadow-2xs">
			<div class="grid grid-cols-4 gap-2 text-center text-xs">
				<div class="step-indicator active flex flex-col items-center gap-1 text-[#e60012] font-black" id="stepIndicator1">
					<div class="w-8 h-8 rounded-full bg-[#e60012] text-white flex items-center justify-center text-xs font-black shadow-xs">1</div>
					<span class="hidden sm:inline">Chọn máy</span>
				</div>
				<div class="step-indicator flex flex-col items-center gap-1 text-gray-400 font-semibold" id="stepIndicator2">
					<div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black">2</div>
					<span class="hidden sm:inline">Dung lượng</span>
				</div>
				<div class="step-indicator flex flex-col items-center gap-1 text-gray-400 font-semibold" id="stepIndicator3">
					<div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black">3</div>
					<span class="hidden sm:inline">Tình trạng</span>
				</div>
				<div class="step-indicator flex flex-col items-center gap-1 text-gray-400 font-semibold" id="stepIndicator4">
					<div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black">4</div>
					<span class="hidden sm:inline">Báo giá &amp; Bán</span>
				</div>
			</div>
		</div>
	</section>

	<!-- 4. WIZARD STEP CONTAINERS -->
	<section class="max-w-[1000px] mx-auto px-4">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-10 shadow-sm min-h-[420px] flex flex-col justify-between">

			<!-- STEP 1 CONTENT: CHỌN HÃNG & CHỌN MODEL -->
			<div id="stepContent1" class="wizard-step space-y-6">
				<div>
					<h2 class="text-base sm:text-lg font-black text-gray-900 mb-1">
						Bước 1: Chọn thương hiệu và dòng máy
					</h2>
					<p class="text-xs text-gray-500">Vui lòng chọn hãng sản xuất chiếc điện thoại bạn muốn bán.</p>
				</div>

				<!-- Brand selector pills/buttons -->
				<div>
					<label class="block text-xs font-bold text-gray-700 mb-2">Thương hiệu điện thoại</label>
					<div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2.5" id="wizardBrandGrid">
						<?php if ( ! empty( $brands ) ) : ?>
							<?php foreach ( $brands as $idx => $b ) : ?>
								<button 
									type="button" 
									class="wizard-brand-btn min-h-[72px] py-2.5 px-2 rounded-xl border <?php echo 0 === $idx ? 'border-[#FF001F] bg-red-50 text-[#FF001F] font-black shadow-xs ring-1 ring-[#FF001F]' : 'border-gray-200 bg-white text-gray-800 font-bold hover:border-[#FF001F]/60 hover:bg-gray-50/50'; ?> text-xs flex flex-col items-center justify-center transition-all gap-1.5 cursor-pointer"
									data-brand-id="<?php echo esc_attr( $b->id ); ?>"
									data-brand-name="<?php echo esc_attr( $b->name ); ?>"
								>
									<div class="h-7 w-full flex items-center justify-center shrink-0">
										<?php echo phonex_get_brand_logo_img( $b, 'max-h-7 max-w-[68px] w-auto h-auto object-contain' ); ?>
									</div>
									<span class="text-xs font-bold leading-normal truncate w-full text-center"><?php echo esc_html( $b->name ); ?></span>
								</button>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<!-- Model selector dropdown or live list -->
				<div>
					<label class="block text-xs font-bold text-gray-700 mb-2">Chọn mẫu máy cụ thể (Model)</label>
					<div id="wizardModelLoading" class="hidden p-4 text-center text-xs text-gray-400">
						<span class="material-symbols-outlined text-[20px] animate-spin align-middle mr-1">sync</span>
						Đang tải danh sách model...
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 max-h-72 overflow-y-auto p-1" id="wizardModelList">
						<!-- Dynamic models loaded via JS -->
					</div>
				</div>

				<div class="pt-4 flex justify-end">
					<button type="button" id="btnNextStep1" class="px-7 py-3 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 transition-colors shadow-2xs">
						<span>Tiếp tục: Chọn dung lượng</span>
						<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
					</button>
				</div>
			</div>

			<!-- STEP 2 CONTENT: DUNG LƯỢNG & MÀU SẮC -->
			<div id="stepContent2" class="wizard-step hidden space-y-6">
				<div>
					<h2 class="text-base sm:text-lg font-black text-gray-900 mb-1">
						Bước 2: Chọn dung lượng bộ nhớ &amp; màu sắc
					</h2>
					<div class="flex items-center gap-3.5 p-3.5 bg-[#FFF0F2] rounded-2xl border border-[#ffb4aa]/80 my-3">
						<div class="w-14 h-14 rounded-xl bg-white border border-gray-200/90 p-1 flex items-center justify-center shrink-0 shadow-2xs">
							<img id="selectedDeviceThumb" src="" alt="Phone" class="w-full h-full object-contain" />
						</div>
						<div class="min-w-0 flex-1">
							<div class="text-[11px] text-gray-600 font-bold uppercase tracking-wider">Thiết bị đã chọn</div>
							<div id="selectedDeviceSummary" class="text-sm sm:text-base font-black text-gray-900 truncate">...</div>
							<div id="selectedDeviceBasePrice" class="text-xs font-bold text-[#FF001F]">...</div>
						</div>
					</div>
				</div>

				<div>
					<label class="block text-xs font-bold text-gray-700 mb-2">Dung lượng bộ nhớ</label>
					<div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="wizardStorageContainer"></div>
				</div>

				<div>
					<label class="block text-xs font-bold text-gray-700 mb-2">Màu sắc máy</label>
					<div class="flex flex-wrap gap-2" id="wizardColorContainer"></div>
				</div>

				<div class="pt-4 flex justify-between border-t border-gray-100">
					<button type="button" id="btnBackStep2" class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs sm:text-sm hover:bg-gray-50 transition-colors">
						&larr; Quay lại
					</button>
					<button type="button" id="btnNextStep2" class="px-7 py-3 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 transition-colors shadow-2xs">
						<span>Tiếp tục: Đánh giá ngoại hình</span>
						<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
					</button>
				</div>
			</div>

			<!-- STEP 3 CONTENT: ĐÁNH GIÁ TÌNH TRẠNG -->
			<div id="stepContent3" class="wizard-step hidden space-y-6">
				<div>
					<h2 class="text-base sm:text-lg font-black text-gray-900 mb-1">
						Bước 3: Đánh giá tình trạng thực tế của máy
					</h2>
					<p class="text-xs text-gray-500">Mô tả đúng tình trạng giúp bạn nhận báo giá chính xác nhất.</p>
				</div>

				<!-- Vỏ máy -->
				<div>
					<label class="block text-xs font-bold text-gray-900 mb-2">Ngoại hình vỏ sườn / mặt lưng</label>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="wizBodyCondition">
						<label class="flex items-center p-3 rounded-xl border-2 border-[#e60012] bg-red-50/50 cursor-pointer">
							<input type="radio" name="wiz_body" value="like_new" checked class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Đẹp như mới (99%) - Không trầy xước</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_body" value="minor_scratches" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Trầy nhẹ (95%) - Xước dăm nhỏ viền</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_body" value="dented" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Cấn móp / Tróc sơn (90%)</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_body" value="cracked" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Nứt vỡ kính lưng / Cong sườn</span>
						</label>
					</div>
				</div>

				<!-- Màn hình -->
				<div>
					<label class="block text-xs font-bold text-gray-900 mb-2">Tình trạng màn hình</label>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-2" id="wizScreenCondition">
						<label class="flex items-center p-3 rounded-xl border-2 border-[#e60012] bg-red-50/50 cursor-pointer">
							<input type="radio" name="wiz_screen" value="perfect" checked class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Màn hình hoàn hảo, hiển thị đẹp</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_screen" value="scratched" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Màn hình trầy xước lông mèo</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_screen" value="burn_in" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Màn hình ám màu / lưu ảnh nhẹ</span>
						</label>
						<label class="flex items-center p-3 rounded-xl border border-gray-200 bg-white cursor-pointer">
							<input type="radio" name="wiz_screen" value="broken" class="text-[#e60012] mr-3" />
							<span class="text-xs font-bold text-gray-900">Màn vỡ kính / sọc / đốm mực</span>
						</label>
					</div>
				</div>

				<!-- Checkbox tính năng -->
				<div class="space-y-2 text-xs">
					<label class="flex items-center gap-2 p-2.5 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer">
						<input type="checkbox" id="wizFaceid" checked class="rounded text-[#e60012] w-4 h-4" />
						<span class="font-bold text-gray-800">Face ID hoặc cảm biến vân tay còn dùng tốt</span>
					</label>
					<label class="flex items-center gap-2 p-2.5 rounded-xl bg-gray-50 border border-gray-200 cursor-pointer">
						<input type="checkbox" id="wizBattery" checked class="rounded text-[#e60012] w-4 h-4" />
						<span class="font-bold text-gray-800">Pin &gt; 80% (chưa báo dịch vụ bảo trì)</span>
					</label>
				</div>

				<div class="pt-4 flex justify-between border-t border-gray-100">
					<button type="button" id="btnBackStep3" class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs sm:text-sm hover:bg-gray-50 transition-colors">
						&larr; Quay lại
					</button>
					<button type="button" id="btnNextStep3" class="px-7 py-3 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-1.5 transition-colors shadow-2xs">
						<span>Xem kết quả định giá &amp; Bán</span>
						<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
					</button>
				</div>
			</div>

			<!-- STEP 4 CONTENT: KẾT QUẢ ĐỊNH GIÁ & ĐẶT LỊCH THU MUA -->
			<div id="stepContent4" class="wizard-step hidden space-y-6">
				<!-- Result Card -->
				<div class="p-6 rounded-2xl bg-gradient-to-br from-red-50 to-orange-50/50 border-2 border-red-200 text-center">
					<div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white border border-red-100 shadow-2xs mb-2">
						<div class="w-6 h-6 rounded bg-gray-50 flex items-center justify-center overflow-hidden">
							<img id="wizStep4DeviceThumb" src="" alt="Device" class="w-full h-full object-contain" />
						</div>
						<span id="wizStep4DeviceName" class="text-xs font-bold text-gray-800">...</span>
					</div>
					<div class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Mức giá thu mua ước tính:</div>
					<div class="text-3xl sm:text-4xl font-black text-[#FF001F] my-2" id="wizEstimatedPrice">
						0₫
					</div>
					<div class="inline-flex items-center gap-2">
						<span class="px-2.5 py-1 rounded-lg bg-[#FF001F] text-white font-black text-xs uppercase" id="wizEstimatedGrade">
							GRADE A
						</span>
						<span class="text-xs font-bold text-gray-700" id="wizGradeSubtitle">
							Like New 99%
						</span>
					</div>
				</div>

				<!-- Lead Capture Form -->
				<div class="space-y-4">
					<h3 class="text-sm sm:text-base font-black text-gray-900">
						Nhập thông tin liên hệ để chốt giá và đặt lịch:
					</h3>

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Họ và tên *</label>
							<input type="text" id="wizCustName" placeholder="Ví dụ: Nguyễn Văn A" class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm outline-none" />
						</div>
						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại * (Dùng tra cứu)</label>
							<input type="tel" id="wizCustPhone" placeholder="Ví dụ: 0987654321" class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm outline-none" />
						</div>
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Hình thức thu mua</label>
							<select id="wizMethod" class="w-full h-11 px-3 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm outline-none bg-white">
								<option value="store">Đến showroom PhoneX gần nhất</option>
								<option value="home">Kỹ thuật viên thu tận nơi</option>
							</select>
						</div>
						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Khu vực / Chi nhánh</label>
							<input type="text" id="wizAddress" placeholder="Quận/Huyện hoặc tên showroom" class="w-full h-11 px-3.5 rounded-xl border border-gray-300 focus:border-[#e60012] text-xs sm:text-sm outline-none" />
						</div>
					</div>

					<button type="button" id="btnWizSubmit" class="w-full h-13 rounded-2xl bg-[#e60012] hover:bg-[#b7000c] text-white font-black text-sm sm:text-base flex items-center justify-center gap-2 shadow-lg shadow-red-600/30 transition-all cursor-pointer min-h-[48px]">
						<span class="material-symbols-outlined text-[20px]">send</span>
						<span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>
					</button>
				</div>

				<div class="pt-4 flex justify-start border-t border-gray-100">
					<button type="button" id="btnBackStep4" class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs sm:text-sm hover:bg-gray-50 transition-colors">
						&larr; Định giá lại
					</button>
				</div>
			</div>

		</div>
	</section>

	<!-- SUCCESS MODAL -->
	<div id="wizSuccessModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
		<div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 text-center shadow-2xl relative">
			<div class="w-16 h-16 rounded-full bg-green-100 text-green-600 mx-auto flex items-center justify-center mb-4">
				<span class="material-symbols-outlined text-[36px]">check_circle</span>
			</div>
			<h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-1">Tạo Phiếu Thành Công!</h3>
			<p class="text-xs text-gray-500 mb-4">Yêu cầu thu mua của bạn đã được tiếp nhận.</p>

			<div class="bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-4 mb-5">
				<div class="text-xs font-semibold text-gray-400 uppercase">Mã phiếu tra cứu:</div>
				<div class="text-xl sm:text-2xl font-black text-[#e60012] tracking-wider mt-1 select-all" id="wizModalCode">
					PX-TM-2026-XXXX
				</div>
			</div>

			<div class="space-y-2">
				<a id="wizModalLookupBtn" href="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="w-full h-11 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5 transition-colors">
					<span class="material-symbols-outlined text-[18px]">track_changes</span>
					<span>Theo dõi tiến độ đơn hàng</span>
				</a>
				<button type="button" onclick="document.getElementById('wizSuccessModal').classList.add('hidden')" class="w-full h-10 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs">
					Đóng
				</button>
			</div>
		</div>
	</div>

</main>

<!-- Wizard State & Navigation Engine -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	var activeFetchBrandId = null;
	var currentBrandId = document.querySelector('.wizard-brand-btn.font-black')?.getAttribute('data-brand-id') || '1';
	var currentBrandName = document.querySelector('.wizard-brand-btn.font-black')?.getAttribute('data-brand-name') || 'Apple';
	var selectedModel = null;
	var selectedStorage = '128GB';
	var selectedColor = 'Tiêu chuẩn';
	var basePrice = 0;

	// Load models for initial brand (Apple)
	loadModelsForBrand(currentBrandId);

	// Brand Buttons
	var brandBtns = document.querySelectorAll('.wizard-brand-btn');
	brandBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			brandBtns.forEach(function(b) {
				b.className = 'wizard-brand-btn min-h-[72px] py-2.5 px-2 rounded-xl border border-gray-200 bg-white text-gray-800 font-bold text-xs flex flex-col items-center justify-center gap-1.5 hover:border-[#FF001F]/60 hover:bg-gray-50/50 transition-all cursor-pointer';
			});
			this.className = 'wizard-brand-btn min-h-[72px] py-2.5 px-2 rounded-xl border border-[#FF001F] bg-red-50 text-[#FF001F] font-black text-xs flex flex-col items-center justify-center gap-1.5 transition-all shadow-xs ring-1 ring-[#FF001F] cursor-pointer';
			currentBrandId = this.getAttribute('data-brand-id');
			currentBrandName = this.getAttribute('data-brand-name');
			loadModelsForBrand(currentBrandId);
		});
	});

	function loadModelsForBrand(bId) {
		activeFetchBrandId = bId;
		selectedModel = null;
		var list = document.getElementById('wizardModelList');
		var loading = document.getElementById('wizardModelLoading');
		var placeholderImg = '<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>';
		loading.classList.remove('hidden');
		list.innerHTML = '';

		fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/models?brand_id=' ) ); ?>' + bId)
			.then(function(r) { return r.json(); })
			.then(function(data) {
				if (String(activeFetchBrandId) !== String(bId)) return; // Discard stale response
				loading.classList.add('hidden');
				if (data && data.models && data.models.length > 0) {
					var html = '';
					data.models.forEach(function(m, idx) {
						var activeClass = idx === 0 ? 'border-[#FF001F] bg-red-50 text-[#FF001F] font-black ring-1 ring-[#FF001F]' : 'border-gray-200 bg-white text-gray-800 font-bold';
						if (idx === 0) {
							selectedModel = m;
							basePrice = parseFloat(m.base_buyback_price || m.base_price) || 0;
						}
						var priceText = m.base_buyback_price_formatted || m.base_price_fmt || (new Intl.NumberFormat('vi-VN').format(m.base_buyback_price || m.base_price || 0) + '₫');
						var imgUrl = m.image_url || placeholderImg;

						html += '<button type="button" class="wizard-model-item p-2.5 rounded-xl border flex items-center gap-3 text-left text-xs sm:text-sm transition-all hover:border-[#FF001F] ' + activeClass + '" data-model-json=\'' + JSON.stringify(m).replace(/'/g, "&apos;") + '\'>';
						html += '  <div class="w-12 h-12 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center p-1 shrink-0 overflow-hidden">';
						html += '    <img src="' + imgUrl + '" alt="' + m.name + '" class="w-full h-full object-contain" loading="lazy" onerror="this.onerror=null;this.src=\'' + placeholderImg + '\';" />';
						html += '  </div>';
						html += '  <div class="min-w-0 flex-1">';
						html += '    <div class="font-bold text-gray-900 truncate text-xs sm:text-sm leading-snug">' + m.name + '</div>';
						html += '    <div class="text-[11px] text-[#FF001F] font-semibold mt-0.5">Thu tới ' + priceText + '</div>';
						html += '  </div>';
						html += '</button>';
					});
					list.innerHTML = html;

					// Attach click handler to models
					document.querySelectorAll('.wizard-model-item').forEach(function(item) {
						item.addEventListener('click', function() {
							document.querySelectorAll('.wizard-model-item').forEach(function(el) {
								el.className = 'wizard-model-item p-2.5 rounded-xl border border-gray-200 bg-white text-gray-800 font-bold flex items-center gap-3 text-left text-xs sm:text-sm transition-all hover:border-[#FF001F]';
							});
							this.className = 'wizard-model-item p-2.5 rounded-xl border border-[#FF001F] bg-red-50 text-[#FF001F] font-black flex items-center gap-3 text-left text-xs sm:text-sm transition-all ring-1 ring-[#FF001F]';
							var mData = JSON.parse(this.getAttribute('data-model-json'));
							selectedModel = mData;
							basePrice = parseFloat(mData.base_buyback_price || mData.base_price) || 0;
						});
					});
				} else {
					selectedModel = null;
					list.innerHTML = '<div class="col-span-full p-6 text-center text-xs text-gray-500 font-semibold bg-gray-50 rounded-xl border border-dashed border-gray-200">Đang cập nhật danh sách model cho hãng này. Quý khách vui lòng liên hệ hotline 0909.123.456 để nhận báo giá trực tiếp.</div>';
				}
			});
	}

	// Wizard Stepper Transitions
	function goToStep(stepNum) {
		for (var i = 1; i <= 4; i++) {
			var stepEl = document.getElementById('stepContent' + i);
			var indEl = document.getElementById('stepIndicator' + i);
			if (stepEl) {
				if (i === stepNum) stepEl.classList.remove('hidden');
				else stepEl.classList.add('hidden');
			}
			if (indEl) {
				var circle = indEl.querySelector('div');
				if (i <= stepNum) {
					indEl.className = 'step-indicator active flex flex-col items-center gap-1 text-[#FF001F] font-black';
					circle.className = 'w-8 h-8 rounded-full bg-[#FF001F] text-white flex items-center justify-center text-xs font-black shadow-xs';
				} else {
					indEl.className = 'step-indicator flex flex-col items-center gap-1 text-gray-400 font-semibold';
					circle.className = 'w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black';
				}
			}
		}
		window.scrollTo({ top: 180, behavior: 'smooth' });
	}

	// Next Step 1 -> 2
	document.getElementById('btnNextStep1')?.addEventListener('click', function() {
		if (!selectedModel) {
			alert('Vui lòng chọn một model máy.');
			return;
		}
		var bName = selectedModel.brand_name || currentBrandName;
		document.getElementById('selectedDeviceSummary').textContent = bName + ' - ' + selectedModel.name;
		var thumbEl = document.getElementById('selectedDeviceThumb');
		var placeholderImg = '<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>';
		if (thumbEl) {
			thumbEl.src = selectedModel.image_url || placeholderImg;
			thumbEl.onerror = function() { this.onerror = null; this.src = placeholderImg; };
		}
		var priceEl = document.getElementById('selectedDeviceBasePrice');
		if (priceEl) {
			var pTxt = selectedModel.base_buyback_price_formatted || selectedModel.base_price_fmt || (new Intl.NumberFormat('vi-VN').format(selectedModel.base_buyback_price || 0) + '₫');
			priceEl.textContent = 'Giá thu Grade A khởi điểm: ' + pTxt;
		}

		// Populate storages
		var stContainer = document.getElementById('wizardStorageContainer');
		var storages = selectedModel.storage_options || ['128GB', '256GB', '512GB', '1TB'];
		var stHtml = '';
		storages.forEach(function(st, idx) {
			var active = (idx === 0) ? 'border-[#e60012] bg-red-50 text-[#e60012] font-black' : 'border-gray-200 bg-white text-gray-700 font-bold';
			if (idx === 0) selectedStorage = st;
			stHtml += '<button type="button" class="wiz-st-btn h-12 rounded-xl border ' + active + ' text-xs sm:text-sm font-bold flex items-center justify-center hover:border-[#e60012]" data-val="' + st + '">' + st + '</button>';
		});
		stContainer.innerHTML = stHtml;
		document.querySelectorAll('.wiz-st-btn').forEach(function(b) {
			b.addEventListener('click', function() {
				document.querySelectorAll('.wiz-st-btn').forEach(function(el) {
					el.className = 'wiz-st-btn h-12 rounded-xl border border-gray-200 bg-white text-gray-700 font-bold text-xs sm:text-sm flex items-center justify-center hover:border-[#e60012]';
				});
				this.className = 'wiz-st-btn h-12 rounded-xl border border-[#e60012] bg-red-50 text-[#e60012] font-black text-xs sm:text-sm flex items-center justify-center';
				selectedStorage = this.getAttribute('data-val');
			});
		});

		// Populate colors
		var clContainer = document.getElementById('wizardColorContainer');
		var colors = selectedModel.color_options || ['Titan Tự Nhiên', 'Titan Đen', 'Titan Trắng', 'Titan Xanh'];
		var clHtml = '';
		colors.forEach(function(cl, idx) {
			var active = (idx === 0) ? 'border-[#e60012] bg-red-50 text-[#e60012] font-black' : 'border-gray-200 bg-white text-gray-700 font-medium';
			if (idx === 0) selectedColor = cl;
			clHtml += '<button type="button" class="wiz-cl-btn px-4 py-2 rounded-xl border ' + active + ' text-xs sm:text-sm hover:border-[#e60012]" data-val="' + cl + '">' + cl + '</button>';
		});
		clContainer.innerHTML = clHtml;
		document.querySelectorAll('.wiz-cl-btn').forEach(function(b) {
			b.addEventListener('click', function() {
				document.querySelectorAll('.wiz-cl-btn').forEach(function(el) {
					el.className = 'wiz-cl-btn px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 font-medium text-xs sm:text-sm hover:border-[#e60012]';
				});
				this.className = 'wiz-cl-btn px-4 py-2 rounded-xl border border-[#e60012] bg-red-50 text-[#e60012] font-black text-xs sm:text-sm';
				selectedColor = this.getAttribute('data-val');
			});
		});

		goToStep(2);
	});

	document.getElementById('btnBackStep2')?.addEventListener('click', function() { goToStep(1); });
	document.getElementById('btnNextStep2')?.addEventListener('click', function() { goToStep(3); });
	document.getElementById('btnBackStep3')?.addEventListener('click', function() { goToStep(2); });

	// Next Step 3 -> 4 (Calculate & Display)
	document.getElementById('btnNextStep3')?.addEventListener('click', function() {
		var body = document.querySelector('input[name="wiz_body"]:checked')?.value || 'like_new';
		var screen = document.querySelector('input[name="wiz_screen"]:checked')?.value || 'perfect';
		var faceid = document.getElementById('wizFaceid')?.checked;
		var batt = document.getElementById('wizBattery')?.checked;

		var grade = 'A';
		var rate = 1.0;

		if (screen === 'broken' || !faceid || body === 'cracked') {
			grade = 'D'; rate = 0.45;
		} else if (screen === 'burn_in' || body === 'dented' || !batt) {
			grade = 'C'; rate = 0.72;
		} else if (screen === 'scratched' || body === 'minor_scratches') {
			grade = 'B'; rate = 0.88;
		} else {
			grade = 'A'; rate = 1.0;
		}

		var bonus = 0;
		if (selectedStorage.indexOf('256') !== -1) bonus = 1000000;
		else if (selectedStorage.indexOf('512') !== -1) bonus = 2200000;
		else if (selectedStorage.indexOf('1TB') !== -1) bonus = 3500000;

		var finalEst = Math.round( ( (basePrice + bonus) * rate ) / 10000 ) * 10000;
		if (finalEst < 500000) finalEst = 500000;

		document.getElementById('wizEstimatedPrice').textContent = new Intl.NumberFormat('vi-VN').format(finalEst) + '₫';
		document.getElementById('wizEstimatedGrade').textContent = 'GRADE ' + grade;
		var sub = document.getElementById('wizGradeSubtitle');
		if (grade === 'A') sub.textContent = 'Like New 99%';
		else if (grade === 'B') sub.textContent = 'Very Good 95%';
		else if (grade === 'C') sub.textContent = 'Good 90%';
		var s4Thumb = document.getElementById('wizStep4DeviceThumb');
		var s4Name = document.getElementById('wizStep4DeviceName');
		var placeholderImg = '<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>';
		if (s4Thumb && selectedModel) {
			s4Thumb.src = selectedModel.image_url || placeholderImg;
			s4Thumb.onerror = function() { this.onerror = null; this.src = placeholderImg; };
		}
		if (s4Name && selectedModel) {
			s4Name.textContent = selectedModel.name + ' (' + selectedStorage + ')';
		}

		goToStep(4);
	});

	document.getElementById('btnBackStep4')?.addEventListener('click', function() { goToStep(3); });

	// Submit Wizard Lead
	document.getElementById('btnWizSubmit')?.addEventListener('click', function() {
		var name = document.getElementById('wizCustName').value.trim();
		var phone = document.getElementById('wizCustPhone').value.trim();
		var method = document.getElementById('wizMethod').value;
		var address = document.getElementById('wizAddress').value.trim();

		if (!name) { alert('Vui lòng nhập họ và tên'); return; }
		if (!phone || phone.length < 9) { alert('Vui lòng nhập số điện thoại hợp lệ (10 số)'); return; }

		var grade = document.getElementById('wizEstimatedGrade').textContent.replace('GRADE', '').trim();
		var estPrice = parseInt(document.getElementById('wizEstimatedPrice').textContent.replace(/[^0-9]/g, ''), 10) || 0;

		var btn = document.getElementById('btnWizSubmit');
		btn.disabled = true;
		btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span> Đang gửi yêu cầu...';

		var payload = {
			customer_name: name,
			customer_phone: phone,
			brand_id: currentBrandId,
			brand_name: currentBrandName,
			model_id: selectedModel.id,
			model_name: selectedModel.name,
			storage: selectedStorage,
			color: selectedColor,
			condition_grade: grade,
			estimated_price: estPrice,
			inspection_method: method,
			store_name: address,
			customer_notes: 'Tạo từ công cụ định giá nhanh /dinh-gia-dien-thoai/'
		};

		fetch('<?php echo esc_url( home_url( '/wp-json/phonex/v1/buyback/submit-request' ) ); ?>', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(payload)
		})
		.then(function(r) { return r.json(); })
		.then(function(data) {
			btn.disabled = false;
			btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">send</span><span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>';
			if (data && data.success && data.request_code) {
				document.getElementById('wizModalCode').textContent = data.request_code;
				var lookupUrl = '<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>?phone=' + encodeURIComponent(phone) + '&code=' + encodeURIComponent(data.request_code);
				document.getElementById('wizModalLookupBtn').setAttribute('href', lookupUrl);
				document.getElementById('wizSuccessModal').classList.remove('hidden');
			} else {
				alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
			}
		})
		.catch(function() {
			btn.disabled = false;
			btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">send</span><span>GỬI YÊU CẦU THU MUA - NHẬN MÃ TRA CỨU</span>';
			alert('Lỗi kết nối mạng, vui lòng gọi 1800.6868');
		});
	});
});
</script>

<?php
get_footer();
