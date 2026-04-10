name=Dockerfile
FROM php:8.2-apache

# Install dependencies for pdo_mysql and other typical extensions
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
      libzip-dev \
      unzip \
      git \
      curl \
      ca-certificates && \
    docker-php-ext-install pdo pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

# Copy application into webroot
COPY . /var/www/html/

# Ensure correct permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 750 /var/www/html

# Expose port 80 (container)
EXPOSE 80

# Default command runs Apache in the foreground (image base does this)