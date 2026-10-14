#!/bin/bash
set -e
# Chạy script này từ THƯ MỤC GỐC project Laravel:
#   ./deploy/deploy-local.sh v1.0.0

# ==== CẤU HÌNH - sửa lại theo tài khoản của bạn ====
DOCKERHUB_USER="vihoangson"
IMAGE_NAME="laravel-app"
TAG="${1:-latest}"

FULL_IMAGE="$DOCKERHUB_USER/$IMAGE_NAME:$TAG"

echo ">> Build image: $FULL_IMAGE"
# -f trỏ vào Dockerfile trong deploy/, nhưng context build (dấu chấm cuối)
# vẫn là thư mục gốc project để COPY . . lấy đúng code Laravel
docker build -f deploy/Dockerfile -t "$FULL_IMAGE" .

echo ">> Đăng nhập Docker Hub (nếu chưa login)"
docker login

echo ">> Push image lên Docker Hub"
docker push "$FULL_IMAGE"

echo ">> Xong. Image đã sẵn sàng: $FULL_IMAGE"
