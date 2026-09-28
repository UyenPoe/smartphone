#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
PhoneX - Home Page Navigation Hub Enhancer
Links all 46 UI pages from pages/shop/home/index.html for easy QA inspection.
"""

import json
import re

def main():
    home_path = 'pages/shop/home/index.html'
    with open(home_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Fix remaining href="#"
    content = content.replace(
        'data-path="compare" href="#"',
        'data-path="compare" href="../../../pages/shop/compare/index.html"'
    )
    content = content.replace(
        'data-path="preowned" href="#"',
        'data-path="preowned" href="../../../pages/stores/used-phones/index.html"'
    )
    content = content.replace(
        'data-path="accessories" href="#"',
        'data-path="accessories" href="../../../pages/shop/products/index.html"'
    )
    content = content.replace(
        'data-path="installment" href="#"',
        'data-path="installment" href="../../../pages/shop/products/index.html"'
    )
    content = content.replace(
        'data-path="promotions" href="#"',
        'data-path="promotions" href="../../../pages/promotions/promotions/index.html"'
    )

    # Replace deals cards href="#"
    deal_urls = [
        '../../../pages/shop/product-detail/index.html',
        '../../../pages/shop/product-detail/index.html',
        '../../../pages/shop/product-detail/index.html',
        '../../../pages/shop/used-detail/index.html',
        '../../../pages/shop/product-detail/index.html'
    ]
    for url in deal_urls:
        content = content.replace('data-path="deals" href="#"', f'data-path="deals" href="{url}"', 1)

    # 2. Build 46-page UI Review Section
    groups = {
        "shop": {
            "title": "🛒 Mua Sắm & Đơn Hàng",
            "badge": "15 trang",
            "badge_color": "bg-red-100 text-red-700",
            "pages": [
                ("shop/home", "Trang chủ Flagship"),
                ("shop/products", "Tất cả sản phẩm"),
                ("shop/product-detail", "Chi tiết máy mới"),
                ("shop/used-detail", "Chi tiết máy cũ 99%"),
                ("shop/series", "Dòng máy iPhone 18"),
                ("shop/brand", "Thương hiệu Apple VN/A"),
                ("shop/search", "Kết quả tìm kiếm"),
                ("shop/search-filter", "Bộ lọc chuyên sâu"),
                ("shop/compare", "So sánh cấu hình"),
                ("shop/cart", "Giỏ hàng & Ưu đãi"),
                ("shop/checkout", "Thanh toán đặt hàng"),
                ("shop/click-collect", "Nhận tại cửa hàng"),
                ("shop/order-success", "Đặt hàng thành công"),
                ("shop/order-tracking", "Tra cứu đơn hàng"),
                ("shop/order-detail", "Chi tiết đơn hàng")
            ]
        },
        "trade_in": {
            "title": "🔄 Thu Cũ Đổi Mới / Trade-in",
            "badge": "9 trang",
            "badge_color": "bg-amber-100 text-amber-800",
            "pages": [
                ("trade-in/sell-phone", "Trang chủ Thu cũ đổi mới"),
                ("trade-in/device-selection", "Chọn thiết bị cần bán"),
                ("trade-in/valuation", "Khảo sát tình trạng máy"),
                ("trade-in/valuation-result", "Báo giá thu mua"),
                ("trade-in/sell-registration", "Đăng ký bán máy"),
                ("trade-in/sell-success", "Gửi yêu cầu thành công"),
                ("trade-in/tradein-result", "Tính bù tiền Trade-in"),
                ("trade-in/tradein-tracking", "Tra cứu hồ sơ bằng SĐT"),
                ("trade-in/tradein-detail", "Chi tiết hồ sơ Thu cũ")
            ]
        },
        "stores": {
            "title": "🏢 Hệ Thống 128 Cửa Hàng",
            "badge": "8 trang",
            "badge_color": "bg-blue-100 text-blue-700",
            "pages": [
                ("stores/stores", "Danh sách 128 Showroom"),
                ("stores/store-detail", "Chi tiết Showroom"),
                ("stores/find-store-stock", "Tìm cửa hàng còn máy"),
                ("stores/stock-check", "Kiểm tra tồn kho"),
                ("stores/reserve-store", "Đặt giữ máy tại shop"),
                ("stores/reserve-success", "Giữ máy thành công"),
                ("stores/reserve-tracking", "Tra cứu phiếu giữ máy"),
                ("stores/used-phones", "Máy cũ theo cửa hàng")
            ]
        },
        "account": {
            "title": "👤 Tài Khoản Khách Hàng",
            "badge": "8 trang",
            "badge_color": "bg-purple-100 text-purple-700",
            "pages": [
                ("account/login-phone-otp", "Đăng nhập SĐT + OTP"),
                ("account/account", "Trung tâm tài khoản VIP"),
                ("account/profile", "Hồ sơ cá nhân"),
                ("account/addresses", "Sổ địa chỉ nhận hàng"),
                ("account/my-orders", "Đơn hàng của tôi"),
                ("account/my-tradein", "Hồ sơ Trade-in của tôi"),
                ("account/favorites", "Sản phẩm yêu thích"),
                ("account/notifications", "Trung tâm thông báo")
            ]
        },
        "warranty": {
            "title": "🛡️ Bảo Hành Điện Tử",
            "badge": "4 trang",
            "badge_color": "bg-green-100 text-green-700",
            "pages": [
                ("warranty/warranty-lookup", "Tra cứu bảo hành IMEI/SĐT"),
                ("warranty/warranty-devices", "Danh sách thiết bị"),
                ("warranty/warranty-request", "Tạo yêu cầu hẹn sửa chữa"),
                ("warranty/warranty-detail", "Chi tiết tiến độ xử lý")
            ]
        },
        "promotions": {
            "title": "🎁 Khuyến Mãi & Ưu Đãi",
            "badge": "2 trang",
            "badge_color": "bg-rose-100 text-rose-700",
            "pages": [
                ("promotions/promotions", "Tổng hợp chương trình Hot"),
                ("promotions/promotion-detail", "Chi tiết ưu đãi mở bán")
            ]
        }
    }

    cards_html = ""
    for g_key, g_val in groups.items():
        links_html = ""
        for route, name in g_val["pages"]:
            url = f"../../../pages/{route}/index.html"
            links_html += f'''
              <li>
                <a href="{url}" class="group flex items-center justify-between p-2 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-600 transition-colors text-xs font-medium">
                  <span class="truncate">{name}</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-0.5 transition-all text-[11px]">&rarr;</span>
                </a>
              </li>'''
        
        cards_html += f'''
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">{g_val["title"]}</h3>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {g_val["badge_color"]}">{g_val["badge"]}</span>
          </div>
          <ul class="space-y-1">
            {links_html}
          </ul>
        </div>'''

    review_hub_section = f'''
<!-- SECTION 14: PHONEX 46-SCREEN UI REVIEW & NAVIGATION HUB -->
<section id="phonex-ui-hub" class="w-full bg-gradient-to-b from-gray-50 to-gray-100 border-t border-b border-gray-200 py-12 px-4 my-8">
  <div class="max-w-7xl mx-auto">
    <!-- Header banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
      <div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs uppercase tracking-wider mb-2">
          <span class="material-symbols-outlined text-[16px]">visibility</span>
          Trung Tâm Kiểm Tra Giao Diện PhoneX
        </div>
        <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
          Sơ Đồ Điều Hướng &amp; Kiểm Tra 46 Màn Hình Giao Diện
        </h2>
        <p class="text-sm text-gray-600 mt-1 max-w-2xl">
          Bấm trực tiếp vào bất kỳ trang nào dưới đây để kiểm tra thiết kế, bố cục responsive và trải nghiệm người dùng trước khi bàn giao.
        </p>
      </div>
      <div class="flex items-center gap-3">
        <a href="../../../dev-pages.html" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-xs shadow-sm hover:shadow transition-all flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px]">dashboard</span>
          Mở Dashboard 46 Trang (Site Map)
        </a>
      </div>
    </div>

    <!-- 6 Module Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      {cards_html}
    </div>
  </div>
</section>

<!-- Floating Quick Navigator Button (Bottom-Right) -->
<div class="fixed bottom-20 md:bottom-6 right-4 z-40">
  <a href="#phonex-ui-hub" class="px-4 py-2.5 bg-gray-900/90 hover:bg-black text-white text-xs font-bold rounded-full shadow-lg backdrop-blur-md flex items-center gap-2 border border-gray-700 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-red-500 text-[18px]">grid_view</span>
    <span>Duyệt 46 Trang UI</span>
    <span class="bg-red-600 text-white text-[10px] px-1.5 py-0.2 rounded-full font-extrabold">46</span>
  </a>
</div>
'''

    # Insert review_hub_section right before </div></main>
    # If already added, replace it
    if 'id="phonex-ui-hub"' in content:
        content = re.sub(r'<!-- SECTION 14: PHONEX 46-SCREEN UI REVIEW.*?</div>\s*</div>\s*(?=<!-- START: COMPONENT FOOTER|<footer)', '', content, flags=re.DOTALL)
    
    target_marker = '</div></main>'
    if target_marker in content:
        content = content.replace(target_marker, review_hub_section + '\n' + target_marker, 1)
    else:
        print("Marker </div></main> not found!")

    with open(home_path, 'w', encoding='utf-8') as f:
        f.write(content)

    print("✔ Đã liên kết thành công 46 trang từ trang Home (pages/shop/home/index.html)!")

if __name__ == '__main__':
    main()
