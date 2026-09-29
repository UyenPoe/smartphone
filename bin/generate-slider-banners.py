#!/usr/bin/env python3
import subprocess
import os
import shutil

# BANNER 1: Tựu Trường Deal Thơm
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
      background: #fed600;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 480px;
      position: relative;
      background: linear-gradient(90deg, #ffc700 0%, #ffd000 20%, #fed800 50%, #ffd000 80%, #ffbe00 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      overflow: hidden;
    }

    /* Background glow / curves */
    .bg-circle-left {
      position: absolute;
      top: -120px;
      left: 360px;
      width: 550px;
      height: 720px;
      border-radius: 50%;
      background: #fedb15;
      z-index: 1;
    }
    .bg-light-glow {
      position: absolute;
      top: -100px;
      right: 200px;
      width: 800px;
      height: 680px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0) 65%);
      z-index: 1;
    }

    /* LEFT WHITE PILL/CURVED PANEL */
    .left-panel {
      position: relative;
      z-index: 3;
      width: 520px;
      height: 480px;
      background: #ffffff;
      border-top-right-radius: 240px;
      border-bottom-right-radius: 240px;
      box-shadow: 15px 0 35px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px 50px 30px 40px;
      text-align: center;
    }
    .panel-line-1 {
      font-size: 28px;
      font-weight: 900;
      color: #e60012;
      text-transform: uppercase;
      letter-spacing: -0.3px;
      margin-bottom: 4px;
    }
    .panel-line-2 {
      font-size: 32px;
      font-weight: 900;
      color: #102a83;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      margin-bottom: 14px;
    }
    .panel-line-3 {
      font-size: 26px;
      font-weight: 900;
      color: #e60012;
      text-transform: uppercase;
      margin-bottom: 2px;
    }
    .panel-line-4 {
      font-size: 25px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 14px;
    }
    .panel-divider {
      width: 180px;
      height: 3px;
      background: #ffd000;
      border-radius: 2px;
      margin-bottom: 14px;
    }
    .panel-line-5 {
      font-size: 28px;
      font-weight: 900;
      color: #e60012;
      text-transform: uppercase;
      letter-spacing: -0.3px;
    }
    .panel-line-6 {
      font-size: 24px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 14px;
    }
    .panel-line-7 {
      font-size: 25px;
      font-weight: 900;
      color: #e60012;
      text-transform: uppercase;
      line-height: 1.25;
    }
    .panel-line-8 {
      font-size: 22px;
      font-weight: 900;
      color: #102a83;
      text-transform: uppercase;
      margin-top: 4px;
      letter-spacing: 0.5px;
    }

    /* CENTER SECTION (BRAND + 3D TITLE + CHARACTER) */
    .center-section {
      position: relative;
      z-index: 3;
      display: flex;
      align-items: center;
      gap: 30px;
      margin-left: 20px;
    }
    .title-col {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .brand-pill {
      background: #000000;
      color: #ffffff;
      padding: 10px 28px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
      margin-bottom: 18px;
    }
    .brand-logo-icon {
      width: 32px;
      height: 32px;
      background: #e60012;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 19px;
      font-weight: 900;
      color: #fff;
    }
    .brand-name {
      font-size: 26px;
      font-weight: 900;
      letter-spacing: -0.5px;
    }
    .brand-name span {
      color: #e60012;
    }

    .title-tuu-truong {
      font-size: 64px;
      font-weight: 900;
      color: #0f2b82;
      text-transform: uppercase;
      letter-spacing: -1.5px;
      line-height: 1;
      -webkit-text-stroke: 3px #ffffff;
      filter: drop-shadow(0 6px 0px rgba(0, 0, 0, 0.12));
    }
    .title-deal-thom {
      font-size: 92px;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: -2px;
      line-height: 1;
      color: #ffd000;
      background: linear-gradient(180deg, #fff275 0%, #ffc700 50%, #ff0055 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      -webkit-text-stroke: 4px #0f2b82;
      filter: drop-shadow(0 8px 12px rgba(15, 43, 130, 0.45));
      position: relative;
      margin-top: -8px;
    }
    .crown-icon {
      position: absolute;
      top: -30px;
      left: 10px;
      width: 44px;
      height: 44px;
      fill: #ffaa00;
      filter: drop-shadow(0 2px 5px rgba(0,0,0,0.3));
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
    }

    /* RIGHT SECTION (DISCOUNT + DEVICES SHOWCASE + BUY BUTTON) */
    .right-section {
      position: relative;
      z-index: 3;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 60px;
    }
    .top-promo-header {
      display: flex;
      align-items: baseline;
      gap: 14px;
      margin-bottom: 10px;
    }
    .promo-subtext {
      font-size: 32px;
      font-weight: 900;
      color: #0f2b82;
      line-height: 1.1;
      text-align: right;
    }
    .promo-subtext span {
      display: block;
      font-size: 26px;
      font-weight: 800;
      color: #1f2937;
    }
    .promo-giant-num {
      font-size: 96px;
      font-weight: 950;
      color: #e60050;
      line-height: 0.9;
      letter-spacing: -3px;
      text-shadow: 3px 4px 0 #ffffff, 6px 8px 15px rgba(230, 0, 80, 0.35);
      display: flex;
      align-items: baseline;
    }
    .grad-cap {
      width: 42px;
      height: 42px;
      fill: #ffffff;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.25));
      margin-left: 10px;
    }

    /* Showcase phones */
    .devices-row {
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
      margin-bottom: 18px;
    }
    .device-item {
      position: relative;
      filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.28));
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
      background: linear-gradient(180deg, #0250d7 0%, #003699 100%);
      color: #ffffff;
      font-size: 28px;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      padding: 14px 60px;
      border-radius: 9999px;
      box-shadow: 0 10px 25px rgba(2, 80, 215, 0.45), inset 0 2px 3px rgba(255, 255, 255, 0.6);
      border: 2.5px solid #ffffff;
      display: flex;
      align-items: center;
      gap: 12px;
    }
  </style>
</head>
<body>
  <div class="banner">
    <div class="bg-circle-left"></div>
    <div class="bg-light-glow"></div>

    <!-- 1. LEFT WHITE CURVED PANEL -->
    <div class="left-panel">
      <div class="panel-line-1">100% Smartphone</div>
      <div class="panel-line-2">Chính Hãng VN/A</div>
      <div class="panel-line-3">TẶNG GÓI</div>
      <div class="panel-line-4">Bảo Hành VIP 1 Đổi 1</div>
      <div class="panel-divider"></div>
      <div class="panel-line-5">TRẢ CHẬM 0%</div>
      <div class="panel-line-6">Đến 12 Tháng</div>
      <div class="panel-line-7">GIẢM THÊM ĐẾN 1 TRIỆU</div>
      <div class="panel-line-8">CHO HỌC SINH - SINH VIÊN</div>
    </div>

    <!-- 2. CENTER: BRAND + 3D TITLE + CHARACTER -->
    <div class="center-section">
      <div class="title-col">
        <div class="brand-pill">
          <div class="brand-logo-icon">&#x26A1;</div>
          <div class="brand-name">Phone<span>X</span>.vn</div>
        </div>

        <div class="title-tuu-truong">TỰU TRƯỜNG</div>
        <div class="title-deal-thom">
          <svg class="crown-icon" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5m14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
          DEAL THƠMMM
        </div>
      </div>

      <!-- Cheerful Student Vector Illustration -->
      <div class="student-img-box">
        <svg class="student-svg" viewBox="0 0 200 360" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Student with yellow shirt and overalls -->
          <circle cx="100" cy="55" r="32" fill="#ffd1b3"/>
          <!-- Hair -->
          <path d="M68 50 C68 20, 132 20, 132 50 C132 30, 120 15, 100 15 C80 15, 68 30, 68 50 Z" fill="#2d1d13"/>
          <circle cx="100" cy="16" r="14" fill="#2d1d13"/>
          <!-- Eyes & smile -->
          <circle cx="90" cy="52" r="3.5" fill="#222"/>
          <circle cx="110" cy="52" r="3.5" fill="#222"/>
          <path d="M92 64 Q100 72 108 64" stroke="#e04040" stroke-width="3" fill="none" stroke-linecap="round"/>
          <circle cx="82" cy="58" r="5" fill="#ff9999" opacity="0.6"/>
          <circle cx="118" cy="58" r="5" fill="#ff9999" opacity="0.6"/>
          <!-- Neck & Yellow T-shirt -->
          <rect x="92" y="85" width="16" height="20" fill="#ffd1b3"/>
          <path d="M60 100 L140 100 L148 190 L52 190 Z" fill="#ff9900"/>
          <!-- Denim / Cream Overalls -->
          <path d="M65 150 L135 150 L138 290 L62 290 Z" fill="#fff8e7"/>
          <path d="M72 100 L82 150 L94 150 L84 100 Z" fill="#fff8e7"/>
          <path d="M128 100 L118 150 L106 150 L116 100 Z" fill="#fff8e7"/>
          <rect x="76" y="170" width="48" height="40" rx="6" fill="#f0ebe0"/>
          <!-- Arms holding books -->
          <path d="M52 120 L30 180 L55 200 L70 150 Z" fill="#ffd1b3"/>
          <path d="M148 120 L170 180 L145 200 L130 150 Z" fill="#ffd1b3"/>
          <!-- Books & Phone -->
          <rect x="70" y="140" width="60" height="75" rx="4" fill="#0099ff" transform="rotate(-8 100 170)"/>
          <rect x="66" y="145" width="64" height="20" rx="3" fill="#ff3366" transform="rotate(-8 100 170)"/>
          <rect x="68" y="168" width="62" height="45" rx="3" fill="#ffffff" transform="rotate(-8 100 170)"/>
          <!-- Smartphone in hand -->
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
            <!-- Wallpaper -->
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
          <svg viewBox="0 0 160 210" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="6" width="148" height="198" rx="28" fill="#18181b" stroke="#e4e4e7" stroke-width="5"/>
            <rect x="12" y="12" width="136" height="186" rx="22" fill="#030712"/>
            <!-- Dynamic Island -->
            <rect x="58" y="18" width="44" height="12" rx="6" fill="#000000"/>
            <!-- Radiant Display -->
            <circle cx="80" cy="110" r="45" fill="url(#grad2)"/>
            <defs>
              <linearGradient id="grad2" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#f59e0b"/>
                <stop offset="50%" stop-color="#ef4444"/>
                <stop offset="100%" stop-color="#8b5cf6"/>
              </linearGradient>
            </defs>
          </svg>
        </div>

        <!-- Phone 3: Xiaomi Flagship -->
        <div class="device-item device-phone-3">
          <svg viewBox="0 0 140 185" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="6" width="128" height="173" rx="16" fill="#1e293b" stroke="#94a3b8" stroke-width="4"/>
            <rect x="12" y="12" width="116" height="161" rx="12" fill="#0f172a"/>
            <!-- Wallpaper -->
            <path d="M128 12 Q60 90 12 173 L128 173 Z" fill="url(#grad3)"/>
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
        <svg style="width:24px;height:24px;fill:#fff;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

# BANNER 2: Phá Cỗ Tung Deal
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
      background: #fed600;
      -webkit-font-smoothing: antialiased;
    }

    .banner {
      width: 2400px;
      height: 480px;
      position: relative;
      background: linear-gradient(90deg, #ffc700 0%, #ffd000 20%, #fed800 50%, #ffd000 80%, #ffbe00 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 60px;
      overflow: hidden;
    }

    /* Decorative clouds & lanterns */
    .moon-glow {
      position: absolute;
      top: -100px;
      right: 180px;
      width: 650px;
      height: 650px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0) 70%);
      z-index: 1;
    }
    .festive-cloud-1 {
      position: absolute;
      top: 25px;
      right: 680px;
      opacity: 0.35;
      z-index: 1;
    }
    .festive-cloud-2 {
      position: absolute;
      bottom: 20px;
      left: 450px;
      opacity: 0.35;
      z-index: 1;
    }

    /* 1. LEFT TITLE: PHÁ CỖ TUNG DEAL */
    .left-title-box {
      position: relative;
      z-index: 3;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin-left: 20px;
    }
    .title-pha-co {
      font-size: 78px;
      font-weight: 950;
      color: #0f2b82;
      text-transform: uppercase;
      letter-spacing: -2px;
      line-height: 0.95;
      -webkit-text-stroke: 3.5px #ffffff;
      filter: drop-shadow(0 6px 0 rgba(0, 0, 0, 0.15));
    }
    .title-tung-deal {
      font-size: 110px;
      font-weight: 950;
      color: #0f2b82;
      text-transform: uppercase;
      letter-spacing: -3px;
      line-height: 0.95;
      -webkit-text-stroke: 4.5px #ffffff;
      filter: drop-shadow(0 8px 0 rgba(0, 0, 0, 0.15));
      margin-top: 5px;
      margin-bottom: 12px;
    }
    .ribbon-dates {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #ffffff;
      border: 3px solid #ff0055;
      border-radius: 9999px;
      padding: 8px 24px;
      box-shadow: 0 8px 20px rgba(255, 0, 85, 0.25);
    }
    .ribbon-icon {
      font-size: 26px;
    }
    .ribbon-text-1 {
      font-size: 26px;
      font-weight: 900;
      color: #e60050;
      text-transform: uppercase;
    }
    .ribbon-text-2 {
      font-size: 22px;
      font-weight: 800;
      color: #e60050;
    }

    /* 2. CENTER WHITE PROMO CARD */
    .center-card {
      position: relative;
      z-index: 3;
      background: #ffffff;
      border-radius: 40px;
      padding: 32px 50px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.04);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      width: 780px;
      margin: 0 20px;
    }
    .card-top-title {
      font-size: 34px;
      font-weight: 900;
      color: #0f2b82;
      letter-spacing: -0.5px;
      margin-bottom: 4px;
    }
    .card-discount-label {
      font-size: 36px;
      font-weight: 900;
      color: #e60050;
      text-transform: uppercase;
      line-height: 1.1;
      margin-bottom: 2px;
    }
    .card-discount-val {
      font-size: 64px;
      font-weight: 950;
      color: #e60050;
      line-height: 1;
      letter-spacing: -1.5px;
      text-shadow: 0 2px 6px rgba(230, 0, 80, 0.25);
    }
    .card-subtext {
      font-size: 19px;
      font-weight: 700;
      color: #4b5563;
      margin-top: 4px;
      margin-bottom: 20px;
    }
    .card-columns {
      display: flex;
      align-items: center;
      width: 100%;
      border-top: 2px dashed #e5e7eb;
      padding-top: 18px;
    }
    .card-col {
      flex: 1;
      padding: 0 15px;
    }
    .card-col:first-child {
      border-right: 2px dashed #e5e7eb;
    }
    .col-title {
      font-size: 21px;
      font-weight: 800;
      color: #0f2b82;
      margin-bottom: 4px;
    }
    .col-highlight {
      font-size: 28px;
      font-weight: 950;
      color: #e60050;
      line-height: 1.1;
    }
    .col-note {
      font-size: 15px;
      font-weight: 600;
      color: #6b7280;
      margin-top: 2px;
    }

    /* 3. RIGHT SHOWCASE & BUTTON */
    .right-box {
      position: relative;
      z-index: 3;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-right: 20px;
    }
    .showcase-row {
      display: flex;
      align-items: flex-end;
      gap: 15px;
      margin-bottom: 24px;
      filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.28));
    }
    .device-box {
      position: relative;
    }
    .btn-buy-deal {
      background: linear-gradient(180deg, #ff4500 0%, #d82b00 100%);
      color: #ffffff;
      font-size: 30px;
      font-weight: 950;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 16px 65px;
      border-radius: 9999px;
      box-shadow: 0 10px 25px rgba(216, 43, 0, 0.5), inset 0 2px 4px rgba(255, 255, 255, 0.7);
      border: 3px solid #ffe600;
      display: flex;
      align-items: center;
      gap: 12px;
    }
  </style>
</head>
<body>
  <div class="banner">
    <div class="moon-glow"></div>

    <!-- 1. LEFT TITLE -->
    <div class="left-title-box">
      <div class="title-pha-co">PHÁ CỖ</div>
      <div class="title-tung-deal">TUNG DEAL</div>
      <div class="ribbon-dates">
        <span class="ribbon-icon">&#x1F96E;</span>
        <span class="ribbon-text-1">Giảm linh đình</span>
        <span class="ribbon-text-2">Từ 25/09 - 30/09</span>
      </div>
    </div>

    <!-- 2. CENTER WHITE CARD -->
    <div class="center-card">
      <div class="card-top-title">Điện thoại | Tablet Flagship</div>
      <div class="card-discount-label">Giảm thêm</div>
      <div class="card-discount-val">150.000 - 1.5 Triệu</div>
      <div class="card-subtext">Áp dụng trên giá sau khuyến mãi</div>

      <div class="card-columns">
        <div class="card-col">
          <div class="col-title">Tất cả iPhone &amp; Galaxy</div>
          <div class="col-highlight">GIẢM thêm đến 2 Triệu</div>
          <div class="col-note">Áp dụng kèm khuyến mãi khác</div>
        </div>
        <div class="card-col">
          <div class="col-title">Phụ kiện | Đồng hồ</div>
          <div class="col-highlight">GIẢM thêm đến 15%</div>
          <div class="col-note">Chính hãng 100% (Trừ Apple)</div>
        </div>
      </div>
    </div>

    <!-- 3. RIGHT SHOWCASE & BUTTON -->
    <div class="right-box">
      <div class="showcase-row">
        <!-- Tablet/Phone showcase svg -->
        <svg width="420" height="230" viewBox="0 0 420 230" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Tablet in back -->
          <rect x="70" y="20" width="220" height="150" rx="14" fill="#1e1e24" stroke="#ffffff" stroke-width="4"/>
          <rect x="76" y="26" width="208" height="138" rx="10" fill="#0f172a"/>
          <circle cx="180" cy="95" r="40" fill="url(#tabGrad)"/>
          
          <!-- Galaxy S24 Ultra -->
          <rect x="20" y="55" width="95" height="145" rx="12" fill="#2d3748" stroke="#cbd5e1" stroke-width="3"/>
          <rect x="24" y="59" width="87" height="137" rx="9" fill="#090d16"/>
          <!-- Camera lenses on back -->
          <circle cx="38" cy="74" r="5" fill="#4a5568"/>
          <circle cx="38" cy="90" r="5" fill="#4a5568"/>
          <circle cx="38" cy="106" r="5" fill="#4a5568"/>

          <!-- iPhone 16 Pro Max front center -->
          <rect x="135" y="45" width="105" height="160" rx="18" fill="#18181b" stroke="#f4f4f5" stroke-width="4"/>
          <rect x="140" y="50" width="95" height="150" rx="14" fill="#020617"/>
          <rect x="168" y="55" width="38" height="10" rx="5" fill="#000000"/>
          <path d="M140 100 Q187 150 235 120 L235 200 L140 200 Z" fill="url(#phGrad)"/>

          <!-- Smartwatch -->
          <rect x="255" y="95" width="55" height="70" rx="12" fill="#18181b" stroke="#71717a" stroke-width="3"/>
          <circle cx="282" cy="130" r="18" fill="#ef4444" opacity="0.8"/>
          
          <!-- Bluetooth Speaker -->
          <rect x="325" y="115" width="85" height="50" rx="14" fill="#0f172a" stroke="#ffffff" stroke-width="3"/>
          <rect x="330" y="120" width="75" height="40" rx="10" fill="#dc2626"/>
          <text x="367" y="146" font-size="14" font-weight="900" fill="#ffffff" text-anchor="middle">JBL</text>

          <defs>
            <linearGradient id="tabGrad" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#3b82f6"/>
              <stop offset="100%" stop-color="#8b5cf6"/>
            </linearGradient>
            <linearGradient id="phGrad" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#ec4899"/>
              <stop offset="100%" stop-color="#f59e0b"/>
            </linearGradient>
          </defs>
        </svg>
      </div>

      <!-- Action Button -->
      <div class="btn-buy-deal">
        <span>MUA NGAY</span>
        <svg style="width:26px;height:26px;fill:#fff;" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

# Render Banner 1
path_b1_html = "/tmp/slider_banner_1.html"
with open(path_b1_html, "w", encoding="utf-8") as f:
    f.write(html_banner1)

tmp_b1_png = "/tmp/slider-banner-1-2400x480.png"
cmd1 = [
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
    "--headless",
    "--disable-gpu",
    "--force-device-scale-factor=1",
    "--window-size=2400,480",
    f"--screenshot={tmp_b1_png}",
    f"file://{path_b1_html}"
]
print("Render Banner 1...")
subprocess.run(cmd1, check=True)

# Render Banner 2
path_b2_html = "/tmp/slider_banner_2.html"
with open(path_b2_html, "w", encoding="utf-8") as f:
    f.write(html_banner2)

tmp_b2_png = "/tmp/slider-banner-2-2400x480.png"
cmd2 = [
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
    "--headless",
    "--disable-gpu",
    "--force-device-scale-factor=1",
    "--window-size=2400,480",
    f"--screenshot={tmp_b2_png}",
    f"file://{path_b2_html}"
]
print("Render Banner 2...")
subprocess.run(cmd2, check=True)

# Copy to destinations
targets = [
    ("assets/images/banners/slider-banner-1-2400x480.png", tmp_b1_png),
    ("assets/images/banners/slider-banner-2-2400x480.png", tmp_b2_png),
    ("phonex-theme/assets/images/banners/slider-banner-1-2400x480.png", tmp_b1_png),
    ("phonex-theme/assets/images/banners/slider-banner-2-2400x480.png", tmp_b2_png),
]

for dst, src in targets:
    os.makedirs(os.path.dirname(dst), exist_ok=True)
    shutil.copyfile(src, dst)
    print(f" Đã lưu: {dst} ({os.path.getsize(dst)} bytes)")

res1 = subprocess.run(["sips", "-g", "pixelWidth", "-g", "pixelHeight", tmp_b1_png], capture_output=True, text=True)
res2 = subprocess.run(["sips", "-g", "pixelWidth", "-g", "pixelHeight", tmp_b2_png], capture_output=True, text=True)
print("Banner 1:", res1.stdout.strip())
print("Banner 2:", res2.stdout.strip())
