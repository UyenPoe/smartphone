# ==============================================================================
# PhoneX Mobile App - Production Dockerfile
# Base: Nginx Alpine siêu nhẹ (~25MB), hiệu năng cao
# ==============================================================================
FROM nginx:alpine

# Copy cấu hình Nginx tối ưu cho Flutter Web SPA & Caching
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy mã nguồn Web đã biên dịch vào thư mục phục vụ của Nginx
COPY build/web /usr/share/nginx/html

# Mở cổng 80 bên trong container
EXPOSE 80

# Chạy Nginx foreground
CMD ["nginx", "-g", "daemon off;"]
