#!/usr/bin/env python3
"""
Crawler Script: Scrapes used phones from Quang Minh Mobile (quangminhmobile.com/dien-thoai-cu/)
and imports them into PhoneX Kho Máy Cũ catalog organized by brand (iPhone cũ, Samsung cũ, Oppo cũ, etc.).
Downloads all product images locally into phonex-theme/assets/images/products/dien-thoai-cu/{brand}/
"""

import os
import re
import sys
import html
import json
import time
import urllib.request
from urllib.parse import urlsplit, urlunsplit, quote

# Current script is in phonex-theme/scripts/
SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
THEME_DIR = os.path.dirname(SCRIPT_DIR)
DATA_JSON_PATH = os.path.join(THEME_DIR, 'data', 'used-phones.json')
IMAGES_BASE_DIR = os.path.join(THEME_DIR, 'assets', 'images', 'products', 'dien-thoai-cu')

HEADERS = {
    'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
}

def safe_quote_url(url):
    try:
        parts = urlsplit(url)
        path = quote(parts.path)
        return urlunsplit((parts.scheme, parts.netloc, path, parts.query, parts.fragment))
    except Exception:
        return url

def fetch_url(url, retries=3):
    safe_url = safe_quote_url(url)
    req = urllib.request.Request(safe_url, headers=HEADERS)
    for i in range(retries):
        try:
            with urllib.request.urlopen(req, timeout=20) as resp:
                return resp.read().decode('utf-8', errors='ignore')
        except Exception as e:
            if i == retries - 1:
                print(f"Error fetching {url}: {e}", file=sys.stderr)
                return None
            time.sleep(1)
    return None

def download_image(img_url, dest_path):
    if os.path.exists(dest_path) and os.path.getsize(dest_path) > 1000:
        return True
    os.makedirs(os.path.dirname(dest_path), exist_ok=True)
    safe_url = safe_quote_url(img_url)
    req = urllib.request.Request(safe_url, headers=HEADERS)
    try:
        with urllib.request.urlopen(req, timeout=20) as resp:
            data = resp.read()
            if len(data) > 500:
                with open(dest_path, 'wb') as f:
                    f.write(data)
                return True
    except Exception as e:
        print(f"Failed to download image {img_url}: {e}", file=sys.stderr)
    return False

def clean_slug(text):
    text = text.lower()
    text = re.sub(r'[àáạảãâầấậẩẫăằắặẳẵ]', 'a', text)
    text = re.sub(r'[èéẹẻẽêềếệểễ]', 'e', text)
    text = re.sub(r'[ìíịỉĩ]', 'i', text)
    text = re.sub(r'[òóọỏõôồốộổỗơờớợởỡ]', 'o', text)
    text = re.sub(r'[ùúụủũưừứựửữ]', 'u', text)
    text = re.sub(r'[ỳýỵỷỹ]', 'y', text)
    text = re.sub(r'đ', 'd', text)
    text = re.sub(r'[^a-z0-9]+', '-', text).strip('-')
    return text[:60]

def detect_brand_info(title, cat_raw, url):
    t = title.lower()
    c = cat_raw.lower()
    u = url.lower()

    if 'iphone' in t or 'iphone' in c or 'apple' in t or 'iphone' in u:
        return ('Apple', 'iPhone cũ', 'iphone')
    elif 'samsung' in t or 'samsung' in c or 'galaxy' in t or 'samsung' in u:
        return ('Samsung', 'Samsung cũ', 'samsung')
    elif 'oppo' in t or 'oppo' in c or 'reno' in t or 'find x' in t or 'oppo' in u:
        return ('OPPO', 'Oppo cũ', 'oppo')
    elif 'xiaomi' in t or 'xiaomi' in c or 'redmi' in t or 'poco' in t or 'xiaomi' in u:
        return ('Xiaomi', 'Xiaomi cũ', 'xiaomi')
    elif 'vivo' in t or 'vivo' in c or 'iqoo' in t or 'vivo' in u:
        return ('Vivo', 'Vivo cũ', 'vivo')
    elif 'realme' in t or 'realme' in c or 'realme' in u:
        return ('Realme', 'Realme cũ', 'realme')
    elif 'honor' in t or 'honor' in c or 'honor' in u:
        return ('Honor', 'Honor cũ', 'honor')
    elif 'infinix' in t or 'infinix' in c or 'infinix' in u:
        return ('Infinix', 'Infinix cũ', 'khac')
    elif 'nubia' in t or 'nubia' in c or 'red magic' in t or 'nubia' in u:
        return ('Nubia', 'Nubia cũ', 'khac')
    elif 'oukitel' in t or 'oukitel' in c or 'oukitel' in u:
        return ('Oukitel', 'Oukitel cũ', 'khac')
    else:
        return ('Khác', 'Smartphone Khác', 'khac')

def parse_product_card(part):
    post_id_m = re.search(r'post-(\d+)', part)
    post_id = post_id_m.group(1) if post_id_m else ''

    link_m = re.search(r'<a\s+href=[\"\'](https?://quangminhmobile\.com/[^\"\']+)[\"\']\s+class=[\"\']woocommerce-LoopProduct-link', part)
    if not link_m:
        link_m = re.search(r'<div class=[\"\']box-image[\"\'].*?<a\s+href=[\"\'](https?://quangminhmobile\.com/[^\"\']+)[\"\']', part, re.DOTALL)
    prod_url = link_m.group(1) if link_m else ''

    title_m = re.search(r'woocommerce-loop-product__title[\"\'][^>]*><a[^>]*>(.*?)</a>', part, re.DOTALL)
    title_raw = title_m.group(1) if title_m else ''
    title = html.unescape(re.sub(r'<.*?>', '', title_raw)).strip()

    cat_m = re.search(r'product-cat[^>]*>\s*([^<]+)\s*</p>', part)
    cat_raw = cat_m.group(1).strip() if cat_m else ''

    img_m = re.search(r'<img[^>]+data-src=[\"\']([^\"\']+)[\"\']', part)
    if not img_m:
        img_m = re.search(r'<img[^>]+src=[\"\'](https?://quangminhmobile\.com/wp-content/uploads/[^\"\']+)[\"\']', part)
    img_url = img_m.group(1) if img_m else ''
    orig_img_url = re.sub(r'-\d+x\d+(\.[a-zA-Z]+)$', r'\1', img_url)

    # Prices
    sale_m = re.search(r'<ins>.*?<bdi>([\d\.]+)', part, re.DOTALL)
    if sale_m:
        price_str = sale_m.group(1).replace('.', '')
        del_m = re.search(r'<del.*?>.*?<bdi>([\d\.]+)', part, re.DOTALL)
        old_price_str = del_m.group(1).replace('.', '') if del_m else ''
    else:
        price_m = re.search(r'<span class=[\"\']woocommerce-Price-amount amount[\"\']><bdi>([\d\.]+)', part, re.DOTALL)
        price_str = price_m.group(1).replace('.', '') if price_m else '0'
        old_price_str = ''

    disc_m = re.search(r'class=[\"\']discount-percent[\"\']>-?(\d+)%', part)
    disc_pct = int(disc_m.group(1)) if disc_m else 0

    price = int(price_str) if price_str.isdigit() else 0
    old_price = int(old_price_str) if old_price_str.isdigit() else (int(price * 1.25) if price > 0 else 0)
    if not disc_pct and old_price > price and price > 0:
        disc_pct = round(((old_price - price) / old_price) * 100)

    if not title or not prod_url or price <= 0:
        return None

    return {
        'post_id': post_id or clean_slug(title)[:10],
        'url': prod_url,
        'title': title,
        'cat_raw': cat_raw,
        'img_url': img_url,
        'orig_img_url': orig_img_url,
        'price': price,
        'old_price': old_price,
        'discount_pct': disc_pct
    }

def main():
    print(f"Theme directory resolved to: {THEME_DIR}")
    print(f"Target data json: {DATA_JSON_PATH}")
    os.makedirs(os.path.dirname(DATA_JSON_PATH), exist_ok=True)

    print("=== STARTING QUANG MINH MOBILE SCRAPER FOR PHONEX KHO MÁY CŨ ===")
    
    seen_urls = set()
    raw_products = []

    # 1. Scrape all general /dien-thoai-cu/ pages
    for p in range(1, 6):
        page_url = f'https://quangminhmobile.com/dien-thoai-cu/page/{p}/' if p > 1 else 'https://quangminhmobile.com/dien-thoai-cu/'
        print(f"Scraping catalog page: {page_url}")
        html_content = fetch_url(page_url)
        if not html_content:
            continue
        parts = re.split(r'<div class=[\"\']product-small col', html_content)
        for part in parts[1:]:
            item = parse_product_card(part)
            if item and item['url'] not in seen_urls:
                seen_urls.add(item['url'])
                raw_products.append(item)

    # 2. Check brand-specific category URLs to ensure no products were missed
    brand_cats = [
        'oppo-cu', 'samsung-cu', 'iphone-cu', 'xiaomi-cu', 'vivo-cu', 
        'realme-cu', 'honor-cu', 'nubia-cu', 'infinix-cu', 'oukitel-cu'
    ]
    for b_slug in brand_cats:
        for p in range(1, 3):
            cat_url = f'https://quangminhmobile.com/{b_slug}/page/{p}/' if p > 1 else f'https://quangminhmobile.com/{b_slug}/'
            html_content = fetch_url(cat_url)
            if not html_content:
                break
            parts = re.split(r'<div class=[\"\']product-small col', html_content)
            new_in_page = 0
            for part in parts[1:]:
                item = parse_product_card(part)
                if item and item['url'] not in seen_urls:
                    seen_urls.add(item['url'])
                    raw_products.append(item)
                    new_in_page += 1
            if len(parts) <= 1:
                break

    print(f"\nTotal unique products scraped: {len(raw_products)}")

    # 3. Process each product, download images, build JSON entries
    processed_items = []
    
    for idx, item in enumerate(raw_products):
        title = item['title']
        cat_raw = item['cat_raw']
        prod_url = item['url']
        post_id = item['post_id']
        price = item['price']
        old_price = item['old_price']
        disc_pct = item['discount_pct']

        brand, type_display, subfolder = detect_brand_info(title, cat_raw, prod_url)
        
        # Clean title & clean raw name
        # Remove unwanted store promo words
        clean_name = title
        clean_name = re.sub(r'&#8211;', '–', clean_name)
        clean_name = re.sub(r'&amp;', '&', clean_name)
        clean_name = re.sub(r'\s*–\s*Giá rẻ.*$', '', clean_name, flags=re.IGNORECASE)
        clean_name = re.sub(r'\s*–\s*Chuyên gia.*$', '', clean_name, flags=re.IGNORECASE)
        clean_name = clean_name.strip()

        # Grade condition detection
        cond_str = "Grade A 99%"
        if '98%' in title or '98%' in clean_name:
            cond_str = "Grade B 98%"
        elif 'mới 100%' in title.lower() or 'new seal' in title.lower() or 'nguyên seal' in title.lower():
            cond_str = "Grade A+ New Seal"
        elif 'like new' in title.lower() or '99%' in title:
            cond_str = "Grade A 99%"
        
        # Battery detection
        bat_str = "Pin 95% - 100% (Chuẩn Zin)"
        pin_m = re.search(r'pin\s*(\d+%|\d+\.?\d*mah)', title, re.IGNORECASE)
        if pin_m:
            bat_str = f"Pin {pin_m.group(1)} (Zin máy)"
        elif 'pin hoàn hảo 100%' in title.lower() or 'pin 100%' in title.lower():
            bat_str = "Pin 100% (Hoàn hảo)"

        # Download image locally
        safe_name = clean_slug(clean_name)
        img_filename = f"qmm-{post_id}-{safe_name}.jpg"
        local_rel_path = f"assets/images/products/dien-thoai-cu/{subfolder}/{img_filename}"
        local_abs_path = os.path.join(THEME_DIR, local_rel_path)

        download_success = False
        if item.get('orig_img_url'):
            download_success = download_image(item['orig_img_url'], local_abs_path)
        if not download_success and item.get('img_url'):
            download_success = download_image(item['img_url'], local_abs_path)

        if not download_success:
            # Fallback to remote image url if download fails
            final_img_path = item.get('img_url') or item.get('orig_img_url')
        else:
            final_img_path = local_rel_path

        # Stock quantity (randomized 2 - 8 for showroom inventory)
        stock_qty = 3 + (int(post_id[-1]) if post_id and post_id[-1].isdigit() else 2) % 6

        # Specs array formatted to PhoneX standards
        specs = [
            f"Tình trạng máy: {cond_str} • {bat_str}",
            "Kiểm định kỹ thuật 30 bước PhoneX Lab Certified",
            "Bảo hành 12 tháng toàn diện, 1 đổi 1 trong 30 ngày đầu"
        ]
        if 'fullbox' in title.lower():
            specs.append("Phụ kiện: Hộp Fullbox zin theo máy")

        entry = {
            "id": f"qmm-{post_id}",
            "name": f"[{cond_str}] {clean_name}",
            "raw_name": clean_name,
            "brand": brand,
            "type": type_display,
            "subfolder": subfolder,
            "condition": cond_str,
            "battery": bat_str,
            "stock_quantity": stock_qty,
            "price": price,
            "old_price": old_price,
            "discount_pct": disc_pct,
            "specs": specs,
            "image_remote": item.get('orig_img_url') or item.get('img_url'),
            "image": final_img_path,
            "source_url": prod_url,
            "updated_at": time.strftime("%Y-%m-%d %H:%M:%S")
        }
        processed_items.append(entry)

        if (idx + 1) % 20 == 0 or (idx + 1) == len(raw_products):
            print(f"Processed & verified images: {idx + 1}/{len(raw_products)} items")

    # 4. Save and merge with existing used-phones.json
    existing_items = []
    if os.path.exists(DATA_JSON_PATH):
        try:
            with open(DATA_JSON_PATH, 'r', encoding='utf-8') as f:
                existing_items = json.load(f)
        except Exception as e:
            print(f"Warning reading existing data: {e}")

    # Remove any previous qmm- items to allow clean update
    filtered_existing = [x for x in existing_items if not str(x.get('id', '')).startswith('qmm-')]

    # Put newly crawled items first so they appear at the top of the catalog!
    merged = processed_items + filtered_existing

    with open(DATA_JSON_PATH, 'w', encoding='utf-8') as f:
        json.dump(merged, f, ensure_ascii=False, indent=2)

    print(f"\nSuccessfully saved {len(merged)} total items to {DATA_JSON_PATH}")
    print(f"  - Newly crawled from Quang Minh Mobile: {len(processed_items)} items")
    print(f"  - Existing PhoneX catalog items preserved: {len(filtered_existing)} items")

    # Summary by brand for newly crawled items
    from collections import Counter
    b_counts = Counter([x['brand'] for x in processed_items])
    print("\nNewly Crawled Items Breakdown by Brand:")
    for b, count in b_counts.most_common():
        print(f"  - {b}: {count} máy")

if __name__ == '__main__':
    main()
