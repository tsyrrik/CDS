FROM php:8.1-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libicu-dev \
        libxslt1-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        libgmp-dev \
        libmagickwand-dev \
        ghostscript; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mysqli \
        opcache \
        pdo_mysql \
        soap \
        xml \
        xsl \
        zip; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN if [ "$GROUP_ID" != "0" ]; then groupmod -o -g "$GROUP_ID" www-data; fi; \
    if [ "$USER_ID" != "0" ]; then usermod -o -u "$USER_ID" www-data; fi

WORKDIR /var/www/html
