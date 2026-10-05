<?php
/**
 * Template Name: PhoneX Buyback Process (Quy Trình Thu Mua)
 *
 * Route: /quy-trinh-thu-mua/
 * Description: Chi tiết quy trình 7 bước kiểm định và thu mua máy cũ tại PhoneX.
 *
 * @package PhoneX
 */

get_header();
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
			<span class="text-gray-900 font-semibold">Quy Trình Thu Mua 7 Bước</span>
		</div>
	</nav>

	<!-- 2. HERO SECTION -->
	<section class="bg-white border-b border-gray-200/80 py-10 px-4">
		<div class="max-w-[1000px] mx-auto text-center">
			<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-[#e60012] text-xs font-bold uppercase tracking-wider mb-3">
				<span class="material-symbols-outlined text-[15px]">verified</span>
				<span>Minh bạch • Chuẩn hóa • Nhanh chóng</span>
			</div>
			<h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight">
				Quy Trình Thu Mua &amp; Kiểm Định 7 Bước Tại PhoneX
			</h1>
			<p class="text-xs sm:text-base text-gray-600 mt-3 max-w-2xl mx-auto leading-relaxed">
				Trải nghiệm quy trình bán điện thoại cũ chuyên nghiệp nhất Việt Nam: Kiểm định 30 bước công khai dưới sự chứng kiến của khách hàng, thanh toán chuyển khoản trong 5 phút.
			</p>
			<div class="flex flex-wrap items-center justify-center gap-3 mt-6">
				<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-6 py-3.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-sm transition-colors min-h-[48px]">
					<span class="material-symbols-outlined text-[18px]">calculate</span>
					<span>Định giá máy ngay</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/bang-gia-thu-mua/' ) ); ?>" class="px-5 py-3.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-xs sm:text-sm flex items-center gap-1.5 hover:bg-gray-50 transition-colors min-h-[48px]">
					<span class="material-symbols-outlined text-[18px]">table_chart</span>
					<span>Xem bảng giá</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 3. DETAILED 7-STEP JOURNEY -->
	<section class="max-w-[1100px] mx-auto px-4 mt-12 space-y-6">
		<?php
		$process_steps = array(
			array(
				'step'     => '01',
				'title'    => 'Định Giá Nhanh Trực Tuyến (Online)',
				'time'     => '30 Giây',
				'icon'     => 'calculate',
				'summary'  => 'Nhập thông tin máy, dung lượng và tình trạng sơ bộ để biết mức giá dự kiến.',
				'details'  => 'Bạn chỉ cần truy cập website PhoneX, chọn thương hiệu, model và tự đánh giá tình trạng ngoại hình, màn hình. Hệ thống AI định giá của PhoneX sẽ trả về giá thu dự kiến theo đúng chuẩn thị trường sỉ.'
			),
			array(
				'step'     => '02',
				'title'    => 'Đặt Lịch Thu Mua (Tại Showroom hoặc Tận Nhà)',
				'time'     => '1 Phút',
				'icon'     => 'calendar_month',
				'summary'  => 'Linh hoạt lựa chọn thời gian và địa điểm giao dịch tiện lợi nhất cho bạn.',
				'details'  => 'Bạn có thể mang máy đến 128 Showroom PhoneX toàn quốc, hoặc đặt kỹ thuật viên đến tận nhà, văn phòng công ty trong vòng 1 giờ (áp dụng tại Hà Nội, TP.HCM, Đà Nẵng).'
			),
			array(
				'step'     => '03',
				'title'    => 'Tiếp Nhận Thiết Bị & Khởi Tạo Phiếu Kiểm Định',
				'time'     => '2 Phút',
				'icon'     => 'assignment',
				'summary'  => 'Mở phiếu kiểm định điện tử có mã QR tra cứu tiến độ thời gian thực.',
				'details'  => 'Nhân viên lễ tân hoặc kỹ thuật viên tiếp nhận máy, chụp ảnh ngoại hình và in phiếu thu mua có mã tra cứu định dạng PX-TM-YYMMDD-XXXX. Bạn có thể dùng số điện thoại tra cứu tiến độ bất kỳ lúc nào.'
			),
			array(
				'step'     => '04',
				'title'    => 'Kiểm Định Kỹ Thuật 30 Bước Chuyên Nghiệp',
				'time'     => '10 - 15 Phút',
				'icon'     => 'rule',
				'summary'  => 'Kiểm tra phần cứng, màn hình, camera, mainboard, pin công khai trước mặt khách.',
				'details'  => 'Kỹ thuật viên thực hiện đầy đủ 30 hạng mục: cảm ứng, điểm chết, camera trước/sau, micro, loa, kết nối Wi-Fi/4G/5G, cảm biến tiệm cận, sạc nhanh và kiểm tra phần mềm chuyên dụng (3uTools, Battery Life).'
			),
			array(
				'step'     => '05',
				'title'    => 'Xếp Hạng Phân Loại Grade A / B / C / D',
				'time'     => '2 Phút',
				'icon'     => 'grade',
				'summary'  => 'Đánh giá cấp bậc chất lượng thiết bị theo tiêu chuẩn niêm yết minh bạch.',
				'details'  => 'Máy được đối chiếu chính xác vào 1 trong 4 hạng: Grade A (Like New 99%), Grade B (95% trầy nhẹ), Grade C (90% cấn móp), hoặc Grade D (máy lỗi, bể kính rã linh kiện). Mỗi hạng có bảng giá công khai tương ứng.'
			),
			array(
				'step'     => '06',
				'title'    => 'Chốt Giá Thu Mua Minh Bạch - Không Ép Giá',
				'time'     => '3 Phút',
				'icon'     => 'handshake',
				'summary'  => 'Báo giá chính xác nhất. Nếu khách hàng không đồng ý, hoàn trả máy miễn phí 100%.',
				'details'  => 'Kỹ thuật viên giải thích chi tiết lý do định giá theo kết quả kiểm định. Khách hàng hoàn toàn chủ động quyết định bán hay không. PhoneX cam kết không thu bất kỳ chi phí kiểm định nào nếu giao dịch không thành công.'
			),
			array(
				'step'     => '07',
				'title'    => 'Giải Ngân Tức Thì & Xóa Dữ Liệu Chuẩn Quốc Tế',
				'time'     => '3 - 5 Phút',
				'icon'     => 'payments',
				'summary'  => 'Chuyển khoản 24/7 mọi ngân hàng hoặc nhận tiền mặt ngay lập tức.',
				'details'  => 'Sau khi ký xác nhận chuyển giao quyền sở hữu thiết bị, tiền sẽ được chuyển thẳng vào tài khoản của bạn trong 5 phút. Kỹ thuật viên đồng thời hỗ trợ thoát tài khoản iCloud/Google và khôi phục cài đặt gốc xóa vĩnh viễn dữ liệu theo chuẩn DoD 5220.22-M.'
			),
		);
		foreach ( $process_steps as $p ) : ?>
			<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-8 flex flex-col md:flex-row gap-6 items-start shadow-2xs hover:border-[#e60012] transition-colors">
				<div class="flex items-center gap-4 md:flex-col md:items-center shrink-0">
					<div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-red-50 text-[#e60012] flex items-center justify-center font-black text-xl shadow-xs">
						<?php echo esc_html( $p['step'] ); ?>
					</div>
					<span class="text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full whitespace-nowrap">
						⏱ <?php echo esc_html( $p['time'] ); ?>
					</span>
				</div>
				<div class="flex-1">
					<div class="flex items-center gap-2 mb-1.5">
						<span class="material-symbols-outlined text-[#e60012] text-[20px]"><?php echo esc_html( $p['icon'] ); ?></span>
						<h2 class="text-lg sm:text-xl font-black text-gray-900">
							<?php echo esc_html( $p['title'] ); ?>
						</h2>
					</div>
					<p class="text-xs sm:text-sm font-semibold text-gray-700 mb-2">
						<?php echo esc_html( $p['summary'] ); ?>
					</p>
					<p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
						<?php echo esc_html( $p['details'] ); ?>
					</p>
				</div>
			</div>
		<?php endforeach; ?>
	</section>

	<!-- 4. DATA SANITIZATION COMMITMENT -->
	<section class="max-w-[1100px] mx-auto px-4 mt-14">
		<div class="rounded-3xl p-6 sm:p-10 shadow-xs border border-[#ffb4aa] text-[#1F1F1F] relative overflow-hidden" style="background-color: var(--px-primary-fixed, #FFF0F2);">
			<div class="absolute -right-12 -top-12 w-64 h-64 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>
			<div class="absolute -left-12 -bottom-12 w-64 h-64 bg-[#ffb4aa]/30 rounded-full blur-2xl pointer-events-none"></div>
			<div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
				<div class="w-16 h-16 rounded-2xl bg-[#FFF0F2] border border-[#ffdad5] flex items-center justify-center text-[#FF001F] shrink-0 shadow-2xs">
					<span class="material-symbols-outlined text-[36px]">security</span>
				</div>
				<div>
					<h3 class="text-xl sm:text-2xl font-black text-[#1F1F1F] mb-2">Cam Kết Bảo Mật &amp; Tiêu Hủy Dữ Liệu Cá Nhân</h3>
					<p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed">
						PhoneX áp dụng quy trình xóa dữ liệu chuyên dụng theo tiêu chuẩn quân sự Hoa Kỳ (DoD 5220.22-M). Sau khi xuất xưởng và nhập kho sỉ, toàn bộ dữ liệu gồm danh bạ, ảnh, tin nhắn, tài khoản ngân hàng và ứng dụng đều bị ghi đè ngẫu nhiên nhiều lần, đảm bảo không thể phục hồi bằng bất kỳ công cụ can thiệp nào.
					</p>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
