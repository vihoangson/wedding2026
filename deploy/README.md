# Quy trình Deploy Laravel qua Docker Hub

Stack: PHP 8.2-FPM + Nginx (1 container, chạy qua supervisord) + MySQL 8.

## Cấu trúc — gom hết đồ deploy vào thư mục `deploy/`, tách biệt code Laravel

```
my-laravel-project/          ← gốc source Laravel (giữ nguyên như cũ)
├── app/ ...
├── .env
├── .dockerignore            ← BẮT BUỘC nằm ở root (Docker chỉ đọc ở đây)
│
└── deploy/                  ← copy toàn bộ nội dung trong file zip này vào đây
    ├── Dockerfile
    ├── docker-compose.yml   ← chỉ dùng trên VM, không đụng tới code
    ├── deploy-local.sh
    ├── deploy-vm.sh
    ├── .env.deploy.example
    └── docker/
        ├── nginx.conf
        └── supervisord.conf
```

Chỉ có `.dockerignore` là phải nằm ở root project, còn lại toàn bộ vào `deploy/`.

## BƯỚC 1 — Ở máy LOCAL: build & push image

Đứng ở **thư mục gốc project Laravel** (không phải trong `deploy/`):
```bash
./deploy/deploy-local.sh v1.0.0
```
Script build với `-f deploy/Dockerfile` nhưng context vẫn là root, nên `COPY . .` trong Dockerfile lấy đúng toàn bộ code Laravel.

> Sửa `DOCKERHUB_USER` trong `deploy/deploy-local.sh` thành username Docker Hub thật trước khi chạy.

## BƯỚC 2 — Trên VM: chuẩn bị

VM **không cần source Laravel** — chỉ cần vài file cấu hình. Tạo 1 thư mục riêng trên VM, ví dụ `/opt/laravel-app/`, rồi copy sang:
```
/opt/laravel-app/
├── docker-compose.yml
├── deploy-vm.sh
├── .env                 ← đổi tên từ .env.deploy.example (biến cho docker-compose)
└── laravel.env           ← .env THẬT của ứng dụng Laravel (APP_KEY, DB_*...)
```
(2 file `.env` khác nhau — đặt tên khác để khỏi đè nhau. Trong `docker-compose.yml`, dòng mount `.env` của Laravel sửa thành `./laravel.env:/var/www/html/.env:ro`.)

Cài Docker trên VM nếu chưa có:
```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER   # rồi logout/login lại
```

## BƯỚC 3 — Trên VM: pull & deploy

```bash
chmod +x deploy-vm.sh
docker login                 # nếu image ở repo private
./deploy-vm.sh v1.0.0
```

Script tự động: `docker compose pull` → `up -d` → `artisan key:generate/migrate` → `config:cache/route:cache/view:cache` → set quyền `storage/`.

> **Source + vendor/ đã bake sẵn vào image từ lúc build ở local** — VM không cần git, không cần composer install, chỉ pull image về là chạy được ngay. Các bước `artisan key:generate/migrate` vẫn chạy ở VM vì phụ thuộc `.env`/DB của từng môi trường (không thể bake cứng vào image, vì mỗi VM/staging/production có DB khác nhau).

## Mỗi lần release mới về sau

```bash
# Local (đứng ở gốc project Laravel)
./deploy/deploy-local.sh v1.0.1

# VM (đứng trong /opt/laravel-app/)
./deploy-vm.sh v1.0.1
```

## Ghi chú
- `vendor/` đã bake sẵn vào image lúc build (`RUN composer install` trong Dockerfile) — VM không cần composer, không cần git.
- `.env` của Laravel **không** bake vào image (đã loại trong `.dockerignore`) vì mỗi môi trường (staging/production) có DB/APP_KEY khác nhau — luôn mount từ ngoài vào lúc chạy container.
- Đổi PHP version, thêm Redis, queue worker... chỉnh `deploy/Dockerfile` / `docker-compose.yml`.
- Mở port 80 (443 nếu có SSL) trên firewall VM.
