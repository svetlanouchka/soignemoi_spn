FROM php:8.1-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code source de l'application
COPY . /var/www/html/

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configuration d'Apache
EXPOSE 80

# Définir la commande d'exécution (Apache est démarré par défaut)
CMD ["apache2-foreground"]
