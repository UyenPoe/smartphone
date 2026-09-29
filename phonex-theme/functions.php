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
	wp_enqueue_style( 'phonex-google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'phonex-material-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', array(), null );

	// Tailwind CSS CDN
	wp_enqueue_script( 'phonex-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );

	// Complete Stitch Tailwind Configuration matching all 46 UI pages
	$tailwind_config = '
		tailwind.config = {
			darkMode: "class",
			theme: {
				extend: {
					colors: {
						"error-container": "#ffdad6",
						"border-subtle": "#E5E7EB",
						"surface-container": "#edeef0",
						"primary-hover": "#C90010",
						"surface-container-lowest": "#ffffff",
						"inverse-on-surface": "#f0f1f3",
						"outline": "#946e69",
						"background": "#f8f9fb",
						"secondary-fixed-dim": "#c8c6c5",
						"on-tertiary-fixed": "#1b1c1c",
						"surface-container-high": "#e7e8ea",
						"tertiary-container": "#727272",
						"secondary-container": "#e5e2e1",
						"on-tertiary-fixed-variant": "#464747",
						"on-background": "#191c1e",
						"secondary-fixed": "#e5e2e1",
						"on-primary-fixed-variant": "#930007",
						"surface-container-low": "#f2f4f6",
						"inverse-primary": "#ffb4aa",
						"on-surface": "#191c1e",
						"surface-container-highest": "#e1e2e4",
						"outline-variant": "#e9bcb6",
						"tertiary-fixed": "#e4e2e2",
						"surface-variant": "#e1e2e4",
						"on-surface-variant": "#5f3f3b",
						"on-secondary-fixed-variant": "#474646",
						"on-secondary": "#ffffff",
						"surface-tint": "#c0000d",
						"on-error": "#ffffff",
						"inverse-surface": "#2e3132",
						"text-main": "#222222",
						"surface": "#f8f9fb",
						"surface-pure": "#FFFFFF",
						"on-primary-container": "#fff7f6",
						"on-primary-fixed": "#410001",
						"on-secondary-fixed": "#1c1b1b",
						"tertiary-fixed-dim": "#c7c6c6",
						"primary-container": "#e60012",
						"error": "#ba1a1a",
						"primary": "#b7000c",
						"on-error-container": "#93000a",
						"on-primary": "#ffffff",
						"on-secondary-container": "#656464",
						"secondary": "#5f5e5e",
						"tertiary": "#595a5a",
						"surface-dim": "#d9dadc",
						"primary-fixed": "#ffdad5",
						"primary-fixed-dim": "#ffb4aa",
						"on-tertiary": "#ffffff",
						"on-tertiary-container": "#faf8f8",
						"surface-bright": "#f8f9fb"
					},
					borderRadius: {
						"DEFAULT": "0.25rem",
						"lg": "0.5rem",
						"xl": "0.75rem",
						"full": "9999px"
					},
					spacing: {
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
						"sans": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"body-sm": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-sm": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"body-regular": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"price-strikethrough": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-lg": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-md": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-lg-mobile": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"label-button": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"label-badge": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"price-lg": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"title-product": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-xl-mobile": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"price-card": ["Plus Jakarta Sans", "system-ui", "sans-serif"],
						"headline-xl": ["Plus Jakarta Sans", "system-ui", "sans-serif"]
					},
					fontSize: {
						"body-sm": ["13px", { "lineHeight": "18px", "fontWeight": "400" }],
						"headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
						"body-regular": ["15px", { "lineHeight": "22px", "fontWeight": "400" }],
						"price-strikethrough": ["13px", { "lineHeight": "18px", "fontWeight": "400" }],
						"headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "700" }],
						"headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
						"headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
						"label-button": ["14px", { "lineHeight": "20px", "fontWeight": "600" }],
						"label-badge": ["11px", { "lineHeight": "14px", "letterSpacing": "0.02em", "fontWeight": "700" }],
						"price-lg": ["22px", { "lineHeight": "28px", "fontWeight": "700" }],
						"title-product": ["16px", { "lineHeight": "24px", "fontWeight": "600" }],
						"headline-xl-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "700" }],
						"price-card": ["18px", { "lineHeight": "24px", "fontWeight": "700" }],
						"headline-xl": ["40px", { "lineHeight": "48px", "fontWeight": "700" }]
					}
				}
			}
		};
	';
	wp_add_inline_script( 'phonex-tailwind', $tailwind_config, 'after' );

	// PhoneX CSS Files
	wp_enqueue_style( 'phonex-header-footer', get_template_directory_uri() . '/assets/css/header-footer.css', array(), PHONEX_VERSION );
	if ( file_exists( get_template_directory() . '/assets/css/runtime-responsive.css' ) ) {
		wp_enqueue_style( 'phonex-responsive', get_template_directory_uri() . '/assets/css/runtime-responsive.css', array(), PHONEX_VERSION );
	}
	wp_enqueue_style( 'phonex-style', get_stylesheet_uri(), array(), PHONEX_VERSION );

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

