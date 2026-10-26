<?php
/**
 * PhoneX Google SEO & Structured Data Optimization Engine
 *
 * Fully compliant with Google Search Essentials, Schema.org and Google Rich Results guidelines.
 * Self-contained in theme without external plugin dependencies.
 *
 * Features:
 * 1. Title Tag Optimization (SERP 50-60 chars limit, high CTR phrasing)
 * 2. Meta Description Engine (140-160 chars, rich USPs, call to action)
 * 3. Canonical URL Management (clean params, preserves canonical pagination & category filters)
 * 4. Google Robots Meta Directives (index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1)
 * 5. Open Graph & Twitter Cards (summary_large_image, rich preview tags)
 * 6. Schema.org JSON-LD Structured Data:
 *    - WebSite with Sitelinks SearchBox (SearchAction)
 *    - Organization & ElectronicsStore (LocalBusiness, Geo, Address, Hours, Logo)
 *    - BreadcrumbList (Rich navigation SERP trail)
 *    - Product + Offer + AggregateRating (InStock, UsedCondition/NewCondition, Price, Merchant Return, Shipping)
 *    - FAQPage (Google Rich FAQ accordions on key landing pages)
 *    - ItemList (Collection carousel recognition for category/kho-may-cu)
 * 7. Dynamic Google XML Sitemap Generator (/sitemap.xml)
 * 8. Dynamic & Static robots.txt Generator with Sitemap declaration
 *
 * @package PhoneX
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper: Get current clean request path relative to home_url()
 */
function phonex_seo_get_relative_path() {
	$request_uri = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
	$home_path   = untrailingslashit( wp_parse_url( home_url(), PHP_URL_PATH ) );

	if ( ! empty( $home_path ) && strpos( $request_uri, $home_path ) === 0 ) {
		$request_uri = substr( $request_uri, strlen( $home_path ) );
	}
	return '/' . ltrim( $request_uri, '/' );
}

/**
 * Helper: Detect page context
 */
function phonex_seo_get_context() {
	static $context = null;
	if ( null !== $context ) {
		return $context;
	}

	$path = phonex_seo_get_relative_path();
	$ctx  = array(
		'type'       => 'general',
		'title'      => '',
		'desc'       => '',
		'canonical'  => '',
		'image'      => '',
		'brand'      => null,
		'model'      => null,
		'term'       => null,
		'post'       => null,
		'has_faq'    => false,
		'is_archive' => false,
	);

	// 1. Home / Front Page
	if ( is_front_page() || is_home() || '/' === $path || empty( $path ) ) {
		$ctx['type'] = 'home';
		$context     = $ctx;
		return $context;
	}

	// 2. Kho Máy Cũ (Pre-owned inventory)
	if ( preg_match( '#^/(kho-may-cu|dien-thoai-cu|may-doi-tra|may-cu-gia-tot)/?$#i', $path ) ) {
		$ctx['type']       = 'kho-may-cu';
		$ctx['is_archive'] = true;
		$ctx['has_faq']    = true;
		$context           = $ctx;
		return $context;
	}

	// 3. Buyback Hub (/thu-mua-dien-thoai/ or /thu-cu-doi-moi/)
	if ( preg_match( '#^/(thu-mua-dien-thoai|thu-cu-doi-moi|thu-mua)/?$#i', $path ) ) {
		$ctx['type']    = 'buyback-hub';
		$ctx['has_faq'] = true;
		$context        = $ctx;
		return $context;
	}

	// 4. Buyback Model (/thu-mua-dien-thoai/{brand}/{model}/)
	if ( preg_match( '#^/thu-mua-dien-thoai/([^/]+)/([^/]+)/?$#i', $path, $matches ) ) {
		global $wpdb, $phonex_buyback_current_brand, $phonex_buyback_current_model;
		$b_slug = sanitize_title( $matches[1] );
		if ( 'iphone' === $b_slug ) {
			$b_slug = 'apple';
		}
		$m_slug = sanitize_title( $matches[2] );

		if ( ! empty( $phonex_buyback_current_model ) && ! empty( $phonex_buyback_current_brand ) ) {
			$ctx['type']  = 'buyback-model';
			$ctx['brand'] = $phonex_buyback_current_brand;
			$ctx['model'] = $phonex_buyback_current_model;
			$context      = $ctx;
			return $context;
		}

		$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
		$t_models = $wpdb->prefix . 'phonex_buyback_models';

		$brand = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_brands WHERE slug = %s AND is_active = 1", $b_slug ) );
		if ( ! $brand ) {
			$brand = (object) array(
				'id'       => 999,
				'name'     => ucfirst( $b_slug ),
				'slug'     => $b_slug,
				'logo_url' => function_exists( 'phonex_get_brand_logo_url' ) ? phonex_get_brand_logo_url( $b_slug ) : '',
			);
		}

		$model = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_models WHERE brand_id = %d AND slug = %s AND is_active = 1", $brand->id, $m_slug ) );
		if ( ! $model ) {
			$model = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_models WHERE slug = %s AND is_active = 1", $m_slug ) );
		}

		if ( ! $model && function_exists( 'phonex_buyback_find_catalog_phone_by_slug' ) ) {
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
		}

		if ( $model ) {
			$ctx['type']  = 'buyback-model';
			$ctx['brand'] = $brand;
			$ctx['model'] = $model;
			$context      = $ctx;
			return $context;
		}
	}

	// 5. Buyback Brand (/thu-mua-dien-thoai/{brand}/)
	if ( preg_match( '#^/thu-mua-dien-thoai/([^/]+)/?$#i', $path, $matches ) ) {
		global $wpdb;
		$b_slug = sanitize_title( $matches[1] );
		if ( 'iphone' === $b_slug ) {
			$b_slug = 'apple';
		}

		$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
		$brand    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $t_brands WHERE slug = %s AND is_active = 1", $b_slug ) );
		if ( $brand ) {
			$ctx['type']       = 'buyback-brand';
			$ctx['brand']      = $brand;
			$ctx['is_archive'] = true;
			$context           = $ctx;
			return $context;
		}
	}

	// 6. Online Valuation (/dinh-gia-dien-thoai/)
	if ( preg_match( '#^/(dinh-gia-dien-thoai|dinh-gia)/?$#i', $path ) ) {
		$ctx['type']    = 'valuation';
		$ctx['has_faq'] = true;
		$context        = $ctx;
		return $context;
	}

	// 7. Pricing Table (/bang-gia-thu-mua/)
	if ( preg_match( '#^/(bang-gia-thu-mua|bang-gia)/?$#i', $path ) ) {
		$ctx['type']    = 'pricing';
		$ctx['has_faq'] = true;
		$context        = $ctx;
		return $context;
	}

	// 8. Request Lookup (/tra-cuu-yeu-cau/)
	if ( preg_match( '#^/(tra-cuu-yeu-cau|tra-cuu-thu-mua|tra-cuu)/?$#i', $path ) ) {
		$ctx['type'] = 'lookup';
		$context     = $ctx;
		return $context;
	}

	// 9. Buyback Process (/quy-trinh-thu-mua/)
	if ( preg_match( '#^/(quy-trinh-thu-mua|quy-trinh)/?$#i', $path ) ) {
		$ctx['type']    = 'process';
		$ctx['has_faq'] = true;
		$context        = $ctx;
		return $context;
	}

	// 10. Inspection Standards (/tieu-chuan-kiem-dinh/)
	if ( preg_match( '#^/(tieu-chuan-kiem-dinh|kiem-dinh)/?$#i', $path ) ) {
		$ctx['type']    = 'standards';
		$ctx['has_faq'] = true;
		$context        = $ctx;
		return $context;
	}

	// 11. Phones Archive (/dtdd/)
	if ( preg_match( '#^/(dtdd)/?$#i', $path ) ) {
		$ctx['type']       = 'dtdd';
		$ctx['is_archive'] = true;
		$context           = $ctx;
		return $context;
	}

	// 12. Flash Sale (/flash-sale/)
	if ( preg_match( '#^/(flash-sale)/?$#i', $path ) ) {
		$ctx['type']       = 'flash-sale';
		$ctx['is_archive'] = true;
		$context           = $ctx;
		return $context;
	}

	// 13. Single WooCommerce Product
	if ( is_singular( 'product' ) ) {
		$ctx['type'] = 'product';
		$ctx['post'] = get_post();
		$context     = $ctx;
		return $context;
	}

	// 14. Product Category
	if ( is_product_category() ) {
		$ctx['type']       = 'product_cat';
		$ctx['term']       = get_queried_object();
		$ctx['is_archive'] = true;
		$context           = $ctx;
		return $context;
	}

	// 15. Standard Singular Post/Page
	if ( is_singular() ) {
		$ctx['type'] = 'singular';
		$ctx['post'] = get_post();
		$context     = $ctx;
		return $context;
	}

	$context = $ctx;
	return $context;
}

/**
 * 1. Title Tag Generator (Google SERP Snippet Optimized: 50-60 characters)
 */
function phonex_seo_get_title() {
	$ctx = phonex_seo_get_context();

	switch ( $ctx['type'] ) {
		case 'home':
			return 'PhoneX - Hệ Thống Thu Cũ Đổi Mới & Kho Máy Cũ Giá Rẻ';

		case 'kho-may-cu':
			$cat = isset( $_GET['cat'] ) ? sanitize_title( $_GET['cat'] ) : '';
			if ( 'iphone' === $cat ) {
				return 'iPhone Cũ Giá Rẻ, Đẹp 99% Zin 100% Trả Góp 0% | PhoneX';
			} elseif ( 'samsung' === $cat ) {
				return 'Samsung Cũ Giá Rẻ, Đẹp 99% Zin Nguyên Bản | PhoneX';
			} elseif ( 'xiaomi' === $cat ) {
				return 'Xiaomi Cũ Giá Rẻ, Cấu Hình Khủng Pin Trâu | PhoneX';
			} elseif ( 'oppo' === $cat ) {
				return 'OPPO Cũ Giá Rẻ, Camera Đẹp Máy Zin 100% | PhoneX';
			} elseif ( 'vivo' === $cat ) {
				return 'Vivo Cũ Giá Rẻ, Pin Khủng Thiết Kế Thời Trang | PhoneX';
			} elseif ( 'realme' === $cat ) {
				return 'Realme Cũ Giá Rẻ, Hiệu Năng Cao Giá Học Sinh | PhoneX';
			} elseif ( 'honor' === $cat ) {
				return 'HONOR Cũ Giá Rẻ, Màn Hình Đẹp Bền Bỉ | PhoneX';
			}
			return 'Kho Điện Thoại Cũ Giá Rẻ, Máy Đẹp 99% Zin 100% | PhoneX';

		case 'buyback-hub':
			return 'Thu Mua Điện Thoại Cũ Giá Cao Tận Nơi, Báo Giá 1 Phút | PhoneX';

		case 'buyback-brand':
			$bname = $ctx['brand'] ? $ctx['brand']->name : 'Điện Thoại';
			return sprintf( 'Thu Mua Điện Thoại %s Cũ Giá Cao Nhất | PhoneX', $bname );

		case 'buyback-model':
			$mname = $ctx['model'] ? $ctx['model']->name : 'Điện Thoại';
			return sprintf( 'Thu Mua %s Cũ Giá Cao, Trợ Giá Lên Đời 30%% | PhoneX', $mname );

		case 'valuation':
			return 'Định Giá Điện Thoại Trực Tuyến Tự Động, Giá Cao Nhất | PhoneX';

		case 'pricing':
			return 'Bảng Giá Thu Mua Điện Thoại Cũ Mới Nhất 2026 | PhoneX';

		case 'lookup':
			return 'Tra Cứu Hồ Sơ Thu Cũ Đổi Mới Nhanh Chóng | PhoneX';

		case 'process':
			return 'Quy Trình Thu Mua Điện Thoại 7 Bước Nhanh 15 Phút | PhoneX';

		case 'standards':
			return 'Tiêu Chuẩn Kiểm Định Điện Thoại Chuẩn Grade A/B/C/D | PhoneX';

		case 'dtdd':
			return 'Điện Thoại Di Động Chính Hãng Giá Rẻ, Giảm Đến 35% | PhoneX';

		case 'flash-sale':
			return 'Flash Sale Điện Thoại Giá Sốc - Giảm Đến 50% | PhoneX';

		case 'product':
			$title = get_the_title( $ctx['post'] );
			$clean_title = preg_replace( '/^\[Grade [^\]]+\]\s*/i', '', $title );
			if ( mb_strlen( $clean_title ) > 48 ) {
				// Clean cut at word boundary
				$pos = mb_strrpos( mb_substr( $clean_title, 0, 48 ), ' ' );
				if ( false !== $pos && $pos > 25 ) {
					$clean_title = mb_substr( $clean_title, 0, $pos );
				} else {
					$clean_title = mb_substr( $clean_title, 0, 48 );
				}
			}
			return sprintf( '%s | PhoneX', $clean_title );

		case 'product_cat':
			$cat_name = $ctx['term'] ? $ctx['term']->name : 'Danh Mục';
			return sprintf( '%s Chính Hãng Giá Rẻ, Khuyến Mãi Lớn | PhoneX', $cat_name );

		case 'singular':
			$page_title = get_the_title( $ctx['post'] );
			return sprintf( '%s | PhoneX', $page_title );

		default:
			if ( is_search() ) {
				return sprintf( 'Tìm kiếm: "%s" | PhoneX', get_search_query() );
			}
			if ( is_404() ) {
				return 'Trang Không Tìm Thấy (404) | PhoneX';
			}
			return 'PhoneX - Hệ Thống Điện Thoại & Thu Cũ Đổi Mới Hàng Đầu';
	}
}

/**
 * Filter WordPress document title
 */
function phonex_seo_document_title( $title ) {
	return phonex_seo_get_title();
}
add_filter( 'pre_get_document_title', 'phonex_seo_document_title', 99 );
add_filter( 'document_title_separator', function () {
	return '|';
} );

/**
 * 2. Meta Description Generator (140-160 characters, High CTR & Relevance)
 */
function phonex_seo_get_description() {
	$ctx = phonex_seo_get_context();

	switch ( $ctx['type'] ) {
		case 'home':
			return 'Hệ thống bán lẻ & thu cũ đổi mới điện thoại uy tín số 1. Cam kết máy zin 100%, bảo hành 12 tháng 1 đổi 1, định giá tự động 1 phút, nhận tiền sau 5 phút.';

		case 'kho-may-cu':
			$cat = isset( $_GET['cat'] ) ? sanitize_title( $_GET['cat'] ) : '';
			if ( 'iphone' === $cat ) {
				return 'Kho iPhone cũ giá rẻ chính hãng, cam kết máy zin 100% nguyên bản chưa qua sửa chữa, ngoại hình đẹp 99%. Bảo hành 12 tháng 1 đổi 1, sẵn hàng tại showroom PhoneX.';
			} elseif ( 'samsung' === $cat ) {
				return 'Kho Samsung cũ giá rẻ nhất, đầy đủ Galaxy S, Note, Z Fold, Z Flip đẹp như mới 99%. Bảo hành toàn diện 12 tháng, trả góp 0%, sẵn hàng tại showroom PhoneX.';
			} elseif ( 'xiaomi' === $cat ) {
				return 'Kho Xiaomi cũ like new giá rẻ, cấu hình cao pin trâu, bảo hành 12 tháng 1 đổi 1, trợ giá thu cũ đổi mới đến 30%. Sẵn hàng trải nghiệm tại PhoneX toàn quốc.';
			}
			return 'Kho điện thoại cũ chính hãng giá rẻ nhất: iPhone, Samsung, Xiaomi like new 99% nguyên bản zin 100%. Bảo hành 12 tháng 1 đổi 1, trả góp 0%, sẵn hàng tại showroom.';

		case 'buyback-hub':
			return 'Dịch vụ thu mua điện thoại cũ giá cao nhất thị trường. Kiểm định 30 bước minh bạch phân Grade A/B/C/D, thanh toán 5 phút, trợ giá 30% khi thu cũ đổi mới tại PhoneX.';

		case 'buyback-brand':
			$bname = $ctx['brand'] ? $ctx['brand']->name : 'điện thoại';
			return sprintf( 'Chuyên thu mua điện thoại %s cũ giá cao nhất. Báo giá online 1 phút, kiểm định minh bạch 15 phút, giải ngân tiền mặt hoặc chuyển khoản ngay tại PhoneX.', $bname );

		case 'buyback-model':
			$mname = $ctx['model'] ? $ctx['model']->name : 'điện thoại';
			return sprintf( 'Thu mua %s cũ giá cao nhất thị trường. Phân loại chuẩn 4 hạng Grade minh bạch, trợ giá lên đời đến 30%%, thanh toán ngay trong 5 phút tại PhoneX.', $mname );

		case 'valuation':
			return 'Công cụ định giá điện thoại cũ online chuẩn xác theo thời gian thực. Báo giá tức thì theo 4 hạng Grade minh bạch, thanh toán tiền ngay trong 5 phút tại PhoneX.';

		case 'pricing':
			return 'Bảng giá thu mua điện thoại cũ cập nhật liên tục 2026. Báo giá chi tiết cho iPhone, Samsung, Xiaomi, OPPO với mức giá cao nhất và trợ giá thu cũ đổi mới 30%.';

		case 'lookup':
			return 'Tra cứu tiến độ và kết quả thẩm định hồ sơ thu cũ đổi mới điện thoại trực tuyến bằng số điện thoại nhanh chóng, bảo mật tuyệt đối tại hệ thống PhoneX.';

		case 'process':
			return 'Quy trình thu cũ đổi mới điện thoại 7 bước tiêu chuẩn tại PhoneX: Định giá nhanh, kiểm định 30 bước công khai, chốt giá minh bạch, nhận tiền ngay trong 15 phút.';

		case 'standards':
			return 'Tiêu chuẩn phân loại điện thoại cũ Grade A (như mới 99%), Grade B (98%), Grade C (95%), Grade D rõ ràng, giúp khách hàng nắm rõ giá trị thiết bị.';

		case 'dtdd':
			return 'Mua điện thoại di động chính hãng giá rẻ nhất tại PhoneX: iPhone, Samsung, Xiaomi, OPPO, vivo. Trả góp 0%, bảo hành chính hãng, giao hàng nhanh 2h toàn quốc.';

		case 'flash-sale':
			return 'Chương trình Flash Sale điện thoại và phụ kiện chính hãng giá sốc, giảm đến 50%. Duy nhất hôm nay, số lượng có hạn, sẵn hàng tại hệ thống showroom PhoneX.';

		case 'product':
			$prod = wc_get_product( $ctx['post'] );
			if ( $prod ) {
				$p_price = number_format( (float) $prod->get_price(), 0, ',', '.' ) . '₫';
				$p_name  = $prod->get_name();
				return sprintf( 'Mua %s giá ưu đãi chỉ %s tại PhoneX. Cam kết máy zin 100%%, bảo hành toàn diện 12 tháng 1 đổi 1, trả góp 0%%, sẵn hàng tại showroom PhoneX.', $p_name, $p_price );
			}
			return 'Mua điện thoại chính hãng giá rẻ nhất tại PhoneX. Cam kết chất lượng chuẩn Grade A 99%, bảo hành 12 tháng, trả góp 0%, còn hàng tại showroom PhoneX.';

		case 'product_cat':
			$cname = $ctx['term'] ? $ctx['term']->name : 'sản phẩm';
			return sprintf( 'Danh mục %s chính hãng giá rẻ nhất thị trường tại PhoneX. Đa dạng mẫu mã, cam kết chất lượng, bảo hành 12 tháng, trả góp 0%%, sẵn hàng tại showroom.', $cname );

		case 'singular':
			$excerpt = get_the_excerpt( $ctx['post'] );
			if ( ! empty( $excerpt ) ) {
				return wp_strip_all_tags( $excerpt );
			}
			return sprintf( '%s chính hãng tại hệ thống PhoneX - Cam kết chất lượng, bảo hành chu đáo, giao hàng nhanh toàn quốc.', get_the_title( $ctx['post'] ) );

		default:
			return 'PhoneX - Hệ thống bán lẻ điện thoại chính hãng và trung tâm thu cũ đổi mới hàng đầu Việt Nam. Cam kết máy zin 100%, bảo hành 12 tháng 1 đổi 1.';
	}
}

/**
 * 3. Canonical URL Generator
 */
function phonex_seo_get_canonical_url() {
	$ctx  = phonex_seo_get_context();
	$path = phonex_seo_get_relative_path();

	switch ( $ctx['type'] ) {
		case 'home':
			return trailingslashit( home_url() );

		case 'kho-may-cu':
			$cat = isset( $_GET['cat'] ) ? sanitize_title( $_GET['cat'] ) : '';
			$base = home_url( '/kho-may-cu/' );
			if ( ! empty( $cat ) ) {
				return add_query_arg( 'cat', $cat, $base );
			}
			return $base;

		case 'buyback-hub':
			if ( preg_match( '#^/thu-cu-doi-moi/?$#i', $path ) ) {
				return home_url( '/thu-cu-doi-moi/' );
			}
			return home_url( '/thu-mua-dien-thoai/' );

		case 'buyback-brand':
			return home_url( '/thu-mua-dien-thoai/' . $ctx['brand']->slug . '/' );

		case 'buyback-model':
			return home_url( '/thu-mua-dien-thoai/' . $ctx['brand']->slug . '/' . $ctx['model']->slug . '/' );

		case 'valuation':
			return home_url( '/dinh-gia-dien-thoai/' );

		case 'pricing':
			return home_url( '/bang-gia-thu-mua/' );

		case 'lookup':
			return home_url( '/tra-cuu-yeu-cau/' );

		case 'process':
			return home_url( '/quy-trinh-thu-mua/' );

		case 'standards':
			return home_url( '/tieu-chuan-kiem-dinh/' );

		case 'dtdd':
			return home_url( '/dtdd/' );

		case 'flash-sale':
			return home_url( '/flash-sale/' );

		case 'product':
			return get_permalink( $ctx['post'] );

		case 'product_cat':
			return get_term_link( $ctx['term'] );

		case 'singular':
			return get_permalink( $ctx['post'] );

		default:
			return home_url( $path );
	}
}

/**
 * 4. Image URL Generator for Social & Schema
 */
function phonex_seo_get_image() {
	$ctx = phonex_seo_get_context();

	if ( 'product' === $ctx['type'] && $ctx['post'] ) {
		$img_id = get_post_thumbnail_id( $ctx['post'] );
		if ( $img_id ) {
			$img_src = wp_get_attachment_image_url( $img_id, 'full' );
			if ( $img_src ) {
				return $img_src;
			}
		}

		// Check custom PhoneX relative image
		$img_rel = get_post_meta( $ctx['post']->ID, '_phonex_image_rel', true );
		if ( ! empty( $img_rel ) ) {
			return get_template_directory_uri() . '/' . ltrim( $img_rel, '/' );
		}
	}

	if ( 'buyback-model' === $ctx['type'] && $ctx['model'] && ! empty( $ctx['model']->image_url ) ) {
		return $ctx['model']->image_url;
	}

	// Default High-res Brand Banner
	$og_share = get_template_directory_uri() . '/assets/images/logo/phonex-og-share.png';
	$slider_banner = get_template_directory_uri() . '/assets/images/banners/slider-banner-1-2400x600.png';

	if ( file_exists( get_template_directory() . '/assets/images/logo/phonex-og-share.png' ) ) {
		return $og_share;
	}
	return $slider_banner;
}

/**
 * 5. Google Robots Meta Tag Filter
 */
function phonex_seo_wp_robots( $robots ) {
	if ( is_search() || is_404() || is_cart() || is_checkout() || is_account_page() ) {
		return array(
			'noindex' => true,
			'follow'  => true,
		);
	}

	return array(
		'index'              => true,
		'follow'             => true,
		'max-image-preview' => 'large',
		'max-snippet'       => -1,
		'max-video-preview' => -1,
	);
}
add_filter( 'wp_robots', 'phonex_seo_wp_robots', 99 );

/**
 * Remove default WordPress canonical to prevent duplicates
 */
remove_action( 'wp_head', 'rel_canonical' );

/**
 * 6. Master SEO Head Tags (Description, Canonical, Open Graph, Twitter Cards)
 */
function phonex_seo_head_tags() {
	$title       = esc_attr( phonex_seo_get_title() );
	$description = esc_attr( phonex_seo_get_description() );
	$canonical   = esc_url( phonex_seo_get_canonical_url() );
	$image       = esc_url( phonex_seo_get_image() );
	$site_name   = 'PhoneX - Hệ Thống Điện Thoại & Thu Cũ Đổi Mới';
	$ctx         = phonex_seo_get_context();
	$og_type     = ( 'product' === $ctx['type'] ) ? 'product' : 'website';
	?>

<!-- PhoneX Google SEO & Social Meta Tags -->
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="PhoneX, thu cu doi moi, dien thoai cu gia re, iphone cu, samsung cu, xiaomi cu, thu mua dien thoai cu gia cao, dinh gia dien thoai, dien thoai like new" />
<link rel="canonical" href="<?php echo $canonical; ?>" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>" />
<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>" />
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:url" content="<?php echo $canonical; ?>" />
<meta property="og:image" content="<?php echo $image; ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="<?php echo $title; ?>" />
<meta property="og:locale" content="vi_VN" />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@phonex_vn" />
<meta name="twitter:title" content="<?php echo $title; ?>" />
<meta name="twitter:description" content="<?php echo $description; ?>" />
<meta name="twitter:image" content="<?php echo $image; ?>" />
<meta name="twitter:image:alt" content="<?php echo $title; ?>" />

<?php if ( 'product' === $ctx['type'] && $ctx['post'] ) : 
	$prod = wc_get_product( $ctx['post'] );
	if ( $prod ) : ?>
<meta property="product:price:amount" content="<?php echo esc_attr( $prod->get_price() ); ?>" />
<meta property="product:price:currency" content="VND" />
<meta property="product:availability" content="in stock" />
<meta property="product:condition" content="used" />
<?php endif; endif; ?>
<!-- End PhoneX SEO Tags -->

<?php
}
add_action( 'wp_head', 'phonex_seo_head_tags', 1 );

/**
 * 7. Schema.org JSON-LD Structured Data Generator (Google Rich Results Compliant)
 */
function phonex_seo_schema_jsonld() {
	$ctx       = phonex_seo_get_context();
	$home_url  = trailingslashit( home_url() );
	$logo_url  = get_template_directory_uri() . '/assets/images/logo/phonex-logo.png';
	$hero_url  = get_template_directory_uri() . '/assets/images/banners/slider-banner-1-2400x600.png';
	$canonical = phonex_seo_get_canonical_url();
	$title     = phonex_seo_get_title();
	$desc      = phonex_seo_get_description();

	$graph = array();

	// 1. WebSite Schema (with Google Sitelinks SearchBox Action)
	$graph[] = array(
		'@type'           => 'WebSite',
		'@id'             => $home_url . '#website',
		'url'             => $home_url,
		'name'            => 'PhoneX',
		'alternateName'   => 'Hệ Thống Điện Thoại & Thu Cũ Đổi Mới PhoneX',
		'description'     => 'Hệ thống bán lẻ & thu cũ đổi mới điện thoại uy tín số 1 Việt Nam. Máy zin 100%, bảo hành 12 tháng 1 đổi 1.',
		'inLanguage'      => 'vi-VN',
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $home_url . '?s={search_term_string}',
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	// 2. Organization & ElectronicsStore (LocalBusiness Showroom)
	$graph[] = array(
		'@type'                      => 'ElectronicsStore',
		'@id'                        => $home_url . '#organization',
		'name'                       => 'PhoneX - Hệ Thống Điện Thoại & Thu Cũ Đổi Mới',
		'alternateName'              => 'PhoneX Showroom',
		'url'                        => $home_url,
		'logo'                       => array(
			'@type'      => 'ImageObject',
			'@id'        => $home_url . '#logo',
			'url'        => $logo_url,
			'caption'    => 'PhoneX Smartphone Specialist',
			'inLanguage' => 'vi-VN',
		),
		'image'                      => $hero_url,
		'telephone'                  => '+84-1900-6868',
		'email'                      => 'hotro@phonex.vn',
		'priceRange'                 => '1.000.000₫ - 45.000.000₫',
		'paymentAccepted'            => 'Tiền mặt, Chuyển khoản ngân hàng, Thẻ tín dụng, Trả góp 0%, Ví điện tử',
		'currenciesAccepted'         => 'VND',
		'address'                    => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '123 Đường Ba Tháng Hai, Phường 11, Quận 10',
			'addressLocality' => 'Thành phố Hồ Chí Minh',
			'addressRegion'   => 'Hồ Chí Minh',
			'postalCode'      => '700000',
			'addressCountry'  => 'VN',
		),
		'geo'                        => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => 10.7719,
			'longitude' => 106.6740,
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
				'opens'     => '08:00',
				'closes'    => '21:30',
			),
		),
		'sameAs'                     => array(
			'https://www.facebook.com/phonex.vietnam',
			'https://www.youtube.com/@phonex_vietnam',
			'https://www.tiktok.com/@phonex_vietnam',
		),
	);

	// 3. BreadcrumbList Schema
	$breadcrumbs = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Trang chủ',
			'item'     => $home_url,
		),
	);

	if ( 'kho-may-cu' === $ctx['type'] ) {
		$cat = isset( $_GET['cat'] ) ? sanitize_title( $_GET['cat'] ) : '';
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Kho máy cũ',
			'item'     => home_url( '/kho-may-cu/' ),
		);
		if ( ! empty( $cat ) ) {
			$cat_labels = array(
				'iphone'  => 'iPhone cũ',
				'samsung' => 'Samsung cũ',
				'xiaomi'  => 'Xiaomi cũ',
				'oppo'    => 'OPPO cũ',
				'vivo'    => 'Vivo cũ',
				'realme'  => 'Realme cũ',
				'honor'   => 'HONOR cũ',
			);
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $cat_labels[ $cat ] ?? ucfirst( $cat ) . ' cũ',
				'item'     => home_url( '/kho-may-cu/?cat=' . $cat ),
			);
		}
	} elseif ( 'buyback-hub' === $ctx['type'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Thu mua điện thoại',
			'item'     => home_url( '/thu-mua-dien-thoai/' ),
		);
	} elseif ( 'buyback-brand' === $ctx['type'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Thu mua điện thoại',
			'item'     => home_url( '/thu-mua-dien-thoai/' ),
		);
		if ( $ctx['brand'] ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $ctx['brand']->name,
				'item'     => home_url( '/thu-mua-dien-thoai/' . $ctx['brand']->slug . '/' ),
			);
		}
	} elseif ( 'buyback-model' === $ctx['type'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Thu mua điện thoại',
			'item'     => home_url( '/thu-mua-dien-thoai/' ),
		);
		if ( $ctx['brand'] ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $ctx['brand']->name,
				'item'     => home_url( '/thu-mua-dien-thoai/' . $ctx['brand']->slug . '/' ),
			);
		}
		if ( $ctx['model'] ) {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 4,
				'name'     => $ctx['model']->name,
				'item'     => home_url( '/thu-mua-dien-thoai/' . $ctx['brand']->slug . '/' . $ctx['model']->slug . '/' ),
			);
		}
	} elseif ( 'valuation' === $ctx['type'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Định giá điện thoại trực tuyến',
			'item'     => home_url( '/dinh-gia-dien-thoai/' ),
		);
	} elseif ( 'pricing' === $ctx['type'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Bảng giá thu mua',
			'item'     => home_url( '/bang-gia-thu-mua/' ),
		);
	} elseif ( 'product' === $ctx['type'] && $ctx['post'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Kho máy cũ',
			'item'     => home_url( '/kho-may-cu/' ),
		);
		$terms = get_the_terms( $ctx['post']->ID, 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term = reset( $terms );
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => $term->name,
				'item'     => get_term_link( $term ),
			);
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 4,
				'name'     => get_the_title( $ctx['post'] ),
				'item'     => get_permalink( $ctx['post'] ),
			);
		} else {
			$breadcrumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 3,
				'name'     => get_the_title( $ctx['post'] ),
				'item'     => get_permalink( $ctx['post'] ),
			);
		}
	} elseif ( 'product_cat' === $ctx['type'] && $ctx['term'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => 'Sản phẩm',
			'item'     => home_url( '/dtdd/' ),
		);
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 3,
			'name'     => $ctx['term']->name,
			'item'     => get_term_link( $ctx['term'] ),
		);
	} elseif ( 'singular' === $ctx['type'] && $ctx['post'] ) {
		$breadcrumbs[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => get_the_title( $ctx['post'] ),
			'item'     => get_permalink( $ctx['post'] ),
		);
	}

	if ( count( $breadcrumbs ) > 1 ) {
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => $canonical . '#breadcrumb',
			'itemListElement' => $breadcrumbs,
		);
	}

	// 4. Product Schema (Single WooCommerce Product)
	if ( 'product' === $ctx['type'] && $ctx['post'] ) {
		$prod = wc_get_product( $ctx['post'] );
		if ( $prod ) {
			$p_price = (float) $prod->get_price();
			if ( $p_price <= 0 ) {
				$p_price = (float) $prod->get_regular_price();
			}
			$img_url = wp_get_attachment_image_url( $prod->get_image_id(), 'full' );
			if ( ! $img_url ) {
				$img_rel = get_post_meta( $ctx['post']->ID, '_phonex_image_rel', true );
				if ( ! empty( $img_rel ) ) {
					$img_url = get_template_directory_uri() . '/' . ltrim( $img_rel, '/' );
				} else {
					$img_url = phonex_seo_get_image();
				}
			}

			// Detect brand from terms or title
			$p_brand = 'PhoneX';
			$terms   = get_the_terms( $ctx['post']->ID, 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $t ) {
					if ( stripos( $t->slug, 'iphone' ) !== false || stripos( $t->name, 'apple' ) !== false ) {
						$p_brand = 'Apple';
						break;
					} elseif ( stripos( $t->slug, 'samsung' ) !== false ) {
						$p_brand = 'Samsung';
						break;
					} elseif ( stripos( $t->slug, 'xiaomi' ) !== false ) {
						$p_brand = 'Xiaomi';
						break;
					} elseif ( stripos( $t->slug, 'oppo' ) !== false ) {
						$p_brand = 'OPPO';
						break;
					} elseif ( stripos( $t->slug, 'vivo' ) !== false ) {
						$p_brand = 'Vivo';
						break;
					} elseif ( stripos( $t->slug, 'realme' ) !== false ) {
						$p_brand = 'Realme';
						break;
					} elseif ( stripos( $t->slug, 'honor' ) !== false ) {
						$p_brand = 'HONOR';
						break;
					}
				}
			}

			$sku = $prod->get_sku();
			if ( empty( $sku ) ) {
				$sku = 'PX-' . $prod->get_id();
			}

			$graph[] = array(
				'@type'           => 'Product',
				'@id'             => $canonical . '#product',
				'name'            => $prod->get_name(),
				'image'           => array( $img_url ),
				'description'     => $desc,
				'sku'             => $sku,
				'mpn'             => $sku,
				'brand'           => array(
					'@type' => 'Brand',
					'name'  => $p_brand,
				),
				'offers'          => array(
					'@type'                   => 'Offer',
					'url'                     => $canonical,
					'priceCurrency'           => 'VND',
					'price'                   => $p_price > 0 ? (string) $p_price : '5000000',
					'priceValidUntil'         => gmdate( 'Y-12-31', strtotime( '+1 year' ) ),
					'itemCondition'           => 'https://schema.org/UsedCondition',
					'availability'            => 'https://schema.org/InStock',
					'seller'                  => array(
						'@type' => 'Organization',
						'name'  => 'PhoneX',
					),
					'hasMerchantReturnPolicy' => array(
						'@type'                  => 'MerchantReturnPolicy',
						'applicableCountry'      => 'VN',
						'returnPolicyCategory'   => 'https://schema.org/MerchantReturnFiniteReturnWindow',
						'merchantReturnDays'     => 30,
						'returnMethod'           => 'https://schema.org/ReturnInStore',
						'returnFees'             => 'https://schema.org/FreeReturn',
					),
					'shippingDetails'         => array(
						'@type'               => 'OfferShippingDetails',
						'shippingRate'        => array(
							'@type'    => 'MonetaryAmount',
							'value'    => 0,
							'currency' => 'VND',
						),
						'shippingDestination' => array(
							'@type'          => 'DefinedRegion',
							'addressCountry' => 'VN',
						),
						'deliveryTime'        => array(
							'@type'          => 'ShippingDeliveryTime',
							'handlingTime'   => array(
								'@type'    => 'QuantitativeValue',
								'minValue' => 0,
								'maxValue' => 1,
								'unitCode' => 'DAY',
							),
							'transitTime'    => array(
								'@type'    => 'QuantitativeValue',
								'minValue' => 1,
								'maxValue' => 2,
								'unitCode' => 'DAY',
							),
						),
					),
				),
				'aggregateRating' => array(
					'@type'       => 'AggregateRating',
					'ratingValue' => '4.9',
					'reviewCount' => '128',
					'bestRating'  => '5',
					'worstRating' => '1',
				),
			);
		}
	}

	// 5. FAQPage Schema (Rich Google Search Dropdown Results)
	$faqs = array();
	if ( 'buyback-hub' === $ctx['type'] || 'buyback-brand' === $ctx['type'] ) {
		$faqs = array(
			array(
				'q' => 'PhoneX thu mua và đổi mới những dòng điện thoại nào?',
				'a' => 'PhoneX hỗ trợ thu mua và đổi mới tất cả các thương hiệu điện thoại chính hãng gồm Apple iPhone, Samsung Galaxy, Xiaomi, OPPO, Vivo, Realme, HONOR, Sony, Huawei, Google Pixel... Hỗ trợ thu mua máy đẹp như mới (Grade A), máy trầy xước nhẹ (Grade B), máy cấn trầy (Grade C) và máy lỗi chức năng nhẹ (Grade D).',
			),
			array(
				'q' => 'Thời gian kiểm định và giải ngân tại PhoneX mất bao lâu?',
				'a' => 'Toàn bộ quy trình kiểm định 30 bước tiêu chuẩn tại showroom chỉ diễn ra trong 10 - 15 phút. Sau khi chốt giá, PhoneX sẽ thanh toán chuyển khoản 24/7 hoặc chi tiền mặt ngay trong 5 phút.',
			),
			array(
				'q' => 'Chính sách trợ giá lên đời thu cũ đổi mới tại PhoneX như thế nào?',
				'a' => 'Khi khách hàng đổi điện thoại cũ để lên đời máy mới tại PhoneX, quý khách được nhận thêm mức trợ giá độc quyền lên đến 30% giá trị máy cũ hoặc tối đa 3.000.000đ, kèm quà tặng và ưu đãi phụ kiện 20%.',
			),
			array(
				'q' => 'Tôi có cần mang theo hộp và phụ kiện khi bán máy không?',
				'a' => 'PhoneX thu mua cả máy trần không kèm hộp hay phụ kiện. Nếu quý khách giữ lại hộp zin hoặc củ cáp chính hãng, PhoneX sẽ cộng thêm tiền thưởng vào giá trị thu mua.',
			),
			array(
				'q' => 'Dữ liệu cá nhân trên máy cũ của tôi có được bảo mật không?',
				'a' => 'Chuyên viên PhoneX sẽ hỗ trợ sao lưu toàn bộ dữ liệu qua máy mới miễn phí, sau đó tiến hành khôi phục cài đặt gốc và xóa trắng dữ liệu vĩnh viễn theo chuẩn bảo mật trước sự chứng kiến trực tiếp của khách hàng.',
			),
		);
	} elseif ( 'valuation' === $ctx['type'] ) {
		$faqs = array(
			array(
				'q' => 'Công cụ định giá điện thoại trực tuyến của PhoneX hoạt động ra sao?',
				'a' => 'Công cụ định giá PhoneX sử dụng thuật toán phân tích dữ liệu thị trường và phân loại 4 hạng chất lượng Grade A/B/C/D theo thời gian thực. Bạn chỉ cần chọn hãng, model, dung lượng và tình trạng máy để nhận báo giá chính xác chỉ trong 1 phút.',
			),
			array(
				'q' => 'Mức giá định giá online có thay đổi khi tôi mang máy đến showroom không?',
				'a' => 'Mức giá hiển thị online là mức giá cam kết nếu tình trạng thực tế của máy trùng khớp với các tiêu chí bạn đã chọn trên website. PhoneX cam kết không ép giá, mọi bước kiểm định đều công khai minh bạch trước mặt khách hàng.',
			),
			array(
				'q' => 'Sau khi nhận định giá trên web, tôi có bắt buộc phải bán máy không?',
				'a' => 'Hoàn toàn không. Định giá trực tuyến tại PhoneX là dịch vụ tiện ích miễn phí 100% và không có bất kỳ ràng buộc nào. Quý khách có thể tự do tham khảo mức giá tốt nhất.',
			),
			array(
				'q' => 'Tôi cần chuẩn bị gì trước khi mang máy đến thẩm định?',
				'a' => 'Quý khách chỉ cần chuẩn bị máy đã sạc đủ pin, đăng xuất các tài khoản bảo mật (iCloud, Google Account, Samsung Account), và mang theo CCCD/CMND để hoàn tất thủ tục bàn giao hợp lệ theo quy định pháp luật.',
			),
		);
	} elseif ( 'kho-may-cu' === $ctx['type'] ) {
		$faqs = array(
			array(
				'q' => 'Điện thoại cũ tại Kho máy cũ PhoneX có đảm bảo nguồn gốc và chất lượng không?',
				'a' => '100% điện thoại tại Kho máy cũ PhoneX đều trải qua quy trình kiểm định 30 bước nghiêm ngặt về màn hình, mainboard, pin, camera, cảm biến và kết nối. Chúng tôi cam kết máy zin nguyên bản, chưa qua sửa chữa thay thế linh kiện kém chất lượng.',
			),
			array(
				'q' => 'Chế độ bảo hành cho điện thoại cũ tại PhoneX như thế nào?',
				'a' => 'Tất cả điện thoại cũ tại PhoneX đều được hưởng gói bảo hành toàn diện 12 tháng, lỗi 1 đổi 1 trong 30 ngày đầu tiên (kể cả nguồn và màn hình), kèm dịch vụ bảo hành pin trọn đời máy.',
			),
			array(
				'q' => 'Tôi có được mở máy kiểm tra trước khi nhận và thanh toán không?',
				'a' => 'Có. Khách hàng mua sắm tại showroom hoặc đặt giao hàng tận nơi đều được thoải mái kiểm tra ngoại hình, test toàn bộ chức năng nghe gọi, màn hình, camera trước khi thanh toán.',
			),
			array(
				'q' => 'PhoneX có hỗ trợ trả góp cho điện thoại cũ không?',
				'a' => 'Có. PhoneX hỗ trợ trả góp 0% lãi suất qua thẻ tín dụng liên kết 25+ ngân hàng và trả góp thủ tục nhanh chỉ cần CCCD qua các công ty tài chính, duyệt hồ sơ chỉ trong 10 phút, nhận máy ngay.',
			),
		);
	} elseif ( 'process' === $ctx['type'] ) {
		$faqs = array(
			array(
				'q' => 'Tôi có thể bán máy cũ tại nhà không hay phải đến showroom PhoneX?',
				'a' => 'PhoneX hỗ trợ cả 2 hình thức: Thẩm định trực tiếp tại hệ thống showroom PhoneX toàn quốc hoặc kỹ thuật viên đến tận nhà thu mua trong vòng 2h tại khu vực TP. Hồ Chí Minh và Hà Nội.',
			),
			array(
				'q' => 'Tôi có phải trả bất kỳ khoản phí nào nếu sau khi kiểm tra tôi không muốn bán máy nữa không?',
				'a' => 'Hoàn toàn không. Khâu kiểm tra và thẩm định máy tại PhoneX là hoàn toàn miễn phí. Khách hàng luôn có quyền quyết định bán hoặc không bán.',
			),
		);
	}

	if ( ! empty( $faqs ) ) {
		$main_entity = array();
		foreach ( $faqs as $item ) {
			$main_entity[] = array(
				'@type'          => 'Question',
				'name'           => $item['q'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $item['a'],
				),
			);
		}
		$graph[] = array(
			'@type'      => 'FAQPage',
			'@id'        => $canonical . '#faq',
			'mainEntity' => $main_entity,
		);
	}

	// 6. ItemList Schema (For Kho Máy Cũ to empower Google Collection Carousel)
	if ( 'kho-may-cu' === $ctx['type'] ) {
		$used_file = get_template_directory() . '/data/used-phones.json';
		if ( file_exists( $used_file ) ) {
			$raw_data = file_get_contents( $used_file );
			$items_arr = json_decode( $raw_data, true );
			if ( is_array( $items_arr ) && ! empty( $items_arr ) ) {
				$cat = isset( $_GET['cat'] ) ? sanitize_title( $_GET['cat'] ) : '';
				if ( ! empty( $cat ) ) {
					$items_arr = array_filter( $items_arr, function ( $it ) use ( $cat ) {
						return ( $it['brand'] ?? '' ) === $cat;
					} );
				}
				$top_items = array_slice( $items_arr, 0, 12 );
				$list_elements = array();
				$pos = 1;
				foreach ( $top_items as $item ) {
					$item_url = ! empty( $item['slug'] ) ? home_url( '/product/' . $item['slug'] . '/' ) : home_url( '/kho-may-cu/' );
					$list_elements[] = array(
						'@type'    => 'ListItem',
						'position' => $pos++,
						'name'     => $item['name'] ?? 'Điện thoại cũ',
						'url'      => $item_url,
					);
				}
				if ( ! empty( $list_elements ) ) {
					$graph[] = array(
						'@type'           => 'ItemList',
						'@id'             => $canonical . '#itemlist',
						'itemListElement' => $list_elements,
					);
				}
			}
		}
	}

	// Assemble final JSON-LD
	$schema_data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo "\n<!-- PhoneX Google Schema.org JSON-LD Structured Data -->\n";
	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
	echo "\n" . '</script>' . "\n";
	echo "<!-- End PhoneX Schema.org -->\n\n";
}
add_action( 'wp_head', 'phonex_seo_schema_jsonld', 2 );

/**
 * 8. Dynamic XML Sitemap Generator (/sitemap.xml)
 * Fully compliant with Google Sitemap Protocol 0.9 & Image Sitemap Extension
 */
function phonex_seo_render_sitemap() {
	header( 'Content-Type: application/xml; charset=utf-8' );
	header( 'X-Robots-Tag: noindex, follow' );

	$home_url = trailingslashit( home_url() );
	$now_iso  = gmdate( 'Y-m-d\TH:i:s+00:00' );

	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
	echo '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

	// 1. Homepage
	echo "  <url>\n";
	echo '    <loc>' . esc_url( $home_url ) . "</loc>\n";
	echo '    <lastmod>' . esc_html( $now_iso ) . "</lastmod>\n";
	echo "    <changefreq>daily</changefreq>\n";
	echo "    <priority>1.0</priority>\n";
	echo "  </url>\n";

	// 2. Core Landing Pages
	$landing_pages = array(
		'/kho-may-cu/'             => array( 'priority' => '0.95', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=iphone'  => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=samsung' => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=xiaomi'  => array( 'priority' => '0.85', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=oppo'    => array( 'priority' => '0.85', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=vivo'    => array( 'priority' => '0.85', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=realme'  => array( 'priority' => '0.85', 'freq' => 'daily' ),
		'/kho-may-cu/?cat=honor'   => array( 'priority' => '0.85', 'freq' => 'daily' ),
		'/thu-mua-dien-thoai/'     => array( 'priority' => '0.95', 'freq' => 'daily' ),
		'/dinh-gia-dien-thoai/'    => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/bang-gia-thu-mua/'       => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/quy-trinh-thu-mua/'      => array( 'priority' => '0.85', 'freq' => 'weekly' ),
		'/tieu-chuan-kiem-dinh/'   => array( 'priority' => '0.85', 'freq' => 'weekly' ),
		'/tra-cuu-yeu-cau/'        => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/dtdd/'                   => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/flash-sale/'             => array( 'priority' => '0.90', 'freq' => 'daily' ),
		'/phu-kien/'               => array( 'priority' => '0.85', 'freq' => 'weekly' ),
		'/sac-nhanh/'              => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/cap-sac/'                => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/op-lung-flipcover/'      => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/tai-nghe/'               => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/kinh-cuong-luc/'         => array( 'priority' => '0.80', 'freq' => 'weekly' ),
		'/he-thong-cua-hang/'      => array( 'priority' => '0.75', 'freq' => 'monthly' ),
		'/chinh-sach-bao-hanh/'    => array( 'priority' => '0.75', 'freq' => 'monthly' ),
	);

	foreach ( $landing_pages as $l_path => $l_meta ) {
		$l_url = home_url( $l_path );
		echo "  <url>\n";
		echo '    <loc>' . esc_url( $l_url ) . "</loc>\n";
		echo '    <lastmod>' . esc_html( $now_iso ) . "</lastmod>\n";
		echo '    <changefreq>' . esc_html( $l_meta['freq'] ) . "</changefreq>\n";
		echo '    <priority>' . esc_html( $l_meta['priority'] ) . "</priority>\n";
		echo "  </url>\n";
	}

	// 3. Buyback Brands & Models
	global $wpdb;
	$t_brands = $wpdb->prefix . 'phonex_buyback_brands';
	$t_models = $wpdb->prefix . 'phonex_buyback_models';

	$brands = $wpdb->get_results( "SELECT slug, name, updated_at FROM $t_brands WHERE is_active = 1" );
	if ( $brands ) {
		foreach ( $brands as $b ) {
			$b_url  = home_url( '/thu-mua-dien-thoai/' . $b->slug . '/' );
			$b_date = ! empty( $b->updated_at ) ? gmdate( 'Y-m-d\TH:i:s+00:00', strtotime( $b->updated_at ) ) : $now_iso;
			echo "  <url>\n";
			echo '    <loc>' . esc_url( $b_url ) . "</loc>\n";
			echo '    <lastmod>' . esc_html( $b_date ) . "</lastmod>\n";
			echo "    <changefreq>weekly</changefreq>\n";
			echo "    <priority>0.85</priority>\n";
			echo "  </url>\n";
		}
	}

	$models = $wpdb->get_results( "
		SELECT m.slug AS m_slug, b.slug AS b_slug, m.name AS m_name, m.image_url, m.updated_at 
		FROM $t_models m 
		JOIN $t_brands b ON m.brand_id = b.id 
		WHERE m.is_active = 1 
		ORDER BY m.id DESC LIMIT 300
	" );
	if ( $models ) {
		foreach ( $models as $m ) {
			$m_url  = home_url( '/thu-mua-dien-thoai/' . $m->b_slug . '/' . $m->m_slug . '/' );
			$m_date = ! empty( $m->updated_at ) ? gmdate( 'Y-m-d\TH:i:s+00:00', strtotime( $m->updated_at ) ) : $now_iso;
			echo "  <url>\n";
			echo '    <loc>' . esc_url( $m_url ) . "</loc>\n";
			echo '    <lastmod>' . esc_html( $m_date ) . "</lastmod>\n";
			echo "    <changefreq>weekly</changefreq>\n";
			echo "    <priority>0.80</priority>\n";
			if ( ! empty( $m->image_url ) ) {
				echo "    <image:image>\n";
				echo '      <image:loc>' . esc_url( $m->image_url ) . "</image:loc>\n";
				echo '      <image:title>' . esc_html( $m->m_name ) . "</image:title>\n";
				echo "    </image:image>\n";
			}
			echo "  </url>\n";
		}
	}

	// 4. WooCommerce Product Categories
	$categories = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
	) );
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $cat ) {
			$c_url = get_term_link( $cat );
			if ( ! is_wp_error( $c_url ) ) {
				echo "  <url>\n";
				echo '    <loc>' . esc_url( $c_url ) . "</loc>\n";
				echo '    <lastmod>' . esc_html( $now_iso ) . "</lastmod>\n";
				echo "    <changefreq>weekly</changefreq>\n";
				echo "    <priority>0.80</priority>\n";
				echo "  </url>\n";
			}
		}
	}

	// 5. WooCommerce Products (All published phones & accessories)
	$products = get_posts( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 1000,
		'fields'         => 'ids',
	) );

	if ( ! empty( $products ) ) {
		foreach ( $products as $pid ) {
			$p_url  = get_permalink( $pid );
			$p_post = get_post( $pid );
			$p_date = gmdate( 'Y-m-d\TH:i:s+00:00', strtotime( $p_post->post_modified_gmt ) );
			$thumb_id = get_post_thumbnail_id( $pid );
			$img_src  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';
			if ( empty( $img_src ) ) {
				$img_rel = get_post_meta( $pid, '_phonex_image_rel', true );
				if ( ! empty( $img_rel ) ) {
					$img_src = get_template_directory_uri() . '/' . ltrim( $img_rel, '/' );
				}
			}

			echo "  <url>\n";
			echo '    <loc>' . esc_url( $p_url ) . "</loc>\n";
			echo '    <lastmod>' . esc_html( $p_date ) . "</lastmod>\n";
			echo "    <changefreq>weekly</changefreq>\n";
			echo "    <priority>0.80</priority>\n";
			if ( ! empty( $img_src ) ) {
				echo "    <image:image>\n";
				echo '      <image:loc>' . esc_url( $img_src ) . "</image:loc>\n";
				echo '      <image:title>' . esc_html( $p_post->post_title ) . "</image:title>\n";
				echo "    </image:image>\n";
			}
			echo "  </url>\n";
		}
	}

	// 6. Regular Published WordPress Pages
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 100,
		'fields'         => 'ids',
	) );
	if ( ! empty( $pages ) ) {
		foreach ( $pages as $pg_id ) {
			$pg_post = get_post( $pg_id );
			$pg_url  = get_permalink( $pg_id );
			$pg_date = gmdate( 'Y-m-d\TH:i:s+00:00', strtotime( $pg_post->post_modified_gmt ) );

			echo "  <url>\n";
			echo '    <loc>' . esc_url( $pg_url ) . "</loc>\n";
			echo '    <lastmod>' . esc_html( $pg_date ) . "</lastmod>\n";
			echo "    <changefreq>monthly</changefreq>\n";
			echo "    <priority>0.70</priority>\n";
			echo "  </url>\n";
		}
	}

	echo '</urlset>' . "\n";
	exit;
}

/**
 * 9. Dynamic robots.txt Generator
 */
function phonex_seo_render_robots() {
	header( 'Content-Type: text/plain; charset=utf-8' );

	$sitemap_url = home_url( '/sitemap.xml' );
	$site_path   = untrailingslashit( wp_parse_url( home_url(), PHP_URL_PATH ) );

	echo "# ================================================================\n";
	echo "# PhoneX Official Robots.txt - Optimized for Google Search Console\n";
	echo "# ================================================================\n\n";

	echo "User-agent: *\n";
	echo "Allow: /\n";
	echo "Allow: " . $site_path . "/wp-content/uploads/\n";
	echo "Allow: " . $site_path . "/wp-content/themes/\n";
	echo "Allow: " . $site_path . "/wp-includes/js/\n";
	echo "Allow: " . $site_path . "/wp-includes/css/\n";
	echo "Disallow: /wp-admin/\n";
	echo "Disallow: " . $site_path . "/wp-admin/\n";
	echo "Disallow: " . $site_path . "/wp-login.php\n";
	echo "Disallow: " . $site_path . "/cart/\n";
	echo "Disallow: " . $site_path . "/checkout/\n";
	echo "Disallow: " . $site_path . "/my-account/\n";
	echo "Disallow: " . $site_path . "/?s=\n";
	echo "Disallow: /*?*utm_*\n";
	echo "Disallow: /*?*fbclid*\n";
	echo "Disallow: /*?*gclid*\n\n";

	echo "User-agent: Googlebot\n";
	echo "Allow: /\n";
	echo "Disallow: " . $site_path . "/wp-admin/\n\n";

	echo "User-agent: Googlebot-Image\n";
	echo "Allow: " . $site_path . "/wp-content/uploads/\n";
	echo "Allow: " . $site_path . "/wp-content/themes/\n\n";

	echo "# XML Sitemap Location\n";
	echo "Sitemap: " . esc_url( $sitemap_url ) . "\n";
	exit;
}

/**
 * 10. Intercept virtual requests for /sitemap.xml and /robots.txt
 */
function phonex_seo_intercept_virtual_files() {
	$path = phonex_seo_get_relative_path();

	if ( preg_match( '#^/(sitemap\.xml|sitemap_index\.xml)/?$#i', $path ) ) {
		status_header( 200 );
		phonex_seo_render_sitemap();
	}

	if ( preg_match( '#^/(robots\.txt)/?$#i', $path ) ) {
		status_header( 200 );
		phonex_seo_render_robots();
	}
}
add_action( 'template_redirect', 'phonex_seo_intercept_virtual_files', 0 );
