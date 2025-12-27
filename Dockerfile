FROM php:8.1-fpm

WORKDIR /data/php

ARG NODE_VERSION=18

ENV DEBIAN_FRONTEND noninteractive

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
          curl \
          git \
          zip unzip \
          supervisor \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && PHP_EXTENSIONS=" \
          amqp \
          mongodb \
          bcmath \
          bz2 \
          calendar \
          event \
          exif \
          gd \
          gettext \
          imagick \
          intl \
          ldap \
          memcached \
          mysqli \
          opcache \
          pdo_mysql \
          pdo_pgsql \
          pgsql \
          redis \
          soap \
          sockets \
          xsl \
          zip \
        " \
    && install-php-extensions $PHP_EXTENSIONS

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY conf/php.ini /usr/local/etc/php/conf.d/php-81.ini
RUN chmod +x /usr/local/sbin/php-fpm
