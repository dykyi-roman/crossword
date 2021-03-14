FROM php:8.0-fpm

WORKDIR /var/www/html/code

RUN apt-get update && apt-get install -y \
        libzip-dev \
        libmcrypt-dev \
        libcurl4-openssl-dev \
        libssl-dev \
	    libonig-dev \
        libicu-dev \
        libevent-dev \
        uuid-dev \
        librabbitmq-dev \
        libssh-dev \
        libgeoip-dev \
        libmemcached-dev \
        openssl \
        openssh-server \
        nano \
        git \
        && rm -rf /var/lib/apt/lists/*

RUN apt-get install -y $PHPIZE_DEPS

RUN docker-php-ext-install -j$(nproc) iconv \
        && docker-php-ext-install pcntl \
        && docker-php-ext-configure intl \
        && docker-php-ext-install intl \
        && docker-php-ext-enable intl \
        && docker-php-ext-install opcache \
        && docker-php-ext-enable opcache \
        && docker-php-ext-install mbstring \
        && docker-php-ext-enable mbstring \
        && docker-php-ext-install zip \
        && docker-php-ext-enable zip \
        && docker-php-ext-install bcmath \
        && docker-php-ext-enable bcmath \
        && docker-php-ext-install sockets \
        && docker-php-ext-enable sockets \
        && docker-php-ext-install tokenizer \
        && docker-php-ext-enable tokenizer \
        && docker-php-ext-install mysqli \
        && docker-php-ext-enable mysqli \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-enable pdo_mysql