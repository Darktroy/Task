FROM php:8.2-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring zip exif pcntl opcache @composer

COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini
RUN usermod -u 1000 www-data
USER www-data

# Install composer
EXPOSE 9000
CMD ["php-fpm"]