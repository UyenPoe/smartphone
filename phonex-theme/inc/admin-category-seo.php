<?php
/**
 * PhoneX Category SEO Content Management (Thông tin ngành hàng - Chuẩn TGDD)
 *
 * Cho phép quản trị viên nhập bài viết SEO chuyên sâu cho từng Danh Mục Sản Phẩm (WooCommerce),
 * đặc biệt là danh mục Điện Thoại theo phong cách Thế Giới Di Động.
 *
 * Tính năng chính:
 * - Tích hợp đầy đủ vào màn hình Sửa Danh Mục (Sản phẩm > Danh mục > Chỉnh sửa)
 * - Tích hợp bộ tải ảnh WordPress Media Library (wp.media): Chọn ảnh, xem trước, chèn 1-click vào bài viết
 * - Tích hợp trang quản trị riêng: Sản phẩm > 📝 Thông tin ngành hàng
 * - Tích hợp Meta Box trong trang Sửa Trang (Page ID 50 / template-phones.php)
 * - Tự động tạo Bảng mục lục nội dung chính (Table of Contents) với hiệu ứng cuộn mượt
 * - Hiệu ứng Xem thêm / Thu gọn với dải mờ gradient chuẩn TGDD
 * - Màu sắc chuẩn hệ thống thương hiệu PhoneX:
 *   🔵 Primary: #e60012 | 🔷 Dark: #b7000c | 🟦 Light: #ffdad5
 *   🔴 Sale: #e60012 | 🟠 Khuyến mãi: #FF9800 | 🟢 Còn hàng: #198754
 *   ⚫ Chữ chính: #222222 | 🩶 Chữ phụ: #5f5e5e | ◻️ Nền section: #f8f9fb | Border: #E5E7EB
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue WordPress Media Uploader scripts & styles for Category and Admin pages
 */
function phonex_category_seo_admin_assets( $hook ) {
	$screen = get_current_screen();
	$is_cat_edit = ( $screen && 'edit-tags' === $screen->base && 'product_cat' === $screen->taxonomy ) || ( $screen && 'term' === $screen->base && 'product_cat' === $screen->taxonomy );
	$is_seo_page = isset( $_GET['page'] ) && 'phonex-industry-seo' === $_GET['page'];
	$is_page_edit = ( $screen && 'page' === $screen->post_type );

	if ( $is_cat_edit || $is_seo_page || $is_page_edit ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'phonex_category_seo_admin_assets' );

/**
 * Get default SEO article data for "Điện Thoại" matching TGDD structure
 */
function phonex_get_default_category_seo_data() {
	$badge_title = 'THÔNG TIN NGÀNH HÀNG';
	$sapo        = 'Trong kỷ nguyên công nghệ số, <strong>điện thoại</strong> di động đã trở thành một phần không thể thiếu trong cuộc sống của mỗi người. Từ liên lạc, tra cứu thông tin đến chụp ảnh, quay phim, giải trí, điện thoại ngày càng chứng minh vai trò quan trọng và tiện dụng của mình. Với thiết kế nhỏ gọn, điện thoại đã trở thành vật mang theo bên mình không thể thiếu. Vậy làm thế nào để lựa chọn được một chiếc điện thoại phù hợp giữa vô vàn sản phẩm trên thị trường? Bài viết này sẽ cung cấp những thông tin hữu ích, giúp bạn trở thành người mua hàng thông thái.';

	$content = <<<HTML
<h2 id="seo-section-1">1. Điện thoại - Thiết bị liên lạc và giải trí</h2>
<p>Điện thoại ngày nay không chỉ phục vụ nghe gọi mà đã trở thành thiết bị cá nhân gắn liền với học tập, làm việc, giải trí, chụp ảnh, thanh toán và kết nối hàng ngày. Từ những smartphone phổ thông dễ tiếp cận đến flagship, điện thoại gaming và thiết bị màn hình gập, người dùng có thể lựa chọn sản phẩm dựa trên ngân sách, thói quen sử dụng và những tính năng thực sự cần thiết.</p>

<p>Thị trường hiện có sự góp mặt của nhiều thương hiệu lớn như <strong>Apple, Samsung, OPPO, Xiaomi, vivo, HONOR, realme và Nothing Phone</strong>. Mỗi hãng xây dựng những dòng sản phẩm với thế mạnh riêng: iPhone chú trọng trải nghiệm iOS và hệ sinh thái Apple; Samsung có danh mục Galaxy rất rộng từ phổ thông đến cao cấp và màn hình gập; OPPO, vivo tập trung nhiều vào thiết kế, camera và trải nghiệm người dùng; Xiaomi, realme mang đến nhiều lựa chọn về cấu hình; trong khi HONOR phát triển mạnh ở pin, độ bền, nhiếp ảnh AI và smartphone gập.</p>

<p>Các thế hệ mới cũng cho thấy điện thoại đang chuyển dần từ cuộc đua thông số sang trải nghiệm tổng thể. Trí tuệ nhân tạo được tích hợp sâu hơn vào tìm kiếm, camera và xử lý nội dung; pin dung lượng lớn xuất hiện trên nhiều thiết bị nhưng thân máy vẫn được tối ưu độ mỏng; màn hình OLED tần số quét cao ngày càng phổ biến và điện thoại gập tiếp tục được hoàn thiện để dễ sử dụng hơn trong đời sống hàng ngày.</p>

<h2 id="seo-section-2">2. Các thương hiệu điện thoại phổ biến hiện nay</h2>

<h3 id="seo-section-2-1">Apple iPhone: trải nghiệm iOS và hệ sinh thái đồng bộ</h3>
<p><strong>iPhone</strong> là dòng điện thoại của Apple, sử dụng hệ điều hành iOS và được thiết kế để kết nối chặt chẽ với các sản phẩm như Macbook, iPad, Apple Watch và AirPods. Danh mục thế hệ hiện tại có iPhone 17, iPhone 16 đáp ứng từ nhu cầu sử dụng hàng ngày đến chụp ảnh, quay video và xử lý những tác vụ chuyên sâu hơn.</p>
<p>Điểm nổi bật của iPhone nằm ở sự kết hợp giữa phần cứng, hệ điều hành và hệ sinh thái. Những thế hệ mới tiếp tục được nâng cấp về màn hình, chip xử lý, hệ thống camera và <strong>Apple Intelligence</strong>. Đây là lựa chọn phù hợp với người đã sử dụng nhiều thiết bị Apple hoặc muốn một trải nghiệm phần mềm nhất quán trong thời gian dài.</p>

<div class="my-4 text-center">
  <img src="https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg" alt="Apple iPhone thế hệ mới tại PhoneX" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Apple iPhone chính hãng VN/A nguyên seal tại PhoneX</p>
</div>

<h3 id="seo-section-2-2">Samsung Galaxy: danh mục rộng từ phổ thông đến điện thoại gập</h3>
<p><strong>Samsung</strong> có danh mục sản phẩm trải rộng với: <strong>Galaxy A</strong> ở phân khúc phổ thông và tầm trung; <strong>Galaxy S</strong> ở nhóm cao cấp; cùng <strong>Galaxy Z</strong> dành cho thiết bị màn hình gập. Nhờ đó, người dùng có thể lựa chọn thiết bị dựa trên ngân sách mà vẫn duy trì trải nghiệm quen thuộc qua giao diện One UI và hệ sinh thái Galaxy.</p>
<p>Galaxy S25 Series hiện đại diện cho nhóm flagship với hiệu năng, camera và Galaxy AI, trong khi Galaxy Z Flip/Fold6 Series mở rộng trải nghiệm bảng màn hình gập. Samsung cũng có nhiều lựa chọn Galaxy A dành cho học tập, làm việc và giải trí hàng ngày.</p>

<div class="my-4 text-center">
  <img src="https://cdn.tgdd.vn/Products/Images/42/368236/motorola-razr-fold-trang-thumb-600x600.jpg" alt="Samsung Galaxy và Smartphone màn hình gập" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Smartphone thiết kế đột phá, nâng tầm trải nghiệm</p>
</div>

<h3 id="seo-section-2-3">OPPO: thiết kế hiện đại và camera dễ sử dụng</h3>
<p><strong>OPPO</strong> phát triển nhiều dòng sản phẩm như <strong>OPPO A Series, OPPO Reno Series và OPPO Find X Series</strong>. Dòng A thường tập trung vào nhu cầu sử dụng phổ thông; Reno hướng đến thiết kế, camera chân dung và sáng tạo nội dung; trong khi Find X được trang bị những công nghệ camera, màn hình và hiệu năng cao cấp hơn.</p>
<p>Thế hệ hiện tại có Reno13 Series, cùng Find X8 Series, tiếp tục nhấn mạnh vào trải nghiệm nhiếp ảnh, thiết kế và ColorOS. OPPO phù hợp với người quan tâm đến camera, khả năng quay chụp nhanh và một giao diện Android có nhiều tính năng tiện dụng.</p>

<h3 id="seo-section-2-4">Xiaomi: nhiều lựa chọn cấu hình trong từng phân khúc</h3>
<p><strong>Xiaomi</strong> mang đến nhiều mẫu máy với cấu hình mạnh so với mức giá, từ Redmi giá rẻ đến Xiaomi số cao cấp. Máy thường được trang bị chip xử lý tốt, pin lớn và màn hình tần số quét cao, phù hợp cho học sinh, sinh viên và game thủ.</p>

<h3 id="seo-section-2-5">vivo: chú trọng camera, thiết kế và trải nghiệm chân dung</h3>
<p>vivo khẳng định thế mạnh với dòng V-series chuyên chụp ảnh chân dung studio, hệ thống Aura Light độc quyền và thiết kế siêu mỏng nhẹ, mang đến trải nghiệm thời trang và phong cách.</p>

<h3 id="seo-section-2-6">HONOR: pin lớn, độ bền và nhiều tính năng AI</h3>
<p>HONOR nổi tiếng với công nghệ pin Silicon-Carbon dung lượng khủng, màn hình chống rơi vỡ chuẩn 5 sao và giao diện MagicOS mượt mà với nhiều trợ lý AI thông minh.</p>

<h3 id="seo-section-2-7">realme: hướng đến hiệu năng và người dùng trẻ</h3>
<p>realme mang ngôn ngữ thiết kế trẻ trung, sạc siêu tốc SuperVOOC và cấu hình bứt phá trong phân khúc giá phổ thông đến tầm trung.</p>

<h2 id="seo-section-3">3. Các nhóm điện thoại phổ biến và đặc trưng của từng phân khúc</h2>
<ul>
  <li><strong>Điện thoại phổ thông (Dưới 4 triệu):</strong> Đáp ứng tốt những nhu cầu thiết yếu như nghe gọi, Zalo, YouTube, lướt web và pin dùng cả ngày.</li>
  <li><strong>Điện thoại tầm trung (4 - 10 triệu):</strong> Cân bằng giữa cấu hình, màn hình AMOLED 120Hz mượt mà, camera sắc nét và pin sạc nhanh 45W - 67W.</li>
  <li><strong>Điện thoại cận cao cấp (10 - 15 triệu):</strong> Tiếp cận nhiều trải nghiệm flagship về chip xử lý mạnh mẽ, khung viền kim loại và camera chống rung OIS.</li>
  <li><strong>Điện thoại cao cấp (Trên 15 triệu):</strong> Ưu tiên trải nghiệm toàn diện từ vật liệu Titan, chip đỉnh cao, camera tiềm vọng zoom xa và trí tuệ nhân tạo AI.</li>
  <li><strong>Điện thoại màn hình gập:</strong> Mở rộng không gian hiển thị linh hoạt, biến chiếc điện thoại bỏ túi thành một máy tính bảng thu nhỏ.</li>
  <li><strong>Điện thoại gaming:</strong> Tối ưu tản nhiệt, tần số quét cực cao và hiệu năng giữ vững trong thời gian dài thi đấu game.</li>
</ul>

<h2 id="seo-section-4">4. Những công nghệ đáng chú ý trên điện thoại hiện nay</h2>
<ul>
  <li><strong>AI tham gia sâu hơn vào trải nghiệm:</strong> Trợ lý tìm kiếm khoanh tròn (Circle to Search), dịch thuật cuộc gọi trực tiếp, xóa vật thể ảnh thông minh.</li>
  <li><strong>Màn hình OLED và tần số quét 120Hz - 144Hz:</strong> Cho màu sắc sống động, độ đen sâu và cuộn lướt siêu mượt.</li>
  <li><strong>Pin dung lượng ngày càng lớn nhưng thân máy vẫn gọn:</strong> Công nghệ pin mật độ cao giúp máy giữ độ mỏng ấn tượng dù pin lên tới 5000mAh - 6000mAh.</li>
  <li><strong>Sạc siêu nhanh:</strong> Công nghệ sạc từ 67W đến 120W giúp nạp đầy pin chỉ trong 20 - 30 phút.</li>
  <li><strong>Camera xử lý thực tế qua thuật toán ISP:</strong> Tái hiện màu da chân thực, chụp đêm sắc nét và quay video HDR chuẩn điện ảnh.</li>
  <li><strong>NFC và eSIM:</strong> Tiện lợi cho thanh toán một chạm (Apple Pay, Google Wallet) và kích hoạt gói cước không cần thẻ SIM vật lý.</li>
</ul>

<h2 id="seo-section-5">5. Những tiêu chí quan trọng khi chọn mua điện thoại</h2>
<ul>
  <li><strong>Hiệu năng:</strong> Chọn chip xử lý dựa trên nhu cầu học tập, làm việc văn phòng hay chơi game đồ họa cao.</li>
  <li><strong>RAM:</strong> 6GB - 8GB cho nhu cầu cơ bản mượt mà; 12GB - 16GB cho đa nhiệm nặng và xử lý tác vụ AI.</li>
  <li><strong>Bộ nhớ trong:</strong> Tối thiểu 128GB cho hiện tại; nên chọn 256GB trở lên nếu có nhu cầu lưu trữ lâu dài trong 3 - 5 năm tới.</li>
  <li><strong>Màn hình:</strong> Cân bằng giữa kích thước cầm nắm (6.1 inch đến 6.7 inch) và chất lượng hiển thị sắc nét.</li>
  <li><strong>Camera:</strong> Chọn theo loại ảnh thường chụp (chân dung, phong cảnh góc rộng hay zoom tele xa).</li>
  <li><strong>Pin và sạc:</strong> Đảm bảo thời lượng sử dụng thoải mái trọn vẹn cả ngày dài làm việc.</li>
  <li><strong>Hệ điều hành & Hệ sinh thái:</strong> Chọn iOS nếu thích tính ổn định, dễ dùng; chọn Android nếu yêu thích tùy biến và đa dạng thương hiệu.</li>
  <li><strong>Độ bền & Chống nước:</strong> Tiêu chuẩn kháng nước kháng bụi IP68 mang lại sự yên tâm tuyệt đối khi sử dụng trời mưa.</li>
</ul>

<h2 id="seo-section-6">6. Mua điện thoại giá tốt, chính hãng tại PhoneX</h2>
<p>Tại <strong>PhoneX</strong>, tất cả điện thoại đều cam kết 100% chính hãng, nguyên seal mới với chế độ bảo hành 12 tháng toàn quốc, chính sách 1 đổi 1 trong 30 ngày nếu có lỗi từ nhà sản xuất, hỗ trợ trả góp 0% lãi suất và dịch vụ giao hàng hỏa tốc trong 1 giờ.</p>

<h2 id="seo-section-7">7. Câu hỏi thường gặp khi mua điện thoại</h2>
<div class="space-y-3 my-4">
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Nên mua điện thoại bao nhiêu GB để sử dụng lâu dài?</strong>
    <p class="text-gray-600 text-sm">Dung lượng 256GB hiện là tiêu chuẩn vàng cho người dùng muốn sử dụng ổn định từ 3 - 4 năm mà không lo đầy bộ nhớ khi quay phim, chụp ảnh và cập nhật hệ điều hành.</p>
  </div>
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Điện thoại RAM bao nhiêu là đủ?</strong>
    <p class="text-gray-600 text-sm">Với iPhone, 6GB - 8GB RAM đã rất mượt mà nhờ tối ưu của iOS. Với Android, khuyến nghị từ 8GB RAM trở lên để đảm bảo máy không phải load lại ứng dụng chạy ngầm.</p>
  </div>
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Có nên mua điện thoại 5G không?</strong>
    <p class="text-gray-600 text-sm">Rất nên mua, vì mạng 5G hiện đã được các nhà mạng Việt Nam phủ sóng thương mại rộng khắp, mang lại tốc độ truy cập internet nhanh gấp 10 lần so với 4G.</p>
  </div>
</div>
HTML;

	return array(
		'badge_title' => $badge_title,
		'sapo'        => $sapo,
		'content'     => $content,
		'enable_toc'  => true,
		'img_1'       => 'https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg',
		'img_2'       => 'https://cdn.tgdd.vn/Products/Images/42/368236/motorola-razr-fold-trang-thumb-600x600.jpg',
		'img_3'       => 'https://cdn.tgdd.vn/Products/Images/42/369628/xiaomi-redmi-note-17-pro-max-5g-purple-thumb-600x600.jpg',
	);
}

/**
 * Default SEO content for "Điện Thoại Cũ Giá Tốt / Máy Cũ 99%" (Category: used, term 21)
 *
 * @return array
 */
function phonex_get_default_used_phone_seo_data() {
	$badge_title = 'THÔNG TIN NGÀNH HÀNG ĐIỆN THOẠI CŨ';
	$sapo        = 'Điện thoại cũ giá tốt (Pre-Owned / Like New 99%) tại PhoneX là giải pháp thông minh giúp bạn sở hữu các dòng flagship cao cấp (iPhone, Samsung Galaxy, Xiaomi...) với mức giá tiết kiệm từ 30% đến 50% so với máy mới xuất xưởng. Toàn bộ thiết bị đều trải qua quy trình thẩm định 45 bước chuyên sâu của Apple Certified Hardware Specialist, cam kết nguyên bản 100% (Zin All), ngoại hình đẹp như mới và hưởng chế độ bảo hành VIP 1 đổi 1 trong 30 ngày độc quyền.';

	$content = <<<HTML
<h2 id="used-section-1">1. Điện thoại cũ là gì? Tại sao nên mua điện thoại cũ tại PhoneX?</h2>
<p><strong>Điện thoại cũ</strong> (hay còn gọi là điện thoại đã qua sử dụng, Like New, Pre-Owned) là những chiếc smartphone chính hãng đã qua một thời gian sử dụng ngắn từ người dùng trước, hoặc là các sản phẩm trưng bày, đổi trả trong thời hạn bảo hành. Thay vì phải chi trả toàn bộ số tiền lớn cho một chiếc máy mới vừa bóc seal, việc chọn mua điện thoại cũ mang lại hàng loạt lợi thế vượt trội:</p>
<ul>
  <li><strong>Tiết kiệm từ 30% - 50% chi phí:</strong> Bạn có thể dễ dàng tiếp cận các mẫu flagship đình đám nhất (như iPhone 15 Pro Max, Galaxy S24 Ultra, Xiaomi 14 Ultra) với mức giá chỉ bằng một chiếc máy tầm trung.</li>
  <li><strong>Khấu hao thấp, giữ giá tốt:</strong> Smartphone mới thường mất giá từ 15% - 25% ngay sau khi bóc hộp. Với điện thoại cũ, biên độ khấu hao cực kỳ thấp, giúp bạn thuận lợi hơn khi muốn lên đời hoặc bán lại sau này.</li>
  <li><strong>Chất lượng và độ bền nguyên bản:</strong> Tại hệ thống 128 Showroom của PhoneX, 100% điện thoại cũ đều cam kết "Zin All" nguyên bản, chưa từng qua sửa chữa ép kính hay thay thế linh kiện trôi nổi.</li>
</ul>

<div class="my-4 text-center">
  <img src="https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg" alt="Điện thoại cũ đẹp như mới tại PhoneX" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Mỗi chiếc điện thoại cũ tại PhoneX đều được chụp ảnh thật và kiểm tra độc bản theo từng số IMEI</p>
</div>

<h2 id="used-section-2">2. Bảng phân loại chất lượng điện thoại cũ tại PhoneX</h2>
<p>Để đảm bảo tính minh bạch tuyệt đối, PhoneX phân loại chi tiết tình trạng ngoại hình và pin theo tiêu chuẩn quốc tế:</p>

<h3 id="used-section-2-1">Grade A (Đẹp 99% - Like New Tuyển Chọn)</h3>
<p>Đây là nhóm sản phẩm cao cấp nhất. Thân máy và viền gần như mới tinh, không cấn móp, không trầy xước. Màn hình sáng bóng, phủ nano chống bám vân tay zin. Dung lượng pin thực tế dao động từ <strong>90% đến 100%</strong>, số chu kỳ sạc rất ít. Thích hợp cho người dùng khó tính yêu cầu ngoại hình hoàn hảo.</p>

<h3 id="used-section-2-2">Grade B (Đẹp 97% - 98% Zin Nguyên Bản)</h3>
<p>Máy có xuất hiện một vài vết xước dăm siêu mảnh ở khung viền hoặc mặt lưng qua quá trình sử dụng thông thường, nhưng tuyệt đối không cấn móp nặng hay nứt vỡ. Mọi linh kiện bên trong cam kết zin 100%, chức năng hoạt động hoàn hảo. Nhóm này có mức giá rẻ hơn Grade A từ 1.000.000₫ đến 2.500.000₫, cực kỳ kinh tế.</p>

<h3 id="used-section-2-3">Hàng Fullbox Trùng IMEI &amp; Còn Bảo Hành Hãng</h3>
<p>Nhiều mẫu máy cũ tại PhoneX vẫn còn đầy đủ hộp nguyên bản trùng IMEI máy, kèm cáp sạc zin bóc hộp và còn thời hạn bảo hành chính hãng AppleCare hoặc Samsung Care+ dài hạn.</p>

<h2 id="used-section-3">3. Quy chuẩn kiểm định độc bản 45 bước kỹ thuật tại PhoneX Lab</h2>
<p>Khác biệt hoàn toàn với thị trường trôi nổi, mỗi chiếc điện thoại cũ tại PhoneX đều phải trải qua và vượt qua 45 bài test khắt khe trước khi được niêm yết lên kệ:</p>
<ul>
  <li><strong>12 Bài test màn hình &amp; cảm ứng:</strong> Kiểm tra cảm ứng đa điểm 10 ngón, độ sáng đỉnh nits, tính năng TrueTone, tần số quét 120Hz ProMotion và đảm bảo không có điểm chết (Dead Pixel) hay ám ố.</li>
  <li><strong>11 Bài test Camera &amp; Cảm biến:</strong> Thử nghiệm chống rung quang học OIS, zoom tiềm vọng, cảm biến LiDAR, Face ID nhận diện 3D siêu nhạy dưới mọi điều kiện ánh sáng.</li>
  <li><strong>12 Bài test Bo mạch &amp; Chống nước:</strong> Đo áp suất viền đảm bảo chuẩn chống nước IP68, kiểm tra giấy quỳ chỉ thị ẩm trắng tinh, test modem 5G, Wi-Fi 7 và sạc nhanh Type-C/MagSafe.</li>
  <li><strong>10 Bài test Hiệu năng &amp; Pin:</strong> Đo dung lượng pin chuẩn qua phần mềm Apple Diagnostics, test tải nặng liên tục trong 30 phút để kiểm tra nhiệt độ tản nhiệt và mức tiêu hao nguồn khi ở chế độ chờ.</li>
</ul>

<div class="my-4 text-center">
  <img src="https://cdn.tgdd.vn/Products/Images/42/367339/samsung-galaxy-s26-ultra-den-thumb-600x600.jpg" alt="Thẩm định chất lượng điện thoại cũ tại PhoneX Lab" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Quy trình thẩm định 45 bước nghiêm ngặt được thực hiện bởi kỹ thuật viên Apple Certified Hardware</p>
</div>

<h2 id="used-section-4">4. Các thương hiệu điện thoại cũ được săn đón nhiều nhất</h2>

<h3 id="used-section-4-1">iPhone Cũ: Hệ sinh thái mượt mà, giữ giá vô địch</h3>
<p><strong>iPhone cũ</strong> luôn là sự lựa chọn số 1 trên thị trường nhờ sự hỗ trợ cập nhật phần mềm lâu dài từ 5 - 7 năm của Apple. Các model bán chạy nhất gồm có: <strong>iPhone 16 Pro Max, iPhone 15 Pro Max, iPhone 14 Pro Max và iPhone 13 Pro Max</strong>. Máy chạy mượt mà, camera quay video chuẩn điện ảnh và đồng bộ tuyệt vời cùng MacBook, Apple Watch.</p>

<h3 id="used-section-4-2">Samsung Galaxy Cũ: Màn hình Dynamic AMOLED đỉnh cao và Galaxy AI</h3>
<p>Với dòng Android, <strong>Samsung Galaxy cũ</strong> (đặc biệt là Galaxy S24 Ultra, S23 Ultra hay dòng màn hình gập Galaxy Z Fold5) mang lại trải nghiệm hiển thị mãn nhãn, camera zoom xa 100x và tính năng trí tuệ nhân tạo Galaxy AI thời thượng với mức giá vô cùng dễ chịu.</p>

<h3 id="used-section-4-3">Xiaomi, OPPO &amp; Google Pixel Cũ: Hiệu năng khủng và chụp ảnh nghệ thuật</h3>
<p>Nếu bạn tìm kiếm smartphone cấu hình cao để chiến game hoặc chụp ảnh với ống kính Leica / Hasselblad thì các dòng flagship cũ của Xiaomi, OPPO và Google Pixel là những món hời công nghệ không thể bỏ lỡ.</p>

<h2 id="used-section-5">5. Tiêu chí vàng khi chọn mua điện thoại cũ bạn cần biết</h2>
<ul>
  <li><strong>Kiểm tra số IMEI và Serial:</strong> Đối chiếu số IMEI trong Cài đặt máy với khay SIM và vỏ hộp để đảm bảo tính đồng nhất.</li>
  <li><strong>Kiểm tra tài khoản ẩn:</strong> Kiểm tra kỹ máy đã thoát sạch tài khoản iCloud (với iPhone) hoặc Knox / Mi Account (với Samsung, Xiaomi), yêu cầu khôi phục cài đặt gốc tại chỗ.</li>
  <li><strong>Kiểm tra pin và tình trạng sạc:</strong> Ưu tiên chọn máy có dung lượng pin thực tế trên 88% để đảm bảo thời lượng sử dụng thoải mái trong ngày.</li>
  <li><strong>Lựa chọn nơi bán có chính sách bảo hành rõ ràng:</strong> Ưu tiên hệ thống có chính sách bảo hành bao gồm cả <em>nguồn và màn hình</em> – 2 linh kiện đắt tiền nhất của smartphone.</li>
</ul>

<h2 id="used-section-6">6. Quyền lợi độc quyền khi mua điện thoại cũ tại PhoneX</h2>
<ul>
  <li><strong>Bảo hành VIP 12 tháng:</strong> Bảo hành toàn diện cả Nguồn và Màn hình cảm ứng trong suốt 1 năm.</li>
  <li><strong>Chính sách 1 Đổi 1 trong 30 ngày:</strong> Bất kỳ lỗi phần cứng nào từ nhà sản xuất đều được đổi ngay máy tương đương hoặc hoàn tiền 100%.</li>
  <li><strong>Cam kết hoàn tiền &amp; Đền bù 1.000.000₫:</strong> Nếu phát hiện máy nhận được không đúng số serial độc bản đã chọn hoặc bị can thiệp linh kiện, PhoneX hoàn tiền 100% và tặng thêm 1 triệu đồng tiền mặt.</li>
  <li><strong>Thu cũ đổi mới trợ giá 3.000.000₫:</strong> Định giá máy cũ của bạn trong 60 giây và hỗ trợ trả góp 0% khoản chênh lệch.</li>
</ul>

<h2 id="used-section-7">7. Câu hỏi thường gặp khi mua điện thoại cũ (FAQ)</h2>
<div class="space-y-3 mt-3">
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Điện thoại cũ tại PhoneX có bị thay linh kiện không?</strong>
    <p class="text-gray-600 text-sm">Cam kết 100% nguyên bản (Zin All). PhoneX kiểm tra trực tiếp qua máy đo áp suất và phần mềm chuyên dụng, quỳ tím còn nguyên vẹn chưa từng dính nước hay qua sửa chữa.</p>
  </div>
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Mua máy cũ có được tặng kèm phụ kiện sạc cáp không?</strong>
    <p class="text-gray-600 text-sm">Tất cả điện thoại cũ bán ra tại PhoneX đều được tặng kèm củ sạc nhanh cao cấp, dán cường lực và ốp lưng bảo vệ miễn phí trọn đời máy.</p>
  </div>
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Ở xa mua online có được kiểm tra máy trước khi thanh toán không?</strong>
    <p class="text-gray-600 text-sm">PhoneX hỗ trợ giao hàng hỏa tốc toàn quốc. Bạn được quyền mở hộp đồng kiểm đúng số serial, ngoại hình và bật nguồn test máy đầy đủ trước khi thanh toán cho nhân viên giao hàng.</p>
HTML;

	return array(
		'badge_title' => $badge_title,
		'sapo'        => $sapo,
		'content'     => $content,
		'enable_toc'  => true,
		'img_1'       => 'https://cdn.tgdd.vn/Products/Images/42/370982/iphone-18-pro-max-den-thumb-600x600.jpg',
		'img_2'       => 'https://cdn.tgdd.vn/Products/Images/42/367339/samsung-galaxy-s26-ultra-den-thumb-600x600.jpg',
		'img_3'       => 'https://cdn.tgdd.vn/Products/Images/42/368236/motorola-razr-fold-trang-thumb-600x600.jpg',
	);
}

/**
 * Default SEO content for "Loa" (Category: loa, term 62)
 *
 * @return array
 */
function phonex_get_default_loa_seo_data() {
	$badge_title = 'THÔNG TIN NGÀNH HÀNG LOA';
	$sapo        = '<strong>Loa</strong> là thiết bị khuếch đại âm thanh không thể thiếu cho nhu cầu thưởng thức âm nhạc, xem phim, giải trí gia đình hay tổ chức những buổi tiệc sôi động. Tại PhoneX, chúng tôi phân phối 100% các dòng loa chính hãng từ những thương hiệu âm thanh huyền thoại như <strong>JBL, Marshall, Sony, Harman Kardon, Edifier và Nanomax</strong>. Tất cả sản phẩm đều được bảo hành chính hãng 12 tháng 1 đổi 1, hỗ trợ trả góp 0% lãi suất và giao hàng hỏa tốc trong 1 giờ.';

	$content = <<<HTML
<h2 id="loa-section-1">1. Loa là gì? Vai trò của loa trong giải trí và công việc</h2>
<p><strong>Loa</strong> (Loudspeaker) là thiết bị ngoại vi chuyển đổi tín hiệu điện tử thành sóng âm thanh có thể nghe được bằng tai người. Ngày nay, loa không chỉ đơn thuần để phát nhạc mà đã trở thành thiết bị đa năng phục vụ học tập trực tuyến, hội họp từ xa, xem phim chuẩn rạp hát tại gia và khuấy động những buổi tiệc dã ngoại, cắm trại ngoài trời.</p>

<div class="my-4 text-center">
  <img src="https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/285750/loa-bluetooth-marshall-emberton-ii-thumb-600x600.jpg" alt="Loa Marshall chính hãng tại PhoneX" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Loa Marshall thiết kế Vintage quý phái cùng chất âm chi tiết chân thực tại PhoneX</p>
</div>

<h2 id="loa-section-2">2. Các dòng loa phổ biến được ưa chuộng hiện nay</h2>
<ul>
  <li><strong>Loa Bluetooth di động:</strong> Nhỏ gọn, tích hợp pin dung lượng cao, chuẩn chống nước bụi IP67 bền bỉ. Điển hình như <em>JBL Charge 5, Marshall Emberton II, Sony SRS-XE300</em>.</li>
  <li><strong>Loa Karaoke di động (PartyBox, loa kéo):</strong> Công suất mạnh mẽ từ 100W đến 800W, tích hợp sẵn hoặc tặng kèm 2 Micro không dây UHF cao cấp, hiệu ứng đèn LED RGB đổi màu theo nhịp điệu bài hát. Điển hình: <em>JBL PartyBox Encore, Nanomax Pro 800W</em>.</li>
  <li><strong>Loa Vi tính để bàn &amp; Soundbar:</strong> Thiết kế thanh lịch, tái tạo không gian âm thanh vòm sống động cho PC, Laptop và Smart TV. Điển hình: <em>Edifier MP230</em>.</li>
  <li><strong>Loa Cầm Tay Mini:</strong> Siêu nhẹ, bỏ vừa balo túi xách, giá thành phải chăng chỉ từ vài trăm nghìn đồng.</li>
</ul>

<h2 id="loa-section-3">3. Tiêu chí chọn công suất loa theo diện tích phòng</h2>
<ul>
  <li><strong>Phòng nhỏ dưới 15m² (Phòng ngủ, bàn làm việc):</strong> Công suất từ <strong>10W - 30W</strong> là đủ để lấp đầy không gian mà không gây chói gắt.</li>
  <li><strong>Phòng khách từ 15m² - 30m²:</strong> Nên chọn loa có công suất từ <strong>40W - 80W</strong> để đảm bảo âm bass uy lực, chắc nịch và lan tỏa đều khắp phòng.</li>
  <li><strong>Không gian mở, sân vườn trên 30m² hoặc dã ngoại:</strong> Lựa chọn tối ưu là các mẫu loa công suất từ <strong>100W - 800W</strong> có tay kéo hoặc quai xách chắc chắn.</li>
</ul>

<h2 id="loa-section-4">4. Những công nghệ âm thanh đáng giá trên loa hiện đại</h2>
<ul>
  <li><strong>Chuẩn kết nối Bluetooth 5.1 - 5.3:</strong> Tốc độ truyền tải nhanh, không độ trễ, tiết kiệm pin và phạm vi kết nối ổn định lên đến 15 - 20 mét.</li>
  <li><strong>Công nghệ Bass Boost / Extra Bass:</strong> Tăng cường dải âm trầm sâu lắng mà không làm méo tiếng ca sĩ.</li>
  <li><strong>Ghép đôi không dây True Wireless Stereo (TWS):</strong> Kết nối 2 loa cùng lúc để tạo thành hệ thống âm thanh vòm Stereo 2 kênh trái - phải tách bạch.</li>
  <li><strong>Kháng nước và kháng bụi chuẩn IP67:</strong> Thoải mái mang loa đi bơi, đi biển hay gặp trời mưa mà không sợ hỏng vi mạch.</li>
  <li><strong>Thời lượng pin dài từ 12 đến 30 giờ:</strong> Đồng thời hỗ trợ tính năng Powerbank sạc ngược cho điện thoại trong tình huống khẩn cấp.</li>
</ul>

<h2 id="loa-section-5">5. Top thương hiệu loa danh tiếng thế giới tại PhoneX</h2>
<p>PhoneX là đại lý ủy quyền chính thức của các thương hiệu âm thanh số 1 thế giới:</p>
<ul>
  <li><strong>JBL (Mỹ):</strong> Nổi tiếng với chất âm trẻ trung, dải bass bùng nổ, độ bền "nồi đồng cối đá".</li>
  <li><strong>Marshall (Anh Quốc):</strong> Đỉnh cao thiết kế Retro cổ điển, dải trung và âm cao mộc mạc, chi tiết sắc bén.</li>
  <li><strong>Sony (Nhật Bản):</strong> Công nghệ Extra Bass trứ danh, pin siêu bền và khả năng chống chịu thời tiết vượt trội.</li>
  <li><strong>Harman Kardon (Mỹ):</strong> Thiết kế vị lai đẳng cấp, âm thanh trung thực chuẩn Hi-Fi sang trọng.</li>
</ul>

<h2 id="loa-section-6">6. Quyền lợi khi mua loa tại hệ thống PhoneX</h2>
<ul>
  <li><strong>Cam kết 100% chính hãng:</strong> Đầy đủ tem chống giả, hóa đơn VAT và bảo hành điện tử chính hãng 12 tháng.</li>
  <li><strong>Lỗi 1 Đổi 1 trong 30 ngày:</strong> Đổi ngay sản phẩm mới nếu phát sinh lỗi từ nhà sản xuất.</li>
  <li><strong>Hỗ trợ Trả Góp 0% Lãi Suất:</strong> Thủ tục đơn giản chỉ cần CCCD gắn chip, duyệt hồ sơ online trong 5 phút.</li>
  <li><strong>Giao hàng hỏa tốc trong 1 giờ:</strong> Nhận hàng ngay tại nhà, kiểm tra âm thanh ưng ý mới thanh toán.</li>
</ul>

<h2 id="loa-section-7">7. Câu hỏi thường gặp khi mua loa (FAQ)</h2>
<div class="space-y-3 mt-3">
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Loa Bluetooth có kết nối được với Smart TV không?</strong>
    <p class="text-gray-600 text-sm">Hầu hết Smart TV hiện nay (Samsung, Sony, LG) đều hỗ trợ kết nối Bluetooth hoặc cổng AUX 3.5mm / Cáp quang Optical với loa một cách nhanh chóng và dễ dàng.</p>
  </div>
  <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
    <strong class="text-gray-900 block mb-1">Mua loa PartyBox có hát karaoke được bằng điện thoại không?</strong>
    <p class="text-gray-600 text-sm">Hoàn toàn được! Bạn chỉ cần bật Bluetooth trên điện thoại, mở ứng dụng YouTube hoặc Zing MP3 và cầm micro không dây lên là có thể hát karaoke thỏa thích cùng người thân.</p>
  </div>
</div>
HTML;

	return array(
		'badge_title' => $badge_title,
		'sapo'        => $sapo,
		'content'     => $content,
		'enable_toc'  => true,
		'img_1'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/248386/loa-bluetooth-jbl-charge-5-thumb-600x600.jpg',
		'img_2'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/285750/loa-bluetooth-marshall-emberton-ii-thumb-600x600.jpg',
		'img_3'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/285746/loa-bluetooth-jbl-partybox-encore-2mic-thumb-600x600.jpg',
	);
}

/**
 * Default SEO content for "Micro" (Category: micro, term 63)
 *
 * @return array
 */
function phonex_get_default_micro_seo_data() {
	$badge_title = 'THÔNG TIN NGÀNH HÀNG MICRO';
	$sapo        = '<strong>Micro</strong> là thiết bị thu âm thanh thiết yếu quyết định trực tiếp đến chất lượng giọng hát, video TikTok, livestream bán hàng, podcast hay các cuộc họp hội nghị trực tuyến. PhoneX tự hào là địa chỉ cung cấp micro chính hãng hàng đầu từ các thương hiệu lừng danh như <strong>Boya, Rode, Shure, DJI, JBL, Kingston HyperX và Excelvan</strong>. Cam kết hàng chuẩn 100%, bảo hành 12 tháng 1 đổi 1 và hỗ trợ kỹ thuật cân chỉnh âm thanh chuyên sâu.';

	$content = <<<HTML
<h2 id="micro-section-1">1. Tầm quan trọng của micro chất lượng cao</h2>
<p>Trong thời đại bùng nổ của mạng xã hội video ngắn (TikTok, YouTube Shorts, Reels) và các nền tảng phát sóng trực tiếp, chất lượng âm thanh chiếm tới <strong>60% thành công</strong> của một nội dung video. Một chiếc <strong>micro</strong> tốt giúp giọng nói trong trẻo, loại bỏ tạp âm đường phố, khử gió rít và tôn lên chất giọng trầm ấm, giúp người nghe tập trung và yêu thích nội dung của bạn hơn.</p>

<div class="my-4 text-center">
  <img src="https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/313886/micro-thu-am-boya-by-v20-thumb-600x600.jpg" alt="Micro thu âm không dây Boya tại PhoneX" class="mx-auto rounded-xl max-h-[360px] object-contain shadow-xs border border-gray-100" />
  <p class="text-xs text-gray-500 italic mt-1.5">Micro cài áo không dây khử tiếng ồn AI thông minh chuyên dụng cho điện thoại</p>
</div>

<h2 id="micro-section-2">2. Các dòng micro phổ biến nhất trên thị trường</h2>
<ul>
  <li><strong>Micro cài áo không dây (Wireless Lavalier):</strong> Siêu nhẹ, ghim trực tiếp vào cổ áo, kết nối không dây tầm xa 50m - 200m qua cổng Type-C hoặc Lightning. Lựa chọn số 1 cho nhà sáng tạo nội dung TikToker, Vlogger, Livestreamer. Điển hình: <em>Boya BY-V20, Rode Wireless GO II, DJI Mic 2</em>.</li>
  <li><strong>Micro thu âm Podcast &amp; Studio (Condenser USB/XLR):</strong> Dải tần rộng, bắt trọn từng sắc thái âm thanh tinh tế, cắm trực tiếp vào máy tính qua cổng USB hoặc vang số qua cổng XLR. Điển hình: <em>Shure MV7, HyperX QuadCast S</em>.</li>
  <li><strong>Micro Karaoke Không Dây (UHF Handheld):</strong> Tay micro kim loại đầm chắc, bắt sóng ổn định, chống hú rít hiệu quả, tương thích với amply và loa kéo. Điển hình: <em>JBL Wireless Microphone Set, Excelvan K18V</em>.</li>
  <li><strong>Micro Karaoke Bluetooth tích hợp loa:</strong> Tích hợp loa ngay trên thân máy, phù hợp giải trí nhanh, du lịch hoặc làm quà tặng cho trẻ em. Điển hình: <em>Micro SD-10</em>.</li>
</ul>

<h2 id="micro-section-3">3. Những thông số kỹ thuật cốt lõi cần quan tâm khi mua micro</h2>
<ul>
  <li><strong>Dải tần số đáp ứng (Frequency Response):</strong> Nên chọn micro có dải tần từ <strong>20Hz - 20kHz</strong> để thu trọn vẹn cả âm trầm ấm và âm bổng trong sáng.</li>
  <li><strong>Khả năng khử ồn (Noise Cancellation):</strong> Chip xử lý AI tích hợp giúp lọc sạch tiếng còi xe, tiếng quạt gió và tiếng ồn môi trường chỉ với một nút bấm.</li>
  <li><strong>Băng tần sóng (UHF vs 2.4GHz):</strong> Băng tần UHF cho khả năng xuyên tường và chống nhiễu sóng cực tốt; băng tần số 2.4GHz mã hóa số kỹ thuật số cho âm thanh trong trẻo, không độ trễ.</li>
  <li><strong>Thời lượng pin:</strong> Micro cài áo nên có thời lượng pin từ 6 - 10 giờ liên tục, kèm hộp sạc dự phòng để tiện dùng cả ngày dài ngoài trời.</li>
</ul>

<h2 id="micro-section-4">4. Top các thương hiệu micro hàng đầu tại PhoneX</h2>
<ul>
  <li><strong>Rode (Australia):</strong> Tiêu chuẩn vàng của ngành thu âm thế giới với chất âm ấm áp, ứng dụng di động mạnh mẽ.</li>
  <li><strong>DJI (Công nghệ cao):</strong> Dẫn đầu công nghệ ghi âm 32-bit Float không lo vỡ âm thanh, hộp sạc thông minh cao cấp.</li>
  <li><strong>Shure (Mỹ):</strong> Huyền thoại âm thanh phòng thu và sân khấu ca nhạc đỉnh cao.</li>
  <li><strong>BOYA:</strong> Phổ cập chất lượng thu âm chuyên nghiệp với mức giá bình dân, dễ tiếp cận cho học sinh sinh viên.</li>
  <li><strong>JBL:</strong> Micro karaoke không dây bền bỉ, tôn giọng hát nhẹ và chống hú tuyệt đối.</li>
</ul>

<h2 id="micro-section-5">5. Chính sách bảo hành và cam kết chất lượng PhoneX</h2>
<ul>
  <li>100% Micro chính hãng nguyên hộp, có tem kiểm định an toàn và tem nhập khẩu chính ngạch.</li>
  <li>Chính sách 1 đổi 1 trong 30 ngày đầu tiên nếu sản phẩm bị lỗi phần cứng từ nhà sản xuất.</li>
  <li>Được kỹ thuật viên hướng dẫn cài đặt phần mềm thu âm, test thử giọng trực tiếp tại 128 Showroom PhoneX toàn quốc.</li>
</ul>
HTML;

	return array(
		'badge_title' => $badge_title,
		'sapo'        => $sapo,
		'content'     => $content,
		'enable_toc'  => true,
		'img_1'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/313886/micro-thu-am-boya-by-v20-thumb-600x600.jpg',
		'img_2'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/285755/micro-rode-wireless-go-ii-thumb-600x600.jpg',
		'img_3'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/248390/bo-2-micro-khong-day-jbl-wireless-set-thumb-600x600.jpg',
	);
}

/**
 * Default SEO content for General Accessories "Phụ Kiện" (Category: phu-kien, term 23)
 *
 * @return array
 */
function phonex_get_default_accessories_seo_data() {
	$badge_title = 'THÔNG TIN NGÀNH HÀNG PHỤ KIỆN';
	$sapo        = '<strong>Phụ kiện công nghệ chính hãng</strong> là những mảnh ghép hoàn hảo giúp nâng tầm trải nghiệm, tối ưu hóa công năng và bảo vệ toàn diện cho chiếc điện thoại, máy tính bảng hay laptop của bạn. Tại hệ sinh thái PhoneX, chúng tôi mang đến hàng ngàn mẫu phụ kiện chuẩn chất lượng từ <strong>Apple, Anker, JBL, Marshall, Sony, Ugreen, Baseus, Logitech, EZVIZ</strong> với chính sách bảo hành 1 đổi 1 từ 12 đến 24 tháng, cam kết giá tốt nhất thị trường.';

	$content = <<<HTML
<h2 id="pk-section-1">1. Hệ sinh thái phụ kiện công nghệ toàn diện tại PhoneX</h2>
<p>Một chiếc smartphone hay laptop hiện đại sẽ không thể phát huy hết sức mạnh nếu thiếu đi các món phụ kiện đồng hành đắc lực. Tại PhoneX, chúng tôi cung cấp đầy đủ các nhóm phụ kiện chính yếu:</p>
<ul>
  <li><strong>Thiết bị Âm thanh:</strong> Loa Bluetooth di động, Loa karaoke, Tai nghe chống ồn không dây TWS, Tai nghe chụp tai Hi-Res.</li>
  <li><strong>Thiết bị Thu âm &amp; Livestream:</strong> Micro cài áo không dây, Micro thu âm Podcast, Micro karaoke gia đình.</li>
  <li><strong>Năng lượng &amp; Cáp sạc:</strong> Củ sạc nhanh GaN siêu nhỏ gọn, Cáp sạc dù chống đứt, Pin sạc dự phòng dung lượng khủng hỗ trợ chuẩn sạc không dây MagSafe / Qi2.</li>
  <li><strong>Bảo vệ thiết bị:</strong> Ốp lưng chống sốc chuẩn quân đội, Kính cường lực Kingbull 9H chống nhìn trộm, Miếng dán bảo vệ cụm camera sapphire.</li>
  <li><strong>Phụ kiện Laptop &amp; Văn phòng:</strong> Chuột không dây công thái học, Bàn phím cơ Bluetooth, Hub chuyển đổi đa năng Type-C, Balo chống nước.</li>
  <li><strong>Camera &amp; Nhà thông minh:</strong> Camera giám sát an ninh 360 độ, Chuông cửa thông minh, Webcam hội nghị Full HD.</li>
</ul>

<h2 id="pk-section-2">2. Cảnh báo nguy cơ khi sử dụng phụ kiện trôi nổi, giá rẻ</h2>
<p>Việc sử dụng các loại củ sạc, cáp sạc hay pin dự phòng không rõ nguồn gốc tiềm ẩn những mối nguy hiểm khôn lường:</p>
<ul>
  <li><strong>Cháy nổ và đoản mạch:</strong> Linh kiện giá rẻ không có mạch ngắt tự động khi quá nhiệt, dễ dẫn đến hiện tượng cháy nổ pin cực kỳ nguy hiểm.</li>
  <li><strong>Chai pin và hỏng nguồn điện thoại:</strong> Dòng điện chập chờn, không ổn định làm suy giảm tuổi thọ pin nhanh chóng và dễ làm chết IC nguồn của máy.</li>
  <li><strong>Mất dữ liệu và rò rỉ bảo mật:</strong> Cáp sạc giả có thể chứa vi mạch độc hại ghi nhận thao tác của người dùng khi cắm vào máy tính.</li>
</ul>

<h2 id="pk-section-3">3. Các chứng chỉ an toàn quốc tế cần có khi chọn mua phụ kiện</h2>
<ul>
  <li><strong>Chứng chỉ Apple MFi (Made for iPhone/iPad):</strong> Đảm bảo 100% tương thích, không bị báo lỗi "Phụ kiện không được hỗ trợ" sau các bản cập nhật iOS.</li>
  <li><strong>Công nghệ sạc bán dẫn GaN (Gallium Nitride):</strong> Cho phép củ sạc có kích thước thu nhỏ đến 50%, tỏa nhiệt ít hơn và sạc nhanh an toàn gấp 3 lần củ sạc thông thường.</li>
  <li><strong>Chuẩn sạc không dây Qi2 &amp; MagSafe:</strong> Hít nam châm chắc chắn, công suất sạc nhanh không dây lên đến 15W mà không gây nóng máy.</li>
  <li><strong>Chuẩn Power Delivery (PD) &amp; Quick Charge (QC 3.0/4.0):</strong> Tự động điều chỉnh điện áp phù hợp từng thiết bị từ tai nghe nhỏ (5W) đến laptop (100W).</li>
</ul>

<h2 id="pk-section-4">4. Đặc quyền khi mua phụ kiện chính hãng tại PhoneX</h2>
<ul>
  <li><strong>100% Phụ kiện chính hãng:</strong> Xuất xứ minh bạch, nguyên seal hộp, tem kiểm định của nhà phân phối.</li>
  <li><strong>Bảo hành 1 Đổi 1 trong 12 - 24 tháng:</strong> Đổi ngay sản phẩm mới tinh nếu phát sinh lỗi kỹ thuật.</li>
  <li><strong>Dán màn hình miễn phí &amp; Bảo hành dán lại 3 lần:</strong> Nhân viên tay nghề cao dán cường lực không bọt khí ngay tại showroom.</li>
  <li><strong>Giao hàng hỏa tốc trong 1 giờ:</strong> Đặt hàng online, nhận phụ kiện tận tay nhanh chóng.</li>
</ul>
HTML;

	return array(
		'badge_title' => $badge_title,
		'sapo'        => $sapo,
		'content'     => $content,
		'enable_toc'  => true,
		'img_1'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/248386/loa-bluetooth-jbl-charge-5-thumb-600x600.jpg',
		'img_2'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/2162/313886/micro-thu-am-boya-by-v20-thumb-600x600.jpg',
		'img_3'       => 'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/9499/315000/adapter-sac-3-cong-67w-anker-prime-thumb-600x600.jpg',
	);
}

/**
 * Resolve Category Term ID for "Điện Thoại"
 */
function phonex_get_phone_cat_term_id() {
	if ( is_tax( 'product_cat' ) ) {
		return get_queried_object_id();
	}
	$term = get_term_by( 'slug', 'dien-thoai', 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		return $term->term_id;
	}
	return 77; // default DB term id for dien-thoai
}

/**
 * Get category SEO data from Category Term Meta (Prioritizing User input in wp-admin)
 *
 * @param int $term_id Optional category term ID.
 * @return array
 */
function phonex_get_category_seo_data( $term_id = 0 ) {
	if ( empty( $term_id ) ) {
		$term_id = phonex_get_phone_cat_term_id();
	}

	$term_obj = ( $term_id > 0 ) ? get_term( $term_id, 'product_cat' ) : null;
	$term_slug = ( $term_obj && ! is_wp_error( $term_obj ) ) ? $term_obj->slug : '';

	// Detect Category Type for Defaults
	if ( 21 === (int) $term_id || in_array( $term_slug, array( 'used', 'may-cu-99', 'dien-thoai-cu' ), true ) ) {
		$defaults = phonex_get_default_used_phone_seo_data();
	} elseif ( 62 === (int) $term_id || in_array( $term_slug, array( 'loa', 'loa-bluetooth', 'loa-karaoke', 'loa-laptop' ), true ) ) {
		$defaults = phonex_get_default_loa_seo_data();
	} elseif ( 63 === (int) $term_id || in_array( $term_slug, array( 'micro', 'micro-thu-am', 'micro-karaoke', 'micro-cai-ao' ), true ) ) {
		$defaults = phonex_get_default_micro_seo_data();
	} elseif ( 23 === (int) $term_id || in_array( $term_slug, array( 'phu-kien', 'accessories', 'phu-kien-di-dong', 'phu-kien-laptop-pc', 'thiet-bi-nghe-nhin-luu-tru', 'sac-cap', 'sac-du-phong', 'camera-giam-sat' ), true ) ) {
		$defaults = phonex_get_default_accessories_seo_data();
	} else {
		$defaults = phonex_get_default_category_seo_data();
	}

	// 1. Check if term meta exists in the Category Edit screen (User custom input always takes precedence)
	if ( $term_id > 0 ) {
		$badge   = get_term_meta( $term_id, '_phonex_cat_seo_badge', true );
		$sapo    = get_term_meta( $term_id, '_phonex_cat_seo_sapo', true );
		$content = get_term_meta( $term_id, '_phonex_cat_seo_content', true );
		$toc     = get_term_meta( $term_id, '_phonex_cat_seo_toc', true );
		$img_1   = get_term_meta( $term_id, '_phonex_cat_seo_img_1', true );
		$img_2   = get_term_meta( $term_id, '_phonex_cat_seo_img_2', true );
		$img_3   = get_term_meta( $term_id, '_phonex_cat_seo_img_3', true );

		if ( ! empty( $content ) || ! empty( $sapo ) || ! empty( $badge ) ) {
			return array(
				'badge_title' => ! empty( $badge ) ? $badge : $defaults['badge_title'],
				'sapo'        => ! empty( $sapo ) ? $sapo : $defaults['sapo'],
				'content'     => ! empty( $content ) ? $content : $defaults['content'],
				'enable_toc'  => ( 'no' === $toc ) ? false : true,
				'img_1'       => ! empty( $img_1 ) ? $img_1 : $defaults['img_1'],
				'img_2'       => ! empty( $img_2 ) ? $img_2 : $defaults['img_2'],
				'img_3'       => ! empty( $img_3 ) ? $img_3 : $defaults['img_3'],
			);
		}
	}

	// 2. Check global phone SEO option (ONLY for dien-thoai category)
	if ( 77 === (int) $term_id || 'dien-thoai' === $term_slug ) {
		$saved_opt = get_option( 'phonex_industry_seo_dien_thoai', null );
		if ( is_array( $saved_opt ) && ! empty( $saved_opt['content'] ) ) {
			return array(
				'badge_title' => ! empty( $saved_opt['badge_title'] ) ? $saved_opt['badge_title'] : $defaults['badge_title'],
				'sapo'        => isset( $saved_opt['sapo'] ) ? $saved_opt['sapo'] : $defaults['sapo'],
				'content'     => $saved_opt['content'],
				'enable_toc'  => isset( $saved_opt['enable_toc'] ) ? (bool) $saved_opt['enable_toc'] : true,
				'img_1'       => $saved_opt['img_1'] ?? $defaults['img_1'],
				'img_2'       => $saved_opt['img_2'] ?? $defaults['img_2'],
				'img_3'       => $saved_opt['img_3'] ?? $defaults['img_3'],
			);
		}

		// 3. Fallback to Page ID 50 meta for phones
		$page_content = get_post_meta( 50, '_phonex_category_seo_content', true );
		if ( ! empty( $page_content ) ) {
			$page_badge = get_post_meta( 50, '_phonex_category_seo_badge', true );
			$page_sapo  = get_post_meta( 50, '_phonex_category_seo_sapo', true );
			return array(
				'badge_title' => ! empty( $page_badge ) ? $page_badge : $defaults['badge_title'],
				'sapo'        => ! empty( $page_sapo ) ? $page_sapo : $defaults['sapo'],
				'content'     => $page_content,
				'enable_toc'  => true,
				'img_1'       => $defaults['img_1'],
				'img_2'       => $defaults['img_2'],
				'img_3'       => $defaults['img_3'],
			);
		}
	}

	return $defaults;
}

/**
 * Save Category SEO data to Term Meta and Sync
 *
 * @param int   $term_id
 * @param array $data
 */
function phonex_save_category_seo_data( $term_id, $data ) {
	$badge   = sanitize_text_field( $data['badge_title'] ?? 'THÔNG TIN NGÀNH HÀNG' );
	$sapo    = wp_kses_post( $data['sapo'] ?? '' );
	$content = wp_kses_post( $data['content'] ?? '' );
	$toc     = ! empty( $data['enable_toc'] ) ? 'yes' : 'no';
	$img_1   = esc_url_raw( $data['img_1'] ?? '' );
	$img_2   = esc_url_raw( $data['img_2'] ?? '' );
	$img_3   = esc_url_raw( $data['img_3'] ?? '' );

	if ( $term_id > 0 ) {
		update_term_meta( $term_id, '_phonex_cat_seo_badge', $badge );
		update_term_meta( $term_id, '_phonex_cat_seo_sapo', $sapo );
		update_term_meta( $term_id, '_phonex_cat_seo_content', $content );
		update_term_meta( $term_id, '_phonex_cat_seo_toc', $toc );
		update_term_meta( $term_id, '_phonex_cat_seo_img_1', $img_1 );
		update_term_meta( $term_id, '_phonex_cat_seo_img_2', $img_2 );
		update_term_meta( $term_id, '_phonex_cat_seo_img_3', $img_3 );
	}

	// Also sync global option
	update_option(
		'phonex_industry_seo_dien_thoai',
		array(
			'badge_title' => $badge,
			'sapo'        => $sapo,
			'content'     => $content,
			'enable_toc'  => ( 'yes' === $toc ),
			'img_1'       => $img_1,
			'img_2'       => $img_2,
			'img_3'       => $img_3,
		)
	);

	// Sync to Page ID 50
	update_post_meta( 50, '_phonex_category_seo_badge', $badge );
	update_post_meta( 50, '_phonex_category_seo_sapo', $sapo );
	update_post_meta( 50, '_phonex_category_seo_content', $content );
}

/**
 * Add custom fields to Product Category edit screen (Sản phẩm > Danh mục > Chỉnh sửa)
 */
function phonex_edit_product_cat_seo_fields( $term ) {
	$term_id  = $term->term_id;
	$seo_data = phonex_get_category_seo_data( $term_id );
	?>
	<tr class="form-field">
		<th scope="row" colspan="2" style="padding-top: 30px;">
			<div style="background:#ffdad5; border-left: 4px solid #e60012; padding: 12px 16px; border-radius: 6px;">
				<h2 style="font-size: 18px; font-weight: 800; color: #b7000c; margin: 0 0 6px 0;">
					📝 THÔNG TIN NGÀNH HÀNG (BÀI VIẾT CHUẨN SEO THEGIOIDIDONG)
				</h2>
				<p style="margin: 0; color: #222222; font-size: 13px;">
					Nội dung này hiển thị trực tiếp ở chân trang danh mục <strong><?php echo esc_html( $term->name ); ?></strong>. 
					Có sẵn bộ tải ảnh (WordPress Media) để chọn và chèn ảnh 1-click vào bài viết mà không cần nhập URL thủ công!
				</p>
			</div>
		</th>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_badge"><strong>Nhãn Ngành Hàng (Badge)</strong></label></th>
		<td>
			<input name="_phonex_cat_seo_badge" id="_phonex_cat_seo_badge" type="text" value="<?php echo esc_attr( $seo_data['badge_title'] ); ?>" style="max-width: 400px; font-weight: bold; color: #e60012; border-color: #e60012; border-radius: 6px;" />
			<p class="description">Ví dụ: <code>THÔNG TIN NGÀNH HÀNG</code> hoặc <code>ĐIỆN THOẠI CHÍNH HÃNG</code></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_sapo"><strong>Đoạn Mở Đầu (Sapo)</strong></label></th>
		<td>
			<textarea name="_phonex_cat_seo_sapo" id="_phonex_cat_seo_sapo" rows="4" style="border-radius: 6px;"><?php echo esc_textarea( $seo_data['sapo'] ); ?></textarea>
			<p class="description">Đoạn tóm tắt mở đầu bài viết chuẩn SEO.</p>
		</td>
	</tr>

	<!-- MEDIA UPLOADER SECTION (CHÈN HÌNH ẢNH MINH HỌA) -->
	<tr class="form-field">
		<th scope="row"><label><strong>📷 Bộ Chèn Hình Ảnh Ngành Hàng</strong></label></th>
		<td>
			<p class="description" style="margin-bottom: 12px;">
				Bấm <strong>"Chọn / Tải ảnh"</strong> để mở Thư viện Media WordPress, sau đó bấm <strong>"➕ Chèn vào bài viết"</strong> để đưa ảnh ngay vào vị trí con trỏ trong khung soạn thảo bên dưới:
			</p>

			<div style="display: flex; gap: 16px; flex-wrap: wrap;">
				<?php for ( $i = 1; $i <= 3; $i++ ) : 
					$slot_val = $seo_data['img_' . $i] ?? '';
				?>
					<div id="slot_box_<?php echo $i; ?>" style="background: #f8f9fb; border: 1px solid #E5E7EB; border-radius: 10px; padding: 12px; width: 220px; text-align: center;">
						<strong style="display: block; margin-bottom: 8px; color: #222222; font-size: 13px;">Ảnh Minh Họa <?php echo $i; ?></strong>
						
						<div style="height: 120px; background: #fff; border: 1px dashed #ccd0d4; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 10px;">
							<img id="seo_img_preview_<?php echo $i; ?>" src="<?php echo esc_url( $slot_val ); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain; <?php echo empty( $slot_val ) ? 'display:none;' : ''; ?>" />
							<span id="seo_img_placeholder_<?php echo $i; ?>" style="color: #5f5e5e; font-size: 12px; <?php echo ! empty( $slot_val ) ? 'display:none;' : ''; ?>">Chưa chọn ảnh</span>
						</div>

						<input type="hidden" name="_phonex_cat_seo_img_<?php echo $i; ?>" id="_phonex_cat_seo_img_<?php echo $i; ?>" value="<?php echo esc_attr( $slot_val ); ?>" />

						<div style="display: flex; flex-direction: column; gap: 6px;">
							<button type="button" class="button phonex-upload-media-btn" data-slot="<?php echo $i; ?>" style="color: #e60012; border-color: #e60012; font-weight: bold;">
								📷 Chọn / Tải ảnh lên
							</button>

							<button type="button" class="button phonex-insert-editor-btn" data-slot="<?php echo $i; ?>" id="btn_insert_<?php echo $i; ?>" style="<?php echo empty( $slot_val ) ? 'display:none;' : ''; ?> background: #e60012; color: #fff; border-color: #e60012; font-weight: bold;">
								➕ Chèn vào bài viết
							</button>

							<button type="button" class="button phonex-remove-media-btn" data-slot="<?php echo $i; ?>" id="btn_remove_<?php echo $i; ?>" style="<?php echo empty( $slot_val ) ? 'display:none;' : ''; ?> color: #e60012; border-color: #e60012;">
								❌ Xóa ảnh
							</button>
						</div>
					</div>
				<?php endfor; ?>
			</div>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_content"><strong>Nội Dung Chi Tiết (SEO)</strong></label></th>
		<td>
			<div style="margin-bottom: 8px;">
				<label>
					<input name="_phonex_cat_seo_toc" type="checkbox" id="_phonex_cat_seo_toc" value="yes" <?php checked( $seo_data['enable_toc'], true ); ?> />
					<strong>Bật Bảng Mục Lục Tự Động (Nội dung chính)</strong> - Hệ thống tự động quét các thẻ H2, H3 để tạo bảng mục lục có thể thu gọn giống Thế Giới Di Động.
				</label>
			</div>

			<?php
			wp_editor(
				$seo_data['content'],
				'_phonex_cat_seo_content',
				array(
					'textarea_name' => '_phonex_cat_seo_content',
					'textarea_rows' => 20,
					'media_buttons' => true,
					'tinymce'       => true,
					'quicktags'     => true,
				)
			);
			?>
			<p class="description" style="margin-top: 6px;">
				💡 <em>Mẹo: Bạn có thể bấm nút <strong>"Thêm Media"</strong> phía trên thanh công cụ soạn thảo, hoặc bấm nút <strong>"➕ Chèn vào bài viết"</strong> ở các ô ảnh minh họa phía trên để đưa hình vào bài viết lập tức.</em>
			</p>
		</td>
	</tr>

	<!-- Media Uploader Script -->
	<script>
	jQuery(document).ready(function($) {
		var editorId = '_phonex_cat_seo_content';

		// Upload / Select Media
		$('.phonex-upload-media-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			var mediaFrame = wp.media({
				title: 'Chọn hoặc Tải Ảnh Minh Họa Ngành Hàng',
				button: { text: 'Sử dụng ảnh này' },
				multiple: false
			}).on('select', function() {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				$('#_phonex_cat_seo_img_' + slot).val(attachment.url);
				$('#seo_img_preview_' + slot).attr('src', attachment.url).show();
				$('#seo_img_placeholder_' + slot).hide();
				$('#btn_insert_' + slot).show();
				$('#btn_remove_' + slot).show();
			}).open();
		});

		// Remove Media
		$('.phonex-remove-media-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			$('#_phonex_cat_seo_img_' + slot).val('');
			$('#seo_img_preview_' + slot).attr('src', '').hide();
			$('#seo_img_placeholder_' + slot).show();
			$('#btn_insert_' + slot).hide();
			$(this).hide();
		});

		// Insert into WP Editor
		$('.phonex-insert-editor-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			var url = $('#_phonex_cat_seo_img_' + slot).val();
			if (!url) return;

			var htmlToInsert = '\n<div class="my-4 text-center">' +
				'\n  <img src="' + url + '" alt="Minh họa sản phẩm" class="mx-auto rounded-xl max-h-[380px] object-contain shadow-xs border border-gray-100" />' +
				'\n  <p class="text-xs text-gray-500 italic mt-1.5">Ảnh thực tế sản phẩm tại PhoneX</p>' +
				'\n</div>\n';

			if (typeof tinyMCE !== 'undefined' && tinyMCE.get(editorId) && !tinyMCE.get(editorId).isHidden()) {
				tinyMCE.get(editorId).insertContent(htmlToInsert);
			} else {
				var textarea = document.getElementById(editorId);
				if (textarea) {
					var pos = textarea.selectionStart || textarea.value.length;
					textarea.value = textarea.value.substring(0, pos) + htmlToInsert + textarea.value.substring(pos);
				}
			}
			alert('Đã chèn ảnh vào vị trí con trỏ trong bài viết!');
		});
	});
	</script>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'phonex_edit_product_cat_seo_fields', 20 );

/**
 * Save custom fields from Product Category edit screen
 */
function phonex_save_product_cat_seo_fields( $term_id ) {
	if ( isset( $_POST['_phonex_cat_seo_content'] ) ) {
		$badge   = sanitize_text_field( $_POST['_phonex_cat_seo_badge'] ?? 'THÔNG TIN NGÀNH HÀNG' );
		$sapo    = wp_kses_post( $_POST['_phonex_cat_seo_sapo'] ?? '' );
		$content = wp_kses_post( $_POST['_phonex_cat_seo_content'] ?? '' );
		$toc     = isset( $_POST['_phonex_cat_seo_toc'] ) ? 'yes' : 'no';
		$img_1   = esc_url_raw( $_POST['_phonex_cat_seo_img_1'] ?? '' );
		$img_2   = esc_url_raw( $_POST['_phonex_cat_seo_img_2'] ?? '' );
		$img_3   = esc_url_raw( $_POST['_phonex_cat_seo_img_3'] ?? '' );

		phonex_save_category_seo_data(
			$term_id,
			array(
				'badge_title' => $badge,
				'sapo'        => $sapo,
				'content'     => $content,
				'enable_toc'  => ( 'yes' === $toc ),
				'img_1'       => $img_1,
				'img_2'       => $img_2,
				'img_3'       => $img_3,
			)
		);
	}
}
add_action( 'edited_product_cat', 'phonex_save_product_cat_seo_fields' );

/**
 * Register Admin Menu under WooCommerce Products
 */
function phonex_register_category_seo_admin_menu() {
	add_submenu_page(
		'edit.php?post_type=product',
		'Thông tin ngành hàng (SEO)',
		'📝 Thông tin ngành hàng',
		'manage_options',
		'phonex-industry-seo',
		'phonex_render_category_seo_admin_page'
	);
}
add_action( 'admin_menu', 'phonex_register_category_seo_admin_menu', 25 );

/**
 * Render Admin Management Page (Sản phẩm > 📝 Thông tin ngành hàng)
 */
function phonex_render_category_seo_admin_page() {
	$target_term_id = phonex_get_phone_cat_term_id();

	// Handle reset to default
	if ( isset( $_POST['phonex_reset_default_seo'] ) && check_admin_referer( 'phonex_reset_seo_action', 'phonex_seo_nonce' ) ) {
		$default = phonex_get_default_category_seo_data();
		phonex_save_category_seo_data( $target_term_id, $default );
		echo '<div class="notice notice-success is-dismissible"><p><strong>Đã khôi phục bài viết SEO mẫu chuẩn Thế Giới Di Động thành công!</strong></p></div>';
	}

	// Handle Save
	if ( isset( $_POST['phonex_save_industry_seo'] ) && check_admin_referer( 'phonex_save_seo_action', 'phonex_seo_nonce' ) ) {
		$badge   = sanitize_text_field( $_POST['badge_title'] ?? 'THÔNG TIN NGÀNH HÀNG' );
		$sapo    = wp_unslash( $_POST['sapo'] ?? '' );
		$content = wp_unslash( $_POST['seo_content'] ?? '' );
		$toc     = isset( $_POST['enable_toc'] ) ? true : false;
		$img_1   = esc_url_raw( $_POST['img_1'] ?? '' );
		$img_2   = esc_url_raw( $_POST['img_2'] ?? '' );
		$img_3   = esc_url_raw( $_POST['img_3'] ?? '' );

		phonex_save_category_seo_data(
			$target_term_id,
			array(
				'badge_title' => $badge,
				'sapo'        => $sapo,
				'content'     => $content,
				'enable_toc'  => $toc,
				'img_1'       => $img_1,
				'img_2'       => $img_2,
				'img_3'       => $img_3,
			)
		);
		echo '<div class="notice notice-success is-dismissible"><p><strong>Đã lưu nội dung Thông Tin Ngành Hàng thành công! Dữ liệu được đồng bộ trực tiếp vào Danh mục Điện Thoại.</strong></p></div>';
	}

	$seo_data = phonex_get_category_seo_data( $target_term_id );
	?>
	<div class="wrap" style="max-width: 1100px;">
		<h1 style="display:flex; align-items:center; gap:8px;">
			<span class="dashicons dashicons-text-page" style="font-size:28px; width:28px; height:28px; color:#e60012;"></span>
			Quản Lý Bài Viết SEO: Thông Tin Ngành Hàng (Đồng bộ Danh Mục)
		</h1>
		<p class="description" style="font-size: 14px; margin-bottom: 20px;">
			Dữ liệu tại đây liên kết trực tiếp với mục 
			<a href="<?php echo esc_url( admin_url( 'term.php?taxonomy=product_cat&tag_ID=' . $target_term_id . '&post_type=product' ) ); ?>" target="_blank" style="font-weight: bold; text-decoration: underline;">Danh mục Điện Thoại ↗</a>
			và hiển thị ở chân trang 
			<a href="<?php echo esc_url( home_url( '/dien-thoai/' ) ); ?>" target="_blank" style="font-weight: bold; text-decoration: underline;">Điện Thoại (/dien-thoai/) ↗</a>.
		</p>

		<div style="background:#fff; border:1px solid #ccd0d4; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05); margin-bottom: 24px;">
			<form method="post" action="">
				<?php wp_nonce_field( 'phonex_save_seo_action', 'phonex_seo_nonce' ); ?>

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<label for="badge_title"><strong>Nhãn Tiêu Đề (Badge)</strong></label>
							</th>
							<td>
								<input name="badge_title" type="text" id="badge_title" value="<?php echo esc_attr( $seo_data['badge_title'] ); ?>" class="regular-text" style="font-weight: bold; color: #e60012; border-color: #e60012; border-radius: 6px;" />
								<p class="description">Hiển thị dạng huy hiệu bo góc phía trên bài viết (Mặc định: <code>THÔNG TIN NGÀNH HÀNG</code>).</p>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label for="sapo"><strong>Đoạn Mở Đầu (Sapo)</strong></label>
							</th>
							<td>
								<textarea name="sapo" id="sapo" rows="4" class="large-text" style="border-radius: 6px;"><?php echo esc_textarea( $seo_data['sapo'] ); ?></textarea>
								<p class="description">Đoạn văn tóm tắt ngắn mở đầu bài viết, giúp công cụ tìm kiếm và người đọc nắm nhanh nội dung.</p>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label><strong>📷 Bộ Chèn Ảnh Ngành Hàng</strong></label>
							</th>
							<td>
								<div style="display: flex; gap: 16px; flex-wrap: wrap;">
									<?php for ( $i = 1; $i <= 3; $i++ ) : 
										$slot_val = $seo_data['img_' . $i] ?? '';
									?>
										<div style="background: #f8f9fb; border: 1px solid #E5E7EB; border-radius: 10px; padding: 12px; width: 220px; text-align: center;">
											<strong style="display: block; margin-bottom: 8px; color: #222222; font-size: 13px;">Ảnh Minh Họa <?php echo $i; ?></strong>
											<div style="height: 120px; background: #fff; border: 1px dashed #ccd0d4; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 10px;">
												<img id="seo_img_preview_<?php echo $i; ?>" src="<?php echo esc_url( $slot_val ); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain; <?php echo empty( $slot_val ) ? 'display:none;' : ''; ?>" />
												<span id="seo_img_placeholder_<?php echo $i; ?>" style="color: #5f5e5e; font-size: 12px; <?php echo ! empty( $slot_val ) ? 'display:none;' : ''; ?>">Chưa chọn ảnh</span>
											</div>
											<input type="hidden" name="img_<?php echo $i; ?>" id="_phonex_cat_seo_img_<?php echo $i; ?>" value="<?php echo esc_attr( $slot_val ); ?>" />
											<div style="display: flex; flex-direction: column; gap: 6px;">
												<button type="button" class="button phonex-upload-media-btn" data-slot="<?php echo $i; ?>" style="color: #e60012; border-color: #e60012; font-weight: bold;">
													📷 Chọn / Tải ảnh lên
												</button>
												<button type="button" class="button phonex-insert-editor-btn" data-slot="<?php echo $i; ?>" id="btn_insert_<?php echo $i; ?>" style="<?php echo empty( $slot_val ) ? 'display:none;' : ''; ?> background: #e60012; color: #fff; border-color: #e60012; font-weight: bold;">
													➕ Chèn vào bài viết
												</button>
												<button type="button" class="button phonex-remove-media-btn" data-slot="<?php echo $i; ?>" id="btn_remove_<?php echo $i; ?>" style="<?php echo empty( $slot_val ) ? 'display:none;' : ''; ?> color: #e60012; border-color: #e60012;">
													❌ Xóa ảnh
												</button>
											</div>
										</div>
									<?php endfor; ?>
								</div>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label for="enable_toc"><strong>Mục Lục Tự Động (TOC)</strong></label>
							</th>
							<td>
								<label>
									<input name="enable_toc" type="checkbox" id="enable_toc" value="1" <?php checked( $seo_data['enable_toc'], true ); ?> />
									Tự động tạo bảng mục lục "Nội dung chính" từ các tiêu đề H2, H3 trong bài viết (giống Thegioididong).
								</label>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label for="seo_content"><strong>Nội Dung Chi Tiết</strong></label>
							</th>
							<td>
								<?php
								$editor_settings = array(
									'textarea_name' => 'seo_content',
									'textarea_rows' => 22,
									'media_buttons' => true,
									'tinymce'       => true,
									'quicktags'     => true,
								);
								wp_editor( $seo_data['content'], 'phonex_seo_editor', $editor_settings );
								?>
							</td>
						</tr>
					</tbody>
				</table>

				<div style="margin-top: 24px; display:flex; align-items:center; gap:16px;">
					<button type="submit" name="phonex_save_industry_seo" class="button button-primary button-large" style="background:#e60012; border-color:#e60012; font-weight:bold; padding: 4px 24px;">
						💾 Lưu Bài Viết SEO Ngành Hàng
					</button>

					<a href="<?php echo esc_url( home_url( '/dien-thoai/' ) ); ?>" target="_blank" class="button button-secondary button-large" style="display:flex; align-items:center; gap:4px;">
						<span class="dashicons dashicons-visibility" style="margin-top:2px;"></span> Xem Trang Ngoài Web
					</a>
				</div>
			</form>
		</div>

		<!-- Reset default -->
		<div style="background:#ffdad5; border:1px solid #bcdcff; border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between;">
			<div>
				<strong style="color:#b7000c; font-size:14px;">Khôi phục bài viết mẫu chuẩn Thế Giới Di Động</strong>
				<p style="margin:4px 0 0; color:#222222; font-size:13px;">
					Nạp lại nội dung bài viết mẫu chuẩn SEO gồm 7 mục, bảng mục lục và cấu trúc ảnh chuẩn TGDD.
				</p>
			</div>
			<form method="post" action="" onsubmit="return confirm('Bạn có chắc chắn muốn nạp lại bài mẫu?');">
				<?php wp_nonce_field( 'phonex_reset_seo_action', 'phonex_seo_nonce' ); ?>
				<button type="submit" name="phonex_reset_default_seo" class="button button-secondary" style="color:#b7000c; border-color:#bcdcff; background:#fff; font-weight:bold;">
					🔄 Nạp Lại Bài Mẫu TGDD
				</button>
			</form>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		var editorId = 'phonex_seo_editor';

		$('.phonex-upload-media-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			var mediaFrame = wp.media({
				title: 'Chọn hoặc Tải Ảnh Minh Họa Ngành Hàng',
				button: { text: 'Sử dụng ảnh này' },
				multiple: false
			}).on('select', function() {
				var attachment = mediaFrame.state().get('selection').first().toJSON();
				$('#_phonex_cat_seo_img_' + slot).val(attachment.url);
				$('#seo_img_preview_' + slot).attr('src', attachment.url).show();
				$('#seo_img_placeholder_' + slot).hide();
				$('#btn_insert_' + slot).show();
				$('#btn_remove_' + slot).show();
			}).open();
		});

		$('.phonex-remove-media-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			$('#_phonex_cat_seo_img_' + slot).val('');
			$('#seo_img_preview_' + slot).attr('src', '').hide();
			$('#seo_img_placeholder_' + slot).show();
			$('#btn_insert_' + slot).hide();
			$(this).hide();
		});

		$('.phonex-insert-editor-btn').on('click', function(e) {
			e.preventDefault();
			var slot = $(this).data('slot');
			var url = $('#_phonex_cat_seo_img_' + slot).val();
			if (!url) return;

			var htmlToInsert = '\n<div class="my-4 text-center">' +
				'\n  <img src="' + url + '" alt="Minh họa sản phẩm" class="mx-auto rounded-xl max-h-[380px] object-contain shadow-xs border border-gray-100" />' +
				'\n  <p class="text-xs text-gray-500 italic mt-1.5">Ảnh thực tế sản phẩm tại PhoneX</p>' +
				'\n</div>\n';

			if (typeof tinyMCE !== 'undefined' && tinyMCE.get(editorId) && !tinyMCE.get(editorId).isHidden()) {
				tinyMCE.get(editorId).insertContent(htmlToInsert);
			} else {
				var textarea = document.getElementById(editorId);
				if (textarea) {
					var pos = textarea.selectionStart || textarea.value.length;
					textarea.value = textarea.value.substring(0, pos) + htmlToInsert + textarea.value.substring(pos);
				}
			}
			alert('Đã chèn ảnh vào bài viết!');
		});
	});
	</script>
	<?php
}

/**
 * Add Meta Box on Page Editor
 */
function phonex_add_page_category_seo_metabox() {
	add_meta_box(
		'phonex_page_category_seo_box',
		'📝 Thông Tin Ngành Hàng (SEO Chuẩn TGDD)',
		'phonex_render_page_category_seo_metabox',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'phonex_add_page_category_seo_metabox' );

function phonex_render_page_category_seo_metabox( $post ) {
	wp_nonce_field( 'phonex_page_seo_meta_save', 'phonex_page_seo_nonce' );
	$seo_data = phonex_get_category_seo_data( 77 );
	?>
	<div style="padding: 10px 0;">
		<p class="description" style="margin-bottom: 15px;">
			Nội dung này được đồng bộ trực tiếp với mục <a href="<?php echo esc_url( admin_url( 'term.php?taxonomy=product_cat&tag_ID=77&post_type=product' ) ); ?>" target="_blank" style="font-weight:bold;">Danh mục Điện Thoại</a>
			hoặc chỉnh sửa nhanh tại <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=phonex-industry-seo' ) ); ?>" target="_blank" style="font-weight:bold;">Sản phẩm &gt; 📝 Thông tin ngành hàng</a>.
		</p>
		<p>
			<label for="_page_seo_badge"><strong>Nhãn tiêu đề:</strong></label><br/>
			<input type="text" id="_page_seo_badge" name="_page_seo_badge" value="<?php echo esc_attr( $seo_data['badge_title'] ); ?>" class="large-text" style="max-width:400px; margin-top:4px;" />
		</p>
		<p>
			<label for="_page_seo_sapo"><strong>Đoạn mở đầu (Sapo):</strong></label><br/>
			<textarea id="_page_seo_sapo" name="_page_seo_sapo" rows="3" class="large-text" style="margin-top:4px;"><?php echo esc_textarea( $seo_data['sapo'] ); ?></textarea>
		</p>
		<p>
			<label for="_page_seo_content"><strong>Nội dung chi tiết:</strong></label><br/>
			<?php
			wp_editor(
				$seo_data['content'],
				'_page_seo_content',
				array(
					'textarea_name' => '_page_seo_content',
					'textarea_rows' => 15,
					'media_buttons' => true,
				)
			);
			?>
		</p>
	</div>
	<?php
}

function phonex_save_page_category_seo_metabox( $post_id ) {
	if ( ! isset( $_POST['phonex_page_seo_nonce'] ) || ! wp_verify_nonce( $_POST['phonex_page_seo_nonce'], 'phonex_page_seo_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_page_seo_content'] ) ) {
		$badge   = sanitize_text_field( $_POST['_page_seo_badge'] ?? 'THÔNG TIN NGÀNH HÀNG' );
		$sapo    = wp_kses_post( $_POST['_page_seo_sapo'] ?? '' );
		$content = wp_kses_post( $_POST['_page_seo_content'] ?? '' );

		phonex_save_category_seo_data(
			77,
			array(
				'badge_title' => $badge,
				'sapo'        => $sapo,
				'content'     => $content,
				'enable_toc'  => true,
			)
		);
	}
}
add_action( 'save_post_page', 'phonex_save_page_category_seo_metabox' );

/**
 * Helper: Parse HTML headings and generate Table of Contents (TOC) & inject Anchor IDs
 *
 * @param string $html
 * @return array array( 'toc_html' => '', 'content_html' => '' )
 */
function phonex_generate_toc_and_anchors( $html ) {
	if ( empty( $html ) ) {
		return array(
			'toc_html'     => '',
			'content_html' => '',
		);
	}

	$toc_items  = array();
	$counter_h2 = 0;
	$counter_h3 = 0;

	// Add ids if not present
	$content_html = preg_replace_callback(
		'/<(h[23])([^>]*)>(.*?)<\/\1>/is',
		function ( $matches ) use ( &$toc_items, &$counter_h2, &$counter_h3 ) {
			$tag   = strtolower( $matches[1] );
			$attrs = $matches[2];
			$title = wp_strip_all_tags( $matches[3] );

			if ( preg_match( '/id=["\']([^"\']+)["\']/i', $attrs, $id_match ) ) {
				$anchor = $id_match[1];
			} else {
				if ( 'h2' === $tag ) {
					$counter_h2++;
					$counter_h3 = 0;
					$anchor     = 'seo-sec-' . $counter_h2;
				} else {
					$counter_h3++;
					$anchor = 'seo-sec-' . $counter_h2 . '-' . $counter_h3;
				}
				$attrs .= ' id="' . esc_attr( $anchor ) . '"';
			}

			$toc_items[] = array(
				'tag'    => $tag,
				'title'  => $title,
				'anchor' => $anchor,
			);

			return '<' . $tag . $attrs . ' class="scroll-mt-24">' . $matches[3] . '</' . $tag . '>';
		},
		$html
	);

	if ( empty( $toc_items ) ) {
		return array(
			'toc_html'     => '',
			'content_html' => $content_html,
		);
	}

	$toc_html  = '<div id="seo-toc-container" class="my-5 rounded-2xl border border-[#e9bcb6] bg-[#f2f4f6] p-5 sm:p-6 transition-all shadow-2xs">';
	$toc_html .= '  <button type="button" id="toggle-seo-toc" class="w-full flex items-center justify-between text-left font-extrabold text-[#222222] text-sm sm:text-base cursor-pointer focus:outline-none select-none">';
	$toc_html .= '    <span class="flex items-center gap-2 text-[#222222]">';
	$toc_html .= '      <span class="material-symbols-outlined text-[#e60012] text-[22px]">list_alt</span>';
	$toc_html .= '      Nội dung chính';
	$toc_html .= '    </span>';
	$toc_html .= '    <span id="toc-chevron" class="material-symbols-outlined text-[#5f5e5e] transition-transform duration-200">expand_more</span>';
	$toc_html .= '  </button>';

	$toc_html .= '  <div id="seo-toc-list" class="mt-4 pt-3 border-t border-[#E5E7EB] text-xs sm:text-sm leading-relaxed">';
	$toc_html .= '    <ul class="space-y-2">';

	$in_sublist = false;

	foreach ( $toc_items as $item ) {
		if ( 'h2' === $item['tag'] ) {
			if ( $in_sublist ) {
				$toc_html  .= '</ul></li>';
				$in_sublist = false;
			}
			$toc_html .= '<li class="font-bold text-[#e60012]">';
			$toc_html .= '  <a href="#' . esc_attr( $item['anchor'] ) . '" class="text-[#e60012] hover:text-[#b7000c] hover:underline transition-colors">';
			$toc_html .= esc_html( $item['title'] );
			$toc_html .= '  </a>';
			$toc_html .= '</li>';
		} elseif ( 'h3' === $item['tag'] ) {
			if ( ! $in_sublist ) {
				$toc_html  .= '<li class="pt-0.5"><ul class="pl-5 space-y-1.5 list-disc text-[#5f5e5e]">';
				$in_sublist = true;
			}
			$toc_html .= '<li class="font-normal">';
			$toc_html .= '  <a href="#' . esc_attr( $item['anchor'] ) . '" class="text-[#b7000c] hover:text-[#e60012] hover:underline transition-colors">';
			$toc_html .= esc_html( $item['title'] );
			$toc_html .= '  </a>';
			$toc_html .= '</li>';
		}
	}

	if ( $in_sublist ) {
		$toc_html .= '</ul></li>';
	}

	$toc_html .= '    </ul>';
	$toc_html .= '  </div>';
	$toc_html .= '</div>';

	return array(
		'toc_html'     => $toc_html,
		'content_html' => $content_html,
	);
}

/**
 * Render Frontend Section: Thông Tin Ngành Hàng (SEO TGDD Standard with PhoneX Brand Palette)
 *
 * @param int $term_id
 */
function phonex_render_category_seo_frontend( $term_id = 0 ) {
	if ( empty( $term_id ) ) {
		$term_id = phonex_get_phone_cat_term_id();
	}

	$data = phonex_get_category_seo_data( $term_id );

	$badge_title = ! empty( $data['badge_title'] ) ? $data['badge_title'] : 'THÔNG TIN NGÀNH HÀNG';
	$sapo        = ! empty( $data['sapo'] ) ? $data['sapo'] : '';
	$raw_content = ! empty( $data['content'] ) ? $data['content'] : '';

	// Process TOC & anchor links
	$processed    = phonex_generate_toc_and_anchors( $raw_content );
	$toc_html     = $data['enable_toc'] ? $processed['toc_html'] : '';
	$content_html = $processed['content_html'];
	?>
	<!-- ================= 8. THÔNG TIN NGÀNH HÀNG (SEO TGDD Standard with PhoneX Brand Palette) ================= -->
	<div class="w-full flex justify-center mt-6">
		<div id="thong-tin-nganh-hang" class="w-full max-w-[820px] bg-white rounded-2xl p-5 sm:p-8 shadow-2xs border border-[#E5E7EB] space-y-6">
			
			<!-- Badge Header: THÔNG TIN NGÀNH HÀNG (Centered as in TGDD) -->
			<div class="flex flex-col items-center justify-center relative mb-2">
				<span class="inline-flex items-center justify-center px-6 py-2 rounded-lg border border-[#e9bcb6] text-[#e60012] bg-[#ffdad5] text-[15px] sm:text-[16px] font-bold uppercase tracking-wider shadow-2xs">
					<?php echo esc_html( $badge_title ); ?>
				</span>

				<?php if ( current_user_can( 'manage_options' ) ) : ?>
					<div class="mt-2 flex items-center gap-3">
						<a href="<?php echo esc_url( admin_url( 'term.php?taxonomy=product_cat&tag_ID=' . $term_id . '&post_type=product' ) ); ?>" class="text-[12px] font-bold text-[#5f5e5e] hover:text-[#e60012] transition-colors flex items-center gap-1" title="Sửa bài viết trong Danh Mục">
							<span class="material-symbols-outlined text-[15px]">category</span> Sửa trong Danh Mục
						</a>
						<span class="text-[#E5E7EB]">|</span>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=phonex-industry-seo' ) ); ?>" class="text-[12px] font-bold text-[#5f5e5e] hover:text-[#e60012] transition-colors flex items-center gap-1" title="Trang soạn thảo SEO">
							<span class="material-symbols-outlined text-[15px]">edit_note</span> Soạn thảo SEO
						</a>
					</div>
				<?php endif; ?>
			</div>

			<!-- Sapo Paragraph (Enlarged readable font) -->
			<?php if ( ! empty( $sapo ) ) : ?>
				<div class="text-[17px] sm:text-[18.5px] md:text-[19px] leading-[1.85] text-[#222222] text-left font-normal [&_a]:text-[#e60012] [&_a]:underline [&_a]:font-semibold hover:[&_a]:text-[#b7000c]">
					<?php echo wp_kses_post( $sapo ); ?>
				</div>
			<?php endif; ?>

			<!-- Table of Contents (Mục lục nội dung chính) -->
			<?php if ( ! empty( $toc_html ) ) : ?>
				<?php echo $toc_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>

			<!-- Expandable Article Content Wrapper (Enlarged typography) -->
			<div class="relative mt-2">
				<div id="seo-content-body" class="max-h-[360px] sm:max-h-[400px] overflow-hidden transition-all duration-500 space-y-5 text-[17px] sm:text-[18.5px] md:text-[19px] leading-[1.85] text-[#222222] [&>h2]:text-[22px] sm:[&>h2]:text-[26px] [&>h2]:font-black [&>h2]:text-[#222222] [&>h2]:pt-6 [&>h2]:pb-2 [&>h2]:border-b [&>h2]:border-[#E5E7EB] [&>h3]:text-[18px] sm:[&>h3]:text-[21px] [&>h3]:font-extrabold [&>h3]:text-[#b7000c] [&>h3]:pt-4 [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:space-y-3 [&>p]:leading-[1.85] [&>p]:mb-4 [&_a]:text-[#e60012] [&_a]:underline [&_a]:font-semibold hover:[&_a]:text-[#b7000c]">
					<?php echo $content_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<!-- Bottom Gradient Fade Overlay -->
				<div id="seo-fade-overlay" class="absolute bottom-0 left-0 right-0 h-36 bg-gradient-to-t from-white via-white/85 to-transparent pointer-events-none transition-opacity duration-300"></div>
			</div>

			<!-- Expand / Collapse Button (Clean Blue Link as in Screenshot) -->
			<div class="text-center pt-2 relative z-10">
				<button type="button" id="btn-toggle-seo-content" class="inline-flex items-center gap-1 text-[#e60012] hover:text-[#b7000c] text-[15px] sm:text-[16px] font-bold hover:underline transition-all cursor-pointer">
					<span id="btn-toggle-seo-text">Xem thêm</span>
					<span id="btn-toggle-seo-icon" class="material-symbols-outlined text-[20px] transition-transform duration-300">keyboard_arrow_down</span>
				</button>
			</div>

		</div>
	</div>

	<!-- JavaScript for SEO Article UX -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// 1. Table of Contents Collapse/Expand
		const btnToggleToc = document.getElementById('toggle-seo-toc');
		const tocList = document.getElementById('seo-toc-list');
		const tocChevron = document.getElementById('toc-chevron');

		if (btnToggleToc && tocList) {
			btnToggleToc.addEventListener('click', function() {
				tocList.classList.toggle('hidden');
				if (tocChevron) {
					tocChevron.classList.toggle('rotate-180');
				}
			});
		}

		// 2. Read More / Collapse Content
		const contentBody = document.getElementById('seo-content-body');
		const fadeOverlay = document.getElementById('seo-fade-overlay');
		const btnToggleMore = document.getElementById('btn-toggle-seo-content');
		const btnText = document.getElementById('btn-toggle-seo-text');
		const btnIcon = document.getElementById('btn-toggle-seo-icon');

		let isExpanded = false;

		if (btnToggleMore && contentBody) {
			btnToggleMore.addEventListener('click', function() {
				isExpanded = !isExpanded;
				if (isExpanded) {
					contentBody.classList.remove('max-h-[620px]');
					contentBody.classList.add('max-h-none');
					if (fadeOverlay) fadeOverlay.classList.add('opacity-0', 'pointer-events-none');
					if (btnText) btnText.textContent = 'Thu gọn';
					if (btnIcon) btnIcon.classList.add('rotate-180');
				} else {
					contentBody.classList.add('max-h-[380px]', 'sm:max-h-[420px]');
					contentBody.classList.remove('max-h-none');
					if (fadeOverlay) fadeOverlay.classList.remove('opacity-0');
					if (btnText) btnText.textContent = 'Xem thêm';
					if (btnIcon) btnIcon.classList.remove('rotate-180');

					// Smooth scroll back to top of SEO section
					const seoContainer = document.getElementById('thong-tin-nganh-hang');
					if (seoContainer) {
						seoContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}
				}
			});
		}

		// 3. Smooth scroll for TOC links
		document.querySelectorAll('#seo-toc-list a[href^="#"]').forEach(link => {
			link.addEventListener('click', function(e) {
				const targetId = this.getAttribute('href').substring(1);
				const targetEl = document.getElementById(targetId);
				if (targetEl) {
					e.preventDefault();
					if (!isExpanded && btnToggleMore) {
						btnToggleMore.click();
					}
					setTimeout(() => {
						targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}, 100);
				}
			});
		});
	});
	</script>
	<?php
}
