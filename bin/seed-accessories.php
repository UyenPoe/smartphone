<?php
/**
 * Seed Accessories and Categories into WooCommerce Database
 */
require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

// 1. Create realme if not exists
if (!term_exists('realme', 'product_cat')) {
    wp_insert_term('realme', 'product_cat', ['slug' => 'realme', 'description' => 'Điện thoại realme chính hãng giá tốt']);
    echo "Created category realme\n";
}

// 2. Create parent category 'Phụ kiện'
$parent_term = term_exists('phu-kien', 'product_cat');
if (!$parent_term) {
    $parent_term = wp_insert_term('Phụ kiện', 'product_cat', [
        'slug' => 'phu-kien',
        'description' => 'Hệ thống phụ kiện smartphone, củ cáp sạc, tai nghe, pin dự phòng chính hãng'
    ]);
    $parent_id = is_array($parent_term) ? (int)$parent_term['term_id'] : (int)$parent_term;
    echo "Created parent category Phụ kiện ID: {$parent_id}\n";
} else {
    $parent_id = is_array($parent_term) ? (int)$parent_term['term_id'] : (int)$parent_term;
    echo "Found existing Phụ kiện ID: {$parent_id}\n";
}

// 3. Subcategories inspired by TGDD
$tgdd_subcats = [
    ['name' => 'Củ sạc, Cáp sạc', 'slug' => 'sac-cap', 'desc' => 'Sạc nhanh 20W - 100W GaN, Type-C, Lightning'],
    ['name' => 'Pin sạc dự phòng', 'slug' => 'pin-du-phong', 'desc' => 'Pin 10.000mAh, 20.000mAh, Không dây MagSafe'],
    ['name' => 'Tai nghe Bluetooth & Loa', 'slug' => 'tai-nghe-loa', 'desc' => 'AirPods, Galaxy Buds, Loa JBL Marshall'],
    ['name' => 'Ốp lưng & Bao da', 'slug' => 'op-lung-bao-da', 'desc' => 'Ốp chống sốc iPhone, Samsung, UAG Spigen'],
    ['name' => 'Kính cường lực & Miếng dán', 'slug' => 'kinh-cuong-luc', 'desc' => 'Kính Mipow Kingbull, Chống nhìn trộm'],
    ['name' => 'Phụ kiện Apple chính hãng', 'slug' => 'phu-kien-apple', 'desc' => 'Củ sạc Apple, Dây sạc Apple, Bút Pencil'],
    ['name' => 'Giá đỡ & Gậy chụp ảnh', 'slug' => 'gia-do-gay-chup-anh', 'desc' => 'Gimbal chống rung, Gậy selfie, Giá đỡ ô tô']
];

foreach ($tgdd_subcats as $sub) {
    if (!term_exists($sub['slug'], 'product_cat')) {
        wp_insert_term($sub['name'], 'product_cat', [
            'slug' => $sub['slug'],
            'description' => $sub['desc'],
            'parent' => $parent_id
        ]);
        echo "Created subcategory: {$sub['name']}\n";
    } else {
        echo "Already exists: {$sub['name']}\n";
    }
}

// 4. Create sample accessory products
$sample_accessories = [
    [
        'title' => 'Củ Sạc Nhanh Apple 20W Type-C - Chính Hãng Apple VN/A',
        'slug' => 'cu-sac-nhanh-apple-20w-type-c-chinh-hang',
        'price' => '490000',
        'sale_price' => '450000',
        'cat_slugs' => ['phu-kien', 'sac-cap', 'phu-kien-apple'],
        'img' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=600&auto=format&fit=crop&q=80',
        'desc' => 'Củ sạc nhanh Apple 20W Type-C chính hãng Apple VN/A, tương thích iPhone 12 đến iPhone 16 Pro Max.'
    ],
    [
        'title' => 'Tai Nghe Apple AirPods Pro 2 MagSafe USB-C (2024)',
        'slug' => 'tai-nghe-apple-airpods-pro-2-magsafe-usb-c',
        'price' => '5690000',
        'sale_price' => '5190000',
        'cat_slugs' => ['phu-kien', 'tai-nghe-loa', 'phu-kien-apple'],
        'img' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=600&auto=format&fit=crop&q=80',
        'desc' => 'AirPods Pro 2 cổng sạc USB-C mới nhất, chống ồn chủ động ANC 2X, chuẩn âm thanh không gian Spatial Audio.'
    ],
    [
        'title' => 'Pin Sạc Dự Phòng Anker MagGo Qi2 10.000mAh Hỗ Trợ MagSafe 15W',
        'slug' => 'pin-sac-du-phong-anker-maggo-qi2-10000mah',
        'price' => '1290000',
        'sale_price' => '990000',
        'cat_slugs' => ['phu-kien', 'pin-du-phong'],
        'img' => 'https://images.unsplash.com/photo-1609592426815-5645a2789642?w=600&auto=format&fit=crop&q=80',
        'desc' => 'Pin dự phòng Anker chuẩn sạc không dây Qi2 mới nhất 15W cho iPhone, màn hình LED hiển thị % pin thông minh.'
    ],
    [
        'title' => 'Kính Cường Lực Mipow Kingbull HD Chống Nhìn Trộm iPhone 16 Pro Max',
        'slug' => 'kinh-cuong-luc-mipow-kingbull-hd-iphone-16-pro-max',
        'price' => '420000',
        'sale_price' => '350000',
        'cat_slugs' => ['phu-kien', 'kinh-cuong-luc'],
        'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600&auto=format&fit=crop&q=80',
        'desc' => 'Kính cường lực Mipow Kingbull chống trầy xước chuẩn 9H, vát cạnh 3D, tính năng bảo mật chống nhìn trộm góc 28 độ.'
    ]
];

foreach ($sample_accessories as $p) {
    $existing = get_page_by_path($p['slug'], OBJECT, 'product');
    if (!$existing) {
        $product = new WC_Product_Simple();
        $product->set_name($p['title']);
        $product->set_slug($p['slug']);
        $product->set_regular_price($p['price']);
        if (!empty($p['sale_price'])) {
            $product->set_sale_price($p['sale_price']);
            $product->set_price($p['sale_price']);
        } else {
            $product->set_price($p['price']);
        }
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_short_description($p['desc']);
        $product->set_description($p['desc']);
        $product->set_manage_stock(true);
        $product->set_stock_quantity(50);
        $product->set_stock_status('instock');

        $term_ids = [];
        foreach ($p['cat_slugs'] as $cslug) {
            $t = get_term_by('slug', $cslug, 'product_cat');
            if ($t) {
                $term_ids[] = (int)$t->term_id;
            }
        }
        $product->set_category_ids($term_ids);
        $pid = $product->save();
        echo "Created accessory product ID: {$pid} - {$p['title']}\n";
    } else {
        echo "Product already exists: {$p['title']}\n";
    }
}
echo "Seeding completed successfully!\n";
