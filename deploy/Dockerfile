FROM php:8.2-fpm

# Cài extension Laravel cần + nginx + supervisor
RUN apt-get update && apt-get install -y \
    git curl zip unzip nginx supervisor \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code (KHÔNG copy vendor, .env - xem .dockerignore)
COPY . .

# Cài toàn bộ thư viện composer NGAY LÚC BUILD -> bake sẵn vendor/ vào image
# (không cần chạy composer install trên VM nữa)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Cấu hình nginx + supervisor
COPY deploy/docker/nginx.conf /etc/nginx/sites-available/default
COPY deploy/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
