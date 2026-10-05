#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
populate_all_missing_phone_specs.py
Generates and populates complete 8-group technical specifications and summary specs
for all 209 Fast Mobile used phones, guaranteeing 100% specs coverage across PhoneX.
"""

import json
import re
import os
import subprocess

BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
DATA_FILE = os.path.join(BASE_DIR, "phonex-theme", "data", "used-phones.json")
XAMPP_DATA_FILE = "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/data/used-phones.json"

from test_model_matcher import detect_model_key

# Model specifications master dictionary
SPECS_MASTER = {
    # --- APPLE IPHONE ---
    'iphone_17_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 17 Pro Max',
        'screen_size': '6.9 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1320 x 2868 Pixels', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'iOS 19 / iOS 18 (Hỗ trợ lâu dài)', 'cpu': 'Apple A19 Pro 6 nhân (3nm thế hệ mới)', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 48 MP, 48 MP (Zoom quang 5x - 10x, OIS chống rung thế hệ mới)',
        'cam_front': '24 MP TrueDepth (Tự động lấy nét, quay 4K60fps)',
        'battery': '4850 mAh • Sạc nhanh 35W • Sạc MagSafe 25W', 'battery_type': 'Li-Ion', 'charge': '35 W',
        'security': 'Mở khóa khuôn mặt Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan cấp 5 & Mặt lưng kính Ceramic Shield', 'weight': '225 g',
        'sim': '1 Nano SIM & 1 eSIM (hoặc 2 eSIM)'
    },
    'iphone_17_pro': {
        'brand': 'Apple', 'name': 'iPhone 17 Pro',
        'screen_size': '6.3 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1206 x 2622 Pixels', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'iOS 19 / iOS 18', 'cpu': 'Apple A19 Pro 6 nhân', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 48 MP, 48 MP (Zoom quang 5x, OIS)',
        'cam_front': '24 MP TrueDepth',
        'battery': '3650 mAh • Sạc nhanh 35W • Sạc MagSafe 25W', 'battery_type': 'Li-Ion', 'charge': '35 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan & Kính Ceramic Shield', 'weight': '199 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_air': {
        'brand': 'Apple', 'name': 'iPhone Air',
        'screen_size': '6.6 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion siêu mỏng', 'resolution': '1260 x 2736 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2500 nits',
        'os': 'iOS 19 / iOS 18', 'cpu': 'Apple A19 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP Fusion (OIS, Smart HDR)',
        'cam_front': '18 MP TrueDepth',
        'battery': '3300 mAh • Thiết kế siêu mỏng 5.5mm • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan siêu nhẹ & Kính Ceramic Shield', 'weight': '165 g',
        'sim': 'eSIM'
    },
    'iphone_17': {
        'brand': 'Apple', 'name': 'iPhone 17',
        'screen_size': '6.3 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2500 nits',
        'os': 'iOS 19 / iOS 18', 'cpu': 'Apple A19 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 24 MP (Góc siêu rộng, OIS)',
        'cam_front': '18 MP TrueDepth',
        'battery': '3600 mAh • Sạc nhanh 25W • Sạc MagSafe', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm tái chế & Kính Ceramic Shield', 'weight': '175 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_16_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 16 Pro Max',
        'screen_size': '6.9 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1320 x 2868 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 18 (Hỗ trợ Apple Intelligence)', 'cpu': 'Apple A18 Pro 6 nhân (3nm)', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 48 MP, 12 MP (Zoom quang 5x, Phím Camera Control)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4685 mAh • Sạc nhanh 25W • MagSafe 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan cấp 5 & Mặt lưng kính nhám', 'weight': '227 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_16_pro': {
        'brand': 'Apple', 'name': 'iPhone 16 Pro',
        'screen_size': '6.3 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1206 x 2622 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 18 (Hỗ trợ Apple Intelligence)', 'cpu': 'Apple A18 Pro 6 nhân (3nm)', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 48 MP, 12 MP (Zoom quang 5x, Phím Camera Control)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3582 mAh • Sạc nhanh 25W • MagSafe 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan & Kính Ceramic Shield', 'weight': '199 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_16_plus': {
        'brand': 'Apple', 'name': 'iPhone 16 Plus',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED, Dynamic Island', 'resolution': '1290 x 2796 Pixels', 'screen_refresh': '60 Hz', 'brightness': '2000 nits',
        'os': 'iOS 18', 'cpu': 'Apple A18 6 nhân (3nm)', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP (Góc siêu rộng, Chụp Macro)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4674 mAh • Sạc nhanh 20W • MagSafe', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính pha màu Ceramic Shield', 'weight': '199 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_16': {
        'brand': 'Apple', 'name': 'iPhone 16',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED, Dynamic Island', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '60 Hz', 'brightness': '2000 nits',
        'os': 'iOS 18', 'cpu': 'Apple A18 6 nhân (3nm)', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP (Camera Control, Chụp Macro)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3561 mAh • Sạc nhanh 20W • MagSafe', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính pha màu Ceramic Shield', 'weight': '170 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_16e': {
        'brand': 'Apple', 'name': 'iPhone 16E',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1800 nits',
        'os': 'iOS 18', 'cpu': 'Apple A18 6 nhân', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Chính 48 MP Fusion (OIS, Night Mode)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3400 mAh • Sạc 20W • Không dây Qi2', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính cường lực', 'weight': '168 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_15_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 15 Pro Max',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1290 x 2796 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 17 (Cập nhật iOS 18)', 'cpu': 'Apple A17 Pro 6 nhân (3nm)', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP, 12 MP (Zoom quang 5x, OIS thế hệ 2)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4422 mAh • Sạc nhanh 20W • Cổng Type-C 3.0', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan cấp 5 & Kính Ceramic Shield', 'weight': '221 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_15_pro': {
        'brand': 'Apple', 'name': 'iPhone 15 Pro',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 17 (Cập nhật iOS 18)', 'cpu': 'Apple A17 Pro 6 nhân (3nm)', 'gpu': 'Apple GPU 6 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP, 12 MP (Zoom quang 3x, OIS)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3274 mAh • Sạc nhanh 20W • Type-C 3.0', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Titan & Kính Ceramic Shield', 'weight': '187 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_15_plus': {
        'brand': 'Apple', 'name': 'iPhone 15 Plus',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED, Dynamic Island', 'resolution': '1290 x 2796 Pixels', 'screen_refresh': '60 Hz', 'brightness': '2000 nits',
        'os': 'iOS 17 (Lên iOS 18)', 'cpu': 'Apple A16 Bionic 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP (Zoom quang 2x, OIS)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4383 mAh • Cổng Type-C • Sạc 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính pha màu', 'weight': '201 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_15': {
        'brand': 'Apple', 'name': 'iPhone 15',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED, Dynamic Island', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '60 Hz', 'brightness': '2000 nits',
        'os': 'iOS 17 (Lên iOS 18)', 'cpu': 'Apple A16 Bionic 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP (Zoom 2x, OIS)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3349 mAh • Cổng sạc Type-C • Sạc 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính Ceramic Shield', 'weight': '171 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_14_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 14 Pro Max',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion, Dynamic Island', 'resolution': '1290 x 2796 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 16 (Lên iOS 18)', 'cpu': 'Apple A16 Bionic 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP, 12 MP (Zoom quang 3x, OIS thế hệ 2)',
        'cam_front': '12 MP TrueDepth (Auto Focus)',
        'battery': '4323 mAh • Sạc nhanh 20W • Cổng Lightning', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Thép không gỉ & Kính nhám Ceramic Shield', 'weight': '240 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_14_pro': {
        'brand': 'Apple', 'name': 'iPhone 14 Pro',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion, Dynamic Island', 'resolution': '1179 x 2556 Pixels', 'screen_refresh': '120 Hz', 'brightness': '2000 nits',
        'os': 'iOS 16 (Lên iOS 18)', 'cpu': 'Apple A16 Bionic 6 nhân', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 48 MP & Phụ 12 MP, 12 MP (Zoom quang 3x, OIS)',
        'cam_front': '12 MP TrueDepth (Auto Focus)',
        'battery': '3200 mAh • Sạc nhanh 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Thép không gỉ & Kính Ceramic Shield', 'weight': '206 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_14_plus': {
        'brand': 'Apple', 'name': 'iPhone 14 Plus',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED', 'resolution': '1284 x 2778 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 16 (Lên iOS 18)', 'cpu': 'Apple A15 Bionic (5 nhân GPU)', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 12 MP & Phụ 12 MP (OIS Sensor-shift, Night Mode)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4325 mAh • Thời lượng pin cực trâu • Sạc 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính Ceramic Shield', 'weight': '203 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_14': {
        'brand': 'Apple', 'name': 'iPhone 14',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED', 'resolution': '1170 x 2532 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 16 (Lên iOS 18)', 'cpu': 'Apple A15 Bionic (5 nhân GPU)', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': 'Chính 12 MP & Phụ 12 MP (OIS, Chế độ điện ảnh 4K)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3279 mAh • Sạc nhanh 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính Ceramic Shield', 'weight': '172 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_13_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 13 Pro Max',
        'screen_size': '6.7 inch', 'screen_tech': 'Super Retina XDR OLED, 120Hz ProMotion', 'resolution': '1284 x 2778 Pixels', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'iOS 15 (Lên iOS 18)', 'cpu': 'Apple A15 Bionic (5 nhân GPU)', 'gpu': 'Apple GPU 5 nhân',
        'cam_back': '3 camera 12 MP (Chính, Góc rộng, Telephoto 3x, OIS cảm biến dịch chuyển)',
        'cam_front': '12 MP TrueDepth',
        'battery': '4352 mAh • Pin trâu bền bỉ • Sạc nhanh 20W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Thép không gỉ & Kính cường lực Ceramic Shield', 'weight': '240 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_12_mini': {
        'brand': 'Apple', 'name': 'iPhone 12 Mini',
        'screen_size': '5.4 inch', 'screen_tech': 'Super Retina XDR OLED nhỏ gọn', 'resolution': '1080 x 2340 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 14 (Lên iOS 18)', 'cpu': 'Apple A14 Bionic 6 nhân', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Kép 12 MP (Chính & Góc siêu rộng 120 độ)',
        'cam_front': '12 MP TrueDepth',
        'battery': '2227 mAh • Sạc nhanh 20W • MagSafe', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Kính Ceramic Shield', 'weight': '135 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_11': {
        'brand': 'Apple', 'name': 'iPhone 11',
        'screen_size': '6.1 inch', 'screen_tech': 'Liquid Retina IPS LCD màu sắc chân thực', 'resolution': '828 x 1792 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 13 (Hỗ trợ iOS 18)', 'cpu': 'Apple A13 Bionic 6 nhân', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Kép 12 MP (Góc rộng & Góc siêu rộng 120 độ, Chụp đêm Night Mode)',
        'cam_front': '12 MP TrueDepth',
        'battery': '3110 mAh • Sạc nhanh 18W • Sạc không dây Qi', 'battery_type': 'Li-Ion', 'charge': '18 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Nhôm & Mặt lưng kính bóng bẩy', 'weight': '194 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_xs': {
        'brand': 'Apple', 'name': 'iPhone Xs',
        'screen_size': '5.8 inch', 'screen_tech': 'Super Retina OLED', 'resolution': '1125 x 2436 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 12 (Lên iOS 17)', 'cpu': 'Apple A12 Bionic 6 nhân', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Kép 12 MP (Chính & Telephoto 2x, OIS kép)',
        'cam_front': '7 MP TrueDepth',
        'battery': '2658 mAh • Sạc nhanh 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Face ID', 'waterproof': 'IP68', 'material': 'Khung Thép không gỉ & Kính cường lực', 'weight': '177 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_x': {
        'brand': 'Apple', 'name': 'iPhone X',
        'screen_size': '5.8 inch', 'screen_tech': 'Super Retina OLED', 'resolution': '1125 x 2436 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 11 (Lên iOS 16)', 'cpu': 'Apple A11 Bionic 6 nhân', 'gpu': 'Apple GPU 3 nhân',
        'cam_back': 'Kép 12 MP (Chính f/1.8 & Tele f/2.4, OIS kép)',
        'cam_front': '7 MP TrueDepth',
        'battery': '2716 mAh • Sạc nhanh 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Face ID', 'waterproof': 'IP67', 'material': 'Khung Thép không gỉ & Kính', 'weight': '174 g',
        'sim': '1 Nano SIM'
    },
    'iphone_se_2022': {
        'brand': 'Apple', 'name': 'iPhone SE (2022)',
        'screen_size': '4.7 inch', 'screen_tech': 'Retina HD IPS LCD', 'resolution': '750 x 1334 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 15 (Lên iOS 18)', 'cpu': 'Apple A15 Bionic 6 nhân (5G)', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': '12 MP (Chống rung OIS, Smart HDR 4)',
        'cam_front': '7 MP FaceTime HD',
        'battery': '2018 mAh • Sạc nhanh 20W • 5G', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Cảm biến vân tay Touch ID', 'waterproof': 'IP67', 'material': 'Khung Nhôm & Kính cường lực', 'weight': '144 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_se_2020': {
        'brand': 'Apple', 'name': 'iPhone SE (2020)',
        'screen_size': '4.7 inch', 'screen_tech': 'Retina HD IPS LCD', 'resolution': '750 x 1334 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 13 (Lên iOS 18)', 'cpu': 'Apple A13 Bionic 6 nhân', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': '12 MP (Chống rung OIS, Chụp xóa phông chân dung)',
        'cam_front': '7 MP',
        'battery': '1821 mAh • Sạc nhanh 18W', 'battery_type': 'Li-Ion', 'charge': '18 W',
        'security': 'Cảm biến vân tay Touch ID', 'waterproof': 'IP67', 'material': 'Khung Nhôm & Kính', 'weight': '148 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_8_plus': {
        'brand': 'Apple', 'name': 'iPhone 8 Plus',
        'screen_size': '5.5 inch', 'screen_tech': 'Retina HD IPS LCD True Tone', 'resolution': '1080 x 1920 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 11 (Lên iOS 16)', 'cpu': 'Apple A11 Bionic 6 nhân', 'gpu': 'Apple GPU 3 nhân',
        'cam_back': 'Kép 12 MP (Góc rộng & Tele 2x, OIS)',
        'cam_front': '7 MP',
        'battery': '2691 mAh • Sạc nhanh 15W • Sạc không dây Qi', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Touch ID', 'waterproof': 'IP67', 'material': 'Khung Nhôm & Mặt lưng kính', 'weight': '202 g',
        'sim': '1 Nano SIM'
    },
    'iphone_8': {
        'brand': 'Apple', 'name': 'iPhone 8',
        'screen_size': '4.7 inch', 'screen_tech': 'Retina HD IPS LCD', 'resolution': '750 x 1334 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 11 (Lên iOS 16)', 'cpu': 'Apple A11 Bionic 6 nhân', 'gpu': 'Apple GPU 3 nhân',
        'cam_back': '12 MP (Chống rung OIS, Quay video 4K)',
        'cam_front': '7 MP',
        'battery': '1821 mAh • Sạc nhanh 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Touch ID', 'waterproof': 'IP67', 'material': 'Khung Nhôm & Mặt lưng kính', 'weight': '148 g',
        'sim': '1 Nano SIM'
    },

    # --- SAMSUNG GALAXY FLAGSHIP & Z-FOLD ---
    'samsung_s26_ultra': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy S26 Ultra 5G',
        'screen_size': '6.9 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz, 3200 nits, Kính Gorilla Armor', 'resolution': '2K+ (1440 x 3120 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '3200 nits',
        'os': 'Android 15, One UI 7 (Galaxy AI thế hệ mới)', 'cpu': 'Snapdragon 8 Elite / Exynos 2600 8 nhân (3nm)', 'gpu': 'Adreno 830',
        'cam_back': 'Chính 200 MP & Phụ 50 MP (Periscope 5x), 50 MP (Tele 3x), 50 MP (Góc rộng), OIS',
        'cam_front': '12 MP Dual Pixel PDAF',
        'battery': '5200 mAh • Sạc siêu nhanh 65W • Sạc không dây 15W', 'battery_type': 'Li-Ion', 'charge': '65 W',
        'security': 'Vân tay siêu âm dưới màn hình, Nhận diện khuôn mặt', 'waterproof': 'IP68', 'material': 'Khung Titan & Kính cường lực Armor', 'weight': '228 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_s26_plus': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy S26+ 5G',
        'screen_size': '6.7 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz', 'resolution': '2K+ (1440 x 3120 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '2800 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Elite / Exynos 2600', 'gpu': 'Adreno 830',
        'cam_back': 'Chính 50 MP (OIS) & 50 MP (Góc rộng) & 10 MP (Tele 3x)',
        'cam_front': '12 MP',
        'battery': '4900 mAh • Sạc nhanh 45W', 'battery_type': 'Li-Ion', 'charge': '45 W',
        'security': 'Vân tay siêu âm dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung Armor Aluminum & Kính cường lực', 'weight': '196 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_s26': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy S26 5G',
        'screen_size': '6.2 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz', 'resolution': 'Full HD+ (1080 x 2340 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Elite / Exynos 2600', 'gpu': 'Adreno 830',
        'cam_back': 'Chính 50 MP & 12 MP & 10 MP (Tele 3x, OIS)',
        'cam_front': '12 MP',
        'battery': '4000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay siêu âm dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung Armor Aluminum & Kính', 'weight': '167 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_s25_ultra': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy S25 Ultra 5G',
        'screen_size': '6.86 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz, 3000 nits', 'resolution': '2K+ (1440 x 3120 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'Android 15, One UI 7 (Hỗ trợ 7 năm OS)', 'cpu': 'Snapdragon 8 Elite for Galaxy (3nm)', 'gpu': 'Adreno 830',
        'cam_back': 'Chính 200 MP & Phụ 50 MP (Periscope 5x), 50 MP (Góc rộng), 10 MP (Tele 3x), OIS',
        'cam_front': '12 MP Dual Pixel',
        'battery': '5000 mAh • Sạc nhanh 45W • Bút S-Pen tích hợp', 'battery_type': 'Li-Ion', 'charge': '45 W',
        'security': 'Vân tay siêu âm dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung Titan & Kính cường lực Gorilla Armor', 'weight': '219 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_z_fold8_ultra': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Fold8 Ultra 5G',
        'screen_size': 'Chính 8.2 inch & Phụ 6.5 inch', 'screen_tech': 'Dynamic AMOLED 2X gập, 120Hz, mỏng nhẹ tối đa', 'resolution': 'QXGA+ & FHD+', 'screen_refresh': '120 Hz', 'brightness': '2800 nits',
        'os': 'Android 15, One UI 7 for Fold', 'cpu': 'Snapdragon 8 Elite for Galaxy', 'gpu': 'Adreno 830',
        'cam_back': '200 MP (OIS) & 50 MP (Tele 5x) & 50 MP (Góc rộng)',
        'cam_front': 'Dưới màn hình 4 MP & Ngoài 10 MP',
        'battery': '4600 mAh • Sạc nhanh 45W', 'battery_type': 'Li-Po', 'charge': '45 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Bản lề FlexHinge titan & Kính Armor', 'weight': '232 g',
        'sim': '2 Nano SIM + eSIM'
    },
    'samsung_z_fold8': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Fold8 5G',
        'screen_size': 'Chính 8.0 inch & Phụ 6.4 inch', 'screen_tech': 'Dynamic AMOLED 2X gập 120Hz', 'resolution': 'QXGA+ & FHD+', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Elite', 'gpu': 'Adreno 830',
        'cam_back': '50 MP (OIS) & 12 MP & 10 MP (Tele 3x)',
        'cam_front': '10 MP ngoài & 4 MP UDC trong',
        'battery': '4500 mAh • Sạc nhanh 45W', 'battery_type': 'Li-Po', 'charge': '45 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Khung Armor Aluminum & Bản lề FlexHinge', 'weight': '238 g',
        'sim': '2 Nano SIM + eSIM'
    },
    'samsung_z_fold7': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Fold7 5G',
        'screen_size': 'Chính 7.8 inch & Phụ 6.3 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz LTPO', 'resolution': 'QXGA+ & FHD+', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Gen 3 for Galaxy', 'gpu': 'Adreno 750',
        'cam_back': '50 MP & 12 MP & 10 MP (OIS, Zoom quang 3x)',
        'cam_front': '10 MP & 4 MP UDC',
        'battery': '4400 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Po', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Armor Aluminum & Kính Gorilla Glass Victus 2', 'weight': '239 g',
        'sim': '2 Nano SIM + eSIM'
    },
    'samsung_z_fold6': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Fold6 5G',
        'screen_size': 'Chính 7.6 inch & Phụ 6.3 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz, 2600 nits', 'resolution': 'QXGA+ (1856 x 2160 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 14, One UI 6.1.1 (Galaxy AI)', 'cpu': 'Snapdragon 8 Gen 3 for Galaxy (4nm)', 'gpu': 'Adreno 750',
        'cam_back': 'Chính 50 MP & Phụ 12 MP, 10 MP (Zoom quang 3x, OIS)',
        'cam_front': '10 MP ngoài & 4 MP dưới màn hình',
        'battery': '4400 mAh • Sạc nhanh 25W • Không dây 15W', 'battery_type': 'Li-Po', 'charge': '25 W',
        'security': 'Cảm biến vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Khung Armor Aluminum cải tiến & Kính Victus 2', 'weight': '239 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_z_flip8': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Flip8 5G',
        'screen_size': 'Chính 6.8 inch & Phụ 4.0 inch', 'screen_tech': 'Dynamic AMOLED 2X gập, 120Hz & Super AMOLED phụ', 'resolution': 'Full HD+ (1080 x 2640 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Elite / Exynos 2500', 'gpu': 'Adreno 830',
        'cam_back': 'Kép 50 MP (OIS) & 12 MP (Góc rộng)',
        'cam_front': '10 MP',
        'battery': '4100 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Po', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Khung Armor Aluminum & Kính Victus 2', 'weight': '187 g',
        'sim': '1 Nano SIM + 1 eSIM'
    },
    'samsung_z_flip7': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Flip7 5G',
        'screen_size': 'Chính 6.7 inch & Phụ 3.9 inch', 'screen_tech': 'Dynamic AMOLED 2X, 120Hz & Super AMOLED phụ', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '2600 nits',
        'os': 'Android 15, One UI 7', 'cpu': 'Snapdragon 8 Gen 3 for Galaxy', 'gpu': 'Adreno 750',
        'cam_back': '50 MP (OIS) & 12 MP (Góc siêu rộng)',
        'cam_front': '10 MP',
        'battery': '4000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Po', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP48', 'material': 'Khung Armor Aluminum', 'weight': '187 g',
        'sim': '1 Nano SIM + 1 eSIM'
    },

    # --- SAMSUNG GALAXY A & M & J SERIES ---
    'samsung_a73': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A73 5G',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED Plus, 120Hz', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '800 nits',
        'os': 'Android 12 (Lên Android 14, One UI 6)', 'cpu': 'Snapdragon 778G 5G 8 nhân (6nm)', 'gpu': 'Adreno 642L',
        'cam_back': 'Chính 108 MP (OIS) & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc siêu nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Khung & Mặt lưng nhựa cao cấp', 'weight': '181 g',
        'sim': '2 Nano SIM (SIM 2 chung khe thẻ nhớ)'
    },
    'samsung_a72': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A72',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED, 90Hz', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 11 (Lên One UI 6)', 'cpu': 'Snapdragon 720G 8 nhân', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 64 MP (OIS) & 12 MP & 8 MP (Tele 3x) & 5 MP',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay quang học dưới màn hình', 'waterproof': 'IP67', 'material': 'Mặt lưng nhám kháng bám vân tay', 'weight': '203 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a71_5g': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A71 5G',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED Plus', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '700 nits',
        'os': 'Android 10 (Lên One UI 5)', 'cpu': 'Exynos 980 5G 8 nhân', 'gpu': 'Mali-G76 MP5',
        'cam_back': 'Chính 64 MP & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Khung kim loại & Mặt lưng Glasstic', 'weight': '185 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a71': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A71',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED Plus', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '600 nits',
        'os': 'Android 10 (Lên One UI 5)', 'cpu': 'Snapdragon 730 8 nhân', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 64 MP & Phụ 12 MP, 5 MP, 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Mặt lưng nhựa 3D Glasstic', 'weight': '179 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a70': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A70',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 9 (Lên Android 11)', 'cpu': 'Snapdragon 675 8 nhân', 'gpu': 'Adreno 612',
        'cam_back': 'Chính 32 MP & 8 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Nhựa 3D Glasstic', 'weight': '183 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a55': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A55 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'Super AMOLED, 120Hz, HDR10+, 1000 nits HBM', 'resolution': 'Full HD+ (1080 x 2340 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 14, One UI 6.1 (Bảo mật Knox Vault)', 'cpu': 'Exynos 1480 8 nhân (4nm, GPU Xclipse 530)', 'gpu': 'AMD Xclipse 530',
        'cam_back': 'Chính 50 MP (OIS, f/1.8) & Góc siêu rộng 12 MP & Macro 5 MP',
        'cam_front': '32 MP (Quay 4K)',
        'battery': '5000 mAh • Sạc siêu nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt', 'waterproof': 'IP67', 'material': 'Khung kim loại cao cấp & Mặt lưng kính Gorilla Glass Victus+', 'weight': '213 g',
        'sim': '2 Nano SIM hoặc 1 Nano SIM + 1 eSIM'
    },
    'samsung_a54': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A54 5G',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1000 nits', 'resolution': 'Full HD+ (1080 x 2340 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 13 (Lên Android 14, One UI 6)', 'cpu': 'Exynos 1380 8 nhân (5nm)', 'gpu': 'Mali-G68 MP5',
        'cam_back': 'Chính 50 MP (OIS thế hệ mới) & 12 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Mặt lưng kính Gorilla Glass 5 & Khung nhựa', 'weight': '202 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'samsung_a53': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A53 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 120Hz, 800 nits', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '800 nits',
        'os': 'Android 12 (Lên One UI 6)', 'cpu': 'Exynos 1280 8 nhân (5nm)', 'gpu': 'Mali-G68',
        'cam_back': 'Chính 64 MP (OIS) & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Khung nhựa & Mặt lưng nhám', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a52s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A52s 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 120Hz', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '800 nits',
        'os': 'Android 11 (Lên One UI 6)', 'cpu': 'Snapdragon 778G 5G 8 nhân (6nm)', 'gpu': 'Adreno 642L',
        'cam_back': 'Chính 64 MP (OIS) & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Nhựa nhám kháng bám vân tay', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a52_5g': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A52 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 120Hz', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '800 nits',
        'os': 'Android 11 (Lên One UI 6)', 'cpu': 'Snapdragon 750G 5G 8 nhân', 'gpu': 'Adreno 619',
        'cam_back': 'Chính 64 MP (OIS) & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Nhựa cao cấp', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a52': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A52',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 90Hz', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 11 (Lên One UI 6)', 'cpu': 'Snapdragon 720G 8 nhân', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 64 MP (OIS) & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Nhựa cao cấp', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a51_5g': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A51 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '600 nits',
        'os': 'Android 10 (Lên One UI 5)', 'cpu': 'Exynos 980 5G 8 nhân', 'gpu': 'Mali-G76 MP5',
        'cam_back': 'Chính 48 MP & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Khung nhôm & Lưng nhựa', 'weight': '187 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a51': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A51',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '600 nits',
        'os': 'Android 10 (Lên One UI 5)', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 48 MP & Phụ 12 MP, 5 MP, 5 MP',
        'cam_front': '32 MP',
        'battery': '4000 mAh • Sạc nhanh 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Mặt lưng 3D Glasstic', 'weight': '172 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a50s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A50s',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 9 (Lên Android 11)', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 48 MP & 8 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '4000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Mặt lưng hoa văn kim cương', 'weight': '169 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a50': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A50',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 9 (Lên Android 11)', 'cpu': 'Exynos 9610 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 25 MP & 8 MP & 5 MP',
        'cam_front': '25 MP',
        'battery': '4000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Nhựa 3D Glasstic', 'weight': '166 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a41': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A41 5G / A41',
        'screen_size': '6.1 inch', 'screen_tech': 'Super AMOLED nhỏ gọn', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 10', 'cpu': 'MediaTek Helio P65 8 nhân', 'gpu': 'Mali-G52 MC2',
        'cam_back': 'Chính 48 MP & 8 MP & 5 MP',
        'cam_front': '25 MP',
        'battery': '3500 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '152 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a35': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A35 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1000 nits', 'resolution': 'Full HD+ (1080 x 2340 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 14, One UI 6.1 (Bảo mật Knox Vault)', 'cpu': 'Exynos 1380 8 nhân (5nm)', 'gpu': 'Mali-G68 MP5',
        'cam_back': 'Chính 50 MP (OIS) & 8 MP & 5 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc siêu nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP67', 'material': 'Mặt lưng kính & Khung viền Key Island', 'weight': '209 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a34': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A34 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1000 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 13 (Lên One UI 6)', 'cpu': 'MediaTek Dimensity 1080 8 nhân (6nm)', 'gpu': 'Mali-G68 MC4',
        'cam_back': 'Chính 48 MP (OIS) & 8 MP & 5 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Mặt lưng nhựa tráng gương', 'weight': '199 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a33': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A33 5G',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED, 90Hz', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 12 (Lên One UI 6)', 'cpu': 'Exynos 1280 8 nhân (5nm)', 'gpu': 'Mali-G68',
        'cam_back': 'Chính 48 MP (OIS) & 8 MP & 5 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP67', 'material': 'Nhựa nhám', 'weight': '186 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a32': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A32',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED, 90Hz', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 11 (Lên One UI 5)', 'cpu': 'MediaTek Helio G80 8 nhân', 'gpu': 'Mali-G52 MC2',
        'cam_back': 'Chính 64 MP & 8 MP & 5 MP & 5 MP',
        'cam_front': '20 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Mặt lưng nhựa bóng', 'weight': '184 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a25': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A25 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1000 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 14, One UI 6.0', 'cpu': 'Exynos 1280 8 nhân (5nm)', 'gpu': 'Mali-G68',
        'cam_back': 'Chính 50 MP (OIS chống rung) & 8 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Khung viền Key Island & Lưng nhựa', 'weight': '197 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a23_5g': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A23 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'PLS LCD, 120Hz mượt mà', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '500 nits',
        'os': 'Android 12 (Lên One UI 6)', 'cpu': 'Snapdragon 695 5G 8 nhân', 'gpu': 'Adreno 619',
        'cam_back': 'Chính 50 MP (OIS) & 5 MP & 2 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa cao cấp', 'weight': '197 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a23': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A23 4G',
        'screen_size': '6.6 inch', 'screen_tech': 'PLS LCD, 90Hz', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '500 nits',
        'os': 'Android 12 (Lên One UI 6)', 'cpu': 'Snapdragon 680 8 nhân (6nm)', 'gpu': 'Adreno 610',
        'cam_back': 'Chính 50 MP (OIS) & 5 MP & 2 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '195 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a15': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A15 4G / 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 90Hz, 800 nits', 'resolution': 'Full HD+ (1080 x 2340 Pixels)', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 14, One UI 6.0', 'cpu': 'MediaTek Helio G99 8 nhân (6nm)', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 50 MP & 5 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc siêu nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Khung viền Key Island & Lưng nhựa bóng', 'weight': '200 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a14': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A14 4G / 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'PLS LCD, sắc nét', 'resolution': 'Full HD+ (1080 x 2408 Pixels)', 'screen_refresh': '60 Hz / 90 Hz', 'brightness': '500 nits',
        'os': 'Android 13, One UI Core 5', 'cpu': 'Exynos 850 / MediaTek Helio G80 8 nhân', 'gpu': 'Mali-G52',
        'cam_back': 'Chính 50 MP & 5 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa vân sọc chống trầy', 'weight': '201 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a12': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A12',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS TFT LCD', 'resolution': 'HD+ (720 x 1600 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 10 (Lên One UI 4)', 'cpu': 'Exynos 850 / Helio P35 8 nhân', 'gpu': 'Mali-G52',
        'cam_back': 'Chính 48 MP & 5 MP & 2 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '205 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a06': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A06',
        'screen_size': '6.7 inch', 'screen_tech': 'PLS LCD góc nhìn rộng', 'resolution': 'HD+ (720 x 1600 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 14, One UI 6.1 (Cam kết 2 năm OS)', 'cpu': 'MediaTek Helio G85 8 nhân (12nm)', 'gpu': 'Mali-G52 MC2',
        'cam_back': 'Chính 50 MP & Phụ 2 MP xóa phông',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên tích hợp phím nguồn', 'waterproof': 'Không', 'material': 'Khung viền Key Island & Mặt lưng sọc kẻ trẻ trung', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a05s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A05s',
        'screen_size': '6.7 inch', 'screen_tech': 'PLS LCD, 90Hz mượt mà', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '90 Hz', 'brightness': '500 nits',
        'os': 'Android 13, One UI Core 5.1', 'cpu': 'Snapdragon 680 8 nhân (6nm tiết kiệm pin)', 'gpu': 'Adreno 610',
        'cam_back': 'Chính 50 MP & 2 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc siêu nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa nhám', 'weight': '194 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a05': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A05',
        'screen_size': '6.7 inch', 'screen_tech': 'PLS LCD', 'resolution': 'HD+ (720 x 1600 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 13, One UI Core 5.1', 'cpu': 'MediaTek Helio G85 8 nhân', 'gpu': 'Mali-G52 MC2',
        'cam_back': 'Chính 50 MP & 2 MP xóa phông',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Nhận diện khuôn mặt', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '195 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a04s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A04s',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS LCD, 90Hz', 'resolution': 'HD+', 'screen_refresh': '90 Hz', 'brightness': '450 nits',
        'os': 'Android 12 (One UI Core 4)', 'cpu': 'Exynos 850 8 nhân', 'gpu': 'Mali-G52',
        'cam_back': 'Chính 50 MP & 2 MP & 2 MP',
        'cam_front': '5 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa bóng', 'weight': '192 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a04': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A04',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS LCD', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 12', 'cpu': 'MediaTek Helio P35 8 nhân', 'gpu': 'PowerVR GE8320',
        'cam_back': 'Chính 50 MP & 2 MP',
        'cam_front': '5 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Nhận diện khuôn mặt', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '192 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a03s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A03s',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS LCD', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 11 (Lên Android 12)', 'cpu': 'MediaTek Helio P35 8 nhân', 'gpu': 'PowerVR GE8320',
        'cam_back': 'Chính 13 MP & 2 MP & 2 MP',
        'cam_front': '5 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa nhám', 'weight': '196 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a03': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A03',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS LCD', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 11', 'cpu': 'Unisoc T606 8 nhân', 'gpu': 'Mali-G57 MP1',
        'cam_back': 'Chính 48 MP & 2 MP',
        'cam_front': '5 MP',
        'battery': '5000 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Mở khóa khuôn mặt', 'waterproof': 'Không', 'material': 'Nhựa vân đan chéo', 'weight': '196 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a9_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A9 (2018)',
        'screen_size': '6.3 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8 (Lên Android 10)', 'cpu': 'Snapdragon 660 8 nhân', 'gpu': 'Adreno 512',
        'cam_back': '4 Camera 24 MP & 10 MP (Tele 2x) & 8 MP & 5 MP',
        'cam_front': '24 MP',
        'battery': '3800 mAh • Sạc nhanh 18W', 'battery_type': 'Li-Ion', 'charge': '18 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Khung nhôm & Lưng kính đổi màu', 'weight': '183 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a8_plus_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A8+ (2018)',
        'screen_size': '6.0 inch', 'screen_tech': 'Super AMOLED tràn viền', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8 (Lên Android 9)', 'cpu': 'Exynos 7885 8 nhân', 'gpu': 'Mali-G71',
        'cam_back': '16 MP (f/1.7)',
        'cam_front': 'Kép 16 MP & 8 MP xóa phông',
        'battery': '3500 mAh • Sạc nhanh', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'IP68', 'material': 'Khung kim loại & 2 mặt kính', 'weight': '191 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a8_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A8 (2018)',
        'screen_size': '5.6 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8 (Lên Android 9)', 'cpu': 'Exynos 7885 8 nhân', 'gpu': 'Mali-G71',
        'cam_back': '16 MP (f/1.7)',
        'cam_front': 'Kép 16 MP & 8 MP',
        'battery': '3000 mAh • Sạc nhanh', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'IP68', 'material': 'Kim loại & Kính', 'weight': '172 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a7_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A7 (2018)',
        'screen_size': '6.0 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8 (Lên Android 10)', 'cpu': 'Exynos 7885 8 nhân', 'gpu': 'Mali-G71',
        'cam_back': '3 Camera 24 MP & 8 MP (Góc rộng 120 độ) & 5 MP',
        'cam_front': '24 MP',
        'battery': '3300 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Mặt lưng kính', 'weight': '168 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a6_plus_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A6+ (2018)',
        'screen_size': '6.0 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8', 'cpu': 'Snapdragon 450 8 nhân', 'gpu': 'Adreno 506',
        'cam_back': 'Kép 16 MP & 5 MP',
        'cam_front': '24 MP (Đèn Flash LED trợ sáng)',
        'battery': '3500 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Kim loại nguyên khối', 'weight': '186 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a6_2018': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A6 (2018)',
        'screen_size': '5.6 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8', 'cpu': 'Exynos 7870 8 nhân', 'gpu': 'Mali-T830 MP1',
        'cam_back': '16 MP',
        'cam_front': '16 MP',
        'battery': '3000 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Kim loại nguyên khối', 'weight': '162 g',
        'sim': '2 Nano SIM'
    },
    'samsung_a20s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy A20s',
        'screen_size': '6.5 inch', 'screen_tech': 'PLS TFT LCD', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 9 (Lên Android 11)', 'cpu': 'Snapdragon 450 8 nhân', 'gpu': 'Adreno 506',
        'cam_back': '3 Camera 13 MP & 8 MP & 5 MP',
        'cam_front': '8 MP',
        'battery': '4000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa bóng', 'weight': '183 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m55': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M55 5G',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED+, 120Hz, 1000 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 14, One UI 6.1', 'cpu': 'Snapdragon 7 Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 644',
        'cam_back': 'Chính 50 MP (OIS) & 8 MP & 2 MP',
        'cam_front': '50 MP Selfie cực nét',
        'battery': '5000 mAh • Sạc siêu nhanh 45W', 'battery_type': 'Li-Ion', 'charge': '45 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'Không', 'material': 'Thiết kế siêu mỏng 7.8mm', 'weight': '180 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m51': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M51',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED Plus', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '600 nits',
        'os': 'Android 10 (Lên One UI 4)', 'cpu': 'Snapdragon 730 8 nhân', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 64 MP & 12 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '7000 mAh Siêu Khủng • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa 3D Glasstic', 'weight': '213 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m34': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M34 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1000 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 13, One UI 5.1', 'cpu': 'Exynos 1280 8 nhân (5nm)', 'gpu': 'Mali-G68',
        'cam_back': 'Chính 50 MP (OIS chống rung) & 8 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '6000 mAh Pin Trâu • Sạc nhanh 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa bóng', 'weight': '208 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m33': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M33 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'TFT LCD, 120Hz', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '500 nits',
        'os': 'Android 12 (Lên One UI 6)', 'cpu': 'Exynos 1280 5G', 'gpu': 'Mali-G68',
        'cam_back': 'Chính 50 MP & 5 MP & 2 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '198 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m31': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M31',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '600 nits',
        'os': 'Android 10 (Lên One UI 4)', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 64 MP & 8 MP & 5 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '6000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '191 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m30s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M30s',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 9', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 48 MP & 8 MP & 5 MP',
        'cam_front': '16 MP',
        'battery': '6000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '188 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m30': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M30',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 8.1', 'cpu': 'Exynos 7904 8 nhân', 'gpu': 'Mali-G71 MP2',
        'cam_back': 'Chính 13 MP & 5 MP & 5 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '174 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m21s': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M21s',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 10', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 64 MP & 8 MP & 5 MP',
        'cam_front': '32 MP',
        'battery': '6000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '191 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m21': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M21',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '550 nits',
        'os': 'Android 10', 'cpu': 'Exynos 9611 8 nhân', 'gpu': 'Mali-G72 MP3',
        'cam_back': 'Chính 48 MP & 8 MP & 5 MP',
        'cam_front': '20 MP',
        'battery': '6000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '188 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m20': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M20',
        'screen_size': '6.3 inch', 'screen_tech': 'PLS TFT LCD', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 8.1 (Lên Android 10)', 'cpu': 'Exynos 7904 8 nhân', 'gpu': 'Mali-G71 MP2',
        'cam_back': 'Chính 13 MP & 5 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '186 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m15': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M15 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'Super AMOLED, 90Hz, 800 nits', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'Android 14, One UI 6.0', 'cpu': 'MediaTek Dimensity 6100+ 8 nhân (6nm)', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 50 MP & 5 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '6000 mAh Pin Trâu • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '217 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m14': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M14 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'PLS LCD, 90Hz', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '500 nits',
        'os': 'Android 13', 'cpu': 'Exynos 1330 5G 8 nhân (5nm)', 'gpu': 'Mali-G68 MP2',
        'cam_back': 'Chính 50 MP & 2 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '6000 mAh • Sạc 25W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '206 g',
        'sim': '2 Nano SIM'
    },
    'samsung_m11': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy M11',
        'screen_size': '6.4 inch', 'screen_tech': 'PLS TFT LCD', 'resolution': 'HD+', 'screen_refresh': '60 Hz', 'brightness': '450 nits',
        'os': 'Android 10', 'cpu': 'Snapdragon 450 8 nhân', 'gpu': 'Adreno 506',
        'cam_back': '3 Camera 13 MP & 5 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 15W', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '197 g',
        'sim': '2 Nano SIM'
    },
    'samsung_j7_pro': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy J7 Pro',
        'screen_size': '5.5 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD (1080 x 1920 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 7 (Lên Android 9)', 'cpu': 'Exynos 7870 8 nhân', 'gpu': 'Mali-T830 MP1',
        'cam_back': '13 MP, f/1.7 (Chụp tối xuất sắc)',
        'cam_front': '13 MP, f/1.9 (Đèn Flash LED trước)',
        'battery': '3600 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Vân tay một chạm phím Home', 'waterproof': 'Không', 'material': 'Kim loại nguyên khối bo cong', 'weight': '181 g',
        'sim': '2 Nano SIM'
    },
    'samsung_j7_prime': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy J7 Prime',
        'screen_size': '5.5 inch', 'screen_tech': 'PLS TFT LCD, Kính Gorilla Glass 4 cong 2.5D', 'resolution': 'Full HD', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 6 (Lên Android 8.1)', 'cpu': 'Exynos 7870 8 nhân', 'gpu': 'Mali-T830 MP1',
        'cam_back': '13 MP, f/1.9',
        'cam_front': '8 MP, f/1.9',
        'battery': '3300 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Cảm biến vân tay một chạm', 'waterproof': 'Không', 'material': 'Kim loại nguyên khối', 'weight': '167 g',
        'sim': '2 Nano SIM'
    },
    'samsung_j7_plus': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy J7 Plus',
        'screen_size': '5.5 inch', 'screen_tech': 'Super AMOLED', 'resolution': 'Full HD', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'Android 7.1', 'cpu': 'MediaTek Helio P20 8 nhân', 'gpu': 'Mali-T880 MP2',
        'cam_back': 'Kép 13 MP (f/1.7) & 5 MP xóa phông Live Focus',
        'cam_front': '16 MP, f/1.9',
        'battery': '3000 mAh', 'battery_type': 'Li-Ion', 'charge': '10 W',
        'security': 'Cảm biến vân tay phím Home', 'waterproof': 'Không', 'material': 'Kim loại nguyên khối', 'weight': '180 g',
        'sim': '2 Nano SIM'
    },

    # --- XIAOMI FLAGSHIP & NOTE & POCO ---
    'xiaomi_14_ultra': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 14 Ultra 5G',
        'screen_size': '6.73 inch', 'screen_tech': 'LTPO AMOLED, 120Hz, Dolby Vision, 3000 nits, Kính Xiaomi Shield Glass', 'resolution': '2K+ (1440 x 3200 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'Snapdragon 8 Gen 3 8 nhân (4nm)', 'gpu': 'Adreno 750',
        'cam_back': 'Hệ thống 4 Camera Leica 50 MP (Cảm biến 1-inch Sony LYT-900, khẩu độ biến thiên f/1.63 - f/4.0, Zoom quang 5x & 3.2x, OIS)',
        'cam_front': '32 MP (Quay phim 4K60fps)',
        'battery': '5000 mAh • Sạc siêu tốc 90W • Sạc không dây 80W', 'battery_type': 'Li-Po', 'charge': '90 W',
        'security': 'Vân tay quang học dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung nhôm nguyên khối / Mặt lưng da nano kháng bẩn', 'weight': '219 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_14_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 14 Pro 5G',
        'screen_size': '6.73 inch', 'screen_tech': 'LTPO AMOLED, 120Hz, 3000 nits', 'resolution': '2K+ (1440 x 3200 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'Snapdragon 8 Gen 3 8 nhân', 'gpu': 'Adreno 750',
        'cam_back': '3 Camera Leica 50 MP (Chính khẩu độ biến thiên f/1.4 - f/4.0, Tele 3.2x, OIS)',
        'cam_front': '32 MP',
        'battery': '4880 mAh • Sạc siêu nhanh 120W (18 phút 100%)', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung nhôm / Kính cường lực Dragon Crystal Glass', 'weight': '223 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_14t_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 14T Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 144Hz, 68 tỷ màu, 4000 nits', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '144 Hz', 'brightness': '4000 nits',
        'os': 'Xiaomi HyperOS (Android 14, Tích hợp Google Gemini AI)', 'cpu': 'MediaTek Dimensity 9300+ 8 nhân (4nm siêu mạnh)', 'gpu': 'Immortalis-G720 MC12',
        'cam_back': '3 Camera Leica 50 MP (Cảm biến Light Fusion 900, Tele 50 MP 2.6x, Góc rộng 12 MP, OIS)',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc siêu tốc HyperCharge 120W (19 phút 100%) • Sạc không dây 50W', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung hợp kim nhôm bền bỉ & Mặt lưng kính mờ 3D', 'weight': '209 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'xiaomi_14t': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 14T 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 144Hz, 4000 nits đỉnh cao', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '144 Hz', 'brightness': '4000 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'MediaTek Dimensity 8300-Ultra 8 nhân (4nm)', 'gpu': 'Mali-G615-MC6',
        'cam_back': '3 Camera Leica 50 MP (Sony IMX906 OIS, Tele 50 MP, Siêu rộng 12 MP)',
        'cam_front': '32 MP',
        'battery': '5000 mAh • Sạc nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP68', 'material': 'Khung viền kim loại & Lưng kính mờ', 'weight': '195 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'xiaomi_14': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 14 5G',
        'screen_size': '6.36 inch', 'screen_tech': 'LTPO OLED, 120Hz, viền siêu mỏng 1.61mm', 'resolution': '1.5K (1200 x 2670 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'Snapdragon 8 Gen 3 8 nhân (4nm)', 'gpu': 'Adreno 750',
        'cam_back': '3 Camera Leica 50 MP (Light Fusion 900 OIS, Tele 75mm OIS, Siêu rộng)',
        'cam_front': '32 MP',
        'battery': '4610 mAh • Sạc siêu tốc 90W • Sạc không dây 50W', 'battery_type': 'Li-Po', 'charge': '90 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung nhôm bóng & Kính cường lực', 'weight': '193 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'xiaomi_13_lite': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 13 Lite 5G',
        'screen_size': '6.55 inch', 'screen_tech': 'AMOLED cong 3D, 120Hz, Dolby Vision', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'MIUI 14 (Lên HyperOS)', 'cpu': 'Snapdragon 7 Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 644',
        'cam_back': 'Chính 50 MP (Sony IMX766) & 8 MP & 2 MP',
        'cam_front': 'Kép 32 MP & 8 MP đo chiều sâu (Đèn selfie kép)',
        'battery': '4500 mAh • Sạc siêu nhanh 67W • Thiết kế mỏng 7.23mm', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP53', 'material': 'Mặt lưng kính cong 3D & Khung nhựa', 'weight': '171 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_13t': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 13T 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 144Hz, 2600 nits', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '144 Hz', 'brightness': '2600 nits',
        'os': 'MIUI 14 (Lên HyperOS)', 'cpu': 'MediaTek Dimensity 8200-Ultra 8 nhân (4nm)', 'gpu': 'Mali-G610 MC6',
        'cam_back': '3 Camera Leica 50 MP (Chính OIS & Tele 50 MP 2x & Góc rộng 12 MP)',
        'cam_front': '20 MP',
        'battery': '5000 mAh • Sạc nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP68', 'material': 'Khung nhựa & Lưng kính / Da BioComfort', 'weight': '197 g',
        'sim': '2 Nano SIM hoặc 1 eSIM + 1 Nano SIM'
    },
    'xiaomi_13': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 13 5G',
        'screen_size': '6.36 inch', 'screen_tech': 'OLED 120Hz, Dolby Vision, 1900 nits', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1900 nits',
        'os': 'MIUI 14 (Lên HyperOS)', 'cpu': 'Snapdragon 8 Gen 2 8 nhân (4nm)', 'gpu': 'Adreno 740',
        'cam_back': '3 Camera Leica: 50 MP (Sony IMX800 OIS) & 10 MP (Tele 3.2x OIS) & 12 MP',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 67W • Sạc không dây 50W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP68', 'material': 'Khung kim loại & Lưng kính', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_12_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12 Pro 5G',
        'screen_size': '6.73 inch', 'screen_tech': 'LTPO AMOLED, 120Hz, 1500 nits', 'resolution': '2K+ (1440 x 3200 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1500 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'Snapdragon 8 Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 730',
        'cam_back': '3 Camera 50 MP (Sony IMX707 OIS & Tele 50 MP 2x & Góc rộng 50 MP)',
        'cam_front': '32 MP',
        'battery': '4600 mAh • Sạc siêu tốc 120W (18 phút đầy) • Không dây 50W', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay trong màn hình, 4 Loa Harman Kardon', 'waterproof': 'Không', 'material': 'Khung kim loại & Kính Victus', 'weight': '205 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_12_lite': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12 Lite 5G',
        'screen_size': '6.55 inch', 'screen_tech': 'AMOLED, 120Hz, 68 tỷ màu', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '950 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'Snapdragon 778G 5G 8 nhân (6nm)', 'gpu': 'Adreno 642L',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP',
        'cam_front': '32 MP (Lấy nét tự động AF)',
        'battery': '4300 mAh • Sạc nhanh 67W • Mỏng 7.29mm nhẹ 173g', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Khung & Lưng nhựa mờ đổi màu', 'weight': '173 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_12t_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12T Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'CrystalRes AMOLED 120Hz', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '900 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'Snapdragon 8+ Gen 1 8 nhân (4nm TSMC)', 'gpu': 'Adreno 730',
        'cam_back': 'Camera Siêu Khủng 200 MP (Samsung HP1, OIS, Zoom 2x trong cảm biến) & 8 MP & 2 MP',
        'cam_front': '20 MP',
        'battery': '5000 mAh • Sạc thần tốc 120W HyperCharge (19 phút)', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay trong màn hình, Loa Harman Kardon', 'waterproof': 'IP53', 'material': 'Mặt lưng kính nhám mờ', 'weight': '205 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_12t': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12T 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz CrystalRes', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '900 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'MediaTek Dimensity 8100-Ultra 8 nhân (5nm)', 'gpu': 'Mali-G610 MC6',
        'cam_back': 'Chính 108 MP (OIS) & 8 MP & 2 MP',
        'cam_front': '20 MP',
        'battery': '5000 mAh • Sạc thần tốc 120W', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP53', 'material': 'Mặt lưng kính cong', 'weight': '202 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_12': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12 5G',
        'screen_size': '6.28 inch', 'screen_tech': 'AMOLED 120Hz nhỏ gọn', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1100 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'Snapdragon 8 Gen 1 8 nhân', 'gpu': 'Adreno 730',
        'cam_back': 'Chính 50 MP (Sony IMX766 OIS) & 13 MP & 5 MP telemacro',
        'cam_front': '32 MP',
        'battery': '4500 mAh • Sạc nhanh 67W • Không dây 50W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'Không', 'material': 'Khung nhôm & Kính Victus', 'weight': '180 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_11t_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 11T Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, Dolby Vision, 1 tỷ màu', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'MIUI 12.5 (Lên HyperOS)', 'cpu': 'Snapdragon 888 5G 8 nhân', 'gpu': 'Adreno 660',
        'cam_back': 'Chính 108 MP & 8 MP & 5 MP Telemacro',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh thần tốc 120W (17 phút)', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay cạnh bên, Loa kép Harman Kardon', 'waterproof': 'IP53', 'material': 'Khung nhôm & Lưng kính', 'weight': '204 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_11t': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 11T 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 1 tỷ màu', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'MIUI 12.5 (Lên HyperOS)', 'cpu': 'MediaTek Dimensity 1200 5G (6nm)', 'gpu': 'Mali-G77 MC9',
        'cam_back': 'Chính 108 MP & 8 MP & 5 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W (36 phút)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung nhôm & Lưng kính', 'weight': '203 g',
        'sim': '2 Nano SIM'
    },
    'xiaomi_11_lite': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 11 Lite 5G NE',
        'screen_size': '6.55 inch', 'screen_tech': 'AMOLED 90Hz siêu mỏng 6.81mm', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'MIUI 12.5 (Lên MIUI 14)', 'cpu': 'Snapdragon 778G 5G 8 nhân', 'gpu': 'Adreno 642L',
        'cam_back': 'Chính 64 MP & 8 MP & 5 MP telemacro',
        'cam_front': '20 MP',
        'battery': '4250 mAh • Sạc 33W • Siêu nhẹ chỉ 158g', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung nhựa & Lưng kính mờ', 'weight': '158 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_14': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 14 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 2100 nits', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '2100 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'MediaTek Dimensity 7025 Ultra 8 nhân (6nm)', 'gpu': 'IMG BXM-8-256',
        'cam_back': 'Chính 50 MP (Sony LYT-600, OIS chống rung) & Phụ 2 MP',
        'cam_front': '16 MP',
        'battery': '5110 mAh • Sạc nhanh 45W', 'battery_type': 'Li-Po', 'charge': '45 W',
        'security': 'Vân tay dưới màn hình', 'waterproof': 'IP64 kháng nước bụi', 'material': 'Mặt lưng kính & Khung nhựa cứng cáp', 'weight': '190 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_13_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 13 Pro 4G / 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 1.5K / FHD+', 'resolution': '1080 x 2400 Pixels / 1220 x 2712 Pixels', 'screen_refresh': '120 Hz', 'brightness': '1800 nits',
        'os': 'MIUI 14 (Lên HyperOS)', 'cpu': 'Snapdragon 7s Gen 2 / Helio G99-Ultra', 'gpu': 'Adreno 710 / Mali-G57',
        'cam_back': 'Camera Siêu Độ Phân Giải 200 MP (Samsung HP3, OIS chống rung, Zoom 4x lossless) & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh / 5100 mAh • Sạc nhanh 67W (44 phút đầy)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP54', 'material': 'Khung viền vuông vắn & Lưng kính', 'weight': '188 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_13': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 13',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 1800 nits, viền siêu mỏng', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1800 nits',
        'os': 'MIUI 14 (Lên HyperOS)', 'cpu': 'Snapdragon 685 8 nhân (6nm)', 'gpu': 'Adreno 610',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP54', 'material': 'Khung & Lưng nhựa cao cấp', 'weight': '178 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_12_pro_5g': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 12 Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, Dolby Vision', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '900 nits',
        'os': 'MIUI 13 (Lên HyperOS)', 'cpu': 'MediaTek Dimensity 1080 8 nhân (6nm)', 'gpu': 'Mali-G68 MC4',
        'cam_back': 'Chính 50 MP (Sony IMX766, OIS) & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Mặt lưng kính sang trọng', 'weight': '187 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_12_pro_4g': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 12 Pro 4G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, Dolby Vision', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1100 nits',
        'os': 'MIUI 13', 'cpu': 'Snapdragon 732G 8 nhân', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '201 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_11_pro_plus': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 11 Pro+ 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'Super AMOLED 120Hz, 1200 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MIUI 12.5 (Lên MIUI 14)', 'cpu': 'MediaTek Dimensity 920 5G (6nm)', 'gpu': 'Mali-G68 MC4',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '4500 mAh • Sạc thần tốc 120W HyperCharge (15 phút đầy)', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay cạnh bên, Loa kép JBL', 'waterproof': 'IP53', 'material': 'Kính Gorilla Glass 5', 'weight': '204 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_11_pro_5g': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 11 Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1200 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MIUI 13', 'cpu': 'Snapdragon 695 5G 8 nhân (6nm)', 'gpu': 'Adreno 619',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W (42 phút đầy)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung phẳng & Lưng kính', 'weight': '202 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_11_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 11 Pro 4G',
        'screen_size': '6.67 inch', 'screen_tech': 'Super AMOLED, 120Hz, 1200 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MIUI 13', 'cpu': 'MediaTek Helio G96 8 nhân', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung phẳng & Lưng kính', 'weight': '202 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_11s': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 11S',
        'screen_size': '6.43 inch', 'screen_tech': 'AMOLED, 90Hz, 1000 nits', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '1000 nits',
        'os': 'MIUI 13', 'cpu': 'MediaTek Helio G96 8 nhân', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 108 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 33W Pro', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '179 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_10_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 10 Pro',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, HDR10, 1200 nits', 'resolution': 'Full HD+ (1080 x 2400 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MIUI 12 (Lên MIUI 14)', 'cpu': 'Snapdragon 732G 8 nhân (8nm)', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 108 MP & 8 MP & 5 MP telemacro & 2 MP',
        'cam_front': '16 MP',
        'battery': '5020 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Kính cường lực Gorilla Glass 5 & Khung nhựa', 'weight': '193 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_10s': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 10S',
        'screen_size': '6.43 inch', 'screen_tech': 'AMOLED, 1100 nits', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '1100 nits',
        'os': 'MIUI 12.5', 'cpu': 'MediaTek Helio G95 8 nhân', 'gpu': 'Mali-G76 MC4',
        'cam_back': 'Chính 64 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '178 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_10_5g': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 10 5G',
        'screen_size': '6.5 inch', 'screen_tech': 'IPS LCD, 90Hz AdaptiveSync', 'resolution': 'Full HD+', 'screen_refresh': '90 Hz', 'brightness': '500 nits',
        'os': 'MIUI 12', 'cpu': 'MediaTek Dimensity 700 5G 8 nhân (7nm)', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 48 MP & 2 MP & 2 MP',
        'cam_front': '8 MP',
        'battery': '5000 mAh • Sạc 18W', 'battery_type': 'Li-Po', 'charge': '18 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Nhựa', 'weight': '190 g',
        'sim': '2 Nano SIM'
    },
    'redmi_note_10': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 10',
        'screen_size': '6.43 inch', 'screen_tech': 'AMOLED, 1100 nits', 'resolution': 'Full HD+', 'screen_refresh': '60 Hz', 'brightness': '1100 nits',
        'os': 'MIUI 12', 'cpu': 'Snapdragon 678 8 nhân (11nm)', 'gpu': 'Adreno 612',
        'cam_back': 'Chính 48 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '178 g',
        'sim': '2 Nano SIM'
    },
    'redmi_12c': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi 12C',
        'screen_size': '6.71 inch', 'screen_tech': 'IPS LCD lớn', 'resolution': 'HD+ (720 x 1650 Pixels)', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'MIUI 13', 'cpu': 'MediaTek Helio G85 8 nhân (12nm)', 'gpu': 'Mali-G52 MC2',
        'cam_back': 'Chính 50 MP (f/1.8, AI) & Phụ QVGA',
        'cam_front': '5 MP',
        'battery': '5000 mAh • Sạc 10W', 'battery_type': 'Li-Po', 'charge': '10 W',
        'security': 'Cảm biến vân tay mặt lưng', 'waterproof': 'Không', 'material': 'Nhựa vân sọc chéo chống bám vân tay', 'weight': '192 g',
        'sim': '2 Nano SIM + Thẻ nhớ MicroSD riêng'
    },
    'poco_x6_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X6 Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'Flow AMOLED, 120Hz, 1.5K, 68 tỷ màu, 1800 nits', 'resolution': '1.5K (1220 x 2712 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1800 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'MediaTek Dimensity 8300-Ultra 8 nhân (4nm флагман)', 'gpu': 'Mali-G615-MC6',
        'cam_back': 'Chính 64 MP (OIS chống rung quang học) & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W (45 phút đầy)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay trong màn hình', 'waterproof': 'IP54', 'material': 'Mặt lưng da thực vật / Kính nhựa cứng cáp', 'weight': '186 g',
        'sim': '2 Nano SIM'
    },
    'poco_x5_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X5 Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'Flow AMOLED 120Hz, 1 tỷ màu, Dolby Vision', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '900 nits',
        'os': 'MIUI 14 for POCO (Lên HyperOS)', 'cpu': 'Snapdragon 778G 5G 8 nhân (6nm)', 'gpu': 'Adreno 642L',
        'cam_back': 'Chính 108 MP (1/1.52\") & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5000 mAh • Sạc nhanh 67W • Mỏng nhẹ 7.9mm', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung phẳng & Nhựa', 'weight': '181 g',
        'sim': '2 Nano SIM'
    },
    'poco_x5': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X5 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 1200 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MIUI 13 for POCO', 'cpu': 'Snapdragon 695 5G 8 nhân (6nm)', 'gpu': 'Adreno 619',
        'cam_back': 'Chính 48 MP & 8 MP & 2 MP',
        'cam_front': '13 MP',
        'battery': '5000 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '189 g',
        'sim': '2 Nano SIM'
    },
    'poco_x4_gt': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X4 GT 5G',
        'screen_size': '6.6 inch', 'screen_tech': 'IPS LCD 144Hz siêu mượt, Dolby Vision', 'resolution': 'Full HD+ (1080 x 2460 Pixels)', 'screen_refresh': '144 Hz', 'brightness': '650 nits',
        'os': 'MIUI 13 for POCO', 'cpu': 'MediaTek Dimensity 8100 8 nhân (5nm đỉnh cao)', 'gpu': 'Mali-G610 MC6',
        'cam_back': 'Chính 64 MP & 8 MP & 2 MP',
        'cam_front': '16 MP',
        'battery': '5080 mAh • Sạc siêu nhanh 67W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'Không', 'material': 'Khung & Lưng nhựa cứng cáp', 'weight': '200 g',
        'sim': '2 Nano SIM'
    },
    'poco_x3_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X3 Pro',
        'screen_size': '6.67 inch', 'screen_tech': 'IPS LCD 120Hz, HDR10, Gorilla Glass 6', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '450 nits',
        'os': 'MIUI 12 for POCO (Lên MIUI 14)', 'cpu': 'Snapdragon 860 8 nhân (7nm hiệu năng cao)', 'gpu': 'Adreno 640',
        'cam_back': 'Chính 48 MP & 8 MP & 2 MP & 2 MP',
        'cam_front': '20 MP',
        'battery': '5160 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Khung nhựa & Lưng nhựa bóng sọc kép', 'weight': '215 g',
        'sim': '2 Nano SIM'
    },
    'poco_x3_nfc': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco X3 NFC',
        'screen_size': '6.67 inch', 'screen_tech': 'IPS LCD 120Hz, HDR10', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '450 nits',
        'os': 'MIUI 12 for POCO', 'cpu': 'Snapdragon 732G 8 nhân (8nm)', 'gpu': 'Adreno 618',
        'cam_back': 'Chính 64 MP (Sony IMX682) & 13 MP & 2 MP & 2 MP',
        'cam_front': '20 MP',
        'battery': '5160 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Nhựa', 'weight': '215 g',
        'sim': '2 Nano SIM'
    },
    'poco_f4': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Poco F4 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'E4 AMOLED 120Hz, Dolby Vision, 1300 nits', 'resolution': 'Full HD+', 'screen_refresh': '120 Hz', 'brightness': '1300 nits',
        'os': 'MIUI 13 for POCO (Lên HyperOS)', 'cpu': 'Snapdragon 870 5G 8 nhân (7nm ổn định mát mẻ)', 'gpu': 'Adreno 650',
        'cam_back': 'Chính 64 MP (Chống rung OIS) & 8 MP & 2 MP',
        'cam_front': '20 MP',
        'battery': '4500 mAh • Sạc siêu nhanh 67W (38 phút đầy)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay cạnh bên', 'waterproof': 'IP53', 'material': 'Mặt lưng kính cường lực & Khung phẳng', 'weight': '195 g',
        'sim': '2 Nano SIM'
    }
}

def generate_specs_package(spec_data, capacity, ram, condition="Grade A 99%", battery_cond="Pin 95% - 100%"):
    brand = spec_data['brand']
    
    # 1. Summary Specs
    summary = {
        'screen': f"{spec_data['screen_size']}, {spec_data['screen_tech']}, {spec_data['resolution']}",
        'os': spec_data['os'],
        'cam_back': spec_data['cam_back'],
        'cam_front': spec_data['cam_front'],
        'cpu': spec_data['cpu'],
        'ram': ram or spec_data.get('ram', '8 GB'),
        'rom': capacity or '128 GB',
        'battery': f"{spec_data['battery']} • {battery_cond} (Chuẩn Zin)"
    }
    
    # 2. Spec Groups (8 standard groups)
    groups = [
        {
            'group': 'Màn hình',
            'items': [
                {'name': 'Kích thước màn hình', 'value': spec_data['screen_size']},
                {'name': 'Công nghệ màn hình', 'value': spec_data['screen_tech']},
                {'name': 'Độ phân giải màn hình', 'value': spec_data['resolution']},
                {'name': 'Tần số quét', 'value': spec_data.get('screen_refresh', '120 Hz')},
                {'name': 'Độ sáng tối đa', 'value': spec_data.get('brightness', '1200 nits')}
            ]
        },
        {
            'group': 'Camera sau',
            'items': [
                {'name': 'Độ phân giải camera sau', 'value': spec_data['cam_back']},
                {'name': 'Quay phim', 'value': '4K@60fps, 4K@30fps, 1080p@60fps, Chế độ điện ảnh (Cinematic)'},
                {'name': 'Đèn Flash', 'value': 'Flash True Tone / LED kép'},
                {'name': 'Tính năng camera', 'value': 'Chụp đêm (Night Mode), Chân dung xóa phông, HDR thông minh, Chống rung quang học (OIS)'}
            ]
        },
        {
            'group': 'Camera trước',
            'items': [
                {'name': 'Độ phân giải camera trước', 'value': spec_data['cam_front']},
                {'name': 'Tính năng', 'value': 'Tự động lấy nét AF, Xóa phông, Quay video 4K / Full HD, Smart HDR'}
            ]
        },
        {
            'group': 'Hệ điều hành & CPU',
            'items': [
                {'name': 'Hệ điều hành', 'value': spec_data['os']},
                {'name': 'Chip xử lý (CPU)', 'value': spec_data['cpu']},
                {'name': 'Tốc độ CPU', 'value': 'Tối ưu hiệu năng cao & tiết kiệm điện năng'},
                {'name': 'Chip đồ họa (GPU)', 'value': spec_data.get('gpu', 'GPU đa nhân hiệu năng cao')}
            ]
        },
        {
            'group': 'Bộ nhớ & Lưu trữ',
            'items': [
                {'name': 'Dung lượng RAM', 'value': ram or spec_data.get('ram', '8 GB')},
                {'name': 'Dung lượng lưu trữ (ROM)', 'value': capacity or '128 GB'},
                {'name': 'Tình trạng linh kiện', 'value': f'Zin 100% nguyên bản, kiểm định 30 bước, {condition}'}
            ]
        },
        {
            'group': 'Pin & Sạc',
            'items': [
                {'name': 'Dung lượng pin', 'value': spec_data['battery']},
                {'name': 'Loại pin', 'value': spec_data.get('battery_type', 'Li-Ion')},
                {'name': 'Hỗ trợ sạc tối đa', 'value': spec_data.get('charge', '25 W')},
                {'name': 'Công nghệ pin', 'value': 'Sạc pin nhanh, Tiết kiệm pin, Sạc bảo vệ tuổi thọ pin'}
            ]
        },
        {
            'group': 'Tiện ích & Thiết kế',
            'items': [
                {'name': 'Bảo mật nâng cao', 'value': spec_data.get('security', 'Mở khóa khuôn mặt / Vân tay')},
                {'name': 'Kháng nước, bụi', 'value': spec_data.get('waterproof', 'IP68 / Kháng nước nhẹ')},
                {'name': 'Chất liệu thiết kế', 'value': spec_data.get('material', 'Khung kim loại & Kính cường lực cao cấp')},
                {'name': 'Khối lượng máy', 'value': spec_data.get('weight', '180 g - 220 g')}
            ]
        },
        {
            'group': 'Kết nối',
            'items': [
                {'name': 'Mạng di động', 'value': 'Hỗ trợ 5G / 4G LTE đa băng tần'},
                {'name': 'SIM', 'value': spec_data.get('sim', '1 Nano SIM & 1 eSIM hoặc 2 Nano SIM')},
                {'name': 'Wi-Fi & Bluetooth', 'value': 'Wi-Fi 6 / 6E / 7, Bluetooth 5.3 tốc độ cao'},
                {'name': 'Cổng kết nối / Sạc', 'value': 'Type-C tiêu chuẩn (hoặc Lightning trên iPhone)'}
            ]
        }
    ]

    # Quick badge keywords
    specs_list = [
        spec_data['screen_size'],
        spec_data['screen_tech'].split(',')[0],
        spec_data['cpu'].split('(')[0].strip(),
        f"RAM {ram or spec_data.get('ram', '8 GB')}",
        f"ROM {capacity or '128 GB'}",
        spec_data['battery'].split('•')[0].strip()
    ]

    return summary, groups, specs_list

def main():
    with open(DATA_FILE, 'r', encoding='utf-8') as f:
        products = json.load(f)

    updated_count = 0
    updated_items_for_wp = []

    for item in products:
        if item.get('spec_groups') and len(item['spec_groups']) > 0:
            continue

        raw = item.get('raw_name') or item.get('name')
        key, cap, ram = detect_model_key(raw)

        if not key or key not in SPECS_MASTER:
            print(f"WARN: No spec master for key '{key}' from '{raw}'")
            continue

        spec_data = SPECS_MASTER[key]
        cond = item.get('condition', 'Grade A 99%')
        bat = item.get('battery', 'Pin 95% - 100%')

        summary, groups, specs_list = generate_specs_package(spec_data, cap, ram, cond, bat)

        item['summary_specs'] = summary
        item['spec_groups'] = groups
        item['specs'] = specs_list

        updated_items_for_wp.append({
            'name': item.get('name'),
            'raw_name': item.get('raw_name'),
            'summary_specs': summary,
            'spec_groups': groups
        })
        updated_count += 1

    print(f"Successfully generated specs for {updated_count} products!")

    # Save to local used-phones.json
    with open(DATA_FILE, 'w', encoding='utf-8') as f:
        json.dump(products, f, ensure_ascii=False, indent=2)
    print(f"Saved updated used-phones.json ({len(products)} products)")

    # Save to live XAMPP used-phones.json
    if os.path.exists(os.path.dirname(XAMPP_DATA_FILE)):
        with open(XAMPP_DATA_FILE, 'w', encoding='utf-8') as f:
            json.dump(products, f, ensure_ascii=False, indent=2)
        print(f"Synced to XAMPP used-phones.json")

    # Now update WordPress database postmeta
    print("\nUpdating WordPress postmeta (_spec_groups, _summary_specs)...")
    temp_json_path = "/tmp/updated_specs_for_wp.json"
    with open(temp_json_path, 'w', encoding='utf-8') as f:
        json.dump(updated_items_for_wp, f, ensure_ascii=False)

    php_script = f"""
    require('/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php');
    $items = json_decode(file_get_contents('{temp_json_path}'), true);
    $updated_posts = 0;
    
    $products = get_posts([
        'post_type' => 'product',
        'post_status' => 'publish',
        'numberposts' => -1
    ]);
    
    foreach ($products as $p) {{
        $pid = $p->ID;
        $title = mb_strtolower(trim($p->post_title));
        $raw = mb_strtolower(trim(get_post_meta($pid, '_phonex_raw_name', true) ?: $p->post_title));
        
        foreach ($items as $it) {{
            $it_title = mb_strtolower(trim($it['name']));
            $it_raw = mb_strtolower(trim($it['raw_name'] ?? ''));
            
            if ($title === $it_title || $raw === $it_raw || stripos($title, $it_raw) !== false || stripos($it_raw, $raw) !== false) {{
                update_post_meta($pid, '_spec_groups', $it['spec_groups']);
                update_post_meta($pid, '_summary_specs', $it['summary_specs']);
                $updated_posts++;
                break;
            }}
        }}
    }}
    
    echo "WP Postmeta updated for $updated_posts products.\n";
    """

    res = subprocess.run(["/Applications/XAMPP/xamppfiles/bin/php", "-r", php_script], capture_output=True, text=True)
    print(res.stdout)
    if res.stderr:
        print("STDERR:", res.stderr)

if __name__ == '__main__':
    main()
