<?php
/**
 * Template Name: PhoneX Integration Guide (Hướng Dẫn Kết Nối Website & API)
 *
 * Route: /huong-dan-ket-noi-website/
 * Description: Tài liệu & hướng dẫn tích hợp Widget định giá và API báo giá PhoneX dành cho đối tác, đại lý B2B.
 *
 * @package PhoneX
 */

get_header();
?>

<main id="primary" class="site-main bg-background min-h-screen font-sans pb-20">

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
			<span class="text-gray-900 font-semibold">Hướng Dẫn Kết Nối Website &amp; Tích Hợp API</span>
		</div>
	</nav>

	<!-- 2. HERO SECTION -->
	<section class="bg-gradient-to-b from-white via-red-50/20 to-white border-b border-gray-200/80 py-12 px-4 relative overflow-hidden">
		<div class="max-w-[1100px] mx-auto text-center relative z-10">
			<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
				<span class="material-symbols-outlined text-[17px]">hub</span>
				<span>Giải Pháp Tích Hợp B2B &amp; Mạng Lưới Đối Tác Thu Cũ PhoneX</span>
			</div>
			
			<h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-tight max-w-4xl mx-auto">
				Hướng Dẫn Kết Nối Website &amp; Tích Hợp Báo Giá PhoneX
			</h1>
			
			<p class="text-sm sm:text-base md:text-lg text-gray-600 mt-4 max-w-3xl mx-auto leading-relaxed">
				Biến website của bạn thành cổng thu mua &amp; thu cũ đổi mới điện thoại tự động. Nhúng Widget định giá thông minh chỉ trong 1 phút hoặc kết nối trực tiếp qua hệ thống REST API thời gian thực.
			</p>

			<!-- Quick Value Metrics Grid -->
			<div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-[900px] mx-auto mt-8 text-left">
				<div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-xs flex items-center gap-3">
					<div class="w-10 h-10 rounded-xl bg-red-50 text-[#e60012] flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[22px]">percent</span>
					</div>
					<div>
						<div class="text-lg font-black text-gray-900">3% – 5%</div>
						<div class="text-xs text-gray-500 font-medium">Hoa hồng mỗi máy thu</div>
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-xs flex items-center gap-3">
					<div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[22px]">speed</span>
					</div>
					<div>
						<div class="text-lg font-black text-gray-900">&lt; 1 Phút</div>
						<div class="text-xs text-gray-500 font-medium">Nhúng mã Widget nhanh</div>
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-xs flex items-center gap-3">
					<div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[22px]">database</span>
					</div>
					<div>
						<div class="text-lg font-black text-gray-900">300+ Model</div>
						<div class="text-xs text-gray-500 font-medium">Cập nhật giá theo giờ</div>
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-xs flex items-center gap-3">
					<div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
						<span class="material-symbols-outlined text-[22px]">verified</span>
					</div>
					<div>
						<div class="text-lg font-black text-gray-900">99.9%</div>
						<div class="text-xs text-gray-500 font-medium">Uptime REST API SLA</div>
					</div>
				</div>
			</div>

			<!-- Fast Action Buttons -->
			<div class="flex flex-wrap items-center justify-center gap-3.5 mt-8">
				<a href="#section-widget-iframe" class="px-6 py-3.5 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-bold text-sm flex items-center gap-2 shadow-sm transition-all transform hover:-translate-y-0.5">
					<span class="material-symbols-outlined text-[19px]">code</span>
					<span>Lấy mã nhúng Widget</span>
				</a>
				<a href="#section-rest-api" class="px-5 py-3.5 rounded-xl bg-white border border-gray-300 text-gray-800 font-bold text-sm flex items-center gap-2 hover:bg-gray-50 transition-colors shadow-2xs">
					<span class="material-symbols-outlined text-[19px]">api</span>
					<span>Tài liệu REST API</span>
				</a>
				<a href="#section-register-partner" class="px-5 py-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 font-bold text-sm flex items-center gap-2 hover:bg-blue-100 transition-colors">
					<span class="material-symbols-outlined text-[19px]">handshake</span>
					<span>Đăng ký đối tác B2B</span>
				</a>
			</div>
		</div>
	</section>

	<!-- 3. B2B PARTNERSHIP ADVANTAGES -->
	<section class="max-w-[1200px] mx-auto px-4 mt-12">
		<div class="text-center max-w-2xl mx-auto mb-8">
			<span class="text-xs font-bold text-[#e60012] uppercase tracking-wider">Hợp Tác Toàn Diện</span>
			<h2 class="text-xl sm:text-3xl font-black text-gray-900 mt-1">Lợi Thế Khi Kết Nối Cùng PhoneX</h2>
			<p class="text-xs sm:text-sm text-gray-600 mt-2">Dù bạn sở hữu blog công nghệ, sàn thương mại, hay chuỗi cửa hàng bán lẻ, PhoneX mang lại giải pháp thu mua chìa khóa trao tay.</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
			<!-- Col 1 -->
			<div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-red-50 text-[#e60012] flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-[26px]">monetization_on</span>
				</div>
				<h3 class="text-base font-extrabold text-gray-900 mb-2">Tăng Doanh Thu &amp; Hoa Hồng Khủng</h3>
				<p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
					Nhận hoa hồng trực tiếp từ 300.000đ – 1.500.000đ trên mỗi máy thu mua thành công. Hệ thống tự động ghi nhận qua Partner ID &amp; Affiliate Tag, thanh toán minh bạch định kỳ ngày 05 và 20 hàng tháng.
				</p>
			</div>

			<!-- Col 2 -->
			<div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-[26px]">shield</span>
				</div>
				<h3 class="text-base font-extrabold text-gray-900 mb-2">Không Rủi Ro Vốn &amp; Hàng Tồn</h3>
				<p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
					Bạn chỉ cần đặt Widget hoặc nút Thu Cũ trên website. PhoneX chịu 100% trách nhiệm tiếp nhận thiết bị, kiểm định 30 bước, thanh toán tiền cho khách hàng và xử lý bảo hành hậu mãi.
				</p>
			</div>

			<!-- Col 3 -->
			<div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-xs hover:shadow-md transition-shadow">
				<div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-[26px]">sync_saved_locally</span>
				</div>
				<h3 class="text-base font-extrabold text-gray-900 mb-2">Dữ Liệu Giá Chuẩn Thời Gian Thực</h3>
				<p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
					Không lo báo sai giá cho khách. Bảng giá thu mua của hơn 300 model điện thoại từ iPhone, Samsung, Xiaomi, OPPO... được cập nhật liên tục từng giờ bám sát thị trường bán sỉ B2B toàn quốc.
				</p>
			</div>
		</div>
	</section>

	<!-- 4. NAVIGATION ANCHOR BAR -->
	<section class="max-w-[1200px] mx-auto px-4 mt-12 sticky top-16 z-20">
		<div class="bg-white/95 backdrop-blur-md border border-gray-200/90 rounded-2xl p-2 shadow-sm flex items-center gap-2 overflow-x-auto scrollbar-none">
			<a href="#section-widget-iframe" class="px-3.5 py-2 rounded-xl hover:bg-gray-100 text-xs font-bold text-gray-700 hover:text-gray-900 shrink-0 flex items-center gap-1.5 transition-colors">
				<span class="material-symbols-outlined text-[17px] text-[#e60012]">web</span>
				<span>1. Nhúng Iframe Widget</span>
			</a>
			<a href="#section-floating-widget" class="px-3.5 py-2 rounded-xl hover:bg-gray-100 text-xs font-bold text-gray-700 hover:text-gray-900 shrink-0 flex items-center gap-1.5 transition-colors">
				<span class="material-symbols-outlined text-[17px] text-blue-600">touch_app</span>
				<span>2. Nút Nổi Thông Minh</span>
			</a>
			<a href="#section-product-button" class="px-3.5 py-2 rounded-xl hover:bg-gray-100 text-xs font-bold text-gray-700 hover:text-gray-900 shrink-0 flex items-center gap-1.5 transition-colors">
				<span class="material-symbols-outlined text-[17px] text-emerald-600">shopping_bag</span>
				<span>3. Nút Thu Cũ Tại Shop</span>
			</a>
			<a href="#section-rest-api" class="px-3.5 py-2 rounded-xl hover:bg-gray-100 text-xs font-bold text-gray-700 hover:text-gray-900 shrink-0 flex items-center gap-1.5 transition-colors">
				<span class="material-symbols-outlined text-[17px] text-purple-600">code_blocks</span>
				<span>4. Tài Liệu REST API</span>
			</a>
			<a href="#section-webhooks" class="px-3.5 py-2 rounded-xl hover:bg-gray-100 text-xs font-bold text-gray-700 hover:text-gray-900 shrink-0 flex items-center gap-1.5 transition-colors">
				<span class="material-symbols-outlined text-[17px] text-amber-600">notifications_active</span>
				<span>5. Webhooks</span>
			</a>
			<a href="#section-register-partner" class="px-3.5 py-2 rounded-xl bg-red-50 text-[#e60012] hover:bg-red-100 text-xs font-black shrink-0 flex items-center gap-1.5 transition-colors ml-auto">
				<span class="material-symbols-outlined text-[17px]">badge</span>
				<span>Đăng Ký Mã Đối Tác</span>
			</a>
		</div>
	</section>

	<!-- 5. PHƯƠNG THỨC 1: NHÚNG IFRAME WIDGET ĐỊNH GIÁ -->
	<section id="section-widget-iframe" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8">
			<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-gray-100">
				<div>
					<div class="flex items-center gap-2">
						<span class="px-2.5 py-1 rounded-md bg-red-100 text-[#b7000c] text-xs font-black uppercase">Phương thức 1</span>
						<span class="text-xs text-gray-500 font-semibold">• Phổ biến nhất (Không cần viết code)</span>
					</div>
					<h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-2">Nhúng Widget Định Giá Thông Minh Lên Website</h2>
					<p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-2xl">
						Chỉ cần sao chép đoạn mã bên dưới và dán vào bất kỳ trang nào trên website (WordPress, Shopify, Web tự code, Landing Page). Khách hàng có thể tra cứu và định giá máy trực tiếp ngay trên trang của bạn.
					</p>
				</div>
				<button type="button" onclick="PhoneXGuide.toggleIframePreview()" id="btnTogglePreview" class="px-4 py-2.5 rounded-xl border border-gray-300 hover:border-gray-400 bg-gray-50 hover:bg-gray-100 text-xs font-bold text-gray-800 transition-colors flex items-center gap-1.5 self-start lg:self-auto shrink-0">
					<span class="material-symbols-outlined text-[18px]">visibility</span>
					<span id="labelTogglePreview">Xem thử Widget trực tiếp</span>
				</button>
			</div>

			<!-- Implementation Steps -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
					<div class="w-7 h-7 rounded-full bg-[#e60012] text-white font-black text-xs flex items-center justify-center mb-2">1</div>
					<div class="text-sm font-bold text-gray-900">Sao chép mã nhúng</div>
					<div class="text-xs text-gray-600 mt-1">Copy đoạn mã thẻ <code>&lt;iframe&gt;</code> chuẩn HTML bên dưới.</div>
				</div>
				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
					<div class="w-7 h-7 rounded-full bg-[#e60012] text-white font-black text-xs flex items-center justify-center mb-2">2</div>
					<div class="text-sm font-bold text-gray-900">Thay thế Partner ID</div>
					<div class="text-xs text-gray-600 mt-1">Điền mã đối tác của bạn vào tham số <code>partner=YOUR_ID</code> để ghi nhận hoa hồng.</div>
				</div>
				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
					<div class="w-7 h-7 rounded-full bg-[#e60012] text-white font-black text-xs flex items-center justify-center mb-2">3</div>
					<div class="text-sm font-bold text-gray-900">Dán vào trang web</div>
					<div class="text-xs text-gray-600 mt-1">Dán vào block HTML trên WordPress, Sidebar hoặc trang "Thu cũ đổi mới".</div>
				</div>
			</div>

			<!-- Embed Code Box -->
			<div class="relative rounded-2xl bg-gray-900 text-gray-100 p-4 sm:p-5 font-mono text-xs overflow-x-auto shadow-inner">
				<div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-800">
					<span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider flex items-center gap-1.5">
						<span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
						<span>HTML Iframe Embed Code (Chuẩn Responsive 100%)</span>
					</span>
					<button type="button" onclick="PhoneXGuide.copyCode('codeIframeEmbed', this)" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-white text-xs font-sans font-bold flex items-center gap-1.5 transition-colors cursor-pointer">
						<span class="material-symbols-outlined text-[15px]">content_copy</span>
						<span>Sao chép mã</span>
					</button>
				</div>
				<pre id="codeIframeEmbed" class="text-emerald-400 leading-relaxed overflow-x-auto whitespace-pre-wrap">&lt;!-- PhoneX Smart Buyback Valuation Widget --&gt;
&lt;iframe 
    src="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/?embed=true&amp;partner=PARTNER_DEMO_2026' ) ); ?>" 
    width="100%" 
    height="760" 
    frameborder="0" 
    style="border:none; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); max-width:100%; display:block; margin:0 auto;" 
    allow="clipboard-write"
    loading="lazy"
    title="Công cụ định giá điện thoại cũ PhoneX"&gt;
&lt;/iframe&gt;</pre>
			</div>

			<!-- Query Params Customization Table -->
			<div class="mt-6">
				<div class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Bảng tham số tùy biến giao diện Widget (URL Query Parameters):</div>
				<div class="overflow-x-auto">
					<table class="w-full text-xs text-left text-gray-700 border border-gray-200 rounded-xl overflow-hidden">
						<thead class="bg-gray-50 text-gray-900 uppercase font-bold text-[11px] border-b border-gray-200">
							<tr>
								<th class="p-3">Tham số</th>
								<th class="p-3">Kiểu</th>
								<th class="p-3">Mặc định</th>
								<th class="p-3">Mô tả tác vụ</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-100">
							<tr>
								<td class="p-3 font-mono font-bold text-blue-600">embed=true</td>
								<td class="p-3 font-mono">boolean</td>
								<td class="p-3 font-mono">true</td>
								<td class="p-3">Ẩn thanh menu Header &amp; Footer chính, chỉ hiển thị form định giá gọn gàng cho iframe.</td>
							</tr>
							<tr>
								<td class="p-3 font-mono font-bold text-blue-600">partner=YOUR_ID</td>
								<td class="p-3 font-mono">string</td>
								<td class="p-3 font-mono">default</td>
								<td class="p-3">Mã đối tác/affiliate của bạn do PhoneX cấp để đối soát và chi trả hoa hồng giới thiệu.</td>
							</tr>
							<tr>
								<td class="p-3 font-mono font-bold text-blue-600">brand=apple</td>
								<td class="p-3 font-mono">string</td>
								<td class="p-3 font-mono">all</td>
								<td class="p-3">Tự động lọc sẵn thương hiệu mong muốn (vd: <code>apple</code>, <code>samsung</code>, <code>xiaomi</code>, <code>oppo</code>).</td>
							</tr>
							<tr>
								<td class="p-3 font-mono font-bold text-blue-600">accent_color=e60012</td>
								<td class="p-3 font-mono">hex</td>
								<td class="p-3 font-mono">e60012</td>
								<td class="p-3">Tùy biến mã màu chủ đạo của nút bấm và viền để đồng bộ với nhận diện thương hiệu của bạn.</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Live Demo Preview Box (Collapsible) -->
			<div id="boxIframePreview" class="hidden mt-6 pt-6 border-t border-gray-100">
				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-200">
					<div class="flex items-center justify-between mb-3">
						<div class="flex items-center gap-2">
							<span class="w-3 h-3 rounded-full bg-red-400"></span>
							<span class="w-3 h-3 rounded-full bg-yellow-400"></span>
							<span class="w-3 h-3 rounded-full bg-green-400"></span>
							<span class="text-xs font-bold text-gray-700 ml-2">Mô phỏng hiển thị trên website đối tác:</span>
						</div>
						<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" target="_blank" class="text-xs text-[#e60012] font-bold hover:underline flex items-center gap-1">
							<span>Mở tab mới</span>
							<span class="material-symbols-outlined text-[14px]">open_in_new</span>
						</a>
					</div>
					<div class="bg-white rounded-xl shadow-xs border border-gray-200 p-2">
						<iframe 
							src="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/?embed=true&partner=DOCS_DEMO' ) ); ?>" 
							class="w-full h-[650px] rounded-lg border-0" 
							title="Live Preview Widget PhoneX">
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 6. PHƯƠNG THỨC 2: NHÚNG NÚT NỔI THÔNG MINH (FLOATING WIDGET) -->
	<section id="section-floating-widget" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8">
			<div class="pb-6 border-b border-gray-100">
				<div class="flex items-center gap-2">
					<span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-800 text-xs font-black uppercase">Phương thức 2</span>
					<span class="text-xs text-gray-500 font-semibold">• Tăng tương tác toàn trang mà không chiếm diện tích</span>
				</div>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-2">Nhúng Nút Nổi "Định Giá Thu Cũ" Góc Màn Hình (JS Snippet)</h2>
				<p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-3xl">
					Chèn 1 dòng mã JavaScript vào trước thẻ đóng <code>&lt;/body&gt;</code>. Một nút bấm nổi chuyên nghiệp sẽ xuất hiện cố định ở góc dưới màn hình. Khi khách bấm vào, hộp thoại định giá sẽ bung ra mượt mà dạng Modal Popup.
				</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 my-6 items-center">
				<div class="lg:col-span-7">
					<div class="relative rounded-2xl bg-gray-900 text-gray-100 p-4 sm:p-5 font-mono text-xs overflow-x-auto shadow-inner">
						<div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-800">
							<span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider">Mã Javascript tự động chèn trước &lt;/body&gt;</span>
							<button type="button" onclick="PhoneXGuide.copyCode('codeJsFloatingEmbed', this)" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-white text-xs font-sans font-bold flex items-center gap-1.5 transition-colors cursor-pointer">
								<span class="material-symbols-outlined text-[15px]">content_copy</span>
								<span>Sao chép mã</span>
							</button>
						</div>
						<pre id="codeJsFloatingEmbed" class="text-cyan-400 leading-relaxed overflow-x-auto whitespace-pre-wrap">&lt;!-- PhoneX Floating Trade-in Button --&gt;
&lt;script 
    src="<?php echo esc_url( home_url( '/wp-content/themes/phonex-theme/assets/js/phonex-widget.js' ) ); ?>" 
    data-partner="YOUR_PARTNER_CODE" 
    data-position="right-bottom" 
    data-text="Định Giá Bán Máy Cũ" 
    data-theme="#e60012" 
    async&gt;
&lt;/script&gt;</pre>
					</div>
				</div>

				<div class="lg:col-span-5 space-y-3">
					<div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100">
						<div class="text-xs font-bold text-blue-900 flex items-center gap-1.5">
							<span class="material-symbols-outlined text-[18px] text-blue-600">electric_bolt</span>
							<span>Kích thước siêu nhẹ: &lt; 4.8 KB</span>
						</div>
						<p class="text-xs text-blue-800 mt-1">Hoàn toàn không làm chậm tốc độ tải trang (Zero Google PageSpeed Impact). Chạy bất đồng bộ <code>async</code>.</p>
					</div>

					<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
						<div class="text-xs font-bold text-gray-900">Bấm thử nghiệm chức năng ngay trên trang này:</div>
						<button type="button" onclick="PhoneXGuide.triggerDemoModal()" class="mt-2.5 w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-[#e60012] to-[#b7000c] text-white text-xs font-bold flex items-center justify-center gap-2 shadow-xs hover:shadow-md transition-all">
							<span class="material-symbols-outlined text-[17px]">touch_app</span>
							<span>Thử mở Popup Định Giá Demo</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 7. PHƯƠNG THỨC 3: NÚT THU CŨ LÊN ĐỜI TRÊN TRANG CHI TIẾT SẢN PHẨM -->
	<section id="section-product-button" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8">
			<div class="pb-6 border-b border-gray-100">
				<div class="flex items-center gap-2">
					<span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 text-xs font-black uppercase">Phương thức 3</span>
					<span class="text-xs text-gray-500 font-semibold">• Dành cho các shop điện thoại &amp; sàn thương mại</span>
				</div>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-2">Nút "Thu Cũ Lên Đời - Trợ Giá Đến 3 Triệu" Tại Trang Sản Phẩm</h2>
				<p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-3xl">
					Tăng tỷ lệ chốt đơn bán máy mới trên website của bạn lên tới 40% bằng cách hỗ trợ khách hàng bán lại máy cũ để đổi máy mới ngay tại chỗ.
				</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-6 items-start">
				<!-- Code Example -->
				<div class="relative rounded-2xl bg-gray-900 text-gray-100 p-4 sm:p-5 font-mono text-xs overflow-x-auto shadow-inner">
					<div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-800">
						<span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider">HTML &amp; JS Nút Bấm Đặt Cạnh Nút Mua Hàng</span>
						<button type="button" onclick="PhoneXGuide.copyCode('codeTradeinBtnEmbed', this)" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-white text-xs font-sans font-bold flex items-center gap-1.5 transition-colors cursor-pointer">
							<span class="material-symbols-outlined text-[15px]">content_copy</span>
							<span>Sao chép</span>
						</button>
					</div>
					<pre id="codeTradeinBtnEmbed" class="text-yellow-300 leading-relaxed overflow-x-auto whitespace-pre-wrap">&lt;!-- Nút Thu Cũ Đổi Mới PhoneX --&gt;
&lt;button type="button" 
    class="phonex-tradein-btn"
    onclick="PhoneXTradeIn.open({
        targetProduct: 'iPhone 15 Pro Max 256GB',
        targetPrice: 28990000,
        subsidyAmount: 2000000,
        partnerId: 'YOUR_PARTNER_CODE'
    })"
    style="background:#fff1f0; color:#e60012; border:1px solid #ffccc7; padding:10px 16px; border-radius:12px; font-weight:bold; cursor:pointer; display:flex; items-center; gap:8px;"&gt;
    &lt;span&gt;🔄 Thu Cũ Lên Đời (Trợ giá đến 2.000.000đ)&lt;/span&gt;
&lt;/button&gt;</pre>
				</div>

				<!-- Live Preview of the Trade-in Card -->
				<div class="p-6 rounded-2xl bg-gray-50 border border-gray-200">
					<div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Minh họa hiển thị tại trang sản phẩm của shop:</div>
					<div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs space-y-3">
						<div class="flex items-center justify-between">
							<span class="text-sm font-bold text-gray-900">iPhone 16 Pro Max 256GB</span>
							<span class="text-base font-black text-[#e60012]">34.990.000đ</span>
						</div>
						<div class="flex gap-2">
							<button type="button" class="flex-1 py-2.5 rounded-xl bg-gray-900 text-white text-xs font-bold">Thêm Vào Giỏ</button>
							<button type="button" onclick="PhoneXGuide.triggerDemoTradeIn()" class="flex-1 py-2.5 rounded-xl bg-red-50 text-[#e60012] border border-red-200 text-xs font-bold flex items-center justify-center gap-1 hover:bg-red-100 transition-colors">
								<span class="material-symbols-outlined text-[16px]">sync_alt</span>
								<span>Thu Cũ Đổi Mới (-3Tr)</span>
							</button>
						</div>
						<div class="text-[11px] text-gray-500 text-center">Tích hợp giải pháp thanh toán &amp; thẩm định máy cũ PhoneX</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. PHƯƠNG THỨC 4: TÀI LIỆU REST API CHUYÊN SÂU (DEVELOPER DOCUMENTATION) -->
	<section id="section-rest-api" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8">
			<div class="pb-6 border-b border-gray-100">
				<div class="flex items-center gap-2">
					<span class="px-2.5 py-1 rounded-md bg-purple-100 text-purple-800 text-xs font-black uppercase">Phương thức 4</span>
					<span class="text-xs text-gray-500 font-semibold">• Dành cho Kỹ sư Lập trình &amp; Tích hợp Hệ thống (ERP/CRM/App)</span>
				</div>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-2">Tài Liệu PhoneX Buyback REST API v1.0</h2>
				<p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-3xl">
					Kết nối trực tiếp vào lõi định giá của PhoneX qua REST API chuẩn JSON. Bạn có thể xây dựng giao diện ứng dụng di động (Flutter, React Native, Swift), hệ thống nội bộ hoặc website độc lập.
				</p>
			</div>

			<!-- Base URL & Authentication -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
					<div class="text-xs font-bold text-gray-500 uppercase">Base API Endpoint (Production):</div>
					<div class="text-sm font-mono font-black text-gray-900 mt-1 flex items-center gap-2">
						<span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-xs font-bold">HTTPS</span>
						<span>https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1</span>
					</div>
				</div>

				<div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
					<div class="text-xs font-bold text-gray-500 uppercase">Xác thực (Authentication Header):</div>
					<div class="text-sm font-mono text-purple-700 mt-1 font-bold">
						X-PhoneX-Partner-Key: &lt;YOUR_SECRET_API_KEY&gt;
					</div>
				</div>
			</div>

			<!-- 6 Core API Endpoints Accordion / Tabs -->
			<div class="space-y-4">
				<div class="text-xs font-bold text-gray-900 uppercase tracking-wider">Danh Sách 6 Endpoints Cốt Lõi:</div>

				<!-- Endpoint 1 -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep1')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-blue-600 text-white font-mono text-xs font-black">GET</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/brands</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Lấy danh mục thương hiệu &amp; số model hỗ trợ</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep1" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Trả về danh sách tất cả các hãng điện thoại đang mở cổng thu mua (Apple, Samsung, Xiaomi, OPPO, vivo, realme...).</div>
						<div class="p-3 rounded-xl bg-gray-900 text-emerald-400 font-mono text-[11px] overflow-x-auto">
							<pre>// Example Response:
{
  "success": true,
  "count": 6,
  "data": [
    { "id": 1, "name": "Apple", "slug": "apple", "logo": "/assets/brands/apple.svg", "model_count": 128 },
    { "id": 2, "name": "Samsung", "slug": "samsung", "logo": "/assets/brands/samsung.svg", "model_count": 94 },
    { "id": 3, "name": "Xiaomi", "slug": "xiaomi", "logo": "/assets/brands/xiaomi.svg", "model_count": 48 }
  ]
}</pre>
						</div>
					</div>
				</div>

				<!-- Endpoint 2 -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep2')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-blue-600 text-white font-mono text-xs font-black">GET</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/models?brand=apple</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Lấy danh mục model kèm giá thu Grade A/B/C/D</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep2" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Trả về toàn bộ model thuộc thương hiệu được chỉ định kèm barem giá theo từng hạng thẩm định.</div>
						<div class="p-3 rounded-xl bg-gray-900 text-emerald-400 font-mono text-[11px] overflow-x-auto">
							<pre>// Example Response:
{
  "success": true,
  "brand": "apple",
  "data": [
    {
      "model_id": "iphone-15-pro-max-256gb",
      "name": "iPhone 15 Pro Max 256GB",
      "capacities": ["256GB", "512GB", "1TB"],
      "pricing": {
        "grade_a": 21500000,
        "grade_b": 19800000,
        "grade_c": 17500000,
        "grade_d": 14200000
      },
      "tradein_subsidy": 1500000
    }
  ]
}</pre>
						</div>
					</div>
				</div>

				<!-- Endpoint 3 -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep3')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-blue-600 text-white font-mono text-xs font-black">GET</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/search?keyword=iphone+15</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Tìm kiếm model nhanh (Autocomplete live search)</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep3" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Hỗ trợ tìm kiếm theo từ khóa có dấu hoặc không dấu, gợi ý tức thì sau 30ms.</div>
						<div class="p-3 rounded-xl bg-gray-900 text-emerald-400 font-mono text-[11px] overflow-x-auto">
							<pre>// cURL Test:
curl -X GET "https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/search?keyword=iphone+15"</pre>
						</div>
					</div>
				</div>

				<!-- Endpoint 4: POST /buyback/estimate -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep4')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-emerald-600 text-white font-mono text-xs font-black">POST</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/estimate</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Động cơ tính giá thu theo tình trạng phần cứng</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep4" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Gửi tình trạng máy khảo sát (màn hình, ngoại hình, pin, chức năng) để nhận mức giá định giá chính xác nhất.</div>
						<div class="p-3 rounded-xl bg-gray-900 text-cyan-400 font-mono text-[11px] overflow-x-auto">
							<pre>// Request Body (JSON):
{
  "model_slug": "iphone-15-pro-max",
  "capacity": "256GB",
  "body_grade": "grade_a",
  "screen_grade": "grade_a",
  "battery_health": "above_85",
  "origin": "vna",
  "partner_id": "PARTNER_CODE"
}

// Response Body (JSON):
{
  "success": true,
  "estimated_price": 21500000,
  "grade": "Grade A",
  "guarantee_valid_hours": 72,
  "tradein_subsidy": 1500000,
  "total_benefit": 23000000
}</pre>
						</div>
					</div>
				</div>

				<!-- Endpoint 5: POST /buyback/submit-request -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep5')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-emerald-600 text-white font-mono text-xs font-black">POST</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/submit-request</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Khởi tạo đơn thu mua / đẩy Lead vào CRM PhoneX</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep5" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Tạo phiếu thu mua chính thức, trả về mã phiếu tra cứu định dạng <code>PX-TM-YYMMDD-XXXX</code>.</div>
						<div class="p-3 rounded-xl bg-gray-900 text-yellow-300 font-mono text-[11px] overflow-x-auto">
							<pre>// Request Body:
{
  "customer_name": "Nguyễn Văn A",
  "customer_phone": "0901234567",
  "customer_address": "123 Lê Lợi, Quận 1, TP.HCM",
  "device_model": "iPhone 15 Pro Max 256GB",
  "estimated_price": 21500000,
  "partner_id": "PARTNER_CODE"
}

// Response:
{
  "success": true,
  "request_code": "PX-TM-261026-8892",
  "status": "pending_inspection",
  "message": "Phiếu thu mua đã được tạo thành công!"
}</pre>
						</div>
					</div>
				</div>

				<!-- Endpoint 6: GET /buyback/lookup -->
				<div class="border border-gray-200 rounded-2xl overflow-hidden">
					<div class="bg-gray-50 px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 cursor-pointer" onclick="PhoneXGuide.toggleApiDetails('api-ep6')">
						<div class="flex items-center gap-2.5">
							<span class="px-2.5 py-1 rounded-md bg-blue-600 text-white font-mono text-xs font-black">GET</span>
							<span class="font-mono text-xs sm:text-sm font-bold text-gray-900">/buyback/lookup?phone=0901234567</span>
							<span class="text-xs text-gray-500 hidden sm:inline">— Tra cứu trạng thái thẩm định &amp; giải ngân</span>
						</div>
						<span class="material-symbols-outlined text-gray-500 text-[18px]">expand_more</span>
					</div>
					<div id="api-ep6" class="p-4 bg-white text-xs space-y-2">
						<div class="text-gray-600">Cho phép đối tác hoặc khách hàng tra cứu thời gian thực trạng thái tiếp nhận, kết quả test 30 bước, và thời gian giải ngân tiền.</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- 9. WEBHOOKS & REALTIME NOTIFICATIONS -->
	<section id="section-webhooks" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8">
			<div class="pb-6 border-b border-gray-100">
				<div class="flex items-center gap-2">
					<span class="px-2.5 py-1 rounded-md bg-amber-100 text-amber-800 text-xs font-black uppercase">Webhooks</span>
					<span class="text-xs text-gray-500 font-semibold">• Đồng bộ hóa sự kiện hai chiều</span>
				</div>
				<h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-2">Webhook Thông Báo Biến Động Đơn Hàng Tự Động</h2>
				<p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-3xl">
					Cấu hình URL Webhook trên hệ thống của bạn để PhoneX chủ động bắn thông báo khi khách đến giao máy, khi kỹ thuật kiểm tra xong và khi tiền hoa hồng được duyệt.
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
				<div class="space-y-3">
					<div class="text-xs font-bold text-gray-900 uppercase">Các sự kiện Webhook được hỗ trợ:</div>
					
					<div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
						<span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[11px] font-bold shrink-0">lead.created</span>
						<div class="text-xs text-gray-700">Khách hàng hoàn tất nhập thông tin định giá và đặt lịch giao dịch.</div>
					</div>

					<div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
						<span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-mono text-[11px] font-bold shrink-0">inspection.done</span>
						<div class="text-xs text-gray-700">Kỹ thuật viên hoàn tất 30 bước test và chốt phân hạng Grade A/B/C/D.</div>
					</div>

					<div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
						<span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono text-[11px] font-bold shrink-0">order.paid</span>
						<div class="text-xs text-gray-700">Khách hàng nhận tiền thành công, giao dịch hoàn tất.</div>
					</div>

					<div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-start gap-3">
						<span class="px-2 py-0.5 rounded bg-red-100 text-red-800 font-mono text-[11px] font-bold shrink-0">commission.approved</span>
						<div class="text-xs text-gray-700">Hoa hồng tương ứng được ghi nhận vào ví đối tác của bạn.</div>
					</div>
				</div>

				<div class="relative rounded-2xl bg-gray-900 text-gray-100 p-4 font-mono text-xs overflow-x-auto shadow-inner">
					<div class="text-gray-400 font-semibold text-[11px] uppercase pb-2 mb-2 border-b border-gray-800">
						Payload JSON mẫu gửi đến Webhook URL của bạn:
					</div>
					<pre class="text-emerald-400 leading-relaxed overflow-x-auto whitespace-pre-wrap">{
  "event": "commission.approved",
  "timestamp": 1792998400,
  "partner_id": "PARTNER_2026",
  "data": {
    "request_code": "PX-TM-261026-8892",
    "device": "iPhone 15 Pro Max 256GB",
    "final_grade": "Grade A",
    "buyback_amount": 21500000,
    "commission_rate": "4%",
    "commission_amount": 860000,
    "payout_schedule": "2026-11-05"
  }
}</pre>
				</div>
			</div>
		</div>
	</section>

	<!-- 10. ĐĂNG KÝ MÃ ĐỐI TÁC & HỖ TRỢ KỸ THUẬT -->
	<section id="section-register-partner" class="max-w-[1200px] mx-auto px-4 mt-12 scroll-mt-28">
		<div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white shadow-xl">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
				<div class="lg:col-span-7 space-y-4">
					<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wider border border-red-500/30">
						<span class="material-symbols-outlined text-[16px]">support_agent</span>
						<span>Kênh Hỗ Trợ Kỹ Thuật Viên B2B PhoneX</span>
					</div>
					<h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
						Bạn Cần Cấp Mã Đối Tác Hoặc Hỗ Trợ Tích Hợp?
					</h2>
					<p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
						Đội ngũ Kỹ sư Giải pháp của PhoneX sẽ trực tiếp hỗ trợ bạn cài đặt Widget, tích hợp API vào hệ thống hoặc tùy biến giao diện theo đúng yêu cầu riêng trong vòng 2 giờ làm việc.
					</p>

					<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
						<div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center gap-3">
							<span class="material-symbols-outlined text-[#e60012] text-[24px]">call</span>
							<div>
								<div class="text-[11px] text-gray-400">Hotline Kỹ thuật B2B (Miễn phí)</div>
								<a href="tel:18006869" class="text-sm font-black text-white hover:text-red-400">1800.6869 (Nhánh 2)</a>
							</div>
						</div>

						<div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center gap-3">
							<span class="material-symbols-outlined text-blue-400 text-[24px]">mail</span>
							<div>
								<div class="text-[11px] text-gray-400">Email Phòng Phát Triển Đối Tác</div>
								<a href="mailto:api@phonex.vn" class="text-sm font-black text-white hover:text-blue-400">api@phonex.vn</a>
							</div>
						</div>
					</div>
				</div>

				<div class="lg:col-span-5 bg-white text-gray-900 p-6 rounded-2xl shadow-lg">
					<h3 class="text-base font-extrabold text-gray-900 mb-1">Đăng Ký Nhận API Key Miễn Phí</h3>
					<p class="text-xs text-gray-500 mb-4">Điền thông tin để nhận Partner ID &amp; Token Test ngay.</p>

					<form id="formPartnerRegister" onsubmit="PhoneXGuide.submitPartnerForm(event)" class="space-y-3">
						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Tên website / Đơn vị của bạn *</label>
							<input type="text" required placeholder="vd: dienthoaigiakho.vn, Tinhte..." class="w-full h-10 px-3 rounded-xl border border-gray-300 text-xs focus:border-[#e60012] focus:ring-1 focus:ring-red-200 outline-none">
						</div>

						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại / Zalo kỹ thuật *</label>
							<input type="tel" required placeholder="vd: 0901234567" class="w-full h-10 px-3 rounded-xl border border-gray-300 text-xs focus:border-[#e60012] focus:ring-1 focus:ring-red-200 outline-none">
						</div>

						<div>
							<label class="block text-xs font-bold text-gray-700 mb-1">Hình thức muốn kết nối</label>
							<select class="w-full h-10 px-3 rounded-xl border border-gray-300 text-xs focus:border-[#e60012] outline-none">
								<option value="widget">1. Nhúng Iframe Widget định giá</option>
								<option value="floating">2. Nút nổi JavaScript góc màn hình</option>
								<option value="api">3. Tích hợp REST API chuyên sâu</option>
								<option value="all">4. Cần tư vấn giải pháp tổng thể</option>
							</select>
						</div>

						<button type="submit" class="w-full py-3 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white text-xs font-black shadow-md transition-all flex items-center justify-center gap-1.5 cursor-pointer">
							<span class="material-symbols-outlined text-[17px]">send</span>
							<span>Gửi yêu cầu kích hoạt API</span>
						</button>
						<div id="partnerFormFeedback" class="hidden text-xs text-center font-bold text-emerald-600 mt-2"></div>
					</form>
				</div>
			</div>
		</div>
	</section>

</main>

<!-- Interactive Script for Copy & Toggles -->
<script>
window.PhoneXGuide = {
	copyCode: function(elementId, btn) {
		var text = document.getElementById(elementId).innerText;
		navigator.clipboard.writeText(text).then(function() {
			var orig = btn.innerHTML;
			btn.innerHTML = '<span class="material-symbols-outlined text-[15px]">check</span><span>Đã chép!</span>';
			btn.classList.add('bg-emerald-700');
			setTimeout(function() {
				btn.innerHTML = orig;
				btn.classList.remove('bg-emerald-700');
			}, 2000);
		});
	},
	toggleIframePreview: function() {
		var box = document.getElementById('boxIframePreview');
		var lbl = document.getElementById('labelTogglePreview');
		if (box.classList.contains('hidden')) {
			box.classList.remove('hidden');
			lbl.innerText = 'Ẩn xem thử Widget';
			box.scrollIntoView({ behavior: 'smooth' });
		} else {
			box.classList.add('hidden');
			lbl.innerText = 'Xem thử Widget trực tiếp';
		}
	},
	toggleApiDetails: function(id) {
		var el = document.getElementById(id);
		if (el) {
			el.classList.toggle('hidden');
		}
	},
	triggerDemoModal: function() {
		alert('Tính năng Demo: Khi tích hợp mã JS vào website của bạn, một Modal Popup tương tác định giá 30 giây sẽ mở ra tức thì tại vị trí này!');
	},
	triggerDemoTradeIn: function() {
		alert('Tính năng Demo: Khách hàng bấm Thu Cũ Đổi Mới sẽ được chuyển tiếp kèm mã trợ giá 3.000.000đ từ PhoneX sang trang định giá!');
	},
	submitPartnerForm: function(e) {
		e.preventDefault();
		var fb = document.getElementById('partnerFormFeedback');
		fb.innerText = 'Đăng ký thành công! Kỹ thuật viên PhoneX sẽ liên hệ hỗ trợ cấp API Key trong 15 phút.';
		fb.classList.remove('hidden');
		e.target.reset();
	}
};
</script>

<?php
get_footer();
