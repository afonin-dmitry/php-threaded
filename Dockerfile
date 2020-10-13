FROM php:7.2-zts-alpine

WORKDIR /usr/src/app/

RUN set -x \
    && apk add --no-cache bash git openssh autoconf gcc libc-dev make \
    && docker-php-ext-install sockets

# pthreads
RUN git clone https://github.com/krakjoe/pthreads.git -b master /tmp/pthreads \
    && docker-php-ext-configure /tmp/pthreads --enable-pthreads \
    && docker-php-ext-install /tmp/pthreads \
    && rm -r /tmp/pthreads

# composer
RUN php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x composer.phar \
    && /usr/src/app/composer.phar install

# Add global composer bin dir to PATH
ENV PATH /root/.composer/vendor/bin:$PATH