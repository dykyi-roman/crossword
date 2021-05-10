FROM php:8.0-fpm

WORKDIR /var/www/html/code

RUN pecl install xdebug

RUN apt-get update && apt-get install -y \
        libzip-dev \
        libmcrypt-dev \
        libcurl4-openssl-dev \
	    libonig-dev \
        libicu-dev \
        libevent-dev \
        && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) iconv \
        && docker-php-ext-enable xdebug \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install intl \
        && docker-php-ext-install zip \
        && docker-php-ext-enable zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
