# Utilisation de l'image officielle PHP avec Apache
FROM php:apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Installer le client MySQL
RUN apt-get update && apt-get install -y default-mysql-client

# Copier le code de l'application dans le répertoire de travail de l'image
COPY . /var/www/html/

# Exposer le port 80 pour le trafic HTTP
EXPOSE 80
