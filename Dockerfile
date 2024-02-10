FROM php:8.2-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./application /application
WORKDIR /application

RUN apt-get update && apt-get install -y ${PHPIZE_DEPS} zip git
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 9501

CMD php artisan serve --port=9501 --host=0.0.0.0
