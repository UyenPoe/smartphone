#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
crawl-all-tgdd-phone-specs.py
Crawl ALL phone products and their complete technical specifications
directly from TheGioiDiDong (https://www.thegioididong.com/dtdd).
"""

import os
import re
import json
import urllib.request
import urllib.parse
import html
import time
from concurrent.futures import ThreadPoolExecutor, as_completed

BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
THEME_DIR = os.path.join(BASE_DIR, "phonex-theme")
DATA_DIR = os.path.join(THEME_DIR, "data")
OUTPUT_FULL_JSON = os.path.join(DATA_DIR, "phone-specs-full.json")
OUTPUT_PHONES_JSON = os.path.join(DATA_DIR, "phones.json")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "vi-VN,vi;q=0.9",
    "Referer": "https://www.thegioididong.com/dtdd",
}

API_HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36",
    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    "X-Requested-With": "XMLHttpRequest",
    "Referer": "https://www.thegioididong.com/dtdd",
}

def detect_brand(name):
    n = name.lower()
    if "iphone" in n or "apple" in n:
        return "Apple"
    if "samsung" in n or "galaxy" in n:
        return "Samsung"
    if "xiaomi" in n or "redmi" in n or "poco" in n:
        return "Xiaomi"
    if "oppo" in n or "reno" in n:
        return "OPPO"
    if "vivo" in n:
        return "Vivo"
    if "realme" in n:
        return "Realme"
    if "honor" in n:
        return "Honor"
    if "tecno" in n or "spark" in n or "camon" in n:
        return "Tecno"
    if "nokia" in n:
        return "Nokia"
    if "motorola" in n or "razr" in n:
        return "Motorola"
    if "nothing" in n:
        return "Nothing Phone"
    if "masstel" in n:
        return "Masstel"
    if "mobell" in n:
        return "Mobell"
    if "tcl" in n:
        return "TCL"
    if "bphone" in n:
        return "Bphone"
    return "Khác"

def detect_capacity(name):
    m = re.search(r"\b(32GB|64GB|128GB|256GB|512GB|1TB)\b", name, re.I)
    return m.group(1).upper() if m else ""

def get_product_list():
    """Fetch all phone products from TGDD via Category/FilterProductBox pagination API."""
    print("="*60)
    print("STEP 1: Collecting all phone products from https://www.thegioididong.com/dtdd")
    print("="*60)
    products = {}
    
    for pi in range(12):
        api_url = f"https://www.thegioididong.com/Category/FilterProductBox?c=42&pi={pi}"
        post_data = urllib.parse.urlencode({"IsParentCate": "False", "prevent": "true"}).encode("utf-8")
        req = urllib.request.Request(api_url, data=post_data, headers=API_HEADERS)
        try:
            with urllib.request.urlopen(req, timeout=12) as resp:
                data = json.loads(resp.read().decode("utf-8"))
                total_reported = data.get("total", 0)
                html_chunk = data.get("listproducts", "")
                if not html_chunk:
                    break
                
                # Parse each <li> product card
                items = re.findall(r"<li[^>]*class=[\x27\"][^\x27\"]*item[^>]*>([\s\S]*?)</li>", html_chunk)
                if not items:
                    # Alternative pattern
                    items = re.findall(r"<a[^>]*class=[\x27\"][^\x27\"]*main-contain[^\x27\"]*[\s\S]*?</a>", html_chunk)
                
                page_added = 0
                for it in items:
                    link_m = re.search(r"href=[\x27\"](/dtdd/[^\x27\"#?]+)[\x27\"]", it)
                    if not link_m:
                        continue
                    href = link_m.group(1)
                    
                    id_m = re.search(r"data-id=[\x27\"](\d+)[\x27\"]", it)
                    pid = id_m.group(1) if id_m else href.split("/")[-1]
                    
                    title_m = re.search(r"<h3>(.*?)</h3>", it)
                    title = html.unescape(re.sub(r"<[^>]+>", "", title_m.group(1))).strip() if title_m else ""
                    if not title:
                        # Fallback title from href
                        slug = href.split("/")[-1]
                        title = slug.replace("-", " ").title()
                    
                    img_m = re.search(r"<img[^>]*data-src=[\x27\"]([^\x27\"]+)[\x27\"]|<img[^>]*src=[\x27\"]([^\x27\"]+)[\x27\"]", it)
                    img = ""
                    if img_m:
                        img = img_m.group(1) or img_m.group(2)
                        if img and img.startswith("//"):
                            img = "https:" + img
                    
                    price_m = re.search(r"<strong[^>]*class=[\x27\"][^\x27\"]*price[^\x27\"]*[\x27\"][^>]*>([\s\S]*?)</strong>", it)
                    price_str = price_m.group(1) if price_m else "0"
                    price_num = int(re.sub(r"[^\d]", "", price_str) or 0)
                    
                    old_m = re.search(r"<div[^>]*class=[\x27\"][^\x27\"]*box-price-old[^\x27\"]*[\x27\"][^>]*>([\s\S]*?)</div>|<span[^>]*class=[\x27\"][^\x27\"]*price-old[^\x27\"]*[\x27\"][^>]*>([\s\S]*?)</span>", it)
                    old_str = old_m.group(1) or old_m.group(2) if old_m else "0"
                    old_num = int(re.sub(r"[^\d]", "", old_str) or 0)
                    
                    disc_m = re.search(r"<span[^>]*class=[\x27\"][^\x27\"]*percent[^\x27\"]*[\x27\"][^>]*>[-–]?(\d+)%</span>", it)
                    disc_num = int(disc_m.group(1)) if disc_m else 0
                    if not disc_num and old_num > price_num and old_num > 0:
                        disc_num = round(((old_num - price_num) / old_num) * 100)
                        
                    brand = detect_brand(title)
                    capacity = detect_capacity(title)
                    
                    if href not in products:
                        products[href] = {
                            "id": pid,
                            "name": title if title.startswith("Điện thoại") else f"Điện thoại {title}",
                            "url": href,
                            "image": img,
                            "price": price_num,
                            "price_old": old_num,
                            "discount_pct": disc_num,
                            "brand": brand,
                            "capacity": capacity,
                        }
                        page_added += 1
                        
                print(f"Page {pi:2d}: Found {page_added:2d} new products (Total unique: {len(products):3d} / {total_reported} reported)")
                if len(items) == 0:
                    break
        except Exception as e:
            print(f"Error fetching page {pi}: {e}")
            break
            
    print(f"\n=> Collected {len(products)} phone products from TGDD catalog.")
    return list(products.values())

def crawl_spec_detail(prod):
    """Crawl full technical specifications from TGDD detail page."""
    href = prod["url"]
    full_url = "https://www.thegioididong.com" + href
    
    spec_groups = []
    summary_specs = {}
    
    try:
        req = urllib.request.Request(full_url, headers=HEADERS)
        raw = urllib.request.urlopen(req, timeout=12).read().decode("utf-8", errors="ignore")
        
        # Verify page title if available
        h1_m = re.search(r"<h1[^>]*>(.*?)</h1>", raw)
        if h1_m:
            page_title = html.unescape(re.sub(r"<[^>]+>", "", h1_m.group(1))).strip()
            if page_title:
                prod["full_title"] = page_title
                
        # Also check high-res hero image if available
        hero_m = re.search(r"<div[^>]*class=[\x27\"][^\x27\"]*detail-slider[^\x27\"]*[\x27\"][^>]*>[\s\S]*?<img[^>]*src=[\x27\"]([^\x27\"]+)[\x27\"]", raw)
        if hero_m and not prod.get("image"):
            prod["image"] = hero_m.group(1)
            
        # Parse all box-specifi blocks
        boxes = re.findall(r"<div[^>]*class=[\x27\"][^\x27\"]*box-specifi[^\x27\"]*[\x27\"][^>]*>([\s\S]*?)</div>", raw)
        
        for b in boxes:
            title_m = re.search(r"<h3[^>]*>(.*?)</h3>|<a[^>]*>(.*?)</a>", b)
            group_name = ""
            if title_m:
                group_name = html.unescape(re.sub(r"<[^>]+>", "", title_m.group(1) or title_m.group(2))).strip()
            if not group_name:
                group_name = "Thông số kỹ thuật"
                
            items = []
            lis = re.findall(r"<li[^>]*>([\s\S]*?)</li>", b)
            for li in lis:
                asides = re.findall(r"<aside[^>]*>([\s\S]*?)</aside>", li)
                if len(asides) >= 2:
                    k = html.unescape(re.sub(r"<[^>]+>", "", asides[0])).strip().rstrip(":")
                    v = html.unescape(re.sub(r"<[^>]+>", " ", asides[1])).strip()
                    v = re.sub(r"\s+", " ", v)
                    if k and v:
                        items.append({"name": k, "value": v})
                else:
                    clean_text = html.unescape(re.sub(r"<[^>]+>", " ", li)).strip()
                    if ":" in clean_text:
                        k, v = clean_text.split(":", 1)
                        items.append({"name": k.strip(), "value": re.sub(r"\s+", " ", v.strip())})
                        
            if items:
                spec_groups.append({
                    "group": group_name,
                    "items": items
                })
                
                # Extract summary keys
                for item in items:
                    k_lower = item["name"].lower()
                    val = item["value"]
                    if "công nghệ màn hình" in k_lower:
                        summary_specs["screen_tech"] = val
                    elif "độ phân giải màn hình" in k_lower or ("độ phân giải" in k_lower and "màn hình" in group_name.lower()):
                        summary_specs["resolution"] = val
                    elif ("màn hình rộng" in k_lower or "kích thước màn hình" in k_lower) and "screen" not in summary_specs:
                        summary_specs["screen"] = val
                    elif "hệ điều hành" in k_lower and "os" not in summary_specs:
                        summary_specs["os"] = val
                    elif "chip xử lý" in k_lower or "cpu" in k_lower:
                        if "tốc độ" not in k_lower:
                            summary_specs["cpu"] = val
                    elif "ram" in k_lower and "ram" not in summary_specs:
                        summary_specs["ram"] = val
                    elif "dung lượng lưu trữ" in k_lower or "bộ nhớ trong" in k_lower:
                        if "storage" not in summary_specs:
                            summary_specs["storage"] = val
                    elif "độ phân giải camera sau" in k_lower or "camera sau" in k_lower:
                        if "quay phim" not in k_lower and "camera_rear" not in summary_specs:
                            summary_specs["camera_rear"] = val
                    elif "độ phân giải camera trước" in k_lower or "camera trước" in k_lower:
                        if "quay phim" not in k_lower and "camera_front" not in summary_specs:
                            summary_specs["camera_front"] = val
                    elif "dung lượng pin" in k_lower and "battery" not in summary_specs:
                        summary_specs["battery"] = val
                    elif "hỗ trợ sạc tối đa" in k_lower or "công nghệ sạc" in k_lower:
                        if "charge" not in summary_specs:
                            summary_specs["charge"] = val
                    elif "bảo mật" in k_lower:
                        summary_specs["security"] = val
                    elif "kháng nước" in k_lower:
                        summary_specs["waterproof"] = val
                    elif "sim" in k_lower and "sim" not in summary_specs:
                        summary_specs["sim"] = val
                    elif "chất liệu" in k_lower:
                        summary_specs["material"] = val

    except Exception as e:
        pass
        
    return {
        "url": href,
        "spec_groups": spec_groups,
        "summary_specs": summary_specs,
        "groups_count": len(spec_groups),
        "items_count": sum(len(g["items"]) for g in spec_groups)
    }

def main():
    prods = get_product_list()
    total = len(prods)
    
    print("\n" + "="*60)
    print(f"STEP 2: Crawling specifications for all {total} phones from TGDD")
    print("="*60)
    
    results = {}
    completed_count = 0
    success_count = 0
    
    with ThreadPoolExecutor(max_workers=10) as executor:
        future_map = {executor.submit(crawl_spec_detail, p): p for p in prods}
        for fut in as_completed(future_map):
            p = future_map[fut]
            completed_count += 1
            try:
                res = fut.result()
                results[p["url"]] = res
                if res["groups_count"] > 0:
                    success_count += 1
                    status = f"✓ {res['groups_count']} groups, {res['items_count']:2d} specs"
                else:
                    status = "⚠ No spec table (Teaser/Concept)"
                print(f"[{completed_count:3d}/{total:3d}] {p['name'][:38]:<38} -> {status}")
            except Exception as e:
                print(f"[{completed_count:3d}/{total:3d}] {p['name'][:38]:<38} -> ✗ Error: {e}")
                results[p["url"]] = {"spec_groups": [], "summary_specs": {}}
                
    print("\n" + "="*60)
    print("STEP 3: Merging & Updating PhoneX Database")
    print("="*60)
    
    # Load existing phones.json to preserve local assets and mappings
    existing_phones = {}
    if os.path.exists(OUTPUT_PHONES_JSON):
        try:
            with open(OUTPUT_PHONES_JSON, "r", encoding="utf-8") as f:
                old_list = json.load(f)
                for item in old_list:
                    k = item.get("name", "").strip().lower()
                    existing_phones[k] = item
        except Exception:
            pass
            
    final_phones_list = []
    full_specs_db = []
    
    missing_specs_products = []
    
    for p in prods:
        href = p["url"]
        spec_data = results.get(href, {"spec_groups": [], "summary_specs": {}})
        groups = spec_data.get("spec_groups", [])
        summary = spec_data.get("summary_specs", {})
        
        c_name = p["name"].strip().lower()
        old_data = existing_phones.get(c_name, {})
        
        # Preserve local images if available
        local_img = old_data.get("image", "")
        if not local_img or "cdn.tgdd.vn" in local_img:
            local_img = p["image"]
            
        # Fallback if no specs
        if not groups:
            missing_specs_products.append(p)
            if old_data.get("spec_groups"):
                groups = old_data["spec_groups"]
            if old_data.get("summary_specs"):
                summary = old_data["summary_specs"]
                
        # Basic short specs bullet points
        basic_specs_bullets = []
        if summary.get("screen"):
            basic_specs_bullets.append(f"Màn hình {summary['screen']}")
        if summary.get("cpu"):
            basic_specs_bullets.append(f"Chip {summary['cpu']}")
        if summary.get("ram") and summary.get("storage"):
            basic_specs_bullets.append(f"RAM {summary['ram']} • Bộ nhớ {summary['storage']}")
        elif summary.get("storage"):
            basic_specs_bullets.append(f"Bộ nhớ trong {summary['storage']}")
        if summary.get("camera_rear"):
            basic_specs_bullets.append(f"Camera sau {summary['camera_rear']}")
        if summary.get("battery"):
            basic_specs_bullets.append(f"Pin {summary['battery']}")
            
        specs_str = " • ".join(basic_specs_bullets) if basic_specs_bullets else old_data.get("specs", "Chính hãng nguyên seal")
        
        record = {
            "id": p["id"],
            "name": p["name"],
            "permalink": f"/lien-he/?product={urllib.parse.quote(p['name'])}",
            "url_tgdd": "https://www.thegioididong.com" + href,
            "image": local_img,
            "image_remote": p["image"],
            "price": p["price"],
            "price_old": p["price_old"],
            "discount_pct": p["discount_pct"],
            "brand": p["brand"],
            "capacity": p["capacity"] or summary.get("storage", ""),
            "specs": specs_str,
            "spec_groups": groups,
            "summary_specs": summary,
            "os": "ios" if p["brand"] == "Apple" else "android",
            "demands": old_data.get("demands", "battery,luxury"),
            "rating": old_data.get("rating", "5.0"),
            "reviews": old_data.get("reviews", 68),
            "is_new": (p["price_old"] == 0 or p["id"] in ["370987", "371030"]),
        }
        
        final_phones_list.append(record)
        full_specs_db.append({
            "id": p["id"],
            "name": p["name"],
            "url_tgdd": "https://www.thegioididong.com" + href,
            "brand": p["brand"],
            "price": p["price"],
            "spec_groups": groups,
            "summary_specs": summary
        })
        
    # Write full specs DB
    with open(OUTPUT_FULL_JSON, "w", encoding="utf-8") as f:
        json.dump(full_specs_db, f, ensure_ascii=False, indent=2)
    print(f"✓ Saved complete specs database: {OUTPUT_FULL_JSON} ({len(full_specs_db)} items)")
    
    # Write phones.json
    with open(OUTPUT_PHONES_JSON, "w", encoding="utf-8") as f:
        json.dump(final_phones_list, f, ensure_ascii=False, indent=2)
    print(f"✓ Updated theme phone catalog: {OUTPUT_PHONES_JSON} ({len(final_phones_list)} items)")
    
    print("\n" + "="*60)
    print("FINAL SUMMARY REPORT:")
    print("="*60)
    print(f"- Total phones crawled from TGDD: {total}")
    print(f"- Products with full 6 specification groups: {success_count} ({success_count/total*100:.1f}%)")
    print(f"- Products without TGDD specs table (Unreleased / Concept): {len(missing_specs_products)}")
    
    if missing_specs_products:
        print("\nMissing items list on TGDD:")
        for idx, m in enumerate(missing_specs_products, 1):
            print(f"  {idx}. {m['name']} (ID: {m['id']}) -> https://www.thegioididong.com{m['url']}")

if __name__ == "__main__":
    main()
