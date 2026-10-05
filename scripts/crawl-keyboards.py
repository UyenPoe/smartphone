#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Bàn Phím (ban-phim)
Source: https://www.thegioididong.com/ban-phim
Category ID: 4547, Total: ~180 sản phẩm

API: POST /Category/FilterProductBox?c=4547&pi={page_index}
     JSON response: { total, listproducts (HTML string) }

Phân loại ảnh:
phonex-theme/assets/images/products/ban-phim/
├── ban-phim-co-day/       (có dây, wired)
├── ban-phim-khong-day/    (không dây, wireless)
├── ban-phim-gaming/       (gaming, mechanical, RGB)
├── ban-phim-bluetooth/    (bluetooth, multi-device)
└── khac/                  (foldable, presenter, khác)
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
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "keyboards.json")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "ban-phim")

SUBDIRS = {
    "ban-phim-gaming":     os.path.join(IMG_BASE_DIR, "ban-phim-gaming"),
    "ban-phim-bluetooth":  os.path.join(IMG_BASE_DIR, "ban-phim-bluetooth"),
    "ban-phim-khong-day":  os.path.join(IMG_BASE_DIR, "ban-phim-khong-day"),
    "ban-phim-co-day":     os.path.join(IMG_BASE_DIR, "ban-phim-co-day"),
    "khac":                os.path.join(IMG_BASE_DIR, "khac"),
}
for d in SUBDIRS.values():
    os.makedirs(d, exist_ok=True)


def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)[:70]


def clean_tgdd(text):
    if not text:
        return ""
    text = re.sub(r"Thế\s*Giới\s*Di\s*Động|TGDD|thegioididong\.com", "PhoneX", text, flags=re.IGNORECASE)
    text = re.sub(r"Điện\s*Máy\s*XANH|DMX", "PhoneX", text, flags=re.IGNORECASE)
    return text.strip()


def detect_type(name, brand=""):
    nl = name.lower()

    # Gaming / mechanical first (highest priority)
    if any(k in nl for k in ["gaming", "mechanical", "rgb", "tenkeyless", "tkl", "keychron",
                              "switch", "red switch", "blue switch", "g915", "g813",
                              "blackwidow", "huntsman", "cynosa", "ornata",
                              "rog", "tuf", "strix", "scope", "dareu", "edra gaming",
                              "akko", "fl-esports", "fl esports", "ajazz", "redragon",
                              "nuphy"]):
        subfolder = "ban-phim-gaming"
        prod_type = "Bàn phím gaming / cơ"
        specs = ["Công nghệ switch cơ (Mechanical) hoặc màng độ bền cao",
                 "Độ phản hồi cực nhanh, click chính xác mỗi phím bấm"]
        if "rgb" in nl or any(k in nl for k in ["g915", "g813", "ornata", "blackwidow"]):
            specs.append("Đèn LED RGB 16.8 triệu màu, hiệu ứng ánh sáng đẹp mắt")
        if "không dây" in nl or "wireless" in nl or "khong day" in nl:
            specs.append("Kết nối không dây 2.4GHz + Bluetooth đa thiết bị")
        else:
            specs.append("Kết nối USB có dây ổn định, cắm là chơi (Plug & Play)")

    # Bluetooth
    elif "bluetooth" in nl or any(k in nl for k in ["multi-device", "multi device", "k380",
                                                      "k480", "k580", "slim folio", "k575"]):
        subfolder = "ban-phim-bluetooth"
        prod_type = "Bàn phím Bluetooth"
        specs = ["Kết nối Bluetooth 5.0 đa thiết bị (tối đa 3 thiết bị cùng lúc)",
                 "Pin sạc USB-C hoặc pin AA dùng lâu nhiều tháng",
                 "Mỏng nhẹ, gọn gàng – hoàn hảo cho laptop, iPad và điện thoại"]
        if brand.lower() == "apple":
            specs.append("Magic Keyboard tích hợp Touch ID, tối ưu hệ sinh thái Apple")
        elif brand.lower() == "logitech":
            specs.append("Công nghệ Logi Bolt – ghép nối nhanh, tín hiệu ổn định")

    # Wireless (non-bluetooth, 2.4GHz dongle)
    elif any(k in nl for k in ["không dây", "khong day", "wireless", "nano receiver",
                                "usb receiver", "2.4ghz", "2.4 ghz"]):
        subfolder = "ban-phim-khong-day"
        prod_type = "Bàn phím không dây"
        specs = ["Kết nối không dây 2.4GHz qua USB Nano Receiver siêu nhỏ",
                 "Pin AA/AAA dùng lâu hoặc pin sạc tích hợp tiện lợi",
                 "Gõ êm ái, chống văng bụi, phù hợp làm việc văn phòng"]

    # Wired (default for named wired keyboards)
    elif any(k in nl for k in ["có dây", "co day", "wired", "usb-a", "type-c",
                                "k120", "k270", "k840", "k845"]):
        subfolder = "ban-phim-co-day"
        prod_type = "Bàn phím có dây"
        specs = ["Kết nối USB có dây độ ổn định tuyệt đối, không lag",
                 "Cắm là dùng (Plug & Play), không cần cài driver",
                 "Bố cục đầy đủ Full-size hoặc compact tiết kiệm không gian"]

    else:
        # Detect by name clues
        if any(k in nl for k in ["magic keyboard", "magic"]) and brand.lower() == "apple":
            subfolder = "ban-phim-bluetooth"
            prod_type = "Bàn phím Bluetooth"
            specs = ["Magic Keyboard – thiết kế mỏng thanh lịch, tích hợp Touch ID",
                     "Kết nối Bluetooth tự động ghép nối với Mac, iPad",
                     "Pin sạc USB-C dùng nhiều tuần mỗi lần sạc"]
        elif any(k in nl for k in ["k120", "k270", "k360", "k520"]):
            subfolder = "ban-phim-co-day"
            prod_type = "Bàn phím có dây"
            specs = ["Bàn phím có dây kết nối USB bền bỉ, gõ êm",
                     "Thiết kế chống văng bụi phù hợp văn phòng",
                     "Bố cục QWERTY chuẩn, phím số đầy đủ"]
        else:
            subfolder = "ban-phim-co-day"
            prod_type = "Bàn phím văn phòng"
            specs = ["Bố cục phím chuẩn, gõ êm ái, không gây mỏi tay",
                     "Thiết kế gọn nhẹ, phù hợp làm việc văn phòng cả ngày",
                     "Tương thích Windows, macOS, ChromeOS"]

    return prod_type, subfolder, specs


def download_file(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True
    url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', url)
    req = urllib.request.Request(url, headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"
    })
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


def fetch_page_ajax(page_index):
    url = f"https://www.thegioididong.com/Category/FilterProductBox?c=4547&pi={page_index}"
    post_data = urllib.parse.urlencode({
        "IsParentCate": "false",
        "IsShowCompare": "false",
        "IsAffiliate": "false",
        "prevent": "true"
    }).encode()
    req = urllib.request.Request(url, data=post_data, method="POST", headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        "X-Requested-With": "XMLHttpRequest",
        "Referer": "https://www.thegioididong.com/ban-phim",
        "Accept": "application/json, text/javascript, */*; q=0.01",
    })
    try:
        with urllib.request.urlopen(req, timeout=20) as resp:
            raw = json.loads(resp.read().decode('utf-8', errors='ignore'))
            return raw.get("total", 0), raw.get("listproducts", "")
    except Exception as e:
        print(f"  Error page {page_index}: {e}")
        return 0, ""


def parse_items(html_frag):
    products = []
    seen_ids = set()

    li_blocks = re.findall(
        r'<li\s+class="[^"]*item[^"]*__cate_4547[^"]*"\s+[^>]*data-id="(\d+)"[^>]*data-price="([\d.]+)"[^>]*>(.*?)</li>',
        html_frag, re.DOTALL
    )

    for prod_id, li_price_str, li_html in li_blocks:
        if prod_id in seen_ids:
            continue
        seen_ids.add(prod_id)

        li_price = int(float(li_price_str))  # original price

        # anchor data-price = current (discounted) price
        a_price_m = re.search(r'<a\s+href=[^>]*data-price="([\d.]+)"', li_html)
        cur_price = int(float(a_price_m.group(1))) if a_price_m else li_price

        old_price = li_price if li_price > cur_price else 0
        discount_pct = round((old_price - cur_price) / old_price * 100) if old_price > cur_price else 0

        name_m = re.search(r'data-name="([^"]+)"', li_html)
        name = html_lib.unescape(name_m.group(1)).strip() if name_m else ""
        name = clean_tgdd(name)
        if not name:
            continue

        href_m = re.search(r"href='(/ban-phim/[^'?]+)'", li_html)
        if not href_m:
            href_m = re.search(r'href="(/ban-phim/[^"?]+)"', li_html)
        href = href_m.group(1) if href_m else f"/ban-phim/product-{prod_id}"
        source_url = "https://www.thegioididong.com" + href

        brand_m = re.search(r'data-brand="([^"]+)"', li_html)
        brand = html_lib.unescape(brand_m.group(1)).strip() if brand_m else ""

        img_m = re.search(r'data-src="(https://(?:cdn|cdnv2)\.tgdd\.vn/[^"]+)"', li_html)
        img_url = img_m.group(1) if img_m else ""
        if img_url:
            img_url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', img_url)

        if not img_url:
            continue

        products.append({
            "id": prod_id,
            "name": name,
            "source_url": source_url,
            "brand": brand,
            "price": cur_price,
            "old_price": old_price,
            "discount_pct": discount_pct,
            "image_remote": img_url,
        })

    return products


def crawl_keyboards():
    print("=" * 60)
    print("PhoneX Crawler: Bàn Phím (ban-phim)")
    print("API: POST /Category/FilterProductBox?c=4547&pi={n}")
    print("=" * 60)

    all_raw = {}

    total, html_frag = fetch_page_ajax(0)
    print(f"Total products reported: {total}")
    items = parse_items(html_frag)
    print(f"  Page 0: {len(items)} items")
    for item in items:
        all_raw[item["id"]] = item

    pages_needed = (total + 39) // 40  # 40 items per page for this category
    print(f"  Pages needed: {pages_needed}")

    for pi in range(1, pages_needed + 2):
        time.sleep(0.4)
        _, html_frag = fetch_page_ajax(pi)
        items = parse_items(html_frag)
        new_items = 0
        for item in items:
            if item["id"] not in all_raw:
                all_raw[item["id"]] = item
                new_items += 1
        print(f"  Page {pi}: {len(items)} items ({new_items} new), total: {len(all_raw)}")
        if len(items) == 0:
            print("  No more items, stopping.")
            break

    print(f"\nTotal unique products: {len(all_raw)}")

    # Build final product list
    products = []
    for item in all_raw.values():
        name = item["name"]
        brand = item.get("brand", "")
        prod_type, subfolder, specs = detect_type(name, brand)

        img_remote = item.get("image_remote", "")
        ext = ".jpg"
        if img_remote:
            ext_m = re.search(r'\.(jpg|jpeg|png|webp)$', img_remote, re.IGNORECASE)
            if ext_m:
                ext = "." + ext_m.group(1).lower()

        img_slug = slugify(name)[:60]
        local_path = f"assets/images/products/ban-phim/{subfolder}/{img_slug}{ext}"

        products.append({
            "id": item["id"],
            "name": name,
            "source_url": item["source_url"],
            "brand": brand,
            "type": prod_type,
            "subfolder": subfolder,
            "price": item["price"],
            "old_price": item["old_price"],
            "discount_pct": item["discount_pct"],
            "specs": specs,
            "image_remote": img_remote,
            "image": local_path,
            "updated_at": datetime.now().strftime("%Y-%m-%dT%H:%M:%S"),
        })

    # Download images
    print(f"\nDownloading {len(products)} images...")
    download_jobs = [(p["image_remote"], os.path.join(THEME_DIR, p["image"]), p["name"])
                     for p in products if p["image_remote"]]

    success = fail = 0
    with ThreadPoolExecutor(max_workers=8) as executor:
        futures = {executor.submit(download_file, url, path): name
                   for url, path, name in download_jobs}
        for future in as_completed(futures):
            if future.result():
                success += 1
            else:
                fail += 1
                print(f"  ✗ Failed: {futures[future][:50]}")

    print(f"  Images: {success} OK, {fail} FAIL")

    # Save JSON
    os.makedirs(os.path.dirname(OUTPUT_PATH), exist_ok=True)
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)

    print(f"\n✓ Saved {len(products)} products → {OUTPUT_PATH}")

    from collections import Counter
    by_folder = Counter(p["subfolder"] for p in products)
    for folder, count in sorted(by_folder.items()):
        img_dir = os.path.join(THEME_DIR, "assets", "images", "products", "ban-phim", folder)
        actual = len([f for f in os.listdir(img_dir) if os.path.isfile(os.path.join(img_dir, f))]) if os.path.exists(img_dir) else 0
        print(f"  {folder}/: {count} products, {actual} images on disk")

    return products


if __name__ == "__main__":
    crawl_keyboards()
