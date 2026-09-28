#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
PhoneX - Code Standardization & Quality Optimization Script
Removes dead DOM elements, fixes HTML syntax, normalizes SEO & Accessibility tags.
"""

import os
import glob
import re
import json

def load_route_labels():
    with open('data/routes.json', 'r', encoding='utf-8') as f:
        data = json.load(f)
    return {k: v.get('label', '') for k, v in data.get('routes', {}).items()}

def clean_file(filepath, route_key, page_label):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original_len = len(content)

    # 1. Fix malformed html tag
    content = re.sub(r'<html\\1\\2\s*([^>]*)>', r'<html \1 lang="vi">', content)
    content = content.replace('</html\\1\\2>', '</html>')
    
    # Ensure lang="vi" in <html ...>
    def fix_html_lang(match):
        attrs = match.group(1)
        if 'lang=' not in attrs:
            attrs = f'{attrs} lang="vi"'.strip()
        return f'<html {attrs}>'
    content = re.sub(r'<html\s+([^>]+)>', fix_html_lang, content)

    # 2. Remove dead DOM elements: data-old-header and data-old-footer
    content = re.sub(r'<header[^>]*data-old-header="1"[^>]*>.*?</header>', '', content, flags=re.DOTALL)
    content = re.sub(r'<footer[^>]*data-old-footer="1"[^>]*>.*?</footer>', '', content, flags=re.DOTALL)

    # 3. Clean up font imports and deduplicate Material Symbols
    # Keep only one clean block for fonts if duplicate exists
    ms_count = len(re.findall(r'<link[^>]+Material\+Symbols\+Outlined[^>]+>', content))
    if ms_count > 1:
        # Remove all Material Symbols links and re-add one
        content = re.sub(r'<link[^>]+Material\+Symbols\+Outlined[^>]+>\s*', '', content)
        font_link = '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>'
        # Insert after Plus+Jakarta+Sans
        content = re.sub(r'(<link[^>]+Plus\+Jakarta\+Sans[^>]+>)', r'\1\n' + font_link, content)

    # 4. Clean up AI prompt text in alt attributes
    def clean_alt(match):
        alt_text = match.group(1)
        if any(w in alt_text for w in ['Primary color', 'plusJakartaSans', 'Mode: light', 'Roundness']):
            if 'Brand logo' in alt_text or 'Logo' in alt_text:
                return 'alt="PhoneX Logo - Smartphone Flagship"'
            return 'alt="PhoneX Sản phẩm & Dịch vụ chính hãng"'
        return match.group(0)

    content = re.sub(r'alt="([^"]*)"', clean_alt, content)

    # 5. Fix Accessibility: data-alt without alt -> convert to alt
    def fix_data_alt(match):
        img_tag = match.group(0)
        has_real_alt = bool(re.search(r'(?<![a-zA-Z0-9\-])alt\s*=', img_tag))
        if not has_real_alt:
            data_alt_match = re.search(r'data-alt="([^"]*)"', img_tag)
            if data_alt_match:
                val = data_alt_match.group(1).strip()
                # Clean up if prompt
                if any(w in val for w in ['Primary color', 'plusJakartaSans', 'Mode: light', 'Roundness']):
                    val = "PhoneX - Smartphone chính hãng"
                elif not val:
                    val = "Hình ảnh PhoneX"
                img_tag = img_tag.replace(data_alt_match.group(0), f'alt="{val}"')
        return img_tag

    content = re.sub(r'<img[^>]+>', fix_data_alt, content)

    # 6. Accessibility on menu button
    content = content.replace('<button class="pxMenu"', '<button class="pxMenu" type="button" aria-label="Mở danh mục menu"')

    # 7. Normalize Title & SEO Meta in <head>
    target_title = f"{page_label} | PhoneX - Hệ Thống Smartphone Chính Hãng" if page_label else "PhoneX - Smartphone Flagship Chính Hãng"
    meta_seo = f'''<title>{target_title}</title>
<meta name="description" content="PhoneX - Chuyên trang mua sắm {page_label.lower() if page_label else 'smartphone'}, định giá thu cũ đổi mới, trả góp 0% và bảo hành điện tử chính hãng toàn quốc."/>
<meta property="og:title" content="{target_title}"/>
<meta property="og:description" content="Hệ sinh thái smartphone chính hãng, thu cũ đổi mới trợ giá cao nhất và giao hàng hỏa tốc tại PhoneX."/>
<meta property="og:type" content="website"/>
<meta name="robots" content="index, follow"/>'''

    # If <title> exists, replace it, else insert before </head>
    if '<title>' in content:
        content = re.sub(r'<title>.*?</title>', f'<title>{target_title}</title>', content)
        # Check if description exists
        if 'name="description"' not in content:
            content = content.replace(f'<title>{target_title}</title>', meta_seo)
    else:
        # Insert right after <meta content="web_standard" name="shell-type"/> or after <head>
        if '<meta content="web_standard" name="shell-type"/>' in content:
            content = content.replace('<meta content="web_standard" name="shell-type"/>', '<meta content="web_standard" name="shell-type"/>\n' + meta_seo)
        else:
            content = re.sub(r'(<head[^>]*>)', r'\1\n' + meta_seo, content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

    new_len = len(content)
    return original_len, new_len

def main():
    route_labels = load_route_labels()
    files = sorted(glob.glob('pages/*/*/index.html'))
    total_saved = 0
    print(f"Bắt đầu chuẩn hóa {len(files)} trang HTML...")

    for f in files:
        rel = f.replace('pages/', '').replace('/index.html', '')
        label = route_labels.get(rel, rel.replace('-', ' ').title())
        orig, new = clean_file(f, rel, label)
        saved = orig - new
        total_saved += saved
        print(f"✔ {rel}: {orig} -> {new} bytes (giảm {saved:,} bytes rác)")

    print(f"\n Hoàn tất! Đã dọn sạch tổng cộng {total_saved:,} bytes (~{total_saved//1024:,} KB) rác DOM.")

if __name__ == '__main__':
    main()
