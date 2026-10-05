<?php
/**
 * PhoneX Buyback REST API & Estimation Engine
 *
 * Endpoints:
 * - GET  /wp-json/phonex/v1/buyback/search
 * - GET  /wp-json/phonex/v1/buyback/brands
 * - GET  /wp-json/phonex/v1/buyback/models
 * - POST /wp-json/phonex/v1/buyback/estimate
 * - POST /wp-json/phonex/v1/buyback/submit-request
 * - GET  /wp-json/phonex/v1/buyback/lookup
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'rest_api_init', 'phonex_buyback_register_rest_routes' );

function phonex_buyback_register_rest_routes() {
	$namespace = 'phonex/v1';

	// 1. Live Device Search
	register_rest_route( $namespace, '/buyback/search', array(
		'methods'             => 'GET',
		'callback'            => 'phonex_buyback_api_search',
		'permission_callback' => '__return_true',
	) );

	// 2. Brands List
	register_rest_route( $namespace, '/buyback/brands', array(
		'methods'             => 'GET',
		'callback'            => 'phonex_buyback_api_brands',
		'permission_callback' => '__return_true',
	) );

	// 3. Models by Brand/Series
	register_rest_route( $namespace, '/buyback/models', array(
		'methods'             => 'GET',
		'callback'            => 'phonex_buyback_api_models',
		'permission_callback' => '__return_true',
	) );

	// 4. Valuation Estimation Calculation
	register_rest_route( $namespace, '/buyback/estimate', array(
		'methods'             => 'POST',
		'callback'            => 'phonex_buyback_api_estimate',
		'permission_callback' => '__return_true',
	) );

	// 5. Submit Buyback Request (CRM)
	register_rest_route( $namespace, '/buyback/submit-request', array(
		'methods'             => 'POST',
		'callback'            => 'phonex_buyback_api_submit_request',
		'permission_callback' => '__return_true',
	) );

	// 6. Lookup Requests by Phone Number
	register_rest_route( $namespace, '/buyback/lookup', array(
		'methods'             => 'GET',
		'callback'            => 'phonex_buyback_api_lookup',
		'permission_callback' => '__return_true',
	) );
}

/**
 * 1. Search devices by query: Brand -> Series -> Model
 */
function phonex_buyback_api_search( WP_REST_Request $request ) {
	global $wpdb;
	$q = trim( sanitize_text_field( $request->get_param( 'q' ) ?? '' ) );
	if ( empty( $q ) || mb_strlen( $q ) < 2 ) {
		return rest_ensure_response( array( 'results' => array() ) );
	}

	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$t_series = $wpdb->prefix . 'phonex_buyback_series';
	$t_models = $wpdb->prefix . 'phonex_buyback_models';

	$sql = $wpdb->prepare(
		"SELECT m.id, m.name as model_name, m.slug as model_slug, m.image_url, m.base_buyback_price,
		        b.name as brand_name, b.slug as brand_slug,
		        COALESCE(s.name, '') as series_name
		 FROM $t_models m
		 JOIN $t_brands b ON m.brand_id = b.id
		 LEFT JOIN $t_series s ON m.series_id = s.id
		 WHERE (m.name LIKE %s OR b.name LIKE %s OR s.name LIKE %s)
		   AND m.is_active = 1 AND b.is_active = 1
		 ORDER BY m.is_popular DESC, m.sort_order ASC
		 LIMIT 12",
		'%' . $wpdb->esc_like( $q ) . '%',
		'%' . $wpdb->esc_like( $q ) . '%',
		'%' . $wpdb->esc_like( $q ) . '%'
	);

	$rows = $wpdb->get_results( $sql );
	$results = array();

	foreach ( $rows as $r ) {
		$url = home_url( '/thu-mua-dien-thoai/' . $r->brand_slug . '/' . $r->model_slug . '/' );
		$results[] = array(
			'id'          => intval( $r->id ),
			'model'       => $r->model_name,
			'brand'       => $r->brand_name,
			'brand_slug'  => $r->brand_slug,
			'brand_logo'  => phonex_get_brand_logo_url( $r->brand_slug ),
			'series'      => $r->series_name,
			'url'         => $url,
			'image'       => $r->image_url ?: ( get_template_directory_uri() . '/assets/images/placeholder.jpg' ),
			'price_up_to' => floatval( $r->base_buyback_price ),
			'price_fmt'   => number_format( $r->base_buyback_price, 0, ',', '.' ) . '₫',
		);
	}

	return rest_ensure_response( array( 'results' => $results ) );
}

/**
 * 2. Get brands list
 */
function phonex_buyback_api_brands( WP_REST_Request $request ) {
	global $wpdb;
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$t_models = $wpdb->prefix . 'phonex_buyback_models';

	$only_featured = $request->get_param( 'featured' ) === '1';
	$where = 'WHERE is_active = 1';
	if ( $only_featured ) {
		$where .= ' AND is_featured = 1';
	}

	$brands = $wpdb->get_results( "SELECT * FROM $t_brands $where ORDER BY sort_order ASC, name ASC" );
	$out = array();

	foreach ( $brands as $b ) {
		$model_count = intval( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $t_models WHERE brand_id = %d AND is_active = 1", $b->id ) ) );
		$out[] = array(
			'id'          => intval( $b->id ),
			'name'        => $b->name,
			'slug'        => $b->slug,
			'url'         => home_url( '/thu-mua-dien-thoai/' . $b->slug . '/' ),
			'logo_url'    => phonex_get_brand_logo_url( $b ),
			'is_featured' => intval( $b->is_featured ),
			'model_count' => $model_count,
		);
	}

	return rest_ensure_response( array( 'brands' => $out ) );
}

/**
 * 3. Get models by brand or series
 */
function phonex_buyback_api_models( WP_REST_Request $request ) {
	global $wpdb;
	$t_models = $wpdb->prefix . 'phonex_buyback_models';
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$t_series = $wpdb->prefix . 'phonex_buyback_series';

	$brand_id   = intval( $request->get_param( 'brand_id' ) );
	$brand_slug = sanitize_title( $request->get_param( 'brand_slug' ) ?? '' );
	$series_id  = intval( $request->get_param( 'series_id' ) );

	if ( empty( $brand_id ) && ! empty( $brand_slug ) ) {
		if ( 'iphone' === $brand_slug ) {
			$brand_slug = 'apple';
		}
		$brand_id = intval( $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $t_brands WHERE slug = %s", $brand_slug ) ) );
	}

	$where = 'WHERE m.is_active = 1';
	$params = array();

	if ( $brand_id > 0 ) {
		$where .= ' AND m.brand_id = %d';
		$params[] = $brand_id;
	}
	if ( $series_id > 0 ) {
		$where .= ' AND m.series_id = %d';
		$params[] = $series_id;
	}

	$sql = "SELECT m.*, b.name as brand_name, b.slug as brand_slug, COALESCE(s.name, '') as series_name
	        FROM $t_models m
	        JOIN $t_brands b ON m.brand_id = b.id
	        LEFT JOIN $t_series s ON m.series_id = s.id
	        $where
	        ORDER BY m.is_popular DESC, m.sort_order ASC";

	if ( ! empty( $params ) ) {
		$sql = $wpdb->prepare( $sql, $params );
	}

	$rows = $wpdb->get_results( $sql );
	$models = array();

	foreach ( $rows as $r ) {
		$models[] = array(
			'id'              => intval( $r->id ),
			'name'            => $r->name,
			'slug'            => $r->slug,
			'url'             => home_url( '/thu-mua-dien-thoai/' . $r->brand_slug . '/' . $r->slug . '/' ),
			'image_url'       => $r->image_url ?: ( get_template_directory_uri() . '/assets/images/placeholder.jpg' ),
			'storage_options' => json_decode( $r->storage_options, true ) ?: array(),
			'color_options'   => json_decode( $r->color_options, true ) ?: array(),
			'base_price'                   => floatval( $r->base_buyback_price ),
			'base_price_fmt'               => number_format( $r->base_buyback_price, 0, ',', '.' ) . '₫',
			'base_buyback_price'           => floatval( $r->base_buyback_price ),
			'base_buyback_price_formatted' => number_format( $r->base_buyback_price, 0, ',', '.' ) . '₫',
			'series_name'                  => $r->series_name,
			'brand_name'                   => $r->brand_name,
		);
	}

	return rest_ensure_response( array( 'models' => $models ) );
}

/**
 * 4. Calculate Buyback Valuation Estimation
 */
function phonex_buyback_api_estimate( WP_REST_Request $request ) {
	global $wpdb;
	$model_id = intval( $request->get_param( 'model_id' ) );
	$storage  = sanitize_text_field( $request->get_param( 'storage' ) ?? '256GB' );

	$t_models = $wpdb->prefix . 'phonex_buyback_models';
	$model    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_models WHERE id = %d AND is_active = 1", $model_id ) );

	if ( ! $model ) {
		return new WP_Error( 'model_not_found', 'Không tìm thấy thiết bị yêu cầu', array( 'status' => 404 ) );
	}

	$base_price = floatval( $model->base_buyback_price );
	if ( $base_price <= 0 ) {
		$base_price = 10000000;
	}

	// Adjust base price by storage capacity
	if ( stripos( $storage, '512GB' ) !== false ) {
		$base_price += 1500000;
	} elseif ( stripos( $storage, '1TB' ) !== false ) {
		$base_price += 3000000;
	} elseif ( stripos( $storage, '128GB' ) !== false ) {
		$base_price -= 1200000;
	} elseif ( stripos( $storage, '64GB' ) !== false ) {
		$base_price -= 2000000;
	}

	// Survey Inputs
	$body_cond    = sanitize_text_field( $request->get_param( 'body_condition' ) ?? 'A' );       // A: 99%, B: 95%, C: 90%
	$screen_cond  = sanitize_text_field( $request->get_param( 'screen_condition' ) ?? 'good' );  // good, scratches, cracked, dead_pixels
	$battery_cond = sanitize_text_field( $request->get_param( 'battery_condition' ) ?? 'good' ); // good (>85%), normal (80-85%), service (<80%)
	$camera_cond  = sanitize_text_field( $request->get_param( 'camera_condition' ) ?? 'good' );  // good, blurry, broken
	$faceid_cond  = sanitize_text_field( $request->get_param( 'faceid_condition' ) ?? 'good' );  // good, defective
	$repaired     = sanitize_text_field( $request->get_param( 'repair_history' ) ?? 'none' );     // none, official_parts, third_party
	$accessories  = sanitize_text_field( $request->get_param( 'accessories' ) ?? 'bare' );        // full_box, phone_only

	$deductions = array();
	$multiplier = 1.0;

	// Grade deduction from body
	if ( 'B' === $body_cond ) {
		$multiplier *= 0.88;
		$deductions[] = 'Ngoại hình trầy xước nhẹ (Grade B): -12%';
	} elseif ( 'C' === $body_cond ) {
		$multiplier *= 0.72;
		$deductions[] = 'Ngoại hình cấn móp, trầy sâu (Grade C): -28%';
	} elseif ( 'D' === $body_cond ) {
		$multiplier *= 0.50;
		$deductions[] = 'Ngoại hình trầy nhiều, nứt kính lưng (Grade D): -50%';
	}

	// Screen deduction
	if ( 'scratches' === $screen_cond ) {
		$multiplier *= 0.94;
		$deductions[] = 'Màn hình có vết xước lông mèo: -6%';
	} elseif ( 'cracked' === $screen_cond ) {
		$multiplier *= 0.65;
		$deductions[] = 'Màn hình nứt kính / sọc / chảy mực: -35%';
	} elseif ( 'dead_pixels' === $screen_cond ) {
		$multiplier *= 0.75;
		$deductions[] = 'Màn hình ám ố, đốm sáng: -25%';
	}

	// Battery deduction
	if ( 'normal' === $battery_cond ) {
		$multiplier *= 0.97;
		$deductions[] = 'Pin dung lượng 80% - 85%: -3%';
	} elseif ( 'service' === $battery_cond ) {
		$multiplier *= 0.90;
		$deductions[] = 'Pin chai dưới 80% (cần bảo trì): -10%';
	}

	// Camera & Face ID
	if ( 'broken' === $camera_cond ) {
		$multiplier *= 0.82;
		$deductions[] = 'Cụm camera lỗi chức năng / đốm cam: -18%';
	}
	if ( 'defective' === $faceid_cond ) {
		$multiplier *= 0.80;
		$deductions[] = 'Mất chức năng Face ID / Touch ID: -20%';
	}

	// Repair history
	if ( 'third_party' === $repaired ) {
		$multiplier *= 0.85;
		$deductions[] = 'Máy đã qua sửa chữa bên ngoài: -15%';
	}

	// Accessories Bonus
	if ( 'full_box' === $accessories ) {
		$base_price += 300000;
		$deductions[] = 'Đầy đủ hộp trùng IMEI & cáp sạc: +300.000₫';
	}

	$estimated_price = round( ( $base_price * $multiplier ) / 10000 ) * 10000;
	if ( $estimated_price < 500000 ) {
		$estimated_price = 500000;
	}

	$price_min = round( ( $estimated_price * 0.95 ) / 10000 ) * 10000;
	$price_max = round( ( $estimated_price * 1.05 ) / 10000 ) * 10000;

	// Grade label
	$grade = 'A';
	if ( $multiplier < 0.60 ) {
		$grade = 'D';
	} elseif ( $multiplier < 0.75 ) {
		$grade = 'C';
	} elseif ( $multiplier < 0.90 ) {
		$grade = 'B';
	}

	return rest_ensure_response( array(
		'success'         => true,
		'model_id'        => $model_id,
		'model_name'      => $model->name,
		'storage'         => $storage,
		'estimated_price' => $estimated_price,
		'estimated_fmt'   => number_format( $estimated_price, 0, ',', '.' ) . '₫',
		'price_min_fmt'   => number_format( $price_min, 0, ',', '.' ) . '₫',
		'price_max_fmt'   => number_format( $price_max, 0, ',', '.' ) . '₫',
		'grade'           => $grade,
		'deductions'      => $deductions,
		'notice'          => 'Giá thu mua chính xác sẽ được xác nhận sau khi chuyên viên PhoneX kiểm định thực tế thiết bị.',
	) );
}

/**
 * 5. Submit Buyback Request into CRM
 */
function phonex_buyback_api_submit_request( WP_REST_Request $request ) {
	global $wpdb;
	$t_req = $wpdb->prefix . 'phonex_buyback_requests';

	$name  = sanitize_text_field( $request->get_param( 'customer_name' ) ?? '' );
	$phone = sanitize_text_field( $request->get_param( 'customer_phone' ) ?? '' );

	if ( empty( $name ) || empty( $phone ) ) {
		return new WP_Error( 'missing_fields', 'Vui lòng cung cấp họ tên và số điện thoại liên hệ.', array( 'status' => 400 ) );
	}

	$brand_name  = sanitize_text_field( $request->get_param( 'brand_name' ) ?? '' );
	$model_name  = sanitize_text_field( $request->get_param( 'model_name' ) ?? '' );
	$storage     = sanitize_text_field( $request->get_param( 'storage' ) ?? '' );
	$color       = sanitize_text_field( $request->get_param( 'color' ) ?? '' );
	$grade       = sanitize_text_field( $request->get_param( 'grade' ) ?? 'A' );
	$est_price   = floatval( $request->get_param( 'estimated_price' ) ?? 0 );
	$method      = sanitize_text_field( $request->get_param( 'inspection_method' ) ?? 'store' );
	$store_name  = sanitize_text_field( $request->get_param( 'store_name' ) ?? 'PhoneX Flagship 136 Nguyễn Thái Học, Q.1, TP.HCM' );
	$app_date    = sanitize_text_field( $request->get_param( 'appointment_date' ) ?? date( 'Y-m-d', strtotime( '+1 day' ) ) );
	$app_time    = sanitize_text_field( $request->get_param( 'appointment_time' ) ?? '09:00 - 11:00' );
	$notes       = sanitize_textarea_field( $request->get_param( 'customer_notes' ) ?? '' );
	$cond_detail = $request->get_param( 'condition_details' );
	if ( is_array( $cond_detail ) ) {
		$cond_detail = wp_json_encode( $cond_detail );
	}

	// Generate unique request code
	$req_code = 'PX-TM-' . date( 'ymd' ) . '-' . strtoupper( wp_generate_password( 4, false ) );

	$data = array(
		'request_code'      => $req_code,
		'customer_name'     => $name,
		'customer_phone'    => $phone,
		'brand_name'        => $brand_name,
		'model_name'        => $model_name,
		'storage'           => $storage,
		'color'             => $color,
		'condition_grade'   => $grade,
		'condition_details' => $cond_detail,
		'estimated_price'   => $est_price,
		'inspection_method' => $method,
		'store_name'        => $store_name,
		'appointment_date'  => $app_date,
		'appointment_time'  => $app_time,
		'customer_notes'    => $notes,
		'status'            => 'new',
	);

	$res = $wpdb->insert( $t_req, $data );
	if ( false === $res ) {
		return new WP_Error( 'db_error', 'Lỗi khi lưu yêu cầu: ' . $wpdb->last_error, array( 'status' => 500 ) );
	}

	return rest_ensure_response( array(
		'success'      => true,
		'request_code' => $req_code,
		'message'      => 'Gửi yêu cầu thu mua thành công! Nhân viên kiểm định PhoneX sẽ gọi lại xác nhận trong vòng 15 phút.',
		'lookup_url'   => home_url( '/tra-cuu-yeu-cau/?phone=' . rawurlencode( $phone ) ),
	) );
}

/**
 * 6. Lookup Requests by Phone Number
 */
function phonex_buyback_api_lookup( WP_REST_Request $request ) {
	global $wpdb;
	$phone = trim( sanitize_text_field( $request->get_param( 'phone' ) ?? '' ) );
	$code  = trim( sanitize_text_field( $request->get_param( 'code' ) ?? '' ) );

	$search_val = ! empty( $phone ) ? $phone : $code;
	if ( empty( $search_val ) ) {
		return rest_ensure_response( array( 'success' => true, 'requests' => array() ) );
	}

	$t_req = $wpdb->prefix . 'phonex_buyback_requests';
	$rows  = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM $t_req WHERE customer_phone = %s OR request_code = %s ORDER BY created_at DESC LIMIT 20",
			$search_val,
			$search_val
		)
	);

	$status_map = array(
		'new'             => array( 'label' => 'Mới tạo', 'step' => 1, 'color' => 'blue' ),
		'contacted'       => array( 'label' => 'Đã liên hệ', 'step' => 2, 'color' => 'indigo' ),
		'scheduled'       => array( 'label' => 'Đã đặt lịch hẹn', 'step' => 3, 'color' => 'purple' ),
		'inspecting'      => array( 'label' => 'Đang kiểm định', 'step' => 4, 'color' => 'amber' ),
		'price_agreed'    => array( 'label' => 'Đã chốt giá', 'step' => 5, 'color' => 'orange' ),
		'price_confirmed' => array( 'label' => 'Đã chốt giá', 'step' => 5, 'color' => 'orange' ),
		'bought'          => array( 'label' => 'Đã giải ngân', 'step' => 6, 'color' => 'emerald' ),
		'purchased'       => array( 'label' => 'Đã thu mua', 'step' => 6, 'color' => 'emerald' ),
		'completed'       => array( 'label' => 'Hoàn tất', 'step' => 7, 'color' => 'green' ),
		'cancelled'       => array( 'label' => 'Đã hủy', 'step' => 0, 'color' => 'red' ),
	);

	$results = array();
	foreach ( $rows as $r ) {
		$st_info = $status_map[ $r->status ] ?? array( 'label' => 'Đang xử lý', 'step' => 1, 'color' => 'gray' );
		$results[] = array(
			'request_code'             => $r->request_code,
			'customer_name'            => $r->customer_name,
			'brand_name'               => $r->brand_name,
			'model_name'               => $r->model_name,
			'device'                   => $r->model_name . ( $r->storage ? ' ' . $r->storage : '' ),
			'storage'                  => $r->storage,
			'color'                    => $r->color,
			'condition_grade'          => $r->condition_grade,
			'grade'                    => $r->condition_grade,
			'estimated_price'          => (float) $r->estimated_price,
			'estimated_price_formatted'=> number_format( $r->estimated_price, 0, ',', '.' ) . '₫',
			'final_price'              => $r->final_price,
			'final_price_formatted'    => $r->final_price ? ( number_format( $r->final_price, 0, ',', '.' ) . '₫' ) : 'Chờ thẩm định',
			'status'                   => $r->status,
			'status_label'             => $st_info['label'],
			'status_step'              => $st_info['step'],
			'status_color'             => $st_info['color'],
			'appointment_date'         => $r->appointment_date ? date( 'd/m/Y', strtotime( $r->appointment_date ) ) : 'Chưa xếp',
			'appointment_time'         => $r->appointment_time,
			'inspection_method'        => ( 'home' === $r->inspection_method ) ? 'Kiểm định tận nhà' : 'Tại Showroom PhoneX',
			'store_name'               => $r->store_name,
			'created_at'               => date( 'H:i d/m/Y', strtotime( $r->created_at ) ),
			'customer_notes'           => $r->customer_notes,
			'staff_notes'              => $r->staff_notes,
		);
	}

	return rest_ensure_response( array( 'success' => true, 'requests' => $results ) );
}
