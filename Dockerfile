# Alap kép: Apache + PHP 8.2
FROM php:8.2-apache

# Másoljuk be a projekt fájlokat a konténerbe
COPY . /var/www/html/

# Engedélyezzük az Apache mod_rewrite-t, ha kellene majd
RUN a2enmod rewrite

# Állítsuk be, hogy az Apache induljon el
CMD ["apache2-foreground"]
