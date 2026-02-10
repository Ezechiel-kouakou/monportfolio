# 1. Étape de Build pour Vue.js
FROM node:lts-alpine as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2. Étape de Production avec PHP + Apache
FROM php:8.2-apache

# Installation de l'extension PostgreSQL pour PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Configuration d'Apache pour le port Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copie du build de Vue.js vers le dossier Apache
COPY --from=build-stage /app/dist /var/www/html

# On s'assure que les permissions sont bonnes
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Activation du module rewrite d'Apache
RUN a2enmod rewrite

# On expose le port
EXPOSE ${PORT}

# COMMANDE DE DÉMARRAGE : Force Apache à tourner au premier plan
CMD ["apache2-foreground"]