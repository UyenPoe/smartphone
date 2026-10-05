#!/usr/bin/env python3
"""
PhoneX - Crawler for TGDD Mobile Phone Chargers & Cables (sac-cap)
Source: https://www.thegioididong.com/sac-cap
Category ID: 9518

Strictly extracts the required fields:
1. Tên sản phẩm (Product name)
2. URL sản phẩm nguồn (Source product URL - internal metadata)
3. Giá hiện tại (Current sale price)
4. Giá cũ (Original price)
5. Hãng / model (Brand & Model)
6. Dung lượng / Chiều dài / Công suất (Power / Length / Spec)
7. Một số thông số kỹ thuật cơ bản (Specifications: Wattage, GaN, PD, QC, Port types, Length)
8. Thời điểm cập nhật dữ liệu (Timestamp)
"""

import urllib.request
import urllib.parse
import json
import re
import html
import os
from datetime import datetime

OUTPUT_PATH = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme", "data", "cables.json")

def clean_tgdd_references(text):
    """Ensure no external brand/retailer name leaks into text."""
    if not text:
        return ""
    text = re.sub(r"Thế\s*Giới\s*Di\s*Động|TGDD|thegioididong\.com", "PhoneX", text, flags=re.IGNORECASE)
    text = re.sub(r"Điện\s*Máy\s*XANH|DMX", "PhoneX", text, flags=re.IGNORECASE)
    return text.strip()

def parse_specs(name, subcate):
    specs = []
    
    # 1. Wattage / Power
    m_watt = re.search(r"(\d+(?:\.\d+)?\s*W\b)", name, re.IGNORECASE)
    wattage = m_watt.group(1).upper() if m_watt else ""
    if wattage:
        specs.append(f"Công suất {wattage}")

    # 2. Cable Length
    m_len = re.search(r"(\d+(?:\.\d+)?\s*m\b)", name, re.IGNORECASE)
    length = m_len.group(1) if m_len else ""
    if length and ("cáp" in subcate.lower() or "dây" in name.lower() or "cáp" in name.lower()):
        specs.append(f"Dài {length}")

    # 3. Fast Charging Technology
    if re.search(r"\bGaN\b", name, re.IGNORECASE):
        specs.append("Công nghệ GaN")
    if re.search(r"\bPD\b|Power\s*Delivery", name, re.IGNORECASE):
        specs.append("Chuẩn PD")
    if re.search(r"\bQC\b|Quick\s*Charge", name, re.IGNORECASE):
        specs.append("Quick Charge")
    if re.search(r"\bQi2\b|Từ\s*tính|Magnetic|MagSafe", name, re.IGNORECASE):
        specs.append("Hít từ tính Magnetic")

    # 4. Ports / Connector Type
    if "Type-C - Lightning" in name or "Type C - Lightning" in name or "Type-C to Lightning" in name:
        specs.append("Type-C sang Lightning")
    elif "Type-C - Type-C" in name or "Type C - Type C" in name or "Type-C to Type-C" in name:
        specs.append("Type-C sang Type-C")
    elif "USB - Type-C" in name or "USB-A - Type-C" in name or "USB to Type-C" in name:
        specs.append("USB-A sang Type-C")
    elif "USB - Lightning" in name or "USB-A - Lightning" in name:
        specs.append("USB-A sang Lightning")
    elif "4 in 1" in name or "3 in 1" in name or "Đa năng" in name:
        specs.append("Cáp sạc đa năng")

    # 5. Number of ports (for adapters)
    m_ports = re.search(r"(\d+)\s*cổng", name, re.IGNORECASE)
    if m_ports:
        specs.append(f"{m_ports.group(1)} cổng ra")

    return specs, wattage, length

def crawl_cables():
    base_url = "https://www.thegioididong.com/Category/FilterProductBox?c=9518&pi={}"
    raw_products = []
    seen_urls = set()
    crawl_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    print("[1/3] Crawling products from https://www.thegioididong.com/sac-cap (cateID: 9518) ...")
    max_pages = 15  # Up to ~300 items
    
    for pi in range(max_pages):
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
            "Referer": "https://www.thegioididong.com/sac-cap",
            "X-Requested-With": "XMLHttpRequest"
        })
        try:
            with urllib.request.urlopen(req) as resp:
                res = resp.read().decode("utf-8")
                obj = json.loads(res)
                listproducts = obj.get("listproducts", "")
                items = re.findall(r"<li class=\" item[^\"]*\"[^>]*>(.*?)</li>", listproducts, re.DOTALL)
                if not items:
                    print(f" - Page {pi}: No more products found, stopping.")
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

                    m_cate = re.search(r"data-cate=\"([^\"]+)\"", it)
                    subcate = html.unescape(m_cate.group(1)).strip() if m_cate else "Sạc cáp"

                    m_price = re.search(r"<strong class=\"price\">([^<]+)</strong>", it)
                    price_str = html.unescape(m_price.group(1)).strip() if m_price else "0₫"

                    m_old = re.search(r"<p class=\"price-old[^\"]*\">([^<]+)</p>", it)
                    price_old_str = html.unescape(m_old.group(1)).strip() if m_old else price_str

                    p_num = int(re.sub(r"[^\d]", "", price_str)) if re.sub(r"[^\d]", "", price_str) else 0
                    p_old_num = int(re.sub(r"[^\d]", "", price_old_str)) if re.sub(r"[^\d]", "", price_old_str) else p_num

                    # Discount calculation
                    discount_pct = 0
                    if p_old_num > p_num and p_old_num > 0:
                        discount_pct = round(((p_old_num - p_num) / p_old_num) * 100)

                    # Extract specs
                    specs, wattage, length = parse_specs(name, subcate)

                    # Primary type category: Củ sạc vs Cáp sạc vs Bộ sạc
                    name_lower = name.lower()
                    subcate_lower = subcate.lower()
                    if "bộ sạc" in name_lower or "bộ adapter" in name_lower:
                        prod_type = "Bộ sạc kèm cáp"
                    elif "cáp" in subcate_lower or "dây cáp" in name_lower or (length and "adapter" not in name_lower):
                        prod_type = "Cáp sạc"
                    else:
                        prod_type = "Củ sạc (Adapter)"

                    # Extract Image
                    m_img = re.search(r"(?:data-src|src)=[\x27\"](https://[^\x27\"]+)[\x27\"]", it)
                    image_url = m_img.group(1) if m_img else "https://cdn.tgdd.vn/mwg-static/common/Common/placeholder.png"

                    raw_products.append({
                        "name": name,
                        "source_url": source_url,
                        "price": p_num,
                        "price_formatted": f"{p_num:,}₫".replace(",", "."),
                        "price_old": p_old_num,
                        "price_old_formatted": f"{p_old_num:,}₫".replace(",", "."),
                        "discount_percent": discount_pct,
                        "brand": brand,
                        "subcate": subcate,
                        "type": prod_type,
                        "wattage": wattage if wattage else "Tiêu chuẩn",
                        "length": length if length else "N/A",
                        "specs": specs if specs else ["Sạc nhanh thông minh", "Bảo hành 12 tháng"],
                        "image": image_url,
                        "updated_at": crawl_time
                    })
        except Exception as e:
            print(f"Error on page {pi}: {e}")
            break

    print(f"[2/3] Total unique products crawled: {len(raw_products)}")

    # Ensure output directory exists
    os.makedirs(os.path.dirname(OUTPUT_PATH), exist_ok=True)
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        json.dump(raw_products, f, ensure_ascii=False, indent=2)

    print(f"[3/3] Successfully saved to {OUTPUT_PATH}")

if __name__ == "__main__":
    crawl_cables()
