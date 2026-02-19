FROM php:8.2-apache

# Activer mod_rewrite (CodeIgniter)
RUN a2enmod rewrite

# Installer extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le projet
COPY . /var/www/html/

# Définir le dossier de travail
WORKDIR /var/www/html

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Permissions pour CodeIgniter
RUN chmod -R 777 writable

# Apache pointe vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
