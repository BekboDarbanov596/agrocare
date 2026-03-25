FROM php:8.2-apache

# Устанавливаем расширения, которые используются в проекте
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql gd mbstring \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Apache документ-директория в php:8.2-apache уже /var/www/html
WORKDIR /var/www/html

# Копируем исходники (а в docker-compose дополнительно будет mount)
COPY . /var/www/html

