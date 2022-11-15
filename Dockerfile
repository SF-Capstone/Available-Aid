FROM bitnami/laravel:latest

WORKDIR /home/Available-Aid

COPY ./composer.json /home/Available-Aid/composer.json
COPY ./.env /home/Available-Aid/.env
COPY ./php.ini /home/Available-Aid/php.ini
COPY ./cacert.pem /home/Available-Aid/cacert.pem
COPY ./storage/app/public/images/* /home/Available-Aid/storage/app/public/images/*

COPY . .

RUN composer install

EXPOSE 8000

ENTRYPOINT [ "php", "artisan", "serve", "--host=0.0.0.0" ]