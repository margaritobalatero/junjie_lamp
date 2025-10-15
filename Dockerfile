FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite (useful for many PHP frameworks)
RUN a2enmod rewrite

# Copy custom Apache config if needed
COPY apache-config/ /etc/apache2/sites-enabled/
