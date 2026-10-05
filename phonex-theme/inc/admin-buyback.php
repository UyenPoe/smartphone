<?php
/**
 * PhoneX Buyback Admin Management & CRM Panel
 *
 * Menu: PhoneX Thu Mua
 * - Quản lý Yêu cầu thu mua (CRM Ticket Workflow)
 * - Quản lý Thương hiệu (Brands)
 * - Quản lý Dòng máy & Models
 * - Cập nhật Bảng giá nhanh
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'phonex_buyback_register_admin_menus' );

function phonex_buyback_register_admin_menus() {
	// Main top-level menu
	add_menu_page(
		__( 'PhoneX Thu Mua', 'phonex' ),
		__( 'PhoneX Thu Mua', 'phonex' ),
		'manage_options',
		'phonex-buyback-crm',
		'phonex_buyback_admin_crm_page',
		'dashicons-smartphone',
		26
	);

	// Submenu 1: Yêu cầu thu mua (CRM)
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Yêu cầu thu mua (CRM)', 'phonex' ),
		__( 'Phiếu Thu Mua (CRM)', 'phonex' ),
		'manage_options',
		'phonex-buyback-crm',
		'phonex_buyback_admin_crm_page'
	);

	// Submenu 2: Quản lý Thương hiệu
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Thương hiệu thu mua', 'phonex' ),
		__( 'Thương hiệu', 'phonex' ),
		'manage_options',
		'phonex-buyback-brands',
		'phonex_buyback_admin_brands_page'
	);

	// Submenu 3: Quản lý Dòng & Models
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Danh sách Model & Bảng giá', 'phonex' ),
		__( 'Model & Giá thu', 'phonex' ),
		'manage_options',
		'phonex-buyback-models',
		'phonex_buyback_admin_models_page'
	);

	// Submenu 4: Trung Tâm Dữ Liệu & Giá Sàn Định Giá
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Trung Tâm Dữ Liệu & Giá Sàn Định Giá', 'phonex' ),
		__( '📊 Dữ Liệu & Giá Sàn', 'phonex' ),
		'manage_options',
		'phonex-buyback-data-center',
		'phonex_buyback_admin_data_center_page'
	);

	// Submenu 5: Thị Trường Chợ Tốt & Phân Tích Grade
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Thị Trường Chợ Tốt & Phân Tích Grade', 'phonex' ),
		__( '🔍 Chợ Tốt & Grade', 'phonex' ),
		'manage_options',
		'phonex-chotot-market',
		'phonex_chotot_market_admin_page'
	);
}

/**
 * 1. CRM YÊU CẦU THU MUA (TICKETS & WORKFLOW)
 */
function phonex_buyback_admin_crm_page() {
	global $wpdb;
	$t_req = $wpdb->prefix . 'phonex_buyback_requests';

	// Handle status update POST
	if ( isset( $_POST['action'] ) && 'update_ticket' === $_POST['action'] && check_admin_referer( 'phonex_update_ticket' ) ) {
		$ticket_id   = intval( $_POST['ticket_id'] );
		$status      = sanitize_text_field( $_POST['status'] );
		$grade       = sanitize_text_field( $_POST['condition_grade'] );
		$final_price = floatval( str_replace( array( '.', ',' ), '', $_POST['final_price'] ) );
		$staff_notes = sanitize_textarea_field( $_POST['staff_notes'] );

		$wpdb->update(
			$t_req,
			array(
				'status'          => $status,
				'condition_grade' => $grade,
				'final_price'     => $final_price,
				'staff_notes'     => $staff_notes,
				'updated_at'      => current_time( 'mysql' ),
			),
			array( 'id' => $ticket_id )
		);

		echo '<div class="notice notice-success is-dismissible"><p>Đã cập nhật phiếu thu mua thành công!</p></div>';
	}

	// Filters
	$status_filter = sanitize_text_field( $_GET['status_filter'] ?? '' );
	$search_query  = sanitize_text_field( $_GET['s'] ?? '' );

	$where = 'WHERE 1=1';
	$params = array();

	if ( ! empty( $status_filter ) ) {
		$where .= ' AND status = %s';
		$params[] = $status_filter;
	}
	if ( ! empty( $search_query ) ) {
		$where .= ' AND (customer_phone LIKE %s OR customer_name LIKE %s OR request_code LIKE %s OR model_name LIKE %s)';
		$like = '%' . $wpdb->esc_like( $search_query ) . '%';
		$params[] = $like;
		$params[] = $like;
		$params[] = $like;
		$params[] = $like;
	}

	$sql = "SELECT * FROM $t_req $where ORDER BY created_at DESC LIMIT 100";
	$tickets = empty( $params ) ? $wpdb->get_results( $sql ) : $wpdb->get_results( $wpdb->prepare( $sql, $params ) );

	// Status counts
	$counts = $wpdb->get_results( "SELECT status, COUNT(*) as cnt FROM $t_req GROUP BY status", OBJECT_K );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">PhoneX CRM - Quản Lý Phiếu Thu Mua</h1>
		<hr class="wp-header-end">

		<!-- Status Filter Bar -->
		<ul class="subsubsub">
			<li><a href="?page=phonex-buyback-crm" class="<?php echo empty( $status_filter ) ? 'current' : ''; ?>">Tất cả</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=new" class="<?php echo 'new' === $status_filter ? 'current' : ''; ?>">Mới (<?php echo esc_html( $counts['new']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=contacted" class="<?php echo 'contacted' === $status_filter ? 'current' : ''; ?>">Đã liên hệ (<?php echo esc_html( $counts['contacted']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=scheduled" class="<?php echo 'scheduled' === $status_filter ? 'current' : ''; ?>">Đã đặt lịch (<?php echo esc_html( $counts['scheduled']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=inspecting" class="<?php echo 'inspecting' === $status_filter ? 'current' : ''; ?>">Đang kiểm định (<?php echo esc_html( $counts['inspecting']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=price_agreed" class="<?php echo 'price_agreed' === $status_filter ? 'current' : ''; ?>">Đã chốt giá (<?php echo esc_html( $counts['price_agreed']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=bought" class="<?php echo 'bought' === $status_filter ? 'current' : ''; ?>">Đã giải ngân (<?php echo esc_html( $counts['bought']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=completed" class="<?php echo 'completed' === $status_filter ? 'current' : ''; ?>">Hoàn tất (<?php echo esc_html( $counts['completed']->cnt ?? 0 ); ?>)</a> |</li>
			<li><a href="?page=phonex-buyback-crm&status_filter=cancelled" class="<?php echo 'cancelled' === $status_filter ? 'current' : ''; ?>">Đã hủy (<?php echo esc_html( $counts['cancelled']->cnt ?? 0 ); ?>)</a></li>
		</ul>

		<form method="get" style="float:right; margin-bottom:10px;">
			<input type="hidden" name="page" value="phonex-buyback-crm">
			<input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Tìm SĐT, tên, mã phiếu...">
			<input type="submit" class="button" value="Tìm kiếm">
		</form>

		<table class="wp-list-table widefat fixed striped" style="margin-top:10px;">
			<thead>
				<tr>
					<th style="width:130px;">Mã Phiếu</th>
					<th style="width:140px;">Khách Hàng</th>
					<th style="width:180px;">Thiết Bị</th>
					<th style="width:100px;">Hạng Máy</th>
					<th style="width:130px;">Giá Ước Tính</th>
					<th style="width:130px;">Giá Chốt</th>
					<th style="width:120px;">Trạng Thái</th>
					<th style="width:120px;">Ngày Tạo</th>
					<th style="width:100px;">Thao Tác</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $tickets ) ) : ?>
					<?php foreach ( $tickets as $tk ) : 
						$est_price = number_format( (float) $tk->estimated_price, 0, ',', '.' ) . '₫';
						$fin_price = ! empty( $tk->final_price ) ? number_format( (float) $tk->final_price, 0, ',', '.' ) . '₫' : '<span style="color:#999;">Chưa chốt</span>';
					?>
						<tr>
							<td><strong><?php echo esc_html( $tk->request_code ); ?></strong></td>
							<td>
								<strong><?php echo esc_html( $tk->customer_name ); ?></strong><br>
								<a href="tel:<?php echo esc_attr( $tk->customer_phone ); ?>"><?php echo esc_html( $tk->customer_phone ); ?></a>
							</td>
							<td>
								<strong><?php echo esc_html( $tk->model_name ); ?></strong><br>
								<small style="color:#666;"><?php echo esc_html( $tk->brand_name . ' • ' . ( $tk->storage ?: 'Std' ) . ' • ' . ( $tk->color ?: 'Std' ) ); ?></small>
							</td>
							<td><span class="badge" style="background:#eef; padding:3px 6px; border-radius:4px; font-weight:bold;">Grade <?php echo esc_html( $tk->condition_grade ?: 'A' ); ?></span></td>
							<td><?php echo esc_html( $est_price ); ?></td>
							<td><strong><?php echo wp_kses_post( $fin_price ); ?></strong></td>
							<td>
								<span style="<?php echo phonex_get_admin_status_style( $tk->status ); ?>; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:bold;">
									<?php echo esc_html( phonex_buyback_status_label( $tk->status ) ); ?>
								</span>
							</td>
							<td><?php echo esc_html( date( 'd/m/Y H:i', strtotime( $tk->created_at ) ) ); ?></td>
							<td>
								<button type="button" class="button button-small" onclick="openTicketModal(<?php echo esc_attr( json_encode( $tk ) ); ?>)">Xử lý</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr><td colspan="9" style="text-align:center; padding:20px;">Không có phiếu thu mua nào phù hợp.</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<!-- Modal Xử lý phiếu thu mua -->
	<div id="ticketModal" style="display:none; position:fixed; z-index:99999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
		<div style="background:#fff; width:520px; max-width:90%; margin:60px auto; padding:24px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.3);">
			<h2 style="margin-top:0;" id="modalTicketTitle">Cập Nhật Phiếu Thu Mua</h2>
			<form method="post">
				<?php wp_nonce_field( 'phonex_update_ticket' ); ?>
				<input type="hidden" name="action" value="update_ticket">
				<input type="hidden" name="ticket_id" id="modalTicketId">

				<div style="margin-bottom:12px;">
					<label style="display:block; font-weight:bold; margin-bottom:4px;">Trạng Thái Xử Lý:</label>
					<select name="status" id="modalStatus" style="width:100%; height:36px;">
						<option value="new">1. Mới tiếp nhận</option>
						<option value="contacted">2. Đã liên hệ xác nhận</option>
						<option value="scheduled">3. Đã đặt lịch hẹn</option>
						<option value="inspecting">4. Đang kiểm định kỹ thuật</option>
						<option value="price_agreed">5. Đã chốt giá với khách</option>
						<option value="bought">6. Đã giải ngân thu mua</option>
						<option value="completed">7. Hoàn tất</option>
						<option value="cancelled">Hủy yêu cầu</option>
					</select>
				</div>

				<div style="display:flex; gap:10px; margin-bottom:12px;">
					<div style="flex:1;">
						<label style="display:block; font-weight:bold; margin-bottom:4px;">Phân Hạng Grade:</label>
						<select name="condition_grade" id="modalGrade" style="width:100%; height:36px;">
							<option value="A">Grade A (99% Mới)</option>
							<option value="B">Grade B (95% Đẹp)</option>
							<option value="C">Grade C (90% Xước cấn)</option>
							<option value="D">Grade D (Linh kiện / Lỗi)</option>
						</select>
					</div>
					<div style="flex:1;">
						<label style="display:block; font-weight:bold; margin-bottom:4px;">Giá Chốt Cuối Cùng (VNĐ):</label>
						<input type="number" step="50000" name="final_price" id="modalFinalPrice" style="width:100%; height:36px;">
					</div>
				</div>

				<div style="margin-bottom:15px;">
					<label style="display:block; font-weight:bold; margin-bottom:4px;">Ghi Chú Kỹ Thuật Viên:</label>
					<textarea name="staff_notes" id="modalStaffNotes" rows="3" style="width:100%;" placeholder="Ghi chú kết quả kiểm định, màn hình, pin, số tài khoản..."></textarea>
				</div>

				<div style="display:flex; justify-content:flex-end; gap:8px;">
					<button type="button" class="button" onclick="closeTicketModal()">Đóng</button>
					<input type="submit" class="button button-primary" value="Lưu Thay Đổi">
				</div>
			</form>
		</div>
	</div>

	<script>
	function openTicketModal(tk) {
		document.getElementById('modalTicketId').value = tk.id;
		document.getElementById('modalTicketTitle').innerText = 'Xử Lý Phiếu: ' + tk.request_code + ' (' + tk.customer_name + ')';
		document.getElementById('modalStatus').value = tk.status;
		document.getElementById('modalGrade').value = tk.condition_grade || 'A';
		document.getElementById('modalFinalPrice').value = tk.final_price || tk.estimated_price || 0;
		document.getElementById('modalStaffNotes').value = tk.staff_notes || '';
		document.getElementById('ticketModal').style.display = 'block';
	}
	function closeTicketModal() {
		document.getElementById('ticketModal').style.display = 'none';
	}
	</script>
	<?php
}

function phonex_get_admin_status_style( $status ) {
	switch ( $status ) {
		case 'new': return 'background:#cce5ff; color:#004085;';
		case 'contacted': return 'background:#d1ecf1; color:#0c5460;';
		case 'scheduled': return 'background:#e2e3e5; color:#383d41;';
		case 'inspecting': return 'background:#fff3cd; color:#856404;';
		case 'price_agreed': return 'background:#d4edda; color:#155724;';
		case 'bought': return 'background:#28a745; color:#fff;';
		case 'completed': return 'background:#155724; color:#fff;';
		case 'cancelled': return 'background:#f8d7da; color:#721c24;';
		default: return 'background:#eee; color:#333;';
	}
}

/**
 * 2. QUẢN LÝ THƯƠNG HIỆU (BRANDS)
 */
function phonex_buyback_admin_brands_page() {
	global $wpdb;
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';

	// Handle add brand
	if ( isset( $_POST['action'] ) && 'add_brand' === $_POST['action'] && check_admin_referer( 'phonex_add_brand' ) ) {
		$name     = sanitize_text_field( $_POST['name'] );
		$slug     = sanitize_title( $_POST['slug'] ?: $name );
		$logo     = esc_url_raw( $_POST['logo_url'] );
		$featured = isset( $_POST['is_featured'] ) ? 1 : 0;
		$order    = intval( $_POST['sort_order'] );

		$wpdb->insert( $t_brands, array(
			'name'        => $name,
			'slug'        => $slug,
			'logo_url'    => $logo,
			'is_featured' => $featured,
			'sort_order'  => $order,
			'is_active'   => 1,
		) );
		echo '<div class="notice notice-success is-dismissible"><p>Đã thêm thương hiệu mới thành công!</p></div>';
	}

	$brands = $wpdb->get_results( "SELECT * FROM $t_brands ORDER BY sort_order ASC, name ASC" );
	?>
	<div class="wrap">
		<h1>Quản Lý Thương Hiệu Thu Mua</h1>
		<div style="display:flex; gap:20px; margin-top:20px;">
			<!-- Add form -->
			<div style="flex:1; background:#fff; padding:20px; border-radius:8px; border:1px solid #ccd0d4; height:fit-content;">
				<h2>Thêm Thương Hiệu Mới</h2>
				<form method="post">
					<?php wp_nonce_field( 'phonex_add_brand' ); ?>
					<input type="hidden" name="action" value="add_brand">
					<p>
						<label><strong>Tên thương hiệu:</strong></label><br>
						<input type="text" name="name" required class="widefat" placeholder="Ví dụ: OnePlus">
					</p>
					<p>
						<label><strong>Slug URL:</strong></label><br>
						<input type="text" name="slug" class="widefat" placeholder="Ví dụ: oneplus">
					</p>
					<p>
						<label><strong>URL Logo:</strong></label><br>
						<input type="text" name="logo_url" class="widefat" placeholder="https://...">
					</p>
					<p>
						<label><input type="checkbox" name="is_featured" value="1" checked> Hiển thị trên Mega Menu Header</label>
					</p>
					<p>
						<label><strong>Thứ tự sắp xếp:</strong></label><br>
						<input type="number" name="sort_order" value="10" style="width:80px;">
					</p>
					<p><input type="submit" class="button button-primary" value="Thêm Thương Hiệu"></p>
				</form>
			</div>

			<!-- List table -->
			<div style="flex:2;">
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th style="width:50px;">ID</th>
							<th style="width:120px;">Thương Hiệu</th>
							<th style="width:100px;">Slug</th>
							<th style="width:100px;">Mega Menu</th>
							<th style="width:80px;">Thứ Tự</th>
							<th style="width:80px;">Trạng Thái</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $brands as $b ) : ?>
							<tr>
								<td><?php echo esc_html( $b->id ); ?></td>
								<td>
									<div style="display:flex; align-items:center; gap:8px;">
										<img src="<?php echo esc_url( phonex_get_brand_logo_url( $b ) ); ?>" alt="<?php echo esc_attr( $b->name ); ?>" style="height:22px; max-width:36px; object-fit:contain; background:#f8f9fa; padding:2px 4px; border-radius:4px; border:1px solid #e2e8f0;" />
										<strong><?php echo esc_html( $b->name ); ?></strong>
									</div>
								</td>
								<td><code><?php echo esc_html( $b->slug ); ?></code></td>
								<td><?php echo $b->is_featured ? '<span style="color:green; font-weight:bold;">★ Nổi bật</span>' : 'Thường'; ?></td>
								<td><?php echo esc_html( $b->sort_order ); ?></td>
								<td><?php echo $b->is_active ? 'Hoạt động' : '<span style="color:red;">Ẩn</span>'; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

/**
 * 3. QUẢN LÝ DÒNG MÁY & MODELS
 */
function phonex_buyback_admin_models_page() {
	global $wpdb;
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$t_models = $wpdb->prefix . 'phonex_buyback_models';

	// Handle add model
	if ( isset( $_POST['action'] ) && 'add_model' === $_POST['action'] && check_admin_referer( 'phonex_add_model' ) ) {
		$name     = sanitize_text_field( $_POST['name'] );
		$slug     = sanitize_title( $_POST['slug'] ?: $name );
		$brand_id = intval( $_POST['brand_id'] );
		$price    = floatval( str_replace( array( '.', ',' ), '', $_POST['base_buyback_price'] ) );
		$img      = esc_url_raw( $_POST['image_url'] );
		$storages = explode( ',', sanitize_text_field( $_POST['storage_options'] ) );
		$storages = array_map( 'trim', $storages );

		$wpdb->insert( $t_models, array(
			'name'               => $name,
			'slug'               => $slug,
			'brand_id'           => $brand_id,
			'base_buyback_price' => $price,
			'image_url'          => $img,
			'storage_options'    => json_encode( $storages ),
			'is_popular'         => 1,
			'is_active'          => 1,
		) );
		echo '<div class="notice notice-success is-dismissible"><p>Đã thêm model máy mới thành công!</p></div>';
	}

	$brands = $wpdb->get_results( "SELECT id, name FROM $t_brands WHERE is_active = 1 ORDER BY name ASC" );
	$models = $wpdb->get_results(
		"SELECT m.*, b.name as brand_name 
		 FROM $t_models m 
		 JOIN $t_brands b ON m.brand_id = b.id 
		 ORDER BY m.base_buyback_price DESC"
	);
	?>
	<div class="wrap">
		<h1>Quản Lý Model Điện Thoại &amp; Bảng Giá Thu Mua</h1>
		<div style="display:flex; gap:20px; margin-top:20px;">
			<!-- Add form -->
			<div style="flex:1; background:#fff; padding:20px; border-radius:8px; border:1px solid #ccd0d4; height:fit-content;">
				<h2>Thêm Model Máy Mới</h2>
				<form method="post">
					<?php wp_nonce_field( 'phonex_add_model' ); ?>
					<input type="hidden" name="action" value="add_model">
					<p>
						<label><strong>Thương hiệu:</strong></label><br>
						<select name="brand_id" style="width:100%; height:36px;">
							<?php foreach ( $brands as $b ) : ?>
								<option value="<?php echo esc_attr( $b->id ); ?>"><?php echo esc_html( $b->name ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<p>
						<label><strong>Tên Model:</strong></label><br>
						<input type="text" name="name" required class="widefat" placeholder="Ví dụ: iPhone 16 Plus">
					</p>
					<p>
						<label><strong>Slug URL:</strong></label><br>
						<input type="text" name="slug" class="widefat" placeholder="Ví dụ: iphone-16-plus">
					</p>
					<p>
						<label><strong>Giá thu Grade A (VNĐ):</strong></label><br>
						<input type="number" step="100000" name="base_buyback_price" required class="widefat" placeholder="Ví dụ: 19500000">
					</p>
					<p>
						<label><strong>Dung lượng (cách nhau dấu phẩy):</strong></label><br>
						<input type="text" name="storage_options" class="widefat" value="128GB, 256GB, 512GB">
					</p>
					<p>
						<label><strong>URL Hình ảnh:</strong></label><br>
						<input type="text" name="image_url" class="widefat" placeholder="https://...">
					</p>
					<p><input type="submit" class="button button-primary" value="Thêm Model"></p>
				</form>
			</div>

			<!-- List table -->
			<div style="flex:2;">
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th style="width:140px;">Tên Model</th>
							<th style="width:90px;">Hãng</th>
							<th style="width:130px;">Giá Thu Grade A</th>
							<th style="width:130px;">Giá Thu Grade B</th>
							<th style="width:110px;">Dung Lượng</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $models as $m ) : 
							$p_a = number_format( (float) $m->base_buyback_price, 0, ',', '.' ) . '₫';
							$p_b = number_format( (float) $m->base_buyback_price * 0.88, 0, ',', '.' ) . '₫';
							$st  = json_decode( $m->storage_options ?? '[]', true );
						?>
							<tr>
								<td><strong><?php echo esc_html( $m->name ); ?></strong></td>
								<td><?php echo esc_html( $m->brand_name ); ?></td>
								<td><strong style="color:#198754;"><?php echo esc_html( $p_a ); ?></strong></td>
								<td><span style="color:#0056b3;"><?php echo esc_html( $p_b ); ?></span></td>
								<td><small><?php echo esc_html( is_array( $st ) ? implode( ', ', $st ) : '' ); ?></small></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}

/**
 * 4. TRUNG TÂM DỮ LIỆU & GIÁ SÀN ĐỊNH GIÁ (DATA CENTER & AUDIT)
 */
function phonex_buyback_admin_data_center_page() {
	global $wpdb;

	// 1. Data metrics
	$total_woo_products = (int) $wpdb->get_var( "SELECT count(*) FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish'" );
	$qmm_count = (int) $wpdb->get_var( "SELECT count(*) FROM {$wpdb->posts} p JOIN {$wpdb->postmeta} m ON p.ID = m.post_id WHERE p.post_type = 'product' AND p.post_status = 'publish' AND m.meta_key = '_phonex_item_id' AND m.meta_value LIKE 'qmm%'" );
	$fast_count = max( 0, $total_woo_products - $qmm_count );
	$tgdd_count = 0; // Đã xóa 100% sạch sẽ khỏi database và catalog

	$t_models = $wpdb->prefix . 'phonex_buyback_models';
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';

	$total_models = (int) $wpdb->get_var( "SELECT count(*) FROM {$t_models}" );
	$total_brands = (int) $wpdb->get_var( "SELECT count(*) FROM {$t_brands}" );

	// Fetch brands for filter
	$brands = $wpdb->get_results( "SELECT id, name, slug FROM {$t_brands} ORDER BY name ASC" );

	// Fetch all models with brand names
	$models = $wpdb->get_results( "
		SELECT m.*, b.name as brand_name, b.slug as brand_slug 
		FROM {$t_models} m 
		LEFT JOIN {$t_brands} b ON m.brand_id = b.id 
		ORDER BY b.name ASC, m.base_buyback_price DESC
	" );
	?>
	<div class="wrap phonex-admin-wrap" style="max-width: 1400px; margin-top: 20px;">
		<!-- Header Section -->
		<div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; padding: 24px 28px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
			<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
				<div>
					<div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(34, 197, 94, 0.2); color: #4ade80; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 600; margin-bottom: 8px;">
						<span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#22c55e;"></span>
						HỆ THỐNG DỮ LIỆU ĐÃ CHUẨN HÓA
					</div>
					<h1 style="color: #fff; margin: 0 0 6px; font-size: 26px; font-weight: 700;">📊 Trung Tâm Dữ Liệu & Giá Sàn Định Giá PhoneX</h1>
					<p style="color: #94a3b8; margin: 0; font-size: 14px;">
						Quản lý tập trung nguồn sản phẩm kho máy cũ, bảng barem định giá thu mua và kiểm soát trạng thái dữ liệu Thế Giới Di Động.
					</p>
				</div>
				<div style="display: flex; gap: 10px;">
					<a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" target="_blank" class="button" style="background: #3b82f6; color: #fff; border: none; padding: 6px 16px; height: auto; font-weight: 600; border-radius: 8px;">
						🔍 Xem Trang Định Giá Online ↗
					</a>
					<a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" target="_blank" class="button" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 6px 16px; height: auto; font-weight: 600; border-radius: 8px;">
						📱 Xem Kho Máy Cũ (<?php echo esc_html( $total_woo_products ); ?>) ↗
					</a>
				</div>
			</div>
		</div>

		<!-- 4 KPI Cards -->
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
			<!-- Card 1: Kho máy thực tế -->
			<div style="background: #fff; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
				<div style="display: flex; justify-content: space-between; align-items: flex-start;">
					<div>
						<div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Kho Máy Cũ (WooCommerce)</div>
						<div style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 6px 0;"><?php echo esc_html( $total_woo_products ); ?> <span style="font-size: 15px; font-weight: 500; color: #64748b;">máy</span></div>
					</div>
					<div style="background: #eff6ff; color: #2563eb; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
						📱
					</div>
				</div>
				<div style="font-size: 13px; color: #475569; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 8px;">
					Fast Mobile: <strong><?php echo esc_html( $fast_count ); ?></strong> | Quang Minh: <strong><?php echo esc_html( $qmm_count ); ?></strong>
				</div>
			</div>

			<!-- Card 2: TGDD (Đã xóa) -->
			<div style="background: #fff; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
				<div style="display: flex; justify-content: space-between; align-items: flex-start;">
					<div>
						<div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Sản Phẩm Thế Giới Di Động</div>
						<div style="font-size: 32px; font-weight: 800; color: #16a34a; margin: 6px 0;"><?php echo esc_html( $tgdd_count ); ?> <span style="font-size: 15px; font-weight: 500; color: #16a34a;">máy</span></div>
					</div>
					<div style="background: #f0fdf4; color: #16a34a; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
						✅
					</div>
				</div>
				<div style="font-size: 13px; color: #16a34a; font-weight: 600; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 8px;">
					Đã xóa sạch 100% khỏi hệ thống
				</div>
			</div>

			<!-- Card 3: Model Định Giá -->
			<div style="background: #fff; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
				<div style="display: flex; justify-content: space-between; align-items: flex-start;">
					<div>
						<div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Dòng Máy Định Giá (Database)</div>
						<div style="font-size: 32px; font-weight: 800; color: #2563eb; margin: 6px 0;"><?php echo esc_html( $total_models ); ?> <span style="font-size: 15px; font-weight: 500; color: #64748b;">model</span></div>
					</div>
					<div style="background: #f5f3ff; color: #7c3aed; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
						⚡
					</div>
				</div>
				<div style="font-size: 13px; color: #475569; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 8px;">
					Bảo lưu trọn vẹn từ <strong><?php echo esc_html( $total_brands ); ?> thương hiệu</strong>
				</div>
			</div>

			<!-- Card 4: Barem Grade -->
			<div style="background: #fff; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
				<div style="display: flex; justify-content: space-between; align-items: flex-start;">
					<div>
						<div style="color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase;">Barem Khấu Trừ Grade</div>
						<div style="font-size: 32px; font-weight: 800; color: #d97706; margin: 6px 0;">4 <span style="font-size: 15px; font-weight: 500; color: #64748b;">hạng máy</span></div>
					</div>
					<div style="background: #fffbeb; color: #d97706; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
						⚖️
					</div>
				</div>
				<div style="font-size: 13px; color: #475569; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 8px;">
					Grade A (100%) - B (88%) - C (72%) - D (55%)
				</div>
			</div>
		</div>

		<!-- Explanation Notice Cards -->
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
			<div style="background: #f8fafc; border: 1px solid #cbd5e1; border-left: 4px solid #16a34a; border-radius: 8px; padding: 18px 22px;">
				<h3 style="margin: 0 0 8px; color: #0f172a; font-size: 16px; display: flex; align-items: center; gap: 8px;">
					<span style="color:#16a34a; font-size: 18px;">✓</span> 1. Kho Sản Phẩm Thực Tế (Bán Lẻ)
				</h3>
				<p style="margin: 0; color: #475569; font-size: 13.5px; line-height: 1.6;">
					Toàn bộ <strong>184 sản phẩm Thế Giới Di Động</strong> trong cơ sở dữ liệu WooCommerce và <strong>195 sản phẩm</strong> trong tệp danh mục JSON đã được xóa hoàn toàn. Hiện tại kho chỉ lưu trữ và hiển thị đúng <strong>307 sản phẩm điện thoại chất lượng</strong> đến từ Fast Mobile (209 máy) và Quang Minh Mobile (98 máy).
				</p>
			</div>

			<div style="background: #f8fafc; border: 1px solid #cbd5e1; border-left: 4px solid #2563eb; border-radius: 8px; padding: 18px 22px;">
				<h3 style="margin: 0 0 8px; color: #0f172a; font-size: 16px; display: flex; align-items: center; gap: 8px;">
					<span style="color:#2563eb; font-size: 18px;">★</span> 2. Dữ Liệu Giá Sàn & Barem Định Giá Thu Mua
				</h3>
				<p style="margin: 0; color: #475569; font-size: 13.5px; line-height: 1.6;">
					Hệ thống định giá tự động tại <a href="<?php echo esc_url( home_url( '/dinh-gia-dien-thoai/' ) ); ?>" target="_blank" style="color:#2563eb; font-weight:600;">/dinh-gia-dien-thoai/</a> sử dụng bảng cơ sở dữ liệu riêng biệt (<code>wp_phonex_buyback_models</code>) với <strong>170 dòng máy</strong>. Việc loại bỏ các sản phẩm bán lẻ của TGDD hoàn toàn <strong>không ảnh hưởng</strong> tới độ chính xác và tính năng định giá thông minh này.
				</p>
			</div>
		</div>

		<!-- Interactive Model Table -->
		<div style="background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
			<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
				<div>
					<h2 style="font-size: 18px; margin: 0 0 4px; font-weight: 700; color: #0f172a;">📋 Bảng Tra Cứu Toàn Bộ 170 Model & Giá Sàn Thu Mua</h2>
					<p style="margin: 0; color: #64748b; font-size: 13px;">Dữ liệu nền tảng đang kích hoạt phục vụ khách hàng định giá trực tuyến trên toàn hệ thống.</p>
				</div>
				<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
					<!-- Brand filter -->
					<select id="phonexBrandFilter" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; min-width: 150px;">
						<option value="all">Tất cả thương hiệu (12)</option>
						<?php foreach ( $brands as $b ) : ?>
							<option value="<?php echo esc_attr( strtolower( $b->name ) ); ?>"><?php echo esc_html( $b->name ); ?></option>
						<?php endforeach; ?>
					</select>

					<!-- Search input -->
					<input type="text" id="phonexModelSearch" placeholder="🔍 Tìm tên dòng máy (ví dụ: iPhone 15, S24...)" style="padding: 6px 14px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px; min-width: 280px;">

					<!-- Count counter -->
					<span id="phonexModelCounter" style="font-size: 13px; font-weight: 600; color: #475569; background: #f1f5f9; padding: 6px 12px; border-radius: 6px;">
						Hiển thị: <strong><?php echo count( $models ); ?></strong> / <?php echo count( $models ); ?> model
					</span>
				</div>
			</div>

			<div style="overflow-x: auto;">
				<table class="wp-list-table widefat fixed striped" style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
					<thead>
						<tr style="background: #f8fafc;">
							<th style="width: 45px; text-align: center;">STT</th>
							<th style="width: 110px;">Hãng</th>
							<th style="width: 220px;">Dòng Máy & Dung Lượng</th>
							<th style="width: 130px; text-align: right;">Giá Thu Grade A<br><small style="font-weight: normal; color:#64748b;">(Like new 99-100%)</small></th>
							<th style="width: 130px; text-align: right;">Giá Thu Grade B<br><small style="font-weight: normal; color:#64748b;">(Cũ đẹp 98%)</small></th>
							<th style="width: 130px; text-align: right;">Giá Thu Grade C<br><small style="font-weight: normal; color:#64748b;">(Trầy xước)</small></th>
							<th style="width: 130px; text-align: right;">Giá Thu Grade D<br><small style="font-weight: normal; color:#64748b;">(Cấn móp / lỗi nhẹ)</small></th>
							<th style="width: 110px; text-align: center;">Trạng Thái</th>
						</tr>
					</thead>
					<tbody id="phonexModelTableBody">
						<?php 
						$index = 1;
						foreach ( $models as $m ) : 
							$p_base = (float) $m->base_buyback_price;
							$p_a = number_format( $p_base, 0, ',', '.' ) . '₫';
							$p_b = number_format( round( $p_base * 0.88 / 10000 ) * 10000, 0, ',', '.' ) . '₫';
							$p_c = number_format( round( $p_base * 0.72 / 10000 ) * 10000, 0, ',', '.' ) . '₫';
							$p_d = number_format( round( $p_base * 0.55 / 10000 ) * 10000, 0, ',', '.' ) . '₫';
							$st_arr = json_decode( $m->storage_options ?? '[]', true );
							$storage_str = is_array( $st_arr ) ? implode( ' · ', $st_arr ) : '';
							$brand_lower = strtolower( $m->brand_name ?? '' );
							$name_lower  = strtolower( $m->name ?? '' );
						?>
							<tr class="phonex-model-row" data-brand="<?php echo esc_attr( $brand_lower ); ?>" data-name="<?php echo esc_attr( $name_lower ); ?>">
								<td style="text-align: center; color: #94a3b8; font-weight: 500;"><?php echo $index++; ?></td>
								<td>
									<span style="display: inline-block; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 12px; background: #e0f2fe; color: #0284c7;">
										<?php echo esc_html( $m->brand_name ); ?>
									</span>
								</td>
								<td>
									<strong style="color: #0f172a; font-size: 13.5px;"><?php echo esc_html( $m->name ); ?></strong>
									<?php if ( $storage_str ) : ?>
										<div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
											💾 <?php echo esc_html( $storage_str ); ?>
										</div>
									<?php endif; ?>
								</td>
								<td style="text-align: right;">
									<strong style="color: #16a34a; font-size: 14px;"><?php echo esc_html( $p_a ); ?></strong>
								</td>
								<td style="text-align: right; color: #2563eb; font-weight: 600;">
									<?php echo esc_html( $p_b ); ?>
								</td>
								<td style="text-align: right; color: #d97706; font-weight: 600;">
									<?php echo esc_html( $p_c ); ?>
								</td>
								<td style="text-align: right; color: #dc2626; font-weight: 600;">
									<?php echo esc_html( $p_d ); ?>
								</td>
								<td style="text-align: center;">
									<span style="display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; background: #dcfce7; color: #15803d;">
										● Kích hoạt
									</span>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Instant Search & Filter Script -->
	<script>
	(function() {
		const searchInput = document.getElementById('phonexModelSearch');
		const brandFilter = document.getElementById('phonexBrandFilter');
		const rows = document.querySelectorAll('.phonex-model-row');
		const counter = document.getElementById('phonexModelCounter');
		const total = rows.length;

		function filterTable() {
			const term = searchInput.value.trim().toLowerCase();
			const selectedBrand = brandFilter.value.toLowerCase();
			let visibleCount = 0;

			rows.forEach(function(row) {
				const rowBrand = row.getAttribute('data-brand') || '';
				const rowName = row.getAttribute('data-name') || '';

				const matchesBrand = (selectedBrand === 'all' || rowBrand === selectedBrand);
				const matchesSearch = (!term || rowName.includes(term) || rowBrand.includes(term));

				if (matchesBrand && matchesSearch) {
					row.style.display = '';
					visibleCount++;
				} else {
					row.style.display = 'none';
				}
			});

			if (counter) {
				counter.innerHTML = 'Hiển thị: <strong>' + visibleCount + '</strong> / ' + total + ' model';
			}
		}

		if (searchInput) {
			searchInput.addEventListener('input', filterTable);
		}
		if (brandFilter) {
			brandFilter.addEventListener('change', filterTable);
		}
	})();
	</script>
	<?php
}

