# Utiliser l'image officielle PHP avec Apache
FROM php:8.1-apache

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier le code source de l'application dans le répertoire de travail d'Apache
COPY . /var/www/html/

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exposer le port 80 pour Apache
EXPOSE 80
