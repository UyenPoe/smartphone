<?php
/**
 * Template Name: PhoneX Inspection Standards (Tiêu Chuẩn Kiểm Định)
 *
 * Route: /tieu-chuan-kiem-dinh/
 * Description: Bộ tiêu chuẩn kiểm định 30 bước và phân loại Grade A/B/C/D tại PhoneX.
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
			<span class="text-gray-900 font-semibold">Tiêu Chuẩn Kiểm Định Grade A/B/C/D</span>
		</div>
	</nav>

	<!-- 2. HERO -->
	<section class="bg-white border-b border-gray-200/80 py-10 px-4">
		<div class="max-w-[1000px] mx-auto text-center">
			<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-[#e60012] text-xs font-bold uppercase tracking-wider mb-3">
				<span class="material-symbols-outlined text-[15px]">verified</span>
				<span>Chuẩn hóa quốc tế • Công bằng tuyệt đối</span>
			</div>
			<h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight">
				Tiêu Chuẩn Phân Loại Grade &amp; Barem Kiểm Định 30 Bước
			</h1>
			<p class="text-xs sm:text-base text-gray-600 mt-3 max-w-2xl mx-auto leading-relaxed">
				Tại PhoneX, mọi thiết bị đều được định giá dựa trên barem kỹ thuật niêm yết công khai, loại bỏ hoàn toàn tính chủ quan của người kiểm tra.
			</p>
			<div class="flex items-center justify-center gap-3 mt-6">
				<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" class="px-6 py-3.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-xs sm:text-sm flex items-center gap-2 shadow-sm transition-colors min-h-[48px]">
					<span class="material-symbols-outlined text-[18px]">calculate</span>
					<span>Tự định giá máy ngay</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 3. GRADE DEFINITIONS (A / B / C / D) -->
	<section class="max-w-[1280px] mx-auto px-4 mt-12">
		<h2 class="text-xl sm:text-2xl font-black text-gray-900 mb-6 text-center">
			4 Cấp Bậc Phân Loại Thiết Bị Tại PhoneX
		</h2>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
			<!-- GRADE A -->
			<div class="bg-white rounded-3xl border-2 border-emerald-500 p-6 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center justify-between mb-3">
						<span class="px-3 py-1 rounded-lg bg-emerald-600 text-white font-black text-xs uppercase">GRADE A</span>
						<span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">99% Like New</span>
					</div>
					<h3 class="text-base font-black text-gray-900 mb-2">Đẹp Xuất Sắc Như Mới</h3>
					<p class="text-xs text-gray-600 mb-4 leading-relaxed">Dành cho thiết bị được bảo quản cẩn thận, hoàn hảo từ ngoại hình đến phần cứng bên trong.</p>
					
					<div class="space-y-2 text-xs text-gray-700 mb-6 border-t border-gray-100 pt-3">
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-emerald-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Vỏ máy:</strong> Không cấn móp, không tróc sơn, không có vết xước nhìn thấy bằng mắt thường.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-emerald-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Màn hình:</strong> Không xước, không ám ố, hiển thị sắc nét 100%.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-emerald-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Dung lượng pin:</strong> Còn từ 85% trở lên, chu kỳ sạc thấp.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-emerald-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Tính năng:</strong> Nguyên bản 100%, chưa từng mở máy sửa chữa.</span>
						</div>
					</div>
				</div>
				<div class="p-3 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-black text-center">
					Thu mua 100% giá niêm yết
				</div>
			</div>

			<!-- GRADE B -->
			<div class="bg-white rounded-3xl border border-blue-400 p-6 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center justify-between mb-3">
						<span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-black text-xs uppercase">GRADE B</span>
						<span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">95% Very Good</span>
					</div>
					<h3 class="text-base font-black text-gray-900 mb-2">Đẹp Qua Sử Dụng (Trầy Nhẹ)</h3>
					<p class="text-xs text-gray-600 mb-4 leading-relaxed">Thiết bị có dấu vết thời gian nhẹ nhưng các linh kiện cốt lõi hoạt động trơn tru.</p>
					
					<div class="space-y-2 text-xs text-gray-700 mb-6 border-t border-gray-100 pt-3">
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-blue-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Vỏ máy:</strong> Có vài vết xước dăm nhẹ ở viền hoặc mặt lưng, không móp sâu.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-blue-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Màn hình:</strong> Xước lông mèo siêu nhẹ, hiển thị trong trẻo không ám.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-blue-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Dung lượng pin:</strong> Từ 80% đến 84%.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-blue-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Tính năng:</strong> Đầy đủ mọi tính năng, bo mạch nguyên zin.</span>
						</div>
					</div>
				</div>
				<div class="p-3 rounded-xl bg-blue-50 text-blue-800 text-xs font-black text-center">
					Thu mua 85% - 90% giá Grade A
				</div>
			</div>

			<!-- GRADE C -->
			<div class="bg-white rounded-3xl border border-amber-400 p-6 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center justify-between mb-3">
						<span class="px-3 py-1 rounded-lg bg-amber-600 text-white font-black text-xs uppercase">GRADE C</span>
						<span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded">90% Good</span>
					</div>
					<h3 class="text-base font-black text-gray-900 mb-2">Ngoại Hình Cấn Móp / Xước Nhiều</h3>
					<p class="text-xs text-gray-600 mb-4 leading-relaxed">Dành cho máy qua sử dụng cường độ cao, vỏ xước nhiều hoặc pin đã chai.</p>
					
					<div class="space-y-2 text-xs text-gray-700 mb-6 border-t border-gray-100 pt-3">
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-amber-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Vỏ máy:</strong> Cấn góc, trầy xước sâu hoặc bong tróc sơn rõ ràng.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-amber-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Màn hình:</strong> Trầy xước nhìn thấy rõ hoặc ám ố nhẹ ở mép.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-amber-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Dung lượng pin:</strong> Dưới 80% (cần bảo trì).</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-amber-600 text-[16px] shrink-0 mt-0.5">check_circle</span>
							<span><strong>Tính năng:</strong> Nghe gọi, wifi, camera vẫn sử dụng bình thường.</span>
						</div>
					</div>
				</div>
				<div class="p-3 rounded-xl bg-amber-50 text-amber-800 text-xs font-black text-center">
					Thu mua 70% - 75% giá Grade A
				</div>
			</div>

			<!-- GRADE D -->
			<div class="bg-white rounded-3xl border border-gray-300 p-6 flex flex-col justify-between shadow-xs">
				<div>
					<div class="flex items-center justify-between mb-3">
						<span class="px-3 py-1 rounded-lg bg-gray-700 text-white font-black text-xs uppercase">GRADE D</span>
						<span class="text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">Linh Kiện / Lỗi</span>
					</div>
					<h3 class="text-base font-black text-gray-900 mb-2">Rơi Vỡ / Hỏng Tính Năng</h3>
					<p class="text-xs text-gray-600 mb-4 leading-relaxed">Thiết bị rơi vỡ nặng, màn sọc, hỏng camera hoặc lỗi chức năng quan trọng.</p>
					
					<div class="space-y-2 text-xs text-gray-700 mb-6 border-t border-gray-100 pt-3">
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-gray-500 text-[16px] shrink-0 mt-0.5">build</span>
							<span><strong>Màn hình:</strong> Bể nứt kính, sọc kẻ, đốm mực hoặc liệt cảm ứng.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-gray-500 text-[16px] shrink-0 mt-0.5">build</span>
							<span><strong>Linh kiện lỗi:</strong> Mất Face ID / vân tay, camera rung nhoè.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-gray-500 text-[16px] shrink-0 mt-0.5">build</span>
							<span><strong>Thân vỏ:</strong> Biến dạng cong sườn, nứt vỡ mặt kính lưng.</span>
						</div>
						<div class="flex items-start gap-2">
							<span class="material-symbols-outlined text-gray-500 text-[16px] shrink-0 mt-0.5">build</span>
							<span><strong>Mục đích:</strong> Thu gom tận dụng linh kiện zin bo mạch.</span>
						</div>
					</div>
				</div>
				<div class="p-3 rounded-xl bg-gray-100 text-gray-800 text-xs font-black text-center">
					Định giá theo linh kiện thực tế
				</div>
			</div>
		</div>
	</section>

	<!-- 4. 30-POINT TECHNICAL INSPECTION CHECKLIST -->
	<section class="max-w-[1100px] mx-auto px-4 mt-16">
		<div class="bg-white rounded-3xl border border-gray-200/90 p-6 sm:p-10 shadow-sm">
			<div class="text-center max-w-2xl mx-auto mb-8">
				<div class="text-xs font-bold uppercase tracking-wider text-[#e60012] mb-1">Quy chuẩn kỹ thuật</div>
				<h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
					Barem Kiểm Định 30 Bước Chuyên Nghiệp
				</h2>
				<p class="text-xs sm:text-sm text-gray-500 mt-2">
					Áp dụng đồng bộ tại 128 Showroom PhoneX và kỹ thuật viên thu mua lưu động.
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<?php
				$categories = array(
					array(
						'title' => 'Nhóm 1: Thẩm Mỹ Ngoại Quan & Khung Vỏ (4 Bước)',
						'items' => array(
							'Kiểm tra viền bezel, góc bo, độ liền lạc khung vỏ',
							'Kiểm tra độ nguyên vẹn mặt lưng kính/gốm/da',
							'Kiểm tra khay SIM, ron chống bụi & nước',
							'Kiểm tra chân cắm sạc Type-C/Lightning và phím bấm vật lý'
						)
					),
					array(
						'title' => 'Nhóm 2: Màn Hình & Cảm Ứng Đa Điểm (5 Bước)',
						'items' => array(
							'Kiểm tra độ nhạy cảm ứng đa điểm toàn màn hình',
							'Kiểm tra điểm chết pixel (Dead pixel, Stuck pixel)',
							'Kiểm tra độ sáng tối đa và tính năng True Tone / ProMotion',
							'Kiểm tra hiện tượng ám màu, ố vàng, lưu ảnh (Burn-in)',
							'Kiểm tra sọc màn hình, chớp nháy và nứt kính phản quang'
						)
					),
					array(
						'title' => 'Nhóm 3: Hệ Thống Camera & Cảm Biến Quang (5 Bước)',
						'items' => array(
							'Kiểm tra camera chính độ phân giải cao và lấy nét tự động',
							'Kiểm tra camera góc siêu rộng (Ultra-wide) và Telephoto zoom quang',
							'Kiểm tra khả năng chống rung quang học OIS khi quay video',
							'Kiểm tra camera selfie trước và chế độ chụp chân dung',
							'Kiểm tra đèn Flash LED và cảm biến laser LiDAR/ToF'
						)
					),
					array(
						'title' => 'Nhóm 4: Bo Mạch, CPU & Hiệu Năng (4 Bước)',
						'items' => array(
							'Kiểm tra nhiệt độ hoạt động và khả năng tản nhiệt của bo mạch',
							'Kiểm tra cảm biến gia tốc kế, con quay hồi chuyển 6 trục',
							'Kiểm tra cảm biến tiệm cận khi thực hiện cuộc gọi',
							'Kiểm tra cảm biến ánh sáng tự động điều chỉnh màn hình'
						)
					),
					array(
						'title' => 'Nhóm 5: Sinh Trắc Học & Bảo Mật (3 Bước)',
						'items' => array(
							'Kiểm tra Face ID (TrueDepth Camera) nhận diện khuôn mặt 3D',
							'Kiểm tra cảm biến vân tay Touch ID / vân tay quang học / siêu âm',
							'Kiểm tra trạng thái khóa bảo mật tài khoản (iCloud, Knox, FRP)'
						)
					),
					array(
						'title' => 'Nhóm 6: Âm Thanh & Giao Tiếp (4 Bước)',
						'items' => array(
							'Kiểm tra loa ngoài stereo (âm trầm, âm bổng, không rè)',
							'Kiểm tra loa thoại trong rõ ràng khi gọi điện',
							'Kiểm tra micro chính đàm thoại và micro phụ khử ồn',
							'Kiểm tra độ rung phản hồi haptic feedback'
						)
					),
					array(
						'title' => 'Nhóm 7: Kết Nối Không Dây & Sóng Mạng (3 Bước)',
						'items' => array(
							'Kiểm tra độ bắt sóng di động 4G / 5G cả 2 khe SIM / eSIM',
							'Kiểm tra kết nối Wi-Fi 6/7 băng tần kép và Bluetooth tầm xa',
							'Kiểm tra kết nối GPS dẫn đường vệ tinh và giao tiếp NFC'
						)
					),
					array(
						'title' => 'Nhóm 8: Pin & Công Nghệ Sạc (2 Bước)',
						'items' => array(
							'Đo dung lượng pin thực tế và số chu kỳ sạc (Charge cycles)',
							'Kiểm tra nhận dòng sạc nhanh công suất cao và sạc không dây'
						)
					),
				);

				foreach ( $categories as $cat ) : ?>
					<div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
						<h3 class="text-xs sm:text-sm font-black text-gray-900 mb-2.5 text-[#e60012]">
							<?php echo esc_html( $cat['title'] ); ?>
						</h3>
						<ul class="space-y-1.5 text-xs text-gray-600">
							<?php foreach ( $cat['items'] as $it ) : ?>
								<li class="flex items-start gap-1.5">
									<span class="material-symbols-outlined text-green-600 text-[15px] shrink-0 mt-0.5">check</span>
									<span><?php echo esc_html( $it ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
