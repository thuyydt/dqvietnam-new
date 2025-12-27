# Stage 1: Base (PHP + Extensions)
FROM php:8.1-fpm AS base

WORKDIR /app/dqvietnam

ENV DEBIAN_FRONTEND noninteractive

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
          zip unzip \
          supervisor \
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
    && install-php-extensions $PHP_EXTENSIONS \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY conf/php.ini /usr/local/etc/php/conf.d/php-81.ini

# Stage 2: Builder (Composer + Node)
FROM base AS builder

ARG NODE_VERSION=18

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
          curl \
          git \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y --no-install-recommends nodejs

# Copy source code
COPY apps/dqvietnam /app/dqvietnam

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install JS dependencies and build
RUN npm install && npm run production -- --no-progress

# Remove node_modules to keep image small
RUN rm -rf node_modules

# Stage 3: Production
FROM base AS production

# Copy built assets and vendor from builder
COPY --from=builder /app/dqvietnam /app/dqvietnam

# Set permissions
RUN chown -R www-data:www-data /app/dqvietnam

# Switch to non-root user for security
USER www-data
