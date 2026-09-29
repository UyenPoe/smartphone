#!/usr/bin/env python3
import urllib.request
import os

images = {
    # 1. Phụ kiện di động
    "sac-du-phong": "https://cdnv2.tgdd.vn/mwg-static/common/Common/99/61/9961578164909f8a9ee7678dc95feeb0.png",
    "sac-cap": "https://cdnv2.tgdd.vn/mwg-static/common/Common/6b/64/6b646ec5f1e9a726933ee31b86a32524.png",
    "op-lung-dien-thoai": "https://cdnv2.tgdd.vn/mwg-static/common/Common/34/02/3402dd9ba3457b84482572d10bcae84e.png",
    "op-lung-may-tinh-bang": "https://cdnv2.tgdd.vn/mwg-static/common/Common/83/60/836050bcf5e1c92dd8d9899bef9f039d.png",
    "mieng-dan": "https://cdnv2.tgdd.vn/mwg-static/common/Common/72/f4/72f4b3ee8f5c1b1a170d590b3a07256d.png",
    "mieng-dan-camera": "https://cdnv2.tgdd.vn/mwg-static/common/Common/33/77/33770e364079ac9dd3888190bd574b8d.png",
    "tui-dung-airpods": "https://cdnv2.tgdd.vn/mwg-static/common/Common/24/66/2466de3fc4831f43afb0d69462130030.png",
    "quat-mini": "https://cdnv2.tgdd.vn/mwg-static/common/Common/96/c0/96c0f165b3ba8e00570f53737e108d9c.png",
    "but-tablet": "https://cdnv2.tgdd.vn/mwg-static/common/Common/3f/d5/3fd5723ac6f01521bd3d768d8ebc8d1a.png",
    "gia-do-dien-thoai-laptop": "https://cdnv2.tgdd.vn/mwg-static/common/Common/26/6f/266f538d2cee7899d54a8b5f57985d83.png",
    "day-deo-dien-thoai": "https://cdnv2.tgdd.vn/mwg-static/common/Common/01/d1/01d140b8ea3be3cdbf4b99299fd14969.png",
    "ong-kinh-dien-thoai": "https://cdnv2.tgdd.vn/mwg-static/common/Common/ff/9a/ff9a1716ada03c1b0c3498b9bd6b6373.png",

    # 2. Phụ kiện laptop, PC
    "hub-cap-chuyen-doi": "https://cdnv2.tgdd.vn/mwg-static/common/Common/e1/2d/e12deafa7615646e9cafc5bbd0667da8.png",
    "chuot-may-tinh": "https://cdnv2.tgdd.vn/mwg-static/common/Common/f7/7e/f77edda15a84c420d75415fccad9e769.png",
    "ban-phim": "https://cdnv2.tgdd.vn/mwg-static/common/Common/7a/d3/7ad3598d5e291815bc6c7f98bb73d078.png",
    "router-thiet-bi-mang": "https://cdnv2.tgdd.vn/mwg-static/common/Common/f9/32/f93258b536d9a7c59b7746e533fb271f.png",
    "balo-tui-chong-soc": "https://cdnv2.tgdd.vn/mwg-static/common/Common/33/8b/338bb7d3763dee703562a108b497fc2f.png",
    "tui-dung-phu-kien": "https://cdnv2.tgdd.vn/mwg-static/common/Common/9e/d6/9ed6b66919dccf3d26fc864184149913.png",
    "phu-phim-laptop": "https://cdnv2.tgdd.vn/mwg-static/common/Common/c3/97/c397a6f5e562a5f3ad3084e4563d6dda.png",
    "phan-mem": "https://cdnv2.tgdd.vn/mwg-static/common/Common/bb/07/bb07512d2429a1b38cedd20b750b734c.png",
    "gia-treo-man-hinh": "https://cdnv2.tgdd.vn/mwg-static/common/Common/7c/a7/7ca750e732738e17142f501ba33eb423.png",
    "mieng-lot-chuot": "https://cdnv2.tgdd.vn/mwg-static/common/Common/b3/0e/b30ead80f9b691b781060ec46e8e2928.png",
    "bang-ve-dien-tu": "https://cdnv2.tgdd.vn/mwg-static/common/Common/58/c0/58c0179556e1f44469d351ad90cb325e.png",

    # 3. Thiết bị nghe nhìn, lưu trữ, thu âm
    "tai-nghe-bluetooth": "https://cdnv2.tgdd.vn/mwg-static/common/Common/7c/09/7c09cbc92ef23816aa7d857ba8e0e194.png",
    "tai-nghe-day": "https://cdnv2.tgdd.vn/mwg-static/common/Common/12/1c/121cd7cb1fc1750893b3f41436b12c85.png",
    "tai-nghe-chup-tai": "https://cdnv2.tgdd.vn/mwg-static/common/Common/cf/9e/cf9e0eecbfc3e326f1c89f13b1ffe320.png",
    "tai-nghe-the-thao": "https://cdnv2.tgdd.vn/mwg-static/common/Common/38/f7/38f7bf684502b5aa0c7949f6d38a6a55.png",
    "loa": "https://cdnv2.tgdd.vn/mwg-static/common/Common/76/6b/766be9586a3a82491ba8106b7e558605.png",
    "micro": "https://cdnv2.tgdd.vn/mwg-static/common/Common/01/68/01681e0828adba69f98cf422d27f1f87.png",
    "may-chieu": "https://cdnv2.tgdd.vn/mwg-static/common/Common/c7/91/c7913b430d86e00918ccde443a9d9714.png",
    "kinh-thong-minh": "https://cdnv2.tgdd.vn/mwg-static/common/Common/b1/c9/b1c980b2bcff1d88660d5e8d4095853b.png",
    "o-cung": "https://cdnv2.tgdd.vn/mwg-static/common/Common/e4/45/e4457c6f0ed94186eae7f3b752196b7f.png",
    "the-nho": "https://cdnv2.tgdd.vn/mwg-static/common/Common/b5/dc/b5dcfbf49e19e81475a625de4b4f2afb.png",
    "usb": "https://cdnv2.tgdd.vn/mwg-static/common/Common/4e/ee/4eee7510a67dedbc2b162a013eaa60f6.png",

    # 4. Camera
    "camera-giam-sat": "https://cdnv2.tgdd.vn/mwg-static/tgdd/Common/af/70/af70e11a54ceeda4d04c41298016f615.png",
    "camera-trong-nha": "https://cdnv2.tgdd.vn/mwg-static/tgdd/Common/e8/0c/e80cc810cf5d743dc7e88c7031380c80.png",
    "camera-ngoai-troi": "https://cdnv2.tgdd.vn/mwg-static/common/Common/9e/e9/9ee9ae20f38eff97221f040a735752ce.png",
    "camera-nang-luong-mat-troi": "https://cdnv2.tgdd.vn/mwg-static/tgdd/Common/5b/46/5b46309f2e80ca497b76f239ccf18829.png",
    "camera-4g": "https://cdnv2.tgdd.vn/mwg-static/tgdd/Common/18/9f/189f4355b6af9e13a9a6d8a05e862ce5.png",
    "chuong-cua-camera": "https://cdnv2.tgdd.vn/mwg-static/common/Common/bb/bf/bbbfeec82a451fff8cb59675907956e8.png",
    "webcam": "https://cdnv2.tgdd.vn/mwg-static/common/Common/0d/b1/0db1d791675fac2991151dddbd2ba7d7.png",
}

dest_dirs = [
    "assets/images/categories/accessories",
    "phonex-theme/assets/images/categories/accessories"
]

for d in dest_dirs:
    os.makedirs(d, exist_ok=True)

print(f"Bắt đầu tải {len(images)} hình ảnh phụ kiện sinh động...")
headers = {"User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"}

success_count = 0
for slug, url in images.items():
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req, timeout=10) as resp:
            data = resp.read()
            for d in dest_dirs:
                with open(os.path.join(d, f"{slug}.png"), "wb") as f:
                    f.write(data)
            success_count += 1
            print(f"[{success_count}/{len(images)}] Đã tải: {slug}.png ({len(data)} bytes)")
    except Exception as e:
        print(f"LỖI tải {slug}: {e}")

print(f"\n Hoàn tất tải {success_count}/{len(images)} hình ảnh phụ kiện vào thư mục dự án!")
