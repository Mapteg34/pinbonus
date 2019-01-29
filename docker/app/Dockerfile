FROM php:fpm

ARG UID
ARG GUID
ARG TZ

ENV UID "${UID}"
ENV GUID "${GUID}"
ENV TZ "${TZ}"

RUN usermod -u $UID www-data && groupmod -g $GUID www-data
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends apt-utils

# pdo_pgsql
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y libpq-dev && \
    docker-php-ext-install -j$(nproc) pdo_mysql && \
    docker-php-ext-enable pdo_mysql

#xdebug
RUN apt-get install -y git && \
    git clone git://github.com/xdebug/xdebug.git /tmp/xdebug && \
    cd /tmp/xdebug && \
    phpize && \
    ./configure --enable-xdebug && \
    make -j$(nproc)&& \
    make install && \
    docker-php-ext-enable xdebug && \
    touch /var/log/xdebug_remote.log && \
    chown www-data:www-data /var/log/xdebug_remote.log && \
    cd / && \
    rm -Rf /tmp/xdebug

#use mailer !
RUN    echo "#!/bin/sh\n/bin/true" > /usr/bin/fake_mail.sh \
    && chmod +x /usr/bin/fake_mail.sh \
    && echo "sendmail_path = /usr/bin/fake_mail.sh" > /usr/local/etc/php/conf.d/mail.ini

#clean
RUN rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/app
