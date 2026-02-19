FROM php:8.2-apache

# Activer mod_rewrite
RUN a2enmod rewrite

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl zip mysqli pdo pdo_mysql \
    && apt-get clean

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le projet
COPY . /var/www/html/

WORKDIR /var/www/html

# Créer un .env vide si absent (IMPORTANT)
RUN [ -f .env ] || cp env .env || true

# Installer dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 777 writable

# Apache → dossier public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
