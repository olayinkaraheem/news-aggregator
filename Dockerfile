FROM php:8.3.2-fpm

# Install dockerize so we can wait for containers to be ready
ENV DOCKERIZE_VERSION 0.6.1

RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.7.7

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION


# Install nodejs
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        build-essential \
        openssl \
        nginx \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        libgmp-dev \
        unzip \
        zip \
        nodejs \
        git \
    && apt-get clean \
    && pecl install redis \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
        gmp \
        bcmath \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*;

RUN apt-get update \
    && apt-get -y install jq

COPY ./composer.json /var/www/

# RUN --mount=type=secret,id=composer_auth,dst=/var/www/auth.json composer install --working-dir=/var/www --no-scripts

RUN mkdir -p /var/www/storage/framework /var/www/storage/framework/views /var/www/storage/framework/sessions /var/www/storage/framework/cache

COPY ./docker/php/laravel.ini /etc/php/conf.d/laravel.ini

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www

COPY . .

RUN composer dump-autoload

RUN chown -R www-data:www-data /var/www

RUN chmod -R 755 /var/www/storage

EXPOSE 80

RUN ["chmod", "+x", "./post_deploy.sh"]

CMD [ "sh", "./post_deploy.sh" ]

