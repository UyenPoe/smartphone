#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
PhoneX - Chợ Tốt Smartphone Crawler & Multi-factor Grade Classification Engine
Crawl phone listings from https://www.chotot.com/mua-ban-dien-thoai,
fetch detail listing specs and seller descriptions, and classify each item
into PhoneX Grade A / B / C / D standard.
"""

import os
import re
import json
import time
import urllib.request
import urllib.parse
from datetime import datetime

THEME_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), "..", "phonex-theme"))
DATA_FILE = os.path.join(THEME_DIR, "data", "chotot-used-phones.json")
XAMPP_THEME_DIR = "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme"
XAMPP_DATA_FILE = os.path.join(XAMPP_THEME_DIR, "data", "chotot-used-phones.json")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36",
    "Accept": "application/json, text/plain, */*",
    "Accept-Language": "vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7",
}

def clean_text(text):
    if not text:
        return ""
    return re.sub(r'\s+', ' ', text).strip()

def analyze_grade(subject, body, elt_condition, elt_warranty, elt_lock):
    """
    Multi-factor PhoneX Grade Classifier:
    Analyzes Title, Body, Condition, Warranty, and Lock version.
    Returns:
        overall_grade: 'GRADE_A' | 'GRADE_B' | 'GRADE_C' | 'GRADE_D'
        grade_badge: 'Grade A (99% Like New)' ...
        grade_color: Hex color
        rationale: Explanation
        factors: { body, screen, battery, hardware }
    """
    full_text = f"{subject} {body}".lower()
    
    factors = {
        "body": {"status": "Chưa xác định", "grade": "GRADE_B", "detail": "Ngoại hình bình thường qua sử dụng"},
        "screen": {"status": "Zin đẹp", "grade": "GRADE_A", "detail": "Màn hình hiển thị tốt, cảm ứng mượt"},
        "battery": {"status": "Tốt", "grade": "GRADE_A", "detail": "Pin hoạt động ổn định"},
        "hardware": {"status": "Nguyên bản", "grade": "GRADE_A", "detail": "Đầy đủ chức năng, chưa phát hiện lỗi"}
    }
    rationales = []

    # 1. HARDWARE & ERROR DETECTION (GRADE D)
    d_hardware_kws = [
        ('mất face id', 'Mất tính năng Face ID'),
        ('mất face', 'Mất tính năng Face ID'),
        ('mất vân tay', 'Hỏng cảm biến vân tay'),
        ('ẩn icloud', 'Máy dính ẩn iCloud'),
        ('bypass', 'Máy đã bị bypass tài khoản'),
        ('lock icloud', 'Dính khóa iCloud'),
        ('mất sóng', 'Mất sóng di động'),
        ('hư cam', 'Hỏng camera'),
        ('camera rung', 'Camera bị rung/mờ'),
        ('lỗi mic', 'Hỏng micro/loa đàm thoại'),
        ('chết main', 'Hỏng bo mạch chủ'),
        ('mất nguồn', 'Không lên nguồn'),
        ('dính nước', 'Máy bị ẩm/rớt nước'),
        ('bán xác', 'Bán dạng xác máy/lấy linh kiện'),
        ('rã xác', 'Rã xác máy lấy linh kiện'),
        ('lấy linh kiện', 'Chỉ dùng để lấy linh kiện')
    ]
    for kw, desc in d_hardware_kws:
        if kw in full_text:
            factors["hardware"]["status"] = "Lỗi nghiêm trọng"
            factors["hardware"]["grade"] = "GRADE_D"
            factors["hardware"]["detail"] = desc
            rationales.append(f"Linh kiện: {desc}")
            break

    # 2. SCREEN DETECTION (GRADE D, C, B, A)
    d_screen_kws = [
        ('sọc màn', 'Màn hình bị sọc kẻ'),
        ('sọc chỉ', 'Màn hình bị sọc chỉ'),
        ('chảy mực', 'Màn hình bị chảy mực/loang màu'),
        ('đốm mực', 'Màn hình có đốm đen/đốm mực'),
        ('vỡ màn', 'Màn hình bị nứt vỡ'),
        ('bể màn', 'Màn hình bị bể nát'),
        ('nứt màn', 'Màn hình nứt kính sâu'),
        ('bể kính', 'Bể mặt kính ngoài'),
        ('vỡ kính', 'Vỡ kính màn hình'),
        ('liệt cảm ứng', 'Màn hình bị liệt cảm ứng'),
        ('loạn cảm ứng', 'Màn hình bị nhảy loạn cảm ứng'),
        ('đen màn', 'Màn hình đen không hiển thị')
    ]
    for kw, desc in d_screen_kws:
        if kw in full_text:
            factors["screen"]["status"] = "Hỏng màn / Bể vỡ"
            factors["screen"]["grade"] = "GRADE_D"
            factors["screen"]["detail"] = desc
            rationales.append(f"Màn hình: {desc}")
            break

    if factors["screen"]["grade"] != "GRADE_D":
        c_screen_kws = [
            ('ám màn', 'Màn hình bị ám ố màu'),
            ('ám nhẹ', 'Màn hình ám hồng/vàng nhẹ'),
            ('lưu ảnh', 'Màn hình có hiện tượng lưu ảnh (burn-in)'),
            ('bóng ma', 'Màn hình có bóng ma mờ'),
            ('phản quang', 'Màn hình có đốm sáng phản quang'),
            ('thay màn', 'Máy đã thay màn hình lô/màn linh kiện'),
            ('màn lô', 'Màn hình linh kiện không phải zin'),
            ('ép kính', 'Máy đã qua ép lại kính ngoài')
        ]
        for kw, desc in c_screen_kws:
            if kw in full_text:
                factors["screen"]["status"] = "Ám ố / Đã sửa"
                factors["screen"]["grade"] = "GRADE_C"
                factors["screen"]["detail"] = desc
                rationales.append(f"Màn hình: {desc}")
                break

    if factors["screen"]["grade"] not in ["GRADE_D", "GRADE_C"]:
        if any(k in full_text for k in ['xước dăm', 'xước lông mèo', 'xước nhẹ màn']):
            factors["screen"]["status"] = "Xước dăm nhẹ"
            factors["screen"]["grade"] = "GRADE_B"
            factors["screen"]["detail"] = "Màn hình có vết xước lông mèo nhẹ, hiển thị tốt"
        elif any(k in full_text for k in ['màn đẹp', 'màn keng', 'màn dán', 'màn zin đẹp']):
            factors["screen"]["status"] = "Hoàn hảo"
            factors["screen"]["grade"] = "GRADE_A"
            factors["screen"]["detail"] = "Màn hình nguyên zin không tì vết"

    # 3. BODY & APPEARANCE (GRADE D, C, B, A)
    if any(k in full_text for k in ['bể lưng nặng', 'cong sườn', 'cong máy', 'móp nặng']):
        factors["body"]["status"] = "Móp nặng / Biến dạng"
        factors["body"]["grade"] = "GRADE_D"
        factors["body"]["detail"] = "Vỏ máy bị cấn móp sâu hoặc biến dạng sườn"
        rationales.append("Vỏ máy: Biến dạng nặng")
    elif any(k in full_text for k in ['cấn móp', 'cấn góc', 'móp góc', 'móp viền', 'trầy nhiều', 'xước nhiều', 'tróc sơn', 'trầy sâu', 'vỏ xấu', 'nứt lưng', 'bể lưng']):
        factors["body"]["status"] = "Cấn móp / Trầy xước nhiều"
        factors["body"]["grade"] = "GRADE_C"
        factors["body"]["detail"] = "Vỏ có vết cấn góc, trầy xước sâu hoặc tróc sơn"
        rationales.append("Vỏ máy: Cấn móp / Trầy nhiều (Grade C)")
    elif any(k in full_text for k in ['95%', '96%', '97%', '98%', 'trầy nhẹ', 'xước nhẹ', 'xước dăm', 'phẩy nhẹ', 'phẩy viền', 'dăm viền', 'trầy viền', 'xước viền']):
        factors["body"]["status"] = "95% - 98% (Xước nhẹ)"
        factors["body"]["grade"] = "GRADE_B"
        factors["body"]["detail"] = "Vỏ máy có trầy xước dăm nhẹ ở viền hoặc lưng"
        rationales.append("Vỏ máy: 95% - 98% trầy xước dăm nhẹ")
    elif any(k in full_text for k in ['99%', '99.9%', 'like new', 'likenew', 'keng', 'đẹp keng', 'như mới', 'mới 100%', 'nguyên seal', 'không trầy', 'chưa vết xước', 'không cấn móp', 'mới tinh']):
        factors["body"]["status"] = "99% Like New"
        factors["body"]["grade"] = "GRADE_A"
        factors["body"]["detail"] = "Ngoại hình đẹp xuất sắc không cấn móp"
        rationales.append("Vỏ máy: Đẹp như mới 99% Like New")
    else:
        if elt_condition == "Mới":
            factors["body"]["status"] = "Mới 100%"
            factors["body"]["grade"] = "GRADE_A"
            factors["body"]["detail"] = "Sản phẩm mới chưa qua sử dụng"
            rationales.append("Vỏ máy: Sản phẩm mới")
        else:
            factors["body"]["status"] = "95% Đã sử dụng"
            factors["body"]["grade"] = "GRADE_B"
            factors["body"]["detail"] = "Ngoại hình thông thường qua thời gian"

    # 4. BATTERY HEALTH DETECTION
    pin_match = re.search(r'(?:pin|dung lượng pin)\s*[:=]?\s*(\d{2,3})\s*%', full_text)
    if not pin_match:
        pin_match = re.search(r'(\d{2})\s*%\s*(?:sạc|pin|dung lượng)', full_text)

    pin_val = None
    if pin_match:
        val = int(pin_match.group(1))
        if 50 <= val <= 100:
            pin_val = val

    if any(k in full_text for k in ['pin bảo trì', 'pin chai', 'thay pin', 'đã thay pin']):
        factors["battery"]["status"] = "Chai pin / Đã thay"
        factors["battery"]["grade"] = "GRADE_C"
        factors["battery"]["detail"] = "Pin báo bảo trì hoặc đã thay thế bên ngoài"
        rationales.append("Pin: Pin chai / Đã thay thế")
    elif pin_val is not None:
        if pin_val < 80:
            factors["battery"]["status"] = f"Pin {pin_val}% (Chai)"
            factors["battery"]["grade"] = "GRADE_C"
            factors["battery"]["detail"] = f"Dung lượng pin dưới 80% ({pin_val}%), cần bảo trì"
            rationales.append(f"Pin: Chai dưới 80% ({pin_val}%)")
        elif pin_val < 85:
            factors["battery"]["status"] = f"Pin {pin_val}%"
            factors["battery"]["grade"] = "GRADE_B"
            factors["battery"]["detail"] = f"Dung lượng pin đạt {pin_val}% (Chuẩn Grade B: 80-84%)"
            rationales.append(f"Pin: Đạt {pin_val}%")
        else:
            factors["battery"]["status"] = f"Pin {pin_val}% (Cao)"
            factors["battery"]["grade"] = "GRADE_A"
            factors["battery"]["detail"] = f"Dung lượng pin hoàn hảo {pin_val}% (>= 85%)"
            rationales.append(f"Pin: Xuất sắc {pin_val}%")

    # 5. OVERALL GRADE DETERMINATION (MINIMUM OF ALL 4 FACTORS)
    grade_hierarchy = {"GRADE_A": 4, "GRADE_B": 3, "GRADE_C": 2, "GRADE_D": 1}
    min_score = min(
        grade_hierarchy[factors["hardware"]["grade"]],
        grade_hierarchy[factors["screen"]["grade"]],
        grade_hierarchy[factors["body"]["grade"]],
        grade_hierarchy[factors["battery"]["grade"]]
    )

    # Reverse map back to Grade
    score_to_grade = {4: "GRADE_A", 3: "GRADE_B", 2: "GRADE_C", 1: "GRADE_D"}
    overall_grade = score_to_grade[min_score]

    # Additional rule: if seller declared "Đã sử dụng (đã sửa chữa)" -> cannot be Grade A
    if elt_condition == "Đã sử dụng (đã sửa chữa)" and overall_grade == "GRADE_A":
        overall_grade = "GRADE_C"
        rationales.append("Người bán khai báo: Đã qua sửa chữa")

    # Meta labels & styles
    grade_metadata = {
        "GRADE_A": {
            "label": "Grade A (99% Like New)",
            "short_label": "Grade A",
            "percent_text": "99% Like New",
            "color": "#00875A",
            "bg_color": "#E3FCEF",
            "border_color": "#ABF5D1",
            "valuation_multiplier": 1.0,
            "badge_class": "bg-emerald-50 text-emerald-800 border-emerald-300"
        },
        "GRADE_B": {
            "label": "Grade B (95% Very Good)",
            "short_label": "Grade B",
            "percent_text": "95% Very Good",
            "color": "#0065FF",
            "bg_color": "#DEEBFF",
            "border_color": "#B3D4FF",
            "valuation_multiplier": 0.88,
            "badge_class": "bg-blue-50 text-blue-800 border-blue-300"
        },
        "GRADE_C": {
            "label": "Grade C (90% Good)",
            "short_label": "Grade C",
            "percent_text": "90% Good",
            "color": "#FF8B00",
            "bg_color": "#FFF0B3",
            "border_color": "#FFE380",
            "valuation_multiplier": 0.72,
            "badge_class": "bg-amber-50 text-amber-800 border-amber-300"
        },
        "GRADE_D": {
            "label": "Grade D (Lỗi / Linh kiện)",
            "short_label": "Grade D",
            "percent_text": "Lỗi / Xác máy",
            "color": "#DE350B",
            "bg_color": "#FFEBE6",
            "border_color": "#FFBDAD",
            "valuation_multiplier": 0.40,
            "badge_class": "bg-red-50 text-red-800 border-red-300"
        }
    }

    meta = grade_metadata[overall_grade]
    rationale_str = " • ".join(rationales) if rationales else "Thiết bị nguyên bản, hoạt động bình thường qua sử dụng"

    return overall_grade, meta, rationale_str, factors

def fetch_chotot_listings(total_items=60):
    """
    Crawls listings from Chợ Tốt mobile phone category (cg=5010)
    and clicks into each detail item to extract parameters & condition.
    """
    print(f"🚀 Bắt đầu crawl dữ liệu Chợ Tốt: https://www.chotot.com/mua-ban-dien-thoai (Mục tiêu: {total_items} máy)...")
    
    results = []
    limit = 20
    offset = 0

    while len(results) < total_items:
        list_url = f"https://gateway.chotot.com/v1/public/ad-listing?cg=5010&limit={limit}&o={offset}"
        try:
            req = urllib.request.Request(list_url, headers=HEADERS)
            with urllib.request.urlopen(req, timeout=15) as resp:
                data = json.loads(resp.read().decode('utf-8'))
                ads = data.get("ads", [])
                if not ads:
                    print("⚠️ Không còn tin đăng mới từ Chợ Tốt.")
                    break
        except Exception as e:
            print(f"❌ Lỗi khi lấy danh sách tại offset {offset}: {e}")
            break

        for ad in ads:
            if len(results) >= total_items:
                break

            list_id = ad.get("list_id") or ad.get("ad_id")
            subject = clean_text(ad.get("subject", ""))
            price = ad.get("price", 0)
            base_body = ad.get("body", "")

            # Default attributes from listing summary
            brand_name = clean_text(ad.get("category_name", "Điện thoại"))
            model_name = subject
            elt_condition = ""
            elt_warranty = ""
            elt_lock = ""
            elt_origin = ""
            color = ""
            location_str = clean_text(f"{ad.get('area_name', '')}, {ad.get('region_name', '')}")
            seller_name = ad.get("account_name", "")
            
            # Real photos
            images = []
            if ad.get("images"):
                images = ad.get("images")
            elif ad.get("image"):
                images = [ad.get("image")]

            # CLICK DETAIL: Call detail endpoint to inspect parameters & complete body
            detail_url = f"https://gateway.chotot.com/v1/public/ad-listing/{list_id}"
            try:
                dreq = urllib.request.Request(detail_url, headers=HEADERS)
                with urllib.request.urlopen(dreq, timeout=10) as dresp:
                    det = json.loads(dresp.read().decode('utf-8'))
                    ad_p = det.get("ad_params", {})
                    
                    if "mobile_brand" in ad_p:
                        brand_name = ad_p["mobile_brand"].get("value", brand_name)
                    if "mobile_model" in ad_p:
                        model_name = ad_p["mobile_model"].get("value", model_name)
                    if "elt_condition" in ad_p:
                        elt_condition = ad_p["elt_condition"].get("value", "")
                    if "elt_warranty" in ad_p:
                        elt_warranty = ad_p["elt_warranty"].get("value", "")
                    if "elt_lock" in ad_p:
                        elt_lock = ad_p["elt_lock"].get("value", "")
                    if "elt_origin" in ad_p:
                        elt_origin = ad_p["elt_origin"].get("value", "")
                    if "mobile_color" in ad_p:
                        color = ad_p["mobile_color"].get("value", "")
                    if "address" in ad_p:
                        location_str = ad_p["address"].get("value", location_str)

                    # Update complete body if available in detail
                    if det.get("ad", {}).get("body"):
                        base_body = det.get("ad", {}).get("body")
                    if det.get("ad", {}).get("images"):
                        images = det.get("ad", {}).get("images")
            except Exception as e:
                # If detail call failed, proceed with listing summary data
                pass

            # Perform Multi-factor PhoneX Grade Classification
            grade_code, grade_meta, rationale, factors = analyze_grade(
                subject=subject,
                body=base_body,
                elt_condition=elt_condition,
                elt_warranty=elt_warranty,
                elt_lock=elt_lock
            )

            # High-res thumb
            thumb = images[0] if images else ""

            item_data = {
                "id": str(list_id),
                "list_id": list_id,
                "title": subject,
                "brand": brand_name,
                "model": model_name,
                "price": price,
                "price_formatted": f"{price:,.0f}₫".replace(",", "."),
                "seller_name": seller_name,
                "location": location_str,
                "condition_declared": elt_condition or "Đã sử dụng",
                "warranty_declared": elt_warranty or "Hết bảo hành",
                "lock_status": elt_lock or "Quốc tế",
                "origin": elt_origin or "Chính hãng",
                "color": color,
                "grade": grade_code,
                "grade_label": grade_meta["label"],
                "grade_short": grade_meta["short_label"],
                "grade_percent": grade_meta["percent_text"],
                "grade_color": grade_meta["color"],
                "grade_bg": grade_meta["bg_color"],
                "grade_border": grade_meta["border_color"],
                "grade_badge_class": grade_meta["badge_class"],
                "grade_rationale": rationale,
                "grade_factors": factors,
                "description": clean_text(base_body),
                "images": images[:6],
                "image": thumb,
                "chotot_url": f"https://www.chotot.com/{list_id}.htm",
                "crawled_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            }

            results.append(item_data)
            print(f"[{len(results):02d}/{total_items}] [{brand_name}] {model_name} | {price:,.0f}đ -> {grade_meta['label']}")
            time.sleep(0.15) # Politeness delay

        offset += limit
        time.sleep(0.5)

    return results

def main():
    os.makedirs(os.path.dirname(DATA_FILE), exist_ok=True)
    phones = fetch_chotot_listings(total_items=60)

    # Save to JSON in phonex-theme/data/chotot-used-phones.json
    output = {
        "metadata": {
            "source": "https://www.chotot.com/mua-ban-dien-thoai",
            "crawled_at": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
            "total_items": len(phones),
            "grade_counts": {
                "GRADE_A": sum(1 for p in phones if p["grade"] == "GRADE_A"),
                "GRADE_B": sum(1 for p in phones if p["grade"] == "GRADE_B"),
                "GRADE_C": sum(1 for p in phones if p["grade"] == "GRADE_C"),
                "GRADE_D": sum(1 for p in phones if p["grade"] == "GRADE_D")
            }
        },
        "phones": phones
    }

    with open(DATA_FILE, "w", encoding="utf-8") as f:
        json.dump(output, f, ensure_ascii=False, indent=2)
    print(f"\n✅ Đã lưu {len(phones)} sản phẩm vào: {DATA_FILE}")

    # Also sync to XAMPP if directory exists
    if os.path.exists(XAMPP_THEME_DIR):
        os.makedirs(os.path.dirname(XAMPP_DATA_FILE), exist_ok=True)
        with open(XAMPP_DATA_FILE, "w", encoding="utf-8") as f:
            json.dump(output, f, ensure_ascii=False, indent=2)
        print(f"✅ Đã đồng bộ sang XAMPP: {XAMPP_DATA_FILE}")

    print("\n📊 THỐNG KÊ PHÂN LOẠI GRADE:")
    for grade_k, count in output["metadata"]["grade_counts"].items():
        print(f"  • {grade_k}: {count} máy ({count/len(phones)*100:.1f}%)")

if __name__ == "__main__":
    main()
