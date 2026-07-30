# ==========================================
# Dockerfile untuk simpan-app (Laravel 13.x + PHP 8.4)
# ==========================================

# ---- Stage 1: Build dependencies (composer) ----
FROM composer:2 AS vendor

WORKDIR /app

COPY database/ database/
COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --no-dev \
    --ignore-platform-reqs

# ---- Stage 2: Final PHP-FPM image ----
FROM php:8.4-fpm

# Install dependency sistem yang dibutuhkan extension PHP & Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang umum dipakai Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Set working directory
WORKDIR /var/www/html

# Copy source code aplikasi
COPY . .

# Copy vendor hasil composer install dari stage sebelumnya
COPY --from=vendor /app/vendor/ /var/www/html/vendor/

# Copy custom php.ini (opsional, sesuaikan kebutuhan)
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Set permission storage & cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
