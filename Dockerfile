FROM php:8.2-fpm
RUN curl -sS https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer
RUN apt-get update && apt-get install -y git unzip zip libxslt-dev
RUN apt-get install -y \
        libzip-dev \
        librabbitmq-dev \
        zip \
  && docker-php-ext-install zip
RUN apt-get install -y python3-pip build-essential
RUN pip3 install PyMySQL --break-system-packages
RUN docker-php-ext-install sockets
RUN docker-php-ext-install xsl mysqli pdo pdo_mysql
RUN docker-php-ext-install opcache
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
COPY . /var/www
WORKDIR /var/www
RUN composer install --no-dev
RUN composer require league/flysystem-aws-s3-v3 --with-all-dependencies --no-interaction
RUN chmod -R 777 ./storage
RUN php artisan storage:link
RUN chmod -R 777 /var/www
USER www
EXPOSE 9000
