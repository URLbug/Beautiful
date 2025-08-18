FROM php:8.4-fpm-alpine

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk update && apk --no-cache add \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    bash \
    fcgi \
    libmcrypt-dev \
    oniguruma-dev \
    postgresql-dev

RUN rm -rf /var/cache/apk/*

RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-webp=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath opcache

RUN chown 33:33 -R /var/www
RUN find . -type d -exec chmod 775 {} \; && \
    find . -type f -exec chmod 664 {} \;

USER 33
CMD ["php-fpm"]