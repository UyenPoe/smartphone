#!/bin/bash
cd "$(dirname "$0")"

echo "======================================================="
echo "   Khởi Động PhoneX Trong Docker (App & Website)       "
echo "======================================================="

if ! command -v docker &> /dev/null; then
    echo "❌ Lỗi: Chưa tìm thấy Docker trên máy!"
    echo "Vui lòng mở ứng dụng Docker Desktop hoặc cài đặt từ https://www.docker.com/products/docker-desktop/"
    read -p "Nhấn Enter để thoát..."
    exit 1
fi

echo "🚀 Đang build và chạy container qua Docker Compose..."
docker compose up --build -d

echo ""
echo "✅ ĐÃ KHỞI CHẠY THÀNH CÔNG!"
echo "-------------------------------------------------------"
echo "📱 PhoneX Mobile App (Flutter Web): http://localhost:8085"
echo "🌐 PhoneX Simulator & Website:     http://localhost:8080"
echo "-------------------------------------------------------"
echo "Để dừng hệ thống: docker compose down"

sleep 2
open "http://localhost:8080"
open "http://localhost:8085"
