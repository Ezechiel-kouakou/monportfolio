# 1. Étape de Build pour Vue.js
FROM node:lts-alpine as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2. Étape de Production avec PHP + Apache
FROM php:8.2-apache

# INSTALLATION DES DÉPENDANCES ET CONFIGURATION MPM
# On supprime physiquement les fichiers mpm_event et mpm_worker pour éviter tout chargement accidentel
RUN apt-get update && apt-get install -y libpq-dev \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork \
    && docker-php-ext-install pdo pdo_pgsql

# Configuration du port dynamique de Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copie du build Vue.js vers le répertoire Apache
COPY --from=build-stage /app/dist /var/www/html

# Permissions et configuration Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    a2enmod rewrite

# On expose le port
EXPOSE ${PORT}

# Commande de démarrage
CMD ["apache2-foreground"]# 1. Étape de Build pour Vue.js
FROM node:lts-alpine as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2. Étape de Production avec PHP + Apache
FROM php:8.2-apache

# INSTALLATION DES DÉPENDANCES ET CONFIGURATION MPM
# On supprime physiquement les fichiers mpm_event et mpm_worker pour éviter tout chargement accidentel
RUN apt-get update && apt-get install -y libpq-dev \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork \
    && docker-php-ext-install pdo pdo_pgsql

# Configuration du port dynamique de Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copie du build Vue.js vers le répertoire Apache
COPY --from=build-stage /app/dist /var/www/html

# Permissions et configuration Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    a2enmod rewrite

# On expose le port
EXPOSE ${PORT}

# Commande de démarrage
CMD ["apache2-foreground"]