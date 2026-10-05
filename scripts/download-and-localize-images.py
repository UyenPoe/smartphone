#!/usr/bin/env python3
"""
PhoneX - Localize and Organize Product Images
Downloads all crawled product images from remote CDN into local project directories,
organized by category subfolders with clean, recognizable file names.

Folder Structure:
phonex-theme/assets/images/products/
├── sac-dtdd/                   # Pin dự phòng & Sạc điện thoại di động
├── sac-cap/
│   ├── cu-sac/                 # Củ sạc / Adapter sạc
│   ├── cap-sac/                # Dây cáp sạc các loại
│   └── bo-sac/                 # Bộ sạc kèm cáp
"""

import os
import json
import re
import urllib.request
from concurrent.futures import ThreadPoolExecutor, as_completed
import unicodedata

THEME_DIR = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "phonex-theme")
IMG_BASE_DIR = os.path.join(THEME_DIR, "assets", "images", "products")

DIR_SAC_DTDD = os.path.join(IMG_BASE_DIR, "sac-dtdd")
DIR_CU_SAC = os.path.join(IMG_BASE_DIR, "sac-cap", "cu-sac")
DIR_CAP_SAC = os.path.join(IMG_BASE_DIR, "sac-cap", "cap-sac")
DIR_BO_SAC = os.path.join(IMG_BASE_DIR, "sac-cap", "bo-sac")

for d in [DIR_SAC_DTDD, DIR_CU_SAC, DIR_CAP_SAC, DIR_BO_SAC]:
    os.makedirs(d, exist_ok=True)

def slugify(text):
    text = unicodedata.normalize('NFKD', text).encode('ascii', 'ignore').decode('utf-8')
    text = re.sub(r'[^\w\s-]', '', text).strip().lower()
    return re.sub(r'[-\s]+', '-', text)[:70]

def download_image(url, save_path):
    if os.path.exists(save_path) and os.path.getsize(save_path) > 1000:
        return True, "exists"
    req = urllib.request.Request(url, headers={
        "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36"
    })
    for attempt in range(3):
        try:
            with urllib.request.urlopen(req, timeout=12) as resp:
                data = resp.read()
                if len(data) > 500:
                    with open(save_path, "wb") as f:
                        f.write(data)
                    return True, "downloaded"
        except Exception as e:
            if attempt == 2:
                print(f"Failed to download {url}: {e}")
                return False, str(e)
    return False, "unknown error"

def process_chargers():
    json_path = os.path.join(THEME_DIR, "data", "chargers.json")
    if not os.path.exists(json_path):
        print(f"File not found: {json_path}")
        return

    with open(json_path, "r", encoding="utf-8") as f:
        products = json.load(f)

    print(f"\n[1/2] Processing {len(products)} products in sac-dtdd (Pin sạc dự phòng & sạc điện thoại)...")
    download_tasks = []
    used_filenames = set()

    for idx, p in enumerate(products):
        img_url = p.get("image", "")
        name = p.get("product_name") or p.get("name") or f"product-{idx}"
        slug = slugify(name)
        if not slug:
            slug = f"charger-{idx}"
        
        # Determine extension
        ext = ".jpg"
        if ".png" in img_url.lower():
            ext = ".png"
        elif ".webp" in img_url.lower():
            ext = ".webp"

        filename = f"{slug}{ext}"
        counter = 1
        while filename in used_filenames:
            filename = f"{slug}-{counter}{ext}"
            counter += 1
        used_filenames.add(filename)

        save_path = os.path.join(DIR_SAC_DTDD, filename)
        rel_path = f"assets/images/products/sac-dtdd/{filename}"

        p["image_local"] = rel_path
        p["image_remote"] = img_url
        p["image"] = rel_path  # Update primary image path to local

        if img_url and img_url.startswith("http"):
            download_tasks.append((img_url, save_path, name))

    print(f" -> Downloading {len(download_tasks)} images into {DIR_SAC_DTDD} ...")
    success_count = 0
    with ThreadPoolExecutor(max_workers=16) as executor:
        futures = {executor.submit(download_image, url, path): name for url, path, name in download_tasks}
        for future in as_completed(futures):
            ok, status = future.result()
            if ok:
                success_count += 1

    print(f" -> Completed: {success_count}/{len(download_tasks)} images ready in sac-dtdd/")

    with open(json_path, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)
    print(f" -> Updated {json_path} with local image paths.")

def process_cables():
    json_path = os.path.join(THEME_DIR, "data", "cables.json")
    if not os.path.exists(json_path):
        print(f"File not found: {json_path}")
        return

    with open(json_path, "r", encoding="utf-8") as f:
        products = json.load(f)

    print(f"\n[2/2] Processing {len(products)} products in sac-cap (Củ sạc, Cáp sạc & Bộ sạc)...")
    download_tasks = []
    used_filenames = set()

    for idx, p in enumerate(products):
        img_url = p.get("image", "")
        name = p.get("name") or f"cable-{idx}"
        prod_type = p.get("type", "")
        slug = slugify(name)
        if not slug:
            slug = f"cable-{idx}"

        # Determine subfolder based on product type
        if "bộ" in prod_type.lower() or "combo" in prod_type.lower():
            target_dir = DIR_BO_SAC
            subfolder = "sac-cap/bo-sac"
        elif "cáp" in prod_type.lower() or "dây" in name.lower():
            target_dir = DIR_CAP_SAC
            subfolder = "sac-cap/cap-sac"
        else:
            target_dir = DIR_CU_SAC
            subfolder = "sac-cap/cu-sac"

        ext = ".jpg"
        if ".png" in img_url.lower():
            ext = ".png"
        elif ".webp" in img_url.lower():
            ext = ".webp"

        filename = f"{slug}{ext}"
        counter = 1
        full_key = f"{subfolder}/{filename}"
        while full_key in used_filenames:
            filename = f"{slug}-{counter}{ext}"
            full_key = f"{subfolder}/{filename}"
            counter += 1
        used_filenames.add(full_key)

        save_path = os.path.join(target_dir, filename)
        rel_path = f"assets/images/products/{subfolder}/{filename}"

        p["image_local"] = rel_path
        p["image_remote"] = img_url
        p["image"] = rel_path

        if img_url and img_url.startswith("http"):
            download_tasks.append((img_url, save_path, name))

    print(f" -> Downloading {len(download_tasks)} images into {IMG_BASE_DIR}/sac-cap/ ...")
    success_count = 0
    with ThreadPoolExecutor(max_workers=16) as executor:
        futures = {executor.submit(download_image, url, path): name for url, path, name in download_tasks}
        for future in as_completed(futures):
            ok, status = future.result()
            if ok:
                success_count += 1

    print(f" -> Completed: {success_count}/{len(download_tasks)} images ready in sac-cap/ subfolders.")

    with open(json_path, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)
    print(f" -> Updated {json_path} with local image paths.")

if __name__ == "__main__":
    process_chargers()
    process_cables()
    print("\nAll product images have been downloaded and localized successfully!")
