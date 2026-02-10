# 1. Étape de Build pour Vue.js
FROM node:lts-alpine as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2. Étape de Production avec PHP + Apache
FROM php:8.2-apache

# Désactivation manuelle du module MPM 'event' et activation de 'prefork'
# C'est la solution directe à l'erreur AH00534
RUN a2dismod mpm_event && a2enmod mpm_prefork

# Installation des dépendances pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Configuration d'Apache pour le port dynamique de Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copie du build Vue.js vers le répertoire web d'Apache
COPY --from=build-stage /app/dist /var/www/html

# Gestion des droits d'accès
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Activation du module rewrite pour les routes de Vue.js
RUN a2enmod rewrite

# On expose le port définit par Railway
EXPOSE ${PORT}

# Lancement d'Apache au premier plan pour Docker
CMD ["apache2-foreground"]