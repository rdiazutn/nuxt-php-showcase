FROM php:7.3-fpm

    RUN apt-get update && apt-get install -y -q --no-install-recommends \
    curl \
    zsh  \
    vim  \
    zlib1g-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN apt-get update && apt-get install -y -q --no-install-recommends \
    zip \
    unzip \
    libcurl4-openssl-dev \
    unixodbc \
    unixodbc-dev \
    pkg-config \
    libssl-dev

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    nano \
    libzip-dev \
    git 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip \
                           mbstring \
                           exif \
                           pcntl \
                           gd \
                           pdo_mysql \ 
                           mysqli && \
    docker-php-ext-enable pdo_mysql && \
    docker-php-ext-enable mysqli && \
    docker-php-ext-enable mbstring

RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
    
# Install and enable xDebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Prevent error in nginx error.log
RUN touch /var/log/xdebug_remote.log
RUN chmod 777 /var/log/xdebug_remote.log


ARG PUID=1000
ARG PGID=1000
RUN usermod -u ${PUID} www-data && groupmod -g ${PGID} www-data
RUN mkdir /home/www-data && chown -R www-data:www-data /home/www-data && usermod -d /home/www-data www-data