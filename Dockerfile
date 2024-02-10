FROM php:8.2-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./application /application
WORKDIR /application

RUN apt-get update && apt-get install -y ${PHPIZE_DEPS} zip git librdkafka-dev
RUN docker-php-ext-install pdo pdo_mysql

RUN git clone https://github.com/arnaud-lb/php-rdkafka.git \
    && cd php-rdkafka \
    && phpize \
    && ./configure \
    && make all -j 5 \
    && make install \
    && docker-php-ext-enable rdkafka

EXPOSE 9501

CMD php artisan serve --port=9501 --host=0.0.0.0
