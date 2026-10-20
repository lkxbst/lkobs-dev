FROM php:8.2-fpm-bookworm

ARG UID=1001
ARG GID=1001

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    libicu-dev \
    libzip-dev \
    libsqlite3-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_sqlite \
        intl \
        gd \
        zip \
        opcache \
        bcmath \
        pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN groupadd -g ${GID} appuser || true \
    && useradd -u ${UID} -g ${GID} -m -s /bin/bash appuser || true

WORKDIR /var/www/html

USER appuser

EXPOSE 9000
CMD ["php-fpm"]
