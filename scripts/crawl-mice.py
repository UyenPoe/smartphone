#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Chuột Máy Tính (chuot-may-tinh)
Source: https://www.thegioididong.com/chuot-may-tinh
Category ID: 86, Total: ~202 sản phẩm

API: POST /Category/FilterProductBox?c=86&pi={page_index}
     JSON response: { total, listproducts (HTML string) }

Phân loại ảnh:
phonex-theme/assets/images/products/chuot-may-tinh/
├── chuot-gaming/       (gaming, rgb, g502, g-pro...)
├── chuot-bluetooth/    (bluetooth, magic mouse...)
├── chuot-khong-day/    (không dây, wireless, usb dongle)
├── chuot-co-day/       (có dây, wired, usb)
└── khac/               (trackpad, presenter, khác)
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
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "mice.json")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products", "chuot-may-tinh")

SUBDIRS = {
    "chuot-gaming":    os.path.join(IMG_BASE_DIR, "chuot-gaming"),
    "chuot-bluetooth": os.path.join(IMG_BASE_DIR, "chuot-bluetooth"),
    "chuot-khong-day": os.path.join(IMG_BASE_DIR, "chuot-khong-day"),
    "chuot-co-day":    os.path.join(IMG_BASE_DIR, "chuot-co-day"),
    "khac":            os.path.join(IMG_BASE_DIR, "khac"),
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


def parse_price(s):
    cleaned = re.sub(r'[^\d]', '', s or "")
    return int(cleaned) if cleaned else 0


def detect_type(name, brand=""):
    nl = name.lower()

    # Gaming first (highest priority)
    if any(k in nl for k in ["gaming", "game", "rgb", "g502", "g pro", "g304", "g305",
                              "g403", "g604", "rog", "tuf", "zephyrus", "razer",
                              "steelseries", "corsair", "hyperx", "edra", "dareu gaming",
                              "g733", "pugio", "basilisk", "deathadder", "viper"]):
        subfolder = "chuot-gaming"
        prod_type = "Chuột gaming"
        specs = ["Sensor quang học DPI cao, điều chỉnh linh hoạt từ 200-25600 DPI",
                 "Click chuyên nghiệp, độ trễ dưới 1ms, độ bền 50 triệu lần bấm"]
        if "rgb" in nl:
            specs.append("Đèn RGB 16.8 triệu màu tùy chỉnh qua phần mềm")
        if "không dây" in nl or "wireless" in nl or "khong day" in nl:
            specs.append("Kết nối không dây 2.4GHz + Bluetooth đa chế độ")
        else:
            specs.append("Dây bện chống rối, nhẹ như không có, cảm giác tự nhiên")

    # Bluetooth
    elif "bluetooth" in nl or "magic mouse" in nl or "silent" in nl and brand.lower() == "logitech":
        subfolder = "chuot-bluetooth"
        prod_type = "Chuột Bluetooth"
        specs = ["Kết nối Bluetooth 5.0 đa thiết bị (lên đến 3 thiết bị đồng thời)",
                 "Pin sạc USB-C hoặc pin AA, thời gian dùng nhiều tháng",
                 "Di chuyển mượt mà mọi bề mặt, tối ưu làm việc di động"]
        if brand.lower() == "apple":
            specs.append("Multi-Touch Surface, tích hợp sâu với hệ sinh thái Apple")
        elif brand.lower() == "logitech":
            specs.append("Công nghệ Logitech Bolt/Unifying tín hiệu cực ổn định")

    # Wireless (non-bluetooth, USB dongle)
    elif any(k in nl for k in ["không dây", "khong day", "wireless", "nano receiver", "usb receiver"]):
        subfolder = "chuot-khong-day"
        prod_type = "Chuột không dây"
        specs = ["Kết nối không dây 2.4GHz qua USB Nano Receiver siêu nhỏ",
                 "Pin AA/AAA dùng lâu 12-24 tháng hoặc pin sạc tích hợp",
                 "Cảm biến quang học chính xác, cuộn mượt, hoạt động trên mọi bề mặt"]

    # Wired
    elif any(k in nl for k in ["có dây", "co day", "wired", "usb-a", "type-c", "type c"]):
        subfolder = "chuot-co-day"
        prod_type = "Chuột có dây"
        specs = ["Kết nối USB-A/USB-C cắm là chạy (Plug & Play), không cần driver",
                 "Không cần pin, tín hiệu ổn định tuyệt đối, phù hợp văn phòng cả ngày",
                 "Cuộn 3 nút êm ái, độ phân giải quang học 1000-1600 DPI"]

    else:
        # Detect by brand and product name inference
        if brand.lower() == "apple":
            subfolder = "chuot-bluetooth"
            prod_type = "Chuột Bluetooth"
            specs = ["Multi-Touch Surface tích hợp Apple Silicon",
                     "Bluetooth kết nối liền mạch với Mac, iPad, iPhone",
                     "Pin sạc Lightning/USB-C tiện lợi"]
        elif any(k in nl for k in ["m650", "m750", "m550", "mx anywhere", "pebble"]):
            subfolder = "chuot-bluetooth"
            prod_type = "Chuột Bluetooth"
            specs = ["Kết nối đa chế độ: Bluetooth + 2.4GHz Logi Bolt",
                     "Cuộn MagSpeed điện từ chính xác đến từng pixel",
                     "Tối ưu cho laptop, máy tính bảng, cả Windows và macOS"]
        else:
            subfolder = "chuot-khong-day"
            prod_type = "Chuột không dây"
            specs = ["Thiết kế ergonomic thoải mái, phù hợp sử dụng nhiều giờ",
                     "Cảm biến quang học chính xác, hoạt động mọi bề mặt",
                     "Tương thích Windows, macOS, Linux không cần cài driver"]

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
    """POST to FilterProductBox API, returns list of raw product dicts"""
    url = f"https://www.thegioididong.com/Category/FilterProductBox?c=86&pi={page_index}"
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
        "Referer": "https://www.thegioididong.com/chuot-may-tinh",
        "Accept": "application/json, text/javascript, */*; q=0.01",
    })
    try:
        with urllib.request.urlopen(req, timeout=20) as resp:
            raw = resp.read().decode('utf-8', errors='ignore')
            data = json.loads(raw)
            return data.get("total", 0), data.get("listproducts", "")
    except Exception as e:
        print(f"  Error page {page_index}: {e}")
        return 0, ""


def parse_items_from_html(html_fragment):
    """Parse product items from HTML string (inside <li>...</li> blocks)"""
    products = []
    seen_ids = set()

    li_blocks = re.findall(
        r'<li\s+class="[^"]*item[^"]*__cate_86[^"]*"[^>]*data-id="(\d+)"[^>]*>(.*?)</li>',
        html_fragment, re.DOTALL
    )

    for prod_id, li_html in li_blocks:
        if prod_id in seen_ids:
            continue
        seen_ids.add(prod_id)

        # Name from data-name attribute
        name_m = re.search(r'data-name="([^"]+)"', li_html)
        name = html_lib.unescape(name_m.group(1)).strip() if name_m else ""
        name = clean_tgdd(name)
        if not name:
            continue

        # Source URL
        href_m = re.search(r"href='(/chuot-may-tinh/[^'?]+)'", li_html)
        if not href_m:
            href_m = re.search(r'href="(/chuot-may-tinh/[^"?]+)"', li_html)
        href = href_m.group(1) if href_m else f"/chuot-may-tinh/product-{prod_id}"
        source_url = "https://www.thegioididong.com" + href

        # Brand
        brand_m = re.search(r'data-brand="([^"]+)"', li_html)
        brand = html_lib.unescape(brand_m.group(1)).strip() if brand_m else ""

        # Current price (from <a data-price="...">)
        cur_price_m = re.search(r'<a\s[^>]*data-price="([\d.]+)"', li_html)
        price_num = int(float(cur_price_m.group(1))) if cur_price_m else 0

        # Old price from <li data-price="..."> (original before discount)
        li_price_m = re.search(r'^<li\s[^>]*data-price="([\d.]+)"', li_html.strip(), re.MULTILINE)
        # fallback: extract from <p class="price-old">
        old_price_m = re.search(r'class="price-old[^"]*">([^<]+)<', li_html)
        old_price_str = old_price_m.group(1).strip() if old_price_m else ""
        old_price_num = parse_price(old_price_str)

        # Also try li outer data-price as old
        if not old_price_num and li_price_m:
            li_price = int(float(li_price_m.group(1)))
            if li_price > price_num:
                old_price_num = li_price

        # Discount %
        discount_m = re.search(r'class="percent"[^>]*>-?(\d+)%<', li_html)
        discount_pct = int(discount_m.group(1)) if discount_m else 0
        if not discount_pct and old_price_num and price_num and old_price_num > price_num:
            discount_pct = round((old_price_num - price_num) / old_price_num * 100)

        # Image URL
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
            "price": price_num,
            "old_price": old_price_num,
            "discount_pct": discount_pct,
            "image_remote": img_url,
        })

    return products


def crawl_all_mice():
    print("=" * 60)
    print("PhoneX Crawler: Chuột Máy Tính (chuot-may-tinh)")
    print("API: POST /Category/FilterProductBox?c=86&pi={n}")
    print("=" * 60)

    all_raw = {}  # keyed by product ID

    # First call to get total count
    total, html_frag = fetch_page_ajax(0)
    print(f"Total products reported by API: {total}")

    items = parse_items_from_html(html_frag)
    print(f"  Page 0: {len(items)} items")
    for item in items:
        all_raw[item["id"]] = item

    # Calculate pages needed (20 items per page)
    pages_needed = (total + 19) // 20
    print(f"  Pages needed: {pages_needed}")

    for pi in range(1, pages_needed + 1):
        time.sleep(0.4)
        _, html_frag = fetch_page_ajax(pi)
        items = parse_items_from_html(html_frag)
        new_items = 0
        for item in items:
            if item["id"] not in all_raw:
                all_raw[item["id"]] = item
                new_items += 1
        print(f"  Page {pi}: {len(items)} items ({new_items} new), total collected: {len(all_raw)}")
        if len(items) == 0:
            print("  No more items, stopping.")
            break

    print(f"\nTotal unique products collected: {len(all_raw)}")

    # Build final product list with type detection and local image paths
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
        local_filename = f"{img_slug}{ext}"
        local_path = f"assets/images/products/chuot-may-tinh/{subfolder}/{local_filename}"

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

    # Sort by price ascending (value-first)
    products.sort(key=lambda x: x["price"])

    # Download images concurrently
    print(f"\nDownloading {len(products)} images...")
    download_jobs = []
    for p in products:
        if p["image_remote"]:
            save_path = os.path.join(THEME_DIR, p["image"])
            download_jobs.append((p["image_remote"], save_path, p["name"]))

    success = 0
    fail = 0
    with ThreadPoolExecutor(max_workers=8) as executor:
        futures = {executor.submit(download_file, url, path): name
                   for url, path, name in download_jobs}
        for future in as_completed(futures):
            name = futures[future]
            if future.result():
                success += 1
            else:
                fail += 1
                print(f"  ✗ Failed: {name[:50]}")

    print(f"  Images: {success} OK, {fail} FAIL")

    # Save JSON
    os.makedirs(os.path.dirname(OUTPUT_PATH), exist_ok=True)
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)

    print(f"\n✓ Saved {len(products)} products → {OUTPUT_PATH}")

    # Summary
    from collections import Counter
    by_folder = Counter(p["subfolder"] for p in products)
    for folder, count in sorted(by_folder.items()):
        img_dir = os.path.join(THEME_DIR, "assets", "images", "products", "chuot-may-tinh", folder)
        actual = len([f for f in os.listdir(img_dir) if os.path.isfile(os.path.join(img_dir, f))]) if os.path.exists(img_dir) else 0
        print(f"  {folder}/: {count} products, {actual} images on disk")

    return products


if __name__ == "__main__":
    crawl_all_mice()
