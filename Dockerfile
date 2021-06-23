# PHP image
FROM php:7.4-apache

# Install system libraries
RUN apt-get update -y && apt-get install -y \
    build-essential \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    openssl \
    zip \
    unzip \
    git

RUN curl -fsSL https://deb.nodesource.com/setup_14.x | sudo -E bash -

RUN apt-get install -y nodejs

RUN echo "NODE Version:" && node --version && echo "NPM Version:" && npm --version

# Install docker dependencies
RUN apt-get install -y libc-client-dev libkrb5-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && docker-php-source delete

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Download composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define working directory
WORKDIR /home/app

# Copy project
COPY . /home/app

# Run composer install
RUN composer install --ignore-platform-reqs

# Run npm install
RUN chmod -R a+rwx ./node_modules && npm install && npm run prod

# Install package
#RUN php artisan passport:install

# Expose the port
EXPOSE 8080

# Run server
CMD php artisan serve --host=0.0.0.0 --port=8080




