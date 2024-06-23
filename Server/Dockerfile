FROM php:8.2-fpm-alpine

# Install essential dependencies and extensions
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip

# Set working directory
WORKDIR /var/www/app

# Install composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# Copy only composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate optimized autoloader and run any necessary scripts
RUN composer dump-autoload --optimize && \
    composer run-script post-install-cmd

# Set permissions
RUN chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage

CMD ["php-fpm"]