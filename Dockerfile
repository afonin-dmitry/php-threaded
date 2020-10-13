FROM composer

WORKDIR /usr/src/composer/

COPY composer.json ./
COPY composer.lock ./

RUN composer install --ignore-platform-reqs

FROM php:7.2-zts-alpine

RUN set -x \
    && apk add --no-cache bash git openssh autoconf gcc libc-dev make \
    && docker-php-ext-install sockets

# pthreads
RUN git clone https://github.com/krakjoe/pthreads.git -b master /tmp/pthreads \
    && docker-php-ext-configure /tmp/pthreads --enable-pthreads \
    && docker-php-ext-install /tmp/pthreads \
    && rm -r /tmp/pthreads

WORKDIR /usr/src/app/

COPY ./ /usr/src/app/
COPY --from=0 /usr/src/composer/ .
COPY --from=0 /usr/bin/composer /usr/bin/composer

ENV PATH /root/.composer/vendor/bin:$PATH