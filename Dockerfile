FROM php:8.3-apache

# Install only the MySQL PDO driver (pdo extension is already in the base image)
RUN docker-php-ext-install pdo_mysql

# Enable Apache rewrite module (useful for clean URLs)
RUN a2enmod rewrite

# Copy all application files
COPY . /var/www/html/

# Set proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]