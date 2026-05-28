FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . /var/www/html

# Copy Apache config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80