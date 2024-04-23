FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpq-dev \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        default-mysql-client \
        curl \
        gnupg \
        procps \
        vim \
        nodejs \
        npm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
        zip \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        intl \
        gd

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install pcov extension
RUN pecl install pcov \
    && docker-php-ext-enable pcov

# Install Node.js, NPM, Yarn
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install npm@latest -g \
    && npm install yarn -g

# Set Composer environment variables
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Install Laravel Installer globally using Composer
RUN composer global require "laravel/installer"

# Set the working directory
WORKDIR /var/www

# Copy application code
COPY . /var/www

# Install PHP dependencies using Composer
RUN composer global install --no-dev --optimize-autoloader

# Expose port
EXPOSE 5173

# Start PHP-FPM
CMD ["php-fpm"]
