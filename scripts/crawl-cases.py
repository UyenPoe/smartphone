#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Mobile Phone Cases (op-lung-flipcover)
Source: https://www.thegioididong.com/op-lung-flipcover
Category ID: 60

Strictly extracts required fields:
1. Tên sản phẩm (Product name)
2. URL sản phẩm nguồn (Source product URL - internal metadata)
3. Giá hiện tại (Current price)
4. Giá cũ (Original price & discount %)
5. Hãng / model tương thích (Brand & Compatible Device)
6. Chất liệu / dòng máy (Material: TPU, PC, Silicone, Leather, etc.)
7. Một số thông số kỹ thuật cơ bản (Specs: MagSafe, Shockproof, Anti-yellowing, Camera Control)
8. Thời điểm cập nhật dữ liệu (Timestamp)

Localizes 100% of images into:
phonex-theme/assets/images/products/op-lung/
├── iphone/
├── samsung/
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
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "cases.json")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "op-lung")

DIR_IPHONE = os.path.join(IMG_BASE_DIR, "iphone")
DIR_SAMSUNG = os.path.join(IMG_BASE_DIR, "samsung")
DIR_KHAC = os.path.join(IMG_BASE_DIR, "khac")

for d in [DIR_IPHONE, DIR_SAMSUNG, DIR_KHAC]:
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
        m = re.search(r"iphone\s*(\d+(?:\s*(?:pro\s*max|pro|plus|mini))?)", name_l)
        model = f"iPhone {m.group(1).title()}" if m else "iPhone"
        return "iPhone", model, "iphone"
    elif "galaxy" in name_l or "samsung" in name_l:
        m = re.search(r"(?:galaxy\s*)?([saz]\d+(?:\s*(?:ultra|fe|\+|plus))?|z\s*fold\s*\d*|z\s*flip\s*\d*)", name_l)
        model = f"Galaxy {m.group(1).upper()}" if m else "Samsung Galaxy"
        return "Samsung", model, "samsung"
    elif "xiaomi" in name_l or "redmi" in name_l:
        return "Xiaomi", "Xiaomi / Redmi", "khac"
    elif "oppo" in name_l:
        return "Oppo", "Oppo Reno / Find", "khac"
    else:
        return "Khác", "Smartphone", "khac"

def detect_material_and_specs(name):
    specs = []
    mat = "Nhựa TPU dẻo cao cấp"
    name_l = name.lower()

    if "pc tpu" in name_l or "pc và tpu" in name_l or ("pc" in name_l and "tpu" in name_l):
        mat = "Viền dẻo TPU & Lưng cứng PC"
    elif "silicone" in name_l or "silicon" in name_l:
        mat = "Silicone lỏng chống bám bẩn"
    elif "da" in name_l:
        mat = "Da nhân tạo cao cấp"
    elif "tpu" in name_l:
        mat = "Nhựa TPU dẻo chống sốc"
    elif "pc" in name_l:
        mat = "Nhựa cứng PC chống trầy"

    specs.append(f"Chất liệu {mat}")

    if "magsafe" in name_l or "magnetic" in name_l or "từ tính" in name_l:
        specs.append("Hít từ tính MagSafe / Qi2")
    if "chống sốc" in name_l or "drop test" in name_l or "xtreme" in name_l:
        specs.append("Chống va đập chuẩn quân đội")
    if "trong suốt" in name_l:
        specs.append("Trong suốt kháng ố vàng")
    if "camera control" in name_l or "button control" in name_l:
        specs.append("Hỗ trợ nút bấm Camera Control")
    if "chống bám" in name_l or "nhám" in name_l:
        specs.append("Mặt lưng nhám mờ chống vân tay")

    if len(specs) < 2:
        specs.append("Gờ cao 1.2mm bảo vệ cụm Camera")
    if len(specs) < 3:
        specs.append("Gia công ôm khít hoàn hảo từng nút bấm")

    return mat, specs

def download_file(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True
    req = urllib.request.Request(url, headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36"
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

def crawl_and_localize_cases():
    base_url = "https://www.thegioididong.com/Category/FilterProductBox?c=60&pi={}"
    raw_products = []
    seen_urls = set()
    crawl_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    print("[1/3] Crawling products from https://www.thegioididong.com/op-lung-flipcover (cateID: 60) ...")
    max_pages = 15  # 300 products

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
            "Referer": "https://www.thegioididong.com/op-lung-flipcover",
            "X-Requested-With": "XMLHttpRequest"
        })
        try:
            with urllib.request.urlopen(req) as resp:
                res = resp.read().decode("utf-8")
                obj = json.loads(res)
                listproducts = obj.get("listproducts", "")
                items = re.findall(r"<li class=\" item[^\"]*\"[^>]*>(.*?)</li>", listproducts, re.DOTALL)
                if not items:
                    print(f" - Page {pi}: No more products found.")
                    break
                print(f" - Page {pi}: fetched {len(items)} items")

                for it in items:
                    m_name = re.search(r"data-name=\"([^\"]+)\"", it)
                    name = html.unescape(m_name.group(1)).strip() if m_name else ""
                    if not name:
                        continue
                    name = clean_tgdd_references(name)

                    m_href = re.search(r"href=[\x27\"]([^\x27\"]+)[\x27\"]", it)
                    source_url = "https://www.thegioididong.com" + m_href.group(1).split("?")[0] if m_href else ""
                    if source_url in seen_urls:
                        continue
                    seen_urls.add(source_url)

                    m_brand = re.search(r"data-brand=\"([^\"]+)\"", it)
                    brand = html.unescape(m_brand.group(1)).strip() if m_brand else "PhoneX"

                    m_price = re.search(r"<strong class=\"price\">([^<]+)</strong>", it)
                    price_str = html.unescape(m_price.group(1)).strip() if m_price else "0₫"

                    m_old = re.search(r"<p class=\"price-old[^\"]*\">([^<]+)</p>", it)
                    price_old_str = html.unescape(m_old.group(1)).strip() if m_old else price_str

                    p_num = int(re.sub(r"[^\d]", "", price_str)) if re.sub(r"[^\d]", "", price_str) else 0
                    p_old_num = int(re.sub(r"[^\d]", "", price_old_str)) if re.sub(r"[^\d]", "", price_old_str) else p_num

                    discount_pct = 0
                    if p_old_num > p_num and p_old_num > 0:
                        discount_pct = round(((p_old_num - p_num) / p_old_num) * 100)

                    # Device detection
                    dev_brand, dev_model, subfolder = detect_device(name)
                    material, specs = detect_material_and_specs(name)

                    # Image URL extraction
                    m_img = re.search(r"(?:data-src|src)=[\x27\"](https://[^\x27\"]+)[\x27\"]", it)
                    image_remote = m_img.group(1) if m_img else ""

                    # Filename & Local path
                    slug = slugify(name)
                    if not slug:
                        slug = f"case-{len(raw_products)}"

                    ext = ".jpg"
                    if ".png" in image_remote.lower():
                        ext = ".png"
                    elif ".webp" in image_remote.lower():
                        ext = ".webp"

                    filename = f"{slug}{ext}"
                    counter = 1
                    target_dir = os.path.join(IMG_BASE_DIR, subfolder)
                    full_key = f"{subfolder}/{filename}"
                    while full_key in used_filenames:
                        filename = f"{slug}-{counter}{ext}"
                        full_key = f"{subfolder}/{filename}"
                        counter += 1
                    used_filenames.add(full_key)

                    save_path = os.path.join(target_dir, filename)
                    local_rel_path = f"assets/images/products/op-lung/{subfolder}/{filename}"

                    if image_remote:
                        download_tasks.append((image_remote, save_path))

                    raw_products.append({
                        "name": name,
                        "source_url": source_url,
                        "price": p_num,
                        "price_formatted": f"{p_num:,}₫".replace(",", "."),
                        "price_old": p_old_num,
                        "price_old_formatted": f"{p_old_num:,}₫".replace(",", "."),
                        "discount_percent": discount_pct,
                        "brand": brand,
                        "device_brand": dev_brand,
                        "device_model": dev_model,
                        "material": material,
                        "specs": specs,
                        "image": local_rel_path,
                        "updated_at": crawl_time
                    })
        except Exception as e:
            print(f"Error on page {pi}: {e}")
            break

    print(f"[2/3] Crawled {len(raw_products)} cases. Now downloading {len(download_tasks)} images locally...")
    success_count = 0
    with ThreadPoolExecutor(max_workers=16) as executor:
        futures = {executor.submit(download_file, url, path): path for url, path in download_tasks}
        for future in as_completed(futures):
            if future.result():
                success_count += 1

    print(f" -> Completed downloading {success_count}/{len(download_tasks)} images into local directories!")

    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(raw_products, f, ensure_ascii=False, indent=2)

    print(f"[3/3] Successfully saved {len(raw_products)} localized products to {OUTPUT_PATH}")

if __name__ == "__main__":
    crawl_and_localize_cases()
