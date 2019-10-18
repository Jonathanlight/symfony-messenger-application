FROM php:7.3.2-fpm-stretch

ENV EXT_APCU_VERSION=5.1.17
ENV EXT_REDIS_VERSION=4.3.0 EXT_IGBINARY_VERSION=3.0.1

## Basic tools
RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install -y bash \
            curl \
            wget \
            ca-certificates \
            vim \
            nano

## Apache
RUN a2enmod ssl rewrite

## PHP
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxrender1 libfontconfig \
        libicu-dev \
        libxext-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo_mysql gd mbstring bcmath zip intl opcache \
    && docker-php-ext-enable intl opcache

RUN docker-php-source extract \
    # ext-apcu
    && mkdir -p /usr/src/php/ext/apcu \
    && curl -fsSL https://github.com/krakjoe/apcu/archive/v$EXT_APCU_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/apcu --strip 1 \
    && docker-php-ext-install apcu \
    # cleanup
    && docker-php-source delete    

RUN docker-php-source extract \
    # igbinary
    && mkdir -p /usr/src/php/ext/igbinary \
    &&  curl -fsSL https://github.com/igbinary/igbinary/archive/$EXT_IGBINARY_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/igbinary --strip 1 \
    && docker-php-ext-install igbinary \
    # redis
    && mkdir -p /usr/src/php/ext/redis \
    && curl -fsSL https://github.com/phpredis/phpredis/archive/$EXT_REDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && docker-php-ext-configure redis --enable-redis-igbinary \
    && docker-php-ext-install redis \
    # cleanup
    && docker-php-source delete

## Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## wkhtmltopdf
RUN curl -fkL "https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz" -o wkhtmltopdf.tar.xz && \
    tar -xJf wkhtmltopdf.tar.xz && \
    mv wkhtmltox/bin/wkhtmltopdf /usr/bin/wkhtmltopdf && \
    mv wkhtmltox/bin/wkhtmltoimage /usr/bin/wkhtmltoimage && \
    chmod +x /usr/bin/wkhtmltopdf && \
    mkdir -p /var/www/symfony/bin && \
    ln -s /usr/bin/wkhtmltopdf /var/www/symfony/bin/wkhtmltopdf

WORKDIR /var/www/symfony
