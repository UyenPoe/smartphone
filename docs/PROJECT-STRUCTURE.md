# PhoneX Smartphone Project

Đây là cấu trúc project frontend thực tế được tổ chức lại từ bộ thiết kế Stitch. Không còn chia thư mục theo Giai đoạn 1/2/3/4 ở source chính.

## Cấu trúc
- `pages/shop`: mua hàng, sản phẩm, giỏ hàng, checkout, đơn hàng.
- `pages/trade-in`: định giá, thu mua, Trade-in và tra cứu bằng số điện thoại.
- `pages/account`: đăng nhập SĐT/OTP và khu vực khách hàng.
- `pages/warranty`: tra cứu và yêu cầu bảo hành.
- `pages/stores`: cửa hàng, tồn kho, giữ máy.
- `assets`: CSS/JS/images dùng chung.
- `components`: component dùng chung khi refactor.
- `data`: mock JSON trước khi nối backend.
- `stitch-source`: bản thiết kế gốc để đối chiếu, không sửa trực tiếp.

## Responsive
Mỗi màn hình hiện giữ `desktop.html`, `tablet.html`, `mobile.html` và `index.html` router theo viewport. Đây là bước bảo toàn thiết kế Stitch. Khi refactor tiếp, ba bản sẽ được hợp nhất thành template responsive thực sự dùng CSS media queries.

## Quy tắc nghiệp vụ
Khách không bắt buộc đăng nhập để mua hàng, định giá, bán máy hoặc Trade-in. Tra cứu Thu mua/Trade-in dùng số điện thoại. Tài khoản khách hàng sử dụng số điện thoại/OTP, không phụ thuộc email.

## Chạy local
Có thể mở `index.html` trực tiếp, hoặc chạy local server (ví dụ VS Code Live Server).
