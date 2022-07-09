ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-fpm-buster

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

#
#--------------------------------------------------------------------------
# Software's Installation
#--------------------------------------------------------------------------
#
# Installing tools and PHP extentions using "apt", "docker-php", "pecl",
#

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


RUN apt-get update \
    && apt-get install -y gnupg \
    gosu \
    curl \
    tmux \
    cron

RUN chmod +x /usr/local/bin/install-php-extensions && \
        install-php-extensions gd \
        intl \
        imagick \
        opcache \
        calendar \
        pgsql \
        pdo_pgsql \
        mcrypt \
        xdebug \
        zip


WORKDIR /var/www


COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./laravel.ini /usr/local/etc/php/conf.d
COPY ./xlaravel.pool.conf /usr/local/etc/php-fpm.d/


ARG APP_ENV=development

#RUN mv "$PHP_INI_DIR/php.ini-${APP_ENV}" "$PHP_INI_DIR/php.ini"

#copy over the custom php.ini
COPY ./php.ini-${APP_ENV} /usr/local/etc/php/conf.d/php.ini

ADD ./startup.sh /opt/startup.sh



CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 9000
