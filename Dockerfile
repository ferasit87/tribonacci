FROM php:7.2-fpm-stretch

ARG UNAME=docker
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID -o $UNAME
RUN useradd -m -u $UID -g $GID -o -s /bin/bash $UNAME

RUN apt-get update && apt-get install -y \
    git \
    vim \
    wget \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libpq-dev \
    pkg-config \
    libssl-dev \
    libjpeg-dev \
    libldap2-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    g++ && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pcntl mongodb

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER $UNAME

RUN mkdir -p /home/docker/engine/

WORKDIR /home/docker/engine/

#COPY --chown=$UNAME:$UNAME . .
COPY --chown=docker:docker . .

ENV COMPOSER_MEMORY_LIMIT=-1 \
    PHP_EXTENSION_SOAP=0 \
    PHP_EXTENSION_PDO=1 \
    PHP_EXTENSION_PDO_MYSQL=0 \
    PHP_EXTENSION_MYSQLI=0 \
    PHP_EXTENSION_APCU=1 \
    PHP_EXTENSION_REDIS=1 \
    PHP_EXTENSION_ZIP=1 \
    PHP_EXTENSION_OPCACHE=1 \
    PHP_EXTENSION_MONGODB=1 \
    PHP_EXTENSION_BCMATH=1 \
    PHP_EXTENSION_IMAGICK=1 \
    PHP_EXTENSION_SOCKETS=1

RUN chmod -R ug+rwx storage \
    && mkdir -p storage/logs/cron storage/logs/debug \
    && composer update \
    && composer install --no-dev

EXPOSE 9000

CMD ["php-fpm"]
