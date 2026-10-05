#!/usr/bin/env python3
"""
Generate 2 Campaign Banners (2400 x 600 px) with PhoneX Red brand theme.
SUPER-SIZED, ULTRA-PROMINENT TYPOGRAPHY & ARTIFACT-FREE 3D RENDERING:
- Banner 1: THU CŨ ĐỔI MỚI - ĐỊNH GIÁ ONLINE 30S - TRỢ GIÁ ĐẾN 3 TRIỆU
- Banner 2: KHO MÁY CŨ PHONEX - LIKE NEW 99% - BẢO HÀNH 12 THÁNG 1 ĐỔI 1 - NGUỒN SỈ ĐẠI LÝ
Preserves original PhoneX Flagship color palette:
- Red gradients: #380002 -> #6e0009 -> #ba0d1a -> #d91424
- Gold highlights: #ffd700, #ffde17, #ff9900
- Pure white containers & badges
Outputs:
- assets/images/banners/slider-banner-1-2400x600.png
- assets/images/banners/slider-banner-2-2400x600.png
- assets/images/banners/slider-banner-1-2400x480.png
- assets/images/banners/slider-banner-2-2400x480.png
"""

import os
import subprocess
import tempfile

CHROME_PATH = "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"

# ==========================================
# BANNER 1: THU CŨ ĐỔI MỚI - ĐỊNH GIÁ ONLINE (2400 x 600 px)
# ==========================================
html_banner1 = """<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900;950&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
      width: 2400px;
      height: 600px;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #380003;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 600px;
      position: relative;
      background: linear-gradient(90deg, #380002 0%, #6e0009 16%, #ba0d1a 45%, #d91424 55%, #ba0d1a 68%, #6e0009 85%, #380002 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
      padding-right: 50px;
    }

    /* Ambient lighting & glowing accents */
    .bg-light-ambient-1 {
      position: absolute;
      top: -120px;
      left: 520px;
      width: 850px;
      height: 850px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 60, 60, 0.38) 0%, rgba(255, 0, 0, 0) 70%);
      z-index: 1;
    }
    .bg-light-ambient-2 {
      position: absolute;
      top: -150px;
      right: 250px;
      width: 1000px;
      height: 900px;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.28) 0%, rgba(255, 215, 0, 0) 65%);
      z-index: 1;
    }
    .bg-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(115deg, transparent 38%, rgba(255, 255, 255, 0.08) 48%, rgba(255, 255, 255, 0.16) 50%, rgba(255, 255, 255, 0.08) 52%, transparent 62%);
      z-index: 2;
      pointer-events: none;
    }

    /* 1. LEFT WHITE PILL/CURVED PANEL */
    .left-panel {
      position: relative;
      z-index: 4;
      width: 560px;
      height: 600px;
      background: #ffffff;
      border-top-right-radius: 280px;
      border-bottom-right-radius: 280px;
      box-shadow: 25px 0 60px rgba(0, 0, 0, 0.35);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 25px 45px 25px 30px;
      text-align: center;
      flex-shrink: 0;
    }
    .panel-line-1 {
      font-size: 30px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 2px;
    }
    .panel-line-2 {
      font-size: 44px;
      font-weight: 950;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      margin-bottom: 8px;
    }
    .panel-line-3 {
      font-size: 26px;
      font-weight: 900;
      color: #334155;
      text-transform: uppercase;
      margin-bottom: 12px;
    }
    .panel-divider {
      width: 240px;
      height: 5px;
      background: #ffd000;
      border-radius: 3px;
      margin-bottom: 12px;
    }
    .panel-line-4 {
      font-size: 32px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: -0.3px;
      margin-bottom: 6px;
    }
    .panel-line-5 {
      font-size: 36px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      line-height: 1.2;
    }
    .panel-line-6 {
      font-size: 26px;
      font-weight: 950;
      color: #1e293b;
      text-transform: uppercase;
      margin-top: 6px;
      letter-spacing: 0.3px;
      white-space: nowrap;
    }

    /* 2. CENTER SECTION (BRAND + 3D TITLE + TRADE-IN EMBLEM) */
    .center-section {
      position: relative;
      z-index: 4;
      display: flex;
      align-items: center;
      gap: 20px;
      margin-left: 20px;
      flex-grow: 1;
      justify-content: center;
    }
    .title-col {
      display: flex;
      flex-direction: column;
      align-items: center;
      flex-shrink: 0;
    }
    .brand-pill {
      background: #ffffff;
      color: #111827;
      padding: 8px 30px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      margin-bottom: 14px;
      border: 2px solid rgba(255, 255, 255, 0.85);
    }
    .brand-logo-icon {
      width: 36px;
      height: 36px;
      background: #ba0d1a;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: 950;
      color: #fff;
    }
    .brand-name {
      font-size: 28px;
      font-weight: 950;
      letter-spacing: -0.5px;
      color: #111827;
    }
    .brand-name span {
      color: #ba0d1a;
    }
    .brand-tagline {
      font-size: 22px;
      font-weight: 800;
      color: #475569;
      border-left: 2px solid #cbd5e1;
      padding-left: 10px;
    }

    .title-thu-cu {
      font-size: 80px;
      font-weight: 950;
      color: #ffffff;
      text-transform: uppercase;
      letter-spacing: -1.5px;
      line-height: 1;
      white-space: nowrap;
      paint-order: stroke fill;
      -webkit-text-stroke: 7px #ffb700;
      text-shadow: 0 4px 0 #b37400, 0 8px 0 #2a0003, 0 14px 28px rgba(0, 0, 0, 0.85);
    }
    .title-tro-gia {
      font-size: 112px;
      font-weight: 950;
      color: #ffde17;
      text-transform: uppercase;
      letter-spacing: -2.5px;
      line-height: 1;
      white-space: nowrap;
      paint-order: stroke fill;
      -webkit-text-stroke: 9px #2a0003;
      text-shadow: 0 5px 0 #d97706, 0 9px 0 #78350f, 0 16px 30px rgba(0, 0, 0, 0.9);
      position: relative;
      margin-top: 4px;
    }
    .crown-icon {
      position: absolute;
      top: -36px;
      left: 6px;
      width: 52px;
      height: 52px;
      fill: #ffd700;
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.6));
    }

    /* Inspection & Trade-in Emblem Vector Graphic */
    .tradein-graphic-box {
      width: 200px;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      flex-shrink: 0;
    }
    .tradein-svg {
      width: 100%;
      height: 100%;
      filter: drop-shadow(0 14px 28px rgba(0,0,0,0.5));
    }

    /* 3. RIGHT SECTION (DISCOUNT + DEVICES SHOWCASE + ACTION BUTTON) */
    .right-section {
      position: relative;
      z-index: 4;
      width: 580px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .top-promo-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 14px;
      white-space: nowrap;
      margin-bottom: 8px;
    }
    .promo-subtext {
      font-size: 28px;
      font-weight: 950;
      color: #ffffff;
      line-height: 1.15;
      text-align: right;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
    }
    .promo-subtext span {
      display: block;
      font-size: 26px;
      font-weight: 950;
      color: #ffeb3b;
    }
    .promo-giant-num {
      font-size: 96px;
      font-weight: 950;
      color: #ffd700;
      line-height: 1;
      letter-spacing: -2px;
      white-space: nowrap;
      paint-order: stroke fill;
      -webkit-text-stroke: 8px #2a0003;
      text-shadow: 0 5px 0 #b45309, 0 14px 28px rgba(0, 0, 0, 0.85);
      display: inline-flex;
      align-items: center;
    }
    .lightning-speed {
      width: 42px;
      height: 42px;
      fill: #ffd700;
      filter: drop-shadow(0 4px 10px rgba(0,0,0,0.5));
      margin-left: 6px;
    }

    /* Showcase phones */
    .devices-row {
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 16px;
      margin-top: 2px;
      margin-bottom: 16px;
      position: relative;
    }
    .device-item {
      position: relative;
      filter: drop-shadow(0 16px 28px rgba(0, 0, 0, 0.55));
    }
    .device-phone-1 {
      width: 115px;
      height: 155px;
      transform: rotate(-6deg);
    }
    .device-phone-2 {
      width: 135px;
      height: 180px;
      z-index: 2;
    }
    .device-phone-3 {
      width: 115px;
      height: 155px;
      transform: rotate(6deg);
    }

    /* Quality Stamp Tag */
    .grade-stamp {
      position: absolute;
      top: -15px;
      right: -20px;
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #ffffff;
      padding: 5px 13px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 950;
      letter-spacing: 0.5px;
      box-shadow: 0 8px 18px rgba(0,0,0,0.45);
      border: 2px solid #ffffff;
      z-index: 10;
      display: flex;
      align-items: center;
      gap: 5px;
      transform: rotate(4deg);
    }

    /* Định Giá Ngay Button */
    .btn-action-buy {
      background: linear-gradient(180deg, #fff7a0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      color: #380003;
      font-size: 32px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 12px 52px;
      border-radius: 9999px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(255, 255, 255, 0.9);
      display: inline-flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      border: 3px solid #fff59d;
      white-space: nowrap;
    }
  </style>
</head>
<body>
  <div class="banner">
    <div class="bg-light-ambient-1"></div>
    <div class="bg-light-ambient-2"></div>
    <div class="bg-shine"></div>

    <!-- 1. LEFT PANEL -->
    <div class="left-panel">
      <div class="panel-line-1">HỆ THỐNG THU CŨ ĐỔI MỚI</div>
      <div class="panel-line-2">ĐỊNH GIÁ ONLINE 30S</div>
      <div class="panel-line-3">TRỢ GIÁ LÊN ĐỜI ĐẾN 3 TRIỆU</div>
      <div class="panel-divider"></div>
      <div class="panel-line-4">KIỂM ĐỊNH 30 BƯỚC CÔNG KHAI</div>
      <div class="panel-line-5">PHÂN GRADE A/B/C/D CHUẨN</div>
      <div class="panel-line-6">CHUYỂN KHOẢN NGAY 5 PHÚT</div>
    </div>

    <!-- 2. CENTER SECTION -->
    <div class="center-section">
      <div class="title-col">
        <div class="brand-pill">
          <div class="brand-logo-icon">&#x26A1;</div>
          <div class="brand-name">Phone<span>X</span></div>
          <div class="brand-tagline">Thu Cũ Giá Cao</div>
        </div>

        <div class="title-thu-cu">THU CŨ ĐỔI MỚI</div>
        <div class="title-tro-gia">
          <svg class="crown-icon" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5m14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
          TRỢ GIÁ ĐẾN 3TR
        </div>
      </div>

      <!-- Trade-In & Inspection Vector Emblem -->
      <div class="tradein-graphic-box">
        <svg class="tradein-svg" viewBox="0 0 220 340" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Circular Glow Orbit -->
          <circle cx="110" cy="160" r="95" stroke="rgba(255, 215, 0, 0.4)" stroke-width="3" stroke-dasharray="6 6"/>
          <circle cx="110" cy="160" r="88" fill="rgba(186, 13, 26, 0.35)"/>
          
          <!-- Old Phone (Left, darker, entering trade-in) -->
          <g transform="translate(35, 75) rotate(-14)">
            <rect x="0" y="0" width="65" height="115" rx="12" fill="#1e293b" stroke="#64748b" stroke-width="2.5"/>
            <rect x="4" y="5" width="57" height="105" rx="9" fill="#0f172a"/>
            <!-- screen content -->
            <rect x="15" y="8" width="26" height="5" rx="2.5" fill="#334155"/>
            <text x="28" y="60" font-size="12" fill="#94a3b8" font-family="'Plus Jakarta Sans', sans-serif" font-weight="900" text-anchor="middle">MÁY CŨ</text>
            <circle cx="28" cy="80" r="9" fill="#ba0d1a" opacity="0.8"/>
            <path d="M24 80 L32 80" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
          </g>

          <!-- Exchange Curved Arrows (Gold) -->
          <g transform="translate(110, 160)">
            <circle cx="0" cy="0" r="35" fill="#ffd700" stroke="#fff" stroke-width="3" filter="drop-shadow(0 6px 12px rgba(0,0,0,0.5))"/>
            <!-- Trade-in Refresh arrows -->
            <path d="M-12 -5 C-9 -17, 9 -17, 14 -7" stroke="#380003" stroke-width="4.5" stroke-linecap="round" fill="none"/>
            <polygon points="9,-14 18,-7 18,-18" fill="#380003"/>
            <path d="M12 5 C9 17, -9 17, -14 7" stroke="#380003" stroke-width="4.5" stroke-linecap="round" fill="none"/>
            <polygon points="-9,14 -18,7 -18,18" fill="#380003"/>
          </g>

          <!-- New Flagship Phone (Right, glowing gold/cyan, upgraded) -->
          <g transform="translate(120, 90) rotate(12)">
            <rect x="0" y="0" width="70" height="126" rx="14" fill="#09090b" stroke="#ffd700" stroke-width="3"/>
            <rect x="4" y="5" width="62" height="116" rx="10" fill="url(#newScreenGrad)"/>
            <rect x="20" y="8" width="30" height="6" rx="3" fill="#000"/>
            <!-- Checkmark badge on new phone -->
            <circle cx="35" cy="62" r="14" fill="#10b981"/>
            <path d="M29 62 L33 66 L42 57" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <text x="35" y="90" font-size="11" fill="#ffd700" font-family="'Plus Jakarta Sans', sans-serif" font-weight="950" text-anchor="middle">LÊN ĐỜI</text>
          </g>

          <!-- Inspection Guarantee Ribbon -->
          <g transform="translate(110, 280)">
            <rect x="-85" y="-16" width="170" height="32" rx="16" fill="#ffffff" stroke="#ffd700" stroke-width="2" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.4))"/>
            <text x="0" y="5" font-size="14" fill="#ba0d1a" font-family="'Plus Jakarta Sans', sans-serif" font-weight="950" text-anchor="middle" letter-spacing="0.5">30 BƯỚC TEST MINH BẠCH</text>
          </g>

          <defs>
            <linearGradient id="newScreenGrad" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#0284c7"/>
              <stop offset="50%" stop-color="#6366f1"/>
              <stop offset="100%" stop-color="#ec4899"/>
            </linearGradient>
          </defs>
        </svg>
      </div>
    </div>

    <!-- 3. RIGHT SECTION: DISCOUNT + SMARTPHONE SHOWCASE + ACTION BUTTON -->
    <div class="right-section">
      <div class="top-promo-header">
        <div class="promo-subtext">
          Thu Mua Mọi Tình Trạng
          <span>GIẢI NGÂN CHUYỂN KHOẢN</span>
        </div>
        <div class="promo-giant-num">
          5 PHÚT
          <svg class="lightning-speed" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
        </div>
      </div>

      <!-- Smartphone Showcase Trio -->
      <div class="devices-row">
        <div class="grade-stamp">&#x2714; GRADE A LIKE NEW</div>
        <!-- Phone 1: Galaxy S24 Ultra -->
        <div class="device-item device-phone-1">
          <svg viewBox="0 0 140 185" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="6" width="128" height="173" rx="16" fill="#2b2d30" stroke="#71717a" stroke-width="4"/>
            <rect x="12" y="12" width="116" height="161" rx="12" fill="#090d16"/>
            <path d="M12 12 Q70 100 128 173 L12 173 Z" fill="url(#grad1)"/>
            <circle cx="70" cy="18" r="3.5" fill="#000"/>
            <defs>
              <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#3b82f6"/>
                <stop offset="50%" stop-color="#8b5cf6"/>
                <stop offset="100%" stop-color="#ec4899"/>
              </linearGradient>
            </defs>
          </svg>
        </div>

        <!-- Phone 2: iPhone 16 Pro Max Center -->
        <div class="device-item device-phone-2">
          <svg viewBox="0 0 150 205" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="5" width="140" height="195" rx="24" fill="#18181b" stroke="#e4e4e7" stroke-width="3"/>
            <rect x="10" y="10" width="130" height="185" rx="20" fill="#09090b"/>
            <rect x="56" y="15" width="38" height="11" rx="5.5" fill="#000"/>
            <circle cx="75" cy="120" r="55" fill="url(#grad2)"/>
            <defs>
              <linearGradient id="grad2" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#ff7e5f"/>
                <stop offset="100%" stop-color="#feb47b"/>
              </linearGradient>
            </defs>
          </svg>
        </div>

        <!-- Phone 3: Galaxy Flip/Fold -->
        <div class="device-item device-phone-3">
          <svg viewBox="0 0 140 185" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="6" width="128" height="173" rx="16" fill="#1e293b" stroke="#64748b" stroke-width="4"/>
            <rect x="12" y="12" width="116" height="161" rx="12" fill="#020617"/>
            <path d="M12 173 Q70 50 128 12 L128 173 Z" fill="url(#grad3)"/>
            <circle cx="70" cy="18" r="3.5" fill="#000"/>
            <defs>
              <linearGradient id="grad3" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#10b981"/>
                <stop offset="50%" stop-color="#06b6d4"/>
                <stop offset="100%" stop-color="#3b82f6"/>
              </linearGradient>
            </defs>
          </svg>
        </div>
      </div>

      <!-- Action Button -->
      <div class="btn-action-buy">
        <span>ĐỊNH GIÁ NGAY</span>
        <svg style="width:26px;height:26px;fill:#380003;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

# ==========================================
# BANNER 2: KHO MÁY CŨ PHONEX - LIKE NEW 99% (2400 x 600 px)
# ==========================================
html_banner2 = """<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900;950&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
      width: 2400px;
      height: 600px;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #380003;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 600px;
      position: relative;
      background: linear-gradient(90deg, #380002 0%, #6e0009 16%, #ba0d1a 45%, #d91424 55%, #ba0d1a 68%, #6e0009 85%, #380002 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 50px;
      overflow: hidden;
    }

    /* Ambient lighting & glowing accents */
    .moon-glow {
      position: absolute;
      top: -120px;
      right: 200px;
      width: 800px;
      height: 800px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.28) 0%, rgba(255, 215, 0, 0) 70%);
      z-index: 1;
    }
    .festive-glow-left {
      position: absolute;
      top: -120px;
      left: 120px;
      width: 800px;
      height: 800px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 60, 60, 0.35) 0%, rgba(255, 0, 0, 0) 70%);
      z-index: 1;
    }
    .bg-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(115deg, transparent 38%, rgba(255, 255, 255, 0.08) 48%, rgba(255, 255, 255, 0.16) 50%, rgba(255, 255, 255, 0.08) 52%, transparent 62%);
      z-index: 2;
      pointer-events: none;
    }

    /* 1. LEFT TITLE: KHO MÁY CŨ - LIKE NEW 99% */
    .left-title-box {
      position: relative;
      z-index: 4;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin-left: 10px;
      flex-shrink: 0;
    }
    .title-pha-co {
      font-size: 102px;
      font-weight: 950;
      color: #ffffff;
      text-transform: uppercase;
      letter-spacing: -2px;
      line-height: 0.95;
      white-space: nowrap;
      paint-order: stroke fill;
      -webkit-text-stroke: 7px #ffd700;
      text-shadow: 0 5px 0 #b38600, 0 8px 0 #2b0003, 0 14px 26px rgba(0, 0, 0, 0.85);
    }
    .title-tung-deal {
      font-size: 136px;
      font-weight: 950;
      color: #ffde17;
      text-transform: uppercase;
      letter-spacing: -3.5px;
      line-height: 0.95;
      white-space: nowrap;
      paint-order: stroke fill;
      -webkit-text-stroke: 9px #2a0003;
      text-shadow: 0 5px 0 #d97706, 0 9px 0 #78350f, 0 16px 32px rgba(0, 0, 0, 0.9);
      margin-top: 4px;
      margin-bottom: 18px;
    }
    .ribbon-dates {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      background: #ffffff;
      border: 3.5px solid #ffd700;
      border-radius: 9999px;
      padding: 9px 28px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
    }
    .ribbon-icon {
      font-size: 28px;
    }
    .ribbon-text-1 {
      font-size: 28px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .ribbon-text-2 {
      font-size: 26px;
      font-weight: 900;
      color: #1e293b;
    }

    /* 2. CENTER WHITE PROMO CARD (Super Sized) */
    .center-card {
      position: relative;
      z-index: 4;
      width: 900px;
      background: #ffffff;
      border-radius: 36px;
      padding: 20px 34px;
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.45);
      display: flex;
      flex-direction: column;
      align-items: center;
      border: 3.5px solid rgba(255, 255, 255, 0.95);
      flex-shrink: 0;
    }
    .card-top-title {
      font-size: 30px;
      font-weight: 950;
      color: #ba0d1a;
      text-align: center;
      margin-bottom: 2px;
      letter-spacing: -0.3px;
      white-space: nowrap;
    }
    .card-sub-head {
      font-size: 34px;
      font-weight: 950;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      white-space: nowrap;
    }
    .card-big-price {
      font-size: 84px;
      font-weight: 950;
      color: #ba0d1a;
      line-height: 1;
      letter-spacing: -2px;
      margin: 2px 0 4px 0;
      text-shadow: 0 4px 12px rgba(186, 13, 26, 0.15);
      white-space: nowrap;
    }
    .card-note {
      font-size: 24px;
      font-weight: 800;
      color: #475569;
      margin-bottom: 10px;
      white-space: nowrap;
    }
    .card-bottom-divider {
      width: 100%;
      height: 1px;
      border-top: 2.5px dashed #cbd5e1;
      margin-bottom: 10px;
    }
    .card-bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      width: 100%;
      text-align: center;
    }
    .col-left {
      padding-right: 22px;
      border-right: 2.5px dashed #cbd5e1;
    }
    .col-right {
      padding-left: 22px;
    }
    .col-title {
      font-size: 25px;
      font-weight: 900;
      color: #0f172a;
      margin-bottom: 2px;
    }
    .col-highlight {
      font-size: 34px;
      font-weight: 950;
      color: #ba0d1a;
      line-height: 1.2;
    }
    .col-note {
      font-size: 22px;
      font-weight: 800;
      color: #475569;
      margin-top: 2px;
      line-height: 1.25;
    }

    /* 3. RIGHT SECTION (DEVICE ECOSYSTEM & BUY BUTTON) */
    .right-section {
      position: relative;
      z-index: 4;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 15px;
      flex-shrink: 0;
    }
    .ecosystem-group {
      position: relative;
      width: 380px;
      height: 240px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
    }
    .eco-tablet {
      position: absolute;
      left: 15px;
      top: 10px;
      width: 250px;
      height: 185px;
      border-radius: 16px;
      background: #0f172a;
      border: 3.5px solid #475569;
      box-shadow: 0 18px 36px rgba(0, 0, 0, 0.55);
      overflow: hidden;
    }
    .eco-phone {
      position: absolute;
      left: 125px;
      top: 15px;
      width: 115px;
      height: 200px;
      border-radius: 20px;
      background: #09090b;
      border: 3.5px solid #ffd700;
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.65);
      z-index: 2;
      overflow: hidden;
    }
    .eco-phone-screen {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #0f172a 0%, #ba0d1a 50%, #f59e0b 100%);
    }
    .eco-badge-stock {
      position: absolute;
      right: -10px;
      bottom: 15px;
      background: #198754;
      color: #ffffff;
      padding: 7px 16px;
      border-radius: 9999px;
      font-size: 17px;
      font-weight: 950;
      letter-spacing: 0.5px;
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.45);
      border: 2px solid #ffffff;
      z-index: 4;
      display: flex;
      align-items: center;
      gap: 7px;
      white-space: nowrap;
    }

    .btn-action-buy {
      background: linear-gradient(180deg, #fff7a0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      color: #380003;
      font-size: 32px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 12px 46px;
      border-radius: 9999px;
      box-shadow: 0 14px 35px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(255, 255, 255, 0.9);
      display: inline-flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      border: 3px solid #fff59d;
      white-space: nowrap;
    }
  </style>
</head>
<body>
  <div class="banner">
    <div class="festive-glow-left"></div>
    <div class="moon-glow"></div>
    <div class="bg-shine"></div>

    <!-- 1. LEFT TITLE: KHO MÁY CŨ - LIKE NEW 99% -->
    <div class="left-title-box">
      <div class="title-pha-co">KHO MÁY CŨ</div>
      <div class="title-tung-deal">LIKE NEW 99%</div>
      <div class="ribbon-dates">
        <span class="ribbon-icon">&#x1F48E;</span>
        <span class="ribbon-text-1">ZIN NGUYÊN BẢN</span>
        <span class="ribbon-text-2">Bảo Hành 12 Tháng 1 Đổi 1</span>
      </div>
    </div>

    <!-- 2. CENTER WHITE PROMO CARD -->
    <div class="center-card">
      <div class="card-top-title">TUYỂN CHỌN 313+ MODEL ZIN KENG</div>
      <div class="card-sub-head">PHÂN GRADE MINH BẠCH - GIÁ TỐT NHẤT</div>
      <div class="card-big-price">TIẾT KIỆM ĐẾN 50%</div>
      <div class="card-note">Trải nghiệm trực tiếp tại 128 Showroom toàn quốc</div>

      <div class="card-bottom-divider"></div>

      <div class="card-bottom-grid">
        <div class="col-left">
          <div class="col-title">Dành Cho Khách Lẻ</div>
          <div class="col-highlight">Bảo Hành 1 Đổi 1</div>
          <div class="col-note">Tặng sạc nhanh 67W + Cường lực</div>
        </div>
        <div class="col-right">
          <div class="col-title">Nguồn Sỉ Đại Lý</div>
          <div class="col-highlight">Chiết Khấu Đến 20%</div>
          <div class="col-note">Bao test 30 ngày • Bảng giá theo ngày</div>
        </div>
      </div>
    </div>

    <!-- 3. RIGHT SECTION: ECOSYSTEM + BUY BUTTON -->
    <div class="right-section">
      <div class="ecosystem-group">
        <div class="eco-tablet">
          <div style="width:100%;height:100%;background:linear-gradient(45deg,#020617,#1e293b);display:flex;align-items:center;justify-content:center;">
            <svg style="width:50px;height:50px;fill:rgba(255,255,255,0.25);" viewBox="0 0 24 24"><path d="M17 1H7c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 18H7V5h10v14z"/></svg>
          </div>
        </div>
        <div class="eco-phone">
          <div class="eco-phone-screen"></div>
        </div>
        <div class="eco-badge-stock">
          <svg style="width:20px;height:20px;fill:#fff;" viewBox="0 0 24 24"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
          <span>SẴN HÀNG TẠI SHOWROOM</span>
        </div>
      </div>

      <div class="btn-action-buy">
        <span>XEM KHO MÁY CŨ</span>
        <svg style="width:26px;height:26px;fill:#380003;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

def render_html_to_png(html_content, output_png):
    with tempfile.NamedTemporaryFile("w", suffix=".html", delete=False) as f:
        f.write(html_content)
        temp_html = f.name

    try:
        cmd = [
            CHROME_PATH,
            "--headless=new",
            "--disable-gpu",
            "--hide-scrollbars",
            "--window-size=2400,600",
            f"--screenshot={output_png}",
            f"file://{temp_html}"
        ]
        subprocess.run(cmd, check=True)
    finally:
        if os.path.exists(temp_html):
            os.remove(temp_html)

if __name__ == "__main__":
    banner1_path = "assets/images/banners/slider-banner-1-2400x600.png"
    banner2_path = "assets/images/banners/slider-banner-2-2400x600.png"
    wp_banner1 = "phonex-theme/assets/images/banners/slider-banner-1-2400x600.png"
    wp_banner2 = "phonex-theme/assets/images/banners/slider-banner-2-2400x600.png"
    xampp_banner1 = "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/assets/images/banners/slider-banner-1-2400x600.png"
    xampp_banner2 = "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/assets/images/banners/slider-banner-2-2400x600.png"

    os.makedirs(os.path.dirname(banner1_path), exist_ok=True)
    os.makedirs(os.path.dirname(wp_banner1), exist_ok=True)

    print("Render Banner 1: THU CŨ ĐỔI MỚI (Super-sized)...")
    render_html_to_png(html_banner1, banner1_path)
    subprocess.run(["cp", banner1_path, wp_banner1], check=True)
    subprocess.run(["cp", banner1_path, "assets/images/banners/slider-banner-1-2400x480.png"], check=True)
    subprocess.run(["cp", banner1_path, "phonex-theme/assets/images/banners/slider-banner-1-2400x480.png"], check=True)
    if os.path.exists(os.path.dirname(xampp_banner1)):
        subprocess.run(["cp", banner1_path, xampp_banner1], check=True)
        subprocess.run(["cp", banner1_path, "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/assets/images/banners/slider-banner-1-2400x480.png"], check=True)

    print("Render Banner 2: KHO MÁY CŨ PHONEX (Super-sized)...")
    render_html_to_png(html_banner2, banner2_path)
    subprocess.run(["cp", banner2_path, wp_banner2], check=True)
    subprocess.run(["cp", banner2_path, "assets/images/banners/slider-banner-2-2400x480.png"], check=True)
    subprocess.run(["cp", banner2_path, "phonex-theme/assets/images/banners/slider-banner-2-2400x480.png"], check=True)
    if os.path.exists(os.path.dirname(xampp_banner2)):
        subprocess.run(["cp", banner2_path, xampp_banner2], check=True)
        subprocess.run(["cp", banner2_path, "/Applications/XAMPP/xamppfiles/htdocs/smartphone/wp-content/themes/phonex-theme/assets/images/banners/slider-banner-2-2400x480.png"], check=True)

    print(f"Đã lưu Banner 1: {banner1_path} ({os.path.getsize(banner1_path)} bytes)")
    print(f"Đã lưu Banner 2: {banner2_path} ({os.path.getsize(banner2_path)} bytes)")
