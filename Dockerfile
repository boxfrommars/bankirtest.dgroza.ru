FROM php:8.3-fpm-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libonig-dev \
        libsqlite3-dev \
        libxml2-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" dom mbstring opcache pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

CMD ["php-fpm"]
