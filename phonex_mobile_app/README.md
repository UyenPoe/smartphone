# PhoneX Mobile App (B2C Khách Lẻ & B2B Đại Lý Dual-Mode)

Ứng dụng di động chính thức của nền tảng **PhoneX**, phục vụ song song hai nhóm đối tượng trên cùng một ứng dụng duy nhất:
1. **Khách hàng cá nhân (B2C):** Định giá thu cũ 30s, mua điện thoại Like New 99%, trả góp 0% duyệt 5 phút, tra cứu bảo hành điện tử.
2. **Đại lý & CTV (B2B):** Thẩm định máy tại quầy, đặt mua sỉ theo lô chiết khấu đến 18%, ví hoa hồng và mã QR giới thiệu.

---

## 📱 Kiến trúc ứng dụng (Dual-Mode Architecture)

```text
phonex_mobile_app/
├── lib/
│   ├── main.dart                       # Khởi chạy Provider & Theme động
│   ├── core/
│   │   ├── constants/
│   │   │   ├── app_colors.dart         # Bảng màu PhoneX Red (#E60012) & B2B Slate (#0F172A)
│   │   │   └── api_constants.dart      # URL REST API: https://smartphone.taichinhtaithanh.com
│   │   ├── state/
│   │   │   └── app_mode_state.dart     # Quản lý chuyển đổi chế độ B2C ↔ B2B
│   │   └── theme/
│   │       └── app_theme.dart          # Giao diện chuẩn Material 3
│   ├── data/
│   │   ├── models/                     # Brand, PhoneModel, ValuationRequest, BuybackTicket
│   │   └── services/
│   │       └── api_service.dart        # Tương tác trực tiếp PhoneX REST API live
│   └── ui/
│       ├── widgets/
│       │   └── dual_mode_header.dart   # Thanh Header có nút chuyển chế độ 1 chạm
│       ├── features/
│       │   ├── b2c/                    # 5 Màn hình Khách Lẻ (Home, Định giá, Bảng giá, Kho, Tra cứu)
│       │   └── b2b/                    # 3 Màn hình Đại Lý (Kho Sỉ, Test tại quầy, Ví hoa hồng)
│       └── main_navigation_screen.dart # Thanh điều hướng thông minh theo chế độ
└── pubspec.yaml
```

---

## ⚡ Hướng dẫn cài đặt & Khởi chạy

### 1. Cài đặt thư viện dependencies
```bash
cd phonex_mobile_app
flutter pub get
```

### 2. Chạy thử nghiệm trên thiết bị hoặc giả lập
```bash
# Chạy trên máy ảo Android hoặc điện thoại cắm dây USB
flutter run

# Hoặc chạy thử nghiệm nhanh trên Chrome / Web
flutter run -d chrome
```

### 3. Xuất file cài đặt APK cho điện thoại Android
```bash
flutter build apk --release
```
*File APK thành phẩm sẽ nằm tại:* `build/app/outputs/flutter-apk/app-release.apk`

---

## 🔗 Danh sách API Live được tích hợp sẵn
- `GET https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/brands`
- `GET https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/models`
- `GET https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/search?keyword=...`
- `POST https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/estimate`
- `POST https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/submit-request`
- `GET https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1/buyback/lookup?phone=...`
