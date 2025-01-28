# Utiliser l'image officielle de PHP avec Apache
FROM php:8.1-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application dans le conteneur
COPY . .

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exposer le port utilisé par l'application
EXPOSE 80

# Définir la commande d'exécution (Apache est démarré par défaut)
CMD ["apache2-foreground"]
