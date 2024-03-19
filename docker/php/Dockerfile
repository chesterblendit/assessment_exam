FROM php:8.2-fpm-buster
LABEL maintainer="ucan-lab <yes@u-can.pro>"
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# Set timezone environment
ENV TZ=UTC \
  # Set locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # Set composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

# Install system dependencies
RUN apt-get update && \
  apt-get -y install --no-install-recommends \
    git \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libgd-dev \
    unzip \
    locales \
    gnupg2 \
    default-mysql-client \
    unixodbc unixodbc-dev \
    libgss3 odbcinst && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/*

# Generate locale
RUN locale-gen en_US.UTF-8 && \
  localedef -f UTF-8 -i en_US en_US.UTF-8

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    gd \
    exif && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr && \
  docker-php-ext-install pdo_odbc

# Install Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Set Composer config
RUN composer config -g process-timeout 3600 && \
  composer config -g repos.packagist composer https://packagist.org

# Copy PHP-FPM configuration files
COPY ./php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./php/php.ini /usr/local/etc/php/php.ini

# Set working directory
WORKDIR /app
