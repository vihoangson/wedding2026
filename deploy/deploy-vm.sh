#!/bin/bash
set -e

# ==== CẤU HÌNH ====
export DOCKERHUB_USER="your-dockerhub-username"
export TAG="${1:-latest}"   # ví dụ: ./deploy-vm.sh v1.0.2

echo ">> Kéo image mới nhất từ Docker Hub"
docker compose pull

echo ">> Dừng container cũ, chạy container mới"
docker compose down
docker compose up -d

echo ">> Đợi container app khởi động..."
sleep 5

echo ">> Sinh APP_KEY nếu .env chưa có"
docker compose exec app php artisan key:generate --force

echo ">> Chạy migrate database"
docker compose exec app php artisan migrate --force

echo ">> Cache config/route/view cho production"
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

echo ">> Set quyền storage"
docker compose exec app chown -R www-data:www-data storage bootstrap/cache

echo ">> Deploy xong! Kiểm tra http://<ip-vm>"
