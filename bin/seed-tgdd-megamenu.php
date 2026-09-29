<?php
/**
 * Seed full TGDD Accessories Mega Menu taxonomy into WooCommerce database
 */
require_once '/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php';

$pk = get_term_by('slug', 'phu-kien', 'product_cat');
if (!$pk) {
    $inserted = wp_insert_term('Phụ kiện', 'product_cat', ['slug' => 'phu-kien']);
    $pk_id = is_array($inserted) ? $inserted['term_id'] : $inserted->term_id;
} else {
    $pk_id = $pk->term_id;
}

$groups = [
    'phu-kien-di-dong' => [
        'name' => 'Phụ kiện di động',
        'items' => [
            ['name' => 'Sạc dự phòng', 'slug' => 'sac-du-phong'],
            ['name' => 'Sạc, cáp', 'slug' => 'sac-cap'],
            ['name' => 'Ốp lưng điện thoại', 'slug' => 'op-lung-dien-thoai'],
            ['name' => 'Ốp lưng máy tính bảng', 'slug' => 'op-lung-may-tinh-bang'],
            ['name' => 'Miếng dán', 'slug' => 'mieng-dan'],
            ['name' => 'Miếng dán Camera', 'slug' => 'mieng-dan-camera'],
            ['name' => 'Túi đựng AirPods', 'slug' => 'tui-dung-airpods'],
            ['name' => 'Quạt mini', 'slug' => 'quat-mini'],
            ['name' => 'Bút tablet', 'slug' => 'but-tablet'],
            ['name' => 'Giá đỡ điện thoại/laptop', 'slug' => 'gia-do-dien-thoai-laptop'],
            ['name' => 'Dây đeo điện thoại', 'slug' => 'day-deo-dien-thoai'],
            ['name' => 'Ống kính điện thoại', 'slug' => 'ong-kinh-dien-thoai'],
        ]
    ],
    'phu-kien-laptop-pc' => [
        'name' => 'Phụ kiện laptop, PC',
        'items' => [
            ['name' => 'Hub, cáp chuyển đổi', 'slug' => 'hub-cap-chuyen-doi'],
            ['name' => 'Chuột máy tính', 'slug' => 'chuot-may-tinh'],
            ['name' => 'Bàn phím', 'slug' => 'ban-phim'],
            ['name' => 'Router - Thiết bị mạng', 'slug' => 'router-thiet-bi-mang'],
            ['name' => 'Balo, túi chống sốc', 'slug' => 'balo-tui-chong-soc'],
            ['name' => 'Túi đựng phụ kiện', 'slug' => 'tui-dung-phu-kien'],
            ['name' => 'Phủ phím laptop', 'slug' => 'phu-phim-laptop'],
            ['name' => 'Phần mềm', 'slug' => 'phan-mem'],
            ['name' => 'Giá treo màn hình', 'slug' => 'gia-treo-man-hinh'],
            ['name' => 'Miếng lót chuột', 'slug' => 'mieng-lot-chuot'],
            ['name' => 'Bảng vẽ điện tử', 'slug' => 'bang-ve-dien-tu'],
        ]
    ],
    'thiet-bi-nghe-nhin-luu-tru' => [
        'name' => 'Thiết bị nghe nhìn, lưu trữ, thu âm',
        'items' => [
            ['name' => 'Tai nghe Bluetooth', 'slug' => 'tai-nghe-bluetooth'],
            ['name' => 'Tai nghe dây', 'slug' => 'tai-nghe-day'],
            ['name' => 'Tai nghe chụp tai', 'slug' => 'tai-nghe-chup-tai'],
            ['name' => 'Tai nghe thể thao', 'slug' => 'tai-nghe-the-thao'],
            ['name' => 'Loa', 'slug' => 'loa'],
            ['name' => 'Micro', 'slug' => 'micro'],
            ['name' => 'Máy chiếu', 'slug' => 'may-chieu'],
            ['name' => 'Kính thông minh', 'slug' => 'kinh-thong-minh'],
            ['name' => 'Ổ cứng', 'slug' => 'o-cung'],
            ['name' => 'Thẻ nhớ', 'slug' => 'the-nho'],
            ['name' => 'USB', 'slug' => 'usb'],
        ]
    ],
    'camera' => [
        'name' => 'Camera',
        'items' => [
            ['name' => 'Camera Giám Sát', 'slug' => 'camera-giam-sat'],
            ['name' => 'Camera trong nhà', 'slug' => 'camera-trong-nha'],
            ['name' => 'Camera ngoài trời', 'slug' => 'camera-ngoai-troi'],
            ['name' => 'Camera Năng Lượng Mặt Trời', 'slug' => 'camera-nang-luong-mat-troi'],
            ['name' => 'Camera 4G', 'slug' => 'camera-4g'],
            ['name' => 'Chuông cửa Camera', 'slug' => 'chuong-cua-camera'],
            ['name' => 'Webcam', 'slug' => 'webcam'],
        ]
    ],
];

foreach ($groups as $g_slug => $group) {
    $parent = get_term_by('slug', $g_slug, 'product_cat');
    if (!$parent) {
        $res = wp_insert_term($group['name'], 'product_cat', [
            'slug' => $g_slug,
            'parent' => $pk_id
        ]);
        $parent_id = is_array($res) ? $res['term_id'] : $res->term_id;
        echo "Created Group: {$group['name']} (ID: {$parent_id})\n";
    } else {
        $parent_id = $parent->term_id;
        echo "Group exists: {$group['name']} (ID: {$parent_id})\n";
    }

    foreach ($group['items'] as $item) {
        $t = get_term_by('slug', $item['slug'], 'product_cat');
        if (!$t) {
            $r = wp_insert_term($item['name'], 'product_cat', [
                'slug' => $item['slug'],
                'parent' => $parent_id
            ]);
            $sub_id = is_array($r) ? $r['term_id'] : $r->term_id;
            echo "  + Created: {$item['name']} (ID: {$sub_id})\n";
        } else {
            wp_update_term($t->term_id, 'product_cat', ['parent' => $parent_id]);
            echo "  = Exists: {$item['name']} (ID: {$t->term_id})\n";
        }
    }
}
echo "Done seeding TGDD Mega Menu categories!\n";
