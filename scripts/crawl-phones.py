#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Crawl brand new phones from TheGioiDiDong (https://www.thegioididong.com/dtdd)
and save local assets + standardized JSON dataset for PhoneX.
"""

import os
import re
import json
import urllib.request
import urllib.parse
import unicodedata
import html
from datetime import datetime
import random

random.seed(42)

THEME_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "phonex-theme"))
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "dien-thoai")
DATA_FILE = os.path.join(THEME_DIR, "data", "phones.json")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language": "vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7",
}

BRAND_SOURCES = [
    ("dtdd", "All", "khac"),
    ("dtdd-apple-iphone", "Apple", "apple"),
    ("dtdd-samsung", "Samsung", "samsung"),
    ("dtdd-oppo", "OPPO", "oppo"),
    ("dtdd-xiaomi", "Xiaomi", "xiaomi"),
    ("dtdd-vivo", "Vivo", "vivo"),
    ("dtdd-realme", "Realme", "realme"),
    ("dtdd-honor", "Honor", "khac"),
    ("dtdd-tecno", "Tecno", "khac"),
    ("dtdd-motorola", "Motorola", "khac"),
    ("dtdd-nothing-phone", "Nothing Phone", "khac"),
    ("dtdd-nokia", "Nokia", "khac"),
    ("dtdd-masstel", "Masstel", "khac"),
    ("dtdd-mobell", "Mobell", "khac"),
]

def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)

def parse_price(val_str):
    if not val_str:
        return 0
    clean = re.sub(r'[^\d]', '', str(val_str).split('.')[0])
    return int(clean) if clean else 0

def download_image(url, target_path):
    if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
        return True

    if url.startswith("//"):
        url = "https:" + url

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
    print("=== PhoneX New Phones Crawler (TGDD dtdd) ===")
    print(f"Target image directory: {IMG_BASE_DIR}")
    print(f"Target data file: {DATA_FILE}")

    for sub in ["apple", "samsung", "oppo", "xiaomi", "vivo", "realme", "khac"]:
        os.makedirs(os.path.join(IMG_BASE_DIR, sub), exist_ok=True)

    all_products = {}

    for slug, brand_hint, default_sub in BRAND_SOURCES:
        url = f"https://www.thegioididong.com/{slug}"
        print(f"\n[Crawling] {brand_hint} -> {url}")

        try:
            req = urllib.request.Request(url, headers=HEADERS)
            raw = urllib.request.urlopen(req, timeout=15).read().decode("utf-8", errors="ignore")
            matches = re.finditer(r'<a\s+([^>]*class=[\'\"][^\'\"]*main-contain[^\'\"]*[\'\"][^>]*)>(.*?)</a>', raw, re.DOTALL)

            count = 0
            for m in matches:
                tag = m.group(1)
                inner = m.group(2)

                id_m = re.search(r'data-id=[\'\"](\d+)[\'\"]', tag)
                name_m = re.search(r'data-name=[\'\"]([^\'\"]+)[\'\"]', tag)
                price_m = re.search(r'data-price=[\'\"]([^\'\"]+)[\'\"]', tag)
                brand_m = re.search(r'data-brand=[\'\"]([^\'\"]+)[\'\"]', tag)
                img_m = re.search(r'src=[\'\"]([^\"\']+)[\'\"]|data-src=[\'\"]([^\"\']+)[\'\"]', inner)

                pid = id_m.group(1) if id_m else ''
                raw_name = html.unescape(name_m.group(1)).strip() if name_m else ''
                price_val = price_m.group(1) if price_m else ''
                raw_brand = html.unescape(brand_m.group(1)).strip() if brand_m else brand_hint
                raw_img = img_m.group(1) or img_m.group(2) if img_m else ''

                if not pid or not raw_name:
                    continue

                price = parse_price(price_val)
                if price <= 0:
                    # try to extract from strong.price
                    p_text_m = re.search(r'class=[\'\"]price[\'\"][^>]*>(.*?)</strong>', inner)
                    if p_text_m:
                        price = parse_price(p_text_m.group(1))

                # Old price & discount
                box_old_m = re.search(r'class=[\'\"]price-old[\'\"][^>]*>(.*?)</span>', inner, re.DOTALL)
                box_dis_m = re.search(r'class=[\'\"]percent[\'\"][^>]*>(.*?)</span>', inner)

                old_price = 0
                if box_old_m:
                    old_price = parse_price(box_old_m.group(1))

                dis_pct = 0
                if box_dis_m:
                    dis_pct = parse_price(box_dis_m.group(1))

                if price > 0 and old_price <= price:
                    # generate realistic small discount if flagship has promo
                    if dis_pct > 0:
                        old_price = int(price / (1 - dis_pct / 100))
                    else:
                        dis_pct = random.choice([0, 5, 8, 10, 12, 15])
                        if dis_pct > 0:
                            old_price = int(price * (1 + dis_pct / 100))
                        else:
                            old_price = price

                # Extract specs from item-compare
                specs_spans = re.findall(r'<div[^>]*class=[\'\"][^\'\"]*item-compare[^\'\"]*[\'\"][^>]*>(.*?)</div>', inner, re.DOTALL)
                specs_text = ""
                if specs_spans:
                    spans = re.findall(r'<span[^>]*>(.*?)</span>', specs_spans[0], re.DOTALL)
                    clean_spans = [html.unescape(s.strip()) for s in spans if s.strip()]
                    specs_text = " • ".join(clean_spans[:3])

                # Brand normalization
                brand = raw_brand
                subfolder = default_sub
                name_upper = raw_name.upper()

                if "IPHONE" in name_upper or "APPLE" in name_upper or "iPhone" in brand:
                    brand = "Apple"
                    subfolder = "apple"
                    os_type = "ios"
                elif "SAMSUNG" in name_upper or "GALAXY" in name_upper or "Samsung" in brand:
                    brand = "Samsung"
                    subfolder = "samsung"
                    os_type = "android"
                elif "OPPO" in name_upper or "RENO" in name_upper:
                    brand = "OPPO"
                    subfolder = "oppo"
                    os_type = "android"
                elif "XIAOMI" in name_upper or "REDMI" in name_upper or "POCO" in name_upper:
                    brand = "Xiaomi"
                    subfolder = "xiaomi"
                    os_type = "android"
                elif "VIVO" in name_upper:
                    brand = "Vivo"
                    subfolder = "vivo"
                    os_type = "android"
                elif "REALME" in name_upper:
                    brand = "Realme"
                    subfolder = "realme"
                    os_type = "android"
                elif "HONOR" in name_upper:
                    brand = "Honor"
                    subfolder = "khac"
                    os_type = "android"
                elif "MOTOROLA" in name_upper:
                    brand = "Motorola"
                    subfolder = "khac"
                    os_type = "android"
                elif "NOTHING" in name_upper:
                    brand = "Nothing Phone"
                    subfolder = "khac"
                    os_type = "android"
                elif "NOKIA" in name_upper:
                    brand = "Nokia"
                    subfolder = "khac"
                    os_type = "android"
                else:
                    os_type = "android"

                # Storage capacity
                cap_m = re.search(r'\b(64GB|128GB|256GB|512GB|1TB|2TB)\b', name_upper)
                capacity = cap_m.group(1) if cap_m else "128GB"

                # Demands
                demands = []
                if price >= 18000000 or "PRO" in name_upper or "ULTRA" in name_upper:
                    demands.extend(["gaming", "camera", "luxury"])
                if "FOLD" in name_upper or "FLIP" in name_upper or "RAZR" in name_upper:
                    demands.append("foldable")
                if price <= 8000000:
                    demands.extend(["budget", "battery"])
                if not demands:
                    demands = ["battery"]

                # Title clean
                clean_name = raw_name
                if not clean_name.startswith("Điện thoại "):
                    clean_name = "Điện thoại " + clean_name

                # Image URL
                if raw_img.startswith("//"):
                    raw_img = "https:" + raw_img
                if "https://cdn.tgdd.vn/" in raw_img:
                    remote_img = "https://cdn.tgdd.vn/" + raw_img.split("https://cdn.tgdd.vn/")[1]
                else:
                    remote_img = raw_img

                item_slug = slugify(clean_name.replace("Điện thoại ", ""))
                filename = f"{pid}-{item_slug}.jpg"
                rel_img_path = f"assets/images/products/dien-thoai/{subfolder}/{filename}"
                abs_img_path = os.path.join(THEME_DIR, rel_img_path)

                if pid not in all_products:
                    count += 1
                    all_products[pid] = {
                        "id": pid,
                        "name": clean_name,
                        "brand": brand,
                        "capacity": capacity,
                        "price": price if price > 0 else 12990000,
                        "price_old": old_price if old_price > 0 else int(price * 1.1),
                        "discount_pct": dis_pct,
                        "specs": specs_text or "Chính hãng VN/A • Mới 100% nguyên seal",
                        "os": os_type,
                        "demands": ",".join(list(set(demands))),
                        "reviews": random.randint(25, 280),
                        "rating": "5.0",
                        "is_new": (dis_pct == 0 or int(pid) >= 360000),
                        "image_remote": remote_img,
                        "image": rel_img_path,
                        "abs_image": abs_img_path,
                        "permalink": f"/dien-thoai/{item_slug}/",
                        "updated_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
                    }

            print(f" -> Added {count} new models for {brand_hint}")

        except Exception as e:
            print(f"Error crawling {brand_hint}: {e}")

    print(f"\n==========================================")
    print(f"Total unique phone products gathered: {len(all_products)}")
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
                fail_imgs += 1
        else:
            fail_imgs += 1

        del item["abs_image"]

    print(f"Image download complete: {success_imgs} succeeded, {fail_imgs} failed.")

    # Save to phones.json
    os.makedirs(os.path.dirname(DATA_FILE), exist_ok=True)
    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(product_list, f, ensure_ascii=False, indent=2)

    print(f"Data saved to {DATA_FILE}")

if __name__ == "__main__":
    main()
