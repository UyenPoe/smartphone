<?php
/**
 * PhoneX Category SEO Content Management (Thông tin ngành hàng - Chuẩn TGDD)
 *
 * Allows administrators to write, edit, and manage rich SEO articles for
 * product categories (specifically "Điện Thoại") modeled after thegioididong.com.
 * Features:
 * - Admin page under "Sản phẩm > Thông tin ngành hàng"
 * - Taxonomy term meta fields in "Sản phẩm > Danh mục"
 * - Meta box on Page editor (Page ID 50 / template-phones.php)
 * - Auto-generated Table of Contents (Mục lục nội dung chính)
 * - Collapsible "Xem thêm / Thu gọn" box with gradient fade
 * - Pre-loaded default SEO article matching thegioididong layout
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get default SEO content for "Điện Thoại" matching TGDD structure
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
	);
}

/**
 * Get category SEO data from DB (or fallback to default)
 *
 * @param int $term_id Optional category term ID.
 * @return array
 */
function phonex_get_category_seo_data( $term_id = 0 ) {
	$defaults = phonex_get_default_category_seo_data();

	// Check if term meta exists
	if ( $term_id > 0 ) {
		$badge   = get_term_meta( $term_id, '_phonex_cat_seo_badge', true );
		$sapo    = get_term_meta( $term_id, '_phonex_cat_seo_sapo', true );
		$content = get_term_meta( $term_id, '_phonex_cat_seo_content', true );
		$toc     = get_term_meta( $term_id, '_phonex_cat_seo_toc', true );

		if ( ! empty( $content ) ) {
			return array(
				'badge_title' => ! empty( $badge ) ? $badge : $defaults['badge_title'],
				'sapo'        => ! empty( $sapo ) ? $sapo : $defaults['sapo'],
				'content'     => $content,
				'enable_toc'  => ( 'no' === $toc ) ? false : true,
			);
		}
	}

	// Check global phone SEO option
	$saved_opt = get_option( 'phonex_industry_seo_dien_thoai', null );
	if ( is_array( $saved_opt ) && ! empty( $saved_opt['content'] ) ) {
		return array(
			'badge_title' => ! empty( $saved_opt['badge_title'] ) ? $saved_opt['badge_title'] : $defaults['badge_title'],
			'sapo'        => isset( $saved_opt['sapo'] ) ? $saved_opt['sapo'] : $defaults['sapo'],
			'content'     => $saved_opt['content'],
			'enable_toc'  => isset( $saved_opt['enable_toc'] ) ? (bool) $saved_opt['enable_toc'] : true,
		);
	}

	// Also check Page ID 50 meta
	$page_content = get_post_meta( 50, '_phonex_category_seo_content', true );
	if ( ! empty( $page_content ) ) {
		$page_badge = get_post_meta( 50, '_phonex_category_seo_badge', true );
		$page_sapo  = get_post_meta( 50, '_phonex_category_seo_sapo', true );
		return array(
			'badge_title' => ! empty( $page_badge ) ? $page_badge : $defaults['badge_title'],
			'sapo'        => ! empty( $page_sapo ) ? $page_sapo : $defaults['sapo'],
			'content'     => $page_content,
			'enable_toc'  => true,
		);
	}

	return $defaults;
}

/**
 * Save Category SEO data
 *
 * @param int   $term_id
 * @param array $data
 */
function phonex_save_category_seo_data( $term_id, $data ) {
	$badge   = sanitize_text_field( $data['badge_title'] ?? 'THÔNG TIN NGÀNH HÀNG' );
	$sapo    = wp_kses_post( $data['sapo'] ?? '' );
	$content = wp_kses_post( $data['content'] ?? '' );
	$toc     = ! empty( $data['enable_toc'] ) ? 'yes' : 'no';

	if ( $term_id > 0 ) {
		update_term_meta( $term_id, '_phonex_cat_seo_badge', $badge );
		update_term_meta( $term_id, '_phonex_cat_seo_sapo', $sapo );
		update_term_meta( $term_id, '_phonex_cat_seo_content', $content );
		update_term_meta( $term_id, '_phonex_cat_seo_toc', $toc );
	}

	// Also save to global option for easy retrieval across templates
	update_option(
		'phonex_industry_seo_dien_thoai',
		array(
			'badge_title' => $badge,
			'sapo'        => $sapo,
			'content'     => $content,
			'enable_toc'  => ( 'yes' === $toc ),
		)
	);

	// Sync to Page ID 50
	update_post_meta( 50, '_phonex_category_seo_badge', $badge );
	update_post_meta( 50, '_phonex_category_seo_sapo', $sapo );
	update_post_meta( 50, '_phonex_category_seo_content', $content );
}

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
 * Render Admin Management Page
 */
function phonex_render_category_seo_admin_page() {
	// Handle reset to default
	if ( isset( $_POST['phonex_reset_default_seo'] ) && check_admin_referer( 'phonex_reset_seo_action', 'phonex_seo_nonce' ) ) {
		$default = phonex_get_default_category_seo_data();
		phonex_save_category_seo_data( 77, $default );
		echo '<div class="notice notice-success is-dismissible"><p><strong>Đã khôi phục bài viết SEO mẫu chuẩn Thế Giới Di Động thành công!</strong></p></div>';
	}

	// Handle Save
	if ( isset( $_POST['phonex_save_industry_seo'] ) && check_admin_referer( 'phonex_save_seo_action', 'phonex_seo_nonce' ) ) {
		$badge   = sanitize_text_field( $_POST['badge_title'] ?? 'THÔNG TIN NGÀNH HÀNG' );
		$sapo    = wp_unslash( $_POST['sapo'] ?? '' );
		$content = wp_unslash( $_POST['seo_content'] ?? '' );
		$toc     = isset( $_POST['enable_toc'] ) ? true : false;

		phonex_save_category_seo_data(
			77,
			array(
				'badge_title' => $badge,
				'sapo'        => $sapo,
				'content'     => $content,
				'enable_toc'  => $toc,
			)
		);
		echo '<div class="notice notice-success is-dismissible"><p><strong>Đã lưu nội dung Thông Tin Ngành Hàng thành công!</strong></p></div>';
	}

	$seo_data = phonex_get_category_seo_data( 77 );
	?>
	<div class="wrap" style="max-width: 1100px;">
		<h1 style="display:flex; align-items:center; gap:8px;">
			<span class="dashicons dashicons-text-page" style="font-size:28px; width:28px; height:28px; color:#b7000c;"></span>
			Quản Lý Bài Viết SEO Danh Mục: Thông Tin Ngành Hàng (Chuẩn TGDD)
		</h1>
		<p class="description" style="font-size: 14px; margin-bottom: 20px;">
			Trang này dùng để soạn thảo và hiển thị bài viết SEO chuẩn <strong>Thegioididong</strong> ở cuối trang danh mục 
			<a href="<?php echo esc_url( home_url( '/dien-thoai/' ) ); ?>" target="_blank" style="font-weight: bold; text-decoration: underline;">Điện Thoại (/dien-thoai/) ↗</a>.
			Bao gồm nhãn ngành hàng, đoạn sapo, mục lục nội dung tự động (Table of Contents), và bài viết phân tích chi tiết.
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
								<input name="badge_title" type="text" id="badge_title" value="<?php echo esc_attr( $seo_data['badge_title'] ); ?>" class="regular-text" style="font-weight: bold; color: #0284c7; border-color: #0284c7; border-radius: 6px;" />
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
									'teeny'         => false,
									'quicktags'     => true,
								);
								wp_editor( $seo_data['content'], 'phonex_seo_editor', $editor_settings );
								?>
								<p class="description" style="margin-top: 8px;">
									💡 <em>Mẹo SEO: Dùng các thẻ <code>&lt;h2&gt;</code> cho tiêu đề chính (1, 2, 3...) và <code>&lt;h3&gt;</code> cho các dòng máy (iPhone, Galaxy, OPPO...) để hệ thống tự động đánh chỉ mục vào bảng Mục lục nội dung chính.</em>
								</p>
							</td>
						</tr>
					</tbody>
				</table>

				<div style="margin-top: 24px; display:flex; align-items:center; gap:16px;">
					<button type="submit" name="phonex_save_industry_seo" class="button button-primary button-large" style="background:#b7000c; border-color:#b7000c; font-weight:bold; padding: 4px 24px;">
						💾 Lưu Bài Viết SEO Ngành Hàng
					</button>

					<a href="<?php echo esc_url( home_url( '/dien-thoai/' ) ); ?>" target="_blank" class="button button-secondary button-large" style="display:flex; align-items:center; gap:4px;">
						<span class="dashicons dashicons-visibility" style="margin-top:2px;"></span> Xem Trang Ngoài Web (Frontend)
					</a>
				</div>
			</form>
		</div>

		<!-- One-click Reset Section -->
		<div style="background:#fff8e5; border:1px solid #ffeeba; border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between;">
			<div>
				<strong style="color:#856404; font-size:14px;">Khôi phục bài viết mẫu chuẩn Thế Giới Di Động</strong>
				<p style="margin:4px 0 0; color:#856404; font-size:13px;">
					Nhấn nút này nếu bạn muốn nạp lại toàn bộ bài viết mẫu chuẩn SEO gồm 7 mục, bảng mục lục và cấu trúc ảnh giống trang thegioididong.com/dtdd.
				</p>
			</div>
			<form method="post" action="" onsubmit="return confirm('Bạn có chắc chắn muốn nạp lại nội dung bài viết SEO mẫu gốc của Thế Giới Di Động? Các thay đổi chưa lưu sẽ bị ghi đè.');">
				<?php wp_nonce_field( 'phonex_reset_seo_action', 'phonex_seo_nonce' ); ?>
				<button type="submit" name="phonex_reset_default_seo" class="button button-secondary" style="color:#856404; border-color:#ffeeba; background:#fff; font-weight:bold;">
					🔄 Nạp Lại Bài Mẫu TGDD
				</button>
			</form>
		</div>
	</div>
	<?php
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
			<h2 style="font-size: 18px; font-weight: bold; color: #b7000c; border-bottom: 2px solid #b7000c; padding-bottom: 8px;">
				📝 Thông Tin Ngành Hàng (Bài Viết Chuẩn SEO TGDD)
			</h2>
			<p class="description">Hiển thị ở chân trang danh mục với bố cục nhãn ngành hàng, bảng mục lục tương tác và bài viết chi tiết.</p>
		</th>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_badge">Nhãn Ngành Hàng (Badge)</label></th>
		<td>
			<input name="_phonex_cat_seo_badge" id="_phonex_cat_seo_badge" type="text" value="<?php echo esc_attr( $seo_data['badge_title'] ); ?>" />
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_sapo">Đoạn Mở Đầu (Sapo)</label></th>
		<td>
			<textarea name="_phonex_cat_seo_sapo" id="_phonex_cat_seo_sapo" rows="4"><?php echo esc_textarea( $seo_data['sapo'] ); ?></textarea>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="_phonex_cat_seo_content">Nội Dung Chi Tiết (SEO)</label></th>
		<td>
			<?php
			wp_editor(
				$seo_data['content'],
				'_phonex_cat_seo_content',
				array(
					'textarea_name' => '_phonex_cat_seo_content',
					'textarea_rows' => 15,
					'media_buttons' => true,
				)
			);
			?>
		</td>
	</tr>
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

		phonex_save_category_seo_data(
			$term_id,
			array(
				'badge_title' => $badge,
				'sapo'        => $sapo,
				'content'     => $content,
				'enable_toc'  => true,
			)
		);
	}
}
add_action( 'edited_product_cat', 'phonex_save_product_cat_seo_fields' );

/**
 * Add Meta Box on Page Editor (e.g. Page ID 50 / template-phones.php)
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
	// Only show note if not phone template, or show editor
	wp_nonce_field( 'phonex_page_seo_meta_save', 'phonex_page_seo_nonce' );
	$seo_data = phonex_get_category_seo_data( 77 );
	?>
	<div style="padding: 10px 0;">
		<p class="description" style="margin-bottom: 15px;">
			Cấu hình bài viết <strong>Thông Tin Ngành Hàng</strong> hiển thị ở cuối trang Danh Mục Điện Thoại.
			Bạn cũng có thể quản lý trực tiếp tại menu <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=phonex-industry-seo' ) ); ?>" target="_blank" style="font-weight:bold;">Sản phẩm &gt; 📝 Thông tin ngành hàng</a>.
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

	// Use regex to find all h2 and h3
	$toc_items    = array();
	$counter_h2   = 0;
	$counter_h3   = 0;
	$current_item = null;

	// Add ids if not present
	$content_html = preg_replace_callback(
		'/<(h[23])([^>]*)>(.*?)<\/\1>/is',
		function ( $matches ) use ( &$toc_items, &$counter_h2, &$counter_h3 ) {
			$tag   = strtolower( $matches[1] );
			$attrs = $matches[2];
			$title = wp_strip_all_tags( $matches[3] );

			// Check if id exists
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

			// Return updated heading with smooth-scroll scroll-margin-top
			return '<' . $tag . $attrs . ' class="scroll-mt-24">' . $matches[3] . '</' . $tag . '>';
		},
		$html
	);

	// Build TOC HTML
	if ( empty( $toc_items ) ) {
		return array(
			'toc_html'     => '',
			'content_html' => $content_html,
		);
	}

	$toc_html  = '<div id="seo-toc-container" class="my-5 rounded-2xl border border-blue-100 bg-[#f4f8fd] p-5 sm:p-6 transition-all shadow-2xs">';
	$toc_html .= '  <button type="button" id="toggle-seo-toc" class="w-full flex items-center justify-between text-left font-bold text-gray-900 text-sm sm:text-base cursor-pointer focus:outline-none select-none">';
	$toc_html .= '    <span class="flex items-center gap-2 text-gray-900">';
	$toc_html .= '      <span class="material-symbols-outlined text-blue-600 text-[22px]">list_alt</span>';
	$toc_html .= '      Nội dung chính';
	$toc_html .= '    </span>';
	$toc_html .= '    <span id="toc-chevron" class="material-symbols-outlined text-gray-500 transition-transform duration-200">expand_more</span>';
	$toc_html .= '  </button>';

	$toc_html .= '  <div id="seo-toc-list" class="mt-4 pt-3 border-t border-blue-100/70 text-xs sm:text-sm leading-relaxed">';
	$toc_html .= '    <ul class="space-y-2">';

	$in_sublist = false;

	foreach ( $toc_items as $item ) {
		if ( 'h2' === $item['tag'] ) {
			if ( $in_sublist ) {
				$toc_html  .= '</ul></li>';
				$in_sublist = false;
			}
			$toc_html .= '<li class="font-bold text-blue-700">';
			$toc_html .= '  <a href="#' . esc_attr( $item['anchor'] ) . '" class="text-[#0071e3] hover:text-blue-900 hover:underline transition-colors">';
			$toc_html .= esc_html( $item['title'] );
			$toc_html .= '  </a>';
			$toc_html .= '</li>';
		} elseif ( 'h3' === $item['tag'] ) {
			if ( ! $in_sublist ) {
				$toc_html  .= '<li class="pt-0.5"><ul class="pl-5 space-y-1.5 list-disc text-gray-600">';
				$in_sublist = true;
			}
			$toc_html .= '<li class="font-normal">';
			$toc_html .= '  <a href="#' . esc_attr( $item['anchor'] ) . '" class="text-blue-600 hover:text-blue-900 hover:underline transition-colors">';
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
 * Render Frontend Section: Thông Tin Ngành Hàng (SEO TGDD Standard)
 *
 * @param int $term_id
 */
function phonex_render_category_seo_frontend( $term_id = 77 ) {
	$data = phonex_get_category_seo_data( $term_id );

	$badge_title = ! empty( $data['badge_title'] ) ? $data['badge_title'] : 'THÔNG TIN NGÀNH HÀNG';
	$sapo        = ! empty( $data['sapo'] ) ? $data['sapo'] : '';
	$raw_content = ! empty( $data['content'] ) ? $data['content'] : '';

	// Process TOC & anchor links
	$processed    = phonex_generate_toc_and_anchors( $raw_content );
	$toc_html     = $data['enable_toc'] ? $processed['toc_html'] : '';
	$content_html = $processed['content_html'];
	?>
	<!-- ================= 8. THÔNG TIN NGÀNH HÀNG (SEO TGDD Standard) ================= -->
	<div id="thong-tin-nganh-hang" class="bg-white rounded-2xl p-6 sm:p-8 shadow-2xs border border-gray-100 space-y-5 mt-8">
		
		<!-- Badge Header: THÔNG TIN NGÀNH HÀNG -->
		<div class="flex items-center justify-between flex-wrap gap-3">
			<div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border-2 border-blue-500 text-blue-600 bg-blue-50/50 text-xs sm:text-sm font-extrabold uppercase tracking-wide shadow-2xs">
				<span class="material-symbols-outlined text-[18px]">verified</span>
				<span><?php echo esc_html( $badge_title ); ?></span>
			</div>

			<?php if ( current_user_can( 'manage_options' ) ) : ?>
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=phonex-industry-seo' ) ); ?>" class="text-[12px] font-bold text-gray-400 hover:text-primary transition-colors flex items-center gap-1" title="Chỉnh sửa bài viết SEO này">
					<span class="material-symbols-outlined text-[16px]">edit_note</span> Sửa nội dung SEO
				</a>
			<?php endif; ?>
		</div>

		<!-- Sapo Paragraph -->
		<?php if ( ! empty( $sapo ) ) : ?>
			<div class="text-xs sm:text-sm leading-relaxed text-gray-700 bg-gray-50/70 p-4 rounded-xl border border-gray-100">
				<?php echo wp_kses_post( $sapo ); ?>
			</div>
		<?php endif; ?>

		<!-- Table of Contents (Mục lục nội dung chính) -->
		<?php if ( ! empty( $toc_html ) ) : ?>
			<?php echo $toc_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>

		<!-- Expandable Article Content Wrapper -->
		<div class="relative mt-4">
			<div id="seo-content-body" class="max-h-[620px] overflow-hidden transition-all duration-500 space-y-4 text-xs sm:text-sm leading-relaxed text-gray-700 [&>h2]:text-base sm:[&>h2]:text-lg [&>h2]:font-black [&>h2]:text-gray-900 [&>h2]:pt-4 [&>h2]:pb-1 [&>h2]:border-b [&>h2]:border-gray-100 [&>h3]:text-sm sm:[&>h3]:text-base [&>h3]:font-extrabold [&>h3]:text-gray-900 [&>h3]:pt-2 [&>ul]:list-disc [&>ul]:pl-5 [&>ul]:space-y-1.5 [&>p]:leading-relaxed">
				<?php echo $content_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<!-- Bottom Gradient Fade Overlay -->
			<div id="seo-fade-overlay" class="absolute bottom-0 left-0 right-0 h-36 bg-gradient-to-t from-white via-white/85 to-transparent pointer-events-none transition-opacity duration-300"></div>
		</div>

		<!-- Expand / Collapse Button -->
		<div class="text-center pt-2 relative z-10">
			<button type="button" id="btn-toggle-seo-content" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-800 text-xs sm:text-sm font-extrabold shadow-2xs hover:shadow-xs transition-all cursor-pointer">
				<span id="btn-toggle-seo-text">Xem thêm nội dung</span>
				<span id="btn-toggle-seo-icon" class="material-symbols-outlined text-[18px] transition-transform duration-300">keyboard_arrow_down</span>
			</button>
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
					if (btnText) btnText.textContent = 'Thu gọn nội dung';
					if (btnIcon) btnIcon.classList.add('rotate-180');
				} else {
					contentBody.classList.add('max-h-[620px]');
					contentBody.classList.remove('max-h-none');
					if (fadeOverlay) fadeOverlay.classList.remove('opacity-0');
					if (btnText) btnText.textContent = 'Xem thêm nội dung';
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
					// If collapsed, expand it first
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
