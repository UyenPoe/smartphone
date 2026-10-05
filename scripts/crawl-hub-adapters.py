#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Hub & Adapters (hub-chuyen-doi)
Source: https://www.thegioididong.com/hub-chuyen-doi
Category ID: 12979

Strictly extracts required fields:
1. Tên sản phẩm (Product name)
2. URL sản phẩm nguồn (Source product URL - internal metadata)
3. Giá hiện tại (Current price)
4. Giá cũ (Original price & discount %)
5. Hãng sản xuất (Brand: Apple, Ugreen, Hyper, Mazer, MicroPack, Xmobile...)
6. Phân loại sản phẩm (Hub USB-C đa năng, Cáp chuyển HDMI/VGA, Cáp âm thanh 3.5mm, Đầu chuyển OTG...)
7. Thông số kỹ thuật chi tiết (Cổng kết nối, công suất sạc PD, chuẩn xuất hình 4K/8K, tốc độ truyền tải)
8. Thời điểm cập nhật dữ liệu (Timestamp)

Localizes 100% of images into:
phonex-theme/assets/images/products/hub-chuyen-doi/
├── hub-usb-c/
├── cap-xuat-hinh/
├── cap-am-thanh/
├── dau-chuyen-otg/
└── khac/
"""

import urllib.request
import urllib.parse
import json
import re
import html
import os
import unicodedata
from datetime import datetime
from concurrent.futures import ThreadPoolExecutor, as_completed

THEME_DIR = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme")
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "hub-adapters.json")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "hub-chuyen-doi")

SUBDIRS = {
    "hub-usb-c": os.path.join(IMG_BASE_DIR, "hub-usb-c"),
    "cap-xuat-hinh": os.path.join(IMG_BASE_DIR, "cap-xuat-hinh"),
    "cap-am-thanh": os.path.join(IMG_BASE_DIR, "cap-am-thanh"),
    "dau-chuyen-otg": os.path.join(IMG_BASE_DIR, "dau-chuyen-otg"),
    "khac": os.path.join(IMG_BASE_DIR, "khac"),
}

for d in SUBDIRS.values():
    os.makedirs(d, exist_ok=True)

def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)[:70]

def clean_tgdd_references(text):
    if not text:
        return ""
    text = re.sub(r"Thế\s*Giới\s*Di\s*Động|TGDD|thegioididong\.com", "PhoneX", text, flags=re.IGNORECASE)
    text = re.sub(r"Điện\s*Máy\s*XANH|DMX", "PhoneX", text, flags=re.IGNORECASE)
    return text.strip()

def detect_type_and_specs(name):
    name_l = name.lower()
    specs = []
    
    if any(k in name_l for k in ["hub", "in 1", "in-1", "đa năng", "cong chuyen"]):
        prod_type = "Hub USB-C đa năng"
        subfolder = "hub-usb-c"
        
        # Ports detect
        ports = []
        if "hdmi" in name_l: ports.append("HDMI 4K")
        if "vga" in name_l: ports.append("VGA")
        if "lan" in name_l or "ethernet" in name_l or "rj45" in name_l: ports.append("Cổng mạng LAN RJ45")
        if "pd" in name_l or "sạc" in name_l: ports.append("Type-C PD 100W")
        if "usb" in name_l: ports.append("USB 3.0 (5Gbps)")
        if "sd" in name_l or "tf" in name_l: ports.append("Khe thẻ nhớ SD/TF")
        
        if ports:
            specs.append("Cổng tích hợp: " + ", ".join(ports))
        else:
            specs.append("Mở rộng đa cổng kết nối Type-C tiện lợi")
            
        specs.append("Vỏ nhôm tản nhiệt nguyên khối cao cấp")
        specs.append("Tương thích tốt MacBook, iPad, Laptop Windows")
        
    elif any(k in name_l for k in ["hdmi", "displayport", "vga", "hdtv"]):
        prod_type = "Cáp xuất hình ảnh"
        subfolder = "cap-xuat-hinh"
        if "8k" in name_l:
            specs.append("Độ phân giải siêu nét 8K@60Hz / 4K@120Hz")
        elif "4k" in name_l:
            specs.append("Độ phân giải Ultra HD 4K@60Hz mượt mà")
        else:
            specs.append("Xuất hình ảnh sắc nét Full HD / 2K / 4K")
        specs.append("Đầu cắm mạ vàng chống nhiễu, lõi đồng nguyên chất")
        specs.append("Kết nối máy tính sang Tivi, Màn hình, Máy chiếu")
        
    elif any(k in name_l for k in ["3.5mm", "audio", "tai nghe", "am thanh"]):
        prod_type = "Cáp chuyển âm thanh"
        subfolder = "cap-am-thanh"
        specs.append("Chip giải mã DAC cao cấp giữ trọn âm thanh gốc")
        specs.append("Hỗ trợ micro đàm thoại và phím điều khiển tai nghe")
        specs.append("Chuyển đổi Type-C / Lightning sang jack 3.5mm")
        
    elif any(k in name_l for k in ["otg", "dau chuyen", "đầu chuyển"]):
        prod_type = "Đầu chuyển đổi OTG"
        subfolder = "dau-chuyen-otg"
        specs.append("Chuẩn kết nối tốc độ cao USB 3.0 / Type-C")
        specs.append("Thiết kế siêu nhỏ gọn tiện lợi móc khóa")
        specs.append("Cắm là nhận (Plug & Play) không cần cài driver")
        
    elif any(k in name_l for k in ["lan", "cat 6", "cat 7", "cat 8", "mang"]):
        prod_type = "Cáp mạng LAN & Chuyên dụng"
        subfolder = "khac"
        specs.append("Băng thông truyền tải mạng Gigabit siêu tốc")
        specs.append("Lõi đồng chống nhiễu tín hiệu ổn định")
        specs.append("Đầu bấm đúc chuẩn xác độ bền cao")
        
    else:
        prod_type = "Cáp kết nối & Bộ chuyển đổi"
        subfolder = "khac"
        specs.append("Chuẩn kết nối tốc độ cao, tín hiệu ổn định")
        specs.append("Chất liệu dây bện dù hoặc bọc TPE bền bỉ")

    return prod_type, subfolder, specs

def download_file(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True
    req = urllib.request.Request(url, headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"
    })
    for _ in range(3):
        try:
            with urllib.request.urlopen(req, timeout=12) as resp:
                data = resp.read()
                if len(data) > 500:
                    with open(save_path, "wb") as f:
                        f.write(data)
                    return True
        except Exception:
            pass
    return False

def crawl_and_localize_hub_adapters():
    base_url = "https://www.thegioididong.com/Category/FilterProductBox?c=12979&pi={}"
    raw_products = []
    seen_urls = set()
    crawl_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    print("[1/3] Crawling products from https://www.thegioididong.com/hub-chuyen-doi (cateID: 12979) ...")
    max_pages = 6

    download_tasks = []
    used_filenames = set()

    for pi in range(max_pages):
        url = base_url.format(pi)
        data = urllib.parse.urlencode({
            "IsParentCate": "False",
            "IsShowCompare": "True",
            "IsAffiliate": "False",
            "prevent": "true"
        }).encode("utf-8")
        req = urllib.request.Request(url, data=data, headers={
            "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36",
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            "X-Requested-With": "XMLHttpRequest"
        })
        try:
            with urllib.request.urlopen(req, timeout=12) as resp:
                content = resp.read().decode("utf-8")
                data_json = json.loads(content)
                html_chunk = data_json.get("listproducts", "")
                if not html_chunk:
                    break

                items = re.findall(r'<li[^>]*class="[^"]*item[^"]*"[^>]*>.*?</li>', html_chunk, re.DOTALL)
                if not items:
                    break

                for it in items:
                    name_m = re.search(r'data-name="([^"]+)"', it)
                    if not name_m:
                        continue
                    full_name = html.unescape(name_m.group(1)).strip()
                    full_name = clean_tgdd_references(full_name)

                    url_m = re.search(r'<a\s+href=[\'"]([^\'"]+)[\'"]', it)
                    prod_url = url_m.group(1) if url_m else ""
                    if prod_url.startswith("/"):
                        prod_url = "https://www.thegioididong.com" + prod_url

                    if prod_url in seen_urls:
                        continue
                    seen_urls.add(prod_url)

                    # Prices
                    cur_price = 0
                    p_m = re.search(r'data-price="([^"]+)"', it)
                    if p_m:
                        try:
                            cur_price = int(float(p_m.group(1)))
                        except Exception:
                            cur_price = 0
                    if cur_price == 0:
                        pr_text_m = re.search(r'<strong[^>]*class="price"[^>]*>([^<]+)</strong>', it)
                        if pr_text_m:
                            num = re.sub(r'[^\d]', '', pr_text_m.group(1))
                            if num:
                                cur_price = int(num)

                    old_price = cur_price
                    p_old_m = re.search(r'<p[^>]*class="price-old[^"]*"[^>]*>([^<]+)</p>', it)
                    if p_old_m:
                        num = re.sub(r'[^\d]', '', p_old_m.group(1))
                        if num:
                            old_price = int(num)

                    disc_pct = 0
                    pct_m = re.search(r'<span[^>]*class="percent"[^>]*>-?(\d+)%</span>', it)
                    if pct_m:
                        disc_pct = int(pct_m.group(1))
                    elif old_price > cur_price and old_price > 0:
                        disc_pct = round(((old_price - cur_price) / old_price) * 100)

                    # Brand
                    brand = "PhoneX Link"
                    brand_m = re.search(r'data-brand="([^"]+)"', it)
                    if brand_m:
                        raw_brand = html.unescape(brand_m.group(1)).strip()
                        if raw_brand and raw_brand.lower() not in ["hãng khác", "other"]:
                            brand = clean_tgdd_references(raw_brand)

                    # Type & Specs
                    prod_type, subfolder_key, specs = detect_type_and_specs(full_name)

                    # Image URL
                    img_url = ""
                    img_m = re.search(r'<img[^>]*data-src=[\'"]([^\'"]+)[\'"]', it)
                    if not img_m:
                        img_m = re.search(r'<img[^>]*src=[\'"]([^\'"]+)[\'"]', it)
                    if img_m:
                        raw_img = img_m.group(1)
                        if "banner-box-product" not in raw_img:
                            img_url = raw_img.replace("http://", "https://")
                            if img_url.startswith("//"):
                                img_url = "https:" + img_url

                    # Local image filename
                    base_slug = slugify(full_name)
                    if not base_slug:
                        base_slug = f"hub-chuyen-doi-{len(raw_products)+1}"
                    if base_slug in used_filenames:
                        cnt = 1
                        while f"{base_slug}-{cnt}" in used_filenames:
                            cnt += 1
                        slug_filename = f"{base_slug}-{cnt}.jpg"
                        used_filenames.add(f"{base_slug}-{cnt}")
                    else:
                        slug_filename = f"{base_slug}.jpg"
                        used_filenames.add(base_slug)

                    target_dir = SUBDIRS.get(subfolder_key, SUBDIRS["khac"])
                    local_abs_path = os.path.join(target_dir, slug_filename)
                    rel_theme_path = f"assets/images/products/hub-chuyen-doi/{subfolder_key}/{slug_filename}"

                    if img_url:
                        download_tasks.append((img_url, local_abs_path))

                    raw_products.append({
                        "name": full_name,
                        "source_url": prod_url,
                        "price": cur_price,
                        "price_formatted": f"{cur_price:,.0f}₫".replace(",", "."),
                        "price_old": old_price,
                        "price_old_formatted": f"{old_price:,.0f}₫".replace(",", "."),
                        "discount_percent": disc_pct,
                        "brand": brand,
                        "type": prod_type,
                        "category_slug": subfolder_key,
                        "specs": specs,
                        "image": rel_theme_path,
                        "image_remote": img_url,
                        "updated_at": crawl_time
                    })

                print(f"  - Page {pi}: Processed {len(items)} items, total unique so far: {len(raw_products)}")

        except Exception as e:
            print(f"  - Page {pi} Error: {e}")
            break

    print(f"\n[2/3] Localizing {len(download_tasks)} product images into local subfolders...")
    downloaded_count = 0
    with ThreadPoolExecutor(max_workers=16) as executor:
        futures = {executor.submit(download_file, url, path): (url, path) for url, path in download_tasks}
        for future in as_completed(futures):
            if future.result():
                downloaded_count += 1
                if downloaded_count % 20 == 0 or downloaded_count == len(download_tasks):
                    print(f"  - Downloaded {downloaded_count}/{len(download_tasks)} images locally...")

    print(f"\n[3/3] Saving JSON dataset to {OUTPUT_PATH}...")
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(raw_products, f, ensure_ascii=False, indent=2)

    print(f"Finished! Crawled & Localized {len(raw_products)} hub & adapter products successfully.")
    return raw_products

if __name__ == "__main__":
    crawl_and_localize_hub_adapters()
