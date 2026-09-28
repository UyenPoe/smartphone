# PhoneX Smartphone E-Commerce Platform

PhoneX là nền tảng giao diện web thương mại điện tử chuyên ngành Smartphone cao cấp, tích hợp hệ thống định giá Thu cũ đổi mới (Trade-in), quản lý chuỗi 128 cửa hàng và cổng bảo hành điện tử.

---

## 📁 Cấu trúc thư mục chuẩn hóa (Project Structure)

```text
phonex-smartphone-project/
├── .gitignore                   # Cấu hình bỏ qua file rác hệ điều hành và node_modules
├── package.json                 # Quản lý scripts kiểm tra, chạy dev server và audit code
├── index.html                   # Entry point chuyển hướng chuẩn SEO
├── dev-pages.html               # Bảng điều khiển kiểm tra trực quan 46 màn hình
│
├── pages/                       # 46 trang responsive hoàn chỉnh theo Domain
│   ├── shop/                    # Mua hàng, sản phẩm, giỏ hàng, checkout, tra cứu đơn
│   ├── trade-in/                # Định giá máy cũ, đăng ký bán máy, trade-in
│   ├── account/                 # Đăng nhập OTP qua SĐT, hồ sơ, lịch sử mua hàng
│   ├── warranty/                # Tra cứu bảo hành điện tử theo IMEI/Serial, tạo yêu cầu
│   ├── stores/                  # Chuỗi cửa hàng, kiểm tra tồn kho, đặt giữ máy
│   └── promotions/              # Danh sách ưu đãi và chi tiết khuyến mãi
│
├── components/                  # Thành phần giao diện chuẩn hóa (Header, Footer, Card)
├── data/                        # Mock data schemas (products.json, stores.json, routes.json)
├── assets/                      # Tài nguyên tĩnh
│   ├── css/                     # runtime-responsive.css, app.css, variables.css
│   ├── js/                      # main.js (giỏ hàng, yêu thích), route-resolver.js
│   └── images/                  # Thư mục lưu trữ hình ảnh nội bộ
│
├── scripts/                     # Scripts công cụ tự động hóa của lập trình viên
│   ├── check-pages.js           # Kiểm tra toàn vẹn cú pháp HTML, SEO & Accessibility
│   └── standardize.py           # Dọn dẹp DOM rác và chuẩn hóa thuộc tính thẻ
│
└── docs/                        # Tài liệu thiết kế hệ thống và lộ trình tích hợp
```

---

## 🚀 Khởi chạy dự án (Developer Quickstart)

### Cách 1: Sử dụng npm / node
```bash
# Khởi động local server
npm run dev

# Hoặc dùng npx serve
npm run serve
```

### Cách 2: Chạy trực tiếp qua Python
```bash
python3 -m http.server 8080
```
Truy cập: `http://localhost:8080`

---

## 🛠️ Công cụ kiểm tra chất lượng mã nguồn (Code Quality Audit)

Chạy kịch bản kiểm tra toàn diện 46 trang:
```bash
npm run check
```
Script sẽ tự động xác thực:
- Chuẩn cú pháp `<!DOCTYPE html>` và `lang="vi"`.
- Không tồn tại thẻ rác bị ẩn (`data-old-*`) hay lỗi regex.
- Thẻ tiêu đề `<title>` và thẻ mô tả `<meta name="description">` đầy đủ trên mọi trang.
- Đầy đủ thuộc tính `alt` cho khả năng tiếp cận (Accessibility - A11y).
