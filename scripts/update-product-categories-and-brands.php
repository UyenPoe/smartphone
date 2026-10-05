<?php
/**
 * Update Categories and Product Brands for All WooCommerce Products
 */

require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

echo "=== 1. CLEANING UP ERRONEOUS CATEGORIES ===\n";
// Delete bad terms "23", "34", "80" if they exist
$bad_slugs = array( '23', '34', '80' );
foreach ( $bad_slugs as $slug ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term ) {
		echo "Deleting erroneous term: ID {$term->term_id} (Name: {$term->name}, Slug: {$term->slug})\n";
		wp_delete_term( $term->term_id, 'product_cat' );
	}
}

echo "\n=== 2. ENSURING TAXONOMY TERMS EXIST ===\n";

// Ensure Categories exist
$cats_to_ensure = array(
	'dien-thoai' => array( 'name' => 'Điện thoại', 'parent' => 0 ),
	'phu-kien'   => array( 'name' => 'Phụ kiện', 'parent' => 0 ),
	'sac-dtdd'   => array( 'name' => 'Sạc Điện Thoại Di Động & Pin Dự Phòng', 'parent' => 'phu-kien' ),
	'sac-du-phong' => array( 'name' => 'Sạc dự phòng', 'parent' => 'phu-kien' ),
	'sac-cap'    => array( 'name' => 'Củ sạc, Cáp sạc', 'parent' => 'phu-kien' ),
	'loa'        => array( 'name' => 'Loa', 'parent' => 'phu-kien' ),
	'micro'      => array( 'name' => 'Micro', 'parent' => 'phu-kien' ),
	'tai-nghe-bluetooth' => array( 'name' => 'Tai nghe Bluetooth', 'parent' => 'phu-kien' ),
	'chuot-may-tinh' => array( 'name' => 'Chuột máy tính', 'parent' => 'phu-kien' ),
	'ban-phim'   => array( 'name' => 'Bàn phím', 'parent' => 'phu-kien' ),
	'camera-giam-sat' => array( 'name' => 'Camera Giám Sát', 'parent' => 'phu-kien' ),
	'apple'      => array( 'name' => 'Apple iPhone', 'parent' => 'dien-thoai' ),
	'samsung'    => array( 'name' => 'Samsung Galaxy', 'parent' => 'dien-thoai' ),
	'xiaomi'     => array( 'name' => 'Xiaomi', 'parent' => 'dien-thoai' ),
	'oppo'       => array( 'name' => 'OPPO', 'parent' => 'dien-thoai' ),
	'vivo'       => array( 'name' => 'vivo', 'parent' => 'dien-thoai' ),
	'realme'     => array( 'name' => 'realme', 'parent' => 'dien-thoai' ),
	'motorola'   => array( 'name' => 'Motorola', 'parent' => 'dien-thoai' ),
	'nothing'    => array( 'name' => 'Nothing Phone', 'parent' => 'dien-thoai' ),
);

$cat_id_map = array();
foreach ( $cats_to_ensure as $c_slug => $c_info ) {
	$term = get_term_by( 'slug', $c_slug, 'product_cat' );
	$parent_id = 0;
	if ( ! empty( $c_info['parent'] ) && isset( $cat_id_map[ $c_info['parent'] ] ) ) {
		$parent_id = $cat_id_map[ $c_info['parent'] ];
	} elseif ( ! empty( $c_info['parent'] ) ) {
		$p_term = get_term_by( 'slug', $c_info['parent'], 'product_cat' );
		if ( $p_term ) {
			$parent_id = $p_term->term_id;
		}
	}

	if ( ! $term ) {
		$inserted = wp_insert_term( $c_info['name'], 'product_cat', array(
			'slug'   => $c_slug,
			'parent' => $parent_id,
		) );
		$cat_id_map[ $c_slug ] = is_array( $inserted ) ? $inserted['term_id'] : $inserted;
		echo "Created product_cat: {$c_info['name']} (Slug: {$c_slug}, ID: {$cat_id_map[$c_slug]})\n";
	} else {
		$cat_id_map[ $c_slug ] = $term->term_id;
		// Update parent if needed
		if ( $parent_id && $term->parent !== $parent_id ) {
			wp_update_term( $term->term_id, 'product_cat', array( 'parent' => $parent_id ) );
		}
	}
}

// Ensure Brands exist in taxonomy 'product_brand'
$brands_list = array(
	'Apple', 'Samsung', 'Xiaomi', 'OPPO', 'vivo', 'realme', 'Motorola', 'Nothing',
	'Anker', 'Baseus', 'Ugreen', 'Xmobile', 'AVA+', 'Hydrus', 'Mazer', 'AUKEY', 'BMX', 'Belkin',
	'JBL', 'Marshall', 'Sony', 'Harman Kardon', 'Edifier', 'Nanomax', 'Boya', 'Rode', 'Shure',
	'DJI', 'HyperX', 'SD', 'Excelvan', 'Logitech', 'Keychron', 'Ezviz', 'Mipow', 'Innostyle'
);

$brand_id_map = array();
foreach ( $brands_list as $b_name ) {
	$term = get_term_by( 'name', $b_name, 'product_brand' );
	if ( ! $term ) {
		$inserted = wp_insert_term( $b_name, 'product_brand' );
		$brand_id_map[ $b_name ] = is_array( $inserted ) ? $inserted['term_id'] : $inserted;
		echo "Created product_brand: {$b_name} (ID: {$brand_id_map[$b_name]})\n";
	} else {
		$brand_id_map[ $b_name ] = $term->term_id;
	}
}

echo "\n=== 3. UPDATING PRODUCTS ===\n";

$products = get_posts( array(
	'post_type'      => 'product',
	'posts_per_page' => -1,
	'orderby'        => 'ID',
	'order'          => 'ASC',
) );

$count_updated = 0;

foreach ( $products as $prod ) {
	$pid   = $prod->ID;
	$title = $prod->post_title;
	$title_lower = mb_strtolower( $title, 'UTF-8' );

	$assign_cats = array();
	$assign_brand = '';

	// 1. Detect Brand
	if ( preg_match( '/\b(iphone|apple|airpods|watch|ipad)\b/iu', $title ) ) {
		$assign_brand = 'Apple';
	} elseif ( preg_match( '/\b(samsung|galaxy)\b/iu', $title ) ) {
		$assign_brand = 'Samsung';
	} elseif ( preg_match( '/\b(xiaomi|redmi)\b/iu', $title ) ) {
		$assign_brand = 'Xiaomi';
	} elseif ( preg_match( '/\b(oppo|find x|reno)\b/iu', $title ) ) {
		$assign_brand = 'OPPO';
	} elseif ( preg_match( '/\b(vivo)\b/iu', $title ) ) {
		$assign_brand = 'vivo';
	} elseif ( preg_match( '/\b(realme)\b/iu', $title ) ) {
		$assign_brand = 'realme';
	} elseif ( preg_match( '/\b(motorola|razr)\b/iu', $title ) ) {
		$assign_brand = 'Motorola';
	} elseif ( preg_match( '/\b(nothing)\b/iu', $title ) ) {
		$assign_brand = 'Nothing';
	} elseif ( preg_match( '/\b(anker|zolo|maggo)\b/iu', $title ) ) {
		$assign_brand = 'Anker';
	} elseif ( preg_match( '/\b(baseus|qpow|comet)\b/iu', $title ) ) {
		$assign_brand = 'Baseus';
	} elseif ( preg_match( '/\b(ugreen|nexode)\b/iu', $title ) ) {
		$assign_brand = 'Ugreen';
	} elseif ( preg_match( '/\b(xmobile|pocketgo|minigo|carryon)\b/iu', $title ) ) {
		$assign_brand = 'Xmobile';
	} elseif ( preg_match( '/\b(ava\+|ava)\b/iu', $title ) ) {
		$assign_brand = 'AVA+';
	} elseif ( preg_match( '/\b(hydrus)\b/iu', $title ) ) {
		$assign_brand = 'Hydrus';
	} elseif ( preg_match( '/\b(innostyle|powermag)\b/iu', $title ) ) {
		$assign_brand = 'Innostyle';
	} elseif ( preg_match( '/\b(mazer)\b/iu', $title ) ) {
		$assign_brand = 'Mazer';
	} elseif ( preg_match( '/\b(aukey)\b/iu', $title ) ) {
		$assign_brand = 'AUKEY';
	} elseif ( preg_match( '/\b(bmx)\b/iu', $title ) ) {
		$assign_brand = 'BMX';
	} elseif ( preg_match( '/\b(belkin)\b/iu', $title ) ) {
		$assign_brand = 'Belkin';
	} elseif ( preg_match( '/\b(jbl)\b/iu', $title ) ) {
		$assign_brand = 'JBL';
	} elseif ( preg_match( '/\b(marshall)\b/iu', $title ) ) {
		$assign_brand = 'Marshall';
	} elseif ( preg_match( '/\b(sony)\b/iu', $title ) ) {
		$assign_brand = 'Sony';
	} elseif ( preg_match( '/\b(harman kardon)\b/iu', $title ) ) {
		$assign_brand = 'Harman Kardon';
	} elseif ( preg_match( '/\b(edifier)\b/iu', $title ) ) {
		$assign_brand = 'Edifier';
	} elseif ( preg_match( '/\b(nanomax)\b/iu', $title ) ) {
		$assign_brand = 'Nanomax';
	} elseif ( preg_match( '/\b(boya)\b/iu', $title ) ) {
		$assign_brand = 'Boya';
	} elseif ( preg_match( '/\b(rode)\b/iu', $title ) ) {
		$assign_brand = 'Rode';
	} elseif ( preg_match( '/\b(shure)\b/iu', $title ) ) {
		$assign_brand = 'Shure';
	} elseif ( preg_match( '/\b(dji)\b/iu', $title ) ) {
		$assign_brand = 'DJI';
	} elseif ( preg_match( '/\b(hyperx)\b/iu', $title ) ) {
		$assign_brand = 'HyperX';
	} elseif ( preg_match( '/\b(sd-10)\b/iu', $title ) ) {
		$assign_brand = 'SD';
	} elseif ( preg_match( '/\b(excelvan)\b/iu', $title ) ) {
		$assign_brand = 'Excelvan';
	} elseif ( preg_match( '/\b(logitech)\b/iu', $title ) ) {
		$assign_brand = 'Logitech';
	} elseif ( preg_match( '/\b(keychron)\b/iu', $title ) ) {
		$assign_brand = 'Keychron';
	} elseif ( preg_match( '/\b(ezviz)\b/iu', $title ) ) {
		$assign_brand = 'Ezviz';
	} elseif ( preg_match( '/\b(mipow)\b/iu', $title ) ) {
		$assign_brand = 'Mipow';
	}

	// 2. Detect Categories
	$is_charger = ( strpos( $title_lower, 'sạc' ) !== false || strpos( $title_lower, 'dự phòng' ) !== false );
	$is_phone = ( strpos( $title_lower, 'phone' ) !== false || strpos( $title_lower, 'galaxy' ) !== false || strpos( $title_lower, 'redmi' ) !== false || strpos( $title_lower, 'oppo' ) !== false || strpos( $title_lower, 'vivo' ) !== false || strpos( $title_lower, 'realme' ) !== false || strpos( $title_lower, 'motorola' ) !== false || strpos( $title_lower, 'nothing' ) !== false );

	// Disambiguate charger vs phone
	if ( $is_charger ) {
		$assign_cats[] = $cat_id_map['sac-dtdd'];
		$assign_cats[] = $cat_id_map['sac-du-phong'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'loa' ) !== false ) {
		$assign_cats[] = $cat_id_map['loa'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'micro' ) !== false ) {
		$assign_cats[] = $cat_id_map['micro'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'tai nghe' ) !== false ) {
		$assign_cats[] = $cat_id_map['tai-nghe-bluetooth'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'chuột' ) !== false ) {
		$assign_cats[] = $cat_id_map['chuot-may-tinh'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'bàn phím' ) !== false ) {
		$assign_cats[] = $cat_id_map['ban-phim'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( strpos( $title_lower, 'camera' ) !== false ) {
		$assign_cats[] = $cat_id_map['camera-giam-sat'];
		$assign_cats[] = $cat_id_map['phu-kien'];
	} elseif ( $is_phone ) {
		$assign_cats[] = $cat_id_map['dien-thoai'];
		if ( 'Apple' === $assign_brand && isset( $cat_id_map['apple'] ) ) $assign_cats[] = $cat_id_map['apple'];
		elseif ( 'Samsung' === $assign_brand && isset( $cat_id_map['samsung'] ) ) $assign_cats[] = $cat_id_map['samsung'];
		elseif ( 'Xiaomi' === $assign_brand && isset( $cat_id_map['xiaomi'] ) ) $assign_cats[] = $cat_id_map['xiaomi'];
		elseif ( 'OPPO' === $assign_brand && isset( $cat_id_map['oppo'] ) ) $assign_cats[] = $cat_id_map['oppo'];
		elseif ( 'vivo' === $assign_brand && isset( $cat_id_map['vivo'] ) ) $assign_cats[] = $cat_id_map['vivo'];
		elseif ( 'realme' === $assign_brand && isset( $cat_id_map['realme'] ) ) $assign_cats[] = $cat_id_map['realme'];
		elseif ( 'Motorola' === $assign_brand && isset( $cat_id_map['motorola'] ) ) $assign_cats[] = $cat_id_map['motorola'];
		elseif ( 'Nothing' === $assign_brand && isset( $cat_id_map['nothing'] ) ) $assign_cats[] = $cat_id_map['nothing'];
	} else {
		$assign_cats[] = $cat_id_map['phu-kien'];
	}

	// Filter out any 0 or empty IDs and cast to integer
	$assign_cats = array_unique( array_filter( array_map( 'intval', $assign_cats ) ) );

	// Update Categories
	if ( ! empty( $assign_cats ) ) {
		wp_set_object_terms( $pid, $assign_cats, 'product_cat' );
	}

	// Update Product Brand
	if ( ! empty( $assign_brand ) ) {
		wp_set_object_terms( $pid, $assign_brand, 'product_brand' );
		update_post_meta( $pid, '_brand', $assign_brand );
	}

	$cat_names = wp_get_post_terms( $pid, 'product_cat', array( 'fields' => 'names' ) );
	$brand_names = wp_get_post_terms( $pid, 'product_brand', array( 'fields' => 'names' ) );

	echo "ID {$pid} | " . mb_substr( $title, 0, 38 ) . "... | Cats: [" . implode( ', ', $cat_names ) . "] | Brand: [" . implode( ', ', $brand_names ) . "]\n";
	$count_updated++;
}

echo "\nSuccessfully updated {$count_updated} products with proper Categories & Product Brands!\n";
