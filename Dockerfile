from node:lts-alpine as build stage 
WORKDIR /app
COPY package*.json ./ 
RUN npm install 
COPY . .
RUN npm run build 
from php:8.2-apache
WORKDIR /var/www/html

RUN apt get update &&  apt install -y  libpq-dev \ &&  docker-php-ext-install pdo pdo_pgsql 
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
COPY --from=build-stage /app/dist/ /var/www/html
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/
RUN a2enmod rewrite 
EXPOSE ${PORT}
 
