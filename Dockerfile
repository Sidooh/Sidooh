#
# PHP Dependencies
#
FROM composer:2.1 as vendor

WORKDIR /app

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

COPY . .

#RUN touch .env && php artisan key:generate

RUN composer dump-autoload


#
# Application
#
FROM php:8.0-alpine

RUN apk add --no-cache mysql-client \
    && docker-php-ext-install pdo_mysql mysqli \
    && docker-php-ext-install -j "$(nproc)" opcache

RUN set -ex; \
  { \
    echo "; Cloud Run enforces memory & timeouts"; \
    echo "memory_limit = -1"; \
    echo "max_execution_time = 0"; \
    echo "; File upload at Cloud Run network limit"; \
    echo "upload_max_filesize = 32M"; \
    echo "post_max_size = 32M"; \
    echo "; Configure Opcache for Containers"; \
    echo "opcache.enable = On"; \
    echo "opcache.validate_timestamps = Off"; \
    echo "; Configure Opcache Memory (Application-specific)"; \
    echo "opcache.memory_consumption = 32"; \
  } > "$PHP_INI_DIR/conf.d/cloud-run.ini"

WORKDIR /app

# Install PHP dependencies
#RUN apt-get update -y && apt-get install -y libxml2-dev
#RUN docker-php-ext-install pdo pdo_mysql mbstring opcache tokenizer xml ctype json bcmath pcntl

# Copy Composer dependencies
#COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=vendor /app ./
#COPY . .

#RUN php artisan config:cache
#RUN php artisan route:cache

# Expose the port
EXPOSE 8080

# Run server
CMD php artisan serve --host=0.0.0.0 --port=8080
