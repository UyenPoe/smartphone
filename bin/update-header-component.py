#!/usr/bin/env python3
import re

items_data = [
    # 1. Phụ kiện di động
    ("Phụ kiện di động", [
        ("Sạc dự phòng", "sac-du-phong", None),
        ("Sạc, cáp", "sac-cap", None),
        ("Ốp lưng điện thoại", "op-lung-dien-thoai", None),
        ("Ốp lưng máy tính bảng", "op-lung-may-tinh-bang", None),
        ("Miếng dán", "mieng-dan", None),
        ("Miếng dán Camera", "mieng-dan-camera", None),
        ("Túi đựng AirPods", "tui-dung-airpods", None),
        ("Quạt mini", "quat-mini", "Hot"),
        ("Bút tablet", "but-tablet", None),
        ("Giá đỡ điện thoại/laptop", "gia-do-dien-thoai-laptop", None),
        ("Dây đeo điện thoại", "day-deo-dien-thoai", None),
        ("Ống kính điện thoại", "ong-kinh-dien-thoai", "Mới"),
    ]),
    # 2. Phụ kiện laptop, PC
    ("Phụ kiện laptop, PC", [
        ("Hub, cáp chuyển đổi", "hub-cap-chuyen-doi", None),
        ("Chuột máy tính", "chuot-may-tinh", None),
        ("Bàn phím", "ban-phim", None),
        ("Router - Thiết bị mạng", "router-thiet-bi-mang", None),
        ("Balo, túi chống sốc", "balo-tui-chong-soc", None),
        ("Túi đựng phụ kiện", "tui-dung-phu-kien", None),
        ("Phủ phím laptop", "phu-phim-laptop", None),
        ("Phần mềm", "phan-mem", None),
        ("Giá treo màn hình", "gia-treo-man-hinh", None),
        ("Miếng lót chuột", "mieng-lot-chuot", None),
        ("Bảng vẽ điện tử", "bang-ve-dien-tu", None),
    ]),
    # 3. Thiết bị nghe nhìn, lưu trữ, thu âm
    ("Thiết bị nghe nhìn, lưu trữ, thu âm", [
        ("Tai nghe Bluetooth", "tai-nghe-bluetooth", None),
        ("Tai nghe dây", "tai-nghe-day", None),
        ("Tai nghe chụp tai", "tai-nghe-chup-tai", None),
        ("Tai nghe thể thao", "tai-nghe-the-thao", None),
        ("Loa", "loa", "Hot"),
        ("Micro", "micro", None),
        ("Máy chiếu", "may-chieu", None),
        ("Kính thông minh", "kinh-thong-minh", None),
        ("Ổ cứng", "o-cung", None),
        ("Thẻ nhớ", "the-nho", None),
        ("USB", "usb", None),
    ]),
    # 4. Camera
    ("Camera", [
        ("Camera Giám Sát", "camera-giam-sat", "Hot"),
        ("Camera trong nhà", "camera-trong-nha", None),
        ("Camera ngoài trời", "camera-ngoai-troi", None),
        ("Camera Năng Lượng", "camera-nang-luong-mat-troi", None),
        ("Camera 4G", "camera-4g", None),
        ("Chuông cửa Camera", "chuong-cua-camera", None),
        ("Webcam", "webcam", None),
    ])
]

def render_section(title, items):
    out = []
    out.append(f'              <h4 class="font-extrabold text-gray-900 text-sm md:text-[15px] mb-3 flex items-center gap-1.5">')
    out.append(f'                <span class="w-1.5 h-3.5 bg-red-600 rounded-full"></span>')
    out.append(f'                <span>{title}</span>')
    out.append(f'              </h4>')
    out.append(f'              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">')
    for name, slug, badge in items:
        badge_html = ""
        if badge == "Hot":
            badge_html = '\n                    <span class="absolute -top-1.5 -right-1.5 text-[9px] font-extrabold bg-red-500 text-white px-1.5 py-0.2 rounded-full leading-none shadow-xs">Hot</span>'
        elif badge == "Mới":
            badge_html = '\n                    <span class="absolute -top-1.5 -right-1.5 text-[9px] font-extrabold bg-rose-500 text-white px-1.5 py-0.2 rounded-full leading-none shadow-xs">Mới</span>'
        
        out.append(f'''                <a href="{{{{ROOT}}}}pages/shop/search-filter/index.html" class="group flex flex-col items-center text-center p-1 rounded-xl hover:bg-red-50/40 transition-all relative">
                  <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-gray-50 border border-gray-100 group-hover:border-red-300 group-hover:bg-red-50/70 flex items-center justify-center transition-all relative shrink-0 shadow-2xs p-1">
                    <img src="{{{{ROOT}}}}assets/images/categories/accessories/{slug}.png" alt="{name}" class="w-8 h-8 sm:w-9 sm:h-9 object-contain transform group-hover:scale-110 transition-transform duration-200" loading="lazy" />{badge_html}
                  </div>
                  <span class="mt-1.5 text-[11px] font-medium text-gray-700 group-hover:text-red-600 leading-tight max-w-[76px] line-clamp-2 transition-colors">{name}</span>
                </a>''')
    out.append(f'              </div>')
    return "\n".join(out)

left_col = f'''          <!-- LEFT COLUMN -->
          <div class="space-y-6">
            <!-- 1. Phụ kiện di động -->
            <div>
{render_section(items_data[0][0], items_data[0][1])}
            </div>

            <!-- 2. Thiết bị nghe nhìn, lưu trữ, thu âm -->
            <div class="pt-4 border-t border-gray-100">
{render_section(items_data[2][0], items_data[2][1])}
            </div>
          </div>'''

right_col = f'''          <!-- RIGHT COLUMN -->
          <div class="space-y-6 lg:pl-8 pt-6 lg:pt-0">
            <!-- 3. Phụ kiện laptop, PC -->
            <div>
{render_section(items_data[1][0], items_data[1][1])}
            </div>

            <!-- 4. Camera -->
            <div class="pt-4 border-t border-gray-100">
{render_section(items_data[3][0], items_data[3][1])}
            </div>
          </div>'''

grid_content = f'''        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
{left_col}

{right_col}
        </div>'''

header_path = "components/header.html"
with open(header_path, "r", encoding="utf-8") as f:
    content = f.read()

pattern = r'<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">[\s\S]*?<\/div>\s*<div class="mt-6 pt-4 border-t border-gray-100'

replacement = grid_content + '\n\n        <div class="mt-6 pt-4 border-t border-gray-100'

new_content, count = re.subn(pattern, replacement, content, count=1)
if count > 0:
    with open(header_path, "w", encoding="utf-8") as f:
        f.write(new_content)
    print(" Cập nhật thành công components/header.html với hình ảnh phụ kiện sinh động!")
else:
    print(" LỖI: Không tìm thấy regex pattern trong components/header.html!")
