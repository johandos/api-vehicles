FROM php:7.3-fpm
RUN apt-get update
RUN apt-get install -y \
            git \
            libzip-dev \
            libc-client-dev \
            libkrb5-dev \
            libpng-dev \
            libjpeg-dev \
            libwebp-dev \
            libfreetype6-dev \
            libkrb5-dev \
            libicu-dev \
            zlib1g-dev \
            zip \
            ffmpeg \
            libmemcached11 \
            libmemcachedutil2 \
            build-essential \
            libmemcached-dev \
            gnupg2 \
            libpq-dev \
            libpq5 \
            libz-dev
RUN docker-php-ext-install gd
RUN docker-php-ext-configure imap \
    --with-kerberos \
    --with-imap-ssl
RUN docker-php-ext-install imap
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install exif
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install sysvsem
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo 'xdebug.remote_enable = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
#RUN composer self-update --1
RUN groupadd -g 1000 docker
RUN useradd -u 1000 -ms /bin/bash -g docker docker
USER docker
EXPOSE 9000
CMD ["php-fpm"]