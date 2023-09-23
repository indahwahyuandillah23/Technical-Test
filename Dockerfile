# Menggunakan PHP FPM
FROM php:8.1-fpm

# Instal ekstensi PHP yang diperlukan
RUN docker-php-ext-install pdo pdo_mysql

# Set direktori kerja di dalam wadah
WORKDIR /var/www/html

# Salin seluruh isi proyek Laravel ke dalam wadah
COPY . /var/www/html

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
