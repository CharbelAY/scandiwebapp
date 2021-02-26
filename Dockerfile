FROM php:7.4

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR src/app

COPY . .

EXPOSE 8080

WORKDIR public

ENTRYPOINT php -S 0.0.0.0:8080
