#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Download product images from Fastmobile and save locally.
"""
import os
import re
import json
import urllib.request
import unicodedata
from concurrent.futures import ThreadPoolExecutor

THEME_DIR = "/Users/uyen/Downloads/phonex-smartphone-project/phonex-theme"
IMG_BASE = os.path.join(THEME_DIR, "assets", "images", "products", "dien-thoai-cu")

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36"
}

def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)

with open("/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616/scratch/fastmobile_phones.json", "r", encoding="utf-8") as f:
    items = json.load(f)

print(f"Total items to download images for: {len(items)}")

for sub in ["iphone", "samsung", "xiaomi"]:
    os.makedirs(os.path.join(IMG_BASE, sub), exist_ok=True)

def download_item(item):
    item_id = item["id"]
    title = item["title"]
    sub = item["subfolder"]
    img_url = item["image"]
    
    clean_slug = slugify(title)[:60]
    filename = f"fm-{item_id}-{clean_slug}.jpg"
    target_path = os.path.join(IMG_BASE, sub, filename)
    rel_path = f"assets/images/products/dien-thoai-cu/{sub}/{filename}"
    
    item["local_image"] = rel_path
    
    if os.path.exists(target_path) and os.path.getsize(target_path) > 1000:
        return True
        
    if not img_url:
        return False
        
    try:
        req = urllib.request.Request(img_url, headers=HEADERS)
        with urllib.request.urlopen(req, timeout=10) as resp:
            content = resp.read()
            if len(content) > 1000:
                with open(target_path, "wb") as f:
                    f.write(content)
                return True
    except Exception as e:
        # print(f"Error {filename}: {e}")
        pass
    return False

with ThreadPoolExecutor(max_workers=12) as executor:
    results = list(executor.map(download_item, items))

success = sum(1 for r in results if r)
print(f"Downloaded/Cached images: {success}/{len(items)}")

with open("/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616/scratch/fastmobile_phones_with_img.json", "w", encoding="utf-8") as f:
    json.dump(items, f, ensure_ascii=False, indent=2)

