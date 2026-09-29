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
    out.append(f'              <h4 class="font-black text-gray-900 text-base md:text-lg mb-3.5 flex items-center gap-2">')
    out.append(f'                <span class="w-2 h-4 bg-red-600 rounded-full"></span>')
    out.append(f'                <span>{title}</span>')
    out.append(f'              </h4>')
    out.append(f'              <div class="grid grid-cols-4 sm:grid-cols-6 gap-x-2 gap-y-3">')
    for name, slug, badge in items:
        badge_html = ""
        if badge == "Hot":
            badge_html = '\n                    <span class="absolute -top-1.5 -right-1.5 text-[10px] font-extrabold bg-red-500 text-white px-2 py-0.5 rounded-full leading-none shadow-sm">Hot</span>'
        elif badge == "Mới":
            badge_html = '\n                    <span class="absolute -top-1.5 -right-1.5 text-[10px] font-extrabold bg-rose-500 text-white px-2 py-0.5 rounded-full leading-none shadow-sm">Mới</span>'
        
        out.append(f'''                <a href="{{{{ROOT}}}}pages/shop/search-filter/index.html" class="group flex flex-col items-center text-center p-1.5 rounded-2xl hover:bg-red-50/50 transition-all relative">
                  <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-white border border-gray-100 group-hover:border-red-300 group-hover:shadow-md flex items-center justify-center transition-all relative shrink-0 shadow-2xs p-1.5">
                    <img src="{{{{ROOT}}}}assets/images/categories/accessories/{slug}.png" alt="{name}" class="w-11 h-11 sm:w-12 sm:h-12 object-contain transform group-hover:scale-110 transition-transform duration-200" loading="lazy" />{badge_html}
                  </div>
                  <span class="mt-2 text-xs sm:text-[13px] font-bold text-gray-800 group-hover:text-red-600 leading-snug max-w-[85px] sm:max-w-[100px] line-clamp-2 transition-colors">{name}</span>
                </a>''')
    out.append(f'              </div>')
    return "\n".join(out)

left_col = f'''          <!-- LEFT COLUMN -->
          <div class="space-y-7">
            <!-- 1. Phụ kiện di động -->
            <div>
{render_section(items_data[0][0], items_data[0][1])}
            </div>

            <!-- 2. Thiết bị nghe nhìn, lưu trữ, thu âm -->
            <div class="pt-5 border-t border-gray-100">
{render_section(items_data[2][0], items_data[2][1])}
            </div>
          </div>'''

right_col = f'''          <!-- RIGHT COLUMN -->
          <div class="space-y-7 lg:pl-8 pt-6 lg:pt-0">
            <!-- 3. Phụ kiện laptop, PC -->
            <div>
{render_section(items_data[1][0], items_data[1][1])}
            </div>

            <!-- 4. Camera -->
            <div class="pt-5 border-t border-gray-100">
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

# 1. Update pxAccessoriesWrapper with onmouseenter/onmouseleave
wrapper_old = '<div class="relative" id="pxAccessoriesWrapper">'
wrapper_new = '<div class="relative" id="pxAccessoriesWrapper" onmouseenter="PhoneXAccessoriesMegaMenu.onEnter()" onmouseleave="PhoneXAccessoriesMegaMenu.onLeave()">'
if wrapper_old in content:
    content = content.replace(wrapper_old, wrapper_new, 1)

# 2. Update pxAccessoriesMegaMenu tag with onmouseenter/onmouseleave and rounded-3xl p-6 md:p-7
menu_tag_pattern = r'<div id="pxAccessoriesMegaMenu"[^>]*>'
menu_tag_replacement = '<div id="pxAccessoriesMegaMenu" onmouseenter="PhoneXAccessoriesMegaMenu.onEnter()" onmouseleave="PhoneXAccessoriesMegaMenu.onLeave()" class="hidden absolute top-full left-0 right-0 z-50 mt-1 bg-white rounded-3xl shadow-2xl border border-gray-100 p-6 md:p-7 text-gray-800 transition-all duration-200" style="display: none;">'
content = re.sub(menu_tag_pattern, menu_tag_replacement, content, count=1)

# 3. Replace grid content
pattern = r'<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">[\s\S]*?<\/div>\s*<div class="mt-6 pt-4 border-t border-gray-100'
replacement = grid_content + '\n\n        <div class="mt-6 pt-4 border-t border-gray-100'
content, count = re.subn(pattern, replacement, content, count=1)

# 4. Update PhoneXAccessoriesMegaMenu script
old_script = r'window\.PhoneXAccessoriesMegaMenu = \{[\s\S]*?\n    \};'
new_script = '''window.PhoneXAccessoriesMegaMenu = {
      timer: null,
      open: function() {
        if (this.timer) clearTimeout(this.timer);
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (!menu) return;
        menu.classList.remove('hidden');
        menu.style.display = 'block';
        if (arrow) arrow.style.transform = 'rotate(180deg)';
        if (btn) btn.classList.add('bg-red-50', 'text-red-600');
      },
      close: function() {
        if (this.timer) clearTimeout(this.timer);
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        const arrow = document.getElementById('pxAccessoriesArrow');
        const btn = document.getElementById('pxAccessoriesBtn');
        if (menu) {
          menu.classList.add('hidden');
          menu.style.display = 'none';
        }
        if (arrow) arrow.style.transform = 'rotate(0deg)';
        if (btn) btn.classList.remove('bg-red-50', 'text-red-600');
      },
      toggle: function(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const menu = document.getElementById('pxAccessoriesMegaMenu');
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden') || menu.style.display === 'none';
        if (isHidden) {
          this.open();
        } else {
          this.close();
        }
      },
      onEnter: function() {
        if (this.timer) clearTimeout(this.timer);
        this.open();
      },
      onLeave: function() {
        if (this.timer) clearTimeout(this.timer);
        const self = this;
        this.timer = setTimeout(function() {
          self.close();
        }, 180);
      }
    };'''
content = re.sub(old_script, new_script, content, count=1)

with open(header_path, "w", encoding="utf-8") as f:
    f.write(content)
print(" Cập nhật thành công components/header.html với kích thước ảnh/chữ lớn hơn và hiệu ứng hover vào/ra mượt mà!")
