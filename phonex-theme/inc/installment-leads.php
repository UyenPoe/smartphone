<?php
/**
 * PhoneX Installment & Trade-in Leads Management Module
 *
 * Quản lý Bảng tính Trả Góp 0%, Thu Cũ Đổi Mới Lên Đời & Công Nợ Bán Sỉ B2B
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. CREATE DATABASE TABLE
 */
function phonex_create_installment_leads_table() {
	global $wpdb;
	$table_name      = $wpdb->prefix . 'phonex_installment_leads';
	$charset_collate = $wpdb->get_charset_collate();

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) !== $table_name ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$sql = "CREATE TABLE $table_name (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			lead_code varchar(30) NOT NULL,
			lead_type varchar(50) NOT NULL DEFAULT 'installment_retail',
			customer_name varchar(255) NOT NULL,
			customer_phone varchar(50) NOT NULL,
			customer_city varchar(100) DEFAULT '',
			customer_id_type varchar(50) DEFAULT 'cccd',
			product_name varchar(255) DEFAULT '',
			product_price bigint(20) DEFAULT 0,
			down_payment_pct int(11) DEFAULT 0,
			down_payment_val bigint(20) DEFAULT 0,
			term_months int(11) DEFAULT 6,
			monthly_payment bigint(20) DEFAULT 0,
			has_tradein tinyint(1) DEFAULT 0,
			tradein_brand varchar(100) DEFAULT '',
			tradein_model varchar(255) DEFAULT '',
			tradein_condition varchar(100) DEFAULT '',
			tradein_valuation bigint(20) DEFAULT 0,
			wholesale_quantity varchar(100) DEFAULT '',
			wholesale_payment_method varchar(100) DEFAULT '',
			notes text DEFAULT '',
			status varchar(50) NOT NULL DEFAULT 'pending',
			staff_notes text DEFAULT '',
			ip_address varchar(100) DEFAULT '',
			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY  (id),
			KEY lead_type (lead_type),
			KEY status (status),
			KEY created_at (created_at)
		) $charset_collate;";
		dbDelta( $sql );
	}
}
add_action( 'init', 'phonex_create_installment_leads_table' );

/**
 * 2. REGISTER ADMIN MENU
 */
function phonex_installment_leads_admin_menu() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'phonex_installment_leads';
	$pending_count = 0;
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
		$pending_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );
	}
	$badge = $pending_count > 0 ? sprintf( ' <span class="awaiting-mod update-plugins count-%1$d"><span class="pending-count">%1$d</span></span>', $pending_count ) : '';

	// Add submenu to PhoneX Thu Mua
	add_submenu_page(
		'phonex-buyback-crm',
		__( 'Hồ Sơ Trả Góp & Bán Sỉ', 'phonex' ),
		__( '💳 Trả Góp & Bán Sỉ', 'phonex' ) . $badge,
		'manage_options',
		'phonex-installment-leads',
		'phonex_admin_installment_leads_page'
	);
}
add_action( 'admin_menu', 'phonex_installment_leads_admin_menu', 35 );

/**
 * 3. AJAX: SUBMIT LEAD (FRONTEND)
 */
function phonex_ajax_submit_installment_lead() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'phonex_installment_leads';

	// Table ensure
	phonex_create_installment_leads_table();

	$customer_name  = sanitize_text_field( $_POST['customer_name'] ?? '' );
	$customer_phone = sanitize_text_field( $_POST['customer_phone'] ?? '' );
	$customer_phone = preg_replace( '/[^0-9]/', '', $customer_phone );

	if ( empty( $customer_name ) || strlen( $customer_phone ) < 9 ) {
		wp_send_json_error( array( 'message' => 'Vui lòng nhập họ tên và số điện thoại hợp lệ (9–11 số).' ) );
	}

	$lead_type       = sanitize_text_field( $_POST['lead_type'] ?? 'installment_retail' );
	$customer_city   = sanitize_text_field( $_POST['customer_city'] ?? '' );
	$customer_id_type= sanitize_text_field( $_POST['customer_id_type'] ?? 'cccd' );
	$product_name    = sanitize_text_field( $_POST['product_name'] ?? '' );
	$product_price   = floatval( $_POST['product_price'] ?? 0 );
	$down_payment_pct= intval( $_POST['down_payment_pct'] ?? 0 );
	$down_payment_val= floatval( $_POST['down_payment_val'] ?? 0 );
	$term_months     = intval( $_POST['term_months'] ?? 6 );
	$monthly_payment = floatval( $_POST['monthly_payment'] ?? 0 );
	$has_tradein     = ! empty( $_POST['has_tradein'] ) ? 1 : 0;
	$tradein_brand   = sanitize_text_field( $_POST['tradein_brand'] ?? '' );
	$tradein_model   = sanitize_text_field( $_POST['tradein_model'] ?? '' );
	$tradein_condition = sanitize_text_field( $_POST['tradein_condition'] ?? '' );
	$tradein_val     = floatval( $_POST['tradein_valuation'] ?? 0 );
	$wholesale_qty   = sanitize_text_field( $_POST['wholesale_quantity'] ?? '' );
	$wholesale_pay   = sanitize_text_field( $_POST['wholesale_payment_method'] ?? '' );
	$notes           = sanitize_textarea_field( $_POST['notes'] ?? '' );
	$ip_address      = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );

	$lead_code = 'PX-TG-' . strtoupper( wp_generate_password( 5, false, false ) );

	$inserted = $wpdb->insert(
		$table_name,
		array(
			'lead_code'                => $lead_code,
			'lead_type'                => $lead_type,
			'customer_name'            => $customer_name,
			'customer_phone'           => $customer_phone,
			'customer_city'            => $customer_city,
			'customer_id_type'         => $customer_id_type,
			'product_name'             => $product_name,
			'product_price'            => $product_price,
			'down_payment_pct'         => $down_payment_pct,
			'down_payment_val'         => $down_payment_val,
			'term_months'              => $term_months,
			'monthly_payment'          => $monthly_payment,
			'has_tradein'              => $has_tradein,
			'tradein_brand'            => $tradein_brand,
			'tradein_model'            => $tradein_model,
			'tradein_condition'        => $tradein_condition,
			'tradein_valuation'        => $tradein_val,
			'wholesale_quantity'       => $wholesale_qty,
			'wholesale_payment_method' => $wholesale_pay,
			'notes'                    => $notes,
			'status'                   => 'pending',
			'ip_address'               => $ip_address,
			'created_at'               => current_time( 'mysql' ),
		)
	);

	if ( false === $inserted ) {
		wp_send_json_error( array( 'message' => 'Lỗi kết nối cơ sở dữ liệu. Vui lòng thử lại hoặc gọi Hotline 1800.6868.' ) );
	}

	wp_send_json_success( array(
		'lead_code' => $lead_code,
		'lead_id'   => $wpdb->insert_id,
		'message'   => 'Đăng ký hồ sơ thành công! Chuyên viên PhoneX sẽ liên hệ hoặc kết bạn Zalo trong 5 phút.',
	) );
}
add_action( 'wp_ajax_phonex_submit_installment_lead', 'phonex_ajax_submit_installment_lead' );
add_action( 'wp_ajax_nopriv_phonex_submit_installment_lead', 'phonex_ajax_submit_installment_lead' );

/**
 * 4. AJAX: UPDATE LEAD STATUS / STAFF NOTES (ADMIN)
 */
function phonex_ajax_update_lead_status() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Không đủ quyền hạn.' ) );
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'phonex_installment_leads';
	$lead_id    = intval( $_POST['lead_id'] ?? 0 );
	$status     = sanitize_text_field( $_POST['status'] ?? 'pending' );
	$staff_notes= isset( $_POST['staff_notes'] ) ? sanitize_textarea_field( $_POST['staff_notes'] ) : null;

	if ( $lead_id <= 0 ) {
		wp_send_json_error( array( 'message' => 'ID hồ sơ không hợp lệ.' ) );
	}

	$update_data = array( 'status' => $status );
	if ( null !== $staff_notes ) {
		$update_data['staff_notes'] = $staff_notes;
	}

	$updated = $wpdb->update(
		$table_name,
		$update_data,
		array( 'id' => $lead_id )
	);

	wp_send_json_success( array( 'message' => 'Cập nhật trạng thái thành công.' ) );
}
add_action( 'wp_ajax_phonex_update_lead_status', 'phonex_ajax_update_lead_status' );

/**
 * 5. AJAX: DELETE LEAD (ADMIN)
 */
function phonex_ajax_delete_lead() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Không đủ quyền hạn.' ) );
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'phonex_installment_leads';
	$lead_id    = intval( $_POST['lead_id'] ?? 0 );

	if ( $lead_id <= 0 ) {
		wp_send_json_error( array( 'message' => 'ID không hợp lệ.' ) );
	}

	$wpdb->delete( $table_name, array( 'id' => $lead_id ) );
	wp_send_json_success( array( 'message' => 'Đã xóa hồ sơ thành công.' ) );
}
add_action( 'wp_ajax_phonex_delete_lead', 'phonex_ajax_delete_lead' );

/**
 * 6. ADMIN DASHBOARD PAGE
 */
function phonex_admin_installment_leads_page() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'phonex_installment_leads';
	phonex_create_installment_leads_table();

	$current_status = sanitize_text_field( $_GET['status'] ?? 'all' );
	$current_type   = sanitize_text_field( $_GET['type'] ?? 'all' );
	$search_query   = sanitize_text_field( $_GET['s'] ?? '' );

	// Build WHERE
	$where = array( '1=1' );
	if ( 'all' !== $current_status ) {
		$where[] = $wpdb->prepare( 'status = %s', $current_status );
	}
	if ( 'all' !== $current_type ) {
		$where[] = $wpdb->prepare( 'lead_type = %s', $current_type );
	}
	if ( ! empty( $search_query ) ) {
		$like = '%' . $wpdb->esc_like( $search_query ) . '%';
		$where[] = $wpdb->prepare( '(customer_name LIKE %s OR customer_phone LIKE %s OR lead_code LIKE %s OR product_name LIKE %s)', $like, $like, $like, $like );
	}
	$where_sql = implode( ' AND ', $where );

	// Query Leads
	$leads = $wpdb->get_results( "SELECT * FROM $table_name WHERE $where_sql ORDER BY id DESC LIMIT 200" );

	// Stats
	$total_leads    = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
	$pending_leads  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status = 'pending'" );
	$tradein_leads  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE has_tradein = 1 OR lead_type = 'tradein_installment'" );
	$wholesale_leads= (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE lead_type = 'b2b_wholesale'" );
	$approved_leads = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE status IN ('approved', 'completed')" );

	?>
	<div class="wrap" style="max-width: 1400px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
		<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
			<div>
				<h1 style="display: flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 800; color: #1e293b; margin: 0;">
					<span style="background: #e60012; color: #fff; width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 20px;">💳</span>
					PhoneX Leads — Quản Lý Hồ Sơ Trả Góp &amp; Bán Sỉ B2B
				</h1>
				<p style="margin: 4px 0 0; color: #64748b; font-size: 13px;">
					Thu thập tự động từ Bảng tính trả góp 0%, Thu cũ đổi mới &amp; Đăng ký công nợ sỉ gối đầu 15–30 ngày.
				</p>
			</div>
			<div>
				<a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" target="_blank" class="button" style="display: inline-flex; align-items: center; gap: 6px;">
					<span class="dashicons dashicons-external"></span> Xem Kho Máy Cũ Frontend
				</a>
			</div>
		</div>

		<!-- KPI CARDS -->
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 24px;">
			<div style="background: #fff; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tổng hồ sơ nhận</div>
				<div style="font-size: 28px; font-weight: 800; color: #1e293b; margin-top: 4px;"><?php echo esc_html( number_format( $total_leads ) ); ?></div>
				<div style="font-size: 12px; color: #10b981; margin-top: 4px; font-weight: 600;">Toàn thời gian</div>
			</div>
			<div style="background: #fff; padding: 18px; border-radius: 12px; border: 1px solid #fecaca; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: linear-gradient(to bottom right, #fff, #fef2f2);">
				<div style="font-size: 12px; font-weight: 700; color: #dc2626; text-transform: uppercase;">Chờ tư vấn (Mới)</div>
				<div style="font-size: 28px; font-weight: 800; color: #dc2626; margin-top: 4px;"><?php echo esc_html( number_format( $pending_leads ) ); ?></div>
				<div style="font-size: 12px; color: #dc2626; margin-top: 4px; font-weight: 600;">Cần liên hệ trong 5 phút</div>
			</div>
			<div style="background: #fff; padding: 18px; border-radius: 12px; border: 1px solid #fed7aa; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: linear-gradient(to bottom right, #fff, #fff7ed);">
				<div style="font-size: 12px; font-weight: 700; color: #ea580c; text-transform: uppercase;">Thu cũ lên đời</div>
				<div style="font-size: 28px; font-weight: 800; color: #ea580c; margin-top: 4px;"><?php echo esc_html( number_format( $tradein_leads ) ); ?></div>
				<div style="font-size: 12px; color: #ea580c; margin-top: 4px; font-weight: 600;">Có máy cũ trừ tiền trả trước</div>
			</div>
			<div style="background: #fff; padding: 18px; border-radius: 12px; border: 1px solid #e9d5ff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: linear-gradient(to bottom right, #fff, #faf5ff);">
				<div style="font-size: 12px; font-weight: 700; color: #9333ea; text-transform: uppercase;">Đại lý sỉ &amp; Công nợ</div>
				<div style="font-size: 28px; font-weight: 800; color: #9333ea; margin-top: 4px;"><?php echo esc_html( number_format( $wholesale_leads ) ); ?></div>
				<div style="font-size: 12px; color: #9333ea; margin-top: 4px; font-weight: 600;">B2B Wholesale gối đầu</div>
			</div>
			<div style="background: #fff; padding: 18px; border-radius: 12px; border: 1px solid #bbf7d0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: linear-gradient(to bottom right, #fff, #f0fdf4);">
				<div style="font-size: 12px; font-weight: 700; color: #16a34a; text-transform: uppercase;">Đã duyệt &amp; Hoàn tất</div>
				<div style="font-size: 28px; font-weight: 800; color: #16a34a; margin-top: 4px;"><?php echo esc_html( number_format( $approved_leads ) ); ?></div>
				<div style="font-size: 12px; color: #16a34a; margin-top: 4px; font-weight: 600;">Hồ sơ thành công</div>
			</div>
		</div>

		<!-- FILTER TABS & SEARCH -->
		<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
			<div style="display: flex; gap: 8px; flex-wrap: wrap;">
				<?php
				$tabs = array(
					'all'        => 'Tất cả (' . $total_leads . ')',
					'pending'    => '🔴 Chờ xử lý (' . $pending_leads . ')',
					'contacted'  => '🟡 Đang liên hệ',
					'approved'   => '🟢 Đã duyệt hồ sơ',
					'completed'  => '✅ Hoàn tất',
					'cancelled'  => '❌ Đã hủy',
				);
				foreach ( $tabs as $s_key => $s_label ) :
					$active = ( $current_status === $s_key );
					$url    = add_query_arg( array( 'page' => 'phonex-installment-leads', 'status' => $s_key, 'type' => $current_type ), admin_url( 'admin.php' ) );
					?>
					<a href="<?php echo esc_url( $url ); ?>"
					   style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid <?php echo $active ? '#e60012' : '#e2e8f0'; ?>; background: <?php echo $active ? '#e60012' : '#f8fafc'; ?>; color: <?php echo $active ? '#fff' : '#475569'; ?>;">
						<?php echo esc_html( $s_label ); ?>
					</a>
				<?php endforeach; ?>
			</div>

			<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" style="display: flex; gap: 8px;">
				<input type="hidden" name="page" value="phonex-installment-leads" />
				<input type="hidden" name="status" value="<?php echo esc_attr( $current_status ); ?>" />
				<select name="type" style="border-radius: 8px; font-size: 13px; border: 1px solid #cbd5e1;">
					<option value="all" <?php selected( $current_type, 'all' ); ?>>Tất cả nguồn</option>
					<option value="installment_retail" <?php selected( $current_type, 'installment_retail' ); ?>>Khách lẻ Trả góp</option>
					<option value="tradein_installment" <?php selected( $current_type, 'tradein_installment' ); ?>>Thu cũ đổi mới</option>
					<option value="b2b_wholesale" <?php selected( $current_type, 'b2b_wholesale' ); ?>>Bán sỉ &amp; Công nợ</option>
				</select>
				<input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Tìm tên, SĐT, mã hồ sơ..." style="border-radius: 8px; font-size: 13px; border: 1px solid #cbd5e1; width: 200px;" />
				<button type="submit" class="button button-primary" style="border-radius: 8px; background: #e60012; border-color: #e60012;">Tìm kiếm</button>
				<?php if ( ! empty( $search_query ) || 'all' !== $current_status || 'all' !== $current_type ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=phonex-installment-leads' ) ); ?>" class="button" style="border-radius: 8px;">Làm mới</a>
				<?php endif; ?>
			</form>
		</div>

		<!-- LEADS TABLE -->
		<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<table class="wp-list-table widefat fixed striped" style="border: none; font-size: 13px;">
				<thead>
					<tr style="background: #f8fafc;">
						<th style="width: 110px; font-weight: 700; color: #334155;">Mã &amp; Thời gian</th>
						<th style="width: 140px; font-weight: 700; color: #334155;">Loại hồ sơ</th>
						<th style="width: 220px; font-weight: 700; color: #334155;">Khách hàng &amp; Zalo</th>
						<th style="font-weight: 700; color: #334155;">Sản phẩm quan tâm</th>
						<th style="width: 240px; font-weight: 700; color: #334155;">Chi tiết tài chính / Góp</th>
						<th style="width: 160px; font-weight: 700; color: #334155;">Trạng thái</th>
						<th style="width: 80px; text-align: center; font-weight: 700; color: #334155;">Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $leads ) ) : ?>
						<tr>
							<td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
								<span class="dashicons dashicons-clipboard" style="font-size: 40px; width: 40px; height: 40px; opacity: 0.5;"></span>
								<p style="margin-top: 10px; font-weight: 600;">Chưa có hồ sơ trả góp hoặc bán sỉ nào phù hợp với bộ lọc.</p>
							</td>
						</tr>
					<?php else : ?>
						<?php foreach ( $leads as $l ) :
							$clean_phone = preg_replace( '/[^0-9]/', '', $l->customer_phone );
							$zalo_url    = 'https://zalo.me/' . $clean_phone;
							$tel_url     = 'tel:' . $clean_phone;
							?>
							<tr id="lead-row-<?php echo esc_attr( $l->id ); ?>">
								<td>
									<strong style="color: #0f172a;"><?php echo esc_html( $l->lead_code ); ?></strong>
									<div style="font-size: 11px; color: #64748b; margin-top: 3px;">
										<?php echo esc_html( date( 'd/m/Y H:i', strtotime( $l->created_at ) ) ); ?>
									</div>
								</td>
								<td>
									<?php if ( 'b2b_wholesale' === $l->lead_type ) : ?>
										<span style="display: inline-block; background: #faf5ff; border: 1px solid #d8b4fe; color: #7e22ce; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
											🏢 Bán Sỉ &amp; Công Nợ
										</span>
									<?php elseif ( $l->has_tradein || 'tradein_installment' === $l->lead_type ) : ?>
										<span style="display: inline-block; background: #fff7ed; border: 1px solid #fed7aa; color: #c2410c; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
											🔄 Thu Cũ + Trả Góp
										</span>
									<?php else : ?>
										<span style="display: inline-block; background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
											💳 Khách Lẻ Trả Góp 0%
										</span>
									<?php endif; ?>

									<div style="font-size: 11px; color: #475569; margin-top: 4px;">
										Duyệt qua: <strong><?php echo esc_html( strtoupper( $l->customer_id_type ) ); ?></strong>
									</div>
								</td>
								<td>
									<div style="font-weight: 700; color: #0f172a; font-size: 14px;">
										<?php echo esc_html( $l->customer_name ); ?>
									</div>
									<div style="display: flex; align-items: center; gap: 6px; margin-top: 4px; flex-wrap: wrap;">
										<a href="<?php echo esc_url( $tel_url ); ?>" style="font-weight: 700; color: #e60012; text-decoration: none;">
											📞 <?php echo esc_html( $l->customer_phone ); ?>
										</a>
										<a href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 3px; background: #0068ff; color: #fff; padding: 2px 7px; border-radius: 5px; font-size: 11px; font-weight: 700; text-decoration: none;">
											💬 Chat Zalo
										</a>
									</div>
									<?php if ( ! empty( $l->customer_city ) ) : ?>
										<div style="font-size: 11px; color: #64748b; margin-top: 3px;">
											📍 <?php echo esc_html( $l->customer_city ); ?>
										</div>
									<?php endif; ?>
								</td>
								<td>
									<strong style="color: #0f172a;"><?php echo esc_html( $l->product_name ?: 'Yêu cầu tư vấn tổng quan' ); ?></strong>
									<?php if ( $l->product_price > 0 ) : ?>
										<div style="font-size: 12px; color: #e60012; font-weight: 700; margin-top: 2px;">
											Giá máy: <?php echo esc_html( number_format( $l->product_price, 0, ',', '.' ) ); ?>₫
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $l->notes ) ) : ?>
										<div style="margin-top: 6px; background: #f8fafc; border: 1px dashed #cbd5e1; padding: 4px 8px; border-radius: 6px; font-size: 11px; color: #475569;">
											<strong>Khách dặn:</strong> <?php echo esc_html( $l->notes ); ?>
										</div>
									<?php endif; ?>
								</td>
								<td>
									<?php if ( 'b2b_wholesale' === $l->lead_type ) : ?>
										<div style="font-size: 12px;">
											<div>SL dự kiến: <strong><?php echo esc_html( $l->wholesale_quantity ?: '5-10 máy' ); ?></strong></div>
											<div style="margin-top: 2px; color: #7e22ce; font-weight: 700;">
												PT: <?php echo esc_html( $l->wholesale_payment_method ?: 'Công nợ gối đầu 15–30 ngày' ); ?>
											</div>
										</div>
									<?php else : ?>
										<div style="font-size: 12px; line-height: 1.5;">
											<div>Trả trước: <strong><?php echo esc_html( number_format( $l->down_payment_val, 0, ',', '.' ) ); ?>₫</strong> (<?php echo esc_html( $l->down_payment_pct ); ?>%)</div>
											<div>Kỳ hạn: <strong><?php echo esc_html( $l->term_months ); ?> tháng</strong></div>
											<div style="color: #e60012; font-weight: 800; font-size: 13px;">
												Góp: <?php echo esc_html( number_format( $l->monthly_payment, 0, ',', '.' ) ); ?>₫/tháng
											</div>
											<?php if ( $l->has_tradein && ! empty( $l->tradein_model ) ) : ?>
												<div style="margin-top: 4px; padding: 4px 6px; background: #fff7ed; border-radius: 6px; border: 1px solid #fed7aa; font-size: 11px; color: #c2410c;">
													<strong>Thu lại:</strong> <?php echo esc_html( $l->tradein_model ); ?> (<?php echo esc_html( $l->tradein_condition ); ?>)
													<?php if ( $l->tradein_valuation > 0 ) : ?>
														— Trừ <strong><?php echo esc_html( number_format( $l->tradein_valuation, 0, ',', '.' ) ); ?>₫</strong>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</td>
								<td>
									<select onchange="pxUpdateLeadStatus(<?php echo esc_attr( $l->id ); ?>, this.value)"
											style="width: 100%; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 4px 8px; border: 1px solid #cbd5e1;
											<?php
											if ( 'pending' === $l->status ) echo 'background: #fef2f2; color: #dc2626; border-color: #fca5a5;';
											elseif ( 'contacted' === $l->status ) echo 'background: #fefce8; color: #ca8a04; border-color: #fde047;';
											elseif ( 'approved' === $l->status ) echo 'background: #f0fdf4; color: #16a34a; border-color: #86efac;';
											elseif ( 'completed' === $l->status ) echo 'background: #ecfdf5; color: #059669; border-color: #6ee7b7;';
											elseif ( 'cancelled' === $l->status ) echo 'background: #f8fafc; color: #64748b; border-color: #cbd5e1;';
											?>">
										<option value="pending" <?php selected( $l->status, 'pending' ); ?>>🔴 Mới nhận (Chờ)</option>
										<option value="contacted" <?php selected( $l->status, 'contacted' ); ?>>🟡 Đang liên hệ</option>
										<option value="approved" <?php selected( $l->status, 'approved' ); ?>>🟢 Đã duyệt hồ sơ</option>
										<option value="completed" <?php selected( $l->status, 'completed' ); ?>>✅ Đã hoàn tất</option>
										<option value="cancelled" <?php selected( $l->status, 'cancelled' ); ?>>❌ Hủy hồ sơ</option>
									</select>
									<span id="status-spinner-<?php echo esc_attr( $l->id ); ?>" style="display: none; font-size: 11px; color: #64748b; margin-top: 2px;">Đang lưu...</span>
								</td>
								<td style="text-align: center;">
									<button type="button" onclick="pxDeleteLead(<?php echo esc_attr( $l->id ); ?>)"
											class="button button-small" style="color: #dc2626; border-color: #fca5a5;" title="Xóa hồ sơ">
										<span class="dashicons dashicons-trash" style="font-size: 16px; width: 16px; height: 16px; margin-top: 3px;"></span>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
	function pxUpdateLeadStatus(leadId, newStatus) {
		var spinner = document.getElementById('status-spinner-' + leadId);
		if (spinner) spinner.style.display = 'block';

		var fd = new FormData();
		fd.append('action', 'phonex_update_lead_status');
		fd.append('lead_id', leadId);
		fd.append('status', newStatus);

		fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
			method: 'POST',
			body: fd
		})
		.then(function(r){ return r.json(); })
		.then(function(res){
			if (spinner) {
				spinner.textContent = '✓ Đã lưu';
				setTimeout(function(){ spinner.style.display = 'none'; spinner.textContent = 'Đang lưu...'; }, 1500);
			}
		})
		.catch(function(err){
			alert('Lỗi cập nhật trạng thái');
			if (spinner) spinner.style.display = 'none';
		});
	}

	function pxDeleteLead(leadId) {
		if (!confirm('Bạn có chắc chắn muốn xóa hồ sơ này không?')) return;
		var fd = new FormData();
		fd.append('action', 'phonex_delete_lead');
		fd.append('lead_id', leadId);

		fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
			method: 'POST',
			body: fd
		})
		.then(function(r){ return r.json(); })
		.then(function(res){
			if (res.success) {
				var row = document.getElementById('lead-row-' + leadId);
				if (row) row.remove();
			} else {
				alert(res.data.message || 'Lỗi xóa hồ sơ');
			}
		});
	}
	</script>
	<?php
}
