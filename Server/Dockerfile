FROM richarvey/nginx-php-fpm:latest

# Copy Laravel application
COPY . /var/www/html

# Set Environment Variables
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel Environment Variables
ENV APP_ENV production
ENV APP_DEBUG true
ENV LOG_CHANNEL stderr

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Increase PHP memory limit
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install dependencies if SKIP_COMPOSER is not set
RUN if [ -z "$SKIP_COMPOSER" ] || [ "$SKIP_COMPOSER" = "0" ]; then \
        composer install --no-dev --optimize-autoloader; \
    fi

# Set write permissions to necessary folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration
COPY default.conf /etc/nginx/sites-available/default

# Start the application
CMD ["/start.sh"]
