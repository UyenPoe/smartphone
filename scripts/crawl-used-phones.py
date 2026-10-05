#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Crawl used phones (điện thoại cũ giá tốt / máy đổi trả) from TGDD
and save local assets + standardized JSON dataset for PhoneX.
"""

import os
import re
import json
import urllib.request
import urllib.parse
import unicodedata
from datetime import datetime

THEME_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "phonex-theme"))
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "dien-thoai-cu")
DATA_FILE = os.path.join(THEME_DIR, "data", "used-phones.json")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language": "vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7",
}

BRAND_SOURCES = [
    ("Apple", "dtdd-apple-iphone", "iphone", "iPhone Cũ Like New"),
    ("Samsung", "dtdd-samsung", "samsung", "Samsung Galaxy Cũ"),
    ("Xiaomi", "dtdd-xiaomi", "xiaomi", "Xiaomi & Redmi Cũ"),
    ("OPPO", "dtdd-oppo", "oppo", "OPPO Cũ Giá Tốt"),
    ("Vivo", "dtdd-vivo", "khac", "Vivo Cũ Giá Tốt"),
    ("Realme", "dtdd-realme", "khac", "Realme Cũ Giá Tốt"),
    ("Honor", "dtdd-honor", "khac", "Honor Cũ Giá Tốt"),
    ("Tecno", "dtdd-tecno", "khac", "Tecno Cũ Giá Tốt"),
    ("Motorola", "dtdd-motorola", "khac", "Motorola Cũ"),
    ("Nokia", "dtdd-nokia", "khac", "Nokia Cũ"),
    ("Masstel", "dtdd-masstel", "khac", "Điện Thoại Phổ Thông Cũ"),
    ("Mobell", "dtdd-mobell", "khac", "Điện Thoại Phổ Thông Cũ"),
    ("All", "dtdd", "khac", "Smartphone Cũ Tổng Hợp")
]

def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)

def parse_price(val_str):
    if not val_str:
        return 0
    clean = re.sub(r'[^\d]', '', val_str)
    return int(clean) if clean else 0

def download_image(url, target_path):
    if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
        return True
    
    # Try high-res 600x600 if available
    high_res_urls = []
    if "-200x200." in url:
        high_res_urls.append(url.replace("-200x200.", "-600x600."))
        high_res_urls.append(url.replace("-200x200.", "."))
    high_res_urls.append(url)

    for u in high_res_urls:
        try:
            req = urllib.request.Request(u, headers=HEADERS)
            with urllib.request.urlopen(req, timeout=10) as response:
                if response.status == 200:
                    content = response.read()
                    if len(content) > 1000:
                        os.makedirs(os.path.dirname(target_path), exist_ok=True)
                        with open(target_path, "wb") as f:
                            f.write(content)
                        return True
        except Exception:
            continue
    return False

def main():
    print("=== PhoneX Used Phones Crawler ===")
    print(f"Target image directory: {IMG_BASE_DIR}")
    print(f"Target data file: {DATA_FILE}")

    for sub in ["iphone", "samsung", "xiaomi", "oppo", "khac"]:
        os.makedirs(os.path.join(IMG_BASE_DIR, sub), exist_ok=True)

    card_regex = re.compile(
        r'<a\s+href=[\"\'](/may-doi-tra/dtdd/[^\"\']+)[\"\'][^>]*>(.*?)</a>',
        re.DOTALL
    )

    all_products = {}

    for brand_name, slug, subfolder, default_type in BRAND_SOURCES:
        url = f"https://www.thegioididong.com/may-doi-tra/{slug}" if slug != "dtdd" else "https://www.thegioididong.com/may-doi-tra/dtdd"
        print(f"\n[Crawling] {brand_name} -> {url}")

        try:
            req = urllib.request.Request(url, headers=HEADERS)
            html = urllib.request.urlopen(req, timeout=15).read().decode("utf-8", errors="ignore")
            matches = card_regex.findall(html)
            print(f" -> Found {len(matches)} product items")

            for href, inner in matches:
                # Name
                name_m = re.search(r'class=[\"\']prdName[\"\'][^>]*>(.*?)</div>', inner, re.DOTALL)
                raw_name = " ".join(name_m.group(1).strip().split()) if name_m else ""
                if not raw_name:
                    continue

                # Remove any TGDD prefix if present
                clean_name = raw_name.replace("Điện thoại ", "").strip()

                # Product ID
                pid_m = re.search(r'pid=(\d+)', href)
                if pid_m:
                    pid = pid_m.group(1)
                else:
                    # extract from href slug
                    pid = slugify(clean_name)[:20]

                # Price current
                price_m = re.search(r'<strong[^>]*>(.*?)</strong>', inner)
                price_str = price_m.group(1).strip() if price_m else ""
                price = parse_price(price_str)
                if price <= 0:
                    continue

                # Old Price (Mới)
                old_m = re.search(r'Giá sản phẩm mới:\s*([^<]+)', inner)
                old_str = old_m.group(1).strip() if old_m else ""
                old_price = parse_price(old_str)
                if old_price <= price:
                    old_price = int(price * 1.35)

                # Discount percentage
                dis_m = re.search(r'class=[\"\']lblDis[\"\'][^>]*>(.*?)</label>', inner, re.DOTALL)
                dis_str = dis_m.group(1).strip() if dis_m else ""
                dis_pct = parse_price(dis_str)
                if dis_pct <= 0 and old_price > price:
                    dis_pct = round(((old_price - price) / old_price) * 100)

                # Image
                img_m = re.search(r'src=[\"\']([^\"\']+)[\"\']', inner)
                raw_img = img_m.group(1) if img_m else ""
                if 'https://cdn.tgdd.vn/' in raw_img:
                    remote_img = 'https://cdn.tgdd.vn/' + raw_img.split('https://cdn.tgdd.vn/')[1]
                else:
                    remote_img = raw_img

                # Quantity in stock
                qty_m = re.search(r'class=[\"\']quantity[\"\'][^>]*>.*?<span>(.*?)</span>', inner, re.DOTALL)
                qty_text = qty_m.group(1).strip() if qty_m else ""
                stock_num = parse_price(qty_text) if qty_text else 1
                if stock_num <= 0:
                    stock_num = 1

                # Detect actual brand
                detected_brand = brand_name
                name_upper = clean_name.upper()
                if "IPHONE" in name_upper or "APPLE" in name_upper:
                    detected_brand = "Apple"
                    item_subfolder = "iphone"
                    item_type = "iPhone Cũ Like New"
                elif "SAMSUNG" in name_upper or "GALAXY" in name_upper:
                    detected_brand = "Samsung"
                    item_subfolder = "samsung"
                    item_type = "Samsung Galaxy Cũ"
                elif "XIAOMI" in name_upper or "REDMI" in name_upper or "POCO" in name_upper:
                    detected_brand = "Xiaomi"
                    item_subfolder = "xiaomi"
                    item_type = "Xiaomi & Redmi Cũ"
                elif "OPPO" in name_upper or "RENO" in name_upper:
                    detected_brand = "OPPO"
                    item_subfolder = "oppo"
                    item_type = "OPPO Cũ Giá Tốt"
                elif "VIVO" in name_upper:
                    detected_brand = "Vivo"
                    item_subfolder = "khac"
                    item_type = "Vivo Cũ Giá Tốt"
                elif "REALME" in name_upper:
                    detected_brand = "Realme"
                    item_subfolder = "khac"
                    item_type = "Realme Cũ Giá Tốt"
                elif "HONOR" in name_upper:
                    detected_brand = "Honor"
                    item_subfolder = "khac"
                    item_type = "Honor Cũ Giá Tốt"
                elif "TECNO" in name_upper:
                    detected_brand = "Tecno"
                    item_subfolder = "khac"
                    item_type = "Tecno Cũ Giá Tốt"
                elif "MOTOROLA" in name_upper:
                    detected_brand = "Motorola"
                    item_subfolder = "khac"
                    item_type = "Motorola Cũ"
                elif "NOKIA" in name_upper:
                    detected_brand = "Nokia"
                    item_subfolder = "khac"
                    item_type = "Nokia Cũ"
                else:
                    detected_brand = brand_name if brand_name != "All" else "Khác"
                    item_subfolder = subfolder
                    item_type = default_type

                # File naming
                item_slug = slugify(clean_name)
                filename = f"{pid}-{item_slug}.jpg"
                rel_img_path = f"assets/images/products/dien-thoai-cu/{item_subfolder}/{filename}"
                abs_img_path = os.path.join(THEME_DIR, rel_img_path)

                # Condition & specs generator
                if dis_pct > 35:
                    condition = "Grade B 98%"
                    battery = "Pin 90% - 94% (Zin nguyên bản)"
                else:
                    condition = "Grade A 99%"
                    battery = "Pin 95% - 100% (Zin keng)"

                specs = [
                    f"Tình trạng máy: {condition} • {battery}",
                    "Kiểm định kỹ thuật toàn diện PhoneX Certified",
                    "Bảo hành 12 tháng toàn diện, 1 đổi 1 trong 30 ngày đầu"
                ]

                clean_key = f"{detected_brand}-{item_slug}"
                if clean_key not in all_products:
                    all_products[clean_key] = {
                        "id": pid,
                        "name": f"[{condition}] {clean_name}",
                        "raw_name": clean_name,
                        "brand": detected_brand,
                        "type": item_type,
                        "subfolder": item_subfolder,
                        "condition": condition,
                        "battery": battery,
                        "stock_quantity": stock_num,
                        "price": price,
                        "old_price": old_price,
                        "discount_pct": dis_pct,
                        "specs": specs,
                        "image_remote": remote_img,
                        "image": rel_img_path,
                        "abs_image": abs_img_path,
                        "updated_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
                    }

        except Exception as e:
            print(f"Error crawling {brand_name}: {e}")

    print(f"\n==========================================")
    print(f"Total unique products gathered: {len(all_products)}")
    print(f"Downloading images locally...")

    success_imgs = 0
    fail_imgs = 0

    product_list = list(all_products.values())
    for item in product_list:
        remote = item["image_remote"]
        local = item["abs_image"]
        if remote:
            if download_image(remote, local):
                success_imgs += 1
            else:
                print(f"Failed to download image for: {item['name']} ({remote})")
                fail_imgs += 1
        else:
            fail_imgs += 1

        del item["abs_image"]

    print(f"Image download complete: {success_imgs} succeeded, {fail_imgs} failed.")

    # Save to used-phones.json
    os.makedirs(os.path.dirname(DATA_FILE), exist_ok=True)
    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(product_list, f, ensure_ascii=False, indent=2)

    print(f"Data saved to {DATA_FILE}")

if __name__ == "__main__":
    main()
