FROM php:7.4-fpm
RUN apt-get update \
    && apt-get install -y git zip unzip libpq-dev  \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN mkdir -p /app
WORKDIR /app
EXPOSE  8000
CMD php artisan serve --host=0.0.0.0
