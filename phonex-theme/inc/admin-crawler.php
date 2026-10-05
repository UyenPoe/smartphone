<?php
/**
 * PhoneX TGDD Product Crawler & Importer
 *
 * Crawls mobile phone data from TheGioiDiDong (https://www.thegioididong.com/dtdd)
 * Extracts the 8 specified fields:
 * 1. Tên sản phẩm
 * 2. URL sản phẩm nguồn
 * 3. Giá hiện tại
 * 4. Giá cũ
 * 5. Hãng / Model
 * 6. Dung lượng nếu xác định được
 * 7. Một số thông số kỹ thuật cơ bản
 * 8. Thời điểm cập nhật dữ liệu
 *
 * Saves into WooCommerce under Category "Điện thoại" and corresponding Brand child categories.
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Admin Menu for "📥 Nhập dữ liệu TGDD"
 */
function phonex_crawler_add_admin_menu() {
	add_menu_page(
		__( 'Nhập Dữ Liệu Điện Thoại TGDD', 'phonex' ),
		__( '📥 Nhập TGDD', 'phonex' ),
		'manage_options',
		'phonex-crawler',
		'phonex_crawler_render_admin_page',
		'dashicons-download',
		28
	);
}
// TGDD crawler menu deactivated per request: TGDD products cleaned from system
// add_action( 'admin_menu', 'phonex_crawler_add_admin_menu' );

/**
 * Helper: Crawl HTML from TGDD via cURL with browser headers
 *
 * @param string $url Target URL.
 * @return string|false HTML or false on failure.
 */
function phonex_crawler_fetch_html( $url ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36' );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	$html = curl_exec( $ch );
	$code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
	curl_close( $ch );

	if ( 200 !== $code || empty( $html ) ) {
		return false;
	}

	return $html;
}

/**
 * Helper: Parse TGDD HTML into structured product data
 *
 * @param string $html Raw HTML.
 * @param string $forced_brand Optional forced brand filter.
 * @return array Array of products.
 */
function phonex_crawler_parse_products( $html, $forced_brand = '' ) {
	$products = array();

	// Match all product li blocks
	preg_match_all( '/<li[^>]*class=["\'][^"\']*item[^"\']*["\'][^>]*>(.*?)<\/li>/is', $html, $matches );

	if ( empty( $matches[0] ) ) {
		return $products;
	}

	$now_vn = current_time( 'Y-m-d H:i:s' );

	foreach ( $matches[0] as $block ) {
		if ( ! preg_match( '/data-name=["\']([^"\']+)["\']/i', $block, $nm ) ||
			! preg_match( '/data-price=["\']([^"\']+)["\']/i', $block, $pr ) ) {
			continue;
		}

		$raw_name   = html_entity_decode( $nm[1], ENT_QUOTES, 'UTF-8' );
		$clean_name = trim( preg_replace( '/^Điện thoại\s+/iu', '', $raw_name ) );
		$data_price = floatval( $pr[1] );

		// 1. Strong.price (Sale/Current display price)
		$strong_price = 0;
		if ( preg_match( '/<strong[^>]*class=["\']price["\'][^>]*>([^<]+)<\/strong>/i', $block, $st ) ) {
			$decoded_st = html_entity_decode( $st[1], ENT_QUOTES, 'UTF-8' );
			$digits     = preg_replace( '/[^0-9]/', '', $decoded_st );
			if ( ! empty( $digits ) ) {
				$strong_price = floatval( $digits );
			}
		}

		// Calculate Current Price & Old Price
		$price_current = 0;
		$price_old     = 0;

		if ( $strong_price > 0 && $data_price > 0 && $strong_price < $data_price ) {
			$price_current = $strong_price;
			$price_old     = $data_price;
		} elseif ( $strong_price > 0 && $data_price > 0 && $data_price < $strong_price ) {
			$price_current = $data_price;
			$price_old     = $strong_price;
		} else {
			$price_current = $data_price > 0 ? $data_price : $strong_price;
			$price_old     = 0;
		}

		// 2. Brand & Model
		$brand = '';
		if ( preg_match( '/data-brand=["\']([^"\']+)["\']/i', $block, $br ) ) {
			$brand = trim( html_entity_decode( $br[1], ENT_QUOTES, 'UTF-8' ) );
			if ( stripos( $brand, 'Apple' ) !== false || stripos( $brand, 'iPhone' ) !== false ) {
				$brand = 'Apple';
			} elseif ( stripos( $brand, 'Samsung' ) !== false ) {
				$brand = 'Samsung';
			} elseif ( stripos( $brand, 'Xiaomi' ) !== false || stripos( $brand, 'Redmi' ) !== false ) {
				$brand = 'Xiaomi';
			} elseif ( stripos( $brand, 'OPPO' ) !== false ) {
				$brand = 'OPPO';
			} elseif ( stripos( $brand, 'vivo' ) !== false ) {
				$brand = 'Vivo';
			} elseif ( stripos( $brand, 'realme' ) !== false ) {
				$brand = 'Realme';
			}
		}

		if ( empty( $brand ) && ! empty( $forced_brand ) ) {
			$brand = $forced_brand;
		}

		// Model: Remove brand prefix and storage from clean_name if needed
		$model_name = $clean_name;

		// 3. Storage / Capacity (Dung lượng) e.g. 64GB, 128GB, 256GB, 512GB, 1TB
		$capacity = '';
		if ( preg_match( '/\b(32GB|64GB|128GB|256GB|512GB|1TB|2TB)\b/i', $clean_name, $cap ) ) {
			$capacity = strtoupper( $cap[1] );
		}

		// 4. Source URL
		$source_url = '';
		if ( preg_match( '/<a[^>]*href=["\']([^"\']+)["\']/i', $block, $hr ) ) {
			$source_url = $hr[1];
			if ( strpos( $source_url, 'http' ) !== 0 ) {
				$source_url = 'https://www.thegioididong.com' . $source_url;
			}
		}

		// 5. Image URL
		$img_url = '';
		if ( preg_match( '/<img[^>]*class=["\'][^"\']*thumb[^"\']*["\'][^>]*src=["\']([^"\']+)["\']/i', $block, $im ) ) {
			$img_url = $im[1];
		} elseif ( preg_match( '/data-src=["\']([^"\']+)["\']/i', $block, $im ) ) {
			$img_url = $im[1];
		}
		if ( strpos( $img_url, '//' ) === 0 ) {
			$img_url = 'https:' . $img_url;
		}

		// 6. Basic Specs (Thông số cơ bản)
		$specs = array();
		if ( preg_match( '/<div[^>]*class=["\'][^"\']*item-compare[^"\']*["\'][^>]*>(.*?)<\/div>/is', $block, $cp ) ) {
			if ( preg_match_all( '/<span>([^<]+)<\/span>/i', $cp[1], $sp_matches ) ) {
				foreach ( $sp_matches[1] as $s ) {
					$s = trim( html_entity_decode( $s, ENT_QUOTES, 'UTF-8' ) );
					if ( ! empty( $s ) ) {
						$specs[] = $s;
					}
				}
			}
		}
		$spec_summary = implode( ' • ', $specs );

		// Check if product already exists in PhoneX DB
		$existing_id           = phonex_crawler_find_existing_product( $clean_name, $source_url );
		$existing_last_crawled = $existing_id ? get_post_meta( $existing_id, '_last_crawled_at', true ) : '';

		$products[] = array(
			'name'                  => $clean_name,
			'source_url'            => $source_url,
			'price_current'         => $price_current,
			'price_old'             => $price_old,
			'brand'                 => $brand,
			'model'                 => $model_name,
			'capacity'              => $capacity,
			'specs'                 => $spec_summary,
			'image'                 => $img_url,
			'updated_at'            => $now_vn,
			'existing_id'           => $existing_id,
			'existing_last_crawled' => $existing_last_crawled,
		);
	}

	return $products;
}

/**
 * Check if a product already exists by source URL or exact title
 */
function phonex_crawler_find_existing_product( $title, $source_url = '' ) {
	global $wpdb;

	if ( ! empty( $source_url ) ) {
		$found_by_meta = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_source_url' AND meta_value = %s LIMIT 1",
				$source_url
			)
		);
		if ( $found_by_meta ) {
			return intval( $found_by_meta );
		}
	}

	$found_by_title = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'product' AND post_status != 'trash' LIMIT 1",
			$title
		)
	);

	return $found_by_title ? intval( $found_by_title ) : 0;
}

/**
 * Ensure Category Hierarchy: "Điện thoại" (Parent) -> Brand (Child)
 *
 * @param string $brand_name Brand name like Apple, Samsung.
 * @return array Array of term IDs [parent_id, child_id].
 */
function phonex_crawler_ensure_categories( $brand_name ) {
	$term_ids = array();

	// 1. Parent: Điện thoại
	$parent_slug = 'dien-thoai';
	$parent_term = get_term_by( 'slug', $parent_slug, 'product_cat' );
	if ( ! $parent_term ) {
		$parent_create = wp_insert_term( 'Điện thoại', 'product_cat', array( 'slug' => $parent_slug ) );
		$parent_id     = is_array( $parent_create ) ? $parent_create['term_id'] : 0;
	} else {
		$parent_id = $parent_term->term_id;
	}

	if ( $parent_id ) {
		$term_ids[] = $parent_id;
	}

	// 2. Child Brand category
	if ( ! empty( $brand_name ) ) {
		$brand_slug  = sanitize_title( $brand_name );
		$child_term  = get_term_by( 'slug', $brand_slug, 'product_cat' );
		if ( ! $child_term ) {
			$child_create = wp_insert_term(
				$brand_name,
				'product_cat',
				array(
					'slug'   => $brand_slug,
					'parent' => $parent_id,
				)
			);
			$child_id = is_array( $child_create ) ? $child_create['term_id'] : 0;
		} else {
			$child_id = $child_term->term_id;
		}

		if ( $child_id ) {
			$term_ids[] = $child_id;
		}
	}

	return $term_ids;
}

/**
 * Import a single product into WooCommerce
 *
 * @param array $item Sanitized item array.
 * @param bool  $download_img Whether to download image into Media Library.
 * @return array Result array [success, id, message, action].
 */
function phonex_crawler_save_product( $item, $download_img = true ) {
	if ( empty( $item['name'] ) || empty( $item['price_current'] ) ) {
		return array(
			'success' => false,
			'message' => 'Tên hoặc giá sản phẩm không hợp lệ.',
		);
	}

	$existing_id = phonex_crawler_find_existing_product( $item['name'], $item['source_url'] );
	$is_update   = ( $existing_id > 0 );

	// Calculate prices
	$price_current = floatval( $item['price_current'] );
	$price_old     = floatval( $item['price_old'] );

	if ( $price_old > $price_current ) {
		$regular_price = $price_old;
		$sale_price    = $price_current;
	} else {
		$regular_price = $price_current;
		$sale_price    = '';
	}

	// Prepare Post Data
	$post_data = array(
		'post_title'   => sanitize_text_field( $item['name'] ),
		'post_type'    => 'product',
		'post_status'  => 'publish',
		'post_excerpt' => sanitize_text_field( $item['specs'] ?? '' ),
	);

	if ( $is_update ) {
		$post_data['ID'] = $existing_id;
		$product_id      = wp_update_post( $post_data );
		$action          = 'updated';
	} else {
		$product_id = wp_insert_post( $post_data );
		$action     = 'created';
	}

	if ( is_wp_error( $product_id ) || ! $product_id ) {
		return array(
			'success' => false,
			'message' => 'Không thể tạo bài viết sản phẩm: ' . ( is_wp_error( $product_id ) ? $product_id->get_error_message() : '' ),
		);
	}

	// Set WooCommerce product type & meta
	wp_set_object_terms( $product_id, 'simple', 'product_type' );

	update_post_meta( $product_id, '_visibility', 'visible' );
	update_post_meta( $product_id, '_stock_status', 'instock' );
	update_post_meta( $product_id, '_total_sales', '0' );
	update_post_meta( $product_id, '_regular_price', $regular_price );
	update_post_meta( $product_id, '_sale_price', $sale_price );
	update_post_meta( $product_id, '_price', $price_current );

	// 8 EXACT FIELDS REQUIRED BY USER
	update_post_meta( $product_id, '_source_url', esc_url_raw( $item['source_url'] ?? '' ) );
	update_post_meta( $product_id, '_brand_name', sanitize_text_field( $item['brand'] ?? '' ) );
	update_post_meta( $product_id, '_model_name', sanitize_text_field( $item['model'] ?? $item['name'] ) );
	update_post_meta( $product_id, '_storage_capacity', sanitize_text_field( $item['capacity'] ?? '' ) );
	update_post_meta( $product_id, '_basic_specs', sanitize_text_field( $item['specs'] ?? '' ) );
	update_post_meta( $product_id, '_last_crawled_at', sanitize_text_field( $item['updated_at'] ?? current_time( 'Y-m-d H:i:s' ) ) );

	// Assign Categories: Điện thoại + Brand
	$cat_ids = phonex_crawler_ensure_categories( $item['brand'] ?? '' );
	if ( ! empty( $cat_ids ) ) {
		wp_set_object_terms( $product_id, array_map( 'intval', $cat_ids ), 'product_cat' );
	}
	if ( ! empty( $item['brand'] ) ) {
		wp_set_object_terms( $product_id, sanitize_text_field( $item['brand'] ), 'product_brand' );
	}

	// Handle Image
	if ( ! empty( $item['image'] ) ) {
		// Store CDN image as fallback meta
		update_post_meta( $product_id, '_crawler_image_url', esc_url_raw( $item['image'] ) );

		// If product does not have a featured image and download is requested
		if ( $download_img && ! has_post_thumbnail( $product_id ) ) {
			phonex_crawler_attach_image( $product_id, $item['image'], $item['name'] );
		}
	}

	return array(
		'success' => true,
		'id'      => $product_id,
		'name'    => $item['name'],
		'brand'   => $item['brand'],
		'action'  => $action,
		'message' => ( 'created' === $action ) ? 'Đã thêm mới thành công' : 'Đã cập nhật giá & thông số',
	);
}

/**
 * Helper: Download image from URL and set as featured image
 */
function phonex_crawler_attach_image( $post_id, $image_url, $desc ) {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// Download image into temp file
	$temp_file = download_url( $image_url, 15 );
	if ( is_wp_error( $temp_file ) ) {
		return false;
	}

	$file_array = array(
		'name'     => sanitize_file_name( $desc ) . '.jpg',
		'tmp_name' => $temp_file,
	);

	$attach_id = media_handle_sideload( $file_array, $post_id, $desc );
	if ( is_wp_error( $attach_id ) ) {
		@unlink( $temp_file );
		return false;
	}

	set_post_thumbnail( $post_id, $attach_id );
	return $attach_id;
}

/**
 * AJAX: Fetch & Preview Products from TGDD
 */
function phonex_crawler_ajax_fetch_preview() {
	check_ajax_referer( 'phonex_crawler_nonce', 'security' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Bạn không có quyền thực hiện.' ) );
	}

	$brand_slug = sanitize_text_field( $_POST['brand'] ?? 'all' );

	$url_map = array(
		'all'     => 'https://www.thegioididong.com/dtdd',
		'apple'   => 'https://www.thegioididong.com/dtdd-apple-iphone',
		'samsung' => 'https://www.thegioididong.com/dtdd-samsung',
		'xiaomi'  => 'https://www.thegioididong.com/dtdd-xiaomi',
		'oppo'    => 'https://www.thegioididong.com/dtdd-oppo',
		'vivo'    => 'https://www.thegioididong.com/dtdd-vivo',
		'realme'  => 'https://www.thegioididong.com/dtdd-realme',
	);

	$target_url   = $url_map[ $brand_slug ] ?? $url_map['all'];
	$forced_brand = ( 'all' !== $brand_slug ) ? ucfirst( $brand_slug ) : '';

	$html = phonex_crawler_fetch_html( $target_url );
	if ( ! $html ) {
		wp_send_json_error( array( 'message' => 'Không thể kết nối đến Thế Giới Di Động. Vui lòng thử lại sau.' ) );
	}

	$products = phonex_crawler_parse_products( $html, $forced_brand );

	wp_send_json_success(
		array(
			'count'    => count( $products ),
			'products' => $products,
			'source'   => $target_url,
		)
	);
}
add_action( 'wp_ajax_phonex_crawler_fetch_preview', 'phonex_crawler_ajax_fetch_preview' );

/**
 * AJAX: Import Single Product (For batching / progress bar)
 */
function phonex_crawler_ajax_import_item() {
	check_ajax_referer( 'phonex_crawler_nonce', 'security' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Bạn không có quyền thực hiện.' ) );
	}

	$item = array(
		'name'          => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
		'source_url'    => esc_url_raw( wp_unslash( $_POST['source_url'] ?? '' ) ),
		'price_current' => floatval( $_POST['price_current'] ?? 0 ),
		'price_old'     => floatval( $_POST['price_old'] ?? 0 ),
		'brand'         => sanitize_text_field( wp_unslash( $_POST['brand'] ?? '' ) ),
		'model'         => sanitize_text_field( wp_unslash( $_POST['model'] ?? '' ) ),
		'capacity'      => sanitize_text_field( wp_unslash( $_POST['capacity'] ?? '' ) ),
		'specs'         => sanitize_text_field( wp_unslash( $_POST['specs'] ?? '' ) ),
		'image'         => esc_url_raw( wp_unslash( $_POST['image'] ?? '' ) ),
		'updated_at'    => sanitize_text_field( wp_unslash( $_POST['updated_at'] ?? '' ) ),
	);

	$download_img = ! empty( $_POST['download_img'] ) && '1' === strval( $_POST['download_img'] );

	$res = phonex_crawler_save_product( $item, $download_img );

	if ( $res['success'] ) {
		wp_send_json_success( $res );
	} else {
		wp_send_json_error( $res );
	}
}
add_action( 'wp_ajax_phonex_crawler_ajax_import_item', 'phonex_crawler_ajax_import_item' );

/**
 * Render Admin Page UI
 */
function phonex_crawler_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$ajax_nonce = wp_create_nonce( 'phonex_crawler_nonce' );
	?>
	<div class="wrap" style="max-width: 1300px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
		
		<!-- Header Banner -->
		<div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; padding: 24px 28px; border-radius: 14px; margin-bottom: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
			<div style="display: flex; align-items: center; gap: 16px;">
				<div style="width: 52px; height: 52px; background: rgba(255,255,255,0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
					<span class="dashicons dashicons-download" style="font-size: 30px; width: 30px; height: 30px; color: #38bdf8;"></span>
				</div>
				<div>
					<h1 style="font-size: 22px; font-weight: 800; margin: 0; color: #fff; line-height: 1.2;">Công Cụ Crawl & Nhập Dữ Liệu TGDD</h1>
					<p style="margin: 4px 0 0; color: #94a3b8; font-size: 13px;">
						Quét tự động từ <strong>thegioididong.com/dtdd</strong> &bull; Trích xuất đúng 8 trường thông tin &bull; Tự động phân loại Danh mục và Hãng vào WooCommerce
					</p>
				</div>
			</div>
			<div>
				<a href="<?php echo esc_url( home_url( '/khuyen-mai/' ) ); ?>" target="_blank" class="button" style="background: #2563eb; color: #fff; border: 0; font-weight: 700; padding: 6px 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 6px rgba(37,99,235,0.4);">
					Xem Trang Khuyến Mãi &rarr;
				</a>
			</div>
		</div>

		<!-- Control Panel Box -->
		<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
			<h2 style="font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 16px; color: #1e293b; display: flex; align-items: center; gap: 8px;">
				<span class="dashicons dashicons-filter" style="color: #64748b;"></span> Tùy Chọn Quét Dữ Liệu
			</h2>

			<div style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
				
				<!-- Brand Filter Selection -->
				<div style="flex: 1; min-width: 220px;">
					<label for="crawler-brand" style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
						1. Chọn Thương Hiệu / Nguồn:
					</label>
					<select id="crawler-brand" style="width: 100%; height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; padding: 0 12px;">
						<option value="all">Tất cả điện thoại (Trang chủ /dtdd)</option>
						<option value="apple">Apple (iPhone)</option>
						<option value="samsung">Samsung</option>
						<option value="xiaomi">Xiaomi (Redmi)</option>
						<option value="oppo">OPPO</option>
						<option value="vivo">Vivo</option>
						<option value="realme">Realme</option>
					</select>
				</div>

				<!-- Download image checkbox -->
				<div style="flex: 1; min-width: 240px; display: flex; align-items: center; height: 40px;">
					<label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #334155; cursor: pointer;">
						<input type="checkbox" id="crawler-download-img" checked="checked" style="width: 18px; height: 18px; border-radius: 4px; accent-color: #2563eb;" />
						Tải ảnh đại diện về Thư viện Media (Độc lập & Bền vững)
					</label>
				</div>

				<!-- Action Buttons -->
				<div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
					<button type="button" id="btn-scan" class="button button-primary" style="height: 40px; padding: 0 20px; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; background: #0284c7; border-color: #0284c7;">
						<span class="dashicons dashicons-search" style="margin-top: 1px;"></span> 1. Quét Dữ Liệu TGDD
					</button>

					<button type="button" id="btn-import-all" class="button" disabled style="height: 40px; padding: 0 20px; font-weight: 700; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; background: #16a34a; border-color: #16a34a; color: #fff; cursor: not-allowed; opacity: 0.6;">
						<span class="dashicons dashicons-cloud-upload" style="margin-top: 1px;"></span> 2. Nhập Hàng Loạt Vào Web
					</button>

					<label style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #475569; margin-left: 6px; cursor: pointer;">
						<input type="checkbox" id="crawler-skip-existing" checked="checked" style="accent-color: #16a34a; width: 16px; height: 16px;" />
						Chỉ nhập máy MỚI (Bỏ qua máy đã có)
					</label>
				</div>
			</div>

			<!-- Notice banner of 8 required fields -->
			<div style="margin-top: 16px; padding: 12px 16px; background: #f8fafc; border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; font-size: 12px; color: #475467; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
				<div>
					<strong>8 Trường dữ liệu chuẩn được lưu:</strong> 
					Tên sản phẩm &bull; URL nguồn &bull; Giá hiện tại &bull; Giá cũ &bull; Hãng/Model &bull; Dung lượng &bull; Thông số kỹ thuật &bull; Thời điểm cập nhật
				</div>
				<div id="scan-summary" style="font-weight: 700; color: #0f172a;"></div>
			</div>
		</div>

		<!-- Progress Bar (Hidden by default) -->
		<div id="progress-container" style="display: none; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
				<div style="font-weight: 700; color: #1e293b; font-size: 14px;" id="progress-status">Đang chuẩn bị nhập...</div>
				<div style="font-weight: 800; color: #2563eb; font-size: 14px;" id="progress-percent">0%</div>
			</div>
			<div style="width: 100%; height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
				<div id="progress-bar-fill" style="width: 0%; height: 100%; background: linear-gradient(90deg, #38bdf8, #2563eb); transition: width 0.2s ease;"></div>
			</div>
			<div id="progress-log" style="margin-top: 10px; font-size: 12px; color: #64748b; font-family: monospace;"></div>
		</div>

		<!-- Scanned Products Table -->
		<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
			<div style="padding: 14px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
				<div style="display: flex; align-items: center; gap: 12px;">
					<h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b;">Danh Sách Sản Phẩm</h3>
					<div id="filter-tabs" style="display: flex; gap: 6px;">
						<button type="button" class="tab-filter-btn active" data-filter="all" style="border: 1px solid #cbd5e1; background: #2563eb; color: #fff; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; cursor: pointer;">
							Tất cả (<span id="count-all">0</span>)
						</button>
						<button type="button" class="tab-filter-btn" data-filter="new" style="border: 1px solid #cbd5e1; background: #fff; color: #475569; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; cursor: pointer;">
							✨ Máy mới chưa có (<span id="count-new">0</span>)
						</button>
						<button type="button" class="tab-filter-btn" data-filter="exist" style="border: 1px solid #cbd5e1; background: #fff; color: #475569; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; cursor: pointer;">
							🟢 Đã có trên web (<span id="count-exist">0</span>)
						</button>
					</div>
				</div>
				<span id="badge-total" style="background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700;">Chưa quét</span>
			</div>

			<div style="overflow-x: auto;">
				<table class="wp-list-table widefat fixed striped" style="border: 0; margin: 0;" id="table-products">
					<thead>
						<tr>
							<th style="width: 50px; text-align: center;">Ảnh</th>
							<th style="width: 220px;">Tên Sản Phẩm</th>
							<th style="width: 140px;">Trạng Thái Nhập</th>
							<th style="width: 80px;">Hãng</th>
							<th style="width: 80px;">Dung lượng</th>
							<th style="width: 110px;">Giá Hiện Tại</th>
							<th style="width: 110px;">Giá Cũ (Gốc)</th>
							<th>Thông Số Kỹ Thuật</th>
							<th style="width: 130px; text-align: center;">Hành Động</th>
						</tr>
					</thead>
					<tbody id="products-tbody">
						<tr>
							<td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8; font-size: 14px;">
								<span class="dashicons dashicons-search" style="font-size: 36px; width: 36px; height: 36px; display: block; margin: 0 auto 10px; opacity: 0.5;"></span>
								Nhấn nút <strong>"1. Quét Dữ Liệu TGDD"</strong> ở trên để tải danh sách sản phẩm mới nhất từ Thế Giới Di Động.
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

	</div>

	<!-- JavaScript Controller for AJAX Crawl & Import -->
	<script>
	(function() {
		const ajaxUrl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>';
		const securityNonce = '<?php echo esc_js( $ajax_nonce ); ?>';
		let scannedProducts = [];
		let currentFilter = 'all';

		const btnScan = document.getElementById('btn-scan');
		const btnImportAll = document.getElementById('btn-import-all');
		const brandSelect = document.getElementById('crawler-brand');
		const tbody = document.getElementById('products-tbody');
		const badgeTotal = document.getElementById('badge-total');
		const scanSummary = document.getElementById('scan-summary');
		const progressContainer = document.getElementById('progress-container');
		const progressBarFill = document.getElementById('progress-bar-fill');
		const progressStatus = document.getElementById('progress-status');
		const progressPercent = document.getElementById('progress-percent');
		const progressLog = document.getElementById('progress-log');
		const chkDownloadImg = document.getElementById('crawler-download-img');
		const chkSkipExisting = document.getElementById('crawler-skip-existing');
		const countAll = document.getElementById('count-all');
		const countNew = document.getElementById('count-new');
		const countExist = document.getElementById('count-exist');

		// Format currency VND helper
		function formatVND(num) {
			if (!num || num <= 0) return '<span style="color:#94a3b8;">-</span>';
			return new Intl.NumberFormat('vi-VN').format(num) + '₫';
		}

		// Tab filter click
		document.querySelectorAll('.tab-filter-btn').forEach(btn => {
			btn.addEventListener('click', function() {
				document.querySelectorAll('.tab-filter-btn').forEach(b => {
					b.style.background = '#fff';
					b.style.color = '#475569';
					b.classList.remove('active');
				});
				this.style.background = '#2563eb';
				this.style.color = '#fff';
				this.classList.add('active');
				currentFilter = this.getAttribute('data-filter');
				renderTable();
			});
		});

		// 1. Quét dữ liệu từ TGDD
		btnScan.addEventListener('click', function() {
			const brand = brandSelect.value;
			btnScan.disabled = true;
			btnScan.innerHTML = '<span class="dashicons dashicons-update spin"></span> Đang kết nối TGDD...';
			btnImportAll.disabled = true;
			btnImportAll.style.opacity = '0.6';
			btnImportAll.style.cursor = 'not-allowed';

			tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:#64748b;"><span class="dashicons dashicons-update spin" style="font-size:24px;"></span> Đang tải và phân tích dữ liệu HTML từ thegioididong.com...</td></tr>';

			const formData = new FormData();
			formData.append('action', 'phonex_crawler_fetch_preview');
			formData.append('security', securityNonce);
			formData.append('brand', brand);

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				btnScan.disabled = false;
				btnScan.innerHTML = '<span class="dashicons dashicons-search"></span> 1. Quét Dữ Liệu TGDD';

				if (!data.success) {
					alert(data.data.message || 'Lỗi khi quét dữ liệu.');
					tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:20px; color:#ef4444;">' + (data.data.message || 'Không thể quét dữ liệu.') + '</td></tr>';
					return;
				}

				scannedProducts = data.data.products || [];
				badgeTotal.textContent = scannedProducts.length + ' sản phẩm';
				scanSummary.textContent = 'Đã quét xong: ' + scannedProducts.length + ' sản phẩm từ ' + data.data.source;

				if (scannedProducts.length === 0) {
					tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:#94a3b8;">Không tìm thấy sản phẩm nào trong trang này.</td></tr>';
					return;
				}

				// Update counts
				let newCount = 0;
				let existCount = 0;
				scannedProducts.forEach(p => {
					if (p.existing_id > 0) existCount++;
					else newCount++;
				});
				countAll.textContent = scannedProducts.length;
				countNew.textContent = newCount;
				countExist.textContent = existCount;

				// Enable Import All Button
				btnImportAll.disabled = false;
				btnImportAll.style.opacity = '1';
				btnImportAll.style.cursor = 'pointer';

				// Render Table
				renderTable();
			})
			.catch(err => {
				btnScan.disabled = false;
				btnScan.innerHTML = '<span class="dashicons dashicons-search"></span> 1. Quét Dữ Liệu TGDD';
				alert('Lỗi kết nối máy chủ: ' + err.message);
			});
		});

		// Render products list in table
		function renderTable() {
			let html = '';
			let visibleCount = 0;

			scannedProducts.forEach((p, idx) => {
				const isExisting = p.existing_id > 0;

				// Filter check
				if (currentFilter === 'new' && isExisting) return;
				if (currentFilter === 'exist' && !isExisting) return;

				visibleCount++;
				const isSale = p.price_old > p.price_current;

				let statusHtml = '';
				let actionBtnHtml = '';

				if (isExisting) {
					statusHtml = `
						<div style="display:inline-flex; align-items:center; gap:4px; padding:3px 8px; border-radius:6px; background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; font-weight:700; font-size:11px;">
							<span class="dashicons dashicons-yes-alt" style="font-size:14px; width:14px; height:14px; color:#16a34a;"></span> Đã có (#${p.existing_id})
						</div>
						${p.existing_last_crawled ? `<div style="font-size:10px; color:#64748b; margin-top:3px;">Lần crawl: ${p.existing_last_crawled}</div>` : ''}
					`;
					actionBtnHtml = `<button type="button" class="button btn-import-one" data-index="${idx}" style="font-weight:700; border-radius:6px; background:#0284c7; color:#fff; border:0; padding:3px 10px; font-size:11px;">🔄 Cập nhật giá</button>`;
				} else {
					statusHtml = `
						<div style="display:inline-flex; align-items:center; gap:4px; padding:3px 8px; border-radius:6px; background:#fffbeb; border:1px solid #fde68a; color:#b45309; font-weight:700; font-size:11px;">
							<span class="dashicons dashicons-plus-alt" style="font-size:14px; width:14px; height:14px; color:#d97706;"></span> Máy mới
						</div>
					`;
					actionBtnHtml = `<button type="button" class="button btn-import-one" data-index="${idx}" style="font-weight:700; border-radius:6px; background:#16a34a; color:#fff; border:0; padding:3px 10px; font-size:11px;">📥 Nhập ngay</button>`;
				}

				html += `<tr id="row-prod-${idx}">`;
				html += `<td style="text-align:center;"><img src="${p.image || ''}" style="width:40px; height:40px; object-fit:contain; border-radius:6px; background:#f8fafc; border:1px solid #e2e8f0;" loading="lazy"/></td>`;
				html += `<td><strong>${p.name}</strong><br/><a href="${p.source_url}" target="_blank" style="font-size:11px; color:#0284c7; text-decoration:none;" title="Xem trên TGDD">&#x2197; Link gốc TGDD</a></td>`;
				html += `<td>${statusHtml}</td>`;
				html += `<td><span style="font-weight:700; color:#1e293b;">${p.brand || '-'}</span></td>`;
				html += `<td><span style="font-weight:600; color:#475569;">${p.capacity || '-'}</span></td>`;
				html += `<td style="font-weight:800; color:#b7000c;">${formatVND(p.price_current)}</td>`;
				html += `<td style="color:#64748b; ${isSale ? 'text-decoration:line-through;' : ''}">${formatVND(p.price_old)}</td>`;
				html += `<td style="font-size:12px; color:#475569;">${p.specs || '<span style="color:#94a3b8;">-</span>'}</td>`;
				html += `<td style="text-align:center;" id="action-cell-${idx}">${actionBtnHtml}</td>`;
				html += `</tr>`;
			});

			if (visibleCount === 0) {
				html = '<tr><td colspan="9" style="text-align:center; padding:30px; color:#94a3b8;">Không có sản phẩm nào thuộc bộ lọc này.</td></tr>';
			}

			tbody.innerHTML = html;

			// Attach click events for individual buttons
			document.querySelectorAll('.btn-import-one').forEach(btn => {
				btn.addEventListener('click', function() {
					const index = parseInt(this.getAttribute('data-index'));
					importSingleProduct(index);
				});
			});
		}

		// Import a single product via AJAX
		function importSingleProduct(index, callback) {
			const p = scannedProducts[index];
			if (!p) return;

			const cell = document.getElementById('action-cell-' + index);
			if (cell) {
				cell.innerHTML = '<span class="dashicons dashicons-update spin" style="color:#0284c7;"></span> <span style="font-size:11px; color:#0284c7;">Đang nhập...</span>';
			}

			const formData = new FormData();
			formData.append('action', 'phonex_crawler_ajax_import_item');
			formData.append('security', securityNonce);
			formData.append('name', p.name);
			formData.append('source_url', p.source_url);
			formData.append('price_current', p.price_current);
			formData.append('price_old', p.price_old);
			formData.append('brand', p.brand);
			formData.append('model', p.model);
			formData.append('capacity', p.capacity);
			formData.append('specs', p.specs);
			formData.append('image', p.image);
			formData.append('updated_at', p.updated_at);
			formData.append('download_img', chkDownloadImg.checked ? '1' : '0');

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					p.existing_id = data.data.id;
					p.existing_last_crawled = p.updated_at;
					if (cell) {
						cell.innerHTML = '<span style="color:#16a34a; font-weight:700; font-size:11px;">&#x2714; Đã lưu (#ID: ' + data.data.id + ')</span>';
					}
				} else {
					if (cell) {
						cell.innerHTML = '<span style="color:#dc2626; font-size:11px;">&#x2718; Lỗi: ' + (data.data.message || 'Thất bại') + '</span>';
					}
				}
				if (typeof callback === 'function') {
					callback(data);
				}
			})
			.catch(err => {
				if (cell) {
					cell.innerHTML = '<span style="color:#dc2626; font-size:11px;">&#x2718; Lỗi mạng: ' + err.message + '</span>';
				}
				if (typeof callback === 'function') {
					callback({ success: false, message: err.message });
				}
			});
		}

		// 2. Nhập tất cả sản phẩm lần lượt (Batch processing with progress bar)
		btnImportAll.addEventListener('click', function() {
			if (!scannedProducts || scannedProducts.length === 0) {
				alert('Chưa có sản phẩm nào được quét.');
				return;
			}

			const skipExisting = chkSkipExisting.checked;
			let itemsToProcess = [];

			scannedProducts.forEach((p, idx) => {
				if (skipExisting && p.existing_id > 0) {
					return; // Skip already crawled products
				}
				itemsToProcess.push(idx);
			});

			if (itemsToProcess.length === 0) {
				alert('Tất cả sản phẩm quét được đều đã có trên web! Bạn có thể bỏ tích "Chỉ nhập máy mới" nếu muốn cập nhật lại giá cho các máy này.');
				return;
			}

			if (!confirm('Bạn có chắc chắn muốn xử lý ' + itemsToProcess.length + ' sản phẩm vào WooCommerce?')) {
				return;
			}

			btnScan.disabled = true;
			btnImportAll.disabled = true;
			progressContainer.style.display = 'block';

			let step = 0;
			const total = itemsToProcess.length;
			let successCount = 0;

			function processNext() {
				if (step >= total) {
					progressStatus.innerHTML = '<span style="color:#16a34a;">&#x2714; Hoàn tất! Đã xử lý ' + total + ' sản phẩm (' + successCount + ' thành công).</span>';
					progressBarFill.style.width = '100%';
					progressPercent.textContent = '100%';
					progressLog.textContent = 'Đã hoàn thành toàn bộ quá trình nhập.';
					btnScan.disabled = false;
					btnImportAll.disabled = false;
					return;
				}

				const prodIndex = itemsToProcess[step];
				const currentItem = scannedProducts[prodIndex];
				const percent = Math.round(((step) / total) * 100);
				progressBarFill.style.width = percent + '%';
				progressPercent.textContent = percent + '%';
				progressStatus.textContent = 'Đang nhập [' + (step + 1) + '/' + total + ']: ' + currentItem.name;
				progressLog.textContent = 'Xử lý: ' + currentItem.name + ' (' + currentItem.brand + ')...';

				importSingleProduct(prodIndex, function(res) {
					if (res && res.success) {
						successCount++;
					}
					step++;
					setTimeout(processNext, 200);
				});
			}

			processNext();
		});

	})();
	</script>
	<style>
		.spin {
			animation: spin 1s infinite linear;
			display: inline-block;
		}
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(359deg); }
		}
	</style>
	<?php
}

/**
 * ==============================================================================
 * WOOCOMMERCE ADMIN PRODUCTS LIST: INLINE TGDD BADGE & SOURCE FILTER
 * ==============================================================================
 */

/**
 * Display clean badge next to product title in WooCommerce list (No column clutter!)
 */
function phonex_crawler_display_product_states( $post_states, $post ) {
	if ( 'product' === $post->post_type ) {
		$crawl_source = get_post_meta( $post->ID, '_crawl_source', true );
		$admin_note   = get_post_meta( $post->ID, '_admin_crawl_note', true );
		$source_url   = get_post_meta( $post->ID, '_source_url', true );
		$capacity     = get_post_meta( $post->ID, '_storage_capacity', true ) ?: get_post_meta( $post->ID, '_capacity', true );

		$source_val = $admin_note ?: $crawl_source;

		if ( ! empty( $source_val ) ) {
			if ( stripos( $source_val, 'chợ tốt' ) !== false || stripos( $source_val, 'chotot' ) !== false ) {
				$badge_bg = '#fff7ed';
				$badge_color = '#c2410c';
				$badge_border = '#fed7aa';
				$label = 'Crawl Chợ Tốt';
			} elseif ( stripos( $source_val, 'fastmobile' ) !== false || stripos( $source_val, 'factmobile' ) !== false ) {
				$badge_bg = '#f0fdf4';
				$badge_color = '#15803d';
				$badge_border = '#bbf7d0';
				$label = 'Crawl Fastmobile';
			} elseif ( stripos( $source_val, 'tgdd' ) !== false || stripos( $source_url, 'thegioididong' ) !== false ) {
				$badge_bg = '#eff6ff';
				$badge_color = '#1d4ed8';
				$badge_border = '#bfdbfe';
				$label = 'Crawl TGDD';
			} else {
				$badge_bg = '#f8fafc';
				$badge_color = '#334155';
				$badge_border = '#cbd5e1';
				$label = 'Crawl ' . $source_val;
			}

			$post_states['phonex_crawl_badge'] = sprintf(
				'<span style="display:inline-flex; align-items:center; gap:3px; background:%s; color:%s; border:1px solid %s; padding:1px 6px; border-radius:4px; font-size:10.5px; font-weight:700; margin-left:6px;" title="Nguồn dữ liệu nội bộ (chỉ lưu quản trị)">📋 %s%s</span>',
				esc_attr( $badge_bg ),
				esc_attr( $badge_color ),
				esc_attr( $badge_border ),
				esc_html( $label ),
				$capacity ? ' • ' . esc_html( $capacity ) : ''
			);
		} elseif ( ! empty( $source_url ) ) {
			$post_states['phonex_tgdd_badge'] = '<span style="display:inline-flex; align-items:center; gap:3px; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; padding:1px 6px; border-radius:4px; font-size:10px; font-weight:700; margin-left:6px;" title="Nguồn crawl nội bộ">📋 Crawl TGDD</span>';
		}
	}
	return $post_states;
}
add_filter( 'display_post_states', 'phonex_crawler_display_product_states', 10, 2 );

/**
 * Add filter dropdown in WooCommerce admin: "Lọc theo nguồn"
 */
function phonex_crawler_filter_source_dropdown() {
	global $typenow;
	if ( 'product' !== $typenow ) {
		return;
	}
	$selected = isset( $_GET['filter_crawl_source'] ) ? sanitize_text_field( $_GET['filter_crawl_source'] ) : '';
	?>
	<select name="filter_crawl_source">
		<option value=""><?php esc_html_e( 'Tất cả nguồn dữ liệu', 'phonex' ); ?></option>
		<option value="chotot" <?php selected( $selected, 'chotot' ); ?>><?php esc_html_e( '🔥 Crawl: Chợ Tốt', 'phonex' ); ?></option>
		<option value="fastmobile" <?php selected( $selected, 'fastmobile' ); ?>><?php esc_html_e( '⚡ Crawl: Fastmobile', 'phonex' ); ?></option>
		<option value="tgdd" <?php selected( $selected, 'tgdd' ); ?>><?php esc_html_e( '📱 Crawl: TGDD', 'phonex' ); ?></option>
		<option value="manual" <?php selected( $selected, 'manual' ); ?>><?php esc_html_e( '📝 Sản phẩm nhập thủ công', 'phonex' ); ?></option>
	</select>
	<?php
}
add_action( 'restrict_manage_posts', 'phonex_crawler_filter_source_dropdown' );

/**
 * Add filter dropdown in WooCommerce admin: "Lọc theo thương hiệu (Brand)"
 */
function phonex_admin_filter_brand_dropdown() {
	global $typenow;
	if ( 'product' !== $typenow ) {
		return;
	}
	$selected = isset( $_GET['product_brand'] ) ? sanitize_text_field( $_GET['product_brand'] ) : '';
	$brands = get_terms( array(
		'taxonomy'   => 'product_brand',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) {
		?>
		<select name="product_brand" id="filter-by-brand">
			<option value=""><?php esc_html_e( 'Tất cả thương hiệu (Brands)', 'phonex' ); ?></option>
			<?php foreach ( $brands as $brand ) : ?>
				<option value="<?php echo esc_attr( $brand->slug ); ?>" <?php selected( $selected, $brand->slug ); ?>>
					<?php echo esc_html( $brand->name ); ?> (<?php echo esc_html( $brand->count ); ?>)
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}
add_action( 'restrict_manage_posts', 'phonex_admin_filter_brand_dropdown' );

/**
 * Filter query by crawl source
 */
function phonex_crawler_filter_source_query( $query ) {
	global $pagenow, $typenow;
	if ( is_admin() && $query->is_main_query() && 'edit.php' === $pagenow && 'product' === $typenow && ! empty( $_GET['filter_crawl_source'] ) ) {
		$source = sanitize_text_field( $_GET['filter_crawl_source'] );
		if ( 'chotot' === $source ) {
			$query->set(
				'meta_query',
				array(
					array(
						'key'     => '_crawl_source',
						'value'   => 'Chợ Tốt',
						'compare' => 'LIKE',
					),
				)
			);
		} elseif ( 'fastmobile' === $source ) {
			$query->set(
				'meta_query',
				array(
					array(
						'key'     => '_crawl_source',
						'value'   => 'Fastmobile',
						'compare' => 'LIKE',
					),
				)
			);
		} elseif ( 'tgdd' === $source ) {
			$query->set(
				'meta_query',
				array(
					array(
						'key'     => '_source_url',
						'value'   => 'thegioididong',
						'compare' => 'LIKE',
					),
				)
			);
		} elseif ( 'manual' === $source ) {
			$query->set(
				'meta_query',
				array(
					'relation' => 'AND',
					array(
						'key'     => '_crawl_source',
						'compare' => 'NOT EXISTS',
					),
					array(
						'relation' => 'OR',
						array(
							'key'     => '_source_url',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => '_source_url',
							'value'   => '',
							'compare' => '=',
						),
					),
				)
			);
		}
	}
}
add_action( 'pre_get_posts', 'phonex_crawler_filter_source_query' );

/**
 * Add Metabox on Product Edit Screen
 */
function phonex_crawler_add_product_metabox() {
	add_meta_box(
		'phonex_crawl_info_meta_box',
		__( '📋 Nguồn Dữ Liệu Crawl (Chỉ Quản Trị)', 'phonex' ),
		'phonex_crawler_render_product_metabox',
		'product',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'phonex_crawler_add_product_metabox' );

/**
 * Render Metabox Content (Admin Only)
 */
function phonex_crawler_render_product_metabox( $post ) {
	$crawl_source = get_post_meta( $post->ID, '_crawl_source', true );
	$admin_note   = get_post_meta( $post->ID, '_admin_crawl_note', true );
	$source_url   = get_post_meta( $post->ID, '_source_url', true );
	$condition    = get_post_meta( $post->ID, '_condition', true ) ?: get_post_meta( $post->ID, '_grade_label', true );
	$brand        = get_post_meta( $post->ID, '_phonex_brand', true ) ?: get_post_meta( $post->ID, '_brand', true );

	if ( empty( $crawl_source ) && empty( $admin_note ) && empty( $source_url ) ) {
		echo '<p style="color:#64748b; font-size:12px; margin:0;">Sản phẩm này được tạo thủ công trong kho PhoneX, không có nguồn crawl từ cơ sở dữ liệu ngoài.</p>';
		return;
	}

	$source_val = $admin_note ?: ( $crawl_source ?: 'Crawl dữ liệu' );
	?>
	<div style="font-size: 12px; line-height: 1.5; color: #334155;">
		<div style="margin-bottom: 8px;">
			<span style="display:inline-block; background: #fff7ed; color: #c2410c; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px; border: 1px solid #fed7aa;">NGUỒN CRAWL NỘI BỘ (CHỈ QUẢN TRỊ)</span>
		</div>
		<div style="background: #f8fafc; border-left: 3px solid #ea580c; padding: 6px 10px; margin-bottom: 10px; border-radius: 0 4px 4px 0;">
			<strong style="color: #c2410c;">Ghi chú quản trị:</strong>
			<p style="margin: 2px 0 0; color: #0f172a; font-weight: 700; font-size: 13px;"><?php echo esc_html( $source_val ); ?></p>
			<p style="margin: 4px 0 0; color: #64748b; font-size: 11px; line-height: 1.4;">Thông tin nguồn crawl này chỉ hiển thị trong trang quản trị để quản trị viên đối chiếu. Website không hiển thị bất kỳ nguồn crawl hay thông tin người bán nào.</p>
		</div>
		<?php if ( ! empty( $condition ) ) : ?>
			<p style="margin: 0 0 6px;"><strong>Phân hạng PhoneX:</strong> <span style="color:#e60012; font-weight:700;"><?php echo esc_html( $condition ); ?></span></p>
		<?php endif; ?>
		<?php if ( ! empty( $brand ) ) : ?>
			<p style="margin: 0 0 6px;"><strong>Thương hiệu:</strong> <?php echo esc_html( $brand ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Add Admin Column for Crawled Products in WooCommerce Products List
 */
function phonex_crawler_product_columns( $columns ) {
	$columns['crawled_db'] = __( 'Nguồn Dữ Liệu', 'phonex' );
	return $columns;
}
add_filter( 'manage_edit-product_columns', 'phonex_crawler_product_columns', 20 );

function phonex_crawler_product_column_content( $column, $post_id ) {
	if ( 'crawled_db' === $column ) {
		$crawl_source = get_post_meta( $post_id, '_crawl_source', true );
		$admin_note   = get_post_meta( $post_id, '_admin_crawl_note', true );
		$source_url   = get_post_meta( $post_id, '_source_url', true );

		$source_val = $admin_note ?: $crawl_source;

		if ( ! empty( $source_val ) ) {
			if ( stripos( $source_val, 'chợ tốt' ) !== false || stripos( $source_val, 'chotot' ) !== false ) {
				echo '<span style="display:inline-block; background:#fff7ed; color:#c2410c; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; border:1px solid #fed7aa;" title="Chỉ lưu quản trị">Crawl Chợ Tốt</span>';
			} elseif ( stripos( $source_val, 'fastmobile' ) !== false || stripos( $source_val, 'factmobile' ) !== false ) {
				echo '<span style="display:inline-block; background:#f0fdf4; color:#15803d; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; border:1px solid #bbf7d0;" title="Chỉ lưu quản trị">Crawl Fastmobile</span>';
			} elseif ( stripos( $source_val, 'tgdd' ) !== false || stripos( $source_url, 'thegioididong' ) !== false ) {
				echo '<span style="display:inline-block; background:#eff6ff; color:#1d4ed8; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; border:1px solid #bfdbfe;" title="Chỉ lưu quản trị">Crawl TGDD</span>';
			} else {
				echo '<span style="display:inline-block; background:#f1f5f9; color:#334155; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; border:1px solid #cbd5e1;">Crawl: ' . esc_html( $source_val ) . '</span>';
			}
		} elseif ( ! empty( $source_url ) ) {
			echo '<span style="display:inline-block; background:#eff6ff; color:#1d4ed8; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; border:1px solid #bfdbfe;">Crawl TGDD</span>';
		} else {
			echo '<span style="color:#94a3b8; font-size:11px;">Thủ công</span>';
		}
	}
}
add_action( 'manage_product_posts_custom_column', 'phonex_crawler_product_column_content', 10, 2 );

