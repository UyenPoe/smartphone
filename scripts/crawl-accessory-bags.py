#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Túi Đựng Phụ Kiện (tui-dung-phu-kien)
Source: https://www.thegioididong.com/tui-dung-phu-kien
Category ID: 13818, Total: ~73 sản phẩm

Phân loại:
phonex-theme/assets/images/products/tui-dung-phu-kien/
├── tui-deo-cheo-edc/   (Túi đeo chéo EDC, Sling bag công nghệ)
├── tui-dung-tech/      (Túi đựng phụ kiện, cáp sạc, tech organizer)
├── tui-bao-tu-mini/    (Túi bao tử, belt bag, waist pack)
└── khac/               (Bao da hộ chiếu Find My, túi du lịch, khác)
"""

import urllib.request
import urllib.parse
import json
import re
import html as html_lib
import os
import unicodedata
import time
from datetime import datetime
from concurrent.futures import ThreadPoolExecutor, as_completed

THEME_DIR = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme")
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "accessory-bags.json")
IMG_BASE = os.path.join(THEME_DIR, "assets", "images", "products", "tui-dung-phu-kien")

SUBDIRS = {
    "tui-deo-cheo-edc": os.path.join(IMG_BASE, "tui-deo-cheo-edc"),
    "tui-dung-tech":    os.path.join(IMG_BASE, "tui-dung-tech"),
    "tui-bao-tu-mini":  os.path.join(IMG_BASE, "tui-bao-tu-mini"),
    "khac":             os.path.join(IMG_BASE, "khac"),
}
for d in SUBDIRS.values():
    os.makedirs(d, exist_ok=True)


def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)[:50]


def clean_text(text):
    if not text:
        return ""
    text = re.sub(r"Thế\s*Giới\s*Di\s*Động|TGDD|thegioididong\.com", "PhoneX", text, flags=re.IGNORECASE)
    text = re.sub(r"Điện\s*Máy\s*XANH|DMX", "PhoneX", text, flags=re.IGNORECASE)
    return text.strip()


def detect_type(name, brand="", raw_compare=""):
    nl = name.lower()

    # Compare specs
    clean_comp = ""
    if raw_compare:
        clean_comp = re.sub(r'<[^>]+>', '', raw_compare).strip()
        clean_comp = html_lib.unescape(clean_comp)

    # Material & Feature specs
    mat_feature = clean_comp if clean_comp else "Vải trượt nước chống thấm"
    if "cordura" in nl:
        mat_feature = "Vải Cordura chống mài mòn quân đội"
    elif "x-pac" in nl:
        mat_feature = "Vải công nghệ X-Pac siêu bền, chống thấm tuyệt đối"
    elif "rfid" in nl:
        mat_feature = "Ngăn chống trộm sóng RFID bảo mật thẻ"
    elif "find my" in nl or "find my" in clean_comp.lower():
        mat_feature = "Tích hợp định vị Apple Find My thông minh"

    if any(k in nl for k in ["organizer", "powershuttle", "đựng phụ kiện", "dung phu kien", "pixoo", "electronic"]):
        subfolder = "tui-dung-tech"
        prod_type = "Túi Đựng Tech & Cáp Sạc"
        specs = [
            mat_feature,
            "Thiết kế nhiều ngăn đàn hồi phân chia củ sạc, cáp sạc, chuột & pin dự phòng",
            "Đệm bảo vệ chống sốc chống va đập cho phụ kiện công nghệ"
        ]
    elif any(k in nl for k in ["belt bag", "waist", "fifth avenue", "bao tử", "quick pack", "slingbean"]):
        subfolder = "tui-bao-tu-mini"
        prod_type = "Túi Bao Tử & Đeo Hông"
        specs = [
            mat_feature,
            "Nhỏ gọn năng động, tiện lợi chứa điện thoại, ví tiền và chìa khóa",
            "Khóa bấm an toàn chắc chắn, quai đeo tùy chỉnh ôm sát cơ thể"
        ]
    elif any(k in nl for k in ["hộ chiếu", "passport", "tote", "du lịch"]):
        subfolder = "khac"
        prod_type = "Phụ Kiện Du Lịch & Khác"
        specs = [
            mat_feature,
            "Chất liệu cao cấp, nhỏ gọn và thanh lịch",
            "Đồng hành lý tưởng trong mọi chuyến du lịch và công tác"
        ]
    else:
        # Default: Túi đeo chéo EDC / Sling Bag
        subfolder = "tui-deo-cheo-edc"
        prod_type = "Túi Đeo Chéo EDC"
        specs = [
            mat_feature,
            "Đệm vai êm ái thoáng khí, khóa kéo YKK Nhật Bản mượt mà",
            "Đa ngăn chứa vừa vặn iPad / Tablet mini, điện thoại và phụ kiện cá nhân"
        ]

    return prod_type, subfolder, specs


def download_file(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True
    url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', url)
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"})
    for attempt in range(3):
        try:
            with urllib.request.urlopen(req, timeout=15) as resp:
                data = resp.read()
                if len(data) > 500:
                    with open(save_path, "wb") as f:
                        f.write(data)
                    return True
        except Exception:
            if attempt < 2:
                time.sleep(1)
    return False


def fetch_page(pi):
    url = f"https://www.thegioididong.com/Category/FilterProductBox?c=13818&pi={pi}"
    post_data = urllib.parse.urlencode({
        "IsParentCate": "false", "IsShowCompare": "false",
        "IsAffiliate": "false", "prevent": "true"
    }).encode()
    req = urllib.request.Request(url, data=post_data, method="POST", headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36",
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        "X-Requested-With": "XMLHttpRequest",
        "Referer": "https://www.thegioididong.com/tui-dung-phu-kien",
    })
    try:
        with urllib.request.urlopen(req, timeout=20) as resp:
            raw = json.loads(resp.read().decode('utf-8', errors='ignore'))
            return raw.get("total", 0), raw.get("listproducts", "")
    except Exception as e:
        print(f"  Error page {pi}: {e}")
        return 0, ""


def parse_items(html_frag):
    products = []
    seen = set()
    li_blocks = re.findall(
        r'<li\s+class="[^"]*item[^"]*__cate_13818[^"]*"\s+[^>]*data-id="(\d+)"[^>]*data-price="([\d.]+)"[^>]*>(.*?)</li>',
        html_frag, re.DOTALL
    )
    for prod_id, li_price_str, li_html in li_blocks:
        if prod_id in seen:
            continue
        seen.add(prod_id)
        li_price = int(float(li_price_str))
        a_price_m = re.search(r'<a\s+href=[^>]*data-price="([\d.]+)"', li_html)
        cur_price = int(float(a_price_m.group(1))) if a_price_m else li_price
        old_price = li_price if li_price > cur_price else 0
        discount_pct = round((old_price - cur_price) / old_price * 100) if old_price > cur_price else 0

        name_m = re.search(r'data-name="([^"]+)"', li_html)
        name = html_lib.unescape(name_m.group(1)).strip() if name_m else ""
        name = clean_text(name)
        if not name:
            continue

        href_m = re.search(r"href='(/tui-dung-phu-kien/[^'?]+)'", li_html)
        if not href_m:
            href_m = re.search(r'href="(/tui-dung-phu-kien/[^"?]+)"', li_html)
        href = href_m.group(1) if href_m else f"/tui-dung-phu-kien/product-{prod_id}"

        brand_m = re.search(r'data-brand="([^"]+)"', li_html)
        brand = html_lib.unescape(brand_m.group(1)).strip() if brand_m else ""

        # Extract real product image from Products/Images
        img_m = re.search(r'data-src="(https://(?:cdn|cdnv2)\.tgdd\.vn/[^"]*?Products/Images/[^"]+)"', li_html)
        if not img_m:
            img_m = re.search(r'data-src="(https://(?:cdn|cdnv2)\.tgdd\.vn/[^"]+)"', li_html)
            if img_m and "common/sample" in img_m.group(1):
                img_m = None
        img_url = img_m.group(1) if img_m else ""
        if img_url:
            img_url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', img_url)
        if not img_url:
            continue

        comp_m = re.search(r'<div class="item-compare[^"]*">(.*?)</div>', li_html, re.DOTALL)
        raw_compare = comp_m.group(1) if comp_m else ""

        products.append({
            "id": prod_id, "name": name,
            "source_url": "https://www.thegioididong.com" + href,
            "brand": brand, "price": cur_price, "old_price": old_price,
            "discount_pct": discount_pct, "image_remote": img_url,
            "raw_compare": raw_compare,
        })
    return products


def crawl():
    print("=" * 60)
    print("PhoneX Crawler: Túi Đựng Phụ Kiện (tui-dung-phu-kien)")
    print("API: POST /Category/FilterProductBox?c=13818&pi={n}")
    print("=" * 60)

    all_raw = {}
    total, frag = fetch_page(0)
    print(f"Total reported: {total}")
    for item in parse_items(frag):
        all_raw[item["id"]] = item
    print(f"  Page 0: {len(all_raw)} items")

    pages = 5
    for pi in range(1, pages):
        time.sleep(0.35)
        _, frag = fetch_page(pi)
        items = parse_items(frag)
        new = 0
        for item in items:
            if item["id"] not in all_raw:
                all_raw[item["id"]] = item
                new += 1
        print(f"  Page {pi}: {len(items)} items ({new} new), total: {len(all_raw)}")
        if len(items) == 0:
            break

    print(f"\nUnique products: {len(all_raw)}")

    products = []
    for item in all_raw.values():
        name, brand = item["name"], item.get("brand", "")
        raw_compare = item.get("raw_compare", "")
        prod_type, subfolder, specs = detect_type(name, brand, raw_compare)
        img_remote = item.get("image_remote", "")
        ext = ".jpg"
        if img_remote:
            ext_m = re.search(r'\.(jpg|jpeg|png|webp)$', img_remote, re.IGNORECASE)
            if ext_m:
                ext = "." + ext_m.group(1).lower()
        local_path = f"assets/images/products/tui-dung-phu-kien/{subfolder}/{item['id']}-{slugify(name)}{ext}"
        products.append({
            "id": item["id"], "name": name,
            "source_url": item["source_url"], "brand": brand,
            "type": prod_type, "subfolder": subfolder,
            "price": item["price"], "old_price": item["old_price"],
            "discount_pct": item["discount_pct"], "specs": specs,
            "image_remote": img_remote, "image": local_path,
            "updated_at": datetime.now().strftime("%Y-%m-%dT%H:%M:%S"),
        })

    print(f"\nDownloading {len(products)} images...")
    success = fail = 0
    with ThreadPoolExecutor(max_workers=8) as executor:
        futures = {executor.submit(download_file, p["image_remote"], os.path.join(THEME_DIR, p["image"])): p["name"]
                   for p in products if p["image_remote"]}
        for future in as_completed(futures):
            if future.result():
                success += 1
            else:
                fail += 1
                print(f"  ✗ {futures[future][:50]}")
    print(f"  Images: {success} OK, {fail} FAIL")

    os.makedirs(os.path.dirname(OUTPUT_PATH), exist_ok=True)
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)
    print(f"\n✓ Saved {len(products)} → {OUTPUT_PATH}")

    from collections import Counter
    for folder, cnt in sorted(Counter(p["subfolder"] for p in products).items()):
        img_dir = os.path.join(THEME_DIR, "assets", "images", "products", "tui-dung-phu-kien", folder)
        actual = len([x for x in os.listdir(img_dir) if os.path.isfile(os.path.join(img_dir, x))]) if os.path.exists(img_dir) else 0
        print(f"  {folder}/: {cnt} products, {actual} images on disk")

    return products


if __name__ == "__main__":
    crawl()
