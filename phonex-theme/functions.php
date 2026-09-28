<?php
/**
 * PhoneX functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PhoneX
 */

if ( ! defined( 'PHONEX_VERSION' ) ) {
	define( 'PHONEX_VERSION', '1.0.0' );
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
			'primary'   => esc_html__( 'Thanh điều hướng chính (Header)', 'phonex' ),
			'mobile'    => esc_html__( 'Menu ứng dụng di động (Mobile App)', 'phonex' ),
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
 * Enqueue scripts and styles.
 */
function phonex_scripts() {
	// Google Fonts & Icons
	wp_enqueue_style( 'phonex-google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'phonex-material-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', array(), null );

	// Tailwind CSS CDN for Stitch Design Tokens
	wp_enqueue_script( 'phonex-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );

	// Inline Tailwind Configuration matching Google Stitch design tokens
	$tailwind_config = '
		tailwind.config = {
			darkMode: "class",
			theme: {
				extend: {
					colors: {
						"primary": "#b7000c",
						"primary-hover": "#C90010",
						"primary-container": "#e60012",
						"surface": "#f8f9fb",
						"surface-pure": "#FFFFFF",
						"surface-container": "#edeef0",
						"surface-container-low": "#f2f4f6",
						"surface-container-high": "#e7e8ea",
						"on-surface": "#191c1e",
						"border-subtle": "#E5E7EB",
						"text-main": "#222222"
					},
					fontFamily: {
						sans: ["Plus Jakarta Sans", "system-ui", "sans-serif"]
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
