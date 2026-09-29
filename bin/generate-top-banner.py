#!/usr/bin/env python3
import subprocess
import os
import shutil

html_content = """<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body, html {
      width: 2400px;
      height: 88px;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #b7000c;
      -webkit-font-smoothing: antialiased;
    }
    .banner-container {
      width: 2400px;
      height: 88px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(90deg, #6c0007 0%, #9e000d 15%, #cf0014 38%, #e1081c 50%, #cf0014 62%, #9e000d 85%, #6c0007 100%);
      box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.3), inset 0 -2px 6px rgba(0, 0, 0, 0.4);
      border-bottom: 2px solid rgba(138, 0, 11, 0.8);
      overflow: hidden;
    }

    /* Ambient light and flare effects */
    .glow-circle-1 {
      position: absolute;
      top: -50px;
      left: 15%;
      width: 320px;
      height: 200px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
      pointer-events: none;
    }
    .glow-circle-2 {
      position: absolute;
      bottom: -60px;
      right: 25%;
      width: 400px;
      height: 200px;
      background: radial-gradient(circle, rgba(255, 214, 0, 0.22) 0%, rgba(255, 214, 0, 0) 70%);
      pointer-events: none;
    }
    .diagonal-shine {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(110deg, transparent 38%, rgba(255, 255, 255, 0.06) 46%, rgba(255, 255, 255, 0.16) 50%, rgba(255, 255, 255, 0.06) 54%, transparent 62%);
      pointer-events: none;
    }

    /* Centered Inner Wrapper */
    .banner-inner {
      width: 100%;
      max-width: 2200px;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 50px;
      position: relative;
      z-index: 2;
      white-space: nowrap;
    }

    .main-row {
      display: flex;
      align-items: center;
      gap: 22px;
      white-space: nowrap;
    }

    /* Left Badge */
    .left-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.12) 100%);
      border: 1.5px solid rgba(255, 255, 255, 0.6);
      border-radius: 9999px;
      padding: 8px 22px;
      color: #ffffff;
      font-weight: 900;
      font-size: 21px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.28), inset 0 1px 2px rgba(255, 255, 255, 0.6);
      white-space: nowrap;
      flex-shrink: 0;
    }
    .bolt-icon {
      width: 24px;
      height: 24px;
      fill: #ffd600;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));
      flex-shrink: 0;
    }

    /* Date and Text */
    .date-tag {
      font-weight: 800;
      font-size: 22px;
      color: #ffffff;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.35);
      letter-spacing: -0.2px;
      white-space: nowrap;
    }
    .promo-text {
      font-weight: 700;
      font-size: 22px;
      color: #ffffff;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.35);
      white-space: nowrap;
    }
    .highlight-discount {
      font-weight: 900;
      font-size: 34px;
      color: #ffe600;
      text-shadow: 0 2px 10px rgba(255, 214, 0, 0.8), 0 1px 3px rgba(0,0,0,0.6);
      padding: 0 4px;
      line-height: 1;
      display: inline-block;
      vertical-align: middle;
      letter-spacing: -0.5px;
    }

    /* Right Action Button */
    .btn-buy {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(180deg, #ffffff 0%, #f6f6f6 100%);
      color: #b7000c;
      padding: 10px 28px;
      border-radius: 9999px;
      font-weight: 900;
      font-size: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.32), inset 0 1px 2px #ffffff;
      border: 1.5px solid rgba(255, 255, 255, 0.95);
      white-space: nowrap;
      flex-shrink: 0;
    }
    .arrow-icon {
      width: 18px;
      height: 18px;
      fill: #b7000c;
    }
  </style>
</head>
<body>
  <div class="banner-container">
    <div class="glow-circle-1"></div>
    <div class="glow-circle-2"></div>
    <div class="diagonal-shine"></div>

    <div class="banner-inner">
      <div class="main-row">
        <!-- 1. Left Badge: 72 Model Giá Sốc -->
        <div class="left-badge">
          <svg class="bolt-icon" viewBox="0 0 24 24">
            <path d="M11 21h-1l1-7H7.5c-.58 0-.57-.32-.38-.66.19-.34.05-.08.07-.12C8.48 10.94 10.42 7.54 13 3h1l-1 7h3.5c.49 0 .56.33.47.51l-.07.15C12.9 17.65 11 21 11 21z"/>
          </svg>
          <span>72 Model Giá Sốc</span>
        </div>

        <!-- 2. Center Text -->
        <span class="date-tag">Duy nhất 3 ngày (28 – 30.09.2026):</span>
        <span class="promo-text">Giảm khủng đến <span class="highlight-discount">35%</span> cho Điện Thoại, Tablet &amp; Phụ Kiện</span>
      </div>

      <!-- 3. Right Button -->
      <div class="btn-buy">
        <span>Mua Ngay</span>
        <svg class="arrow-icon" viewBox="0 0 24 24">
          <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
        </svg>
      </div>
    </div>
  </div>
</body>
</html>
"""

html_path = "/tmp/top_campaign_banner_template.html"
with open(html_path, "w", encoding="utf-8") as f:
    f.write(html_content)

out_files = [
    "assets/images/banners/top-campaign-banner-2400x88.png",
    "phonex-theme/assets/images/banners/top-campaign-banner-2400x88.png"
]

tmp_png = "/tmp/top_campaign_banner_2400x88.png"

cmd = [
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome",
    "--headless",
    "--disable-gpu",
    "--force-device-scale-factor=1",
    "--window-size=2400,88",
    f"--screenshot={tmp_png}",
    f"file://{html_path}"
]

print("Đang render banner 2400x88...")
subprocess.run(cmd, check=True)

for f in out_files:
    os.makedirs(os.path.dirname(f), exist_ok=True)
    shutil.copyfile(tmp_png, f)
    print(f" Đã xuất ảnh: {f}")

res = subprocess.run(["sips", "-g", "pixelWidth", "-g", "pixelHeight", tmp_png], capture_output=True, text=True)
print(res.stdout)
