FROM php:8.0-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql

# Copier la configuration Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copier le code de l’application Suplike
COPY . /var/www/html/suplike

# Définir le répertoire de travail
WORKDIR /var/www/html/suplike

# Exposer le port 80
EXPOSE 80
