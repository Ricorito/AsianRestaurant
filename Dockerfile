FROM php:8.2-apache

# Másoljuk be az egész projektet
COPY . /var/www/html/

# Telepítjük a mysqli kiterjesztést
RUN docker-php-ext-install mysqli

# Apache rewrite mod engedélyezése, ha kell
RUN a2enmod rewrite

# Indítsa el az Apache-ot
CMD ["apache2-foreground"]
