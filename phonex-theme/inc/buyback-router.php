<?php
/**
 * PhoneX Buyback URL Router & Template Dispatcher
 *
 * Implements clean, SEO-friendly hierarchical routes:
 * - /thu-mua-dien-thoai/                     -> Hub / Central Landing Page
 * - /thu-mua-dien-thoai/{brand}/            -> Brand Buyback Page
 * - /thu-mua-dien-thoai/{brand}/{model}/    -> Model Buyback & Valuation Page
 * - /dinh-gia-dien-thoai/                   -> Interactive Online Valuation Wizard
 * - /bang-gia-thu-mua/                      -> Dynamic Price List
 * - /tra-cuu-yeu-cau/                       -> Request Status Lookup by Phone Number
 * - /quy-trinh-thu-mua/                     -> 7-Step Inspection & Buyback Process
 * - /tieu-chuan-kiem-dinh/                  -> Grade A/B/C/D Inspection Standards
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns current clean request path relative to home_url()
 */
function phonex_buyback_get_relative_path() {
	$request_uri = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
	$home_path   = untrailingslashit( wp_parse_url( home_url(), PHP_URL_PATH ) );

	if ( ! empty( $home_path ) && strpos( $request_uri, $home_path ) === 0 ) {
		$request_uri = substr( $request_uri, strlen( $home_path ) );
	}
	return '/' . ltrim( $request_uri, '/' );
}

/**
 * Finds a phone item from used-phones.json by matching its model slug or clean name
 *
 * @param string $m_slug Model slug to search.
 * @param string $b_slug Optional brand slug.
 * @return array|null Matched item data or null.
 */
function phonex_buyback_find_catalog_phone_by_slug( $m_slug, $b_slug = '' ) {
	static $catalog = null;
	if ( null === $catalog ) {
		$json_path = get_template_directory() . '/data/used-phones.json';
		if ( file_exists( $json_path ) ) {
			$catalog = json_decode( file_get_contents( $json_path ), true ) ?: array();
		} else {
			$catalog = array();
		}
	}

	$m_slug_clean = strtolower( trim( $m_slug ) );

	foreach ( $catalog as $idx => $item ) {
		$raw_name   = $item['name'] ?? '';
		$clean_name = trim( preg_replace( '/^\[[^\]]+\]\s*/', '', $raw_name ) );
		$item_brand = strtolower( sanitize_title( $item['brand'] ?? '' ) );
		if ( 'iphone' === $item_brand ) {
			$item_brand = 'apple';
		}

		if ( ! empty( $b_slug ) && $item_brand !== $b_slug ) {
			continue;
		}

		$short_name      = preg_split( '/[-–—]\s*(?:Like|Máy|Cũ|Lưng|Chính|Fullbox|New|Pin|Hộp|Zin|Bản|Quốc|Chạy)/iu', $clean_name )[0];
		$slug_from_short = sanitize_title( $short_name );
		$slug_from_clean = sanitize_title( $clean_name );
		$item_slug       = $item['slug'] ?? '';

		if ( $slug_from_short === $m_slug_clean || 
		     $slug_from_clean === $m_slug_clean || 
		     $item_slug === $m_slug_clean ||
		     ( ! empty( $slug_from_short ) && strpos( $m_slug_clean, $slug_from_short ) === 0 ) ||
		     ( ! empty( $slug_from_clean ) && strpos( $m_slug_clean, $slug_from_clean ) === 0 ) ||
		     ( ! empty( $slug_from_short ) && strpos( $slug_from_short, $m_slug_clean ) === 0 ) ||
		     ( ! empty( $slug_from_clean ) && strpos( $slug_from_clean, $m_slug_clean ) === 0 ) ||
		     ( ! empty( $item_slug ) && strpos( $item_slug, $m_slug_clean ) !== false ) ) {
			return array(
				'item'       => $item,
				'clean_name' => $clean_name,
				'idx'        => $idx,
			);
		}
	}

	return null;
}

/**
 * Generates an SEO-optimized Buyback Model URL for any product or catalog item
 *
 * @param array $item Product catalog item.
 * @return string Clean buyback URL.
 */
function phonex_get_buyback_url_for_product( $item ) {
	if ( is_object( $item ) ) {
		$item = (array) $item;
	}

	// Fast path: if this item already has canonical slugs from wp_phonex_buyback_models
	if ( ! empty( $item['slug'] ) && ! empty( $item['brand_slug'] ) ) {
		return home_url( '/thu-mua-dien-thoai/' . $item['brand_slug'] . '/' . $item['slug'] . '/' );
	}

	$brand = trim( $item['brand_name'] ?? $item['brand'] ?? 'Khác' );
	$brand_slug = ! empty( $item['brand_slug'] ) ? $item['brand_slug'] : strtolower( sanitize_title( $brand ) );
	if ( 'iphone' === $brand_slug ) {
		$brand_slug = 'apple';
	} elseif ( empty( $brand_slug ) ) {
		$brand_slug = 'khac';
	}

	$raw_name   = $item['name'] ?? '';
	$clean_name = trim( preg_replace( '/^\[[^\]]+\]\s*/', '', $raw_name ) );
	$short_name = preg_split( '/[-–—]\s*(?:Like|Máy|Cũ|Lưng|Chính|Fullbox|New|Pin|Hộp|Zin|Bản|Quốc|Chạy)/iu', $clean_name )[0];
	$short_name = trim( $short_name );
	if ( empty( $short_name ) ) {
		$short_name = $clean_name;
	}

	// 1. Check if matches an active canonical model in wp_phonex_buyback_models
	static $canonical_cache = null;
	global $wpdb;
	if ( null === $canonical_cache ) {
		$canonical_cache = array();
		$t_models = $wpdb->prefix . 'phonex_buyback_models';
		$rows = $wpdb->get_results( "SELECT slug, name, brand_id FROM $t_models WHERE is_active = 1" );
		if ( $rows ) {
			foreach ( $rows as $r ) {
				$canonical_cache[ strtolower( $r->name ) ] = $r->slug;
			}
		}
	}

	$short_l = strtolower( $short_name );
	foreach ( $canonical_cache as $c_name => $c_slug ) {
		if ( strpos( $short_l, $c_name ) !== false ) {
			return home_url( '/thu-mua-dien-thoai/' . $brand_slug . '/' . $c_slug . '/' );
		}
	}

	// 2. Fallback: clean slug from short name
	$model_slug = sanitize_title( $short_name );
	if ( empty( $model_slug ) ) {
		$model_slug = $item['slug'] ?? ( 'px-' . ( $item['id'] ?? 'item' ) );
	}

	return home_url( '/thu-mua-dien-thoai/' . $brand_slug . '/' . $model_slug . '/' );
}

/**
 * Intercept template routing for buyback URLs
 */
function phonex_buyback_route_template( $template ) {
	$path = phonex_buyback_get_relative_path();
	global $phonex_buyback_current_brand, $phonex_buyback_current_model, $wpdb;

	// 1. HUB / LANDING PAGE: /thu-mua-dien-thoai/
	if ( preg_match( '#^/thu-mua-dien-thoai/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-hub.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 2. MODEL PAGE: /thu-mua-dien-thoai/{brand}/{model}/
	if ( preg_match( '#^/thu-mua-dien-thoai/([^/]+)/([^/]+)/?$#i', $path, $matches ) ) {
		$b_slug = sanitize_title( $matches[1] );
		$m_slug = sanitize_title( $matches[2] );

		// Normalize iphone -> apple alias
		if ( 'iphone' === $b_slug ) {
			$b_slug = 'apple';
		}

		$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
		$t_models = $wpdb->prefix . 'phonex_buyback_models';

		$brand = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_brands WHERE slug = %s AND is_active = 1", $b_slug ) );
		if ( ! $brand ) {
			// Virtual fallback brand
			$brand = (object) array(
				'id'       => 999,
				'name'     => ucfirst( $b_slug ),
				'slug'     => $b_slug,
				'logo_url' => function_exists( 'phonex_get_brand_logo_url' ) ? phonex_get_brand_logo_url( $b_slug ) : '',
			);
		}

		$model = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_models WHERE brand_id = %d AND slug = %s AND is_active = 1", $brand->id, $m_slug ) );
		if ( ! $model ) {
			// Fallback 1: search model by slug only in DB
			$model = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_models WHERE slug = %s AND is_active = 1", $m_slug ) );
		}

		if ( ! $model ) {
			// Fallback 2: search in used-phones.json catalog (guarantees 100% resolution for all products)
			$matched = phonex_buyback_find_catalog_phone_by_slug( $m_slug, $b_slug );
			if ( $matched ) {
				$item       = $matched['item'];
				$clean_name = $matched['clean_name'];
				$idx        = $matched['idx'];

				$rom = $item['summary_specs']['rom'] ?? '';
				if ( empty( $rom ) && preg_match( '/(\d+\s*(?:GB|TB))/i', $clean_name, $m_rom ) ) {
					$rom = strtoupper( $m_rom[1] );
				}
				$storages = ! empty( $rom ) ? array( $rom ) : array( '128GB', '256GB', '512GB' );

				$img_path = $item['image'] ?? '';
				if ( ! empty( $img_path ) && strpos( $img_path, 'http' ) !== 0 ) {
					$img_url = get_template_directory_uri() . '/' . ltrim( $img_path, '/' );
				} elseif ( ! empty( $img_path ) ) {
					$img_url = $img_path;
				} else {
					$img_url = get_template_directory_uri() . '/assets/images/phones/generic-phone.png';
				}

				$model = (object) array(
					'id'                 => 10000 + $idx,
					'brand_id'           => $brand->id,
					'series_id'          => 0,
					'name'               => $clean_name,
					'slug'               => $m_slug,
					'base_buyback_price' => (float) ( $item['price'] ?? 5000000 ),
					'storage_options'    => json_encode( $storages ),
					'color_options'      => json_encode( array( 'Tiêu chuẩn', 'Xanh', 'Đen', 'Trắng' ) ),
					'image_url'          => $img_url,
					'spec_groups'        => $item['spec_groups'] ?? array(),
					'summary_specs'      => $item['summary_specs'] ?? array(),
					'is_active'          => 1,
				);
			}
		} else {
			// Model was found in DB -> enrich with spec_groups & summary_specs if not set
			if ( empty( $model->spec_groups ) ) {
				$matched = phonex_buyback_find_catalog_phone_by_slug( $m_slug, $b_slug );
				if ( $matched ) {
					$model->spec_groups   = $matched['item']['spec_groups'] ?? array();
					$model->summary_specs = $matched['item']['summary_specs'] ?? array();
				}
			}
		}

		if ( $model && $brand ) {
			$phonex_buyback_current_brand = $brand;
			$phonex_buyback_current_model = $model;
			$tpl = get_template_directory() . '/page-templates/template-buyback-model.php';
			if ( file_exists( $tpl ) ) {
				return $tpl;
			}
		}
	}

	// 3. BRAND PAGE: /thu-mua-dien-thoai/{brand}/
	if ( preg_match( '#^/thu-mua-dien-thoai/([^/]+)/?$#i', $path, $matches ) ) {
		$b_slug = sanitize_title( $matches[1] );
		if ( 'iphone' === $b_slug ) {
			$b_slug = 'apple';
		}

		$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
		$brand    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_brands WHERE slug = %s AND is_active = 1", $b_slug ) );

		if ( $brand ) {
			$phonex_buyback_current_brand = $brand;
			$tpl = get_template_directory() . '/page-templates/template-buyback-brand.php';
			if ( file_exists( $tpl ) ) {
				return $tpl;
			}
		}
	}

	// 4. VALUATION WIZARD: /dinh-gia-dien-thoai/
	if ( preg_match( '#^/(dinh-gia-dien-thoai|dinh-gia)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-valuation.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 5. PRICING TABLE / GIÁ THU MUA DỰ KIẾN: /bang-gia-thu-mua/ & /gia-thu-mua-du-kien/
	if ( preg_match( '#^/(bang-gia-thu-mua|bang-gia|gia-thu-mua-du-kien|gia-thu-du-kien|bang-gia-du-kien)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-pricing.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 6. REQUEST LOOKUP: /tra-cuu-yeu-cau/
	if ( preg_match( '#^/(tra-cuu-yeu-cau|tra-cuu-thu-mua|tra-cuu)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-lookup.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 7. BUYBACK PROCESS: /quy-trinh-thu-mua/
	if ( preg_match( '#^/(quy-trinh-thu-mua|quy-trinh)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-process.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 8. INSPECTION STANDARDS: /tieu-chuan-kiem-dinh/
	if ( preg_match( '#^/(tieu-chuan-kiem-dinh|kiem-dinh)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-buyback-standards.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 9. KHO MÁY CŨ (PRE-OWNED INVENTORY): /kho-may-cu/
	if ( preg_match( '#^/(kho-may-cu|dien-thoai-cu|may-doi-tra|may-cu-gia-tot)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-used-phones.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	// 10. CHỢ TỐT MARKET SCANNER: /thi-truong-chotot/
	if ( preg_match( '#^/(thi-truong-chotot|khao-sat-chotot|chotot-market|chotot)/?$#i', $path ) ) {
		$tpl = get_template_directory() . '/page-templates/template-chotot-market.php';
		if ( file_exists( $tpl ) ) {
			return $tpl;
		}
	}

	return $template;
}
add_filter( 'template_include', 'phonex_buyback_route_template', 98 );

/**
 * Prevents 404 header on custom buyback routes
 */
function phonex_buyback_prevent_404() {
	$path = phonex_buyback_get_relative_path();
	if ( preg_match( '#^/(thu-mua-dien-thoai|dinh-gia-dien-thoai|bang-gia-thu-mua|gia-thu-mua-du-kien|gia-thu-du-kien|bang-gia-du-kien|tra-cuu-yeu-cau|quy-trinh-thu-mua|tieu-chuan-kiem-dinh|kho-may-cu|dien-thoai-cu|may-doi-tra|thi-truong-chotot|khao-sat-chotot|chotot)(/.*)?$#i', $path ) ) {
		global $wp_query;
		if ( $wp_query ) {
			$wp_query->is_404 = false;
		}
		status_header( 200 );
	}
}
add_action( 'template_redirect', 'phonex_buyback_prevent_404', 1 );
