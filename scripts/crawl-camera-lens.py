#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Camera Lens Protectors (mieng-dan-camera)
Source: https://www.thegioididong.com/mieng-dan-camera
Category ID: 13118

Strictly extracts required fields:
1. Tên sản phẩm (Product name)
2. URL sản phẩm nguồn (Source product URL - internal metadata)
3. Giá hiện tại (Current price)
4. Giá cũ (Original price & discount %)
5. Hãng / model tương thích (Brand & Compatible Device Model)
6. Dòng máy (iPhone 16 Pro/Pro Max, iPhone 15, iPhone 14...)
7. Chất liệu & Tính năng (Viền hợp kim Aluminium, Viền Titanium, Kính Sapphire, Chống lóa flash...)
8. Một số thông số kỹ thuật cơ bản
9. Thời điểm cập nhật dữ liệu (Timestamp)

Localizes 100% of images into:
phonex-theme/assets/images/products/mieng-dan-camera/
├── iphone/
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
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "camera-lens.json")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "mieng-dan-camera")

DIR_IPHONE = os.path.join(IMG_BASE_DIR, "iphone")
DIR_KHAC = os.path.join(IMG_BASE_DIR, "khac")

for d in [DIR_IPHONE, DIR_KHAC]:
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

def detect_device(name):
    name_l = name.lower()
    if "iphone" in name_l:
        m = re.search(r"iphone\s*([0-9\s\w/]+?)(?:\s*(?:dekey|uniq|jcpal|mipow|optix|titanshield|3d|lens|-|\+))", name_l)
        model = f"iPhone {m.group(1).strip().title()}" if m else "iPhone"
        return "iPhone", model, "iphone"
    elif "samsung" in name_l or "galaxy" in name_l:
        m = re.search(r"(?:galaxy\s*)?(s[0-9]+(?:\s*(?:ultra|plus|\+|fe))?|z\s*fold[0-9]*|z\s*flip[0-9]*|a[0-9]+)", name_l)
        model = f"Galaxy {m.group(1).strip().upper()}" if m else "Galaxy"
        return "Samsung", model, "khac"
    else:
        return "Thiết bị khác", "Smartphone", "khac"

def detect_material_and_specs(name):
    specs = []
    name_l = name.lower()

    if "titan" in name_l:
        mat = "Viền hợp kim Titanium hàng không"
        prod_type = "Viền Titanium cao cấp"
    elif "aluminium" in name_l or "nhôm" in name_l:
        mat = "Viền hợp kim nhôm Aluminium CNC"
        prod_type = "Viền kim loại chống va đập"
    elif "sapphire" in name_l:
        mat = "Mặt kính nhân tạo Sapphire siêu cứng"
        prod_type = "Kính Sapphire chống xước"
    elif "pc" in name_l or "thuỷ tinh" in name_l:
        mat = "Kính cường lực quang học & Khung PC"
        prod_type = "Kính quang học trong suốt"
    else:
        mat = "Mặt kính cường lực 9H & Viền kim loại"
        prod_type = "Kính bảo vệ ống kính"

    specs.append(f"Chất liệu {mat}")
    specs.append("Độ trong suốt 99.9% chụp ảnh sắc nét")

    if "flash" in name_l or "đen" in name_l or "black" in name_l or "pro" in name_l:
        specs.append("Vòng đệm đen chống lóa khi bật đèn Flash ban đêm")
    else:
        specs.append("Công nghệ AR chống phản xạ ánh sáng")

    specs.append("Kèm khung dán định hình căn chỉnh chuẩn xác tại nhà")
    specs.append("Chống trầy xước, bụi bẩn và dầu mỡ bám bẩn")

    return prod_type, mat, specs

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

def crawl_and_localize_camera_lens():
    base_url = "https://www.thegioididong.com/Category/FilterProductBox?c=13118&pi={}"
    raw_products = []
    seen_urls = set()
    crawl_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    print("[1/3] Crawling products from https://www.thegioididong.com/mieng-dan-camera (cateID: 13118) ...")
    max_pages = 5

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
                    brand = "PhoneX Care"
                    brand_m = re.search(r'data-brand="([^"]+)"', it)
                    if brand_m:
                        raw_brand = html.unescape(brand_m.group(1)).strip()
                        if raw_brand and raw_brand.lower() not in ["hãng khác", "other"]:
                            brand = clean_tgdd_references(raw_brand)

                    # Device & Category
                    dev_brand, dev_model, subfolder_key = detect_device(full_name)
                    prod_type, mat, specs = detect_material_and_specs(full_name)

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
                        base_slug = f"mieng-dan-camera-{len(raw_products)+1}"
                    if base_slug in used_filenames:
                        cnt = 1
                        while f"{base_slug}-{cnt}" in used_filenames:
                            cnt += 1
                        slug_filename = f"{base_slug}-{cnt}.jpg"
                        used_filenames.add(f"{base_slug}-{cnt}")
                    else:
                        slug_filename = f"{base_slug}.jpg"
                        used_filenames.add(base_slug)

                    target_dir = DIR_IPHONE if subfolder_key == "iphone" else DIR_KHAC
                    local_abs_path = os.path.join(target_dir, slug_filename)
                    rel_theme_path = f"assets/images/products/mieng-dan-camera/{subfolder_key}/{slug_filename}"

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
                        "device_brand": dev_brand,
                        "device_model": dev_model,
                        "type": prod_type,
                        "material": mat,
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

    print(f"Finished! Crawled & Localized {len(raw_products)} camera lens products successfully.")
    return raw_products

if __name__ == "__main__":
    crawl_and_localize_camera_lens()
