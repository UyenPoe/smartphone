<?php
/**
 * PhoneX functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PhoneX
 */

if ( ! defined( 'PHONEX_VERSION' ) ) {
	define( 'PHONEX_VERSION', '2.5.0' );
}
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', PHONEX_VERSION );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function phonex_setup() {
	load_theme_textdomain( 'phonex', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus
	register_nav_menus(
		array(
			'primary'        => esc_html__( 'Thanh điều hướng chính (Header)', 'phonex' ),
			'mobile'         => esc_html__( 'Menu ứng dụng di động (Mobile App)', 'phonex' ),
			'footer-support' => esc_html__( 'Footer: Chính sách & Hỗ trợ', 'phonex' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// WooCommerce Theme Support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'phonex_setup' );

/**
 * Set content width
 */
function phonex_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'phonex_content_width', 1280 );
}
add_action( 'after_setup_theme', 'phonex_content_width', 0 );

/**
 * Enqueue scripts and styles with full Google Stitch Design Tokens.
 */
function phonex_scripts() {
	// Google Fonts & Material Symbols Icons
	wp_enqueue_style( 'phonex-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'phonex-material-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', array(), null );

	// Tailwind CSS CDN
	wp_enqueue_script( 'phonex-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );

	// Complete PhoneX Flagship Design System Tailwind Configuration
	$tailwind_config = '
		tailwind.config = {
			darkMode: "class",
			theme: {
				extend: {
					colors: {
						// PhoneX UI/UX Design System v1.0 Flagship Palette
						"primary": "#FF001F",
						"primary-flagship": "#FF001F",
						"primary-deep": "#b7000c",
						"primary-dark": "#D9001B",
						"primary-hover": "#D9001B",
						"primary-light": "#FFF0F2",
						"primary-container": "#e60012",
						"primary-fixed": "#ffdad5",
						"primary-fixed-dim": "#ffb4aa",
						"sale": "#e60012",
						"flash-sale": "#E53935",
						"promo": "#FF9800",
						"hot-deal": "#FF9800",
						"success": "#198754",
						"stock-green": "#198754",
						"text-main": "#1F1F1F",
						"text-sub": "#6B7280",
						"surface-pure": "#FFFFFF",
						"bg-section": "#F6F7F9",
						"bg-card-sub": "#F9FAFB",
						"border-subtle": "#E5E7EB",

						// Legacy & compatibility tokens
						"surface-container-high": "#e7e8ea",
						"on-primary": "#ffffff",
						"error": "#ba1a1a",
						"secondary": "#6B7280",
						"on-tertiary": "#ffffff",
						"surface-container-low": "#f2f4f6",
						"on-error-container": "#93000a",
						"inverse-surface": "#2e3132",
						"inverse-on-surface": "#f0f1f3",
						"tertiary-fixed-dim": "#c7c6c6",
						"on-secondary-container": "#656464",
						"tertiary": "#595a5a",
						"tertiary-fixed": "#e4e2e2",
						"on-secondary": "#ffffff",
						"tertiary-container": "#727272",
						"on-primary-container": "#fff7f6",
						"on-primary-fixed-variant": "#930007",
						"on-secondary-fixed": "#1c1b1b",
						"surface-tint": "#c0000d",
						"error-container": "#ffdad6",
						"surface-container-lowest": "#ffffff",
						"surface-container-highest": "#e1e2e4",
						"on-background": "#191c1e",
						"on-secondary-fixed-variant": "#474646",
						"secondary-container": "#e5e2e1",
						"inverse-primary": "#ffb4aa",
						"on-primary-fixed": "#410001",
						"surface": "#f8f9fb",
						"surface-dim": "#d9dadc",
						"on-error": "#ffffff",
						"background": "#f8f9fb",
						"surface-bright": "#f8f9fb",
						"outline-variant": "#e9bcb6",
						"surface-variant": "#e1e2e4",
						"on-surface-variant": "#5f3f3b",
						"outline": "#946e69",
						"on-surface": "#191c1e",
						"on-tertiary-container": "#faf8f8",
						"surface-container": "#edeef0",
						"on-tertiary-fixed-variant": "#464747",
						"on-tertiary-fixed": "#1b1c1c",
						"secondary-fixed-dim": "#c8c6c5",
						"secondary-fixed": "#e5e2e1",
						"border-light": "#e9bcb6",
						"bg-main": "#FFFFFF"
					},
					borderRadius: {
						"DEFAULT": "0.25rem",
						"badge": "6px",
						"button": "8px",
						"input": "8px",
						"card": "12px",
						"modal": "16px",
						"lg": "0.5rem",
						"xl": "0.75rem",
						"2xl": "1rem",
						"3xl": "1.5rem",
						"full": "9999px"
					},
					spacing: {
						"space-1": "4px",
						"space-2": "8px",
						"space-3": "12px",
						"space-4": "16px",
						"space-5": "20px",
						"space-6": "24px",
						"space-8": "32px",
						"space-10": "40px",
						"space-12": "48px",
						"space-16": "64px",
						"gutter": "1.25rem",
						"space-xs": "0.25rem",
						"margin": "1.5rem",
						"gutter-mobile": "0.75rem",
						"margin-desktop": "3.5rem",
						"space-lg": "1.5rem",
						"space-2xl": "4rem",
						"space-md": "1rem",
						"space-sm": "0.5rem",
						"space-xl": "2.5rem"
					},
					fontFamily: {
						"sans": ["Inter", "-apple-system", "BlinkMacSystemFont", "Segoe UI", "Roboto", "sans-serif"],
						"body-sm": ["Inter", "sans-serif"],
						"headline-sm": ["Inter", "sans-serif"],
						"body-regular": ["Inter", "sans-serif"],
						"price-strikethrough": ["Inter", "sans-serif"],
						"headline-lg": ["Inter", "sans-serif"],
						"headline-md": ["Inter", "sans-serif"],
						"headline-lg-mobile": ["Inter", "sans-serif"],
						"label-button": ["Inter", "sans-serif"],
						"label-badge": ["Inter", "sans-serif"],
						"price-lg": ["Inter", "sans-serif"],
						"title-product": ["Inter", "sans-serif"],
						"headline-xl-mobile": ["Inter", "sans-serif"],
						"price-card": ["Inter", "sans-serif"],
						"headline-xl": ["Inter", "sans-serif"]
					},
					fontSize: {
						"body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
						"headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
						"body-regular": ["16px", { "lineHeight": "26px", "fontWeight": "400" }],
						"price-strikethrough": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
						"headline-lg": ["34px", { "lineHeight": "42px", "fontWeight": "700" }],
						"headline-md": ["26px", { "lineHeight": "34px", "fontWeight": "700" }],
						"headline-lg-mobile": ["26px", { "lineHeight": "34px", "fontWeight": "700" }],
						"label-button": ["15px", { "lineHeight": "22px", "fontWeight": "600" }],
						"label-badge": ["11px", { "lineHeight": "14px", "letterSpacing": "0.02em", "fontWeight": "700" }],
						"price-lg": ["22px", { "lineHeight": "28px", "fontWeight": "700" }],
						"title-product": ["16px", { "lineHeight": "24px", "fontWeight": "600" }],
						"headline-xl-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "700" }],
						"price-card": ["20px", { "lineHeight": "26px", "fontWeight": "700" }],
						"headline-xl": ["36px", { "lineHeight": "44px", "fontWeight": "700" }]
					}
				}
			}
		};
	';
	wp_add_inline_script( 'phonex-tailwind', $tailwind_config, 'after' );

	// PhoneX CSS Files
	wp_enqueue_style( 'phonex-variables', get_template_directory_uri() . '/assets/css/variables.css', array(), PHONEX_VERSION );
	wp_enqueue_style( 'phonex-header-footer', get_template_directory_uri() . '/assets/css/header-footer.css', array( 'phonex-variables' ), PHONEX_VERSION );
	if ( file_exists( get_template_directory() . '/assets/css/runtime-responsive.css' ) ) {
		wp_enqueue_style( 'phonex-responsive', get_template_directory_uri() . '/assets/css/runtime-responsive.css', array( 'phonex-variables' ), PHONEX_VERSION );
	}
	wp_enqueue_style( 'phonex-style', get_stylesheet_uri(), array( 'phonex-variables' ), PHONEX_VERSION );

	// PhoneX JS Files
	if ( file_exists( get_template_directory() . '/assets/js/route-resolver.js' ) ) {
		wp_enqueue_script( 'phonex-route-resolver', get_template_directory_uri() . '/assets/js/route-resolver.js', array(), PHONEX_VERSION, true );
	}
	if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
		wp_enqueue_script( 'phonex-main', get_template_directory_uri() . '/assets/js/main.js', array(), PHONEX_VERSION, true );
	}

	// Navigation & Comment reply
	wp_enqueue_script( 'phonex-navigation', get_template_directory_uri() . '/js/navigation.js', array(), PHONEX_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'phonex_scripts' );

/**
 * Register widget area.
 */
function phonex_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Cột bên Shop (Sidebar)', 'phonex' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Khu vực bộ lọc sản phẩm trong trang danh mục.', 'phonex' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title text-base font-bold text-gray-900 mb-3">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'phonex_widgets_init' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom database tables for PhoneX (Trade-in, Stores, Warranty, Inventory).
 */
require get_template_directory() . '/inc/database.php';

/**
 * PhoneX Custom REST API Endpoints.
 */
require get_template_directory() . '/inc/rest-api.php';

/**
 * Load WooCommerce compatibility file if WooCommerce is active.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * PhoneX Flash Sale Giờ Vàng Management & Options
 */
require get_template_directory() . '/inc/admin-flashsale.php';

/**
 * PhoneX Mega Promotions Page Management & Options
 */
require get_template_directory() . '/inc/admin-promotions.php';

/**
 * PhoneX TGDD Product Crawler & Importer
 */
require get_template_directory() . '/inc/admin-crawler.php';

/**
 * PhoneX Category SEO & Industry Info (Thông tin ngành hàng chuẩn TGDD)
 */
require get_template_directory() . '/inc/admin-category-seo.php';

/**
 * PhoneX Google SEO & Schema.org Optimization Engine
 */
require get_template_directory() . '/inc/seo.php';

/**
 * PhoneX Buyback & Wholesale Architecture (Module Thu Mua Điện Thoại Chuyên Sâu)
 */
require_once get_template_directory() . '/inc/buyback-database.php';
require_once get_template_directory() . '/inc/buyback-router.php';
require_once get_template_directory() . '/inc/buyback-api.php';
require_once get_template_directory() . '/inc/admin-buyback.php';
require_once get_template_directory() . '/inc/admin-chotot-market.php';
require_once get_template_directory() . '/inc/installment-leads.php';

/**
 * Route /sac-dtdd/ directly to template-chargers.php
 * Route /sac-cap/ directly to template-cables.php
 */
function phonex_charger_route_template( $template ) {
	$request_uri = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
	if ( preg_match( '#/(sac-dtdd|sac-dien-thoai-di-dong|sac-du-phong-dtdd)$#i', $request_uri ) ) {
		$charger_template = get_template_directory() . '/page-templates/template-chargers.php';
		if ( file_exists( $charger_template ) ) {
			return $charger_template;
		}
	}
	if ( preg_match( '#/(sac-cap|cu-sac-cap-sac|cap-sac-dtdd)$#i', $request_uri ) ) {
		$cables_template = get_template_directory() . '/page-templates/template-cables.php';
		if ( file_exists( $cables_template ) ) {
			return $cables_template;
		}
	}
	if ( preg_match( '#/(op-lung-flipcover|op-lung-dien-thoai|op-lung)$#i', $request_uri ) ) {
		$cases_template = get_template_directory() . '/page-templates/template-cases.php';
		if ( file_exists( $cases_template ) ) {
			return $cases_template;
		}
	}
	if ( preg_match( '#/(op-lung-may-tinh-bang|bao-da-ipad|bao-da-tablet)$#i', $request_uri ) ) {
		$tablet_cases_template = get_template_directory() . '/page-templates/template-tablet-cases.php';
		if ( file_exists( $tablet_cases_template ) ) {
			return $tablet_cases_template;
		}
	}
	if ( preg_match( '#/(mieng-dan-camera|kinh-camera|dan-camera)$#i', $request_uri ) ) {
		$camera_template = get_template_directory() . '/page-templates/template-camera-lens.php';
		if ( file_exists( $camera_template ) ) {
			return $camera_template;
		}
	}
	if ( preg_match( '#/(mieng-dan-man-hinh|mieng-dan|kinh-cuong-luc)$#i', $request_uri ) ) {
		$screens_template = get_template_directory() . '/page-templates/template-screen-protectors.php';
		if ( file_exists( $screens_template ) ) {
			return $screens_template;
		}
	}
	if ( preg_match( '#/(hub-chuyen-doi|hub-cap-chuyen-doi)$#i', $request_uri ) ) {
		$adapters_template = get_template_directory() . '/page-templates/template-adapters.php';
		if ( file_exists( $adapters_template ) ) {
			return $adapters_template;
		}
	}
	if ( preg_match( '#/(chuot-may-tinh|chuot-gaming|chuot-bluetooth|chuot-khong-day|chuot-co-day)$#i', $request_uri ) ) {
		$mice_template = get_template_directory() . '/page-templates/template-mice.php';
		if ( file_exists( $mice_template ) ) {
			return $mice_template;
		}
	}
	if ( preg_match( '#/(ban-phim|ban-phim-gaming|ban-phim-bluetooth|ban-phim-co-day|ban-phim-khong-day)$#i', $request_uri ) ) {
		$keyboards_template = get_template_directory() . '/page-templates/template-keyboards.php';
		if ( file_exists( $keyboards_template ) ) {
			return $keyboards_template;
		}
	}
	if ( preg_match( '#/(thiet-bi-mang|router-thiet-bi-mang|router-wifi)$#i', $request_uri ) ) {
		$network_template = get_template_directory() . '/page-templates/template-network-devices.php';
		if ( file_exists( $network_template ) ) {
			return $network_template;
		}
	}
	if ( preg_match( '#/(balo-tui-chong-soc|tui-chong-soc|balo-laptop|tui-xach-laptop)$#i', $request_uri ) ) {
		$backpacks_template = get_template_directory() . '/page-templates/template-backpacks.php';
		if ( file_exists( $backpacks_template ) ) {
			return $backpacks_template;
		}
	}
	if ( preg_match( '#/(tui-dung-phu-kien|tui-phu-kien|tui-deo-cheo)$#i', $request_uri ) ) {
		$accessory_bags_template = get_template_directory() . '/page-templates/template-accessory-bags.php';
		if ( file_exists( $accessory_bags_template ) ) {
			return $accessory_bags_template;
		}
	}
	if ( preg_match( '#/(tui-dung-airpods|op-airpods|case-airpods)$#i', $request_uri ) ) {
		$airpods_cases_template = get_template_directory() . '/page-templates/template-airpods-cases.php';
		if ( file_exists( $airpods_cases_template ) ) {
			return $airpods_cases_template;
		}
	}
	if ( preg_match( '#/(quat-mini|quat-cam-tay|quat-tich-dien)$#i', $request_uri ) ) {
		$mini_fans_template = get_template_directory() . '/page-templates/template-mini-fans.php';
		if ( file_exists( $mini_fans_template ) ) {
			return $mini_fans_template;
		}
	}
	if ( preg_match( '#/(dtdd)$#i', $request_uri ) ) {
		global $wp_query;
		if ( $wp_query ) {
			$wp_query->is_404 = false;
		}
		status_header( 200 );
		$phones_template = get_template_directory() . '/page-templates/template-phones.php';
		if ( file_exists( $phones_template ) ) {
			return $phones_template;
		}
	}
	if ( preg_match( '#/(kho-may-cu|dien-thoai-cu|may-doi-tra|may-doi-tra/dtdd|dtdd-cu|may-cu-gia-tot)$#i', $request_uri ) ) {
		global $wp_query;
		if ( $wp_query ) {
			$wp_query->is_404 = false;
		}
		status_header( 200 );
		$used_phones_template = get_template_directory() . '/page-templates/template-used-phones.php';
		if ( file_exists( $used_phones_template ) ) {
			return $used_phones_template;
		}
	}
	if ( preg_match( '#/(tra-gop|tra-gop-dien-thoai|mua-tra-gop|bang-tinh-tra-gop)$#i', $request_uri ) ) {
		global $wp_query;
		if ( $wp_query ) {
			$wp_query->is_404 = false;
		}
		status_header( 200 );
		$installment_template = get_template_directory() . '/page-templates/template-installment.php';
		if ( file_exists( $installment_template ) ) {
			return $installment_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'phonex_charger_route_template', 99 );

function phonex_fix_custom_routes_404() {
	$request_uri = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
	if ( preg_match( '#/(dtdd|kho-may-cu|dien-thoai-cu|may-doi-tra|may-doi-tra/dtdd|dtdd-cu|may-cu-gia-tot|tra-gop|tra-gop-dien-thoai|mua-tra-gop|bang-tinh-tra-gop)$#i', $request_uri ) ) {
		global $wp_query;
		if ( $wp_query ) {
			$wp_query->is_404 = false;
		}
		status_header( 200 );
	}
}
add_action( 'template_redirect', 'phonex_fix_custom_routes_404', 1 );

