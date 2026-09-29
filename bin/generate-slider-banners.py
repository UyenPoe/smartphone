#!/usr/bin/env python3
"""
Generate 2 Campaign Banners (2400 x 480 px) with PhoneX Red brand theme.
All small text enlarged for crystal-clear readability across all screens.
Exact dimensions: 2400x480 (5:1 aspect ratio).
Outputs:
- assets/images/banners/slider-banner-1-2400x480.png
- assets/images/banners/slider-banner-2-2400x480.png
"""

import os
import subprocess
import tempfile

CHROME_PATH = "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"

# ==========================================
# BANNER 1: TỰU TRƯỜNG DEAL THƠMMM (PhoneX Red)
# ==========================================
html_banner1 = """<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
      width: 2400px;
      height: 480px;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #580005;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 480px;
      position: relative;
      background: linear-gradient(90deg, #4d0004 0%, #7d000a 16%, #ba0d1a 45%, #cf1322 55%, #ba0d1a 68%, #7d000a 85%, #4d0004 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
    }

    /* Ambient lighting & glowing accents */
    .bg-light-ambient-1 {
      position: absolute;
      top: -100px;
      left: 450px;
      width: 700px;
      height: 700px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 60, 60, 0.3) 0%, rgba(255, 0, 0, 0) 70%);
      z-index: 1;
    }
    .bg-light-ambient-2 {
      position: absolute;
      top: -120px;
      right: 220px;
      width: 850px;
      height: 720px;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.22) 0%, rgba(255, 215, 0, 0) 65%);
      z-index: 1;
    }
    .bg-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(115deg, transparent 40%, rgba(255, 255, 255, 0.06) 48%, rgba(255, 255, 255, 0.12) 50%, rgba(255, 255, 255, 0.06) 52%, transparent 60%);
      z-index: 2;
      pointer-events: none;
    }

    /* 1. LEFT WHITE PILL/CURVED PANEL */
    .left-panel {
      position: relative;
      z-index: 4;
      width: 560px;
      height: 480px;
      background: #ffffff;
      border-top-right-radius: 240px;
      border-bottom-right-radius: 240px;
      box-shadow: 20px 0 45px rgba(0, 0, 0, 0.28);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 24px 50px 24px 36px;
      text-align: center;
    }
    .panel-line-1 {
      font-size: 32px;
      font-weight: 900;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: -0.3px;
      margin-bottom: 2px;
    }
    .panel-line-2 {
      font-size: 36px;
      font-weight: 950;
      color: #111827;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      margin-bottom: 12px;
    }
    .panel-line-3 {
      font-size: 28px;
      font-weight: 900;
      color: #ba0d1a;
      text-transform: uppercase;
      margin-bottom: 2px;
    }
    .panel-line-4 {
      font-size: 30px;
      font-weight: 850;
      color: #1f2937;
      margin-bottom: 12px;
    }
    .panel-divider {
      width: 220px;
      height: 4px;
      background: #ffd000;
      border-radius: 2px;
      margin-bottom: 12px;
    }
    .panel-line-5 {
      font-size: 34px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: -0.3px;
    }
    .panel-line-6 {
      font-size: 30px;
      font-weight: 850;
      color: #1f2937;
      margin-bottom: 12px;
    }
    .panel-line-7 {
      font-size: 32px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      line-height: 1.2;
    }
    .panel-line-8 {
      font-size: 27px;
      font-weight: 950;
      color: #374151;
      text-transform: uppercase;
      margin-top: 4px;
      letter-spacing: 0.5px;
    }

    /* 2. CENTER SECTION (BRAND + 3D TITLE + CHARACTER) */
    .center-section {
      position: relative;
      z-index: 4;
      display: flex;
      align-items: center;
      gap: 25px;
      margin-left: 10px;
    }
    .title-col {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .brand-pill {
      background: #ffffff;
      color: #111827;
      padding: 10px 32px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
      margin-bottom: 14px;
      border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .brand-logo-icon {
      width: 36px;
      height: 36px;
      background: #ba0d1a;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      font-weight: 900;
      color: #fff;
    }
    .brand-name {
      font-size: 30px;
      font-weight: 900;
      letter-spacing: -0.5px;
      color: #111827;
    }
    .brand-name span {
      color: #ba0d1a;
    }

    .title-tuu-truong {
      font-size: 68px;
      font-weight: 950;
      color: #ffffff;
      text-transform: uppercase;
      letter-spacing: -1.2px;
      line-height: 1;
      -webkit-text-stroke: 1.5px #ffd700;
      text-shadow: 0 6px 14px rgba(0, 0, 0, 0.6);
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
    }
    .title-deal-thom {
      font-size: 96px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: -2px;
      line-height: 1;
      background: linear-gradient(180deg, #fffdf0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      -webkit-text-stroke: 3.5px #4d0004;
      filter: drop-shadow(0 10px 16px rgba(0, 0, 0, 0.7));
      position: relative;
      margin-top: -6px;
    }
    .crown-icon {
      position: absolute;
      top: -32px;
      left: 10px;
      width: 48px;
      height: 48px;
      fill: #ffd700;
      filter: drop-shadow(0 3px 6px rgba(0,0,0,0.5));
    }

    /* Student Illustration */
    .student-img-box {
      width: 250px;
      height: 440px;
      display: flex;
      align-items: flex-end;
      position: relative;
    }
    .student-svg {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 10px 20px rgba(0,0,0,0.35));
    }

    /* 3. RIGHT SECTION (DISCOUNT + DEVICES SHOWCASE + BUY BUTTON) */
    .right-section {
      position: relative;
      z-index: 4;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 90px;
    }
    .top-promo-header {
      display: flex;
      align-items: baseline;
      gap: 16px;
      margin-bottom: 8px;
    }
    .promo-subtext {
      font-size: 38px;
      font-weight: 950;
      color: #ffffff;
      line-height: 1.15;
      text-align: right;
      text-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
    }
    .promo-subtext span {
      display: block;
      font-size: 32px;
      font-weight: 900;
      color: #ffeb3b;
    }
    .promo-giant-num {
      font-size: 106px;
      font-weight: 950;
      color: #ffd700;
      line-height: 0.9;
      letter-spacing: -3px;
      text-shadow: 3px 4px 0 #4d0004, 0 8px 25px rgba(255, 215, 0, 0.45);
      display: flex;
      align-items: baseline;
    }
    .grad-cap {
      width: 48px;
      height: 48px;
      fill: #ffd700;
      filter: drop-shadow(0 3px 6px rgba(0,0,0,0.4));
      margin-left: 10px;
    }

    /* Showcase phones */
    .devices-row {
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 20px;
      margin-top: 6px;
      margin-bottom: 16px;
    }
    .device-item {
      position: relative;
      filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.45));
      transition: transform 0.2s ease;
    }
    .device-phone-1 {
      width: 150px;
      height: 195px;
      transform: rotate(-6deg);
    }
    .device-phone-2 {
      width: 170px;
      height: 220px;
      z-index: 2;
    }
    .device-phone-3 {
      width: 150px;
      height: 195px;
      transform: rotate(6deg);
    }

    /* Mua Ngay Button */
    .btn-action-buy {
      background: linear-gradient(180deg, #fff7a0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      color: #4d0004;
      font-size: 32px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 16px 64px;
      border-radius: 9999px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), inset 0 2px 3px rgba(255, 255, 255, 0.8);
      display: inline-flex;
      align-items: center;
      gap: 14px;
      cursor: pointer;
      border: 2px solid #fff59d;
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
      <div class="panel-line-1">100% SMARTPHONE</div>
      <div class="panel-line-2">CHÍNH HÃNG VN/A</div>
      <div class="panel-line-3">TẶNG GÓI</div>
      <div class="panel-line-4">Bảo Hành VIP 1 Đổi 1</div>
      <div class="panel-divider"></div>
      <div class="panel-line-5">TRẢ CHẬM 0%</div>
      <div class="panel-line-6">Đến 12 Tháng</div>
      <div class="panel-line-7">GIẢM THÊM ĐẾN 1 TRIỆU</div>
      <div class="panel-line-8">CHO HỌC SINH - SINH VIÊN</div>
    </div>

    <!-- 2. CENTER SECTION -->
    <div class="center-section">
      <div class="title-col">
        <div class="brand-pill">
          <div class="brand-logo-icon">&#x26A1;</div>
          <div class="brand-name">Phone<span>X</span></div>
        </div>

        <div class="title-tuu-truong">TỰU TRƯỜNG</div>
        <div class="title-deal-thom">
          <svg class="crown-icon" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5m14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
          DEAL THƠMMM
        </div>
      </div>

      <!-- Student Mascot Vector Illustration -->
      <div class="student-img-box">
        <svg class="student-svg" viewBox="0 0 200 360" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="100" cy="55" r="32" fill="#ffd1b3"/>
          <path d="M68 50 C68 20, 132 20, 132 50 C132 30, 120 15, 100 15 C80 15, 68 30, 68 50 Z" fill="#2d1d13"/>
          <circle cx="100" cy="16" r="14" fill="#2d1d13"/>
          <circle cx="90" cy="52" r="3.5" fill="#222"/>
          <circle cx="110" cy="52" r="3.5" fill="#222"/>
          <path d="M92 64 Q100 72 108 64" stroke="#e04040" stroke-width="3" fill="none" stroke-linecap="round"/>
          <circle cx="82" cy="58" r="5" fill="#ff9999" opacity="0.6"/>
          <circle cx="118" cy="58" r="5" fill="#ff9999" opacity="0.6"/>
          <rect x="92" y="85" width="16" height="20" fill="#ffd1b3"/>
          <path d="M60 100 L140 100 L148 190 L52 190 Z" fill="#ff9900"/>
          <path d="M65 150 L135 150 L138 290 L62 290 Z" fill="#fff8e7"/>
          <path d="M72 100 L82 150 L94 150 L84 100 Z" fill="#fff8e7"/>
          <path d="M128 100 L118 150 L106 150 L116 100 Z" fill="#fff8e7"/>
          <rect x="76" y="170" width="48" height="40" rx="6" fill="#f0ebe0"/>
          <path d="M52 120 L30 180 L55 200 L70 150 Z" fill="#ffd1b3"/>
          <path d="M148 120 L170 180 L145 200 L130 150 Z" fill="#ffd1b3"/>
          <rect x="70" y="140" width="60" height="75" rx="4" fill="#0099ff" transform="rotate(-8 100 170)"/>
          <rect x="66" y="145" width="64" height="20" rx="3" fill="#ff3366" transform="rotate(-8 100 170)"/>
          <rect x="68" y="168" width="62" height="45" rx="3" fill="#ffffff" transform="rotate(-8 100 170)"/>
          <rect x="135" y="140" width="28" height="52" rx="5" fill="#1f2937" stroke="#3b82f6" stroke-width="2"/>
          <rect x="138" y="145" width="22" height="40" rx="3" fill="#60a5fa"/>
        </svg>
      </div>
    </div>

    <!-- 3. RIGHT SECTION: DISCOUNT + SMARTPHONE SHOWCASE + BUY BUTTON -->
    <div class="right-section">
      <div class="top-promo-header">
        <div class="promo-subtext">
          Tân Sinh Viên &amp; HSSV
          <span>Giảm Thêm Đến</span>
        </div>
        <div class="promo-giant-num">
          3 TRIỆU
          <svg class="grad-cap" viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
        </div>
      </div>

      <!-- Smartphone Showcase Trio -->
      <div class="devices-row">
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
        <span>MUA NGAY</span>
        <svg style="width:26px;height:26px;fill:#4d0004;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

# ==========================================
# BANNER 2: PHÁ CỖ TUNG DEAL (PhoneX Red)
# ==========================================
html_banner2 = """<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
      width: 2400px;
      height: 480px;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #580005;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 480px;
      position: relative;
      background: linear-gradient(90deg, #4d0004 0%, #7d000a 16%, #ba0d1a 45%, #cf1322 55%, #ba0d1a 68%, #7d000a 85%, #4d0004 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 50px;
      overflow: hidden;
    }

    /* Ambient lighting & glowing accents */
    .moon-glow {
      position: absolute;
      top: -100px;
      right: 180px;
      width: 650px;
      height: 650px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 215, 0, 0.22) 0%, rgba(255, 215, 0, 0) 70%);
      z-index: 1;
    }
    .festive-glow-left {
      position: absolute;
      top: -100px;
      left: 100px;
      width: 650px;
      height: 650px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 60, 60, 0.25) 0%, rgba(255, 0, 0, 0) 70%);
      z-index: 1;
    }
    .bg-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(115deg, transparent 40%, rgba(255, 255, 255, 0.06) 48%, rgba(255, 255, 255, 0.12) 50%, rgba(255, 255, 255, 0.06) 52%, transparent 60%);
      z-index: 2;
      pointer-events: none;
    }

    /* 1. LEFT TITLE: PHÁ CỖ TUNG DEAL */
    .left-title-box {
      position: relative;
      z-index: 4;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin-left: 15px;
    }
    .title-pha-co {
      font-size: 82px;
      font-weight: 950;
      color: #ffffff;
      text-transform: uppercase;
      letter-spacing: -2px;
      line-height: 0.95;
      -webkit-text-stroke: 1.5px #ffd700;
      filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.6));
    }
    .title-tung-deal {
      font-size: 116px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: -3px;
      line-height: 0.95;
      background: linear-gradient(180deg, #fffdf0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      -webkit-text-stroke: 4px #4d0004;
      filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.7));
      margin-top: 5px;
      margin-bottom: 14px;
    }
    .ribbon-dates {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      background: #ffffff;
      border: 3px solid #ffd700;
      border-radius: 9999px;
      padding: 10px 28px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
    }
    .ribbon-icon {
      font-size: 30px;
    }
    .ribbon-text-1 {
      font-size: 28px;
      font-weight: 950;
      color: #ba0d1a;
      text-transform: uppercase;
      letter-spacing: 0.2px;
    }
    .ribbon-text-2 {
      font-size: 26px;
      font-weight: 850;
      color: #1f2937;
    }

    /* 2. CENTER WHITE PROMO CARD (Enlarged for maximum readability) */
    .center-card {
      position: relative;
      z-index: 4;
      width: 850px;
      background: #ffffff;
      border-radius: 34px;
      padding: 24px 38px;
      box-shadow: 0 16px 45px rgba(0, 0, 0, 0.38);
      display: flex;
      flex-direction: column;
      align-items: center;
      border: 2px solid rgba(255, 255, 255, 0.95);
    }
    .card-top-title {
      font-size: 30px;
      font-weight: 950;
      color: #ba0d1a;
      text-align: center;
      margin-bottom: 2px;
      letter-spacing: -0.3px;
    }
    .card-sub-head {
      font-size: 34px;
      font-weight: 950;
      color: #111827;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .card-big-price {
      font-size: 68px;
      font-weight: 950;
      color: #ba0d1a;
      line-height: 1;
      letter-spacing: -1.5px;
      margin: 4px 0 6px 0;
    }
    .card-note {
      font-size: 20px;
      font-weight: 800;
      color: #4b5563;
      margin-bottom: 12px;
    }
    .card-bottom-divider {
      width: 100%;
      height: 1px;
      border-top: 2px dashed #cbd5e1;
      margin-bottom: 12px;
    }
    .card-bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      width: 100%;
      text-align: center;
    }
    .col-left {
      padding-right: 20px;
      border-right: 2px dashed #cbd5e1;
    }
    .col-right {
      padding-left: 20px;
    }
    .col-title {
      font-size: 20px;
      font-weight: 850;
      color: #111827;
      margin-bottom: 3px;
    }
    .col-highlight {
      font-size: 28px;
      font-weight: 950;
      color: #ba0d1a;
      line-height: 1.2;
    }
    .col-note {
      font-size: 18px;
      font-weight: 800;
      color: #4b5563;
      margin-top: 3px;
    }

    /* 3. RIGHT SECTION (DEVICE ECOSYSTEM & BUY BUTTON) */
    .right-section {
      position: relative;
      z-index: 4;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 15px;
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
      left: 30px;
      top: 10px;
      width: 250px;
      height: 190px;
      border-radius: 18px;
      background: #0f172a;
      border: 3px solid #475569;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
      overflow: hidden;
    }
    .eco-phone {
      position: absolute;
      left: 130px;
      top: 30px;
      width: 110px;
      height: 185px;
      border-radius: 20px;
      background: #09090b;
      border: 3px solid #ffd700;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
      z-index: 2;
      overflow: hidden;
    }
    .eco-phone-screen {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #1e1b4b 0%, #ba0d1a 50%, #f59e0b 100%);
    }
    .eco-watch {
      position: absolute;
      right: 50px;
      bottom: 20px;
      width: 60px;
      height: 75px;
      border-radius: 18px;
      background: #18181b;
      border: 2.5px solid #71717a;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
      z-index: 3;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .eco-watch-screen {
      width: 44px;
      height: 58px;
      border-radius: 12px;
      background: #ef4444;
      opacity: 0.85;
    }
    .eco-speaker {
      position: absolute;
      right: 0px;
      bottom: 55px;
      width: 86px;
      height: 52px;
      border-radius: 14px;
      background: #ba0d1a;
      border: 2px solid #ffffff;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
      z-index: 4;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 16px;
      font-weight: 950;
      letter-spacing: 0.5px;
    }

    .btn-action-buy {
      background: linear-gradient(180deg, #fff7a0 0%, #ffd700 45%, #ff9900 85%, #d97706 100%);
      color: #4d0004;
      font-size: 32px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 16px 64px;
      border-radius: 9999px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), inset 0 2px 3px rgba(255, 255, 255, 0.8);
      display: inline-flex;
      align-items: center;
      gap: 14px;
      cursor: pointer;
      border: 2px solid #fff59d;
    }
  </style>
</head>
<body>
  <div class="banner">
    <div class="festive-glow-left"></div>
    <div class="moon-glow"></div>
    <div class="bg-shine"></div>

    <!-- 1. LEFT TITLE: PHÁ CỖ TUNG DEAL -->
    <div class="left-title-box">
      <div class="title-pha-co">PHÁ CỖ</div>
      <div class="title-tung-deal">TUNG DEAL</div>
      <div class="ribbon-dates">
        <span class="ribbon-icon">🥮</span>
        <span class="ribbon-text-1">GIẢM LINH ĐÌNH</span>
        <span class="ribbon-text-2">Từ 25/09 - 30/09</span>
      </div>
    </div>

    <!-- 2. CENTER WHITE PROMO CARD -->
    <div class="center-card">
      <div class="card-top-title">Điện thoại | Tablet Flagship</div>
      <div class="card-sub-head">GIẢM THÊM</div>
      <div class="card-big-price">150.000 - 1.5 Triệu</div>
      <div class="card-note">Áp dụng trên giá sau khuyến mãi</div>

      <div class="card-bottom-divider"></div>

      <div class="card-bottom-grid">
        <div class="col-left">
          <div class="col-title">Tất cả iPhone &amp; Galaxy</div>
          <div class="col-highlight">GIẢM thêm đến 2 Triệu</div>
          <div class="col-note">Áp dụng kèm khuyến mãi khác</div>
        </div>
        <div class="col-right">
          <div class="col-title">Phụ kiện | Đồng hồ</div>
          <div class="col-highlight">GIẢM thêm đến 15%</div>
          <div class="col-note">Chính hãng 100% (Trừ Apple)</div>
        </div>
      </div>
    </div>

    <!-- 3. RIGHT SECTION: ECOSYSTEM + BUY BUTTON -->
    <div class="right-section">
      <div class="ecosystem-group">
        <div class="eco-tablet">
          <div style="width:100%;height:100%;background:linear-gradient(45deg,#020617,#1e293b);"></div>
        </div>
        <div class="eco-phone">
          <div class="eco-phone-screen"></div>
        </div>
        <div class="eco-watch">
          <div class="eco-watch-screen"></div>
        </div>
        <div class="eco-speaker">JBL</div>
      </div>

      <div class="btn-action-buy">
        <span>MUA NGAY</span>
        <svg style="width:26px;height:26px;fill:#4d0004;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
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
            "--window-size=2400,480",
            f"--screenshot={output_png}",
            f"file://{temp_html}"
        ]
        subprocess.run(cmd, check=True)
    finally:
        if os.path.exists(temp_html):
            os.remove(temp_html)

if __name__ == "__main__":
    banner1_path = "assets/images/banners/slider-banner-1-2400x480.png"
    banner2_path = "assets/images/banners/slider-banner-2-2400x480.png"
    wp_banner1 = "phonex-theme/assets/images/banners/slider-banner-1-2400x480.png"
    wp_banner2 = "phonex-theme/assets/images/banners/slider-banner-2-2400x480.png"

    os.makedirs(os.path.dirname(banner1_path), exist_ok=True)
    os.makedirs(os.path.dirname(wp_banner1), exist_ok=True)

    print("Render Banner 1 with enlarged fonts...")
    render_html_to_png(html_banner1, banner1_path)
    subprocess.run(["cp", banner1_path, wp_banner1], check=True)

    print("Render Banner 2 with enlarged fonts...")
    render_html_to_png(html_banner2, banner2_path)
    subprocess.run(["cp", banner2_path, wp_banner2], check=True)

    print(f"Đã lưu Banner 1: {banner1_path} ({os.path.getsize(banner1_path)} bytes)")
    print(f"Đã lưu Banner 2: {banner2_path} ({os.path.getsize(banner2_path)} bytes)")
