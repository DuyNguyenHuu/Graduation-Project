FROM php:8.2-fpm

# Cài thư viện cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    pkg-config \
    build-essential \
    && docker-php-ext-install pdo pdo_mysql zip

# Cài Memcached extension
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www