#!/usr/bin/env python3
"""
Download Chợ Tốt phone images locally for high-speed offline display in PhoneX Kho Máy Cũ.
"""
import os
import json
import urllib.request
from concurrent.futures import ThreadPoolExecutor

BASE_DIR = "/Users/uyen/Downloads/phonex-smartphone-project"
DATA_FILE = os.path.join(BASE_DIR, "phonex-theme/data/chotot-used-phones.json")
IMG_DIR_LOCAL = os.path.join(BASE_DIR, "phonex-theme/assets/images/products/dien-thoai-cu/chotot")
IMG_DIR_XAMPP = "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/assets/images/products/dien-thoai-cu/chotot"

os.makedirs(IMG_DIR_LOCAL, exist_ok=True)
os.makedirs(IMG_DIR_XAMPP, exist_ok=True)

with open(DATA_FILE, "r", encoding="utf-8") as f:
    data = json.load(f)

phones = data.get("phones", [])
print(f"Total phones to process images: {len(phones)}")

def download_image(phone):
    list_id = phone.get("list_id")
    img_url = phone.get("image")
    if not img_url:
        return list_id, False, "No image URL"
    
    local_path = os.path.join(IMG_DIR_LOCAL, f"ct-{list_id}.jpg")
    xampp_path = os.path.join(IMG_DIR_XAMPP, f"ct-{list_id}.jpg")
    
    if os.path.exists(local_path) and os.path.getsize(local_path) > 1000:
        if not os.path.exists(xampp_path) or os.path.getsize(xampp_path) < 1000:
            with open(local_path, "rb") as src, open(xampp_path, "wb") as dst:
                dst.write(src.read())
        return list_id, True, "Already cached"
    
    try:
        req = urllib.request.Request(
            img_url,
            headers={
                "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36",
                "Referer": "https://www.chotot.com/"
            }
        )
        with urllib.request.urlopen(req, timeout=15) as resp:
            content = resp.read()
            if len(content) > 1000:
                with open(local_path, "wb") as f_out:
                    f_out.write(content)
                with open(xampp_path, "wb") as f_out:
                    f_out.write(content)
                return list_id, True, f"Downloaded {len(content)} bytes"
            else:
                return list_id, False, f"Image too small ({len(content)} bytes)"
    except Exception as e:
        return list_id, False, str(e)

with ThreadPoolExecutor(max_workers=10) as executor:
    results = list(executor.map(download_image, phones))

success_count = sum(1 for r in results if r[1])
print(f"Completed downloading images: {success_count}/{len(phones)} successful.")
