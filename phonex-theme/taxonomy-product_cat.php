<?php
/**
 * Master Taxonomy Template for WooCommerce product_cat
 *
 * Automatically delegates to dedicated templates:
 * - Phone categories -> template-phones.php
 * - Used phone categories -> template-used-phones.php
 * - Accessories & all subcategories (loa, micro, tai nghe, sạc cáp...) -> template-accessories.php
 *
 * @package PhoneX
 */

$term = get_queried_object();
$slug = ( $term && ! is_wp_error( $term ) ) ? $term->slug : '';

if ( in_array( $slug, array( 'dien-thoai', 'smartphones', 'apple', 'apple-iphone', 'samsung', 'samsung-galaxy', 'xiaomi', 'oppo', 'vivo', 'realme', 'motorola', 'nothing-phone' ), true ) ) {
	include get_template_directory() . '/page-templates/template-phones.php';
	return;
}

if ( in_array( $slug, array( 'used', 'may-cu-99', 'dien-thoai-cu' ), true ) ) {
	include get_template_directory() . '/page-templates/template-used-phones.php';
	return;
}

if ( in_array( $slug, array( 'sac-dtdd', 'sac-du-phong', 'sac-cap', 'pin-du-phong', 'sac' ), true ) ) {
	include get_template_directory() . '/page-templates/template-chargers.php';
	return;
}

// All accessories, audio, camera, laptop accessories, etc.
include get_template_directory() . '/page-templates/template-accessories.php';
