<?php
/**
 * PhoneX Custom Database Schema & Management
 *
 * Implements dedicated tables for PhoneX High-Performance Omnichannel Smartphone Operations:
 * - 128 Showrooms Directory
 * - Real-time Multi-store Inventory
 * - Trade-in (Thu cũ đổi mới) Valuation Matrix & Requests
 * - Electronic Warranty (Bảo hành điện tử theo Serial / IMEI) & RMA
 * - In-Store Pickup Reservations
 * - Phone OTP Verification
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PHONEX_DB_VERSION = '1.0.0';

/**
 * Creates or updates custom PhoneX database tables using dbDelta.
 */
function phonex_install_database() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$sql = "
	CREATE TABLE {$wpdb->prefix}phonex_stores (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		store_code varchar(32) NOT NULL,
		name varchar(255) NOT NULL,
		province varchar(100) NOT NULL,
		district varchar(100) NOT NULL,
		address text NOT NULL,
		phone varchar(32) NOT NULL,
		opening_hours varchar(100) DEFAULT '08:00 - 21:30',
		latitude decimal(10,8) DEFAULT NULL,
		longitude decimal(11,8) DEFAULT NULL,
		is_active tinyint(1) DEFAULT 1,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_store_code (store_code),
		KEY idx_province_district (province, district)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_store_inventory (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		store_id bigint(20) unsigned NOT NULL,
		product_id bigint(20) unsigned NOT NULL,
		variation_id bigint(20) unsigned DEFAULT 0,
		stock_quantity int(11) NOT NULL DEFAULT 0,
		reserved_quantity int(11) NOT NULL DEFAULT 0,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_store_product_variation (store_id, product_id, variation_id),
		KEY idx_product_stock (product_id, stock_quantity)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_tradein_models (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		brand varchar(64) NOT NULL,
		model_name varchar(255) NOT NULL,
		storage_capacity varchar(32) NOT NULL,
		base_price decimal(12,2) NOT NULL,
		grade_a_rate decimal(4,2) DEFAULT 1.00,
		grade_b_rate decimal(4,2) DEFAULT 0.85,
		grade_c_rate decimal(4,2) DEFAULT 0.65,
		grade_d_rate decimal(4,2) DEFAULT 0.40,
		subsidize_amount decimal(12,2) DEFAULT 0.00,
		is_active tinyint(1) DEFAULT 1,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		KEY idx_brand_model (brand, model_name(100))
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_tradein_requests (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		request_code varchar(32) NOT NULL,
		customer_name varchar(150) NOT NULL,
		customer_phone varchar(20) NOT NULL,
		old_model_id bigint(20) unsigned NOT NULL,
		condition_grade enum('A','B','C','D') NOT NULL,
		functional_issues text DEFAULT NULL,
		cosmetic_issues text DEFAULT NULL,
		estimated_value decimal(12,2) NOT NULL,
		final_value decimal(12,2) DEFAULT NULL,
		target_product_id bigint(20) unsigned DEFAULT NULL,
		fulfillment_store_id bigint(20) unsigned DEFAULT NULL,
		status enum('pending','appraised','accepted','completed','cancelled') DEFAULT 'pending',
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_request_code (request_code),
		KEY idx_customer_phone (customer_phone),
		KEY idx_status (status)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_warranty_records (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		imei varchar(32) NOT NULL,
		serial_number varchar(64) DEFAULT NULL,
		product_name varchar(255) NOT NULL,
		order_id bigint(20) unsigned DEFAULT NULL,
		customer_name varchar(150) NOT NULL,
		customer_phone varchar(20) NOT NULL,
		purchase_date date NOT NULL,
		warranty_expire_date date NOT NULL,
		warranty_package varchar(100) DEFAULT 'Standard 12M',
		status enum('active','expired','voided') DEFAULT 'active',
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_imei (imei),
		KEY idx_serial_number (serial_number),
		KEY idx_customer_phone (customer_phone)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_warranty_requests (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		ticket_code varchar(32) NOT NULL,
		warranty_id bigint(20) unsigned NOT NULL,
		store_id bigint(20) unsigned DEFAULT NULL,
		issue_description text NOT NULL,
		status enum('received','diagnosing','repairing','completed','rejected','returned') DEFAULT 'received',
		resolution_notes text DEFAULT NULL,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_ticket_code (ticket_code),
		KEY idx_warranty_id (warranty_id)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_store_reservations (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		reservation_code varchar(32) NOT NULL,
		product_id bigint(20) unsigned NOT NULL,
		variation_id bigint(20) unsigned DEFAULT 0,
		store_id bigint(20) unsigned NOT NULL,
		customer_name varchar(150) NOT NULL,
		customer_phone varchar(20) NOT NULL,
		expires_at datetime NOT NULL,
		status enum('holding','picked_up','expired','cancelled') DEFAULT 'holding',
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		UNIQUE KEY uq_reservation_code (reservation_code),
		KEY idx_store_status (store_id, status)
	) $charset_collate;

	CREATE TABLE {$wpdb->prefix}phonex_otp_verifications (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		phone_number varchar(20) NOT NULL,
		otp_code varchar(10) NOT NULL,
		action_type varchar(50) NOT NULL,
		expires_at datetime NOT NULL,
		is_used tinyint(1) DEFAULT 0,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id),
		KEY idx_phone_action (phone_number, action_type)
	) $charset_collate;
	";

	dbDelta( $sql );

	update_option( 'phonex_db_version', PHONEX_DB_VERSION );
}

add_action( 'after_switch_theme', 'phonex_install_database' );

/**
 * Seed initial sample stores if none exist
 */
function phonex_seed_sample_data_if_empty() {
	global $wpdb;
	$table_stores = $wpdb->prefix . 'phonex_stores';

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_stores'" ) === $table_stores ) {
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_stores" );
		if ( intval( $count ) === 0 ) {
			$wpdb->insert( $table_stores, array(
				'store_code'    => 'HN-THAIHA-01',
				'name'          => 'PhoneX Flagship 58 Thái Hà',
				'province'      => 'Hà Nội',
				'district'      => 'Đống Đa',
				'address'       => '58 Thái Hà, Trung Liệt, Đống Đa, Hà Nội',
				'phone'         => '024.7300.6868',
				'opening_hours' => '08:00 - 22:00',
				'latitude'      => 21.01185,
				'longitude'     => 105.82025,
				'is_active'     => 1,
			) );

			$wpdb->insert( $table_stores, array(
				'store_code'    => 'HCM-NTH-01',
				'name'          => 'PhoneX Flagship 136 Nguyễn Thái Học',
				'province'      => 'TP. Hồ Chí Minh',
				'district'      => 'Quận 1',
				'address'       => '136 Nguyễn Thái Học, P. Phạm Ngũ Lão, Quận 1, TP. HCM',
				'phone'         => '028.7300.6868',
				'opening_hours' => '08:00 - 22:00',
				'latitude'      => 10.76785,
				'longitude'     => 106.69345,
				'is_active'     => 1,
			) );

			$wpdb->insert( $table_stores, array(
				'store_code'    => 'DN-NVL-01',
				'name'          => 'PhoneX 88 Nguyễn Văn Linh',
				'province'      => 'Đà Nẵng',
				'district'      => 'Hải Châu',
				'address'       => '88 Nguyễn Văn Linh, Nam Dương, Hải Châu, Đà Nẵng',
				'phone'         => '0236.7300.6868',
				'opening_hours' => '08:00 - 21:30',
				'latitude'      => 16.06120,
				'longitude'     => 108.21730,
				'is_active'     => 1,
			) );
		}
	}
}
add_action( 'after_switch_theme', 'phonex_seed_sample_data_if_empty', 20 );
