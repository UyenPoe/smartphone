#!/usr/bin/env python3
"""
PhoneX - Crawler & Image Localizer for Thiết Bị Mạng (thiet-bi-mang)
Source: https://www.thegioididong.com/thiet-bi-mang
Category ID: 4727, Total: ~117 sản phẩm

Phân loại:
phonex-theme/assets/images/products/thiet-bi-mang/
├── router-wifi/        (router wifi, access point, mesh)
├── wifi-di-dong/       (mobile wifi, 4G/5G pocket wifi)
├── switch-mang/        (switch, bộ chia mạng)
├── thiet-bi-mang-khac/ (repeater, extender, modem, khác)
"""

import urllib.request, urllib.parse, json, re, html as html_lib
import os, unicodedata, time
from datetime import datetime
from concurrent.futures import ThreadPoolExecutor, as_completed

THEME_DIR = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme")
OUTPUT_PATH = os.path.join(THEME_DIR, "data", "network-devices.json")
IMG_BASE = os.path.join(THEME_DIR, "assets", "images", "products", "thiet-bi-mang")

SUBDIRS = {
    "router-wifi":         os.path.join(IMG_BASE, "router-wifi"),
    "wifi-di-dong":        os.path.join(IMG_BASE, "wifi-di-dong"),
    "switch-mang":         os.path.join(IMG_BASE, "switch-mang"),
    "thiet-bi-mang-khac":  os.path.join(IMG_BASE, "thiet-bi-mang-khac"),
}
for d in SUBDIRS.values():
    os.makedirs(d, exist_ok=True)


def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)[:70]


def clean_brand(text):
    if not text:
        return ""
    text = re.sub(r"Thế\s*Giới\s*Di\s*Động|TGDD|thegioididong\.com", "PhoneX", text, flags=re.IGNORECASE)
    return text.strip()


def detect_type(name, brand=""):
    nl = name.lower()

    if any(k in nl for k in ["wifi di động", "wifi di dong", "4g lte", "5g", "pocket wifi",
                               "phát wifi", "phat wifi", "mobile wifi", "mifi", "m7000", "m7350",
                               "m7450", "m7650", "m5250", "e5577", "e5783"]):
        subfolder = "wifi-di-dong"
        prod_type = "Wifi di động 4G/5G"
        specs = ["Kết nối 4G LTE / 5G tốc độ cao, phủ sóng rộng",
                 "Pin dung lượng lớn dùng cả ngày, sạc qua USB-C",
                 "Hỗ trợ nhiều thiết bị kết nối đồng thời (8–32 thiết bị)"]

    elif any(k in nl for k in ["switch", "bộ chia", "bo chia", "hub mạng", "hub mang", "sg108",
                                "tl-sg", "tl-sf", "gs308", "gs116"]):
        subfolder = "switch-mang"
        prod_type = "Switch mạng"
        specs = ["Chia sẻ kết nối mạng LAN cho nhiều thiết bị cùng lúc",
                 "Tốc độ Gigabit 10/100/1000Mbps ổn định",
                 "Plug & Play, không cần cấu hình, dễ lắp đặt"]

    elif any(k in nl for k in ["repeater", "khuếch đại", "khuech dai", "extender", "mở rộng",
                                "mo rong", "powerline", "deco", "orbi", "velop", "eero",
                                "mesh", "whole home", "access point", "điểm truy cập", "diem truy cap",
                                "ap", "eap", "omada", "unifi"]):
        subfolder = "router-wifi"
        prod_type = "Mesh Wifi / Access Point"
        specs = ["Phủ sóng Wifi toàn nhà với công nghệ Mesh thông minh",
                 "Tốc độ AX1800/AX3000/AX6000, băng tần kép/tam",
                 "Quản lý thiết bị dễ dàng qua app điện thoại"]

    elif any(k in nl for k in ["modem", "dsl", "adsl", "vdsl", "fiber", "cáp quang", "cap quang",
                                "ont", "gpon"]):
        subfolder = "thiet-bi-mang-khac"
        prod_type = "Modem / ONT"
        specs = ["Tương thích modem ADSL/VDSL/Cáp quang GPON/EPON",
                 "Kết nối ổn định, hỗ trợ đường truyền Internet tốc độ cao",
                 "Cấu hình đơn giản, tương thích đa nhà mạng Việt Nam"]

    else:
        # Default: router wifi
        subfolder = "router-wifi"
        prod_type = "Router Wifi"
        specs = ["Phủ sóng Wifi rộng cho căn hộ và văn phòng",
                 "Chuẩn Wifi 6 (802.11ax) hoặc Wifi 5 (802.11ac) tốc độ cao",
                 "Bảo mật WPA3, quản lý thiết bị qua app, dễ cài đặt"]
        # Refine by keywords
        if any(k in nl for k in ["ax", "wifi 6", "wifi6", "ax1800", "ax3000", "ax5400", "ax6000"]):
            specs[0] = "Chuẩn Wifi 6 (802.11ax) – tốc độ lên đến 5400Mbps, giảm nhiễu thông minh"
            specs.append("Kết nối đồng thời nhiều thiết bị nhờ công nghệ MU-MIMO & OFDMA")
        if any(k in nl for k in ["gaming", "game"]):
            specs.append("Tối ưu cho gaming: QoS ưu tiên game, ping thấp ổn định")

    return prod_type, subfolder, specs


def download_file(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True
    url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', url)
    req = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
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
    url = f"https://www.thegioididong.com/Category/FilterProductBox?c=4727&pi={pi}"
    post_data = urllib.parse.urlencode({
        "IsParentCate": "false", "IsShowCompare": "false",
        "IsAffiliate": "false", "prevent": "true"
    }).encode()
    req = urllib.request.Request(url, data=post_data, method="POST", headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36",
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        "X-Requested-With": "XMLHttpRequest",
        "Referer": "https://www.thegioididong.com/thiet-bi-mang",
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
        r'<li\s+class="[^"]*item[^"]*__cate_4727[^"]*"\s+[^>]*data-id="(\d+)"[^>]*data-price="([\d.]+)"[^>]*>(.*?)</li>',
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
        name = clean_brand(name)
        if not name:
            continue

        href_m = re.search(r"href='(/thiet-bi-mang/[^'?]+)'", li_html)
        href = href_m.group(1) if href_m else f"/thiet-bi-mang/product-{prod_id}"

        brand_m = re.search(r'data-brand="([^"]+)"', li_html)
        brand = html_lib.unescape(brand_m.group(1)).strip() if brand_m else ""

        img_m = re.search(r'data-src="(https://(?:cdn|cdnv2)\.tgdd\.vn/[^"]+)"', li_html)
        img_url = img_m.group(1) if img_m else ""
        if img_url:
            img_url = re.sub(r'-\d+x\d+(\.jpg|\.png|\.webp)$', r'-600x600\1', img_url)
        if not img_url:
            continue

        products.append({
            "id": prod_id, "name": name,
            "source_url": "https://www.thegioididong.com" + href,
            "brand": brand, "price": cur_price, "old_price": old_price,
            "discount_pct": discount_pct, "image_remote": img_url,
        })
    return products


def crawl():
    print("=" * 60)
    print("PhoneX Crawler: Thiết Bị Mạng (thiet-bi-mang)")
    print("API: POST /Category/FilterProductBox?c=4727&pi={n}")
    print("=" * 60)

    all_raw = {}
    total, frag = fetch_page(0)
    print(f"Total products: {total}")
    for item in parse_items(frag):
        all_raw[item["id"]] = item
    print(f"  Page 0: {len(all_raw)} items")

    pages = (total + 39) // 40
    for pi in range(1, pages + 2):
        time.sleep(0.4)
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
        prod_type, subfolder, specs = detect_type(name, brand)
        img_remote = item.get("image_remote", "")
        ext = ".jpg"
        if img_remote:
            ext_m = re.search(r'\.(jpg|jpeg|png|webp)$', img_remote, re.IGNORECASE)
            if ext_m:
                ext = "." + ext_m.group(1).lower()
        local_path = f"assets/images/products/thiet-bi-mang/{subfolder}/{slugify(name)[:60]}{ext}"
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
        img_dir = os.path.join(THEME_DIR, "assets", "images", "products", "thiet-bi-mang", folder)
        actual = len([x for x in os.listdir(img_dir) if os.path.isfile(os.path.join(img_dir, x))]) if os.path.exists(img_dir) else 0
        print(f"  {folder}/: {cnt} products, {actual} images")

    return products


if __name__ == "__main__":
    crawl()
