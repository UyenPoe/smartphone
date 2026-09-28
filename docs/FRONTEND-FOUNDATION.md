# Frontend Foundation

## Mục tiêu
Chuẩn hóa lớp dùng chung trước khi chuyển PhoneX sang WordPress/WooCommerce. Màn hình Stitch vẫn là nguồn đối chiếu hình ảnh.

## Dữ liệu
- `data/products.json`: schema sản phẩm mẫu.
- `data/stores.json`: schema cửa hàng mẫu.
- `data/cart.example.json`: ví dụ payload giỏ hàng.

## JavaScript
`assets/js/main.js` cung cấp `window.PhoneX` với giỏ hàng local, yêu thích và helper tìm kiếm. Đây là prototype; khi lên WooCommerce, cart/order phải dùng WooCommerce API/session.

## Mapping WordPress
- `components/header.html` → `header.php`
- `components/footer.html` → `footer.php`
- `components/product-card.html` → template part sản phẩm
- `products.json` → WooCommerce Product + variation
- `stores.json` → custom post type/table Store
- Thu mua/Trade-in/Bảo hành → Smartphone Core custom plugin + custom tables/API
