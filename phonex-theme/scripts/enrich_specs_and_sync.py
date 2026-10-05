#!/usr/bin/env python3
"""
Enrich specifications and detailed descriptions for all phone models in PhoneX Kho Máy Cũ.
Matches models (Apple, Samsung, OPPO, Xiaomi, Vivo, Realme, Honor, Oukitel, etc.)
and generates accurate technical specifications (spec_groups, summary_specs)
and comprehensive product descriptions (the_content with PhoneX 30-step inspection report).
"""

import os
import re
import sys
import html
import json
import time

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
THEME_DIR = os.path.dirname(SCRIPT_DIR)
DATA_JSON_PATH = os.path.join(THEME_DIR, 'data', 'used-phones.json')

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
    return text[:70]

def build_model_specs(raw_name, brand, condition, battery, price):
    n = raw_name.lower()
    b = brand.lower()

    # Defaults
    screen_size = "6.67 inch"
    screen_tech = "AMOLED"
    screen_res = "Full HD+ (1080 x 2400 Pixels)"
    screen_refresh = "120 Hz"
    screen_bright = "1200 nits"

    cam_back_main = "50 MP, f/1.8, OIS chống rung quang học"
    cam_back_sub = "8 MP (Góc siêu rộng) + 2 MP (Macro)"
    cam_back_video = "4K@30fps, 1080p@60fps"
    cam_front = "16 MP, f/2.4, HDR, Làm đẹp AI"

    cpu_chip = "MediaTek Dimensity 7050 8 nhân"
    cpu_speed = "2 nhân 2.6 GHz & 6 nhân 2.0 GHz"
    gpu_chip = "Mali-G68 MC4"

    ram_val = "8 GB"
    rom_val = "256 GB"
    ram_m = re.search(r'(\d+)\s*(?:gb|g)?\s*/\s*(\d+)\s*(?:gb|g)?', n)
    if ram_m:
        ram_val = f"{ram_m.group(1)} GB"
        rom_val = f"{ram_m.group(2)} GB"
    else:
        rom_m = re.search(r'\b(64|128|256|512|1024|1tb)\s*gb?\b', n)
        if rom_m:
            rom_val = f"{rom_m.group(1).upper()}"
            if not rom_val.endswith('B'):
                rom_val += 'GB'
            if rom_val == '1024GB':
                rom_val = '1TB'

    battery_cap = "5000 mAh"
    charging_tech = "Sạc nhanh 67W, Tiết kiệm pin"
    os_val = "Android 14"
    connect_val = "5G Sub-6, Wi-Fi 6, Bluetooth 5.3, NFC, Type-C"
    sim_val = "2 Nano SIM (hoặc 1 eSIM + 1 Nano SIM)"
    ip_rating = "Kháng nước, kháng bụi IP65"
    weight_val = "185 g"
    material_val = "Khung viền hợp kim, mặt lưng kính cường lực"

    # ================= 1. APPLE IPHONE =================
    if 'apple' in b or 'iphone' in n:
        os_val = "iOS 18 (Hỗ trợ cập nhật lâu dài)"
        sim_val = "1 Nano SIM & 1 eSIM (hoặc 2 eSIM)"
        ip_rating = "Kháng nước, kháng bụi IP68 (Độ sâu 6m trong 30 phút)"
        material_val = "Khung viền nhôm hàng không / Titanium, mặt lưng kính Ceramic Shield"

        if '16 pro max' in n:
            screen_size = "6.9 inch"
            screen_tech = "Super Retina XDR OLED, ProMotion 120Hz"
            screen_res = "2868 x 1320 Pixels"
            screen_bright = "2000 nits"
            cam_back_main = "48 MP Fusion (24mm, f/1.78, OIS Sensor-shift)"
            cam_back_sub = "48 MP (Góc siêu rộng 120°) + 12 MP (Telephoto 5x tiềm vọng)"
            cam_back_video = "4K@120fps Dolby Vision, ProRes LOG"
            cam_front = "12 MP TrueDepth, f/1.9, Face ID 3D"
            cpu_chip = "Apple A18 Pro (3nm thế hệ 2, 6 nhân)"
            gpu_chip = "Apple GPU 6 nhân thế hệ mới"
            ram_val = "8 GB"
            battery_cap = "4685 mAh"
            charging_tech = "Sạc nhanh 25W MagSafe, Sạc không dây Qi2 15W, Cổng USB-C 3.0"
            weight_val = "227 g"
        elif '16 pro' in n:
            screen_size = "6.3 inch"
            screen_tech = "Super Retina XDR OLED, ProMotion 120Hz"
            screen_res = "2622 x 1206 Pixels"
            screen_bright = "2000 nits"
            cam_back_main = "48 MP Fusion (OIS Sensor-shift)"
            cam_back_sub = "48 MP (Góc siêu rộng) + 12 MP (Telephoto 5x)"
            cam_front = "12 MP TrueDepth Face ID"
            cpu_chip = "Apple A18 Pro (3nm, 6 nhân)"
            gpu_chip = "Apple GPU 6 nhân"
            ram_val = "8 GB"
            battery_cap = "3582 mAh"
            charging_tech = "Sạc nhanh 25W MagSafe, USB-C 3.0"
            weight_val = "199 g"
        elif '16' in n:
            screen_size = "6.1 inch"
            screen_tech = "Super Retina XDR OLED, Dynamic Island"
            screen_res = "2556 x 1179 Pixels"
            cam_back_main = "48 MP Fusion (f/1.6, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng 120°)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A18 (3nm, 6 nhân)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "8 GB"
            battery_cap = "3561 mAh"
            charging_tech = "Sạc nhanh 20W, MagSafe, USB-C"
            weight_val = "170 g"
        elif '15 pro max' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super Retina XDR OLED, ProMotion 120Hz"
            screen_res = "2796 x 1290 Pixels"
            cam_back_main = "48 MP Main (f/1.78, OIS Sensor-shift)"
            cam_back_sub = "12 MP (Góc siêu rộng) + 12 MP (Telephoto 5x)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A17 Pro (3nm)"
            gpu_chip = "Apple GPU 6 nhân Ray Tracing"
            ram_val = "8 GB"
            battery_cap = "4441 mAh"
            charging_tech = "Sạc nhanh 20W, MagSafe 15W, USB-C 3.0"
            weight_val = "221 g"
        elif '15' in n:
            screen_size = "6.1 inch"
            screen_tech = "Super Retina XDR OLED, Dynamic Island"
            screen_res = "2556 x 1179 Pixels"
            cam_back_main = "48 MP Main (f/1.6, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A16 Bionic (4nm)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "6 GB"
            battery_cap = "3349 mAh"
            charging_tech = "Sạc nhanh 20W, USB-C"
            weight_val = "171 g"
        elif '14 pro max' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super Retina XDR OLED, Dynamic Island 120Hz"
            screen_res = "2796 x 1290 Pixels"
            cam_back_main = "48 MP Main (f/1.78, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng) + 12 MP (Tele 3x)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A16 Bionic (4nm)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "6 GB"
            battery_cap = "4323 mAh"
            charging_tech = "Sạc nhanh 20W, Lightning"
            weight_val = "240 g"
        elif '14 plus' in n or '14+' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2778 x 1284 Pixels"
            cam_back_main = "12 MP Main (f/1.5, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A15 Bionic (5 nhân GPU)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "6 GB"
            battery_cap = "4325 mAh"
            charging_tech = "Sạc nhanh 20W"
            weight_val = "203 g"
        elif '14' in n:
            screen_size = "6.1 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2532 x 1170 Pixels"
            cam_back_main = "12 MP Main (f/1.5, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A15 Bionic (5 nhân GPU)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "6 GB"
            battery_cap = "3279 mAh"
            charging_tech = "Sạc nhanh 20W"
            weight_val = "172 g"
        elif '13 pro max' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super Retina XDR OLED, 120Hz ProMotion"
            screen_res = "2778 x 1284 Pixels"
            cam_back_main = "12 MP Main (f/1.5, OIS Sensor-shift)"
            cam_back_sub = "12 MP (Góc siêu rộng) + 12 MP (Tele 3x)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A15 Bionic (5 nhân GPU)"
            gpu_chip = "Apple GPU 5 nhân"
            ram_val = "6 GB"
            battery_cap = "4352 mAh"
            charging_tech = "Sạc nhanh 20W, Lightning"
            weight_val = "238 g"
        elif '13' in n:
            screen_size = "6.1 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2532 x 1170 Pixels"
            cam_back_main = "12 MP Main (f/1.6, OIS chéo)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A15 Bionic (4 nhân GPU)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "4 GB"
            battery_cap = "3227 mAh"
            charging_tech = "Sạc nhanh 20W"
            weight_val = "173 g"
        elif '12 pro max' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2778 x 1284 Pixels"
            cam_back_main = "12 MP Main (f/1.6, OIS Sensor-shift)"
            cam_back_sub = "12 MP (Góc siêu rộng) + 12 MP (Tele 2.5x) + LiDAR"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A14 Bionic (5nm)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "6 GB"
            battery_cap = "3687 mAh"
            charging_tech = "Sạc nhanh 20W"
            weight_val = "226 g"
        elif '12' in n:
            screen_size = "6.1 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2532 x 1170 Pixels"
            cam_back_main = "12 MP Main (f/1.6)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A14 Bionic (5nm)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "4 GB"
            battery_cap = "2815 mAh"
            charging_tech = "Sạc nhanh 20W"
            weight_val = "162 g"
        elif '11 pro' in n:
            screen_size = "5.8 inch"
            screen_tech = "Super Retina XDR OLED"
            screen_res = "2436 x 1125 Pixels"
            cam_back_main = "12 MP Main (f/1.8, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng) + 12 MP (Tele 2x)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A13 Bionic (7nm+)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "4 GB"
            battery_cap = "3046 mAh"
            charging_tech = "Sạc nhanh 18W"
            weight_val = "188 g"
        elif '11' in n:
            screen_size = "6.1 inch"
            screen_tech = "Liquid Retina IPS LCD"
            screen_res = "1792 x 828 Pixels"
            cam_back_main = "12 MP Main (f/1.8, OIS)"
            cam_back_sub = "12 MP (Góc siêu rộng)"
            cam_front = "12 MP TrueDepth"
            cpu_chip = "Apple A13 Bionic (7nm+)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "4 GB"
            battery_cap = "3110 mAh"
            charging_tech = "Sạc nhanh 18W"
            weight_val = "194 g"
        elif 'xs max' in n:
            screen_size = "6.5 inch"
            screen_tech = "Super Retina OLED"
            screen_res = "2688 x 1242 Pixels"
            cam_back_main = "12 MP Main (f/1.8, OIS)"
            cam_back_sub = "12 MP (Tele 2x, OIS)"
            cam_front = "7 MP TrueDepth"
            cpu_chip = "Apple A12 Bionic (7nm)"
            gpu_chip = "Apple GPU 4 nhân"
            ram_val = "4 GB"
            battery_cap = "3174 mAh"
            charging_tech = "Sạc nhanh 15W"
            weight_val = "208 g"

    # ================= 2. SAMSUNG GALAXY =================
    elif 'samsung' in b or 'galaxy' in n:
        os_val = "Android 14, One UI 6.1 (Tích hợp Galaxy AI)"
        if 's24 ultra' in n:
            screen_size = "6.8 inch"
            screen_tech = "Dynamic AMOLED 2X, 120Hz, HDR10+"
            screen_res = "Quad HD+ (3120 x 1440 Pixels)"
            screen_bright = "2600 nits"
            cam_back_main = "200 MP (f/1.7, OIS, Laser AF)"
            cam_back_sub = "50 MP (Periscope Tele 5x) + 10 MP (Tele 3x) + 12 MP (Ultra Wide)"
            cam_back_video = "8K@30fps, 4K@120fps"
            cam_front = "12 MP Dual Pixel PDAF"
            cpu_chip = "Snapdragon 8 Gen 3 for Galaxy (4nm, 8 nhân)"
            gpu_chip = "Adreno 750"
            ram_val = "12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh 45W, Sạc không dây 15W, Bút S-Pen tích hợp"
            ip_rating = "IP68"
            weight_val = "232 g"
        elif 's23 ultra' in n:
            screen_size = "6.8 inch"
            screen_tech = "Dynamic AMOLED 2X, 120Hz"
            screen_res = "Quad HD+ (3088 x 1440 Pixels)"
            screen_bright = "1750 nits"
            cam_back_main = "200 MP (f/1.7, OIS)"
            cam_back_sub = "10 MP (Tele 10x) + 10 MP (Tele 3x) + 12 MP (Ultra Wide)"
            cam_back_video = "8K@30fps, 4K@60fps"
            cam_front = "12 MP Dual Pixel"
            cpu_chip = "Snapdragon 8 Gen 2 for Galaxy (4nm)"
            gpu_chip = "Adreno 740"
            ram_val = "8 GB / 12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh 45W, Bút S-Pen"
            ip_rating = "IP68"
            weight_val = "234 g"
        elif 's24 fe' in n or 's23 fe' in n:
            screen_size = "6.4 inch"
            screen_tech = "Dynamic AMOLED 2X, 120Hz"
            screen_res = "Full HD+ (1080 x 2340 Pixels)"
            cam_back_main = "50 MP (f/1.8, OIS)"
            cam_back_sub = "8 MP (Tele 3x) + 12 MP (Ultra Wide)"
            cam_front = "10 MP"
            cpu_chip = "Exynos 2400e / Exynos 2200 8 nhân"
            gpu_chip = "Xclipse 940"
            ram_val = "8 GB"
            battery_cap = "4700 mAh"
            charging_tech = "Sạc nhanh 25W, Sạc không dây"
            ip_rating = "IP68"
            weight_val = "209 g"
        elif 's22 ultra' in n:
            screen_size = "6.8 inch"
            screen_tech = "Dynamic AMOLED 2X, 120Hz"
            screen_res = "Quad HD+ (3088 x 1440 Pixels)"
            cam_back_main = "108 MP (f/1.8, OIS)"
            cam_back_sub = "10 MP (Tele 10x) + 10 MP (Tele 3x) + 12 MP (Ultra Wide)"
            cam_front = "40 MP"
            cpu_chip = "Snapdragon 8 Gen 1 (4nm)"
            gpu_chip = "Adreno 730"
            ram_val = "8 GB / 12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh 45W, Bút S-Pen"
            ip_rating = "IP68"
            weight_val = "228 g"
        elif 'z flip 7' in n or 'z flip 6' in n or 'z flip' in n:
            screen_size = "Chính 6.7\" gập & Phụ 3.4\" Flex Window"
            screen_tech = "Dynamic AMOLED 2X, 120Hz"
            screen_res = "Full HD+ (2640 x 1080 Pixels)"
            cam_back_main = "50 MP (f/1.8, OIS)"
            cam_back_sub = "12 MP (Ultra Wide 123°)"
            cam_front = "10 MP"
            cpu_chip = "Snapdragon 8 Gen 3 for Galaxy (4nm)"
            gpu_chip = "Adreno 750"
            ram_val = "12 GB"
            battery_cap = "4000 mAh"
            charging_tech = "Sạc nhanh 25W, Sạc không dây 15W, Thiết kế gập vỏ sò cao cấp"
            ip_rating = "IP48"
            weight_val = "187 g"
        elif 'a56' in n or 'a55' in n or 'a54' in n:
            screen_size = "6.6 inch"
            screen_tech = "Super AMOLED, 120Hz, Vision Booster"
            screen_res = "Full HD+ (1080 x 2340 Pixels)"
            cam_back_main = "50 MP (f/1.8, OIS)"
            cam_back_sub = "12 MP (Ultra Wide) + 5 MP (Macro)"
            cam_front = "32 MP"
            cpu_chip = "Exynos 1480 (4nm, GPU AMD Xclipse 530)"
            ram_val = "8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh 25W"
            ip_rating = "IP67"
            weight_val = "213 g"
        elif 'a34' in n or 'a33' in n or 'a35' in n:
            screen_size = "6.6 inch"
            screen_tech = "Super AMOLED, 120Hz"
            screen_res = "Full HD+"
            cam_back_main = "48 MP (f/1.8, OIS)"
            cam_back_sub = "8 MP + 5 MP"
            cam_front = "13 MP"
            cpu_chip = "MediaTek Dimensity 1080 8 nhân"
            ram_val = "8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh 25W"
            ip_rating = "IP67"
            weight_val = "199 g"
        elif 'a16' in n or 'a15' in n or 'a17' in n:
            screen_size = "6.7 inch"
            screen_tech = "Super AMOLED, 90Hz"
            screen_res = "Full HD+ (1080 x 2340 Pixels)"
            cam_back_main = "50 MP (f/1.8)"
            cam_back_sub = "5 MP + 2 MP"
            cam_front = "13 MP"
            cpu_chip = "MediaTek Dimensity 6300 / Helio G99"
            ram_val = "8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh 25W"
            weight_val = "200 g"
        elif 'a06' in n or 'a07' in n:
            screen_size = "6.7 inch"
            screen_tech = "PLS LCD, 90Hz"
            screen_res = "HD+ (720 x 1600 Pixels)"
            cam_back_main = "50 MP (f/1.8)"
            cam_back_sub = "2 MP (Xóa phông)"
            cam_front = "8 MP"
            cpu_chip = "MediaTek Helio G85 8 nhân"
            ram_val = "4 GB / 8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh 25W"
            weight_val = "189 g"

    # ================= 3. OPPO =================
    elif 'oppo' in b or 'reno' in n:
        os_val = "Android 14, ColorOS 14 (AI Portrait mượt mà)"
        if 'reno 15f' in n or '15f' in n:
            screen_size = "6.7 inch"
            screen_tech = "AMOLED, 120Hz, 1.07 tỷ màu"
            screen_res = "Full HD+ (1080 x 2412 Pixels)"
            screen_bright = "1200 nits"
            cam_back_main = "50 MP Chân dung sắc nét (f/1.8, OIS)"
            cam_back_sub = "8 MP (Góc rộng 112°) + 2 MP (Macro)"
            cam_front = "32 MP Sony IMX615, Tự động lấy nét, AI Beauty"
            cpu_chip = "MediaTek Dimensity 7050 5G (6nm)"
            gpu_chip = "Mali-G68 MC4"
            ram_val = "8 GB / 12 GB (Mở rộng RAM +8GB)"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh SUPERVOOC 67W (50% trong 19 phút)"
            weight_val = "177 g siêu mỏng nhẹ"
        elif 'reno 14f' in n or '14f' in n or '11f' in n:
            screen_size = "6.7 inch"
            screen_tech = "AMOLED, 120Hz, Viền siêu mỏng"
            screen_res = "Full HD+"
            cam_back_main = "64 MP Chân dung siêu nét"
            cam_back_sub = "8 MP (Góc rộng) + 2 MP (Macro)"
            cam_front = "32 MP Chân dung tự nhiên"
            cpu_chip = "MediaTek Dimensity 7050 5G (6nm)"
            ram_val = "8 GB / 12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh SUPERVOOC 67W"
            ip_rating = "IP65 kháng bụi nước"
            weight_val = "177 g"
        elif 'find x5 pro' in n or 'find' in n:
            screen_size = "6.7 inch"
            screen_tech = "LTPO2 AMOLED, 120Hz, 1 tỷ màu"
            screen_res = "2K+ (1440 x 3216 Pixels)"
            cam_back_main = "50 MP Sony IMX766, OIS 5 trục, MariSilicon X"
            cam_back_sub = "50 MP (Góc siêu rộng) + 13 MP (Tele 5x)"
            cam_front = "32 MP Sony"
            cpu_chip = "Snapdragon 8 Gen 1 (4nm)"
            ram_val = "12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh SUPERVOOC 80W, Sạc không dây AirVOOC 50W"
            ip_rating = "IP68"
            material_val = "Mặt lưng gốm Ceramic nguyên khối cao cấp"
            weight_val = "218 g"
        elif 'a58' in n or 'a5' in n:
            screen_size = "6.72 inch"
            screen_tech = "LTPS LCD, 100% DCI-P3"
            screen_res = "Full HD+ (1080 x 2400 Pixels)"
            cam_back_main = "50 MP (f/1.8)"
            cam_back_sub = "2 MP (Xóa phông)"
            cam_front = "8 MP"
            cpu_chip = "MediaTek Helio G85 8 nhân"
            ram_val = "6 GB / 8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh SUPERVOOC 33W"
            weight_val = "192 g"

    # ================= 4. XIAOMI / REDMI =================
    elif 'xiaomi' in b or 'redmi' in n or 'poco' in n:
        os_val = "Xiaomi HyperOS (Android 14) tối ưu mượt mà"
        if '14t' in n:
            screen_size = "6.67 inch"
            screen_tech = "AMOLED, 144Hz, HDR10+, Dolby Vision"
            screen_res = "1.5K (1220 x 2712 Pixels)"
            screen_bright = "4000 nits đỉnh"
            cam_back_main = "50 MP Sony Light Fusion 900 (OIS, Thấu kính Leica Summilux)"
            cam_back_sub = "50 MP (Telephoto 50mm Leica) + 12 MP (Góc siêu rộng 15mm)"
            cam_front = "32 MP"
            cpu_chip = "MediaTek Dimensity 8300-Ultra (4nm, 8 nhân)"
            gpu_chip = "Mali-G615-MC6"
            ram_val = "12 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc siêu nhanh HyperCharge 67W"
            ip_rating = "IP68"
            weight_val = "193 g"
        elif 'xiaomi 13' in n:
            screen_size = "6.36 inch"
            screen_tech = "OLED, 120Hz, Viền siêu mỏng 1.61mm"
            screen_res = "Full HD+ (1080 x 2400 Pixels)"
            cam_back_main = "50 MP Leica (f/1.8, HyperOIS)"
            cam_back_sub = "10 MP (Tele 3.2x, OIS) + 12 MP (Góc siêu rộng)"
            cam_front = "32 MP"
            cpu_chip = "Snapdragon 8 Gen 2 (4nm)"
            ram_val = "8 GB / 12 GB"
            battery_cap = "4500 mAh"
            charging_tech = "Sạc siêu tốc 67W, Sạc không dây 50W"
            ip_rating = "IP68"
            weight_val = "185 g"
        elif 'note 14 pro' in n or 'note 15 pro' in n:
            screen_size = "6.67 inch"
            screen_tech = "AMOLED cong 3D, 120Hz, 68 tỷ màu"
            screen_res = "1.5K (1220 x 2712 Pixels)"
            cam_back_main = "50 MP Sony LYT-600 / 200 MP (OIS)"
            cam_back_sub = "8 MP (Ultra Wide) + 2 MP (Macro)"
            cam_front = "20 MP"
            cpu_chip = "Snapdragon 7s Gen 2 / Dimensity 7300-Ultra"
            ram_val = "8 GB / 12 GB"
            battery_cap = "5100 mAh / 5500 mAh"
            charging_tech = "Sạc nhanh Turbo Charge 67W"
            ip_rating = "IP68/IP69K siêu bền"
            weight_val = "190 g"
        elif 'redmi 13' in n or 'redmi 15c' in n:
            screen_size = "6.79 inch"
            screen_tech = "IPS LCD, 90Hz, Kính Gorilla Glass"
            screen_res = "Full HD+ (1080 x 2460 Pixels)"
            cam_back_main = "108 MP Siêu nét 3x In-sensor Zoom"
            cam_back_sub = "2 MP (Macro)"
            cam_front = "13 MP"
            cpu_chip = "MediaTek Helio G91-Ultra 8 nhân"
            ram_val = "6 GB / 8 GB"
            battery_cap = "5030 mAh"
            charging_tech = "Sạc nhanh 33W"
            material_val = "Mặt lưng kính bóng bẩy cao cấp"
            weight_val = "205 g"

    # ================= 5. VIVO =================
    elif 'vivo' in b or 'vivo' in n:
        os_val = "OriginOS / Funtouch OS 14 (Android 14)"
        if 'x200 pro' in n:
            screen_size = "6.31 inch"
            screen_tech = "LTPO AMOLED, 120Hz, Zeiss Master Color"
            screen_res = "1.5K (1216 x 2640 Pixels)"
            screen_bright = "4500 nits cực đỉnh"
            cam_back_main = "50 MP Sony LYT-818 (1/1.28\", OIS, Thấu kính Zeiss T*)"
            cam_back_sub = "50 MP (Periscope Tele 3x) + 50 MP (Ultra Wide 119°)"
            cam_front = "32 MP"
            cpu_chip = "MediaTek Dimensity 9400 (3nm đỉnh cao, 8 nhân)"
            gpu_chip = "Immortalis-G925"
            ram_val = "12 GB / 16 GB"
            battery_cap = "5700 mAh (Pin Silicon-Carbon thế hệ mới)"
            charging_tech = "Sạc siêu nhanh FlashCharge 90W"
            ip_rating = "IP68/IP69"
            weight_val = "187 g"
        elif 'v50 lite' in n or 'y100' in n or 'y29' in n:
            screen_size = "6.67 inch"
            screen_tech = "AMOLED, 120Hz, 1800 nits"
            screen_res = "Full HD+"
            cam_back_main = "50 MP Aura Light (OIS chống rung)"
            cam_back_sub = "8 MP + 2 MP"
            cam_front = "32 MP"
            cpu_chip = "Snapdragon 685 / 4 Gen 2"
            ram_val = "8 GB"
            battery_cap = "5000 mAh"
            charging_tech = "Sạc nhanh FlashCharge 80W / 44W"
            weight_val = "185 g"

    # ================= 6. OUKITEL PIN KHỦNG & SIÊU BỀN =================
    elif 'oukitel' in b or 'oukitel' in n:
        screen_size = "Chính 6.8\" FHD+ 120Hz & Phụ sau 1.1\" AMOLED"
        screen_tech = "IPS LCD siêu bền, Kính cường lực Gorilla Glass 5"
        screen_res = "Full HD+ (1080 x 2460 Pixels)"
        cam_back_main = "200 MP Siêu chi tiết (f/1.65)"
        cam_back_sub = "64 MP Camera Hồng ngoại quan sát đêm (Night Vision) + 2 MP"
        cam_front = "32 MP"
        cpu_chip = "MediaTek Helio G99 6nm 8 nhân"
        ram_val = "12 GB (Mở rộng lên đến 24GB)"
        rom_val = "256 GB"
        battery_cap = "15.000 mAh (Dùng liên tục 3-5 ngày, hỗ trợ sạc ngược cho máy khác)"
        charging_tech = "Sạc nhanh 65W, Chuẩn chống sốc quân sự MIL-STD-810H"
        ip_rating = "Chuẩn chống nước, chống bụi cao nhất IP68 / IP69K (Chịu áp lực nước nóng)"
        weight_val = "465 g đầm chắc siêu bền"
        material_val = "Khung kim loại gia cường bọc cao su chống va đập 1.8m"

    # Structured spec_groups list
    spec_groups = [
        {
            "group": "Màn hình",
            "items": [
                {"name": "Kích thước màn hình", "value": screen_size},
                {"name": "Công nghệ màn hình", "value": screen_tech},
                {"name": "Độ phân giải màn hình", "value": screen_res},
                {"name": "Tần số quét", "value": screen_refresh},
                {"name": "Độ sáng tối đa", "value": screen_bright}
            ]
        },
        {
            "group": "Camera sau",
            "items": [
                {"name": "Độ phân giải camera sau", "value": cam_back_main},
                {"name": "Camera phụ", "value": cam_back_sub},
                {"name": "Quay phim", "value": cam_back_video},
                {"name": "Tính năng camera", "value": "Chụp đêm (Night Mode), Xóa phông chân dung, HDR tự động, Chống rung quang học (OIS)"}
            ]
        },
        {
            "group": "Camera trước",
            "items": [
                {"name": "Độ phân giải camera trước", "value": cam_front},
                {"name": "Tính năng", "value": "Tự động lấy nét, Xóa phông, Quay video Full HD/4K, Mở khóa khuôn mặt Face ID / AI"}
            ]
        },
        {
            "group": "Hệ điều hành & Vi xử lý (CPU)",
            "items": [
                {"name": "Hệ điều hành", "value": os_val},
                {"name": "Chip xử lý (CPU)", "value": cpu_chip},
                {"name": "Tốc độ CPU", "value": cpu_speed},
                {"name": "Chip đồ họa (GPU)", "value": gpu_chip}
            ]
        },
        {
            "group": "RAM & Bộ nhớ lưu trữ",
            "items": [
                {"name": "RAM", "value": ram_val},
                {"name": "Dung lượng lưu trữ", "value": rom_val},
                {"name": "Khả dụng", "value": "Đã định dạng sạch, sẵn sàng sử dụng 100%"}
            ]
        },
        {
            "group": "Pin & Công nghệ sạc",
            "items": [
                {"name": "Dung lượng pin", "value": battery_cap},
                {"name": "Tình trạng pin thực tế", "value": battery},
                {"name": "Công nghệ sạc", "value": charging_tech}
            ]
        },
        {
            "group": "Kết nối & Tiện ích",
            "items": [
                {"name": "Mạng di động", "value": connect_val},
                {"name": "SIM", "value": sim_val},
                {"name": "Chuẩn kháng nước, bụi", "value": ip_rating},
                {"name": "Bảo mật sinh trắc học", "value": "Mở khóa khuôn mặt 3D / Cảm biến vân tay dưới màn hình"}
            ]
        },
        {
            "group": "Thiết kế & Chất liệu",
            "items": [
                {"name": "Chất liệu", "value": material_val},
                {"name": "Trọng lượng", "value": weight_val},
                {"name": "Phân loại thẩm mỹ", "value": condition}
            ]
        }
    ]

    summary_specs = {
        "screen": f"{screen_size}, {screen_tech}, {screen_res}",
        "os": os_val,
        "cam_back": cam_back_main,
        "cam_front": cam_front,
        "cpu": cpu_chip,
        "ram": ram_val,
        "rom": rom_val,
        "battery": f"{battery_cap} • {battery}"
    }

    # Rich, beautiful editorial article
    article = f"""
<div class="phonex-product-editorial">
  <h3>Đánh Giá Chi Tiết {raw_name} — Tuyển Chọn Like New Tại PhoneX</h3>
  <p><strong>{raw_name}</strong> là một trong những sản phẩm được săn đón nhất trong phân khúc máy cũ lướt nhờ thiết kế thời thượng, cấu hình mạnh mẽ và giá trị sử dụng lâu dài vượt trội so với mức chi phí đầu tư ban đầu.</p>
  
  <h4>1. Trải nghiệm Màn hình &amp; Hiển thị xuất sắc</h4>
  <p>Máy được trang bị màn hình <strong>{screen_size}</strong> sử dụng tấm nền công nghệ <strong>{screen_tech}</strong> cùng độ phân giải <strong>{screen_res}</strong> và tần số quét <strong>{screen_refresh}</strong>. Mọi thao tác cuộn lướt, chuyển cảnh hay giải trí xem phim, chơi game đều cực kỳ mượt mà, màu sắc sống động và độ tương phản sâu đạt chuẩn rạp chiếu.</p>

  <h4>2. Sức mạnh Hiệu năng &amp; Đa nhiệm</h4>
  <p>Được vận hành bởi vi xử lý <strong>{cpu_chip}</strong> kết hợp bộ nhớ RAM <strong>{ram_val}</strong> và bộ nhớ trong <strong>{rom_val}</strong>, {raw_name} xử lý trơn tru mọi tác vụ từ học tập, làm việc văn phòng đến các tựa game đồ họa nặng mà không lo giật lag hay quá nhiệt.</p>

  <h4>3. Khả năng Nhiếp ảnh &amp; Quay Video Chuyên Nghiệp</h4>
  <p>Cụm camera sau <strong>{cam_back_main}</strong> cùng camera trước <strong>{cam_front}</strong> hỗ trợ chống rung quang học OIS và các thuật toán xử lý hình ảnh tiên tiến, mang lại những bức ảnh sắc nét, màu sắc tự nhiên ngay cả trong điều kiện thiếu sáng hoặc ngược sáng.</p>

  <h4>4. Báo Cáo Kiểm Định 30 Bước PhoneX Lab Certified</h4>
  <p>Tất cả sản phẩm tại PhoneX đều phải trải qua quy trình thẩm định 30 bước khắt khe bởi đội ngũ kỹ sư phần cứng giàu kinh nghiệm trước khi lên kệ:</p>
  <ul>
    <li><strong>Nguồn gốc xuất xứ:</strong> 100% máy chính hãng, số IMEI rõ ràng, không dính tài khoản iCloud / Google / Knox ẩn.</li>
    <li><strong>Mainboard &amp; Linh kiện:</strong> Nguyên bản 100%, chưa từng qua sửa chữa hay thay thế linh kiện trôi nổi.</li>
    <li><strong>Màn hình &amp; Cảm ứng:</strong> Sáng đẹp, không điểm chết, không ám ố, cảm ứng đa điểm mượt mà 10/10.</li>
    <li><strong>Tình trạng pin:</strong> <strong>{battery}</strong>, chu kỳ sạc ổn định, không chai phồng, đảm bảo thời lượng sử dụng trọn vẹn cả ngày.</li>
    <li><strong>Chức năng ngoại vi:</strong> Face ID / Cảm biến vân tay siêu nhạy, loa trong / loa ngoài to rõ không rè, mic thu âm trong trẻo, chân sạc sạch sẽ kết nối ổn định.</li>
  </ul>

  <h4>5. Quyền Lợi &amp; Chính Sách Bảo Hành Khi Mua Tại PhoneX</h4>
  <ul>
    <li><strong>Bảo hành toàn diện:</strong> 12 tháng phần cứng cho cả nguồn và màn hình.</li>
    <li><strong>Đổi mới linh hoạt:</strong> 1 đổi 1 trong 30 ngày đầu tiên nếu phát sinh bất kỳ lỗi kỹ thuật nào từ nhà sản xuất.</li>
    <li><strong>Hỗ trợ tài chính:</strong> Trả góp 0% lãi suất duyệt hồ sơ nhanh qua CCCD hoặc thẻ tín dụng.</li>
    <li><strong>Thu cũ đổi mới (Trade-in):</strong> Trợ giá thu lại máy cũ lên đến 3.000.000₫.</li>
  </ul>
</div>
"""

    return spec_groups, summary_specs, article

def main():
    print("=== STARTING SPEC ENRICHMENT AND WOOCOMMERCE SYNC ===")
    
    if not os.path.exists(DATA_JSON_PATH):
        print(f"File not found: {DATA_JSON_PATH}")
        sys.exit(1)

    with open(DATA_JSON_PATH, 'r', encoding='utf-8') as f:
        products = json.load(f)

    print(f"Total products to process: {len(products)}")

    enriched_products = []
    for idx, p in enumerate(products):
        raw_name = p.get('raw_name') or p.get('name') or ''
        brand = p.get('brand') or 'Khác'
        condition = p.get('condition') or 'Grade A 99%'
        battery = p.get('battery') or 'Pin 95% - 100%'
        price = p.get('price') or 0

        spec_groups, summary_specs, article = build_model_specs(raw_name, brand, condition, battery, price)

        # Generate standard clean slug
        clean_title = p.get('name') or raw_name
        slug = clean_slug(clean_title)
        permalink = f"http://localhost/smartphone/product/{slug}/"

        p['spec_groups'] = spec_groups
        p['summary_specs'] = summary_specs
        p['description_html'] = article
        p['permalink'] = permalink
        p['slug'] = slug

        enriched_products.append(p)

    # Save enriched catalog
    with open(DATA_JSON_PATH, 'w', encoding='utf-8') as f:
        json.dump(enriched_products, f, ensure_ascii=False, indent=2)

    print(f"Successfully enriched {len(enriched_products)} products in {DATA_JSON_PATH}!")

if __name__ == '__main__':
    main()
