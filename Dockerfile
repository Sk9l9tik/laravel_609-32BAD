FROM php:8.2-fpm

RUN curl -sS https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer

RUN apt-get update && apt-get install -y git unzip zip libxslt-dev
RUN apt-get install -y \
        libzip-dev \
        librabbitmq-dev \
        zip \
  && docker-php-ext-install zip


# RUN python3 -m venv /opt/venv && \
#     /opt/venv/bin/pip install --upgrade pip && \
#     /opt/venv/bin/pip install PyMySQL
# ENV PATH="/opt/venv/bin:$PATH"

RUN apt-get install -y python3-pip build-essential # ansible
RUN pip3 install PyMySQL --break-system-packages
# RUN which ansible-playbook
# RUN apt-get install -y supervisor


# RUN pecl install amqp
# RUN docker-php-ext-enable amqp
RUN docker-php-ext-install sockets
RUN docker-php-ext-install xsl mysqli pdo pdo_mysql
RUN docker-php-ext-install opcache


# RUN apt-get update && apt-get install -y \
# 		libfreetype6-dev \
# 		libjpeg62-turbo-dev \
# 		libpng-dev \
# 	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
# 	&& docker-php-ext-install -j$(nproc) gd


# RUN apt-get update --fix-missing
# RUN apt-get install -y cron
# COPY cron /etc/cron.d/worker-cron
# RUN crontab /etc/cron.d/worker-cron
# RUN touch /var/log/cron.log



RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www
WORKDIR /var/www

RUN composer install --no-dev
RUN chmod -R 777 ./storage
RUN php artisan storage:link
RUN chmod -R 777 /var/www

# RUN chmod -R 755 /var/www/ansible
# RUN chmod 400 /var/www/ansible/cert.key
USER www
EXPOSE 9000



