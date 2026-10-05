<?php
/**
 * Template Name: PhoneX Buyback Request Lookup (Tra Cứu Yêu Cầu Thu Mua)
 *
 * Route: /tra-cuu-yeu-cau/
 * Description: Tra cứu tiến độ yêu cầu thu mua bằng số điện thoại hoặc mã phiếu.
 *
 * @package PhoneX
 */

get_header();

global $wpdb;
$t_req = $wpdb->prefix . 'phonex_buyback_requests';

$param_phone = sanitize_text_field( $_GET['phone'] ?? '' );
$param_code  = sanitize_text_field( $_GET['code'] ?? '' );
$search_val  = ! empty( $param_phone ) ? $param_phone : $param_code;

$initial_tickets = array();
if ( ! empty( $search_val ) ) {
	$initial_tickets = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM $t_req WHERE customer_phone = %s OR request_code = %s ORDER BY created_at DESC LIMIT 20",
			$search_val,
			$search_val
		)
	);
}

$status_map = array(
	'new'             => array( 'label' => 'Mới tạo', 'step' => 1, 'badge' => 'bg-blue-100 text-blue-800' ),
	'contacted'       => array( 'label' => 'Đã liên hệ', 'step' => 2, 'badge' => 'bg-cyan-100 text-cyan-800' ),
	'scheduled'       => array( 'label' => 'Đã đặt lịch hẹn', 'step' => 3, 'badge' => 'bg-purple-100 text-purple-800' ),
	'inspecting'      => array( 'label' => 'Đang kiểm định', 'step' => 4, 'badge' => 'bg-amber-100 text-amber-800 animate-pulse' ),
	'price_agreed'    => array( 'label' => 'Đã chốt giá', 'step' => 5, 'badge' => 'bg-indigo-100 text-indigo-800' ),
	'price_confirmed' => array( 'label' => 'Đã chốt giá', 'step' => 5, 'badge' => 'bg-indigo-100 text-indigo-800' ),
	'bought'          => array( 'label' => 'Đã giải ngân', 'step' => 6, 'badge' => 'bg-green-100 text-green-800' ),
	'purchased'       => array( 'label' => 'Đã thu mua', 'step' => 6, 'badge' => 'bg-green-100 text-green-800' ),
	'completed'       => array( 'label' => 'Hoàn tất', 'step' => 7, 'badge' => 'bg-green-100 text-green-800' ),
	'cancelled'       => array( 'label' => 'Đã hủy', 'step' => 0, 'badge' => 'bg-gray-100 text-gray-600' ),
);

$stages = array(
	1 => '1. Tiếp nhận',
	2 => '2. Đã liên hệ',
	3 => '3. Đã đặt lịch',
	4 => '4. Đang kiểm định',
	5 => '5. Đã chốt giá',
	6 => '6. Đã giải ngân',
	7 => '7. Hoàn tất',
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
			<span class="text-gray-900 font-semibold">Tra Cứu Yêu Cầu Thu Mua</span>
		</div>
	</nav>

	<!-- 2. SEARCH HERO -->
	<section class="max-w-[800px] mx-auto px-4 pt-10 pb-6 text-center">
		<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-[#e60012] text-xs font-bold uppercase tracking-wider mb-2">
			<span class="material-symbols-outlined text-[15px]">track_changes</span>
			<span>Hệ thống CRM PhoneX</span>
		</div>
		<h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
			Tra Cứu Tiến Độ Kiểm Định &amp; Thu Mua
		</h1>
		<p class="text-xs sm:text-base text-gray-500 mt-2">
			Nhập số điện thoại bạn đã đăng ký hoặc Mã phiếu thu mua (PX-TM-...) để kiểm tra trạng thái thời gian thực.
		</p>

		<!-- Lookup Form -->
		<form method="get" action="<?php echo esc_url( home_url( '/tra-cuu-yeu-cau/' ) ); ?>" class="mt-6 flex flex-col sm:flex-row gap-2 max-w-lg mx-auto">
			<div class="relative flex-1">
				<span class="absolute left-3.5 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-[20px]">phone_iphone</span>
				<input 
					type="text" 
					name="phone"
					id="lookupInput" 
					value="<?php echo esc_attr( $search_val ); ?>"
					placeholder="Nhập số điện thoại hoặc mã PX-TM-..." 
					class="w-full h-12 pl-11 pr-4 rounded-xl border border-gray-300 focus:border-[#e60012] focus:ring-2 focus:ring-red-100 text-sm font-semibold text-gray-900 outline-none shadow-2xs"
					required
				/>
			</div>
			<button 
				type="submit" 
				id="btnLookupSubmit" 
				class="h-12 px-6 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-black text-sm flex items-center justify-center gap-1.5 transition-colors shadow-sm shrink-0 min-h-[48px]"
			>
				<span class="material-symbols-outlined text-[18px]">search</span>
				<span>Tra cứu ngay</span>
			</button>
		</form>
	</section>

	<!-- 3. RESULTS CONTAINER -->
	<section class="max-w-[900px] mx-auto px-4 mt-4">
		<!-- Loading state -->
		<div id="lookupLoading" class="hidden p-12 text-center text-sm text-gray-500">
			<span class="material-symbols-outlined text-[32px] text-[#e60012] animate-spin align-middle mb-2">sync</span>
			<p>Đang tìm kiếm thông tin yêu cầu của bạn...</p>
		</div>

		<!-- Tickets Output (Server-rendered + Dynamic Client Updated) -->
		<div id="lookupResultsContainer" class="space-y-6">
			<?php if ( ! empty( $initial_tickets ) ) : ?>
				<?php foreach ( $initial_tickets as $tk ) : 
					$st_info   = $status_map[ $tk->status ] ?? array( 'label' => 'Đang xử lý', 'step' => 1, 'badge' => 'bg-gray-100 text-gray-800' );
					$curr_step = $st_info['step'];
					$est_str   = number_format( (float) $tk->estimated_price, 0, ',', '.' ) . '₫';
					$fin_str   = ! empty( $tk->final_price ) ? number_format( (float) $tk->final_price, 0, ',', '.' ) . '₫' : '';
				?>
					<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 shadow-sm">
						<!-- Header -->
						<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 pb-4 mb-5">
							<div>
								<div class="text-xs font-semibold text-gray-400">Mã yêu cầu thu mua</div>
								<div class="text-lg sm:text-xl font-black text-gray-900 tracking-wider">
									<?php echo esc_html( $tk->request_code ); ?>
								</div>
								<div class="text-[11px] text-gray-500 mt-0.5">
									Ngày tạo: <?php echo esc_html( date( 'H:i d/m/Y', strtotime( $tk->created_at ) ) ); ?>
								</div>
							</div>
							<div class="text-left sm:text-right">
								<span class="inline-block px-3 py-1 rounded-full text-xs font-black <?php echo esc_attr( $st_info['badge'] ); ?>">
									<?php echo esc_html( $st_info['label'] ); ?>
								</span>
							</div>
						</div>

						<!-- Device Details -->
						<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 rounded-2xl bg-gray-50 border border-gray-100">
							<div>
								<div class="text-xs text-gray-500">Thiết bị:</div>
								<div class="text-base font-bold text-gray-900">
									<?php echo esc_html( $tk->model_name ); ?>
								</div>
								<div class="text-xs text-gray-600 mt-1">
									<?php echo esc_html( $tk->brand_name . ' • ' . ( $tk->storage ?: 'Tiêu chuẩn' ) . ' • ' . ( $tk->color ?: 'Tiêu chuẩn' ) ); ?>
								</div>
							</div>
							<div>
								<div class="text-xs text-gray-500">Phân hạng &amp; Giá:</div>
								<div class="flex items-center gap-2 mt-0.5">
									<span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-black text-xs">
										GRADE <?php echo esc_html( $tk->condition_grade ?: 'A' ); ?>
									</span>
									<span class="text-sm font-bold text-gray-600">Ước tính: <?php echo esc_html( $est_str ); ?></span>
								</div>
								<?php if ( ! empty( $fin_str ) ) : ?>
									<div class="text-xs text-[#e60012] font-black mt-1">
										Giá chốt chính thức: <?php echo esc_html( $fin_str ); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>

						<!-- 7-Stage Progress Stepper -->
						<?php if ( 'cancelled' !== $tk->status ) : ?>
							<div class="mb-6">
								<div class="text-xs font-bold text-gray-700 uppercase mb-3">Tiến độ xử lý 7 bước:</div>
								<div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2 text-center text-[11px]">
									<?php foreach ( $stages as $s_num => $s_label ) : 
										$is_done = ( $s_num <= $curr_step );
										$is_current = ( $s_num === $curr_step );
										$color_class = $is_done ? 'bg-[#e60012] text-white font-black' : 'bg-gray-100 text-gray-400 font-semibold';
										$border_class = $is_current ? 'ring-2 ring-red-400' : '';
									?>
										<div class="flex flex-col items-center gap-1.5 p-2 rounded-xl <?php echo $is_current ? 'bg-red-50' : ''; ?>">
											<div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] <?php echo esc_attr( $color_class . ' ' . $border_class ); ?>">
												<?php echo esc_html( $s_num ); ?>
											</div>
											<span class="<?php echo $is_done ? 'text-gray-900 font-bold' : 'text-gray-400'; ?>">
												<?php echo esc_html( $s_label ); ?>
											</span>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php else : ?>
							<div class="p-3 rounded-xl bg-red-50 text-red-700 text-xs font-semibold mb-6">
								Yêu cầu thu mua này đã được hủy theo nguyện vọng của khách hàng.
							</div>
						<?php endif; ?>

						<!-- Store / Notes -->
						<?php if ( ! empty( $tk->store_name ) || ! empty( $tk->customer_notes ) || ! empty( $tk->staff_notes ) ) : ?>
							<div class="border-t border-gray-100 pt-4 text-xs text-gray-600 space-y-1">
								<?php if ( ! empty( $tk->store_name ) ) : ?>
									<div><strong>Địa điểm:</strong> <?php echo esc_html( $tk->store_name ); ?> (<?php echo ( 'home' === $tk->inspection_method ) ? 'Thu tận nhà' : 'Tại showroom'; ?>)</div>
								<?php endif; ?>
								<?php if ( ! empty( $tk->customer_notes ) ) : ?>
									<div><strong>Ghi chú của bạn:</strong> <?php echo esc_html( $tk->customer_notes ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $tk->staff_notes ) ) : ?>
									<div class="text-[#e60012]"><strong>Ghi chú kỹ thuật viên:</strong> <?php echo esc_html( $tk->staff_notes ); ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php elseif ( ! empty( $search_val ) ) : ?>
				<div class="bg-white rounded-3xl border border-gray-200/90 p-8 sm:p-12 text-center shadow-2xs">
					<div class="w-16 h-16 rounded-full bg-red-50 text-[#e60012] mx-auto flex items-center justify-center mb-3">
						<span class="material-symbols-outlined text-[32px]">manage_search</span>
					</div>
					<h3 class="text-lg font-black text-gray-900 mb-1">Không Tìm Thấy Phiếu Thu Mua Nào</h3>
					<p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto mb-4">
						Không tìm thấy phiếu nào gắn với thông tin <strong>"<?php echo esc_html( $search_val ); ?>"</strong>. Vui lòng kiểm tra lại số điện thoại hoặc mã phiếu.
					</p>
					<a href="tel:18006868" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-gray-900 text-white font-bold text-xs">
						<span class="material-symbols-outlined text-[16px]">call</span>
						<span>Tổng đài PhoneX: 1800.6868</span>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<!-- Not found state placeholder for client JS -->
		<div id="lookupNotFound" class="hidden bg-white rounded-3xl border border-gray-200/90 p-8 sm:p-12 text-center shadow-2xs">
			<div class="w-16 h-16 rounded-full bg-red-50 text-[#e60012] mx-auto flex items-center justify-center mb-3">
				<span class="material-symbols-outlined text-[32px]">manage_search</span>
			</div>
			<h3 class="text-lg font-black text-gray-900 mb-1">Không Tìm Thấy Phiếu Thu Mua Nào</h3>
			<p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto mb-4">
				Vui lòng kiểm tra lại số điện thoại hoặc mã phiếu của bạn. Nếu cần hỗ trợ khẩn cấp, vui lòng gọi tổng đài miễn phí PhoneX.
			</p>
			<a href="tel:18006868" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-gray-900 text-white font-bold text-xs">
				<span class="material-symbols-outlined text-[16px]">call</span>
				<span>Tổng đài PhoneX: 1800.6868</span>
			</a>
		</div>
	</section>

</main>

<?php
get_footer();
