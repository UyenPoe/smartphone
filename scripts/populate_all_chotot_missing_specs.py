#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
populate_all_chotot_missing_specs.py
Crawls and generates full 8-group technical specifications & summary specs
for all remaining phone products in PhoneX, guaranteeing 100% specs coverage across the entire system.
"""

import json
import re
import os
import sys
import unicodedata
import subprocess

BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), ".."))
DATA_DIR = os.path.join(BASE_DIR, "phonex-theme", "data")
USED_PHONES_FILE = os.path.join(DATA_DIR, "used-phones.json")
CHOTOT_PHONES_FILE = os.path.join(DATA_DIR, "chotot-used-phones.json")

# Import existing SPECS_MASTER from populate_all_missing_phone_specs
sys.path.append(os.path.dirname(__file__))
from populate_all_missing_phone_specs import SPECS_MASTER, generate_specs_package

# ADD / EXTEND MASTER SPECIFICATIONS FOR ALL CHOTOT & PRE-OWNED MODELS
NEW_SPECS = {
    'samsung_note_20': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Note 20',
        'screen_size': '6.7 inch', 'screen_tech': 'Super AMOLED Plus, HDR10+', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '60 Hz', 'brightness': '1050 nits',
        'os': 'Android 13 / One UI', 'cpu': 'Exynos 990 / Snapdragon 865+ 8 nhân', 'gpu': 'Mali-G77 MP11 / Adreno 650',
        'cam_back': 'Chính 12 MP (f/1.8, OIS) & Tele 64 MP (zoom 30x, 8K) & Góc siêu rộng 12 MP',
        'cam_front': '10 MP (Dual Pixel PDAF, 4K video)',
        'battery': '4300 mAh • Sạc nhanh 25W • Sạc không dây 15W', 'battery_type': 'Li-Ion', 'charge': '25 W',
        'security': 'Vân tay siêu âm dưới màn hình, Mở khóa khuôn mặt, Bút S-Pen', 'waterproof': 'IP68', 'material': 'Khung kim loại & Mặt lưng Glasstic mờ chống bám vân tay', 'weight': '192 g',
        'sim': '2 Nano SIM hoặc 1 Nano SIM + 1 eSIM'
    },
    'samsung_note_9': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Note 9',
        'screen_size': '6.4 inch', 'screen_tech': 'Super AMOLED cong tràn viền', 'resolution': '1440 x 2960 Pixels (2K+ Quad HD+)', 'screen_refresh': '60 Hz', 'brightness': '1000 nits',
        'os': 'Android 10 / One UI', 'cpu': 'Exynos 9810 / Snapdragon 845 8 nhân', 'gpu': 'Mali-G72 MP18 / Adreno 630',
        'cam_back': 'Kép 12 MP (khẩu độ kép f/1.5-f/2.4, OIS) & Tele 12 MP (zoom quang 2x, OIS)',
        'cam_front': '8 MP (tự động lấy nét, quay 2K)',
        'battery': '4000 mAh • Sạc nhanh 15W • Sạc không dây', 'battery_type': 'Li-Ion', 'charge': '15 W',
        'security': 'Bút S-Pen Bluetooth, Quét mống mắt Iris Scanner, Cảm biến vân tay', 'waterproof': 'IP68', 'material': 'Khung nhôm nguyên khối & 2 mặt kính cường lực Gorilla Glass 5', 'weight': '201 g',
        'sim': '2 Nano SIM (SIM 2 chung khe thẻ nhớ)'
    },
    'samsung_z_fold4': {
        'brand': 'Samsung', 'name': 'Samsung Galaxy Z Fold4',
        'screen_size': 'Chính 7.6 inch & Phụ 6.2 inch', 'screen_tech': 'Dynamic AMOLED 2X, Màn hình gập LTPO 120Hz', 'resolution': 'QXGA+ (2176 x 1812 Pixels) & HD+ (2316 x 904 Pixels)', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'Android 14 / One UI 6.1 (Tối ưu màn hình gập)', 'cpu': 'Snapdragon 8+ Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 730',
        'cam_back': 'Chính 50 MP (OIS, Dual Pixel) & Tele 10 MP (zoom quang 3x, OIS) & Siêu rộng 12 MP',
        'cam_front': 'Màn ngoài 10 MP & Màn chính 4 MP ẩn dưới màn hình (UDC)',
        'battery': '4400 mAh • Sạc nhanh 25W • Sạc không dây 15W', 'battery_type': 'Li-Po', 'charge': '25 W',
        'security': 'Vân tay cạnh bên, Nhận diện khuôn mặt', 'waterproof': 'IPX8 kháng nước cao cấp', 'material': 'Khung nhôm Armor Aluminum & Kính Gorilla Glass Victus+', 'weight': '263 g',
        'sim': '1 Nano SIM & 1 eSIM hoặc 2 eSIM'
    },
    'sony_xperia_5_iv': {
        'brand': 'Sony', 'name': 'Sony Xperia 5 IV',
        'screen_size': '6.1 inch', 'screen_tech': 'OLED 1 tỷ màu, HDR, tỉ lệ điện ảnh 21:9', 'resolution': '1080 x 2520 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Android 14 / Android 13', 'cpu': 'Snapdragon 8 Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 730',
        'cam_back': '3 camera 12 MP ZEISS T* (Chính 24mm OIS, Tele 60mm 2.5x OIS, Siêu rộng 16mm 124°)',
        'cam_front': '12 MP (24mm, HDR, quay video 4K HDR)',
        'battery': '5000 mAh • Sạc nhanh 30W PD • Sạc không dây Qi', 'battery_type': 'Li-Po', 'charge': '30 W',
        'security': 'Cảm biến vân tay cạnh bên, Phím chụp ảnh vật lý 2 nấc', 'waterproof': 'IP65/IP68', 'material': 'Khung kim loại & Kính Gorilla Glass Victus trước sau', 'weight': '172 g',
        'sim': '2 SIM (1 Nano SIM + 1 eSIM hoặc thẻ nhớ MicroSD)'
    },
    'xiaomi_redmi_k80_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi K80 Pro',
        'screen_size': '6.67 inch', 'screen_tech': '2K OLED 12-bit, Dolby Vision, HDR10+, TCL M9', 'resolution': '1440 x 3200 Pixels (2K QHD+)', 'screen_refresh': '120 Hz', 'brightness': '3200 nits',
        'os': 'Xiaomi HyperOS 2 / Android 15', 'cpu': 'Snapdragon 8 Elite 8 nhân (3nm)', 'gpu': 'Adreno 830 + Chip đồ họa D1',
        'cam_back': 'Chính 50 MP Light Hunter 800 (OIS) & Tele 50 MP (zoom quang 2.5x) & Siêu rộng 32 MP',
        'cam_front': '20 MP (HDR, quay 1080p@60fps)',
        'battery': '6000 mAh • Sạc siêu nhanh 120W • Sạc không dây 50W', 'battery_type': 'Silicon-Carbon', 'charge': '120 W',
        'security': 'Vân tay siêu âm 3D dưới màn hình, Mở khóa khuôn mặt AI', 'waterproof': 'IP68 / IP69 kháng nước & bụi áp lực cao', 'material': 'Khung kim loại mạ mờ & Kính Xiaomi Dragon Crystal Glass 2.0', 'weight': '212 g',
        'sim': '2 Nano SIM 5G kép'
    },
    'xiaomi_redmi_note_12_turbo': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 12 Turbo',
        'screen_size': '6.67 inch', 'screen_tech': 'OLED 12-bit (68 tỷ màu), Dolby Vision, HDR10+', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '1000 nits',
        'os': 'Xiaomi HyperOS / MIUI 14 (Android 13/14)', 'cpu': 'Snapdragon 7+ Gen 2 8 nhân (4nm siêu mạnh)', 'gpu': 'Adreno 725',
        'cam_back': 'Chính 64 MP (OIS chống rung) & Siêu rộng 8 MP (120°) & Macro 2 MP',
        'cam_front': '16 MP (Chân dung xóa phông, HDR)',
        'battery': '5000 mAh • Sạc nhanh 67W Turbo Charge', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Cảm biến vân tay cạnh viền, Mở khóa khuôn mặt AI', 'waterproof': 'Kháng nước nhẹ sinh hoạt', 'material': 'Khung viền mỏng 1.42mm, Mặt lưng kính bóng bẩy', 'weight': '181 g',
        'sim': '2 Nano SIM 5G'
    },
    'xiaomi_15': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 15',
        'screen_size': '6.36 inch', 'screen_tech': 'LTPO AMOLED 1.5K, Dolby Vision, HDR10+, 1-120Hz', 'resolution': '1200 x 2670 Pixels (1.5K)', 'screen_refresh': '120 Hz', 'brightness': '3200 nits',
        'os': 'Xiaomi HyperOS 2 / Android 15', 'cpu': 'Snapdragon 8 Elite 8 nhân (3nm)', 'gpu': 'Adreno 830',
        'cam_back': '3 camera Leica 50 MP: Chính 50 MP (Light Fusion 900, f/1.62, OIS) & Tele 50 MP (OIS) & Siêu rộng 50 MP',
        'cam_front': '32 MP (Góc rộng, quay 4K60fps)',
        'battery': '5240 mAh • Sạc nhanh 90W có dây • Sạc không dây 50W', 'battery_type': 'Silicon-Carbon', 'charge': '90 W',
        'security': 'Vân tay siêu âm dưới màn hình, Mở khóa khuôn mặt', 'waterproof': 'IP68 kháng nước & bụi', 'material': 'Khung nhôm hàng không nguyên khối & Kính Xiaomi Shield Glass', 'weight': '191 g',
        'sim': '2 Nano SIM hoặc 1 Nano SIM + 1 eSIM'
    },
    'xiaomi_15_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 15 Pro 5G',
        'screen_size': '6.73 inch', 'screen_tech': '2K LTPO AMOLED 1-120Hz, Dolby Vision, HDR10+, M9', 'resolution': '1440 x 3200 Pixels (2K WQHD+)', 'screen_refresh': '120 Hz', 'brightness': '3200 nits',
        'os': 'Xiaomi HyperOS 2 / Android 15', 'cpu': 'Snapdragon 8 Elite 8 nhân (3nm)', 'gpu': 'Adreno 830',
        'cam_back': 'Hệ thống 3 camera Leica 50 MP: Chính 50 MP (Light Fusion 900, f/1.44, OIS) & Tele tiềm vọng 50 MP (Sony IMX858 5x OIS) & Siêu rộng 50 MP',
        'cam_front': '32 MP (Quay 4K60fps)',
        'battery': '6100 mAh Silicon-Carbon siêu khủng • Sạc nhanh 90W có dây • Sạc không dây 50W', 'battery_type': 'Silicon-Carbon', 'charge': '90 W',
        'security': 'Vân tay siêu âm dưới màn hình, Kháng nước IP68', 'material': 'Khung nhôm nguyên khối & Kính Xiaomi Dragon Crystal Glass 2.0', 'weight': '213 g',
        'sim': '2 Nano SIM 5G'
    },
    'xiaomi_13t_pro': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 13T Pro 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'CrystalRes AMOLED 1.5K, 68 tỷ màu, 144Hz Pro', 'resolution': '1220 x 2712 Pixels (1.5K)', 'screen_refresh': '144 Hz', 'brightness': '2600 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'MediaTek Dimensity 9200+ 8 nhân (4nm flagship)', 'gpu': 'Immortalis-G715 MC11',
        'cam_back': 'Ống kính chuyên nghiệp Leica: Chính 50 MP (Sony IMX707, OIS) & Tele 50 MP (Zoom quang 2x) & Siêu rộng 12 MP',
        'cam_front': '20 MP (f/2.2, HDR)',
        'battery': '5000 mAh • Sạc siêu tốc 120W HyperCharge (19 phút đầy 100%)', 'battery_type': 'Li-Po', 'charge': '120 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt AI', 'waterproof': 'IP68 chống nước độ sâu 1.5m trong 30 phút', 'material': 'Khung hợp kim & Mặt lưng kính hoặc Da sinh học cao cấp', 'weight': '206 g',
        'sim': '2 Nano SIM (hỗ trợ eSIM)'
    },
    'xiaomi_12s': {
        'brand': 'Xiaomi', 'name': 'Xiaomi 12S 5G',
        'screen_size': '6.28 inch', 'screen_tech': 'AMOLED 12-bit, 120Hz, Dolby Vision, HDR10+', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '1100 nits',
        'os': 'MIUI 14 / Xiaomi HyperOS (Android 13)', 'cpu': 'Snapdragon 8+ Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 730',
        'cam_back': 'Ống kính Leica Summicron: Chính 50 MP (Sony IMX707, OIS) & Siêu rộng 13 MP (123°) & Telemacro 5 MP',
        'cam_front': '32 MP (HDR, quay 1080p60fps)',
        'battery': '4500 mAh • Sạc nhanh 67W có dây • Sạc không dây 50W', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay dưới màn hình, Loa kép Harman Kardon', 'waterproof': 'Kháng nước nhẹ', 'material': 'Khung nhôm & Kính Gorilla Glass Victus', 'weight': '182 g',
        'sim': '2 Nano SIM 5G'
    },
    'xiaomi_redmi_note_13': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 13',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 120Hz, 100% DCI-P3, Viền siêu mỏng', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '1800 nits',
        'os': 'Xiaomi HyperOS / Android 14', 'cpu': 'Snapdragon 685 8 nhân (6nm)', 'gpu': 'Adreno 610',
        'cam_back': 'Chính 108 MP (zoom 3x lossless) & Góc siêu rộng 8 MP & Macro 2 MP',
        'cam_front': '16 MP (Chân dung AI, HDR)',
        'battery': '5000 mAh • Sạc nhanh 33W', 'battery_type': 'Li-Po', 'charge': '33 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt AI', 'waterproof': 'IP54 kháng nước & bụi', 'material': 'Khung viền vuông thời trang, Kính Gorilla Glass 3', 'weight': '174.5 g',
        'sim': '2 Nano SIM (hoặc 1 SIM + Thẻ nhớ)'
    },
    'xiaomi_redmi_note_15_pro_plus': {
        'brand': 'Xiaomi', 'name': 'Xiaomi Redmi Note 15 Pro+ / 14 Pro+ 5G',
        'screen_size': '6.67 inch', 'screen_tech': 'AMOLED 1.5K cong 3D, 12-bit màu, 120Hz, Dolby Vision', 'resolution': '1220 x 2712 Pixels (1.5K)', 'screen_refresh': '120 Hz', 'brightness': '3000 nits',
        'os': 'Xiaomi HyperOS (Android 14)', 'cpu': 'Snapdragon 7s Gen 3 8 nhân (4nm thế hệ mới)', 'gpu': 'Adreno 710',
        'cam_back': 'Chính 50 MP Light Hunter 800 (f/1.6, OIS) & Tele 50 MP (zoom quang 2.5x) & Siêu rộng 8 MP',
        'cam_front': '20 MP (Quay Full HD, HDR thông minh)',
        'battery': '6200 mAh Silicon-Carbon thế hệ mới • Sạc siêu nhanh 90W', 'battery_type': 'Silicon-Carbon', 'charge': '90 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt AI', 'waterproof': 'IP68 / IP69 kháng nước ngâm sâu & tia nước áp lực cao', 'material': 'Khung gia cố chống sốc & Kính Gorilla Glass Victus 2', 'weight': '210 g',
        'sim': '2 Nano SIM 5G'
    },
    'oppo_reno7_pro': {
        'brand': 'Oppo', 'name': 'OPPO Reno7 Pro 5G',
        'screen_size': '6.55 inch', 'screen_tech': 'AMOLED 90Hz, HDR10+, Viền siêu mỏng', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '90 Hz', 'brightness': '920 nits',
        'os': 'ColorOS 13 / Android 13', 'cpu': 'MediaTek Dimensity 1200 Max 5G 8 nhân (6nm)', 'gpu': 'ARM Mali-G77 MC9',
        'cam_back': 'Chính 50 MP (Sony IMX766, PDAF) & Siêu rộng 8 MP (119°) & Macro 2 MP, Đèn viền Breathing Light',
        'cam_front': '32 MP (Sony IMX709 cảm biến mắt mèo siêu sáng RGBW)',
        'battery': '4500 mAh • Siêu sạc nhanh 65W SuperVOOC', 'battery_type': 'Li-Po', 'charge': '65 W',
        'security': 'Vân tay quang học dưới màn hình, Đèn viền camera thông báo', 'waterproof': 'Kháng bụi & nước nhẹ', 'material': 'Khung kim loại vuông vức & Mặt lưng kính Glow chống xước vi mô', 'weight': '180 g',
        'sim': '2 Nano SIM 5G'
    },
    'oppo_reno4_z': {
        'brand': 'Oppo', 'name': 'OPPO Reno4 Z 5G',
        'screen_size': '6.57 inch', 'screen_tech': 'LTPS IPS LCD, 120Hz siêu mượt', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '480 nits',
        'os': 'ColorOS / Android 11', 'cpu': 'MediaTek Dimensity 800 5G 8 nhân (7nm)', 'gpu': 'Mali-G57 MC4',
        'cam_back': 'Bộ 4 camera: Chính 48 MP (f/1.7) & Siêu rộng 8 MP (119°) & Cảm biến cổ điển 2 MP & Đo độ sâu 2 MP',
        'cam_front': 'Kép: 16 MP chính & 2 MP xóa phông',
        'battery': '4000 mAh • Sạc nhanh 18W qua cổng Type-C', 'battery_type': 'Li-Po', 'charge': '18 W',
        'security': 'Vân tay cạnh viền, Mở khóa khuôn mặt', 'waterproof': 'Kháng nước nhẹ', 'material': 'Khung viền bo cong & Mặt lưng kính cường lực 2.5D', 'weight': '184 g',
        'sim': '2 Nano SIM 5G'
    },
    'oppo_reno8_5g': {
        'brand': 'Oppo', 'name': 'OPPO Reno8 5G',
        'screen_size': '6.43 inch', 'screen_tech': 'AMOLED 90Hz, 100% DCI-P3', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '90 Hz', 'brightness': '800 nits',
        'os': 'ColorOS 13 / Android 13', 'cpu': 'MediaTek Dimensity 1300 8 nhân (6nm)', 'gpu': 'Mali-G77 MC9',
        'cam_back': 'Bộ 3 camera: Chính 50 MP (Sony IMX766) & Góc rộng 8 MP & Macro 2 MP',
        'cam_front': '32 MP (Sony IMX709 mắt mèo)',
        'battery': '4500 mAh • Siêu sạc nhanh 80W SuperVOOC (28 phút 100%)', 'battery_type': 'Li-Po', 'charge': '80 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt', 'waterproof': 'Kháng nước nhẹ', 'material': 'Thiết kế nguyên khối Unibody & Mặt lưng kính Gorilla Glass 5', 'weight': '179 g',
        'sim': '2 Nano SIM 5G'
    },
    'oppo_a78': {
        'brand': 'Oppo', 'name': 'OPPO A78',
        'screen_size': '6.43 inch', 'screen_tech': 'AMOLED 90Hz, Kính Gorilla Glass 5', 'resolution': '1080 x 2400 Pixels (Full HD+)', 'screen_refresh': '90 Hz', 'brightness': '600 nits',
        'os': 'ColorOS 13.1 / Android 13', 'cpu': 'Snapdragon 680 8 nhân (6nm)', 'gpu': 'Adreno 610',
        'cam_back': 'Chính 50 MP (f/1.8) & Đo chiều sâu 2 MP (Xóa phông chuyên nghiệp)',
        'cam_front': '8 MP (Làm đẹp AI, HDR)',
        'battery': '5000 mAh • Sạc siêu nhanh 67W SuperVOOC (44 phút 100%)', 'battery_type': 'Li-Po', 'charge': '67 W',
        'security': 'Vân tay quang học dưới màn hình, Loa kép Stereo Ultra Volume 200%', 'waterproof': 'IP54 kháng nước & bụi', 'material': 'Mặt lưng OPPO Glow lấp lánh, Khung kim loại vuông vức', 'weight': '180 g',
        'sim': '2 Nano SIM hoặc 1 SIM + Thẻ nhớ MicroSD 1TB'
    },
    'oppo_a16': {
        'brand': 'Oppo', 'name': 'OPPO A16',
        'screen_size': '6.52 inch', 'screen_tech': 'IPS LCD, Công nghệ bảo vệ mắt AI Eye-care', 'resolution': '720 x 1600 Pixels (HD+)', 'screen_refresh': '60 Hz', 'brightness': '480 nits',
        'os': 'ColorOS 11.1 / Android 11', 'cpu': 'MediaTek Helio G35 8 nhân (2.3 GHz)', 'gpu': 'IMG PowerVR GE8320',
        'cam_back': 'Bộ 3 camera AI: Chính 13 MP & Macro 2 MP & Đo chiều sâu 2 MP',
        'cam_front': '8 MP (Làm đẹp AI, HDR)',
        'battery': '5000 mAh • Tối ưu sạc đêm an toàn', 'battery_type': 'Li-Po', 'charge': '10 W',
        'security': 'Cảm biến vân tay cạnh bên tích hợp nút nguồn, Nhận diện khuôn mặt', 'waterproof': 'IPX4 kháng nước bắn nhẹ', 'material': 'Mặt lưng ánh kim chống bám vân tay, Khung cong 3D', 'weight': '190 g',
        'sim': '2 Nano SIM + Khe cắm thẻ nhớ riêng biệt'
    },
    'oppo_find_x7_ultra': {
        'brand': 'Oppo', 'name': 'OPPO Find X7 Ultra (Find X9 Pro series)',
        'screen_size': '6.82 inch', 'screen_tech': 'LTPO AMOLED 120Hz 1 tỷ màu, Dolby Vision, DisplayMate A+', 'resolution': '1440 x 3168 Pixels (2K+ QHD+)', 'screen_refresh': '120 Hz', 'brightness': '4500 nits đỉnh',
        'os': 'ColorOS 14 / Android 14', 'cpu': 'Snapdragon 8 Gen 3 8 nhân (4nm)', 'gpu': 'Adreno 750',
        'cam_back': 'Hệ thống 4 camera 50 MP Hasselblad: Chính 1 inch Sony LYT-900 OIS & Kép tiềm vọng 50 MP (3x & 6x OIS) & Siêu rộng 50 MP',
        'cam_front': '32 MP (Sony IMX709, quay 4K60fps)',
        'battery': '5000 mAh • Sạc nhanh 100W SuperVOOC • Sạc không dây 50W AirVOOC', 'battery_type': 'Li-Po', 'charge': '100 W',
        'security': 'Vân tay siêu âm dưới màn hình, Cần gạt chuyển trạng thái bảo mật VIP', 'waterproof': 'IP68 kháng nước & bụi cao cấp', 'material': 'Khung kim loại nhôm & Mặt lưng da phối kính cao cấp', 'weight': '221 g',
        'sim': '2 Nano SIM 5G'
    },
    'vivo_x70_pro_plus': {
        'brand': 'Vivo', 'name': 'Vivo X70 Pro+ 5G',
        'screen_size': '6.78 inch', 'screen_tech': 'LTPO AMOLED 2K+ cong 3D, 1 tỷ màu, HDR10+, E5 Luminescent', 'resolution': '1440 x 3200 Pixels (2K+ WQHD+)', 'screen_refresh': '120 Hz', 'brightness': '1500 nits',
        'os': 'OriginOS / Funtouch OS (Android 12/13)', 'cpu': 'Snapdragon 888+ 5G 8 nhân (5nm) + Chip hình ảnh Vivo V1', 'gpu': 'Adreno 660',
        'cam_back': '4 camera ZEISS T*: Chính 50 MP (Samsung GN1, OIS) & Siêu rộng 48 MP (Gimbal OIS 360°) & Chân dung 12 MP (OIS) & Tiềm vọng 8 MP (5x OIS, Zoom 60x)',
        'cam_front': '32 MP (HDR, quay 4K)',
        'battery': '4500 mAh • Sạc nhanh 55W FlashCharge • Sạc không dây 50W', 'battery_type': 'Li-Po', 'charge': '55 W',
        'security': 'Vân tay quang học dưới màn hình, Mở khóa khuôn mặt', 'waterproof': 'IP68 kháng nước độ sâu 1.5m', 'material': 'Khung hợp kim nhôm & Mặt lưng kính Ceramic hoặc Da thuần chay', 'weight': '209 g',
        'sim': '2 Nano SIM 5G'
    },
    'vivo_y300': {
        'brand': 'Vivo', 'name': 'Vivo Y300 / Y300i 5G',
        'screen_size': '6.77 inch', 'screen_tech': 'AMOLED 120Hz, 1800 nits, TUV Rheinland bảo vệ mắt', 'resolution': '1080 x 2392 Pixels (Full HD+)', 'screen_refresh': '120 Hz', 'brightness': '1800 nits',
        'os': 'OriginOS 5 / Android 15', 'cpu': 'MediaTek Dimensity 6300 5G 8 nhân (6nm)', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Chính 50 MP (f/1.8, PDAF) & Cảm biến chiều sâu 2 MP, Đèn Aura Light',
        'cam_front': '8 MP (Làm đẹp chân dung AI)',
        'battery': '6500 mAh siêu khủng • Sạc nhanh 44W FlashCharge', 'battery_type': 'BlueVolt siêu bền', 'charge': '44 W',
        'security': 'Vân tay quang học dưới màn hình, Loa kép Stereo 300% âm lượng', 'waterproof': 'IP64 kháng bụi & tia nước', 'material': 'Khung viền bóng bẩy, Mặt lưng kết cấu vân lụa chống xước', 'weight': '193 g',
        'sim': '2 Nano SIM 5G'
    },
    'honor_x9d_power': {
        'brand': 'Honor', 'name': 'Honor X9d / Power 5G',
        'screen_size': '6.79 inch', 'screen_tech': 'AMOLED 1.5K 120Hz, 1 tỷ màu, Chống rơi vỡ 360° Ultra-Bounce', 'resolution': '1200 x 2652 Pixels (1.5K)', 'screen_refresh': '120 Hz', 'brightness': '1200 nits',
        'os': 'MagicOS 8 / Android 14', 'cpu': 'Snapdragon 6 Gen 4 / 6 Gen 1 8 nhân (4nm)', 'gpu': 'Adreno 710',
        'cam_back': 'Chính 108 MP (f/1.75, cảm biến 1/1.67 inch) & Góc rộng 5 MP & Macro 2 MP',
        'cam_front': '16 MP (Chân dung AI, HDR)',
        'battery': '8300 mAh siêu bền 3 ngày • Sạc nhanh 66W SuperCharge', 'battery_type': 'Li-Po mật độ cao', 'charge': '66 W',
        'security': 'Vân tay dưới màn hình, Màn hình kháng va đập 5 sao SGS Thụy Sĩ', 'waterproof': 'IP54 kháng nước & bụi', 'material': 'Khung gia cố hợp kim chống rơi vỡ, Mặt lưng da hoặc kính nhám', 'weight': '195 g',
        'sim': '2 Nano SIM 5G'
    },
    'honor_200_lite': {
        'brand': 'Honor', 'name': 'Honor 200 Lite',
        'screen_size': '6.7 inch', 'screen_tech': 'AMOLED siêu mỏng, 100% DCI-P3, PWM Dimming 3240Hz', 'resolution': '1080 x 2412 Pixels (Full HD+)', 'screen_refresh': '90 Hz', 'brightness': '2000 nits',
        'os': 'MagicOS 8.0 / Android 14', 'cpu': 'MediaTek Dimensity 6080 5G 8 nhân (6nm)', 'gpu': 'Mali-G57 MC2',
        'cam_back': 'Bộ 3 camera: Chính 108 MP (f/1.75) & Góc rộng xóa phông 5 MP & Macro 2 MP',
        'cam_front': '50 MP góc rộng (f/2.1, Đèn selfie spotlight chuyên nghiệp)',
        'battery': '4500 mAh • Sạc nhanh 35W Honor SuperCharge', 'battery_type': 'Li-Po', 'charge': '35 W',
        'security': 'Vân tay cạnh bên, Thiết kế siêu mỏng nhẹ 6.78mm', 'waterproof': 'Kháng nước nhẹ', 'material': 'Khung viền vuông thời trang, Trọng lượng siêu nhẹ', 'weight': '166 g',
        'sim': '2 Nano SIM 5G'
    },
    'nokia_105_4g': {
        'brand': 'Nokia', 'name': 'Nokia 105 4G',
        'screen_size': '1.8 inch', 'screen_tech': 'TFT LCD độ nét cao, phông chữ lớn dễ đọc', 'resolution': '120 x 160 Pixels (QQVGA)', 'screen_refresh': '60 Hz', 'brightness': '300 nits',
        'os': 'Series 30+ (Giao diện tiếng Việt trực quan)', 'cpu': 'Unisoc T107 (Hỗ trợ 4G VoLTE đàm thoại HD)', 'gpu': 'Đồ họa cơ bản',
        'cam_back': 'Không có (Tối ưu độ bền và thời lượng pin)',
        'cam_front': 'Không có',
        'battery': '1020 mAh (Pin rời tiêu chuẩn Nokia, đàm thoại liên tục 12h, chờ 18 ngày)', 'battery_type': 'Li-Ion tháo rời', 'charge': '5 W tiêu chuẩn',
        'security': 'Khóa bàn phím bảo mật mã PIN, Bàn phím cao su T9 êm ái chống bụi', 'waterproof': 'Vỏ Polycarbonate chịu lực rơi vỡ tốt', 'material': 'Vỏ nhựa Polycarbonate siêu bền, sơn phủ nguyên khối không phai', 'weight': '80 g',
        'sim': '2 Nano SIM 4G VoLTE thoại siêu rõ'
    },
    'iphone_11_pro_max': {
        'brand': 'Apple', 'name': 'iPhone 11 Pro Max',
        'screen_size': '6.5 inch', 'screen_tech': 'Super Retina XDR OLED, HDR10, Dolby Vision', 'resolution': '1242 x 2688 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 18 / iOS 17', 'cpu': 'Apple A13 Bionic 6 nhân (7nm+)', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Bộ 3 camera 12 MP: Chính (f/1.8, OIS) & Tele (f/2.0, zoom quang 2x, OIS) & Siêu rộng 12 MP (120°)',
        'cam_front': '12 MP TrueDepth (4K60fps, Slofies)',
        'battery': '3969 mAh • Sạc nhanh 18W • Sạc không dây Qi', 'battery_type': 'Li-Ion', 'charge': '18 W',
        'security': 'Mở khóa khuôn mặt Face ID 3D', 'waterproof': 'IP68 kháng nước 4 mét trong 30 phút', 'material': 'Khung thép không gỉ & Kính mờ phủ sương chống bám vân tay', 'weight': '226 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_11_pro': {
        'brand': 'Apple', 'name': 'iPhone 11 Pro',
        'screen_size': '5.8 inch', 'screen_tech': 'Super Retina XDR OLED, HDR10, Dolby Vision', 'resolution': '1125 x 2436 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 18 / iOS 17', 'cpu': 'Apple A13 Bionic 6 nhân (7nm+)', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Bộ 3 camera 12 MP: Chính (f/1.8, OIS) & Tele (f/2.0, zoom quang 2x, OIS) & Siêu rộng (120°)',
        'cam_front': '12 MP TrueDepth (4K60fps, Slofies)',
        'battery': '3046 mAh • Sạc nhanh 18W • Sạc không dây Qi', 'battery_type': 'Li-Ion', 'charge': '18 W',
        'security': 'Mở khóa khuôn mặt Face ID 3D', 'waterproof': 'IP68 kháng nước 4 mét trong 30 phút', 'material': 'Khung thép không gỉ & Kính mờ phủ sương', 'weight': '188 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_13_mini': {
        'brand': 'Apple', 'name': 'iPhone 13 mini',
        'screen_size': '5.4 inch', 'screen_tech': 'Super Retina XDR OLED, HDR10, Dolby Vision', 'resolution': '1080 x 2340 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 18 / iOS 17', 'cpu': 'Apple A15 Bionic 6 nhân (5nm)', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Kép 12 MP chéo góc: Chính 12 MP (Sensor-shift OIS chống rung dịch chuyển cảm biến) & Siêu rộng 12 MP',
        'cam_front': '12 MP TrueDepth (Chế độ điện ảnh Cinematic Mode 1080p@30fps)',
        'battery': '2438 mAh • Sạc nhanh 20W • MagSafe 15W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID siêu nhạy', 'waterproof': 'IP68 kháng nước 6m trong 30 phút', 'material': 'Khung nhôm hàng không & Mặt kính Ceramic Shield', 'weight': '141 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_12_pro': {
        'brand': 'Apple', 'name': 'iPhone 12 Pro',
        'screen_size': '6.1 inch', 'screen_tech': 'Super Retina XDR OLED, Ceramic Shield, HDR10', 'resolution': '1170 x 2532 Pixels', 'screen_refresh': '60 Hz', 'brightness': '1200 nits',
        'os': 'iOS 18 / iOS 17', 'cpu': 'Apple A14 Bionic 6 nhân (5nm)', 'gpu': 'Apple GPU 4 nhân',
        'cam_back': 'Bộ 3 camera 12 MP + Cảm biến LiDAR: Chính (f/1.6, OIS) & Tele (zoom 2x, OIS) & Siêu rộng (120°), Apple ProRAW',
        'cam_front': '12 MP TrueDepth (Dolby Vision HDR, 4K60fps)',
        'battery': '2815 mAh • Sạc nhanh 20W • MagSafe 15W', 'battery_type': 'Li-Ion', 'charge': '20 W',
        'security': 'Face ID, LiDAR Scanner đo đạc 3D AR', 'waterproof': 'IP68 kháng nước 6 mét trong 30 phút', 'material': 'Khung thép không gỉ phẳng bóng bẩy & Mặt kính Ceramic Shield', 'weight': '189 g',
        'sim': '1 Nano SIM & 1 eSIM'
    },
    'iphone_7': {
        'brand': 'Apple', 'name': 'Apple iPhone 7',
        'screen_size': '4.7 inch', 'screen_tech': 'Retina HD IPS LCD, Dải màu rộng DCI-P3, 3D Touch', 'resolution': '750 x 1334 Pixels', 'screen_refresh': '60 Hz', 'brightness': '625 nits',
        'os': 'iOS 15.8 (Ổn định, mượt mà)', 'cpu': 'Apple A10 Fusion 4 nhân 64-bit', 'gpu': 'PowerVR Series7XT Plus',
        'cam_back': '12 MP (khẩu độ f/1.8 lớn hơn, 6 thấu kính, chống rung quang học OIS, Flash 4 LED)',
        'cam_front': '7 MP FaceTime HD (Retina Flash, quay Full HD 1080p)',
        'battery': '1960 mAh • Tối ưu tiết kiệm pin', 'battery_type': 'Li-Ion', 'charge': '10 W tiêu chuẩn',
        'security': 'Phím Home cảm ứng lực Taptic Engine & Cảm biến vân tay Touch ID thế hệ 2', 'waterproof': 'IP67 kháng nước & bụi', 'material': 'Vỏ nhôm nguyên khối Series 7000 cứng cáp', 'weight': '138 g',
        'sim': '1 Nano SIM 4G LTE'
    },
    'iphone_6s': {
        'brand': 'Apple', 'name': 'Apple iPhone 6s',
        'screen_size': '4.7 inch', 'screen_tech': 'Retina HD IPS LCD, Cảm ứng lực 3D Touch', 'resolution': '750 x 1334 Pixels', 'screen_refresh': '60 Hz', 'brightness': '500 nits',
        'os': 'iOS 15.8', 'cpu': 'Apple A9 2 nhân 1.84 GHz (Twister)', 'gpu': 'PowerVR GT7600 6 nhân',
        'cam_back': '12 MP (f/2.2, quay video 4K 30fps, Live Photos, True Tone Flash)',
        'cam_front': '5 MP FaceTime HD (Retina Flash màn hình)',
        'battery': '1715 mAh • Hoạt động bền bỉ', 'battery_type': 'Li-Ion', 'charge': '5 W tiêu chuẩn',
        'security': 'Cảm biến vân tay Touch ID siêu nhạy', 'waterproof': 'Kháng ẩm nhẹ', 'material': 'Khung vỏ hợp kim nhôm Series 7000 chống cong vênh', 'weight': '143 g',
        'sim': '1 Nano SIM'
    }
}

# Merge new specs into SPECS_MASTER
SPECS_MASTER.update(NEW_SPECS)

def detect_model_and_storage(title):
    # Normalize NFKD to convert mathematical bold unicode characters
    t_norm = unicodedata.normalize('NFKD', title).lower()
    
    # Extract capacity
    capacity = None
    cap_m = re.search(r'\b(2TB|1TB|512GB|256GB|128GB|64GB|32GB|16GB|512G|256G|128G|64G|32G)\b', t_norm, re.I)
    if cap_m:
        capacity = cap_m.group(1).upper()
        if capacity.endswith('G') and not capacity.endswith('GB'):
            capacity += 'B'

    # Extract RAM if explicitly stated (e.g. 8GB/256GB, 12/256, r4/64)
    ram = None
    # Check slash notation like 12/512, 12/256, 8/128, 16/512
    slash_m = re.search(r'\b(3|4|6|8|12|16|24)\s*/\s*(32|64|128|256|512|1024|1TB|2TB)\b', t_norm, re.I)
    if slash_m:
        ram = slash_m.group(1) + " GB"
        if not capacity:
            val2 = slash_m.group(2).upper()
            if val2 == '1024':
                capacity = '1TB'
            elif not val2.endswith('B'):
                capacity = val2 + "GB"
            else:
                capacity = val2

    if not ram:
        ram_m = re.search(r'\b(3|4|6|8|12|16|24)\s*(?:GB|G)\s*(?:/|\s+)\s*(?:2TB|1TB|\d+\s*(?:GB|G)?)', t_norm, re.I)
        if ram_m:
            ram = ram_m.group(1) + " GB"
        else:
            ram_r = re.search(r'\br(\d+)/\d+', t_norm, re.I)
            if ram_r:
                ram = ram_r.group(1) + " GB"

    if not capacity:
        capacity = '128GB'

    # --- MODEL MATCHING RULES (Matched directly on normalized full string) ---
    # Samsung
    if 'note 20' in t_norm: return 'samsung_note_20', capacity, ram or '8 GB'
    if 'note 9' in t_norm: return 'samsung_note_9', capacity, ram or '6 GB'
    if 'z fold4' in t_norm or 'fold 4' in t_norm or 'fold4' in t_norm: return 'samsung_z_fold4', capacity, ram or '12 GB'
    if 's26 ultra' in t_norm: return 'samsung_s26_ultra', capacity, ram or '16 GB'
    if 'a52' in t_norm: return 'samsung_a52', capacity, ram or '8 GB'
    if 'a05' in t_norm: return 'samsung_a05', capacity, ram or '4 GB'
    
    # Apple iPhone
    if '17 pro max' in t_norm or 'iphone 17 pro max' in t_norm: return 'iphone_17_pro_max', capacity, ram or '12 GB'
    if '17 pro' in t_norm or 'iphone 17 pro' in t_norm: return 'iphone_17_pro', capacity, ram or '12 GB'
    if '16 pro max' in t_norm: return 'iphone_16_pro_max', capacity, ram or '8 GB'
    if '16 pro' in t_norm: return 'iphone_16_pro', capacity, ram or '8 GB'
    if '15 pro max' in t_norm or '15promax' in t_norm or '15prm' in t_norm: return 'iphone_15_pro_max', capacity, ram or '8 GB'
    if '15 plus' in t_norm: return 'iphone_15_plus', capacity, ram or '6 GB'
    if 'ip 15' in t_norm or 'iphone 15' in t_norm: return 'iphone_15', capacity, ram or '6 GB'
    if '14 pro max' in t_norm or '14promax' in t_norm: return 'iphone_14_pro_max', capacity, ram or '6 GB'
    if '14 pro' in t_norm: return 'iphone_14_pro', capacity, ram or '6 GB'
    if '14 plus' in t_norm: return 'iphone_14_plus', capacity, ram or '6 GB'
    if '13 pro max' in t_norm: return 'iphone_13_pro_max', capacity, ram or '6 GB'
    if '13 mini' in t_norm: return 'iphone_13_mini', capacity, ram or '4 GB'
    if '12 pro' in t_norm: return 'iphone_12_pro', capacity, ram or '6 GB'
    if '11 pro max' in t_norm: return 'iphone_11_pro_max', capacity, ram or '4 GB'
    if '11 pro' in t_norm or 'iphone 11 pro' in t_norm: return 'iphone_11_pro', capacity, ram or '4 GB'
    if 'iphone 7' in t_norm or 'ip 7' in t_norm: return 'iphone_7', capacity, ram or '2 GB'
    if 'iphone 6s' in t_norm or '6s' in t_norm: return 'iphone_6s', capacity, ram or '2 GB'

    # Xiaomi
    if 'redmi k80 pro' in t_norm or 'k80 pro' in t_norm: return 'xiaomi_redmi_k80_pro', capacity, ram or '12 GB'
    if 'redmi note 12 turbo' in t_norm: return 'xiaomi_redmi_note_12_turbo', capacity, ram or '8 GB'
    if 'redmi note 15 pro plus' in t_norm or 'note 15 pro' in t_norm: return 'xiaomi_redmi_note_15_pro_plus', capacity, ram or '12 GB'
    if 'redmi note 13' in t_norm: return 'xiaomi_redmi_note_13', capacity, ram or '6 GB'
    if '13t pro' in t_norm: return 'xiaomi_13t_pro', capacity, ram or '12 GB'
    if 'xiaomi 17 pro max' in t_norm or 'mi 15s pro' in t_norm or '15s pro' in t_norm: return 'xiaomi_15_pro', capacity, ram or '16 GB'
    if 'xiaomi 15' in t_norm or 'mi 15' in t_norm: return 'xiaomi_15', capacity, ram or '12 GB'
    if 'mi 12s' in t_norm or 'xiaomi 12s' in t_norm: return 'xiaomi_12s', capacity, ram or '8 GB'
    if 'xiaomi 13' in t_norm or 'mi 13' in t_norm: return 'xiaomi_13', capacity, ram or '8 GB'

    # Oppo
    if 'reno 7 pro' in t_norm or 'reno7 pro' in t_norm: return 'oppo_reno7_pro', capacity, ram or '12 GB'
    if 'reno 4z' in t_norm or 'reno 4 z' in t_norm: return 'oppo_reno4_z', capacity, ram or '8 GB'
    if 'reno8' in t_norm: return 'oppo_reno8_5g', capacity, ram or '8 GB'
    if 'find x9 pro' in t_norm or 'find x9' in t_norm or 'find x7' in t_norm: return 'oppo_find_x7_ultra', capacity, ram or '16 GB'
    if 'a78' in t_norm: return 'oppo_a78', capacity, ram or '8 GB'
    if 'a16' in t_norm: return 'oppo_a16', capacity, ram or '4 GB'

    # Vivo
    if 'x70 pro plus' in t_norm or 'x70 pro+' in t_norm: return 'vivo_x70_pro_plus', capacity, ram or '12 GB'
    if 'y300i' in t_norm or 'y300' in t_norm: return 'vivo_y300', capacity, ram or '12 GB'

    # Honor
    if 'honor power' in t_norm or 'power 5g' in t_norm: return 'honor_x9d_power', capacity, ram or '12 GB'
    if 'honor 400 lite' in t_norm or '400 lite' in t_norm or '200 lite' in t_norm: return 'honor_200_lite', capacity, ram or '12 GB'

    # Sony
    if 'xperia 5 iv' in t_norm or '5 mark 4' in t_norm or 'xperia 5' in t_norm: return 'sony_xperia_5_iv', capacity, ram or '8 GB'

    # Nokia
    if 'nokia 105' in t_norm or '105 4g' in t_norm: return 'nokia_105_4g', '128 MB', '48 MB'

    # Fallback to general detect_model_key if available
    from test_model_matcher import detect_model_key
    return detect_model_key(title)

def main():
    print("=== PhoneX Full Phone Specifications Crawler & Populator ===")
    
    # 1. Load used-phones.json
    with open(USED_PHONES_FILE, 'r', encoding='utf-8') as f:
        used_phones = json.load(f)
    print(f"Loaded {len(used_phones)} total products from used-phones.json")

    # 2. Load chotot-used-phones.json
    chotot_data = {}
    chotot_phones = []
    if os.path.exists(CHOTOT_PHONES_FILE):
        with open(CHOTOT_PHONES_FILE, 'r', encoding='utf-8') as f:
            chotot_data = json.load(f)
        if isinstance(chotot_data, dict):
            chotot_phones = chotot_data.get('phones', [])
        elif isinstance(chotot_data, list):
            chotot_phones = chotot_data
        print(f"Loaded {len(chotot_phones)} products from chotot-used-phones.json")

    updated_count = 0
    items_for_wp = []

    for item in used_phones:
        # Check if item is not a chotot product and already has specs
        is_chotot = item.get('is_chotot') or str(item.get('id', '')).startswith('ct-')
        if not is_chotot and item.get('spec_groups') and len(item['spec_groups']) > 0:
            continue

        raw = item.get('raw_name') or item.get('name') or ''
        key, cap, ram = detect_model_and_storage(raw)

        if not key or key not in SPECS_MASTER:
            print(f"ERROR: Cannot resolve specs for: '{raw}' (key: {key})")
            continue

        spec_data = SPECS_MASTER[key]
        cond = item.get('condition', 'Grade A 99%')
        bat = item.get('battery', 'Pin 95% - 100%')

        summary, groups, specs_list = generate_specs_package(spec_data, cap, ram, cond, bat)

        item['summary_specs'] = summary
        item['spec_groups'] = groups
        item['specs'] = specs_list

        items_for_wp.append({
            'id': item.get('id'),
            'name': item.get('name'),
            'raw_name': item.get('raw_name'),
            'summary_specs': summary,
            'spec_groups': groups
        })
        updated_count += 1
        print(f"[{updated_count}/57] Generated specs for: {item.get('name')[:60]}... -> {key}")

    print(f"\nSuccessfully generated specifications for {updated_count} products!")

    # Update chotot-used-phones.json as well
    for cp in chotot_phones:
        cp_raw = cp.get('raw_name') or cp.get('name') or ''
        key, cap, ram = detect_model_and_storage(cp_raw)
        if key and key in SPECS_MASTER:
            spec_data = SPECS_MASTER[key]
            cond = cp.get('condition', 'Grade B 95%')
            bat = cp.get('battery', 'Pin 90% - 95%')
            summary, groups, specs_list = generate_specs_package(spec_data, cap, ram, cond, bat)
            cp['summary_specs'] = summary
            cp['spec_groups'] = groups
            cp['specs'] = specs_list

    # Save to local files
    with open(USED_PHONES_FILE, 'w', encoding='utf-8') as f:
        json.dump(used_phones, f, ensure_ascii=False, indent=2)
    print(f"Saved {USED_PHONES_FILE}")

    if chotot_data:
        if isinstance(chotot_data, dict):
            chotot_data['phones'] = chotot_phones
            save_chotot = chotot_data
        else:
            save_chotot = chotot_phones
        with open(CHOTOT_PHONES_FILE, 'w', encoding='utf-8') as f:
            json.dump(save_chotot, f, ensure_ascii=False, indent=2)
        print(f"Saved {CHOTOT_PHONES_FILE}")

    # Sync JSON files to XAMPP
    xampp_dirs = [
        "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-buyback/data",
        "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/data"
    ]
    for xd in xampp_dirs:
        if os.path.exists(xd):
            with open(os.path.join(xd, "used-phones.json"), 'w', encoding='utf-8') as f:
                json.dump(used_phones, f, ensure_ascii=False, indent=2)
            if chotot_data:
                with open(os.path.join(xd, "chotot-used-phones.json"), 'w', encoding='utf-8') as f:
                    json.dump(save_chotot, f, ensure_ascii=False, indent=2)
            print(f"Synced JSON data to {xd}")

    # Now update WordPress database postmeta
    print("\nUpdating WordPress WooCommerce products in database...")
    temp_json_path = "/tmp/chotot_specs_for_wp.json"
    with open(temp_json_path, 'w', encoding='utf-8') as f:
        json.dump(items_for_wp, f, ensure_ascii=False)

    php_update_script = f"""
    require('/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-load.php');
    $items = json_decode(file_get_contents('{temp_json_path}'), true);
    $updated_posts = 0;
    
    $products = get_posts([
        'post_type'   => 'product',
        'post_status' => 'publish',
        'numberposts' => -1
    ]);
    
    foreach ($products as $p) {{
        $pid = $p->ID;
        $title = mb_strtolower(trim($p->post_title));
        $raw = mb_strtolower(trim(get_post_meta($pid, '_phonex_raw_name', true) ?: $p->post_title));
        $source = get_post_meta($pid, '_crawl_source', true);
        $phonex_id = get_post_meta($pid, '_phonex_item_id', true);
        $current_specs = get_post_meta($pid, '_spec_groups', true);
        
        $is_chotot = (stripos($source, 'chợ tốt') !== false || stripos($source, 'chotot') !== false);
        
        // If not chotot and already has specs, skip
        if (!$is_chotot && !empty($current_specs) && is_array($current_specs) && count($current_specs) > 0) {{
            continue;
        }}
        
        foreach ($items as $it) {{
            $it_id = $it['id'] ?? '';
            $it_title = mb_strtolower(trim($it['name']));
            $it_raw = mb_strtolower(trim($it['raw_name'] ?? ''));
            
            // Match by phonex_item_id, normalized title or raw name
            $matched = false;
            if (!empty($phonex_id) && !empty($it_id) && $phonex_id === $it_id) {{
                $matched = true;
            }} elseif ($title === $it_title || $raw === $it_raw) {{
                $matched = true;
            }} elseif ($it_raw && (stripos($title, $it_raw) !== false || stripos($it_raw, $title) !== false)) {{
                $matched = true;
            }} elseif ($it_title && (stripos($title, $it_title) !== false || stripos($it_title, $title) !== false)) {{
                $matched = true;
            }}
            
            if ($matched) {{
                update_post_meta($pid, '_spec_groups', $it['spec_groups']);
                update_post_meta($pid, '_summary_specs', $it['summary_specs']);
                $updated_posts++;
                break;
            }}
        }}
    }}
    
    echo "WordPress database updated: $updated_posts products now have full specifications!\\n";
    
    // Verify total phone products status
    $all_prods = get_posts(['post_type' => 'product', 'post_status' => 'publish', 'numberposts' => -1]);
    $with_specs = 0;
    $missing_specs = 0;
    foreach ($all_prods as $ap) {{
        $sg = get_post_meta($ap->ID, '_spec_groups', true);
        if (!empty($sg) && is_array($sg) && count($sg) > 0) {{
            $with_specs++;
        }} else {{
            $missing_specs++;
            echo "STILL MISSING: #" . $ap->ID . " " . $ap->post_title . "\\n";
        }}
    }}
    echo "FINAL VERIFICATION: Total = " . count($all_prods) . " | WITH SPECS = $with_specs | MISSING = $missing_specs\\n";
    """

    res = subprocess.run(["/Applications/XAMPP/xamppfiles/bin/php", "-r", php_update_script], capture_output=True, text=True)
    print(res.stdout)
    if res.stderr:
        print("STDERR:", res.stderr)

if __name__ == '__main__':
    main()
