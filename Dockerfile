# Exemple de correction pour ton Dockerfile
FROM php:8.2-fpm
RUN docker-php-ext-install pdo pdo_mysql

# Créer un utilisateur spécifique pour éviter le mode root
RUN addgroup -S appgroup && adduser -S appuser -G appgroup
USER appuser