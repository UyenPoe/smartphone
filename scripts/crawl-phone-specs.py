#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Crawl complete specifications from TheGioiDiDong for all phones in phones.json.
Extracts structured spec groups and key summary specs.
"""

import os
import re
import json
import urllib.request
import html
from concurrent.futures import ThreadPoolExecutor, as_completed

THEME_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "phonex-theme"))
DATA_FILE = os.path.join(THEME_DIR, "data", "phones.json")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "vi-VN,vi;q=0.9",
}

BRAND_SLUGS = [
    "dtdd", "dtdd-apple-iphone", "dtdd-samsung", "dtdd-oppo", "dtdd-xiaomi",
    "dtdd-vivo", "dtdd-realme", "dtdd-honor", "dtdd-tecno", "dtdd-motorola",
    "dtdd-nothing-phone", "dtdd-nokia", "dtdd-masstel", "dtdd-mobell"
]

def collect_urls():
    product_urls = {}
    print("Collecting product URLs from TGDD...")
    for slug in BRAND_SLUGS:
        url = f"https://www.thegioididong.com/{slug}"
        try:
            req = urllib.request.Request(url, headers=HEADERS)
            raw = urllib.request.urlopen(req, timeout=10).read().decode("utf-8", errors="ignore")
            matches = re.finditer(r"<a\s+([^>]*href=[\x27\"]([^\x27\"]+)[\x27\"][^>]*class=[\x27\"][^\x27\"]*main-contain[^\x27\"]*[\x27\"][^>]*)>", raw)
            for m in matches:
                tag = m.group(1)
                href = m.group(2)
                id_m = re.search(r"data-id=[\x27\"](\d+)[\x27\"]", tag)
                if id_m:
                    pid = id_m.group(1)
                    if pid not in product_urls:
                        product_urls[pid] = href
        except Exception as e:
            print(f"Error {slug}: {e}")
    print(f"Total product URLs collected: {len(product_urls)}")
    return product_urls

def parse_specs(url):
    try:
        req = urllib.request.Request(url, headers=HEADERS)
        raw = urllib.request.urlopen(req, timeout=12).read().decode("utf-8", errors="ignore")
        boxes = re.findall(r"<div[^>]*class=[\x27\"][^\x27\"]*box-specifi[^\x27\"]*[\x27\"][^>]*>([\s\S]*?)</div>", raw)
        spec_groups = []
        summary = {}

        for b in boxes:
            title_m = re.search(r"<a[^>]*>(.*?)</a>|<h3[^>]*>(.*?)</h3>", b)
            group_name = html.unescape(re.sub(r"<[^>]+>", "", title_m.group(1) or title_m.group(2))).strip() if title_m else "Thông số chung"
            items = []
            lis = re.findall(r"<li[^>]*>([\s\S]*?)</li>", b)
            for li in lis:
                clean_li = html.unescape(re.sub(r"\s+", " ", re.sub(r"<[^>]+>", " ", li))).strip()
                if ":" in clean_li:
                    parts = clean_li.split(":", 1)
                    k = parts[0].strip()
                    v = parts[1].strip()
                    if k and v:
                        items.append({"name": k, "value": v})
                        kl = k.lower()
                        if "công nghệ màn hình" in kl:
                            summary["screen_tech"] = v
                        elif "độ phân giải" in kl and "màn hình" in group_name.lower():
                            summary["resolution"] = v
                        elif ("màn hình rộng" in kl or "kích thước màn hình" in kl) and "screen" not in summary:
                            summary["screen"] = v
                        elif "hệ điều hành" in kl and "os" not in summary:
                            summary["os"] = v
                        elif "chip xử lý" in kl or "cpu" in kl:
                            if "tốc độ" not in kl:
                                summary["cpu"] = v
                        elif "ram" in kl and "ram" not in summary:
                            summary["ram"] = v
                        elif "dung lượng lưu trữ" in kl or "bộ nhớ trong" in kl:
                            if "storage" not in summary:
                                summary["storage"] = v
                        elif "độ phân giải camera sau" in kl or "camera sau" in kl:
                            if "quay phim" not in kl and "camera_rear" not in summary:
                                summary["camera_rear"] = v
                        elif "độ phân giải camera trước" in kl or "camera trước" in kl:
                            if "quay phim" not in kl and "camera_front" not in summary:
                                summary["camera_front"] = v
                        elif "dung lượng pin" in kl and "battery" not in summary:
                            summary["battery"] = v
                        elif "hỗ trợ sạc tối đa" in kl or "công nghệ sạc" in kl:
                            if "charge" not in summary:
                                summary["charge"] = v
                        elif "sim" in kl and "sim" not in summary:
                            summary["sim"] = v
                        elif "chất liệu" in kl and "material" not in summary:
                            summary["material"] = v
                        elif "bảo mật" in kl and "security" not in summary:
                            summary["security"] = v
                        elif "kháng nước" in kl and "waterproof" not in summary:
                            summary["waterproof"] = v
            if items:
                spec_groups.append({"group": group_name, "items": items})
        return spec_groups, summary
    except Exception as e:
        return [], {}

def main():
    if not os.path.exists(DATA_FILE):
        print(f"Data file not found: {DATA_FILE}")
        return

    with open(DATA_FILE, "r", encoding="utf-8") as f:
        phones = json.load(f)

    product_urls = collect_urls()

    print(f"\nStarting specs crawl for {len(phones)} phones...")
    success_count = 0
    failed_items = []

    def process_phone(p):
        pid = str(p.get("id"))
        href = product_urls.get(pid)
        if not href:
            # fallback: try matching by permalink or clean slug
            clean_name = p.get("name", "").replace("Điện thoại ", "").strip()
            # attempt direct search URL or dtdd slug
            return p, [], {}, f"Không tìm thấy URL chi tiết cho {p.get('name')}"

        if not href.startswith("http"):
            href = "https://www.thegioididong.com" + href

        groups, summary = parse_specs(href)
        if groups:
            return p, groups, summary, None
        else:
            return p, [], {}, f"Không bóc tách được thông số từ {href}"

    with ThreadPoolExecutor(max_workers=10) as executor:
        futures = {executor.submit(process_phone, p): p for p in phones}
        for future in as_completed(futures):
            p, groups, summary, err = future.result()
            if groups:
                p["spec_groups"] = groups
                p["summary_specs"] = summary
                success_count += 1
                print(f"[SUCCESS] {p.get('name')} -> {len(groups)} nhóm thông số")
            else:
                failed_items.append({"name": p.get("name"), "id": p.get("id"), "reason": err})
                print(f"[FAILED] {p.get('name')} -> {err}")

    # Save updated phones.json
    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(phones, f, ensure_ascii=False, indent=2)

    print("\n" + "="*50)
    print(f"Crawl Completed: {success_count}/{len(phones)} phones successfully extracted specs.")
    print(f"Failed items: {len(failed_items)}")
    if failed_items:
        print("\nDanh sách sản phẩm chưa lấy được từ TGDD:")
        for item in failed_items:
            print(f"- {item['name']} (ID: {item['id']}): {item['reason']}")
    print("="*50)

if __name__ == "__main__":
    main()
