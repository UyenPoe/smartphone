#!/usr/bin/env python3
"""
PhoneX - Crawler for TGDD Mobile Phone Chargers & Power Banks (sac-dtdd)
Source: https://www.thegioididong.com/sac-dtdd

Strictly extracts the 8 required fields:
1. Tên sản phẩm (Product name)
2. URL sản phẩm nguồn (Source product URL)
3. Giá hiện tại (Current sale price)
4. Giá cũ (Original price)
5. Hãng / model (Brand & Model)
6. Dung lượng nếu xác định được (Battery capacity: e.g. 10.000 mAh, 20.000 mAh)
7. Một số thông số kỹ thuật cơ bản (Basic specifications: Wattage, PD, GaN, Qi2 Magnetic, etc.)
8. Thời điểm cập nhật dữ liệu (Timestamp: e.g. 2026-09-30 09:36:00)
"""

import urllib.request
import urllib.parse
import json
import re
import html
import os
from datetime import datetime

OUTPUT_PATH = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme", "data", "chargers.json")

def crawl_chargers():
    base_url = "https://www.thegioididong.com/Category/FilterProductBox?c=57&pi={}"
    raw_products = []
    seen_urls = set()
    crawl_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    print("[1/3] Crawling products from https://www.thegioididong.com/sac-dtdd ...")
    for pi in range(12):  # Paginate until no more items
        url = base_url.format(pi)
        data = urllib.parse.urlencode({
            "IsParentCate": "False",
            "IsShowCompare": "True",
            "IsAffiliate": "False",
            "prevent": "true"
        }).encode("utf-8")
        req = urllib.request.Request(url, data=data, headers={
            "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36",
            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            "Referer": "https://www.thegioididong.com/sac-dtdd",
            "X-Requested-With": "XMLHttpRequest"
        })
        try:
            with urllib.request.urlopen(req) as resp:
                res = resp.read().decode("utf-8")
                obj = json.loads(res)
                listproducts = obj.get("listproducts", "")
                items = re.findall(r"<li class=\" item[^\"]*\"[^>]*>(.*?)</li>", listproducts, re.DOTALL)
                if not items:
                    break
                print(f" - Page {pi}: fetched {len(items)} items")
                for it in items:
                    m_name = re.search(r"data-name=\"([^\"]+)\"", it)
                    name = html.unescape(m_name.group(1)).strip() if m_name else ""
                    if not name:
                        continue

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

                    # Normalize Capacity
                    cap_match = re.search(r"(\d+(?:[\.,]\d+)?)\s*mah", name, re.IGNORECASE)
                    if cap_match:
                        digits = re.sub(r"[^\d]", "", cap_match.group(1))
                        if len(digits) >= 4:
                            capacity = f"{int(digits):,} mAh".replace(",", ".")
                        else:
                            capacity = f"{digits} mAh"
                    else:
                        capacity = "N/A"

                    # Wattage
                    m_watt = re.search(r"(\d+(?:\.\d+)?\s*W)", name, re.IGNORECASE)
                    wattage = m_watt.group(1).upper() if m_watt else ""

                    # Specs
                    specs = []
                    if wattage:
                        specs.append(f"Công suất {wattage}")
                    if any(k in name for k in ["Magnetic", "Qi2", "Không dây", "MagSafe"]):
                        specs.append("Sạc không dây Magnetic / Qi2")
                    if "Type C" in name or "Type-C" in name:
                        specs.append("Cổng Type-C Power Delivery")
                    if "PD" in name:
                        specs.append("Chuẩn sạc nhanh PD")
                    if "QC" in name or "Quick Charge" in name:
                        specs.append("Chuẩn QC 3.0")
                    if "Polymer" in name:
                        specs.append("Lõi pin Polymer bền bỉ")
                    elif "LiFePO4" in name:
                        specs.append("Lõi pin an toàn LiFePO4")
                    elif "Solid-state" in name:
                        specs.append("Lõi pin thể rắn Solid-state")
                    if not specs:
                        specs = ["Sạc nhanh chuẩn an toàn", "Bảo hành 12 tháng"]

                    # Model
                    clean_model = name
                    for prefix in ["Pin sạc dự phòng", "Polymer", "LiFePO4", "Solid-state", "Không dây", "Magnetic", "Qi2", "Type C", "PD", "QC 3.0", brand]:
                        clean_model = re.sub(re.escape(prefix), "", clean_model, flags=re.IGNORECASE)
                    clean_model = re.sub(r"\s+", " ", clean_model).strip()
                    clean_model = re.sub(r"\d+(?:\.\d+)?\s*(?:mAh|W)", "", clean_model, flags=re.IGNORECASE).strip("- /")
                    if not clean_model:
                        clean_model = brand

                    # Image
                    m_img = re.search(r"data-src=\"([^\"]+)\"", it)
                    image_url = m_img.group(1) if m_img else ""

                    raw_products.append({
                        "product_name": name,
                        "source_url": source_url,
                        "current_price": price_str,
                        "current_price_num": p_num,
                        "old_price": price_old_str,
                        "old_price_num": p_old_num,
                        "brand": brand,
                        "model": clean_model,
                        "capacity": capacity,
                        "specs": specs,
                        "image": image_url,
                        "updated_at": crawl_time
                    })
        except Exception as e:
            print(f"Error fetching page {pi}: {e}")
            break

    print(f"[2/3] Total crawled items: {len(raw_products)}")
    os.makedirs(os.path.dirname(OUTPUT_PATH), exist_ok=True)
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(raw_products, f, ensure_ascii=False, indent=2)
    print(f"[3/3] Successfully saved to {OUTPUT_PATH}")

if __name__ == "__main__":
    crawl_chargers()
