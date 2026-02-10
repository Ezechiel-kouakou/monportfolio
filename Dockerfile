# 1. Build Vue.js
FROM node:lts-alpine as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2. Production PHP + Apache (Version Allégée)
FROM php:8.2-apache

# Désactivation forcée de MPM Event pour éviter le crash AH00534
RUN a2dismod mpm_event || true && a2enmod mpm_prefork || true

# Installation minimum pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# LIMITATION DE LA RAM : On configure Apache pour être très léger
# On réduit le nombre de processus pour tenir dans la formule gratuite
RUN echo "StartServers 1\nMinSpareServers 1\nMaxSpareServers 3\nMaxRequestWorkers 10\nMaxConnectionsPerChild 100" >> /etc/apache2/apache2.conf

# Config Port Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Copie et Permissions
COPY --from=build-stage /app/dist /var/www/html
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html && a2enmod rewrite

EXPOSE ${PORT}
CMD ["apache2-foreground"]